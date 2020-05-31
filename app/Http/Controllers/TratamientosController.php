<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ace\Tratamiento;
use Ace\Repositories\TratamientosRepository;
use Auth;
use Session;
use Validator;

class TratamientosController extends Controller
{
    private $tratamientos;

    public function __construct(TratamientosRepository $tratamientos)
    {
        $this->tratamientos = $tratamientos;
    }

    public function listar()
    {
        return view('panel.tratamiento.listar');
    }

    public function datatable(Request $request)
    {
        $tratamientosRequest = $request->all();
        //variables traidas por post para server side
        $start = $tratamientosRequest['start'];
        $length = $tratamientosRequest['length'];
        $search = $tratamientosRequest['search']['value'];
        $draw = $tratamientosRequest['draw'];
        $tratamientos = null;
        $tratamientosNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $tratamientos = $this->tratamientos->findTratamientosDatatableSearch($start, $length, $search, Auth::user()->id);
                $tratamientosNumero = $this->tratamientos->findTratamientosDatatableSearchNum($search, Auth::user()->id);
            }else{
                $tratamientos = $this->tratamientos->findTratamientosDatatable($start, $length, Auth::user()->id);
                $tratamientosNumero = $this->tratamientos->findTratamientosDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $tratamientos = $this->tratamientos->findTratamientosDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $tratamientosNumero = $this->tratamientos->findTratamientosDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $tratamientos = $this->tratamientos->findTratamientosDatatable($start, $length, Session::get('medicoActual')->user->id);
                $tratamientosNumero = $this->tratamientos->findTratamientosDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($tratamientos->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($tratamientosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($tratamientos as $tratamiento) {
            $array = array();
            $array['id'] = $tratamiento->id;
            $array['nombre'] = $tratamiento->nombre;
            $array['creado'] = $tratamiento->created_at;

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

            $tratamientosRequest = $request->all();

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los tratamientos que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($tratamientosRequest, [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('tratamientos')->where(function ($query) {
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

                $tratamientosRequest['user_id'] = Auth::user()->id;
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
                
                $validator = Validator::make($tratamientosRequest, [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('tratamientos')->where(function ($query) {
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

                $tratamientosRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
            }

            Tratamiento::create($tratamientosRequest);

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function eliminar(Request $request)
    {  
        if($request->ajax()){    
            $tratamientosRequest = $request->all();

            $tratamiento = Tratamiento::find($tratamientosRequest['tratamiento']);
            $tratamiento->delete();
            
            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $tratamiento = Tratamiento::find($id);
        return Response()->json($tratamiento);
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){      
            $tratamiento = Tratamiento::find($id);

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los tratamientos que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($request->all(), [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:100',
                        Rule::unique('tratamientos')->where(function ($query) use($tratamiento) {
                            $query->where('user_id', Auth::user()->id)->where('id', 'NOT LIKE', $tratamiento->id)->whereNull('deleted_at');
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
                        Rule::unique('tratamientos')->where(function ($query) use($tratamiento) {
                            $query->where('user_id', Session::get('medicoActual')->user->id)->where('id', 'NOT LIKE', $tratamiento->id)->whereNull('deleted_at');
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

            $tratamiento->fill($request->all());
            $tratamiento->save();

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }    
    }
}
