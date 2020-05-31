//Gestion de la creacion de citas
$("#registro").click(function(){

	$('#cargando').show();

	var token = $("#responsive-modal-create #token").val();

	var paciente = $("#responsive-modal-create #paciente_id").val();
	var citaTipo = $("#responsive-modal-create #citaTipo_id").val();
	var tratamiento = null;
	var fechaHoraInicio = $("#responsive-modal-create #fechaHoraInicio").val();
	var fechaHoraFin = $("#responsive-modal-create #fechaHoraFin").val();
	var observacion = $("#responsive-modal-create #observacion").val();

	var route = "/panel/agenda/almacenar";

	//validamos que el tratamiento haya sido escogido, si el tipo de cita es sesion
    if($("#responsive-modal-create #citaTipo_id option:selected").text() == "Sesión") {
        if($("#responsive-modal-create #tratamiento_id").val() == ''){
        	$('#cargando').hide();

        	$("#responsive-modal-create #msj").html('');
   			$("#responsive-modal-create #msj").html("<li>Debe escoger alguno de los tratamientos cuando el tipo de cita es de Sesión.</li>");
   			$("#responsive-modal-create #msj-error").fadeIn();
   			return false;
        }else{
        	tratamiento = $("#responsive-modal-create #tratamiento_id").val();
        }
    }  

	$.ajax({

		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'POST',
		dataType: 'json',
		data: {paciente_id:paciente, citaTipo_id:citaTipo, tratamiento_id:tratamiento, fechaHoraInicio:fechaHoraInicio, fechaHoraFin:fechaHoraFin, observacion:observacion},

		success:function(data){

			$('#cargando').hide();

			if(data.mensaje == "Ok"){
				swal({
	              title: 'Cita Creada Correctamente',
	              type: 'success',
	            },
	            function(isConfirm){
	              if(isConfirm){
	                window.location.href = "/panel/agenda/mostrar";
	                return false;
	              }
	            });
			}else{
				if(data.mensaje == "Solape"){
		   			$("#responsive-modal-create #msj").html('');
		   			$("#responsive-modal-create #msj").html("<li>El horario de la nueva cita no se puede cruzar con una ya existente.</li>");
		   			$("#responsive-modal-create #msj-error").fadeIn();
				}else{
					if(data.mensaje == "Misma Fecha"){
			   			$("#responsive-modal-create #msj").html('');
			   			$("#responsive-modal-create #msj").html("<li>Asegúrese de que la fecha de inicio de la cita y la fecha de culminación de la misma, coincidan en el mismo día.</li>");
			   			$("#responsive-modal-create #msj-error").fadeIn();
					}else{
						if(data.mensaje == "Tipo Cita 1 Error"){
				   			$("#responsive-modal-create #msj").html('');
				   			$("#responsive-modal-create #msj").html("<li>Asegúrese de que el tipo de cita sea el correcto, ya que el paciente actualmente cuenta con una historia médica registrada.</li>");
				   			$("#responsive-modal-create #msj-error").fadeIn();
						}else{
							if(data.mensaje == "Tipo Cita 2 Error"){
					   			$("#responsive-modal-create #msj").html('');
					   			$("#responsive-modal-create #msj").html("<li>Asegúrese de que el tipo de cita sea el correcto, ya que el paciente actualmente no cuenta con una historia médica registrada para tener una cita de tipo Control/Consulta.</li>");
					   			$("#responsive-modal-create #msj-error").fadeIn();
							}else{
								if(data.mensaje == "Tipo Cita 3 Error"){
						   			$("#responsive-modal-create #msj").html('');
						   			$("#responsive-modal-create #msj").html("<li>Asegúrese de que el tratamiento escogido sea el correcto, ya que el paciente actualmente no cuenta con dicho tratamiento asignado o activo.</li>");
						   			$("#responsive-modal-create #msj-error").fadeIn();
								}
							}
						}
					}
				}
			}		
		},

		error:function(msj){

			$('#cargando').hide();

			var response = JSON.parse(msj.responseText);
	        var errorString = '<ul>';
	        $.each( response.errors, function(key, value) {
	            errorString += '<li>' + value + '</li>';
	        });
	        errorString += '</ul>';
	        $("#responsive-modal-create #msj").html(errorString);

		    $("#responsive-modal-create #msj-error").fadeIn();
		}
	});

});

$("#responsive-modal-create #cancelar").click(function(){

	//al cancelar una creacion de cita, que se pongan en blanco de nuevo los campos
	$("#responsive-modal-create #msj").html('');
	$("#responsive-modal-create #msj-error").fadeOut();
	$("#responsive-modal-create #paciente_id").val('');
	$("#responsive-modal-create #pacienteIdAgenda").val('');
	$("#responsive-modal-create #citaTipo_id").val('');
	$("#responsive-modal-create #observacion").val('');
	$("#responsive-modal-create #tratamientoSesion").hide();
});

