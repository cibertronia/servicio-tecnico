$(function() {
	$(document).on('click', '.login', function(event) {
		var username = $("#emailuser").val();
		var password = $("#password").val();
		if (username=='') {
			$("#emailuser").after('<div class="mt-2 text-center text-danger noUserLogin">INGRESE CORREO DE ACCESO</div>');
			setTimeout(function() {
				$(".noUserLogin").remove();
			}, 2500);
		}else if (password=='') {
			$("#password").after('<div class="mt-2 text-center text-danger noPswdLogin">INGRESE SU CONTRASEÑA</div>');
			setTimeout(function() {
				$(".noUserLogin").remove();
			}, 2500);
		}else{
			$(".login").addClass('d-none');
			$(".spinner").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#login").serialize(),
			})
			.done(function(data) {
				setTimeout(function() {
					$(".login").removeClass('d-none');
			    $(".spinner").addClass('d-none');
				  $(".respuesta").html(data);
				}, 500);
			})
		}
		event.preventDefault();
	});
	// $(document).on('click', '#rememberPswd', function(event) {
	// 	event.preventDefault();
	// 	$("#login").addClass('d-none');
	// 	$("#recovery").removeClass('d-none');
	// });
});