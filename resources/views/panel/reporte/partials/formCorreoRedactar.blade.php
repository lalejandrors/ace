<div class="box-body">

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('formatoId') ? ' has-error' : '' }}">
                {!! Form::label('formatoId', 'Escoja un formato') !!}
                {!! Form::select('formatoId', $formatos, null, ['class' => 'form-control', 'placeholder' => '----------', 'id' => 'formatoId']) !!}
                {!! $errors->first('formatoId', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group{{ $errors->has('contenido') ? ' has-error' : '' }}">
                {!! Form::label('contenido', 'Contenido') !!}
                {!! Form::textarea('contenido', Input::old('contenido'), ['class' => 'form-control', 'id' => 'contenido']) !!}
                {!! $errors->first('contenido', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group{{ $errors->has('asunto') ? ' has-error' : '' }}">
                {!! Form::label('asunto', 'Asunto') !!}
                {!! Form::text('asunto', Input::old('asunto'), ['class' => 'form-control', 'placeholder' => 'Asunto del correo', 'id' => 'asunto']) !!}
                {!! $errors->first('asunto', '<span class="help-block">:message</span>') !!}
            </div>
        </div>
    </div>

</div>