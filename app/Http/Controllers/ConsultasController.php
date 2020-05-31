<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Ace\Formato;
use Ace\InfoCentro;
use Ace\Repositories\PacientesRepository;
use Auth;
use Session;
use Mail;
use Carbon\Carbon;
use Validator;

class ConsultasController extends Controller
{
    private $pacientes;

    public function __construct(PacientesRepository $pacientes)
    {
        $this->pacientes = $pacientes;
    }

    public function consultas()
    {
        return view('panel.reporte.consultar');
    }

    public function consulta1($genero, $min, $max)
    {
        $pacientes = null;

        if($genero == 1){//si es por hombres
        	$genero = 'Masculino';
        }else{
        	if($genero == 2){//si es por mujeres
        		$genero = 'Femenino';
        	}
        }

        $min = Carbon::now()->subYears($min)->format('Y-m-d');
        $max = Carbon::now()->subYears($max)->format('Y-m-d');

        if($genero == 3){//no importa el genero, quiero todos
        	//solo puedo buscar entre los pacientes que me corresponden
        	if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
	            $pacientes = $this->pacientes->findConsulta1SinGenero($min, $max, Auth::user()->id);   
	        }

	        if(Auth::user()->perfil_id == 3){//si es asistente
	            $pacientes = $this->pacientes->findConsulta1SinGenero($min, $max, Session::get('medicoActual')->user->id);
	        }
        }else{//segun el genero escogido
        	if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
	            $pacientes = $this->pacientes->findConsulta1ConGenero($genero, $min, $max, Auth::user()->id);   
	        }

	        if(Auth::user()->perfil_id == 3){
	            $pacientes = $this->pacientes->findConsulta1ConGenero($genero, $min, $max, Session::get('medicoActual')->user->id);
	        }
        }

        return response()->json($pacientes->toArray());
    }

    public function consulta2($ciudad)
    {
        $pacientes = null;

        //solo puedo buscar entre los pacientes que me corresponden
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
            $pacientes = $this->pacientes->findConsulta2($ciudad, Auth::user()->id);   
        }

        if(Auth::user()->perfil_id == 3){//si es asistente
            $pacientes = $this->pacientes->findConsulta2($ciudad, Session::get('medicoActual')->user->id);
        }

        return response()->json($pacientes->toArray());
    }

    public function consulta3($min, $max)
    {
        $pacientes = null;

        $min = Carbon::now()->subYears($min)->format('Y-m-d');
        $max = Carbon::now()->subYears($max)->format('Y-m-d');

        //solo puedo buscar entre los pacientes que me corresponden
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
            $pacientes = $this->pacientes->findConsulta3($min, $max, Auth::user()->id);   
        }

        if(Auth::user()->perfil_id == 3){//si es asistente
            $pacientes = $this->pacientes->findConsulta3($min, $max, Session::get('medicoActual')->user->id);
        }

        return response()->json($pacientes->toArray());
    }

    public function consulta4($eleccion)
    {
        $pacientes = null;

        //solo puedo buscar entre los pacientes que me corresponden
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
            if($eleccion == 1){//si es por semana
                $pacientes = $this->pacientes->findConsulta4Semana(Auth::user()->id);
                //por la forma en que se hizo la consulta en el repositorio, no es necesario pasar el resultado a array como en los otros casos
                return response()->json($pacientes);
            }else{//si es solo por el dia
                $pacientes = $this->pacientes->findConsulta4Dia(Auth::user()->id);
                return response()->json($pacientes->toArray());
            }  
        }

        if(Auth::user()->perfil_id == 3){//si es asistente
            if($eleccion == 1){
                $pacientes = $this->pacientes->findConsulta4Semana(Session::get('medicoActual')->user->id);
                return response()->json($pacientes);
            }else{
                $pacientes = $this->pacientes->findConsulta4Dia(Session::get('medicoActual')->user->id);
                return response()->json($pacientes->toArray());
            }
        }
    }

    public function consulta5($cie10)
    {
        $pacientes = null;

        //solo puedo buscar entre los pacientes que me corresponden
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
            $pacientes = $this->pacientes->findConsulta5($cie10, Auth::user()->id);   
        }

        if(Auth::user()->perfil_id == 3){//si es asistente
            $pacientes = $this->pacientes->findConsulta5($cie10, Session::get('medicoActual')->user->id);
        }

        return response()->json($pacientes->toArray());
    }

    public function consulta6($tratamiento, $eleccion)
    {
        $pacientes = null;

        //solo puedo buscar entre los pacientes que me corresponden
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
            if($eleccion == 1){
                $pacientes = $this->pacientes->findConsulta6Recibido($tratamiento, Auth::user()->id);
            }
            if($eleccion == 2){
                $pacientes = $this->pacientes->findConsulta6NoRecibido($tratamiento, Auth::user()->id);
            }   
        }

        if(Auth::user()->perfil_id == 3){//si es asistente
            if($eleccion == 1){
                $pacientes = $this->pacientes->findConsulta6Recibido($tratamiento, Session::get('medicoActual')->user->id);
            }
            if($eleccion == 2){
                $pacientes = $this->pacientes->findConsulta6NoRecibido($tratamiento, Session::get('medicoActual')->user->id);
            }
        }

        return response()->json($pacientes->toArray());
    }

    public function consulta7($tratamiento)
    {
        $pacientes = null;

        //solo puedo buscar entre los pacientes que me corresponden
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si es medico
            $pacientes = $this->pacientes->findConsulta7($tratamiento, Auth::user()->id);  
        }

        if(Auth::user()->perfil_id == 3){//si es asistente
            $pacientes = $this->pacientes->findConsulta7($tratamiento, Session::get('medicoActual')->user->id);
        }

        return response()->json($pacientes->toArray());
    }

    //funciones del envio del correo en las consultas
    public function sender($listadoEmails)
    {
        //si el usuario logueado es un super o un medico se deben listar solo sus formatos
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            $formatos = Formato::where('user_id', Auth::user()->id)->orderBy('id','DESC')->get();
        }

        //si el usuario logueado es un asistente se deben listar los formatos que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            $formatos = Formato::where('user_id', Session::get('medicoActual')->user->id)->orderBy('id','DESC')->get();
        }

        $formatos = $formatos->pluck('nombre','id');

        return view('panel.reporte.sender', compact('listadoEmails', 'formatos'));
    }

    public function formato($formato)
    {
        $formato = Formato::find($formato);

        return response()->json($formato->toArray());
    }

    public function send(Request $request)
    {
        //validamos los campos enviados
        $validator = Validator::make($request->all(), [
            'formatoId' => 'required',
            'contenido' => 'required',
            'asunto' => 'required|min:2|max:50',
        ], [], [
            'formatoId' => '"Formato"',
            'contenido' => '"Contenido"',
            'asunto' => '"Asunto"',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        //recopilamos la info necesaria
        $infoCentro = InfoCentro::find(1);

        $asunto = $request['asunto'];

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

        //guardamos en un array los correos y luego los recorremos en un for mandando el mail a cada paciente por aparte
        $cadenaEmails = substr ($request['listadoEmails'], 0, -1);
        $listadoEmails = explode(",", $cadenaEmails);

        for($i = 0; $i < count($listadoEmails); $i++){

            $correo = $listadoEmails[$i];

            Mail::send('mails.consulta', $requestFinal->all(), function($msj) use($asunto, $correo, $correoMedico){
                $msj->subject($asunto);
                $msj->to($correo);
                $msj->cc($correoMedico, $name = null);
            });
        }

        Flash::success('Correos enviados de manera exitosa.');
        return redirect()->route('panel.informe.consultas');
    }

}
