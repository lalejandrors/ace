@extends('layouts.master')

	@section('titulo','Listado de copias de seguridad')

	@section('css')
		<style>
			#cargandoAuto{
				display: none;
			}
		</style>
    @endsection

	@section('contenido')
        <h2>Lista de Copias de Seguridad Automáticas</h2>

        <div class="form-group">
            <a class="btn btn-primary pull-left" href="{{ route('panel.copia.crear') }}" role="button">Crear Nueva Copia</a>
            <br><br>
        </div>
        
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body table-responsive">
                <table class="data-table table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                       	<th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset($copias))
                        @foreach($copias as $copia)
                        <tr>
                            <td>
                                {{ $copia->nombre }}
                            </td>
							<td>
								{{ $copia->descripcion }}
							</td>
							<td>
								{{ $copia->created_at }}
							</td>
                    		<td style="text-align: center;">
								{{ Form::open(['route' => ['panel.copia.restablecer', $copia->id], 'method' => 'get', 'id' => $copia->id]) }}
									<a title="Restablecer" class="btn btn-success btnAcciones" onclick="

	                                    swal({
	                                      title: 'Restablecer Base de Datos<br><br><div id=cargandoAuto style=display: none><img src=/images/loading.gif style=display: block; margin: 0 auto;/></div>',
	                                      text: '<span id=texto>Está seguro que desea restablecer su base de datos a la almacenada en esta copia de seguridad?... recuerde que los datos administrativos como usuarios del sistema y copias de seguridad, no se verán afectados.</span>',
	                                      type: 'warning',
	                                      showCancelButton: true,
	                                      confirmButtonColor: '#DD6B55',
	                                      confirmButtonText: 'Si',
	                                      closeOnConfirm: false,
	                                      html: true
	                                    },
	                                    function(isConfirm){
	                                      if(isConfirm){
	                                        $('#cargandoAuto').show();
	                                        $('#texto').html('Se está procesando su solicitud...');
	                                        document.getElementById({{ $copia->id }}).submit();
	                                        return false;
	                                      }
	                                    });

	                                    return false;

	                                "><i class="fa fa-undo" aria-hidden="true"></i></a>
	                            {{ Form::close() }}
							</td>
						</tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            {!! $copias->render() !!}
        </div>

        <h2>Copia de Seguridad Manual</h2>
        <br>

        <div class="box-body">
		    <div class="row">
		        <div class="col-sm-6">
		            <div class="form-group">
		                <a class="btn btn-primary" href="{{ route('panel.copia.descargar') }}" role="button">Descargar Backup</a>
		                <br>
		                <small class='text-muted'>Aca puede descargar el archivo .csv que contiene toda la información de la base de datos.</small>
		            </div>
		        </div>
		        <div class="col-sm-6">
	                {!! Form::open(['route' => ['panel.copia.cargar'], 'method' => 'post', 'id' => 'formRestablecer', 'files' => true]) !!}
					    {{ csrf_field() }}

			        	<div class="form-group{{ $errors->has('path') ? ' has-error' : '' }}">
			                {!! Form::file('path', ['class' => 'form-control']) !!}
			                <small class='text-muted'>Aca puede cargar el archivo .csv generado al descargar el backup para restablecer la base de datos.</small>
			                {!! $errors->first('path', '<span class="help-block">:message</span>') !!}
			            </div>

					    <div class="form-group">
		                    <button type="submit" class="btn btn-primary pull-left">
		                        Restablecer Backup
		                    </button>
		                    <img src="{{ asset('images/loading.gif') }}" class="pull-right" id="cargandoManual" style="display: none;width: 35px;height: 35px;"/>
			            </div>
				    {!! Form::close() !!}
		        </div>
		    </div>
		</div>
	@endsection

	@section('js')
		<script type="text/javascript">
	    	$(document).ready(function () {
				$("#formRestablecer").submit(function(event) {
					//esto es para hacer visible el gif de cargando al estar restableciendo el backup
					$("#cargandoManual").show();
					document.getElementById('formRestablecer').submit();
					return false;
				});
			})
	    </script>
    @endsection