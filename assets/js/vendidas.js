$(function () {

	$("#listaVendidas").DataTable({ responsive: true, order: false });
	$(document).on('click', '.Buscar', function (event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});

	$(document).on('click', '.borrar_venta', function (event) {
		event.preventDefault();
		let idCotizacion = $(this).attr("id");
		console.log("idCotizacion a borrar es: ");
		console.log(idCotizacion);
		swal.fire({
			title: "¿CAMBIAR LA VENTA A GENERADA?",
			text: "El stock regresara al inventario",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: "Sí",
			cancelButtonText: "Cancelar",
		})
			.then(resultado => {
				if (resultado.value) {
					$.ajax({
						url: "includes/borrar_venta.php",
						type: "POST",
						dataType: "json",
						data: { idCotizacion: idCotizacion },
						success: function (data) {
							console.log("resultado borrado");
							console.log(data);
							(data == 'ok') ? swal_correcto() : swal_error();
							setTimeout(function () {
								location.replace("/?root=generadas");
							}, 2000);
						},
					});
				}
			});

	});

	$(document).on('click', '.btn_modal_editar_nota_venta', function (event) {
		event.preventDefault();
		$("#modal_editar_nota_venta").modal();
		let idNotaEntrega = $(this).attr("id");
		console.log('idNotaEntrega:');
		console.log(idNotaEntrega);
		$.ajax({
			url: "includes/ajax/get_data_nota_venta.php",
			type: "POST",
			dataType: "json",
			data: { idNotaEntrega: idNotaEntrega },
			success: function (data) {
				console.log("Datos Nota Entrega:");
				$("#actualizar_idNotaE").val(data.idNotaE);
				$("#observaciones_editar_nota_venta").val(data.observaciones);

				let modalTitle = document.querySelector(".titulo_modal");
				modalTitle.textContent = "EDITAR NOTA DE VENTA Nº" + idNotaEntrega;
			},
		});

	});
	$(document).on('click', '.actualizar_nota_venta', function (event) {
		event.preventDefault();
		let idNotaEntrega = $("#actualizar_idNotaE").val();
		let observaciones = $("#observaciones_editar_nota_venta").val();
		console.log('idNotaEntrega actualizar es:');
		console.log(idNotaEntrega);
		console.log(observaciones);
		observaciones = (observaciones == '' || observaciones == null) ? ' ' : observaciones;
		$.ajax({
			url: "includes/ajax/actualizar_nota_venta.php",
			type: "POST",
			dataType: "json",
			data: {
				idNotaEntrega: idNotaEntrega,
				observaciones: observaciones
			},
			success: function (data) {
				$("#modal_editar_nota_venta").modal("hide");
				console.log(data);
				(data == 'ok') ? swal_correcto() : swal_error();
				setTimeout(function () {
					location.reload()
				}, 5000);
			},
		});

	});

	//Inicio copiar todo de compradas Facturacion aqui tal cual 
	$(document).ready(function () {
		$("form").keypress(function (e) {
			if (e.which == 13) {
				return false;
			}
		});
	});
	$('#ClienteProducto').select2({
		dropdownParent: $('#modalFacturaFR .modal-body')
	});
	// $("#ClienteProducto").select2();
	// $("#ClienteProducto").select2({
	// 	theme: "classic"
	// });
	//	OBTENER DATOS DEL PRODUCTO
	$("#ClienteProducto").change(function () {
		$(this).select2('close');
		$("#ClienteProducto option:selected").each(function () {
			var idProducto = $(this).val();
			var miCiudad = $("#miCiudad").val();

			$.ajax({
				url: 'includes/api_facturacion/getDataProductoFiscales.php',
				type: 'POST',
				dataType: 'json',
				data: { id: idProducto },
				success: function (data) {
					$(".PreciosProductoSelected").removeClass('d-none');

					$("#CantidadProducto").val('1');
					$("#PrecioEspecial").val('');
					$("#PrecioEspecial").focus();
					$("#ProdExistenciaCB").val(data.saldo_fisico);
					$("#fecha_poliza").val(data.fecha_poliza);
					$("#PrecioLista").val(data.c_u_facturar_minimo);
					$("#PrecioEspecial").val(data.importes_para_facturar);

					$("#idProducto").val(data.idProducto);
					$("#detalle").val(data.detalle);

					if (data.codigo == '' || data.codigo == null) {
						$("#codigo").val('Sin Código');
					} else { $("#codigo").val(data.codigo); }


					$(".Add_ProductoEmision").attr('disabled', false);

				}
			})
		});
	});
	$(document).on("click", ".borrar", function (event) {
		event.preventDefault();
		$(this).closest("tr").remove();
		//document.getElementById("total").value = "Modo Debito";
		// actualizarSubTotal();
		actualizarTotal();

	});
	$(document).on("click", ".btnFacturaModalCargarDatos", function (event) {
		event.preventDefault();
		let id = $(this).attr("id");
		$.ajax({
			url: "includes/api_facturacion/getDataCompradas.php",
			type: "POST",
			dataType: "json",
			data: { id: id },
			success: function (data) {
				$("#clientReasonSocial").val(data.NombreCliente);
				$("#clientNroDocument").val(data.nitCliente);
				//$("#clientCode").val(data.nitCliente);
				$("#clientCity").val(data.ciudadCliente);
				$("#clientEmail").val(data.correoCliente);
				$("#userPos").val(data.nombreVendedor);

				$("#branchIdName").val(data.sucursalCompra);
				$("#idCotizacion").val(data.idCotizacion);

				$('#tableProductosVendidos').empty();
				var DatosJson = JSON.parse(JSON.stringify(data));
				console.log(DatosJson.productosVendidos.length);

				//	fiscales productos ocultar inicio
				$(".Add_ProductoEmision").attr('disabled', true);
				$(".efectAddProduct").addClass('d-none');
				$(".PreciosProductoSelected").addClass('d-none');
				$(".checkOptions").addClass('d-none');
				$(".showTableProd").removeClass('d-none');
				$(".datosAdicionales").removeClass('d-none');
				$(".btnSaveCotiza").removeClass('d-none');
				//	fiscales productos ocultar fin

				$("#tableProductosVendidos").append(
					'<thead class="thead-dark">' +
					'<tr>' +
					'<th scope="col" width="15%" class="text-center p-5">' +
					'<h5>Cantidad' +
					'</th>' +
					'<th scope="col" width="15%" class="text-center p-5">' +
					'<h5>CodProd' +
					'</th>' +
					'<th scope="col" width="40%" class="text-center p-5">' +
					'<h5>Producto' +
					'</th>' +
					'<th scope="col" width="15%" class="text-center p-5">' +
					'<h5>PrecioUnidad Bs' +
					'</th>' +
					'<th scope="col" width="15%" class="text-center p-5">' +
					'<h5>SubTotal Bs' +
					'</th>' +
					'<th scope="col" width="15%" class="text-center p-5">' +
					'<h5>Eliminar' +
					'</th>' +
					'</tr>' +
					'</thead>' +
					'<tbody>');
				let count = 0;
				for (i = 0; i < DatosJson.productosVendidos.length; i++) {

					count = i;
				}
				$("#tableProductosVendidos").append(
					'<thead class="thead-light">' +
					'<tr>' +
					'<th colspan="4" class="text-right p-4 "><strong><h4>TOTAL</h4></strong></th>' +
					'<th scope="col">' +
					'<input class="form-control text-right" readonly name="total" id="total" value="' + DatosJson.dataTotal * 0 + '">' +
					'<input name="count" id="count" type="hidden" value="' + count + '">' +
					'<input name="correlativo" id="correlativo" type="hidden" value="">' +
					'</th>' +
					'<th scope="col" class="text-left p-4 "><strong><h4>Bs</h4></strong></th>' +
					'</tr>' +
					'</thead>' +
					'</tbody>');
				actualizarclientCode();
				actualizarSubTotal();


			},
		});

	});

	//	AGREGAR PRODUCTO A LA TABLA factura
	$(document).on('click', '.Add_ProductoEmision', function (event) {
		event.preventDefault();
		//$(".showTableProd").removeClass('d-none');
		var idProducto = $("#ClienteProducto option:selected").val();
		var PrecioLista = $("#PrecioLista").val();
		var Cantidad = $("#CantidadProducto").val();
		var PrecioEspec = $("#PrecioEspecial").val();
		var ClaveCotiza = $("#ClaveGeneradaAleatoria").val();
		var saldo_fisico = $("#ProdExistenciaCB").val();
		if (idProducto == 'Seleccione producto') {
			$(".noSelectProd").removeClass('d-none');
			setTimeout(function () {
				$(".noSelectProd").addClass('d-none');
			}, 2000);
			//return false;
		} else if (Cantidad == '') {
			$(".CantidadEmpty").removeClass('d-none');
			setTimeout(function () {
				$(".CantidadEmpty").addClass('d-none');
			}, 2000);
			//return false;
		}
		else if (parseInt(Cantidad, 10) > parseInt(saldo_fisico, 10) || parseInt(Cantidad, 10) <= 0) {
			$(".CantidadEmpty").removeClass('d-none');
			setTimeout(function () {
				$(".CantidadEmpty").addClass('d-none');
			}, 2500);
			//return false;
		} else if (PrecioEspec == '') {
			$(".emptyPrecioEsp").removeClass('d-none');
			setTimeout(function () {
				$(".emptyPrecioEsp").addClass('d-none');
			}, 2000);
			//return false;
		} else {
			$(".efectAddProduct").removeClass('d-none');
			$(".Add_ProductoEmision").attr('disabled', true);
			agregar_prodFiscal();
			setTimeout(function () {
				$(".efectAddProduct").addClass('d-none');
				$(".Add_ProductoEmision").attr('disabled', false);
				$(".PreciosProductoSelected").addClass('d-none');
				$(".checkOptions").addClass('d-none');
				$(".showTableProd").removeClass('d-none');
				$(".datosAdicionales").removeClass('d-none');
				$(".btnSaveCotiza").removeClass('d-none');
				//$("#respuesta").html(data);
			}, 2000);

		}
	});
	$(document).on('click', '.facturarSintic', function (event) {
		event.preventDefault();
		$('.facturarSintic').attr('disabled', true);  //boton facturar desactivar
		$(".efectSaveCotiza").removeClass('d-none');

		let clientReasonSocial = $("#clientReasonSocial").val();
		let clientDocumentType = $("#clientDocumentType").val();  //nit ,ci ,pasaporte
		let clientNroDocument = $("#clientNroDocument").val();  //numero nit o nro carnet
		let clientCode = $("#clientCode").val();					//codigo unico cliente
		let clientCity = $("#clientCity").val();					//ciudad cliente(personal)

		let clientEmail = $("#clientEmail").val();		// email cliente

		let userPos = $("#userPos").val(); 					//vendedor que emitio la factura
		let paramCurrency = $("#paramCurrency").val();		//tipo de moneda 
		let paramPaymentMethod = $("#paramPaymentMethod").val(); // tipo o metodo de pago para siat


		let datosPostCliente = "clientReasonSocial=" + clientReasonSocial +
			"&clientDocumentType=" + clientDocumentType +
			"&clientNroDocument=" + clientNroDocument +
			"&clientCode=" + clientCode +
			"&clientCity=" + clientCity +
			"&clientEmail=" + clientEmail;
		//crear cliente
		// Esta función asíncrona respuesta de api crear cliente
		//1er paso crear cliente y retornar
		var crearClienteApi = () => {
			return new Promise((resolve, reject) => {
				$.ajax({
					url: 'includes/api_facturacion/crear_cliente.php',
					type: 'POST',
					dataType: 'json',
					data: datosPostCliente,
					beforeSend: function () {
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
					},
					success: function (data) {
						if (data.response == 'ok') {
							let clienteCreado = {
								customer_id: data.customer_id,
								first_name: data.first_name,
								identity_document: data.identity_document,
								email: data.email
							}
							console.log('ClienteCreado en api');
							resolve(clienteCreado);//promesa resuelta xd

						} else {
							console.log('error crear cliente en api');
							reject('error');
						}
					}
				});
			});
		}
		clienteListo();
		async function clienteListo() {
			try {
				let clienteCreado = await crearClienteApi();
				console.log(clienteCreado);
				//mandamos para facturar
				let customer_id = clienteCreado.customer_id;
				let first_name = clienteCreado.first_name;
				let identity_document = clienteCreado.identity_document;
				let email = clienteCreado.email;
				let idCotizacion = $("#idCotizacion").val();
				let tipo_venta = $("#tipo_venta").val();//marca para diferenciar
				let tipo_documento_identidad = parseInt($("#clientDocumentType").val());
				let codigo_metodo_pago = parseInt($("#paramPaymentMethod").val());
				let subtotal = parseFloat($("#total").val());
				let total = parseFloat($("#total").val());
				let total_tax = parseFloat(total * 0.13);


				let items = { items: capturar_carrito() }
				items = JSON.stringify(items)
				// console.log(items);

				let datosPostFactura = "customer_id=" + customer_id +
					"&first_name=" + first_name +
					"&identity_document=" + identity_document +
					"&email=" + email +
					"&idCotizacion=" + idCotizacion +
					"&tipo_venta=" + tipo_venta + //marca para diferenciar
					"&tipo_documento_identidad=" + tipo_documento_identidad +
					"&codigo_metodo_pago=" + codigo_metodo_pago +
					"&subtotal=" + subtotal +
					"&total=" + total +
					"&total_tax=" + total_tax +
					"&items=" + items;



				$.ajax({
					url: 'includes/api_facturacion/facturacionsintic.php',
					type: 'POST',
					dataType: 'json',
					data: datosPostFactura,
					success: function (data) {
						if (data.response == 'ok') {
							console.log('Factura Exitosa');
							Swal.fire({
								type: 'success',
								title: "FACTURACIÓN EXITOSA",
								animation: false,
								customClass: {
									popup: 'animated bounceInDown'
								},
								icon: "success",
								button: "Ok",
								text: "Factura Guardada Correctamente",
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
								location.replace('?root=facturacion_listado');
							}, 5000);

						} else {
							Swal.fire({
								type: 'error',
								title: "ERROR AL CONECTAR CON IMPUESTOS NACIONALES",
								animation: false,
								customClass: {
									popup: 'animated bounceInDown'
								},
								text: "Error de  Conexion Con SIAT , Intente Nuevamente",
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
							}, 7000);
							//$('.facturarSintic').attr('disabled', false);  //boton facturar desactivar
							$(".efectSaveCotiza").addClass('d-none');

						}

					}
				});

			} catch (error) {
				console.log(error);
				Swal.fire({
					type: 'error',
					title: "ERROR AL CONECTAR CON IMPUESTOS NACIONALES",
					animation: false,
					customClass: {
						popup: 'animated bounceInDown'
					},
					text: "Error de  Conexion Con SIAT , Intente Nuevamente",
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
				}, 7000);
				//$('.facturarSintic').attr('disabled', false);  //boton facturar reactivar
				$(".efectSaveCotiza").addClass('d-none');
				console.log('Fallo Crear cliente, forzando login api');
				let auth_login = "auth_login=1";
				$.ajax({
					url: 'includes/api_facturacion/auth_login.php',
					type: 'POST',
					dataType: 'json',
					data: auth_login,
					success: function (data) {
						if (data == 'ok') {
							console.log('Login correcto, token actualizado');
						} else {
							console.log('Error login, token no actualizado');
						}
					}
				});
			}
		}



	});
	//fin copiar todo de compradasfacturacion aqui tal cual 
});

