<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Control;
use Ace\IncapacidadMedica;
use Ace\Repositories\IncapacidadesRepository;
use Ace\HistoriaClinica;
use Ace\InfoCentro;
use Ace\Repositories\PacientesRepository;
use Ace\Sesion;
use Auth;
use Session;
use PDF;

class IncapacidadesController extends Controller
{
    private $incapacidades;
    private $pacientes;

    public function __construct(IncapacidadesRepository $incapacidades, PacientesRepository $pacientes)
    {
        $this->incapacidades = $incapacidades;
        $this->pacientes = $pacientes;
    }

    public function listar()
    {
        return view('panel.incapacidad.listar');
    }

    public function datatable(Request $request)
    {
        $incapacidadesRequest = $request->all();
        //variables traidas por post para server side
        $start = $incapacidadesRequest['start'];
        $length = $incapacidadesRequest['length'];
        $search = $incapacidadesRequest['search']['value'];
        $draw = $incapacidadesRequest['draw'];
        $incapacidades = null;
        $incapacidadesNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $incapacidades = $this->incapacidades->findIncapacidadesDatatableSearch($start, $length, $search, Auth::user()->id);
                $incapacidadesNumero = $this->incapacidades->findIncapacidadesDatatableSearchNum($search, Auth::user()->id);
            }else{
                $incapacidades = $this->incapacidades->findIncapacidadesDatatable($start, $length, Auth::user()->id);
                $incapacidadesNumero = $this->incapacidades->findIncapacidadesDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $incapacidades = $this->incapacidades->findIncapacidadesDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $incapacidadesNumero = $this->incapacidades->findIncapacidadesDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $incapacidades = $this->incapacidades->findIncapacidadesDatatable($start, $length, Session::get('medicoActual')->user->id);
                $incapacidadesNumero = $this->incapacidades->findIncapacidadesDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($incapacidades->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($incapacidadesNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($incapacidades as $incapacidad) {
            $array = array();
            $array['id'] = $incapacidad->id;
            $array['numero'] = $incapacidad->numero;
            $array['paciente'] = $incapacidad->nombres.' '.$incapacidad->apellidos.'<br>'.'('.$incapacidad->identificacion.')';

            $entorno = "";//guarda el valor de entorno, segun la formula se haya creado en una historia, control o sesion
            if($incapacidad->historia != null){
                $entorno = "Incapacidad creada junto con la historia de número <a href='/panel/historia/ver/" . $incapacidad->historiaId . "' target='_blank'>" . $incapacidad->historia . "</a>.";
            }
            if($incapacidad->control != null){
                $entorno = "Incapacidad creada junto con el control de número <a href='/panel/control/ver/" . $incapacidad->controlId . "' target='_blank'>" . $incapacidad->control . "</a>.";
            }
            if($incapacidad->sesion != null){
                $entorno = "Incapacidad creada junto con la sesión de número <a href='/panel/sesion/ver/" . $incapacidad->sesionId . "' target='_blank'>" . $incapacidad->sesion . "</a>.";
            }
            
            $array['origen'] = $entorno;
            $array['creado'] = $incapacidad->created_at;

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

    public function ver($id)
    {
        //envio de datos a la vista
        $incapacidad = IncapacidadMedica::find($id);
        $paciente = $this->pacientes->findPacienteById($incapacidad->paciente_id);
        $informacion = InfoCentro::find(1);
        //localizamos la historia, control o sesion relacionada con la incapacidad, para enviarla a la vista, y extraer de alli los diagnosticos
        $historia = null;
        $control = null;
        $sesion = null;
        if($incapacidad->historiaClinica_id != null){
            $historia = HistoriaClinica::find($incapacidad->historiaClinica_id);
        }
        if($incapacidad->control_id != null){
            $control = Control::find($incapacidad->control_id);
        }
        if($incapacidad->sesion_id != null){
            $sesion = Sesion::find($incapacidad->sesion_id);
        }

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $incapacidad);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $incapacidad);
        }

        $pdf = PDF::loadView('panel.incapacidad.ver', ['incapacidad' => $incapacidad, 'paciente' => $paciente, 'informacion' => $informacion, 'historia' => $historia, 'control' => $control, 'sesion' => $sesion]);
        return $pdf->stream();
    }

}
