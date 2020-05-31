@extends('layouts.master')

	@section('titulo','Bienvenido')

	@section('css')
    @endsection

	@section('contenido')
		{{ Form::hidden('perfilId', Auth::user()->perfil_id, ['id' => 'perfilId']) }}
		{{ Form::hidden('nombreUser', Auth::user()->nombres, ['id' => 'nombreUser']) }}
		{{ Form::hidden('medicoActual', Session::get('medicoActual'), ['id' => 'medicoActual']) }}

		{{-- se renderiza y carga el select con los medico que le pertenecen al asistente logueado --}}
		@if(Auth::user()->perfil_id == 3)
			<div class="form-group pull-right">
			    <select class="form-control" id="selectMedico">
			    	<option value="" disabled selected>Seleccione un médico...</option>
			    	@foreach($user->medicos as $medico)
			    		<option value="{{ $medico->id }}">{{ $medico->user->nombres }}</option>
			    	@endforeach
		  		</select>
			</div>
		@endif
	@endsection

	@section('js')
		{!!Html::script('js/personal/medico.js')!!}
    @endsection