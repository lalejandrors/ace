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
use Ace\IncapacidadMedica;
use Ace\InfoCentro;
use Ace\ItemFormula;
use Ace\ItemFormulaTratamiento;
use Ace\Repositories\ItemformulatratamientosRepository;
use Ace\Paciente;
use Ace\Repositories\PacientesRepository;
use Ace\Sesion;
use Ace\Repositories\SesionesRepository;
use Ace\ViaMedicamento;
use Auth;
use Session;
use Validator;
use PDF;
use Jenssegers\Date\Date;//para poder usar Carbon en espanol, es una extension de Carbon
use Carbon\Carbon;

class SesionesController extends Controller
{
    private $pacientes;
    private $sesiones;
    private $itemformulatratamientos;
    private $acompanantes;

    public function __construct(PacientesRepository $pacientes, SesionesRepository $sesiones, ItemformulatratamientosRepository $itemformulatratamientos, AcompanantesRepository $acompanantes)
    {
        $this->pacientes = $pacientes;
        $this->sesiones = $sesiones;
        $this->itemformulatratamientos = $itemformulatratamientos;
        $this->acompanantes = $acompanantes;
    }

    public function listar(Request $request)
    {
        return view('panel.sesion.listar');
    }

    public function datatable(Request $request)
    {
        $sesionesRequest = $request->all();
        //variables traidas por post para server side
        $start = $sesionesRequest['start'];
        $length = $sesionesRequest['length'];
        $search = $sesionesRequest['search']['value'];
        $draw = $sesionesRequest['draw'];
        $sesiones = null;
        $sesionesNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $sesiones = $this->sesiones->findSesionesDatatableSearch($start, $length, $search, Auth::user()->id);
                $sesionesNumero = $this->sesiones->findSesionesDatatableSearchNum($search, Auth::user()->id);
            }else{
                $sesiones = $this->sesiones->findSesionesDatatable($start, $length, Auth::user()->id);
                $sesionesNumero = $this->sesiones->findSesionesDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $sesiones = $this->sesiones->findSesionesDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $sesionesNumero = $this->sesiones->findSesionesDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $sesiones = $this->sesiones->findSesionesDatatable($start, $length, Session::get('medicoActual')->user->id);
                $sesionesNumero = $this->sesiones->findSesionesDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($sesiones->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($sesionesNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($sesiones as $sesion) {
            $array = array();
            $array['id'] = $sesion->id;
            $array['numero'] = $sesion->numero;
            $array['tratamiento'] = $sesion->tratamiento;
            $array['numsesion'] = "Sesión #".$sesion->numeroVez." de ".$sesion->numeroSesiones." en total.";
            $array['paciente'] = $sesion->nombres.' '.$sesion->apellidos.'<br>'.'('.$sesion->identificacion.')';
            $array['creado'] = $sesion->created_at;

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

        return view('panel.sesion.crear', compact('viaMedicamentos','formatos'));
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

            //luego validamos los campos enviados de sesion
            $validator = Validator::make($request->all(), [
                'sesiones__paciente_id' => 'required',
                'sesiones__acompanante_id' => 'nullable',
                'existente_parentesco' => 'required_with:sesiones__acompanante_id|max:20',
                'sesiones__observacion' => 'required|min:2',
            ], [], [
                'sesiones__paciente_id' => '"Paciente"',
                'sesiones__acompanante_id' => '"Acompañante"',
                'existente_parentesco' => '"Parentesco para Acompañante Existente"',
                'sesiones__observacion' => '"Observación"',
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
                    $existencia = $this->itemformulatratamientos->existenciaFormulacionTratamiento($request['sesiones__paciente_id'], $itemsTratamiento[$j]);

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
            $paciente = Paciente::find($request['sesiones__paciente_id']);
            $acompananteId = null;

            if($request['sesiones__acompanante_id'] != ''){//si es un acompanante existente, solo asignarlo al paciente
                $paciente->acompanantes()->attach($request['sesiones__acompanante_id'], ['parentesco' => $request['existente_parentesco']]);
                $acompananteId = $request['sesiones__acompanante_id'];
            }

            if($request['acompanantes__identificacion'] != '' || $request['acompanantes__tipoId'] != '' || $request['acompanantes__nombres'] != '' || $request['acompanantes__apellidos'] != '' || $request['nuevo_parentesco'] != '' || $request['acompanantes__telefonoFijo'] != '' || $request['acompanantes__telefonoCelular'] != ''){//o si es uno nuevo, crearlo y asignarlo al paciente, ademas de asignarselo a la sesion
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

            //CREAMOS LA SESION
            $ultimoIdSesion = Sesion::orderBy('id','DESC')->first();

            if($ultimoIdSesion == null){//si es la primera sesion en crear
                $ultimoIdSesion = 1;
            }else{
                $ultimoIdSesion = (int)($ultimoIdSesion->id) + 1;//esto es para construir el numero
            }

            $sesionNumero = (string)$ultimoIdSesion.$request['paci_identificacion'].$request['sesiones__paciente_id'];

            $sesion = Sesion::create([
                'numero' => $sesionNumero,
                'paciente_id' => $request['sesiones__paciente_id'],
                'acompanante_id' => $acompananteId,
                'itemFormulaTratamiento_id' => $request['itemFormulaTratamientoId'],
                'numeroVez' => $request['numeroVez'],
                'observacion' => $request['sesiones__observacion'],
                'user_id' => Auth::user()->id,
            ]);

            //editamos el campo de sesiones realizadas
            $itemFormulaTratamiento = ItemFormulaTratamiento::find($request['itemFormulaTratamientoId']);
            $itemFormulaTratamiento->update(['sesionesRealizadas' => $request['numeroVez']]);

            //ahora si el numero de sesiones realizadas ya cumplen lo formulado, ponemos en activo 0 a esa asignacion de tratamiento del paciente
            if($request['numeroVez'] == $request['numeroSesiones']){
                $itemFormulaTratamiento->update(['activo' => 0]);
            }

            //REGISTRAMOS LOS DIAGNOSTICOS
            if($request['diagnosticos'] != null){//ya que en las sesiones, los diagnosticos no son obligatorios, primero preguntamos si llegan
                $diagnosticos = $request['diagnosticos'];
                //primero en la relacion de pacientes y diagnosticos
                for($i = 0; $i < count($diagnosticos); $i++){
                    $paciente->cie10s()->attach($diagnosticos[$i]);
                }
                //ahora en la relacion de la sesion y los diagnosticos
                $sesion->cie10s()->sync($diagnosticos);
            }

            //GESTION DE LA FORMULA CLINICA
            if($request['formulaMedicaHidden'] == '1'){//si se desplego el form para crear una formula medica
                //antes de insertar los medicamentos (items), hacemos el registro de la entidad formula medica
                $ultimoIdFormulaMedica = Formula::orderBy('id','DESC')->first();

                if($ultimoIdFormulaMedica == null){//si es la primera formula medica en crear
                    $ultimoIdFormulaMedica = 1;
                }else{
                    $ultimoIdFormulaMedica = (int)($ultimoIdFormulaMedica->id) + 1;//esto es para construir el numero
                }

                $formulaMedicaNumero = (string)$ultimoIdFormulaMedica.$request['paci_identificacion'].$request['sesiones__paciente_id'];

                $formulaMedica = Formula::create([
                    'numero' => $formulaMedicaNumero,
                    'sesion_id' => $sesion->id,
                    'paciente_id' => $request['sesiones__paciente_id'],
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

                $formulaTratamientoNumero = (string)$ultimoIdFormulaTratamiento.$request['paci_identificacion'].$request['sesiones__paciente_id'];

                $formulaTratamiento = FormulaTratamiento::create([
                    'numero' => $formulaTratamientoNumero,
                    'sesion_id' => $sesion->id,
                    'paciente_id' => $request['sesiones__paciente_id'],
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

                $incapacidadNumero = (string)$ultimoIdIncapacidad.$request['paci_identificacion'].$request['sesiones__paciente_id'];

                IncapacidadMedica::create([
                    'numero' => $incapacidadNumero,
                    'sesion_id' => $sesion->id,
                    'paciente_id' => $request['sesiones__paciente_id'],
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

                $certificadoNumero = (string)$ultimoIdCertificado.$request['paci_identificacion'].$request['sesiones__paciente_id'];

                CertificadoMedico::create([
                    'numero' => $certificadoNumero,
                    'sesion_id' => $sesion->id,
                    'paciente_id' => $request['sesiones__paciente_id'],
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

                $consentimientoNumero = (string)$ultimoIdConsentimiento.$request['paci_identificacion'].$request['sesiones__paciente_id'];

                Consentimiento::create([
                    'numero' => $consentimientoNumero,
                    'sesion_id' => $sesion->id,
                    'paciente_id' => $request['sesiones__paciente_id'],
                    'contenido' => $request['consentimientos__contenido'],
                    'observacion' => $request['consentimientos__observacion'],
                    'user_id' => Auth::user()->id,
                ]);
            }

            //si ya se cumplio el numero de sesiones del tratamiento, avisar al usuario que el tratamiento ya se termino
            if($request['numeroVez'] == $request['numeroSesiones']){
                return response()->json([
                    "mensaje" => "Tratamiento terminado"
                ]);
            }else{
                return response()->json([
                    "mensaje" => "Ok"
                ]);
            }

        }
    }

    public function detallar($id)
    {
        //envio de datos a la vista
        $sesion = Sesion::find($id);
        $formula = Formula::where('sesion_id', $sesion->id)->first();
        $formulaTratamiento = FormulaTratamiento::where('sesion_id', $sesion->id)->first();
        $incapacidadMedica = IncapacidadMedica::where('sesion_id', $sesion->id)->first();
        $certificadoMedico = CertificadoMedico::where('sesion_id', $sesion->id)->first();
        $consentimientoInformado = Consentimiento::where('sesion_id', $sesion->id)->first();

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $sesion);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $sesion);
        }

        return view('panel.sesion.detallar', compact('sesion', 'formula', 'formulaTratamiento', 'incapacidadMedica', 'certificadoMedico', 'consentimientoInformado'));
    }

    public function ver($id)
    {
        //envio de datos a la vista
        $sesion = Sesion::find($id);
        $paciente = $this->pacientes->findPacienteById($sesion->paciente->id);//no uso el paciente desde sesion, ya que usando este metodo, me trae datos especiales como edad
        if($sesion->acompanante != null){//traigo el parentesco del acompanante del paciente que se encuentra en la tabla pivot
            $parentescoAcompanante = $this->acompanantes->findParentescoAcompanante($sesion->paciente->id, $sesion->acompanante->id);
        }else{
            $parentescoAcompanante = null;
        }
        $informacion = InfoCentro::find(1);
        $formula = Formula::where('control_id', $sesion->id)->first();
        $formulaTratamiento = FormulaTratamiento::where('sesion_id', $sesion->id)->first();
        $incapacidadMedica = IncapacidadMedica::where('sesion_id', $sesion->id)->first();
        $certificadoMedico = CertificadoMedico::where('sesion_id', $sesion->id)->first();
        $consentimientoInformado = Consentimiento::where('sesion_id', $sesion->id)->first();

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $sesion);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $sesion);
        }

        $pdf = PDF::loadView('panel.sesion.ver', ['sesion' => $sesion, 'paciente' => $paciente, 'parentescoAcompanante' => $parentescoAcompanante, 'informacion' => $informacion, 'formula' => $formula, 'formulaTratamiento' => $formulaTratamiento, 'incapacidadMedica' => $incapacidadMedica, 'certificadoMedico' => $certificadoMedico, 'consentimientoInformado' => $consentimientoInformado]);
        return $pdf->stream();
    }

    public function versimple($id)
    {
        //envio de datos a la vista
        $sesion = Sesion::find($id);
        $paciente = $this->pacientes->findPacienteById($sesion->paciente->id);//no uso el paciente desde sesion, ya que usando este metodo, me trae datos especiales como edad
        if($sesion->acompanante != null){//traigo el parentesco del acompanante del paciente que se encuentra en la tabla pivot
            $parentescoAcompanante = $this->acompanantes->findParentescoAcompanante($sesion->paciente->id, $sesion->acompanante->id);
        }else{
            $parentescoAcompanante = null;
        }
        $informacion = InfoCentro::find(1);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $sesion);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $sesion);
        }

        $pdf = PDF::loadView('panel.sesion.versimple', ['sesion' => $sesion, 'paciente' => $paciente, 'parentescoAcompanante' => $parentescoAcompanante, 'informacion' => $informacion]);
        return $pdf->stream();
    }

    //para verificar la asignacion de un tratamiento a un paciente
    public function asignacion($pacienteId, $tratamientoId)
    {
        //necesitamos verificarlo, trayendo el numero de la sesion que seria la actual y el numero de sesiones totales para mostrar en pantalla
        $asignacion = $this->itemformulatratamientos->asignacionFormulacionTratamiento($pacienteId, $tratamientoId);

        return response()->json($asignacion);
    }
}
