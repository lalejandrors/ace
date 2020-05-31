<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_identificacion", 'Identificación') !!}
            {!! Form::text('paci_identificacion', null, ['class' => 'form-control', 'id' => 'paci_identificacion', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('paci_tipoId', 'Tipo de identificación') !!}
            {!! Form::text('paci_tipoId', null, ['class' => 'form-control', 'id' => 'paci_tipoId', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('paci_nombres', 'Nombres') !!}
            {!! Form::text('paci_nombres', null, ['class' => 'form-control', 'id' => 'paci_nombres', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('paci_apellidos', 'Apellidos') !!}
            {!! Form::text('paci_apellidos', null, ['class' => 'form-control', 'id' => 'paci_apellidos', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_edad", 'Edad') !!}
            {!! Form::text('paci_edad', null, ['class' => 'form-control', 'id' => 'paci_edad', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_genero", 'Género') !!}
            {!! Form::text('paci_genero', null, ['class' => 'form-control', 'id' => 'paci_genero', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_hijos", 'Hijos') !!}
            {!! Form::text('paci_hijos', null, ['class' => 'form-control', 'id' => 'paci_hijos', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_estadoCivil", 'Estado Civil') !!}
            {!! Form::text('paci_estadoCivil', null, ['class' => 'form-control', 'id' => 'paci_estadoCivil', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_telefonoFijo", 'Teléfono fijo') !!}
            {!! Form::text('paci_telefonoFijo', null, ['class' => 'form-control', 'id' => 'paci_telefonoFijo', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_telefonoCelular", 'Teléfono celular') !!}
            {!! Form::text('paci_telefonoCelular', null, ['class' => 'form-control', 'id' => 'paci_telefonoCelular', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_ciudad_id", 'Ciudad') !!}
            {!! Form::text('paci_ciudad_id', null, ['class' => 'form-control', 'id' => 'paci_ciudad_id', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('paci_direccion', 'Dirección') !!}
            {!! Form::text('paci_direccion', null, ['class' => 'form-control', 'id' => 'paci_direccion', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_ubicacion", 'Ubicación') !!}
            {!! Form::text('paci_ubicacion', null, ['class' => 'form-control', 'id' => 'paci_ubicacion', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_email", 'Correo Eléctronico') !!}
            {!! Form::text('paci_email', null, ['class' => 'form-control', 'id' => 'paci_email', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("paci_eps_id", 'EPS') !!}
            {!! Form::text('paci_eps_id', null, ['class' => 'form-control', 'id' => 'paci_eps_id', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label('paci_ocupacion', 'Ocupación') !!}
            {!! Form::text('paci_ocupacion', null, ['class' => 'form-control', 'id' => 'paci_ocupacion', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>