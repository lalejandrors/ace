@extends('layouts.master')

	@section('titulo','Edición de paciente')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Edición de Paciente</h2>

        {!! Form::open(['route' => ['panel.paciente.editar2', $paciente->id], 'method' => 'put']) !!}
		    {{ csrf_field() }}

        	@include('panel.paciente.partials.formPacienteEditar2')
        	<br><br>

		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Editar
                </button>
            </div>
	    {!! Form::close() !!}
	@endsection

	@section('js')
		{!!Html::script('js/personal/autocompletar.js')!!}
    @endsection