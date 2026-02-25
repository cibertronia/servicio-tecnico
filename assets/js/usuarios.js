$(function() {
  $(":input").inputmask();
  $('#listaUsuarios').dataTable({
    responsive: true,
    //order:false
  });
  $(document).on('click', '.openModaladdUsuario', function(event) {
    $("#nombreUsuario").val('');
    $("#sexoUsuario").val(0);
    $("#cargoUsuario").val('');
    $("#correoUsuario").val('');
    $("#telefonoUsuario").val('');
    $("#idTelegram").val('');
    $("#sucursalUsuario").val(0);
    $("#rangoUsuario").val(0);
    $("#openModaladdUsuario").modal({backdrop: 'static', keyboard: false});
    event.preventDefault();
  });
  $(document).on('click', '.regNewUser', function(event) {    
    var nombre    = $("#nombreUsuario").val();
    var sexo      = $("#sexoUsuario").val();
    var cargo     = $("#cargoUsuario").val();
    var correo    = $("#correoUsuario").val();
    var telefono  = $("#telefonoUsuario").val();
    var apitele   = $("#idTelegram").val();
    var sucursal  = $("#sucursalUsuario").val();
    var rango     = $("#rangoUsuario").val();
    if (nombre=='') {
      $(".emptyNombreCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyNombreCliente").addClass('d-none');
        $("#nombreUsuario").focus();
      },1500);
    }else if (sexo==null) {
      $(".noOptionSexo").removeClass('d-none');
      setTimeout(function(){
        $(".noOptionSexo").addClass('d-none');
        $("#sexoUsuario").focus();
      },1500);
    }else if (cargo=='') {
      $(".emptyCargoUsuario").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCargoUsuario").addClass('d-none');
        $("#cargoUsuario").focus();
      },1500);
    }else if (correo=='') {
      $(".emptyCorreoUsuario").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCorreoUsuario").addClass('d-none');
        $("#correoUsuario").focus();
      },1500);
    }else if (telefono=='') {
      $(".emptyTelefonoCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyTelefonoCliente").addClass('d-none');
        $("#telefonoUsuario").focus();
      },1500);
    }else if (sucursal==null) {
      $(".noSelectSucursal").removeClass('d-none');
      setTimeout(function(){
        $(".noSelectSucursal").addClass('d-none');
        $("#sucursalUsuario").focus();
      },1500);
    }else if (rango==null) {
      $(".noSelectRango").removeClass('d-none');
      setTimeout(function(){
        $(".noSelectRango").addClass('d-none');
        $("#rangoUsuario").focus();
      },1500);
    }else{
      $(".regNewUser").addClass('d-none');
      $(".spinner-regNewUser").removeClass('d-none');
      $("#openModaladdUsuario").modal('hide');
      $.ajax({
        url: 'do.php',
        type: 'POST',
        dataType: 'html',
        data: $("#registrarnuevoUsuario").serialize(),
      })
      Swal.fire({
        position:'center',
        icon: 'info',
        title: 'Cuenta creada.',
        html: 'La nueva cuenta fué creada correctamente.<br>Se le envió un correo al usuario con sus datos de acceso.',
        showConfirmButton: false,
      })
      setTimeout(function() {
        
        location.reload();
      }, 3000)


      .done(function(data) {
        $(".regNewUser").removeClass('d-none');
        $(".spinner-regNewUser").addClass('d-none');
        $(".respuesta").html(data);
      })

    }
    event.preventDefault();
  });
  $(document).on('click', '.activarCuentaUsuario', function(event) {
    var idUser = $(this).attr('id');
    var swalWithBootstrapButtons = Swal.mixin({
      customClass:{
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-danger mr-2",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
    .fire({
      title: "Activar cuenta?",
      text: "Esta acción, activara la cuenta del usuario registrado, si no la activas, no podrá ingresar al sistema.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, Activar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
    })
    .then(function(result){
      if (result.value){
        $.ajax({
          url: 'do.php',
          type: 'POST',
          dataType: 'html',
          data: "action=HabilitarCuentaUsuario&idUser="+idUser,
          success:function(data){
            $(".respuesta").html(data);
          }
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "La couenta ya no será activada.",
          "error"
        );
      }
    });
    return false;
    event.preventDefault();
  });
  $(document).on('click', '.openModalCancelarCuentaUsuario', function(event) {
    var idUser = $(this).attr('id');
    $("#openModalCancelarUsuario").modal();
    $("#idUserModalCancelarUsuario").val(idUser);
    event.preventDefault();
  });
  $(document).on('click', '.btnCancelarCuenta', function(event) {
    var razon = $("#razonCancelarUsuario").val();
    if (razon=='') {
      $("#razonCancelarUsuario").after('<div class="mt-2 text-center text-danger noRazonCancelar">DESCRIBA LA RAZÓN</div>');
      setTimeout(function() {
        $(".noRazonCancelar").remove();
      }, 2500);
    }else{
      $(".btnCancelarCuenta").addClass('d-none');
      $(".spinner").removeClass('d-none');
      $.ajax({
        url: 'do.php',
        type: 'POST',
        dataType: 'html',
        data: $("#cancelarCuentaUsuario").serialize(),
      })
      .done(function(data) {
        $(".respuesta").html(data);
        $("#openModalCancelarUsuario").modal('hide');
        $(".btnCancelarCuenta").removeClass('d-none');
        $(".spinner").addClass('d-none');
      })
      return false;
    }
    event.preventDefault();
  });
  $(document).on('click', '.openModalTelegram', function(event) {
    $("#modalTeleGram").modal();
    var idUsuario = $(this).attr("id");
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {obteneriDTelegram: idUsuario},
      success:function(data){
        $("#idTelegram_modal").val(data.idTelegram);
        $("#idUser_modalTele").val(idUsuario);
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.TeleSend', function(event) {
    var mensaje = $("#mensajeTele").val();
    if (mensaje=='') {
      $("#mensajeTele").after('<div class="text-center text-danger noMessage">INGRESE UN MENSAJE</div>');
      setTimeout(function(){
        $(".noMessage").remove();
      },2500)
    }else{
      $(".TeleSend").addClass('d-none');
      $(".spinner").removeClass('d-none');
      $.ajax({
        url: 'do.php',
        type: 'POST',
        dataType: 'html',
        data: $("#telesms").serialize(),
      })
      .done(function(data) {
        $(".TeleSend").removeClass('d-none');
        $(".spinner").addClass('d-none');
        $("#modalTeleGram").modal('hide');
        $(".respuesta").html(data);
      })
    }
    event.preventDefault();
  });
  $(document).on('click', '.updateUsuario', function(event) {
    alert("esta acción esta pendiente de trabajar")
    event.preventDefault();
  });
  $(document).on('click', '.openModaleditUsuario', function(event) {
    $("#EditUser_modal").modal({backdrop: 'static', keyboard: false});
    var idUsuario = $(this).attr("id");
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {editarUsuarioJSON: idUsuario},
      success:function(data){
        $("#idUser_modal_editUser").val(idUsuario);
        $("#nombre_Usuario").val(data.Nombre);
        $("#sexo_Usuario").val(data.idSexo);
        $("#cargo_Usuario").val(data.cargo);
        $("#correo_Usuario").val(data.correo);
        $("#telefono_Usuario").val(data.telefono);
        $("#sucursal_Usuario").val(data.idTienda);
        $("#id_Telegram").val(data.idTelegram);
        $("#rango_Usuario").val(data.idRango);        
      }
    })
    event.preventDefault();
  });  
  $(document).on('click', '.btnUpdateUser', function(event) {    
    var nombre  = $("#nombre_Usuario").val();
    var cargo   = $("#cargo_Usuario").val();
    var correo  = $("#correo_Usuario").val();
    var telefono= $("#telefono_Usuario").val();
    var idTeleG = $("#id_Telegram").val();
    var sucursal= $("#sucursal_Usuario").val();
    var idRango = $("#rango_Usuario").val();
    if (nombre=='') {
      $(".emptyNombreCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyNombreCliente").addClass('d-none');
        $("#nombre_Usuario").focus();
      },1500);
    }else if (cargo=='') {
      $(".emptyCargoUsuario").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCargoUsuario").addClass('d-none');
        $("#cargo_Usuario").focus();
      },1500);
    }else if (correo=='') {
      $(".emptyCorreoUsuario").removeClass('d-none');
      setTimeout(function(){
        $(".emptyCorreoUsuario").addClass('d-none');
        $("#correo_Usuario").focus();
      },1500);
    }else if (telefono=='') {
      $(".emptyTelefonoCliente").removeClass('d-none');
      setTimeout(function(){
        $(".emptyTelefonoCliente").addClass('d-none');
        $("#telefono_Usuario").focus();
      },1500);
    }else{
      $(".btnUpdateUser").addClass('d-none');
      $(".spinner-btnUpdateUser").removeClass('d-none');
      $.ajax({
        url: 'do.php',
        type: 'POST',
        dataType: 'html',
        data: $("#actualizarUsuario").serialize(),
      })
      .done(function(data) {
        $(".btnUpdateUser").removeClass('d-none');
        $(".spinner-btnUpdateUser").addClass('d-none');
        //$("#EditUser_modal").modal("hide");
        $(".respuesta").html(data);
      })
    }
    event.preventDefault();
  });
  $(document).on('click', '.btnEnabledRegistrar', function(event) {
    var swalWithBootstrapButtons = Swal.mixin({
      customClass:{
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-danger mr-2",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro?",
      text: "Con esta acción, volveras a habilitar la página de registro, la cúal, permitirá el registro a cualquier usuario que vea el formulario.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, habilitar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
    })
    .then(function(result){
      if (result.value){
        $.ajax({
          url: 'do.php',
          type: 'POST',
          dataType: 'html',
          data: 'action=HabilitarPaginaRegistro',
          success:function(data){
            $(".respuesta").html(data);            
          }
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "La página de registro ya no se habilitará.",
          "error"
        );
      }
    });
    event.preventDefault();
  });
  $(document).on('click', '.btnDisabledRegistrar', function(event) {
    var swalWithBootstrapButtons = Swal.mixin({
      customClass:{
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-danger mr-2",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro?",
      text: "Con esta acción, deshabilitaras la página de registro y ya no será visible para nadie.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, Deshabilitar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
    })
    .then(function(result){
      if (result.value){
        $.ajax({
          url: 'do.php',
          type: 'POST',
          dataType: 'html',
          data: 'action=DeshabilitarPaginaRegistro',
          success:function(data){
            $(".respuesta").html(data);            
          }
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "La página de registro ya no se deshabilitará.",
          "error"
        );
      }
    });
    event.preventDefault();
  });
  $(document).on('click', '.btnDisabledPrecioUSD', function(event) {
    var swalWithBootstrapButtons = Swal.mixin({
      customClass:{
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-danger mr-2",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro?",
      text: "Con esta acción, deshabilitaras el precio USD.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, Deshabilitar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
    })
    .then(function(result){
      if (result.value){
        $.ajax({
          url: 'do.php',
          type: 'POST',
          dataType: 'html',
          data: 'action=DeshabilitarPrecioUSD',
          success:function(data){
            $(".respuesta").html(data);            
          }
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "El precio USD ya no se deshabilitará.",
          "error"
        );
      }
    });
    event.preventDefault();
  });
  $(document).on('click', '.btnEnabledPrecioUSD', function(event) {
    var swalWithBootstrapButtons = Swal.mixin({
      customClass:{
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-danger mr-2",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
    .fire({
      title: "¿Estás seguro?",
      text: "Con esta acción, habilitaras el precio USD.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, Habilitar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
    })
    .then(function(result){
      if (result.value){
        $.ajax({
          url: 'do.php',
          type: 'POST',
          dataType: 'html',
          data: 'action=HabilitarPrecioUSD',
          success:function(data){
            $(".respuesta").html(data);            
          }
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "El precio USD ya no se habilitará.",
          "error"
        );
      }
    });
    event.preventDefault();
  });
  function contador(input,maximo){
    function actualizarContador(input){
      var caracteres = $(input).val().length;
      if (caracteres > maximo) {
        $(input).attr('disabled', true);
        if (input == "#nombreUsuario" || input == "#nombre_Usuario" ) {
          $(".limiteNombreExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteNombreExcedido").addClass('d-none');
            $(input).attr('disabled', false);
            var contendio = $(input).val();
            var nuevoCont = contendio.slice(0, -1);
            $(input).val(nuevoCont)
          }, 1000);
        }else if (input == "#cargoUsuario" || input == "#cargo_Usuario" ) {
          $(".limiteCodigoExcedido").removeClass('d-none');
          setTimeout(function() {
            $(".limiteCargoExcedido").addClass('d-none');
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
  contador("#nombreUsuario",30); contador("#nombre_Usuario",30); contador("#cargoUsuario",15); contador("#cargo_Usuario",15);
});