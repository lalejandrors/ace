<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Acompanante;
use Ace\Repositories\AcompanantesRepository;
use Ace\CertificadoMedico;
use Ace\Consentimiento;
use Ace\Control;
use Ace\Formato;
use Ace\Formula;
use Ace\FormulaTratamiento;
use Ace\Repositories\ControlesRepository;
use Ace\IncapacidadMedica;
use Ace\InfoCentro;
use Ace\ItemFormula;
use Ace\ItemFormulaTratamiento;
use Ace\Repositories\ItemformulatratamientosRepository;
use Ace\Paciente;
use Ace\Repositories\PacientesRepository;
use Ace\ViaMedicamento;
use Auth;
use Session;
use Validator;
use PDF;
use Jenssegers\Date\Date;//para poder usar Carbon en espanol, es una extension de Carbon
use Carbon\Carbon;

class ControlesController extends Controller
{
    private $pacientes;
    private $controles;
    private $itemformulatratamientos;
    private $acompanantes;

    public function __construct(PacientesRepository $pacientes, ControlesRepository $controles, ItemformulatratamientosRepository $itemformulatratamientos, AcompanantesRepository $acompanantes)
    {
        $this->pacientes = $pacientes;
        $this->controles = $controles;
        $this->itemformulatratamientos = $itemformulatratamientos;
        $this->acompanantes = $acompanantes;
    }

    public function listar(Request $request)
    {
        return view('panel.control.listar');
    }

