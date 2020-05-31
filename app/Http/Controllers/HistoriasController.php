<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Acompanante;
use Ace\Repositories\AcompanantesRepository;
use Ace\CertificadoMedico;
use Ace\Consentimiento;
use Ace\Formato;
use Ace\Formula;
use Ace\FormulaTratamiento;
use Ace\HistoriaClinica;
use Ace\Repositories\HistoriasRepository;
use Ace\IncapacidadMedica;
use Ace\ItemFormula;
use Ace\ItemFormulaTratamiento;
use Ace\InfoCentro;
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

class HistoriasController extends Controller
{
    private $pacientes;
    private $historias;
    private $itemformulatratamientos;
    private $acompanantes;

    public function __construct(PacientesRepository $pacientes, HistoriasRepository $historias, ItemformulatratamientosRepository $itemformulatratamientos, AcompanantesRepository $acompanantes)
    {
        $this->pacientes = $pacientes;
        $this->historias = $historias;
        $this->itemformulatratamientos = $itemformulatratamientos;
        $this->acompanantes = $acompanantes;
    }

    public function listar(Request $request)
    {
        return view('panel.historia.listar');
    }

    public function datatable(Request $request)
    {
        $historiasRequest = $request->all();
        //variables traidas por post para server side
        $start = $historiasRequest['start'];
        $length = $historiasRequest['length'];
        $search = $historiasRequest['search']['value'];
        $draw = $historiasRequest['draw'];
        $historias = null;
        $historiasNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $historias = $this->historias->findHistoriasDatatableSearch($start, $length, $search, Auth::user()->id);
                $historiasNumero = $this->historias->findHistoriasDatatableSearchNum($search, Auth::user()->id);
            }else{
                $historias = $this->historias->findHistoriasDatatable($start, $length, Auth::user()->id);
                $historiasNumero = $this->historias->findHistoriasDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $historias = $this->historias->findHistoriasDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $historiasNumero = $this->historias->findHistoriasDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $historias = $this->historias->findHistoriasDatatable($start, $length, Session::get('medicoActual')->user->id);
                $historiasNumero = $this->historias->findHistoriasDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($historias->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($historiasNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($historias as $historia) {
            $array = array();
            $array['id'] = $historia->id;
            $array['numero'] = $historia->numero;
            $array['paciente'] = $historia->nombres.' '.$historia->apellidos.'<br>'.'('.$historia->identificacion.')';
            $array['creado'] = $historia->created_at;

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

        return view('panel.historia.crear', compact('viaMedicamentos','formatos'));
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

            //luego validamos los campos enviados de historia clinica
            $validator = Validator::make($request->all(), [
                'historias__paciente_id' => 'required',
                'historias__acompanante_id' => 'nullable',

                'existente_parentesco' => 'required_with:historias__acompanante_id|max:20',

                'historias__parentescoDiabetes' => 'nullable|min:2|max:255',
                'historias__parentescoHipertension' => 'nullable|min:2|max:255',
                'historias__parentescoCardiopatia' => 'nullable|min:2|max:255',
                'historias__parentescoHepatopatia' => 'nullable|min:2|max:255',
                'historias__parentescoNefropatia' => 'nullable|min:2|max:255',
                'historias__parentescoEnfermedadesMentales' => 'nullable|min:2|max:255',
                'historias__parentescoAsma' => 'nullable|min:2|max:255',
                'historias__parentescoCancer' => 'nullable|min:2|max:255',
                'historias__parentescoEnfermedadesAlergicas' => 'nullable|min:2|max:255',
                'historias__parentescoEnfermedadesEndocrinas' => 'nullable|min:2|max:255',
                'historias__otrosDescripcion' => 'nullable|min:2',
                'historias__parentescoOtros' => 'nullable|min:2|max:255',

                'historias__descripcionQuirurgicos' => 'nullable|min:2|max:255',
                'historias__descripcionTransfusionales' => 'nullable|min:2|max:255',
                'historias__descripcionAlergias' => 'nullable|min:2|max:255',
                'historias__descripcionTraumaticos' => 'nullable|min:2|max:255',
                'historias__descripcionHospitalizacionesPrevias' => 'nullable|min:2|max:255',
                'historias__descripcionAdicciones' => 'nullable|min:2|max:255',
                'historias__descripcionOtros' => 'nullable|min:2',

                'historias__bano' => 'nullable',
                'historias__banoDientes' => 'nullable',
                'historias__servicioAguaPotable' => 'nullable',
                'historias__cigarrillosDiarios' => 'nullable|numeric',
                'historias__anosFumando' => 'nullable|numeric',
                'historias__alcoholismoFrecuencia' => 'nullable|min:2|max:100',
                'historias__comidasDiarias' => 'nullable|numeric',
                'historias__calidadComida' => 'nullable|min:2|max:100',
                'historias__actividadFisica' => 'nullable|min:2|max:100',
                'historias__inmunizaciones' => 'nullable',
                'historias__inmunizacionesPendientes' => 'nullable|min:2|max:100',
                'historias__ultimaDesparacitacion' => 'nullable|min:2|max:100',

                'historias__menarca' => 'nullable|min:2|max:100',
                'historias__ritmoMenstrual' => 'nullable|min:2|max:100',
                'historias__dismenorrea' => 'nullable',
                'historias__fum' => 'nullable',
                'historias__ivsa' => 'nullable',
                'historias__numeroParejas' => 'nullable|numeric',
                'historias__fpp' => 'nullable',
                'historias__fup' => 'nullable',
                'historias__menopausia' => 'nullable',
                'historias__metodoPlanificacion' => 'nullable|min:2|max:100',
                'historias__citologiaVaginal' => 'nullable|min:2|max:100',
                'historias__examenMamas' => 'nullable|min:2|max:100',

                'historias__padecimientoActual' => 'required|min:2',

                'historias__astenia' => 'nullable',
                'historias__adinamia' => 'nullable',
                'historias__anorexia' => 'nullable',
                'historias__fiebre' => 'nullable',
                'historias__perdidaPeso' => 'nullable',

                'historias__aparatoDigestivo' => 'nullable|min:2',
                'historias__aparatoCardiovascular' => 'nullable|min:2',
                'historias__aparatoRespiratorio' => 'nullable|min:2',
                'historias__aparatoUrinario' => 'nullable|min:2',
                'historias__aparatoGenital' => 'nullable|min:2',
                'historias__aparatoHematologico' => 'nullable|min:2',
                'historias__sistemaEndocrino' => 'nullable|min:2',
                'historias__sistemaOsteomuscular' => 'nullable|min:2',
                'historias__sistemaNervioso' => 'nullable|min:2',
                'historias__sistemaSensorial' => 'nullable|min:2',
                'historias__psicosomatico' => 'nullable|min:2',

                'historias__terapeuticaAnterior' => 'nullable|min:2',

                'historias__ta' => 'required|min:2|max:20',
                'historias__fc' => 'nullable|min:2|max:20',
                'historias__fr' => 'nullable|min:2|max:20',
                'historias__temp' => 'nullable|min:2|max:20',
                'historias__peso' => 'required|min:2|max:20',
                'historias__talla' => 'nullable|min:2|max:20',

                'historias__conciencia' => 'nullable',
                'historias__hidratacion' => 'nullable',
                'historias__coloracion' => 'nullable',
                'historias__marcha' => 'nullable',
                'historias__otrasAlteraciones' => 'nullable|min:2',

                'historias__normocefalo' => 'nullable',
                'historias__cabello' => 'nullable',
                'historias__pupilas' => 'nullable',
                'historias__faringe' => 'nullable',
                'historias__amigdalas' => 'nullable',
                'historias__nariz' => 'nullable',
                'historias__adenomegaliasCabeza' => 'nullable',
                'historias__cuello' => 'nullable',
                'historias__adenomegaliasCuello' => 'nullable',
                'historias__pulsos' => 'nullable',
                'historias__torax' => 'nullable',
                'historias__movResp' => 'nullable',
                'historias__camposPulmonares' => 'nullable',
                'historias__ruidosCardiacos' => 'nullable',
                'historias__adenomegaliasAxilares' => 'nullable',
                'historias__adenomegaliasAxilaresDescripcion' => 'nullable|min:2',
                'historias__abdomen' => 'nullable',
                'historias__dolorPalpacion' => 'nullable',
                'historias__dolorPalpacionDescripcion' => 'nullable|min:2',
                'historias__visceromegalias' => 'nullable',
                'historias__peristalsis' => 'nullable',
                'historias__peristalsisDescripcion' => 'nullable|min:2',
                'historias__miembrosSuperiores' => 'nullable',
                'historias__miembrosInferiores' => 'nullable',
                'historias__genitales' => 'nullable|min:2',

                'historias__tratamiento' => 'required|min:2',

                'historias__observacion' => 'nullable|min:2',
            ], [], [
                'historias__paciente_id' => '"Paciente"',
                'historias__acompanante_id' => '"Acompañante"',

                'existente_parentesco' => '"Parentesco para Acompañante Existente"',

                'historias__parentescoDiabetes' => '"Parentesco Diabetes"',
                'historias__parentescoHipertension' => '"Parentesco Hipertensión"',
                'historias__parentescoCardiopatia' => '"Parentesco Cardiopatía"',
                'historias__parentescoHepatopatia' => '"Parentesco Hepatopatía"',
                'historias__parentescoNefropatia' => '"Parentesco Nefropatía"',
                'historias__parentescoEnfermedadesMentales' => '"Parentesco Enfermedades Mentales"',
                'historias__parentescoAsma' => '"Parentesco Asma"',
                'historias__parentescoCancer' => '"Parentesco Cancer"',
                'historias__parentescoEnfermedadesAlergicas' => '"Parentesco Enfermedades Alérgicas"',
                'historias__parentescoEnfermedadesEndocrinas' => '"Parentesco Enfermedades Endocrinas"',
                'historias__otrosDescripcion' => '"Otras Enfermedades"',
                'historias__parentescoOtros' => '"Parentesco Otras Enfermedades"',

                'historias__descripcionQuirurgicos' => '"Quirúrgicos"',
                'historias__descripcionTransfusionales' => '"Transfusionales"',
                'historias__descripcionAlergias' => '"Alergias"',
                'historias__descripcionTraumaticos' => '"Traumáticos"',
                'historias__descripcionHospitalizacionesPrevias' => '"Hospitalizaciones Previas"',
                'historias__descripcionAdicciones' => '"Adicciones"',
                'historias__descripcionOtros' => '"Otros"',

                'historias__bano' => '"Baño"',
                'historias__banoDientes' => '"Baño Dientes"',
                'historias__servicioAguaPotable' => '"Servicio Agua Potable"',
                'historias__cigarrillosDiarios' => '"Número Cigarrillos Diarios"',
                'historias__anosFumando' => '"Años Fumando"',
                'historias__alcoholismoFrecuencia' => '"Alcoholismo Frecuencia"',
                'historias__comidasDiarias' => '"Número Comidas Diarias"',
                'historias__calidadComida' => '"Calidad Comida"',
                'historias__actividadFisica' => '"Actividad Física"',
                'historias__inmunizaciones' => '"Inmunizaciones"',
                'historias__inmunizacionesPendientes' => '"Inmunizaciones Pendientes"',
                'historias__ultimaDesparacitacion' => '"Última Desparacitación"',

                'historias__menarca' => '"Menarca"',
                'historias__ritmoMenstrual' => '"Ritmo Menstrual"',
                'historias__dismenorrea' => '"Dismenorrea"',
                'historias__fum' => '"Fecha Última Menstruación"',
                'historias__ivsa' => '"Inicio de Vida Sexual"',
                'historias__numeroParejas' => '"Número Parejas"',
                'historias__fpp' => '"Fecha Probable de Parto"',
                'historias__fup' => '"Fecha Último Parto"',
                'historias__menopausia' => '"Menopausia"',
                'historias__metodoPlanificacion' => '"Método Planificación"',
                'historias__citologiaVaginal' => '"Citología Vaginal"',
                'historias__examenMamas' => '"Éxamen Mamas"',

                'historias__padecimientoActual' => '"Padecimiento Actual"',

                'historias__astenia' => '"Astenia"',
                'historias__adinamia' => '"Adinamia"',
                'historias__anorexia' => '"Anorexia"',
                'historias__fiebre' => '"Fiebre"',
                'historias__perdidaPeso' => '"Pérdida Peso"',

                'historias__aparatoDigestivo' => '"Aparato Digestivo"',
                'historias__aparatoCardiovascular' => '"Aparato Cardiovascular"',
                'historias__aparatoRespiratorio' => '"Aparato Respiratorio"',
                'historias__aparatoUrinario' => '"Aparato Urinario"',
                'historias__aparatoGenital' => '"Aparato Genital"',
                'historias__aparatoHematologico' => '"Aparato Hematológico"',
                'historias__sistemaEndocrino' => '"Sistema Endocrino"',
                'historias__sistemaOsteomuscular' => '"Sistema Osteomuscular"',
                'historias__sistemaNervioso' => '"Sistema Nervioso"',
                'historias__sistemaSensorial' => '"Sistema Sensorial"',
                'historias__psicosomatico' => '"Psicosomático"',

                'historias__terapeuticaAnterior' => '"Terapéutica Anterior"',

                'historias__ta' => '"Tensión Arterial"',
                'historias__fc' => '"Frecuencia Cardíaca"',
                'historias__fr' => '"Frecuencia Respiratoria"',
                'historias__temp' => '"Temperatura"',
                'historias__peso' => '"Peso"',
                'historias__talla' => '"Talla"',

                'historias__conciencia' => '"Conciencia"',
                'historias__hidratacion' => '"Hidratación"',
                'historias__coloracion' => '"Coloración"',
                'historias__marcha' => '"Marcha"',
                'historias__otrasAlteraciones' => '"Otras Alteraciones"',

                'historias__normocefalo' => '"Normocéfalo"',
                'historias__cabello' => '"Cabello"',
                'historias__pupilas' => '"Pupilas"',
                'historias__faringe' => '"Faringe"',
                'historias__amigdalas' => '"Amígdalas"',
                'historias__nariz' => '"Naríz"',
                'historias__adenomegaliasCabeza' => '"Adenomegalias Cabeza"',
                'historias__cuello' => '"Cuello"',
                'historias__adenomegaliasCuello' => '"Adenomegalias Cuello"',
                'historias__pulsos' => '"Pulsos"',
                'historias__torax' => '"Torax"',
                'historias__movResp' => '"Mov. Resp."',
                'historias__camposPulmonares' => '"Campos Pulmonares"',
                'historias__ruidosCardiacos' => '"Ruidos Cardíacos"',
                'historias__adenomegaliasAxilares' => '"Adenomegalias Axilares"',
                'historias__adenomegaliasAxilaresDescripcion' => '"Adenomegalias Axilares Descripción"',
                'historias__abdomen' => '"Abdomen"',
                'historias__dolorPalpacion' => '"Dolor Palpación"',
                'historias__dolorPalpacionDescripcion' => '"Dolor Palpación Descripción"',
                'historias__visceromegalias' => '"Visceromegalias"',
                'historias__peristalsis' => '"Peristalsis"',
                'historias__peristalsisDescripcion' => '"Peristalsis Descripción"',
                'historias__miembrosSuperiores' => '"Miembros Superiores"',
                'historias__miembrosInferiores' => '"Miembros Inferiores"',
                'historias__genitales' => '"Genitales"',

                'historias__tratamiento' => '"Tratamiento"',

                'historias__observacion' => '"Observación"',
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
                    $existencia = $this->itemformulatratamientos->existenciaFormulacionTratamiento($request['historias__paciente_id'], $itemsTratamiento[$j]);

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
            $paciente = Paciente::find($request['historias__paciente_id']);
            $acompananteId = null;

            if($request['historias__acompanante_id'] != ''){//si es un acompanante existente, solo asignarlo al paciente
                $paciente->acompanantes()->attach($request['historias__acompanante_id'], ['parentesco' => $request['existente_parentesco']]);
                $acompananteId = $request['historias__acompanante_id'];
            }

            if($request['acompanantes__identificacion'] != '' || $request['acompanantes__tipoId'] != '' || $request['acompanantes__nombres'] != '' || $request['acompanantes__apellidos'] != '' || $request['nuevo_parentesco'] != '' || $request['acompanantes__telefonoFijo'] != '' || $request['acompanantes__telefonoCelular'] != ''){//o si es uno nuevo, crearlo y asignarlo al paciente, ademas de asignarselo a la historia
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

            //CREAMOS LA HISTORIA
            $ultimoIdHistoria = HistoriaClinica::orderBy('id','DESC')->first();

            if($ultimoIdHistoria == null){//si es la primera historia en crear
                $ultimoIdHistoria = 1;
            }else{
                $ultimoIdHistoria = (int)($ultimoIdHistoria->id) + 1;//esto es para construir el numero
            }

            $historiaNumero = (string)$ultimoIdHistoria.$request['paci_identificacion'].$request['historias__paciente_id'];

            $historiaClinica = HistoriaClinica::create([
                'numero' => $historiaNumero,
                'paciente_id' => $request['historias__paciente_id'],
                'acompanante_id' => $acompananteId,

                'parentescoDiabetes' => $request['historias__parentescoDiabetes'],
                'parentescoHipertension' => $request['historias__parentescoHipertension'],
                'historias__parentescoCardiopatia' => $request['historias__parentescoCardiopatia'],
                'parentescoHepatopatia' => $request['historias__parentescoHepatopatia'],
                'parentescoNefropatia' => $request['historias__parentescoNefropatia'],
                'parentescoEnfermedadesMentales' => $request['historias__parentescoEnfermedadesMentales'],
                'parentescoAsma' => $request['historias__parentescoAsma'],
                'parentescoCancer' => $request['historias__parentescoCancer'],
                'parentescoEnfermedadesAlergicas' => $request['historias__parentescoEnfermedadesAlergicas'],
                'parentescoEnfermedadesEndocrinas' => $request['historias__parentescoEnfermedadesEndocrinas'],
                'otrosDescripcion' => $request['historias__otrosDescripcion'],
                'parentescoOtros' => $request['historias__parentescoOtros'],
                'descripcionQuirurgicos' => $request['historias__descripcionQuirurgicos'],
                'descripcionTransfusionales' => $request['historias__descripcionTransfusionales'],
                'descripcionAlergias' => $request['historias__descripcionAlergias'],
                'descripcionTraumaticos' => $request['historias__descripcionTraumaticos'],
                'descripcionHospitalizacionesPrevias' => $request['historias__descripcionHospitalizacionesPrevias'],
                'descripcionAdicciones' => $request['historias__descripcionAdicciones'],
                'descripcionOtros' => $request['historias__descripcionOtros'],
                'bano' => $request['historias__bano'],
                'banoDientes' => $request['historias__banoDientes'],
                'servicioAguaPotable' => $request['historias__servicioAguaPotable'],
                'cigarrillosDiarios' => $request['historias__cigarrillosDiarios'],
                'anosFumando' => $request['historias__anosFumando'],
                'alcoholismoFrecuencia' => $request['historias__alcoholismoFrecuencia'],
                'comidasDiarias' => $request['historias__comidasDiarias'],
                'calidadComida' => $request['historias__calidadComida'],
                'actividadFisica' => $request['historias__actividadFisica'],
                'inmunizaciones' => $request['historias__inmunizaciones'],
                'inmunizacionesPendientes' => $request['historias__inmunizacionesPendientes'],
                'ultimaDesparacitacion' => $request['historias__ultimaDesparacitacion'],
                'menarca' => $request['historias__menarca'],
                'ritmoMenstrual' => $request['historias__ritmoMenstrual'],
                'dismenorrea' => $request['historias__dismenorrea'],
                'fum' => $request['historias__fum'],
                'ivsa' => $request['historias__ivsa'],
                'numeroParejas' => $request['historias__numeroParejas'],
                'fpp' => $request['historias__fpp'],
                'fup' => $request['historias__fup'],
                'menopausia' => $request['historias__menopausia'],
                'metodoPlanificacion' => $request['historias__metodoPlanificacion'],
                'citologiaVaginal' => $request['historias__citologiaVaginal'],
                'examenMamas' => $request['historias__examenMamas'],
                'padecimientoActual' => $request['historias__padecimientoActual'],
                'astenia' => $request['historias__astenia'],
                'adinamia' => $request['historias__adinamia'],
                'anorexia' => $request['historias__anorexia'],
                'fiebre' => $request['historias__fiebre'],
                'perdidaPeso' => $request['historias__perdidaPeso'],
                'aparatoDigestivo' => $request['historias__aparatoDigestivo'],
                'aparatoCardiovascular' => $request['historias__aparatoCardiovascular'],
                'aparatoRespiratorio' => $request['historias__aparatoRespiratorio'],
                'aparatoUrinario' => $request['historias__aparatoUrinario'],
                'aparatoGenital' => $request['historias__aparatoGenital'],
                'aparatoHematologico' => $request['historias__aparatoHematologico'],
                'sistemaEndocrino' => $request['historias__sistemaEndocrino'],
                'sistemaOsteomuscular' => $request['historias__sistemaOsteomuscular'],
                'sistemaNervioso' => $request['historias__sistemaNervioso'],
                'sistemaSensorial' => $request['historias__sistemaSensorial'],
                'psicosomatico' => $request['historias__psicosomatico'],
                'terapeuticaAnterior' => $request['historias__terapeuticaAnterior'],
                'ta' => $request['historias__ta'],
                'fc' => $request['historias__fc'],
                'fr' => $request['historias__fr'],
                'temp' => $request['historias__temp'],
                'peso' => $request['historias__peso'],
                'talla' => $request['historias__talla'],
                'conciencia' => $request['historias__conciencia'],
                'hidratacion' => $request['historias__hidratacion'],
                'coloracion' => $request['historias__coloracion'],
                'marcha' => $request['historias__marcha'],
                'otrasAlteraciones' => $request['historias__otrasAlteraciones'],
                'normocefalo' => $request['historias__normocefalo'],
                'cabello' => $request['historias__cabello'],
                'pupilas' => $request['historias__pupilas'],
                'faringe' => $request['historias__faringe'],
                'amigdalas' => $request['historias__amigdalas'],
                'nariz' => $request['nariz'],
                'adenomegaliasCabeza' => $request['historias__adenomegaliasCabeza'],
                'cuello' => $request['historias__cuello'],
                'adenomegaliasCuello' => $request['historias__adenomegaliasCuello'],
                'pulsos' => $request['historias__pulsos'],
                'torax' => $request['historias__torax'],
                'movResp' => $request['historias__movResp'],
                'camposPulmonares' => $request['historias__camposPulmonares'],
                'ruidosCardiacos' => $request['historias__ruidosCardiacos'],
                'adenomegaliasAxilares' => $request['historias__adenomegaliasAxilares'],
                'adenomegaliasAxilaresDescripcion' => $request['historias__adenomegaliasAxilaresDescripcion'],
                'abdomen' => $request['historias__abdomen'],
                'dolorPalpacion' => $request['historias__dolorPalpacion'],
                'dolorPalpacionDescripcion' => $request['historias__dolorPalpacionDescripcion'],
                'visceromegalias' => $request['historias__visceromegalias'],
                'peristalsis' => $request['historias__peristalsis'],
                'peristalsisDescripcion' => $request['historias__peristalsisDescripcion'],
                'miembrosSuperiores' => $request['historias__miembrosSuperiores'],
                'miembrosInferiores' => $request['historias__miembrosInferiores'],
                'genitales' => $request['historias__genitales'],
                'tratamiento' => $request['historias__tratamiento'],
                'observacion' => $request['historias__observacion'],

                'user_id' => Auth::user()->id,
            ]);

            //REGISTRAMOS LOS DIAGNOSTICOS
            $diagnosticos = $request['diagnosticos'];

            //primero en la relacion de pacientes y diagnosticos
            for($i = 0; $i < count($diagnosticos); $i++){
                $paciente->cie10s()->attach($diagnosticos[$i]);
            }
            //ahora en la relacion de la historia y los diagnosticos
            $historiaClinica->cie10s()->sync($diagnosticos);

            //GESTION DE LA FORMULA CLINICA
            if($request['formulaMedicaHidden'] == '1'){//si se desplego el form para crear una formula medica
                //antes de insertar los medicamentos (items), hacemos el registro de la entidad formula medica
                $ultimoIdFormulaMedica = Formula::orderBy('id','DESC')->first();

                if($ultimoIdFormulaMedica == null){//si es la primera formula medica en crear
                    $ultimoIdFormulaMedica = 1;
                }else{
                    $ultimoIdFormulaMedica = (int)($ultimoIdFormulaMedica->id) + 1;//esto es para construir el numero
                }

                $formulaMedicaNumero = (string)$ultimoIdFormulaMedica.$request['paci_identificacion'].$request['historias__paciente_id'];

                $formulaMedica = Formula::create([
                    'numero' => $formulaMedicaNumero,
                    'historiaClinica_id' => $historiaClinica->id,
                    'paciente_id' => $request['historias__paciente_id'],
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

                $formulaTratamientoNumero = (string)$ultimoIdFormulaTratamiento.$request['paci_identificacion'].$request['historias__paciente_id'];

                $formulaTratamiento = FormulaTratamiento::create([
                    'numero' => $formulaTratamientoNumero,
                    'historiaClinica_id' => $historiaClinica->id,
                    'paciente_id' => $request['historias__paciente_id'],
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

                $incapacidadNumero = (string)$ultimoIdIncapacidad.$request['paci_identificacion'].$request['historias__paciente_id'];

                IncapacidadMedica::create([
                    'numero' => $incapacidadNumero,
                    'historiaClinica_id' => $historiaClinica->id,
                    'paciente_id' => $request['historias__paciente_id'],
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

                $certificadoNumero = (string)$ultimoIdCertificado.$request['paci_identificacion'].$request['historias__paciente_id'];

                CertificadoMedico::create([
                    'numero' => $certificadoNumero,
                    'historiaClinica_id' => $historiaClinica->id,
                    'paciente_id' => $request['historias__paciente_id'],
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

                $consentimientoNumero = (string)$ultimoIdConsentimiento.$request['paci_identificacion'].$request['historias__paciente_id'];

                Consentimiento::create([
                    'numero' => $consentimientoNumero,
                    'historiaClinica_id' => $historiaClinica->id,
                    'paciente_id' => $request['historias__paciente_id'],
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
        $historia = HistoriaClinica::find($id);
        $formula = Formula::where('historiaClinica_id', $historia->id)->first();
        $formulaTratamiento = FormulaTratamiento::where('historiaClinica_id', $historia->id)->first();
        $incapacidadMedica = IncapacidadMedica::where('historiaClinica_id', $historia->id)->first();
        $certificadoMedico = CertificadoMedico::where('historiaClinica_id', $historia->id)->first();
        $consentimientoInformado = Consentimiento::where('historiaClinica_id', $historia->id)->first();

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $historia);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $historia);
        }

        return view('panel.historia.detallar', compact('historia', 'formula', 'formulaTratamiento', 'incapacidadMedica', 'certificadoMedico', 'consentimientoInformado'));
    }

    public function ver($id)
    {
        //envio de datos a la vista
        $historia = HistoriaClinica::find($id);
        $paciente = $this->pacientes->findPacienteById($historia->paciente->id);//no uso el paciente desde historia, ya que usando este metodo, me trae datos especiales como edad
        if($historia->acompanante != null){//traigo el parentesco del acompanante del paciente que se encuentra en la tabla pivot
            $parentescoAcompanante = $this->acompanantes->findParentescoAcompanante($historia->paciente->id, $historia->acompanante->id);
        }else{
            $parentescoAcompanante = null;
        }
        $informacion = InfoCentro::find(1);
        $formula = Formula::where('historiaClinica_id', $historia->id)->first();
        $formulaTratamiento = FormulaTratamiento::where('historiaClinica_id', $historia->id)->first();
        $incapacidadMedica = IncapacidadMedica::where('historiaClinica_id', $historia->id)->first();
        $certificadoMedico = CertificadoMedico::where('historiaClinica_id', $historia->id)->first();
        $consentimientoInformado = Consentimiento::where('historiaClinica_id', $historia->id)->first();

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $historia);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $historia);
        }

        $pdf = PDF::loadView('panel.historia.ver', ['historia' => $historia, 'paciente' => $paciente, 'parentescoAcompanante' => $parentescoAcompanante, 'informacion' => $informacion, 'formula' => $formula, 'formulaTratamiento' => $formulaTratamiento, 'incapacidadMedica' => $incapacidadMedica, 'certificadoMedico' => $certificadoMedico, 'consentimientoInformado' => $consentimientoInformado]);
        return $pdf->stream();
    }

    public function versimple($id)
    {
        //envio de datos a la vista
        $historia = HistoriaClinica::find($id);
        $paciente = $this->pacientes->findPacienteById($historia->paciente->id);//no uso el paciente desde historia, ya que usando este metodo, me trae datos especiales como edad
        if($historia->acompanante != null){//traigo el parentesco del acompanante del paciente que se encuentra en la tabla pivot
            $parentescoAcompanante = $this->acompanantes->findParentescoAcompanante($historia->paciente->id, $historia->acompanante->id);
        }else{
            $parentescoAcompanante = null;
        }
        $informacion = InfoCentro::find(1);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $historia);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $historia);
        }

        $pdf = PDF::loadView('panel.historia.versimple', ['historia' => $historia, 'paciente' => $paciente, 'parentescoAcompanante' => $parentescoAcompanante, 'informacion' => $informacion]);
        return $pdf->stream();
    }

    //para verificar la existencia de una historia clinica al momento de querer registrarla
    public function existencia($pacienteId)
    {
        //necesitamos buscar solo en las historias que pertenecen a cada medico, nunca todos.
        $historia = HistoriaClinica::where('paciente_id', $pacienteId)->where('user_id', Auth::user()->id)->first();

        return response()->json($historia);
    }

    //para traer los datos del paciente a la historia clinica a partir del autocomplete
    public function pacienteObtener($pacienteId)
    {
        $paciente = $this->pacientes->findPacienteById($pacienteId);

        return response()->json($paciente);
    }

    //para traer los datos del acompanante a la historia clinica a partir del autocomplete
    public function acompananteObtener($acompananteId)
    {
        $acompanante = Acompanante::find($acompananteId);

        return response()->json($acompanante);
    }
}
