$(function() {
  $(":input").inputmask();
  $("#listamisClientes").dataTable({responsive: true});
  $(document).on('click', '.openModalAddCliente', function(event) {
    $(".tooltip").hide();
    $("#openModalAddCliente").modal({backdrop: 'static', keyboard: false});
    event.preventDefault();
  });
  $(document).on('click', '.btnRegistrarNuevoCliente', function(event) {
    var nombre    = $("#nombreCliente").val();
    var idCiudad  = $("#ciudadCliente").val();
    var correo    = $("#correoCliente").val();
    var empresa   = $("#empresaCliente").val();
    var telEmpresa= $("#telefonoEmpresaCliente").val();
    var extEmpresa= $("#exttelefonoEmpresaCliente").val();
    var telCliente= $("#telefonoCliente").val();
    var idTelegram= $("#apiCliente").val();
    var direccion = $("#direccionCliente").val();
    var comentario= $("#comentariosCliente").val();    
    if (nombre=='') {
      $(".emptyNombreCliente").removeClass('d-none')
      setTimeout(function(){
        $(".emptyNombreCliente").addClass('d-none');
        $("#nombreCliente").focus()
      },2000);
    }else if (idCiudad==null) {
      $(".emptyCiudadCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCiudadCliente").addClass('d-none');
        $("#ciudadCliente").focus();
      },2000);
    }else if (correo!='' & $("#correoCliente").val().indexOf('@', 0) == -1 || $("#correoCliente").val().indexOf('.', 0) == -1) {      
      $(".correoNoValido").removeClass('d-none');
      setTimeout(function() {
        $(".correoNoValido").addClass('d-none');
      }, 2000);      
    }else if (extEmpresa !='' & telEmpresa == '') {
      $(".emptyTelefonoEmpresa").removeClass('d-none');
      setTimeout(function() {
        $(".emptyTelefonoEmpresa").addClass('d-none');
        $("#telefonoEmpresaCliente").focus();
      }, 2000);
    }else if (telCliente=='') {
      $(".emptyCelularCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCelularCliente").addClass('d-none');
        $("#telefonoCliente").focus()
      },2000);
    }else{
      $(".btnRegistrarNuevoCliente").addClass('d-none');
      $(".spinner-RegistrarNuevoCliente").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: $("#formAddNuevoCliente").serialize(),
      })
      .done(function(data) {
        $(".btnRegistrarNuevoCliente").removeClass('d-none');
        $(".spinner-RegistrarNuevoCliente").addClass('d-none');
        $("#openModalAddCliente").modal('hide');
        $(".respuesta").html(data);
      })
      return false;
    }    
    event.preventDefault();
  });
  $(document).on('click', '.openModaleditCliente', function(event) {
    $(".tooltip").hide();
    let idCliente = $(this).attr("id");
    $("#openModaleditCliente").modal({backdrop: 'static', keyboard: false});
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {editarClienteJSON: idCliente},
      success:function(data){
        $("#idClienteModalEdit").val(idCliente);
        $("#nombre_Cliente").val(data.nombre);
        $("#ciudad_Cliente").val(data.idCiudad);
        $("#correo_Cliente").val(data.correo);
        $("#empresa_Cliente").val(data.empresa);
        $("#telefono_EmpresaCliente").val(data.telEmpresa);
        $("#ext_telefonoEmpresaCliente").val(data.ext);
        $("#telefono_Cliente").val(data.celular);
        $("#api_Cliente").val(data.idTelegram);
        $("#direccion_Cliente").val(data.direccion);
        $("#comentarios_Cliente").val(data.comentarios);
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.btnActualizarCliente', function(event) {
    var nombre    = $("#nombre_Cliente").val();
    var correo    = $("#correo_Cliente").val();
    var telEmpresa= $("#telefono_EmpresaCliente").val();
    var extEmpresa= $("#exttele_fonoEmpresaCliente").val();
    var telefono  = $("#telefono_Cliente").val();
    if (nombre=='') {
      $(".emptyNombreCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyNombreCliente").addClass('d-none');
        $("#nombre_Cliente").focus();
      },2000)
    }/*else if (correo!='' & $("#correo_Cliente").val().indexOf('@', 0) == -1 || $("#correo_Cliente").val().indexOf('.', 0) == -1) {      
      $(".correoNoValido").removeClass('d-none');
      setTimeout(function() {
        $(".correoNoValido").addClass('d-none');
      }, 2000);      
    }*/else if (extEmpresa!='' & telEmpresa==''){
      $(".emptyTelefonoEmpresa").removeClass('d-none');
      setTimeout(function() {
        $(".emptyTelefonoEmpresa").addClass('d-none');
        $("#telefono_EmpresaCliente").focus();
      }, 2000);
    }else if (telefono=='') {
      $(".emptyCelularCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCelularCliente").addClass('d-none');
        $("#telefono_Cliente").focus();
      },2000)
    }else{
      $(".btnActualizarCliente").addClass('d-none');
      $(".spinner-ActualizarCliente").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: $("#formEditCliente").serialize(),
      })
      .done(function(data) {
        $(".btnActualizarCliente").removeClass('d-none');
        $(".spinner-ActualizarCliente").addClass('d-none');
        //$("#openModaleditCliente").modal('hide');
        $(".respuesta").html(data);
      })
      return false;
    }
    event.preventDefault();
  });
  $(document).on('click', '.openModalTeleGram', function(event) {
    $(".tooltip").hide();
    var idCliente = $(this).attr('id');
    $("#openModalTeleGram").modal({backdrop: 'static', keyboard: false});
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {obteneriDTelegramCliente: idCliente},
      success:function(data){
        $("#idUserAPI").val(idCliente);
        $("#telegramAPI").val(data.idTelegram);
      }
    })
    return false;
    event.preventDefault();
  });
  $(document).on('click', '.TeleSend', function(event) {
    var mensaje   = $("#mensajeTele").val();
    var idTelegram= $("#telegramAPI").val();
    if (mensaje=='') {
      $("#mensajeTele").after('<div class="mt-2 text-danger text-center emptyMensajeTele">MENSAJE VACÍO.</div>');
      setTimeout(function() {
        $(".emptyMensajeTele").remove()
      }, 2000);
    }else{
      $(".TeleSend").addClass('d-none');
      $(".spinner-TeleSend").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: $("#telesms").serialize(),
      })
      .done(function(data) {
        $(".TeleSend").removeClass('d-none');
        $(".spinner-TeleSend").addClass('d-none');
        setTimeout(function() {
          $("#openModalTeleGram").modal('hide');
          $(".respuesta").html(data);
        }, 500);
      })
      return false;
    }
    event.preventDefault();    
  });
  //Funciones en vivo
  function contador(input,maximo){
    function actualizarContador(input){
      var caracteres = $(input).val().length;
      if (caracteres > maximo) {
        $(input).attr('disabled', true);
        if (input == "#nombreCliente" || input == "#nombre_Cliente" ) {
          $(".limiteNombreExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteNombreExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
          }, 1500);
        }else if (input == "#empresaCliente" || input == "#empresa_Cliente" ) {
          $(".limiteNombreEmpresaExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteNombreEmpresaExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
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
  contador("#nombre_Cliente",20); contador("#nombreCliente",20); contador("#empresaCliente",25); contador("#empresa_Cliente",25);
});