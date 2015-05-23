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


function openModalView(idcontenedor,elemento){
   var fila = elemento.attr('data-key');
    $.get('view', {id: fila}).done(function(data) {
        $('#'+idcontenedor).html(data);
        $('#viewModal').modal({backdrop:'static'});
    });
}

function openModalUpdate(idcontenedor,elemento){
   var fila = elemento.attr('data-key');
    $.get('update', {id: fila}).done(function(data) {
        $('#'+idcontenedor).html(data);
        $('#updateModal').modal({backdrop:'static'});
    });
}

function openModalTarifas(idcontenedor,id,destino){
    $.get(destino, {ideps: id}).done(function(data) {
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
