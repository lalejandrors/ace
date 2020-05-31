<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('razonSocial') ? ' has-error' : '' }}">
                {!! Form::label('razonSocial', 'Razón Social') !!}
                {!! Form::text('razonSocial', $informacion->razonSocial, ['class' => 'form-control', 'placeholder' => 'Razón Social']) !!}
                {!! $errors->first('razonSocial', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('nit') ? ' has-error' : '' }}">
                {!! Form::label('nit', 'NIT') !!}
                {!! Form::text('nit', $informacion->nit, ['class' => 'form-control', 'placeholder' => 'NIT']) !!}
                {!! $errors->first('nit', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('registroMedico') ? ' has-error' : '' }}">
                {!! Form::label('registroMedico', 'Registro Médico') !!}
                {!! Form::text('registroMedico', $informacion->registroMedico, ['class' => 'form-control', 'placeholder' => 'Registro Médico']) !!}
                {!! $errors->first('registroMedico', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label("email", 'Correo Eléctronico') !!}
                {!! Form::text('email', $informacion->email, ['class' => 'form-control', 'placeholder' => 'Correo Eléctronico']) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                {!! Form::label('direccion', 'Dirección Establecimiento') !!}
                {!! Form::text('direccion', $informacion->direccion, ['class' => 'form-control', 'placeholder' => 'Dirección Establecimiento']) !!}
                {!! $errors->first('direccion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('telefonos') ? ' has-error' : '' }}">
                {!! Form::label('telefonos', 'Teléfonos') !!}
                {!! Form::text('telefonos', $informacion->telefonos, ['class' => 'form-control', 'placeholder' => 'Teléfonos']) !!}
                {!! $errors->first('telefonos', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('linkWeb') ? ' has-error' : '' }}">
                {!! Form::label('linkWeb', 'URL Sitio Web (Opcional)') !!}
                {!! Form::text('linkWeb', $informacion->linkWeb, ['class' => 'form-control', 'placeholder' => 'URL Sitio Web']) !!}
                {!! $errors->first('linkWeb', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('linkFacebook') ? ' has-error' : '' }}">
                {!! Form::label('linkFacebook', 'URL Perfil de Facebook (Opcional)') !!}
                {!! Form::text('linkFacebook', $informacion->linkFacebook, ['class' => 'form-control', 'placeholder' => 'URL Perfil de Facebook']) !!}
                {!! $errors->first('linkFacebook', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('linkTwitter') ? ' has-error' : '' }}">
                {!! Form::label('linkTwitter', 'URL Perfil de Twitter (Opcional)') !!}
                {!! Form::text('linkTwitter', $informacion->linkTwitter, ['class' => 'form-control', 'placeholder' => 'URL Perfil de Twitter']) !!}
                {!! $errors->first('linkTwitter', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('linkYoutube') ? ' has-error' : '' }}">
                {!! Form::label('linkYoutube', 'URL Canal de Youtube (Opcional)') !!}
                {!! Form::text('linkYoutube', $informacion->linkYoutube, ['class' => 'form-control', 'placeholder' => 'URL Canal de Youtube']) !!}
                {!! $errors->first('linkYoutube', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('linkInstagram') ? ' has-error' : '' }}">
                {!! Form::label('linkInstagram', 'URL Perfil de Instagram (Opcional)') !!}
                {!! Form::text('linkInstagram', $informacion->linkInstagram, ['class' => 'form-control', 'placeholder' => 'URL Perfil de Instagram']) !!}
                {!! $errors->first('linkInstagram', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('infoAdicional') ? ' has-error' : '' }}">
                {!! Form::label('infoAdicional', 'Información Adicional (Opcional)') !!}
                {!! Form::textarea('infoAdicional', $informacion->infoAdicional, ['class' => 'form-control', 'placeholder' => 'Información Adicional', 'rows' => '3']) !!}
                {!! $errors->first('infoAdicional', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('path') ? ' has-error' : '' }}">
                {!! Form::label("path", 'Logo del Establecimiento') !!}
                {!! Form::file('path', ['class' => 'form-control']) !!}
                <small class='text-muted'>Se recomienda un ancho de imagen de aproximadamente 600 píxeles y con forma rectangular</small>
                {!! $errors->first('path', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <?php 
                $urlImg = "logo/".$informacion->path;
            ?>
            <img src="{{ asset($urlImg) }}" alt="" style="width:50%;">
        </div>
    </div>

</div>