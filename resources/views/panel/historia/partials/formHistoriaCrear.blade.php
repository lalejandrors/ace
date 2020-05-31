<div class="box-body">

    <p>Los campos obligatorios estarán con un color rosa. Son los campos mínimos para registrar una historia, además del paciente.</p>

    <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
        <ul id="msj"></ul>
    </div>

    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    {{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}
    <h3 style="color: #24b4b5;">Datos Básicos del Paciente</h3>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group" id="paciente_id">
                {!! Form::label("historias__paciente_id", 'Paciente') !!}
                {!! Form::text('pacienteId', null, ['class' => 'form-control', 'placeholder' => 'Nombre o documento del paciente...', 'id' => 'pacienteId', 'style' => 'background-color:#FFF5F5']) !!}
                {!! Form::hidden('historias__paciente_id', null, ['id' => 'historias__paciente_id']) !!}
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
                        {!! Form::hidden('historias__acompanante_id', null, ['id' => 'historias__acompanante_id']) !!}
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
    <h3 style="color: #24b4b5;">Secciones de la Historia</h3>
    <div class="panel-group" id="accordion">
        {{-- ANTECEDENTES --}}{{-- ANTECEDENTES --}}{{-- ANTECEDENTES --}}{{-- ANTECEDENTES --}}{{-- ANTECEDENTES --}}{{-- ANTECEDENTES --}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">1. Antecedentes</a></h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <h4 style="color: #f96c0d;">a) Heredo Familiares</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoDiabetes", 'Diabetes') !!}
                                {!! Form::textarea('historias__parentescoDiabetes', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con diabetes', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoDiabetes']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoHipertension", 'Hipertensión') !!}
                                {!! Form::textarea('historias__parentescoHipertension', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con hipertensión', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoHipertension']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoCardiopatia", 'Cardiopatía') !!}
                                {!! Form::textarea('historias__parentescoCardiopatia', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con cardiopatía', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoCardiopatia']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoHepatopatia", 'Hepatopatía') !!}
                                {!! Form::textarea('historias__parentescoHepatopatia', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con hepatopatía', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoHepatopatia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoNefropatia", 'Nefropatía') !!}
                                {!! Form::textarea('historias__parentescoNefropatia', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con nefropatía', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoNefropatia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoEnfermedadesMentales", 'Enf. Mentales') !!}
                                {!! Form::textarea('historias__parentescoEnfermedadesMentales', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con enfermedades mentales', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoEnfermedadesMentales']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoAsma", 'Asma') !!}
                                {!! Form::textarea('historias__parentescoAsma', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con asma', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoAsma']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoCancer", 'Cáncer') !!}
                                {!! Form::textarea('historias__parentescoCancer', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con cancer', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoCancer']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoEnfermedadesAlergicas", 'Enf. Alérgicas') !!}
                                {!! Form::textarea('historias__parentescoEnfermedadesAlergicas', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con enfermedades alérgicas', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoEnfermedadesAlergicas']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoEnfermedadesEndocrinas", 'Enfermedades Endócrinas') !!}
                                {!! Form::textarea('historias__parentescoEnfermedadesEndocrinas', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con enfermedades endocrinas', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoEnfermedadesEndocrinas']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__otrosDescripcion", 'Otras Enfermedades') !!}
                                {!! Form::textarea('historias__otrosDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Otras Enfermedades en la familia', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__otrosDescripcion']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__parentescoOtros", 'Parentesco Otras Enfermedades') !!}
                                {!! Form::textarea('historias__parentescoOtros', null, ['class' => 'form-control', 'placeholder' => 'Perentesco de familiares con esas otras enfermedades', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__parentescoOtros']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">b) Personales Patológicos</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionQuirurgicos", 'Quirúrgicos') !!}
                                {!! Form::textarea('historias__descripcionQuirurgicos', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes quirúrgicos personales', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionQuirurgicos']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionTransfusionales", 'Transfusionales') !!}
                                {!! Form::textarea('historias__descripcionTransfusionales', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes personales de transfusiones', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionTransfusionales']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionAlergias", 'Alergias') !!}
                                {!! Form::textarea('historias__descripcionAlergias', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes personales de alergias', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionAlergias']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionTraumaticos", 'Traumáticos') !!}
                                {!! Form::textarea('historias__descripcionTraumaticos', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes traumáticos personales', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionTraumaticos']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionHospitalizacionesPrevias", 'Hospitalizaciones Previas') !!}
                                {!! Form::textarea('historias__descripcionHospitalizacionesPrevias', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes personales de hospitalizaciones previas', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionHospitalizacionesPrevias']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionAdicciones", 'Adicciones') !!}
                                {!! Form::textarea('historias__descripcionAdicciones', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes personales de adicciones', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionAdicciones']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__descripcionOtros", 'Otros') !!}
                                {!! Form::textarea('historias__descripcionOtros', null, ['class' => 'form-control', 'placeholder' => 'Antecedentes personales de otras patologías', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__descripcionOtros']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">c) Personales No Patológicos</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__bano", 'Baño') !!}
                                {!! Form::select('historias__bano', ['' => '----------', 'Diario' => 'Diario', 'Irregular' => 'Irregular'], null, ['class' => 'form-control', 'id' => 'historias__bano']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__banoDientes", 'Baño de Dientes') !!}
                                {!! Form::select('historias__banoDientes', ['' => '----------', 'Diario' => 'Diario', 'Irregular' => 'Irregular'], null, ['class' => 'form-control', 'id' => 'historias__banoDientes']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__servicioAguaPotable", 'Servicio de Agua Potable') !!}
                                {!! Form::checkbox('historias__servicioAguaPotable', 1, null, ['id' => 'historias__servicioAguaPotable']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__cigarrillosDiarios", 'Cigarrillos Diarios') !!}
                                {!! Form::number('historias__cigarrillosDiarios', null, ['class' => 'form-control', 'id' => 'historias__cigarrillosDiarios', 'placeholder' => 'Cigarrillos Diarios', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__anosFumando", 'Años Fumando') !!}
                                {!! Form::number('historias__anosFumando', null, ['class' => 'form-control', 'id' => 'historias__anosFumando', 'placeholder' => 'Años Fumando', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__alcoholismoFrecuencia", 'Alcoholismo Frecuencia') !!}
                                {!! Form::textarea('historias__alcoholismoFrecuencia', null, ['class' => 'form-control', 'placeholder' => 'Alcoholismo Frecuencia', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__alcoholismoFrecuencia']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__comidasDiarias", 'Comidas Diarias') !!}
                                {!! Form::number('historias__comidasDiarias', null, ['class' => 'form-control', 'id' => 'historias__comidasDiarias', 'placeholder' => 'Comidas Diarias', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__calidadComida", 'Calidad de la Comida') !!}
                                {!! Form::textarea('historias__calidadComida', null, ['class' => 'form-control', 'placeholder' => 'Calidad de la Comida', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__calidadComida']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__actividadFisica", 'Actividad Física') !!}
                                {!! Form::textarea('historias__actividadFisica', null, ['class' => 'form-control', 'placeholder' => 'Actividad Física', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__actividadFisica']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__inmunizaciones", 'Inmunizaciones') !!}
                                {!! Form::select('historias__inmunizaciones', ['' => '----------', 'Completas' => 'Completas', 'Pendientes' => 'Pendientes'], null, ['class' => 'form-control', 'id' => 'historias__inmunizaciones']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__inmunizacionesPendientes", 'Inmunizaciones Pendientes') !!}
                                {!! Form::textarea('historias__inmunizacionesPendientes', null, ['class' => 'form-control', 'placeholder' => 'Inmunizaciones Pendientes', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__inmunizacionesPendientes']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__ultimaDesparacitacion", 'Última Desparacitación') !!}
                                {!! Form::textarea('historias__ultimaDesparacitacion', null, ['class' => 'form-control', 'placeholder' => 'Última Desparacitación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__ultimaDesparacitacion']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">d) Gineco – Obstétricos</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__menarca", 'Menarca') !!}
                                {!! Form::textarea('historias__menarca', null, ['class' => 'form-control', 'placeholder' => 'Menarca', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__menarca']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__ritmoMenstrual", 'Ritmo Menstrual') !!}
                                {!! Form::textarea('historias__ritmoMenstrual', null, ['class' => 'form-control', 'placeholder' => 'Ritmo Menstrual', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__ritmoMenstrual']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__dismenorrea", 'Dismenorrea') !!}
                                {!! Form::checkbox('historias__dismenorrea', 1, null, ['id' => 'historias__dismenorrea']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__fum", 'Fecha Última Menstruación') !!}
                                {!! Form::text('historias__fum', null, ['class' => 'datepickermax form-control', 'id' => 'historias__fum', 'placeholder' => 'Seleccione una fecha...']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__ivsa", 'Inicio de Vida Sexual') !!}
                                {!! Form::checkbox('historias__ivsa', 1, null, ['id' => 'historias__ivsa']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__numeroParejas", 'Número de Parejas') !!}
                                {!! Form::number('historias__numeroParejas', null, ['class' => 'form-control', 'id' => 'historias__numeroParejas', 'placeholder' => 'Número de Parejas', 'min' => 0, 'onkeypress' => 'return event.charCode >= 48']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__fpp", 'Fecha Probable de Parto') !!}
                                {!! Form::text('historias__fpp', null, ['class' => 'datepickermin form-control', 'id' => 'historias__fpp', 'placeholder' => 'Seleccione una fecha...']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__fup", 'Fecha Último Parto') !!}
                                {!! Form::text('historias__fup', null, ['class' => 'datepickermax form-control', 'id' => 'historias__fup', 'placeholder' => 'Seleccione una fecha...']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__menopausia", 'Menopausia') !!}
                                {!! Form::checkbox('historias__menopausia', 1, null, ['id' => 'historias__menopausia']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__metodoPlanificacion", 'Método de Planificación') !!}
                                {!! Form::textarea('historias__metodoPlanificacion', null, ['class' => 'form-control', 'placeholder' => 'Método de Planificación', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__metodoPlanificacion']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__citologiaVaginal", 'Citología Vaginal') !!}
                                {!! Form::textarea('historias__citologiaVaginal', null, ['class' => 'form-control', 'placeholder' => 'Citología Vaginal', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__citologiaVaginal']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__examenMamas", 'Examen de Mamas') !!}
                                {!! Form::textarea('historias__examenMamas', null, ['class' => 'form-control', 'placeholder' => 'Examen de Mamas', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__examenMamas']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- PADECIMIENTO ACTUAL--}}{{-- PADECIMIENTO ACTUAL--}}{{-- PADECIMIENTO ACTUAL--}}{{-- PADECIMIENTO ACTUAL--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">2. Padecimiento Actual (1 principio, 2 evolución, 3 estado actual) *</a></h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("historias__padecimientoActual", 'Padecimiento Actual') !!}
                                {!! Form::textarea('historias__padecimientoActual', null, ['class' => 'form-control', 'placeholder' => 'Padecimiento Actual', 'rows' => '5', 'style' => 'background-color:#FFF5F5', 'id' => 'historias__padecimientoActual']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- SINTOMAS GENERALES--}}{{-- SINTOMAS GENERALES--}}{{-- SINTOMAS GENERALES--}}{{-- SINTOMAS GENERALES--}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">3. Síntomas Generales</a></h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__astenia", 'Astenia') !!}
                                {!! Form::checkbox('historias__astenia', 1, null, ['id' => 'historias__astenia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__adinamia", 'Adinamia') !!}
                                {!! Form::checkbox('historias__adinamia', 1, null, ['id' => 'historias__adinamia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__anorexia", 'Anorexia') !!}
                                {!! Form::checkbox('historias__anorexia', 1, null, ['id' => 'historias__anorexia']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__fiebre", 'Fiebre') !!}
                                {!! Form::checkbox('historias__fiebre', 1, null, ['id' => 'historias__fiebre']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__perdidaPeso", 'Pérdida de Peso') !!}
                                {!! Form::checkbox('historias__perdidaPeso', 1, null, ['id' => 'historias__perdidaPeso']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- APARATOS Y SISTEMAS--}}{{-- APARATOS Y SISTEMAS--}}{{-- APARATOS Y SISTEMAS--}}{{-- APARATOS Y SISTEMAS--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse4">4. Interrogatorio por Aparatos y Sistemas</a></h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__aparatoDigestivo", 'Aparato Digestivo') !!}
                                {!! Form::textarea('historias__aparatoDigestivo', null, ['class' => 'form-control', 'placeholder' => 'Halitosis, boca seca, disfagia(odino), pirosis, nausea, vomito, (hematemesis), dolor abd. meteorismo y flatulencias, constipación, diarrea, rectorragia, melena, pujo y tenesmo, Ictericia coluria y acolia, prurito cutáneo.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__aparatoDigestivo']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__aparatoCardiovascular", 'Aparato Cardiovascular') !!}
                                {!! Form::textarea('historias__aparatoCardiovascular', null, ['class' => 'form-control', 'placeholder' => 'Disnea, tos, hemoptisis, dolor precordial, palpitaciones, cianosis, edema y manifestaciones perifericas (acúfenos, fosfenos, síncope, lipotimia, cefalea, etc).', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__aparatoCardiovascular']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__aparatoRespiratorio", 'Aparato Respiratorio') !!}
                                {!! Form::textarea('historias__aparatoRespiratorio', null, ['class' => 'form-control', 'placeholder' => 'Tos, disnea, dolor torácico, hemoptisis, cianosis, vomica, alteraciones de la voz.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__aparatoRespiratorio']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__aparatoUrinario", 'Aparato Urinario') !!}
                                {!! Form::textarea('historias__aparatoUrinario', null, ['class' => 'form-control', 'placeholder' => 'Alteraciones de la micción (poliuria, anuria, polaquiuria, oliguria, nicturia, opsiuria, disuria, tenesmo vesical, urgencia, chorro, enuresis, incontenincia) caracteres de la orina (volumen, olor, color, aspecto) dolor lumbar, edema renal, hipertensión arterial, datos clínicos de anemia.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__aparatoUrinario']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__aparatoGenital", 'Aparato Genital') !!}
                                {!! Form::textarea('historias__aparatoGenital', null, ['class' => 'form-control', 'placeholder' => 'Criptorquidia, fimosis, función sexual. Sangrado genital, flujo o leucorrea, dolor ginecológico, prurito vulvar.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__aparatoGenital']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__aparatoHematologico", 'Aparato Hematológico') !!}
                                {!! Form::textarea('historias__aparatoHematologico', null, ['class' => 'form-control', 'placeholder' => 'Datos clínicos de anemia (palidez, astenia, adinamia y otros), hemorragias, adenopatías, esplenomegalia.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__aparatoHematologico']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__sistemaEndocrino", 'Sistema Endocrino') !!}
                                {!! Form::textarea('historias__sistemaEndocrino', null, ['class' => 'form-control', 'placeholder' => 'Bocio, letargia bradipsiquia (lalia), intol. calor/frio, nerviosismo, hiperquinesis, carac. sexuales, galactorrea, amenorrea, ginecomastia, obesidad, ruborización.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__sistemaEndocrino']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__sistemaOsteomuscular", 'Sistema Osteomuscular') !!}
                                {!! Form::textarea('historias__sistemaOsteomuscular', null, ['class' => 'form-control', 'placeholder' => 'Ganglios, xeroftalmia, xerostomia, fotosensibilidad artralgias/mialgias, Raynaud.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__sistemaOsteomuscular']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__sistemaNervioso", 'Sistema Nervioso') !!}
                                {!! Form::textarea('historias__sistemaNervioso', null, ['class' => 'form-control', 'placeholder' => 'Cefalea, síncope, convulsiones, deficit transitorio, vertigo, confusion y obnub., vigilia/sueño, paralisis y M, marcha y equilibrio, sensibilidad.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__sistemaNervioso']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__sistemaSensorial", 'Sistema Sensorial') !!}
                                {!! Form::textarea('historias__sistemaSensorial', null, ['class' => 'form-control', 'placeholder' => 'Visión, agudeza, borrosa diplopia, fosgenos, dolor ocular, fotofobia, xeroftalmia, amaurosis, otalgia, otorrea y otorragia, hipoacusia, tinitus, olfacción, epistaxis, secreción, Geusis, Garganta (dolor) Fonación.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__sistemaSensorial']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("historias__psicosomatico", 'Psicosomático') !!}
                                {!! Form::textarea('historias__psicosomatico', null, ['class' => 'form-control', 'placeholder' => 'Personalidad, ansiedad, depresión, afectividad, emotividad, amnesia, voluntad, pensamiento, atención, ideación suicida, delirios', 'rows' => '4', 'style' => 'resize:none', 'id' => 'historias__psicosomatico']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TERAPEUTICA ANTERIOR--}}{{-- TERAPEUTICA ANTERIOR--}}{{-- TERAPEUTICA ANTERIOR--}}{{-- TERAPEUTICA ANTERIOR--}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse5">5. Terapéutica Empleada Anteriormente</a></h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("historias__terapeuticaAnterior", 'Terapéutica Anterior') !!}
                                {!! Form::textarea('historias__terapeuticaAnterior', null, ['class' => 'form-control', 'placeholder' => 'Terapéutica Anterior', 'rows' => '5', 'id' => 'historias__terapeuticaAnterior']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- EXPLORACION FISICA--}}{{-- EXPLORACION FISICA--}}{{-- EXPLORACION FISICA--}}{{-- EXPLORACION FISICA--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse6">6. Exploración Física *</a></h4>
            </div>
            <div id="collapse6" class="panel-collapse collapse">
                <div class="panel-body">
                    <h4 style="color: #f96c0d;">a) Signos Vitales</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__ta", 'Tensión Arterial') !!}
                                {!! Form::text('historias__ta', null, ['class' => 'form-control', 'placeholder' => 'Tensión Arterial', 'style' => 'background-color:#FFF5F5', 'id' => 'historias__ta']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__fc", 'Frecuencia Cardíaca') !!}
                                {!! Form::text('historias__fc', null, ['class' => 'form-control', 'placeholder' => 'Frecuencia Cardíaca', 'id' => 'historias__fc']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__fr", 'Frecuencia Respiratoria') !!}
                                {!! Form::text('historias__fr', null, ['class' => 'form-control', 'placeholder' => 'Frecuencia Respiratoria', 'id' => 'historias__fr']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__temp", 'Temperatura Corporal') !!}
                                {!! Form::text('historias__temp', null, ['class' => 'form-control', 'placeholder' => 'Temperatura Corporal', 'id' => 'historias__temp']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__peso", 'Peso') !!}
                                {!! Form::text('historias__peso', null, ['class' => 'form-control', 'placeholder' => 'Peso', 'style' => 'background-color:#FFF5F5', 'id' => 'historias__peso']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__talla", 'Talla') !!}
                                {!! Form::text('historias__talla', null, ['class' => 'form-control', 'placeholder' => 'Talla', 'id' => 'historias__talla']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">b) Exploración General</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__conciencia", 'Conciencia') !!}
                                {!! Form::select('historias__conciencia', ['' => '----------', 'Orientado' => 'Orientado', 'Desorientado' => 'Desorientado'], null, ['class' => 'form-control', 'id' => 'historias__conciencia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__hidratacion", 'Hidratación') !!}
                                {!! Form::select('historias__hidratacion', ['' => '----------', 'Buena' => 'Buena', 'Deshidratado' => 'Deshidratado'], null, ['class' => 'form-control', 'id' => 'historias__hidratacion']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__coloracion", 'Coloración') !!}
                                {!! Form::select('historias__coloracion', ['' => '----------', 'Adecuada' => 'Adecuada', 'Palidez' => 'Palidez', 'Ictérico' => 'Ictérico'], null, ['class' => 'form-control', 'id' => 'historias__coloracion']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__marcha", 'Marcha') !!}
                                {!! Form::select('historias__marcha', ['' => '----------', 'Normal' => 'Normal', 'Anormal' => 'Anormal'], null, ['class' => 'form-control', 'id' => 'historias__marcha']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__otrasAlteraciones", 'Otras Alteraciones') !!}
                                {!! Form::textarea('historias__otrasAlteraciones', null, ['class' => 'form-control', 'placeholder' => 'Otras Alteraciones', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__otrasAlteraciones']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">c) Exploración Regional (Inspección, palpación, percusión, auscultación, comb.)</h4>
                    <h4>Cabeza</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__normocefalo", 'Normocéfalo') !!}
                                {!! Form::checkbox('historias__normocefalo', 1, null, ['id' => 'historias__normocefalo']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__cabello", 'Cabello') !!}
                                {!! Form::select('historias__cabello', ['' => '----------', 'Bien Implantado' => 'Bien Implantado', 'Alopecia' => 'Alopecia'], null, ['class' => 'form-control', 'id' => 'historias__cabello']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__pupilas", 'Pupilas') !!}
                                {!! Form::select('historias__pupilas', ['' => '----------', 'Isocóricas' => 'Isocóricas', 'Anisocória' => 'Anisocória'], null, ['class' => 'form-control', 'id' => 'historias__pupilas']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__faringe", 'Faringe') !!}
                                {!! Form::select('historias__faringe', ['' => '----------', 'Normal' => 'Normal', 'Hiperemia' => 'Hiperemia', 'Exudado Purulento' => 'Exudado Purulento'], null, ['class' => 'form-control', 'id' => 'historias__faringe']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__amigdalas", 'Amigdalas') !!}
                                {!! Form::select('historias__amigdalas', ['' => '----------', 'Normales' => 'Normales', 'Hipertróficas' => 'Hipertróficas', 'Exudado Purulento' => 'Exudado Purulento'], null, ['class' => 'form-control', 'id' => 'historias__amigdalas']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__nariz", 'Naríz') !!}
                                {!! Form::select('historias__nariz', ['' => '----------', 'Fosas Permeables' => 'Fosas Permeables', 'Obstruidas' => 'Obstruidas', 'Alterada' => 'Alterada'], null, ['class' => 'form-control', 'id' => 'historias__nariz']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__adenomegaliasCabeza", 'Adenomegalias') !!}
                                {!! Form::select('historias__adenomegaliasCabeza', ['' => '----------', 'No Palpables' => 'No Palpables', 'Submandibulares' => 'Submandibulares', 'Retroauriculares' => 'Retroauriculares'], null, ['class' => 'form-control', 'id' => 'historias__adenomegaliasCabeza']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Cuello</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__cuello", 'Cuello') !!}
                                {!! Form::select('historias__cuello', ['' => '----------', 'Cilíndrico' => 'Cilíndrico', 'Tráquea Central' => 'Tráquea Central', 'Crecimiento Tiroideo' => 'Crecimiento Tiroideo'], null, ['class' => 'form-control', 'id' => 'historias__cuello']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__adenomegaliasCuello", 'Adenomegalias') !!}
                                {!! Form::select('historias__adenomegaliasCuello', ['' => '----------', 'No Palpables' => 'No Palpables', 'Posteriores' => 'Posteriores', 'Anteriores' => 'Anteriores', 'Supraclavicular' => 'Supraclavicular'], null, ['class' => 'form-control', 'id' => 'historias__adenomegaliasCuello']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__pulsos", 'Pulsos') !!}
                                {!! Form::select('historias__pulsos', ['' => '----------', 'Palpables' => 'Palpables', 'Simétricos' => 'Simétricos', 'Alterados' => 'Alterados'], null, ['class' => 'form-control', 'id' => 'historias__pulsos']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Torax</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__torax", 'Torax') !!}
                                {!! Form::select('historias__torax', ['' => '----------', 'Normolíneo' => 'Normolíneo', 'Tonel' => 'Tonel', 'Excavado' => 'Excavado'], null, ['class' => 'form-control', 'id' => 'historias__torax']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__movResp", 'Mov. Resp.') !!}
                                {!! Form::select('historias__movResp', ['' => '----------', 'Simétricos' => 'Simétricos', 'Asimétricos' => 'Asimétricos'], null, ['class' => 'form-control', 'id' => 'historias__movResp']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__camposPulmonares", 'Campos Pulmonares') !!}
                                {!! Form::select('historias__camposPulmonares', ['' => '----------', 'Bien Ventilados' => 'Bien Ventilados', 'Alterado' => 'Alterado'], null, ['class' => 'form-control', 'id' => 'historias__camposPulmonares']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__ruidosCardiacos", 'Ruidos Cardiacos') !!}
                                {!! Form::select('historias__ruidosCardiacos', ['' => '----------', 'Adecuada Frecuencia' => 'Adecuada Frecuencia', 'Rítmicos' => 'Rítmicos', 'Alterado' => 'Alterado'], null, ['class' => 'form-control', 'id' => 'historias__ruidosCardiacos']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__adenomegaliasAxilares", 'Adenomegalias Axilares') !!}
                                {!! Form::select('historias__adenomegaliasAxilares', ['' => '----------', 'No Palpables' => 'No Palpables', 'Presentes' => 'Presentes'], null, ['class' => 'form-control', 'id' => 'historias__adenomegaliasAxilares']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__adenomegaliasAxilaresDescripcion", 'Adenomegalias Axilares Descripción') !!}
                                {!! Form::textarea('historias__adenomegaliasAxilaresDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Adenomegalias Axilares Descripción', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__adenomegaliasAxilaresDescripcion']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Abdomen</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__abdomen", 'Abdomen') !!}
                                {!! Form::select('historias__abdomen', ['' => '----------', 'Plano' => 'Plano', 'Globoso' => 'Globoso', 'Blando y Depresible' => 'Blando y Depresible', 'Resistencia' => 'Resistencia', 'Abdomen en Madera' => 'Abdomen en Madera'], null, ['class' => 'form-control', 'id' => 'historias__abdomen']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__dolorPalpacion", 'Dolor Palpación') !!}
                                {!! Form::checkbox('historias__dolorPalpacion', 1, null, ['id' => 'historias__dolorPalpacion']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__dolorPalpacionDescripcion", 'Dolor Palpación Descripción') !!}
                                {!! Form::textarea('historias__dolorPalpacionDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Dolor Palpación Descripción', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__dolorPalpacionDescripcion']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__visceromegalias", 'Visceromegalias') !!}
                                {!! Form::select('historias__visceromegalias', ['' => '----------', 'No Palpable' => 'No Palpable', 'Hepatomegalia' => 'Hepatomegalia', 'Esplenomegalia' => 'Esplenomegalia'], null, ['class' => 'form-control', 'id' => 'historias__visceromegalias']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__peristalsis", 'Peristalsis') !!}
                                {!! Form::select('historias__peristalsis', ['' => '----------', 'Normal' => 'Normal', 'Alterada' => 'Alterada'], null, ['class' => 'form-control', 'id' => 'historias__peristalsis']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__peristalsisDescripcion", 'Peristalsis Descripción') !!}
                                {!! Form::textarea('historias__peristalsisDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Peristalsis Descripción', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__peristalsisDescripcion']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Miembros</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__miembrosSuperiores", 'Miembros Superiores') !!}
                                {!! Form::select('historias__miembrosSuperiores', ['' => '----------', 'Íntegras' => 'Íntegras', 'Simétricas' => 'Simétricas', 'Pulsos Palpables' => 'Pulsos Palpables', 'Alteradas' => 'Alteradas'], null, ['class' => 'form-control', 'id' => 'historias__miembrosSuperiores']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__miembrosInferiores", 'Miembros Inferiores') !!}
                                {!! Form::select('historias__miembrosInferiores', ['' => '----------', 'Íntegras' => 'Íntegras', 'Simétricas' => 'Simétricas', 'Pulsos Palpables' => 'Pulsos Palpables', 'Alteradas' => 'Alteradas'], null, ['class' => 'form-control', 'id' => 'historias__miembrosInferiores']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Genitales</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("historias__genitales", 'Genitales') !!}
                                {!! Form::textarea('historias__genitales', null, ['class' => 'form-control', 'placeholder' => 'Genitales', 'rows' => '2', 'style' => 'resize:none', 'id' => 'historias__genitales']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- IMPRESION DIAGNOSTICA--}}{{-- IMPRESION DIAGNOSTICA--}}{{-- IMPRESION DIAGNOSTICA--}}{{-- IMPRESION DIAGNOSTICA--}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse7">7. Impresión Diagnóstica *</a></h4>
            </div>
            <div id="collapse7" class="panel-collapse collapse">
                <div class="panel-body">
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
                </div>
            </div>
        </div>
        {{-- TRATAMIENTO--}}{{-- TRATAMIENTO--}}{{-- TRATAMIENTO--}}{{-- TRATAMIENTO--}}{{-- TRATAMIENTO--}}{{-- TRATAMIENTO--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse8">8. Tratamiento *</a></h4>
            </div>
            <div id="collapse8" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("historias__tratamiento", 'Tratamiento') !!}
                                {!! Form::textarea('historias__tratamiento', null, ['class' => 'form-control', 'placeholder' => 'Tratamiento', 'rows' => '5', 'style' => 'background-color:#FFF5F5', 'id' => 'historias__tratamiento']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>

    <h3 style="color: #24b4b5;">Observación</h3>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                {!! Form::label("historias__observacion", 'Observación') !!}
                {!! Form::textarea('historias__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '5', 'id' => 'historias__observacion']) !!}
            </div>
        </div>
    </div>

</div>