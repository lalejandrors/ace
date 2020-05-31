<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield('titulo')</title>

    <link rel="shortcut icon" href="{{ asset('images/logo.ico') }}">

    {{-- INDISPENSABLES --}}
    {!!Html::style('css/app.css')!!}
    {!!Html::style('css/custom.css')!!}
    <link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />

    {{-- PANEL --}}
    {!!Html::style('vendor/sbadmin2/metisMenu/metisMenu.min.css')!!}
    {!!Html::style('vendor/sbadmin2/dist/css/sb-admin-2.css')!!}
    {!!Html::style('vendor/sbadmin2/font-awesome/css/font-awesome.min.css')!!}

    {{-- PARA USAR ALERTAS CON ESTILO EN TODAS LAS PAGINAS --}}
    {!!Html::style('vendor/sweetalert/dist/sweetalert.css')!!}

    <style>
        .btnAcciones{
            margin: 2px;
        }
        .logoSuperior{
            margin-left: 50px;
        }
        @media (max-width: 767px) {
            .logoSuperior{
                margin-left: 0px;
            }
        }
    </style>

    @yield('css')
</head>
<body>
    <?php 
        //crear un array con los PERMISOS del usuario logueado actualmente
        $permisos = array();
        for($i=0; $i < count(Auth::user()->permisos); $i++){
            array_push($permisos, Auth::user()->permisos[$i]->id);
        }
    ?>

    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand logoSuperior" href="{{ route('panel.user.bienvenido') }}" style="margin-top:-10px;"><img alt="Brand" src="{{ asset("images/welcome.png") }}" width="80px"></a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                {{-- esta sesion contiene el elemento medico completo que se le asigno al establecerlo en el index --}}
                @if(Session::get('medicoActual') != null)
                    <b style="padding-left: 20px;">{{ 'Dr(a). '.Session::get('medicoActual')->user->nombres.' '.Session::get('medicoActual')->user->apellidos.' ('.Session::get('medicoActual')->user->identificacion.')' }}</b>
                @endif

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        {{ Auth::user()->nombres }}
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="{{ route('panel.user.logout') }}"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        
                        @if(in_array(4, $permisos))
                            <li>
                                <a href="{{ route('panel.agenda.mostrar') }}"><i class="fa fa-calendar fa-fw"></i> Agenda</a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('panel.paciente.listar') }}"><i class="fa fa-child fa-fw"></i> Pacientes</a>
                        </li>

                        @if(in_array(3, $permisos))
                            <li>
                                <a href="{{ route('panel.historia.listar') }}"><i class="fa fa-heartbeat fa-fw"></i> Historias Clínicas</a>
                            </li>
                        @endif

                        @if(in_array(3, $permisos))
                            <li>
                                <a href="{{ route('panel.control.listar') }}"><i class="fa fa-heart fa-fw"></i> Controles Médicos</a>
                            </li>
                        @endif

                        @if(in_array(3, $permisos))
                            <li>
                                <a href="{{ route('panel.sesion.listar') }}"><i class="fa fa-heart-o fa-fw"></i> Sesiones de Tratamiento</a>
                            </li>
                        @endif

                        @if(in_array(3, $permisos))
                            <li>
                                <a href="#"><i class="fa fa-paperclip fa-fw"></i> Registros Adicionales<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('panel.formula.listar') }}"><i class='fa fa-medkit fa-fw'></i> Fórmulas Médicas</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.formulatratamiento.listar') }}"><i class='fa fa-stethoscope fa-fw'></i> Fórmulaciones de Tratamiento</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.incapacidad.listar') }}"><i class='fa fa-wheelchair fa-fw'></i> Incapacidades Médicas</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.certificado.listar') }}"><i class='fa fa-file-text fa-fw'></i> Certificados Médicos</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.consentimiento.listar') }}"><i class='fa fa-file-text-o fa-fw'></i> Consentimientos Informados</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(in_array(6, $permisos))
                            <li>
                                <a href="#"><i class="fa fa-table fa-fw"></i> Reportes<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('panel.informe.consultas') }}"><i class='fa fa-database fa-fw'></i> Generar Consultas</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(in_array(5, $permisos))
                            <li>
                                <a href="#"><i class="fa fa-pencil fa-fw"></i> Personalización<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('panel.tratamiento.listar') }}"><i class='fa fa-stethoscope fa-fw'></i> Tratamientos</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.medicamento.listar') }}"><i class='fa fa-medkit fa-fw'></i> Medicamentos</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.laboratorio.listar') }}"><i class='fa fa-flask fa-fw'></i> Laboratorios</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.citatipo.listar') }}"><i class='fa fa-th-large fa-fw'></i> Tipos de Citas</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.formato.listar') }}"><i class='fa fa-file-text-o fa-fw'></i> Formatos</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        @if(in_array(7, $permisos))
                            <li>
                                <a href="#"><i class="fa fa-cog fa-fw"></i> Administración<span class="fa arrow"></span></a>
                                <ul class="nav nav-second-level">
                                    <li>
                                        <a href="{{ route('panel.informacion.edicion') }}"><i class="fa fa-info fa-fw"></i> Información</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.permiso.listar') }}"><i class="fa fa-hand-paper-o fa-fw"></i> Permisos</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('panel.copia.listar') }}"><i class="fa fa-undo fa-fw"></i> Copias de Seguridad</a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('panel.user.listar') }}"><i class='fa fa-users fa-fw'></i> Usuarios</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-wrapper">
            @include('flash::message')

            <div style="padding-top: 3%;padding-bottom: 6%; overflow: hidden;">
                @yield('contenido')
            </div>
        </div>
    </div>

    <div class="well well-sm" style="text-align: center;margin-bottom: 0px;">
        <a class="navbar-brand" href="http://www.grlcreativos.com/" target="_blank" style="margin-top:-15px;">
            <img alt="Brand" src="{{ asset("images/grlCreativos.png") }}" width="50px">
        </a>

        Copyright © GRL Creativos 2017
    </div>

    {{-- INDISPENSABLES --}}
    {!!Html::script('js/app.js')!!}
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    {{-- PARA LOS INPUT DE FECHA --}}
    <script>
    $(function(){
        $(".datepickermax").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy/mm/dd',
            maxDate: '0'
        });
        $(".datepickermin").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy/mm/dd',
            minDate: '0'
        });
    });
    </script>

    {{-- PANEL --}}
    {!!Html::script('vendor/sbadmin2/metisMenu/metisMenu.min.js')!!}
    {!!Html::script('vendor/sbadmin2/dist/js/sb-admin-2.js')!!}

    {{-- PARA USAR ALERTAS CON ESTILO EN TODAS LAS PAGINAS --}}
    {!!Html::script('vendor/sweetalert/dist/sweetalert.min.js')!!}

    <script>
        // para evitar que se empiece a escribir en algun input con espacio
        $('input, textarea').keypress(function(e) {
            if($(this).val() == "" && e.which === 32){
                return false;
            } 
        });
    </script>

    @yield('js')
</body>
</html>
