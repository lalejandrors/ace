<div class="box-body">

    <p>Los campos obligatorios estarán con un color rosa. Son los campos mínimos para registrar un control, además del paciente.</p>

    <div id="msj-error" class="alert alert-warning alert-dismissable" role="alert" style="display:none;">
        <ul id="msj"></ul>
    </div>

    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

    {{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}{{-- PACIENTE --}}
    <h3 style="color: #24b4b5;">Datos Básicos del Paciente</h3>

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group" id="paciente_id">
                {!! Form::label("controles__paciente_id", 'Paciente') !!}
                {!! Form::text('pacienteId', null, ['class' => 'form-control', 'placeholder' => 'Nombre o documento del paciente...', 'id' => 'pacienteId', 'style' => 'background-color:#FFF5F5']) !!}
                {!! Form::hidden('controles__paciente_id', null, ['id' => 'controles__paciente_id']) !!}
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
                        {!! Form::hidden('controles__acompanante_id', null, ['id' => 'controles__acompanante_id']) !!}
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
    <h3 style="color: #24b4b5;">Secciones del Control Médico</h3>
    <div class="panel-group" id="accordion">
        {{-- PADECIMIENTO ACTUAL--}}{{-- PADECIMIENTO ACTUAL--}}{{-- PADECIMIENTO ACTUAL--}}{{-- PADECIMIENTO ACTUAL--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse1">1. Padecimiento Actual (1 principio, 2 evolución, 3 estado actual) *</a></h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("controles__padecimientoActual", 'Padecimiento Actual') !!}
                                {!! Form::textarea('controles__padecimientoActual', null, ['class' => 'form-control', 'placeholder' => 'Padecimiento Actual', 'rows' => '5', 'style' => 'background-color:#FFF5F5', 'id' => 'controles__padecimientoActual']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- SINTOMAS GENERALES--}}{{-- SINTOMAS GENERALES--}}{{-- SINTOMAS GENERALES--}}{{-- SINTOMAS GENERALES--}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse2">2. Síntomas Generales</a></h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__astenia", 'Astenia') !!}
                                {!! Form::checkbox('controles__astenia', 1, null, ['id' => 'controles__astenia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__adinamia", 'Adinamia') !!}
                                {!! Form::checkbox('controles__adinamia', 1, null, ['id' => 'controles__adinamia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__anorexia", 'Anorexia') !!}
                                {!! Form::checkbox('controles__anorexia', 1, null, ['id' => 'controles__anorexia']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__fiebre", 'Fiebre') !!}
                                {!! Form::checkbox('controles__fiebre', 1, null, ['id' => 'controles__fiebre']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__perdidaPeso", 'Pérdida de Peso') !!}
                                {!! Form::checkbox('controles__perdidaPeso', 1, null, ['id' => 'controles__perdidaPeso']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- APARATOS Y SISTEMAS--}}{{-- APARATOS Y SISTEMAS--}}{{-- APARATOS Y SISTEMAS--}}{{-- APARATOS Y SISTEMAS--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse3">3. Interrogatorio por Aparatos y Sistemas</a></h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__aparatoDigestivo", 'Aparato Digestivo') !!}
                                {!! Form::textarea('controles__aparatoDigestivo', null, ['class' => 'form-control', 'placeholder' => 'Halitosis, boca seca, disfagia(odino), pirosis, nausea, vomito, (hematemesis), dolor abd. meteorismo y flatulencias, constipación, diarrea, rectorragia, melena, pujo y tenesmo, Ictericia coluria y acolia, prurito cutáneo.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__aparatoDigestivo']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__aparatoCardiovascular", 'Aparato Cardiovascular') !!}
                                {!! Form::textarea('controles__aparatoCardiovascular', null, ['class' => 'form-control', 'placeholder' => 'Disnea, tos, hemoptisis, dolor precordial, palpitaciones, cianosis, edema y manifestaciones perifericas (acúfenos, fosfenos, síncope, lipotimia, cefalea, etc).', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__aparatoCardiovascular']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__aparatoRespiratorio", 'Aparato Respiratorio') !!}
                                {!! Form::textarea('controles__aparatoRespiratorio', null, ['class' => 'form-control', 'placeholder' => 'Tos, disnea, dolor torácico, hemoptisis, cianosis, vomica, alteraciones de la voz.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__aparatoRespiratorio']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__aparatoUrinario", 'Aparato Urinario') !!}
                                {!! Form::textarea('controles__aparatoUrinario', null, ['class' => 'form-control', 'placeholder' => 'Alteraciones de la micción (poliuria, anuria, polaquiuria, oliguria, nicturia, opsiuria, disuria, tenesmo vesical, urgencia, chorro, enuresis, incontenincia) caracteres de la orina (volumen, olor, color, aspecto) dolor lumbar, edema renal, hipertensión arterial, datos clínicos de anemia.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__aparatoUrinario']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__aparatoGenital", 'Aparato Genital') !!}
                                {!! Form::textarea('controles__aparatoGenital', null, ['class' => 'form-control', 'placeholder' => 'Criptorquidia, fimosis, función sexual. Sangrado genital, flujo o leucorrea, dolor ginecológico, prurito vulvar.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__aparatoGenital']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__aparatoHematologico", 'Aparato Hematológico') !!}
                                {!! Form::textarea('controles__aparatoHematologico', null, ['class' => 'form-control', 'placeholder' => 'Datos clínicos de anemia (palidez, astenia, adinamia y otros), hemorragias, adenopatías, esplenomegalia.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__aparatoHematologico']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__sistemaEndocrino", 'Sistema Endocrino') !!}
                                {!! Form::textarea('controles__sistemaEndocrino', null, ['class' => 'form-control', 'placeholder' => 'Bocio, letargia bradipsiquia (lalia), intol. calor/frio, nerviosismo, hiperquinesis, carac. sexuales, galactorrea, amenorrea, ginecomastia, obesidad, ruborización.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__sistemaEndocrino']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__sistemaOsteomuscular", 'Sistema Osteomuscular') !!}
                                {!! Form::textarea('controles__sistemaOsteomuscular', null, ['class' => 'form-control', 'placeholder' => 'Ganglios, xeroftalmia, xerostomia, fotosensibilidad artralgias/mialgias, Raynaud.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__sistemaOsteomuscular']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__sistemaNervioso", 'Sistema Nervioso') !!}
                                {!! Form::textarea('controles__sistemaNervioso', null, ['class' => 'form-control', 'placeholder' => 'Cefalea, síncope, convulsiones, deficit transitorio, vertigo, confusion y obnub., vigilia/sueño, paralisis y M, marcha y equilibrio, sensibilidad.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__sistemaNervioso']) !!}
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__sistemaSensorial", 'Sistema Sensorial') !!}
                                {!! Form::textarea('controles__sistemaSensorial', null, ['class' => 'form-control', 'placeholder' => 'Visión, agudeza, borrosa diplopia, fosgenos, dolor ocular, fotofobia, xeroftalmia, amaurosis, otalgia, otorrea y otorragia, hipoacusia, tinitus, olfacción, epistaxis, secreción, Geusis, Garganta (dolor) Fonación.', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__sistemaSensorial']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                {!! Form::label("controles__psicosomatico", 'Psicosomático') !!}
                                {!! Form::textarea('controles__psicosomatico', null, ['class' => 'form-control', 'placeholder' => 'Personalidad, ansiedad, depresión, afectividad, emotividad, amnesia, voluntad, pensamiento, atención, ideación suicida, delirios', 'rows' => '4', 'style' => 'resize:none', 'id' => 'controles__psicosomatico']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- TERAPEUTICA ANTERIOR--}}{{-- TERAPEUTICA ANTERIOR--}}{{-- TERAPEUTICA ANTERIOR--}}{{-- TERAPEUTICA ANTERIOR--}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse4">4. Terapéutica Empleada Anteriormente</a></h4>
            </div>
            <div id="collapse4" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("controles__terapeuticaAnterior", 'Terapéutica Anterior') !!}
                                {!! Form::textarea('controles__terapeuticaAnterior', null, ['class' => 'form-control', 'placeholder' => 'Terapéutica Anterior', 'rows' => '5', 'id' => 'controles__terapeuticaAnterior']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- EXPLORACION FISICA--}}{{-- EXPLORACION FISICA--}}{{-- EXPLORACION FISICA--}}{{-- EXPLORACION FISICA--}}
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse5">5. Exploración Física *</a></h4>
            </div>
            <div id="collapse5" class="panel-collapse collapse">
                <div class="panel-body">
                    <h4 style="color: #f96c0d;">a) Signos Vitales</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__ta", 'Tensión Arterial') !!}
                                {!! Form::text('controles__ta', null, ['class' => 'form-control', 'placeholder' => 'Tensión Arterial', 'style' => 'background-color:#FFF5F5', 'id' => 'controles__ta']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__fc", 'Frecuencia Cardíaca') !!}
                                {!! Form::text('controles__fc', null, ['class' => 'form-control', 'placeholder' => 'Frecuencia Cardíaca', 'id' => 'controles__fc']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__fr", 'Frecuencia Respiratoria') !!}
                                {!! Form::text('controles__fr', null, ['class' => 'form-control', 'placeholder' => 'Frecuencia Respiratoria', 'id' => 'controles__fr']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__temp", 'Temperatura Corporal') !!}
                                {!! Form::text('controles__temp', null, ['class' => 'form-control', 'placeholder' => 'Temperatura Corporal', 'id' => 'controles__temp']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__peso", 'Peso') !!}
                                {!! Form::text('controles__peso', null, ['class' => 'form-control', 'placeholder' => 'Peso', 'style' => 'background-color:#FFF5F5', 'id' => 'controles__peso']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__talla", 'Talla') !!}
                                {!! Form::text('controles__talla', null, ['class' => 'form-control', 'placeholder' => 'Talla', 'id' => 'controles__talla']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">b) Exploración General</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__conciencia", 'Conciencia') !!}
                                {!! Form::select('controles__conciencia', ['' => '----------', 'Orientado' => 'Orientado', 'Desorientado' => 'Desorientado'], null, ['class' => 'form-control', 'id' => 'controles__conciencia']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__hidratacion", 'Hidratación') !!}
                                {!! Form::select('controles__hidratacion', ['' => '----------', 'Buena' => 'Buena', 'Deshidratado' => 'Deshidratado'], null, ['class' => 'form-control', 'id' => 'controles__hidratacion']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__coloracion", 'Coloración') !!}
                                {!! Form::select('controles__coloracion', ['' => '----------', 'Adecuada' => 'Adecuada', 'Palidez' => 'Palidez', 'Ictérico' => 'Ictérico'], null, ['class' => 'form-control', 'id' => 'controles__coloracion']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__marcha", 'Marcha') !!}
                                {!! Form::select('controles__marcha', ['' => '----------', 'Normal' => 'Normal', 'Anormal' => 'Anormal'], null, ['class' => 'form-control', 'id' => 'controles__marcha']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__otrasAlteraciones", 'Otras Alteraciones') !!}
                                {!! Form::textarea('controles__otrasAlteraciones', null, ['class' => 'form-control', 'placeholder' => 'Otras Alteraciones', 'rows' => '2', 'style' => 'resize:none', 'id' => 'controles__otrasAlteraciones']) !!}
                            </div>
                        </div>
                    </div>

                    <h4 style="color: #f96c0d;">c) Exploración Regional (Inspección, palpación, percusión, auscultación, comb.)</h4>
                    <h4>Cabeza</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__normocefalo", 'Normocéfalo') !!}
                                {!! Form::checkbox('controles__normocefalo', 1, null, ['id' => 'controles__normocefalo']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__cabello", 'Cabello') !!}
                                {!! Form::select('controles__cabello', ['' => '----------', 'Bien Implantado' => 'Bien Implantado', 'Alopecia' => 'Alopecia'], null, ['class' => 'form-control', 'id' => 'controles__cabello']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__pupilas", 'Pupilas') !!}
                                {!! Form::select('controles__pupilas', ['' => '----------', 'Isocóricas' => 'Isocóricas', 'Anisocória' => 'Anisocória'], null, ['class' => 'form-control', 'id' => 'controles__pupilas']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__faringe", 'Faringe') !!}
                                {!! Form::select('controles__faringe', ['' => '----------', 'Normal' => 'Normal', 'Hiperemia' => 'Hiperemia', 'Exudado Purulento' => 'Exudado Purulento'], null, ['class' => 'form-control', 'id' => 'controles__faringe']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__amigdalas", 'Amigdalas') !!}
                                {!! Form::select('controles__amigdalas', ['' => '----------', 'Normales' => 'Normales', 'Hipertróficas' => 'Hipertróficas', 'Exudado Purulento' => 'Exudado Purulento'], null, ['class' => 'form-control', 'id' => 'controles__amigdalas']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__nariz", 'Naríz') !!}
                                {!! Form::select('controles__nariz', ['' => '----------', 'Fosas Permeables' => 'Fosas Permeables', 'Obstruidas' => 'Obstruidas', 'Alterada' => 'Alterada'], null, ['class' => 'form-control', 'id' => 'controles__nariz']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__adenomegaliasCabeza", 'Adenomegalias') !!}
                                {!! Form::select('controles__adenomegaliasCabeza', ['' => '----------', 'No Palpables' => 'No Palpables', 'Submandibulares' => 'Submandibulares', 'Retroauriculares' => 'Retroauriculares'], null, ['class' => 'form-control', 'id' => 'controles__adenomegaliasCabeza']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Cuello</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__cuello", 'Cuello') !!}
                                {!! Form::select('controles__cuello', ['' => '----------', 'Cilíndrico' => 'Cilíndrico', 'Tráquea Central' => 'Tráquea Central', 'Crecimiento Tiroideo' => 'Crecimiento Tiroideo'], null, ['class' => 'form-control', 'id' => 'controles__cuello']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__adenomegaliasCuello", 'Adenomegalias') !!}
                                {!! Form::select('controles__adenomegaliasCuello', ['' => '----------', 'No Palpables' => 'No Palpables', 'Posteriores' => 'Posteriores', 'Anteriores' => 'Anteriores', 'Supraclavicular' => 'Supraclavicular'], null, ['class' => 'form-control', 'id' => 'controles__adenomegaliasCuello']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__pulsos", 'Pulsos') !!}
                                {!! Form::select('controles__pulsos', ['' => '----------', 'Palpables' => 'Palpables', 'Simétricos' => 'Simétricos', 'Alterados' => 'Alterados'], null, ['class' => 'form-control', 'id' => 'controles__pulsos']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Torax</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__torax", 'Torax') !!}
                                {!! Form::select('controles__torax', ['' => '----------', 'Normolíneo' => 'Normolíneo', 'Tonel' => 'Tonel', 'Excavado' => 'Excavado'], null, ['class' => 'form-control', 'id' => 'controles__torax']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__movResp", 'Mov. Resp.') !!}
                                {!! Form::select('controles__movResp', ['' => '----------', 'Simétricos' => 'Simétricos', 'Asimétricos' => 'Asimétricos'], null, ['class' => 'form-control', 'id' => 'controles__movResp']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__camposPulmonares", 'Campos Pulmonares') !!}
                                {!! Form::select('controles__camposPulmonares', ['' => '----------', 'Bien Ventilados' => 'Bien Ventilados', 'Alterado' => 'Alterado'], null, ['class' => 'form-control', 'id' => 'controles__camposPulmonares']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__ruidosCardiacos", 'Ruidos Cardiacos') !!}
                                {!! Form::select('controles__ruidosCardiacos', ['' => '----------', 'Adecuada Frecuencia' => 'Adecuada Frecuencia', 'Rítmicos' => 'Rítmicos', 'Alterado' => 'Alterado'], null, ['class' => 'form-control', 'id' => 'controles__ruidosCardiacos']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__adenomegaliasAxilares", 'Adenomegalias Axilares') !!}
                                {!! Form::select('controles__adenomegaliasAxilares', ['' => '----------', 'No Palpables' => 'No Palpables', 'Presentes' => 'Presentes'], null, ['class' => 'form-control', 'id' => 'controles__adenomegaliasAxilares']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__adenomegaliasAxilaresDescripcion", 'Adenomegalias Axilares Descripción') !!}
                                {!! Form::textarea('controles__adenomegaliasAxilaresDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Adenomegalias Axilares Descripción', 'rows' => '2', 'style' => 'resize:none', 'id' => 'controles__adenomegaliasAxilaresDescripcion']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Abdomen</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__abdomen", 'Abdomen') !!}
                                {!! Form::select('controles__abdomen', ['' => '----------', 'Plano' => 'Plano', 'Globoso' => 'Globoso', 'Blando y Depresible' => 'Blando y Depresible', 'Resistencia' => 'Resistencia', 'Abdomen en Madera' => 'Abdomen en Madera'], null, ['class' => 'form-control', 'id' => 'controles__abdomen']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__dolorPalpacion", 'Dolor Palpación') !!}
                                {!! Form::checkbox('controles__dolorPalpacion', 1, null, ['id' => 'controles__dolorPalpacion']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__dolorPalpacionDescripcion", 'Dolor Palpación Descripción') !!}
                                {!! Form::textarea('controles__dolorPalpacionDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Dolor Palpación Descripción', 'rows' => '2', 'style' => 'resize:none', 'id' => 'controles__dolorPalpacionDescripcion']) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__visceromegalias", 'Visceromegalias') !!}
                                {!! Form::select('controles__visceromegalias', ['' => '----------', 'No Palpable' => 'No Palpable', 'Hepatomegalia' => 'Hepatomegalia', 'Esplenomegalia' => 'Esplenomegalia'], null, ['class' => 'form-control', 'id' => 'controles__visceromegalias']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__peristalsis", 'Peristalsis') !!}
                                {!! Form::select('controles__peristalsis', ['' => '----------', 'Normal' => 'Normal', 'Alterada' => 'Alterada'], null, ['class' => 'form-control', 'id' => 'controles__peristalsis']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__peristalsisDescripcion", 'Peristalsis Descripción') !!}
                                {!! Form::textarea('controles__peristalsisDescripcion', null, ['class' => 'form-control', 'placeholder' => 'Peristalsis Descripción', 'rows' => '2', 'style' => 'resize:none', 'id' => 'controles__peristalsisDescripcion']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Miembros</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__miembrosSuperiores", 'Miembros Superiores') !!}
                                {!! Form::select('controles__miembrosSuperiores', ['' => '----------', 'Íntegras' => 'Íntegras', 'Simétricas' => 'Simétricas', 'Pulsos Palpables' => 'Pulsos Palpables', 'Alteradas' => 'Alteradas'], null, ['class' => 'form-control', 'id' => 'controles__miembrosSuperiores']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__miembrosInferiores", 'Miembros Inferiores') !!}
                                {!! Form::select('controles__miembrosInferiores', ['' => '----------', 'Íntegras' => 'Íntegras', 'Simétricas' => 'Simétricas', 'Pulsos Palpables' => 'Pulsos Palpables', 'Alteradas' => 'Alteradas'], null, ['class' => 'form-control', 'id' => 'controles__miembrosInferiores']) !!}
                            </div>
                        </div>
                    </div>

                    <h4>Genitales</h4>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                {!! Form::label("controles__genitales", 'Genitales') !!}
                                {!! Form::textarea('controles__genitales', null, ['class' => 'form-control', 'placeholder' => 'Genitales', 'rows' => '2', 'style' => 'resize:none', 'id' => 'controles__genitales']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- IMPRESION DIAGNOSTICA--}}{{-- IMPRESION DIAGNOSTICA--}}{{-- IMPRESION DIAGNOSTICA--}}{{-- IMPRESION DIAGNOSTICA--}}
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse6">6. Impresión Diagnóstica *</a></h4>
            </div>
            <div id="collapse6" class="panel-collapse collapse">
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
                <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse7">7. Tratamiento *</a></h4>
            </div>
            <div id="collapse7" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                {!! Form::label("controles__tratamiento", 'Tratamiento') !!}
                                {!! Form::textarea('controles__tratamiento', null, ['class' => 'form-control', 'placeholder' => 'Tratamiento', 'rows' => '5', 'style' => 'background-color:#FFF5F5', 'id' => 'controles__tratamiento']) !!}
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
                {!! Form::label("controles__observacion", 'Observación') !!}
                {!! Form::textarea('controles__observacion', null, ['class' => 'form-control', 'placeholder' => 'Observación', 'rows' => '5', 'id' => 'controles__observacion']) !!}
            </div>
        </div>
    </div>

</div>