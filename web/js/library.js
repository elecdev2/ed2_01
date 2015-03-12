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
