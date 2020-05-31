<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Agenda;
use Ace\Repositories\AgendasRepository;
use Ace\CitaTipo;
use Ace\HistoriaClinica;
use Ace\InfoCentro;
use Ace\Repositories\ItemformulatratamientosRepository;
use Ace\Tratamiento;
use Auth;
use Session;
use Mail;
use Jenssegers\Date\Date;//para poder usar Carbon en espanol, es una extension de Carbon
use Carbon\Carbon;
use Validator;

class AgendasController extends Controller
{
    private $agendas;
    private $itemformulatratamientos;

    public function __construct(AgendasRepository $agendas, ItemformulatratamientosRepository $itemformulatratamientos)
    {
        $this->agendas = $agendas;
        $this->itemformulatratamientos = $itemformulatratamientos;
    }

    public function cargar()
    {
        $agendas = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus formatos
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
        	$agendas = $this->agendas->findMisAgendas(Auth::user()->id);
        }

        //si el usuario logueado es un asistente se deben listar los formatos que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            $agendas = $this->agendas->findMisAgendas(Session::get('medicoActual')->user->id);
        }

        return Response()->json($agendas);
    }

    public function mostrar()
    {
        $citaTipos = null;
        $tratamientos = null;

        //ya que cada medico tiene sus propios tipos de citas...
        //si el usuario logueado es un super o un medico
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
        	$citaTipos = CitaTipo::where('user_id', Auth::user()->id)->pluck('nombre','id');
            $tratamientos = Tratamiento::where('user_id', Auth::user()->id)->pluck('nombre','id');
        }

        //si el usuario logueado es un auxiliar
        if(Auth::user()->perfil_id == 3){
            $citaTipos = CitaTipo::where('user_id', Session::get('medicoActual')->user->id)->pluck('nombre','id');
            $tratamientos = Tratamiento::where('user_id', Session::get('medicoActual')->user->id)->pluck('nombre','id');
        }

        return view('panel.agenda.mostrar', compact('citaTipos', 'tratamientos'));
    }

    public function almacenar(Request $request)
    {
        if($request->ajax()){

            //validamos los campos enviados
            $validator = Validator::make($request->all(), [
                'paciente_id' => 'required',
                'citaTipo_id' => 'required',
                'fechaHoraInicio' => 'date_format:Y-m-d H:i|before:fechaHoraFin|after:'. Carbon::now(),
                'fechaHoraFin' => 'date_format:Y-m-d H:i|after:fechaHoraInicio',
                'observacion' => 'nullable|min:2|max:200',
            ], [], [
                'paciente_id' => '"Paciente"',
                'citaTipo_id' => '"Tipo de Cita"',
                'fechaHoraInicio' => '"Fecha y Hora Inicio"',
                'fechaHoraFin' => '"Fecha y Hora Fin"',
                'observacion' => '"Observación"',
            ]);

            if ($validator->fails()){
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

        	$agendasRequest = $request;

        	if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
	            $agendasRequest['user_id'] = Auth::user()->id;
	        }

	        if(Auth::user()->perfil_id == 3){//si es asistente
	            $agendasRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
	        }

	        //validamos que la fecha inicio y fin, sean para el mismo dia
			$fechaInicio = substr($agendasRequest['fechaHoraInicio'], 0, 10);
			$fechaFin = substr($agendasRequest['fechaHoraFin'], 0, 10);

			if($fechaInicio == $fechaFin){

				//validamos que las fechas no se solapen con las ya existentes
		        $fechaHoraInicio = "'".$agendasRequest['fechaHoraInicio']."'";
		        $fechaHoraFin = "'".$agendasRequest['fechaHoraFin']."'";

		    	$resultadoSolape = $this->agendas->validateSolape($fechaHoraInicio, $fechaHoraFin, $agendasRequest['user_id']);

		    	if($resultadoSolape == null){//si no se solapan

                    //validamos los tipos de citas
                    $citaTipo = CitaTipo::find($agendasRequest['citaTipo_id']);
                    $historiasExistentes = HistoriaClinica::where('paciente_id', $agendasRequest['paciente_id'])->count();

                    if($citaTipo->nombre == 'Primera Vez'){//si es primera vez, no debe existir una historia medica para el paciente
                        
                        if($historiasExistentes != 0){
                            return response()->json([
                                "mensaje" => "Tipo Cita 1 Error"
                            ]);
                        }else{
                            $cita = Agenda::create($agendasRequest->all());

                            //enviamos un correo al paciente, notificandole sobre su cita y enviandole la informacion
                            ///////////////////////////////////////////////////////////////////////////////////////////////
                            //recopilamos la info necesaria
                            $nombrePaciente = $cita->paciente->nombres;
                            $fechaHoraCita = $cita->fechaHoraInicio;
                            $tipoCita = $cita->citaTipo->nombre;

                            $infoCentro = InfoCentro::find(1);

                            $nombreMedico = '';
                            $correoMedico = '';
                            $especialidadMedico = '';

                            //si el usuario logueado es un super o un medico se deben listar solo sus formatos
                            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
                                $nombreMedico = Auth::user()->nombres.' '.Auth::user()->apellidos;
                                $correoMedico = Auth::user()->medico->email;
                                $especialidadMedico = Auth::user()->medico->especialidad;
                            }

                            //si el usuario logueado es un asistente se deben listar los formatos que le pertenecen al medico con el que esta actualmente trabajando
                            if(Auth::user()->perfil_id == 3){
                                $nombreMedico = Session::get('medicoActual')->user->nombres.' '.Session::get('medicoActual')->user->apellidos;
                                $correoMedico = Session::get('medicoActual')->email;
                                $especialidadMedico = Session::get('medicoActual')->especialidad;
                            }

                            $requestFinal = $request;

                            $requestFinal['nombrePaciente'] = $nombrePaciente;
                            //transformamos el formato de la fecha a uno mas amigable para mostrar al usuario en el correo
                            Date::setLocale('es');
                            $timestamp = $fechaHoraCita;
                            $date = Date::createFromFormat('Y-m-d H:i', $timestamp);
                            $finalDate = $date->format('l j F Y H:i A');
                            $fechaCita = ucwords($finalDate);
                            $requestFinal['fechaHoraCita'] = $fechaCita;
                            //////////////////////////////////////////////////////////////////////////////////////////////
                            $requestFinal['tipoCita'] = $tipoCita;

                            $requestFinal['nombreMedico'] = $nombreMedico;
                            $requestFinal['correoMedico'] = $correoMedico;
                            $requestFinal['especialidadMedico'] = $especialidadMedico;

                            $requestFinal['razonSocial'] = $infoCentro->razonSocial;
                            $requestFinal['email'] = $infoCentro->email;
                            $requestFinal['direccion'] = $infoCentro->direccion;
                            $requestFinal['telefonos'] = $infoCentro->telefonos;
                            $requestFinal['linkWeb'] = $infoCentro->linkWeb;
                            $requestFinal['linkFacebook'] = $infoCentro->linkFacebook;
                            $requestFinal['linkTwitter'] = $infoCentro->linkTwitter;
                            $requestFinal['linkYoutube'] = $infoCentro->linkYoutube;
                            $requestFinal['linkInstagram'] = $infoCentro->linkInstagram;
                            $requestFinal['infoAdicional'] = $infoCentro->infoAdicional;
                            $requestFinal['logo'] = $infoCentro->path;

                            $correo = $cita->paciente->email;

                            Mail::send('mails.cita', $requestFinal->all(), function($msj) use($correo){
                                $msj->subject('Información sobre su nueva cita médica.');
                                $msj->to($correo);
                            });
                            /////////////////////////////////////////////////////////////////

                            return response()->json([
                                "mensaje" => "Ok"
                            ]);
                        }
                    }else{

                        if($citaTipo->nombre == 'Control/Consulta'){//si es control/consulta, ya debe existir una historia medica para el paciente

                            if($historiasExistentes != 0){
                                $cita = Agenda::create($agendasRequest->all());

                                //enviamos un correo al paciente, notificandole sobre su cita y enviandole la informacion
                                ///////////////////////////////////////////////////////////////////////////////////////////////
                                //recopilamos la info necesaria
                                $nombrePaciente = $cita->paciente->nombres;
                                $fechaHoraCita = $cita->fechaHoraInicio;
                                $tipoCita = $cita->citaTipo->nombre;

                                $infoCentro = InfoCentro::find(1);

                                $nombreMedico = '';
                                $correoMedico = '';
                                $especialidadMedico = '';

                                //si el usuario logueado es un super o un medico se deben listar solo sus formatos
                                if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
                                    $nombreMedico = Auth::user()->nombres.' '.Auth::user()->apellidos;
                                    $correoMedico = Auth::user()->medico->email;
                                    $especialidadMedico = Auth::user()->medico->especialidad;
                                }

                                //si el usuario logueado es un asistente se deben listar los formatos que le pertenecen al medico con el que esta actualmente trabajando
                                if(Auth::user()->perfil_id == 3){
                                    $nombreMedico = Session::get('medicoActual')->user->nombres.' '.Session::get('medicoActual')->user->apellidos;
                                    $correoMedico = Session::get('medicoActual')->email;
                                    $especialidadMedico = Session::get('medicoActual')->especialidad;
                                }

                                $requestFinal = $request;

                                $requestFinal['nombrePaciente'] = $nombrePaciente;
                                //transformamos el formato de la fecha a uno mas amigable para mostrar al usuario en el correo
                                Date::setLocale('es');
                                $timestamp = $fechaHoraCita;
                                $date = Date::createFromFormat('Y-m-d H:i', $timestamp);
                                $finalDate = $date->format('l j F Y H:i A');
                                $fechaCita = ucwords($finalDate);
                                $requestFinal['fechaHoraCita'] = $fechaCita;
                                //////////////////////////////////////////////////////////////////////////////////////////////
                                $requestFinal['tipoCita'] = $tipoCita;

                                $requestFinal['nombreMedico'] = $nombreMedico;
                                $requestFinal['correoMedico'] = $correoMedico;
                                $requestFinal['especialidadMedico'] = $especialidadMedico;

                                $requestFinal['razonSocial'] = $infoCentro->razonSocial;
                                $requestFinal['email'] = $infoCentro->email;
                                $requestFinal['direccion'] = $infoCentro->direccion;
                                $requestFinal['telefonos'] = $infoCentro->telefonos;
                                $requestFinal['linkWeb'] = $infoCentro->linkWeb;
                                $requestFinal['linkFacebook'] = $infoCentro->linkFacebook;
                                $requestFinal['linkTwitter'] = $infoCentro->linkTwitter;
                                $requestFinal['linkYoutube'] = $infoCentro->linkYoutube;
                                $requestFinal['linkInstagram'] = $infoCentro->linkInstagram;
                                $requestFinal['infoAdicional'] = $infoCentro->infoAdicional;
                                $requestFinal['logo'] = $infoCentro->path;

                                $correo = $cita->paciente->email;

                                Mail::send('mails.cita', $requestFinal->all(), function($msj) use($correo){
                                    $msj->subject('Información sobre su nueva cita médica.');
                                    $msj->to($correo);
                                });
                                /////////////////////////////////////////////////////////////////

                                return response()->json([
                                    "mensaje" => "Ok"
                                ]);
                            }else{
                                return response()->json([
                                    "mensaje" => "Tipo Cita 2 Error"
                                ]);
                            }
                        }else{

                            if($citaTipo->nombre == 'Sesión'){//si es sesion, debe existir un item de formula tratamiento que coincida con el tratamiento y con el paciente, y que ademas este activa
                                $existencia = $this->itemformulatratamientos->existenciaFormulacionTratamiento($agendasRequest['paciente_id'], $agendasRequest['tratamiento_id']);

                                if($existencia != 0){
                                    $cita = Agenda::create($agendasRequest->all());

                                    //enviamos un correo al paciente, notificandole sobre su cita y enviandole la informacion
                                    ///////////////////////////////////////////////////////////////////////////////////////////////
                                    //recopilamos la info necesaria
                                    $nombrePaciente = $cita->paciente->nombres;
                                    $fechaHoraCita = $cita->fechaHoraInicio;
                                    $tipoCita = $cita->citaTipo->nombre;
                                    $tratamiento = $cita->tratamiento->nombre;//le mandamos tambien el nombre del tratamiento por el que es la sesion, en el correo

                                    $infoCentro = InfoCentro::find(1);

                                    $nombreMedico = '';
                                    $correoMedico = '';
                                    $especialidadMedico = '';

                                    //si el usuario logueado es un super o un medico se deben listar solo sus formatos
                                    if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
                                        $nombreMedico = Auth::user()->nombres.' '.Auth::user()->apellidos;
                                        $correoMedico = Auth::user()->medico->email;
                                        $especialidadMedico = Auth::user()->medico->especialidad;
                                    }

                                    //si el usuario logueado es un asistente se deben listar los formatos que le pertenecen al medico con el que estan actualmente trabajando
                                    if(Auth::user()->perfil_id == 3){
                                        $nombreMedico = Session::get('medicoActual')->user->nombres.' '.Session::get('medicoActual')->user->apellidos;
                                        $correoMedico = Session::get('medicoActual')->email;
                                        $especialidadMedico = Session::get('medicoActual')->especialidad;
                                    }

                                    $requestFinal = $request;

                                    $requestFinal['nombrePaciente'] = $nombrePaciente;
                                    //transformamos el formato de la fecha a uno mas amigable para mostrar al usuario en el correo
                                    Date::setLocale('es');
                                    $timestamp = $fechaHoraCita;
                                    $date = Date::createFromFormat('Y-m-d H:i', $timestamp);
                                    $finalDate = $date->format('l j F Y H:i A');
                                    $fechaCita = ucwords($finalDate);
                                    $requestFinal['fechaHoraCita'] = $fechaCita;
                                    //////////////////////////////////////////////////////////////////////////////////////////////
                                    $requestFinal['tipoCita'] = $tipoCita.'('.$tratamiento.')';

                                    $requestFinal['nombreMedico'] = $nombreMedico;
                                    $requestFinal['correoMedico'] = $correoMedico;
                                    $requestFinal['especialidadMedico'] = $especialidadMedico;

                                    $requestFinal['razonSocial'] = $infoCentro->razonSocial;
                                    $requestFinal['email'] = $infoCentro->email;
                                    $requestFinal['direccion'] = $infoCentro->direccion;
                                    $requestFinal['telefonos'] = $infoCentro->telefonos;
                                    $requestFinal['linkWeb'] = $infoCentro->linkWeb;
                                    $requestFinal['linkFacebook'] = $infoCentro->linkFacebook;
                                    $requestFinal['linkTwitter'] = $infoCentro->linkTwitter;
                                    $requestFinal['linkYoutube'] = $infoCentro->linkYoutube;
                                    $requestFinal['linkInstagram'] = $infoCentro->linkInstagram;
                                    $requestFinal['infoAdicional'] = $infoCentro->infoAdicional;
                                    $requestFinal['logo'] = $infoCentro->path;

                                    $correo = $cita->paciente->email;

                                    Mail::send('mails.cita', $requestFinal->all(), function($msj) use($correo){
                                        $msj->subject('Información sobre su nueva cita médica.');
                                        $msj->to($correo);
                                    });
                                    /////////////////////////////////////////////////////////////////

                                    return response()->json([
                                        "mensaje" => "Ok"
                                    ]);
                                }else{
                                    return response()->json([
                                        "mensaje" => "Tipo Cita 3 Error"
                                    ]);
                                }

                            }else{//si ya es algun otro tipo de cita creado por el usuario
                                $cita = Agenda::create($agendasRequest->all());

                                //enviamos un correo al paciente, notificandole sobre su cita y enviandole la informacion
                                ///////////////////////////////////////////////////////////////////////////////////////////////
                                //recopilamos la info necesaria
                                $nombrePaciente = $cita->paciente->nombres;
                                $fechaHoraCita = $cita->fechaHoraInicio;
                                $tipoCita = $cita->citaTipo->nombre;

                                $infoCentro = InfoCentro::find(1);

                                $nombreMedico = '';
                                $correoMedico = '';
                                $especialidadMedico = '';

                                //si el usuario logueado es un super o un medico se deben listar solo sus formatos
                                if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
                                    $nombreMedico = Auth::user()->nombres.' '.Auth::user()->apellidos;
                                    $correoMedico = Auth::user()->medico->email;
                                    $especialidadMedico = Auth::user()->medico->especialidad;
                                }

                                //si el usuario logueado es un asistente se deben listar los formatos que le pertenecen al medico con el que esta actualmente trabajando
                                if(Auth::user()->perfil_id == 3){
                                    $nombreMedico = Session::get('medicoActual')->user->nombres.' '.Session::get('medicoActual')->user->apellidos;
                                    $correoMedico = Session::get('medicoActual')->email;
                                    $especialidadMedico = Session::get('medicoActual')->especialidad;
                                }

                                $requestFinal = $request;

                                $requestFinal['nombrePaciente'] = $nombrePaciente;
                                //transformamos el formato de la fecha a uno mas amigable para mostrar al usuario en el correo
                                Date::setLocale('es');
                                $timestamp = $fechaHoraCita;
                                $date = Date::createFromFormat('Y-m-d H:i', $timestamp);
                                $finalDate = $date->format('l j F Y H:i A');
                                $fechaCita = ucwords($finalDate);
                                $requestFinal['fechaHoraCita'] = $fechaCita;
                                //////////////////////////////////////////////////////////////////////////////////////////////
                                $requestFinal['tipoCita'] = $tipoCita;

                                $requestFinal['nombreMedico'] = $nombreMedico;
                                $requestFinal['correoMedico'] = $correoMedico;
                                $requestFinal['especialidadMedico'] = $especialidadMedico;

                                $requestFinal['razonSocial'] = $infoCentro->razonSocial;
                                $requestFinal['email'] = $infoCentro->email;
                                $requestFinal['direccion'] = $infoCentro->direccion;
                                $requestFinal['telefonos'] = $infoCentro->telefonos;
                                $requestFinal['linkWeb'] = $infoCentro->linkWeb;
                                $requestFinal['linkFacebook'] = $infoCentro->linkFacebook;
                                $requestFinal['linkTwitter'] = $infoCentro->linkTwitter;
                                $requestFinal['linkYoutube'] = $infoCentro->linkYoutube;
                                $requestFinal['linkInstagram'] = $infoCentro->linkInstagram;
                                $requestFinal['infoAdicional'] = $infoCentro->infoAdicional;
                                $requestFinal['logo'] = $infoCentro->path;

                                $correo = $cita->paciente->email;

                                Mail::send('mails.cita', $requestFinal->all(), function($msj) use($correo){
                                    $msj->subject('Información sobre su nueva cita médica.');
                                    $msj->to($correo);
                                });
                                /////////////////////////////////////////////////////////////////

                                return response()->json([
                                    "mensaje" => "Ok"
                                ]);
                            }
                        }
                    }
		    	}else{
		    		return response()->json([
		        		"mensaje" => "Solape"
		        	]);
		    	}
			}else{
				return response()->json([
	        		"mensaje" => "Misma Fecha"
	        	]);
			}
        }
    }

    public function eliminar($id)
    {
        $agenda = Agenda::find($id);
        $agenda->delete();
        
        return response()->json([
    		"mensaje" => "Ok"
    	]);
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){
            //validamos los campos enviados
            $validator = Validator::make($request->all(), [
                'paciente_id' => 'required',
                'citaTipo_id' => 'required',
                'fechaHoraInicio' => 'date_format:Y-m-d H:i|before:fechaHoraFin',
                'fechaHoraFin' => 'date_format:Y-m-d H:i|after:fechaHoraInicio',
                'observacion' => 'nullable|min:2|max:200',
                'estado' => 'required',
            ], [], [
                'paciente_id' => '"Paciente"',
                'citaTipo_id' => '"Tipo de Cita"',
                'fechaHoraInicio' => '"Fecha y Hora Inicio"',
                'fechaHoraFin' => '"Fecha y Hora Fin"',
                'observacion' => '"Observación"',
                'estado' => '"Estado"',
            ]);

            if ($validator->fails()){
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

            //validamos que la fecha inicio y fin, sean para el mismo dia
    		$fechaInicio = substr($request['fechaHoraInicio'], 0, 10);
    		$fechaFin = substr($request['fechaHoraFin'], 0, 10);

    		if($fechaInicio == $fechaFin){

    			//validamos que las fechas no se solapen con las ya existentes
    	        $fechaHoraInicio = "'".$request['fechaHoraInicio']."'";
    	        $fechaHoraFin = "'".$request['fechaHoraFin']."'";
                $usuarioId = null;

                if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                    $usuarioId = Auth::user()->id;
                }

                if(Auth::user()->perfil_id == 3){//si es asistente
                    $usuarioId = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
                }

    	        $resultadoSolape = $this->agendas->validateSolapeEdit($fechaHoraInicio, $fechaHoraFin, $id, $usuarioId);

    	    	if($resultadoSolape == null){//si no se solapan
    	    		
                    //validamos los tipos de citas
                    $citaTipo = CitaTipo::find($request['citaTipo_id']);
                    $historiasExistentes = HistoriaClinica::where('paciente_id', $request['paciente_id'])->count();

    	        	if($citaTipo->nombre == 'Primera Vez'){//si es primera vez, no debe existir una historia medica para el paciente
                            
                        if($historiasExistentes != 0){
                            return response()->json([
                                "mensaje" => "Tipo Cita 1 Error"
                            ]);
                        }else{
                            $agenda = Agenda::find($id);
                            $agenda->fill($request->all());
                            $agenda->save();

                            return response()->json([
                                "mensaje" => "Ok"
                            ]);
                        }
                    }else{

                        if($citaTipo->nombre == 'Control/Consulta'){//si es control/consulta, ya debe existir una historia medica para el paciente

                            if($historiasExistentes != 0){
                                $agenda = Agenda::find($id);
                                $agenda->fill($request->all());
                                $agenda->save();

                                return response()->json([
                                    "mensaje" => "Ok"
                                ]);
                            }else{
                                return response()->json([
                                    "mensaje" => "Tipo Cita 2 Error"
                                ]);
                            }
                        }else{

                            if($citaTipo->nombre == 'Sesión'){//si es sesion, debe existir una formula-tratamiento que coincida con el tratamiento y con el paciente, y que ademas este activa
                                $existencia = $this->itemformulatratamientos->existenciaFormulacionTratamiento($request['paciente_id'], $request['tratamiento_id']);

                                if($existencia != 0){
                                    $agenda = Agenda::find($id);
                                    $agenda->fill($request->all());
                                    $agenda->save();

                                    return response()->json([
                                        "mensaje" => "Ok"
                                    ]);
                                }else{
                                    return response()->json([
                                        "mensaje" => "Tipo Cita 3 Error"
                                    ]);
                                }

                            }else{//si ya es algun otro tipo de cita creado por el usuario
                                $agenda = Agenda::find($id);
                                $agenda->fill($request->all());
                                $agenda->save();

                                return response()->json([
                                    "mensaje" => "Ok"
                                ]);
                            }
                        }
                    }
    	    	}else{
    	    		return response()->json([
    	        		"mensaje" => "Solape"
    	        	]);
    	    	}
    		}else{
    			return response()->json([
            		"mensaje" => "Misma Fecha"
            	]);
    		}
        }
    }
    
}
