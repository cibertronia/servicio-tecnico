$(function () {
	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: { monedaPrincipal: '' },
		success: function (data) {
			$(".simboloMoneda").html(data.simbolo)
		}
	})
	$("#imgProducto").val('');
	$("#nombreProducto").val('');
	$("#marcaProducto").val('');
	$("#modeloProducto").val('');
	$("#industriaProducto").val('')
	$("#caracteristicasProducto").val('');
	$("#precioProducto").val('');
	$("#stockProducto").val('');
	$("[name='stockProducto[]']").val('');
	$('.js-summernote').summernote({
		height: 150,
		tabsize: 2,
		placeholder: "Ingrese la descripción del repuesto...",
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
	$("#imgProducto").change(function () {
		filePreview(this);
	});
	$("#formProducto").submit(agregarImagen);
	function agregarImagen(event) {
		var imagen = $("#imgProducto").val();
		var servProvee = $("#configuracionProveedor").val();
		var servCateg = $("#configuracionCategorias").val();
		var servStock = $("#configuracionStock").val();
		var sucursales = $("#numeroSucursales").val();
		if (servProvee == 1) {
			var proveedor = $("#proveedor").val();
		} else if (servCateg == 1) {
			var categoria = $("#categorias").val();
		} else if (servStock == 1) {
			if (sucursales == 1) {
				var stock = $("#stockProducto").val();
			}
		}
		var nombre = $("#nombreProducto").val();
		var marca = $("#marcaProducto").val();
		var modelo = $("#modeloProducto").val();
		var indust = $("#industriaProducto").val()
		var caract = $("#caracteristicasProducto").val();
		var precio = $("#precioProducto").val();
		var formulario = new FormData($("#formProducto")[0]);
		
		//if (imagen == '') {
		//	$(".btnGuardarProducto").before('<div class="text-danger mb-2 noLoadImg"><h2>OLVIDÓ CARGAR UNA IMAGEN</h2></div>');
		//	setTimeout(function () {
		//		$(".noLoadImg").remove();
		//	}, 2500);
		//} else 
		if (servProvee == 1 & proveedor == null) {
			$(".noSelectProveedor").removeClass('d-none');
			setTimeout(function () {
				$(".noSelectProveedor").addClass('d-none');
				$("#proveedor").focus();
			}, 2000);
		} else if (servCateg == 1 & categoria == null) {
			$(".noSelectCategoria").removeClass('d-none');
			setTimeout(function () {
				$(".noSelectCategoria").addClass('d-none');
				$("#categorias").focus();
			}, 2000);
		} else if (nombre == '') {
			$(".emptyNombreProducto").removeClass('d-none');
			setTimeout(function () {
				$(".emptyNombreProducto").addClass('d-none');
				$("#nombreProducto").focus();
			}, 2000);
		}


		// else if (marca == '') {
		// 	$(".emptyMarcaProducto").removeClass('d-none');
		// 	setTimeout(function () {
		// 		$(".emptyMarcaProducto").addClass('d-none');
		// 		$("#marcaProducto").focus();
		// 	}, 2000);
		// } else if (modelo == '') {
		// 	$(".emptyModeloProducto").removeClass('d-none');
		// 	setTimeout(function () {
		// 		$(".emptyModeloProducto").addClass('d-none');
		// 		$("#modeloProducto").focus();
		// 	}, 2000);
		// } else if (indust == '') {
		// 	$(".emptyIndustriaProducto").removeClass('d-none');
		// 	setTimeout(function () {
		// 		$(".emptyIndustriaProducto").addClass('d-none');
		// 		$("#indstriaProducto").focus();
		// 	}, 2000);
		// }

		else if (precio == '') {
			$(".emptyPrecioProducto").removeClass('d-none');
			setTimeout(function () {
				$(".emptyPrecioProducto").addClass('d-none');
				$("#precioProducto").focus();
			}, 2000);
		} else if (isNaN(precio)) {
			$(".noValidoPrecioProducto").removeClass('d-none');
			setTimeout(function () {
				$(".noValidoPrecioProducto").addClass('d-none');
				$("#precioProducto").focus();
			}, 2000);
		} else if (servStock == 1 & sucursales == 1 & stock == '') {
			$(".stockVacio").removeClass('d-none');
			setTimeout(function () {
				$(".stockVacio").addClass('d-none');
				$("#stockProducto").focus();
			}, 2000);
		} else if (servStock == 1 & sucursales == 1 & isNaN(stock)) {
			$(".stockNoValido").removeClass('d-none');
			setTimeout(function () {
				$(".stockNoValido").addClass('d-none');
				$("#stockProducto").focus();
			}, 2000);
		} 
		
		// else if (caract == '') {
		// 	$("#caracteristicasProducto").after('<div class="text-center text-danger noCaractProducto">INGRE CARACTERÍSTICAS</div>');
		// 	setTimeout(function () {
		// 		$(".noCaractProducto").remove();
		// 		$("#caracteristicasProducto").focus();
		// 	}, 2500);
		// }
		
		else {
			$(".btnGuardarProducto").addClass('d-none');
			$(".spinner-GuardarProducto").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				data: formulario,
				contentType: false,
				processData: false,
			})
				.done(function (datos) {
					$(".btnGuardarProducto").removeClass('d-none');
					$(".spinner-GuardarProducto").addClass('d-none');
					$(".respuesta").html(datos);
				});
			return false;
		}
		event.preventDefault();
	}
	$('.select2').select2();
	$(document).on('click', '.btnGuardarProducto_conProveedor', function (event) {
		event.preventDefault();
	});
	/*$(document).on('click', '#imagenExistente', function(event) {
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'html',
			data: {buscarImagenesExistentesPro: ''},
			success:function(data){
				$("#imagenExistente").html(data);
			}
		})
		event.preventDefault();
	});*/
	/*var autoSave = $('#autoSave');
	var interval;
	var timer = function(){
	interval = setInterval(function(){
	  //start slide...
	  if (autoSave.prop('checked'))
		saveToLocal();
		clearInterval(interval);
	}, 3000);
  };
  //save
  var saveToLocal = function(){
	localStorage.setItem('summernoteData', $('#saveToLocal').summernote("code"));
	//console.log("saved");
  }
  //delete 
  var removeFromLocal = function(){
	localStorage.removeItem("summernoteData");
	$('#saveToLocal').summernote('reset');
  }*/
});