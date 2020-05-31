@extends('layouts.master')

	@section('titulo','Redactar un correo')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Redactar un Correo</h2>

        {!! Form::open(['route' => ['panel.informe.send'], 'method' => 'post', 'id' => 'formSender']) !!}
		    {{ csrf_field() }}

        	{!! Form::hidden('listadoEmails', $listadoEmails) !!}
        	@include('panel.reporte.partials.formCorreoRedactar')
        	<br>

        	{{-- Imagen de cargando --}}
        	<div id="cargando" style="display: none;"><img src="/images/loading.gif" style="display: block;margin: 0 auto;width: 80px;height: 80px;"/></div>
        	{{-- end imagen cargando --}}

		    <br>
		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Enviar
                </button>
            </div>
	    {!! Form::close() !!}
	@endsection

	@section('js')
		{!!Html::script('vendor/tinymce/js/tinymce/tinymce.min.js')!!}
		<script>
			var editor_config = {
				path_absolute: "/",
				selector: "textarea",
				plugins: [
					"advlist autolink lists link image charmap print preview hr anchor pagebreak autoresize",
					"searchreplace wordcount visualblocks visualchars code fullscreen",
					"insertdatetime media nonbreaking save table contextmenu directionality",
					"emoticons template paste textcolor colorpicker textpattern"
				],
				toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor | emoticons | fontselect",
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
		{!!Html::script('js/personal/sender.js')!!}
    @endsection