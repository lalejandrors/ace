<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ace\CitaTipo;
use Ace\Repositories\CitatiposRepository;
use Auth;
use Session;
use Validator;

class CitatiposController extends Controller
{
    private $citatipos;

    public function __construct(CitatiposRepository $citatipos)
    {
        $this->citatipos = $citatipos;
    }

    public function listar()
    {
        return view('panel.citatipo.listar');
    }

    public function datatable(Request $request)
    {
        $citatiposRequest = $request->all();
        //variables traidas por post para server side
        $start = $citatiposRequest['start'];
        $length = $citatiposRequest['length'];
        $search = $citatiposRequest['search']['value'];
        $draw = $citatiposRequest['draw'];
        $citatipos = null;
        $citatiposNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $citatipos = $this->citatipos->findCitatiposDatatableSearch($start, $length, $search, Auth::user()->id);
                $citatiposNumero = $this->citatipos->findCitatiposDatatableSearchNum($search, Auth::user()->id);
            }else{
                $citatipos = $this->citatipos->findCitatiposDatatable($start, $length, Auth::user()->id);
                $citatiposNumero = $this->citatipos->findCitatiposDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $citatipos = $this->citatipos->findCitatiposDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $citatiposNumero = $this->citatipos->findCitatiposDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $citatipos = $this->citatipos->findCitatiposDatatable($start, $length, Session::get('medicoActual')->user->id);
                $citatiposNumero = $this->citatipos->findCitatiposDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($citatipos->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($citatiposNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($citatipos as $citatipo) {
            $array = array();
            $array['id'] = $citatipo->id;
            $array['nombre'] = $citatipo->nombre;
            $estilo = "width: 0px;height: 50px;border-left: 22px solid $citatipo->color; border-right: 22px solid $citatipo->color;border-bottom: 15px solid transparent;margin: 0 auto;";
            $array['color'] = "<div class='pacmanColor' style='$estilo'></div>";
            $array['creado'] = $citatipo->created_at;
            //generamos los botones desde aca para poder especificar que para algunos tipos de cita los botones no se deben mostrar
            $acciones = '';
            if($citatipo->nombre != "Primera Vez" && $citatipo->nombre != "Control/Consulta" && $citatipo->nombre != "Sesión"){
                $acciones = '<a title="Editar" class="btn btn-warning"><i class="fa fa-pencil-square-o" title="Editar" style="display:table;margin:0 auto" onclick="editMember(' . $citatipo->id . ')" data-toggle="modal" data-target="#responsive-modal-edit" aria-hidden="true"></i></a><a title="Eliminar" class="btn btn-danger"><i class="fa fa-trash" title="Eliminar" style="display:table;margin:0 auto" onclick="deleteMember(' . $citatipo->id . ')" aria-hidden="true"></i></a>';
            }
            $array['acciones'] = $acciones;

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
            $citatiposRequest = $request->all();

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los tipos de citas que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($citatiposRequest, [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('cita_tipos')->where(function ($query) {
                            $query->where('user_id', Auth::user()->id)->whereNull('deleted_at');
                        }),
                    ],
                    'color' => 'required',
                ], [], [
                    'nombre' => '"Nombre"',
                    'color' => '"Color"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }

                $citatiposRequest['user_id'] = Auth::user()->id;
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
                
                $validator = Validator::make($citatiposRequest, [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('cita_tipos')->where(function ($query) {
                            $query->where('user_id', Session::get('medicoActual')->user->id)->whereNull('deleted_at');
                        }),
                    ],
                    'color' => 'required',
                ], [], [
                    'nombre' => '"Nombre"',
                    'color' => '"Color"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }

                $citatiposRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
            }

            CitaTipo::create($citatiposRequest);

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function eliminar(Request $request)
    {
        if($request->ajax()){    
            $citatiposRequest = $request->all();

            $citatipo = CitaTipo::find($citatiposRequest['citatipo']);
            $citatipo->delete();
            
            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $citatipo = CitaTipo::find($id);
        return Response()->json($citatipo);
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){      
            $citatipo = CitaTipo::find($id);

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los tipos de citas que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($request->all(), [
                    'nombre' => [
                        'required',
                        'min:2',
                        'max:50',
                        Rule::unique('cita_tipos')->where(function ($query) use($citatipo) {
                            $query->where('user_id', Auth::user()->id)->where('id', 'NOT LIKE', $citatipo->id)->whereNull('deleted_at');
                        }),
                    ],
                    'color' => 'required',
                ], [], [
                    'nombre' => '"Nombre"',
                    'color' => '"Color"',
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
                        'max:50',
                        Rule::unique('cita_tipos')->where(function ($query) use($citatipo) {
                            $query->where('user_id', Session::get('medicoActual')->user->id)->where('id', 'NOT LIKE', $citatipo->id)->whereNull('deleted_at');
                        }),
                    ],
                    'color' => 'required',
                ], [], [
                    'nombre' => '"Nombre"',
                    'color' => '"Color"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            $citatipo->fill($request->all());
            $citatipo->save();

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }
}
