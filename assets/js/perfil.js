$(function() {
	var idUser = $("#idUserHidden").val();
	var defaults = $("#defaultAvatar").val();
	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: {buscarAvatarUsuario: idUser},
		success:function(data){
			if (data.miAvatar=='') {
				$("#imgx").after('<img id="thisAvatar" src="assets/img/avatars/'+defaults+'"  width="100" alt="avatar default"/>');
			}else{
				$("#imgx").after('<img id="thisAvatar" src="assets/img/avatars/'+data.miAvatar+'"  width="100" alt="mi avatar"/>');
			}
		}
	});
	$(document).on('click', '.btnChangePswd', function(event) {
		var pswd = $("#pswdUser").val();
		if (pswd=='') {
			$(".responseBtnChangePswd").before('<div class="mt-2 text-center text-danger noPswdUser">COMPO OBLIGATORIO</div>');
			setTimeout(function() {
				$(".noPswdUser").remove();
			}, 2500);
		}else if (pswd!=''& pswd.length<8) {
			$(".responseBtnChangePswd").before('<div class="mt-2 text-center text-danger noMinLenghtPswd">8 CARCATERES MÍNIMO</div>');
			setTimeout(function() {
				$(".noMinLenghtPswd").remove();
			}, 2500);
		}else if (pswd!=''& pswd.length>21) {
			$(".responseBtnChangePswd").before('<div class="mt-2 text-center text-danger noMaxLenghtPswd">8 CARCATERES MÁXIMO</div>');
			setTimeout(function() {
				$(".noMaxLenghtPswd").remove();
			}, 2500);
		}else{
			$(".btnChangePswd").addClass('d-none');
			$(".spinner-btnChangePswd").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#changPswd").serialize(),
			})
			.done(function(data) {
				$(".btnChangePswd").removeClass('d-none');
				$(".spinner-btnChangePswd").addClass('d-none');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.updateDatos', function(event) {
		event.preventDefault();
		var formElement = document.getElementById("#actualizaDatos");
		var formData = new FormData(formElement);
		let telefono = $("#telUser").val();
    let correo   = $("#mailUser").val();
    let password = $("#pswdUser").val();
    let idTelegram = $("#idTelegram").val();
    //let formulario = new FormData("#actualizaDatos");
    if (telefono=='') {
      $("#telUser").after('<div class="text-center text-danger noTelefono">Ingrese un teléfono</div>');
      setTimeout(function(){
        $(".noTelefono").remove();
        $("#telUser").focus()
      },2500);
    }else if (correo=='') {
      $("#mailUser").after('<div class="text-center text-danger noMail">Ingrese un correo</div>');
      setTimeout(function(){
        $(".noMail").remove();
        $("#mailUser").focus()
      },2500);
    }else if (password=='') {
      $("#pswdUser").after('<div class="text-center text-danger noPswd">Ingrese una contraseña</div>');
      setTimeout(function(){
        $(".noPswd").remove();
        $("#pswdUser").focus()
      },2500);
    }else if (idTelegram=='') {
      $("#idTelegram").after('<div class="text-center text-danger notelegramUser">Ingrese ID Telegram</div>');
      setTimeout(function(){
        $(".notelegramUser").remove();
        $("#idTelegram").focus()
      },2500);
    }else{
      $(".updateDatos").addClass('d-none');
      $(".spinner").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        contentType: false,
        processData: false,
        //dataType: 'json',
        data: formData,
        success:function(data){
        	console.log(data);
        	$(".respuesta").html(data)
        }
      })
      // .done(function(data) {
      //   $(".updateDatos").removeClass('d-none');
      //   $(".spinner").addClass('d-none');
      //   $(".respuesta").html(data);
      // })
      // return false;
    }
		
	});
	function filePreview_(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imgx + img').remove();
				$('#imgx').after('<img src="'+e.target.result+'" width="150"/>');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#img_file").change(function () {
		filePreview_(this);
	});

	$("#img_file").change(function() {
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
			alert('Seleccione una imagen válida (JPEG/JPG/PNG).');
			$("#img_file").val('');
			return false;
		}
	});
	function filePreview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				$('#imgx_ + img').remove();
				$('#imgx_').after('<img src="'+e.target.result+'" width="150"/>');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

	$("#img_file_").change(function () {
		filePreview(this);
	});

	$("#img_file_").change(function() {
		var file = this.files[0];
		var imagefile = file.type;
		var match= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
			alert('Seleccione una imagen válida (JPEG/JPG/PNG).');
			$("#img_file").val('');
			return false;
		}
	});
});