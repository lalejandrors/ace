@extends('layouts.master')

	@section('titulo','Ver paciente')

	@section('css')
    @endsection

	@section('contenido')
		<?php 
		//crear un array con los PERMISOS del usuario logueado actualmente
			$permisos = array();
			for($i=0; $i < count(Auth::user()->permisos); $i++){
			    array_push($permisos, Auth::user()->permisos[$i]->id);
			}
		?>

        <h2>Ver Paciente</h2>

        <div class="form-group">
        	@if(in_array(1, $permisos))
                <a href="{{ route('panel.paciente.edicion2', $paciente) }}" role="button" class="btn btn-warning pull-right">Editar</a>
            @endif
            <br><br>
        </div>

        @include('panel.paciente.partials.formPacienteVer')
        <br><br>

        <h2>Acompañantes</h2>
        
        <div class="box box-primary">
            <div class="box-header"></div>
            <div class="box-body">
                <table class="data-table table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Nombre e identificación</th>
                        <th>Datos de contacto</th>
                        <th>Parentesco</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($acompanantes as $acompanante)
                        <tr>
                            <td>
                                {{ $acompanante->acompanante }}
                            </td>
							<td>
                                @if($acompanante->telefonoFijo != '')
                                	{{ $acompanante->telefonoFijo }}
                                	<br>
                                @endif
                                @if($acompanante->telefonoCelular != '')
                                	{{ $acompanante->telefonoCelular }}
                                	<br>
                                @endif
                            </td>
							<td>
								{{ $acompanante->parentesco }}
							</td>
							<td style="text-align: center;">
                    			@if(in_array(1, $permisos))
	                                <a title="Editar" href="{{ route('panel.acompanante.edicion', [$acompanante->id, $paciente]) }}" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                @endif	
							</td>
						</tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
	@endsection

	@section('js')
    @endsection