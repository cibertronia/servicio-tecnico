$(function () {
	$('#listaProductos').DataTable({ responsive: true });
	$(".select2").select2();
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
		callbacks: {
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
	$("#imgProducto").change(function () {
		var file = this.files[0];
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			$("#imgProducto").after('<div class="mt-2 text-center text-danger formatNoValido">FORMATO NO VÁLIDO</div>');
			setTimeout(function () {
				$(".formatNoValido").remove();
			}, 2500);
			$("#imgProducto").val('');
			return false;
		} else {
			$(".textcambiarImagen").html('CAMBIAR IMAGEN');
			$(".fileinput-button").removeClass('btn-warning');
			$(".fileinput-button").addClass('btn-primary');

			/*$(".btnGuardaImagen").removeClass('d-none');
			$(".fileinput-button").addClass('d-none');*/
		}
	});
	function filePreview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imgx + img').remove();
				$('#imgx').after('<img src="' + e.target.result + '" width="150"/>');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgProducto").change(function () { filePreview(this); });
	$(document).on('click', '.cerrarPanelEditar', function (event) {
		$(".tooltip").hide();
		$("#panelEditarProducto").addClass('d-none');
		$("#panelProductos").removeClass('d-none');
		event.preventDefault();
	});
	
    $(document).on('click', '.btnLog', function (event) {
		var idProducto = $(this).data('idprod1');
		console.log(idProducto);
		window.open('l.php?p=' + idProducto   , '_blank' );
		
		event.preventDefault();
	});
	
	
	//Este código posiblemente no se use y ni recuerdo nada de el.
	$(document).on('click', '.btnBuscar', function (event) {
		$(".tooltip").hide();
		var opciones = $("#opcionesBusqueda").val();
		var clave = $("#claveBusqueda").val();
		if (opciones == null) {
			$("#opcionesBusqueda").after('<div class="mt-2 text-center text-danger noSelectOption">SELECCIONE UNA OPCION</div>');
			setTimeout(function () {
				$(".noSelectOption").remove();
			}, 2500)
		} else if (clave == '') {
			$("#claveBusqueda").after('<div class="mt-2 text-center text-danger noTextBusqueda">INGRESE EL TEXTO</div>');
			setTimeout(function () {
				$(".noTextBusqueda").remove();
			}, 2500)
		} else {
			$("#botonBuscar").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'includes/consultas.php',
				type: 'POST',
				dataType: 'html',
				data: { buscarProductosxFiltro: opciones, clave },
			})
				.done(function (data) {
					$(".listaProductos").removeClass('d-none');
					$("#botonBuscar").removeClass('d-none');
					$(".spinner").addClass('d-none');
					$(".respuestaBusqueda").html(data);
				})
		}
		event.preventDefault();
	});
	$(document).on('click', '.openPaneleditProducto', function (event) {
		$("#panelEditarProducto").removeClass('d-none');
		$("#panelProductos").addClass('d-none');
		$(".tooltip").hide();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: { monedaPrincipal: '' },
			success: function (data) {
				$(".simboloMoneda").html(data.simbolo)
			}
		});
		var idProducto = $(this).attr('id');
		var servProvee = $("#configuracionProveedor").val();
		var servCateg = $("#configuracionCategorias").val();
		var servStock = $("#configuracionStock").val();
		var sucursales = $("#numeroSucursales").val();
		if (servProvee == 1) {
			var proveedor = $("#proveedor").val();
		} else if (servCateg == 1) {
			var categoria = $("#categorias").val();
		}
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: { buscarDatosProductoJSON: idProducto },
			success: function (data) {
				$("#idProductoPanelEdit").val(idProducto);
				$("#proveedor").val(data.idProveedor);
				$("#categorias").val(data.idCategoria);
				$("#mercaderiaProducto").val(data.mercaderia);
				$("#nombreProducto").val(data.nombre);
				$("#marcaProducto").val(data.marca);
				$("#modeloProducto").val(data.modelo);
				$("#obsProducto").val(data.observaciones);
				$("#industriaProducto").val(data.industria);
				$("#precioProducto").val(data.precio);
				$("#caracteristicasProducto").summernote("code", data.descripcion)
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.opnelModalEditImagen', function (event) {
		var idProducto = $(this).attr('id');
		$('#imgx + img').remove();
		$("#openModalEditImagen").modal();
		$("#idProductoImagenModal").val(idProducto);
		$(".tooltip").hide();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: { llamarImagenproducto: idProducto },
			success: function (data) {
				var imagen = '<img src="Productos/' + data.imagen + '" alt="img Producto" width="150" >';
				$("#imgx").after(imagen);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.btnActualizarProducto', function (event) {
		$(".tooltip").hide();
		var servProvee = $("#configuracionProveedor").val();
		var servCateg = $("#configuracionCategorias").val();
		var servStock = $("#configuracionStock").val();
		if (servProvee == 1) { var proveedor = $("#proveedor").val(); }
		if (servCateg == 1) { var categoria = $("#categorias").val(); }
		var nombreProducto = $("#nombreProducto").val();
		var marcaProducto = $("#marcaProducto").val();
		var modeloProducto = $("#modeloProducto").val();
		var indust = $("#industriaProducto").val();
		var precioProducto = $("#precioProducto").val();
		var descripcion = $("#caracteristicasProducto").val();
		if (servProvee == 1 & proveedor == null) {
			$(".noSelectProveedor").removeClass('d-none');
			$(".caracteristicasProducto").addClass('d-none');
			setTimeout(function () {
				$(".noSelectProveedor").addClass('d-none');
				$(".caracteristicasProducto").removeClass('d-none');
				$("#proveedor").focus();
			}, 2000);
		} else if (servCateg == 1 & categoria == null) {
			$(".noSelectCategoria").removeClass('d-none');
			$(".caracteristicasProducto").addClass('d-none');
			setTimeout(function () {
				$(".noSelectCategoria").addClass('d-none');
				$(".caracteristicasProducto").removeClass('d-none');
				$("#categorias").focus();
			}, 2000);
		} else if (nombreProducto == '') {
			$(".emptyNombreProducto").removeClass('d-none');
			$(".caracteristicasProducto").addClass('d-none');
			setTimeout(function () {
				$(".emptyNombreProducto").addClass('d-none');
				$(".caracteristicasProducto").removeClass('d-none');
				$("#nombreProducto").focus();
			}, 2000);
		}
		// else if (marcaProducto == '') {
		// 	$(".emptyMarcaProducto").removeClass('d-none');
		// 	$(".caracteristicasProducto").addClass('d-none');
		// 	setTimeout(function () {
		// 		$(".emptyMarcaProducto").addClass('d-none');
		// 		$(".caracteristicasProducto").removeClass('d-none');
		// 		$("#marcaProducto").focus();
		// 	}, 2000);
		// } else if (modeloProducto == '') {
		// 	$(".emptyModeloProducto").removeClass('d-none');
		// 	$(".caracteristicasProducto").addClass('d-none');
		// 	setTimeout(function () {
		// 		$(".emptyModeloProducto").addClass('d-none');
		// 		$(".caracteristicasProducto").removeClass('d-none');
		// 		$("#modeloProducto").focus();
		// 	}, 2000);
		// } else if (indust == '') {
		// 	$(".emptyIndustriaProducto").removeClass('d-none');
		// 	$(".caracteristicasProducto").addClass('d-none');
		// 	setTimeout(function () {
		// 		$(".emptyIndustriaProducto").addClass('d-none');
		// 		$(".caracteristicasProducto").removeClass('d-none');
		// 		$("#indstriaProducto").focus();
		// 	}, 2000);
		// } 
		else if (precioProducto == '') {
			$(".emptyPrecioProducto").removeClass('d-none');
			$(".caracteristicasProducto").addClass('d-none');
			setTimeout(function () {
				$(".emptyPrecioProducto").addClass('d-none');
				$(".caracteristicasProducto").removeClass('d-none');
				$("#precioProducto").focus();
			}, 2000);
		} else if (precioProducto != '' & isNaN(precioProducto)) {
			$(".noValidoPrecioProducto").removeClass('d-none');
			$(".caracteristicasProducto").addClass('d-none');
			setTimeout(function () {
				$(".noValidoPrecioProducto").addClass('d-none');
				$(".caracteristicasProducto").removeClass('d-none');
				$("#precioProducto").focus();
			}, 2000);
		} else {
			$(".btnActualizarProducto").addClass('d-none');
			$(".spinner-ActualizarProducto").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formProducto").serialize(),
			})
				.done(function (data) {
					$(".btnActualizarProducto").removeClass('d-none');
					$(".spinner-ActualizarProducto").addClass('d-none');
					$(".respuesta").html(data);
				})
			return false;
		}
		event.preventDefault();
	});
	$("#img_file").change(function () {
		filePreview(this);
		$(".btnActualizaImgProducto").removeClass('d-none');
	});
	$("#img_file").change(function () {
		var file = this.files[0];
		var imagefile = file.type;
		var match = ["image/jpeg", "image/png", "image/jpg"];
		if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
			alert('Seleccione una imagen válida (JPEG/JPG/PNG).');
			$("#img_file").val('');
			return false;
		}
	});
	function filePreview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imgx + img').remove();
				$('#imgx').after('<img src="' + e.target.result + '" width="150"/>');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#actualizaImagen").submit(actualizarImgProducto);
	function actualizarImgProducto(event) {
		var formulario = new FormData($("#actualizaImagen")[0]);
		$(".btnActualizaImgProducto").addClass('d-none');
		$(".spinner").removeClass('d-none');
		$(".tooltip").hide();
		$.ajax({
			url: 'puerta_ajax.php',
			type: 'POST',
			data: formulario,
			contentType: false,
			processData: false,
		})
			.done(function (datos) {
				$(".btnActualizaImgProducto").removeClass('d-none');
				$(".spinner").addClass('d-none');
				$(".respuesta").html(datos);
			});
		return false;
		event.preventDefault();
	}
	$(document).on('click', '.updateStock', function (event) {
		$(".tooltip").hide();
		$("#stockSucursal_modal").modal();
		var idInventario = $(this).attr('id');
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: { buscarDatosStockSucursal: idInventario },
			success: function (data) {
				$("#nombreSucursal_modal").val(data.nombreTienda);
				$("#idInventario_modal").val(idInventario);
				$(".nombreSucursal").html(data.nombreTienda);
				$("#stockSucursalModal").val(data.stock)
				$(".respuesta").html(data)
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.btnActualizarStock', function (event) {
		var stock = $("#stockSucursalModal").val();
		if (stock == '') {
			$(".stockVacio").removeClass('d-none');
			setTimeout(function () {
				$(".stockVacio").addClass('d-none');
			}, 1500);
		} else {
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formStockSucursal").serialize(),
			})
				.done(function (data) {
					$("#stockSucursal_modal").modal('hide');
					//$(".listaProductos").html(data);
					
					var id = $("#idInventario_modal").val();
					var total =  $("#stockSucursalModal").val();
					$("#" + id).text( total);
					
					
					 var idtotal= $("#" + id).data("idtotal");
					 
					 $("#" + idtotal).text( data );
					
					  
				})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.buttonexcel', function (event) {
		$(".buttonexcel").attr('disabled', true);

		var Form = new FormData($('#filesForm')[0]);
		$.ajax({

			url: "includes/recibir_excel_csv/recibe_excel_validanpuerta_ajax.php",
			type: "post",
			dataType: 'json',
			data: Form,
			processData: false,
			contentType: false,
			beforeSend: function () {
				Swal.fire({
					type: 'info',
					title: 'CONECTANDO',
				})
				setTimeout(function () {
					//location.reload();
				}, 4500);
			},
			success: function (data) {
				console.log(data);
				if (data == 'ok') {
					Swal.fire({
						type: 'success',
						title: 'IMPORTADO CORRECTAMENTE',
					})
					setTimeout(function () {
						location.reload();
					}, 4500);
				}
				if (data == 'error') {
					Swal.fire({
						type: 'error',
						title: 'ERROR AL IMPORTAR ARCHIVO',
					})
					setTimeout(function () {
						location.reload();
					}, 4500);
				} if (data != 'ok' && data != 'error') {
					$(".buttonexcel").attr('disabled', false);
					Swal.fire({
						type: "error",
						title: "ARCHIVO NO SELECCIONADO",
					})
					setTimeout(function () {
						//location.reload();
					}, 2500);
				}

			}
		});
	});

	let exportFormatter = {
		format: {
			body: function (data, row, column, node) {
				if ((column === 11) || (column === 5))
					return '';
				else if ((column >= 6 ) && (column <= 10)){
					var s = data;
					var htmlObj = $(s);
					return htmlObj.text();
				}
				else {
					return data;
				}
			}
		}
	};

	// obteniendo rango de usuario
	const rango = $('#js-page-content').data('rango');
	
	// creando constante para layout de dataTable con botones dependiendo del rango de usuario
	const topEnd = (rango == 2) ? "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" : "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f>>";	

	$('#listamisVentas').dataTable({
		responsive: true,
		lengthChange: false,
		dom:
			/*  --- Layout Structure 
			--- Options
			l   -   length changing input control
			f   -   filtering input
			t   -   The table!
			i   -   Table information summary
			p   -   pagination control
			r   -   processing display element
			B   -   buttons
			R   -   ColReorder
			S   -   Select
		
			--- Markup
			< and >             - div element
			<"class" and >      - div with a class
			<"#id" and >        - div with an ID
			<"#id.class" and >  - div with an ID and a class
		
			--- Further reading
			https://datatables.net/reference/option/dom
			-------------------------------------- */
			
			topEnd +
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
			/*{
			  extend:    'colvis',
			  text:      'Column Visibility',
			  titleAttr: 'Col visibility',
			  className: 'mr-sm-3' 
			},
			{    
			  extend: 'pdfHtml5',
			  text: 'PDF',
			  titleAttr: 'Generate PDF',
			  className: 'btn-outline-danger btn-sm mr-1'
			},
			*/
			//   {    
			// 	extend: 'excelHtml5',
			// 	text: 'Excel',
			// 	titleAttr: 'Generar Excel',
			// 	className: 'btn-outline-success btn-sm mr-1'
			//   },
			/*{        
			  extend: 'csvHtml5',
			  text: 'CSV',
			  titleAttr: 'Generate CSV',
			  className: 'btn-outline-primary btn-sm mr-1'
			},*/
			/*{        
			  extend: 'copyHtml5',
			  text: 'Copy',
			  titleAttr: 'Copy to clipboard',
			  className: 'btn-outline-primary btn-sm mr-1'
			},*/
			/*{        
			  extend: 'print',
			  text: 'Print',
			  titleAttr: 'Print Table',
			  className: 'btn-outline-primary btn-sm'
			}*/
		]
	});
	$(document).on('click', '.eliminar_repuesto', function (event) {
		let idProducto = $("#idProductoPanelEdit").val();
		console.log('repuesto a eliminar:')
		console.log(idProducto)

		swal.fire({
			title: "ELIMINAR REPUESTO",
			text: "¿Desea eliminar el repuesto seleccionado...?",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: "Sí",
			cancelButtonText: "Cancelar",
		})
			.then(resultado => {
				if (resultado.value) {
					$.ajax({
						url: 'includes/eliminar_repuesto.php',
						type: 'POST',
						dataType: 'json',
						data: { idProducto: idProducto },
						success: function (data) {
							if (data == 'ok') {
								swal.fire({
									title: "CORRECTO",
									text: "Repuesto Eliminado",
									icon: 'success',
								})

							} else {
								swal.fire({
									title: "ERROR",
									text: "Error al eliminar repuesto",
									icon: 'error',
								})
							}
							setTimeout(function () {
								location.reload();
							}, 3000)
						}
					})
				}
			});

	});




});
