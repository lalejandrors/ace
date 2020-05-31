<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ace\CitaTipo;
use Ace\LimiteUsuario;
use Ace\Medico;
use Ace\Perfil;
use Ace\User;
use Ace\Repositories\UsersRepository;
use Auth;
use Validator;

class UsersController extends Controller
{
    private $users;

    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function listar()
    {
        return view('panel.user.listar');
    }

    public function datatable(Request $request)
    {
        $usersRequest = $request->all();
        //variables traidas por post para server side
        $start = $usersRequest['start'];
        $length = $usersRequest['length'];
        $search = $usersRequest['search']['value'];
        $draw = $usersRequest['draw'];
        $users = null;
        $usersNumero = null;

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if($search){
            $users = $this->users->findUsersDatatableSearch($start, $length, $search);
            $usersNumero = $this->users->findUsersDatatableSearchNum($search);
        }else{
            $users = $this->users->findUsersDatatable($start, $length);
            $usersNumero = $this->users->findUsersDatatableNum();
        }

        $datosFinales = count($users->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($usersNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($users as $user) {
            $array = array();
            $array['id'] = $user->id;
            $array['nombre'] = $user->nombres.' '.$user->apellidos.'<br>('.$user->username.')';

            $perfil = '';
            if($user->perfil_id == 1){
                $perfil = "<span class='label label-danger'>$user->perfil</span>";
            }
            if($user->perfil_id == 2){
                $perfil = "<span class='label label-primary'>$user->perfil</span>";
            }
            if($user->perfil_id == 3){
                $perfil = "<span class='label label-warning'>$user->perfil</span><br><br>";
                $medicos = $this->users->findMedicosUsuariosDatatable($user->id);
                foreach($medicos as $medico){
                    $perfil = $perfil . "<ul style='padding-left: 20px;text-align: left;'><li>$medico->nombres"." "."$medico->apellidos</li></ul>";
                }
            }
            $array['perfil'] = $perfil;

            $estado = '';
            if($user->activo == 0){
                $estado = '<span class="label label-default">Inactivo</span>';
            }
            if($user->activo == 1){
                $estado = '<span class="label label-success">Activo</span>';
            }
            $array['estado'] = $estado;

            $array['creado'] = $user->created_at;

            $permisos = array();
            for($i=0; $i < count(Auth::user()->permisos); $i++){
                array_push($permisos, Auth::user()->permisos[$i]->id);
            }
            $acciones = '';
            if(in_array(7, $permisos)){
                if(Auth::user()->id != $user->id && $user->perfil_id != 1){
                    $acciones = '<a title="Eliminar" class="btn btn-danger btnAcciones"><i class="fa fa-trash" title="Eliminar" style="display:table;margin:0 auto" onclick="deleteMember(' . $user->id . ')" aria-hidden="true"></i></a>';

                    if($user->activo == 1){
                        $acciones = $acciones.'<a title="Desactivar" class="btn btn-default btnAcciones"><i class="fa fa-ban" title="Desactivar" style="display:table;margin:0 auto" onclick="disableMember(' . $user->id . ')" aria-hidden="true"></i></a>';
                    }else{
                        $acciones = $acciones.'<a title="Activar" class="btn btn-success btnAcciones"><i class="fa fa-ban" title="Activar" style="display:table;margin:0 auto" onclick="enableMember(' . $user->id . ')" aria-hidden="true"></i></a>';
                    }
                        
                }

                if(Auth::user()->id == $user->id || $user->perfil_id == 3){
                    $acciones = $acciones.'<a title="Editar" class="btn btn-warning btnAcciones"><i class="fa fa-pencil-square-o" title="Editar" style="display:table;margin:0 auto" onclick="editMember(' . $user->id . ')" data-target="#responsive-modal-edit" data-toggle="modal" aria-hidden="true"></i></a>';
                }
            }

            $acciones = $acciones.'<a title="Ver" class="btn btn-primary btnAcciones"><i class="fa fa-eye" title="Ver" style="display:table;margin:0 auto" onclick="viewMember(' . $user->id . ')" data-target="#responsive-modal-view" data-toggle="modal" aria-hidden="true"></i></a>'; 

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

    public function crear()
    {
        $perfiles = Perfil::pluck('nombre','id');
        $medicos = $this->users->obtenerMedicos();
        
        return Response()->json(array('perfiles'=>$perfiles,'medicos'=>$medicos));
    }

    public function almacenar(Request $request)
    {
        if($request->ajax()){    
            //validador para los campos de usuario
            $validator = Validator::make($request->all(), [
                'nombres' => 'required|min:2|max:50',
                'apellidos' => 'required|min:2|max:50',
                'tipoId' => 'required',
                'identificacion' => [
                    'required',
                    'numeric',
                    'digits_between:5,20',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at');
                    }),
                ],
                'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                'username' => [
                    'required',
                    'min:5',
                    'max:20',
                    Rule::unique('users')->where(function ($query) {
                        $query->whereNull('deleted_at');
                    }),
                ],
                'password' => 'required|min:5|max:20',
                'perfil_id' => 'required',
            ], [], [
                'nombres' => '"Nombres"',
                'apellidos' => '"Apellidos"',
                'tipoId' => '"Tipo de Identificación"',
                'identificacion' => '"Identificación"',
                'telefonoFijo' => '"Teléfono Fijo"',
                'telefonoCelular' => '"Teléfono Celular"',
                'username' => '"Nombre de Usuario"',
                'password' => '"Contraseña"',
                'perfil_id' => '"Tipo de Usuario"',
            ]);

            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()
                ), 400);
            }

