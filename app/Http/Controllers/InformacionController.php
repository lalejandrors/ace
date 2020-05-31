<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Ace\InfoCentro;
use Validator;

class InformacionController extends Controller
{
    public function edicion()
    {
        $informacion = InfoCentro::find(1);

        return view('panel.informacion.editar', compact('informacion'));
    }

    public function editar(Request $request)
    {
        //validamos los campos enviados
        $validator = Validator::make($request->all(), [
            'razonSocial' => 'required|min:5|max:100',
            'nit' => 'required|min:5|max:20',
            'registroMedico' => 'required|min:5|max:20',
            'email' => 'required|min:5|max:100|email',
            'direccion' => 'required|min:5|max:150',
            'telefonos' => 'required|min:5|max:100',
            'linkWeb' => 'nullable|min:5|max:150|url',
            'linkFacebook' => 'nullable|min:5|max:150|url',
            'linkTwitter' => 'nullable|min:5|max:150|url',
            'linkYoutube' => 'nullable|min:5|max:150|url',
            'linkInstagram' => 'nullable|min:5|max:150|url',
            'infoAdicional' => 'nullable|min:5|max:150',
            'path' => 'nullable|image|file|dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000',
        ], [], [
            'razonSocial' => '"Razón Social"',
            'nit' => '"NIT"',
            'registroMedico' => '"Registro Médico"',
            'email' => '"Correo Eléctronico"',
            'direccion' => '"Dirección Establecimiento"',
            'telefonos' => '"Teléfonos"',
            'linkWeb' => '"URL Sitio Web"',
            'linkFacebook' => '"URL Perfil de Facebook"',
            'linkTwitter' => '"URL Perfil de Twitter"',
            'linkYoutube' => '"URL Canal de Youtube"',
            'linkInstagram' => '"URL Perfil de Instagram"',
            'infoAdicional' => '"Información Adicional"',
            'path' => '"Logo del Establecimiento"',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $informacion = InfoCentro::find(1);

        //eliminamos la imagen vieja si existe una nueva
        if($request['path'] != null){
            \Storage::delete($informacion->path);
        }

        $informacion->fill($request->all());
        $informacion->save();

        Flash::success('La información del establecimiento ha sido editada de manera correcta.');
        return redirect()->route('panel.user.bienvenido');
    }
}
