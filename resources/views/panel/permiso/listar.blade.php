@extends('layouts.master')

    @section('titulo','Listado de asistentes')

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
        <h2>Lista de Asistentes</h2>

        {{-- DATATABLE --}}
        <div class="table-responsive col-md-12">   
            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}"> 
            <table class="table table-bordered table-striped table-hover" id="manageMemberTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Médicos</th>
                        <th>Estado</th>
                        <th>Permisos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- DATATABLE --}}

        <!-- modal EDITAR -->
        @include('panel.permiso.partials.formPermisoEditar')
        <!-- /modal EDITAR -->
    @endsection

    @section('js')
        {!!Html::script('vendor/datatables/datatables.js')!!}
        {!!Html::script('js/personal/permisos.js')!!}
        <script>
            //dashabilita el placeholder del select de permisos
            $("option[value='']").attr("disabled", "disabled").siblings().removeAttr("disabled");
        </script>
    @endsection