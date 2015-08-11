function abrirHistoria()
{
	var pac = $('button#historia_clinica').attr('data-paciente');
	var med = $('button#historia_clinica').attr('data-medico');

	$.post('get-historia', {pac: pac, med:med}).done(function(data) {
		if(data == 0)
		{
			notification('El paciente no tiene historia clinica', 3);
		}else{
			$('div#historia').html('');
			$('div#historia').html(data);
			$('input#nombre_pac').attr('data-cita', $('#helper').attr('data-cita'));
			$('#historiaModal h3.modal-title').text($('#nombre_pac').attr('value'));
			$('#historiaModal').modal({backdrop:'static'});
		}
	});
}

// function atender(id)
// {
// 	$.post('../atencion/create', {id_pac:id}).done(function(result) {
// 		$('#infoCitas').html(result);
// 		$('#infoCitasModal h3').text('Atención de paciente');
// 		$('#infoCitasModal').modal({backdrop:'static'});
// 	});
// }

$(document).on('click', '.imprimir', function(event) {
	event.preventDefault();
	var keys = $('#historia_rep').yiiGridView('getSelectedRows');
	if(keys == '')
	{
		notification('Por favor seleccione al menos un elemento', 3);
	}else{
		bootbox.confirm('¿Está seguro que desea imprimir todas las historias seleccionadas?', function(result){
			if(result)
			{
				imprimirHistoria(keys);
			}
		});
	}
});

function imprimirHistoria(id)
{
	$.post('imprimir', {keys: id}).done(function(result) {
		console.log(result);
	});
}

function openModalViewHistoria(elemento){
   var fila = elemento.attr('data-key');
   // tituloModal(campo,fila);
    $.get('view', {id: fila}).done(function(data) {
        $('#vista').html(data);
        $('#viewHistoriaModal').modal({backdrop:'static'});
    });
}


function notification(mensaje, num)
{
	toastr.options = {
	  "closeButton": false,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": false,
	  "positionClass": "toast-top-right",
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "1000",
	  "timeOut": "5000",
	  "extendedTimeOut": "1000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  // "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}

	switch(num){
		case 1: toastr.success(mensaje);break;
		case 2: toastr.error(mensaje);break;
		case 3: toastr.warning(mensaje);break;
		case 4: toastr.info(mensaje);break;
	}
}