@extends('layouts.master')

	@section('titulo','Detalles sesión de tratamiento')

	@section('css')
    @endsection

	@section('contenido')

        <h2>Detalles Sesión de Tratamiento</h2>
        <br>
        
		<ul>
            <li><a href="{{ route('panel.sesion.versimple', $sesion) }}" target="_blank">Sesión de Tratamiento Simple</a></li>   
            <li><a href="{{ route('panel.sesion.ver', $sesion) }}" target="_blank">Sesión de Tratamiento Completa</a></li>
            <hr>
            @if($formula != null)
                <li><a href="{{ route('panel.formula.ver', $formula) }}" target="_blank">Formula Médica</a></li>
            @endif
            @if($formulaTratamiento != null)
                <li><a href="{{ route('panel.formulatratamiento.ver', $formulaTratamiento) }}" target="_blank">Formulación de Tratamientos</a></li>
            @endif
            @if($incapacidadMedica != null)
                <li><a href="{{ route('panel.incapacidad.ver', $incapacidadMedica) }}" target="_blank">Incapacidad Médica</a></li>
            @endif
            @if($certificadoMedico != null)
                <li><a href="{{ route('panel.certificado.ver', $certificadoMedico) }}" target="_blank">Certificado Médico</a></li>
            @endif
            @if($consentimientoInformado != null)
                <li><a href="{{ route('panel.consentimiento.ver', $consentimientoInformado) }}" target="_blank">Consentimiento Informado</a></li>
            @endif    
        </ul>
	@endsection

	@section('js')
    @endsection