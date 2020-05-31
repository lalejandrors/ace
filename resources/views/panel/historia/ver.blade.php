<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Historia Clínica Impresión</title>
    <link rel="stylesheet" href="css/app.css">
    <style>
      tbody{
        font-size: 10px;
      }
      th, td {
        padding: 3px !important;
      }
      h1, h2, h3{
        font-family: helvetica;
        line-height: 1.1;
        text-align: center;
      }
      h1{
        font-weight: 500;
      }
      h2{
        font-weight: 300;
      }
      h3{
        font-weight: 200;
      }
    </style>
  </head>

  <body>

    <div id="contenido">
        {{-- COMIENZA CABECERA --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <td style="text-align: center;">
                <br>
                @if(Auth::user()->perfil_id == 1 || Auth::user()->perfil_id == 2)
                  Dr(a). {{ Auth::user()->nombres }} {{ Auth::user()->apellidos }}
                  <br>
                  {{ Auth::user()->medico->especialidad }}
                  <br>
                  Registro Médico: {{ Auth::user()->medico->registroMedico }}
                @endif
                @if(Auth::user()->perfil_id == 3)
                  Dr(a). {{ Session::get('medicoActual')->user->nombres }} {{ Session::get('medicoActual')->user->apellidos }}
                  <br>
                  Especialidad: {{ Session::get('medicoActual')->especialidad }}
                  <br>
                  Registro Médico: {{ Session::get('medicoActual')->registroMedico }}
                @endif
              </td>
              <td>
                <br>
                <h1>HISTORIA CLÍNICA</h1>
              </td>
              <td style="text-align: center;">
                <img src="logo/{{ $informacion->path }}" alt="" style="width:110px; height: auto;">
                <br>
                {{ $informacion->razonSocial }}
                <br>
                NIT: {{ $informacion->nit }}
              </td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA CABECERA --}}
        {{-- COMIENZA INFO GENERAL DE LA HISTORIA --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <th><b>Número de la Historia: </b></th>
              <td colspan="2">{{ $historia->numero }}</td>
              <th><b>Fecha de Creación: </b></th>
              <td colspan="2">{{ $historia->created_at }}</td>
            </tr>
            <tr>
              <th><b>Descripción: </b></th>
              <td colspan="5">{{ $historia->observacion }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA INFO GENERAL DE LA HISTORIA --}}
        {{-- COMIENZA PACIENTE --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="8"> Datos Básicos del Paciente</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Identificación: </b></th>
              <td>{{ $paciente->identificacion }}</td>
              <th><b>Tipo de Identificación: </b></th>
              <td>{{ $paciente->tipoId }}</td>
              <th><b>Nombres: </b></th>
              <td>{{ $paciente->nombres }}</td>
              <th><b>Apellidos: </b></th>
              <td>{{ $paciente->apellidos }}</td>
            </tr>
            <tr>
              <th><b>Edad: </b></th>
              <td>{{ $paciente->edad }}</td>
              <th><b>Género: </b></th>
              <td>{{ $paciente->genero }}</td>
              <th><b>Hijos: </b></th>
              <td>{{ $paciente->hijos }}</td>
              <th><b>Estado Civil: </b></th>
              <td>{{ $paciente->estadoCivil }}</td>
            </tr>
            <tr>
              <th><b>Teléfono Fijo: </b></th>
              <td>{{ $paciente->telefonoFijo }}</td>
              <th><b>Teléfono Celular: </b></th>
              <td>{{ $paciente->telefonoCelular }}</td>
              <th><b>Ciudad: </b></th>
              <td>{{ $paciente->ciudad }} ({{ $paciente->departamento }})</td>
              <th><b>Dirección: </b></th>
              <td>{{ $paciente->direccion }}</td>
            </tr>
            <tr>
              <th><b>Ubicación: </b></th>
              <td>{{ $paciente->ubicacion }}</td>
              <th><b>Correo Electrónico: </b></th>
              <td>{{ $paciente->email }}</td>
              <th><b>EPS: </b></th>
              <td>{{ $paciente->eps }}</td>
              <th><b>Ocupación: </b></th>
              <td>{{ $paciente->ocupacion }}</td>
            </tr>
          </tbody>
        </table>
          {{-- TERMINA PACIENTE --}}
          {{-- COMIENZA ACOMPANANTE --}}
        @if($historia->acompanante != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="8"> Datos del Acompañante</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><b>Identificación: </b></th>
                <td>{{ $historia->acompanante->identificacion }}</td>
                <th><b>Tipo de Identificación: </b></th>
                <td>{{ $historia->acompanante->tipoId }}</td>
                <th><b>Nombres: </b></th>
                <td>{{ $historia->acompanante->nombres }}</td>
                <th><b>Apellidos: </b></th>
                <td>{{ $historia->acompanante->apellidos }}</td>
              </tr>
              <tr>
                <th><b>Parentesco: </b></th>
                <td>{{ $parentescoAcompanante->parentesco }}</td>
                <th><b>Teléfono Fijo: </b></th>
                <td>{{ $historia->acompanante->telefonoFijo }}</td>
                <th><b>Teléfono Celular: </b></th>
                <td>{{ $historia->acompanante->telefonoCelular }}</td>
                <th></th>
                <td></td>
              </tr>
            </tbody>
          </table>
        @endif
        {{-- TERMINA ACOMPANANTE --}}
        {{-- COMIENZA ANTECEDENTES --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 1. Antecedentes</th>
            </tr>
          </thead>
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> a) Heredo Familiares</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Diabetes: </b></th>
              <td>{{ $historia->parentescoDiabetes }}</td>
              <th><b>Hipertensión: </b></th>
              <td>{{ $historia->parentescoHipertension }}</td>
              <th><b>Cardiopatía: </b></th>
              <td>{{ $historia->parentescoCardiopatia }}</td>
            </tr>
            <tr>
              <th><b>Hepatopatía: </b></th>
              <td>{{ $historia->parentescoHepatopatia }}</td>
              <th><b>Nefropatía: </b></th>
              <td>{{ $historia->parentescoNefropatia }}</td>
              <th><b>Enf. Mentales: </b></th>
              <td>{{ $historia->parentescoEnfermedadesMentales }}</td>
            </tr>
            <tr>
              <th><b>Asma: </b></th>
              <td>{{ $historia->parentescoAsma }}</td>
              <th><b>Cáncer: </b></th>
              <td>{{ $historia->parentescoCancer }}</td>
              <th><b>Enf. Alérgicas: </b></th>
              <td>{{ $historia->parentescoEnfermedadesAlergicas }}</td>
            </tr>
            <tr>
              <th><b>Enfermedades Endócrinas: </b></th>
              <td>{{ $historia->enfermedadesEndocrinas }}</td>
              <th><b>Otras Enfermedades: </b></th>
              <td>{{ $historia->otrosDescripcion }}</td>
              <th><b>Parentesco Otras Enfermedades: </b></th>
              <td>{{ $historia->parentescoOtros }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> b) Personales Patológicos</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Quirúrgicos: </b></th>
              <td>{{ $historia->descripcionQuirurgicos }}</td>
              <th><b>Transfusionales: </b></th>
              <td>{{ $historia->descripcionTransfusionales }}</td>
              <th><b>Alergias: </b></th>
              <td>{{ $historia->descripcionAlergias }}</td>
            </tr>
            <tr>
              <th><b>Traumáticos: </b></th>
              <td>{{ $historia->descripcionTraumaticos }}</td>
              <th><b>Hospitalizaciones Previas: </b></th>
              <td>{{ $historia->descripcionHospitalizacionesPrevias }}</td>
              <th><b>Adicciones: </b></th>
              <td>{{ $historia->descripcionAdicciones }}</td>
            </tr>
            <tr>
              <th><b>Otros: </b></th>
              <td colspan="5">{{ $historia->descripcionOtros }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> c) Personales No Patológicos</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Baño: </b></th>
              <td>{{ $historia->bano }}</td>
              <th><b>Baño de Dientes: </b></th>
              <td>{{ $historia->banoDientes }}</td>
              <th><b>Servicio de Agua Potable: </b></th>
              @if($historia->servicioAguaPotable == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
            </tr>
            <tr>
              <th><b>Cigarrillos Diarios: </b></th>
              <td>{{ $historia->cigarrillosDiarios }}</td>
              <th><b>Años Fumando: </b></th>
              <td>{{ $historia->anosFumando }}</td>
              <th><b>Alcoholismo Frecuencia: </b></th>
              <td>{{ $historia->alcoholismoFrecuencia }}</td>
            </tr>
            <tr>
              <th><b>Comidas Diarias: </b></th>
              <td>{{ $historia->comidasDiarias }}</td>
              <th><b>Calidad de la Comida: </b></th>
              <td>{{ $historia->calidadComida }}</td>
              <th><b>Actividad Física: </b></th>
              <td>{{ $historia->actividadFisica }}</td>
            </tr>
            <tr>
              <th><b>Inmunizaciones: </b></th>
              <td>{{ $historia->inmunizaciones }}</td>
              <th><b>Inmunizaciones Pendientes: </b></th>
              <td>{{ $historia->inmunizacionesPendientes }}</td>
              <th><b>Última Desparacitación: </b></th>
              <td>{{ $historia->ultimaDesparacitacion }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> d) Gineco – Obstétricos</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Menarca: </b></th>
              <td>{{ $historia->menarca }}</td>
              <th><b>Ritmo Menstrual: </b></th>
              <td>{{ $historia->ritmoMenstrual }}</td>
              <th><b>Dismenorrea: </b></th>
              @if($historia->dismenorrea == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
            </tr>
            <tr>
              <th><b>Fecha Última Menstruación: </b></th>
              <td>{{ $historia->fum }}</td>
              <th><b>Inicio de Vida Sexual: </b></th>
              @if($historia->ivsa == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Número de Parejas: </b></th>
              <td>{{ $historia->numeroParejas }}</td>
            </tr>
            <tr>
              <th><b>Fecha Probable de Parto: </b></th>
              <td>{{ $historia->fpp }}</td>
              <th><b>Fecha Último Parto: </b></th>
              <td>{{ $historia->fup }}</td>
              <th><b>Menopausia: </b></th>
              @if($historia->menopausia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
            </tr>
            <tr>
              <th><b>Método de Planificación: </b></th>
              <td>{{ $historia->metodoPlanificacion }}</td>
              <th><b>Citología Vaginal: </b></th>
              <td>{{ $historia->citologiaVaginal }}</td>
              <th><b>Examen de Mamas: </b></th>
              <td>{{ $historia->examenMamas }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA ANTECEDENTES --}}
        {{-- COMIENZA PADECIMIENTO ACTUAL --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 2. Padecimiento Actual (1 principio, 2 evolución, 3 estado actual)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Padecimiento Actual: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->padecimientoActual }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA PADECIMIENTO ACTUAL --}}
        {{-- COMIENZA SINTOMAS GENERALES --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 3. Síntomas Generales</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Astenia: </b></th>
              @if($historia->astenia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Adinamia: </b></th>
              @if($historia->adinamia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Anorexia: </b></th>
              @if($historia->anorexia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
            </tr>
            <tr>
              <th><b>Fiebre: </b></th>
              @if($historia->fiebre == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Pérdida de Peso: </b></th>
              @if($historia->perdidaPeso == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th></th>
              <td></td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA SINTOMAS GENERALES --}}
        {{-- COMIENZA INTERROGATORIO POR APARATOS Y SISTEMAS --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 4. Interrogatorio por Aparatos y Sistemas</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Aparato Digestivo: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->aparatoDigestivo }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Cardiovascular: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->aparatoCardiovascular }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Respiratorio: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->aparatoRespiratorio }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Urinario: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->aparatoUrinario }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Genital: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->aparatoGenital }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Hematológico: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->aparatoHematologico }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Endocrino: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->sistemaEndocrino }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Osteomuscular: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->sistemaOsteomuscular }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Nervioso: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->sistemaNervioso }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Sensorial: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->sistemaSensorial }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Psicosomático: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->psicosomatico }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA INTERROGATORIO POR APARATOS Y SISTEMAS --}}
        {{-- COMIENZA TERAPEUTICA ANTERIOR --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 5. Terapéutica Empleada Anteriormente</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Terapéutica Anterior: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->terapeuticaAnterior }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA TERAPEUTICA ANTERIOR --}}
        {{-- COMIENZA EXPLORACION FISICA --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 6. Exploración Física</th>
            </tr>
          </thead>
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> a) Signos Vitales</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Tensión Arterial: </b></th>
              <td>{{ $historia->ta }}</td>
              <th><b>Frecuencia Cardíaca: </b></th>
              <td>{{ $historia->fc }}</td>
              <th><b>Frecuencia Respiratoria: </b></th>
              <td>{{ $historia->fr }}</td>
            </tr>
            <tr>
              <th><b>Temperatura Corporal: </b></th>
              <td>{{ $historia->temp }}</td>
              <th><b>Peso: </b></th>
              <td>{{ $historia->peso }}</td>
              <th><b>Talla: </b></th>
              <td>{{ $historia->talla }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> b) Exploración General</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Conciencia: </b></th>
              <td>{{ $historia->conciencia }}</td>
              <th><b>Hidratación: </b></th>
              <td>{{ $historia->hidratacion }}</td>
              <th><b>Coloración: </b></th>
              <td>{{ $historia->coloracion }}</td>
            </tr>
            <tr>
              <th><b>Marcha: </b></th>
              <td>{{ $historia->marcha }}</td>
              <th><b>Otras Alteraciones: </b></th>
              <td colspan="3">{{ $historia->otrasAlteraciones }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 12px;"> c) Exploración Regional (Inspección, palpación, percusión, auscultación, comb.)</th>
            </tr>
            <tr>
              <th colspan="6" style="font-size: 11px;"> Cabeza</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Normocéfalo: </b></th>
              @if($historia->normocefalo == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Cabello: </b></th>
              <td>{{ $historia->cabello }}</td>
              <th><b>Pupilas: </b></th>
              <td>{{ $historia->pupilas }}</td>
            </tr>
            <tr>
              <th><b>Faringe: </b></th>
              <td>{{ $historia->faringe }}</td>
              <th><b>Amigdalas: </b></th>
              <td>{{ $historia->amigdalas }}</td>
              <th><b>Naríz: </b></th>
              <td>{{ $historia->nariz }}</td>
            </tr>
            <tr>
              <th><b>Adenomegalias: </b></th>
              <td>{{ $historia->adenomegaliasCabeza }}</td>
              <th></th>
              <td></td>
              <th></th>
              <td></td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 11px;"> Cuello</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Cuello: </b></th>
              <td>{{ $historia->cuello }}</td>
              <th><b>Adenomegalias: </b></th>
              <td>{{ $historia->adenomegaliasCuello }}</td>
              <th><b>Pulsos: </b></th>
              <td>{{ $historia->pulsos }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 11px;"> Torax</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Torax: </b></th>
              <td>{{ $historia->torax }}</td>
              <th><b>Mov. Resp.: </b></th>
              <td>{{ $historia->movResp }}</td>
              <th><b>Campos Pulmonares: </b></th>
              <td>{{ $historia->camposPulmonares }}</td>
            </tr>
            <tr>
              <th><b>Ruidos Cardiacos: </b></th>
              <td>{{ $historia->ruidosCardiacos }}</td>
              <th><b>Adenomegalias Axilares: </b></th>
              <td>{{ $historia->adenomegaliasAxilares }}</td>
              <th><b>Adenomegalias Axilares Descripción: </b></th>
              <td>{{ $historia->adenomegaliasAxilaresDescripcion }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 11px;"> Abdomen</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Abdomen: </b></th>
              <td>{{ $historia->abdomen }}</td>
              <th><b>Dolor Palpación: </b></th>
              @if($historia->dolorPalpacion == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Dolor Palpación Descripción: </b></th>
              <td>{{ $historia->dolorPalpacionDescripcion }}</td>
            </tr>
            <tr>
              <th><b>Visceromegalias: </b></th>
              <td>{{ $historia->visceromegalias }}</td>
              <th><b>Peristalsis: </b></th>
              <td>{{ $historia->peristalsis }}</td>
              <th><b>Peristalsis Descripción: </b></th>
              <td>{{ $historia->peristalsisDescripcion }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 11px;"> Miembros</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Miembros Superiores: </b></th>
              <td colspan="2">{{ $historia->miembrosSuperiores }}</td>
              <th><b>Miembros Inferiores: </b></th>
              <td colspan="2">{{ $historia->miembrosInferiores }}</td>
            </tr>
          </tbody>
        </table>
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6" style="font-size: 11px;"> Genitales</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Genitales: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->genitales }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA EXPLORACION FISICA --}}
        {{-- COMIENZA IMPRESION DIAGNOSTICA --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 7. Impresión Diagnóstica</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Listado de Diagnósticos: </b></th>
            </tr>
            <tr>
              <td colspan="6">
                @foreach($historia->cie10s as $cie10)
                  - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                @endforeach
              </td>
            </tr>
            <tr>
              <th colspan="6"><b>Impresión Diagnóstica: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->impresionDiagnostica }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA IMPRESION DIAGNOSTICA --}}
        {{-- COMIENZA TRATAMIENTO --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 8. Tratamiento</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Tratamiento: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->tratamiento }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA TRATAMIENTO --}}
        {{-- COMIENZA OBSERVACION --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> Observación</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Observación: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $historia->observacion }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA OBSERVACION--}}
        @if($formula != null || $formulaTratamiento != null || $incapacidadMedica != null || $certificadoMedico != null || $consentimientoInformado != null)
          <h2>REGISTROS ADICIONALES</h2>
        @endif
        {{-- COMIENZA FORMULA MEDICA --}}
        @if($formula != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Formula Médica</th>
              </tr>
            </thead>
            <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $formula->numero }}</td>
              <th><b>Observación General: </b></th>
              <td colspan="3">{{ $formula->observacion }}</td>
            </tr>
            <?php 
              $contadorFormula = 0;
            ?>
              @foreach($formula->itemsFormulas as $item)
                <?php 
                  $contadorFormula = $contadorFormula + 1;
                ?>
                <tr>
                  <th colspan="6" style="font-size: 11px;"><b>Medicamento #{{ $contadorFormula }}</b></th>
                </tr>
                <tr>
                  <th><b>Nombre: </b></th>
                  <td>{{ $item->medicamento->nombre }}</td>
                  <th><b>Cantidad: </b></th>
                  <td>{{ $item->cantidad }}</td>
                  <th><b>Dosis/Frecuencia: </b></th>
                  <td>{{ $item->dosisFrecuencia }}</td>
                </tr>
                <tr>
                  <th><b>Horas: </b></th>
                  <td>{{ $item->horas }}</td>
                  <th><b>Duración Tratamiento: </b></th>
                  <td>{{ $item->duracion }}</td>
                  <th><b>Vía Medicamento: </b></th>
                  <td>{{ $item->viaMedicamento->nombre }}</td>
                </tr>
                <tr>
                  <th><b>Observación: </b></th>
                  <td colspan="5">{{ $item->observacion }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
        {{-- TERMINA FORMULA MEDICA--}}
        {{-- COMIENZA FORMULA TRATAMIENTO --}}
        @if($formulaTratamiento != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Formulación de Tratamientos</th>
              </tr>
            </thead>
            <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $formulaTratamiento->numero }}</td>
              <th><b>Observación General: </b></th>
              <td colspan="3">{{ $formulaTratamiento->observacion }}</td>
            </tr>
            <?php 
              $contadorFormulaTratamiento = 0;
            ?>
              @foreach($formulaTratamiento->itemsFormulasTratamientos as $item)
                <?php 
                  $contadorFormulaTratamiento = $contadorFormulaTratamiento + 1;
                ?>
                <tr>
                  <th colspan="6" style="font-size: 11px;"><b>Tratamiento #{{ $contadorFormulaTratamiento }}</b></th>
                </tr>
                <tr>
                  <th><b>Nombre: </b></th>
                  <td>{{ $item->tratamiento->nombre }}</td>
                  <th><b>Número de Sesiones: </b></th>
                  <td>{{ $item->numeroSesiones }}</td>
                  <th><b>Fecha Posible Terminación: </b></th>
                  <td>{{ $item->fechaPosibleTerminacion }}</td>
                </tr>
                <tr>
                  <th><b>Observación: </b></th>
                  <td colspan="5">{{ $item->observacion }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @endif
        {{-- TERMINA FORMULA TRATAMIENTO--}}
        {{-- COMIENZA INCAPACIDAD MEDICA --}}
        @if($incapacidadMedica != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Incapacidad Médica</th>
              </tr>
            </thead>
            <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $incapacidadMedica->numero }}</td>
              <th><b>Observación General: </b></th>
              <td colspan="3">{{ $incapacidadMedica->observacion }}</td>
            </tr>
            <tr>
              <th><b>Contenido: </b></th>
              <td colspan="5">
                <?php 
                  //transformamos la fecha de hoy
                  Date::setLocale('es');
                  $timestamp = date('Y-m-d');
                  $date = Date::createFromFormat('Y-m-d', $timestamp);
                  $finalDate = $date->format('l j F Y');
                  $fechaActual = ucwords($finalDate);

                  //y la fecha final de la incapacidad
                  Date::setLocale('es');
                  $timestamp = $incapacidadMedica->fechaFin;
                  $date = Date::createFromFormat('Y-m-d', $timestamp);
                  $finalDate = $date->format('l j F Y');
                  $fechaFin = ucwords($finalDate);
                ?>
                El que suscribe como médico, responsable de consulta externa en esta unidad, hace constar que habiendo examinado al paciente {{ $paciente->nombres }} {{ $paciente->apellidos }} encontró como padecimientos principales:
                <br>
                @foreach($historia->cie10s as $cie10)
                  - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                @endforeach
                Por lo que se considera que requiere de reposo y cuidados especiales. Esta incapacidad estará vigente desde el día {{ $fechaActual }} hasta el día {{ $fechaFin }}.
              </td>
            </tr>
            </tbody>
          </table>
        @endif
        {{-- TERMINA INCAPACIDAD MEDICA--}}
        {{-- COMIENZA CERTIFICADO MEDICO --}}
        @if($certificadoMedico != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Certificado Médico</th>
              </tr>
            </thead>
            <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $certificadoMedico->numero }}</td>
              <th><b>Observación General: </b></th>
              <td colspan="3">{{ $certificadoMedico->observacion }}</td>
            </tr>
            <tr>
              <th><b>Contenido: </b></th>
              <td colspan="5"><div style="margin: 20px;">{!! $certificadoMedico->contenido !!}</div></td>
            </tr>
            </tbody>
          </table>
        @endif
        {{-- TERMINA CERTIFICADO MEDICO--}}
        {{-- COMIENZA CONSENTIMIENTO INFORMADO--}}
        @if($consentimientoInformado != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Consentimiento Informado</th>
              </tr>
            </thead>
            <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $consentimientoInformado->numero }}</td>
              <th><b>Observación General: </b></th>
              <td colspan="3">{{ $consentimientoInformado->observacion }}</td>
            </tr>
            <tr>
              <th><b>Contenido: </b></th>
              <td colspan="5"><div style="margin: 20px;">{!! $consentimientoInformado->contenido !!}</div></td>
            </tr>
            </tbody>
          </table>
        @endif
        {{-- TERMINA CONSENTIMIENTO INFORMADO--}}
        {{-- COMIENZA FIRMA --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <td style="text-align: center;">
                <br><br><br><br>
                ___________________________________________________
                <br>
                Firma del Médico
                <br><br>
              </td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA FIRMA --}}
        {{-- COMIENZA PIE --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <td style="text-align: center;">
                <br>
                <b>Datos de Contacto</b>
                <br>
                {{ $informacion->direccion }}
                <br>
                Teléfonos: {{ $informacion->telefonos }}
                <br>
                {{ $informacion->email }}
                <br>
                {{ str_replace("https://", "", $informacion->linkWeb) }}
                <br><br>
              </td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA PIE --}}
    </div>

  </body>
</html>