<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Ace\Control;
use Ace\Formula;
use Ace\Repositories\FormulasRepository;
use Ace\HistoriaClinica;
use Ace\InfoCentro;
use Ace\Repositories\PacientesRepository;
use Ace\Sesion;
use Auth;
use Session;
use PDF;

class FormulasController extends Controller
{
    private $formulas;
    private $pacientes;

    public function __construct(FormulasRepository $formulas, PacientesRepository $pacientes)
    {
        $this->formulas = $formulas;
        $this->pacientes = $pacientes;
    }

    public function listar()
    {
        return view('panel.formula.listar');
    }

    public function datatable(Request $request)
    {
        $formulasRequest = $request->all();
        //variables traidas por post para server side
        $start = $formulasRequest['start'];
        $length = $formulasRequest['length'];
        $search = $formulasRequest['search']['value'];
        $draw = $formulasRequest['draw'];
        $formulas = null;
        $formulasNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $formulas = $this->formulas->findFormulasDatatableSearch($start, $length, $search, Auth::user()->id);
                $formulasNumero = $this->formulas->findFormulasDatatableSearchNum($search, Auth::user()->id);
            }else{
                $formulas = $this->formulas->findFormulasDatatable($start, $length, Auth::user()->id);
                $formulasNumero = $this->formulas->findFormulasDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $formulas = $this->formulas->findFormulasDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $formulasNumero = $this->formulas->findFormulasDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $formulas = $this->formulas->findFormulasDatatable($start, $length, Session::get('medicoActual')->user->id);
                $formulasNumero = $this->formulas->findFormulasDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($formulas->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($formulasNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($formulas as $formula) {
            $array = array();
            $array['id'] = $formula->id;
            $array['numero'] = $formula->numero;
            $array['paciente'] = $formula->nombres.' '.$formula->apellidos.'<br>'.'('.$formula->identificacion.')';

            $entorno = "";//guarda el valor de entorno, segun la formula se haya creado en una historia, control o sesion
            if($formula->historia != null){
                $entorno = "Formula creada junto con la historia de número <a href='/panel/historia/ver/" . $formula->historiaId . "' target='_blank'>" . $formula->historia . "</a>.";
            }
            if($formula->control != null){
                $entorno = "Formula creada junto con el control de número <a href='/panel/control/ver/" . $formula->controlId . "' target='_blank'>" . $formula->control . "</a>.";
            }
            if($formula->sesion != null){
                $entorno = "Formula creada junto con la sesión de número <a href='/panel/sesion/ver/" . $formula->sesionId . "' target='_blank'>" . $formula->sesion . "</a>.";
            }
            
            $array['origen'] = $entorno;
            $array['creado'] = $formula->created_at;

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
        $formula = Formula::find($id);
        $paciente = $this->pacientes->findPacienteById($formula->paciente_id);
        $informacion = InfoCentro::find(1);
        //localizamos la historia, control o sesion relacionada con la formula, para enviarla a la vista, y extraer de alli los diagnosticos
        $historia = null;
        $control = null;
        $sesion = null;
        if($formula->historiaClinica_id != null){
            $historia = HistoriaClinica::find($formula->historiaClinica_id);
        }
        if($formula->control_id != null){
            $control = Control::find($formula->control_id);
        }
        if($formula->sesion_id != null){
            $sesion = Sesion::find($formula->sesion_id);
        }

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $formula);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $formula);
        }

        $pdf = PDF::loadView('panel.formula.ver', ['formula' => $formula, 'paciente' => $paciente, 'informacion' => $informacion, 'historia' => $historia, 'control' => $control, 'sesion' => $sesion]);
        return $pdf->stream();
    }

}
