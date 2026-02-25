$(function () {
	/*$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'html',
		data: {sucursalRegistrados: 'Cochabamba'},
		success:function(data){
			$("#listaRegistrados").html(data);
		}
	});*/
	$(".tooltip").hide();
	$('#listaRegistrados').dataTable({
		responsive: true,
		order: false
	});
	$("#garantiaEq").change(function (event) {
		$("#garantiaEq option:selected").each(function () {
			var garantia = $("#garantiaEq option:selected").val();
			if (garantia == 'si') {
				$(".opcionGarantia_div").removeClass('d-none');
				$("#fechaCompraEq").focus()
			} else {
				$(".opcionGarantia_div").addClass('d-none');
			}
		});
	});
	$("#garantia_Eq").change(function (event) {
		$("#garantia_Eq option:selected").each(function () {
			var garantia = $("#garantia_Eq option:selected").val();
			if (garantia == 'si') {
				$(".opcionGarantia_div").removeClass('d-none');
				$("#fechaCompra_Eq").focus()
			} else {
				$(".opcionGarantia_div").addClass('d-none');
			}
			$(".btnBotones").removeClass('d-none')
		});
	});
	/*$(document).on('click', '.btnCochabamba', function(event) {
		var sucursal = 'Cochabamba';
		$(".btnCochabamba").attr('disabled', true);
		$(".btnCochabamba").addClass('btn-danger');
		$(".btnCochabamba").removeClass('btn-primary');
		$(".btnSantaCruz").addClass('btn-primary');
		$(".btnSantaCruz").removeClass('btn-danger');
		$(".btnSantaCruz").attr('disabled', false);
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {sucursalRegistrados: sucursal},
			success:function(data){
				$("#listaRegistrados").html(data)
			}
		})
		event.preventDefault();
	});	
	$(document).on('click', '.btnSantaCruz', function(event) {
		var sucursal = 'Santa Cruz';
		$(".btnSantaCruz").attr('disabled', true);
		$(".btnSantaCruz").addClass('btn-danger');
		$(".btnSantaCruz").removeClass('btn-primary');
		$(".btnCochabamba").addClass('btn-primary');
		$(".btnCochabamba").removeClass('btn-danger');
		$(".btnCochabamba").attr('disabled', false);
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {sucursalRegistrados: sucursal},
			success:function(data){
				$("#listaRegistrados").html(data)
			}
		})
		event.preventDefault();
	});*/
	$(document).on('click', '.openModal_editInfoEquipo', function (event) {
		var idClave = $(this).attr('id');
		$("#openModal_editInfoEquipo").modal();
		$(".tooltip").hide();
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: { llamarServicioProductoJSON: idClave },
			success: function (data) {
				$("#sucursalModaleditInfoEquipo").val(data.sucursal);
				$("#idClaveEq").val(idClave);
				$("#eqNombre").val(data.equipo);
				$("#marcaEq").val(data.marca);
				$("#modeloEq").val(data.modelo);
				$("#serieEq").val(data.serie);
				$("#problemaEq").val(data.problema);
				$("#observacionesEq").val(data.observaciones);
				$("#garantiaEq").val(data.garantia);
				if (data.garantia == 'si') {
					$(".opcionGarantia_div").removeClass('d-none');
					$("#fechaCompraEq").val(data.fechaCompra);
					$("#numeroFacturaEq").val(data.numFactura);
				} else {
					$(".opcionGarantia_div").addClass('d-none');
				}
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.openModal_AddEquipo', function (event) {
		var idClave = $(this).attr('id');
		$("#openModal_AddEquipo").modal()
		$("#claveOtroEquipo").val(idClave);
		$(".tooltip").hide();
		event.preventDefault();
	});
	$(document).on('click', '#btnActualizaEq', function (event) {
		var nombre = $("#eqNombre").val();
		var marca = $("#marcaEq").val();
		var modelo = $("#modeloEq").val();
		var serie = $("#serieEq").val();
		var problema = $("#problemaEq").val();
		var observac = $("#observacionesEq").val();
		var garantia = $("#garantiaEq").val();
		var fCompra = $("#fechaCompraEq").val();
		var numFactura = $("#numeroFacturaEq").val();
		if (nombre == '') {
			$("#eqNombre").after('<div class="text-center text-danger noNombreEq">Ingrese nombre</div>');
			setTimeout(function () {
				$(".noNombreEq").remove();
				$("#eqNombre").focus();
			}, 2500);
		} else if (marca == '') {
			$("#marcaEq").after('<div class="text-center text-danger noMarcaEq">Ingrese marca</div>');
			setTimeout(function () {
				$(".noMarcaEq").remove();
				$("#marcaEq").focus();
			}, 2500);
		} else if (modelo == '') {
			$("#modeloEq").after('<div class="text-center text-danger noModeloEq">Ingrese modelo</div>');
			setTimeout(function () {
				$(".noModeloEq").remove();
				$("#modeloEq").focus();
			}, 2500);
		} else if (serie == '') {
			$("#serieEq").after('<div class="text-center text-danger noSerieEq">Ingrese serie</div>');
			setTimeout(function () {
				$(".noSerieEq").remove();
				$("#serieEq").focus();
			}, 2500);
		} else if (problema == '') {
			$("#problemaEq").after('<div class="text-center text-danger noProblemaEq">Dscriba problema</div>');
			setTimeout(function () {
				$(".noProblemaEq").remove();
				$("#problemaEq").focus();
			}, 2500);
		} else if (garantia == 'si' & fCompra == '') {
			$("#fechaCompraEq").after('<div class="text-center text-danger noFechaCompraEq">Indique la fecha</div>');
			setTimeout(function () {
				$(".noFechaCompraEq").remove();
				$("#fechaCompraEq").focus();
			}, 2500);
		} else if (garantia == 'si' & numFactura == '') {
			$("#numeroFacturaEq").after('<div class="text-center text-danger noFacturaEq">Ingrese factura</div>');
			setTimeout(function () {
				$(".noFacturaEq").remove();
				$("#numeroFacturaEq").focus();
			}, 2500);
		} else {
			$("#btnActualizaEq").addClass('d-none');
			$(".spinnerActEq").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#updateThisEquipo").serialize(),
			})
				.done(function (data) {
					$("#btnActualizaEq").removeClass('d-none');
					$(".spinnerActEq").addClass('d-none');
					$("#openModal_editInfoEquipo").modal('hide');
					$(".respuesta").html(data);
				})
		}
		event.preventDefault();
	});
	$(document).on('click', '.borraridClave', function (event) {
		var idClave = $(this).attr('id');
		$(".tooltip").hide();
		const swalWithBootstrapButtons = Swal.mixin({
			customClass: {
				confirmButton: 'btn btn-success',
				cancelButton: 'btn btn-danger mr-2'
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
			if (result.value) {
				$.ajax({
					url: 'do.php',
					type: 'POST',
					dataType: 'html',
					data: "action=borrarEquipo_soporteClaves&idClave=" + idClave,
				})
					.done(function (data) {
						$(".respuesta").html(data);
					})
				return false;
			} else if (
				/* Read more about handling dismissals below */
				result.dismiss === Swal.DismissReason.cancel
			) {
				swalWithBootstrapButtons.fire(
					'Cancelado',
					'El registro de este equipo ya no será borada.',
					'error'
				)
			}
		})
		event.preventDefault();
	});
	function agregadoEquipo() {

		Swal.fire({
			icon: 'success',
			title: 'Equipo agregado!',
			animation: false,
			customClass: {
				popup: 'animated bounceInDown'
			}
		})
		setTimeout(function () {
			location.reload()
		}, 2500);


	}
	$(document).on('click', '#btnMas_Campos', function (event) {
		$(".tooltip").hide();
		var claveSoporte = $("#claveOtroEquipo").val();
		var equipo = $("#eq_Nombre").val();
		var marca = $("#marca_Eq").val();
		var modelo = $("#modelo_Eq").val();
		var serie = $("#serie_Eq").val();
		var problema = $("#problema_Eq").val();
		var observaciones = $("#observaciones_Eq").val();
		var realizar = $("#trabj_Realizar").val();
		var garantia = $("#garantia_Eq option:selected").val();
		var fechaCompra = $("#fechaCompra_Eq").val();
		var numeroFactura = $("#numeroFactura_Eq").val();
		if (equipo == '') {
			$("#eq_Nombre").after('<div class="text-center text-danger noMaquinaNombre">Ingrese dato</div>');
			setTimeout(function () {
				$(".noMaquinaNombre").remove();
				$("#eq_Nombre").focus();
			}, 2500);
		} else if (marca == '') {
			$("#marca_Eq").after('<div class="text-center text-danger noNarcaEquipo">Ingrese marca</div>');
			setTimeout(function () {
				$(".noNarcaEquipo").remove();
				$("#marca_Eq").focus();
			}, 2500);
		} else if (modelo == '') {
			$("#modelo_Eq").after('<div class="text-center text-danger noModeloEquipo">Ingrese modelo</div>');
			setTimeout(function () {
				$(".noModeloEquipo").remove();
				$("#modelo_Eq").focus();
			}, 2500);
		} else if (serie == '') {
			$("#serie_Eq").after('<div class="text-center text-danger noSerieEquipo">Ingrese serie</div>');
			setTimeout(function () {
				$(".noSerieEquipo").remove();
				$("#serie_Eq").focus();
			}, 2500);
		} else if (problema == '') {
			$("#problema_Eq").after('<div class="text-center text-danger noInsertProblema">Ingrese el problema</div>');
			setTimeout(function () {
				$(".noInsertProblema").remove();
				$("#problema_Eq").focus();
			}, 2500);
		} else if (realizar == '') {
			$("#trabj_Realizar").after('<div class="text-center text-danger noInsertTarea">Ingrese tarea</div>');
			setTimeout(function () {
				$(".noInsertTarea").remove();
				$("#trabj_Realizar").focus();
			}, 2500);
		} else if (garantia == 'si' & fechaCompra == '') {
			$("#fechaCompra_Eq").after('<div class="text-center text-danger noInsertFecha">Ingrese fecha</div>');
			setTimeout(function () {
				$(".noInsertFecha").remove();
			}, 2500);
		} else if (garantia == 'si' & numeroFactura == '') {
			$("#numeroFactura_Eq").after('<div class="text-center text-danger factura">Ingrese factura</div>');
			setTimeout(function () {
				$(".factura").remove();
				$("#numeroFactura_Eq").focus();
			}, 2500);
		} else {
			var datosPOST = "action=GuardarClaveServicio&Clave=" + claveSoporte + "&equipo=" + equipo + "&marca=" + marca + "&modelo=" +
				modelo + "&serie=" + serie + "&problema=" + problema + "&observaciones=" + observaciones + "&realizar=" + realizar + "&garantia=" +
				garantia + "&fechaCompra=" + fechaCompra + "&numeroFactura=" + numeroFactura;
			$(".showTable").html('');
			$("#btnMas_Campos").addClass('d-none');
			$(".spinnerMasCampos").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function (data) {
					$("#btnMas_Campos").removeClass('d-none');
					$(".spinnerMasCampos").addClass('d-none');
					$(".showTable").html(data);
					$("#eq_Nombre").val('');
					$("#marca_Eq").val('');
					$("#modelo_Eq").val('');
					$("#serie_Eq").val('');
					$("#problema_Eq").val('');
					$("#observaciones_Eq").val('');
					$("#trabj_Realizar").val('');
					$("#garantia_Eq").val('Seleccione una opción');
					$("#fechaCompra_Eq").val('');
					$("#numeroFactura_Eq").val('');
					$("#eq_Nombre").focus();
				}
			})
		}
		event.preventDefault();
	});
	$(document).on('click', '.openModal_cancelarOrden', function (event) {
		var idSoporte = $(this).attr('id');
		$("#idSoporteCancelacion").val(idSoporte)
		$("#openModal_cancelarOrden").modal();
		$(".tooltip").hide();
		event.preventDefault();
	});
	$(document).on('click', '.openModal_cancelarOrden_individual', function (event) {
		var idClave = $(this).attr('id');
		$("#openModal_cancelarOrden_individual").modal();
		$("#idClaveCancelacionIndividual").val(idClave);
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: { obtenerClavexID: idClave },
			success: function (data) {
				$("#claveModalReparacion").val(data.clave);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '#cancelaOrden', function (event) {
		var motivo = $("#motivoCancelacion").val();
		if (motivo == '') {
			$("#motivoCancelacion").after('<div class="text-center text-danger noMotivoCancelacion">Describa la razón</div>');
			setTimeout(function () {
				$(".noMotivoCancelacion").remove();
				$("#motivoCancelacion").focus();
			}, 2500);
		} else {
			$("#cancelaOrden").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formCancelaOrden").serialize(),
			})
				.done(function (data) {
					$("#cancelaOrden").removeClass('d-none');
					$(".spinner").addClass('d-none');
					$("#openModal_cancelarOrden").modal('hide')
					$(".respuesta").html(data);
				})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '#cancelaEstaOrden', function (event) {
		var motivo = $("#motivo_Cancelacion").val();
		if (motivo == '') {
			$("#motivo_Cancelacion").after('<div class="text-center text-danger noMotivoCancelacion">Describa la razón</div>');
			setTimeout(function () {
				$(".noMotivoCancelacion").remove();
				$("#motivo_Cancelacion").focus();
			}, 2500);
		} else {
			$("#cancelaEstaOrden").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formCancelaestaOrden").serialize(),
			})
				.done(function (data) {
					$("#cancelaEstaOrden").removeClass('d-none');
					$(".spinner").addClass('d-none');
					$("#openModal_cancelarOrden_individual").modal('hide')
					$(".respuesta").html(data);
				})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.openModal_ingresacostos', function (event) {
		var Clave = $(this).attr('id');//clave soporte de tabla soporte_sucursales
		$("#openModal_ingresacostos").modal();
		$("#claveCostos").val(Clave);
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: { llamarEquiposSoporteHTML: Clave },
			success: function (data) {
				$(".costos").html(data)
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '#guardaCostos', function (event) {
		$("#guardaCostos").addClass('d-none');
		$(".spinner").removeClass('d-none');
		$.ajax({
			url: 'do.php',
			type: 'POST',
			dataType: 'html',
			data: $("#formCostosReparacion").serialize(),
		})
			.done(function (data) {
				$("#guardaCostos").removeClass('d-none');
				$(".spinner").addClass('d-none');
				$("#openModal_ingresacostos").modal('hide');
				$(".respuesta").html(data);
			})
		return false;
		event.preventDefault();
	});
	$(document).on('click', '.Buscar', function (event) {
		$("#buscar").removeClass('d-none');
		event.preventDefault();
	});
	$(document).on('click', '.downloadPDF', function (event) {
		$(".tooltip").hide()
	});

	//modal agregar diagnostico
	//$("#repuestosBD").select2(); 
	//select repuestos en modal con buscador
	$('#repuestosBD').select2({
		dropdownParent: $('#modalDiagnosticoEquipo .modal-body')
	});
	//agregar diagnostico(1preciomano de obra,2repuestos,3insumos,4serviciosExternos)
	//al equipo registrado y cargar sus datos
	$(document).on('click', '.btnDiagnosticoCargarDatosAjax', function (event) {

		let idClaveEquipo = $(this).attr('id');
		$("#idClaveEquipo").val(idClaveEquipo);
		//00 llenando los campos de garantia
		$.ajax({
			url: "includes/ajax/getData_soporte_claves.php",
			type: "POST",
			dataType: "json",
			data: { idClave: idClaveEquipo },
			success: function (data) {
				$("#garantiaEquipoRepuesto").val(data.garantia_vigente_repuesto);
				$("#garantiaEquipoMano").val(data.garantia_vigente_mano);
				$("#encargado_diagnostico").val(data.encargado_diagnostico);
				$("#nombreEquipo").text(data.equipo);
				if ($("#garantiaEquipoRepuesto").val() == 'no') {
					let input = document.getElementById('garantiaEquipoRepuesto');
					input.style.backgroundColor = 'red';
				}
				else {
					let input = document.getElementById('garantiaEquipoRepuesto');
					input.style.backgroundColor = 'green';
				}
				if ($("#garantiaEquipoMano").val() == 'no') {
					let input = document.getElementById('garantiaEquipoMano');
					input.style.backgroundColor = 'red';
				}
				else {
					let input = document.getElementById('garantiaEquipoMano');
					input.style.backgroundColor = 'green';
				}
			},
		});

		//01 lista costo y realizar en equipo
		let ListarPrecioAsistenciaTecnica = "action=ListarPrecioAsistenciaTecnica" +
			"&idClave=" + idClaveEquipo;
		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: ListarPrecioAsistenciaTecnica,
			success: function (data) {
				$(".respuestaCostoAsistenciaTecnica").html(data);
			}
		});
		//02 listando sus repuestos
		let ListarRepuestosEquipoidClave = "action=ListarRepuestosEquipoidClave" +
			"&idClave=" + idClaveEquipo;
		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: ListarRepuestosEquipoidClave,
			success: function (data) {
				$(".respuestaRepuestosEquipo").html(data);
			}
		});
		//03 listando mas abajito :v sus Insumos Externos
		let ListarInsumosExternosEquipo = "action=ListarInsumosExternosEquipo" +
			"&idClave=" + idClaveEquipo;
		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: ListarInsumosExternosEquipo,
			success: function (data) {
				$(".respuestaInsumosExternos").html(data);
			}
		});
		//04 listando mas abajito :v sus Servicios Externos
		let ListarServiciosExternosEquipo = "action=ListarServiciosExternos" +
			"&idClave=" + idClaveEquipo;
		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: ListarServiciosExternosEquipo,
			success: function (data) {
				$(".respuestaServiciosExternos").html(data);
			}
		});

		//05 listando OTROSGASTOS
		let ListarOtrosGastos = "action=ListarOtrosGastos" +
			"&idClave=" + idClaveEquipo;
		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: ListarOtrosGastos,
			success: function (data) {
				$(".respuestaOtrosGastosPrecio").html(data);
			}
		});

		//06 mostramos el total de todo el diagnostico
		mostrarTotalDiagnostico(idClaveEquipo);

		event.preventDefault();
	});
	// agregar repuestos al diagnostico
	$(document).on('click', '#btnMasRepuestosBD', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let idProducto = $("#repuestosBD option:selected").val();
		let idSucursal = $("#idSucursal").val();
		let cantidad = $("#repuestosBDcantidad").val();
		let precioEspecial = $("#precioEspecial").val();

		if (idProducto == 'null') {
			$("#repuestosBD").after('<div class="text-center text-danger reRepuestosBD">Seleccione un repuesto</div>');
			setTimeout(function () {
				$(".reRepuestosBD").remove();
				$("#repuestosBD").focus();
			}, 2500);
		}
		else {
			// Hicieron click en "Sí"
			//$("#garantiaEquipoRepuesto").attr("disabled", false);
			//$("#garantiaEquipoMano").attr("disabled", false);
			let datosPOST = "action=agregarRepuestoClave" +
				"&idClave=" + idClave +
				"&idProducto=" + idProducto +
				"&idSucursal=" + idSucursal +
				"&cantidad=" + cantidad +
				"&precioEspecial=" + precioEspecial;
			$(".respuestaRepuestosEquipo").html('');
			//$("#btnMasCampos").addClass('d-none');
			//$(".spinnerMasCampos").removeClass('d-none');
			$.ajax({
				url: 'accionesServicioTecnico/accionesRegistrados.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function (data) {
					$(".respuestaRepuestosEquipo").html(data);
					//$("#repuestosBD option:selected").val('');
					$('#repuestosBD').val('null');
					$('#repuestosBD').change();
					$("#repuestosBDcantidad").val('1');
					$("#precioEspecial").val('0');
					//05 mostramos el total de todo el diagnostico
					mostrarTotalDiagnostico(idClave);
				}
			})
		}
		event.preventDefault();
	});
	// eliminar un repuesto del diagnostico
	$(document).on('click', '.removerRepuestoDelDiagnostico', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let idClaveRepuesto = $(this).attr('id');

		let datosPOST = "action=removerRepuestoDelDiagnostico" +
			"&idClave=" + idClave +
			"&idClaveRepuesto=" + idClaveRepuesto;

		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: datosPOST,
			success: function (data) {
				$(".respuestaRepuestosEquipo").html(data);
				$("#repuestosBDcantidad").val('1');
				//05 mostramos el total de todo el diagnostico
				mostrarTotalDiagnostico(idClave);
			}
		})

		event.preventDefault();
	});

	// agregar Insumos Externos al diagnostico
	$(document).on('click', '#btnMasInsumosBD', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let nombreInsumo = $("#nombreInsumo").val();
		let idSucursal = $("#idSucursal").val();
		let insumosCantidad = $("#insumosCantidad").val();
		let precioInsumo = $("#precioInsumo").val();

		if (nombreInsumo == '') {
			$("#nombreInsumo").after('<div class="text-center text-danger nonombreInsumo">Ingrese nombre</div>');
			setTimeout(function () {
				$(".nonombreInsumo").remove();
				$("#nombreInsumo").focus();
			}, 2500);
		}
		else {
			let datosPOST = "action=agregarInsumoExterno" +
				"&idClave=" + idClave +
				"&nombre_repuesto=" + nombreInsumo +
				"&idSucursal=" + idSucursal +
				"&cantidad=" + insumosCantidad +
				"&precioEspecial=" + precioInsumo;
			$(".respuestaInsumosExternos").html('');
			$.ajax({
				url: 'accionesServicioTecnico/accionesRegistrados.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function (data) {
					$(".respuestaInsumosExternos").html(data);
					$("#nombreInsumo").val('');
					$("#insumosCantidad").val('1');
					$("#precioInsumo").val('0');
					//05 mostramos el total de todo el diagnostico
					mostrarTotalDiagnostico(idClave);
				}
			})
		}
		event.preventDefault();
		$("#garantiaEquipoRepuesto").attr("disabled", true);
		$("#garantiaEquipoMano").attr("disabled", true);

	});

	$(document).on('click', '#closeModal', function (event) {
		$('#modalDiagnosticoEquipo').modal('hide');

		let idClave = $("#idClaveEquipo").val();
		let encargado_diagnostico = $("#encargado_diagnostico").val();
		encargado_diagnostico = encargado_diagnostico == '' ? 'Técnico Encargado' : encargado_diagnostico;
		let datosPOST = "action=guardar_encargado_diagnostico" +
			"&idClave=" + idClave +
			"&encargado_diagnostico=" + encodeURIComponent(encargado_diagnostico);
		console.log(datosPOST);
		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'json',
			data: datosPOST,
			success: function (data) {
				swal.fire({
					title: "DIAGNOSTICO GUARDADO",
					text: "Exitosamente",
					icon: 'success',
					confirmButtonText: "OK",
				})

			}
		})
		event.preventDefault();
	});
	// eliminar un removerInsumoDelDiagnostico 
	$(document).on('click', '.removerInsumoDelDiagnostico', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let idClaveRepuesto = $(this).attr('id');

		let datosPOST = "action=removerInsumoDelDiagnostico" +
			"&idClave=" + idClave +
			"&idClaveRepuesto=" + idClaveRepuesto;

		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: datosPOST,
			success: function (data) {
				$(".respuestaInsumosExternos").html(data);
				$("#insumosCantidad").val('1');
				//05 mostramos el total de todo el diagnostico
				mostrarTotalDiagnostico(idClave);
			}
		})

		event.preventDefault();
	});

	// ACTUALIZAR COSTO ASISTENCIA TECNICA O PRECIO MANO DE OBRA
	$(document).on('click', '#btnActualizarPrecioAsistenciaTecnica', function (event) {

		let idClave = $("#idClaveEquipo").val();

		let costo = $("#costoReparacionEquipo").val();
		let realizar = $("#realizarTrabajo").val();
		if (realizar == '') {
			$("#realizarTrabajo").after('<div class="text-center text-danger reRealizarTrabajo">Ingrese descripción</div>');
			setTimeout(function () {
				$(".reRealizarTrabajo").remove();
				$("#realizarTrabajo").focus();
			}, 2500);
		}
		else {
			let datosPOST = "action=btnActualizarPrecioAsistenciaTecnica" +
				"&idClave=" + idClave +
				"&costo=" + costo +
				"&realizar=" + realizar;
			$.ajax({
				url: 'accionesServicioTecnico/accionesRegistrados.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function (data) {
					$(".respuestaCostoAsistenciaTecnica").html(data);
					$("#costoReparacionEquipo").val('0');
					$("#realizarTrabajo").val('');
					//05 mostramos el total de todo el diagnostico
					mostrarTotalDiagnostico(idClave);
				}
			})
		}
		event.preventDefault();
	});

	$(document).on('click', '#btnMasServiciosExternos', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let nombreServicioExterno = $("#serviciosExternos").val();
		let idSucursal = $("#idSucursal").val();
		let cantidadServicioExterno = $("#serviciosCantidad").val();
		let precioServicioExterno = $("#precioServicioExterno").val();

		if (nombreServicioExterno == '') {
			$("#serviciosExternos").after('<div class="text-center text-danger seserviciosExternos">Ingrese nombre</div>');
			setTimeout(function () {
				$(".seserviciosExternos").remove();
				$("#serviciosExternos").focus();
			}, 2500);
		}
		else {
			let datosPOST = "action=agregarServicioExterno" +
				"&idClave=" + idClave +
				"&nombre_repuesto=" + nombreServicioExterno +
				"&idSucursal=" + idSucursal +
				"&cantidad=" + cantidadServicioExterno +
				"&precioEspecial=" + precioServicioExterno;
			$(".respuestaServiciosExternos").html('');
			$.ajax({
				url: 'accionesServicioTecnico/accionesRegistrados.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function (data) {
					$(".respuestaServiciosExternos").html(data);
					$("#serviciosExternos").val('');
					$("#serviciosCantidad").val('1');
					$("#precioServicioExterno").val('0');
					//05 mostramos el total de todo el diagnostico
					mostrarTotalDiagnostico(idClave);
				}
			})
		}
		event.preventDefault();
	});
	//04 eliminar un removerServicioExternoDelDiagnostico 
	$(document).on('click', '.removerServicioExternoDelDiagnostico', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let idClaveRepuesto = $(this).attr('id');

		let datosPOST = "action=removerServicioExternoDelDiagnostico" +
			"&idClave=" + idClave +
			"&idClaveRepuesto=" + idClaveRepuesto;

		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: datosPOST,
			success: function (data) {
				$(".respuestaServiciosExternos").html(data);
				//05 mostramos el total de todo el diagnostico
				mostrarTotalDiagnostico(idClave);
			}
		})

		event.preventDefault();
	});


	$(document).on('click', '#btnMasOtrosGastosPrecio', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let nombre_repuesto = $("#otrosGastos").val();
		let idSucursal = $("#idSucursal").val();
		let cantidad = $("#otrosGastosCantidad").val();
		let precioEspecial = $("#otrosGastosPrecio").val();

		if (nombre_repuesto == '') {
			$("#otrosGastos").after('<div class="text-center text-danger ototrosGastos">Ingrese nombre</div>');
			setTimeout(function () {
				$(".ototrosGastos").remove();
				$("#otrosGastos").focus();
			}, 2500);
		}
		else {
			let datosPOST = "action=agregarOtrosGastosPrecio" +
				"&idClave=" + idClave +
				"&nombre_repuesto=" + nombre_repuesto +
				"&idSucursal=" + idSucursal +
				"&cantidad=" + cantidad +
				"&precioEspecial=" + precioEspecial;
			$(".respuestaOtrosGastosPrecio").html('');
			$.ajax({
				url: 'accionesServicioTecnico/accionesRegistrados.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function (data) {
					$(".respuestaOtrosGastosPrecio").html(data);
					$("#otrosGastos").val('');
					$("#otrosGastosCantidad").val('1');
					$("#otrosGastosPrecio").val('0');
					//05 mostramos el total de todo el diagnostico
					mostrarTotalDiagnostico(idClave);
				}
			})
		}
		event.preventDefault();
	});
	//05  removerOtrosGastosoDelDiagnostico 
	$(document).on('click', '.removerOtrosGastosDelDiagnostico', function (event) {

		let idClave = $("#idClaveEquipo").val();
		let idClaveRepuesto = $(this).attr('id');

		let datosPOST = "action=removerOtrosGastosDelDiagnostico" +
			"&idClave=" + idClave +
			"&idClaveRepuesto=" + idClaveRepuesto;

		$.ajax({
			url: 'accionesServicioTecnico/accionesRegistrados.php',
			type: 'POST',
			dataType: 'html',
			data: datosPOST,
			success: function (data) {
				$(".respuestaOtrosGastosPrecio").html(data);
				//05 mostramos el total de todo el diagnostico
				mostrarTotalDiagnostico(idClave);
			}
		})

		event.preventDefault();
	});
	$(document).on('click', '.openModal_ingresartaller', function (event) {
		var Clave = $(this).attr('id');//clave soporte de tabla soporte_sucursales
		//var Clave2 = $(this).attr('id2');//clave soporte de tabla soporte_sucursales
		$("#openModal_ingresacostos").modal();
		$("#claveCostos").val(Clave);
		$.ajax({
			url: 'includes/ajax_html/get_soporte_claves.php',
			type: 'POST',
			dataType: 'html',
			data: { llamarEquiposSoporteHTML: Clave },
			success: function (data) {
				$(".costos").html(data)
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '#IngresarTallerEquipos', function (event) {
		$("#guardaCostos").addClass('d-none');
		$(".spinner").removeClass('d-none');

		swal.fire({
			title: "INGRESAR AL TALLER DE REPARACIONES ?",
			text: "Asegurese que todos los equipos de lista tengan diagnostico y precio correcto",
			icon: 'info',
			showCancelButton: true,
			confirmButtonText: "Sí, Ingresar Taller",
			cancelButtonText: "Cancelar",
		})
			.then(resultado => {
				if (resultado.value) {
					$.ajax({
						url: 'accionesServicioTecnico/accionesRegistrados.php',
						type: 'POST',
						dataType: 'html',
						data: $("#formCostosReparacion").serialize(),
					})
						.done(function (data) {
							$("#guardaCostos").removeClass('d-none');
							$(".spinner").addClass('d-none');

							$(".respuesta").html(data);

						})
					return false;

				}
			});

		event.preventDefault();
	});

	$(document).on('click', '#btn_Continuar', function (event) {
		$(".tooltip").hide();
		var claveSoporte = $("#claveOtroEquipo").val();
		var equipo = $("#eq_Nombre").val();
		var marca = $("#marca_Eq").val();
		var modelo = $("#modelo_Eq").val();
		var serie = $("#serie_Eq").val();
		var problema = $("#problema_Eq").val();
		var observaciones = $("#observaciones_Eq").val();

		var garantiaEquipoRepuesto = $("#garantiaEquipoRepuestoModal").val();
		var garantiaEquipoMano = $("#garantiaEquipoManoModal").val();
		var fechaCompra = $("#fechaVenta").val();
		var notaEntrega = $("#numeroFacturaModal").val();
		// var fechaCompra = $("#fechaCompra_Eq").val();
		var sucursal = $("#sucursalUsuario").val();
		var idSucursal = $("#idSucursal").val();
		if (equipo == '') {
			$("#eq_Nombre").after('<div class="text-center text-danger noMaquinaNombre">Ingrese dato</div>');
			setTimeout(function () {
				$(".noMaquinaNombre").remove();
				$("#eq_Nombre").focus();
			}, 2500);
		} else if (marca == '') {
			$("#marca_Eq").after('<div class="text-center text-danger noNarcaEquipo">Ingrese marca</div>');
			setTimeout(function () {
				$(".noNarcaEquipo").remove();
				$("#marca_Eq").focus();
			}, 2500);
		} else if (modelo == '') {
			$("#modelo_Eq").after('<div class="text-center text-danger noModeloEquipo">Ingrese modelo</div>');
			setTimeout(function () {
				$(".noModeloEquipo").remove();
				$("#modelo_Eq").focus();
			}, 2500);
		} else if (serie == '') {
			$("#serie_Eq").after('<div class="text-center text-danger noSerieEquipo">Ingrese serie</div>');
			setTimeout(function () {
				$(".noSerieEquipo").remove();
				$("#serie_Eq").focus();
			}, 2500);
		} else if (problema == '') {
			$("#problema_Eq").after('<div class="text-center text-danger noInsertProblema">Ingrese el problema</div>');
			setTimeout(function () {
				$(".noInsertProblema").remove();
				$("#problema_Eq").focus();
			}, 2500);
		} else {
			var datosPOST = "action=agregarOtroEquipo" +
				"&Clave=" + claveSoporte +
				"&sucursal=" + sucursal +
				"&idSucursal=" + idSucursal +
				"&equipo=" + equipo +
				"&marca=" + marca +
				"&modelo=" + modelo +
				"&serie=" + serie +
				"&problema=" + problema +
				"&observaciones=" + observaciones +

				"&garantiaEquipoRepuesto=" + garantiaEquipoRepuesto +
				"&garantiaEquipoMano=" + garantiaEquipoMano +
				"&fechaCompra=" + fechaCompra +
				"&notaEntrega=" + notaEntrega;

			$("#btn_Continuar").addClass('d-none');
			$(".spinnerContinuar").removeClass('d-none');
			$(".respuesta").html('');
			$.ajax({
				url: 'accionesServicioTecnico/accionesRegistrados.php',
				type: 'POST',
				dataType: 'html',
				data: datosPOST,
				success: function () {
					$("#btn_Continuar").removeClass('d-none');
					$(".spinnerContinuar").addClass('d-none');
					$("#openModal_AddEquipo").modal('hide');
					$(".respuesta").html(agregadoEquipo());
				}
			})
		}
		event.preventDefault();
	});

});

function mostrarTotalDiagnostico(idClaveEquipo) {
	$.ajax({
		url: "includes/ajax/getData_totalDiagnosticoEquipo.php",
		type: "POST",
		dataType: "json",
		data: { idClave: idClaveEquipo },
		success: function (data) {
			$("#costoTotalDiagnostico").val(data.totalDiagnostico);
		},
	});
}
$(document).on('click', '.removerCostoDelDiagnostico_victor', function (event) {

	let idClave = $("#idClaveEquipo").val();
	let idClaveRepuesto = $(this).attr('id');

	let datosPOST = "action=removerCostoDelDiagnostico_victor" +
		"&idClave=" + idClave +
		"&idClaveRepuesto=" + idClaveRepuesto;

	$.ajax({
		url: 'accionesServicioTecnico/accionesRegistrados.php',
		type: 'POST',
		dataType: 'html',
		data: datosPOST,
		success: function (data) {
			//$(".respuestaServiciosExternos").html(data);
			//05 mostramos el total de todo el diagnostico
			$("#costoReparacionEquipo").val('0');
            $("#realizarTrabajo").val('');
            mostrarTotalDiagnostico(idClave);
            $("#data-table").empty();
		},
		error: function (data) {
			console.log("error");
		}
	})

	event.preventDefault();
});