<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ace\Laboratorio;
use Ace\Repositories\LaboratoriosRepository;
use Auth;
use Session;
use Validator;

class LaboratoriosController extends Controller
{
    private $laboratorios;

    public function __construct(LaboratoriosRepository $laboratorios)
    {
        $this->laboratorios = $laboratorios;
    }

    public function listar()
    {
        return view('panel.laboratorio.listar');
    }

    public function datatable(Request $request)
    {
        $laboratoriosRequest = $request->all();
        //variables traidas por post para server side
        $start = $laboratoriosRequest['start'];
        $length = $laboratoriosRequest['length'];
        $search = $laboratoriosRequest['search']['value'];
        $draw = $laboratoriosRequest['draw'];
        $laboratorios = null;
        $laboratoriosNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $laboratorios = $this->laboratorios->findLaboratoriosDatatableSearch($start, $length, $search, Auth::user()->id);
                $laboratoriosNumero = $this->laboratorios->findLaboratoriosDatatableSearchNum($search, Auth::user()->id);
            }else{
                $laboratorios = $this->laboratorios->findLaboratoriosDatatable($start, $length, Auth::user()->id);
                $laboratoriosNumero = $this->laboratorios->findLaboratoriosDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $laboratorios = $this->laboratorios->findLaboratoriosDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $laboratoriosNumero = $this->laboratorios->findLaboratoriosDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $laboratorios = $this->laboratorios->findLaboratoriosDatatable($start, $length, Session::get('medicoActual')->user->id);
                $laboratoriosNumero = $this->laboratorios->findLaboratoriosDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($laboratorios->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($laboratoriosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($laboratorios as $laboratorio) {
            $array = array();
            $array['id'] = $laboratorio->id;
            $array['nombre'] = $laboratorio->nombre;
            $array['creado'] = $laboratorio->created_at;

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
            $laboratoriosRequest = $request->all();

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los laboratorios que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($laboratoriosRequest, [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('laboratorios')->where(function ($query) {
                            $query->where('user_id', Auth::user()->id)->whereNull('deleted_at');
                        }),
                    ],
                ], [], [
                    'nombre' => '"Nombre"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }

                $laboratoriosRequest['user_id'] = Auth::user()->id;
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
                
                $validator = Validator::make($laboratoriosRequest, [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('laboratorios')->where(function ($query) {
                            $query->where('user_id', Session::get('medicoActual')->user->id)->whereNull('deleted_at');
                        }),
                    ],
                ], [], [
                    'nombre' => '"Nombre"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }

                $laboratoriosRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
            }

            Laboratorio::create($laboratoriosRequest);

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function eliminar(Request $request)
    {
        if($request->ajax()){     
            $laboratoriosRequest = $request->all();

            $laboratorio = Laboratorio::find($laboratoriosRequest['laboratorio']);
            $laboratorio->delete();
            
            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $laboratorio = Laboratorio::find($id);
        return Response()->json($laboratorio);
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){    
            $laboratorio = Laboratorio::find($id);

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los laboratorios que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($request->all(), [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('laboratorios')->where(function ($query) use($laboratorio) {
                            $query->where('user_id', Auth::user()->id)->where('id', 'NOT LIKE', $laboratorio->id)->whereNull('deleted_at');
                        }),
                    ],
                ], [], [
                    'nombre' => '"Nombre"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
                
                $validator = Validator::make($request->all(), [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('laboratorios')->where(function ($query) use($laboratorio) {
                            $query->where('user_id', Session::get('medicoActual')->user->id)->where('id', 'NOT LIKE', $laboratorio->id)->whereNull('deleted_at');
                        }),
                    ],
                ], [], [
                    'nombre' => '"Nombre"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            $laboratorio->fill($request->all());
            $laboratorio->save();

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }
}
