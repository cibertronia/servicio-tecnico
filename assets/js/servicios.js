$(function() {	
	var elementos 		= Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	elementos.forEach(function(data) {
	  var switchery = new Switchery(data,{size:'small',color: '#FBFAF9', secondaryColor: '#FBFAF9', jackColor: '#ff4341', jackSecondaryColor: '#1dc944'},);
	});
  $.ajax({
    url: 'includes/consultas.php',
    type: 'POST',
    dataType: 'json',
    data: {monedaPrincipal: ''},
    success:function(data){
      $("#monedaPrincipal").val(data.monedaP);
      $(".simboloMoneda").html(data.simbolo);
    }
  });
  $("#monedaPrincipal").change(function(event) {
    $("#monedaPrincipal option:selected").each(function(index, el) {
     var monedaPrincipal = $("#monedaPrincipal option:selected").val();
     $.ajax({
       url: 'puerta_ajax.php',
       type: 'POST',
       dataType: 'html',
       data: {action: 'cambiarMonedaPricipal',monedaPrincipal},
       success:function(data){
        $(".respuesta").html(data);
       }
     })
    });
  });
	$(".paginaRegistrar").change(function(){
		if ($(this).is(':checked')) {
			$(".spinner_paginaRegistrar").removeClass('d-none');
			$.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=HabilitarPaginaRegistro',
        success:function(data){
        	$(".spinner_paginaRegistrar").addClass('d-none');
          $(".respuesta").html(data);
        }
      })
		}else{
			$(".spinner_paginaRegistrar").removeClass('d-none');
			$.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=DeshabilitarPaginaRegistro',
        success:function(data){
        	$(".spinner_paginaRegistrar").addClass('d-none');
          $(".respuesta").html(data);
        }
      })
		}
	});
	$(".precioDolar").change(function(){
		if ($(this).is(':checked')) {
			$(".spinner_precioDolar").removeClass('d-none');
			$.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=HabilitarPrecioUSD',
        success:function(data){        	
        	$(".spinner_precioDolar").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
		}else{
			$(".spinner_precioDolar").removeClass('d-none');
			$.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=DeshabilitarPrecioUSD',
        success:function(data){
        	$(".spinner_precioDolar").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
		}
	})
  $(".proveedores").change(function(){
    if ($(this).is(':checked')) {
      $(".spinner_proveedores").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=HabilitarProveedores',
        success:function(data){
          $(".spinner_proveedores").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
    }else{
      $(".spinner_proveedores").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=DeshabilitarProveedores',
        success:function(data){
          $(".spinner_proveedores").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
    }
  })
  $(".categorias").change(function(){
    if ($(this).is(':checked')) {
      $(".spinner_categorias").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=HabilitarCategorias',
        success:function(data){
          $(".spinner_categorias").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
    }else{
      $(".spinner_categorias").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=DeshabilitarCategorias',
        success:function(data){
          $(".spinner_categorias").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
    }
  })
  $(".stock").change(function(){
    if ($(this).is(':checked')) {
      
      $(".spinner_stock").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=HabilitarStock',
        success:function(data){
          $(".cardStockFooter").removeClass('d-none');
          $(".spinner_stock").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
    }else{
      $(".cardStockFooter").addClass('d-none');
      $(".spinner_stock").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: 'action=DeshabilitarStock',
        success:function(data){
          $(".spinner_stock").addClass('d-none');
          $(".respuesta").html(data);            
        }
      })
    }
  })
});