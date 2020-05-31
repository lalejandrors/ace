<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Control Médico Impresión</title>
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
                <h1>CONTROL MÉDICO</h1>
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
        {{-- COMIENZA INFO GENERAL DEL CONTROL --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <th><b>Número del control: </b></th>
              <td colspan="2">{{ $control->numero }}</td>
              <th><b>Fecha de Creación: </b></th>
              <td colspan="2">{{ $control->created_at }}</td>
            </tr>
            <tr>
              <th><b>Descripción: </b></th>
              <td colspan="5">{{ $control->observacion }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA INFO GENERAL DEL CONTROL --}}
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
        @if($control->acompanante != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="8"> Datos del Acompañante</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><b>Identificación: </b></th>
                <td>{{ $control->acompanante->identificacion }}</td>
                <th><b>Tipo de Identificación: </b></th>
                <td>{{ $control->acompanante->tipoId }}</td>
                <th><b>Nombres: </b></th>
                <td>{{ $control->acompanante->nombres }}</td>
                <th><b>Apellidos: </b></th>
                <td>{{ $control->acompanante->apellidos }}</td>
              </tr>
              <tr>
                <th><b>Parentesco: </b></th>
                <td>{{ $parentescoAcompanante->parentesco }}</td>
                <th><b>Teléfono Fijo: </b></th>
                <td>{{ $control->acompanante->telefonoFijo }}</td>
                <th><b>Teléfono Celular: </b></th>
                <td>{{ $control->acompanante->telefonoCelular }}</td>
                <th></th>
                <td></td>
              </tr>
            </tbody>
          </table>
        @endif
        {{-- TERMINA ACOMPANANTE --}}
        {{-- COMIENZA PADECIMIENTO ACTUAL --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 1. Padecimiento Actual (1 principio, 2 evolución, 3 estado actual)</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Padecimiento Actual: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->padecimientoActual }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA PADECIMIENTO ACTUAL --}}
        {{-- COMIENZA SINTOMAS GENERALES --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 2. Síntomas Generales</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th><b>Astenia: </b></th>
              @if($control->astenia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Adinamia: </b></th>
              @if($control->adinamia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Anorexia: </b></th>
              @if($control->anorexia == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
            </tr>
            <tr>
              <th><b>Fiebre: </b></th>
              @if($control->fiebre == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Pérdida de Peso: </b></th>
              @if($control->perdidaPeso == 0)
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
              <th colspan="6"> 3. Interrogatorio por Aparatos y Sistemas</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Aparato Digestivo: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->aparatoDigestivo }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Cardiovascular: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->aparatoCardiovascular }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Respiratorio: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->aparatoRespiratorio }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Urinario: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->aparatoUrinario }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Genital: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->aparatoGenital }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Aparato Hematológico: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->aparatoHematologico }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Endocrino: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->sistemaEndocrino }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Osteomuscular: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->sistemaOsteomuscular }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Nervioso: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->sistemaNervioso }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Sistema Sensorial: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->sistemaSensorial }}</td>
            </tr>
            <tr>
              <th colspan="6"><b>Psicosomático: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->psicosomatico }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA INTERROGATORIO POR APARATOS Y SISTEMAS --}}
        {{-- COMIENZA TERAPEUTICA ANTERIOR --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 4. Terapéutica Empleada Anteriormente</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Terapéutica Anterior: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->terapeuticaAnterior }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA TERAPEUTICA ANTERIOR --}}
        {{-- COMIENZA EXPLORACION FISICA --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 5. Exploración Física</th>
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
              <td>{{ $control->ta }}</td>
              <th><b>Frecuencia Cardíaca: </b></th>
              <td>{{ $control->fc }}</td>
              <th><b>Frecuencia Respiratoria: </b></th>
              <td>{{ $control->fr }}</td>
            </tr>
            <tr>
              <th><b>Temperatura Corporal: </b></th>
              <td>{{ $control->temp }}</td>
              <th><b>Peso: </b></th>
              <td>{{ $control->peso }}</td>
              <th><b>Talla: </b></th>
              <td>{{ $control->talla }}</td>
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
              <td>{{ $control->conciencia }}</td>
              <th><b>Hidratación: </b></th>
              <td>{{ $control->hidratacion }}</td>
              <th><b>Coloración: </b></th>
              <td>{{ $control->coloracion }}</td>
            </tr>
            <tr>
              <th><b>Marcha: </b></th>
              <td>{{ $control->marcha }}</td>
              <th><b>Otras Alteraciones: </b></th>
              <td colspan="3">{{ $control->otrasAlteraciones }}</td>
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
              @if($control->normocefalo == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Cabello: </b></th>
              <td>{{ $control->cabello }}</td>
              <th><b>Pupilas: </b></th>
              <td>{{ $control->pupilas }}</td>
            </tr>
            <tr>
              <th><b>Faringe: </b></th>
              <td>{{ $control->faringe }}</td>
              <th><b>Amigdalas: </b></th>
              <td>{{ $control->amigdalas }}</td>
              <th><b>Naríz: </b></th>
              <td>{{ $control->nariz }}</td>
            </tr>
            <tr>
              <th><b>Adenomegalias: </b></th>
              <td>{{ $control->adenomegaliasCabeza }}</td>
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
              <td>{{ $control->cuello }}</td>
              <th><b>Adenomegalias: </b></th>
              <td>{{ $control->adenomegaliasCuello }}</td>
              <th><b>Pulsos: </b></th>
              <td>{{ $control->pulsos }}</td>
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
              <td>{{ $control->torax }}</td>
              <th><b>Mov. Resp.: </b></th>
              <td>{{ $control->movResp }}</td>
              <th><b>Campos Pulmonares: </b></th>
              <td>{{ $control->camposPulmonares }}</td>
            </tr>
            <tr>
              <th><b>Ruidos Cardiacos: </b></th>
              <td>{{ $control->ruidosCardiacos }}</td>
              <th><b>Adenomegalias Axilares: </b></th>
              <td>{{ $control->adenomegaliasAxilares }}</td>
              <th><b>Adenomegalias Axilares Descripción: </b></th>
              <td>{{ $control->adenomegaliasAxilaresDescripcion }}</td>
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
              <td>{{ $control->abdomen }}</td>
              <th><b>Dolor Palpación: </b></th>
              @if($control->dolorPalpacion == 0)
                <td>No</td>
              @else
                <td>Si</td>
              @endif
              <th><b>Dolor Palpación Descripción: </b></th>
              <td>{{ $control->dolorPalpacionDescripcion }}</td>
            </tr>
            <tr>
              <th><b>Visceromegalias: </b></th>
              <td>{{ $control->visceromegalias }}</td>
              <th><b>Peristalsis: </b></th>
              <td>{{ $control->peristalsis }}</td>
              <th><b>Peristalsis Descripción: </b></th>
              <td>{{ $control->peristalsisDescripcion }}</td>
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
              <td colspan="2">{{ $control->miembrosSuperiores }}</td>
              <th><b>Miembros Inferiores: </b></th>
              <td colspan="2">{{ $control->miembrosInferiores }}</td>
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
              <td colspan="6">{{ $control->genitales }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA EXPLORACION FISICA --}}
        {{-- COMIENZA IMPRESION DIAGNOSTICA --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 6. Impresión Diagnóstica</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Listado de Diagnósticos: </b></th>
            </tr>
            <tr>
              <td colspan="6">
                @foreach($control->cie10s as $cie10)
                  - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                @endforeach
              </td>
            </tr>
            <tr>
              <th colspan="6"><b>Impresión Diagnóstica: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->impresionDiagnostica }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA IMPRESION DIAGNOSTICA --}}
        {{-- COMIENZA TRATAMIENTO --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> 7. Tratamiento</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th colspan="6"><b>Tratamiento: </b></th>
            </tr>
            <tr>
              <td colspan="6">{{ $control->tratamiento }}</td>
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
              <td colspan="6">{{ $control->observacion }}</td>
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
                @foreach($control->cie10s as $cie10)
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