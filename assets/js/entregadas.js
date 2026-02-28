$(function() {  
  $(document).on('click', '.Buscar', function(event) {
    $("#buscar").removeClass('d-none');
    event.preventDefault();
  });
	$("#listaEntregadas").DataTable({responsive:true,order:false});
	$(document).on('click', '.openModal_VenderCotizacion', function(event) {
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {monedaPrincipal: ''},
      success:function(data){
        // $(".simboloMoneda").html(data.simbolo);
        $("#idMonedaPanel").val(data.monedaP);
      }   
         
    })
    
    $("#codigoCotizacionVenta").val('');
    $("#porCantidad").val('');
    $("#recibide").val('');
    $("#cantidadLetras").val('');
    $("#enConceptode").val('');
		$("#openModal_VenderCotizacion").modal({backdrop: 'static', keyboard: false});
		var serviPrecioDolar = $("#serviPrecioDolar").val();
		var idCotizacionVenta= $(this).attr('id');
  // // console.log(idMoneda);
  // console.log('gaaaa');
		$.ajax({
			url: 'includes/consultas.php',
			type: 'POST',
			dataType: 'json',
			data: {idCotizacionVenta},
			success:function(data){
        var idMoneda = $("#idMonedaPanel").val();       
        if (idMoneda == 1) {
          plural = 'Bolivianos';
        }else if (idMoneda == 2) {
          plural = 'Dólares';
        }else if (idMoneda == 3) {
          plural = 'Euros';
        }else if (idMoneda == 4) {
          plural = 'Soles';
        }else if (idMoneda == 5) {
          plural = 'Pesos';
        }else{
          plural = 'moneda desconocida';
        }
				var TotalVenta = data.TotalVenta;
				var enLetras   = numeroALetras(TotalVenta,{plural,centPlural:'centavos.'});
				var minusculas = enLetras.toLowerCase();
				var inicialMayuscula = minusculas.charAt(0).toUpperCase();
				function capitalizarPrimeraLetra(minusculas) {
          return minusculas.charAt(0).toUpperCase() + minusculas.slice(1);
        }
        $("#idCotizacionModalVenta").val(idCotizacionVenta);
        $("#codigoCotizacionVenta").attr('disabled', true);
        $("#codigoCotizacionVenta").val(data.codigoCotiza);
        $("#idVendedorCotizacion").val(data.idUser);
        $("#idClienteCotizacionVenta").val(data.idCliente);
        $("#nombreVendedorCotizacion").val(data.nombreVendedor);
        $("#idTiendaCotizacion").val(data.idTienda);
        $("#claveCotizacionVenta").val(data.claveCotizacion);
				$("#porCantidad").val(TotalVenta);
        $("#enConceptode").val(data.Prod);
				$("#cantidadLetras").val(capitalizarPrimeraLetra(minusculas));
				$("#recibide").val(data.nombreCliente);
				setTimeout(function() {$("#enConceptode").focus();}, 500);
			}
		})		
		if (serviPrecioDolar==1) {
			$.ajax({
			  url: 'includes/consultas.php',
			  type: 'POST',
			  dataType: 'html',
			  data: {consultaMonedas: ''},
			  success:function(data){
				  $("#selectedMoneda").html(data)
			  }
		  })
		}
		event.preventDefault();
	});
	$(document).on('click', '.guardarPago', function(event) {
		var serviPrecioDolar = $("#serviPrecioDolar").val();
		var idCotizacion     = $("#idCotizacionModalVenta").val();
		var monedaSelector   = $("#selectedMoneda").val();
		var precioDolar      = $("#precioDolar").val();
		var porCantidad      = $("#porCantidad").val();
		var nombreCliente    = $("#recibide").val();
		var cantidadLetras   = $("#cantidadLetras").val();
		var concepto         = $("#enConceptode").val();
		var idVendedor         = $("#idVendedor").val();
		var nombreVendedor         = $("#nombreVendedor").val();
		$("#codigoCotizacionVenta").attr('disabled', false);
		if (serviPrecioDolar==1 & precioDolar=='') {
			$(".emptyPrecioDolar").removeClass('d-none');
			setTimeout(function() {
				$(".emptyPrecioDolar").addClass('d-none');
			}, 1500);
		}else if (porCantidad=='') {
			$(".emptyCantidadNumeros").removeClass('d-none');
			setTimeout(function() {
				$(".emptyCantidadNumeros").addClass('d-none');
			}, 1500);
		}else if (nombreCliente=='') {
			$(".emptyNombreCliente").removeClass('d-none');
			setTimeout(function() {
				$(".emptyNombreCliente").addClass('d-none');
			}, 1500);
		}else if(cantidadLetras==''){
			$(".emptyCantidadLetras").removeClass('d-none');
			setTimeout(function() {
				$(".emptyCantidadLetras").addClass('d-none');
			}, 1500);
		}else if (concepto=='') {
			$(".emptyConcepto").removeClass('d-none');
			setTimeout(function() {
				$(".emptyConcepto").addClass('d-none');
			}, 1500);
		}else if ((idVendedor=='-1') && (nombreVendedor == "")) {
			$(".emptyNombreVendedor").removeClass('d-none');
			setTimeout(function() {
				$(".emptyNombreVendedor").addClass('d-none');
			}, 1500);
		}		else{
			$(".guardarPago").addClass('d-none');
			$(".spinner-guardarPago").removeClass('d-none');
			$.ajax({
				url: 'puerta_ajax.php',
				type: 'POST',
				dataType: 'html',
				data: $("#formularioVenta").serialize(),
			})
			.done(function(data) {
				$(".guardarPago").removeClass('d-none');
			  $(".spinner-guardarPago").addClass('d-none');
			  $("#openModal_VenderCotizacion").modal('hide');
				$(".tablaProductos_notaE").html(data);
			})
			return false;
		}
		event.preventDefault();
	});
  $(document).on('click', '.actualizarNotaE', function(event) {
    var descripcion = $("#descripcionEntrega").val();
    if (descripcion=='') {
      $(".emptyDescripcion").removeClass('d-none');
      setTimeout(function() {
        $(".emptyDescripcion").addClass('d-none');
      }, 1500);
    }else{
      $(".actualizarNotaE").addClass('d-none');
      $(".spinner-actualizarNotaE").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: $("#formNotaEntrega").serialize(),
      })
      .done(function(data) {
        $(".actualizarNotaE").removeClass('d-none');
        $(".spinner-actualizarNotaE").addClass('d-none');
        $("#openModalNotaEntrega").modal('hide');
        $(".respuesta").html(data);
      })
      return false;
    }
    event.preventDefault();
  });
	
  $("#selectedMoneda").change(function() {
		$("#selectedMoneda option:selected").each(function() {
			var Moneda 		=	$("#selectedMoneda option:selected").val();
			var Cantidad 	=	$("#porCantidad").val();
			var valorDolar 	=	$("#precioDolar").val();
			var CodeCotiza 	=	$("#codigoCotizacionVenta").val();    
      
      $("#cantidadLetras").val("");				
      let TotalVenta = 0;
      let plural = ''
      let idCotizacionVenta= $('#idCotizacionModalVenta').val();
			if (Moneda==2) { //DOLARES
        TotalVenta = Cantidad/valorDolar;
        plural = 'Dólares';
				$("#porCantidad").val((TotalVenta).toFixed(2));
				
        $.ajax({
          url: 'includes/consultas.php',
          type: 'POST',
          dataType: 'json',
          data: {idCotizacionVenta},
          success:function(data){
            $("#enConceptode").val(data.Prod);
          }
        })

			}else if(Moneda == 1){  //BOLIVIANOS
        TotalVenta = Cantidad*valorDolar
        plural = 'Bolivianos';
				$("#porCantidad").val((TotalVenta).toFixed(2));
				
				$.ajax({
          url: 'includes/consultas.php',
          type: 'POST',
          dataType: 'json',
          data: {idCotizacionVentaBs: idCotizacionVenta},
          success:function(data){            
            $("#enConceptode").val(data.Prod);
          }
        })
                
			}
 
			var enLetras   = numeroALetras(TotalVenta,{plural,centPlural:'centavos.'});
			var minusculas = enLetras.toLowerCase();
			var inicialMayuscula = minusculas.charAt(0).toUpperCase();

			$("#cantidadLetras").val(inicialMayuscula + minusculas.slice(1));		
		});
	});

  var numeroALetras = (function() {
    // Código basado en https://gist.github.com/alfchee/e563340276f89b22042a
    function Unidades(num){
    switch(num){
      case 1: return 'UN';
      case 2: return 'DOS';
      case 3: return 'TRES';
      case 4: return 'CUATRO';
      case 5: return 'CINCO';
      case 6: return 'SEIS';
      case 7: return 'SIETE';
      case 8: return 'OCHO';
      case 9: return 'NUEVE';
    }
    return '';
    } //Unidades()
    function Decenas(num){
      let decena = Math.floor(num/10);
      let unidad = num - (decena * 10);
      switch(decena){
        case 1:
        switch(unidad){
          case 0: return 'DIEZ';
          case 1: return 'ONCE';
          case 2: return 'DOCE';
          case 3: return 'TRECE';
          case 4: return 'CATORCE';
          case 5: return 'QUINCE';
          default: return 'DIECI' + Unidades(unidad);
        }
        case 2:
        switch(unidad){
          case 0: return 'VEINTE';
          default: return 'VEINTI' + Unidades(unidad);
        }
        case 3: return DecenasY('TREINTA', unidad);
        case 4: return DecenasY('CUARENTA', unidad);
        case 5: return DecenasY('CINCUENTA', unidad);
        case 6: return DecenasY('SESENTA', unidad);
        case 7: return DecenasY('SETENTA', unidad);
        case 8: return DecenasY('OCHENTA', unidad);
        case 9: return DecenasY('NOVENTA', unidad);
        case 0: return Unidades(unidad);
      }
    }//Unidades()
    function DecenasY(strSin, numUnidades) {
      if (numUnidades > 0)
      return strSin + ' Y ' + Unidades(numUnidades)
      return strSin;
    }//DecenasY()
    function Centenas(num) {
      let centenas = Math.floor(num / 100);
      let decenas = num - (centenas * 100);
      switch(centenas){
        case 1:
        if (decenas > 0)
            return 'CIENTO ' + Decenas(decenas);
        return 'CIEN';
        case 2: return 'DOSCIENTOS ' + Decenas(decenas);
        case 3: return 'TRESCIENTOS ' + Decenas(decenas);
        case 4: return 'CUATROCIENTOS ' + Decenas(decenas);
        case 5: return 'QUINIENTOS ' + Decenas(decenas);
        case 6: return 'SEISCIENTOS ' + Decenas(decenas);
        case 7: return 'SETECIENTOS ' + Decenas(decenas);
        case 8: return 'OCHOCIENTOS ' + Decenas(decenas);
        case 9: return 'NOVECIENTOS ' + Decenas(decenas);
      }
      return Decenas(decenas);
    }//Centenas()
    function Seccion(num, divisor, strSingular, strPlural) {
      let cientos = Math.floor(num / divisor)
      let resto = num - (cientos * divisor)
      let letras = '';
      if (cientos > 0)
        if (cientos > 1)
          letras = Centenas(cientos) + ' ' + strPlural;
        else
          letras = strSingular;
        if (resto > 0)
          letras += '';
        return letras;
    }//Seccion()
    function Miles(num) {
      let divisor = 1000;
      let cientos = Math.floor(num / divisor)
      let resto = num - (cientos * divisor)
      let strMiles = Seccion(num, divisor, 'UN MIL', 'MIL');
      let strCentenas = Centenas(resto);
      if(strMiles == '')
        return strCentenas;
      return strMiles + ' ' + strCentenas;
    }//Miles()
    function Millones(num) {
      let divisor = 1000000;
      let cientos = Math.floor(num / divisor)
      let resto = num - (cientos * divisor)

      let strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE');
      let strMiles = Miles(resto);

      if(strMillones == '')
          return strMiles;

      return strMillones + ' ' + strMiles;
    }//Millones()
    return function NumeroALetras(num, currency) {
      currency = currency || {};
      let data = {
        numero: num,
        enteros: Math.floor(num),
        centavos: (((Math.round(num * 100)) - (Math.floor(num) * 100))),
        letrasCentavos: '',
          letrasMonedaPlural: currency.plural || 'PESOS CHILENOS',//'PESOS', 'Dólares', 'Bolívares', 'etcs'
          letrasMonedaSingular: currency.singular || 'PESO CHILENO', //'PESO', 'Dólar', 'Bolivar', 'etc'
          letrasMonedaCentavoPlural: currency.centPlural || 'CHIQUI PESOS CHILENOS',
          letrasMonedaCentavoSingular: currency.centSingular || 'CHIQUI PESO CHILENO'
        };
        if (data.centavos > 0) {
          data.letrasCentavos = 'CON ' + (function () {
            if (data.centavos == 1)
              return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoSingular;
            else
              return Millones(data.centavos) + ' ' + data.letrasMonedaCentavoPlural;
          })();
        };
        if(data.enteros == 0)
          return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
        if (data.enteros == 1)
          return Millones(data.enteros) + ' ' + data.letrasMonedaSingular + ' ' + data.letrasCentavos;
        else
          return Millones(data.enteros) + ' ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos;
    };
  })();
});