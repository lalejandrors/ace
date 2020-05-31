@extends('layouts.master')

	@section('titulo','Edición de permisos')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Edición de Permisos</h2>

        {!! Form::open(['route' => ['panel.permiso.editar', $user->id], 'method' => 'put']) !!}
		    {{ csrf_field() }}

		    @include('panel.permiso.partials.formPermisoEditar')
        	<br><br>

		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Editar
                </button>
            </div>
	    {!! Form::close() !!}
	@endsection

	@section('js')
	    <script>
	        //dashabilita el placeholder del select de permisos
			$("option[value='']").attr("disabled", "disabled").siblings().removeAttr("disabled");
	    </script>
    @endsection