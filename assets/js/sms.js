$(function() {
	$('.select2').select2();
	$("#idClienteModal").val('');
	$("#telefonoModal").val('');
	$("#mensajeModal").val('');
	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'html',
		data: {listaClientesconTelefono:''},
		success:function(data){
			$("#listaClientes").html(data);
		}
	})
	$("#listaClientes").change(function(event) {
		$("#listaClientes option:selected").each(function(index, el) {
			var idCliente = $("#listaClientes option:selected").val();
			$("#mensajeModal").focus();			
		});
	});
	var Mensaje = 160;
  $('#contadorSMS').html('Quedan ' + Mensaje + ' Caracteres');
  $('#mensajeModal').keyup(function() {
    var caracteres = $('#mensajeModal').val().length;
    /*if (caracteres > 160) {
    	$(".limiteExcedido").removeClass('d-none');
    	setTimeout(function() {
    		$(".limiteExcedido").addClass('d-none');
    	}, 1500);
    }*/
    var remanentes = Mensaje - caracteres;
    $('#contadorSMS').html('Quedan ' + remanentes + ' Caracteres');
  });
  $(document).on('click', '.sendSMS', function(event) {
  	var telefono = $("#telefonoModal").val();
	  var mensaje  = $("#mensajeModal").val();
	  /*if (telefono == '') {
	  	$(".emptyTelefono").removeClass('d-none');
	  	setTimeout(function() {
	  		$(".emptyTelefono").addClass('d-none');
	  		$("#telefonoModal").focus();
	  	}, 1500);
	  }else*/ if (mensaje == '') {
  		$(".emptyMensaje").removeClass('d-none');
  		setTimeout(function() {
  			$(".emptyMensaje").addClass('d-none');
  			$("#mensajeModal").focus();
  		}, 1500);
  	}else{
  		$(".sendSMS").addClass('d-none');
  		$(".spinner-sendSMS").removeClass('d-none');
  		$.ajax({
  			url: 'do.php',
  			type: 'POST',
  			dataType: 'html',
  			data: $("#enviarSMS").serialize(),
  		})
  		.done(function(data) {
  			$(".sendSMS").removeClass('d-none');
  			$(".spinner-sendSMS").addClass('d-none');
  			$(".respuesta").html(data)
  		})
  		return false;
  	}
  	event.preventDefault();
  });
  function contador(input,maximo){
    function actualizarContador(input){
      var caracteres = $(input).val().length;
      if (caracteres > maximo) {
        $(input).attr('disabled', true);
        if (input == "#mensajeModal") {
          $(".limiteExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont);
            $("#contadorSMS").html('Quedan 0 Caracteres' );
          }, 1500);
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
  contador("#mensajeModal",160);
});