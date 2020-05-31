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
        "url": "/panel/medicamento/datatable",
        "type": "POST",
        'headers': {
            'X-CSRF-TOKEN': token
        }
    },
    'columns': [{
            data: 'nombre'
        },
        {
            data: 'tipo'
        },
        {
            data: 'concentracion'
        },
        {
            data: 'unidades'
        },
        {
            data: 'presentacion'
        },
        {
            data: 'laboratorio'
        },
        {
            data: 'creado'
        }
    ],
    "columnDefs": [{
        "targets": [7],
        "data": "id",
        "visible": true,
        "className": "td_defecto",
        "render": function (data, type, row) {
            return '<a title="Editar" class="btn btn-warning"><i class="fa fa-pencil-square-o" title="Editar" style="display:table;margin:0 auto" onclick="editMember(' + data + ')" data-toggle="modal" data-target="#responsive-modal-edit" aria-hidden="true"></i></a><a title="Eliminar" class="btn btn-danger"><i class="fa fa-trash" title="Eliminar" style="display:table;margin:0 auto" onclick="deleteMember(' + data + ')" aria-hidden="true"></i></a>';
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

    var nombre = $("#responsive-modal-create #nombre").val();
    var tipo = $("#responsive-modal-create #tipo").val();
    var concentracion = $("#responsive-modal-create #concentracion").val();
    var unidades = $("#responsive-modal-create #unidades").val();
    var presentacion = $("#responsive-modal-create #presentacion_id").val();
    var laboratorio = $("#responsive-modal-create #laboratorio_id").val();

    var route = "/panel/medicamento/almacenar"; 

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {nombre:nombre, tipo:tipo, concentracion:concentracion, unidades:unidades, presentacion_id:presentacion, laboratorio_id:laboratorio},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Medicamento Creado Correctamente',
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
    $("#responsive-modal-create #tipo").val('');
    $("#responsive-modal-create #concentracion").val('');
    $("#responsive-modal-create #unidades").val('');
    $("#responsive-modal-create #presentacionId").val('');
    $("#responsive-modal-create #presentacion_id").val('');
    $("#responsive-modal-create #laboratorioId").val('');
    $("#responsive-modal-create #laboratorio_id").val('');
}

//GESTION DE LA EDICION DE CITAS
function editMember(id) {
    var token = $("#responsive-modal-edit #token").val();

    var route = "/panel/medicamento/edicion/"+id;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            $("#responsive-modal-edit #medicamentoId").val(data.id);
            $("#responsive-modal-edit #nombre").val(data.nombre);
            $("#responsive-modal-edit #tipo").val(data.tipo);
            $("#responsive-modal-edit #concentracion").val(data.concentracion);
            $("#responsive-modal-edit #unidades").val(data.unidades);
            $("#responsive-modal-edit #presentacionId").val(data.presentacion["nombre"]);
            $("#responsive-modal-edit #presentacion_id").val(data.presentacion["id"]);
            $("#responsive-modal-edit #laboratorioId").val(data.laboratorio["nombre"]);
            $("#responsive-modal-edit #laboratorio_id").val(data.laboratorio["id"]);
        }
    });
}

$("#edicion").click(function(){

    $('#cargando').show();

    var token = $("#responsive-modal-edit #token").val();
    var medicamento = $("#medicamentoId").val();

    var nombre = $("#responsive-modal-edit #nombre").val();
    var tipo = $("#responsive-modal-edit #tipo").val();
    var concentracion = $("#responsive-modal-edit #concentracion").val();
    var unidades = $("#responsive-modal-edit #unidades").val();
    var presentacion = $("#responsive-modal-edit #presentacion_id").val();
    var laboratorio = $("#responsive-modal-edit #laboratorio_id").val();

    var route = "/panel/medicamento/editar/"+medicamento;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {nombre:nombre, tipo:tipo, concentracion:concentracion, unidades:unidades, presentacion_id:presentacion, laboratorio_id:laboratorio},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Medicamento Editado Correctamente',
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
}

function deleteMember(id) {
    swal({
        title: 'Eliminar Medicamento',
        text: 'Desea eliminar este medicamento?',
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

            var route = "/panel/medicamento/eliminar"; 

            $.ajax({

                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {medicamento:id},

                success:function(data){
                    $('#cargando').hide();

                    if(data.mensaje == "Ok"){
                        swal({
                          title: 'Medicamento Eliminado',
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