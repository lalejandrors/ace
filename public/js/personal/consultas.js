$(document).ready(function () { 

    //gestion del select de consultas
    $("#selectConsulta").on('change', function() {

        //volver todo por default en cada change
        $("#contenedorTablaConsultas").html("");
        $("#divResultadoConsultas").hide();
        $("#divSinResultados").hide();
        $("#generoConsulta1").val(1);
        $("#edadMinimaConsulta1").val("");
        $("#edadMaximaConsulta1").val("");
        $("#ciudadConsulta2").val("");//limpiamos el autocomplete con su hidden
        $("#ciudadConsulta_2").val("");
        $("#edadMinimaConsulta3").val("");
        $("#edadMaximaConsulta3").val("");
        $("#cie10Consulta5").val("");//limpiamos el autocomplete con su hidden
        $("#cie10Consulta_5").val("");
        $("#tratamientoConsulta6").val("");//limpiamos el autocomplete con su hidden
        $("#tratamientoConsulta_6").val("");
        $("#eleccionConsulta6").val(1);
        $("#tratamientoConsulta7").val("");//limpiamos el autocomplete con su hidden
        $("#tratamientoConsulta_7").val("");

        if($("#selectConsulta").val() == '1') {
            $("#divFormConsulta1").show();
            $("#divFormConsulta2").hide();
            $("#divFormConsulta3").hide();
            $("#divFormConsulta4").hide();
            $("#divFormConsulta5").hide();
            $("#divFormConsulta6").hide();
            $("#divFormConsulta7").hide();
        }

        if($("#selectConsulta").val() == '2') {
            $("#divFormConsulta2").show();
            $("#divFormConsulta1").hide();
            $("#divFormConsulta3").hide();
            $("#divFormConsulta4").hide();
            $("#divFormConsulta5").hide();
            $("#divFormConsulta6").hide();
            $("#divFormConsulta7").hide();
        }

        if($("#selectConsulta").val() == '3') {
            $("#divFormConsulta3").show();
            $("#divFormConsulta1").hide();
            $("#divFormConsulta2").hide();
            $("#divFormConsulta4").hide();
            $("#divFormConsulta5").hide();
            $("#divFormConsulta6").hide();
            $("#divFormConsulta7").hide();
        } 

        if($("#selectConsulta").val() == '4') {
            $("#divFormConsulta4").show();
            $("#divFormConsulta1").hide();
            $("#divFormConsulta2").hide();
            $("#divFormConsulta3").hide();
            $("#divFormConsulta5").hide();
            $("#divFormConsulta6").hide();
            $("#divFormConsulta7").hide();
        }

        if($("#selectConsulta").val() == '5') {
            $("#divFormConsulta5").show();
            $("#divFormConsulta1").hide();
            $("#divFormConsulta2").hide();
            $("#divFormConsulta3").hide();
            $("#divFormConsulta4").hide();
            $("#divFormConsulta6").hide();
            $("#divFormConsulta7").hide();
        }

        if($("#selectConsulta").val() == '6') {
            $("#divFormConsulta6").show();
            $("#divFormConsulta1").hide();
            $("#divFormConsulta2").hide();
            $("#divFormConsulta3").hide();
            $("#divFormConsulta4").hide();
            $("#divFormConsulta5").hide();
            $("#divFormConsulta7").hide();
        }

        if($("#selectConsulta").val() == '7') {
            $("#divFormConsulta7").show();
            $("#divFormConsulta1").hide();
            $("#divFormConsulta2").hide();
            $("#divFormConsulta3").hide();
            $("#divFormConsulta4").hide();
            $("#divFormConsulta5").hide();
            $("#divFormConsulta6").hide();
        }   
    });

    //gestion de las consultas ajax
    //consulta1
    $("#botonConsulta1").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var genero = $("#generoConsulta1").val();
        var edadMinima = parseInt($("#edadMinimaConsulta1").val());
        var edadMaxima = parseInt($("#edadMaximaConsulta1").val());
        var listadoEmails = '';

        //validamos que se hayan llenado los campos necesarios para la consulta
        if($("#edadMinimaConsulta1").val() == "" || $("#edadMaximaConsulta1").val() == "" || edadMinima > edadMaxima || edadMaxima < 1 || edadMinima > 999 || edadMaxima > 999 || edadMinima < 0 || edadMaxima < 0){
            
            $('#cargando').hide();
            $("#divResultadoConsultas").hide();

            swal({
                title: 'Revise los datos',
                text: 'Asegúrese de que llenó todos los datos necesarios para la consulta, y que estos concuerdan con lo solicitado.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Entendido',
                closeOnConfirm: true
            });

            return false;
        }

        var route = "/panel/informe/consulta1/"+genero+"/"+edadMinima+"/"+edadMaxima;

        $.get(route, function(res){
            if(res != null){

                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });
                
                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

    //consulta2
    $("#botonConsulta2").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var ciudad = $("#ciudadConsulta2").val();
        var listadoEmails = '';

        //validamos que se hayan llenado los campos necesarios para la consulta
        if(ciudad == ""){
            
            $('#cargando').hide();
            $("#divResultadoConsultas").hide();

            swal({
                title: 'Revise los datos',
                text: 'Asegúrese de que llenó todos los datos necesarios para la consulta, y que estos concuerdan con lo solicitado.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Entendido',
                closeOnConfirm: true
            });

            return false;
        }

        var route = "/panel/informe/consulta2/"+ciudad;

        $.get(route, function(res){
            if(res != null){

                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });

                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

    //consulta3
    $("#botonConsulta3").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var edadMinima = parseInt($("#edadMinimaConsulta3").val());
        var edadMaxima = parseInt($("#edadMaximaConsulta3").val());
        var listadoEmails = '';

        //validamos que se hayan llenado los campos necesarios para la consulta
        if($("#edadMinimaConsulta3").val() == "" || $("#edadMaximaConsulta3").val() == "" || edadMinima > edadMaxima || edadMaxima < 1 || edadMinima > 999 || edadMaxima > 999 || edadMinima < 0 || edadMaxima < 0){
            
            $('#cargando').hide();
            $("#divResultadoConsultas").hide();

            swal({
                title: 'Revise los datos',
                text: 'Asegúrese de que llenó todos los datos necesarios para la consulta, y que estos concuerdan con lo solicitado.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Entendido',
                closeOnConfirm: true
            });

            return false;
        }

        var route = "/panel/informe/consulta3/"+edadMinima+"/"+edadMaxima;

        $.get(route, function(res){
            if(res != null){

                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });

                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

    //consulta4
    $("#botonConsulta4").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var eleccion = 0;
        var listadoEmails = '';

        if($("#eleccionSemanaConsulta4").is(':checked')){
            eleccion = 1;
        }else{
            eleccion = 2;
        }

        var route = "/panel/informe/consulta4/"+eleccion;

        $.get(route, function(res){
            if(res != null){
                
                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });
                
                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

    //consulta5
    $("#botonConsulta5").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var cie10 = $("#cie10Consulta5").val();
        var listadoEmails = '';

        //validamos que se hayan llenado los campos necesarios para la consulta
        if(cie10 == ""){
            
            $('#cargando').hide();
            $("#divResultadoConsultas").hide();

            swal({
                title: 'Revise los datos',
                text: 'Asegúrese de que llenó todos los datos necesarios para la consulta, y que estos concuerdan con lo solicitado.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Entendido',
                closeOnConfirm: true
            });

            return false;
        }

        var route = "/panel/informe/consulta5/"+cie10;

        $.get(route, function(res){
            if(res != null){
                
                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });
                
                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

    //consulta6
    $("#botonConsulta6").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var tratamiento = $("#tratamientoConsulta6").val();
        var eleccion = $("#eleccionConsulta6").val();
        var listadoEmails = '';

        //validamos que se hayan llenado los campos necesarios para la consulta
        if(tratamiento == "" || eleccion == ""){
            
            $('#cargando').hide();
            $("#divResultadoConsultas").hide();

            swal({
                title: 'Revise los datos',
                text: 'Asegúrese de que llenó todos los datos necesarios para la consulta, y que estos concuerdan con lo solicitado.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Entendido',
                closeOnConfirm: true
            });

            return false;
        }

        var route = "/panel/informe/consulta6/"+tratamiento+"/"+eleccion;

        $.get(route, function(res){
            if(res != null){
                
                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });
                
                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

    //consulta7
    $("#botonConsulta7").on('click', function() {

        //Añadimos la imagen de carga en el contenedor
        $('#cargando').show();

        $("#contenedorTablaConsultas").html("");
        $("#listadoEmails").attr("href", "");

        var tratamiento = $("#tratamientoConsulta7").val();
        var eleccion = $("#eleccionConsulta7").val();
        var listadoEmails = '';

        //validamos que se hayan llenado los campos necesarios para la consulta
        if(tratamiento == "" || eleccion == ""){
            
            $('#cargando').hide();
            $("#divResultadoConsultas").hide();

            swal({
                title: 'Revise los datos',
                text: 'Asegúrese de que llenó todos los datos necesarios para la consulta, y que estos concuerdan con lo solicitado.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Entendido',
                closeOnConfirm: true
            });

            return false;
        }

        var route = "/panel/informe/consulta7/"+tratamiento;

        $.get(route, function(res){
            if(res != null){
                
                $('#cargando').hide();
                var contador = 0;//contador para saber si se encuentran resultados o no

                $("#contenedorTablaConsultas").append("<table class='data-table table table-bordered table-hover' id='tablaConsultas'><thead><tr><th>Nombre e identificación</th><th>Domicilio</th><th>Edad</th><th>Creado</th><th>Acciones</th></tr></thead><tbody id='cuerpoTablaConsultas'></tbody></table>");
                $(res).each(function(key,value){
                    contador++;
                    $("#cuerpoTablaConsultas").append("<tr><td>"+value.nombres+" "+value.apellidos+"<br>("+value.identificacion+")</td><td>"+value.direccion+"<br>"+value.ciudad+" ("+value.departamento+")"+"</td><td>"+value.fechaNacimiento+"<br>"+value.edad+" años"+"</td><td>"+value.created_at+"</td><td style='text-align: center;'><a title='Ver' target='_blank' href='/panel/paciente/ver/"+value.id+"' class='btn btn-primary btnAcciones'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>");
                    listadoEmails = listadoEmails + value.email + ',';
                });
                
                if(contador > 0){//si se encontraron resultados

                    $("#divResultadoConsultas").show();
                    $("#divSinResultados").hide();
                    //asignamos al enlace al form de redactar correo, la ruta con el parametro de la lista de los correos
                    $("#listadoEmails").attr("href", "/panel/informe/sender/"+listadoEmails);
                    //aca activamos la paginacion, despues de que nuestra tabla ya fue llenada
                    $('#tablaConsultas').paginate({
                        limit: 4,
                        previous: false,
                        next: false,
                    });
                }else{
                    $("#divResultadoConsultas").hide();
                    $("#divSinResultados").show();
                }
            }
        });
    });

})