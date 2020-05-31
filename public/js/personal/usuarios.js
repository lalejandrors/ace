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
        "url": "/panel/user/datatable",
        "type": "POST",
        'headers': {
            'X-CSRF-TOKEN': token
        }
    },
    'columns': [{
            data: 'nombre'
        },
        {
            data: 'perfil'
        },
        {
            data: 'estado'
        },
        {
            data: 'creado'
        },
        {
            data: 'acciones'
        }
    ],
    "columnDefs": [{
        "targets": [4],
        "className": "td_defecto"
    }],
    'language': {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
//END DATATABLE

//GESTION DE LA CREACION DE CITAS
function createMember() {
    var token = $("#responsive-modal-edit #token").val();

    var route = "/panel/user/crear";

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            //esto convierte el objeto que llega desde el servidor, a un array para agregar esos datos al select dinamicamente
            //los perfiles
            var obj1 = data.perfiles;
            Object.keys(obj1).map(function (key) {
                $("#responsive-modal-create #perfil_id").append('<option value="'+key+'">'+obj1[key]+'</option>');
            });

            //los medicos
            var obj2 = data.medicos;
            Object.keys(obj2).map(function (key) {
                $("#responsive-modal-create #medicosAsociados").append('<option value="'+key+'">'+obj2[key]+'</option>');
            });
        }
    });
}

$("#registro").click(function(){

    $('#cargando').show();

    var token = $("#responsive-modal-create #token").val();

    var nombres = $("#responsive-modal-create #nombres").val();
    var apellidos = $("#responsive-modal-create #apellidos").val();
    var tipoId = $("#responsive-modal-create #tipoId").val();
    var identificacion = $("#responsive-modal-create #identificacion").val();
    var telefonoFijo = $("#responsive-modal-create #telefonoFijo").val();
    var telefonoCelular = $("#responsive-modal-create #telefonoCelular").val();
    var username = $("#responsive-modal-create #username").val();
    var password = $("#responsive-modal-create #password").val();
    var perfil_id = $("#responsive-modal-create #perfil_id").val();
    var especialidad = $("#responsive-modal-create #especialidad").val();
    var registroMedico = $("#responsive-modal-create #registroMedico").val();
    var email = $("#responsive-modal-create #email").val();
    var medicosAsociados = $("#responsive-modal-create #medicosAsociados").val();

    var route = "/panel/user/almacenar"; 

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {nombres:nombres, apellidos:apellidos, tipoId:tipoId, identificacion:identificacion, telefonoFijo:telefonoFijo, telefonoCelular:telefonoCelular, username:username, password:password, perfil_id:perfil_id, especialidad:especialidad, registroMedico:registroMedico, email:email, medicosAsociados:medicosAsociados},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Usuario Creado Correctamente',
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
    $("#responsive-modal-create #nombres").val('');
    $("#responsive-modal-create #apellidos").val('');
    $("#responsive-modal-create #tipoId").val('');
    $("#responsive-modal-create #identificacion").val('');
    $("#responsive-modal-create #telefonoFijo").val('');
    $("#responsive-modal-create #telefonoCelular").val('');
    $("#responsive-modal-create #username").val('');
    $("#responsive-modal-create #password").val('');
    $('#responsive-modal-create #perfil_id option').each(function() {
        $(this).remove();
    });
    $("#responsive-modal-create #especialidad").val('');
    $("#responsive-modal-create #registroMedico").val('');
    $("#responsive-modal-create #email").val('');
    $('#responsive-modal-create #medicosAsociados option').each(function() {
        $(this).remove();
    });
    $("#responsive-modal-create #formMedicoCrear").hide();
    $("#responsive-modal-create #listadoMedicosCrear").hide();
}

//GESTION DE LA EDICION DE USUARIOS
function editMember(id) {
    var token = $("#responsive-modal-edit #token").val();

    var route = "/panel/user/edicion/"+id;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            // $("#responsive-modal-edit #medicamentoId").val(data.id);
            // $("#responsive-modal-edit #nombre").val(data.nombre);
            // $("#responsive-modal-edit #tipo").val(data.tipo);
            // $("#responsive-modal-edit #concentracion").val(data.concentracion);
            // $("#responsive-modal-edit #unidades").val(data.unidades);
            // $("#responsive-modal-edit #presentacionId").val(data.presentacion["nombre"]);
            // $("#responsive-modal-edit #presentacion_id").val(data.presentacion["id"]);
            // $("#responsive-modal-edit #laboratorioId").val(data.laboratorio["nombre"]);
            // $("#responsive-modal-edit #laboratorio_id").val(data.laboratorio["id"]);
            if($("#responsive-modal-edit #currentUserId").val() == data.user.id) {
                $("#formUserEditar").show();
            }else{
                $("#formUserEditar").hide();
            }

            if(data.user.perfil_id == '1' || data.user.perfil_id == '2') {
                $("#formMedicoEditar").show();
            }else{
                $("#formMedicoEditar").hide();
            }  

            if(data.user.perfil_id == '3') {
                $("#listadoMedicosEditar").show();
            }else{
                $("#listadoMedicosEditar").hide();
            }

        }
    });
}

