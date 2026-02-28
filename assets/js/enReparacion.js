$(function() {
	var elem = document.querySelector('.js-switch');
  var init = new Switchery(elem);
	$("#listaenReparacion").dataTable({responsive:true,
      order: false
    });
	$(document).on('click', '.openModalServicio', function(event) {
		var idServicio = $(this).attr('id');
		$("#openModal_Servicio").modal();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {llamarFichaTecnica: idServicio},
			success:function(data){
				$("#tablaEquipos").html(data);
				$("#idServicioModal").val(idServicio);
				$("#nombreCliente").val(data.cliente);
				$("#telefonoCliente").val(data.telefono);
				$("#celularCliente").val(data.celular);
				$("#maquinaCliente").val(data.maquina);
				$("#marcaCliente").val(data.marca);
				$("#modeloCliente").val(data.modelo);
				$("#serieCliente").val(data.serie);
				$("#fechaRecibido").val(data.fechar);
				$("#Observaciones").val(data.obsr);
				$("#Trabajo").val(data.realizar);
			}
		})		
		event.preventDefault();
	});
	$(document).on('click', '.openModal_editServicio', function(event) {
		var idServicio = $(this).attr('id');
		$("#openModal_editServicio").modal();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {llamarFichaTecnica: idServicio},
			success:function(data){
				$(".tablaEquipos").html(data);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.delServicio', function(event) {
		var idServicio = $(this).attr('id');

		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
		  title: 'Estás seguro?',
		  html: "Si continuas, no podrás deshacer los cambios.",
		  icon: 'question',
		  showCancelButton: true,
		  confirmButtonText: 'Sí, borrar!',
		  cancelButtonText: 'No, cancelar!',
		  reverseButtons: true
		}).then((result) => {
			$(".delServicio").tooltip('hide');
		  if (result.value) {
		  	$.ajax({
			    url: 'puerta_ajax.php',
			    type: 'POST',
			    dataType: 'html',
			    data: "action=deleteFichaTecnica&idServicio="+idServicio,
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
		      'La ficha ya no será borrada',
		      'error'
		    )
		  }
		})
		event.preventDefault();
	});
	$(document).on('click', '.cancelServicio', function(event) {
		var idServicio = $(this).attr('id');
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success',
		    cancelButton: 'btn btn-danger mr-3'
		  },
		  buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
		  title: 'Estás seguro?',
		  html: "Si continuas, no podrás deshacer los cambios.<br>La reparación pasará a un estado de cancelado.",
		  icon: 'question',
		  showCancelButton: true,
		  confirmButtonText: 'Sí, cancelar!',
		  cancelButtonText: 'No, cancelar!',
		  reverseButtons: true
		}).then((result) => {
			$(".delServicio").tooltip('hide');
		  if (result.value) {
		  	$.ajax({
			    url: 'puerta_ajax.php',
			    type: 'POST',
			    dataType: 'html',
			    data: "action=cancelarReparacion&idServicio="+idServicio,
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
		      'La reparación continuará en proceso!',
		      'error'
		    )
		  }
		})
		event.preventDefault();
	});
	$(document).on('click', '.actualizaServicio', function(event) {
		var nombre 					= $("#Nombre").val();
		var celular 				= $("#Celular").val();
		var maquina 				= $("#Maquina").val();
		var observaciones 	= $("#Observaciones_").val();
		var trabajo 				= $("#Trabajo_").val();
		if (nombre=='') {
			$("#Nombre").after('<div class="text-center text-danger noNombreCliente">Ingrese nombre</div>');
			setTimeout(function() {
				$(".noNombreCliente").remove();
				$("#Nombre").focus();
			}, 2500);
		}else if (celular=='') {
			$("#Celular").after('<div class="text-center text-danger noCellCliente">Ingrese teléfono</div>');
			setTimeout(function() {
				$(".noCellCliente").remove();
				$("#Celular").focus();
			}, 2500);
		}else if (maquina=='') {
			$("#Maquina").after('<div class="text-center text-danger noMaquinaCliente">Ingrese los datos</div>');
			setTimeout(function() {
				$(".noMaquinaCliente").remove();
				$("#Maquina").focus();
			}, 2500);
		}else if (observaciones=='') {
			$("#Observaciones_").after('<div class="text-center text-danger noObservacionesCliente">Ingrese las observaciones</div>');
			setTimeout(function() {
				$(".noObservacionesCliente").remove();
				$("#Observaciones_").focus();
			}, 2500);
		}else if (trabajo=='') {
			$("#Trabajo_").after('<div class="text-center text-danger noTrabajoCliente">Ingrese el trabajo</div>');
			setTimeout(function() {
				$(".noTrabajoCliente").remove();
				$("#Trabajo_").focus();
			}, 2500);
		}else{
			$(".actualizaServicio").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#actuzalizarServicio").serialize(),
			})
			.done(function(data) {
				$("#openModal_editServicio").modal('hide');
				$(".respuesta").html(data);
			})
			//return false;
		}
		event.preventDefault();
	});
	/*$(document).on('click', '.guardaDetalles', function(event) {
		var idServicio 	= $("#idServicioModal").val();
		var trabajo 		= $("#trabajoRealizado").val();
		if (trabajo=='') {
			$("#trabajoRealizado").after('<div class="text-center text-danger noDetalles">Ingrese descripcion</div>');
			setTimeout(function() {
				$(".noDetalles").remove();
				$("#trabajoRealizado").focus()
			}, 2500);
		}else{
			$(".guardaDetalles").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#agregarReparaciones").serialize(),
			})
			.done(function(data) {
				$(".guardaDetalles").removeClass('d-none');
				$(".spinner").addClass('d-none');
				$("#openModal_Servicio").modal('hide');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});*/
	$(document).on('click', '.Buscar', function(event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});
	$(document).on('click', '.openModal_ingresaDetalles', function(event) {
		$("#openModal_ingresaDetalles").modal();
		var clave = $(this).attr('id');
		var sucursal = $("#sucursalRegistro").val()
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {obtenerRegistrosClave: clave},
			success:function(data){
				$("#detalles").html(data);
				$("#claveModalDetalles").val(clave);
				$("#sucursalSoporte_add").val(sucursal);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.guardaDetalles', function(event) {
		$(".guardaDetalles").addClass('d-none');
		$(".spinnerDetalles").removeClass('d-none');
		$.ajax({
			url: 'puerta_ajax.php',
			type: 'POST',
			dataType: 'html',
			data: $("#detallesRep").serialize(),
		})
		.done(function(data) {
			$("#openModal_ingresaDetalles").modal('hide');
			$(".respuesta").html(data);
			$(".guardaDetalles").removeClass('d-none');
			$(".spinnerDetalles").addClass('d-none');
		})
		event.preventDefault();
	});
});