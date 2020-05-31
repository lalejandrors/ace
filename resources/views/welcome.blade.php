@extends('layouts.principal')

    @section('titulo','Ace Software Médico')

    @section('css')
    @endsection

    @section('contenido')
        <img alt="Brand" src="{{ asset("images/welcome.png") }}" style="display: block;margin: 0 auto;width: 70%;height: auto;">

        <form class="form-horizontal" role="form" method="POST" action="{{ route('panel.user.bienvenido') }}">
            {{ csrf_field() }}
            
            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
                <label for="username" class="col-xs-3 col-sm-4 col-md-4 control-label">Usuario</label>
                <div class="col-xs-9 col-sm-6 col-md-6">
                    <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}">
                    @if ($errors->has('username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('username') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-xs-3 col-sm-4 col-md-4 control-label">Contraseña</label>
                <div class="col-xs-9 col-sm-6 col-md-6">
                    <input id="password" type="password" class="form-control" name="password">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-xs-3 col-sm-4 col-md-4 control-label"></label>
                <div class="col-xs-9 col-sm-6 col-md-6">
                    <button type="submit" class="btn btn-primary form-control">
                        Ingresar
                    </button>
                </div>
            </div>
        </form>
    @endsection

    @section('js')
    @endsection