$("#edicion").click(function(){

    // $('#cargando').show();

    // var token = $("#responsive-modal-edit #token").val();
    // var medicamento = $("#medicamentoId").val();

    // var nombre = $("#responsive-modal-edit #nombre").val();
    // var tipo = $("#responsive-modal-edit #tipo").val();
    // var concentracion = $("#responsive-modal-edit #concentracion").val();
    // var unidades = $("#responsive-modal-edit #unidades").val();
    // var presentacion = $("#responsive-modal-edit #presentacion_id").val();
    // var laboratorio = $("#responsive-modal-edit #laboratorio_id").val();

    // var route = "/panel/medicamento/editar/"+medicamento;

    // $.ajax({

    //     url: route,
    //     headers: {'X-CSRF-TOKEN': token},
    //     type: 'PUT',
    //     dataType: 'json',
    //     data: {nombre:nombre, tipo:tipo, concentracion:concentracion, unidades:unidades, presentacion_id:presentacion, laboratorio_id:laboratorio},

    //     success:function(data){
    //         $('#cargando').hide();

    //         if(data.mensaje == "Ok"){
    //             swal({
    //               title: 'Medicamento Editado Correctamente',
    //               type: 'success',
    //             },
    //             function(isConfirm){
    //               if(isConfirm){
    //                 // limpiar los campos
    //                 limpiarInputsEdit();
    //                 // ocultar el modal
    //                 $("#responsive-modal-edit").modal('hide');
    //                 // atualizar la datatable
    //                 table.ajax.reload(null, false); 
    //                 return false;
    //               }
    //             });
    //         }else{
    //             $("#responsive-modal-edit #msj").html('');
    //             $("#responsive-modal-edit #msj").html("<li>Se a presentado un problema en la base de datos. Favor intentar después.</li>");
    //             $("#responsive-modal-edit #msj-error").fadeIn();
    //         }       
    //     },

    //     error:function(msj){
    //         $('#cargando').hide();

    //         var response = JSON.parse(msj.responseText);
    //         var errorString = '<ul>';
    //         $.each( response.errors, function(key, value) {
    //             errorString += '<li>' + value + '</li>';
    //         });
    //         errorString += '</ul>';
    //         $("#responsive-modal-edit #msj").html(errorString);

    //         $("#responsive-modal-edit #msj-error").fadeIn();
    //     }
    // });
});

$("#responsive-modal-edit #cancelar").click(function(){
    limpiarInputsEdit();
});


function limpiarInputsEdit(){
    //que se pongan en blanco de nuevo los campos
    // $("#responsive-modal-edit #msj").html('');
    // $("#responsive-modal-edit #msj-error").fadeOut();
    // $('#responsive-modal-edit #permisos option').each(function() {
    //     $(this).remove();
    // });
    // $("#responsive-modal-edit #nombre").val('');
}

function deleteMember(id) {
    // swal({
    //     title: 'Eliminar Medicamento',
    //     text: 'Desea eliminar este medicamento?',
    //     type: 'warning',
    //     showCancelButton: true,
    //     confirmButtonColor: '#DD6B55',
    //     confirmButtonText: 'Si',
    //     closeOnConfirm: false
    // },
    // function(isConfirm){
    //     if(isConfirm){
    //         $('#cargando').show();

    //         var token = $("#responsive-modal-create #token").val();

    //         var route = "/panel/medicamento/eliminar"; 

    //         $.ajax({

    //             url: route,
    //             headers: {'X-CSRF-TOKEN': token},
    //             type: 'POST',
    //             dataType: 'json',
    //             data: {medicamento:id},

    //             success:function(data){
    //                 $('#cargando').hide();

    //                 if(data.mensaje == "Ok"){
    //                     swal({
    //                       title: 'Medicamento Eliminado',
    //                       type: 'success',
    //                     },
    //                     function(isConfirm){
    //                       if(isConfirm){
    //                         // atualizar la datatable
    //                         table.ajax.reload(null, false); 
    //                         return false;
    //                       }
    //                     });
    //                 }else{
    //                     swal("Error", "Se a presentado un problema en la base de datos. Favor intentar después.");
    //                 }       
    //             },

    //             error:function(msj){
    //                 $('#cargando').hide();
    //                 swal("Error", "Se a presentado un problema en la base de datos. Favor intentar después.");
    //             }
    //         });

    //         return false;
    //     }
    // });

    // return false;
}