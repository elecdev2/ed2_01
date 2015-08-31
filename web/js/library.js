
$('.modal').on('shown.bs.modal', function () {
    $(".modal-body").scrollTop(0);
});

function nombrePaciente(docInput,idInput,nombretag,nombre1,nombre2,apellido1,apellido2,direccion,telefono,fecha,edad,email,tipoId)
{
    $(docInput).on('blur', function(event) {

        $.post('getpaciente',{data: $(docInput).val()}).done(function(data) {
            $(idInput).val(data['id']);
            if($(docInput).val() != ''){
                if(data['id'] == null){
                    $(nombretag).text('El usuario no existe...').append('<a id="n_paciente" href="#" data-toggle="modal" data-target="#pacienteModal">registrar</a>');
                }else{
                    $(tipoId).val(data['tipo_identificacion']);
                    $(nombre1).val(data['nombre1']);
                    $(nombre2).val(data['nombre2']);
                    $(apellido1).val(data['apellido1']);
                    $(apellido2).val(data['apellido2']);
                    $(direccion).val(data['direccion']);
                    $(telefono).val(data['telefono']);
                    $(fecha).val(data['fecha_nacimiento']);
                    $(email).val(data['email']);
                    $.post('calcular-edad', {fecha: data['fecha_nacimiento']}).done(function(data) {
                        $(edad).val(data);
                    });
                }
            }
        });
    });
}

// function tituloModal(campo,key){
//     $.post('titulo-modal', {campo: campo, key:key}).done(function(data) {
//         var titulo = '';
//         $.each(data, function(index, val) {
//              titulo = titulo +' '+val;
//         });
//         $('.modal-title').html(titulo);
//     });
// }

function openModalView(idcontenedor,elemento){
   var fila = elemento.attr('data-key');
   // tituloModal(campo,fila);
    $.get('view', {id: fila}).done(function(data) {
        $('#act').html('');
        $('#'+idcontenedor).html(data);
        var titulo = $("#helperHid").attr("data-titulo");
        $('.modal-title').text('');
        $('.modal-title').text(titulo);
        $('#viewModal').modal({backdrop:'static'});
        $('#update').attr('value', $('#helperHid').attr('data-value'));
    });
}

function openModalUpdate(idcontenedor,elemento){
   var fila = elemento.attr('data-key');
    $.get('update', {id: fila}).done(function(data) {
         $('#vista').html('');
        $('#'+idcontenedor).html(data);
        var titulo = $("#helperHid").attr("data-titulo");
        $('.modal-title').text('');
        $('.modal-title').text(titulo);
        $('#updateModal').modal({backdrop:'static'});
        $('#view').attr('value', $('#helperHid').attr('data-value'));
    });
}

function openModalUpdateBarra(idcontenedor,id){
    $.get('update', {id: id}).done(function(data) {
        $('#vista').html('');
        $('#'+idcontenedor).html(data);
        $('#updateModal').modal({backdrop:'static'});
        $('#view').attr('value', $('#helperHid').attr('data-value'));
    });
}

function openModalViewBarra(idcontenedor,id){
    $.get('view', {id: id}).done(function(data) {
        $('#act').html('');
        $('#'+idcontenedor).html(data);
        $('#viewModal').modal({backdrop:'static'});
        $('#update').attr('value', $('#helperHid').attr('data-value'));
    });
}

function openModalTarifas(idcontenedor,id){
    $.post('create', {ideps: id}).done(function(data) {
        $('#'+idcontenedor).html(data);
        $('#tarModal').modal({backdrop:'static'});
    });
}
 
// serialize form, render response and close modal
function submitForm($form) {
    $.post(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function(result) {
            $form.parent().html(result.message);
            $('#viewModal').modal('hide');
            $('#updateModal').modal('hide');
        })
        .fail(function() {
            console.log("server error");
            $form.replaceWith('<button class="newType">Fail</button>').fadeOut()
        });
    return false;
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return window.location.href;
}

//Ventanta Ver click en tabla

    $(document).on('click', 'table.kv-grid-table tr:not(tr.skip-export) td:not(:last-child)',function(event) {
        // event.preventDefault();
        openModalView('vista',$(this).parent());
    }); 
// botones del actionColumn

    $(document).on('click', '#ver',function(event) {
        event.preventDefault();
        openModalView('vista',$($(this).parent()).parent());
    });

    $(document).on('click', '#actualizar' ,function(event) {
        event.preventDefault();
        openModalUpdate('act',$($(this).parent()).parent());
    });
   
