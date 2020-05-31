<div id="responsive-modal-edit" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="width: 90%; float: left;">Edición del Tratamiento</h4>
                <div id="cargando" style="display: none; width: 10%; float: left;">
                    <img src="{{ asset('images/loading.gif') }}" style="width: 35px; height: 35px;"/>
                </div>
            </div>
            <div class="modal-body">
                
                <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
                    <ul id="msj"></ul>
                </div>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="medicamentoId" id="medicamentoId" value="">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("nombre", 'Nombre') !!}
                            {!! Form::text('nombre', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("tipo", 'Tipo') !!}
                            {!! Form::select('tipo', ['' => '----------', 'Medicina Alternativa' => 'Medicina Alternativa', 'Medicina Ortodoxa' => 'Medicina Ortodoxa'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("concentracion", 'Concentración') !!}
                            {!! Form::text('concentracion', null, ['class' => 'form-control', 'placeholder' => 'Ej: 50 mg/30 ml']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("unidades", 'Unidades por presentación') !!}
                            {!! Form::number('unidades', null, ['class' => 'form-control', 'placeholder' => 'Unidades por presentación', 'min' => 1, 'onkeypress' => 'return event.charCode >= 48']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("presentacion_id", 'Presentación') !!}
                            {!! Form::text('presentacionId', null, ['class' => 'form-control', 'placeholder' => 'Escriba la presentación del medicamento', 'id' => 'presentacionId', 'style' => 'background-color:#F5F5F5']) !!}
                            {!! Form::hidden('presentacion_id', null, ['id' => 'presentacion_id']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("laboratorio_id", 'Laboratorio') !!}
                            {!! Form::text('laboratorioId', null, ['class' => 'form-control', 'placeholder' => 'Escriba el laboratorio', 'id' => 'laboratorioId', 'style' => 'background-color:#F5F5F5']) !!}
                            {!! Form::hidden('laboratorio_id', null, ['id' => 'laboratorio_id']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
                {!! link_to('#', $title="Editar", $attributes = ['id' => 'edicion', 'class' => 'btn btn-primary'], $secure = null) !!}
            </div>
        </div>
    </div>
</div>