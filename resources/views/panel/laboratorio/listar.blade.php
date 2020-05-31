@extends('layouts.master')

    @section('titulo','Listado de laboratorios')

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
        <h2>Lista de Laboratorios</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="navbar-form pull-left">
                    <a class="btn btn-primary" role="button" data-toggle="modal" onclick="createMember()" data-target="#responsive-modal-create">Crear Laboratorio</a>
                    <br><br>
                </div>
            </div>
        </div>

        {{-- DATATABLE --}}
        <div class="table-responsive col-md-12">   
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
            <table class="table table-bordered table-striped table-hover" id="manageMemberTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- DATATABLE --}}

        <!-- modal CREAR -->
        @include('panel.laboratorio.partials.formLaboratorioCrear')
        <!-- /modal CREAR -->

        <!-- modal EDITAR -->
        @include('panel.laboratorio.partials.formLaboratorioEditar')
        <!-- /modal EDITAR -->
    @endsection

    @section('js')
        {!!Html::script('vendor/datatables/datatables.js')!!}
        {!!Html::script('js/personal/laboratorios.js')!!}
    @endsection