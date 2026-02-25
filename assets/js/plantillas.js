$(function() {
	$('.js-summernote').summernote({
    height: 750,
    tabsize: 2,
    placeholder: "empiece a escribir código html... te deseo mucha suerte!! &nbsp;😂",
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
	    callbacks:{
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
	$(document).on('click', '.editarPlantilla', function(event) {
		var idPlantilla = $(this).attr('id');
		$("#panelListaIndicaciones").addClass('d-none');
		$("#panelListaPlantillas").addClass('d-none');
		$(".tooltip").hide();
		$("#panelCrarPlantilla").removeClass('d-none');
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {obtenerDatosPlantilla: idPlantilla},
			success:function(data){
				$("#idPlantilla").val(idPlantilla);
				$("#nombrePlantilla").val(data.nombre);
				$("#contenidoPlantilla").summernote("code",data.html);
				$(".btn-actualizarPlantilla").removeClass('d-none');
			}
		})
		return false;
		event.preventDefault();
	});
	$(document).on('click', '.actualizarPlantilla', function(event) {
		var nombrePlantilla = $("#nombrePlantilla").val();
		var contenidoHTML 	= $("#contenidoPlantilla").val();
		if (nombrePlantilla == '') {
			$("#nombrePlantilla").after('<div class="my-2 text-center text-danger noNombrePlantilla">INGRESE UN NOMBRE</div>');
			setTimeout(function() {
				$(".noNombrePlantilla").remove();
				$(".noNombrePlantilla").focus()
			}, 2000);
		}else {
			$(".actualizarPlantilla").addClass('d-none');
			$(".spinner-actualizarPlantilla").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formPlantilla").serialize(),
			})
			.done(function(data) {
				$(".actualizarPlantilla").removeClass('d-none');
				$(".spinner-actualizarPlantilla").addClass('d-none');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
	$(document).on('click', '.cerrarEditorHTML', function(event) {
		$("#panelCrarPlantilla").addClass('d-none');
		$(".tooltip").hide();
		$("#panelListaIndicaciones").removeClass('d-none');
		$("#panelListaPlantillas").removeClass('d-none');
		$("#action").val('actualizarPlantilla');
		$(".btn-guardarPlantilla").addClass('d-none')
		event.preventDefault();
	});
	$("#listaPlantillas").dataTable({responsive:true});
	$(document).on('click', '.modal_crearPlantillaHTML', function(event) {
		$("#panelListaIndicaciones").addClass('d-none');
		$("#panelListaPlantillas").addClass('d-none');
		$(".tooltip").hide();
		$("#panelCrarPlantilla").removeClass('d-none');
		$("#action").val('guardarPlantilla');
		$("#idPlantilla").val('');
		$("#nombrePlantilla").val('');
		$("#contenidoPlantilla").summernote("code",'');
		$(".btn-actualizarPlantilla").addClass('d-none');
		$(".btn-guardarPlantilla").removeClass('d-none')
		event.preventDefault();
	});
	$(document).on('click', '.guardarPlantilla', function(event) {
		var nombrePlantilla = $("#nombrePlantilla").val();
		var contenidoHTML 	= $("#contenidoPlantilla").val();
		if (contenidoHTML == '') {
			$("#contenidoPlantilla").after('<div class="my-2 text-center text-danger noContenidoPlantilla">EL CONTENIDO ESTÁ VACÍO.</div>');
			setTimeout(function() {
				$(".noContenidoPlantilla").remove();
				$("#contenidoPlantilla").focus()
			}, 2000);
		}else if (nombrePlantilla == '') {
			$("#nombrePlantilla").after('<div class="my-2 text-center text-danger noNombrePlantilla">INGRESE UN NOMBRE</div>');
			setTimeout(function() {
				$(".noNombrePlantilla").remove();
				$("#nombrePlantilla").focus()
			}, 2000);
		}else {
			$(".guardarPlantilla").addClass('d-none');
			$(".spinner-guardarPlantilla").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formPlantilla").serialize(),
			})
			.done(function(data) {
				$(".guardarPlantilla").removeClass('d-none');
				$(".spinner-guardarPlantilla").addClass('d-none');
				$(".respuesta").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
});