    public function datatable(Request $request)
    {
        $controlesRequest = $request->all();
        //variables traidas por post para server side
        $start = $controlesRequest['start'];
        $length = $controlesRequest['length'];
        $search = $controlesRequest['search']['value'];
        $draw = $controlesRequest['draw'];
        $controles = null;
        $controlesNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $controles = $this->controles->findControlesDatatableSearch($start, $length, $search, Auth::user()->id);
                $controlesNumero = $this->controles->findControlesDatatableSearchNum($search, Auth::user()->id);
            }else{
                $controles = $this->controles->findControlesDatatable($start, $length, Auth::user()->id);
                $controlesNumero = $this->controles->findControlesDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $controles = $this->controles->findControlesDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $controlesNumero = $this->controles->findControlesDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $controles = $this->controles->findControlesDatatable($start, $length, Session::get('medicoActual')->user->id);
                $controlesNumero = $this->controles->findControlesDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($controles->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($controlesNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($controles as $control) {
            $array = array();
            $array['id'] = $control->id;
            $array['numero'] = $control->numero;
            $array['paciente'] = $control->nombres.' '.$control->apellidos.'<br>'.'('.$control->identificacion.')';
            $array['creado'] = $control->created_at;

            $datos[] = $array;
        }
        
        $json_data = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($datosFinales),
            "recordsFiltered" => intval($datosProcesados),
            "data" => $datos
        );

        echo json_encode($json_data);
    }

    public function crear()
    {   
        //enviar la info necesaria para los forms
        $viaMedicamentos = ViaMedicamento::pluck('nombre','id');
        $formatos = Formato::where('user_id', Auth::user()->id)->orderBy('id','DESC')->get();
        $formatos = $formatos->pluck('nombre','id');

        return view('panel.control.crear', compact('viaMedicamentos','formatos'));
    }

    public function almacenar(Request $request)
    {
        if($request->ajax()){
            //primero se valida el acompanante
            if($request['acompanantes__identificacion'] != '' || $request['acompanantes__tipoId'] != '' || $request['acompanantes__nombres'] != '' || $request['acompanantes__apellidos'] != '' || $request['nuevo_parentesco'] != '' || $request['acompanantes__telefonoFijo'] != '' || $request['acompanantes__telefonoCelular'] != ''){

                $validator = Validator::make($request->all(), [
                    'acompanantes__identificacion' => 'required|numeric|digits_between:5,20|unique:acompanantes,identificacion',
                    'acompanantes__tipoId' => 'required',
                    'acompanantes__nombres' => 'required|min:2|max:50',
                    'acompanantes__apellidos' => 'required|min:2|max:50',
                    'nuevo_parentesco' => 'required|min:2|max:20',
                    'acompanantes__telefonoFijo' => 'required_without:acompanantes__telefonoCelular|max:15',
                    'acompanantes__telefonoCelular' => 'required_without:acompanantes__telefonoFijo|max:10',
                ], [], [
                    'acompanantes__identificacion' => '"Identificación para Acompañante"',
                    'acompanantes__tipoId' => '"Tipo de Identificación para Acompañante"',
                    'acompanantes__nombres' => '"Nombres para Acompañante"',
                    'acompanantes__apellidos' => '"Apellidos para Acompañante"',
                    'nuevo_parentesco' => '"Parentesco para Acompañante"',
                    'acompanantes__telefonoFijo' => '"Teléfono Fijo para Acompañante"',
                    'acompanantes__telefonoCelular' => '"Teléfono Celular para Acompañante"',
                ]);

                if ($validator->fails()){
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //luego validamos los campos enviados de control
            $validator = Validator::make($request->all(), [
                'controles__paciente_id' => 'required',
                'controles__acompanante_id' => 'nullable',

                'existente_parentesco' => 'required_with:controles__acompanante_id|max:20',

                'controles__padecimientoActual' => 'required|min:2',

                'controles__astenia' => 'nullable',
                'controles__adinamia' => 'nullable',
                'controles__anorexia' => 'nullable',
                'controles__fiebre' => 'nullable',
                'controles__perdidaPeso' => 'nullable',

                'controles__aparatoDigestivo' => 'nullable|min:2',
                'controles__aparatoCardiovascular' => 'nullable|min:2',
                'controles__aparatoRespiratorio' => 'nullable|min:2',
                'controles__aparatoUrinario' => 'nullable|min:2',
                'controles__aparatoGenital' => 'nullable|min:2',
                'controles__aparatoHematologico' => 'nullable|min:2',
                'controles__sistemaEndocrino' => 'nullable|min:2',
                'controles__sistemaOsteomuscular' => 'nullable|min:2',
                'controles__sistemaNervioso' => 'nullable|min:2',
                'controles__sistemaSensorial' => 'nullable|min:2',
                'controles__psicosomatico' => 'nullable|min:2',

                'controles__terapeuticaAnterior' => 'nullable|min:2',

                'controles__ta' => 'required|min:2|max:20',
                'controles__fc' => 'nullable|min:2|max:20',
                'controles__fr' => 'nullable|min:2|max:20',
                'controles__temp' => 'nullable|min:2|max:20',
                'controles__peso' => 'required|min:2|max:20',
                'controles__talla' => 'nullable|min:2|max:20',

                'controles__conciencia' => 'nullable',
                'controles__hidratacion' => 'nullable',
                'controles__coloracion' => 'nullable',
                'controles__marcha' => 'nullable',
                'controles__otrasAlteraciones' => 'nullable|min:2',

                'controles__normocefalo' => 'nullable',
                'controles__cabello' => 'nullable',
                'controles__pupilas' => 'nullable',
                'controles__faringe' => 'nullable',
                'controles__amigdalas' => 'nullable',
                'controles__nariz' => 'nullable',
                'controles__adenomegaliasCabeza' => 'nullable',
                'controles__cuello' => 'nullable',
                'controles__adenomegaliasCuello' => 'nullable',
                'controles__pulsos' => 'nullable',
                'controles__torax' => 'nullable',
                'controles__movResp' => 'nullable',
                'controles__camposPulmonares' => 'nullable',
                'controles__ruidosCardiacos' => 'nullable',
                'controles__adenomegaliasAxilares' => 'nullable',
                'controles__adenomegaliasAxilaresDescripcion' => 'nullable|min:2',
                'controles__abdomen' => 'nullable',
                'controles__dolorPalpacion' => 'nullable',
                'controles__dolorPalpacionDescripcion' => 'nullable|min:2',
                'controles__visceromegalias' => 'nullable',
                'controles__peristalsis' => 'nullable',
                'controles__peristalsisDescripcion' => 'nullable|min:2',
                'controles__miembrosSuperiores' => 'nullable',
                'controles__miembrosInferiores' => 'nullable',
                'controles__genitales' => 'nullable|min:2',

                'controles__tratamiento' => 'required|min:2',

                'controles__observacion' => 'nullable|min:2',
            ], [], [
                'controles__paciente_id' => '"Paciente"',
                'controles__acompanante_id' => '"Acompañante"',

                'existente_parentesco' => '"Parentesco para Acompañante Existente"',

                'controles__padecimientoActual' => '"Padecimiento Actual"',

                'controles__astenia' => '"Astenia"',
                'controles__adinamia' => '"Adinamia"',
                'controles__anorexia' => '"Anorexia"',
                'controles__fiebre' => '"Fiebre"',
                'controles__perdidaPeso' => '"Pérdida Peso"',

                'controles__aparatoDigestivo' => '"Aparato Digestivo"',
                'controles__aparatoCardiovascular' => '"Aparato Cardiovascular"',
                'controles__aparatoRespiratorio' => '"Aparato Respiratorio"',
                'controles__aparatoUrinario' => '"Aparato Urinario"',
                'controles__aparatoGenital' => '"Aparato Genital"',
                'controles__aparatoHematologico' => '"Aparato Hematológico"',
                'controles__sistemaEndocrino' => '"Sistema Endocrino"',
                'controles__sistemaOsteomuscular' => '"Sistema Osteomuscular"',
                'controles__sistemaNervioso' => '"Sistema Nervioso"',
                'controles__sistemaSensorial' => '"Sistema Sensorial"',
                'controles__psicosomatico' => '"Psicosomático"',

                'controles__terapeuticaAnterior' => '"Terapéutica Anterior"',

                'controles__ta' => '"Tensión Arterial"',
                'controles__fc' => '"Frecuencia Cardíaca"',
                'controles__fr' => '"Frecuencia Respiratoria"',
                'controles__temp' => '"Temperatura"',
                'controles__peso' => '"Peso"',
                'controles__talla' => '"Talla"',

                'controles__conciencia' => '"Conciencia"',
                'controles__hidratacion' => '"Hidratación"',
                'controles__coloracion' => '"Coloración"',
                'controles__marcha' => '"Marcha"',
                'controles__otrasAlteraciones' => '"Otras Alteraciones"',

                'controles__normocefalo' => '"Normocéfalo"',
                'controles__cabello' => '"Cabello"',
                'controles__pupilas' => '"Pupilas"',
                'controles__faringe' => '"Faringe"',
                'controles__amigdalas' => '"Amígdalas"',
                'controles__nariz' => '"Naríz"',
                'controles__adenomegaliasCabeza' => '"Adenomegalias Cabeza"',
                'controles__cuello' => '"Cuello"',
                'controles__adenomegaliasCuello' => '"Adenomegalias Cuello"',
                'controles__pulsos' => '"Pulsos"',
                'controles__torax' => '"Torax"',
                'controles__movResp' => '"Mov. Resp."',
                'controles__camposPulmonares' => '"Campos Pulmonares"',
                'controles__ruidosCardiacos' => '"Ruidos Cardíacos"',
                'controles__adenomegaliasAxilares' => '"Adenomegalias Axilares"',
                'controles__adenomegaliasAxilaresDescripcion' => '"Adenomegalias Axilares Descripción"',
                'controles__abdomen' => '"Abdomen"',
                'controles__dolorPalpacion' => '"Dolor Palpación"',
                'controles__dolorPalpacionDescripcion' => '"Dolor Palpación Descripción"',
                'controles__visceromegalias' => '"Visceromegalias"',
                'controles__peristalsis' => '"Peristalsis"',
                'controles__peristalsisDescripcion' => '"Peristalsis Descripción"',
                'controles__miembrosSuperiores' => '"Miembros Superiores"',
                'controles__miembrosInferiores' => '"Miembros Inferiores"',
                'controles__genitales' => '"Genitales"',

                'controles__tratamiento' => '"Tratamiento"',

                'controles__observacion' => '"Observación"',
            ]);

            if ($validator->fails()){
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

            //luego si existe, validamos la formula clinica
            //las creo afuera del if, ya que luego las necesito en la creacion
            $numeroMedicamentos = null;

            $itemsMedicamento = null;
            $itemsCantidad = null;
            $itemsDosisFrecuencia = null;
            $itemsHoras = null;
            $itemsDuracion = null;
            $itemsVia = null;
            $itemsObservacionFM = null;

            if($request['formulaMedicaHidden'] == '1'){//si se desplego el form para crear una formula clinica
                //debemos recorrer los array que llegan de la formula, y relacionar los atributos dentro de un for
                $numeroMedicamentos = count($request['itemsMedicamento']);

                $itemsMedicamento = $request['itemsMedicamento'];
                $itemsCantidad = $request['itemsCantidad'];
                $itemsDosisFrecuencia = $request['itemsDosisFrecuencia'];
                $itemsHoras = $request['itemsHoras'];
                $itemsDuracion = $request['itemsDuracion'];
                $itemsVia = $request['itemsVia'];
                $itemsObservacionFM = $request['itemsObservacionFM'];

                for($j = 0; $j < $numeroMedicamentos; $j++){
                    $requestFormulaMedica = $request->all();
                    $requestFormulaMedica['itemMedicamento'] = $itemsMedicamento[$j];
                    $requestFormulaMedica['itemCantidad'] = $itemsCantidad[$j];
                    $requestFormulaMedica['itemDosisFrecuencia'] = $itemsDosisFrecuencia[$j];
                    $requestFormulaMedica['itemHoras'] = $itemsHoras[$j];
                    $requestFormulaMedica['itemDuracion'] = $itemsDuracion[$j];
                    $requestFormulaMedica['itemVia'] = $itemsVia[$j];
                    $requestFormulaMedica['itemObservacionFM'] = $itemsObservacionFM[$j];

                    $indice = $j+1;

                    //validamos el objeto armado
                    $validator = Validator::make($requestFormulaMedica, [
                        'itemMedicamento' => 'required',
                        'itemCantidad' => 'required|numeric',
                        'itemDosisFrecuencia' => 'required|min:2|max:100',
                        'itemHoras' => 'required|min:2|max:100',
                        'itemDuracion' => 'required|min:2|max:100',
                        'itemVia' => 'required',
                        'itemObservacionFM' => 'nullable|min:2',
                    ], [], [
                        'itemMedicamento' => "\"Medicamento #$indice de la Fórmula médica\"",
                        'itemCantidad' => "\"Cantidad del Medicamento #$indice de la Fórmula médica\"",
                        'itemDosisFrecuencia' => "\"Dosis/Frecuencia del Medicamento #$indice de la Fórmula médica\"",
                        'itemHoras' => "\"Horas del Medicamento #$indice de la Fórmula médica\"",
                        'itemDuracion' => "\"Duración del Tratamiento con el Medicamento #$indice de la Fórmula médica\"",
                        'itemVia' => "\"Vía del Medicamento #$indice de la Fórmula médica\"",
                        'itemObservacionFM' => "\"Observación del Medicamento #$indice de la Fórmula médica\"",
                    ]);

                    if ($validator->fails()){
                        return response()->json(array(
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                        ), 400);
                    }
                }

                //al final necesito un validator solo para la observacion final de la formula clinica
                $validator = Validator::make($request->all(), [
                    'formulas__observacion' => 'nullable|min:2',
                ], [], [
                    'formulas__observacion' => '"Observación Final de la Formula Médica"',
                ]);

                if ($validator->fails()){
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //luego si existe, validamos la formula de tratamientos
            //las creo afuera del if, ya que luego las necesito en la creacion
            $numeroTratamientos = null;

            $itemsTratamiento = null;
            $itemsNumeroSesiones = null;
            $itemsFechaPosibleTerminacion = null;
            $itemsObservacionFT = null;

            if($request['formulaTratamientoHidden'] == '1'){//si se desplego el form para crear una formulacion de tratamientos
                //debemos recorrer los array que llegan de la formula, y relacionar los atributos dentro de un for
                $numeroTratamientos = count($request['itemsTratamiento']);

                $itemsTratamiento = $request['itemsTratamiento'];
                $itemsNumeroSesiones = $request['itemsNumeroSesiones'];
                $itemsFechaPosibleTerminacion = $request['itemsFechaPosibleTerminacion'];
                $itemsObservacionFT = $request['itemsObservacionFT'];

                for($j = 0; $j < $numeroTratamientos; $j++){
                    $requestFormulaTratamiento = $request->all();
                    $requestFormulaTratamiento['itemTratamiento'] = $itemsTratamiento[$j];
                    $requestFormulaTratamiento['itemNumeroSesiones'] = $itemsNumeroSesiones[$j];
                    $requestFormulaTratamiento['itemFechaPosibleTerminacion'] = $itemsFechaPosibleTerminacion[$j];
                    $requestFormulaTratamiento['itemObservacionFT'] = $itemsObservacionFT[$j];

                    $indice = $j+1;

                    //validamos el objeto armado
                    $validator = Validator::make($requestFormulaTratamiento, [
                        'itemTratamiento' => 'required',
                        'itemNumeroSesiones' => 'required|numeric',
                        'itemFechaPosibleTerminacion' => 'required|date',
                        'itemObservacionFT' => 'nullable|min:2',
                    ], [], [
                        'itemTratamiento' => "\"Tratamiento #$indice de la Formulación de tratamientos\"",
                        'itemNumeroSesiones' => "\"Número de Sesiones del Tratamiento #$indice de la Formulación de tratamientos\"",
                        'itemFechaPosibleTerminacion' => "\"Fecha Posible Terminación del Tratamiento #$indice de la Formulación de tratamientos\"",
                        'itemObservacionFT' => "\"Observación del Tratamiento #$indice de la Formulación de tratamientos\"",
                    ]);

                    if ($validator->fails()){
                        return response()->json(array(
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                        ), 400);
                    }

                    //despues de que pase la validacion de los campos, debemos validar que ese tratamiento no este asignado al paciente actualmente
                    $existencia = $this->itemformulatratamientos->existenciaFormulacionTratamiento($request['controles__paciente_id'], $itemsTratamiento[$j]);

                    if($existencia != 0){
                        return response()->json([
                            "mensaje" => "El tratamiento #$indice ya se encuentra asignado al paciente."
                        ]);
                    }
                }

                //al final necesito un validator solo para la observacion final de la formula de tratamientos
                $validator = Validator::make($request->all(), [
                    'tratamientos__observacion' => 'nullable|min:2',
                ], [], [
                    'tratamientos__observacion' => '"Observación Final de la Formulación de Tratamientos"',
                ]);

                if ($validator->fails()){
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //luego si existe, validamos la incapacidad medica
            if($request['incapacidadHidden'] == '1'){//si se desplego el form para crear una incapacidad medica
                $validator = Validator::make($request->all(), [
                    'incapacidades__fechaFin' => 'required',
                    'incapacidades__observacion' => 'nullable',
                ], [], [
                    'incapacidades__fechaFin' => '"Fecha Final Incapacidad"',
                    'incapacidades__observacion' => '"Observación"',
                ]);

                if ($validator->fails()){
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //luego si existe, validamos el certificado medico
            if($request['certificadoMedicoHidden'] == '1'){//si se desplego el form para crear un certificado medico
                $validator = Validator::make($request->all(), [
                    'certificados__contenido' => 'required',
                    'certificados__observacion' => 'nullable',
                ], [], [
                    'certificados__contenido' => '"Contenido del Certificado Médico"',
                    'certificados__observacion' => '"Observación"',
                ]);

                if ($validator->fails()){
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //luego si existe, validamos el consentimiento informado
            if($request['consentimientoInformadoHidden'] == '1'){//si se desplego el form para crear un consentimiento informado
                $validator = Validator::make($request->all(), [
                    'consentimientos__contenido' => 'required',
                    'consentimientos__observacion' => 'nullable',
                ], [], [
                    'consentimientos__contenido' => '"Contenido del Consentimiento Informado"',
                    'consentimientos__observacion' => '"Observación"',
                ]);

                if ($validator->fails()){
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //GESTION DE ACOMPANANTE
            $paciente = Paciente::find($request['controles__paciente_id']);
            $acompananteId = null;

            if($request['controles__acompanante_id'] != ''){//si es un acompanante existente, solo asignarlo al paciente
                $paciente->acompanantes()->attach($request['controles__acompanante_id'], ['parentesco' => $request['existente_parentesco']]);
                $acompananteId = $request['controles__acompanante_id'];
            }

            if($request['acompanantes__identificacion'] != '' || $request['acompanantes__tipoId'] != '' || $request['acompanantes__nombres'] != '' || $request['acompanantes__apellidos'] != '' || $request['nuevo_parentesco'] != '' || $request['acompanantes__telefonoFijo'] != '' || $request['acompanantes__telefonoCelular'] != ''){//o si es uno nuevo, crearlo y asignarlo al paciente, ademas de asignarselo a el control
                $acompanante = Acompanante::create([
                    'tipoId' => $request['acompanantes__tipoId'],
                    'identificacion' => $request['acompanantes__identificacion'],
                    'nombres' => $request['acompanantes__nombres'],
                    'apellidos' => $request['acompanantes__apellidos'],
                    'telefonoFijo' => $request['acompanantes__telefonoFijo'],
                    'telefonoCelular' => $request['acompanantes__telefonoCelular'],
                ]);
                $paciente->acompanantes()->attach($acompanante->id, ['parentesco' => $request['nuevo_parentesco']]);
                $acompananteId = $acompanante->id;
            }

            //CREAMOS EL CONTROL
            $ultimoIdControl = Control::orderBy('id','DESC')->first();

            if($ultimoIdControl == null){//si es el primer control en crear
                $ultimoIdControl = 1;
            }else{
                $ultimoIdControl = (int)($ultimoIdControl->id) + 1;//esto es para construir el numero
            }

            $controlNumero = (string)$ultimoIdControl.$request['paci_identificacion'].$request['controles__paciente_id'];

            $control = Control::create([
                'numero' => $controlNumero,
                'paciente_id' => $request['controles__paciente_id'],
                'acompanante_id' => $acompananteId,

                'padecimientoActual' => $request['controles__padecimientoActual'],
                'astenia' => $request['controles__astenia'],
                'adinamia' => $request['controles__adinamia'],
                'anorexia' => $request['controles__anorexia'],
                'fiebre' => $request['controles__fiebre'],
                'perdidaPeso' => $request['controles__perdidaPeso'],
                'aparatoDigestivo' => $request['controles__aparatoDigestivo'],
                'aparatoCardiovascular' => $request['controles__aparatoCardiovascular'],
                'aparatoRespiratorio' => $request['controles__aparatoRespiratorio'],
                'aparatoUrinario' => $request['controles__aparatoUrinario'],
                'aparatoGenital' => $request['controles__aparatoGenital'],
                'aparatoHematologico' => $request['controles__aparatoHematologico'],
                'sistemaEndocrino' => $request['controles__sistemaEndocrino'],
                'sistemaOsteomuscular' => $request['controles__sistemaOsteomuscular'],
                'sistemaNervioso' => $request['controles__sistemaNervioso'],
                'sistemaSensorial' => $request['controles__sistemaSensorial'],
                'psicosomatico' => $request['controles__psicosomatico'],
                'terapeuticaAnterior' => $request['controles__terapeuticaAnterior'],
                'ta' => $request['controles__ta'],
                'fc' => $request['controles__fc'],
                'fr' => $request['controles__fr'],
                'temp' => $request['controles__temp'],
                'peso' => $request['controles__peso'],
                'talla' => $request['controles__talla'],
                'conciencia' => $request['controles__conciencia'],
                'hidratacion' => $request['controles__hidratacion'],
                'coloracion' => $request['controles__coloracion'],
                'marcha' => $request['controles__marcha'],
                'otrasAlteraciones' => $request['controles__otrasAlteraciones'],
                'normocefalo' => $request['controles__normocefalo'],
                'cabello' => $request['controles__cabello'],
                'pupilas' => $request['controles__pupilas'],
                'faringe' => $request['controles__faringe'],
                'amigdalas' => $request['controles__amigdalas'],
                'nariz' => $request['nariz'],
                'adenomegaliasCabeza' => $request['controles__adenomegaliasCabeza'],
                'cuello' => $request['controles__cuello'],
                'adenomegaliasCuello' => $request['controles__adenomegaliasCuello'],
                'pulsos' => $request['controles__pulsos'],
                'torax' => $request['controles__torax'],
                'movResp' => $request['controles__movResp'],
                'camposPulmonares' => $request['controles__camposPulmonares'],
                'ruidosCardiacos' => $request['controles__ruidosCardiacos'],
                'adenomegaliasAxilares' => $request['controles__adenomegaliasAxilares'],
                'adenomegaliasAxilaresDescripcion' => $request['controles__adenomegaliasAxilaresDescripcion'],
                'abdomen' => $request['controles__abdomen'],
                'dolorPalpacion' => $request['controles__dolorPalpacion'],
                'dolorPalpacionDescripcion' => $request['controles__dolorPalpacionDescripcion'],
                'visceromegalias' => $request['controles__visceromegalias'],
                'peristalsis' => $request['controles__peristalsis'],
                'peristalsisDescripcion' => $request['controles__peristalsisDescripcion'],
                'miembrosSuperiores' => $request['controles__miembrosSuperiores'],
                'miembrosInferiores' => $request['controles__miembrosInferiores'],
                'genitales' => $request['controles__genitales'],
                'tratamiento' => $request['controles__tratamiento'],
                'observacion' => $request['controles__observacion'],

                'user_id' => Auth::user()->id,
            ]);

            //REGISTRAMOS LOS DIAGNOSTICOS
            $diagnosticos = $request['diagnosticos'];

            //primero en la relacion de pacientes y diagnosticos
            for($i = 0; $i < count($diagnosticos); $i++){
                $paciente->cie10s()->attach($diagnosticos[$i]);
            }
            //ahora en la relacion del control y los diagnosticos
            $control->cie10s()->sync($diagnosticos);

            //GESTION DE LA FORMULA CLINICA
            if($request['formulaMedicaHidden'] == '1'){//si se desplego el form para crear una formula medica
                //antes de insertar los medicamentos (items), hacemos el registro de la entidad formula medica
                $ultimoIdFormulaMedica = Formula::orderBy('id','DESC')->first();

                if($ultimoIdFormulaMedica == null){//si es la primera formula medica en crear
                    $ultimoIdFormulaMedica = 1;
                }else{
                    $ultimoIdFormulaMedica = (int)($ultimoIdFormulaMedica->id) + 1;//esto es para construir el numero
                }

                $formulaMedicaNumero = (string)$ultimoIdFormulaMedica.$request['paci_identificacion'].$request['controles__paciente_id'];

                $formulaMedica = Formula::create([
                    'numero' => $formulaMedicaNumero,
                    'control_id' => $control->id,
                    'paciente_id' => $request['controles__paciente_id'],
                    'observacion' => $request['formulas__observacion'],
                    'user_id' => Auth::user()->id,
                ]);

                //ahora debemos insertar los registros de relacion entre la formula medica y los cie10 que tiene asociados
                $formulaMedica->cie10s()->sync($diagnosticos);

                //por ultimo para insertar los items de la formula, debemos recorrer los array, y relacionar los atributos dentro de un for
                for($p = 0; $p < $numeroMedicamentos; $p++){
                    ItemFormula::create([
                        'formula_id' => $formulaMedica->id,
                        'medicamento_id' => $itemsMedicamento[$p],
                        'viaMedicamento_id' => $itemsVia[$p],
                        'cantidad' => $itemsCantidad[$p],
                        'dosisFrecuencia' => $itemsDosisFrecuencia[$p],
                        'horas' => $itemsHoras[$p],
                        'duracion' => $itemsDuracion[$p],
                        'observacion' => $itemsObservacionFM[$p],
                    ]);
                }
            }

            //GESTION DE LA FORMULA DE TRATAMIENTOS
            if($request['formulaTratamientoHidden'] == '1'){//si se desplego el form para crear una formula de tratamientos
                //antes de insertar los tratamientos (items), hacemos el registro de la entidad formula tratamientos
                $ultimoIdFormulaTratamiento = FormulaTratamiento::orderBy('id','DESC')->first();

                if($ultimoIdFormulaTratamiento == null){//si es la primera formulacion de tratamientos en crear
                    $ultimoIdFormulaTratamiento = 1;
                }else{
                    $ultimoIdFormulaTratamiento = (int)($ultimoIdFormulaTratamiento->id) + 1;//esto es para construir el numero
                }

                $formulaTratamientoNumero = (string)$ultimoIdFormulaTratamiento.$request['paci_identificacion'].$request['controles__paciente_id'];

                $formulaTratamiento = FormulaTratamiento::create([
                    'numero' => $formulaTratamientoNumero,
                    'control_id' => $control->id,
                    'paciente_id' => $request['controles__paciente_id'],
                    'observacion' => $request['tratamientos__observacion'],
                    'user_id' => Auth::user()->id,
                ]);

                //ahora debemos insertar los registros de relacion entre la formula tratamiento y los cie10 que tiene asociados
                $formulaTratamiento->cie10s()->sync($diagnosticos);

                //por ultimo para insertar los items de la formula, debemos recorrer los array, y relacionar los atributos dentro de un for
                for($p = 0; $p < $numeroTratamientos; $p++){
                    ItemFormulaTratamiento::create([
                        'formulaTratamiento_id' => $formulaTratamiento->id,
                        'tratamiento_id' => $itemsTratamiento[$p],
                        'numeroSesiones' => $itemsNumeroSesiones[$p],
                        'sesionesRealizadas' => 0,
                        'activo' => 1,
                        'fechaPosibleTerminacion' => $itemsFechaPosibleTerminacion[$p],
                        'observacion' => $itemsObservacionFT[$p],
                    ]);
                }
            }

            //GESTION DE LA INCAPACIDAD
            if($request['incapacidadHidden'] == '1'){
                $ultimoIdIncapacidad = IncapacidadMedica::orderBy('id','DESC')->first();

                if($ultimoIdIncapacidad == null){//si es la primera incapacidad en crear
                    $ultimoIdIncapacidad = 1;
                }else{
                    $ultimoIdIncapacidad = (int)($ultimoIdIncapacidad->id) + 1;//esto es para construir el numero
                }

                $incapacidadNumero = (string)$ultimoIdIncapacidad.$request['paci_identificacion'].$request['controles__paciente_id'];

                IncapacidadMedica::create([
                    'numero' => $incapacidadNumero,
                    'control_id' => $control->id,
                    'paciente_id' => $request['controles__paciente_id'],
                    'fechaFin' => $request['incapacidades__fechaFin'],
                    'observacion' => $request['incapacidades__observacion'],
                    'user_id' => Auth::user()->id,
                ]);
            }

            //GESTION DEL CERTIFICADO MEDICO
            if($request['certificadoMedicoHidden'] == '1'){
                $ultimoIdCertificado = CertificadoMedico::orderBy('id','DESC')->first();

                if($ultimoIdCertificado == null){//si es el primer certificado en crear
                    $ultimoIdCertificado = 1;
                }else{
                    $ultimoIdCertificado = (int)($ultimoIdCertificado->id) + 1;//esto es para construir el numero
                }

                $certificadoNumero = (string)$ultimoIdCertificado.$request['paci_identificacion'].$request['controles__paciente_id'];

                CertificadoMedico::create([
                    'numero' => $certificadoNumero,
                    'control_id' => $control->id,
                    'paciente_id' => $request['controles__paciente_id'],
                    'contenido' => $request['certificados__contenido'],
                    'observacion' => $request['certificados__observacion'],
                    'user_id' => Auth::user()->id,
                ]);
            }

            //GESTION DEL CONSENTIMIENTO INFORMADO
            if($request['consentimientoInformadoHidden'] == '1'){
                $ultimoIdConsentimiento = Consentimiento::orderBy('id','DESC')->first();

                if($ultimoIdConsentimiento == null){//si es el primer consentimiento en crear
                    $ultimoIdConsentimiento = 1;
                }else{
                    $ultimoIdConsentimiento = (int)($ultimoIdConsentimiento->id) + 1;//esto es para construir el numero
                }

                $consentimientoNumero = (string)$ultimoIdConsentimiento.$request['paci_identificacion'].$request['controles__paciente_id'];

                Consentimiento::create([
                    'numero' => $consentimientoNumero,
                    'control_id' => $control->id,
                    'paciente_id' => $request['controles__paciente_id'],
                    'contenido' => $request['consentimientos__contenido'],
                    'observacion' => $request['consentimientos__observacion'],
                    'user_id' => Auth::user()->id,
                ]);
            }

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function detallar($id)
    {
        //envio de datos a la vista
        $control = Control::find($id);
        $formula = Formula::where('control_id', $control->id)->first();
        $formulaTratamiento = FormulaTratamiento::where('control_id', $control->id)->first();
        $incapacidadMedica = IncapacidadMedica::where('control_id', $control->id)->first();
        $certificadoMedico = CertificadoMedico::where('control_id', $control->id)->first();
        $consentimientoInformado = Consentimiento::where('control_id', $control->id)->first();

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $control);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $control);
        }

        return view('panel.control.detallar', compact('control', 'formula', 'formulaTratamiento', 'incapacidadMedica', 'certificadoMedico', 'consentimientoInformado'));
    }

    public function ver($id)
    {
        //envio de datos a la vista
        $control = Control::find($id);
        $paciente = $this->pacientes->findPacienteById($control->paciente->id);//no uso el paciente desde control, ya que usando este metodo, me trae datos especiales como edad
        if($control->acompanante != null){//traigo el parentesco del acompanante del paciente que se encuentra en la tabla pivot
            $parentescoAcompanante = $this->acompanantes->findParentescoAcompanante($control->paciente->id, $control->acompanante->id);
        }else{
            $parentescoAcompanante = null;
        }
        $informacion = InfoCentro::find(1);
        $formula = Formula::where('control_id', $control->id)->first();
        $formulaTratamiento = FormulaTratamiento::where('control_id', $control->id)->first();
        $incapacidadMedica = IncapacidadMedica::where('control_id', $control->id)->first();
        $certificadoMedico = CertificadoMedico::where('control_id', $control->id)->first();
        $consentimientoInformado = Consentimiento::where('control_id', $control->id)->first();

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $control);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $control);
        }

        $pdf = PDF::loadView('panel.control.ver', ['control' => $control, 'paciente' => $paciente, 'parentescoAcompanante' => $parentescoAcompanante, 'informacion' => $informacion, 'formula' => $formula, 'formulaTratamiento' => $formulaTratamiento, 'incapacidadMedica' => $incapacidadMedica, 'certificadoMedico' => $certificadoMedico, 'consentimientoInformado' => $consentimientoInformado]);
        return $pdf->stream();
    }

    public function versimple($id)
    {
        //envio de datos a la vista
        $control = Control::find($id);
        $paciente = $this->pacientes->findPacienteById($control->paciente->id);//no uso el paciente desde control, ya que usando este metodo, me trae datos especiales como edad
        if($control->acompanante != null){//traigo el parentesco del acompanante del paciente que se encuentra en la tabla pivot
            $parentescoAcompanante = $this->acompanantes->findParentescoAcompanante($control->paciente->id, $control->acompanante->id);
        }else{
            $parentescoAcompanante = null;
        }
        $informacion = InfoCentro::find(1);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $control);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $control);
        }

        $pdf = PDF::loadView('panel.control.versimple', ['control' => $control, 'paciente' => $paciente, 'parentescoAcompanante' => $parentescoAcompanante, 'informacion' => $informacion]);
        return $pdf->stream();
    }
}
