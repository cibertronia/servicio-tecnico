$(function() {
	$('.js-summernote').summernote({
    height: 150,
    tabsize: 2,
    placeholder: "Ingrese la descripción del producto...",
    dialogsFade: true,
    toolbar: [
      ['style', ['style']],
      ['font', ['strikethrough', 'superscript', 'subscript']],
      ['font', ['bold', 'italic', 'underline', 'clear']],
      ['fontsize', ['fontsize']],
      ['fontname', ['fontname']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['height', ['height']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]],
	    callbacks:{
	    //restore from localStorage
	    /*onInit: function(e){
	      $('.js-summernote').summernote("code", localStorage.getItem("summernoteData"));
	    },
	    onChange: function(contents, $editable){
	      clearInterval(interval);
	      timer();
	    }*/
	  }
	});
	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: {monedaPrincipal: ''},
		success:function(data){
			$(".simboloMoneda").html(data.simbolo)
		}
	})
	$("#listaGeneradas").dataTable({responsive: true,order:false});
	$(".select2").select2();
	$(document).on('click', '.Buscar', function(event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});
	$(document).on('click', '.EditarCotizacionPanel', function(event) {
		$("[role='tooltip']").tooltip('hide');
		var claveCotizacion = $(this).attr('id');
		$("#panelCotizacionesGeneradas").addClass('d-none');
		$("#panelEditarCot").removeClass('d-none');
		selectorProductos();
		$.ajax({
			url: 'puerta_ajax.php',
			type: 'POST',
			dataType: 'html',
			data: {action:'mostrarProductosTemporales', claveCotizacion},
			success:function(data){
				$(".tablaProductosTemporales").html(data);
				$("#claveTemporal_Panel").val(claveCotizacion);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.cerrarPanel', function(event) {
		$("[role='tooltip']").tooltip('show');
		$("#panelCotizacionesGeneradas").removeClass('d-none');
		$("#panelEditarCot").addClass('d-none');
		$("#clavePanel").val('');
		event.preventDefault();
	});
	$(document).on('click', '.modal_enviarCotizacion', function(event) {
		var idCotizacion = $(this).attr('id');
		$("#modal_enviarCotizacion").modal();
		$("#idCotizacionMail").val(idCotizacion);		
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {buscarCorreoClienteJSON: idCotizacion},
			success:function(data){
				$("#correoCliente").val(data.correo);
				$("#idTiendaCotizacionCorreo").val(data.idTienda);
				$.ajax({
					url: 'includes/consultas.php',
					type: 'POST',
					dataType: 'json',
					data: {buscardatosUsuarioJSON: idCotizacion},
					success:function(respuesta){
						$("#Mensaje").summernote("code","Señor(a): "+data.nombre+".<br>Le enviamos adjunto la cotización solicitada.<br>Esperamos una respuesta favorables de suparte.<br>Atentamente:<br>"+respuesta.Nombre+"<br>"+respuesta.cargo);
					}
				})
			}
		})
		return false;
		event.preventDefault();
	});
	$(document).on('click', '.sendCotizacionMail', function(event) {
		var idCotizacion  = $("#idCotizacionMail").val();
		var correoCliente = $("#correoCliente").val();
		var asunto 				= $("#Asunto").val();
		var mensaje 			= $("#Mensaje").val();
		var idTienda      = $("#idTiendaCotizacionCorreo").val();
		$(".sendCotizacionMail").addClass('d-none');
		$(".spinner-sendCotizacionMail").removeClass('d-none');
		$.ajax({
			url: 'pdf.php',
			type: 'GET',
			dataType: 'html',
			data: {enviarCotizacionCorreo:idCotizacion},
		});
		setTimeout(function() {
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {action:'enviarCotizacionxCorreo',correoCliente,idCotizacion,asunto,mensaje,idTienda},
				success:function(data){
					$("#modal_enviarCotizacion").modal('hide');
					$(".sendCotizacionMail").removeClass('d-none');
					$(".spinner-sendCotizacionMail").addClass('d-none');
					$(".respuesta").html(data);
				}
			})
		}, 1500);
		event.preventDefault();
	});
	$(document).on('click', '.borrarCotizacion', function(event) {
		event.preventDefault();		
		var idCotizacion = $(this).attr("id");
		var ClaveCotiza  = $("#claveCotizacion").val();
		var rangoUsuario = $("#RangoUsuario").val();
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success m-3',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
		  title: '¿Estás seguro?',
		  html: "Si continuas, no podrás deshacer los cambios.",
		  icon: 'question',
		  showCancelButton: true,
		  confirmButtonText: 'Sí, borrar!',
		  cancelButtonText: 'No, cancelar!',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	if (rangoUsuario==1) {
		  		swalWithBootstrapButtons.fire(
			      'Sin Autorización',
			      'No cuentas con los privilegios necesarios.',
			      'error'
			    )
		  	}else{
		  		$.ajax({
				    url: 'puerta_ajax.php',
				    type: 'POST',
				    dataType: 'html',
				    data: "action=borrarCotizacionGenerada&idCotizacion="+idCotizacion+"&clave="+ClaveCotiza,
			    })
			    .done(function(data) {
				    $(".respuesta").html(data);
			    })
		  	}		  	
		  } else if (
		    /* Read more about handling dismissals below */
		    result.dismiss === Swal.DismissReason.cancel
		  ) {
		    swalWithBootstrapButtons.fire(
		      'Cancelado',
		      'La cotización ya no será borrada',
		      'error'
		    )
		  }
		})
	});
	$(document).on('click', '.marcarComoEntregada', function(event) {
		var idCotizacion = $(this).attr('id');
		$("[role='tooltip']").tooltip('hide');
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success m-3',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: false
		})		
		swalWithBootstrapButtons.fire({
		  title: '¿Estás seguro?',
		  html: "Estás a punto de cambiar el estado de esta cotización<br>Si continúas, pasará a cotizaciones entregadas.",
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
					data: {action: 'marcarComoEntregada',idCotizacion},
					success:function(data){
						$(".respuesta").html(data);
						$("[role='tooltip']").tooltip('show');
					}
				})
		  } else if (
		    /* Read more about handling dismissals below */
		    result.dismiss === Swal.DismissReason.cancel
		  ) {		  	
		    swalWithBootstrapButtons.fire(
		      'Cancelado',
		      'La cotización ya no será entregada',
		      'error'
		    )
		  }
		})
		//$("[role='tooltip']").tooltip('show');
		event.preventDefault();
	});
	function selectorProductos(){
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {selectorProductosGenerarCotizacion: ''},
			success:function(data){
				$("#selectorProducto").html(data);
			}
		})
	}
	$("#selectorProducto").change(function(event) {
		$("#selectorProducto option:selected").each(function() {			
			var idProducto 		= $(this).val();
			var numSucursales = $("#numSucursales").val();
			var servicioStock = $("#serviStock").val();
			$(".spinner-consultaPrecio").removeClass('d-none');
			$(".datosProducto").addClass('d-none');
			$(".btn-NoMas").addClass('d-none');
			$("#cantidadProducto").val('');
			$("#precioEspecial").val('');
			if (servicioStock == 1) {
				for (var i = 0; i < numSucursales; i++) {
					$.ajax({
						url: 'includes/consultas.php',
						type: 'POST',
						dataType: 'json',
						data: {buscarStockProductoJSON: idProducto,i},						
					})
					.done(function(data){							
						$('.codigoTienda_'+data.posicion).html(data.codeTienda);
						$("#stockDisponible_"+data.posicion).val(data.stock);
						$("#cantidadProducto").attr('disabled', false);
						if (data.stock < 10) {
							$("#stockDisponible_"+data.posicion).addClass('text-danger is-invalid');
						}else{
							$("#stockDisponible_"+data.posicion).removeClass('text-danger is-invalid');
							$("#stockDisponible_"+data.posicion).addClass('text-success is-valid');
						}
					})
					$(".stockProducto").removeClass('d-none');						
				}
			}
			$.ajax({
				url: 'includes/consultas.php',
				type: 'POST',
				dataType: 'json',
				data: {buscaPrecioProductoJSON: idProducto},
				success:function(data){
					$(".spinner-consultaPrecio").addClass('d-none');
					$(".datosProducto").removeClass('d-none')
					$("#precioVenta").val(data.precio);
					$("#cantidadProducto").focus();
					$(".btn-NoMas").addClass('d-none');
				}
			})
			return false;
		});
	});
	$(document).on('click', '.modal_editarProductoTemporal', function(event) {
		var idClave = $(this).attr('id');
		$("#modal_editarProductoTemporal").modal({backdrop: 'static', keyboard: false});
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {editarProductoTablaTemporal:idClave},
			success:function(respuesta){
				$("#idClave_ProductoTemporal").val(idClave);
				$("#cantidadProducto_modal").val(respuesta.cantidad);
				$("#precioVenta_modal").val(respuesta.precioEspecial);
				$("#claveTemporal_modal").val(respuesta.claveTemporal);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.btnActualizarProducto', function(event) {
		var cantidad = $("#cantidadProducto_modal").val();
		var precioEsp= $("#precioVenta_modal").val();
		if (cantidad=='') {
			$(".emptyCantidadProducto").removeClass('d-none');
			setTimeout(function() {
				$(".emptyCantidadProducto").addClass('d-none');
			}, 1500);
		}else if (isNaN(cantidad)) {
			$(".cantidadNoValida").removeClass('d-none');
			setTimeout(function() {
				$(".cantidadNoValida").addClass('d-none');
			}, 1500);
		}else if (precioEsp=='') {
			$(".emptyPrecioProducto").removeClass('d-none');
			setTimeout(function() {
				$(".emptyPrecioProducto").addClass('d-none');
			}, 1500);
		}else if (isNaN(precioEsp)) {
			$(".precioEspNoValido").removeClass('d-none');
			setTimeout(function() {
				$(".precioEspNoValido").addClass('d-none');
			}, 1500);
		}else{
			$(".btnActualizarProducto").addClass('d-none');
			$(".spinner-ActualizarProducto").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formEditProducto").serialize(),
			})
			.done(function(data) {
				$(".btnActualizarProducto").removeClass('d-none');
				$(".spinner-ActualizarProducto").addClass('d-none');
				$("#modal_editarProductoTemporal").modal('hide');
				$(".tablaProductosTemporales").html(data);
				$(".alertTablaProducto").before('<div class="row tablaActualizada"><div class="col"><div class="text-danger text-center"><b>TABLA ACTUALIZADA!!</b></div></div></div>');
				setTimeout(function() {
					$(".tablaActualizada").remove();
				}, 3000);
			})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.borrarProductoTemporal', function(event) {
		var idClave 	= $(this).attr('id');
		var claveTemp = $("#claveTemporal_Panel").val();
		$(".borrarProductoTemporal").remove()
		$(".spinner-borrarProductoTemp_"+idClave+"").removeClass('d-none')
		$.ajax({
			url: 'puerta_ajax.php',
			type: 'POST',
			dataType: 'html',
			data: "action=borrarProductoTemporal&idClave="+idClave+"&claveTemporal="+claveTemp,
		})
		.done(function(data) {
			//$(".tablaProductosTemporales").html('');
			$(".tablaProductosTemporales").html(data);
		})
		return false;
		event.preventDefault();
	});
	$(document).on('click', '.btn-masProductos', function(event) {
		var claveTemp 		= $("#claveTemporal_Panel").val();
		var precioVen 		= $("#precioVenta").val();
		var cantidad 			= $("#cantidadProducto").val();
		var precioEsp 		= $("#precioEspecial").val();
		var idProducto 		= $("#selectorProducto").val();
		var stockDisponible=$("#stockDisponible").val();
		if (precioVen 		== ''){			
			$(".emptyPrecioVenta").removeClass('d-none');
			setTimeout(function() {
				$(".emptyPrecioVenta").addClass('d-none');
				$("#precioVenta").focus();
			}, 500);
		}else if (precioVen!='' & isNaN(precioVen)) {
			$(".invalidPrecioVenta").removeClass('d-none');
			setTimeout(function() {
				$(".invalidPrecioVenta").addClass('d-none');
				$("#precioVenta").val('');
				$("#precioVenta").focus();
			}, 500);
		}else if (cantidad=='') {
			$(".emptyCantidadProducto").removeClass('d-none');
			setTimeout(function() {
				$(".emptyCantidadProducto").addClass('d-none');
				$("#cantidadProducto").focus();
			}, 500);
		}else if (cantidad!=''& isNaN(cantidad)) {
			$(".invalidCantidadProducto").removeClass('d-none');
			setTimeout(function() {
				$(".invalidCantidadProducto").addClass('d-none');
				$("#cantidadProducto").val('');
				$("#cantidadProducto").focus();
			}, 500);
		}else if (precioEsp=='') {
			$(".emptyPrecioEspecial").removeClass('d-none');
			setTimeout(function() {
				$(".emptyPrecioEspecial").addClass('d-none');
				$("#precioEspecial").focus();
			}, 500);
		}else if (precioEsp!='' & isNaN(precioEsp)) {
			$(".invalidPrecioEspecial").removeClass('d-none');
			setTimeout(function() {
				$(".invalidPrecioEspecial").addClass('d-none');
				$("#precioEspecial").val('');
				$("#precioEspecial").focus();
			}, 500);
		}else{
			$(".btn-masProductos").addClass('d-none')
			$(".spinner-masProductos").removeClass('d-none');
			$(".labelBtn").remove();
			$(".spinner-masProductos").after('<label for="btn-masProductos" class="form-label labelBtn" style="letter-spacing: 2px;">Guardando producto...</label>');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: "action=GuardarProductoTemporal&claveTemporal="+claveTemp+"&idProducto="+idProducto+"&cantidad="+cantidad+"&precioVenta="+precioVen+"&precioEspecial="+precioEsp,
			})
			.done(function(data) {
				$(".labelBtn").html('&nbsp;&nbsp;');
				$(".btn-masProductos").removeClass('d-none')
				$(".spinner-masProductos").addClass('d-none');
				$(".tablaProductosTemporales").html(data);
				$("#precioVenta").val('');
				$("#cantidadProducto").val('');
				$("#precioEspecial").val('');
				$(".datosProducto").addClass('d-none');
				$(".selectorProducto").addClass('d-none');
				$(".btn-agregarotroProducto").removeClass('d-none');
				$(".labelBtn").remove();
				$(".stockProducto").addClass('d-none');
				$(".stockProducto").val('');
				$("#btn-masProductos").before('<label for="btn-masProductos" class="form-label labelBtn" style="letter-spacing: 2px;">&nbsp;&nbsp;</label>');
			})
			return false;
		}
		event.preventDefault();
	});	
	$(document).on('click', '.btn-Sicontinuar', function(event) {
		$(".btn-agregarotroProducto").addClass('d-none');
		$(".cargandoProductos").removeClass('d-none');
		selectorProductos()
		setTimeout(function() {
			$(".cargandoProductos").addClass('d-none');
			$(".btn-NoMas").removeClass('d-none');
			$(".selectorProducto").removeClass('d-none')
		},2000);
		event.preventDefault();
	});
	$(document).on('click', '.btn-Yano', function(event) {
		$(".btn-NoMas").addClass('d-none')
		$(".detallesCotizacion").removeClass('d-none');
		$("#selectorProducto").val();
		var claveTemp = $("#claveTemporal_Panel").val();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {obtenerDetallesCotizacion: claveTemp},
			success:function(data){
				$("#formaPago").val(data.formaPago);
				$("#tiempoEntrega").val(data.tiempoEntrega);
				$("#validezCotizacion").val(data.fechaOferta);
				$("#detallesGarantia").text(data.garantiaDetalles);
				$("#observaciones").text(data.comentarios);
			}
		})
		return false;
		event.preventDefault();
	});
	$(document).on('click', '.btn-Nocontinuar', function(event) {
		$(".btn-agregarotroProducto").addClass('d-none');
		selectorProductos();		
		$(".selectorProducto").removeClass('d-none');
		$(".detallesCotizacion").removeClass('d-none');
		var claveTemp = $("#claveTemporal_Panel").val();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {obtenerDetallesCotizacion: claveTemp},
			success:function(data){
				$("#formaPago").val(data.formaPago);
				$("#tiempoEntrega").val(data.tiempoEntrega);
				$("#validezCotizacion").val(data.fechaOferta);
				$("#detallesGarantia").text(data.garantiaDetalles);
				$("#observaciones").text(data.comentarios);
			}
		})
		return false;
		/*$(".btn-NoMas").addClass('d-none')
		*/
		event.preventDefault();
	});
	$(document).on('click', '.guardarCotizacion', function(event) {
		var formaPago 				= $("#formaPago").val();
		var tiempoEntrega 		= $("#tiempoEntrega").val();
		var validezCotizacion = $("#validezCotizacion").val();
		var detallesGarantia	= $("#detallesGarantia").val();
		var claveTemporal 		= $("#claveTemporal_Panel").val();
		var observaciones 		= $("#observaciones").val();
		if (formaPago == null ) {
			$(".emptyFormaPago").removeClass('d-none');
			setTimeout(function() {
				$(".emptyFormaPago").addClass('d-none');
				$("#formaPago").focus();
			}, 2000);
		}else if (tiempoEntrega == null ) {
			$(".emptyTiempoEntrega").removeClass('d-none');
			setTimeout(function() {
				$(".emptyTiempoEntrega").addClass('d-none');
				$("#tiempoEntrega").focus();
			}, 2000);
		}else if (validezCotizacion == '' ) {
			$(".emptyValidezOferta").removeClass('d-none');
			setTimeout(function() {
				$(".emptyValidezOferta").addClass('d-none');
				$("#validezCotizacion").focus();
			}, 2000);
		}else if (detallesGarantia == '' ) {
			$("#detallesGarantia").after('<div class="my-2 text-danger text-center noDetallesGarantia">INGRESE LOS DETALLES DE LA GARANTÍA</div>');
			selectorProductos();
			setTimeout(function() {
				$(".noDetallesGarantia").remove();
				$("#detallesGarantia").focus();
			}, 2000);
		}else{
			$(".guardarCotizacion").addClass('d-none');
			$(".spinner-guardarCotizacion").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: {action:'ActualizarDatosCotizacion',claveTemporal,formaPago,tiempoEntrega,validezCotizacion,detallesGarantia,observaciones}
			})
			.done(function(data) {
				$(".guardarCotizacion").removeClass('d-none');
				$(".spinner-guardarCotizacion").addClass('d-none');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
});