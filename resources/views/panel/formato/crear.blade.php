@extends('layouts.master')

	@section('titulo','Creación de formatos')

	@section('css')
    @endsection

	@section('contenido')
        <h2>Creación de Formatos</h2>

        {!! Form::open(['route' => ['panel.formato.almacenar'], 'method' => 'post']) !!}
		    {{ csrf_field() }}

        	@include('panel.formato.partials.formFormatoCrear')
        	<br><br>

		    <div class="form-group">
                <button type="submit" class="btn btn-primary center-block">
                    Crear
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
    @endsection