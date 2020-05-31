<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('identificacion') ? ' has-error' : '' }}">
                {!! Form::label("identificacion", 'Identificación') !!}
                {!! Form::text('identificacion', $paciente->identificacion, ['class' => 'form-control', 'placeholder' => 'Identificación', 'id' => 'identificacion']) !!}
                {!! $errors->first('identificacion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('tipoId') ? ' has-error' : '' }}">
                {!! Form::label('tipoId', 'Tipo de identificación') !!}
                {!! Form::select('tipoId', ['' => '----------', 'CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], $paciente->tipoId, ['class' => 'form-control']) !!}
                {!! $errors->first('tipoId', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
                {!! Form::label('nombres', 'Nombres') !!}
                {!! Form::text('nombres', $paciente->nombres, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
                {!! $errors->first('nombres', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
                {!! Form::label('apellidos', 'Apellidos') !!}
                {!! Form::text('apellidos', $paciente->apellidos, ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
                {!! $errors->first('apellidos', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('fechaNacimiento') ? ' has-error' : '' }}">
                {!! Form::label("fechaNacimiento", 'Fecha de Nacimiento') !!}
                {!! Form::text('fechaNacimiento', $paciente->fechaNacimiento, ['class' => 'datepickermax form-control', 'placeholder' => 'Seleccione una fecha...']) !!}
                {!! $errors->first('fechaNacimiento', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('genero') ? ' has-error' : '' }}">
                {!! Form::label("genero", 'Género') !!}
                {!! Form::select('genero', ['' => '----------', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino', 'Otro' => 'Otro'], $paciente->genero, ['class' => 'form-control']) !!}
                {!! $errors->first('genero', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('hijos') ? ' has-error' : '' }}">
                {!! Form::label("hijos", 'Hijos') !!}
                {!! Form::select('hijos', ['' => '----------', 1 => 'Si', 0 => 'No'], $paciente->hijos, ['class' => 'form-control']) !!}
                {!! $errors->first('hijos', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('estadoCivil') ? ' has-error' : '' }}">
                {!! Form::label("estadoCivil", 'Estado Civil') !!}
                {!! Form::select('estadoCivil', ['' => '----------', 'Soltero(a)' => 'Soltero(a)', 'Viudo(a)' => 'Viudo(a)', 'Casado(a)' => 'Casado(a)', 'Unión Libre' => 'Unión Libre', 'Divorciado' => 'Divorciado'], $paciente->estadoCivil, ['class' => 'form-control']) !!}
                {!! $errors->first('estadoCivil', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('telefonoFijo') ? ' has-error' : '' }}">
                {!! Form::label("telefonoFijo", 'Teléfono fijo (Opcional si ingresa celular)') !!}
                {!! Form::text('telefonoFijo', $paciente->telefonoFijo, ['class' => 'form-control', 'placeholder' => 'Teléfono fijo']) !!}
                {!! $errors->first('telefonoFijo', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('telefonoCelular') ? ' has-error' : '' }}">
                {!! Form::label("telefonoCelular", 'Teléfono celular (Opcional si ingresa fijo)') !!}
                {!! Form::text('telefonoCelular', $paciente->telefonoCelular, ['class' => 'form-control', 'placeholder' => 'Teléfono celular']) !!}
                {!! $errors->first('telefonoCelular', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('ciudad_id') ? ' has-error' : '' }}">
                {!! Form::label("ciudad_id", 'Ciudad') !!}
                {!! Form::text('ciudadId', $paciente->ciudad->nombre." (".$paciente->ciudad->departamento->nombre.")", ['class' => 'form-control', 'placeholder' => 'Escriba la ciudad...', 'id' => 'ciudadId', 'style' => 'background-color:#F5F5F5']) !!}
                {!! Form::hidden('ciudad_id', $paciente->ciudad_id, ['id' => 'ciudad_id']) !!}
                {!! $errors->first("ciudad_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('direccion') ? ' has-error' : '' }}">
                {!! Form::label('direccion', 'Dirección') !!}
                {!! Form::text('direccion', $paciente->direccion, ['class' => 'form-control', 'placeholder' => 'Dirección']) !!}
                {!! $errors->first('direccion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('ubicacion') ? ' has-error' : '' }}">
                {!! Form::label("ubicacion", 'Ubicación') !!}
                {!! Form::select('ubicacion', ['' => '----------', 'Rural' => 'Rural', 'Urbano' => 'Urbano'], $paciente->ubicacion, ['class' => 'form-control']) !!}
                {!! $errors->first('ubicacion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label("email", 'Correo Eléctronico (Opcional Deseable)') !!}
                <?php 
                    $email = '';
                    if($paciente->email != "fakermail999@999.com"){
                        $email = $paciente->email;
                    }
                ?>
                {!! Form::text('email', $email, ['class' => 'form-control', 'placeholder' => 'Correo Eléctronico']) !!}
                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('eps_id') ? ' has-error' : '' }}">
                {!! Form::label("eps_id", 'EPS') !!}
                {!! Form::text('epsId', $paciente->eps->nombre, ['class' => 'form-control', 'placeholder' => 'Escriba la EPS...', 'id' => 'epsId', 'style' => 'background-color:#F5F5F5']) !!}
                {!! Form::hidden('eps_id', $paciente->eps_id, ['id' => 'eps_id']) !!}
                {!! $errors->first("eps_id", '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('ocupacion') ? ' has-error' : '' }}">
                {!! Form::label('ocupacion', 'Ocupación') !!}
                {!! Form::text('ocupacion', $paciente->ocupacion, ['class' => 'form-control', 'placeholder' => 'Ocupación']) !!}
                {!! $errors->first('ocupacion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>