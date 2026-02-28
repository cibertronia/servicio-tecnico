$(function () {
	$("#garantiaEquipo").change(function (event) {
		$("#garantiaEquipo option:selected").each(function () {
			var opcionGarantia = $(this).val();
			$(".botonesRegistro").removeClass('d-none');
			if (opcionGarantia == 'no') {
				$(".opcionesGarantia").addClass('d-none');
			} else {
				$(".opcionesGarantia").removeClass('d-none');
			}
		});
	});
	$(document).on('click', '#btnMasCampos', function (event) {
		var sucursal = $("#sucursalUsuario").val();
		var nombreCliente = $("#nombreCliente").val();
		var cellCliente = $("#telCliente").val();
		var claveSoporte = $("#claveSoporte").val();
		var equipo = $("#equipoNombre").val();
		var marca = $("#marcaEquipo").val();
		var modelo = $("#modeloEquipo").val();
		var serie = $("#serieEquipo").val();
		var problema = $("#problemaEquipo").val();
		var observaciones = $("#observacionesEquipo").val();
		var garantia = $("#garantiaEquipo option:selected").val();//dividir y mandar
		var fechaCompra = $("#fechaCompra").val();
		var numeroFactura = $("#numeroFactura").val();


		// var garantia_vigente_repuesto = $("#garantiaEquipoRepuesto").val();
		// var garantia_vigente_mano = $("#garantiaEquipoMano").val();




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
		} else if (serie == '') {
			$("#serieEquipo").after('<div class="text-center text-danger noSerieEquipo">Ingrese serie</div>');
			setTimeout(function () {
				$(".noSerieEquipo").remove();
				$("#serieEquipo").focus();
			}, 2500);
		} else if (problema == '') {
			$("#problemaEquipo").after('<div class="text-center text-danger noInsertProblema">Ingrese el problema</div>');
			setTimeout(function () {
				$(".noInsertProblema").remove();
				$("#problemaEquipo").focus();
			}, 2500);
		}

		//VALIDAR
		// else if (garantia_vigente_repuesto == 'si' || garantia_vigente_mano == 'si' ) {	
		// 	$("#garantiaEquipo").val('si');
		// 	garantia='si';
		// }
		// else if (garantia_vigente_repuesto == 'no' && garantia_vigente_mano == 'no' ) {	
		// 	$("#garantiaEquipo").val('no');
		// 	garantia='no';
		// }


		else if (garantia == 'si' & fechaCompra == '') {
			$("#fechaCompra").after('<div class="text-center text-danger noInsertFecha">Ingrese fecha</div>');
			setTimeout(function () {
				$(".noInsertFecha").remove();
			}, 2500);
		} else if (garantia == 'si' & numeroFactura == '') {
			$("#numeroFactura").after('<div class="text-center text-danger factura">Ingrese factura</div>');
			setTimeout(function () {
				$(".factura").remove();
				$("#numeroFactura").focus();
			}, 2500);
		} else {
			var datosPOST = "action=GuardarClaveServicio&Clave=" + claveSoporte + "&sucursal=" + sucursal + "&equipo=" + equipo + "&marca=" + marca + "&modelo=" +
				modelo + "&serie=" + serie + "&problema=" + problema + "&observaciones=" + observaciones + "&garantia=" +
				garantia + "&fechaCompra=" + fechaCompra + "&numeroFactura=" + numeroFactura;
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
					$("#garantiaEquipo").val('Seleccione una opción');
					$("#fechaCompra").val('');
					$("#numeroFactura").val('');
					$("#equipoNombre").focus();
				}
			})
		 }
		event.preventDefault();
	});
	$(document).on('click', '#btnContinuar', function (event) {
		var sucursal = $("#sucursalUsuario").val();
		var claveSoporte = $("#claveSoporte").val();
		var nombreCliente = $("#nombreCliente").val();
		var cellCliente = $("#telCliente").val();
		var equipo = $("#equipoNombre").val();
		var marca = $("#marcaEquipo").val();
		var modelo = $("#modeloEquipo").val();
		var serie = $("#serieEquipo").val();
		var problema = $("#problemaEquipo").val();
		var observaciones = $("#observacionesEquipo").val();
		var garantia = $("#garantiaEquipo option:selected").val();
		var fechaCompra = $("#fechaCompra").val();
		var numeroFactura = $("#numeroFactura").val();
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
		} else if (serie == '') {
			$("#serieEquipo").after('<div class="text-center text-danger noSerieEquipo">Ingrese serie</div>');
			setTimeout(function () {
				$(".noSerieEquipo").remove();
				$("#serieEquipo").focus();
			}, 2500);
		} else if (problema == '') {
			$("#problemaEquipo").after('<div class="text-center text-danger noInsertProblema">Ingrese el problema</div>');
			setTimeout(function () {
				$(".noInsertProblema").remove();
				$("#problemaEquipo").focus();
			}, 2500);
		} else if (garantia == 'si' & fechaCompra == '') {
			$("#fechaCompra").after('<div class="text-center text-danger noInsertFecha">Ingrese fecha</div>');
			setTimeout(function () {
				$(".noInsertFecha").remove();
			}, 2500);
		} else if (garantia == 'si' & numeroFactura == '') {
			$("#numeroFactura").after('<div class="text-center text-danger factura">Ingrese factura</div>');
			setTimeout(function () {
				$(".factura").remove();
				$("#numeroFactura").focus();
			}, 2500);
		} else {
			//var datosPOST = "action=GuardarnuevoServicio&nombreCliente="+
			nombreCliente + "&sucursal=" + sucursal + "&cellCliente=" + cellCliente + "&Clave=" +
				claveSoporte + "&equipo=" + equipo + "&marca=" + marca + "&modelo=" + modelo + "&serie=" +
				serie + "&problema=" + problema + "&observaciones=" + observaciones + "&garantia=" +
				garantia + "&fechaCompra=" + fechaCompra + "&numeroFactura=" + numeroFactura;
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
		}
		event.preventDefault();
	});
	/*	Funciones fuera de servicio por cambios hechos al sistema	*/
	/*$(document).on('click', '.guardaServicio', function(event) {
		alert("Presionaste el boton con la clase guardaServicio");
		return false;
		var nombre 	= $("#Nombre").val();
		var celular = $("#Celular").val();
		var maquina = $("#Maquina").val();
		var marca 	= $("#Marca").val();
		var modelo 	= $("#Modelo").val();
		var serie 	= $("#numSerie").val();
		var trabajo = $("#Trabajo").val();
		if (nombre == '') {
			$("#Nombre").after('<div class="text-center text-danger no NonameService">Ingre un nombre</div>');
			setTimeout(function() {
				$(".NonameService").remove();
				$("#Nombre").focus();
			},2500);
		}else if (celular=='') {
			$("#Celular").after('<div class="text-center text-danger no NocellService">Ingre teléfono</div>');
			setTimeout(function() {
				$(".NocellService").remove();
				$("#Celular").focus();
			},2500);
		}else if (maquina=='') {
			$("#Maquina").after('<div class="text-center text-danger no NomaquinaService">Ingre un dato válido</div>');
			setTimeout(function() {
				$(".NomaquinaService").remove();
				$("#Maquina").focus();
			},2500);
		}else if (trabajo=='') {
			$("#Trabajo").after('<div class="text-center text-danger no NotrabajoService">Ingre el trabajo a realizar</div>');
			setTimeout(function() {
				$(".NotrabajoService").remove();
				$("#Trabajo").focus();
			},2500);
		}else{
			$(".guardaServicio").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#registrarServicio").serialize(),
			})
			.done(function(data) {
				$(".guardaServicio").removeClass('d-none');
			  $(".spinner").addClass('d-none');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.deleteServicio', function(event) {
		var idClave = $(this).attr('id');
		var swalWithBootstrapButtons = Swal.mixin({
	  customClass:{
		confirmButton: "btn btn-primary",
		cancelButton: "btn btn-danger mr-2",
	  },
	  buttonsStyling: false,
	});
	swalWithBootstrapButtons
	.fire({
	  title: "Estás seguro?",
	  text: "Si continuas, el registro seleccionado será eliminado sin poder recuperar la información?",
	  icon: "question",
	  showCancelButton: true,
	  confirmButtonText: "Sí, borrar!",
	  cancelButtonText: "No, cancelar!",
	  reverseButtons: true
	})
	.then(function(result){
	  if (result.value){
		$.ajax({
		  url: 'puerta_ajax.php',
		  type: 'POST',
		  dataType: 'html',
		  data: "action=BorrarServicio_clave&idClave="+idClave,
		  success:function(data){
			$(".respuesta").html(data);
		  }
		})
	  }else if (result.dismiss === Swal.DismissReason.cancel){
		swalWithBootstrapButtons.fire(
		  "Cancelado",
		  "El registro ya no será eliminado.",
		  "error"
		);
	  }
	});
		event.preventDefault();
	});*/


	//yuli servicio tecnico

	$("#ClienteProducto").select2();

	$("#ClienteProducto").change(function () {
		$("#ClienteProducto option:selected").each(function () {
			var idCliente = $(this).val();
			var $selectEquipoExistente = $("#EquipoExistente");

			$("#marcaEquipo").val('');
			$("#modeloEquipo").val('');
			$("#serieEquipo").val('');
			$("#fechaVenta").val('');

			$("#garantiaEquipo").val('no');
			// $("#garantiaEquipoRepuesto").val('no');
			// $("#garantiaEquipoMano").val('no');
			

			$.ajax({
				url: 'includes/ajax/getDataClientesYuli.php',
				type: 'POST',
				dataType: 'json',
				data: { id: idCliente },
				success: function (data) {
					$("#nombreCliente").val(data.Nombres+' '+data.Apellidos);
					
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

	$("#EquipoExistente").change(function () {
		$("#EquipoExistente option:selected").each(function () {

			var idVenta = $(this).val();


			var getDataClientesYuliJson = $("#getDataClientesYuliJson").val();


			const clientData = JSON.parse(getDataClientesYuliJson);

			//$("#marcaEquipo").val(clientData.Apellidos);
			//$("#marcaEquipo").val(clientData.comprados.length);

			for (let i = 0; i < clientData.comprados.length; i++) {
				if (idVenta == clientData.comprados[i].idVenta) {

					$("#equipoNombre").val(clientData.comprados[i].Producto);
					$("#marcaEquipo").val(clientData.comprados[i].Marca);
					$("#modeloEquipo").val(clientData.comprados[i].Modelo);
					$("#serieEquipo").val('S/N:');
					$("#fechaCompra").val(clientData.comprados[i].FechaVenta);
					$("#numeroFactura").val(clientData.comprados[i].idEntrega);
					

					// $("#garantiaEquipoRepuesto").val(clientData.comprados[i].garantia_vigente_repuesto);
					// $("#garantiaEquipoMano").val(clientData.comprados[i].garantia_vigente_mano);

					// if ($("#garantiaEquipoRepuesto").val() == 'si' || $("#garantiaEquipoMano").val() == 'si' ) {	
					// 	$("#garantiaEquipo").val('si');	
					// }else{
					// 	$("#garantiaEquipo").val('no');	
					// }

				}
			}
			$(".botonesRegistro").removeClass('d-none');
		});
	});

	$("input:checkbox[name='optionUser']").change(function () {


		if ($(this).is(':checked')) {

			$(".siExistente").removeClass('d-none');//color si o no
			$(".noExistente").addClass('d-none');//color si o no

			$(".ClienteXistente").removeClass('d-none');
			$(".clienteTelefonoCol").removeClass('d-none');
			// $(".NoClienteXistente").addClass('d-none');

			$(".equipoExistenteCol").removeClass('d-none');
			// $(".equipoNoExistenteCol").addClass('d-none');

		} else {

			$(".noExistente").removeClass('d-none');//color si o no
			$(".siExistente").addClass('d-none');//color si o no

			$(".ClienteXistente").addClass('d-none');
			$(".NoClienteXistente").removeClass('d-none');
			$(".clienteTelefonoCol").removeClass('d-none');

			$(".equipoNoExistenteCol").removeClass('d-none');
			$(".equipoExistenteCol").addClass('d-none');

			$("#getDataClientesYuliJson").val('');




			$("#nombreCliente").val('');
			$("#telCliente").val('');
			$("#equipoNombre").val('');
			$("#marcaEquipo").val('');
			$("#modeloEquipo").val('');
			$("#serieEquipo").val('');
			$("#problemaEquipo").val('');
			$("#observacionesEquipo").val('');
			
			$("#fechaCompra").val('');
			$("#numeroFactura").val('');
	
			$("#garantiaEquipo").val('no');//dividir y mandar

			// $("#garantiaEquipoRepuesto").val('no');
			// $("#garantiaEquipoMano").val('no');

		}
	});



});