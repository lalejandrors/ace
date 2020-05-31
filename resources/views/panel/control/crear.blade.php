@extends('layouts.master')

	@section('titulo','Creación de control médico')

	@section('css')
        <style>
            .btnRegistroAdicional{
                width: 35%;
            }
            @media (max-width: 991px) {
                .btnRegistroAdicional{
                    width: 50%;
                }
            }
            @media (max-width: 767px) {
                .btnRegistroAdicional{
                    width: 60%;
                }
            }
            @media (max-width: 479px) {
                .btnRegistroAdicional{
                    width: 65%;
                }
            }
        </style>
    @endsection

	@section('contenido')
	    <h2>Creación de Control Médico</h2>

    	@include('panel.control.partials.formControlCrear')

    	{{-- botones para agregar registros adicionales (consentimientos, incapacidades...) --}}
    	<h3 style="color: #24b4b5;">Registros Adicionales</h3>
        <p>Sólo los registros que estén abiertos/visibles al enviar los datos del control, serán los que se registrarán con el mismo.</p>
        <br><br>
    	{{-- FORMULA MEDICA --}}
    	<div class="form-group">
    		{!! Form::hidden('formulaMedicaHidden', '0', ['id' => 'formulaMedicaHidden']) !!}
            <button type="button" id="btnAgregarFormulaMedica" class="btn btn-success center-block btnRegistroAdicional">Formula Médica</button>
        </div>
        <div id="agregarFormulaMedica" style="display: none;background-color: #EAFFFF;padding: 20px;border-radius: 15px;margin-bottom: 30px;">
        	@include('panel.historia.partials.subpartialFormulaMedicaCrear')
        </div>
        {{-- END FORMULA MEDICA --}}

        {{-- FORMULACION DE TRATAMIENTOS --}}
    	<div class="form-group">
    		{!! Form::hidden('formulaTratamientoHidden', '0', ['id' => 'formulaTratamientoHidden']) !!}
            <button type="button" id="btnAgregarFormulaTratamiento" class="btn btn-success center-block btnRegistroAdicional">Formulación de Tratamientos</button>
        </div>
        <div id="agregarFormulaTratamiento" style="display: none;background-color: #EAFFFF;padding: 20px;border-radius: 15px;margin-bottom: 30px;">
        	@include('panel.historia.partials.subpartialFormulaTratamientoCrear')
        </div>
        {{-- END FORMULACION DE TRATAMIENTOS--}}

        {{-- INCAPACIDAD --}}
        <div class="form-group">
            {!! Form::hidden('incapacidadHidden', '0', ['id' => 'incapacidadHidden']) !!}
            <button type="button" id="btnAgregarIncapacidad" class="btn btn-warning center-block btnRegistroAdicional">Incapacidad Médica</button>
        </div>
        <div id="agregarIncapacidad" style="display: none;background-color: #EAFFFF;padding: 20px;border-radius: 15px;margin-bottom: 30px;">
            @include('panel.historia.partials.subpartialIncapacidadCrear')
        </div>
        {{-- END INCAPACIDAD --}}

    	{{-- CERTIFICADO --}}
    	<div class="form-group">
    		{!! Form::hidden('certificadoMedicoHidden', '0', ['id' => 'certificadoMedicoHidden']) !!}
            <button type="button" id="btnAgregarCertificadoMedico" class="btn btn-warning center-block btnRegistroAdicional">Certificado Médico</button>
        </div>
        <div id="agregarCertificadoMedico" style="display: none;background-color: #EAFFFF;padding: 20px;border-radius: 15px;margin-bottom: 30px;">
        	@include('panel.historia.partials.subpartialCertificadoCrear')
        </div>
        {{-- END CERTIFICADO --}}

        {{-- CONSENTIMIENTO --}}
    	<div class="form-group">
    		{!! Form::hidden('consentimientoInformadoHidden', '0', ['id' => 'consentimientoInformadoHidden']) !!}
            <button type="button" id="btnAgregarConsentimientoInformado" class="btn btn-warning center-block btnRegistroAdicional">Consentimiento Informado</button>
        </div>
        <div id="agregarConsentimientoInformado" style="display: none;background-color: #EAFFFF;padding: 20px;border-radius: 15px;margin-bottom: 30px;">
        	@include('panel.historia.partials.subpartialConsentimientoCrear')
        </div>
        {{-- END CONSENTIMIENTO --}}

        <br><br>
	    <div class="form-group">
            {!! link_to('#', $title="Registrar", $attributes = ['id' => 'registro', 'class' => 'btn btn-primary center-block btnRegistroAdicional'], $secure = null) !!}
        </div>
	@endsection

	@section('js')
		{!!Html::script('vendor/tinymce/js/tinymce/tinymce.min.js')!!}
		<script>
			var editor_config = {
				path_absolute: "/",
				selector: ".formato",
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak autoresize",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor colorpicker textpattern"
				],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | forecolor backcolor | emoticons | fontselect",
				relative_urls: false,
				remove_script_host: false,
				file_browser_callback: function (field_name, url, type, win) {
					var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
					var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

					var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;
					if (type == 'image') {
						cmsURL = cmsURL + "&type=Images";
					} else {
						cmsURL = cmsURL + "&type=Files";
					}

					tinyMCE.activeEditor.windowManager.open({
						file: cmsURL,
						title: 'Filemanager',
						width: x * 0.8,
						height: y * 0.8,
						resizable: "yes",
						close_previous: "no"
					});
				}
			};

			tinymce.init(editor_config); 
		</script>
		{!!Html::script('js/personal/autocompletar.js')!!}
		{!!Html::script('js/personal/controles.js')!!}
    @endsection