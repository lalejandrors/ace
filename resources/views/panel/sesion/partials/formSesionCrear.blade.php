<div class="box-body">

    <p>Los campos obligatorios estarán con un color rosa. Son los campos mínimos para registrar una sesión de un tratamiento, además del paciente.</p>

    <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
        <ul id="msj"></ul>
    </div>

    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    <h2 id="numeroSesion" style="display: none; color: #f96c0d;"></h2>
    {{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}
    <h3 style="color: #24b4b5;">Datos Básicos del Paciente</h3>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group" id="paciente_id">
                {!! Form::label("sesiones__paciente_id", 'Paciente') !!}
                {!! Form::text('pacienteId', null, ['class' => 'form-control', 'placeholder' => 'Nombre o documento del paciente...', 'id' => 'pacienteId', 'style' => 'background-color:#FFF5F5']) !!}
                {!! Form::hidden('sesiones__paciente_id', null, ['id' => 'sesiones__paciente_id']) !!}
            </div>
        </div>
        <div class="col-sm-6">    
            <div class="form-group" id="tratamiento_id">
                {!! Form::label("sesiones__tratamiento_id", 'Tratamiento') !!}
                {!! Form::text('tratamientoId', null, ['class' => 'form-control', 'placeholder' => 'Nombre del tratamiento...', 'id' => 'tratamientoId', 'style' => 'background-color:#FFF5F5', 'disabled' => 'disabled']) !!}
                {!! Form::hidden('sesiones__tratamiento_id', null, ['id' => 'sesiones__tratamiento_id']) !!}
            </div>
        </div>
    </div>

    @include('panel.historia.partials.subpartialPacienteVer')

    {{-- ACOMPANANTES --}}{{-- ACOMPANANTES --}}{{-- ACOMPANANTES --}}{{-- ACOMPANANTES --}}{{-- ACOMPANANTES --}}{{-- ACOMPANANTES --}}
    <h4>Acompañante</h4>
    <p>Tener presente que el registro de acompañante es opcional. En caso de que se desee registrar, todos sus campos son obligatorios.</p>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                {!! Form::checkbox('acompananteExistenteCheck', 1, null, ['id' => 'acompananteExistenteCheck']) !!}
                {!! Form::label('acompananteExistenteCheck', 'Acompañante Existente') !!}
            </div>
        </div>
    </div>

    <div class="row" id="formAcompananteExistente" style="display: none;">
        <div class="col-md-12">
       
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" id="acompanante_id">
                        {!! Form::text('acompananteId', null, ['class' => 'form-control', 'placeholder' => 'Nombre o documento del acompañante...', 'id' => 'acompananteId', 'style' => 'background-color:#F5F5F5']) !!}
                        {!! Form::hidden('sesiones__acompanante_id', null, ['id' => 'sesiones__acompanante_id']) !!}
                    </div>
                </div>
            </div>

           @include('panel.historia.partials.subpartialAcompananteVer')

        </div>
    </div>

    <div class="row" id="formAcompanante">
        <div class="col-md-12">
       
            @include('panel.historia.partials.subpartialAcompananteCrear')

        </div>
    </div>

    <br>

    {{-- ACCORDION --}}{{-- ACCORDION --}}{{-- ACCORDION --}}{{-- ACCORDION --}}{{-- ACCORDION --}}{{-- ACCORDION --}}
    <h3 style="color: #24b4b5;">Diagnósticos</h3>
    <p>Los diagnósticos solo son requeridos en caso que se desee registrar una formula médica, una formulación de tratamiento o una incapacidad médica.</p>
    {{-- Aca generamos los cie10 dinamicamente --}}
    <button class="btn btn-success btnAgregarDiagnostico">Agregar Diagnóstico</button>
    {!! Form::hidden('numeroDiagnosticos', 1, ['id' => 'numeroDiagnosticos']) !!}

    <table class="table table-bordered table-hover table-striped tabla_diagnosticos" style="margin-top: 30px;">
        <thead>
            <tr>
                <th>Diagnóstico</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody class="diagnosticosConjunto">
            <tr>
                <td>
                    <div class="form-group">
                        <input id="diagnostico1" type="text" class="form-control" placeholder="Nombre o código cie10 de la patología"/>
                        <input id="diagnostico_id1" type="hidden"/>
                    </div>
                </td>
                <td class="quitar_diagnostico">
                    <a href="#" style="display: block;text-align: center;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>
                </td>
            </tr>
        </tbody>
    </table>
    <br>

    <h3 style="color: #24b4b5;">Observaciones</h3>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label("sesiones__observacion", 'Observaciones') !!}
                {!! Form::textarea('sesiones__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observaciones', 'rows' => '5', 'id' => 'sesiones__observacion', 'style' => 'background-color:#FFF5F5']) !!}
            </div>
        </div>
    </div>

</div>