function abrirHistoria()
{
	var pac = $('#historia_clinica').attr('data-paciente');
	var med = $('#historia_clinica').attr('data-medico');

	$.post('get-historia', {pac: pac, med:med}).done(function(data) {
		$('#citas').html(data);
		$('#nombre_pac').attr('data-cita', $('#helper').attr('data-cita'));
		$('#citasModal h3.modal-title').text($('#nombre_pac').attr('value'));
		$('#citasModal').modal({backdrop:'static'});
	});
}
