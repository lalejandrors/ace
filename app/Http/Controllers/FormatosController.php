<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Illuminate\Validation\Rule;
use Ace\Formato;
use Ace\Repositories\FormatosRepository;
use Auth;
use Session;
use Validator;

class FormatosController extends Controller
{
    private $formatos;

    public function __construct(FormatosRepository $formatos)
    {
        $this->formatos = $formatos;
    }

    public function listar()
    {
        return view('panel.formato.listar');
    }

    public function datatable(Request $request)
    {
        $formatosRequest = $request->all();
        //variables traidas por post para server side
        $start = $formatosRequest['start'];
        $length = $formatosRequest['length'];
        $search = $formatosRequest['search']['value'];
        $draw = $formatosRequest['draw'];
        $formatos = null;
        $formatosNumero = null;

        //si el usuario logueado es un super o un medico se deben listar solo sus pacientes
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){
            if($search){
                $formatos = $this->formatos->findFormatosDatatableSearch($start, $length, $search, Auth::user()->id);
                $formatosNumero = $this->formatos->findFormatosDatatableSearchNum($search, Auth::user()->id);
            }else{
                $formatos = $this->formatos->findFormatosDatatable($start, $length, Auth::user()->id);
                $formatosNumero = $this->formatos->findFormatosDatatableNum(Auth::user()->id);
            }
        }

        //si el usuario logueado es un asistente se deben listar los pacientes que le pertenecen al medico con el que esta actualmente trabajando
        if(Auth::user()->perfil_id == 3){
            if($search){
                $formatos = $this->formatos->findFormatosDatatableSearch($start, $length, $search, Session::get('medicoActual')->user->id);
                $formatosNumero = $this->formatos->findFormatosDatatableSearchNum($search, Session::get('medicoActual')->user->id);
            }else{
                $formatos = $this->formatos->findFormatosDatatable($start, $length, Session::get('medicoActual')->user->id);
                $formatosNumero = $this->formatos->findFormatosDatatableNum(Session::get('medicoActual')->user->id);
            }
        }

        $datosFinales = count($formatos->toArray());//numero de registros a mostrar por pagina
        $datosProcesados = count($formatosNumero->toArray());//numero de registros totales

        $datos = array();
        foreach ($formatos as $formato) {
            $array = array();
            $array['id'] = $formato->id;
            $array['nombre'] = $formato->nombre;
            $array['creado'] = $formato->created_at;

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
        return view('panel.formato.crear');
    }

    public function almacenar(Request $request)
    {
        $formatosRequest = $request->all();

        //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los formatos que pertenecen a nuestro usuario actual por lo del factor de unique
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
            
            $validator = Validator::make($formatosRequest, [
                'nombre' => [
                    'required',
                    'min:2',
                    'max:50',
                    Rule::unique('formatos')->where(function ($query) {
                        $query->where('user_id', Auth::user()->id);
                    }),
                ],
                'contenido' => 'required',
            ], [], [
                'nombre' => '"Nombre"',
                'contenido' => '"Contenido"',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $formatosRequest['user_id'] = Auth::user()->id;
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
            
            $validator = Validator::make($formatosRequest, [
                'nombre' => [
                    'required',
                    'min:2',
                    'max:50',
                    Rule::unique('formatos')->where(function ($query) {
                        $query->where('user_id', Session::get('medicoActual')->user->id);
                    }),
                ],
                'contenido' => 'required',
            ], [], [
                'nombre' => '"Nombre"',
                'contenido' => '"Contenido"',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $formatosRequest['user_id'] = Session::get('medicoActual')->user->id;//registramos el id del medico por el que trabaja el asistente, para que todo quede a nombre del medico
        }

        Formato::create($formatosRequest);

        Flash::success('Formato creado de manera exitosa.');
        return redirect()->route('panel.formato.listar');
    }

    public function eliminar(Request $request)
    {
        if($request->ajax()){    
            $formatosRequest = $request->all();

            $formato = Formato::find($formatosRequest['formato']);
            $formato->delete();
            
            return response()->json([
                "mensaje" => "Ok"
            ]);
        }
    }

    public function edicion($id)
    {
        $formato = Formato::find($id);

        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico...
            $this->authorize('ownerOne', $formato);
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es un asistente, la policy cambia ya que se compara el id del medico que esta en la sesion, no del usuario actual
            $this->authorize('ownerTwo', $formato);
        }

        return view('panel.formato.editar', compact('formato'));
    }

    public function editar($id, Request $request)
    {
        $formato = Formato::find($id);

        //antes de todo validar, y se hace con la ayuda de Rule, ya que debemos validar con where, porque solo queremos tener en cuenta en la validacion, los formatos que pertenecen a nuestro usuario actual por lo del factor de unique
        if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2){//si mi usuario actual es super o medico
            
            $validator = Validator::make($request->all(), [
                'nombre' => [
                    'required',
                    'min:2',
                    'max:50',
                    Rule::unique('formatos')->where(function ($query) use($formato) {
                        $query->where('user_id', Auth::user()->id)->where('id', 'NOT LIKE', $formato->id);
                    }),
                ],
                'contenido' => 'required',
            ], [], [
                'nombre' => '"Nombre"',
                'contenido' => '"Contenido"',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        if(Auth::user()->perfil_id == 3){//si mi usuario actual es super o medico
            
            $validator = Validator::make($request->all(), [
                'nombre' => [
                    'required',
                    'min:2',
                    'max:50',
                    Rule::unique('formatos')->where(function ($query) use($formato) {
                        $query->where('user_id', Session::get('medicoActual')->user->id)->where('id', 'NOT LIKE', $formato->id);
                    }),
                ],
                'contenido' => 'required',
            ], [], [
                'nombre' => '"Nombre"',
                'contenido' => '"Contenido"',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $formato->fill($request->all());
        $formato->save();

        Flash::success('El formato ha sido editado de manera correcta.');
        return redirect()->route('panel.formato.listar');
    }
}
