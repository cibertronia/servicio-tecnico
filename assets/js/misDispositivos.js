$(function() {
  $(document).on('click', '.nuevoCliente', function(event) {
    location.replace("/?root=misclientes");
    event.preventDefault();
  });
  var idUser = $("#idUser").val();
  var idRango= $("#idRango").val();
  $("#listamisDispositivos").dataTable({responsive: true});
  $('#ClientesModal').select2({dropdownParent: $('#AddDevice')});
  $(document).on('click', '.findDataDevice', function() {
    $(".dataDispo").html("");
    $(".dataDispo").html("");
    $('#nameDispositivo').val("");
    $('#modeloDispositivo').val("");
    $('#colorDispositivo').val("");
    $('#capacidadDispositivo').val("");
    var IMEI = $("#imeiDispositivo").val();
    var idUser= $(this).attr('id');
    if (IMEI=='') {
      $("#imeiDispositivo").after('<div class="text-center text-danger noIMEI">CAMPO VACÍO.</div>');
      setTimeout(function(){
        $(".noIMEI").remove()
      },2500);
    }else{
      $(".findDataDevice").addClass('d-none');
      $(".automatico").removeClass('d-none');
      $(".autoIMEI").removeClass('d-none');
      $.ajax({
        url: 'includes/consultas.php',
        type: 'POST',
        dataType: 'json',
        data: {IMEI, idUser},
        success:function(data){
          if (data==0) {
            $("#imeiDispositivo").after('<div class="text-center text-danger sinSaldo">SALDO INSUFICIENTE</div>');
            setTimeout(function(){
              $(".sinSaldo").remove();
            },2500);
            $(".findDataDevice").removeClass('d-none');
            $(".automatico").addClass('d-none');
            $(".autoIMEI").addClass('d-none');
            $(".tooltip").tooltip("hide");
            return false;
          }
          $(".findDataDevice").removeClass('d-none');
          $(".automatico").addClass('d-none');
          $(".autoIMEI").addClass('d-none');
          if (data.status === true) {
            $(".showDispo").removeClass('d-none');
            $(".dataDispo").html(data.descrip);
            $('#nameDispositivo').val(data.dispo);
            $('#modeloDispositivo').val(data.model);
            $('#colorDispositivo').val(data.color);
            $('#capacidadDispositivo').val(data.capac);
            $(".miSaldo").html("$ "+data.saldo);
            $(".dataDispo").after("<div class='text-center text-danger infoSaldo' style='font-size:20px'>Tu nuevo saldo es de:<br>$ <b>"+data.saldo+"</b></div>");
            setTimeout(function(){
              $(".infoSaldo").remove();
            },2500)
          }else{
            $("#imeiDispositivo").after('<div class="errorData text-danger text-center">'+data.error+'</div>');
            setTimeout(function(){
              $(".errorData").remove()
            },2000);
          }
        }
      });
    }
  });
  $(document).on('click', '.checkFMI', function(event) {
    var imei  = $(this).attr('id');
    var idUser= $("#idUser").val();
    var swalWithBootstrapButtons = Swal.mixin({
      customClass:{
        confirmButton: "btn btn-primary",
        cancelButton: "btn btn-danger mr-4",
      },
      buttonsStyling: false,
    });
    swalWithBootstrapButtons
    .fire({
      title: "Estás seguro?",
      text: "Si continuas se te descontarán $ 0.10 de tu cuenta para verificar el Check Status.",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Sí, continuar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true
    })
    .then(function(result){
      if (result.value){
        $.ajax({
          url: 'includes/consultas.php',
          type: 'POST',
          dataType: 'json',
          data: {checkStatus: imei,idUser},
          success:function(data){
            if (data.saldo<0.10) {
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'No posees suficiente saldo para esta operación.',
                showConfirmButton: false,
                timer: 2500
              })
            }else if (data.error=='0') {
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'No hay conexión en este momento',
                showConfirmButton: false,
                timer: 2500
              })
            }else if (data.error=='Invalid IMEI/Serial Number') {
              Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'El IMEI/Serial No es válido',
                showConfirmButton: false,
                timer: 2500
              })
            }else{
              $(".miSaldo").html("$ "+data.saldoActual);
              if (data.fmiON!=false) {
                Swal.fire({
                  position: 'center',
                  icon: 'error',
                  title: 'Check Status ON' ,
                  text: 'El Dispositivo con el IMEI/Serial '+data.imei+' aún se encuentra activo' ,
                  showConfirmButton: false,
                  timer: 3500
                })
              }else{
                $(".checkFMI").removeClass('btn-danger').html('OFF');
                $(".fmiCheck").removeClass('bg-danger-500');
                $(".checkFMI").addClass('btn-success');
                $(".fmiCheck").addClass('bg-success-500');
                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Check Status OFF' ,
                  text: 'El Dispositivo con el IMEI/Serial '+data.imei+' ya está OFF' ,
                  showConfirmButton: false,
                })
                setTimeout(function(){
                  location.reload()
                },3500)
              }
              /*Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Obtuvimos los iguientes datos: \nSaldo: '+data.saldo+'\nDatos: ' +data.fmiON,
                showConfirmButton: false,
                timer: 2500
              })*/
            }
          }
        })
      }else if (result.dismiss === Swal.DismissReason.cancel){
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "El check status ya no será procesado.",
          "error"
        );
      }
    });
    event.preventDefault();
  });
  $.ajax({
    url: 'includes/consultas.php',
    type: 'POST',
    dataType: 'html',
    data: {ListarmisClientesUSER: idUser, idRango},
    success:function(data){
      $("#ClientesModal").html(data);
    }
  })
  $(document).on('click', '.listarTelefonos', function(event) {
    var idDispositivo = $(this).attr("id");
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'html',
      data: {motrarTelDispoID: idDispositivo},
      success:function(data){
        $("#modal_listarTelefonos").modal();
        $(".response").html(data);
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.listarCorreos', function(event) {
    var idDispositivo = $(this).attr("id");
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'html',
      data: {mostrarCorreosDispoID: idDispositivo},
      success:function(data){
        $("#modal_listarCorreos").modal();
        $(".response_m").html(data);
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.modal_editDispoName', function(event) {
    $("#modal_editDispoName").modal();
    var idDispo = $(this).attr("id");
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {mostrarDispositivosID: idDispo},
      success:function(data){
        $("#idDispositivo").val(idDispo);
        $("#nameDispo").val(data.Nombre);
        $("#modeloDispo").val(data.Modelo);
        $("#colorDispo").val(data.Color);
        $("#capacidadDispo").val(data.Capacidad);
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.upDispo', function(event) {
    var nombre    = $("#nameDispo").val()
    var modelo    = $("#modeloDispo").val();
    var color     = $("#colorDispo").val();
    var capacidad = $("#capacidadDispo").val();
    if (nombre=='') {
      $("#nameDispo").after('<div class="text-center text-danger noNameDispo">NOMBRE</div>');
      setTimeout(function(){
        $(".noNameDisp").remove();
        $("#nameDispo").focus();
      },2500)
    }else if (modelo=='') {
      $("#modeloDispo").after('<div class="text-center text-danger noMoodeloDispo">MODELO</div>');
      setTimeout(function(){
        $(".noMoodeloDispo").remove();
        $("#modeloDispo").focus();
      },2500)
    }else if (color=='') {
      $("#colorDispo").after('<div class="text-center text-danger noColorDispo">COLOR</div>');
      setTimeout(function(){
        $(".noColorDispo").remove();
        $("#colorDispo").focus();
      },2500)
    }else if (capacidad=='') {
      $("#capacidadDispo").after('<div class="text-center text-danger noCapaDispo">CAPACIDAD</div>');
      setTimeout(function(){
        $(".noCapaDispo").remove();
        $("#capacidadDispo").focus();
      },2500)
    }else{
      $(".upDispo").addClass('d-none');
      $(".up_Dispo").removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: $("#infoDispo").serialize(),
        success:function(data){
          $(".upDispo").removeClass('d-none');
          $(".up_Dispo").addClass('d-none');
          if (data=='0') {
            $(".upDispo").addClass('d-none');
            $(".btn-upDispo").before("<div class='row mt-3 showbtn-Dispo'><div class='col'><div class='alert alert-danger' role='alert'>No hay cambios que guardar.</div></div></div>");
            setTimeout(function(){
              $(".upDispo").removeClass('d-none');
              $(".showbtn-Dispo").remove();
            },2500)
          }else{
            $("#modal_editDispoName").modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Dispositivo actualizado',
              showConfirmButton: false,
              timer: 2500
            })
            $("#respuesta").html(data);
          }
        }
      })
    }
    event.preventDefault();
  });
  $(document).on('click', '.modal_newDispositivo', function(event) {
    event.preventDefault();
    $("#AddDevice").modal()
  });
  var i=1;
  $(document).on('click', '.masCampos', function(event) {
    event.preventDefault();
    i++;
    $(".datosTelefonicos").append('<div class="row mt-2 mb-2" id="row'+i+'">'+
      '<div class="col-2">'+
        '<input type="text" name="code[]" class="form-control">'+
      '</div>'+
      '<div class="col-4">'+
        '<input type="text" name="telefono[]" class="form-control">'+
      '</div>'+
      '<div class="col-5">'+
        '<input type="text" name="origen[]" class="form-control">'+
      '</div>'+
      '<div class="col-1">'+
        '<button id='+i+' class="btn btn-danger btn-sm btn-icon rounded-circle menosCampos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Remover campo"><i class="far fa-minus-circle"></i></button>'+
      '</div></div>');
  });
  $(document).on('click', '.otroCampo', function(event) {
    var idDispo = $(this).attr('id');
    i++;
    $(".aviso"+idDispo).after(' <div class="row mt-2 mb-2" id="row'+i+'">'+
      '<div class="col-2">'+
        '<input type="text" name="code[]" class="form-control">'+
      '</div>'+
      '<div class="col-4">'+
        '<input type="text" name="telefono[]" class="form-control">'+
      '</div>'+
      '<div class="col-5">'+
        '<input type="text" name="origen[]" class="form-control">'+
      '</div>'+
      '<div class="col-1">'+
        '<button id='+i+' class="btn btn-danger btn-sm btn-icon rounded-circle menos__Campos campo'+idDispo+'" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Remover campo"><i class="far fa-minus-circle"></i></button>'+
      '</div></div>');
    event.preventDefault();
  });
  $(document).on('click', '.menos__Campos', function(event) {
    var id      = $(this).attr('id');
    $("#row"+id).remove();

    event.preventDefault();
  });
  $(document).on('click', '.mas_Campos', function(event) {
    event.preventDefault();
    i++;
    $(".correos").append('<div class="row mt-2 mb-2" id="row'+i+'">'+
      '<div class="col-6">'+
        '<input type="email" name="correo[]" id="correoDispositivo" class=" form-control">'+
      '</div>'+
      '<div class="col-5">'+
        '<input type="text" name="origencorreo[]" id="origenCorreo" class=" form-control">'+
      '</div>'+
      '<div class="col-1">'+
        '<button id='+i+' class="btn btn-danger btn-sm btn-icon rounded-circle menos_Campos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Remover campo"><i class="far fa-minus-circle"></i></button>'+
      '</div></div>');
  });
  $(document).on('click', '.menosCampos', function(event) {
    event.preventDefault();
    var id = $(this).attr("id");
    var row= $("#row"+id);
    row.remove();
  });
  $(document).on('click', '.menos_Campos', function(event) {
    event.preventDefault();
    var id = $(this).attr("id");
    var row= $("#row"+id);
    row.remove();
  });
  $(document).on('click', '.goBack2', function(event) {
    $(".area3").addClass('d-none')
    $(".area2").removeClass('d-none');
    $(".area1").removeClass('d-none');
    event.preventDefault();
  });
  $(document).on('click', '.nextArea3', function(event) {
    var idCliente   = $("#ClientesModal option:selected").val();
    var imeiSerial  = $("#imeiDispositivo").val();
    var dispositivo = $("#nameDispositivo").val();
    var modelo      = $("#modeloDispositivo").val();
    var color       = $("#colorDispositivo").val();
    var capacidad   = $("#capacidadDispositivo").val();
    var pin         = $("#pinDispositivo option:selected").val();
    var idioma      = $("#idiomaDispositivo option:selected").val();
    if (idCliente=='0') {
      $("#ClientesModal").after('<div class="text-center text-danger noIDCliente">SELECCIONE CLIENTE</div>');
      setTimeout(function(){
        $(".noIDCliente").remove();
      },2500);
    }else if (imeiSerial=='') {
      $("#imeiDispositivo").after('<div class="text-center text-danger noIMEISerial">INGRESE IMEI</div>');
      setTimeout(function(){
        $(".noIMEISerial").remove();
      },2500);
    }else if (dispositivo=='') {
      $("#nameDispositivo").after('<div class="text-center text-danger noDispoName">INGRESE DISPOSITIVO</div>');
      setTimeout(function(){
        $(".noDispoName").remove();
      },2500);
    }else if (modelo=='') {
      $("#modeloDispositivo").after('<div class="text-center text-danger noModeloName">INGRESE MODELO</div>');
      setTimeout(function(){
        $(".noModeloName").remove();
      },2500);
    }else if (color=='') {
      $("#colorDispositivo").after('<div class="text-center text-danger noColorName">INGRESE COLOR</div>');
      setTimeout(function(){
        $(".noColorName").remove();
      },2500);
    }else if (capacidad=='') {
      $("#capacidadDispositivo").after('<div class="text-center text-danger noCapacidadName">INGRESE CAPACIDAD</div>');
      setTimeout(function(){
        $(".noCapacidadName").remove();
      },2500);
    }else if (pin=='Seleccione PIN') {
      $("#pinDispositivo").after('<div class="text-center text-danger noPINDevice">SELECCIONE PIN</div>');
      setTimeout(function(){
        $(".noPINDevice").remove();
      },2500);
    }else if (idioma=='Seleccione idioma') {
      $("#idiomaDispositivo").after('<div class="text-center text-danger noLangDevice">SELECCIONE IDIOMA</div>');
      setTimeout(function(){
        $(".noLangDevice").remove();
      },2500);
    }else{
      $(".area1").addClass('d-none');
      $(".area2").addClass('d-none');
      $(".area3").removeClass('d-none');
    }
    event.preventDefault();
  });
  $(document).on('click', '.guardaDotosDispo', function(event) {
    $(".guardaDotosDispo").addClass('d-none');
    $(".spinner").removeClass('d-none');
    $.ajax({
      url: 'puerta_ajax.php',
      type: 'POST',
      dataType: 'html',
      data: $("#datosDispositivo").serialize(),
    })
    .done(function(data) {
      $(".guardaDotosDispo").removeClass('d-none');
      $(".spinner").addClass('d-none');
      $("#AddDevice").modal("hide");
      $(".respuesta").html(data);
    })
    event.preventDefault();
  });
  $("#SelectScript").change(function() {
    $("#SelectScript option:selected").each(function() {
      var option = $(this).val();
      var idDispo= $("#idDispoModalSMS").val();
      if (option!='') {
        $(".showAfterSelect").removeClass('d-none');
        $.ajax({
          url: 'includes/consultas.php',
          type: 'POST',
          dataType: 'html',
          data: {showOptionMessage: option, idDispo},
          success:function(data){
            
          }
        })
      }
    });
  });
  $(document).on('click', '.editTelefono', function(event) {
    var idTelefono  = $(this).attr('id');
    var pais        = $("#pais"+idTelefono).val();
    var telefono    = $("#telefono"+idTelefono).val();
    var origen      = $("#origen"+idTelefono).val();
    if (pais=='') {
      $("#pais"+idTelefono).after('<div class="text-center text-danger noCountry"><b>País</b></div>');
      setTimeout(function(){
        $(".noCountry").remove();
      },1500);
    }else if (telefono=='') {
      $("#telefono"+idTelefono).after('<div class="text-center text-danger noPhone"><b>Teléfono</b></div>');
      setTimeout(function(){
        $(".noPhone").remove();
      },1500);
    }else if (origen=='') {
      $("#origen"+idTelefono).after('<div class="text-center text-danger noOrigen"><b>Origen</b></div>');
      setTimeout(function(){
        $(".noOrigen").remove();
      },1500);
    }else{
      $(".btn-tel"+idTelefono).addClass('d-none');
      $(".edit"+idTelefono).removeClass('d-none');
      $.ajax({
        url: 'puerta_ajax.php',
        type: 'POST',
        dataType: 'html',
        data: "action=UpPhoneDispo&idTelefono="+idTelefono+"&pais="+pais+"&telefono="+telefono+"&origen="+origen,
        success:function(data){         
          setTimeout(function(){
            $(".btn-tel"+idTelefono).removeClass('d-none');
            $(".edit"+idTelefono).addClass('d-none');
            $(".aviso"+idTelefono).after('<div class="row mt-3 updOK"><div class="col text-center text-primary"><b>DATOS ACTUALIZADOS</b></div></div>');
            setTimeout(function(){
              $(".updOK").remove();
            },2000);
          },1000);          
        }
      });
    }
    event.preventDefault();
  });
  $(document).on('click', '.modalCorreo', function(event) {
    var idDispositivo=$(this).attr('id');
    $("#modal_byMail").modal();
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'json',
      data: {mostrar_CorreosDispoID: idDispositivo},
      success:function(data){
        $("#MailClienteDispo").html(data.Correo)
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.modalSMS', function(event) {
    var idDispositivo   = $(this).attr("id");
    $("#modal_bySMS").modal();
    $("#idDispoModalSMS").val(idDispositivo);
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'html',
      data: {showPhoneDevices: idDispositivo},
      success:function(data){
        $("#SelectPhoneNumbers").html(data)
      }
    })
    event.preventDefault();
  });
  $(document).on('click', '.sendSMSModal', function(event) {
    $(".sendSMSModal").addClass("d-none");
    $(".btnSendSMS").removeClass('d-none')
    event.preventDefault();
  });
  $(document).on('click', '.btn-plus_m', function(event) {
    var idDispositivo = $(this).attr('id');
    $(".btn_plus_m").addClass('d-none');
    $(".aviso_m"+idDispositivo).removeClass('d-none');
    event.preventDefault();
  });
});