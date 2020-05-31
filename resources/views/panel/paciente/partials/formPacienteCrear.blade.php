<div id="responsive-modal-create" class="modal fade" tabindex="-1" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="width: 90%; float: left;">Registro de Nuevo Paciente</h4>
                <div id="cargando" style="display: none; width: 10%; float: left;">
                    <img src="{{ asset('images/loading.gif') }}" style="width: 35px; height: 35px;"/>
                </div>
            </div>
            <div class="modal-body">
                
                <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
                    <ul id="msj"></ul>
                </div>

                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("identificacion", 'Identificación') !!}
                            {!! Form::text('identificacion', null, ['class' => 'form-control', 'placeholder' => 'Identificación', 'id' => 'identificacion']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('tipoId', 'Tipo de identificación') !!}
                            {!! Form::select('tipoId', ['' => '----------', 'CC (Cédula de ciudadanía)' => 'CC (Cédula de ciudadanía)', 'CE (Cédula de extranjería)' => 'CE (Cédula de extranjería)', 'PA (Pasaporte)' => 'PA (Pasaporte)', 'RC (Registro civil)' => 'RC (Registro civil)', 'TI (Tarjeta de identidad)' => 'TI (Tarjeta de identidad)'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

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
                            {!! Form::label("fechaNacimiento", 'Fecha de Nacimiento') !!}
                            {!! Form::text('fechaNacimiento', null, ['class' => 'datepickermax form-control', 'placeholder' => 'Seleccione una fecha...']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("genero", 'Género') !!}
                            {!! Form::select('genero', ['' => '----------', 'Masculino' => 'Masculino', 'Femenino' => 'Femenino', 'Otro' => 'Otro'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("hijos", 'Hijos') !!}
                            {!! Form::select('hijos', ['' => '----------', 1 => 'Si', 0 => 'No'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("estadoCivil", 'Estado Civil') !!}
                            {!! Form::select('estadoCivil', ['' => '----------', 'Soltero(a)' => 'Soltero(a)', 'Viudo(a)' => 'Viudo(a)', 'Casado(a)' => 'Casado(a)', 'Unión Libre' => 'Unión Libre', 'Divorciado' => 'Divorciado'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("telefonoFijo", 'Teléfono fijo (Opcional si ingresa celular)') !!}
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
                            {!! Form::label("ciudad_id", 'Ciudad') !!}
                            {!! Form::text('ciudadId', null, ['class' => 'form-control', 'placeholder' => 'Escriba la ciudad...', 'id' => 'ciudadId', 'style' => 'background-color:#F5F5F5']) !!}
                            {!! Form::hidden('ciudad_id', null, ['id' => 'ciudad_id']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('direccion', 'Dirección') !!}
                            {!! Form::text('direccion', null, ['class' => 'form-control', 'placeholder' => 'Dirección']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("ubicacion", 'Ubicación') !!}
                            {!! Form::select('ubicacion', ['' => '----------', 'Rural' => 'Rural', 'Urbano' => 'Urbano'], null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("email", 'Correo Eléctronico (Opcional Deseable)') !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Correo Eléctronico']) !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label("eps_id", 'EPS') !!}
                            {!! Form::text('epsId', null, ['class' => 'form-control', 'placeholder' => 'Escriba la EPS...', 'id' => 'epsId', 'style' => 'background-color:#F5F5F5']) !!}
                            {!! Form::hidden('eps_id', null, ['id' => 'eps_id']) !!}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {!! Form::label('ocupacion', 'Ocupación') !!}
                            {!! Form::text('ocupacion', null, ['class' => 'form-control', 'placeholder' => 'Ocupación']) !!}
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" id="cancelar">Cancelar</button>
                {!! link_to('#', $title="Crear", $attributes = ['id' => 'registro', 'class' => 'btn btn-primary'], $secure = null) !!}
            </div>
        </div>
    </div>
</div>