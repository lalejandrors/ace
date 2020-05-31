$(document).ready(function () {

    $("#ciudadConsulta_2").autocomplete({//visible en los reportes
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/ciudad",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        select:function(event, ui){
            $('#ciudadConsulta2').val(ui.item.id);
        }
    });

    $("#cie10Consulta_5").autocomplete({//visible en los reportes
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
            $('#cie10Consulta5').val(ui.item.id);
        }
    });

    $("#tratamientoConsulta_6").autocomplete({//visible en los reportes
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
            $('#tratamientoConsulta6').val(ui.item.id);
        }
    });

    $("#tratamientoConsulta_7").autocomplete({//visible en los reportes
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
            $('#tratamientoConsulta7').val(ui.item.id);
        }
    });

    $("#responsive-modal-create #presentacionId").autocomplete({//visible en gestion de medicamentos
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/presentacion",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-create",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-create #presentacion_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-edit #presentacionId").autocomplete({//visible en gestion de medicamentos
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/presentacion",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-edit",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-edit #presentacion_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-create #laboratorioId").autocomplete({//visible en gestion de medicamentos
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/laboratorio",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-create",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-create #laboratorio_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-edit #laboratorioId").autocomplete({//visible en gestion de medicamentos
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/laboratorio",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-edit",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-edit #laboratorio_id').val(ui.item.id);//el hidden
        }
    });

    $("#pacienteId").autocomplete({//visible en gestion de historias clinicas, controles y sesiones
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/paciente",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        select:function(event, ui){
            $('#historias__paciente_id').val(ui.item.id);//el hidden
            $('#controles__paciente_id').val(ui.item.id);
            $('#sesiones__paciente_id').val(ui.item.id);
            $("#tratamientoId").prop('disabled', false);
            $('#paci_identificacion').focus();//para cargar los datos del paciente en los inputs automaticamente, sin tener que dar un click fuera
        }
    });

    $("#acompananteId").autocomplete({//visible en gestion de historias clinicas, controles y sesiones
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/acompanante",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        select:function(event, ui){
            $('#historias__acompanante_id').val(ui.item.id);//el hidden
            $('#controles__acompanante_id').val(ui.item.id);
            $('#sesiones__acompanante_id').val(ui.item.id);
            $('#acom_identificacion').focus();//para cargar los datos del paciente en los inputs automaticamente, sin tener que dar un click fuera
        }
    });

    $("#responsive-modal-create #ciudadId").autocomplete({//visible en gestion de pacientes
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/ciudad",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-create",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-create #ciudad_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-edit #ciudadId").autocomplete({//visible en gestion de pacientes
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/ciudad",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-edit",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-edit #ciudad_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-create #epsId").autocomplete({//visible en gestion de pacientes
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/eps",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-create",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-create #eps_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-edit #epsId").autocomplete({//visible en gestion de pacientes
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/eps",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-edit",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-edit #eps_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-create #pacienteIdAgenda").autocomplete({//visible en gestion de agendas
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/paciente",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-create",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-create #paciente_id').val(ui.item.id);//el hidden
        }
    });

    $("#responsive-modal-edit #pacienteIdAgenda").autocomplete({//visible en gestion de agendas
        maxResults: 10,
        source:function(request, response){
            $.ajax({
                url:"/panel/autocomplete/paciente",
                dataType:"json",
                data:{busqueda:request.term},
                success:function(data){
                    response(data.slice(0, 10));
                }
            });
        },
        minLength:1,
        appendTo: "#responsive-modal-edit",//ya que se usa en una ventana modal de bootstrap, para que se muestre sin problemas
        select:function(event, ui){
            $('#responsive-modal-edit #paciente_id').val(ui.item.id);//el hidden
        }
    });

    $("#diagnostico1").autocomplete({//visible en la generacion dinamica de cie10s en historia clinica, controles y sesiones. El js de los demas diagnosticos se maneja en historias.js, controles.js o sesiones.js
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
            $("#diagnostico_id1").val(ui.item.id);//el hidden
        }
    });

    $("#medicamento1").autocomplete({//visible en la generacion dinamica de medicamentos en historia clinica, controles y sesiones. El js de los demas medicamentos se maneja en historias.js, controles.js o sesiones.js
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
            $("#medicamento_id1").val(ui.item.id);//el hidden
        }
    });

    $("#tratamiento1").autocomplete({//visible en la generacion dinamica de tratamientos en historia clinica, controles y sesiones. El js de los demas tratamientos se maneja en historias.js, controles.js o sesiones.js
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
            $("#tratamiento_id1").val(ui.item.id);//el hidden
        }
    });

    $("#tratamientoId").autocomplete({//visible en el formulario de creacion de sesion. Con este podremos verificar si el paciente tiene sesiones pendientes de algun tratamiento
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
            $("#sesiones__tratamiento_id").val(ui.item.id);//el hidden
        }
    });
})