            //antes de continuar, si se escogio un super o un medico, se debe validar que este pueda ser creado segun el limite establecido
            if($request['perfil_id'] == '1' || $request['perfil_id'] == '2'){
                //contamos cuantos usuarios super o medicos tenemos
                $valorExistente = User::where('perfil_id', 1)->orWhere('perfil_id', 2)->count();
                //obtenemos el numero limite establecido en el cliente
                $valorLimite = LimiteUsuario::find(1)->limite;

                if($valorExistente >= $valorLimite){
                    // Flash::warning('No fué posible crear el nuevo usuario ya que superó el número de Superusuarios o Médicos a crear. Si desea aumentar este límite, porfavor póngase en contacto con nosotros.');
                    return response()->json([
                        "mensaje" => "Limite Usuarios"
                    ]);
                }
            }

            //validador para los campos de medico
            if($request['perfil_id'] == '1' || $request['perfil_id'] == '2'){

                $validator = Validator::make($request->all(), [
                    'especialidad' => 'required|min:5|max:100',
                    'registroMedico' => 'required|min:5|max:20',
                    'email' => 'required|min:5|max:100|email',
                ], [], [
                    'especialidad' => '"Especialidad"',
                    'registroMedico' => '"Registro Médico"',
                    'email' => '"Correo Electrónico"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //gestion medico
            //armamos un nuevo array con los datos solo del medico
            $arrayMedico = array(
                "especialidad" => $request['especialidad'],
                "registroMedico" => $request['registroMedico'],
                "email" => $request['email']
            );
            $medico = Medico::create($arrayMedico);

            //gestion usuario
            $arrayUser = array(
                "username" => $request['username'],
                "password" => bcrypt($request['password']),
                "tipoId" => $request['tipoId'],
                "identificacion" => $request['identificacion'],
                "nombres" => $request['nombres'],
                "apellidos" => $request['apellidos'],
                "telefonoFijo" => $request['telefonoFijo'],
                "telefonoCelular" => $request['telefonoCelular'],
                "perfil_id" => $request['perfil_id'],
                "activo" => 1,
                "medico_id" => $medico->id,
            );

            $user = User::create($arrayUser);

            //asignacion de los permisos por defecto
            if($user->perfil_id == 1){//para super
                $user->permisos()->sync([1, 2, 3, 4, 5, 6, 7]);
            }

            if($user->perfil_id == 2){//para medico
                $user->permisos()->sync([1, 2, 3, 4, 5, 6]);
            }

            if($user->perfil_id == 3){//para asistente
                $user->permisos()->sync([1, 4]);
            }
            
            //llenado de la tabla intermedia, entre asistentes y medicos
            if($user->perfil_id == 3){
                if(isset($request['medicosAsociados'])){//si hay algo de medicos elegidos...
                    $user->medicos()->sync($request['medicosAsociados']);
                }
            }

            //creacion de los tipos de citas por default
            if($user->perfil_id == 1 || $user->perfil_id == 2){
                CitaTipo::create(array('nombre' => 'Primera Vez', 'color' => '#0400FF', 'user_id' => $user->id));
                CitaTipo::create(array('nombre' => 'Control/Consulta', 'color' => '#00D600', 'user_id' => $user->id));
                CitaTipo::create(array('nombre' => 'Sesión', 'color' => '#FFBB00', 'user_id' => $user->id));
            }

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function eliminar(Request $request)
    {
        if($request->ajax()){    
            //eliminamos el usuario, ademas de su registro en medicos
            $usuariosRequest = $request->all();

            $user = User::find($usuariosRequest['usuario']);
            $user->delete();
            Medico::destroy($user->medico_id);
            
            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $user = User::find($id);
        
        $perfiles = Perfil::pluck('nombre','id');
        $medicos = $this->users->obtenerMedicos();

        //para seleccionar los valores del multiselect de los medicos con los valores previos
        $misMedicos = $user->medicos->pluck('id')->toArray();

        return Response()->json(array('perfiles'=>$perfiles,'medicos'=>$medicos,'user'=>$user,'misMedicos'=>$misMedicos));
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){    
            $user = User::find($id);

            if($user->id == Auth::user()->id){//que solo implemente las validaciones si el usuario que va a editar es el mismo usuario a editar
                //validador para los campos de usuario
                if($request['password'] != ""){//si se llena algo en el campo password
                    $validator = Validator::make($request->all(), [
                        'nombres' => 'required|min:2|max:50',
                        'apellidos' => 'required|min:2|max:50',
                        'tipoId' => 'required',
                        'identificacion' => [
                            'required',
                            'numeric',
                            'digits_between:5,20',
                            Rule::unique('users')->where(function ($query) use($user) {
                                $query->where('id', 'NOT LIKE', $user->id)->whereNull('deleted_at');
                            }),
                        ],
                        'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                        'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                        'username' => [
                            'required',
                            'min:5',
                            'max:20',
                            Rule::unique('users')->where(function ($query) use($user) {
                                $query->where('id', 'NOT LIKE', $user->id)->whereNull('deleted_at');
                            }),
                        ],
                        'password' => 'required|min:5|max:20',
                    ], [], [
                        'nombres' => '"Nombres"',
                        'apellidos' => '"Apellidos"',
                        'tipoId' => '"Tipo de Identificación"',
                        'identificacion' => '"Identificación"',
                        'telefonoFijo' => '"Teléfono Fijo"',
                        'telefonoCelular' => '"Teléfono Celular"',
                        'username' => '"Nombre de Usuario"',
                        'password' => '"Contraseña"',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(array(
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                        ), 400);
                    }
                }else{//si no se va a cambiar la password
                    $validator = Validator::make($request->all(), [
                        'nombres' => 'required|min:2|max:50',
                        'apellidos' => 'required|min:2|max:50',
                        'tipoId' => 'required',
                        'identificacion' => 'required|numeric|digits_between:5,20|unique:users,identificacion,'. $user->id,
                        'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                        'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                        'username' => 'required|min:5|max:20|unique:users,username,'. $user->id,
                    ], [], [
                        'nombres' => '"Nombres"',
                        'apellidos' => '"Apellidos"',
                        'tipoId' => '"Tipo de Identificación"',
                        'identificacion' => '"Identificación"',
                        'telefonoFijo' => '"Teléfono Fijo"',
                        'telefonoCelular' => '"Teléfono Celular"',
                        'username' => '"Nombre de Usuario"',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(array(
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                        ), 400);
                    }
                } 
                

                //validador para los campos de medico
                if($user->perfil_id == 1 || $user->perfil_id == 2){

                    $validator = Validator::make($request->all(), [
                        'especialidad' => 'required|min:5|max:100',
                        'registroMedico' => 'required|min:5|max:20',
                        'email' => 'required|min:5|max:100|email',
                    ], [], [
                        'especialidad' => '"Especialidad"',
                        'registroMedico' => '"Registro Médico"',
                        'email' => '"Correo Electrónico"',
                    ]);

                    if ($validator->fails()) {
                        return response()->json(array(
                            'success' => false,
                            'errors' => $validator->getMessageBag()->toArray()
                        ), 400);
                    }
                }
            }

            //gestion usuario
            $requestUsers = $request['users'];

            if($requestUsers['password'] != ""){
                $requestUsers['password'] = bcrypt($requestUsers['password']);
            }else{
                $requestUsers['password'] = $user->password;
            }
            
            $user->fill($requestUsers);
            $user->save();
            
            //gestion medico
            $medico = null;
            if($user->perfil_id == 1 || $user->perfil_id == 2){
                $medico = $user->medico;
                $medico->fill($request['medicos']);
                $medico->save();
            }

            //llenado de la tabla intermedia, entre asistentes y medicos
            if($user->perfil_id == 3){
                if(isset($request['medicosAsociados'])){//si hay algo de medicos elegidos, que se sincronice
                    $user->medicos()->sync($request['medicosAsociados']);
                }else{//si no se eligio a ninguno, que se borren los que habian antes
                    $user->medicos()->detach();
                }
            }

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function ver($id)
    {
        $perfiles = Perfil::pluck('nombre','id');
        $medicos = $this->users->obtenerMedicos();
        $user = User::find($id);
        //para seleccionar los valores del multiselect de los medicos con los valores previos
        $misMedicos = $user->medicos->pluck('id')->toArray();

        return Response()->json(array('perfiles'=>$perfiles,'medicos'=>$medicos,'user'=>$user,'misMedicos'=>$misMedicos));
    }

    public function estadoCambiar(Request $request)
    {
        if($request->ajax()){
            $usuariosRequest = $request->all();

            $user = User::find($usuariosRequest['usuario']);
            if($user->activo == 1){
                $user->update(['activo' => 0]);
            }else{
                $user->update(['activo' => 1]);
            }

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }
    
}
