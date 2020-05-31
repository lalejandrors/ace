@extends('layouts.master')

	@section('titulo','Generar una consulta')

	@section('css')
		<style>
			/*CSS Necesario para la paginacion por cliente*/
			.page-navigation a {
				margin: 0 2px;
				display: inline-block;
				padding: 3px 10px;
				color: #ffffff;
				background-color: #24b4b5;
				border-radius: 5px;
				text-decoration: none;
				font-weight: bold;
			}
			.page-navigation a[data-selected] {
				background-color: #329ea1; 
			}
		</style>
    @endsection

	@section('contenido')
        <h2>Escoja el tipo de consulta</h2>
        <br>
        <div class="form-group">
		    <select class="form-control" id="selectConsulta">
		    	<option value="" disabled selected>Seleccione una consulta...</option>
		    	<option value="1">Quienes son mujeres u hombres entre distintas edades.</option>
		    	<option value="2">Pacientes por departamento o ciudad.</option>
		    	<option value="3">Cuales pacientes son padres según un límite de edad.</option>
		    	<option value="4">Pacientes que cumplen años en un rango de una semana.</option>
		    	<option value="5">Listado de pacientes con cierta patología en especial.</option>
		    	<option value="6">Listado de pacientes que han tomado algún tratamiento y cuáles no.</option>
		    	<option value="7">Listado de pacientes que se encuentran atrasados en la realización de su tratamiento.</option>
	  		</select>
		</div>

		<br><br>

        {{-- consulta1 --}}
        <div id="divFormConsulta1" style="display: none;">
	        <div class="box-body">
			    <div class="row">
			        <div class="col-sm-6">
		                {!! Form::label("generoConsulta1", 'Escoja el filtro por genero') !!}
		                {!! Form::select('generoConsulta1', [1 => 'Hombre', 2 => 'Mujer', 3 => 'Todos'], null, ['class' => 'form-control', 'id' => "generoConsulta1"]) !!}
			        </div>
			        <div class="col-sm-3">
		                {!! Form::label("edadMinimaConsulta1", 'Edad mínima') !!}
		                {!! Form::number('edadMinimaConsulta1', null, ['class' => 'form-control', 'id' => 'edadMinimaConsulta1', 'placeholder' => 'Edad mínima', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
			        </div>
			        <div class="col-sm-3">
		                {!! Form::label("edadMaximaConsulta1", 'Edad máxima') !!}
		                {!! Form::number('edadMaximaConsulta1', null, ['class' => 'form-control', 'id' => 'edadMaximaConsulta1', 'placeholder' => 'Edad máxima', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta1" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta1 --}}

        {{-- consulta2 --}}
        <div id="divFormConsulta2" style="display: none;">
	        <div class="box-body">
			    <div class="row">
			        <div class="col-sm-6">
		                {!! Form::label("ciudadConsulta2", 'Ciudad') !!}
		                {!! Form::text('ciudadConsulta_2', null, ['class' => 'form-control', 'placeholder' => 'Escriba la ciudad...', 'id' => 'ciudadConsulta_2', 'style' => 'background-color:#F5F5F5']) !!}
		                {!! Form::hidden('ciudadConsulta2', null, ['id' => 'ciudadConsulta2']) !!}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta2" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta2 --}}

        {{-- consulta3 --}}
        <div id="divFormConsulta3" style="display: none;">
	        <div class="box-body">
			    <div class="row">
	                <div class="col-sm-3">
		                {!! Form::label("edadMinimaConsulta3", 'Edad mínima') !!}
		                {!! Form::number('edadMinimaConsulta3', null, ['class' => 'form-control', 'id' => 'edadMinimaConsulta3', 'placeholder' => 'Edad mínima', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
			        </div>
			        <div class="col-sm-3">
		                {!! Form::label("edadMaximaConsulta3", 'Edad máxima') !!}
		                {!! Form::number('edadMaximaConsulta3', null, ['class' => 'form-control', 'id' => 'edadMaximaConsulta3', 'placeholder' => 'Edad máxima', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta3" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta3 --}}

        {{-- consulta4 --}}
        <div id="divFormConsulta4" style="display: none;">
	        <div class="box-body">
			    <div class="row">
			        <div class="col-sm-2">
		                {!! Form::label("eleccionConsulta4", 'Una semana') !!}
		                {{ Form::radio('eleccionConsulta4', 1, true, ['class' => 'form-control', 'id' => 'eleccionSemanaConsulta4']) }}
			        </div>
			        <div class="col-sm-2">
		                {!! Form::label("eleccionConsulta4", 'Solo el día de hoy') !!}
		                {{ Form::radio('eleccionConsulta4', 2, false, ['class' => 'form-control', 'id' => 'eleccionDiaConsulta4']) }}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta4" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta4 --}}

        {{-- consulta5 --}}
        <div id="divFormConsulta5" style="display: none;">
	        <div class="box-body">
			    <div class="row">
			        <div class="col-sm-6">
		                {!! Form::label("cie10Consulta5", 'Patología') !!}
		                {!! Form::text('cie10Consulta_5', null, ['class' => 'form-control', 'placeholder' => 'Nombre o código cie10 de la patología...', 'id' => 'cie10Consulta_5', 'style' => 'background-color:#F5F5F5']) !!}
		                {!! Form::hidden('cie10Consulta5', null, ['id' => 'cie10Consulta5']) !!}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta5" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta5 --}}

        {{-- consulta6 --}}
        <div id="divFormConsulta6" style="display: none;">
	        <div class="box-body">
			    <div class="row">
			        <div class="col-sm-6">
		                {!! Form::label("tratamientoConsulta6", 'Tratamiento') !!}
		                {!! Form::text('tratamientoConsulta_6', null, ['class' => 'form-control', 'placeholder' => 'Nombre del tratamiento...', 'id' => 'tratamientoConsulta_6', 'style' => 'background-color:#F5F5F5']) !!}
		                {!! Form::hidden('tratamientoConsulta6', null, ['id' => 'tratamientoConsulta6']) !!}
			        </div>
			        <div class="col-sm-6">
		                {!! Form::label("eleccionConsulta6", 'Escoja el filtro de búsqueda') !!}
		                {!! Form::select('eleccionConsulta6', [1 => 'Lo han recibido', 2 => 'No lo han recibido'], null, ['class' => 'form-control', 'id' => "eleccionConsulta6"]) !!}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta6" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta6 --}}

        {{-- consulta6 --}}
        <div id="divFormConsulta7" style="display: none;">
	        <div class="box-body">
			    <div class="row">
			        <div class="col-sm-6">
		                {!! Form::label("tratamientoConsulta7", 'Tratamiento') !!}
		                {!! Form::text('tratamientoConsulta_7', null, ['class' => 'form-control', 'placeholder' => 'Nombre del tratamiento...', 'id' => 'tratamientoConsulta_7', 'style' => 'background-color:#F5F5F5']) !!}
		                {!! Form::hidden('tratamientoConsulta7', null, ['id' => 'tratamientoConsulta7']) !!}
			        </div>
			    </div>
			</div>
        	<br>
		    <div class="form-group">
                <button type="button" id="botonConsulta7" class="btn btn-primary center-block">
                    Buscar
                </button>
                <br><br>
            </div>
		</div>
        {{-- endconsulta6 --}}

        {{-- Imagen de cargando --}}
        <div id="cargando" style="display: none;"><img src="/images/loading.gif" style="display: block;margin: 0 auto;width: 80px;height: 80px;"/></div>
        {{-- end imagen cargando --}}

        {{-- resultados de las consultas --}}
        <div id="divResultadoConsultas" style="display: none;">

	        <div class="box box-primary">
                <div class="box-header"></div>
                <div class="box-body table-responsive" id="contenedorTablaConsultas">
                	{{-- aca se genera la tabla dinamica --}}
                </div>
            </div>

            {{-- boton a form de envio de correo (href se le asigna en el js) --}}
			<div class="form-group" id="btnEnviarMail">
                <a id="listadoEmails" class="btn btn-primary pull-right" href="">Enviar un mail</a>
                <br><br>
        	</div>
		</div>
        {{-- end resultados de las consultas --}}

        {{-- sin resultados --}}
        <div id="divSinResultados" style="display: none;text-align: center;">
        	<p>No se encontraron resultados.</p>
		</div>
        {{-- end sin resultados --}}
	@endsection

	@section('js')
		{!!Html::script('vendor/lightweightpagination/jquery-paginate.js')!!}
		{!!Html::script('js/personal/autocompletar.js')!!}
		{!!Html::script('js/personal/consultas.js')!!}
    @endsection