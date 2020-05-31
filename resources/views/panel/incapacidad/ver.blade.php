<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Incapacidad Impresión</title>
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
                <h1>INCAPACIDAD MÉDICA</h1>
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
        {{-- COMIENZA INFO GENERAL DE LA INCAPACIDAD --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $incapacidad->numero }}</td>
              <th><b>Observación General: </b></th>
              <td>{{ $incapacidad->observacion }}</td>
              <th><b>Fecha de Creación: </b></th>
              <td>{{ $incapacidad->created_at }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA INFO GENERAL DE LA INCAPACIDAD --}}
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
        {{-- COMIENZA INCAPACIDAD MEDICA --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> Incapacidad Médica</th>
            </tr>
          </thead>
          <tbody>
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
                $timestamp = $incapacidad->fechaFin;
                $date = Date::createFromFormat('Y-m-d', $timestamp);
                $finalDate = $date->format('l j F Y');
                $fechaFin = ucwords($finalDate);
              ?>
              El que suscribe como médico, responsable de consulta externa en esta unidad, hace constar que habiendo examinado al paciente {{ $paciente->nombres }} {{ $paciente->apellidos }} encontró como padecimientos principales:
              <br>
              @if($historia != null)
                @foreach($historia->cie10s as $cie10)
                  - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                @endforeach
              @endif
              @if($control != null)
                @foreach($control->cie10s as $cie10)
                  - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                @endforeach
              @endif
              @if($sesion != null)
                @foreach($sesion->cie10s as $cie10)
                  - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                @endforeach
              @endif
              Por lo que se considera que requiere de reposo y cuidados especiales. Esta incapacidad estará vigente desde el día {{ $fechaActual }} hasta el día {{ $fechaFin }}.
            </td>
          </tr>
          </tbody>
        </table>
        {{-- TERMINA INCAPACIDAD MEDICA--}}
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