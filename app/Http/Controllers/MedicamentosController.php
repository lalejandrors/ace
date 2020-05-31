<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ace\Medicamento;
use Ace\Repositories\MedicamentosRepository;
use Auth;
use Session;
use Validator;

class MedicamentosController extends Controller
{
    private $medicamentos;

    public function __construct(MedicamentosRepository $medicamentos)
    {
        $this->medicamentos = $medicamentos;
    }

    public function listar()
    {
        return view('panel.medicamento.listar');
    }

    public function datatable(Request $request)
    {
        $medicamentosRequest = $request->all();
        //variables traidas por post para server side
        $start = $medicamentosRequest['start'];
        $length = $medicamentosRequest['length'];
        $search = $medicamentosRequest['search']['value'];
        $draw = $medicamentosRequest['draw'];
        $medicamentos = null;
        $medicamentosNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $medicamentos = $this->medicamentos->findMedicamentosDatatableSearch($start, $length, $search, Auth::user()->id);
                $medicamentosNumero = $this->medicamentos->findMedicamentosDatatableSearchNum($search, Auth::user()->id);
            }else{
                $medicamentos = $this->medicamentos->findMedicamentosDatatable($start, $length, Auth::user()->id);
                $medicamentosNumero = $this->medicamentos->findMedicamentosDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $medicamentos = $this->medicamentos->findMedicamentosDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $medicamentosNumero = $this->medicamentos->findMedicamentosDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $medicamentos = $this->medicamentos->findMedicamentosDatatable($start, $length, Session::get('medicoActual')->user->id);
                $medicamentosNumero = $this->medicamentos->findMedicamentosDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($medicamentos->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($medicamentosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($medicamentos as $medicamento) {
            $array = array();
            $array['id'] = $medicamento->id;
            $array['nombre'] = $medicamento->nombre;
            $array['tipo'] = $medicamento->tipo;
            $array['concentracion'] = $medicamento->concentracion;
            $array['unidades'] = $medicamento->unidades;
            $array['presentacion'] = $medicamento->presentacion;
            $array['laboratorio'] = $medicamento->laboratorio;
            $array['creado'] = $medicamento->created_at;

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

    public function almacenar(Request $request)
    {
        if($request->ajax()){    

            $medicamentosRequest = $request->all();

            //antes de todo validar
            $validator = Validator::make($medicamentosRequest, [
                'nombre' => 'required|min:2|max:255',
                'tipo' => 'required',
                'concentracion' => 'required|min:2|max:150',
                'unidades' => 'required|numeric',
                'presentacion_id' => 'required',
                'laboratorio_id' => 'required',
            ], [], [
                'nombre' => '"Nombre"',
                'tipo' => '"Tipo"',
                'concentracion' => '"Concentración"',
                'unidades' => '"Unidades"',
                'presentacion_id' => '"Presentación"',
                'laboratorio_id' => '"Laboratorio"',
            ]);

            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                $medicamentosRequest['user_id'] = Auth::user()->id;
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
                $medicamentosRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
            }

            Medicamento::create($medicamentosRequest);

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function eliminar(Request $request)
    {
        if($request->ajax()){     
            $medicamentosRequest = $request->all();

            $medicamento = Medicamento::find($medicamentosRequest['medicamento']);
            $medicamento->delete();
            
            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $medicamento = Medicamento::find($id);
        return Response()->json($medicamento);
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){      
            $medicamento = Medicamento::find($id);

            //antes de todo validar
            $validator = Validator::make($request->all(), [
                'nombre' => 'required|min:2|max:255',
                'tipo' => 'required',
                'concentracion' => 'required|min:2|max:150',
                'unidades' => 'required|numeric',
                'presentacion_id' => 'required',
                'laboratorio_id' => 'required',
            ], [], [
                'nombre' => '"Nombre"',
                'tipo' => '"Tipo"',
                'concentracion' => '"Concentración"',
                'unidades' => '"Unidades"',
                'presentacion_id' => '"Presentación"',
                'laboratorio_id' => '"Laboratorio"',
            ]);

            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

            $medicamento->fill($request->all());
            $medicamento->save();

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }
}
