@extends('layouts.master')

    @section('titulo','Listado de usuarios')

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
        <h2>Lista de Usuarios</h2>
        
        <div class="row">
            <div class="col-md-4">
            	@if(in_array(7, $permisos))
	                <div class="navbar-form pull-left">
	                    <a class="btn btn-primary" role="button" data-toggle="modal" onclick="createMember()" data-target="#responsive-modal-create">Crear Usuario</a>
	                    <br><br>
	                </div>
	            @endif
            </div>
        </div>

        {{-- DATATABLE --}}
        <div class="table-responsive col-md-12">   
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            <input type="hidden" name="currentUser" id="currentUser" value="{{ Auth::user()->id }}">
            <input type="hidden" name="currentUserPerfil" id="currentUserPerfil" value="{{ Auth::user()->perfil_id }}"> 
            <table class="table table-bordered table-striped table-hover" id="manageMemberTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Perfil</th>
                        <th>Estado</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- DATATABLE --}}

        <!-- modal CREAR -->
        @include('panel.user.partials.formUserCrear')
        <!-- /modal CREAR -->

        <!-- modal EDITAR -->
        @include('panel.user.partials.formUserEditar')
        <!-- /modal EDITAR -->

        <!-- modal VER -->
        @include('panel.user.partials.formUserVer')
        <!-- /modal VER -->
    @endsection

    @section('js')
        {!!Html::script('vendor/datatables/datatables.js')!!}
        {!!Html::script('js/personal/autocompletar.js')!!}
        <script>
            $(document).ready(function () {

			    $("#perfil_id").on('change', function() {//gestiona los campos del form que deben o no aparecer segun el perfil del usuario
			        if($("#perfil_id").val() == '1' || $("#perfil_id").val() == '2') {
			            $("#formMedicoCrear").show();
			        }else{
			            $("#formMedicoCrear").hide();
			        }  

			        if($("#perfil_id").val() == '3') {
			            $("#listadoMedicosCrear").show();
			        }else{
			            $("#listadoMedicosCrear").hide();
			        }     
			    });
			});

			//gestiona el ver u ocultar password
	        $('#show_password').hover(function functionName() {
					$('#responsive-modal-edit #password').attr('type', 'text');
					$('.eye').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
				}, function () {
					$('#responsive-modal-edit #password').attr('type', 'password');
					$('.eye').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
				}
			)

			//dashabilita el placeholder del select de medicos
	        $("option[value='']").attr("disabled", "disabled").siblings().removeAttr("disabled");
        </script>
        {!!Html::script('js/personal/usuarios.js')!!}
    @endsection