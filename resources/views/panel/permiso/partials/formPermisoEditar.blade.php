<div id="responsive-modal-edit" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="width: 90%; float: left;">Edición de los Permisos</h4>
                <div id="cargando" style="display: none; width: 10%; float: left;">
                    <img src="{{ asset('images/loading.gif') }}" style="width: 35px; height: 35px;"/>
                </div>
            </div>
            <div class="modal-body">
                
                <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
                    <ul id="msj"></ul>
                </div>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="permisoId" id="permisoId" value="">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            {!! Form::label('permisos', 'Permisos') !!}
                            {!! Form::select('permisos[]', [], null, ['class' => 'form-control', 'id' => 'permisos', 'placeholder' => 'Selecciona los permisos...', 'multiple']) !!}
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