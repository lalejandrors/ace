<!DOCTYPE html>
  <head>
    <meta charset="utf-8">
    <title>Formula Médica Impresión</title>
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
                <h1>FORMULA MÉDICA</h1>
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
        {{-- COMIENZA INFO GENERAL DE LA FORMULA --}}
        <table class="table table-bordered table-striped" >
          <tbody>
            <tr>
              <th><b>Número: </b></th>
              <td>{{ $formula->numero }}</td>
              <th><b>Observación General: </b></th>
              <td>{{ $formula->observacion }}</td>
              <th><b>Fecha de Creación: </b></th>
              <td>{{ $formula->created_at }}</td>
            </tr>
          </tbody>
        </table>
        {{-- TERMINA INFO GENERAL DE LA FORMULA --}}
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
        {{-- COMIENZA IMPRESION DIAGNOSTICA --}}
        @if($historia != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Listado de Diagnósticos</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="6">
                  @foreach($historia->cie10s as $cie10)
                    - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                  @endforeach
                </td>
              </tr>
            </tbody>
          </table>
        @endif

        @if($control != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Listado de Diagnósticos</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="6">
                  @foreach($control->cie10s as $cie10)
                    - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                  @endforeach
                </td>
              </tr>
            </tbody>
          </table>
        @endif

        @if($sesion != null)
          <table class="table table-bordered table-striped" >
            <thead>
              <tr>
                <th colspan="6"> Listado de Diagnósticos</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td colspan="6">
                  @foreach($sesion->cie10s as $cie10)
                    - ({{ $cie10->codigo }}) {{ $cie10->descripcion }} <br>
                  @endforeach
                </td>
              </tr>
            </tbody>
          </table>
        @endif
        {{-- TERMINA IMPRESION DIAGNOSTICA --}}
        {{-- COMIENZA FORMULA MEDICA --}}
        <table class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th colspan="6"> Formula Médica</th>
            </tr>
          </thead>
          <tbody>
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
        {{-- TERMINA FORMULA MEDICA--}}
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