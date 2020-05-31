// global variable
var table;
var token = $('#token').val();

//DATATABLE
table = $("#manageMemberTable").DataTable({
    'responsive': true,
    'processing': true,
    'serverSide': true,
    'paging': true,
    'info': true,
    'filter': true,
    'ajax': {
        "url": "/panel/paciente/datatable",
        "type": "POST",
        'headers': {
            'X-CSRF-TOKEN': token
        }
    },
    'columns': [{
            data: 'nombreidenti'
        },
        {
            data: 'datoscontacto'
        },
        {
            data: 'domicilio'
        },
        {
            data: 'edad'
        },
        {
            data: 'creado'
        }
    ],
    "columnDefs": [{
        "targets": [5],
        "data": "id",
        "visible": true,
        "className": "td_defecto",
        "render": function (data, type, row) {
            return '<a title="Editar" class="btn btn-warning"><i class="fa fa-pencil-square-o" title="Editar" style="display:table;margin:0 auto" onclick="editMember(' + data + ')" data-toggle="modal" data-target="#responsive-modal-edit" aria-hidden="true"></i></a>';
        }
    }],
    'language': {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
//END DATATABLE

//GESTION DE LA CREACION DE CITAS
function createMember() {
    
}

$("#registro").click(function(){

    $('#cargando').show();

    var token = $("#responsive-modal-create #token").val();

    var identificacion = $("#responsive-modal-create #identificacion").val();
    var tipoIdentificacion = $("#responsive-modal-create #tipoId").val();
    var nombres = $("#responsive-modal-create #nombres").val();
    var apellidos = $("#responsive-modal-create #apellidos").val();
    var fechaNacimiento = $("#responsive-modal-create #fechaNacimiento").val();
    var genero = $("#responsive-modal-create #genero").val();
    var hijos = $("#responsive-modal-create #hijos").val();
    var estadoCivil = $("#responsive-modal-create #estadoCivil").val();
    var telefonoFijo = $("#responsive-modal-create #telefonoFijo").val();
    var telefonoCelular = $("#responsive-modal-create #telefonoCelular").val();
    var ciudad = $("#responsive-modal-create #ciudad_id").val();
    var direccion = $("#responsive-modal-create #direccion").val();
    var ubicacion = $("#responsive-modal-create #ubicacion").val();
    var email = $("#responsive-modal-create #email").val();
    var eps = $("#responsive-modal-create #eps_id").val();
    var ocupacion = $("#responsive-modal-create #ocupacion").val();

    var route = "/panel/paciente/almacenar"; 

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {identificacion:identificacion, tipoId:tipoIdentificacion, nombres:nombres, apellidos:apellidos, fechaNacimiento:fechaNacimiento, genero:genero, hijos:hijos, estadoCivil:estadoCivil, telefonoFijo:telefonoFijo, telefonoCelular:telefonoCelular, ciudad_id:ciudad, direccion:direccion, ubicacion:ubicacion, email:email, eps_id:eps, ocupacion:ocupacion},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Paciente Creado Correctamente',
                  type: 'success',
                },
                function(isConfirm){
                  if(isConfirm){
                    // limpiar los campos
                    limpiarInputsCreate();
                    // ocultar el modal
                    $("#responsive-modal-create").modal('hide');
                    // atualizar la datatable
                    table.ajax.reload(null, false); 
                    return false;
                  }
                });
            }else{
                $("#responsive-modal-create #msj").html('');
                $("#responsive-modal-create #msj").html("<li>Se a presentado un problema en la base de datos. Favor intentar después.</li>");
                $("#responsive-modal-create #msj-error").fadeIn();
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
    limpiarInputsCreate();
});


function limpiarInputsCreate(){
    //que se pongan en blanco de nuevo los campos
    $("#responsive-modal-create #msj").html('');
    $("#responsive-modal-create #msj-error").fadeOut();
    $("#responsive-modal-create #identificacion").val('');
    $("#responsive-modal-create #tipoId").val('');
    $("#responsive-modal-create #nombres").val('');
    $("#responsive-modal-create #apellidos").val('');
    $("#responsive-modal-create #fechaNacimiento").val('');
    $("#responsive-modal-create #genero").val('');
    $("#responsive-modal-create #hijos").val('');
    $("#responsive-modal-create #estadoCivil").val('');
    $("#responsive-modal-create #telefonoFijo").val('');
    $("#responsive-modal-create #telefonoCelular").val('');
    $("#responsive-modal-create #ciudadId").val('');
    $("#responsive-modal-create #ciudad_id").val('');
    $("#responsive-modal-create #direccion").val('');
    $("#responsive-modal-create #ubicacion").val('');
    $("#responsive-modal-create #email").val('');
    $("#responsive-modal-create #epsId").val('');
    $("#responsive-modal-create #eps_id").val('');
    $("#responsive-modal-create #ocupacion").val('');
}

$('#responsive-modal-create #identificacion').blur(function () {

    if ($('#responsive-modal-create #identificacion').val() != "") {
        var identificacion = $('#responsive-modal-create #identificacion').val();
        var route = "/panel/paciente/existencia/" + identificacion;

        $.get(route, function (res) {
            if (res.identificacion != null) {
                swal({
                    title: 'Paciente existente',
                    text: 'El número de identificación que acaba de ingresar ya se encuentra registrado en el sistema.',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: true
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $('#responsive-modal-create #identificacion').val('');
                    }
                });
            }
        });
    }
});

