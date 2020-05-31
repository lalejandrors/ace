@extends('layouts.master')

    @section('titulo','Listado de tipos de citas')

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
        {!!Html::style('vendor/minicolors/jquery.minicolors.css')!!}
    @endsection

    @section('contenido')
        <h2>Lista de Tipos de Citas</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="navbar-form pull-left">
                    <a class="btn btn-primary" role="button" data-toggle="modal" onclick="createMember()" data-target="#responsive-modal-create">Crear Tipo de Cita</a>
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
                        <th>Color</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        {{-- DATATABLE --}}

        <!-- modal CREAR -->
        @include('panel.citatipo.partials.formCitatipoCrear')
        <!-- /modal CREAR -->

        <!-- modal EDITAR -->
        @include('panel.citatipo.partials.formCitatipoEditar')
        <!-- /modal EDITAR -->
    @endsection

    @section('js')
        {!!Html::script('vendor/datatables/datatables.js')!!}
        {!!Html::script('vendor/minicolors/jquery.minicolors.js')!!}
        <script>
            $('#responsive-modal-create #inputColor, #responsive-modal-edit #inputColor').minicolors({
                animationSpeed: 50,
                animationEasing: 'swing',
                change: null,
                changeDelay: 0,
                control: 'hue',
                defaultValue: '',
                format: 'hex',
                hide: null,
                hideSpeed: 100,
                inline: false,
                keywords: '',
                letterCase: 'lowercase',
                opacity: false,
                position: 'bottom left',
                show: null,
                showSpeed: 100,
                theme: 'bootstrap',
                swatches: []
            });
        </script>
        {!!Html::script('js/personal/citatipos.js')!!}
    @endsection