// botones cabecera modal    
    $(document).on('click','.updModal', function(event) {
        event.preventDefault();
        openModalUpdateBarra('act', $(this).val());
    });

    $(document).on('click','.verModal', function(event) {
        event.preventDefault();
        openModalViewBarra('vista', $(this).val());
    });

    $(document).ready(function() {
        $('.fomularioTitulo').hide();
        $('.search-boton').on('click', function() {
            $('.fomularioTitulo').slideToggle('fast');
            return false;
        });
   });

    $(document).on('click', '#convencion', function(event) {
        event.preventDefault();
       $('#convModal').modal('show');
    });

    function cerrarModal (modal) {
        $(modal).modal('hide');
    }

    $(document).on('click', '#cambiarFoto', function(event) {
        event.preventDefault();
        document.getElementById("input-1").click();
    });

    $(document).on('change', '#input-1', function(event) {
        // event.preventDefault();
        document.getElementById("cargar").click();
    });

    $(document).on('click', '#cambiarFirma', function(event) {
        event.preventDefault();
        document.getElementById("input-2").click();
    });

    $(document).on('change', '#input-2', function(event) {
        event.preventDefault();
        document.getElementById("cargarFirma").click();
    });

    $(document).on('change', '#pacientes-identificacion', function(event) {
        var doc = $(this).val();
        $.post('paciente', {data: doc}).done(function(data) {
            $('.alert-danger').remove();
            if(data == '0'){
                if($('#pacientes-identificacion').val() != ''){
                    $('.field-pacientes-identificacion').append('<div class="col-sm-2 alert-danger"><span>El paciente no existe</span><div>');
                }
                $('form').find("input[type=text], textarea").val("");
                // $('div.procedimientos-create').html('');
                // $.get('create', function(data) {
                //     $('div.procedimientos-create').html(data);
                // });
                // $('.select2-selection__rendered').click();
                // $('#pacientes-identificacion').val(doc);
            }else{
                $('#citasmedicas-pacientes_id').val(data['id']);
                $('#procedimientos-idpacientes').val(data['id']);
                $('#pacientes-tipo_identificacion').select2('val', data['tipo_identificacion']);
                $('#pacientes-nombre1').val(data['nombre1']);
                $('#pacientes-nombre2').val(data['nombre2']);
                $('#pacientes-apellido1').val(data['apellido1']);
                $('#pacientes-apellido2').val(data['apellido2']);
                $('#pacientes-sexo').select2('val', data['sexo']);
                $('#pacientes-direccion').val(data['direccion']);
                $('#pacientes-telefono').val(data['telefono']);
                $('#pacientes-sexo').val(data['sexo']);
                $('#pacientes-fecha_nacimiento').val(data['fecha_nacimiento']);
                $('#pacientes-tipo_usuario').select2('val', data['tipo_usuario']);
                $('#pacientes-tipo_residencia').select2('val', data['tipo_residencia']);
                $('#pacientes-activo').val(data['activo']);
                $('#pacientes-idciudad').select2('val', data['idciudad']);
                $('#pacientes-ideps').select2('val', data['ideps']);
                $('#pacientes-email').val(data['email']);
                $('#pacientes-envia_email').val(data['envia_email']);
            }
        });
    });


     function refreshCalendar()
    {
        var source = 'consultar-citas?id='+$('#renderEvents').attr('data-value');
        $('.fullcalendar').fullCalendar(  'removeEvents' );
        $('.fullcalendar').fullCalendar('removeEventSource', source);
        $('.fullcalendar').fullCalendar('addEventSource', source);
    }

    function cancelarCita(id)
    {
        bootbox.confirm('¿Está seguro que desea cancelar esta cita?', function(result) {
            if(result){
                $.post('cancel', {id: id}).done( function(data) {
                    $('.modal').modal('hide');
                    notification(data, 1);
                    $('.fullcalendar').fullCalendar( 'removeEvents', id );
                });
            }
        });
    }

    function mostrarPanel()
    {
        $('.panelDatos').show();
        $('table.detail-view').hide();
    }

    function updateCitas()
    {
        var id_cita = $('#helper').attr('data-cita');
        var ips = $('#helper').attr('data-ips');
        var num_ips = $('#helper').attr('data-num');
        var med = $('#helper').attr('data-med') == null ? null : $('#helper').attr('data-med');
        var fecha = $('#helper').attr('data-fecha');
        if(fecha == 'false')
        {
            $.get('update', {id: id_cita, ips:ips, num_ips:num_ips, med:med}).done(function(data) {
                $('#editCitas').html(data);
                var titulo = $('#helperHid').attr('data-titulo');
                $('#helperHid').attr('data-cita', id_cita);
                $('#helperHid').attr('data-fecha', fecha);
                $('.modal-title').text('');
                $('.modal-title').text(titulo);

                $('#editCitasModal').modal({backdrop:'static'});
            });
        }else{
            notification('No se pueden modificar los datos de una cita pasada', 3);
        }
    }

    function viewCitas()
    {
       
        var id_cita = $('#helper').attr('data-cita') == '' ? $('#nombre_pac').attr('data-cita') : $('#helper').attr('data-cita');
        var ips = $('#txtIdIps').val();
        var num_ips = $('#num_ips').val();
        if($('#helperHid').attr('data-new') != 0)
        {
            $.get('view-cita', {id: id_cita}).done(function(data) {
                $('#infoCitas').html(data);
                $('#helper').attr('data-cita', id_cita);
                $('#helper').attr('data-ips', ips);
                $('#helper').attr('data-num', num_ips);
                $('#helper').attr('data-fecha',$('#helperHid').attr('data-fecha'));
                $('#infoCitasModal').modal({backdrop:'static'});
            });
        }else{
            notification('No existe un registro para ver', 3);
        }
    }

