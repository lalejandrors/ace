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
        "url": "/panel/formato/datatable",
        "type": "POST",
        'headers': {
            'X-CSRF-TOKEN': token
        }
    },
    'columns': [{
            data: 'nombre'
        },
        {
            data: 'creado'
        }
    ],
    "columnDefs": [{
        "targets": [2],
        "data": "id",
        "visible": true,
        "className": "td_defecto",
        "render": function (data, type, row) {
            return '<a title="Editar" class="btn btn-warning" href="/panel/formato/edicion/' + data + '"><i class="fa fa-eye" style="display:table;margin:0 auto" aria-hidden="true"></i></a><a title="Eliminar" class="btn btn-danger"><i class="fa fa-trash" title="Eliminar" style="display:table;margin:0 auto" onclick="deleteMember(' + data + ')" aria-hidden="true"></i></a>';
        }
    }],
    'language': {
        "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
    }
});
//END DATATABLE

function deleteMember(id) {
    swal({
        title: 'Eliminar Formato',
        text: 'Desea eliminar este formato?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Si',
        closeOnConfirm: false
    },
    function(isConfirm){
        if(isConfirm){
            var token = $("#token").val();

            var route = "/panel/formato/eliminar"; 

            $.ajax({

                url: route,
                headers: {'X-CSRF-TOKEN': token},
                type: 'POST',
                dataType: 'json',
                data: {formato:id},

                success:function(data){

                    if(data.mensaje == "Ok"){
                        swal({
                          title: 'Formato Eliminado',
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
                    swal("Error", "Se a presentado un problema en la base de datos. Favor intentar después.");
                }
            });

            return false;
        }
    });

    return false;
}