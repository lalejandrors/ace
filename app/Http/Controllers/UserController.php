<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Ace\Medico;
use Ace\User;
use Auth;
use Session;
use Validator;

class UserController extends Controller
{
   	public function login()
    {
        return view('welcome');
    }

    public function ingreso()
    {
        //esto es cuando la sesion esta viva y se quiere ingresar, para que no pase por el login de nuevo
        $user = User::find(Auth::user()->id);

        return view('panel.index', compact('user'));
    }

    public function bienvenido(Request $request)
    {
        //validamos los campos enviados
        $validator = Validator::make($request->all(), [
            'username' => 'min:2|max:150|required',
            'password' => 'min:6|max:20|required',
        ], [], [
            'username' => '"Usuario"',
            'password' => '"Contraseña"',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        //este es el ingreso por login, mediante post
        if (Auth::attempt(['username' => $request['username'], 'password' => $request['password']])) {
            //verificamos que el usuario loqueado esta activo o no. Si no lo esta, que cierre la sesion y lo devuelva
            $activo = Auth::user()->activo;

            if($activo == 1){//si esta activo
                $user = User::find(Auth::user()->id);

                return view('panel.index', compact('user'));
            }else{
                Auth::logout();

                Flash::warning('Usted no se encuentra activo en este momento. Porfavor consultar con el administrador del sistema.');
                return back()->withInput();
            }
        }else{

            Flash::warning('Datos de ingreso incorrectos.');
            return back()->withInput();
        }
    }

    public function logout()
    {
        //olvidamos todas las variables de sesion que hayan, en caso de que cerremos sesion con un asistente
        Session::flush();
        
        Auth::logout();

        return redirect()->route('user.login');
    }

    public function asignacion($id)
    {
        $medico = Medico::find($id);

        //verificamos que el usuario escogido este activo, si no es asi, que le diga al usuario que debe escoger otro medico
        $activo = $medico->user->activo;

        if($activo == 1){//esta activo
            //creamos la variable de sesion con el medico que esta actualmente seleccionado en la sesion del asistente
            Session::put('medicoActual', $medico);

            return response()->json($medico->user->toArray());
        }else{
            return response()->json([
                "mensaje" => "Inactivo"
            ]);
        }
    }
}
