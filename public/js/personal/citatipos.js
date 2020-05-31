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
        "url": "/panel/citatipo/datatable",
        "type": "POST",
        'headers': {
            'X-CSRF-TOKEN': token
        }
    },
    'columns': [{
            data: 'nombre'
        },
        {
            data: 'color'
        },
        {
            data: 'creado'
        },
        {
            data: 'acciones'
        }
    ],
    "columnDefs": [{
        "targets": [3],
        "className": "td_defecto"
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

    var nombre = $("#responsive-modal-create #nombre").val();
    var color = $("#responsive-modal-create #inputColor").val();

    var route = "/panel/citatipo/almacenar"; 

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {nombre:nombre, color:color},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Tipo de Cita Creado Correctamente',
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
    $("#responsive-modal-create #nombre").val('');
    $("#responsive-modal-create #inputColor").val('');
}

//GESTION DE LA EDICION DE CITAS
function editMember(id) {
    var token = $("#responsive-modal-edit #token").val();

    var route = "/panel/citatipo/edicion/"+id;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            $("#responsive-modal-edit #citatipoId").val(data.id);
            $("#responsive-modal-edit #nombre").val(data.nombre);
            $("#responsive-modal-edit #inputColor").minicolors('value',data.color);
        }
    });
}

$("#edicion").click(function(){

    $('#cargando').show();

    var token = $("#responsive-modal-edit #token").val();
    var citatipo = $("#citatipoId").val();

    var nombre = $("#responsive-modal-edit #nombre").val();
    var color = $("#responsive-modal-edit #inputColor").val();

    var route = "/panel/citatipo/editar/"+citatipo;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {nombre:nombre, color:color},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Tipo de Cita Editado Correctamente',
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
    $("#responsive-modal-edit #nombre").val('');
    $("#responsive-modal-edit #inputColor").val('');
}

function deleteMember(id) {
    swal({
        title: 'Eliminar Tipo de Cita',
        text: 'Desea eliminar este tipo de cita?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si',
        closeOnConfirm: false
    },
    function(isConfirm){
        if(isConfirm){
            $('#cargando').show();

            var token = $("#responsive-modal-create #token").val();   
            var route = "/panel/citatipo/eliminar"; 

            $.ajax({

                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {citatipo:id},

                success:function(data){
                    $('#cargando').hide();

                    if(data.mensaje == "Ok"){
                        swal({
                          title: 'Tipo de Cita Eliminado',
                          type: 'success',
                        },
                        function(isConfirm){
                          if(isConfirm){
                            // atualizar la datatable
                            table.ajax.reload(null, false); 
                            return false;
                          }
                        });
                    }else{
                        swal("Error", "Se a presentado un problema en la base de datos. Favor intentar después.");
                    }       
                },

                error:function(msj){
                    $('#cargando').hide();
                    swal("Error", "Se a presentado un problema en la base de datos. Favor intentar después.");
                }
            });

            return false;
        }
    });

    return false;
}
// @if($citatipo->nombre != "Primera Vez" && $citatipo->nombre != "Control/Consulta" && $citatipo->nombre != "Sesión")