//inicio 2 _metodos para facturar copiar tal cual
function capturar_carrito() {

	let numero_fiscales = $("#correlativo").val();
	let carrito = [];
	for (let i = 100; i <= numero_fiscales; i++) {
		if ($("#" + i + "description").val()) {

			let codeProduct = $("#" + i + "codeProduct").val();
			let description = $("#" + i + "description").val();
			let idProductoFiscal = parseInt($("#" + i + "idProductoFiscal").val());
			let qty = parseInt($("#" + i + "qty").val());
			let priceUnit = (parseFloat($("#" + i + "priceUnit").val())).toFixed(2);
			priceUnit = parseFloat(priceUnit);
			let subTotal = (parseFloat($("#" + i + "subTotal").val())).toFixed(2);
			subTotal = parseFloat(subTotal);
			let producto = {
				product_id: 0, //defecto api
				product_code: codeProduct,
				product_name: description,
				price: priceUnit,
				quantity: qty,

				total: subTotal,
				unidad_medida: 62, //defecto api
				numero_serie: "",
				numero_imei: "",
				codigo_producto_sin: 99794, //defecto api

				codigo_actividad: "465000", //defecto api
				discount: 0,

				idProductoFiscal: idProductoFiscal,
				prodF: 'si'
			}
			carrito.push(producto);
		}
	}
	// console.log(carrito);
	return carrito;

}
function actualizarclientCode() {
	let iniciales = "";
	let clientReasonSocial = document.getElementById("clientReasonSocial").value;
	for (x = 0; x < clientReasonSocial.length; x++) {
		if (x == 0) {
			iniciales = iniciales + clientReasonSocial.charAt(x);
		}
		if (clientReasonSocial.charAt(x + 1) != ' ') {
			if (clientReasonSocial.charAt(x) == ' ') {
				iniciales = iniciales + clientReasonSocial.charAt(x + 1);
			}
		}
	}
	document.getElementById("clientCode").value = "CLIENT-" + iniciales +
		clientReasonSocial.length;
}