//GESTION DE LA EDICION DE CITAS
function editMember(id) {
    var token = $("#responsive-modal-edit #token").val();

    var route = "/panel/paciente/edicion/"+id;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            $("#responsive-modal-edit #pacienteId").val(data.id);
            $("#responsive-modal-edit #identificacion").val(data.identificacion);
            $("#responsive-modal-edit #tipoId").val(data.tipoId);
            $("#responsive-modal-edit #nombres").val(data.nombres);
            $("#responsive-modal-edit #apellidos").val(data.apellidos);
            $("#responsive-modal-edit #fechaNacimiento").val(data.fechaNacimiento);
            $("#responsive-modal-edit #genero").val(data.genero);
            $("#responsive-modal-edit #hijos").val(data.hijos);
            $("#responsive-modal-edit #estadoCivil").val(data.estadoCivil);
            $("#responsive-modal-edit #telefonoFijo").val(data.telefonoFijo);
            $("#responsive-modal-edit #telefonoCelular").val(data.telefonoCelular);
            $("#responsive-modal-edit #ciudadId").val(data.ciudad["nombre"] + " (" + data.ciudad["departamento"]["nombre"] + ")");//esto graias al "with" en los modelos de paciente y ciudad
            $("#responsive-modal-edit #ciudad_id").val(data.ciudad_id);
            $("#responsive-modal-edit #direccion").val(data.direccion);
            $("#responsive-modal-edit #ubicacion").val(data.ubicacion);
            $("#responsive-modal-edit #email").val(data.email);
            $("#responsive-modal-edit #epsId").val(data.eps["nombre"]);
            $("#responsive-modal-edit #eps_id").val(data.eps_id);
            $("#responsive-modal-edit #ocupacion").val(data.ocupacion);
        }
    });

    //Para llenar la info de los acompanantes
    var route2 = "/panel/paciente/acompanantes/"+id;

    $.ajax({

        url: route2,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            $.each(data, function(i, acompanante){

                var telefonos = "";
                var btnEditar = "";
                var permisoGestionar = $("#permisoGestionar").val();

                if(acompanante.telefonoFijo != ''){
                    telefonos = acompanante.telefonoFijo + "<br>";
                }
                if(acompanante.telefonoCelular != ''){
                    telefonos = telefonos + acompanante.telefonoCelular + "<br>";
                }

                if(permisoGestionar == "1"){//tiene el permiso
                    btnEditar = '<a title="Editar" target="_blank" href="/panel/acompanante/edicion/' + acompanante.id + '/' + id + '" class="btn btn-warning"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
                }else{//no tiene el permiso
                    btnEditar = "";
                }

                $("#acompanantesContent").append("<tr><td>"+acompanante.acompanante+"</td><td>"+telefonos+"</td><td>"+acompanante.parentesco+"</td><td style='text-align: center;'>"+btnEditar+"</td></tr>");
            });

            if(data == ""){
                $("#acompanantesContent").append("<tr><td colspan='4' style='text-align:center;'>No tiene</td></tr>");
            }
        }
    });
}

