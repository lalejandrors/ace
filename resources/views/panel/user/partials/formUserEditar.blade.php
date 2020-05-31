<div id="responsive-modal-edit" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="width: 90%; float: left;">Edición del Usuario</h4>
                <div id="cargando" style="display: none; width: 10%; float: left;">
                    <img src="{{ asset('images/loading.gif') }}" style="width: 35px; height: 35px;"/>
                </div>
            </div>
            <div class="modal-body">
                
                <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
                    <ul id="msj"></ul>
                </div>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                <input type="hidden" name="usuarioId" id="usuarioId" value="">

                <input type="hidden" name="currentUserId" id="currentUserId" value="{{ Auth::user()->id }}">

                {{-- @if(Auth::user()->id == $user->id) --}}
                    <div id="formUserEditar">    
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('nombres', 'Nombres') !!}
                                    {!! Form::text('nombres', null, ['class' => 'form-control', 'placeholder' => 'Nombres']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('apellidos', 'Apellidos') !!}
                                    {!! Form::text('apellidos', null, ['class' => 'form-control', 'placeholder' => 'Apellidos']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('tipoId', 'Tipo de identificación') !!}
                                    {!! Form::select('tipoId', ['' => '----------', 'CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], null, ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label("identificacion", 'Identificación') !!}
                                    {!! Form::text('identificacion', null, ['class' => 'form-control', 'placeholder' => 'Identificación']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label("telefonoFijo", 'Teléfono fijo  (Opcional si ingresa celular)') !!}
                                    {!! Form::text('telefonoFijo', null, ['class' => 'form-control', 'placeholder' => 'Teléfono fijo']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label("telefonoCelular", 'Teléfono celular (Opcional si ingresa fijo)') !!}
                                    {!! Form::text('telefonoCelular', null, ['class' => 'form-control', 'placeholder' => 'Teléfono celular']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label("username", 'Nombre de usuario') !!}
                                    {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Nombre de usuario']) !!}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    {!! Form::label('password', 'Contraseña (Opcional si se desea cambiar)') !!}
                                    <div class="input-group">
                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Contraseña', 'id' => 'password']) !!}
                                        <span class="input-group-btn">
                                            <button id= "show_password" class="btn btn-secondary" type="button">
                                                <i class="eye fa fa-eye-slash" aria-hidden="true"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>
                    </div>
                {{-- @endif --}}

                {{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}
                {{-- @if($user->perfil_id == 1 || $user->perfil_id == 2) --}}
                    <div id="formMedicoEditar">    
                        @include('panel.user.partials.formMedicoEditar')
                        <br><br>
                    </div>
                {{-- @endif --}}

                {{-- @if(Auth::user()->perfil_id == 1 && $user->perfil_id == 3) --}} 
                    <div class="row" id="listadoMedicosEditar">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label('medicosAsociados', 'Médicos asociados') !!}
                                {!! Form::select('medicosAsociados[]', [], null, ['class' => 'form-control', 'id' => 'medicosAsociados', 'placeholder' => 'Selecciona uno o varios médicos...', 'multiple']) !!}
                                <br><br>
                            </div>
                        </div>
                    </div>
                {{-- @endif --}}
                {{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}{{-- extras --}}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
                {!! link_to('#', $title="Editar", $attributes = ['id' => 'edicion', 'class' => 'btn btn-primary'], $secure = null) !!}
            </div>
        </div>
    </div>
</div>