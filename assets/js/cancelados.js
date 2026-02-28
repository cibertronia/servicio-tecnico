$(function() {
	$(document).on('click', '.Buscar', function(event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});
	$("#listaCancelados").dataTable({
		responsive:true,
    order: false
  });
	$(document).on('click', '.restaurarOrdenSoporte', function(event) {
		var idClave = $(this).attr('id');
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger mr-2'
		  },
		  buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
		  title: 'Estás seguro?',
		  html: "Estas a punto de restaurar una orden que fué anteriormente cancelada<br>Si continuas, su estado cambiará a <b>Registrada</b>.",
		  icon: 'question',
		  showCancelButton: true,
		  confirmButtonText: 'Sí, continuar!',
		  cancelButtonText: 'No, cancelar!',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	$.ajax({
					url: 'puerta_ajax.php',
					type: 'POST',
					dataType: 'html',
					data: "action=RestaurarOredenSoporte&idClave="+idClave,
				})
				.done(function(data) {
					$(".respuesta").html(data);
				})
				return false;	
		  } else if (
		    /* Read more about handling dismissals below */
		    result.dismiss === Swal.DismissReason.cancel
		  ) {
		    swalWithBootstrapButtons.fire(
		      'Cancelado',
		      'La orden ya no será restuarada.',
		      'error'
		    )
		  }
		})
		event.preventDefault();
	});
});