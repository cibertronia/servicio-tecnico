$(function() {
	var elementos 		= Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	elementos.forEach(function(data) {
	  var switchery   = new Switchery(data);
	});
	var nombreVendedor = $("#nombre_Vendedor").val();
	$(".nombreVendedor").html(nombreVendedor);
	$(":input").inputmask();
	$(".select2").select2();
	$("#nombreCliente").keyup(function(){
		var nombreCliente = $("#nombreCliente").val();
		$("#nombre_Cliente").html(nombreCliente)
	})
	$("#telefonoCliente").keyup(function(){
		var telefonoCliente = $("#telefonoCliente").val();
		$("#telefono_Cliente").html(telefonoCliente)
	})
	var servicioStock = $("#serviStock").val();
	var serviProveed  = $("#serviProveedor").val();
	var serviCategoria= $("#serviCategoria").val();
	var numSucursales = $("#numerodeSucursales").val();
	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'html',
		data: {obtenerUltimaFactura:''},
		success:function(data){
			$("#numFactura").val(data)
			if (data<10) {
				$(".numFactura").html('000000000'+data)
			}else if (data < 100) {
				$(".numFactura").html('00000000'+data)
			}else if (data < 1000) {
				$(".numFactura").html('0000000'+data)
			}else if (data < 10000) {
				$(".numFactura").html('000000'+data)
			}else if (data < 10000 ) {
				$(".numFactura").html('00000'+data)
			}else if (data < 100000 ) {
				$(".numFactura").html('0000'+data)
			}else if (data < 1000000 ) {
				$(".numFactura").html('000'+data)
			}

			
		}
	})
	// function selectorClientes(){
	// 	$.ajax({
	// 		url: 'includes/consultas.php',
	// 		type: 'POST',
	// 		dataType: 'html',
	// 		data: {obtenerListaClientesGenerar: ''},
	// 		success:function(data){
	// 			$("#idClientelista").html(data);
	// 		}
	// 	})
	// }
	function selectorClientes(){
		$("#idCliente_lista").addClass('d-none')
		$(".cargandoClientes").removeClass('d-none');
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {obtenerListaClientesGenerar: ''},
			success:function(data){
				$(".cargandoClientes").addClass('d-none');
				$(".selectListaClientes").removeClass('d-none');
				$("#idCliente_lista").html(data);
			}
		})
	}
	selectorClientes();
	$("#idCliente_existente").val(0);
	$("#listaProductos").dataTable({responsive: true});
	$("#clienteExistente").change(function() {
		if ($(this).is(':checked')) {
			$(".cargandoClientes").removeClass('d-none');			
			$(".datosCliente").addClass('d-none');
			$(".selectorProducto").addClass('d-none');
			$.ajax({
				url: 'includes/consultas.php',
				type: 'POST',
				dataType: 'html',
				data: {obtenerListaClientesGenerar: ''},
				success:function(data){
					$(".cargandoClientes").addClass('d-none');
					$(".selectListaClientes").removeClass('d-none');
					$("#idCliente_lista").html(data);
				}
			})
			return false;
		}else{
			selectorProductos();
			$(".datosCliente").removeClass('d-none');
			$(".selectListaClientes").addClass('d-none');
			$(".selectorProducto").removeClass('d-none');
			function cerrarMySQLi(){
				var closeCon = "<?php mysqli_close($MySQLi) ?>";
				return closeCon;
			}
			function listarCiudades(){
				var ciudades = "<?php listaCiudades($MySQLi) ?>";
				return ciudades;
			}
			cerrarMySQLi();
			$("#ciudadCliente").val(0);
			$("#nombreCliente").val('');
			$("#telefonoCliente").val('');
			$("#correoCliente").val('');
			$("#empresaCliente").val('');
			$("#telempresaCliente").val('');
			$("#exttelefonoEmpresaCliente").val('');
			$("#direccionCliente").val('');
			$("#comentariosCliente").val('');
			$("#idTelegram").val('');
			$("#idCliente_existente").val(0);
		}
	});
	$("#idCliente_lista").change(function(event) {
		$("#idCliente_lista option:selected").each(function() {
			var idCliente = $(this).val();
			$(".loaderDatosClientes").removeClass('d-none');
			$.ajax({
				url: 'includes/consultas.php',
				type: 'POST',
				dataType: 'json',
				data: {obtenerListaClientesJSON: idCliente},
				success:function(data){
					$(".loaderDatosClientes").addClass('d-none');
					$("#nombreCliente").val(data.nombre);
					$("#telefonoCliente").val(data.celular);
					$("#nombre_Cliente").html(data.nombre);
					$("#telefono_Cliente").html(data.celular);
					$(".selectorProducto").removeClass('d-none');
					selectorProductos();
					$("#idCliente_existente").val(idCliente);
					$(".datosCliente").removeClass('d-none');
					$("#direccionCliente").val(data.direccion);
					$("#comentariosCliente").val(data.comentarios);
					$("#idTelegram").val(data.idTelegram);
				}
			})
			return false;
		});
	});
	$("#selectorProducto").change(function(event) {
		$("#selectorProducto option:selected").each(function() {			
			var idProducto 		= $(this).val();
			var nombreCliente = $("#nombreCliente").val();
			var celularCliente= $("#telefonoCliente").val();
    	var numSucursales = $("#numerodeSucursales").val();
    	if (nombreCliente == '') {
				$(".emptyNombreCliente").removeClass('d-none');
				selectorProductos();
				setTimeout(function() {
					$(".emptyNombreCliente").addClass('d-none');
					$("#nombreCliente").focus();
					$("#selectorProducto").val(0);
				}, 2000);
			}else if (celularCliente == '') {
				$(".emptyCelularCliente").removeClass('d-none');
				selectorProductos();
				setTimeout(function() {
					$(".emptyCelularCliente").addClass('d-none');
					$("#telefonoCliente").focus();
					$("#selectorProducto").val(0);
				}, 2000);
			}else{
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
			}
			//return false;
		});
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
	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: {monedaPrincipal: ''},
		success:function(data){
			$(".simboloMoneda").html(data.simbolo)
		}
	})
	$("#cantidadProductos").val(0)
	$("#precioProducto").val(0)	
	$(document).on('click', '.cerrarProducto', function(event) {
		var idProducto = $("#selectorProducto option:selected").val();
		// $("[idProducto='']").attr('idProducto':idProducto)
		event.preventDefault();
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
				url: 'do.php',
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
		var claveTemp = $("#claveTemporal").val();
		$.ajax({
			url: 'do.php',
			type: 'POST',
			dataType: 'html',
			data: "action=borrarProductoTemporalFactura&idClave="+idClave+"&claveTemporal="+claveTemp,
		})
		.done(function(data) {
			//$(".tablaProductosTemporales").html('');
			$(".tablaProductosTemporales").html(data);
		})
		$.ajax({
			url: 'do.php',
			type: 'POST',
			dataType: 'html',
			data: "action=borrarProductoTemporalFacturaView&claveTemporal="+claveTemp,
			success:function(data){
				$(".tablaProductosFactura").html(data);
			}
		})
		return false;
		event.preventDefault();
	});
	$(document).on('click', '.btn-masProductos', function(event) {
		var precioVen 		= $("#precioVenta").val();
		var cantidad 			= $("#cantidadProducto").val();
		var precioEsp 		= $("#precioEspecial").val();
		var claveTemp 		= $("#claveTemporal").val();
		var idProducto 		= $("#selectorProducto").val();
		var nombreCliente = $("#nombreCliente").val();
		var celularCliente= $("#telefonoCliente").val();
		var ciudadCliente = $("#ciudadCliente").val();
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
		}else if (nombreCliente=='') {
			$(".emptyNombreCliente").removeClass('d-none');
			setTimeout(function() {
				$(".emptyNombreCliente").addClass('d-none');
				$("#nombreCliente").focus();
			}, 500);
		}else if (celularCliente=='') {
			$(".emptyCelularCliente").removeClass('d-none');
			setTimeout(function() {
				$(".emptyCelularCliente").addClass('d-none');
				$("#telefonoCliente").focus();
			}, 500);
		}else{
			$(".btn-masProductos").addClass('d-none')
			$(".spinner-masProductos").removeClass('d-none');
			$(".labelBtn").remove();
			$(".spinner-masProductos").after('<label for="btn-masProductos" class="form-label labelBtn" style="letter-spacing: 2px;">Guardando producto...</label>');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: "action=GuardarProductoTemporalFactura&claveTemporal="+claveTemp+"&idProducto="+idProducto+"&cantidad="+cantidad+"&precioVenta="+precioVen+"&precioEspecial="+precioEsp,
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
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: "action=GuardarProductoTemporalFacturaView&claveTemporal="+claveTemp,
				success:function(data){
					$(".tablaProductosFactura").html(data)
				}
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
		event.preventDefault();
	});
	$(document).on('click', '.btn-Nocontinuar', function(event) {
		$(".btn-agregarotroProducto").addClass('d-none');
		selectorProductos();		
		$(".selectorProducto").removeClass('d-none');
		$(".detallesCotizacion").removeClass('d-none');
		/*$(".btn-NoMas").addClass('d-none')
		*/
		event.preventDefault();
	});
	$(document).on('click', '.guardarCotizacion', function(event) {
		var nombreCliente = $("#nombreCliente").val();
		var celularCliente= $("#telefonoCliente").val();
		var ciudadCliente = $("#ciudadCliente").val();
		var formadePago 	= $("#formaPago").val();
		var tiempoEntrega = $("#tiempoEntrega").val();
		var validezCotiza = $("#validezCotizacion").val();
		var garantiaDetall= $("#detallesGarantia").val();
		if (nombreCliente == '' ) {
			$(".emptyNombreCliente").removeClass('d-none');
			$(".tablaProductosTemporales").addClass('d-none');
			$(".detallesCotizacion").addClass('d-none');
			setTimeout(function() {
				$(".tablaProductosTemporales").removeClass('d-none');
				$(".detallesCotizacion").removeClass('d-none');
				$(".emptyNombreCliente").addClass('d-none');
				$("#nombreCliente").focus();
			}, 2000);
		}else if (celularCliente == '' ) {
			$(".emptyCelularCliente").removeClass('d-none');
			$(".tablaProductosTemporales").addClass('d-none');
			$(".detallesCotizacion").addClass('d-none');
			setTimeout(function() {
				$(".tablaProductosTemporales").removeClass('d-none');
				$(".detallesCotizacion").removeClass('d-none');
				$(".emptyCelularCliente").addClass('d-none');
				$("#telefonoCliente").focus();
			}, 2000);
		}else if (ciudadCliente == null ) {
			$(".emptyCiudadCliente").removeClass('d-none');
			$(".tablaProductosTemporales").addClass('d-none');
			$(".detallesCotizacion").addClass('d-none');
			setTimeout(function() {
				$(".tablaProductosTemporales").removeClass('d-none');
				$(".detallesCotizacion").removeClass('d-none');
				$(".emptyCiudadCliente").addClass('d-none');
				$("#ciudadCliente").focus();
			}, 2000);
		}else if (formadePago == null ) {
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
		}else if (validezCotiza == '' ) {
			$(".emptyValidezOferta").removeClass('d-none');
			setTimeout(function() {
				$(".emptyValidezOferta").addClass('d-none');
				$("#validezCotizacion").focus();
			}, 2000);
		}else if (garantiaDetall == '' ) {
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
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#generarCotizacion").serialize(),
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
  function contador(input,maximo){
    function actualizarContador(input){
      var caracteres = $(input).val().length;
      if (caracteres > maximo) {
        $(input).attr('disabled', true);
        if (input == "#nombreCliente" || input == "#nombre_Cliente" ) {
          $(".limiteNombreExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteNombreExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
          }, 1500);
        }else if (input == "#empresaCliente" || input == "#empresa_Cliente" ) {
          $(".limiteNombreEmpresaExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteNombreEmpresaExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
          }, 1500);
        }
      }
    }
    $(input).keyup(function(event) {
      actualizarContador(input);
    });
    $(input).change(function(event) {
      actualizarContador(input);
    });
  }
  contador("#nombre_Cliente",20); contador("#nombreCliente",20); contador("#empresaCliente",25); contador("#empresa_Cliente",25);
});