function actualizarSubTotal() {
	let count = document.getElementById("count").value;
	count = parseFloat(count);
	let subtotal = 0;
	let sum = 0;

	for (x = 0; x <= count; x++) {

		if (document.getElementById(x + "priceUnit") != null) {
			let price = parseFloat(document.getElementById(x + "priceUnit").value);
			let qty = parseInt(document.getElementById(x + "qty").value);
			document.getElementById(x + "subTotal").value = (price * qty).toFixed(2);
		}

	}
	for (x = 100; x <= correlativo; x++) {

		if (document.getElementById(x + "priceUnit") != null) {
			let price = parseFloat(document.getElementById(x + "priceUnit").value);
			let qty = parseInt(document.getElementById(x + "qty").value);
			document.getElementById(x + "subTotal").value = (price * qty).toFixed(2);
		}

	}
	actualizarTotal();
}

function actualizarTotal() {
	let count = document.getElementById("count").value;
	count = parseFloat(count);

	let sum = 0;
	for (x = 0; x <= count; x++) {
		if (document.getElementById(x + "subTotal") != null) {
			sum = sum + parseFloat(document.getElementById(x + "subTotal").value);
		}

	}
	for (x = 100; x <= correlativo; x++) {
		if (document.getElementById(x + "subTotal") != null) {
			sum = sum + parseFloat(document.getElementById(x + "subTotal").value);
		}

	}

	document.getElementById("total").value = sum.toFixed(2);
}