$("#edicion").click(function(){

    $('#cargando').show();

    var token = $("#responsive-modal-edit #token").val();
    var paciente = $("#pacienteId").val();

    var identificacion = $("#responsive-modal-edit #identificacion").val();
    var tipoIdentificacion = $("#responsive-modal-edit #tipoId").val();
    var nombres = $("#responsive-modal-edit #nombres").val();
    var apellidos = $("#responsive-modal-edit #apellidos").val();
    var fechaNacimiento = $("#responsive-modal-edit #fechaNacimiento").val();
    var genero = $("#responsive-modal-edit #genero").val();
    var hijos = $("#responsive-modal-edit #hijos").val();
    var estadoCivil = $("#responsive-modal-edit #estadoCivil").val();
    var telefonoFijo = $("#responsive-modal-edit #telefonoFijo").val();
    var telefonoCelular = $("#responsive-modal-edit #telefonoCelular").val();
    var ciudad = $("#responsive-modal-edit #ciudad_id").val();
    var direccion = $("#responsive-modal-edit #direccion").val();
    var ubicacion = $("#responsive-modal-edit #ubicacion").val();
    var email = $("#responsive-modal-edit #email").val();
    var eps = $("#responsive-modal-edit #eps_id").val();
    var ocupacion = $("#responsive-modal-edit #ocupacion").val();

    var route = "/panel/paciente/editar/"+paciente;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {identificacion:identificacion, tipoId:tipoIdentificacion, nombres:nombres, apellidos:apellidos, fechaNacimiento:fechaNacimiento, genero:genero, hijos:hijos, estadoCivil:estadoCivil, telefonoFijo:telefonoFijo, telefonoCelular:telefonoCelular, ciudad_id:ciudad, direccion:direccion, ubicacion:ubicacion, email:email, eps_id:eps, ocupacion:ocupacion},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Paciente Editado Correctamente',
                  type: 'success',
                },
                function(isConfirm){
                  if(isConfirm){
                    // limpiar los campos
                    limpiarInputsEdit();
                    // ocultar el modal
                    $("#responsive-modal-edit").modal('hide');
                    // atualizar la datatable
                    table.ajax.reload(null, false); 
                    return false;
                  }
                });
            }else{
                $("#responsive-modal-edit #msj").html('');
                $("#responsive-modal-edit #msj").html("<li>Se a presentado un problema en la base de datos. Favor intentar después.</li>");
                $("#responsive-modal-edit #msj-error").fadeIn();
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
    limpiarInputsEdit();
});


function limpiarInputsEdit(){
    //que se pongan en blanco de nuevo los campos
    $("#responsive-modal-edit #msj").html('');
    $("#responsive-modal-edit #msj-error").fadeOut();
    $("#responsive-modal-edit #identificacion").val('');
    $("#responsive-modal-edit #tipoId").val('');
    $("#responsive-modal-edit #nombres").val('');
    $("#responsive-modal-edit #apellidos").val('');
    $("#responsive-modal-edit #fechaNacimiento").val('');
    $("#responsive-modal-edit #genero").val('');
    $("#responsive-modal-edit #hijos").val('');
    $("#responsive-modal-edit #estadoCivil").val('');
    $("#responsive-modal-edit #telefonoFijo").val('');
    $("#responsive-modal-edit #telefonoCelular").val('');
    $("#responsive-modal-edit #ciudadId").val('');
    $("#responsive-modal-edit #ciudad_id").val('');
    $("#responsive-modal-edit #direccion").val('');
    $("#responsive-modal-edit #ubicacion").val('');
    $("#responsive-modal-edit #email").val('');
    $("#responsive-modal-edit #epsId").val('');
    $("#responsive-modal-edit #eps_id").val('');
    $("#responsive-modal-edit #ocupacion").val('');
    $("#responsive-modal-edit #acompanantesContent").html('');
}