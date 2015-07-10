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
        event.preventDefault();
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

     function getPaciente () {
        var doc = $('#documento_cita').val();
        $.post('paciente', {data: doc}).done(function(data) {
            
            if(data['id'] == null){
                console.log('El paciente no existe');
                $('#pacienteName').html('El paciente no existe');
            }else{
                console.log(data);
                $('#citasmedicas-pacientes_id').val(data['id']);
                $('#pacientes-tipo_identificacion').select2('val', data['tipo_identificacion']);
                $('#pacientes-nombre1').val(data['nombre1']);
                $('#pacientes-nombre2').val(data['nombre2']);
                $('#pacientes-apellido1').val(data['apellido1']);
                $('#pacientes-apellido2').val(data['apellido2']);
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
    }

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
                    bootbox.alert(data);
                    $('.fullcalendar').fullCalendar( 'removeEvents', id );
                });
            }
        });
    }

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
