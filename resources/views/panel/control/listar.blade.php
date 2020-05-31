@extends('layouts.master')

	@section('titulo','Listado de controles médicos')

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
		
        <h2>Lista de Controles Médicos</h2>
        
		<div class="row">
		  	<div class="col-md-4">
		  		@if(in_array(2, $permisos))
			        <div class="navbar-form pull-left">
		                <a class="btn btn-primary" href="{{ route('panel.control.crear') }}" role="button">Crear Control</a>
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
                        <th>Número</th>
                        <th>Paciente</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- DATATABLE --}}
	@endsection

	@section('js')
        {!!Html::script('vendor/datatables/datatables.js')!!}
        <script>
            // global variable
            var table;
            var token = $('#token').val();

            //DATATABLE
            table = $("#manageMemberTable").DataTable({
                'responsive': true,
                'processing': true,
                'serverSide': true,
                'paging': true,
                'info': true,
                'filter': true,
                'ajax': {
                    "url": "/panel/control/datatable",
                    "type": "POST",
                    'headers': {
                        'X-CSRF-TOKEN': token
                    }
                },
                'columns': [{
                        data: 'numero'
                    },
                    {
                        data: 'paciente'
                    },
                    {
                        data: 'creado'
                    }
                ],
                "columnDefs": [{
                    "targets": [3],
                    "data": "id",
                    "visible": true,
                    "className": "td_defecto",
                    "render": function (data, type, row) {
                        return '<a title="Editar" class="btn btn-warning" href="/panel/control/detallar/' + data + '"><i class="fa fa-eye" style="display:table;margin:0 auto" aria-hidden="true"></i></a>';
                    }
                }],
                'language': {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            });
            //END DATATABLE
        </script>
        {!!Html::script('js/personal/controles.js')!!}
    @endsection