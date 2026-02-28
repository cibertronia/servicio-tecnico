$(function() {
	$(":input").inputmask();
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
		let telefono = $("#telUser").val();
    let correo   = $("#mailUser").val();
    let password = $("#pswdUser").val();
    let idTelegram = $("#idTelegram").val();
    //let formulario = new FormData("#actualizaDatos");
    if (telefono=='') {
      $(".emptyCelularCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCelularCliente").addClass('d-none');
        $("#telUser").focus()
      },1500);
    }else if (correo=='') {
      $(".emptyCorreo").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCorreo").addClass('d-none');
        $("#mailUser").focus()
      },2500);
    }else{
      $(".updateDatos").addClass('d-none');
      $(".spinner-updateDatos").removeClass('d-none');
      $.ajax({
      	url: 'puerta_ajax.php',
      	type: 'POST',
      	dataType: 'html',
      	data: $("#actualizaDatos").serialize(),
      })
      .done(function(data) {
      	$(".updateDatos").removeClass('d-none');
      	$(".spinner-updateDatos").addClass('d-none');
      	$(".respuesta").html(data);
      })
      return false;
    }
    event.preventDefault();
	});
	$("#imgPerfilAvatar").change(function() {
		var file 			= this.files[0];
		var imagefile = file.type;
		var match 		= ["image/jpeg","image/png","image/jpg"];
		if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
			$("#imgPerfilAvatar").after('<div class="mt-2 text-center text-danger formatNoValido">FORMATO NO VÁLIDO</div>');
			setTimeout(function() {
				$(".formatNoValido").remove();
			}, 2500);
			$("#imgPerfilAvatar").val('');
			return false;
		}else{
			/*var nuevo = $("#imgPerfilAvatar").val();
			var idUser= $("#idUserHidden").val();*/
			var formulario = new FormData($("#miAvatar")[0]);
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				data: formulario,
				contentType: false,
				processData:false,
			})
			.done(function(resp){
				$(".respuesta").html(resp)
			});
		}
	});
	function filePreview(input) {
		if (input.files && input.files[0]) {
			var reader 		= new FileReader();
			reader.onload = function (e) {
				$('#imgx + img').remove();
				$('#imgx').after('<img src="'+e.target.result+'" width="100"/>');
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imgPerfilAvatar").change(function () {
		filePreview(this);
	});
	$(document).on('click', '#imgPerfilAvatar', function(event) {
		
	});
});