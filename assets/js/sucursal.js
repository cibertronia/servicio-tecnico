$(function() {
	$('#listaSucursales').DataTable({responsive: true});
	$(document).on('click', '.openModaladdSucursal', function(event) {
		$("#nombreSucursal").val('');
		$("#codigoSucursal").val('');
		$("#openModaladdSucursal").modal({backdrop: 'static', keyboard: false});
		event.preventDefault();
	});
	$(document).on('click', '.regNewSucursal', function(event) {
		var sucursal = $("#nombreSucursal").val();
		var codesucu = $("#codigoSucursal").val();
		if (sucursal=='') {
			$(".emptyNombre").removeClass('d-none');
			setTimeout(function(){
				$(".emptyNombre").addClass('d-none');
				$("#nombreSucursal").focus();
			},1500)
		}else if (codesucu=='') {
			$(".emptyCode").removeClass('d-none');
			setTimeout(function(){
				$(".emptyCode").addClass('d-none');
				$("#codigoSucursal").focus();
			},2500)
		}else{			
			$(".regNewSucursal").addClass('d-none');
			$(".spinner-regNewSucursal").removeClass('d-none');
			event.preventDefault();
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#registrarnuevaSucursal").serialize(),
			})
			.done(function(data) {
				$(".regNewSucursal").removeClass('d-none');
			  $(".spinner-regNewSucursal").addClass('d-none');
				$("#openModaladdSucursal").modal('hide');
				$(".respuesta").html(data);
			})
		}
		event.preventDefault();
	});
	$(document).on('click', '.openModaleditSucursal', function(event) {
		$("#openModaleditSucursal").modal({backdrop: 'static', keyboard: false});
		var idSucursal = $(this).attr('id');
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {editarSucursalJSON: idSucursal},
			success:function(data){
				$("#editSucursal").modal();
				$("#idSucursalModal").val(idSucursal);
				$("#nombre_Sucursal").val(data.sucursal);
				$("#codigo_Sucursal").val(data.codeTienda);
			}
		})
		event.preventDefault();
	});
	$(document).on('click', '.actualizarSucursal', function(event) {
		var sucursal = $("#nombre_Sucursal").val();
		var codigo   = $("#codigo_Sucursal").val();
		if (sucursal=='') {
			$("#nombre_Sucursal").after('<div class="text-center text-danger no_SucursalForm">INGRESE SUCURSAL</div>');
			setTimeout(function(){
				$("#nombre_Sucursal").focus();
				$(".no_SucursalForm").remove();
			},2500)
		}else if (codigo=='') {
			$("#codigo_Sucursal").after('<div class="text-center text-danger no_CodeForm">INGRESE CÓDIGO</div>');
			setTimeout(function(){
				$("#codigo_Sucursal").focus();
				$(".no_CodeForm").remove();
			},2500)
		}else{
			$(".actualizarSucursal").addClass('d-none');
			$(".spinner-actualizarSucursal").removeClass('d-none');
			$.ajax({
				url: 'do.php',
				type: 'POST',
				dataType: 'html',
				data: $("#updateSucursal").serialize(),
			})
			.done(function(data) {
				$(".actualizarSucursal").removeClass('d-none');
				$(".spinner-actualizarSucursal").addClass('d-none');
				$(".respuesta").html(data);
			})
		}
		event.preventDefault();
	});
	$(document).on('click', '.deshabilitarSucursal', function(event) {
		event.preventDefault();
		var idSucursal = $(this).attr("id");
		var rangoUsuario = $("#rangoUsuario").val();
		const swalWithBootstrapButtons = Swal.mixin({
		  customClass: {
		    confirmButton: 'btn btn-success m-3',
		    cancelButton: 'btn btn-danger'
		  },
		  buttonsStyling: false
		})
		swalWithBootstrapButtons.fire({
		  title: 'Estás seguro?',
		  html: "Si continuas, la sucursal será deshabilitada del sistema. Eso implica que <span class='text-danger'><b>TODO</b></span> el stock de esta sucursal, será borrado de la base de datos.",
		  icon: 'question',
		  showCancelButton: true,
		  confirmButtonText: 'Sí, deshabilitar!',
		  cancelButtonText: 'No, cancelar!',
		  reverseButtons: true
		}).then((result) => {
		  if (result.value) {
		  	if (rangoUsuario==1) {
		  		swalWithBootstrapButtons.fire(
			      'Sin Autorización',
			      'No cuentas con los privilegios necesarios.',
			      'error'
			    )
		  	}else{
		  		$.ajax({
						url: 'do.php',
						type: 'POST',
						dataType: 'html',
						data: "action=DeshabilitarSucursal&idSucursal="+idSucursal,
					})
					.done(function(data) {
						$(".respuesta").html(data);
					})
					return false;
		  	}		  	
		  } else if (
		    /* Read more about handling dismissals below */
		    result.dismiss === Swal.DismissReason.cancel
		  ) {
		    swalWithBootstrapButtons.fire(
		      'Cancelado',
		      'La sucursal ya no será deshabilitada.',
		      'error'
		    )
		  }
		})
	});
	$(document).on('click', '.HabilitarSucursal', function(event) {
		event.preventDefault();
		var idSucursal = $(this).attr("id");
		$.ajax({
			url: 'do.php',
			type: 'POST',
			dataType: 'html',
			data: "action=HabilitarSucursal&idSucursal="+idSucursal,
		})
		.done(function(data) {
			$(".respuesta").html(data);
		})
		return false;		
	});
	$(document).on('click', '.editSucursal', function(event) {
		event.preventDefault();
		var idSucursal = $(this).attr("id");
		$("#sucursalEdit").modal()
		$.ajax({
			url: 'dist/php/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {idSucursal},
			success:function(data){
				$("#idSucursal").val(idSucursal);
				$("#name_Sucursal").val(data.Sucursal);
				$("#code_Sucursal").val(data.code);
			}
		})
	});
	function contador(input,maximo){
    function actualizarContador(input){
      var caracteres = $(input).val().length;
      if (caracteres > maximo) {
        $(input).attr('disabled', true);
        if (input == "#nombreSucursal" || input == "#nombre_Sucursal" ) {
          $(".limiteNombreExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteNombreExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
          }, 1000);
        }else if (input == "#codigoSucursal" || input == "#codigo_Sucursal" ) {
          $(".limiteCodigoExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteCodigoExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
          }, 1000);
        }
      }
    }
    $(input).keyup(function(event) {
      actualizarContador(input);
    });
    $(input).change(function(event) {
      actualizarContador(input);
    });
  }
  contador("#nombreSucursal",30); contador("#codigoSucursal",3); contador("#nombre_Sucursal",30); contador("#codigo_Sucursal",3);
});