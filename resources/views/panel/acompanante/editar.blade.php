@extends('layouts.master')

	@section('titulo','Edición de acompanante')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Edición de Acompañante</h2>

        {!! Form::open(['route' => ['panel.acompanante.editar', $acompanante->id, $pacienteId], 'method' => 'put']) !!}
		    {{ csrf_field() }}

        	@include('panel.acompanante.partials.formAcompananteEditar')
        	<br><br>

		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Editar
                </button>
            </div>
	    {!! Form::close() !!}
	@endsection

	@section('js')
    @endsection