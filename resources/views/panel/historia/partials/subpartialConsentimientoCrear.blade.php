<div class="box-body">

    <h3 style="color: #3097d1;">Crear Consentimiento Informado</h3>
    <p>Todos los campos son requeridos excepto "Observación".</p>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('formatoIdConsentimiento', 'Escoja un formato') !!}
                {!! Form::select('formatoIdConsentimiento', $formatos, null, ['class' => 'form-control', 'placeholder' => '----------', 'id' => 'formatoIdConsentimiento']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('consentimientos__contenido', 'Contenido del consentimiento') !!}
                {!! Form::textarea('consentimientos__contenido', Input::old('consentimientos__contenido'), ['class' => 'form-control formato', 'id' => 'consentimientos__contenido']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('consentimientos__observacion', 'Observación (Opcional)') !!}
                {!! Form::textarea('consentimientos__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'consentimientos__observacion']) !!}
            </div>
        </div>
    </div>
    
</div>