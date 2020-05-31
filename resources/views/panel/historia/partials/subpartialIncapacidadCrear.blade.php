<div class="box-body">

    <h3 style="color: #3097d1;">Crear Incapacidad Médica</h3>
    <p>Todos los campos son requeridos excepto "Observación".</p>
    
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('incapacidades__fechaFin', 'Fecha Final Incapacidad') !!}
                {!! Form::text('incapacidades__fechaFin', null, ['class' => 'datepickermin form-control', 'id' => 'incapacidades__fechaFin', 'placeholder' => 'Seleccione una fecha...']) !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::label('incapacidades__observacion', 'Observación (Opcional)') !!}
                {!! Form::textarea('incapacidades__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'incapacidades__observacion']) !!}
            </div>
        </div>
    </div>
    
</div>