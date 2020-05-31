<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("especialidad", 'Especialidad') !!}
                {!! Form::text('especialidad', null, ['class' => 'form-control', 'placeholder' => 'Especialidad']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("registroMedico", 'Registro Médico') !!}
                {!! Form::text('registroMedico', null, ['class' => 'form-control', 'placeholder' => 'Registro Médico']) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label("email", 'Correo Eléctronico') !!}
                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Correo Eléctronico']) !!}
            </div>
        </div>
    </div>

</div>