function nombrePaciente(docInput,idInput,nombreTag,direccion,telefono,fecha,edad,email)
{
    $(docInput).on('blur', function(event) {

        $.post('getpaciente',{data: $(docInput).val()}).done(function(data) {
            $(idInput).val(data['id']);
            if($(docInput).val() != ''){
                if(data['id'] == null){
                    $(nombreTag).text('El usuario no existe...').append('<a id="n_paciente" href="#" data-toggle="modal" data-target="#pacienteModal">registrar</a>');
                }else{
                    $(nombreTag).text(data['nombre1']+' '+data['nombre2']+' '+data['apellido1']+' '+data['apellido2']);
                    $(direccion).val(data['direccion']);
                    $(telefono).val(data['telefono']);
                    $(fecha).val(data['fecha_nacimiento']);
                    $(email).val(data['email']);
                    // $(edad).text(_calculateAge(data['fecha_nacimiento']));
                }
            }
        });
    });
}

function _calculateAge(birthday) { // birthday is a date
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs); // miliseconds from epoch
    return Math.abs(ageDate.getUTCFullYear() - 1970);
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
