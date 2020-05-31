<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acompanantes__identificacion", 'Identificación') !!}
            {!! Form::text('acompanantes__identificacion', null, ['class' => 'form-control', 'placeholder' => 'Identificación', 'id' => 'acompanantes__identificacion']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acompanantes__tipoId", 'Tipo de identificación') !!}
            {!! Form::select('acompanantes__tipoId', ['' => '----------', 'CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], null, ['class' => 'form-control', 'id' => 'acompanantes__tipoId']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acompanantes__nombres", 'Nombres') !!}
            {!! Form::text('acompanantes__nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres', 'id' => 'acompanantes__nombres']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acompanantes__apellidos", 'Apellidos') !!}
            {!! Form::text('acompanantes__apellidos', null, ['class' => 'form-control', 'placeholder' => 'Apellidos', 'id' => 'acompanantes__apellidos']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("nuevo_parentesco", 'Parentesco') !!}
            {!! Form::text('nuevo_parentesco', null, ['class' => 'form-control', 'placeholder' => 'Parentesco', 'id' => 'nuevo_parentesco']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acompanantes__telefonoFijo", 'Teléfono Fijo') !!}
            {!! Form::text('acompanantes__telefonoFijo', null, ['class' => 'form-control', 'placeholder' => 'Teléfono Fijo', 'id' => 'acompanantes__telefonoFijo']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acompanantes__telefonoCelular", 'Teléfono Celular') !!}
            {!! Form::text('acompanantes__telefonoCelular', null, ['class' => 'form-control', 'placeholder' => 'Teléfono Celular', 'id' => 'acompanantes__telefonoCelular']) !!}
        </div>
    </div>
</div>