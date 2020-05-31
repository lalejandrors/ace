@extends('layouts.master')

	@section('titulo','Detalles control médico')

	@section('css')
    @endsection

	@section('contenido')

        <h2>Detalles Control Médico</h2>
        <br>
        
		<ul>
            <li><a href="{{ route('panel.control.versimple', $control) }}" target="_blank">Control Médico Simple</a></li>   
            <li><a href="{{ route('panel.control.ver', $control) }}" target="_blank">Control Médico Completo</a></li>
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