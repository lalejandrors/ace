$(document).ready(function () { 

    //gestion del select de formatos
    $("#formatoId").on('change', function() {

        if($("#formatoId").val() != ""){
            tinyMCE.activeEditor.setContent('');
            $("#asunto").val('');

            var formato = $("#formatoId").val();

            var route = "/panel/informe/formato/"+formato;

            $.get(route, function(res){
                if(res != null){
                    $(res).each(function(key,value){
                        tinyMCE.activeEditor.setContent(value.contenido);
                    });
                }
            });
        }else{
            tinyMCE.activeEditor.setContent('');
        }
    });

    //aparecer la imagen de cargando al enviar
    $("#formSender").submit(function() {

        $("#cargando").show();
    });
})