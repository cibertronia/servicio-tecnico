$(function () {
	var buscar = 1;
	$(document).on('click', '.Buscar', function (event) {
		buscar == 1 ? $("#buscar").removeClass('d-none') : $("#buscar").addClass('d-none');
		buscar == 1 ? buscar = 0 : buscar = 1;
		event.preventDefault();
	});
let exportFormatter = {
    format: {
        body: function (data, row, column, node) {
            //if ((column === 11) || (column === 5))
            //    return '';
            //else if ((column >= 6 ) && (column <= 10)){
            //    var s = data;
            //    var htmlObj = $(s);
            //    return htmlObj.text();
            //}
            //else {
                return data;
            //}
        }
    }
};	
	$("#tabla_facturas").DataTable({
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
				className: 'btn-outline-success btn-sm mr-1',
				exportOptions: exportFormatter
			},			
		]		
	});

	$(document).on('click', '.boton_llenar_modal_anular', function (event) {
		let id = $(this).attr("id");
		$.ajax({
			url: 'includes/api_facturacion/getDataFactura.php',
			type: 'POST',
			dataType: 'json',
			data: { id: id },
			success: function (data) {
				$("#invoiceNumber1").val(data.invoiceNumber);
				$("#invoiceCode1").val(data.invoiceCode);
				$("#clientEmail1").val(data.clientEmail);
				$("#tipoFactura1").val(data.tipoFactura);
				$("#branchId1").val(data.branchId);

			}
		})
		event.preventDefault();
	});

	$(document).on('click', '.boton_anular_api', function (event) {
		let id = $(this).attr("id");
		$(".boton_anular_api").attr('disabled', true);
		Swal.fire({
			type: 'info',
			title: "CONECTANDO CON IMPUESTOS NACIONALES",
			animation: false,
			customClass: {
				popup: 'animated bounceInDown'
			},
			text: "La Conexion Con SIAT Puede Demorar Varios Segundos Espere Por Favor",
			icon: "info",

			timer: 10000,

			onOpen: function () {
				let swalContainer = document.querySelector('.swal2-container');
				let swalPopup = document.querySelector('.swal2-popup');

				swalContainer.style.zIndex = '9999';
				swalPopup.style.zIndex = '9999';
			},
			didDestroy: function () {

				Swal.close();
			}
		});

		$.ajax({
			type: "POST",
			dataType: 'json',
			url: 'includes/api_facturacion/anular_factura.php',
			data: $("#form_anular").serialize(),
			success: function (data) {
				if (data == 'ok') {
					console.log('Anulación Exitosa');
					Swal.fire({
						type: 'success',
						title: "ANULACIÓN EXITOSA",
						animation: false,
						customClass: {
							popup: 'animated bounceInDown'
						},
						text: "Factura Anulada Correctamente",
						timer: 5000,
						onOpen: function () {
							let swalContainer = document.querySelector('.swal2-container');
							let swalPopup = document.querySelector('.swal2-popup');

							swalContainer.style.zIndex = '9999';
							swalPopup.style.zIndex = '9999';
						},
						didDestroy: function () {

							Swal.close();
						}
					});
					setTimeout(function () {
						location.reload();
					}, 5000);

				} else {
					Swal.fire({
						type: 'error',
						title: "ERROR",
						animation: false,
						customClass: {
							popup: 'animated bounceInDown'
						},
						text: "Puede que la factura ya este anulada , Intente Nuevamente",
						icon: "error",
						button: "Ok",
						timer: 15000,
						onOpen: function () {
							let swalContainer = document.querySelector('.swal2-container');
							let swalPopup = document.querySelector('.swal2-popup');

							swalContainer.style.zIndex = '9999';
							swalPopup.style.zIndex = '9999';
						},
						didDestroy: function () {

							Swal.close();
						}
					});
					setTimeout(function () {
						location.reload();
					}, 5000);
				}
			}

		})
		event.preventDefault();
	});

	$(document).on('click', '.ver_pdf', function (event) {
		let invoiceCode = $(this).attr("id");
		let url = './../includes/api_facturacion/factura_pdf.php?invoiceCode=' + invoiceCode;
		window.open(url, '_blank');
		//document.getElementById('pdfFactura').submit();

	});




});


//función asíncrona que se ejecuta automatico para validar token en la bd
(async () => {
	let datosPOST =
		"token_validar=" + "token_validar";
	console.log(datosPOST);
	$.ajax({
		url: "includes/api_facturacion/token_validar.php",
		type: "POST",
		dataType: "json",
		data: datosPOST,
		success: function (data) {
			console.log(data);
		},
	});

})();