//Gestion de la edicion de citas
$("#edicion").click(function(){

	$('#cargando').show();

	var token = $("#responsive-modal-edit #token").val();

	var cita = $("#citaId").val();
	var paciente = null;
	//validamos cual paciente queda, si el que habia antes o uno nuevo
	if($("#pacienteNuevoCheck").is(':checked')) {
	    paciente = $("#responsive-modal-edit #paciente_id").val();
	} else {
	    paciente = $("#pacienteId").val();
	}

	var citaTipo = $("#responsive-modal-edit #citaTipo_id").val();
	var tratamiento = null;
	var fechaHoraInicio = $("#responsive-modal-edit #fechaHoraInicio").val();
	var fechaHoraFin = $("#responsive-modal-edit #fechaHoraFin").val();
	var observacion = $("#responsive-modal-edit #observacion").val();
	var estado = $("#estado").val();

	var route = "/panel/agenda/editar/"+cita;

	//validamos que el tratamiento haya sido escogido, si el tipo de cita es sesion
    if($("#responsive-modal-edit #citaTipo_id option:selected").text() == "Sesión") {
        if($("#responsive-modal-edit #tratamiento_id").val() == ''){
        	$('#cargando').hide();

        	$("#responsive-modal-edit #msj").html('');
   			$("#responsive-modal-edit #msj").html("<li>Debe escoger alguno de los tratamientos cuando el tipo de cita es de Sesión.</li>");
   			$("#responsive-modal-edit #msj-error").fadeIn();
   			return false;
        }else{
        	tratamiento = $("#responsive-modal-edit #tratamiento_id").val();
        }
    }

	$.ajax({

		url: route,
		headers: {'X-CSRF-TOKEN': token},
		type: 'PUT',
		dataType: 'json',
		data: {paciente_id:paciente, citaTipo_id:citaTipo, tratamiento_id:tratamiento, fechaHoraInicio:fechaHoraInicio, fechaHoraFin:fechaHoraFin, observacion:observacion, estado:estado},

		success:function(data){

			$('#cargando').hide();

			if(data.mensaje == "Ok"){
				swal({
	              title: 'Cita Editada Correctamente',
	              type: 'success',
	            },
	            function(isConfirm){
	              if(isConfirm){
	                window.location.href = "/panel/agenda/mostrar";
	                return false;
	              }
	            });
			}else{
				if(data.mensaje == "Solape"){
		   			$("#responsive-modal-edit #msj").html('');
		   			$("#responsive-modal-edit #msj").html("<li>El horario de la cita no se puede cruzar con una ya existente.</li>");
		   			$("#responsive-modal-edit #msj-error").fadeIn();
				}else{
					if(data.mensaje == "Misma Fecha"){
			   			$("#responsive-modal-edit #msj").html('');
			   			$("#responsive-modal-edit #msj").html("<li>Asegúrese de que la fecha de inicio de la cita y la fecha de culminación de la misma, coincidan en el mismo día.</li>");
			   			$("#responsive-modal-edit #msj-error").fadeIn();
					}else{
						if(data.mensaje == "Tipo Cita 1 Error"){
				   			$("#responsive-modal-edit #msj").html('');
				   			$("#responsive-modal-edit #msj").html("<li>Asegúrese de que el tipo de cita sea el correcto, ya que el paciente actualmente cuenta con una historia médica registrada.</li>");
				   			$("#responsive-modal-edit #msj-error").fadeIn();
						}else{
							if(data.mensaje == "Tipo Cita 2 Error"){
					   			$("#responsive-modal-edit #msj").html('');
					   			$("#responsive-modal-edit #msj").html("<li>Asegúrese de que el tipo de cita sea el correcto, ya que el paciente actualmente no cuenta con una historia médica registrada para tener una cita de tipo Control/Consulta.</li>");
					   			$("#responsive-modal-edit #msj-error").fadeIn();
							}else{
								if(data.mensaje == "Tipo Cita 3 Error"){
						   			$("#responsive-modal-edit #msj").html('');
						   			$("#responsive-modal-edit #msj").html("<li>Asegúrese de que el tratamiento escogido sea el correcto, ya que el paciente actualmente no cuenta con dicho tratamiento asignado o activo.</li>");
						   			$("#responsive-modal-edit #msj-error").fadeIn();
								}
							}
						}
					}
				}
			}		
		},

		error:function(msj){

			$('#cargando').hide();

			var response = JSON.parse(msj.responseText);
	        var errorString = '<ul>';
	        $.each( response.errors, function(key, value) {
	            errorString += '<li>' + value + '</li>';
	        });
	        errorString += '</ul>';
	        $("#responsive-modal-edit #msj").html(errorString);

		    $("#responsive-modal-edit #msj-error").fadeIn();
		}
	});

});

$("#responsive-modal-edit #cancelar").click(function(){

	//al cancelar una edicion de cita, que se pongan en blanco de nuevo los campos
	$("#responsive-modal-edit #msj").html('');
	$("#responsive-modal-edit #msj-error").fadeOut();
	$("#responsive-modal-edit #paciente_id").val('');
	$("#responsive-modal-edit #pacienteIdAgenda").val('');
	$("#responsive-modal-edit #pacienteNuevo").hide();
	$("#responsive-modal-edit #pacienteViejo").show();
	$("#responsive-modal-edit #pacienteNuevoCheck").prop('checked', false);
	$("#responsive-modal-edit #tratamientoSesion").hide();
});

//Gestion el borrado de las citas
$("#eliminar").click(function(){

	swal({
      title: 'Eliminar Cita',
      text: 'Desea eliminar esta cita?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Si',
      closeOnConfirm: false
    },
    function(isConfirm){
      if(isConfirm){

      	$('#cargando').show();

        var token = $("#responsive-modal-edit #token").val();

		var cita = $("#citaId").val();

		var route = "/panel/agenda/eliminar/"+cita;

		$.ajax({

			url: route,
			headers: {'X-CSRF-TOKEN': token},
			type: 'DELETE',
			dataType: 'json',
			success:function(data){

				$('#cargando').hide();

				if(data.mensaje == "Ok"){
					swal({
		              title: 'Cita Eliminada Correctamente',
		              type: 'success',
		            },
		            function(isConfirm){
		              if(isConfirm){
		                window.location.href = "/panel/agenda/mostrar";
		                return false;
		              }
		            });
				}		
			}
		});
        
        return false;
      }
    });
});