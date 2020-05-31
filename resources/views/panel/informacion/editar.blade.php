@extends('layouts.master')

	@section('titulo','Información del establecimiento')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Información del Establecimiento</h2>

        {!! Form::open(['route' => ['panel.informacion.editar'], 'method' => 'put', 'files' => true]) !!}
		    {{ csrf_field() }}

        	@include('panel.informacion.partials.formInformacionEditar')
        	<br><br>

		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Guardar
                </button>
            </div>
	    {!! Form::close() !!}
	@endsection

	@section('js')
    @endsection