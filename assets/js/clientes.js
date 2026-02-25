$(function() {
  $("#listageneralClientes").dataTable({responsive: true});
  $(document).on('click', '.openModalAddCliente', function(event) {
    $("#openModalAddCliente").modal()
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
      $("#nombreCliente").after('<div class="text-center text-danger noNombreCliente">INGRESE UN NOMBRE</div>');
      setTimeout(function(){
        $(".noNombreCliente").remove()
      },2500);
    }else if (nombre.length>99) {
      $("#nombreCliente").after('<div class="text-center text-danger nombreClienteExcedido">NOMBRE MUY LARGO</div>');
      setTimeout(function(){
        $(".nombreClienteExcedido").remove()
      },2500);
    }else if (idCiudad==null) {
      $("#ciudadCliente").after('<div class="text-center text-danger noCiudadCliente">SELECCIONE CIUDAD</div>');
      setTimeout(function(){
        $(".noCiudadCliente").remove()
      },2500);
    }else if (telCliente=='') {
      $("#telefonoCliente").after('<div class="text-center text-danger noCellCliente">INGRESE TELÉFONO</div>');
      setTimeout(function(){
        $(".noCellCliente").remove()
      },2500);
    }else{
      $(".btnRegistrarNuevoCliente").addClass('d-none');
      $(".spinner").removeClass('d-none');
      $.ajax({
        url: 'do.php',
        type: 'POST',
        dataType: 'html',
        data: $("#formAddNuevoCliente").serialize(),
      })
      .done(function(data) {
        $(".btnRegistrarNuevoCliente").removeClass('d-none');
        $(".spinner").addClass('d-none');
        $("#openModalAddCliente").modal('hide');
        $(".respuesta").html(data);
      })
      return false;
    }    
    event.preventDefault();
  });
  $(document).on('click', '.openModaleditCliente', function(event) {
    let idCliente = $(this).attr("id");
    $("#openModaleditCliente").modal();
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
    var telefono  = $("#telefono_Cliente").val();
    if (nombre=='') {
      $("#nombre_Cliente").after('<div class="text-center text-danger noNombreClienteEdit">INGRESE NOMBRE</div>');
      setTimeout(function(){
        $(".noNombreClienteEdit").remove();
      },2500)
    }else if (telefono=='') {
      $("#telefono_Cliente").after('<div class="text-center text-danger noCellClienteEdit">INGRESE TELÉFONO</div>');
      setTimeout(function(){
        $(".noCellClienteEdit").remove();
      },2500)
    }else{
      $(".btnActualizarCliente").addClass('d-none');
      $(".spinner-ActualizarCliente").removeClass('d-none');
      $.ajax({
        url: 'do.php',
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
  $(document).on('click', '.tablaClientes', function(event) {
    var download= 'download';
    var ruta    = "BackupSQL/";
    $.ajax({
      url: 'downloadSQL.php',
      type: 'GET',
      dataType: 'html',
      data: {download},
      success:function(data){
        $(".respuesta").html(data)
      }
    })
    event.preventDefault();
  });
});