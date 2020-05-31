<?php

namespace Ace\Http\Controllers;

use Illuminate\Http\Request;
use Laracasts\Flash\Flash;
use Ace\Acompanante;
use Validator;

class AcompanantesController extends Controller
{
    public function edicion($acompananteId, $pacienteId)
    {
        $acompanante = Acompanante::find($acompananteId);

        //obtener el paciente y mandarlo al metodo editar me funciona para al final, redirigir al ver de ese paciente, y revisar los cambios que sufrio su acompanante
        return view('panel.acompanante.editar', compact('acompanante','pacienteId'));
    }

    public function editar($acompananteId, $pacienteId, Request $request)
    {
        $acompanante = Acompanante::find($acompananteId);
            
        //validamos los campos enviados
        $validator = Validator::make($request->all(), [
            'identificacion' => 'required|min:5|max:50|unique:acompanantes,identificacion,'. $acompananteId,
            'tipoId' => 'required',
            'nombres' => 'required|min:2|max:50',
            'apellidos' => 'required|min:2|max:50',
            'telefonoFijo' => 'required_without:pacientes.telefonoCelular|max:15',
            'telefonoCelular' => 'required_without:pacientes.telefonoFijo|max:10',
        ], [], [
            'identificacion' => '"Identificación"',
            'tipoId' => '"Tipo de Identificación"',
            'nombres' => '"Nombres"',
            'apellidos' => '"Apellidos"',
            'telefonoFijo' => '"Teléfono Fijo"',
            'telefonoCelular' => '"Teléfono Celular"',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $acompanante->fill($request->all());
        $acompanante->save();

        Flash::success('El acompañante ha sido editado de manera correcta.');
        return redirect()->route('panel.paciente.ver', $pacienteId);
    }
}
