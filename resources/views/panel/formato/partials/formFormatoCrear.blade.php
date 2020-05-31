<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                {!! Form::label('nombre', 'Nombre') !!}
                {!! Form::text('nombre', Input::old('nombre'), ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
                {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('contenido') ? ' has-error' : '' }}">
                {!! Form::label('contenido', 'Contenido') !!}
                <br>
                <small>Evite cargar imágenes a los formatos de certificados médicos y consentimientos informados, ya que se podría dificultar la generación de su impresión en PDF. Para los formatos de correos eléctronicos no hay inconvenientes.</small>
                {!! Form::textarea('contenido', Input::old('contenido'), ['class' => 'form-control']) !!}
                {!! $errors->first('contenido', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>