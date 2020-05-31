<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Control;
use Ace\FormulaTratamiento;
use Ace\Repositories\FormulastratamientoRepository;
use Ace\HistoriaClinica;
use Ace\InfoCentro;
use Ace\Repositories\PacientesRepository;
use Ace\Sesion;
use Auth;
use Session;
use PDF;

class FormulastratamientoController extends Controller
{
    private $formulasTratamiento;
    private $pacientes;
    private $acompanantes;

    public function __construct(FormulastratamientoRepository $formulasTratamiento, PacientesRepository $pacientes)
    {
        $this->formulasTratamiento = $formulasTratamiento;
        $this->pacientes = $pacientes;
    }

    public function listar()
    {
        return view('panel.formulatratamiento.listar');
    }

    public function datatable(Request $request)
    {
        $formulasTratamientoRequest = $request->all();
        //variables traidas por post para server side
        $start = $formulasTratamientoRequest['start'];
        $length = $formulasTratamientoRequest['length'];
        $search = $formulasTratamientoRequest['search']['value'];
        $draw = $formulasTratamientoRequest['draw'];
        $formulasTratamiento = null;
        $formulasTratamientoNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $formulasTratamiento = $this->formulasTratamiento->findFormulasTratamientoDatatableSearch($start, $length, $search, Auth::user()->id);
                $formulasTratamientoNumero = $this->formulasTratamiento->findFormulasTratamientoDatatableSearchNum($search, Auth::user()->id);
            }else{
                $formulasTratamiento = $this->formulasTratamiento->findFormulasTratamientoDatatable($start, $length, Auth::user()->id);
                $formulasTratamientoNumero = $this->formulasTratamiento->findFormulasTratamientoDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $formulasTratamiento = $this->formulasTratamiento->findFormulasTratamientoDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $formulasTratamientoNumero = $this->formulasTratamiento->findFormulasTratamientoDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $formulasTratamiento = $this->formulasTratamiento->findFormulasTratamientoDatatable($start, $length, Session::get('medicoActual')->user->id);
                $formulasTratamientoNumero = $this->formulas->findFormulasTratamientoDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($formulasTratamiento->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($formulasTratamientoNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($formulasTratamiento as $formulaTratamiento) {
            $array = array();
            $array['id'] = $formulaTratamiento->id;
            $array['numero'] = $formulaTratamiento->numero;
            $array['paciente'] = $formulaTratamiento->nombres.' '.$formulaTratamiento->apellidos.'<br>'.'('.$formulaTratamiento->identificacion.')';

            $entorno = "";//guarda el valor de entorno, segun la formula se haya creado en una historia, control o sesion
            if($formulaTratamiento->historia != null){
                $entorno = "Formula de tratamiento creada junto con la historia de número <a href='/panel/historia/ver/" . $formulaTratamiento->historiaId . "' target='_blank'>" . $formulaTratamiento->historia . "</a>.";
            }
            if($formulaTratamiento->control != null){
                $entorno = "Formula de tratamiento creada junto con el control de número <a href='/panel/control/ver/" . $formulaTratamiento->controlId . "' target='_blank'>" . $formulaTratamiento->control . "</a>.";
            }
            if($formulaTratamiento->sesion != null){
                $entorno = "Formula de tratamiento creada junto con la sesión de número <a href='/panel/sesion/ver/" . $formulaTratamiento->sesionId . "' target='_blank'>" . $formulaTratamiento->sesion . "</a>.";
            }
            
            $array['origen'] = $entorno;
            $array['creado'] = $formulaTratamiento->created_at;

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
        $formulaTratamiento = FormulaTratamiento::find($id);
        $paciente = $this->pacientes->findPacienteById($formulaTratamiento->paciente_id);
        $informacion = InfoCentro::find(1);
        //localizamos la historia, control o sesion relacionada con la formula de tratamiento, para enviarla a la vista, y extraer de alli los diagnosticos
        $historia = null;
        $control = null;
        $sesion = null;
        if($formulaTratamiento->historiaClinica_id != null){
            $historia = HistoriaClinica::find($formulaTratamiento->historiaClinica_id);
        }
        if($formulaTratamiento->control_id != null){
            $control = Control::find($formulaTratamiento->control_id);
        }
        if($formulaTratamiento->sesion_id != null){
            $sesion = Sesion::find($formulaTratamiento->sesion_id);
        }

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $formulaTratamiento);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $formulaTratamiento);
        }

        $pdf = PDF::loadView('panel.formulatratamiento.ver', ['formulaTratamiento' => $formulaTratamiento, 'paciente' => $paciente, 'informacion' => $informacion, 'historia' => $historia, 'control' => $control, 'sesion' => $sesion]);
        return $pdf->stream();
    }

}