function actualizarCantidad(fila) {
	let count = document.getElementById("count").value;
	//let price = parseFloat(document.getElementById(x + "precioUnidad").value);
	// document.getElementById(fila + "qty").value = 1;
	count = parseFloat(count);
	actualizarSubTotal();
	actualizarTotal();
}

var correlativo = 100;
function agregar_prodFiscal() {
	correlativo++;
	var username = $('#username').val();
	var myLabel = $('#miLabel');


	let idProducto = document.getElementById("idProducto").value;
	let CantidadProducto = document.getElementById("CantidadProducto").value;
	let codigo = document.getElementById("codigo").value;

	let detalle = document.getElementById("detalle").value;

	let PrecioEspecial = document.getElementById("PrecioEspecial").value;

	let saldo_fisico = document.getElementById("ProdExistenciaCB").value;
	let c_u_facturar_minimo = document.getElementById("PrecioLista").value;

	$('#tableProductosVendidos').append(
		"<tr  id='fila" + correlativo + "'>" +
		"<td>" +
		"<input type='hidden' name='" + correlativo + "idProductoFiscal' id='" + correlativo + "idProductoFiscal' value='" + idProducto + "'>" +
		//id del producto fiscal
		"<input class='form-control text-center' min='1' max='" + saldo_fisico + "' type='number'  name='" + correlativo + "qty'" +
		"id='" + correlativo + "qty' saldo_fisico='" + saldo_fisico + "' onchange='actualizarSubTotal()' oninput='actualizarSubTotal()' value='" + CantidadProducto + "'>" +
		"<label for='" + correlativo + "qty'> SaldoFisico: <b>" + saldo_fisico + "</b></label>" +
		"</td>" +
		"<td>" +
		"<input class='form-control' id='" + correlativo +
		"codeProduct'  placeholder='CODE' value='" + codigo + "'>" +
		"</td>" +
		"<td>" +
		"<input class='form-control' id='" + correlativo +
		"description' placeholder='DescripcionProducto' value='" + detalle + "'>" +
		"</td>" +
		"<td>" +
		"<input class='form-control text-right' type='number' min='" + c_u_facturar_minimo + "' c_u_facturar_minimo='" + c_u_facturar_minimo + "' placeholder='PrecioUnidad' name='" +
		correlativo + "priceUnit' id='" + correlativo +
		"priceUnit' onchange='actualizarSubTotal()' oninput='actualizarSubTotal()' value='" + PrecioEspecial + "'>" +
		"<label for='" + correlativo + "priceUnit'> Facturar Minimo: <b>" + c_u_facturar_minimo + "</b></label>" +
		"</td>" +
		"<td>" +
		"<input class='form-control text-right' readonly name='" +
		correlativo + "subTotal' id='" + correlativo +
		"subTotal'  value='' >" +
		"</td>" +
		"<td>" +
		"<button class='btn btn-info borrar' title='" + correlativo + "-" + idProducto +
		"' onClick='eliminarxdxd(" + correlativo + ")'>Eliminar</button>" +
		"</td>" +
		"</tr>");

	document.getElementById("correlativo").value = correlativo;
	actualizarSubTotal();
	actualizarTotal();
}

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

//final 2 _metodos para facturar copiar tal cual

//swalfires
function swal_correcto() {
	Swal.fire({
		icon: 'success',
		title: 'Correcto',
		animation: false,
		customClass: {
			popup: 'animated bounceInDown'
		}
	})
}
function swal_error() {
	Swal.fire({
		icon: 'error',
		title: 'Error',
		animation: false,
		customClass: {
			popup: 'animated bounceInDown'
		}
	})
}