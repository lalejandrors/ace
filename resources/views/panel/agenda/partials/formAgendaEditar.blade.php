<div id="responsive-modal-edit" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="width: 90%; float: left;">Edición de la Cita</h4>
                <div id="cargando" style="display: none; width: 10%; float: left;">
                    <img src="{{ asset('images/loading.gif') }}" style="width: 35px; height: 35px;"/>
                </div>
            </div>
            <div class="modal-body">
                
                <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
                    <ul id="msj"></ul>
                </div>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                <input type="hidden" name="citaId" id="citaId" value="">

                <input type="hidden" name="pacienteId" id="pacienteId" value="">

                <div class="form-group" id="pacienteViejo">
                    {{ Form::label('paciente', null, ['class' => 'form-control', 'id' => 'paciente', 'style' => 'background-color:#C7FFD5']) }}
                </div>

                <div class="form-group" id="pnCheck">
                    {!! Form::label('pacienteNuevoCheck', 'Cambiar Paciente') !!}
                    {{ Form::checkbox('pacienteNuevoCheck', 1, null, ['id' => 'pacienteNuevoCheck']) }}
                </div>

                <div class="form-group" id="pacienteNuevo" style="display: none;">
                    {!! Form::text('pacienteIdAgenda', null, ['class' => 'form-control', 'placeholder' => 'Nombre o documento del paciente...', 'id' => 'pacienteIdAgenda', 'style' => 'background-color:#F5F5F5']) !!}
                    {!! Form::hidden('paciente_id', null, ['id' => 'paciente_id']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label('citaTipo_id', 'Tipo de Cita') }}
                    {!! Form::select('citaTipo_id', $citaTipos, null, ['class' => 'form-control', 'placeholder' => '----------', 'id' => 'citaTipo_id']) !!}
                </div>

                <div class="form-group" id="tratamientoSesion" style="display: none;">
                    {{ Form::label('tratamiento_id', 'Tratamiento') }}
                    {!! Form::select('tratamiento_id', $tratamientos, null, ['class' => 'form-control', 'placeholder' => '----------', 'id' => 'tratamiento_id']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label('fechaHoraInicio', 'Fecha y Hora Inicio') }}
                    {!! Form::text('fechaHoraInicio', null, ['class' => 'form-control', 'id' => 'fechaHoraInicio']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label('fechaHoraFin', 'Fecha y Hora Fin') }}
                    {!! Form::text('fechaHoraFin', null, ['class' => 'form-control', 'id' => 'fechaHoraFin']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label('observacion', 'Observación (Opcional)') }}
                    {!! Form::textarea('observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '3', 'id' => 'observacion']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label('estado', 'Estado de la Cita') }}
                    {!! Form::select('estado', ['' => '----------', 'Creada' => 'Creada', 'Confirmada' => 'Confirmada', 'Asistida' => 'Asistida'], null, ['class' => 'form-control', 'id' => 'estado']) !!}
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
                {!! link_to('#', $title="Eliminar", $attributes = ['id' => 'eliminar', 'class' => 'btn btn-danger'], $secure = null) !!}
                {!! link_to('#', $title="Editar", $attributes = ['id' => 'edicion', 'class' => 'btn btn-primary'], $secure = null) !!}
            </div>
        </div>
    </div>
</div>