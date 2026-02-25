$(function() {
	$("#historialPagos").dataTable({responsive: true});
	$(document).on('click', '.addsaldo', function(event) {
		$("#modal_solicitaSaldo").modal();
		event.preventDefault();
	});	
	$(document).on('click', '.addPayPal', function(event) {
		var idUser = $(this).attr("id");
		var cantid = $("#ingreseCantidadPayPal").val();
		if (cantid=='') {
			$("#ingreseCantidadPayPal").after('<div class="text-center text-danger noCantidad">INGRESE CANTIDAD</div>');
			setTimeout(function(){
				$(".noCantidad").remove();
			},2500);
		}else{
			$(".addPayPal").addClass('d-none');
			$(".spinnerPayPal").removeClass('d-none');
		}
		event.preventDefault();
	});
	$(".").modal(modal_solicitaSaldo)
});