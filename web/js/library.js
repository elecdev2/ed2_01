function nombrePaciente(docInput,idInput,nombreTag)
{
    $(docInput).on('blur', function(event) {

        $.post('getpaciente',{data: $(docInput).val()}).done(function(data) {
            $(idInput).val(data['id']);
            if($(docInput).val() != ''){
                if(data['id'] == null)
                    $(nombreTag).text('El usuario no existe...').append('<a id="n_paciente" href="#" data-toggle="modal" data-target="#pacienteModal">registrar</a>');
                else
                    $(nombreTag).text(data['nombre1']+' '+data['nombre2']+' '+data['apellido1']+' '+data['apellido2']);
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
 
// serialize form, render response and close modal
function submitForm($form) {
    $.post(
        $form.attr("action"), // serialize Yii2 form
        $form.serialize()
    )
        .done(function(result) {
            $form.parent().html(result.message);
            $('#viewModal').modal('hide');
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
