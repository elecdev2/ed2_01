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
		// console.log(result);
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

function swichtWIndow(me,id){
	
	var formsCollection = document.getElementsByTagName("form");
	var iniDiv = '';
	for(var i = 1; i < formsCollection.length; i++)
	{
		var btn = formsCollection[i].elements[formsCollection[i].length-1];

		var isDirty = false;
		$.each(formsCollection[i].elements, function(index, val) 
		{
			switch(val.type)
			{
				case 'textarea':
					if(val.value !== '' && btn.disabled == false)
					{
						isDirty = true;
					}
				break;
				case 'select-one':
					if(val.title !== 'historico')
					{
						if(val.value !== '' && btn.disabled == false)
						{
							isDirty = true;
						}
						
					}
				break;
				case 'select-multiple':
					if(val.title !== 'historico')
					{
						if(val.value !== '' && btn.disabled == false)
						{
							isDirty = true;
						}
						
					}
				break;
				case 'file':
					if(val.title !== 'historico')
					{
						if(val.value !== '' && btn.disabled == false)
						{
							isDirty = true;
						}
						
					}
				break;
			}
		});
		if(isDirty == true)
		{			
			var div = '<div class="alert-info"><div class="col-sm-9"><p>'+formsCollection[i].name+'</p></div></div>';
			iniDiv = iniDiv+div;
			// console.log(div);
		}
		
	}
	if(iniDiv !== '')
	{
		bootbox.dialog({
	        title: "Atención",
	        message: '<h4>No se han guardado los cambios en los siguientes formularios:</h4><br>'+ iniDiv,
	        buttons: {
	            success: {
	                label: "Cerrar de todas formas",
	                className: "btn btn-danger",
	                callback: function () {
						$(me).modal('hide');
						$(id).modal({backdrop:'static'});
	                }
	            }
	        }
	    });
	}else{
		$(me).modal('hide');
		$(id).modal({backdrop:'static'});
	}
}


function cerrarCita(id){
	bootbox.confirm('ADVERTENCIA: Está apunto de cerrar la cita, una vez cerrada no se podrá acceder a su información. ¿Desea cerrar la cita?',function(result)
	{
		if(result)
		{
			$.post('cerrar-cita', {id: id}).done(function(data){
				switch(data)
				{
					case '0': notification('Error al cerrar la cita, por favor intentelo más tarde', 2); break;

					case '1': 
							$(document).find('#viewModal').modal('hide');
							$.pjax.reload({container:'#atn_pjax'});
				            notification('Se guardaron los cambios', 1);
				    break;

					default:
						notification('La cita se ha cerrado', 1);
						$('.modal').modal('hide');
						
						$('.fullcalendar').fullCalendar( 'removeEvents', id );
						$('.fullcalendar').fullCalendar( 'renderEvent', data);
					break;
				}
				
			});
		}
	})
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

