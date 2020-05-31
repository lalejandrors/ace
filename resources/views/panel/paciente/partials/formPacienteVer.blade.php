<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[identificacion]", 'Identificación') !!}
                {!! Form::text('pacientes[identificacion]', $paciente->identificacion, ['class' => 'form-control', 'id' => 'identificacion', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('pacientes[tipoId]', 'Tipo de identificación') !!}
                {!! Form::select('pacientes[tipoId]', ['CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], $paciente->tipoId, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('pacientes[nombres]', 'Nombres') !!}
                {!! Form::text('pacientes[nombres]', $paciente->nombres, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('pacientes[apellidos]', 'Apellidos') !!}
                {!! Form::text('pacientes[apellidos]', $paciente->apellidos, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[fechaNacimiento]", 'Fecha de Nacimiento') !!}
                {!! Form::text('pacientes[fechaNacimiento]', $paciente->fechaNacimiento, ['class' => 'datepickermax form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[genero]", 'Género') !!}
                {!! Form::select('pacientes[genero]', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino', 'Otro' => 'Otro'], $paciente->genero, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[hijos]", 'Hijos') !!}
                {!! Form::select('pacientes[hijos]', [1 => 'Si', 0 => 'No'], $paciente->hijos, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[estadoCivil]", 'Estado Civil') !!}
                {!! Form::select('pacientes[estadoCivil]', ['Soltero(a)' => 'Soltero(a)', 'Viudo(a)' => 'Viudo(a)', 'Casado(a)' => 'Casado(a)', 'Unión Libre' => 'Unión Libre', 'Divorciado' => 'Divorciado'], $paciente->estadoCivil, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[telefonoFijo]", 'Teléfono fijo') !!}
                {!! Form::text('pacientes[telefonoFijo]', $paciente->telefonoFijo, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[telefonoCelular]", 'Teléfono celular') !!}
                {!! Form::text('pacientes[telefonoCelular]', $paciente->telefonoCelular, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[ciudad_id]", 'Ciudad') !!}
                {!! Form::text('pacientes[ciudad_id]', $paciente->ciudad->nombre." (".$paciente->ciudad->departamento->nombre.")", ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('pacientes[direccion]', 'Dirección') !!}
                {!! Form::text('pacientes[direccion]', $paciente->direccion, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[ubicacion]", 'Ubicación') !!}
                {!! Form::select('pacientes[ubicacion]', ['Rural' => 'Rural', 'Urbano' => 'Urbano'], $paciente->ubicacion, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[email]", 'Correo Eléctronico') !!}
                {!! Form::text('pacientes[email]', $paciente->email, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("pacientes[eps_id]", 'EPS') !!}
                {!! Form::text('pacientes[eps_id]', $paciente->eps->nombre, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('pacientes[ocupacion]', 'Ocupación') !!}
                {!! Form::text('pacientes[ocupacion]', $paciente->ocupacion, ['class' => 'form-control', 'disabled']) !!}
            </div>
        </div>
    </div>

</div>