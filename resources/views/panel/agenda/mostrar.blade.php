@extends('layouts.master')

	@section('titulo','Agenda')

	@section('css')
		{!!Html::style('vendor/fullcalendar/fullcalendar.min.css')!!}
		{!!Html::style('vendor/datetimepicker/jquery-ui-timepicker-addon.css')!!}
    @endsection

	@section('contenido')
        <h2>Agenda</h2>

        {{-- formulario de crear --}}
    	@include('panel.agenda.partials.formAgendaCrear')
        {{-- end formulario de crear --}}

        {{-- formulario de editar --}}
    	@include('panel.agenda.partials.formAgendaEditar')
        {{-- end formulario de editar --}}

        <div id='top' style="background: #eee;border-bottom: 1px solid #ddd;padding: 0 10px;line-height: 40px;font-size: 12px;"></div>
		<div id='calendar' style="max-width: 900px;margin: 40px auto;padding: 0 10px;"></div>
	@endsection

	@section('js')
		{!!Html::script('vendor/fullcalendar/lib/moment.min.js')!!}
		{!!Html::script('vendor/fullcalendar/fullcalendar.min.js')!!}
		{!!Html::script('vendor/fullcalendar/locale-all.js')!!}
		{!!Html::script('vendor/datetimepicker/jquery-ui-timepicker-addon.js')!!}
		{!!Html::script('vendor/datetimepicker/jquery-ui-sliderAccess.js')!!}
		<script>
			$(document).ready(function() {
				var initialLocaleCode = 'es';

				$('#calendar').fullCalendar({
					header: {
						left: 'prev,next today',
						center: 'title',
						right: 'month,agendaWeek,agendaDay'
					},
					locale: initialLocaleCode,
					minTime: "07:00:00",
  					maxTime: "20:00:00",
  					slotDuration: '00:15:00',
  					selectOverlap: false,
  					eventStartEditable: false,
  					eventDurationEditable: false,
  					defaultView: 'agendaWeek',
					navLinks: true, // can click day/week names to navigate views
					editable: true,
					selectable: true,
					selectHelper: true,

					//esto permite crear una nueva cita
					select: function(start, end){
						start = moment(start.format('YYYY-MM-DD HH:mm'));
						end = moment(end.format('YYYY-MM-DD HH:mm'));

						$('#responsive-modal-create #fechaHoraInicio').val(start.format('YYYY-MM-DD HH:mm'));
						$('#responsive-modal-create #fechaHoraFin').val(end.format('YYYY-MM-DD HH:mm'));

						$('#responsive-modal-create').modal('show');
					},

					//aca gestiono la edicion de la cita
					eventClick: function(event, jsEvent, view) {
						//valido que la cita que voy a editar es pasada, de hoy o futura... si es pasada o de hoy, que solo me permita editar el estado, si es futura, cualquiera de sus propiedades. Esto escogiendo cual de los modales voy a mostrar segun la validacion de fechas

						//dia de la cita
						var diaCita = $.fullCalendar.moment(event.start).format('YYYY-MM-DD');
						var matches = diaCita.match(/^(\d{4})\-(\d{2})\-(\d{2})$/);
						var year = parseInt(matches[1], 10);
					    var month = parseInt(matches[2], 10) - 1; // months are 0-11
					    var day = parseInt(matches[3], 10);
					    diaCita = new Date(year, month, day);
					    //

					    //dia de hoy
					    var hoy = new Date();
					    var yyyy = hoy.getFullYear();
						var mm = hoy.getMonth()+1; //January is 0!
						var dd = hoy.getDate();
						if(dd<10) {
						    dd='0'+dd
						} 
						if(mm<10) {
						    mm='0'+mm
						} 
						hoy = yyyy+'-'+mm+'-'+dd;
						var matches = hoy.match(/^(\d{4})\-(\d{2})\-(\d{2})$/);
						var year = parseInt(matches[1], 10);
					    var month = parseInt(matches[2], 10) - 1; // months are 0-11
					    var day = parseInt(matches[3], 10);
					    hoy = new Date(year, month, day);
					    //

					    if(diaCita <= hoy){//citas pasadas o de hoy
					    	//primero debo dar el formato deseado a las fechas
							var inicio = $.fullCalendar.moment(event.start).format('YYYY-MM-DD HH:mm');
							var fin = $.fullCalendar.moment(event.end).format('YYYY-MM-DD HH:mm');

							$('#citaId').val(event.id);
							$('#pacienteId').val(event.pacienteId);
							$('#paciente').text('Paciente: '+event.paciente);
							$('#responsive-modal-edit #citaTipo_id').val(event.citaTipo);
							$('#responsive-modal-edit #tratamiento_id').val(event.tratamiento);
							$('#responsive-modal-edit #fechaHoraInicio').val(inicio);
							$('#responsive-modal-edit #fechaHoraFin').val(fin);
							$('#responsive-modal-edit #observacion').val(event.observacion);
							$('#estado').val(event.estado);

							//preguntamos si es tipo de cita sesion, que sea visible el input de tratamiento
							if(event.citaTipoNombre == 'Sesión'){
								$('#responsive-modal-edit #tratamientoSesion').show();
							}

							//como es una cita pasada, debo deshabilitar todos los controles, menos el de estado
							$('#pnCheck').hide();
							$('#responsive-modal-edit #citaTipo_id').prop( "disabled", true );
							$('#responsive-modal-edit #fechaHoraInicio').prop( "disabled", true );
							$('#responsive-modal-edit #fechaHoraFin').prop( "disabled", true );
							$('#responsive-modal-edit #observacion').prop( "disabled", true );
							$('#estado').val(event.estado);

							$('#responsive-modal-edit').modal('show');
					    }else{//citas futuras
					    	//primero debo dar el formato deseado a las fechas
							var inicio = $.fullCalendar.moment(event.start).format('YYYY-MM-DD HH:mm');
							var fin = $.fullCalendar.moment(event.end).format('YYYY-MM-DD HH:mm');

							$('#citaId').val(event.id);
							$('#pacienteId').val(event.pacienteId);
							$('#paciente').text('Paciente: '+event.paciente);
							$('#responsive-modal-edit #citaTipo_id').val(event.citaTipo);
							$('#responsive-modal-edit #tratamiento_id').val(event.tratamiento);
							$('#responsive-modal-edit #fechaHoraInicio').val(inicio);
							$('#responsive-modal-edit #fechaHoraFin').val(fin);
							$('#responsive-modal-edit #observacion').val(event.observacion);
							$('#estado').val(event.estado);

							//preguntamos si es tipo de cita sesion, que sea visible el input de tratamiento
							if(event.citaTipoNombre == 'Sesión'){
								$('#responsive-modal-edit #tratamientoSesion').show();
							}

							//volvemos a habilitar los campos que posiblemente se desactivaron al abrir una cita pasada
							$('#pnCheck').show();
							$('#responsive-modal-edit #citaTipo_id').prop( "disabled", false );
							$('#responsive-modal-edit #fechaHoraInicio').prop( "disabled", false );
							$('#responsive-modal-edit #fechaHoraFin').prop( "disabled", false );
							$('#responsive-modal-edit #observacion').prop( "disabled", false );

							//se deshabilita el option de asistida para futuras citas
							$('#estado option[value="Asistida"]').attr("disabled", true);

							$('#responsive-modal-edit').modal('show');
					    }
				    },

					//aca me traigo todas las citas desde la ruta que se especifica
					events: '/panel/agenda/cargar'
				});

				//asignamos el plugin "Timepicker to jQuery UI Datepicker" a los inputs tanto de crear como de editar
				$('#responsive-modal-create #fechaHoraInicio').datetimepicker({
					dateFormat: "yy-mm-dd",
    				timeFormat:  "HH:mm"
				});
				$('#responsive-modal-create #fechaHoraFin').datetimepicker({
					dateFormat: "yy-mm-dd",
    				timeFormat:  "HH:mm"
				});
				$('#responsive-modal-edit #fechaHoraInicio').datetimepicker({
					dateFormat: "yy-mm-dd",
    				timeFormat:  "HH:mm"
				});
				$('#responsive-modal-edit #fechaHoraFin').datetimepicker({
					dateFormat: "yy-mm-dd",
    				timeFormat:  "HH:mm"
				});

				//gestion checkbox de cambiar o no de paciente en edicion
				$('#pacienteNuevoCheck').change(function() {
			        if($(this).is(":checked")) {
			            $('#pacienteNuevo').show();
			            $('#pacienteViejo').hide();
			        }else{
			            $('#pacienteViejo').show();
			            $('#pacienteNuevo').hide();
			        }      
			    });

			    //gestion checkbox de cambiar de tipo de cita, para saber cuando es sesion y mostrar los tratamientos
				$('#responsive-modal-create #citaTipo_id').on('change', function() {//para creacion
			        if($("#responsive-modal-create #citaTipo_id option:selected").text() == "Sesión") {
			            $('#responsive-modal-create #tratamientoSesion').show();
			        }else{
			            $('#responsive-modal-create #tratamientoSesion').hide();
			        }     
			    });
			    $('#responsive-modal-edit #citaTipo_id').on('change', function() {//para edicion
			        if($("#responsive-modal-edit #citaTipo_id option:selected").text() == "Sesión") {
			            $('#responsive-modal-edit #tratamientoSesion').show();
			        }else{
			            $('#responsive-modal-edit #tratamientoSesion').hide();
			        }     
			    });
			});
		</script>
		{!!Html::script('js/personal/autocompletar.js')!!}
	    {!!Html::script('js/personal/agendas.js')!!}
    @endsection