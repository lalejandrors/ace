<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Response;
use Laracasts\Flash\Flash;
use Ace\Repositories\AcompanantesRepository;
use Ace\Paciente;
use Ace\Repositories\PacientesRepository;
use Auth;
use Carbon\Carbon;
use Session;
use Validator;

class PacientesController extends Controller
{
    private $acompanantes;
    private $pacientes;

    public function __construct(AcompanantesRepository $acompanantes, PacientesRepository $pacientes)
    {
        $this->acompanantes = $acompanantes;
        $this->pacientes = $pacientes;
    }

    public function listar(Request $request)
    {
        return view('panel.paciente.listar');
    }

    public function datatable(Request $request)
    {
        $pacientesRequest = $request->all();
        //variables traidas por post para server side
        $start = $pacientesRequest['start'];
        $length = $pacientesRequest['length'];
        $search = $pacientesRequest['search']['value'];
        $draw = $pacientesRequest['draw'];
        $pacientes = null;
        $pacientesNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $pacientes = $this->pacientes->findPacientesDatatableSearch($start, $length, $search, Auth::user()->id);
                $pacientesNumero = $this->pacientes->findPacientesDatatableSearchNum($search, Auth::user()->id);
            }else{
                $pacientes = $this->pacientes->findPacientesDatatable($start, $length, Auth::user()->id);
                $pacientesNumero = $this->pacientes->findPacientesDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $pacientes = $this->pacientes->findPacientesDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $pacientesNumero = $this->pacientes->findPacientesDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $pacientes = $this->pacientes->findPacientesDatatable($start, $length, Session::get('medicoActual')->user->id);
                $pacientesNumero = $this->pacientes->findPacientesDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($pacientes->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($pacientesNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($pacientes as $paciente) {
            $array = array();
            $array['id'] = $paciente->id;
            $array['nombreidenti'] = $paciente->nombres.' '.$paciente->apellidos.'<br>'.'('.$paciente->identificacion.')';
            $contacto = '';
            if($paciente->telefonoFijo != ''){
                $contacto = 'Teléfono fijo: '.$paciente->telefonoFijo.'<br>';
            }
            if($paciente->telefonoCelular != ''){
                $contacto = $contacto.'Teléfono celular: '.$paciente->telefonoCelular.'<br>';
            }
            if($paciente->email != '' && $paciente->email != 'fakermail999@999.com'){
                $contacto = $contacto.'Correo electrónico: '.$paciente->email.'<br>';
            }
            $array['datoscontacto'] = $contacto;
            $array['domicilio'] = $paciente->direccion.'<br>'.$paciente->ciudad.' ('.$paciente->departamento.')';
            $fecharr = explode("-", $paciente->fechaNacimiento);
            $array['edad'] = Carbon::createFromDate((int)$fecharr[0], (int)$fecharr[1], (int)$fecharr[2])->age;
            $array['creado'] = $paciente->created_at;

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

            $pacientesRequest = $request->all();
            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los pacientes que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($pacientesRequest, [
                    'identificacion' => [
                        'required',
                        'numeric',
                        'digits_between:5,20',
                        Rule::unique('pacientes')->where(function ($query) {
                            $query->where('user_id', Auth::user()->id);
                        }),
                    ],
                    'tipoId' => 'required',
                    'nombres' => 'required|min:2|max:50',
                    'apellidos' => 'required|min:2|max:50',
                    'fechaNacimiento' => 'required',
                    'genero' => 'required',
                    'hijos' => 'required',
                    'estadoCivil' => 'required',
                    'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                    'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                    'ciudad_id' => 'required',
                    'direccion' => 'required|min:5|max:150',
                    'ubicacion' => 'required',
                    'email' => 'nullable|required|min:5|max:100|email',
                    'eps_id' => 'required',
                    'ocupacion' => 'required|min:2|max:100',
                ], [], [
                    'identificacion' => '"Identificación"',
                    'tipoId' => '"Tipo de Identificación"',
                    'nombres' => '"Nombres"',
                    'apellidos' => '"Apellidos"',
                    'fechaNacimiento' => '"Fecha de Nacimiento"',
                    'genero' => '"Género"',
                    'hijos' => '"Hijos"',
                    'estadoCivil' => '"Estado Civil"',
                    'telefonoFijo' => '"Teléfono Fijo"',
                    'telefonoCelular' => '"Teléfono Celular"',
                    'ciudad_id' => '"Ciudad"',
                    'direccion' => '"Dirección"',
                    'ubicacion' => '"Ubicación"',
                    'email' => '"Correo Electrónico"',
                    'eps_id' => '"EPS"',
                    'ocupacion' => '"Ocupación"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }

                $pacientesRequest['user_id'] = Auth::user()->id;
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es asistente
                
                $validator = Validator::make($pacientesRequest, [
                    'identificacion' => [
                        'required',
                        'numeric',
                        'digits_between:5,20',
                        Rule::unique('pacientes')->where(function ($query) {
                            $query->where('user_id', Session::get('medicoActual')->user->id);
                        }),
                    ],
                    'tipoId' => 'required',
                    'nombres' => 'required|min:2|max:50',
                    'apellidos' => 'required|min:2|max:50',
                    'fechaNacimiento' => 'required',
                    'genero' => 'required',
                    'hijos' => 'required',
                    'estadoCivil' => 'required',
                    'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                    'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                    'ciudad_id' => 'required',
                    'direccion' => 'required|min:5|max:150',
                    'ubicacion' => 'required',
                    'email' => 'nullable|required|min:5|max:100|email',
                    'eps_id' => 'required',
                    'ocupacion' => 'required|min:2|max:100',
                ], [], [
                    'identificacion' => '"Identificación"',
                    'tipoId' => '"Tipo de Identificación"',
                    'nombres' => '"Nombres"',
                    'apellidos' => '"Apellidos"',
                    'fechaNacimiento' => '"Fecha de Nacimiento"',
                    'genero' => '"Género"',
                    'hijos' => '"Hijos"',
                    'estadoCivil' => '"Estado Civil"',
                    'telefonoFijo' => '"Teléfono Fijo"',
                    'telefonoCelular' => '"Teléfono Celular"',
                    'ciudad_id' => '"Ciudad"',
                    'direccion' => '"Dirección"',
                    'ubicacion' => '"Ubicación"',
                    'email' => '"Correo Electrónico"',
                    'eps_id' => '"EPS"',
                    'ocupacion' => '"Ocupación"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }

                $pacientesRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el aistente, para que todo quede a nombre del medico
            }

            //agregamos un correo random si no se ingreso alguno ya que es opcional, y necesitamos almenos uno fake para los demas procesos
            if(!isset($pacientesRequest['email'])){
                $pacientesRequest['email'] = "fakermail999@999.com";
            }

            Paciente::create($pacientesRequest);

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $paciente = Paciente::find($id);
        return Response()->json($paciente);
    }

    public function editar($id, Request $request)
    {
        if($request->ajax()){    
            $paciente = Paciente::find($id);
            $pacientesRequest = $request->all();

            //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los pacientes que pertenecen a nuestro usuario actual por lo del factor de unique
            if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
                
                $validator = Validator::make($pacientesRequest, [
                    'identificacion' => [
                        'required',
                        'numeric',
                        'digits_between:5,20',
                        Rule::unique('pacientes')->where(function ($query) use($paciente) {
                            $query->where('user_id', Auth::user()->id)->where('id', 'NOT LIKE', $paciente->id);
                        }),
                    ],
                    'tipoId' => 'required',
                    'nombres' => 'required|min:2|max:50',
                    'apellidos' => 'required|min:2|max:50',
                    'fechaNacimiento' => 'required',
                    'genero' => 'required',
                    'hijos' => 'required',
                    'estadoCivil' => 'required',
                    'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                    'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                    'ciudad_id' => 'required',
                    'direccion' => 'required|min:5|max:150',
                    'ubicacion' => 'required',
                    'email' => 'nullable|required|min:5|max:100|email',
                    'eps_id' => 'required',
                    'ocupacion' => 'required|min:2|max:100',
                ], [], [
                    'identificacion' => '"Identificación"',
                    'tipoId' => '"Tipo de Identificación"',
                    'nombres' => '"Nombres"',
                    'apellidos' => '"Apellidos"',
                    'fechaNacimiento' => '"Fecha de Nacimiento"',
                    'genero' => '"Género"',
                    'hijos' => '"Hijos"',
                    'estadoCivil' => '"Estado Civil"',
                    'telefonoFijo' => '"Teléfono Fijo"',
                    'telefonoCelular' => '"Teléfono Celular"',
                    'ciudad_id' => '"Ciudad"',
                    'direccion' => '"Dirección"',
                    'ubicacion' => '"Ubicación"',
                    'email' => '"Correo Electrónico"',
                    'eps_id' => '"EPS"',
                    'ocupacion' => '"Ocupación"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
                
                $validator = Validator::make($pacientesRequest, [
                    'identificacion' => [
                        'required',
                        'numeric',
                        'digits_between:5,20',
                        Rule::unique('pacientes')->where(function ($query) use($paciente) {
                            $query->where('user_id', Session::get('medicoActual')->user->id)->where('id', 'NOT LIKE', $paciente->id);
                        }),
                    ],
                    'tipoId' => 'required',
                    'nombres' => 'required|min:2|max:50',
                    'apellidos' => 'required|min:2|max:50',
                    'fechaNacimiento' => 'required',
                    'genero' => 'required',
                    'hijos' => 'required',
                    'estadoCivil' => 'required',
                    'telefonoFijo' => 'required_without:telefonoCelular|max:15',
                    'telefonoCelular' => 'required_without:telefonoFijo|max:10',
                    'ciudad_id' => 'required',
                    'direccion' => 'required|min:5|max:150',
                    'ubicacion' => 'required',
                    'email' => 'nullable|required|min:5|max:100|email',
                    'eps_id' => 'required',
                    'ocupacion' => 'required|min:2|max:100',
                ], [], [
                    'identificacion' => '"Identificación"',
                    'tipoId' => '"Tipo de Identificación"',
                    'nombres' => '"Nombres"',
                    'apellidos' => '"Apellidos"',
                    'fechaNacimiento' => '"Fecha de Nacimiento"',
                    'genero' => '"Género"',
                    'hijos' => '"Hijos"',
                    'estadoCivil' => '"Estado Civil"',
                    'telefonoFijo' => '"Teléfono Fijo"',
                    'telefonoCelular' => '"Teléfono Celular"',
                    'ciudad_id' => '"Ciudad"',
                    'direccion' => '"Dirección"',
                    'ubicacion' => '"Ubicación"',
                    'email' => '"Correo Electrónico"',
                    'eps_id' => '"EPS"',
                    'ocupacion' => '"Ocupación"',
                ]);

                if ($validator->fails()) {
                    return response()->json(array(
                        'success' => false,
                        'errors' => $validator->getMessageBag()->toArray()
                    ), 400);
                }
            }

            //agregamos un correo random si no se ingreso alguno ya que es opcional, y necesitamos almenos uno fake para los demas procesos
            if(!isset($pacientesRequest['email'])){
                $pacientesRequest['email'] = "fakermail999@999.com";
            }

            $paciente->fill($pacientesRequest);
            $paciente->save();

            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    //metodos para acceso a pacientes por reportes////////////////////////////////////////////////////////////////////////////////////////////////
    public function edicion2($id)
    {
        $paciente = Paciente::find($id);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $paciente);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $paciente);
        }

        return view('panel.paciente.editar', compact('paciente'));
    }

    public function editar2($id, Request $request)
    {
        $paciente = Paciente::find($id);
        $pacientesRequest = $request->all();

        //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los pacientes que pertenecen a nuestro usuario actual por lo del factor de unique
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
            
            $validator = Validator::make($pacientesRequest, [
                'identificacion' => [
                    'required',
                    'numeric',
                    'digits_between:5,20',
                    Rule::unique('pacientes')->where(function ($query) use($paciente) {
                        $query->where('user_id', Auth::user()->id)->where('id', 'NOT LIKE', $paciente->id);
                    }),
                ],
                'tipoId' => 'required',
                'nombres' => 'required|min:2|max:50',
                'apellidos' => 'required|min:2|max:50',
                'fechaNacimiento' => 'required',
                'genero' => 'required',
                'hijos' => 'required',
                'estadoCivil' => 'required',
                'telefonoFijo' => 'required_without:telefonoCelular|max:20',
                'telefonoCelular' => 'required_without:telefonoFijo|numeric|digits:10',
                'ciudad_id' => 'required',
                'direccion' => 'required|min:5|max:150',
                'ubicacion' => 'required',
                'email' => 'nullable|required|min:5|max:100|email',
                'eps_id' => 'required',
                'ocupacion' => 'required|min:2|max:100',
            ], [], [
                'identificacion' => '"Identificación"',
                'tipoId' => '"Tipo de Identificación"',
                'nombres' => '"Nombres"',
                'apellidos' => '"Apellidos"',
                'fechaNacimiento' => '"Fecha de Nacimiento"',
                'genero' => '"Género"',
                'hijos' => '"Hijos"',
                'estadoCivil' => '"Estado Civil"',
                'telefonoFijo' => '"Teléfono Fijo"',
                'telefonoCelular' => '"Teléfono Celular"',
                'ciudad_id' => '"Ciudad"',
                'direccion' => '"Dirección"',
                'ubicacion' => '"Ubicación"',
                'email' => '"Correo Electrónico"',
                'eps_id' => '"EPS"',
                'ocupacion' => '"Ocupación"',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
            
            $validator = Validator::make($pacientesRequest, [
                'identificacion' => [
                    'required',
                    'numeric',
                    'digits_between:5,20',
                    Rule::unique('pacientes')->where(function ($query) use($paciente) {
                        $query->where('user_id', Session::get('medicoActual')->user->id)->where('id', 'NOT LIKE', $paciente->id);
                    }),
                ],
                'tipoId' => 'required',
                'nombres' => 'required|min:2|max:50',
                'apellidos' => 'required|min:2|max:50',
                'fechaNacimiento' => 'required',
                'genero' => 'required',
                'hijos' => 'required',
                'estadoCivil' => 'required',
                'telefonoFijo' => 'required_without:telefonoCelular|max:20',
                'telefonoCelular' => 'required_without:telefonoFijo|numeric|digits:10',
                'ciudad_id' => 'required',
                'direccion' => 'required|min:5|max:150',
                'ubicacion' => 'required',
                'email' => 'nullable|required|min:5|max:100|email',
                'eps_id' => 'required',
                'ocupacion' => 'required|min:2|max:100',
            ], [], [
                'identificacion' => '"Identificación"',
                'tipoId' => '"Tipo de Identificación"',
                'nombres' => '"Nombres"',
                'apellidos' => '"Apellidos"',
                'fechaNacimiento' => '"Fecha de Nacimiento"',
                'genero' => '"Género"',
                'hijos' => '"Hijos"',
                'estadoCivil' => '"Estado Civil"',
                'telefonoFijo' => '"Teléfono Fijo"',
                'telefonoCelular' => '"Teléfono Celular"',
                'ciudad_id' => '"Ciudad"',
                'direccion' => '"Dirección"',
                'ubicacion' => '"Ubicación"',
                'email' => '"Correo Electrónico"',
                'eps_id' => '"EPS"',
                'ocupacion' => '"Ocupación"',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        //agregamos un correo random si no se ingreso alguno ya que es opcional, y necesitamos almenos uno fake para los demas procesos
        if(!isset($pacientesRequest['email'])){
            $pacientesRequest['email'] = "fakermail999@999.com";
        }

        $paciente->fill($pacientesRequest);
        $paciente->save();

        Flash::success('El paciente ha sido editado de manera correcta.');
        return redirect()->route('panel.paciente.listar');
    }

    public function ver($id)
    {
        $paciente = Paciente::find($id);
        $acompanantes = $this->acompanantes->findAcompanantes($id);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $paciente);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $paciente);
        }

        return view('panel.paciente.ver', compact('paciente', 'acompanantes'));
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function acompanantes($id)
    {
        $acompanantes = $this->acompanantes->findAcompanantes($id);
        return Response()->json($acompanantes);
    }

    //para verificar la existencia de un paciente al momento de querer registrarlo en el form de registro
    public function existencia($identificacion)
    {
        //necesitamos buscar solo en los pacientes que pertenecen a cada medico, nunca todos.
        $usuarioId = null;

        //si el usuario logueado es un super o un medico
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            $usuarioId = Auth::user()->id;
        }

        //si el usuario logueado es un asistente
        if(Auth::user()->perfil_id == 3){
            $usuarioId = Session::get('medicoActual')->user->id;
        }

        $paciente = Paciente::where('identificacion', $identificacion)->where('user_id', $usuarioId)->first();

        return response()->json($paciente);
    }
}
