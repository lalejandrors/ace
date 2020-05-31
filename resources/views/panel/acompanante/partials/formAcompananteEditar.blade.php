<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('identificacion') ? ' has-error' : '' }}">
                {!! Form::label("identificacion", 'Identificación') !!}
                {!! Form::text('identificacion', $acompanante->identificacion, ['class' => 'form-control', 'placeholder' => 'Identificación', 'id' => 'identificacion']) !!}
                {!! $errors->first('identificacion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('tipoId') ? ' has-error' : '' }}">
                {!! Form::label('tipoId', 'Tipo de identificación') !!}
                {!! Form::select('tipoId', ['CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], $acompanante->tipoId, ['class' => 'form-control', 'placeholder' => '----------']) !!}
                {!! $errors->first('tipoId', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
                {!! Form::label('nombres', 'Nombres') !!}
                {!! Form::text('nombres', $acompanante->nombres, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
                {!! $errors->first('nombres', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                {!! Form::label('apellidos', 'Apellidos') !!}
                {!! Form::text('apellidos', $acompanante->apellidos, ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
                {!! $errors->first('apellidos', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('telefonoFijo') ? ' has-error' : '' }}">
                {!! Form::label("telefonoFijo", 'Teléfono fijo (Opcional si ingresa celular)') !!}
                {!! Form::text('telefonoFijo', $acompanante->telefonoFijo, ['class' => 'form-control', 'placeholder' => 'Teléfono fijo']) !!}
                {!! $errors->first('telefonoFijo', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('telefonoCelular') ? ' has-error' : '' }}">
                {!! Form::label("telefonoCelular", 'Teléfono celular (Opcional si ingresa fijo)') !!}
                {!! Form::text('telefonoCelular', $acompanante->telefonoCelular, ['class' => 'form-control', 'placeholder' => 'Teléfono celular']) !!}
                {!! $errors->first('telefonoCelular', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>