$(document).ready(function() {
	$("#nombreUsuario").val('');
	$("#sexoUsuario").val('0');
	$("#telefonoUsuario").val('');
	$("#idTelegram").val('');
	$("#correoUsuario").val('');
	$("#sucursalUsuario").val('0');
	$(document).on('click', '.registrarCuenta', function(event) {
		var form 		= $("#registrar").serialize();
		var nombre 	= $("#nombreUsuario").val();
		var genero 	= $("#sexoUsuario").val();
		var telefono= $("#telefonoUsuario").val();
		var idTeleG = $("#idTelegram").val();
		var correo  = $("#correoUsuario").val();
		var sucursal= $("#sucursalUsuario").val();
		if (nombre=='') {
			$("#nombreUsuario").after('<div class="mt-2 text-center text-danger noNombreRegistrar">INGRESE SU NOMBRE</div>');
			setTimeout(function() {$(".noNombreRegistrar").remove()}, 2500);
		}else if (nombre!=''& nombre.length>99) {
			$("#nombreUsuario").after('<div class="mt-2 text-center text-danger nombreMaxLength">CAMPO NOMBRE EXCEDIDO</div>');
			setTimeout(function() {$(".nombreMaxLength").remove()}, 2500);
		}else if (genero==null) {
			$("#sexoUsuario").after('<div class="mt-2 text-center text-danger noGeneroRegistrar">SELECCIONE GÉNERO</div>');
			setTimeout(function() {$(".noGeneroRegistrar").remove()}, 2500);
		}else if (telefono=='') {
			$("#telefonoUsuario").after('<div class="mt-2 text-center text-danger noTelefonoRegistrar">INGRESE TELÉFONO</div>');
			setTimeout(function() {$(".noTelefonoRegistrar").remove()}, 2500);
		}else if (telefono!='' & telefono.length<8) {
			$("#telefonoUsuario").after('<div class="mt-2 text-center text-danger noMinTelfonoReg">MÍNIMO DE 7 NÚMEROS</div>');
			setTimeout(function() {$(".noMinTelfonoReg").remove()}, 2500);
		}else if (telefono!='' & telefono.length>9) {
			$("#telefonoUsuario").after('<div class="mt-2 text-center text-danger noMaxTelefonoReg">MÁXIMO 8 NÚMEROS</div>');
			setTimeout(function() {$(".noMaxTelefonoReg").remove()}, 2500);
		}else if (correo=='') {
			$("#correoUsuario").after('<div class="mt-2 text-center text-danger noCorreoRegistrar">INGRESE UN CORREO</div>');
			setTimeout(function() {$(".noCorreoRegistrar").remove()}, 2500);
		}else if (sucursal==null) {
			$("#sucursalUsuario").after('<div class="mt-2 text-center text-danger noSucursalRegistrar">SELECCIONE SUCURSAL</div>');
			setTimeout(function() {$(".noSucursalRegistrar").remove()}, 2500);
		}else{
			$(".registrarCuenta").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#registrar").serialize(),
			})
			.done(function(data) {
				$(".registrarCuenta").removeClass('d-none');
				$(".spinner").addClass('d-none');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
});