// view de historia clinica boton ver mas en datos de paciente
    $(document).on('hide.bs.collapse', '#vistaPaciente', function(event) {
        // event.preventDefault();
        $("a.search-boton").html('<span style="vertical-align: middle" class="glyphicon glyphicon-eye-open"></span> ver más <i class="fa fa-caret-down fa-lg"></i>');
    });

    $(document).on('show.bs.collapse', '#vistaPaciente', function(event) {
        // event.preventDefault();
        $("a.search-boton").html('<span style="vertical-align: middle" class="glyphicon glyphicon-eye-close"></span> ver menos <i class="fa fa-caret-up fa-lg"></i>');
    });

    $('#procedimientos-cod_cups').on('change', function(event) {
        var cod_cup = $(this).val();
        var eps_id = $('#eps_id').val();
        if(cod_cup != ''){
            $.post('precio', {cod: cod_cup, id: eps_id}, function(data) {
                saldo = data['valor_procedimiento'];
                $('#procedimientos-valor_procedimiento').val(data['valor_procedimiento']);
                $('#procedimientos-valor_saldo').val(data['valor_procedimiento']);
                $('#procedimientos-valor_copago').val(0);
                $('#procedimientos-valor_abono').val(0);
                $('#procedimientos-descuento').val(data['descuento']);
                // console.log(data['valor_procedimiento']);
            });
        }
    });

    $('#pacientes-fecha_nacimiento').on('change', function(event) {
        $.post('calcular-edad', {fecha: $(this).val()}).done(function(data) {
            $('#pacientes-codeps').val(data);
        });
    });

    $('#pacientes-codeps').on('change', function(event) {
        $.post('calcular-fecha', {age:$(this).val()}).done(function(data) {
            $('#pacientes-fecha_nacimiento').val(data);
        });
    });

    // function confirmacion (event, revertFunc, med, ips, date) 
    // {

    //     $.post('cambiar-fecha', {date: date, id:event.id, med:med, sw: 1, ips:ips}).done(function(data) {
    //         $('#mover').html(data);
    //         $('#date').attr('value', date);
    //         $('#id').attr('value', event.id);
    //         $('#med').attr('value', med);
    //         $('#moveCitasModal h3.modal-title').text('Cambiar fecha y/o hora');
    //         $('#cancelar').attr('onclick', revertFunc);
    //         $('#moveCitasModal').modal({backdrop:'static'});
    //     });

    // }

    $('.saldo').on('change', function(event) {
        event.preventDefault();
        var abono = parseFloat($('#procedimientos-valor_abono').val());

        if(isNaN(abono)){
            $('#procedimientos-valor_saldo').val($('#procedimientos-valor_procedimiento').val());
        }else{
            $('#procedimientos-valor_saldo').val($('#procedimientos-valor_procedimiento').val()-abono);
        }
    });

   

        // $(document)
        // .ajaxStart(function() {
        //     $(".modal").hide().show();
        // })
        // .ajaxStop(function() {
        //     $(".modal").hide().hide();
        // });
        
        // $(document)
        // .ajaxStart(function() {
        //     $(".loader").hide().show();
        // }).ajaxStop(function() {
        //     $(".loader").hide().hide();
        // });
