$(document).ready(function () {

    //alertar al asistente de escoger al medico
    var perfilId = $('#perfilId').val();
    var nombreUser = $('#nombreUser').val();
    var medicoActual = $('#medicoActual').val();

    if(perfilId == 3 || perfilId == 4){
        if(medicoActual == ""){    
            swal({
                title: 'Bienvenido(a) '+nombreUser,
                text: 'Recuerde seleccionar un médico con el cual trabajar antes de continuar.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Ok',
                closeOnConfirm: false
            });
        }
    }

    //al seleccionar un medico al ingresar al sistema, por parte de un asistente
    $('#selectMedico').on('change', function() {
        
        var medico = $('#selectMedico').val();
        var route = "/panel/user/asignacion/"+medico;

        $.get(route, function(res){
            if(res.mensaje == 'Inactivo'){//si el medico escogido esta inactivo
                swal({
                    title: 'Médico inactivo',
                    text: 'Ha elegido trabajar con un médico actualmente inactivo en el sistema. Debe elegir otro médico o consultar con el administrador del sistema.',
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: false
                });
            }else{
                swal({
                    title: 'Médico elegido',
                    text: 'Ha elegido trabajar en el entorno del médico '+res.nombres+' ('+res.identificacion+').',
                    type: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'Ok',
                    closeOnConfirm: false
                },
                function(isConfirm){
                    if(isConfirm){
                       location.reload();
                    }
                });
            }
        });

    });
})