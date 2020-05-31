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
        "url": "/panel/permiso/datatable",
        "type": "POST",
        'headers': {
            'X-CSRF-TOKEN': token
        }
    },
    'columns': [{
            data: 'nombre'
        },
        {
            data: 'medicos'
        },
        {
            data: 'estado'
        },
        {
            data: 'permisos'
        }
    ],
    "columnDefs": [{
        "targets": [4],
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

//GESTION DE LA EDICION DE CITAS
function editMember(id) {
    var token = $("#responsive-modal-edit #token").val();

    var route = "/panel/permiso/edicion/"+id;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'GET',
        dataType: 'json',
        success:function(data){

            $("#responsive-modal-edit #permisoId").val(data.user.id);

            //esto convierte el objeto que llega desde el servidor, a un array para agregar esos datos al select dinamicamente
            var obj = data.permisos;
            Object.keys(obj).map(function (key) {
                $("#responsive-modal-edit #permisos").append('<option value="'+key+'">'+obj[key]+'</option>');
            });

            //aca se recorren los option del select, comparando con los id de los permisos del usuario y asi seleccionar los que a el pertenecen
            var obj2 = data.misPermisos;
            var arr = Object.keys(obj2).map(function (key) { return obj2[key]; });

            $("#responsive-modal-edit #permisos option").each(function(i){
                var contador = 0;
                for(var i=0; i < arr.length; i++){
                    if($(this).val() == arr[i]){
                        contador = contador + 1;
                    }
                }

                if(contador > 0){
                    $(this).attr('selected','selected');
                }
            });
        }
    });
}

$("#edicion").click(function(){

    $('#cargando').show();

    var token = $("#responsive-modal-edit #token").val();
    var permiso = $("#permisoId").val();

    var permisos = $("#responsive-modal-edit #permisos").val();

    var route = "/panel/permiso/editar/"+permiso;

    $.ajax({

        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {permisos:permisos},

        success:function(data){
            $('#cargando').hide();

            if(data.mensaje == "Ok"){
                swal({
                  title: 'Permisos Editados Correctamente',
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
    $('#responsive-modal-edit #permisos option').each(function() {
        $(this).remove();
    });
}