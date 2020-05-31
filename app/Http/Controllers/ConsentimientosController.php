<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Control;
use Ace\Consentimiento;
use Ace\Repositories\ConsentimientosRepository;
use Ace\HistoriaClinica;
use Ace\InfoCentro;
use Ace\Repositories\PacientesRepository;
use Ace\Sesion;
use Auth;
use Session;
use PDF;

class ConsentimientosController extends Controller
{
    private $consentimientos;
    private $pacientes;

    public function __construct(ConsentimientosRepository $consentimientos, PacientesRepository $pacientes)
    {
        $this->consentimientos = $consentimientos;
        $this->pacientes = $pacientes;
    }

    public function listar()
    {
        return view('panel.consentimiento.listar');
    }

    public function datatable(Request $request)
    {
        $consentimientosRequest = $request->all();
        //variables traidas por post para server side
        $start = $consentimientosRequest['start'];
        $length = $consentimientosRequest['length'];
        $search = $consentimientosRequest['search']['value'];
        $draw = $consentimientosRequest['draw'];
        $consentimientos = null;
        $consentimientosNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $consentimientos = $this->consentimientos->findConsentimientosDatatableSearch($start, $length, $search, Auth::user()->id);
                $consentimientosNumero = $this->consentimientos->findConsentimientosDatatableSearchNum($search, Auth::user()->id);
            }else{
                $consentimientos = $this->consentimientos->findConsentimientosDatatable($start, $length, Auth::user()->id);
                $consentimientosNumero = $this->consentimientos->findConsentimientosDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $consentimientos = $this->consentimientos->findConsentimientosDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $consentimientosNumero = $this->consentimientos->findConsentimientosDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $consentimientos = $this->consentimientos->findConsentimientosDatatable($start, $length, Session::get('medicoActual')->user->id);
                $consentimientosNumero = $this->consentimientos->findConsentimientosDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($consentimientos->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($consentimientosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($consentimientos as $consentimiento) {
            $array = array();
            $array['id'] = $consentimiento->id;
            $array['numero'] = $consentimiento->numero;
            $array['paciente'] = $consentimiento->nombres.' '.$consentimiento->apellidos.'<br>'.'('.$consentimiento->identificacion.')';

            $entorno = "";//guarda el valor de entorno, segun la formula se haya creado en una historia, control o sesion
            if($consentimiento->historia != null){
                $entorno = "Consentimiento creado junto con la historia de número <a href='/panel/historia/ver/" . $consentimiento->historiaId . "' target='_blank'>" . $consentimiento->historia . "</a>.";
            }
            if($consentimiento->control != null){
                $entorno = "Consentimiento creado junto con el control de número <a href='/panel/control/ver/" . $consentimiento->controlId . "' target='_blank'>" . $consentimiento->control . "</a>.";
            }
            if($consentimiento->sesion != null){
                $entorno = "Consentimiento creado junto con la sesión de número <a href='/panel/sesion/ver/" . $consentimiento->sesionId . "' target='_blank'>" . $consentimiento->sesion . "</a>.";
            }
            
            $array['origen'] = $entorno;
            $array['creado'] = $consentimiento->created_at;

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
        $consentimiento = Consentimiento::find($id);
        $paciente = $this->pacientes->findPacienteById($consentimiento->paciente_id);
        $informacion = InfoCentro::find(1);
        //localizamos la historia, control o sesion relacionada con el consentimiento, para enviarla a la vista, y extraer de alli los diagnosticos
        $historia = null;
        $control = null;
        $sesion = null;
        if($consentimiento->historiaClinica_id != null){
            $historia = HistoriaClinica::find($consentimiento->historiaClinica_id);
        }
        if($consentimiento->control_id != null){
            $control = Control::find($consentimiento->control_id);
        }
        if($consentimiento->sesion_id != null){
            $sesion = Sesion::find($consentimiento->sesion_id);
        }

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $consentimiento);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $consentimiento);
        }

        $pdf = PDF::loadView('panel.consentimiento.ver', ['consentimiento' => $consentimiento, 'paciente' => $paciente, 'informacion' => $informacion, 'historia' => $historia, 'control' => $control, 'sesion' => $sesion]);
        return $pdf->stream();
    }

}
