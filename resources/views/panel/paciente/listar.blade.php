@extends('layouts.master')

	@section('titulo','Listado de pacientes')

	@section('css')
        {!!Html::style('vendor/datatables/datatables.css')!!}
        <style>
            .fullscreen-modal .modal-dialog{  
               width: 85%  !important; 
            }

            .td_defecto{
                width: 100px !important;
                text-align: center;
            }

            .table-responsive{
                padding-left: 0px !important;
                padding-right: 0px !important;
            }
        </style>
    @endsection

	@section('contenido')
		<?php 
		    //crear un array con los PERMISOS del usuario logueado actualmente
			$permisos = array();
			for($i=0; $i < count(Auth::user()->permisos); $i++){
			    array_push($permisos, Auth::user()->permisos[$i]->id);
			}
		?>

        {{-- GUARDAMOS EN UNA VARIABLE ESTE VALOR, PARA PODER SABER SI SE TIENE EL PERMISO DESDE EL JAVASCRIPT --}}
        @if(in_array(1, $permisos))
            <input type="hidden" name="permisoGestionar" id="permisoGestionar" value="1">
        @else
            <input type="hidden" name="permisoGestionar" id="permisoGestionar" value="0">
        @endif

        <h2>Lista de Pacientes</h2>
        
		<div class="row">
		  	<div class="col-md-4">
		  		@if(in_array(1, $permisos))
			        <div class="navbar-form pull-left">
		                <a class="btn btn-primary" role="button" data-toggle="modal" onclick="createMember()" data-target="#responsive-modal-create">Crear Paciente</a>
		                <br><br>
		            </div>
		        @endif
		  	</div>
		</div>

        {{-- DATATABLE --}}
        <div class="table-responsive col-md-12">   
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
            <table class="table table-bordered table-striped table-hover" id="manageMemberTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre e identificación</th>
                        <th>Datos de contacto</th>
                        <th>Domicilio</th>
                        <th>Edad</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- DATATABLE --}}

        <!-- modal CREAR -->
        @include('panel.paciente.partials.formPacienteCrear')
        <!-- /modal CREAR -->

        <!-- modal EDITAR -->
        @include('panel.paciente.partials.formPacienteEditar')
        <!-- /modal EDITAR -->
	@endsection

	@section('js')
        {!!Html::script('vendor/datatables/datatables.js')!!}
        {!!Html::script('js/personal/autocompletar.js')!!}
        {!!Html::script('js/personal/pacientes.js')!!}
    @endsection