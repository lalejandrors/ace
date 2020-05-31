@extends('layouts.master')

	@section('titulo','Creación de copias de seguridad')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Creación de Copias de Seguridad</h2>

        {!! Form::open(['route' => ['panel.copia.almacenar'], 'method' => 'post']) !!}
		    {{ csrf_field() }}

        	@include('panel.copia.partials.formCopiaCrear')
        	<br><br>

		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Crear
                </button>
            </div>
	    {!! Form::close() !!}
	@endsection

	@section('js')
    @endsection