$(function() {
	$("#listaReparados").dataTable({responsive:true,
      order: false
    });
	$(document).on('click', '.Buscar', function(event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});
	$(document).on('click', '.openModalServicio', function(event) {
		var idServicio = $(this).attr('id');
		$("#openModal_Servicio").modal();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {llamarFichaTecnica: idServicio},
			success:function(data){
				$("#idServicioModal").val(idServicio);
				$("#nombreCliente").val(data.cliente);
				$("#telefonoCliente").val(data.telefono);
				$("#celularCliente").val(data.celular);
				$("#maquinaCliente").val(data.maquina);
				$("#fechaRecibido").val(data.fechar);
				$("#Observaciones").val(data.obsr);
				$("#Trabajo").val(data.realizar);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.openModal_editReparaciones', function(event) {
		var idServicio = $(this).attr('id');
		$("#openModal_editReparaciones").modal();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {llamarFichaTecnica: idServicio},
			success:function(data){
				$("#idServicio_editReparaciones").val(idServicio);
				$("#TrabajoRealizado").val(data.realizado);
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
			    url: 'do.php',
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
		    cancelButton: 'btn btn-danger'
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
			    url: 'do.php',
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
				url: 'do.php',
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
	$(document).on('click', '.guardaDetalles', function(event) {
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
				url: 'do.php',
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
	});
	$(document).on('click', '.actualizaReparacion', function(event) {
		var realizado	= $("#TrabajoRealizado").val();
		if (realizado=='') {
			$("#TrabajoRealizado").after('<div class="text-center text-danger noTrabajoRealizadoCliente">Ingrese los detalles</div>');
			setTimeout(function() {
				$(".noTrabajoRealizadoCliente").remove();
				$("#TrabajoRealizado").focus();
			}, 2500);
		}else{
			$(".actualizaReparacion").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#actuzalizarReparaciones").serialize(),
			})
			.done(function(data) {
				$("#openModal_editReparaciones").modal('hide');
				$(".respuesta").html(data);
			})
			//return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.cambiaraReparado', function(event) {
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
		  confirmButtonText: 'Sí, continuar!',
		  cancelButtonText: 'No, cancelar!',
		  reverseButtons: true
		}).then((result) => {
			$(".delServicio").tooltip('hide');
		  if (result.value) {
		  	$.ajax({
			    url: 'do.php',
			    type: 'POST',
			    dataType: 'html',
			    data: "action=cambiaraEntregado&idServicio="+idServicio,
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
		      'La ficha ya no cambiará de estado',
		      'error'
		    )
		  }
		})
		event.preventDefault();
	});
	$(document).on('click', '.openModal_entregarOrden', function(event) {
		var clave = $(this).attr('id');
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {BuscarSucursalxClave: clave},
			success:function(respuesta){
				$("#sucursalOrden").val(respuesta);
			}
		})
		$("#openModal_entregarOrden").modal();
		$("#claveModalEntrega").val(clave);
		event.preventDefault();
	});
	$(document).on('click', '.entregaOrden', function(event) {		
		$(".entregaOrden").addClass('d-none');
		$(".spinner").removeClass('d-none');
		$.ajax({
			url: 'do.php',
			type: 'POST',
			dataType: 'html',
			data: $("#EntregarOrdendeEquipo").serialize(),
		})
		.done(function(data) {
			$("#openModal_entregarOrden").modal('hide');
			$(".respuesta").html(data);
			$(".entregaOrden").removeClass('d-none');
			$(".spinner").addClass('d-none');
		})
		return false;
		event.preventDefault();
	});
});