<div class="box-body">

    <h3 style="color: #3097d1;">Crear Certificado Médico</h3>
    <p>Todos los campos son requeridos excepto "Observación".</p>
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('formatoIdCertificado', 'Escoja un formato') !!}
                {!! Form::select('formatoIdCertificado', $formatos, null, ['class' => 'form-control', 'placeholder' => '----------', 'id' => 'formatoIdCertificado']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label('certificados__contenido', 'Contenido del certificado') !!}
                {!! Form::textarea('certificados__contenido', Input::old('certificados__contenido'), ['class' => 'form-control formato', 'id' => 'certificados__contenido']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('certificados__observacion', 'Observación (Opcional)') !!}
                {!! Form::textarea('certificados__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'certificados__observacion']) !!}
            </div>
        </div>
    </div>
    
</div>