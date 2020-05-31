<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Acompanante;
use Ace\Cie10;
use Ace\Repositories\CiudadesRepository;
use Ace\Eps;
use Ace\Laboratorio;
use Ace\Repositories\MedicamentosRepository;
use Ace\Paciente;
use Ace\Presentacion;
use Ace\Tratamiento;
use Auth;
use Session;
use DB;

class AutocompletesController extends Controller
{
    private $ciudades;
    private $medicamentos;

    public function __construct(CiudadesRepository $ciudades, MedicamentosRepository $medicamentos)
    {
        $this->ciudades = $ciudades;
        $this->medicamentos = $medicamentos;
    }

    public function presentacion()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $presentaciones = Presentacion::select('id', 'nombre as label')->where('nombre','like',"%$busqueda%")->orderBy('nombre','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label

        return response()->json($presentaciones->toArray());
    }

    public function laboratorio()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $laboratorios = null;//necesitamos siempre cargar solo los laboratorios que pertenecen a cada medico

        //si el usuario logueado es un super o un medico
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            $laboratorios = Laboratorio::select('id', 'nombre as label')->where('nombre','like',"%$busqueda%")->where('user_id', Auth::user()->id)->orderBy('nombre','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label
        }

        //si el usuario logueado es un asistente
        if(Auth::user()->perfil_id == 3){
            $laboratorios = Laboratorio::select('id', 'nombre as label')->where('nombre','like',"%$busqueda%")->where('user_id', Session::get('medicoActual')->user->id)->orderBy('nombre','ASC')->get();
        }

        return response()->json($laboratorios->toArray());
    }

    public function ciudad()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $ciudades = $this->ciudades->ciudadesAutocomplete($busqueda);

        return response()->json($ciudades->toArray());
    }

    public function cie10()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $cie10s = Cie10::select('id', DB::raw('CONCAT("(", codigo , ") ", descripcion) as label'))->where(DB::raw('CONCAT("(", codigo , ") ", descripcion)'),'like',"%$busqueda%")->orderBy('id','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label

        return response()->json($cie10s->toArray());
    }

    public function paciente()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $pacientes = null;//necesitamos siempre cargar solo los pacientes que pertenecen a cada medico

        //si el usuario logueado es un super o un medico
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            $pacientes = Paciente::select('id', DB::raw('CONCAT(nombres , " ", apellidos, " (", identificacion, ")") as label'))->where(DB::raw('CONCAT(nombres , " ", apellidos, " (", identificacion, ")")'),'like',"%$busqueda%")->where('user_id', Auth::user()->id)->orderBy('identificacion','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label
        }

        //si el usuario logueado es un asistente
        if(Auth::user()->perfil_id == 3){
            $pacientes = Paciente::select('id', DB::raw('CONCAT(nombres , " ", apellidos, " (", identificacion, ")") as label'))->where(DB::raw('CONCAT(nombres , " ", apellidos, " (", identificacion, ")")'),'like',"%$busqueda%")->where('user_id', Session::get('medicoActual')->user->id)->orderBy('identificacion','ASC')->get();
        }

        return response()->json($pacientes->toArray());
    }

    public function acompanante()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $acompanantes = Acompanante::select('id', DB::raw('CONCAT(nombres , " ", apellidos, " (", identificacion, ")") as label'))->where(DB::raw('CONCAT(nombres , " ", apellidos, " (", identificacion, ")")'),'like',"%$busqueda%")->orderBy('identificacion','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label

        return response()->json($acompanantes->toArray());
    }

    public function eps()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $eps = Eps::select('id', 'nombre as label')->where('nombre','like',"%$busqueda%")->orderBy('nombre','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label

        return response()->json($eps->toArray());
    }

    public function medicamento()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $medicamentos = null;//necesitamos siempre cargar solo los medicamentos que pertenecen a cada medico

        //si el usuario logueado es un super o un medico
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            $medicamentos = $this->medicamentos->medicamentosAutocomplete($busqueda, Auth::user()->id);
        }

        //si el usuario logueado es un asistente
        if(Auth::user()->perfil_id == 3){
            $medicamentos = $this->medicamentos->medicamentosAutocomplete($busqueda, Session::get('medicoActual')->user->id);
        }

        return response()->json($medicamentos->toArray());
    }

    public function tratamiento()
    {
        $busqueda = $_GET['busqueda'];//ya que se uso el metodo ajax, el dato enviado se anade a la URL de la ruta, que se obtiene por la variable global GET
        $tratamientos = null;//necesitamos siempre cargar solo los tratamientos que pertenecen a cada medico

        //si el usuario logueado es un super o un medico
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            $tratamientos = Tratamiento::select('id', 'nombre as label')->where('nombre','like',"%$busqueda%")->where('user_id', Auth::user()->id)->orderBy('nombre','ASC')->get();//para que funcione el autocomplete de jquery ui, los datos se deben mandar como value y label
        }

        //si el usuario logueado es un asistente
        if(Auth::user()->perfil_id == 3){
            $tratamientos = Tratamiento::select('id', 'nombre as label')->where('nombre','like',"%$busqueda%")->where('user_id', Session::get('medicoActual')->user->id)->orderBy('nombre','ASC')->get();
        }

        return response()->json($tratamientos->toArray());
    }

}
