<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('nombre') ? ' has-error' : '' }}">
                {!! Form::label("nombre", 'Nombre') !!}
                {!! Form::text('nombre', Input::old('nombre'), ['class' => 'form-control', 'placeholder' => 'Un nombre descriptivo de la copia']) !!}
                {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('descripcion') ? ' has-error' : '' }}">
                {!! Form::label('descripcion', 'Descripción (Opcional)') !!}
                {!! Form::textarea('descripcion', Input::old('descripcion'), ['class' => 'form-control', 'placeholder' => 'Una descripción si se desea detallada de la copia', 'rows' => '3']) !!}
                {!! $errors->first('descripcion', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>