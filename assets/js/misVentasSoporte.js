$(function () {
	$(document).on('click', '.Buscar', function (event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});
	$('#listamisVentas').dataTable({
		responsive: true,
		lengthChange: false,
		dom:
			"<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
		buttons: [
			{
				extend: 'excelHtml5',
				text: 'Excel',
				titleAttr: 'Generar Excel',
				className: 'btn-outline-success btn-sm mr-1'
			},
		]
	});
});