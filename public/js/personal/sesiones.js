$(document).ready(function () {

    //activamos el nuevo input de fecha
    $(".datepickermindynamic").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy/mm/dd',
        minDate: '0'
    });

    //funcion que se ejecuta al sacar de foco a identificacion, y mediante ajax busca que del paciente de quien es el documento, se tenga ya una historia clinica registrada
    $('#paciente_id input').blur( function() {
        var pacienteId = $('#sesiones__paciente_id').val();

        if(pacienteId != ''){//si hay algo realmente cargado en el autocomplete
            var route = "/panel/historia/existencia/"+pacienteId;

            $.get(route, function(res){
                if(res.paciente_id == null){
                    swal({
                        title: 'Historia inexistente',
                        text: 'El paciente que acaba de seleccionar no cuenta con una historia clínica registrada en el sistema.',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Ok',
                        closeOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            //limpiamos el autocomplete con su hidden
                            $('#sesiones__paciente_id').val('');
                            $('#pacienteId').val('');
                        }
                    });
                }else{
                    //aca cargamos los datos traidos en los campos readonly
                    var route = "/panel/historia/paciente/"+pacienteId;

                    $.get(route, function(res){
                        $('#paci_identificacion').val(res.identificacion);
                        $('#paci_tipoId').val(res.tipoId);
                        $('#paci_nombres').val(res.nombres);
                        $('#paci_apellidos').val(res.apellidos);
                        $('#paci_edad').val(res.edad);
                        $('#paci_genero').val(res.genero);
                        $('#paci_hijos').val(res.hijos);
                        $('#paci_estadoCivil').val(res.estadoCivil);
                        $('#paci_telefonoFijo').val(res.telefonoFijo);
                        $('#paci_telefonoCelular').val(res.telefonoCelular);
                        $('#paci_ciudad_id').val(res.ciudad + ' (' + res.departamento + ')');
                        $('#paci_direccion').val(res.direccion);
                        $('#paci_ubicacion').val(res.ubicacion);
                        $('#paci_email').val(res.email);
                        $('#paci_eps_id').val(res.eps);
                        $('#paci_ocupacion').val(res.ocupacion);
                    });
                }
            });
        }
    });

    //funcion que deshabilita el input de autocomplete tratamiento, en caso que se borre el campo de autocomplete paciente
    $("#pacienteId").change(function() {
        if($("#pacienteId").val() == ''){
            $("#tratamientoId").prop('disabled', true);
        }
    });

    //funcion que se ejecuta al sacar de foco de tratamiento, y mediante ajax busca que ese tratamiento este asignado actualmente al paciente seleccionado
    var itemFormulaTratamientoId = 0;
    var numeroVez = 0;
    var numeroSesiones = 0;
    $('#tratamiento_id input').blur( function() {
        var pacienteId = $('#sesiones__paciente_id').val();
        var tratamientoId = $('#sesiones__tratamiento_id').val();

        if(pacienteId != '' && tratamientoId != ''){//si hay algo realmente cargado en los autocomplete
            var route = "/panel/sesion/asignacion/"+pacienteId+"/"+tratamientoId;

            $.get(route, function(res){
                if(res.tratamiento_id == null){
                    swal({
                        title: 'Tratamiento no Asignado',
                        text: 'El tratamiento que acaba de seleccionar no se encuentra asignado al paciente.',
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#DD6B55',
                        confirmButtonText: 'Ok',
                        closeOnConfirm: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            //limpiamos el autocomplete con su hidden
                            $('#sesiones__tratamiento_id').val('');
                            $('#tratamientoId').val('');
                            $('#numeroSesion').text('');
                            $('#numeroSesion').hide();
                        }
                    });
                }else{
                    //si esta asignado el tratamiento, mostramos el numero de la sesion en la que estamos actualmente
                    itemFormulaTratamientoId = res.idItem;
                    numeroVez = parseInt(res.sesionesRealizadas) + 1;
                    numeroSesiones = res.numeroSesiones;
                    $('#numeroSesion').text('Sesión #' + numeroVez + ' de ' + numeroSesiones);
                    $('#numeroSesion').show();
                }
            });
        }
    });

    //para la gestion de acompanantes
    $('#acompananteExistenteCheck').change(function() {
        if($(this).is(":checked")) {
            $("#formAcompananteExistente").show();
            $("#formAcompanante").hide();
            $("#acompanantes__identificacion").val('');
            $("#acompanantes__tipoId").val('');
            $("#acompanantes__nombres").val('');
            $("#acompanantes__apellidos").val('');
            $("#acompanantes__telefonoFijo").val('');
            $("#acompanantes__telefonoCelular").val('');
            $("#nuevo_parentesco").val('');
        }else{
            $("#formAcompanante").show();
            $("#formAcompananteExistente").hide();
            $("#sesiones__acompanante_id").val('');
            $("#acompananteId").val('');
            $("#existente_parentesco").val('');
            $("#acom_identificacion").val('');
            $("#acom_tipoId").val('');
            $("#acom_nombres").val('');
            $("#acom_apellidos").val('');
            $("#acom_telefonoFijo").val('');
            $("#acom_telefonoCelular").val('');
        }      
    });

    //funcion que se ejecuta al sacar de foco a identificacion, y mediante ajax busca que del acompanante de quien es el documento
    $('#acompanante_id input').blur( function() {

        var acompananteId = $('#sesiones__acompanante_id').val();

        if(acompananteId != ''){//si hay algo realmente cargado en el autocomplete

            //aca cargamos los datos traidos en los campos readonly
            var route = "/panel/historia/acompanante/"+acompananteId;

            $.get(route, function(res){
                $('#acom_identificacion').val(res.identificacion);
                $('#acom_tipoId').val(res.tipoId);
                $('#acom_nombres').val(res.nombres);
                $('#acom_apellidos').val(res.apellidos);
                $('#acom_telefonoFijo').val(res.telefonoFijo);
                $('#acom_telefonoCelular').val(res.telefonoCelular);
            });
        }
    });

    //para guardar los datos de la sesion
    $("#registro").click(function(){

        var token = $("#token").val();

        var sesiones__paciente_id = $("#sesiones__paciente_id").val();
        var sesiones__acompanante_id = $("#sesiones__acompanante_id").val();
        var sesiones__observacion = $("#sesiones__observacion").val();

        var acompanantes__identificacion = $("#acompanantes__identificacion").val();
        var acompanantes__tipoId = $("#acompanantes__tipoId").val();
        var acompanantes__nombres = $("#acompanantes__nombres").val();
        var acompanantes__apellidos = $("#acompanantes__apellidos").val();
        var acompanantes__telefonoFijo = $("#acompanantes__telefonoFijo").val();
        var acompanantes__telefonoCelular = $("#acompanantes__telefonoCelular").val();

        var existente_parentesco = $("#existente_parentesco").val();
        var nuevo_parentesco = $("#nuevo_parentesco").val();
        var paci_identificacion = $("#paci_identificacion").val();

        //aca armamos el array con los diagnosticos ingresados
        var diagnosticos = [];
        var numeroDiagnosticos = $("#numeroDiagnosticos").val();

        if($("#diagnostico_id1").val() != "" && numeroDiagnosticos > 0){//si se agrego almenos el primer diagnostico

            if($("#diagnostico_id" + numeroDiagnosticos).val() != ""){//verificamos que el ultimo agregado, tenga realmente un valor asignado
                for(var i=1; i <= numeroDiagnosticos; i++){
                    diagnosticos[i-1] = $("#diagnostico_id" + i).val();
                }
            }else{//cuando el ultimo agregado no se lleno con nada, se ignora
                for(var i=1; i <= numeroDiagnosticos-1; i++){
                    diagnosticos[i-1] = $("#diagnostico_id" + i).val();
                }
            }

            //ahora se debe validar que los diagnosticos no se repitan en el array
            $contadorDiagnosticosDuplicados = 0;

            for(var i=0; i < diagnosticos.length; i++){
                for(var j=0; j < diagnosticos.length; j++){
                    if(diagnosticos[i] == diagnosticos[j]){
                        $contadorDiagnosticosDuplicados = $contadorDiagnosticosDuplicados + 1;
                    }
                }
            }

            if($contadorDiagnosticosDuplicados > diagnosticos.length){//si el valor del contador supera el numero de diagnosticos agregados al array, es que alguno de ellos esta repetido en dicho array
                $("#msj").html('');
                $("#msj").html("<li>Uno o varios de los diagnósticos se encuentran agregados más de una vez en esta sesión.</li>");
                $("#msj-error").fadeIn();
                window.scrollTo(0, 0);
                return false;
            }
        }

        //aca armamos el array con los items de formula medica ingresados (medicamentos)
        var itemsMedicamento = [];
        var itemsCantidad = [];
        var itemsDosisFrecuencia = [];
        var itemsHoras = [];
        var itemsDuracion = [];
        var itemsVia = [];
        var itemsObservacionFM = [];
        var formulaMedicaHidden = $("#formulaMedicaHidden").val();
        var numeroMedicamentos = $("#numeroMedicamentos").val();

        if($("#formulaMedicaHidden").val() == '1'){//cuando se tiene abierto el div de agregar el registro
            if($("#medicamento_id1").val() != "" && numeroMedicamentos > 0){
                //antes de gestionar una formula medica, de tratamiento o una incapacidad se debe validar que haya almenos un diagnostico ingresado
                if(diagnosticos.length == 0){
                    $("#msj").html('');
                    $("#msj").html("<li>En caso que se desee registrar una formula médica, una formulación de tratamiento o una incapacidad médica debe haber como mínimo un diagnóstico ingresado.</li>");
                    $("#msj-error").fadeIn();
                    window.scrollTo(0, 0);
                    return false;
                }

                //se revisa si el ultimo item esta vacio para ignorarlo, si tiene agregado almenos uno de los campos, se manda a validar al server
                if($("#medicamento_id" + numeroMedicamentos).val() == "" && $("#medicamentoCantidad" + numeroMedicamentos).val() == "" && $("#medicamentoDosisFrecuencia" + numeroMedicamentos).val() == "" && $("#medicamentoHoras" + numeroMedicamentos).val() == "" && $("#medicamentoDuracion" + numeroMedicamentos).val() == "" && $("#medicamentoVia" + numeroMedicamentos + " option:selected").val() == ""){//todos los campos vacios
                    for(var i=1; i <= numeroMedicamentos-1; i++){
                        itemsMedicamento[i-1] = $("#medicamento_id" + i).val();
                        itemsCantidad[i-1] = $("#medicamentoCantidad" + i).val();
                        itemsDosisFrecuencia[i-1] = $("#medicamentoDosisFrecuencia" + i).val();
                        itemsHoras[i-1] = $("#medicamentoHoras" + i).val();
                        itemsDuracion[i-1] = $("#medicamentoDuracion" + i).val();
                        itemsVia[i-1] = $("#medicamentoVia" + i + " option:selected").val();
                        itemsObservacionFM[i-1] = $("#medicamentoObservacion" + i).val();
                    }
                }else{
                    for(var i=1; i <= numeroMedicamentos; i++){
                        itemsMedicamento[i-1] = $("#medicamento_id" + i).val();
                        itemsCantidad[i-1] = $("#medicamentoCantidad" + i).val();
                        itemsDosisFrecuencia[i-1] = $("#medicamentoDosisFrecuencia" + i).val();
                        itemsHoras[i-1] = $("#medicamentoHoras" + i).val();
                        itemsDuracion[i-1] = $("#medicamentoDuracion" + i).val();
                        itemsVia[i-1] = $("#medicamentoVia" + i + " option:selected").val();
                        itemsObservacionFM[i-1] = $("#medicamentoObservacion" + i).val();
                    }
                }
            }else{
                $("#msj").html('');
                $("#msj").html("<li>Debe ingresar como mínimo un medicamento antes de registrar la formula médica.</li>");
                $("#msj-error").fadeIn();
                window.scrollTo(0, 0);
                return false;
            }
        }

        //ahora se debe validar que los medicamentos no se repitan en el array
        $contadorMedicamentosDuplicados = 0;

        for(var i=0; i < itemsMedicamento.length; i++){
            for(var j=0; j < itemsMedicamento.length; j++){
                if(itemsMedicamento[i] == itemsMedicamento[j]){
                    $contadorMedicamentosDuplicados = $contadorMedicamentosDuplicados + 1;
                }
            }
        }

        if($contadorMedicamentosDuplicados > itemsMedicamento.length){//si el valor del contador supera el numero de medicamentos agregados al array, es que alguno de ellos esta repetido en dicho array
            $("#msj").html('');
            $("#msj").html("<li>Uno o varios de los medicamentos se encuentran agregados más de una vez en la formula médica.</li>");
            $("#msj-error").fadeIn();
            window.scrollTo(0, 0);
            return false;
        }

        var formulas__observacion = $("#formulas__observacion").val();

        //aca armamos el array con los items de formulacion de tratamientos ingresados (tratamientos)
        var itemsTratamiento = [];
        var itemsNumeroSesiones = [];
        var itemsFechaPosibleTerminacion = [];
        var itemsObservacionFT = [];
        var formulaTratamientoHidden = $("#formulaTratamientoHidden").val();
        var numeroTratamientos = $("#numeroTratamientos").val();

        if($("#formulaTratamientoHidden").val() == '1'){//cuando se tiene abierto el div de agregar el registro
            if($("#tratamiento_id1").val() != "" && numeroTratamientos > 0){
                //antes de gestionar una formula medica, de tratamiento o una incapacidad se debe validar que haya almenos un diagnostico ingresado
                if(diagnosticos.length == 0){
                    $("#msj").html('');
                    $("#msj").html("<li>En caso que se desee registrar una formula médica, una formulación de tratamiento o una incapacidad médica debe haber como mínimo un diagnóstico ingresado.</li>");
                    $("#msj-error").fadeIn();
                    window.scrollTo(0, 0);
                    return false;
                }

                //se revisa si el ultimo item esta vacio para ignorarlo, si tiene agregado almenos uno de los campos, se manda a validar al server
                if($("#tratamiento_id" + numeroTratamientos).val() == "" && $("#tratamientoNumeroSesiones" + numeroTratamientos).val() == "" && $("#tratamientoFechaPosibleTerminacion" + numeroTratamientos).val() == ""){//todos los campos vacios
                    for(var i=1; i <= numeroTratamientos-1; i++){
                        itemsTratamiento[i-1] = $("#tratamiento_id" + i).val();
                        itemsNumeroSesiones[i-1] = $("#tratamientoNumeroSesiones" + i).val();
                        itemsFechaPosibleTerminacion[i-1] = $("#tratamientoFechaPosibleTerminacion" + i).val();
                        itemsObservacionFT[i-1] = $("#tratamientoObservacion" + i).val();
                    }
                }else{
                    for(var i=1; i <= numeroTratamientos; i++){
                        itemsTratamiento[i-1] = $("#tratamiento_id" + i).val();
                        itemsNumeroSesiones[i-1] = $("#tratamientoNumeroSesiones" + i).val();
                        itemsFechaPosibleTerminacion[i-1] = $("#tratamientoFechaPosibleTerminacion" + i).val();
                        itemsObservacionFT[i-1] = $("#tratamientoObservacion" + i).val();
                    }
                }

            }else{
                $("#msj").html('');
                $("#msj").html("<li>Debe ingresar como mínimo un tratamiento antes de registrar la formulación de tratamiento.</li>");
                $("#msj-error").fadeIn();
                window.scrollTo(0, 0);
                return false;
            }
        }

        //ahora se debe validar que los tratamientos no se repitan en el array
        $contadorTratamientosDuplicados = 0;

        for(var i=0; i < itemsTratamiento.length; i++){
            for(var j=0; j < itemsTratamiento.length; j++){
                if(itemsTratamiento[i] == itemsTratamiento[j]){
                    $contadorTratamientosDuplicados = $contadorTratamientosDuplicados + 1;
                }
            }
        }

        if($contadorTratamientosDuplicados > itemsTratamiento.length){//si el valor del contador supera el numero de tratamientos agregados al array, es que alguno de ellos esta repetido en dicho array
            $("#msj").html('');
            $("#msj").html("<li>Uno o varios de los tratamientos se encuentran agregados más de una vez en la formulación de tratamientos.</li>");
            $("#msj-error").fadeIn();
            window.scrollTo(0, 0);
            return false;
        }

        var tratamientos__observacion = $("#tratamientos__observacion").val();
        
        if($("#incapacidadHidden").val() == '1'){
            //antes de gestionar una formula medica, de tratamiento o una incapacidad se debe validar que haya almenos un diagnostico ingresado
            if(diagnosticos.length == 0){
                $("#msj").html('');
                $("#msj").html("<li>En caso que se desee registrar una formula médica, una formulación de tratamiento o una incapacidad médica debe haber como mínimo un diagnóstico ingresado.</li>");
                $("#msj-error").fadeIn();
                window.scrollTo(0, 0);
                return false;
            }
        }
        var incapacidades__fechaFin = $('#incapacidades__fechaFin').val();
        var incapacidades__observacion = $("#incapacidades__observacion").val();
        var incapacidadHidden = $("#incapacidadHidden").val();

        var certificados__contenido = tinyMCE.get('certificados__contenido').getContent();
        var certificados__observacion = $("#certificados__observacion").val();
        var certificadoMedicoHidden = $("#certificadoMedicoHidden").val();

        var consentimientos__contenido = tinyMCE.get('consentimientos__contenido').getContent();
        var consentimientos__observacion = $("#consentimientos__observacion").val();
        var consentimientoInformadoHidden = $("#consentimientoInformadoHidden").val();
        
        var route = "/panel/sesion/almacenar"; 

        $.ajax({

            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'POST',
            dataType: 'json',
            data: {
                sesiones__paciente_id:sesiones__paciente_id,
                sesiones__acompanante_id:sesiones__acompanante_id,
                sesiones__observacion:sesiones__observacion,

                itemFormulaTratamientoId:itemFormulaTratamientoId,
                numeroVez:numeroVez, 
                numeroSesiones:numeroSesiones,

                acompanantes__identificacion:acompanantes__identificacion,
                acompanantes__tipoId:acompanantes__tipoId,
                acompanantes__nombres:acompanantes__nombres,
                acompanantes__apellidos:acompanantes__apellidos,
                acompanantes__telefonoFijo:acompanantes__telefonoFijo,
                acompanantes__telefonoCelular:acompanantes__telefonoCelular,

                existente_parentesco:existente_parentesco,
                nuevo_parentesco:nuevo_parentesco,
                paci_identificacion:paci_identificacion,

                diagnosticos:diagnosticos,

                itemsMedicamento:itemsMedicamento,
                itemsCantidad:itemsCantidad,
                itemsDosisFrecuencia:itemsDosisFrecuencia,
                itemsHoras:itemsHoras,
                itemsDuracion:itemsDuracion,
                itemsVia:itemsVia,
                itemsObservacionFM:itemsObservacionFM,
                formulas__observacion:formulas__observacion,
                formulaMedicaHidden:formulaMedicaHidden,

                itemsTratamiento:itemsTratamiento,
                itemsNumeroSesiones:itemsNumeroSesiones,
                itemsFechaPosibleTerminacion:itemsFechaPosibleTerminacion,
                itemsObservacionFT:itemsObservacionFT,
                tratamientos__observacion:tratamientos__observacion,
                formulaTratamientoHidden:formulaTratamientoHidden,

                incapacidades__fechaFin:incapacidades__fechaFin,
                incapacidades__observacion:incapacidades__observacion,
                incapacidadHidden:incapacidadHidden,

                certificados__contenido:certificados__contenido,
                certificados__observacion:certificados__observacion,
                certificadoMedicoHidden:certificadoMedicoHidden,

                consentimientos__contenido:consentimientos__contenido,
                consentimientos__observacion:consentimientos__observacion,
                consentimientoInformadoHidden:consentimientoInformadoHidden,
            },

            success:function(data){

                if(data.mensaje == "Ok"){
                    swal({
                      title: 'Sesión Creada Correctamente',
                      type: 'success',
                    },
                    function(isConfirm){
                      if(isConfirm){
                        window.location.href = "/panel/sesion/listar";
                        return false;
                      }
                    });
                }else{
                    var mensaje = data.mensaje;
                    if(mensaje.indexOf("ya se encuentra asignado al paciente.") !== -1){//devuelve error cuando se quiere asignar un tratamiento ya asignado actualmente a un paciente
                        $("#msj").html('');
                        $("#msj").html("<li>"+mensaje+"</li>");
                        $("#msj-error").fadeIn();
                    }else{
                        if(data.mensaje == "Tratamiento terminado"){
                            swal({
                              title: 'El Tratamiento ha Finalizado',
                              type: 'success',
                            },
                            function(isConfirm){
                              if(isConfirm){
                                window.location.href = "/panel/sesion/listar";
                                return false;
                              }
                            });
                        }
                    }
                }   
            },

            error:function(msj){

                var response = JSON.parse(msj.responseText);
                var errorString = '<ul>';
                $.each( response.errors, function(key, value) {
                    errorString += '<li>' + value + '</li>';
                });
                errorString += '</ul>';
                $("#msj").html(errorString);

                $("#msj-error").fadeIn();
            }
        });
    });

    //manejo dinamico de los diagnosticos cie10
    var max_diagnosticos = 50;
    var diagnosticosConjunto = $(".diagnosticosConjunto");
    var btnAgregarDiagnostico = $(".btnAgregarDiagnostico");
    
    $(btnAgregarDiagnostico).click(function(e){
        e.preventDefault();

        //guardamos en la variable el numero de diagnosticos agregados
        var diagnosticoActual = $(".tabla_diagnosticos tbody tr").length;

        if(diagnosticoActual < max_diagnosticos){
            if($("#diagnostico_id" + diagnosticoActual).val() != ""){//este if es para que solo cuando el ultimo diagnostico agregado tenga un valor, me deje crear uno nuevo y no estar agregando vacios
                $(diagnosticosConjunto).append('<tr><td><div class="form-group"><input id="' + "diagnostico" + (diagnosticoActual + 1) + '" type="text" class="form-control" placeholder="Nombre o código cie10 de la patología"/><input id="' + "diagnostico_id" + (diagnosticoActual + 1) + '" type="hidden"/></div></td><td class="quitar_diagnostico"><a href="#" style="display: block;text-align: center;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td></tr>');
                //activamos el nuevo input con el plugin de autocomplete. El primer diagnostico se gestiona con el js de autocompletar.js
                $("#diagnostico" + (diagnosticoActual + 1)).autocomplete({
                    maxResults: 10,
                    source:function(request, response){
                        $.ajax({
                            url:"/panel/autocomplete/cie10",
                            dataType:"json",
                            data:{busqueda:request.term},
                            success:function(data){
                                response(data.slice(0, 10));
                            }
                        });
                    },
                    minLength:1,
                    select:function(event, ui){
                        $("#diagnostico_id" + (diagnosticoActual + 1)).val(ui.item.id);
                    }
                });
                //mantenemos actualizado siempre el hidden que cuenta el numero de diagnosticos agregados en todo momento
                $("#numeroDiagnosticos").val($(".tabla_diagnosticos tbody tr").length);
            }
        }
    });
    
    $(diagnosticosConjunto).on("click",".quitar_diagnostico", function(e){
        e.preventDefault(); 
        $(this).parent('tr').remove();
        
        //renombramos los elementos cada que se elimine alguno
        $(".tabla_diagnosticos tbody tr").each(function(i){
            $(this).find("td").eq(0).find("div input[type=text]").attr("id","diagnostico" + (i + 1));
            $(this).find("td").eq(0).find("div input[type=hidden]").attr("id","diagnostico_id" + (i + 1));

            $("#diagnostico" + (i + 1)).autocomplete({
                maxResults: 10,
                source:function(request, response){
                    $.ajax({
                        url:"/panel/autocomplete/cie10",
                        dataType:"json",
                        data:{busqueda:request.term},
                        success:function(data){
                            response(data.slice(0, 10));
                        }
                    });
                },
                minLength:1,
                select:function(event, ui){
                    $("#diagnostico_id" + (i + 1)).val(ui.item.id);
                }
            });
        });

        //mantenemos actualizado siempre el hidden que cuenta el numero de diagnosticos agregados en todo momento
        $("#numeroDiagnosticos").val($(".tabla_diagnosticos tbody tr").length);
    });

    //para habilitar la creacion de una formula medica
    $("#btnAgregarFormulaMedica").click(function(){

        if($("#formulaMedicaHidden").val() == '0'){
            $("#formulaMedicaHidden").val('1');
            $("#agregarFormulaMedica").show();
        }else{
            $("#formulaMedicaHidden").val('0');
            $("#agregarFormulaMedica").hide();
        }
    });

    //manejo dinamico de los items de la formula medica
    var max_medicamentos = 10;
    var medicamentosConjunto = $(".medicamentosConjunto");
    var btnAgregarMedicamento = $(".btnAgregarMedicamento");
    
    $(btnAgregarMedicamento).click(function(e){
        e.preventDefault();

        //guardamos en la variable el numero de formulas agregadas
        var formulaActual = $(".tabla_formulas tbody tr").length;

        if(formulaActual < max_medicamentos){
            if($("#medicamento_id" + formulaActual).val() != "" && $("#medicamentoCantidad" + formulaActual).val() != "" && $("#medicamentoDosisFrecuencia" + formulaActual).val() != "" && $("#medicamentoHoras" + formulaActual).val() != "" && $("#medicamentoDuracion" + formulaActual).val() != "" && $("#medicamentoVia" + formulaActual + " option:selected").val() != ""){//este if es para que solo cuando el ultimo medicamento agregado tenga un valor, me deje crear uno nuevo y no estar agregando vacios
                $(medicamentosConjunto).append('<tr><td><div class="form-group"><input id="' + "medicamento" + (formulaActual + 1) + '" type="text" class="form-control" style="background-color:#F5F5F5;" placeholder="Nombre del medicamento..."/><input id="' + "medicamento_id" + (formulaActual + 1) + '" type="hidden"/></div></td><td><div class="form-group"><input type="number" id="' + "medicamentoCantidad" + (formulaActual + 1) + '" class="form-control" placeholder="Ej: 1 botella, 2 cajas, etc..." min="1" onkeypress="return event.charCode >= 48"></div></td><td><div class="form-group"><input id="' + "medicamentoDosisFrecuencia" + (formulaActual + 1) + '" type="text" class="form-control" placeholder="100 mg cada 6 horas"/></div></td><td><div class="form-group"><input id="' + "medicamentoHoras" + (formulaActual + 1) + '" type="text" class="form-control" placeholder="9 am, 3 pm..."/></div></td><td><div class="form-group"><input type="text" id="' + "medicamentoDuracion" + (formulaActual + 1) + '" class="form-control" placeholder="Ej: 30 días"></div></td><td><div class="form-group"><select id="' + "medicamentoVia" + (formulaActual + 1) + '" class="form-control"><option value="">----------</option><option value="1">Oral</option><option value="2">Sublingual</option><option value="3">Tópica</option><option value="4">Transdérmica</option><option value="5">Oftálmica</option><option value="6">Ótica</option><option value="7">Intranasal</option><option value="8">Inhalatoria</option><option value="9">Rectal</option><option value="10">Vaginal</option><option value="11">Intravenosa</option><option value="12">Intramuscular</option><option value="13">Subcutánea</option></select></div></td><td><div class="form-group"><textarea id="' + "medicamentoObservacion" + (formulaActual + 1) + '" rows="2" class="form-control" placeholder="Observación" style="resize: none;"></textarea></div></td><td class="quitar_medicamento"><a href="#" style="display: block;text-align: center;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td></tr>');
                //activamos el nuevo input con el plugin de autocomplete. El primer medicamento se gestiona con el js de autocompletar.js
                $("#medicamento" + (formulaActual + 1)).autocomplete({
                    maxResults: 10,
                    source:function(request, response){
                        $.ajax({
                            url:"/panel/autocomplete/medicamento",
                            dataType:"json",
                            data:{busqueda:request.term},
                            success:function(data){
                                response(data.slice(0, 10));
                            }
                        });
                    },
                    minLength:1,
                    select:function(event, ui){
                        $("#medicamento_id" + (formulaActual + 1)).val(ui.item.id);
                    }
                });
                //mantenemos actualizado siempre el hidden que cuenta el numero de diagnosticos agregados en todo momento
                $("#numeroMedicamentos").val($(".tabla_formulas tbody tr").length);
            }
        }
    });
    
    $(medicamentosConjunto).on("click",".quitar_medicamento", function(e){
        e.preventDefault(); 
        $(this).parent('tr').remove();
        
        //renombramos los elementos cada que se elimine alguno
        $(".tabla_formulas tbody tr").each(function(i){
            $(this).find("td").eq(0).find("div input[type=text]").attr("id","medicamento" + (i + 1));
            $(this).find("td").eq(0).find("div input[type=hidden]").attr("id","medicamento_id" + (i + 1));
            $(this).find("td").eq(1).find("div input[type=number]").attr("id","medicamentoCantidad" + (i + 1));
            $(this).find("td").eq(2).find("div input[type=text]").attr("id","medicamentoDosisFrecuencia" + (i + 1));
            $(this).find("td").eq(3).find("div input[type=text]").attr("id","medicamentoHoras" + (i + 1));
            $(this).find("td").eq(4).find("div input[type=text]").attr("id","medicamentoDuracion" + (i + 1));
            $(this).find("td").eq(5).find("div select").attr("id","medicamentoVia" + (i + 1));
            $(this).find("td").eq(6).find("div textarea").attr("id","medicamentoObservacion" + (i + 1));

            $("#medicamento" + (i + 1)).autocomplete({
                maxResults: 10,
                source:function(request, response){
                    $.ajax({
                        url:"/panel/autocomplete/medicamento",
                        dataType:"json",
                        data:{busqueda:request.term},
                        success:function(data){
                            response(data.slice(0, 10));
                        }
                    });
                },
                minLength:1,
                select:function(event, ui){
                    $("#medicamento_id" + (i + 1)).val(ui.item.id);
                }
            });
        });

        //mantenemos actualizado siempre el hidden que cuenta el numero de diagnosticos agregados en todo momento
        $("#numeroMedicamentos").val($(".tabla_formulas tbody tr").length);
    });

    //para habilitar la creacion de una formulacion de tratamientos
    $("#btnAgregarFormulaTratamiento").click(function(){

        if($("#formulaTratamientoHidden").val() == '0'){
            $("#formulaTratamientoHidden").val('1');
            $("#agregarFormulaTratamiento").show();
        }else{
            $("#formulaTratamientoHidden").val('0');
            $("#agregarFormulaTratamiento").hide();
        }
    });

    //manejo dinamico de los items de la formulacion de tratamientos
    var max_tratamientos = 10;
    var tratamientosConjunto = $(".tratamientosConjunto");
    var btnAgregarTratamiento = $(".btnAgregarTratamiento");
    
    $(btnAgregarTratamiento).click(function(e){
        e.preventDefault();

        //guardamos en la variable el numero de formulas de tratamiento agregadas
        var formulaTratamientoActual = $(".tabla_formulasTratamiento tbody tr").length;

        if(formulaTratamientoActual < max_tratamientos){
            if($("#tratamiento_id" + formulaTratamientoActual).val() != "" && $("#tratamientoNumeroSesiones" + formulaTratamientoActual).val() != "" && $("#tratamientoFechaPosibleTerminacion" + formulaTratamientoActual).val() != ""){//este if es para que solo cuando el ultimo tratamiento agregado tenga un valor, me deje crear uno nuevo y no estar agregando vacios
                $(tratamientosConjunto).append('<tr><td><div class="form-group"><input id="' + "tratamiento" + (formulaTratamientoActual + 1) + '" type="text" class="form-control" style="background-color:#F5F5F5;" placeholder="Nombre del tratamiento..."/><input id="' + "tratamiento_id" + (formulaTratamientoActual + 1) + '" type="hidden"/></div></td><td><div class="form-group"><input type="number" id="' + "tratamientoNumeroSesiones" + (formulaTratamientoActual + 1) + '" class="form-control" min="1" onkeypress="return event.charCode >= 48"></div></td><td><div class="form-group"><input id="' + "tratamientoFechaPosibleTerminacion" + (formulaTratamientoActual + 1) + '" type="text" class="datepickermindynamic form-control" placeholder="Seleccione una fecha..."/></div></td><td><div class="form-group"><textarea id="' + "tratamientoObservacion" + (formulaTratamientoActual + 1) + '" rows="2" class="form-control" placeholder="Observación" style="resize: none;"></textarea></div></td><td class="quitar_tratamiento"><a href="#" style="display: block;text-align: center;"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a></td></tr>');
                //activamos el nuevo input de fecha
                $(".datepickermindynamic").datepicker({
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy/mm/dd',
                    minDate: '0'
                });
                //activamos el nuevo input con el plugin de autocomplete. El primer tratamiento se gestiona con el js de autocompletar.js
                $("#tratamiento" + (formulaTratamientoActual + 1)).autocomplete({
                    maxResults: 10,
                    source:function(request, response){
                        $.ajax({
                            url:"/panel/autocomplete/tratamiento",
                            dataType:"json",
                            data:{busqueda:request.term},
                            success:function(data){
                                response(data.slice(0, 10));
                            }
                        });
                    },
                    minLength:1,
                    select:function(event, ui){
                        $("#tratamiento_id" + (formulaTratamientoActual + 1)).val(ui.item.id);
                    }
                });
                //mantenemos actualizado siempre el hidden que cuenta el numero de diagnosticos agregados en todo momento
                $("#numeroTratamientos").val($(".tabla_formulasTratamiento tbody tr").length);
            }
        }
    });
    
    $(tratamientosConjunto).on("click",".quitar_tratamiento", function(e){
        e.preventDefault(); 
        $(this).parent('tr').remove();

        //renombramos los elementos cada que se elimine alguno
        $(".tabla_formulasTratamiento tbody tr").each(function(i){
            $(this).find("td").eq(0).find("div input[type=text]").attr("id","tratamiento" + (i + 1));
            $(this).find("td").eq(0).find("div input[type=hidden]").attr("id","tratamiento_id" + (i + 1));
            $(this).find("td").eq(1).find("div input[type=number]").attr("id","tratamientoNumeroSesiones" + (i + 1));
            $(this).find("td").eq(2).find("div input[type=text]").attr("id","tratamientoFechaPosibleTerminacion" + (i + 1));
            $(this).find("td").eq(3).find("div textarea").attr("id","tratamientoObservacion" + (i + 1));

            $("#tratamiento" + (i + 1)).autocomplete({
                maxResults: 10,
                source:function(request, response){
                    $.ajax({
                        url:"/panel/autocomplete/tratamiento",
                        dataType:"json",
                        data:{busqueda:request.term},
                        success:function(data){
                            response(data.slice(0, 10));
                        }
                    });
                },
                minLength:1,
                select:function(event, ui){
                    $("#tratamiento_id" + (i + 1)).val(ui.item.id);
                }
            });
        });

        //mantenemos actualizado siempre el hidden que cuenta el numero de diagnosticos agregados en todo momento
        $("#numeroTratamientos").val($(".tabla_formulasTratamiento tbody tr").length);
    });

    //para habilitar la creacion de una incapacidad
    $("#btnAgregarIncapacidad").click(function(){

        if($("#incapacidadHidden").val() == '0'){
            $("#incapacidadHidden").val('1');
            $("#agregarIncapacidad").show();
        }else{
            $("#incapacidadHidden").val('0');
            $("#agregarIncapacidad").hide();
        }
    });

    //gestion del select de formatos
    $("#formatoIdCertificado").on('change', function() {

        if($("#formatoIdCertificado").val() != ""){
            tinyMCE.get('certificados__contenido').setContent('');
            $("#certificados__observacion").val('');

            var formato = $("#formatoIdCertificado").val();

            var route = "/panel/informe/formato/"+formato;

            $.get(route, function(res){
                if(res != null){
                    $(res).each(function(key,value){
                        tinyMCE.get('certificados__contenido').setContent(value.contenido);
                    });
                }
            });
        }else{
            tinyMCE.get('certificados__contenido').setContent('');
        }
    });

    //para habilitar la creacion de un certificado medico
    $("#btnAgregarCertificadoMedico").click(function(){

        if($("#certificadoMedicoHidden").val() == '0'){
            $("#certificadoMedicoHidden").val('1');
            $("#agregarCertificadoMedico").show();
        }else{
            $("#certificadoMedicoHidden").val('0');
            $("#agregarCertificadoMedico").hide();
        }
    });

    //gestion del select de formatos
    $("#formatoIdConsentimiento").on('change', function() {

        if($("#formatoIdConsentimiento").val() != ""){
            tinyMCE.get('consentimientos__contenido').setContent('');
            $("#consentimientos__observacion").val('');

            var formato = $("#formatoIdConsentimiento").val();

            var route = "/panel/informe/formato/"+formato;

            $.get(route, function(res){
                if(res != null){
                    $(res).each(function(key,value){
                        tinyMCE.get('consentimientos__contenido').setContent(value.contenido);
                    });
                }
            });
        }else{
            tinyMCE.get('consentimientos__contenido').setContent('');
        }
    });

    //para habilitar la creacion de un consentimiento informado
    $("#btnAgregarConsentimientoInformado").click(function(){

        if($("#consentimientoInformadoHidden").val() == '0'){
            $("#consentimientoInformadoHidden").val('1');
            $("#agregarConsentimientoInformado").show();
        }else{
            $("#consentimientoInformadoHidden").val('0');
            $("#agregarConsentimientoInformado").hide();
        }
    });

})