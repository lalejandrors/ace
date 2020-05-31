 <div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acom_identificacion", 'Identificación') !!}
            {!! Form::text('acom_identificacion', null, ['class' => 'form-control', 'id' => 'acom_identificacion', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acom_tipoId", 'Tipo de Identificación') !!}
            {!! Form::text('acom_tipoId', null, ['class' => 'form-control', 'id' => 'acom_tipoId', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acom_nombres", 'Nombres') !!}
            {!! Form::text('acom_nombres', null, ['class' => 'form-control', 'id' => 'acom_nombres', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acom_apellidos", 'Apellidos') !!}
            {!! Form::text('acom_apellidos', null, ['class' => 'form-control', 'id' => 'acom_apellidos', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("existente_parentesco", 'Parentesco') !!}
            {!! Form::text('existente_parentesco', null, ['class' => 'form-control', 'placeholder' => 'Parentesco', 'id' => 'existente_parentesco']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acom_telefonoFijo", 'Teléfono Fijo') !!}
            {!! Form::text('acom_telefonoFijo', null, ['class' => 'form-control', 'id' => 'acom_telefonoFijo', 'readonly' => 'true']) !!}
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            {!! Form::label("acom_telefonoCelular", 'Teléfono Celular') !!}
            {!! Form::text('acom_telefonoCelular', null, ['class' => 'form-control', 'id' => 'acom_telefonoCelular', 'readonly' => 'true']) !!}
        </div>
    </div>
</div>