<div id="responsive-modal-view" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="width: 90%; float: left;">Ver Usuario</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('nombres', 'Nombres') !!}
                            {!! Form::text('nombres', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('apellidos', 'Apellidos') !!}
                            {!! Form::text('apellidos', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('tipoId', 'Tipo de identificación') !!}
                            {!! Form::select('tipoId', ['CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("identificacion", 'Identificación') !!}
                            {!! Form::text('identificacion', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("telefonoFijo", 'Teléfono fijo') !!}
                            {!! Form::text('telefonoFijo', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("telefonoCelular", 'Teléfono celular') !!}
                            {!! Form::text('telefonoCelular', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("username", 'Nombre de usuario') !!}
                            {!! Form::text('username', null, ['class' => 'form-control', 'disabled']) !!}
                        </div>
                    </div>
                    {{-- @if($user->perfil_id != 1) --}}
                        <div id="estadoVer">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('activo', 'Estado del usuario') !!}
                                    {!! Form::select('activo', ['0' => 'Inactivo', '1' => 'Activo'], null, ['class' => 'form-control', 'disabled']) !!}
                                </div>
                            </div>
                        </div>
                    {{-- @endif --}}
                </div>
                <br><br>

                {{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}
                {{-- @if($user->perfil_id == 1 || $user->perfil_id == 2) --}}
                    <div id="formMedicoVer">
                        @include('panel.user.partials.formMedicoVer')
                        <br><br>
                    </div>    
                {{-- @endif --}}

                {{-- @if($user->perfil_id == 3) --}}
                    <div id="listadoMedicosVer">  
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('medicosAsociados', 'Médicos asociados') !!}
                                    {!! Form::select('medicosAsociados[]', [], null, ['class' => 'form-control', 'id' => 'medicosAsociados', 'placeholder' => 'Selecciona uno o varios médicos...', 'multiple', 'disabled']) !!}
                                    <br><br>
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- @endif --}}
                {{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Volver</button>
            </div>
        </div>
    </div>
</div>