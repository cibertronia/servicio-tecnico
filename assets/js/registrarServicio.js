$(function () {
	$("#equipoNombre").change(function (event) {
		$(".botonesRegistro").removeClass('d-none');
	});

	$(document).on('click', '#btnMasCampos', function (event) {

		var sucursal = $("#sucursalUsuario").val();
		var idSucursal = $("#idSucursal").val();
		var nombreCliente = $("#nombreCliente").val();
		var cellCliente = $("#telCliente").val();
		var claveSoporte = $("#claveSoporte").val();
		var equipo = $("#equipoNombre").val();
		var marca = $("#marcaEquipo").val();
		var modelo = $("#modeloEquipo").val();
		var serie = $("#serieEquipo").val();
		serie = (serie == '') ? "S/N:" : serie;
		var problema = $("#problemaEquipo").val();
		var observaciones = $("#observacionesEquipo").val();

		var numeroFactura = $("#numeroFactura").val();

		var fechaVenta = $("#fechaVenta").val();
		var garantiaEquipoRepuesto = $("#garantiaEquipoRepuesto").val();
		var garantiaEquipoMano = $("#garantiaEquipoMano").val();
		var notaEntrega = $("#numeroFactura").val();
		let idEquipoExistente = $("#EquipoExistente option:selected").val();

		if (nombreCliente == '') {
			$("#nombreCliente").after('<div class="text-center text-danger noNombreCliente">Ingrese nombre</div>');
			setTimeout(function () {
				$(".noNombreCliente").remove();
				$("#nombreCliente").focus();
			}, 2500);
		} else if (cellCliente == '') {
			$("#telCliente").after('<div class="text-center text-danger noTelefonoCliente">Ingrese teléfono</div>');
			setTimeout(function () {
				$(".noTelefonoCliente").remove();
				$("#telCliente").focus();
			}, 2500);
		} else if (equipo == '') {
			$("#equipoNombre").after('<div class="text-center text-danger noMaquinaNombre">Ingrese dato</div>');
			setTimeout(function () {
				$(".noMaquinaNombre").remove();
				$("#equipoNombre").focus();
			}, 2500);
		} else if (marca == '') {
			$("#marcaEquipo").after('<div class="text-center text-danger noNarcaEquipo">Ingrese marca</div>');
			setTimeout(function () {
				$(".noNarcaEquipo").remove();
				$("#marcaEquipo").focus();
			}, 2500);
		} else if (modelo == '') {
			$("#modeloEquipo").after('<div class="text-center text-danger noModeloEquipo">Ingrese modelo</div>');
			setTimeout(function () {
				$(".noModeloEquipo").remove();
				$("#modeloEquipo").focus();
			}, 2500);
		} else if (problema == '') {
			$("#problemaEquipo").after('<div class="text-center text-danger noInsertProblema">Ingrese el problema</div>');
			setTimeout(function () {
				$(".noInsertProblema").remove();
				$("#problemaEquipo").focus();
			}, 2500);
		} else {
			swal.fire({
				title: "¿AÑADIR EQUIPO A LA COLA?",
				text: "¿Esta seguro que desea añadir este equipo a la cola de recepción?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: "Sí, Añadir",
				cancelButtonText: "Cancelar",
			})
				.then(resultado => {
					if (resultado.value) {
						// Hicieron click en "Sí"

						$("#garantiaEquipoRepuesto").attr("disabled", false);
						$("#garantiaEquipoMano").attr("disabled", false);

						var datosPOST = "action=GuardarClaveServicio&Clave=" + claveSoporte +
							"&sucursal=" + sucursal + "&idSucursal=" + idSucursal + "&equipo=" + equipo +
							"&marca=" + marca + "&modelo=" + modelo + "&serie=" + serie + "&problema=" + problema +
							"&observaciones=" + observaciones + "&numeroFactura=" + numeroFactura +
							"&fechaVenta=" + fechaVenta + "&garantiaEquipoRepuesto=" + garantiaEquipoRepuesto +
							"&garantiaEquipoMano=" + garantiaEquipoMano + "&notaEntrega=" + notaEntrega;
						$(".respuesta").html('');
						$("#btnMasCampos").addClass('d-none');
						$(".spinnerMasCampos").removeClass('d-none');
						$.ajax({
							url: 'puerta_ajax.php',
							type: 'POST',
							dataType: 'html',
							data: datosPOST,
							success: function (data) {
								$("#btnMasCampos").removeClass('d-none');
								$(".spinnerMasCampos").addClass('d-none');
								$(".respuesta").html(data);
								$("#equipoNombre").val('');
								$("#marcaEquipo").val('');
								$("#modeloEquipo").val('');
								$("#serieEquipo").val('');
								$("#problemaEquipo").val('');
								$("#observacionesEquipo").val('');
								$("#fechaVenta").val('');
								$("#numeroFactura").val('');
								$("#equipoNombre").focus();
								$('#EquipoExistente').val('null');
								$('#EquipoExistente').change();
							}
						})
						if ($("input:checkbox[name='optionUser']").is(':checked')) {
							$("#garantiaEquipoRepuesto").attr("disabled", true);
							$("#garantiaEquipoMano").attr("disabled", true);
						} else {
							$("#garantiaEquipoRepuesto").attr("disabled", false);
							$("#garantiaEquipoMano").attr("disabled", false);
						}

						$(".ModoColaRecepcion").addClass('d-none');
						if ($("#controladorEquipos").val() == '0') {
							//console.log('uwu')
							$("#controladorEquipos").val('1');
						}
						//$(".siExistente").addClass('d-none');	
						//$(".noExistente").addClass('d-none');
						//$(".checkb").addClass('d-none');					
						//$(".ClienteXistente").addClass('d-none');


					}
				});
		}

		event.preventDefault();

	});



	$(document).on('click', '#btnContinuar', function (event) {

		if ($("#controladorEquipos").val() == '0') {
			console.log($("#controladorEquipos").val());
			swal.fire({
				title: "Error",
				text: "No tiene equipos en la cola",
				icon: 'warning',
				showCancelButton: false,
			})

		}
		else {
			swal.fire({
				title: "FINALIZAR RECEPCION",
				text: "¿Desea guardar la lista de equipos?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonText: "Sí, Guardar",
				cancelButtonText: "Cancelar",
			})
				.then(resultado => {
					if (resultado.value) {
						var sucursal = $("#sucursalUsuario").val();
						var claveSoporte = $("#claveSoporte").val();
						var nombreCliente = $("#nombreCliente").val();
						var cellCliente = $("#telCliente").val();
						var equipo = $("#equipoNombre").val();
						var marca = $("#marcaEquipo").val();
						var modelo = $("#modeloEquipo").val();
						var serie = $("#serieEquipo").val();
						var direccion = $("#direccion").val();
						direccion = (direccion == '') ? "Dirección no registrada" : direccion;
						var problema = $("#problemaEquipo").val();
						var observaciones = $("#observacionesEquipo").val();
						var fechaCompra = $("#fechaCompra").val();
						var numeroFactura = $("#numeroFactura").val();

						var fechaVenta = $("#fechaVenta").val();
						var garantiaEquipoRepuesto = $("#garantiaEquipoRepuesto").val();
						var garantiaEquipoMano = $("#garantiaEquipoMano").val();

						$("#garantiaEquipoRepuesto").attr("disabled", false);
						$("#garantiaEquipoMano").attr("disabled", false);
						//var datosPOST = "action=GuardarnuevoServicio&nombreCliente="+
						nombreCliente + "&sucursal=" + sucursal + "&cellCliente=" + cellCliente + "&Clave=" +
							claveSoporte + "&equipo=" + equipo + "&marca=" + marca + "&modelo=" + modelo + "&serie=" +
							serie + "&problema=" + problema + "&observaciones=" + observaciones + "&fechaCompra=" + fechaCompra + "&numeroFactura=" + numeroFactura;

						$("#btnContinuar").addClass('d-none');
						$(".spinnerContinuar").removeClass('d-none');
						$(".respuesta").html('');
						$.ajax({
							url: 'puerta_ajax.php',
							type: 'POST',
							dataType: 'html',
							data: $("#registrarServicio").serialize(),			//datosPOST,
							success: function (data) {
								$("#btnContinuar").removeClass('d-none');
								$(".spinnerContinuar").addClass('d-none');
								$(".respuesta").html(data);
							}
						})
						$("#garantiaEquipoRepuesto").attr("disabled", true);
						$("#garantiaEquipoMano").attr("disabled", true);
						//----------------------tarea gabo
					}
				});
			$("#controladorEquipos").val('0');
		}
		event.preventDefault();


	});

	//yuli servicio tecnico
	// Cliente existente si o no
	$("input:checkbox[name='optionUser']").change(function () {
		$("#getDataClientesYuliJson").val('');
		//$("#ClienteProducto").val('null');	
		//$("#EquipoExistente").val('null');	
		$("#telCliente").val('');
		$("#nombreCliente").val('');
		$("#equipoNombre").val('');
		$("#fechaVenta").val('');
		$("#marcaEquipo").val('');
		$("#modeloEquipo").val('');
		$("#serieEquipo").val('');
		$("#problemaEquipo").val('');
		$("#observacionesEquipo").val('');
		$("#fechaCompra").val('');
		$("#numeroFactura").val('');
		// $("#garantiaEquipoRepuesto").val('no');
		// $("#garantiaEquipoMano").val('no');
		if ($(this).is(':checked')) {

			$(".siExistente").removeClass('d-none');//color si o no
			$(".noExistente").addClass('d-none');//color si o no

			$(".ClienteXistente").removeClass('d-none'); //lista clientes yuli
			$(".equipoExistenteCol").removeClass('d-none');//lista de sus productos de ese cliente

			$("#nombreCliente").attr("readonly", "readonly");
			$("#equipoNombre").attr("readonly", "readonly");
			//$("#marcaEquipo").attr("readonly", "readonly");
			//$("#modeloEquipo").attr("readonly", "readonly");
			//$("#serieEquipo").attr("readonly", "readonly");
			$("#garantiaEquipoRepuesto").attr("disabled", true);
			$("#garantiaEquipoMano").attr("disabled", true);
			$("#numeroFactura").attr("readonly", "readonly");
			$("#fechaVenta").attr("readonly", "readonly");


		} else {

			$(".siExistente").addClass('d-none');//color si o no
			$(".noExistente").removeClass('d-none');//color si o no

			$(".ClienteXistente").addClass('d-none');
			$(".equipoExistenteCol").addClass('d-none');

			$("#nombreCliente").removeAttr("readonly");
			$("#equipoNombre").removeAttr("readonly");
			$("#marcaEquipo").removeAttr("readonly");
			$("#equipoNombre").removeAttr("readonly");
			$("#marcaEquipo").removeAttr("readonly");
			$("#modeloEquipo").removeAttr("readonly");
			$("#serieEquipo").removeAttr("readonly");
			$("#garantiaEquipoRepuesto").attr("disabled", false);
			$("#garantiaEquipoMano").attr("disabled", false);
			$("#numeroFactura").removeAttr("readonly");
			$("#fechaVenta").removeAttr("readonly");
		}

	});
	//llenado automatico datos del cliente existente de yuli 01
	$("#ClienteProducto").select2();
	$("#ClienteProducto").change(function () {
		$("#ClienteProducto option:selected").each(function () {
			var idCliente = $(this).val();
			var $selectEquipoExistente = $("#EquipoExistente");

			$("#marcaEquipo").val('');
			$("#modeloEquipo").val('');
			$("#serieEquipo").val('');
			$("#fechaVenta").val('');
			// $("#garantiaEquipoRepuesto").val('no');
			// $("#garantiaEquipoMano").val('no');
			$.ajax({
				url: 'includes/ajax/getDataClientesYuli.php',
				type: 'POST',
				dataType: 'json',
				data: { id: idCliente },
				success: function (data) {
					$("#nombreCliente").val(data.Nombres + ' ' + data.Apellidos);

					$("#telCliente").val(data.Celular);
					$("#getDataClientesYuliJson").val('');
					$("#getDataClientesYuliJson").val(JSON.stringify(data));

					$selectEquipoExistente.empty();
					$selectEquipoExistente.append($("<option disabled selected>Seleccione Equipo</option>"));
					for (let i = 0; i < data.comprados.length; i++) {

						$selectEquipoExistente.append($("<option>", {
							value: data.comprados[i].idVenta,
							text: data.comprados[i].Producto + ' ' + data.comprados[i].Marca + ' ' + data.comprados[i].Modelo
						}));
					}
					//$("#ClienteProducto").val('di');
					//juliana ventura ejemplo
				}
			})
		});
	});
	$("#EquipoExistente").select2();
	$("#EquipoExistente").change(function () {
		$("#EquipoExistente option:selected").each(function () {

			var idVenta = $(this).val();
			var getDataClientesYuliJson = $("#getDataClientesYuliJson").val();

			const clientData = JSON.parse(getDataClientesYuliJson);//convertimos a objeto

			//$("#marcaEquipo").val(clientData.Apellidos);
			//$("#marcaEquipo").val(clientData.comprados.length);

			for (let i = 0; i < clientData.comprados.length; i++) {
				if (idVenta == clientData.comprados[i].idVenta) {

					$("#equipoNombre").val(clientData.comprados[i].Producto);
					$("#marcaEquipo").val(clientData.comprados[i].Marca);
					$("#modeloEquipo").val(clientData.comprados[i].Modelo);
					$("#serieEquipo").val('S/N:');
					$("#fechaVenta").val(clientData.comprados[i].FechaVenta);
					$("#numeroFactura").val(clientData.comprados[i].idEntrega);
					$("#garantiaEquipoRepuesto").val(clientData.comprados[i].garantia_vigente_repuesto);
					$("#garantiaEquipoMano").val(clientData.comprados[i].garantia_vigente_mano);
					// $("#garantiaEquipoRepuesto").val(clientData.comprados[i].garantia_vigente_repuesto);
					// $("#garantiaEquipoMano").val(clientData.comprados[i].garantia_vigente_mano);

				}
			}
			$(".botonesRegistro").removeClass('d-none');
		});
	});




});