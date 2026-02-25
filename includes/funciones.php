<?php

error_reporting(0);
function redimensionar($src, $ancho_forzado)
{
  if (file_exists($src)) {
    list($width, $height, $type, $attr) = getimagesize($src);
    if ($ancho_forzado > $width) {
      $max_width = $width;
    } else {
      $max_width = $ancho_forzado;
    }
    $proporcion = $width / $max_width;
    if ($proporcion == 0) {
      return -1;
    }
    $height_dyn = $height / $proporcion;
  } else {
    return -1;
  }
  return array($max_width, $height_dyn);
}
function mesesSpanish($fechas)
{
  $meses          =   array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $diaNumero      =   date('d');
  $mes            =   $meses[date('n') - 1];
  $mesNumero      =   date('m');
  $Year           =   date('Y');
  $fechas         =   $diaNumero . " de " . $mes . " de " . $Year;
  return $fechas;
}
function fechaFormato($fechas)
{
  $newFecha = date("d-m-Y", strtotime($fechas));
  return $newFecha;
}
function formatoHora($hora)
{
  $newHora = date('g:i a', strtotime($hora));
  return $newHora;
}
//ALERTAS
function alert_imagenProductoActualizado()
{ ?>
  <script type="text/javascript">
    $("#openModalEditImagen").modal('hide');
    Swal.fire({
      position: 'center',
      icon: 'primary',
      title: 'Imagen Actualizada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2000);
  </script><?php
          }
          function alert_plantillaHTMLactualizada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Plantilla Actualizada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2000);
  </script><?php
          }
          function alert_plantillaHTMLcreada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Plantilla Creada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2000);
  </script><?php
          }
          function alert_imagenPerfilCargado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Imagen cargada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 100);
  </script><?php
          }
          function alert_sesionCaducada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Tu sesión ha expirado.',
      //text: 'La sesión no existe o ya caducó.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_nombreIMG_espaciosenblanco()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Nombre imagen error!',
      html: 'El nombre de la imagen contine espacios en blanco<br>Cambie el nombre de la imagen y asegurese que este no contenga espacion en blanco, ni caracteres especiales.',
      showConfirmButton: true,
    })
  </script><?php
          }
          function alert_nombreIMG_yaexiste()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Nombre imagen error!',
      html: 'El nombre de la imagen ya existe en los registros del sistema.<br>Cambie el nombre a su imagen y vuelva a intentar.',
      showConfirmButton: true,
    });
    //return false;
  </script><?php
          }
          function alert_sinAutorizacion()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Sin Autorización.',
      text: 'No cuentas con los permisos necesarios para realizar esta acción.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_cotizacionGuardada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cotización guardada.',
      html: 'Los datos de la cotización han sido guardados correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.replace('?root=generadas');
    }, 2500);
  </script><?php
          }
          function alert_peticionDesconocida()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Peticion desconocida.',
      text: 'La petición que intentas hacer no existe o está deshabilitda.',
      showConfirmButton: false,
    })
  </script><?php
          }
          function alert_usuarioNoExiste()
          { ?>
  <script type="text/javascript">
    $("#emailuser").after('<div class="mt-2 text-center text-danger usuarioLoginNoExiste">EL USUARIO NO EXISTE</div>');
    setTimeout(function() {
      $(".usuarioLoginNoExiste").remove()
    }, 2500);
  </script><?php
          }
          function alert_noCambiosUsuarioEdit()
          { ?>
  <script type="text/javascript">
    $(".btnUpdateUser").before('<div class="mt-2 text-center text-danger noCambiosUsuarioEdit">NO HAY CAMBIOS QUE GUARDAR</div>');
    setTimeout(function() {
      $(".noCambiosUsuarioEdit").remove()
    }, 3000);
  </script><?php
          }
          function alert_noCambiosSucursalEdit()
          { ?>
  <script type="text/javascript">
    $(".btnActualizarSucursal").before('<div class="my-2 text-center text-danger noCambiosSucursalEdit">NO HAY CAMBIOS QUE GUARDAR</div>');
    setTimeout(function() {
      $(".noCambiosSucursalEdit").remove()
    }, 3000);
  </script><?php
          }
          function alert_sucursalEditActualizada()
          { ?>
  <script type="text/javascript">
    $("#openModaleditSucursal").modal('hide');
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Sucursal actualizada.',
      text: 'Los datos de la sucursal se actualizaron correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_cotizacionBorrada()
          { ?>
  <script type="text/javascript">
    $(".tooltip").hide();
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cotización borrada',
      text: 'La cotización seleccionada ha sido borrada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_productoCargado()
          { ?>
  <script type="text/javascript">
    $("#openModaleditSucursal").modal('hide');
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Producto cargado.',
      text: 'Los datos del producto se guardaron correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_productoActualizadoOK($ok = true)
          {
          
          
if ($ok)
  echo ("        
  <script type=\"text/javascript\">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Producto actualizado.',
      text: 'Se acttualizó el producto.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script>
  ");
  else
  echo ("        
  <script type=\"text/javascript\">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Producto NO actualizado.',
      text: 'El precio es menor al actual, no se actualizó',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script>
  ");
  
          }
          function alert_noCambiosEditMiCliente()
          { ?>
  <script type="text/javascript">
    $(".row-ActualizarCliente").before('<div class="my-2 text-center text-danger noCambiosClienteEdit">NO HAY CAMBIOS QUE GUARDAR</div>');
    setTimeout(function() {
      $(".noCambiosClienteEdit").remove()
    }, 2000);
  </script><?php
          }
          function alert_noCambiosEditProducto()
          { ?>
  <script type="text/javascript">
    $(".btnActualizarProducto").before('<div class="mb-2 text-center text-danger noCambiosClienteEdit">NO HAY CAMBIOS QUE GUARDAR</div>');
    setTimeout(function() {
      $(".noCambiosClienteEdit").remove()
    }, 2000);
  </script><?php
          }
          function alert_contrasenaNoValida()
          { ?>
  <script type="text/javascript">
    $("#password").after('<div class="mt-2 text-center text-danger pswdNoValido">CONTRASEÑA NO VÁLIDA</div>');
    setTimeout(function() {
      $(".pswdNoValido").remove()
    }, 2500);
  </script><?php
          }
          function alert_cuentaNoVerificada()
          { ?>
  <script type="text/javascript">
    $(".alert").remove();
    $("#imgLogo").after('<div class="alert bg-danger-400 text-white" role="alert"><strong>Oh Oh!</strong><br>Tu cuenta aun no ha sido verificada.<br>Debes ingresar a tu correco y activar tu cuenta con el link que se te envió.</div>');
  </script><?php
          }
          function alert_cotizacionEntrega()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cotizacion entregada.',
      text: 'La cotización seleccionada, ha sido marcada como entregada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.replace("?root=entregadas");
    }, 2500);
  </script><?php
          }
          function contrasenaUPDATED()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Contraseña cambiada.',
      html: 'La contraseña fué cambiada como lo solicitaste.<br>Ahora, tu sesión será cerrada para que puedas ingresar con tu nueva contraseña.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_usuarioEditAcualizado()
          { ?>
  <script type="text/javascript">
    $("#EditUser_modal").modal("hide");
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Usuario Actualizado.',
      text: 'Los datos del usuario han sido actualizados.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_clienteEditAcualizado()
          { ?>
  <script type="text/javascript">
    $("#openModaleditCliente").modal("hide");
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cliente Actualizado.',
      text: 'Los datos del cliente han sido actualizados.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_errorAlRegistraralUsuario()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'error',
      title: 'Error de registro!.',
      html: 'Ocurrió un error al intentar enviar el correo al usuario.',
      showConfirmButton: false,
    })
  </script><?php
          }
          function alert_usuarioRegistradoFromPagina()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cuenta creada.',
      html: 'La nueva cuenta fué creada correctamente.<br>Revisa tu correo para que puedas acceder al sistema.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.replace("./");
    }, 5000);
  </script><?php
          }
          function alert_usuarioRegistradoOK()
          { ?>
  <script type="text/javascript">
    $("#openModaladdUsuario").modal('hide');
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cuenta creada.',
      html: 'La nueva cuenta fué creada correctamente.<br>Sel le envió un correo al usuario con sus datos de acceso.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script><?php
          }
          function alert_cuentaCancelada($motivo)
          { ?>
  <script type="text/javascript">
    $(".alert").remove();
    $("#imgLogo").after('<div class="alert bg-danger-400 text-white" role="alert"><strong>Lo sentimos!</strong><br>Tu cuenta ha sido cancelada por el siguiente motivo:<br><?= $motivo ?></div>');
  </script><?php
          }
          function alert_cuentaUsuarioActivada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cuenta activada.',
      text: 'La cuenta fué activada correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_cuentaUsuarioCancelada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cuenta cancelada.',
      text: 'La cuenta fué cancelada correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_notaEntregaOK()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cotización vendida.',
      text: 'La cotización fué marcada como vendida exitosamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.replace("?root=vendidas");
    }, 2500);
  </script><?php
          }
          function alert_smsTeleGramEnviado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Mensaje enviado.',
      text: 'El mensaje fué enviado correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_sucursalDeshabilitada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Sucursal deshabilitada.',
      text: 'La sucursal se deshabilito correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_sucursalHabilitada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Sucursal habilitada.',
      text: 'La sucursal se habilito correctamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_paginaRegistrarHabilitada()
          { ?>
  <script type="text/javascript">
    $(".pageRegistrar").after('<div class="my-2 text-success text-center enableRegistro fw-700">REGISTRO HABILITADO</div>');
    setTimeout(function() {
      $(".enableRegistro").remove()
      $("#pagRegistrar").html('Deshabilitar');
      $(".pageRegistrar").removeClass('bg-danger-500').addClass('bg-success-500');
    }, 2500);
  </script><?php
          }
          function alert_paginaRegistrarDeshabilitada()
          { ?>
  <script type="text/javascript">
    $(".pageRegistrar").after('<div class="my-2 text-danger text-center disableRegistro fw-700">REGISTRO DESHABILITADO</div>');
    setTimeout(function() {
      $(".disableRegistro").remove()
      $("#pagRegistrar").html('Habilitar');
      $(".pageRegistrar").removeClass('bg-success-500').addClass('bg-danger-500');
    }, 2500);
  </script><?php
          }
          function alert_precioUSDDeshabilitado()
          { ?>
  <script type="text/javascript">
    $(".precioUSD").after('<div class="my-2 text-danger text-center disablePrecioUSD fw-700">PRECIO DÓLAR DESHABILITADO</div>');
    setTimeout(function() {
      $(".disablePrecioUSD").remove();
      $("#preUSD").html('Habilitar');
      $(".precioUSD").removeClass('bg-success-500').addClass('bg-danger-500');
    }, 2500);
  </script><?php
          }
          function alert_precioUSDHabilitado()
          { ?>
  <script type="text/javascript">
    $(".precioUSD").after('<div class="my-2 text-success text-center enablePrecioUSD fw-700">PRECIO DÓLAR HABILITADO</div>');
    setTimeout(function() {
      $(".enablePrecioUSD").remove();
      $("#preUSD").html('Deshabilitar');
      $(".precioUSD").removeClass('bg-danger-500').addClass('bg-success-500');
    }, 2500);
  </script><?php
          }
          function alert_proveedoresDeshabilitado()
          { ?>
  <script type="text/javascript">
    $(".Proveedores").after('<div class="my-2 text-danger text-center disablePrecioUSD fw-700">PROVEEDORES DESHABILITADO</div>');
    setTimeout(function() {
      $(".disablePrecioUSD").remove();
      $(".Proveedores").removeClass('bg-success-500').addClass('bg-danger-500');
      $("#funProveedor").html('Habilitar');
    }, 2500);
  </script><?php
          }
          function alert_proveedoresHabilitado()
          { ?>
  <script type="text/javascript">
    $(".Proveedores").after('<div class="my-2 text-success text-center enablePrecioUSD fw-700">PROVEEDORES HABILITADO</div>');
    setTimeout(function() {
      $(".enablePrecioUSD").remove();
      $(".Proveedores").removeClass('bg-danger-500').addClass('bg-success-500');
      $("#funProveedor").html('Deshabilitar');
    }, 2500);
  </script><?php
          }
          function alert_categoriasDeshabilitado()
          { ?>
  <script type="text/javascript">
    $(".Categorias").after('<div class="my-2 text-danger text-center disablePrecioUSD fw-700">CATEGORIAS DESHABILITADO</div>');
    setTimeout(function() {
      $(".disablePrecioUSD").remove();
      $(".Categorias").removeClass('bg-success-500').addClass('bg-danger-500');
      $("#funCategorias").html('Habilitar');
    }, 2500);
  </script><?php
          }
          function alert_categoriasHabilitado()
          { ?>
  <script type="text/javascript">
    $(".Categorias").after('<div class="my-2 text-success text-center enablePrecioUSD fw-700">CATEGORIAS HABILITADO</div>');
    setTimeout(function() {
      $(".enablePrecioUSD").remove();
      $(".Categorias").removeClass('bg-danger-500').addClass('bg-success-500');
      $("#funCategorias").html('Deshabilitar');
    }, 2500);
  </script><?php
          }
          function alert_stockDeshabilitado()
          { ?>
  <script type="text/javascript">
    $(".Stock").after('<div class="my-2 text-danger text-center disableStock fw-700">STOCK DESHABILITADO</div>');
    setTimeout(function() {
      $(".disableStock").remove();
      $(".Stock").removeClass('bg-success-500').addClass('bg-danger-500');
      $("#funStock").html('Habilitar');
    }, 2500);
  </script><?php
          }
          function alert_stockHabilitado()
          { ?>
  <script type="text/javascript">
    $(".Stock").after('<div class="my-2 text-success text-center enableStock fw-700">STOCK HABILITADO</div>');
    setTimeout(function() {
      $(".enableStock").remove();
      $(".Stock").removeClass('bg-danger-500').addClass('bg-success-500');
      $("#funStock").html('Deshabilitar');
    }, 2500);
  </script><?php
          }
          function alert_nuevoClienteRegistrado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cliente registrado.',
      html: 'El nuevo cliente ha sido registrado exitosamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function alert_cotizacionActualizada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cotización actualizada',
      html: 'La cotización será actualizada.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2000);
  </script><?php
          }
          function alert_cotizacionEnviadaporMail()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Cotización enviada.',
      showConfirmButton: false,
      timer: 2000,
    })
  </script><?php
          }
          function alert_nuevaSucursalCreada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      position: 'center',
      icon: 'success',
      title: 'Sucursal creada.',
      html: 'La nueva sucursal ha sido creada exitosamente.',
      showConfirmButton: false,
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function error404()
          {
            echo '
  <div class="h-alt-f d-flex flex-column align-items-center justify-content-center text-center">
    <h1 class="page-error color-fusion-500">
      ERROR <span class="text-gradient">404</span>
      <small class="fw-500">Algo <u>está</u> mal!</small>
    </h1>
    <h2 class="fw-500 mb-5">
      La página que solicitaste no existe.
    </h2>
  </div>';
          }

          function error403()
          {
            echo '
              <div class="h-alt-f d-flex flex-column align-items-center justify-content-center text-center">
                <h1 class="page-error color-fusion-500">
                  ERROR <span class="text-gradient">403</span>
                  <small class="fw-500">Acceso denegado!</small>
                </h1>
                <h2 class="fw-500 mb-5">
                  No tienes permiso a la página que solicitaste.
                </h2>
              </div>';
          }
          //CONSTANTES
          function constante_die($MySQLi)
          {
            die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
          }
          function password($length = 8)
          {
            $chars  = '0123456789';
            $count  = mb_strlen($chars);
            for ($i = 0, $result = ''; $i < $length; $i++) {
              $index  = rand(0, $count - 1);
              $result .= mb_substr($chars, $index, 1);
            }
            return $result;
          }
          function codigoCotizacion($MySQLi, $idTienda)
          {
            $Q_Tienda   = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idTienda' ");
            $dataTienda = mysqli_fetch_assoc($Q_Tienda);
            //include 'date.php';
            $codeTienda = $dataTienda['codeTienda'] . date('Y-Agis');
            return $codeTienda;
          }
          function cargarSucursales_select($MySQLi)
          {
            $Q_Sucursales = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE estado=1");
            echo '<option disabled selected>Seleccione sucursal</option>';
            while ($data  = mysqli_fetch_assoc($Q_Sucursales)) {
              echo '<option value=' . $data['idTienda'] . '>' . $data['sucursal'] . '</option>';
            }
          }
          /*  PRODUCTOS  */
          
          
          
          
          
          
          
          
          
          
          
          function listaProductos($MySQLi, $serviStock)
          {
             $Q_Productos    = mysqli_query($MySQLi, "SELECT * FROM productos WHERE estado=1 ORDER BY mercaderia, nombre ASC");
            $num            = 1;
            $idtotal = 100000;
            
            
            $Q_Configuraciones = mysqli_query($MySQLi, "SELECT simbolo FROM configuraciones");
              $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
              $simbolo           = $dataConfiguracion['simbolo'];
              
            $Q_Sucursales = mysqli_query($MySQLi, "SELECT idTienda FROM sucursales WHERE estado=1 ORDER BY idTienda ASC");
                $resultSucurs = mysqli_num_rows($Q_Sucursales); //Número de sucursales
                
            while ($dataProd = mysqli_fetch_assoc($Q_Productos)) {
              $mercaderia = ($dataProd['mercaderia'] == '' || $dataProd['mercaderia'] == null) ? ' ' : $dataProd['mercaderia'];
              $nombre = ($dataProd['nombre'] == '' || $dataProd['nombre'] == null) ? ' ' : $dataProd['nombre'];
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>

      <td>' . mb_convert_encoding($mercaderia, 'HTML-ENTITIES', 'UTF-8') . '</td>
      <td>' . mb_convert_encoding($nombre, 'HTML-ENTITIES', 'UTF-8') . '</td>';

              //$Q_Configuraciones = mysqli_query($MySQLi, "SELECT simbolo FROM configuraciones");
              //$dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
              //$simbolo           = $dataConfiguracion['simbolo'];
              echo '
      <td class="text-right">' . number_format($dataProd['precio'], 2) . '</td>
      <td class="text-right">' . $dataProd['observaciones'] . '</td>
      <td class="text-center">';
              $src      = 'Productos/' . $dataProd['imagen'];
              $imgArray = redimensionar($src, 30);
              echo '
      <img src="' . $src . '" width="' . $imgArray[0] . '" height="' . $imgArray[1] . '" class="opnelModalEditImagen" id=' . $dataProd['idProducto'] . ' />';
              echo '
      </td>';
              if ($serviStock == 1) {
                $idProducto   = $dataProd['idProducto'];
                //$Q_Sucursales = mysqli_query($MySQLi, "SELECT idTienda FROM sucursales WHERE estado=1 ORDER BY idTienda ASC");
                //$resultSucurs = mysqli_num_rows($Q_Sucursales); //Número de sucursales

                //$Q_Inventarios = mysqli_query($MySQLi, "SELECT stock FROM inventario WHERE idProducto='$idProducto' ");
                //$resultInvent = mysqli_num_rows($Q_Inventarios);
                
                
                for ($i = 0; $i < $resultSucurs; $i++) {
                  $Q_Inventari = mysqli_query($MySQLi, "SELECT idInventario,stock FROM inventario WHERE idProducto='$idProducto' LIMIT $i,1 ");
                  $dataStock  = mysqli_fetch_assoc($Q_Inventari);
                  $idInventari = $dataStock['idInventario'];

                  $Q_Sucursal = mysqli_query($MySQLi, "SELECT sucursal FROM sucursales WHERE estado=1 LIMIT $i,1 ");
                  $dataSucursa = mysqli_fetch_assoc($Q_Sucursal);

                  $sucursalNom = $dataSucursa['sucursal'];
                  $stockProduc = $dataStock['stock'];
                  if ($_SESSION['idRango'] > 0) {
                    if ($stockProduc < 10) {
                      echo '
             <td class="text-center"><button id=' . $idInventari . ' class="btn btn-xs btn-default updateStock" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip"  ' . 'data-idtotal="' . $idtotal . '"' . ' data-original-title="stock producto ' .  $sucursalNom . '">' . $stockProduc . '</botton></td>';
                    } else {
                      echo '
              <td class="text-center"><button id=' . $idInventari . ' class="btn btn-xs btn-default updateStock" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip"   ' . 'data-idtotal="' . $idtotal . '"' . ' data-original-title="stock producto ' . $sucursalNom . '">' . $stockProduc . '</botton></td>';
                    }
                  } else {
                    if ($stockProduc < 10) {
                      echo '
             <td class="text-center"><button class="btn btn-xs btn-default" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip"   ' . 'data-idtotal="' . $idtotal . '"' . ' data-original-title="stock producto ' . $sucursalNom .   '">' . $stockProduc . '</botton></td>';
                    } else {
                      echo '
              <td class="text-center"><button class="btn btn-xs btn-default" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip"   ' . 'data-idtotal="' . $idtotal . '"' . ' data-original-title="stock producto ' . $sucursalNom . '">' . $stockProduc . '</botton></td>';
                    }
                  }
                }
              
                  
                  
                  
              }
              echo '
      <!--<td class="text-center">' . $dataProd['codigoProducto'] . '
        <button class="btn btn-primary btn-xs" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Código producto" id=' . $dataProd['idProducto'] . '><i class="fad fa-barcode-alt"></i></button>
      </td>-->

';

             $q_stock_total = mysqli_query(
                $MySQLi,
                "SELECT
idProducto,
SUM(stock) AS total_stock
FROM
inventario
WHERE
idProducto = '$idProducto'"
              );
              $d_stock_total  = mysqli_fetch_assoc($q_stock_total);
              $total_stock = $d_stock_total['total_stock'];
   
               
$idprod1 = $idProducto;
              echo $total_stock >= 10 ? '<td class="text-center" style="background-color: default;"><button  id=' . $idtotal . ' data-idprod1="'.$idprod1.'"  class="btn btn-xs btn-default btnLog" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Stock Total Producto"><b>' . $total_stock . '</b></botton></td>' : '<td class="text-center" style="background-color: white;"><button  id=' . $idtotal . '  data-idprod1="' . $idprod1 .'" style="background-color: red;" class="btn btn-xs btn-default btnLog" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Stock Total Producto"><b>' . $total_stock . '</b></botton></td>';

              echo '
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openPaneleditProducto"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar producto" id=' . $dataProd['idProducto'] . '><i class="far fa-edit"></i></button>&nbsp;
      </td>
    </tr>';
              $num++;
              $idtotal++;
            }
          }
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          
          /*  USUARIOS  */
          function listaUsuarios($MySQLi, $idUser, $idRango)
          {
            if ($idRango == 3) {
              $Q_Usuarios       = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE estado<2 ORDER BY Nombre ASC");
            } else {
              $Q_Usuarios       = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idRango!=3 AND estado<2 ORDER BY Nombre ASC");
            }
            $num = 1;
            while ($dataUsers = mysqli_fetch_assoc($Q_Usuarios)) {
                if ($dataUsers['idTienda'] == -1) continue;
              echo '
    <tr>
      <td class="text-center">' . $num /*$dataUsers['idUser']*/ . '</td>
      <td>' . $dataUsers['Nombre'] . '</td>
      <td>' . $dataUsers['cargo'] . '</td>
      <td>' . $dataUsers['correo'] . '</td>
      <td class="text-center">' . $dataUsers['telefono'] . ' &nbsp;';
              if ($dataUsers['idTelegram'] != '') {
                echo '<button class="btn btn-primary btn-sm btn-icon rounded-circle openModalTelegram"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Enviar mensaje por Telegram" id=' . $dataUsers['idUser'] . '><i class="far fa-paper-plane"></i></button>';
              }
              echo '
      </td>
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openModaleditUsuario"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar usuaio" id=' . $dataUsers['idUser'] . '><i class="far fa-user-edit"></i></button>&nbsp;';
              if ($dataUsers['estado'] == 0) {
                echo '
          <button class="btn btn-success btn-sm btn-icon rounded-circle activarCuentaUsuario" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Activar la cuenta de este usuario" id=' . $dataUsers['idUser'] . '><i class="far fa-power-off"></i></button>&nbsp;';
              } else {
                if ($dataUsers['idRango'] < 2) {
                  echo '
             <button class="btn btn-danger btn-sm btn-icon rounded-circle openModalCancelarCuentaUsuario" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cancelar la cuenta de este usuario" id=' . $dataUsers['idUser'] . '><i class="far fa-trash-alt"></i></button>';
                }
              }
              echo '
      </td>
    </tr>';
              $num++;
            }
          }
          /*  MIS CLIENTES  */
          function lista_misClientes($MySQLi, $idUser)
          {
            $Q_misClientes  = mysqli_query($MySQLi, "SELECT idCliente,idCiudad,idTelegram,nombre,correo,empresa,telEmpresa,ext,celular,direccion,comentarios,fechaRegistro FROM clientes WHERE idUser='$idUser' ORDER BY nombre ASC");
            $num = 1;
            while ($dataClientes = mysqli_fetch_assoc($Q_misClientes)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>
      <td>' . $dataClientes['nombre'] . '</td>
      <td>' . $dataClientes['correo'] . '</td>
      <td>' . $dataClientes['empresa'] . '</td>';
              if ($dataClientes['telEmpresa'] != '' & $dataClientes['ext'] != '') {
                $telEmpresa = $dataClientes['telEmpresa'] . ' ext: ' . $dataClientes['ext'];
              } else {
                $telEmpresa = $dataClientes['telEmpresa'];
              }
              echo '
      <td>' . $telEmpresa . '</td>
      <td>';
              if ($dataClientes['idTelegram'] != '') {
                echo $dataClientes['celular'] . ' &nbsp; <button class="btn btn-primary btn-xs btn-icon rounded-circle openModalTeleGram" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Enviar mensaje por Telegram" id=' . $dataClientes['idCliente'] . '><i class="far fa-paper-plane"></i></button>';
              } else {
                echo $dataClientes['celular'];
              }
              echo '</td>';
              $idCiudad     = $dataClientes['idCiudad'];
              $Q_CiudadClte = mysqli_query($MySQLi, "SELECT * FROM ciudades WHERE idCiudad='$idCiudad' ");
              $dataCiudadClt = mysqli_fetch_assoc($Q_CiudadClte);
              echo '
      <td>' . $dataCiudadClt['ciudad'] . '</td>
      <td>' . fechaFormato($dataClientes['fechaRegistro']) . '</td>
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openModaleditCliente" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar cliente" id=' . $dataClientes['idCliente'] . '><i class="far fa-user-edit"></i></button>
      </td>
    </tr>';
              $num++;
            }
          }
          function tabla_misVentas($MySQLi, $idUser, $startBusqueda, $fecha)
          {
            $Q_Ventas  = mysqli_query($MySQLi, "SELECT nombreCliente,idRecibo,idNotaEntrega,idProducto,cantidad,precioEspecial1,totalVenta1 FROM ventas WHERE idVendedor='$idUser'AND fecha BETWEEN'$startBusqueda'AND'$fecha'AND estado=1 AND tipo=1 ORDER BY fecha ASC");
            $num = 1;
            while ($dataVenta = mysqli_fetch_assoc($Q_Ventas)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>
      <td class="text-center">' . $dataVenta['nombreCliente'] . '</td>';
              $idProducto   = $dataVenta['idProducto'];
              $Q_Producto   = mysqli_query($MySQLi, "SELECT nombre FROM productos WHERE idProducto='$idProducto' ");
              $dataProducto = mysqli_fetch_assoc($Q_Producto);
              $nombreProduct = $dataProducto['nombre'];
              echo '
      <td class="text-center">' . imap_utf8($nombreProduct) . '</td>
      <td class="text-center">' . $dataVenta['cantidad'] . '</td>
      <td class="text-right">' . number_format($dataVenta['precioEspecial1'], 2) . '</td>
      <td class="text-right">' . number_format(($dataVenta['cantidad'] * $dataVenta['precioEspecial1']), 2) . '</td>
      <td class="text-center"><a target="_blank" href="pdf.php?idRecibo=' . $dataVenta['idRecibo'] . '" class="text-reset" style="text-decoration:none">' . $dataVenta['idRecibo'] . '</a></td>
      <td class="text-center"><a target="_blank" href="pdf.php?idNotaEntrega=' . $dataVenta['idNotaEntrega'] . '" class="text-reset" style="text-decoration:none">' . $dataVenta['idNotaEntrega'] . '</a></td>
    </tr>';
              $num++;
            }
          }
          function tabla_Ventas($MySQLi, $idUser, $startBusqueda, $fecha, $serviStock, $numSucursales)
          {
            $Q_Ventas  = mysqli_query($MySQLi, "SELECT idSucursal,nombreCliente,idRecibo,idNotaEntrega,idProducto,cantidad,precioEspecial1,totalVenta1 FROM ventas WHERE fecha BETWEEN'$startBusqueda'AND'$fecha'AND estado=1 AND tipo=1 ORDER BY fecha ASC");
            $num = 1;
            while ($dataVenta = mysqli_fetch_assoc($Q_Ventas)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>';
              $idTienda     = $dataVenta['idSucursal'];
              $Q_Sucursal   = mysqli_query($MySQLi, "SELECT sucursal FROM sucursales WHERE idTienda='$idTienda'  ");
              $dataSucursal = mysqli_fetch_assoc($Q_Sucursal);
              $sucursal     = $dataSucursal['sucursal'];
              if ($serviStock == 1) {
                if ($numSucursales > 1) {
                  echo '
          <td class="text-center">' . $dataSucursal['sucursal'] . '</td>';
                }
              }
              echo '
      <td class="text-center">' . $dataVenta['nombreCliente'] . '</td>';
              $idProducto   = $dataVenta['idProducto'];
              $Q_Producto   = mysqli_query($MySQLi, "SELECT nombre FROM productos WHERE idProducto='$idProducto' ");
              $dataProducto = mysqli_fetch_assoc($Q_Producto);
              $nombreProduct = $dataProducto['nombre'];
              echo '
      <td class="text-center">' . $nombreProduct . '</td>
      <td class="text-center">' . $dataVenta['cantidad'] . '</td>
      <td class="text-right">' . number_format($dataVenta['precioEspecial1'], 2) . '</td>
      <td class="text-right">' . number_format(($dataVenta['cantidad'] * $dataVenta['precioEspecial1']), 2) . '</td>
      <td class="text-center"><a target="_blank" href="pdf.php?idRecibo=' . $dataVenta['idRecibo'] . '" class="text-reset" style="text-decoration:none">' . $dataVenta['idRecibo'] . '</a></td>
      <td class="text-center"><a target="_blank" href="pdf.php?idNotaEntrega=' . $dataVenta['idNotaEntrega'] . '" class="text-reset" style="text-decoration:none">' . $dataVenta['idNotaEntrega'] . '</a></td>
    </tr>';
              $num++;
            }
          }
          function lista_generalClientes($MySQLi, $idRango)
          {
            $Q_misClientes  = mysqli_query($MySQLi, "SELECT * FROM clientes ORDER BY nombre ASC");
            $num = 1;
            while ($dataClientes = mysqli_fetch_assoc($Q_misClientes)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>';
              $idSucursal = $dataClientes['idTienda'];
              $Q_Sucursal = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idSucursal' ");
              $dataSucursa = mysqli_fetch_assoc($Q_Sucursal);
              $sucursal   = $dataSucursa['sucursal'];
              echo '
      <td>' . $sucursal . '</td>
      <td>' . $dataClientes['nombre'] . '</td>
      <td>' . $dataClientes['correo'] . '</td>
      <td>' . $dataClientes['empresa'] . '</td>';
              if ($dataClientes['telEmpresa'] != '' & $dataClientes['ext'] != '') {
                $telEmpresa = $dataClientes['telEmpresa'] . ' ext: ' . $dataClientes['ext'];
              } else {
                $telEmpresa = $dataClientes['telEmpresa'];
              }
              echo '
      <td>' . $telEmpresa . '</td>
      <td>' . $dataClientes['celular'] . '</td>';
              $idCiudad     = $dataClientes['idCiudad'];
              $Q_CiudadClte = mysqli_query($MySQLi, "SELECT * FROM ciudades WHERE idCiudad='$idCiudad' ");
              $dataCiudadClt = mysqli_fetch_assoc($Q_CiudadClte);
              echo '
      <td>' . $dataCiudadClt['ciudad'] . '</td>
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openModaleditCliente" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar cliente" id=' . $dataClientes['idCliente'] . '><i class="far fa-user-edit"></i></button>
      </td>
    </tr>';
              $num++;
            }
          }
          function lista_generalSucursales($MySQLi, $idRango)
          {
            echo '
  <input type="hidden" id="rangoUsuario" value=' . $idRango . '>';
            $Q_Sucursales   = mysqli_query($MySQLi, "SELECT * FROM sucursales ORDER BY sucursal ASC");
            $num = 1;
            while ($dataSucursales = mysqli_fetch_assoc($Q_Sucursales)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>
      <td class="text-center">' . $dataSucursales['sucursal'] . '</td>
      <td class="text-center">' . $dataSucursales['codeTienda'] . '</td>
      <td class="text-center">
        <button class="btn mx-1 btn-primary btn-sm btn-icon rounded-circle openModaleditSucursal" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar esta sucursal" id=' . $dataSucursales['idTienda'] . '><i class="far fa-edit"></i></button>';
              if ($dataSucursales['estado'] == 1 & $dataSucursales['idTienda'] != 1) {
                echo '
          <button class="btn mx-1 btn-danger btn-sm btn-icon rounded-circle deshabilitarSucursal" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Deshabilitar esta sucursal" id=' . $dataSucursales['idTienda'] . '><i class="fad fa-power-off"></i></button>';
              } else if ($dataSucursales['estado'] != 1 & $dataSucursales['idTienda'] != 1) {
                if ($idRango > 2) {
                  echo '
          <button class="btn mx-1 btn-success btn-sm btn-icon rounded-circle HabilitarSucursal" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Habilitar esta sucursal" id=' . $dataSucursales['idTienda'] . '><i class="fad fa-power-off"></i></button>';
                }
              }
              echo '
      </td>
    </tr>';
              $num++;
            }
          }
          //PROVEEDORES
          function listaProveedores($MySQLi, $idUser, $idRango)
          {
            $Q_Proveedores   = mysqli_query($MySQLi, "SELECT * FROM proveedores WHERE estado=1 ORDER BY proveedor ASC");
            $num = 1;
            while ($dataProveedor = mysqli_fetch_assoc($Q_Proveedores)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>
      <td class="text-center">' . $dataProveedor['proveedor'] . '</td>
      <td class="text-center">' . $dataProveedor['telEmpresa'] . '' . ($dataProveedor['ext'] != '' ? ' - ext ' . $dataProveedor['ext'] : '') . '</td>
      <td class="text-center">' . $dataProveedor['encargado'] . '</td>
      <td class="text-center">' . $dataProveedor['cell'] . '</td>
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openModaleditProveedor" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar proveedor" id=' . $dataProveedor['idProveedor'] . '><i class="far fa-edit"></i></button>
      </td>
    </tr>';
              $num++;
            }
          }
          //CATEGORIAS
          function listaCategorias($MySQLi, $idUser, $idRango)
          {
            $Q_Categorias   = mysqli_query($MySQLi, "SELECT * FROM categorias WHERE estado=1 ORDER BY categoria ASC");
            $num = 1;
            while ($dataCategoria = mysqli_fetch_assoc($Q_Categorias)) {
              echo '
    <tr>
      <td class="text-center">' . $num . '</td>
      <td class="text-center">' . $dataCategoria['categoria'] . '</td>
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openModaleditCategoria" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar categoria" id=' . $dataCategoria['idCategoria'] . '><i class="far fa-edit"></i></button>
      </td>
    </tr>';
              $num++;
            }
          }
          //CONSULTAS
          function precioDolar($MySQLi)
          {
            $Q_Precio   = mysqli_query($MySQLi, "SELECT * FROM preciodolar ");
            $dataPre    = mysqli_fetch_assoc($Q_Precio);
            $precioDolar = $dataPre['precio'];
            return $precioDolar;
          }
          function listaCiudades($MySQLi)
          {
            $Q_Ciudades = mysqli_query($MySQLi, "SELECT * FROM ciudades ");
            while ($dataCiudad = mysqli_fetch_assoc($Q_Ciudades)) {
              echo '<option value=' . $dataCiudad['idCiudad'] . '>' . $dataCiudad['ciudad'] . '</option>';
            }
          }
          function aleatorio()
          {
            $code   = uniqid();
            $code   = substr($code, -10);
            return $code;
          }
          function listaProductos_notaEntrega($MySQLi, $claveTemporal)
          {
            $Q_clavesTemp   = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveTemporal' ORDER BY idClave ASC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
            $resultClaves   = mysqli_num_rows($Q_clavesTemp);
            if ($resultClaves > 0) { ?>
    <table class="mt-3 table table-striped table-bordered table-td-valign-middle w-100" style="font-size:10px;">
      <thead>
        <tr class="bg-primary text-white">
          <th width="12%" class="text-center">Cantidad</th>
          <th width="38%" class="text-center">Mercaderia</th>
          <th width="40%" class="text-center">Repuesto</th>
          <!-- <th width="32%" class="text-center">Marca</th>
          <th width="32%" class="text-center">Modelo</th> -->
        </tr>
      </thead>
      <tbody><?php
              while ($dataRegistros = mysqli_fetch_assoc($Q_clavesTemp)) { ?>
          <tr class="fw-800">
            <td class="text-center"><?php echo $dataRegistros['cantidad'] ?></td><?php
                                                                                  $this_idProducto    = $dataRegistros['idProducto'];
                                                                                  $Q_thisProducto     = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$this_idProducto'");
                                                                                  $dataProducto       = mysqli_fetch_assoc($Q_thisProducto);
                                                                                  $mercaderia         = $dataProducto['mercaderia'];
                                                                                  $this_nameProducto  = $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'];
                                                                                  $this_marcaProduct  = $dataProducto['marca'];
                                                                                  $this_modeloProduc  = $dataProducto['modelo'];


                                                                                  ?>
            <td><?= $mercaderia ?></td>
            <td><?= $this_nameProducto ?></td>

          </tr><?php } ?>
      </tbody>
    </table> <?php mysqli_close($MySQLi);
            } else {
              mysqli_close($MySQLi); ?>
    <table class="mt-3 table table-striped table-bordered table-td-valign-middle w-100" style="font-size:10px;">
      <thead>
        <tr class="bg-primary text-white">
          <th width="2%" class="text-center">Cantidad</th>
          <th width="32%" class="text-center">Mercaderia</th>
          <th width="32%" class="text-center">Repuesto</th>

        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="3" class="text-center text-danger" style="letter-spacing: 1px">NO HAY PRODUCTOS QUE MOSTRAR</td>
        </tr>
      </tbody>
    </table><?php
            }
          }
          function listaProductosTemporales($MySQLi, $claveTemporal)
          {
            $Q_clavesTemp   = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveTemporal' ORDER BY idClave ASC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
            $resultClaves   = mysqli_num_rows($Q_clavesTemp);
            if ($resultClaves > 0) { ?>
    <table class="mt-3 table table-striped table-bordered table-td-valign-middle w-100" style="font-size:10px;">
      <thead>
        <tr class="bg-primary text-white">
          <th width="5%" class="text-center">Cantidad</th>
          <th width="45%" class="text-center">Producto</th>
          <th width="15%" class="text-center">Precio Venta</th>
          <th width="15%" class="text-center">Precio Especial</th>
          <th width="10%" class="text-center">Total</th>
          <th width="10%" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody><?php
              while ($dataRegistros = mysqli_fetch_assoc($Q_clavesTemp)) { ?>
          <tr class="fw-800">
            <td class="text-center"><?php echo $dataRegistros['cantidad'] ?></td><?php
                                                                                  $this_idProducto    = $dataRegistros['idProducto'];
                                                                                  $Q_thisProducto     = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$this_idProducto'");
                                                                                  $dataProducto       = mysqli_fetch_assoc($Q_thisProducto);
                                                                                  $this_mercaderiaProducto  = $dataProducto['mercaderia'];
                                                                                  $this_nameProducto  = $dataProducto['nombre'];
                                                                                  $this_marcaProduct  = $dataProducto['marca'];
                                                                                  $this_modeloProduc  = $dataProducto['modelo'];
                                                                                  $this_fullnameProd  = $this_mercaderiaProducto . "  " . $this_nameProducto . "  " . $this_marcaProduct . "  " . $this_modeloProduc;  ?>
            <td class=""><?= $this_fullnameProd ?></td><?php
                                                        $Q_Configuraciones  = mysqli_query($MySQLi, "SELECT simbolo FROM configuraciones");
                                                        $dataConfiguracion  = mysqli_fetch_assoc($Q_Configuraciones);
                                                        $simbolo            = $dataConfiguracion['simbolo']; ?>
            <td class="text-right"><span class="text-success"><?= $simbolo ?></span> <?php echo number_format($dataRegistros['precioVenta'], 2) ?></td>
            <td class="text-right"><span class="text-success"><?= $simbolo ?></span> <?php echo number_format($dataRegistros['precioEspecial'], 2) ?></td>
            <td class="text-right"><span class="text-success"><?= $simbolo ?></span> <?php echo number_format($dataRegistros['precioEspecial'] * $dataRegistros['cantidad'], 2) ?></td>
            <td class="text-center"><?php
                                    $consultaClave    = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveTemporal' ");
                                    $resultBusqueda   = mysqli_num_rows($consultaClave);
                                    if ($resultBusqueda > 1) { ?>
                <button type="button" class="btn btn-danger btn-sm btn-icon rounded-circle borrarProductoTemporal" id="<?= $dataRegistros['idClave'] ?>"><i class="far fa-trash-alt"></i></button>
                <div class="spinner-borrarProductoTemp_<?= $dataRegistros['idClave'] ?> spinner-<?= APP_THEME ?> m-auto d-none">
                  <div class="bar1"></div>
                  <div class="bar2"></div>
                  <div class="bar3"></div>
                  <div class="bar4"></div>
                  <div class="bar5"></div>
                  <div class="bar6"></div>
                  <div class="bar7"></div>
                  <div class="bar8"></div>
                  <div class="bar9"></div>
                  <div class="bar10"></div>
                  <div class="bar11"></div>
                  <div class="bar12"></div>
                </div><?php
                                    }
                                    $idClave          = $dataRegistros['idClave']; ?>
              <button type="button" class="btn btn-primary btn-sm btn-icon rounded-circle modal_editarProductoTemporal" id="<?= $idClave ?>"><i class="far fa-edit"></i></button>
            </td>
          </tr><?php } ?>
      </tbody>
    </table> <?php mysqli_close($MySQLi);
            } else {
              mysqli_close($MySQLi); ?>
    <table class="mt-3 table table-striped table-bordered table-td-valign-middle w-100" style="font-size:10px;">
      <thead>
        <tr class="bg-primary text-white">
          <th width="5%" class="text-center">Cantidad</th>
          <th width="45%" class="text-center">Producto</th>
          <th width="15%" class="text-center">Precio Venta</th>
          <th width="15%" class="text-center">Precio Especial</th>
          <th width="10%" class="text-center">Total</th>
          <th width="10%" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="6" class="text-center text-danger" style="letter-spacing: 1px">NO HAY PRODUCTOS QUE MOSTRAR</td>
        </tr>
      </tbody>
    </table><?php
            }
          }
          function lista_cotizacionesGeneradas($MySQLi, $Inicio, $Fin, $idRangoDf, $idTiendaDf)
          {
            $query_generadas = $idRangoDf > 1 ? "SELECT * FROM cotizaciones WHERE estado=0 AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC" : "SELECT * FROM cotizaciones WHERE estado=0 AND idTienda = $idTiendaDf AND fecha BETWEEN '$Inicio' AND '$Fin'  ORDER BY idCotizacion DESC";
            // $Q_Cotizaciones = mysqli_query($MySQLi,"SELECT * FROM cotizaciones WHERE estado=0 AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC");
            $Q_Cotizaciones = mysqli_query($MySQLi, $query_generadas);
            while ($dataCotiza = mysqli_fetch_assoc($Q_Cotizaciones)) {
              $idCotizacion   = $dataCotiza['idCotizacion'];
              $codigo         = $dataCotiza['codigo'];
              $clave          = $dataCotiza['clave'];
              $idUser         = $dataCotiza['idUser'];
              $idCliente      = $dataCotiza['idCliente'];
              $formaPago      = $dataCotiza['formaPago'];
              $fechaOferta    = $dataCotiza['fechaOferta'];
              $tiempoEntrega  = $dataCotiza['tiempoEntrega'];
              $comentarios    = $dataCotiza['comentarios'];
              $fechaRegistro  = $dataCotiza['fecha'];
              $horaRegistro   = $dataCotiza['hora'];
              $Q_Cliente      = mysqli_query($MySQLi, "SELECT nombre,celular,correo FROM clientes WHERE idCliente='$idCliente' ");
              $dataCliente    = mysqli_fetch_assoc($Q_Cliente);
              $Q_Usuario      = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUser' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
              $dataUsuario    = mysqli_fetch_assoc($Q_Usuario); ?>
    <tr>
      <td class="text-center pt-5"><?= $idCotizacion ?></td>
      <!-- DATOS REGISTRO -->
      <!-- <td>
        <div class="table-responsive">
          
        </div>
      </td> -->
      <!-- DETALLES COTIZACION -->
      <td>
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-striped w-100" style="font-size: 10px;">
            <tr>
              <th>Cliente</th>
              <td><?= $dataCliente['nombre'] ?></td>
              <th>Celular</th>
              <td><?= $dataCliente['celular'] ?></td>
              <th>Código</th>
              <td><?= $codigo ?></td>
            </tr>
            <tr>
              <th>Vendedor</th>
              <td><?= $dataUsuario['Nombre'] ?></td>
              <th>Fecha</th>
              <td><?= fechaFormato($fechaRegistro) ?></td>
              <th>Hora</th>
              <td><?= formatoHora($horaRegistro) ?></td>
            </tr>
          </table>
          <table class="table table-sm table-bordered table-striped w-100" style="font-size: 10px;">
            <thead>
              <tr class="bg-primary text-white">
                <th width="5%" class="text-center">Cantidad</th>
                <th width="50%" class="text-center">Descripción</th>
                <th width="15%" class="text-center">Precio venta</th>
                <th width="15%" class="text-center">Precio oferta</th>
                <th width="15%" class="text-center">Total</th>
              </tr>
            </thead>
            <tbody><?php
                    $Q_Configuraciones = mysqli_query($MySQLi, "SELECT simbolo FROM configuraciones");
                    $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
                    $simbolo          = $dataConfiguracion['simbolo'];
                    $Q_clavesTemp     = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$clave' ");
                    while ($dataClaves = mysqli_fetch_assoc($Q_clavesTemp)) {
                      echo '
                <tr>
                  <td class="text-center">' . $dataClaves['cantidad'] . '</td>';
                      $idProducto   = $dataClaves['idProducto'];
                      $Q_Productos  = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
                      $dataProducto = mysqli_fetch_assoc($Q_Productos);
                      $nombreProducto = $dataProducto['mercaderia'] . " " . $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'];
                      echo '
                  <td>' . $nombreProducto . '</td>
                  <td class="text-right">' . $simbolo . ' &nbsp; ' . number_format($dataClaves['precioVenta'], 2) . '</td>
                  <td class="text-right">' . $simbolo . ' &nbsp; ' . number_format($dataClaves['precioEspecial'], 2) . '</td>
                  <td class="text-right">' . $simbolo . ' &nbsp; ' . number_format(($dataClaves['precioEspecial'] * $dataClaves['cantidad']), 2) . '</td>
                </tr>';
                    } ?>
              <tr>
                <th colspan="4" class="text-right text-danger">TOTAL</th><?php
                                                                          $Q_Total  = mysqli_query($MySQLi, "SELECT SUM(cantidad*precioEspecial)AS Total FROM claveTemporal WHERE claveTemporal='$clave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                                          $dataTotal = mysqli_fetch_assoc($Q_Total); ?>
                <th class="text-right"><?= $simbolo . ' &nbsp; ' . number_format($dataTotal['Total'], 2) ?></th>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-center" style="margin-top: -1.5%;">
          <button id="<?= $clave ?>" class="mx-2 btn btn-info btn-sm btn-icon rounded-circle waves-effect waves-themed EditarCotizacionPanel" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar esta Cotización"><i class="fal fa-pencil"></i></button>
          <input type="hidden" id="claveCotizacion" value="<?= $clave ?>">
          <!-- SI EL CLIENTE PROPORCIONÓ UN CORREO --><?php
                                                      if ($dataCliente['correo'] != '') {
                                                        echo '
             <button id="' . $idCotizacion . '" class="mx-2 btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed modal_enviarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Enviar cotización por correo electrónico a ' . $dataCliente['correo'] . '"><i class="fal fa-envelope"></i></button>';
                                                      } ?>

          <button id="<?= $idCotizacion ?>" class="mx-2 btn btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed marcarComoEntregada" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Entregar Cotización"><i class="fal fa-paper-plane"></i></button><?php
                                                                                                                                                                                                                                                                                                                                                                                                                    if ($idRangoDf > 1) { ?>
            <button id="<?= $idCotizacion ?>" class="mx-2 btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed borrarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar Cotización"><i class="fal fa-trash-alt"></i></button><?php
                                                                                                                                                                                                                                                                                                                                                                                                                    } ?>
          <!-- funciona este boton para generar un word-->
          <!-- <a target="_blank" href="word.php?idCotizacion=<?= $idCotizacion ?>" class="mx-2 btn btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar en Word"><i class="fal fa-file-word"></i></a> -->

          <a target="_blank" href="pdf.php?idCotizacion=<?php echo $idCotizacion ?>" class="mx-2 btn btn-info btn-sm btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar en PDF"><i class="fal fa-file-pdf"></i></a>
        </div>
      </td>
    </tr><?php
            }
          }
          function lista_cotizacionesEntregadas($MySQLi, $Inicio, $Fin, $idRangoDf, $idTiendaDf)
          {
            $Q_Configuraciones = mysqli_query($MySQLi, "SELECT monedaP,simbolo FROM configuraciones");
            $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
            $monedaPrincipal   = $dataConfiguracion['monedaP'];
            $simboloMoneda     = $dataConfiguracion['simbolo'];

            $query_entregadas = $idRangoDf > 1 ? "SELECT * FROM cotizaciones WHERE estado=1 AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC" : "SELECT * FROM cotizaciones WHERE estado=1 AND idTienda = $idTiendaDf AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC";
            // $Q_Cotizaciones = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE estado=1 AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC");
            $Q_Cotizaciones = mysqli_query($MySQLi, $query_entregadas);

            while ($dataCotiza = mysqli_fetch_assoc($Q_Cotizaciones)) {
              $idCotizacion   = $dataCotiza['idCotizacion'];
              $codigo         = $dataCotiza['codigo'];
              $clave          = $dataCotiza['clave'];
              $idUser         = $dataCotiza['idUser'];
              $idCliente      = $dataCotiza['idCliente'];
              $formaPago      = $dataCotiza['formaPago'];
              $fechaOferta    = $dataCotiza['fechaOferta'];
              $tiempoEntrega  = $dataCotiza['tiempoEntrega'];
              $comentarios    = $dataCotiza['comentarios'];
              $fechaRegistro  = $dataCotiza['fecha'];
              $horaRegistro   = $dataCotiza['hora'];
              $Q_Cliente      = mysqli_query($MySQLi, "SELECT nombre,celular,correo FROM clientes WHERE idCliente='$idCliente' ");
              $dataCliente    = mysqli_fetch_assoc($Q_Cliente);
              $Q_Usuario      = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUser' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
              $dataUsuario    = mysqli_fetch_assoc($Q_Usuario); ?>
    <tr>
      <td class="text-center pt-5"><?= $idCotizacion ?></td>
      <!-- DATOS REGISTRO -->
      <!-- <td>
        <div class="table-responsive">
          
        </div>
      </td> -->
      <!-- DETALLES COTIZACION -->
      <td>
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-striped w-100" style="font-size: 10px;">
            <tr>
              <th>Cliente</th>
              <td><?= $dataCliente['nombre'] ?></td>
              <th>Celular</th>
              <td><?= $dataCliente['celular'] ?></td>
              <th>Código</th>
              <td><?= $codigo ?></td>
            </tr>
            <tr>
              <th>Vendedor</th>
              <td><?= $dataUsuario['Nombre'] ?></td>
              <th>Fecha</th>
              <td><?= fechaFormato($fechaRegistro) ?></td>
              <th>Hora</th>
              <td><?= formatoHora($horaRegistro) ?></td>
            </tr>
          </table>
          <table class="table table-sm table-bordered table-striped w-100" style="font-size: 10px;">
            <thead>
              <tr class="bg-primary text-white">
                <th width="5%" class="text-center">Cantidad</th>
                <th width="50%" class="text-center">Descripción</th>
                <th width="15%" class="text-center">Precio venta</th>
                <th width="15%" class="text-center">Precio oferta</th>
                <th width="15%" class="text-center">Total</th>
              </tr>
            </thead>
            <tbody><?php
                    $Q_clavesTemp     = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$clave' ");
                    while ($dataClaves = mysqli_fetch_assoc($Q_clavesTemp)) {
                      echo '
                <tr>
                  <td class="text-center">' . $dataClaves['cantidad'] . '</td>';
                      $idProducto   = $dataClaves['idProducto'];
                      $Q_Productos  = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
                      $dataProducto = mysqli_fetch_assoc($Q_Productos);
                      $nombreProducto = $dataProducto['mercaderia'] . " " . $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'];
                      echo '
                  <td>' . $nombreProducto . '</td>
                  <td class="text-right">' . $simboloMoneda . ' &nbsp; ' . number_format($dataClaves['precioVenta'], 2) . '</td>
                  <td class="text-right">' . $simboloMoneda . ' &nbsp; ' . number_format($dataClaves['precioEspecial'], 2) . '</td>
                  <td class="text-right">' . $simboloMoneda . ' &nbsp; ' . number_format(($dataClaves['precioEspecial'] * $dataClaves['cantidad']), 2) . '</td>
                </tr>';
                    } ?>
              <tr>
                <th colspan="4" class="text-right text-danger">TOTAL</th><?php
                                                                          $Q_Total  = mysqli_query($MySQLi, "SELECT SUM(cantidad*precioEspecial)AS Total FROM claveTemporal WHERE claveTemporal='$clave' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                                          $dataTotal = mysqli_fetch_assoc($Q_Total); ?>
                <th class="text-right"><?= $simboloMoneda . ' &nbsp; ' . number_format($dataTotal['Total'], 2) ?></th>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-center" style="margin-top: -1.5%;">
          <!--<button id="<?= $idCotizacion ?>" class="mx-2 btn btn-info btn-sm btn-icon rounded-circle waves-effect waves-themed modal_EditarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar esta Cotización"><i class="fal fa-pencil"></i></button>-->
          <input type="hidden" id="claveCotizacion" value="<?= $clave ?>">
          <!-- SI EL CLIENTE PROPORCIONÓ UN CORREO --><?php
                                                      if ($dataCliente['correo'] != '') {
                                                        echo '
             <button id="' . $idCotizacion . '" class="mx-2 btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed modal_enviarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Enviar cotización por correo electrónico a ' . $dataCliente['correo'] . '"><i class="fal fa-envelope"></i></button>';
                                                      } ?>

          <button id="<?= $idCotizacion ?>" class="mx-2 btn btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed openModal_VenderCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cambiar a Vendida la Cotización del Repuesto"><i class="fad fa-dollar-sign"></i></button><?php

                                                                                                                                                                                                                                                                                                                                                                                                                                                    if ($idRangoDf > 1) { ?>
            <!--<button id="<?= $idCotizacion ?>" class="mx-2 btn btn-danger btn-sm btn-icon rounded-circle waves-effect waves-themed borrarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar Cotización"><i class="fal fa-trash-alt"></i></button>--><?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                    } ?>
          <!-- funciona este boton para generar word -->
          <!-- <a target="_blank" href="word.php?idCotizacion=<?= $idCotizacion ?>" class="mx-2 btn btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar en Word"><i class="fal fa-file-word"></i></a> -->

          <a target="_blank" href="pdf.php?idCotizacion=<?php echo $idCotizacion ?>" class="mx-2 btn btn-info btn-sm btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar en PDF"><i class="fal fa-file-pdf"></i></a>
        </div>
      </td>
    </tr><?php
            }
          }
          function lista_cotizacionesVendidas($MySQLi, $Inicio, $Fin, $idRangoDf, $idTiendaDf)
          {
            // $Q_Configuraciones = mysqli_query($MySQLi, "SELECT simbolo FROM configuraciones");
            // $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
            // $simbolo           = $dataConfiguracion['simbolo'];

            $query_entregadas = $idRangoDf > 1 ? "SELECT * FROM cotizaciones WHERE estado=2 AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC" : "SELECT * FROM cotizaciones WHERE estado=2 AND idTienda = $idTiendaDf AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC";
            // $Q_Cotizaciones = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE estado=2 AND fecha BETWEEN '$Inicio' AND '$Fin' ORDER BY idCotizacion DESC");
            $Q_Cotizaciones = mysqli_query($MySQLi, $query_entregadas);
            while ($dataCotiza = mysqli_fetch_assoc($Q_Cotizaciones)) {
              $idCotizacion   = $dataCotiza['idCotizacion'];
              $codigo         = $dataCotiza['codigo'];
              $clave          = $dataCotiza['clave'];
              $idUser         = $dataCotiza['idUser'];
              $idCliente      = $dataCotiza['idCliente'];
              $formaPago      = $dataCotiza['formaPago'];
              $fechaOferta    = $dataCotiza['fechaOferta'];
              $tiempoEntrega  = $dataCotiza['tiempoEntrega'];
              $comentarios    = $dataCotiza['comentarios'];
              $fechaRegistro  = $dataCotiza['fecha'];
              $horaRegistro   = $dataCotiza['hora'];
              $Q_Cliente      = mysqli_query($MySQLi, "SELECT nombre,celular,correo FROM clientes WHERE idCliente='$idCliente' ");
              $dataCliente    = mysqli_fetch_assoc($Q_Cliente);
              $Q_Usuario      = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUser' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
              $dataUsuario    = mysqli_fetch_assoc($Q_Usuario); ?>
    <tr>
      <td class="text-center pt-5"><?= $idCotizacion ?></td>
      <!-- DATOS REGISTRO -->
      <!-- <td>
        <div class="table-responsive">
          
        </div>
      </td> -->
      <!-- DETALLES COTIZACION -->
      <td>
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-striped w-100" style="font-size: 10px;">
            <tr>
              <th>Cliente</th>
              <td><?= $dataCliente['nombre'] ?></td>
              <th>Celular</th>
              <td><?= $dataCliente['celular'] ?></td>
              <th>Código</th>
              <td><?= $codigo ?></td>
            </tr>
            <tr>
              <th>Vendedor</th>
              <td><?= $dataUsuario['Nombre'] ?></td>
              <th>Fecha</th>
              <td><?= fechaFormato($fechaRegistro) ?></td>
              <th>Hora</th>
              <td><?= formatoHora($horaRegistro) ?></td>
            </tr>
          </table>
          <table class="table table-sm table-bordered table-striped w-100" style="font-size: 10px;">
            <thead>
              <tr class="bg-primary text-white">
                <th width="5%" class="text-center">Cantidad</th>
                <th width="50%" class="text-center">Descripción</th>
                <th width="15%" class="text-center">Precio venta</th>
                <th width="15%" class="text-center">Precio oferta</th>
                <th width="15%" class="text-center">Total</th>
              </tr>
            </thead>
            <tbody><?php
                    $Q_clavesTemp     = mysqli_query($MySQLi, "SELECT ventas.idProducto, ventas.cantidad, 
                    IF(ventas.idMoneda=1, ventas.precioVenta1, ventas.precioVenta2) precioVenta, 
                    IF(ventas.idMoneda=1, ventas.precioEspecial1, ventas.precioEspecial2) precioEspecial,
                    IF(ventas.idMoneda=1, ventas.totalVenta1, ventas.totalVenta2) precioTotal,
                    monedas.simbolo
                    FROM ventas 
                    LEFT JOIN monedas ON ventas.idMoneda = monedas.idMoneda
                    WHERE idCotizacion='$idCotizacion' ");
                    while ($dataClaves = mysqli_fetch_assoc($Q_clavesTemp)) {
                      $simbolo = $dataClaves['simbolo'];
                      echo '
                <tr>
                  <td class="text-center">' . $dataClaves['cantidad'] . '</td>';
                      $idProducto   = $dataClaves['idProducto'];
                      $Q_Productos  = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
                      $dataProducto = mysqli_fetch_assoc($Q_Productos);
                      $nombreProducto = $dataProducto['mercaderia'] . " " . $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'];
                      echo '
                  <td>' . $nombreProducto . '</td>
                  <td class="text-right">' . $dataClaves['simbolo'] . ' &nbsp; ' . number_format($dataClaves['precioVenta'], 2) . '</td>
                  <td class="text-right">' . $dataClaves['simbolo'] . ' &nbsp; ' . number_format($dataClaves['precioEspecial'], 2) . '</td>
                  <td class="text-right">' . $dataClaves['simbolo'] . ' &nbsp; ' . number_format($dataClaves['precioTotal'], 2) . '</td>
                </tr>';
                    } ?>
              <tr>
                <th colspan="4" class="text-right text-danger">TOTAL</th><?php
                                                                          $Q_Total  = mysqli_query($MySQLi, "SELECT SUM(IF(ventas.idMoneda=1, ventas.totalVenta1, ventas.totalVenta2))AS Total FROM ventas WHERE idCotizacion='$idCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                                          $dataTotal = mysqli_fetch_assoc($Q_Total); ?>
                <th class="text-right"><?= $simbolo . ' &nbsp; ' . number_format($dataTotal['Total'], 2) ?></th>
              </tr>
            </tbody>
          </table>
        </div>
        <input type="hidden" id="claveCotizacion" value="<?= $clave ?>">
        <div class="text-center" style="margin-top: -1.5%;"><?php
                                                            $Q_NotaEntrega  = mysqli_query($MySQLi, "SELECT idNotaE FROM notaEntrega WHERE idCotizacion='$idCotizacion' ");
                                                            $dataNotaEntrega = mysqli_fetch_assoc($Q_NotaEntrega);
                                                            $idNotaEntrega  = $dataNotaEntrega['idNotaE'];
                                                            $Q_Recibo       = mysqli_query($MySQLi, "SELECT idRecibo FROM recibos WHERE idCotizacion='$idCotizacion' ");
                                                            $dataRecibo     = mysqli_fetch_assoc($Q_Recibo);
                                                            $idRecibo       = $dataRecibo['idRecibo']; ?>
          <!--  funciona este btn crear nota de entrega-->
          <!-- <a target="_blank" href="pdf.php?idNotaEntrega=<?= $idNotaEntrega ?>" class="mx-2 btn btn-primary btn-md btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar nota de entrega"><i class="fad fa-cloud-download"></i></a> -->
          <!--  funciona este btn crear recibo -->
          <!-- <a target="_blank" href="pdf.php?idRecibo=<?= $idRecibo ?>" class="mx-2 btn btn-success btn-md btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar recibo"><i class="fad fa-cloud-download"></i></a> -->
          <a target="_blank" href="reportes/reporte_nota_de_venta.php?idNotaEntrega=<?= $idNotaEntrega ?>" class="mx-2 btn btn-primary btn-md btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="DESCARGAR NOTA DE VENTA"><i class="fad fa-cloud-download"></i></a>
         
          <button class="mx-2 btn btn-success btn-md btn-icon rounded-circle waves-effect waves-themed btn_modal_editar_nota_venta" title="EDITAR NOTA DE VENTA <?php echo $idNotaEntrega; ?>" id="<?php echo $idNotaEntrega; ?>"><i class="fad fa-cloud-upload" data-toggle="tooltip" title="" data-original-title="EDITAR NOTA DE VENTA <?php echo $idNotaEntrega; ?>" style="font-size: 15px"></i>
          </button>

          <button class="mx-2 btn btn-info btn-md btn-icon rounded-circle waves-effect waves-themed btnFacturaModalCargarDatos" title="EMITIR FACTURA <?php echo $idCotizacion; ?>" data-toggle="modal" data-target="#modalFacturaFR" data-dismiss="modal" id="<?php echo $idCotizacion; ?>"><i class="fas fa-file-invoice" data-toggle="tooltip" title="" data-original-title="EMITIR FACTURA <?php echo $idCotizacion; ?>" style="font-size: 15px"></i>
          </button>
          <button id="<?= $idCotizacion ?>" class="mx-2 btn btn-danger btn-md btn-icon rounded-circle waves-effect waves-themed borrar_venta" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Volver a Generada <?= $idCotizacion ?>"><i class="fal fa-pencil"></i></button>
        </div>
      </td>
    </tr><?php
            }
          }
          function listaPlantillasHTML($MySQLi)
          {
            $Q_Plantillas = mysqli_query($MySQLi, "SELECT * FROM plantillasHTML");
            $numero       = 1;
            while ($data  = mysqli_fetch_assoc($Q_Plantillas)) {
              echo '
    <tr>
      <td>' . $numero . '</td>
      <td>' . $data['nombre'] . '</td>
      <td class="text-center">
        <button id=' . $data['idPlantilla'] . ' class="mx-1 btn btn-primary btn-sm btn-icon rounded-circle waves-effect waves-themed modal_verPlantilla" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Visualizar plantilla"><i class="fal fa-eye"></i></button>
        <button id=' . $data['idPlantilla'] . ' class="mx-1 btn btn-success btn-sm btn-icon rounded-circle waves-effect waves-themed editarPlantilla" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar plantilla"><i class="fal fa-edit"></i></button>
      </td>
    </tr>';
              $numero++;
            }
          }
          function medidasHoja($MySQLi)
          {
            $Q_Medidas  = mysqli_query($MySQLi, "SELECT idHoja,nombre FROM hojas WHERE estado=1 ORDER BY nombre ASC ");
            while ($data = mysqli_fetch_assoc($Q_Medidas)) {
              echo '<option value=' . $data['idHoja'] . '>' . $data['nombre'] . '</option>';
            }
          }
          //COPIADO DEL EJEMPLO EQUIMSARA ----------------------------------------------------------------


          //Funciones a usar en Equimport
          function alertaFormulario()
          {
            echo '<div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true"><i class="fal fa-times-square"></i></span>
    </button>
    <strong>Puntos a tomar en cuenta, mientras se familiariza con el sistema:</strong><br><br>
    - Cuenta con 2 opciones: &nbsp; <i><b>Añadir otro equipo</b></i> &nbsp; o &nbsp; <i><b>No añadir mas equipos y continuar</b></i><br>
    Al presionar el botón: <button class="btn btn-primary btn-xs" type="button">Añadir otro equipo</button> &nbsp; deberá llenar todos los campos, ya que son obligatorios.<br>Sí todos los campos estan llenos, se mostrará una tabla con algunos datos del registro.<br>
    <img src="assets/img/ejemplos/tabla.png" alt="tabla" width="100%"><br>Los cuales podrá editar o borrar si así lo desea; pero, los datos del formulario se <i><b>borraran</b></i> (el formulario será limpiado), para que <i><b>Tenga que</b></i> (de caracter obligatorio) ingresar nuevos datos para el próximo equipo a registrar. &nbsp;&nbsp;<b>Qué quiere decir esto?</b><br>
    Que <b>NO podrá </b> preionar el botón <button class="btn btn-primary btn-xs" type="button">No añadir mas equipos y continuar</button> estando los campos del formulario vacío.<br>Sí cumple con los requerimientos del formulario y presiona el botón, los datos del nuevo registro + los mostrados en la tabla, se guardaran en un solo archivo y se mostraran en el siguiente paso que será: <i><b>En reparación.</b></i>
  </div>';
          }
          // function fechaFormato($fecha){
          //   $newFecha = date('d-m-Y', strtotime($fecha));
          //   return $newFecha;
          // }
          function fechaLetras($fecha)
          {
            $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $dia  = $dias[date('w', strtotime($fecha))];
            $diaNumero = date('d', strtotime($fecha));
            $mes  = $meses[date('n', strtotime($fecha)) - 1];
            $Year = date('Y');
            $Fecha = $dia . ", " . $diaNumero . " de " . $mes . " de " . $Year;
            return $Fecha;
          }
          function fechaLetras2($fecha)
          {
            $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
            $meses = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $dia  = $dias[date('w', strtotime($fecha))];
            $diaNumero = date('d', strtotime($fecha));
            $mes  = $meses[date('n', strtotime($fecha)) - 1];
            $Year = date('Y', strtotime($fecha));
            $Fecha = $diaNumero . " de " . $mes . " de " . $Year;
            return $Fecha;
          }
          function noCambiosUsuario()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'uuups!',
      'Los datos del formulario no han cambiado, si desea modicar los datos, haga los respectivos cambios.',
      'error'
    )
  </script><?php
          }
          function registroServicioGuardado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Ficha de servicio guardada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=registrados");
    }, 2000);
  </script><?php
          }
          function usuarioActualizado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO ACTUALIZADO!',
      'Los datos del usuario fueron cambiados.',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500)
  </script><?php
          }
          function productoSoporteActualizado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'EQUIPO ACTUALIZADO!',
      '',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500)
  </script><?php
          }
          function equipoBorrado_soporteClave()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'EQUIPO BORRADO',
      '',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500)
  </script><?php
          }
          function productoBorrado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Producto borrado!',
      'El producto seleccionado fué eliminado de la base de datos.',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500)
  </script><?php
          }
          function equipoReparado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Orden reparada!',
      'Los datos fueron guardados correctamente y la orden pasa a Reparados.',
      'success'
    )
    setTimeout(function() {
      location.replace("?root=reparados");
    }, 2500)
  </script><?php
          }
          function fichaServicioActualizada()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Ficha servicio actualizado!',
      '',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500)
  </script><?php
          }
          function fichaTecnicaBorrada()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Ficha de servicio eliminada!',
      'La ficha de reparación ha sido eliminada definitivamente',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500)
  </script><?php
          }
          function costosIngresados()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos ingresados correctamente!',
      'Los costos de cada unos de los equipos y el trabajo a realizar fueron ingresados correctamente.',
      'success'
    )
    setTimeout(function() {
      location.replace("?root=enReparacion");
    }, 3000)
  </script><?php
          }
          function fichaRegistroGuarada()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Ficha de servicio Guarada!',
      'Los datos de la ficha de servicio fueron guardados exitosamente!',
      'success'
    )
    setTimeout(function() {
      location.replace('?root=enReparacion');
    }, 2500)
  </script><?php
          }
          function equipoEntregado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos guardados!',
      'Los datos se guardaron correctamente y la ficha ha sido marcada como entregada!',
      'success'
    )
    setTimeout(function() {
      location.replace('?root=entregados');
    }, 2500)
  </script><?php
          }
          function reparacionGuardada()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Equipo Reparado!',
      'El equipo reparado pasará a la lista de reparados',
      'success'
    )
    setTimeout(function() {
      location.replace('?root=reparados');
    }, 2500)
  </script><?php
          }
          // function precioDolar($MySQLi) {
          //   $queryDolar = mysqli_query($MySQLi,"SELECT * FROM preciodolar");
          //   $dataDolar  = mysqli_fetch_assoc($queryDolar);
          //   $PrecioDolar= $dataDolar['precio'];
          //   echo $PrecioDolar;
          // }
          function cotizacionGenerada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización generada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=generadas");
    }, 2000);
  </script><?php
          }
          function cotizacionGeneradayEntregada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización Generada y Entregada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=entregadas");
    }, 2000);
  </script><?php
          }
          function cotizacionyClienteGenerada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización y Cliente Generados!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=generadas");
    }, 2000);
  </script><?php
          }
          function productoActualizado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Producto actualizado!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=productos");
    }, 2000);
  </script><?php
          }
          function otroEquipoAgregado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Equipo agregado!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script><?php
          }
          function cotizacionEntregadayClienteGuardado()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización Entregada y Cliente Guardado!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=entregadas");
    }, 2000);
  </script><?php
          }
          function cotizacionActualizada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización Actualizada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.reload();
    }, 2000);
  </script><?php
          }
          function ordenIndividualCancelada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Orden individual cancelada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=cancelados");
    }, 2000);
  </script><?php
          }
          function ordenTotalCancelada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Orden cancelada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=cancelados");
    }, 2000);
  </script><?php
          }
          function ordenRestaurada()
          { ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Orden restaurada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function() {
      location.replace("?root=registrados");
    }, 2000);
  </script><?php
          }
          function equipsRegistrados($MySQLi, $Q_Servicio)
          {
            while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) {
              $Clave    = $dataServicio['clave_soporte'];
              $Q_Fichas = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=0 ");
              $R_Fichas = mysqli_num_rows($Q_Fichas);
              if ($R_Fichas > 0) {

            ?>
      <tr>
        <td class="text-center pt-4"><?= $dataServicio['idSoporte'] ?></td>
        <td>
          <table>
            <tr>
              <th class="btn-primary">Nombre Cliente</th>
              <td><?= $dataServicio['nombreCliente'] ?></td>
            </tr>
            <tr>
              <th class="btn-secondary">Fecha de registro</th>
              <td><?= fechaLetras2($dataServicio['fechaRegistro']) ?></td>
            </tr>
            <tr>
              <th class="btn-warning">Dirección en la cual se realizará el Servicio Técnico</th>
              <td><?= $dataServicio['direccion'] ?></td>
            </tr>
            <tr>
              <th class="btn-info">Sucursal Encargada</th>
              <td><?= $dataServicio['sucursal'] ?></td>
            </tr>
          </table>
          <table class="table table-bordered table-hover table-sm table-striped w-100">
            <thead>
              <tr>
                <th width="15%" class="text-center">Equipo</th>
                <th width="1%" class="text-center">Garantia Repuesto</th>
                <th width="1%" class="text-center">Garantia Mano de Obra</th>
                <th class="text-center">Fecha Compra</th>
                <th width="5%" class="text-center">N&ordm; Nota de Entrega</th>
                <th class="text-center">Problema</th>
                <th class="text-center">Observaciones</th>
                <th width="1%" class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody><?php
                    while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) {
                      echo '
            <tr>
              <td>[Nombre] ' . $dataFichas['equipo'] . '<br>[Marca] ' . $dataFichas['marca'] . '<br>[Modelo] ' . $dataFichas['modelo'] . '</td>
              <td class="text-center">' . $dataFichas['garantia_vigente_repuesto'] . '</td> 
              <td class="text-center">' . $dataFichas['garantia_vigente_mano'] . '</td>      
              <td class="text-center">' . $dataFichas['fechaCompra'] . '</td>
              <td class="text-center">' . $dataFichas['notaEntrega'] . '</td>
              <td>' . $dataFichas['problema'] . '</td>
              <td>' . $dataFichas['observaciones'] . '</td>
              <td class="text-center">

                <button id=' . $dataFichas['idClave'] . '
                class="btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed btnDiagnosticoCargarDatosAjax"
                data-toggle="modal" data-target="#modalDiagnosticoEquipo"
                data-dismiss="modal" id="' . $dataFichas['idClave'] . '">
                <i class="fa fa-wrench" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" 
                data-toggle="tooltip" title="" data-original-title="Agregar Diagnostico (' . $dataFichas['idClave'] . ')"></i></button>&nbsp;
                <br/>
                <a target="_blank" href="reportes/reporteDiagnosticoEquipo.php?idClave=' . $dataFichas['idClave'] . '&sucursal=' . $dataServicio['sucursal'] . '&idSoporte=' . $dataServicio['idSoporte'] . '" class="btn btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed downloadPDF" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-secondary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a>
                <br/>
                <a target="_blank" href="reportes/reporteDiagnosticoEquipoWord.php?idClave=' . $dataFichas['idClave'] . '&sucursal=' . $dataServicio['sucursal'] . '&idSoporte=' . $dataServicio['idSoporte'] . '" class="mt-2 btn btn-dark btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en Word para el técnico"><i class="fal fa-file-word"></i></a>

                <br/>
                <button id=' . $dataFichas['idClave'] . '
                class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_cancelarOrden_individual"
                data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip"
                title="" data-original-title="Remover este equipo de la orden de reparación"><i class="ni ni-ban"></i></button>

                
                
              </td>
            </tr>';
                    } ?>
            </tbody>
          </table>
        </td>
        <td>
          <br>
          <button id="<?= $Clave ?>" class="mt-2 btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_AddEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar otro equipo"><i class="fal fa-plus"></i></button><br>

          <button id="<?= $dataServicio['clave_soporte'] ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_ingresartaller" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar a taller"><i class="far fa-handshake"></i></button><br>

          <a target="_blank" href="reportes/reporteRecepcionEntrega.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&Sucursal=<?= $dataServicio['sucursal'] ?>&servicio=1" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed downloadPDF" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar Comprobante Recepción PDF <?php echo $dataServicio['sucursal'] ?>"><i class="fal fa-file-pdf"></i></a><br>
          <a target="_blank" href="reportes/reporteRecepcionEntregaWord.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&Sucursal=<?= $dataServicio['sucursal'] ?>&servicio=1" class="mt-2 btn btn-dark btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar Comprobante Recepción Word <?php echo $dataServicio['sucursal'] ?>"><i class="fal fa-file-word"></i></a>

          <!-- <a target="_blank" href="hojadeservicio.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&Sucursal=<?php //$dataServicio['sucursal'] 
                                                                                                                ?>&servicio=tecnico" class="btn mt-2 btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-light-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a> -->
        </td>
      </tr><?php
              }
            }
          }
          function equipsRegistradosxSucursal($MySQLi, $Q_Servicio, $sucursalPrimaria)
          {
            while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) { ?>
    <tr>
      <td class="text-center pt-4"><?= $dataServicio['idSoporte'] ?></td>
      <td>
        <table>
          <tr>
            <th>Nombre Cliente</th>
            <td><?= $dataServicio['nombreCliente'] ?></td>
          </tr>
          <tr>
            <th>Fecha de registro</th>
            <td><?= fechaLetras2($dataServicio['fechaRegistro']) ?></td>
          </tr>
        </table>
        <table class="table table-bordered table-hover table-sm table-striped w-100">
          <thead>
            <tr>
              <th class="text-center">Equipo</th>
              <th class="text-center">Marca</th>
              <th class="text-center">Modelo</th>
              <th class="text-center">Serie</th>
              <th class="text-center">Garantia</th>
              <th class="text-center">Fecha Compra</th>
              <th class="text-center">N&ordm; Factura</th>
              <th class="text-center">Problema</th>
              <th class="text-center">Observaciones</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody><?php
                  $Clave    = $dataServicio['clave_soporte'];
                  $Q_Fichas = mysqli_query($MySQLi, "SELECT* FROM soporte_claves WHERE clave='$Clave' AND estado=0 ");
                  $R_Fichas = mysqli_num_rows($Q_Fichas);
                  while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) {
                    echo '
            <tr>
              <td>' . $dataFichas['equipo'] . '</td>
              <td>' . $dataFichas['marca'] . '</td>
              <td>' . $dataFichas['modelo'] . '</td>
              <td>' . $dataFichas['serie'] . '</td>
              <td class="text-center">' . $dataFichas['garantia'] . '</td>';
                    if ($dataFichas['garantia'] == 'si') {
                      echo '
                <td class="text-center">' . $dataFichas['fechaCompra'] . '</td>
                <td class="text-center">' . $dataFichas['numFactura'] . '</td>';
                    } else {
                      echo '
                <td class="text-center"><i>No aplica</i></td>
                <td class="text-center"><i>No aplica</i></td>';
                    }
                    echo '
              <td>' . $dataFichas['problema'] . '</td>
              <td>' . $dataFichas['observaciones'] . '</td>
              <td class="text-center">
                <a target="_blank" href="fichaTecnica.php?idClave=' . $dataFichas['idClave'] . '&sucursal=' . $dataServicio['sucursal'] . '&idSoporte=' . $dataServicio['idSoporte'] . '" class="btn btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-secondary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a>

                <button id=' . $dataFichas['idClave'] . ' class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_cancelarOrden_individual" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Remover este equipo de la orden de reparación"><i class="ni ni-ban"></i></button>

                <button id=' . $dataFichas['idClave'] . ' class="btn btn-success btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_editInfoEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar información del producto (' . $dataFichas['idClave'] . ')"><i class="fal fa-pencil"></i></button>&nbsp;
                
              </td>
            </tr>';
                  } ?>
          </tbody>
        </table>
      </td>
      <td class="text-center">
        <button id="<?= $Clave ?>" class="mt-2 btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_AddEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar otro equipo"><i class="fal fa-plus"></i></button><br>

        <button id="<?= $dataServicio['clave_soporte'] ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_ingresacostos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar a taller"><i class="far fa-handshake"></i></button><br>

        <a target="_blank" href="hojadeservicio.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&Sucursal=<?= $dataServicio['sucursal'] ?>&servicio=1" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar hoja de servicio en PDF"><i class="fal fa-file-pdf"></i></a><br>

        <!-- <a target="_blank" href="hojadeservicio.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&Sucursal=<?php //$dataServicio['sucursal'] 
                                                                                                              ?>&servicio=tecnico" class="btn mt-2 btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-light-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a> -->
      </td>
    </tr><?php
            }
          }
          function equipsCancelados($MySQLi, $Q_Servicio)
          {
            while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) {
              $clave  = $dataServicio['clave'];
              $Q_Clave = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE clave_soporte='$clave'");
              $dataClv = mysqli_fetch_assoc($Q_Clave); ?>
    <tr>
      <td class="text-center pt-4"><?= $dataClv['idSoporte'] ?></td>
      <td>
        <table>
          <tr>
            <th class="btn-primary">Nombre Cliente</th>
            <td><?= $dataClv['nombreCliente'] ?></td>
          </tr>
          <tr>
            <th class="btn-secondary">Fecha de registro</th>
            <td><?= fechaLetras2($dataClv['fechaRegistro']) ?></td>
          </tr>
          <tr>
            <th class="btn-info">Sucursal</th>
            <td><?= $dataClv['sucursal'] ?></td>
          </tr>
        </table>
        <table class="table table-bordered table-hover table-sm table-striped w-100">
          <thead>
            <tr>
              <th class="text-center">Equipo</th>
              <th width="1%" class="text-center">Garantia Repuesto</th>
              <th width="1%" class="text-center">Garantia Mano de Obra</th>
              <th class="text-center">Fecha Compra</th>
              <th width="5%" class="text-center">N&ordm; Nota de Entrega</th>
              <th class="text-center">Problema</th>
              <th class="text-center">Observaciones</th>
              <!-- <th class="text-center">Acciones</th> -->
            </tr>
          </thead>
          <tbody><?php
                  $Clave    = $dataClv['clave_soporte'];
                  $Q_Fichas = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=4 ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                  $R_Fichas = mysqli_num_rows($Q_Fichas);
                  while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) {
                    echo '
            <tr>
              <td>[Nombre] ' . $dataFichas['equipo'] . '<br>[Marca] ' . $dataFichas['marca'] . '<br>[Modelo] ' . $dataFichas['modelo'] . '</td>
              <td class="text-center">' . $dataFichas['garantia_vigente_repuesto'] . '</td> 
              <td class="text-center">' . $dataFichas['garantia_vigente_mano'] . '</td>
              <td class="text-center">' . $dataFichas['fechaCompra'] . '</td>
              <td class="text-center">' . $dataFichas['notaEntrega'] . '</td>
              <td>' . $dataFichas['problema'] . '</td>
              <td>' . $dataFichas['observaciones'] . '</td>
              ';
                    if ($dataClv['estado'] != '3') {
                      echo '<!-- <td class="text-center"><button id=' . $dataFichas['idClave'] . ' class="mt-2btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed restaurarOrdenSoporte" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Restaurar orden de reparación"><i class="far fa-paper-plane"></i></button></td> -->';
                    } else {
                      echo '<!-- <td class="text-center">Ya se realizo la Entrega<br> del grupo al que pertenecia este Equipo</td> -->';
                    }
                    echo '</tr>
              <tr>
              <th colspan="3">Motivo de la cancelación</th>
              <td colspan="5">' . $dataFichas['motivo'] . '</td>
            </tr> ';
                  } ?>
          </tbody>
        </table>
      </td>
    </tr><?php
            }
          }
          //funciones utilizadas en este script

          function listaClientes($MySQLi, $idUser, $idRango)
          {
            if ($idRango > 2) {
              $Q_misClientes    = mysqli_query($MySQLi, "SELECT * FROM clientes ORDER BY Nombre ASC ");
            } else {
              $Q_misClientes    = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idRegistrador='$idUser' ORDER BY Nombre ASC ");
            }
            $Num = 1;
            while ($dataClientes = mysqli_fetch_assoc($Q_misClientes)) {
              $idCliente = $dataClientes['idCliente'];
              echo '
    <tr>
      <td class="text-center">' . $Num . '</td>
      <td>' . $dataClientes['Nombre'] . '</td>
      <td>' . $dataClientes['Correo'] . '</td>
      <td class="text-center">';
              if ($dataClientes['Codigo'] != '' and $dataClientes['Telefono'] != '') {
                echo '(' . $dataClientes['Codigo'] . ") " . $dataClientes['Telefono'];
              } else {
                echo '';
              }
              if ($dataClientes['ApiTelegram'] != '') {
                echo '
          <button class="btn btn-primary btn-sm btn-icon rounded-circle modalTelegram"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Enviar mensaje por Telegram" id=' . $dataClientes['idCliente'] . '><i class="fal fa-paper-plane"></i></button>';
              }
              echo '
      </td>
      <td>' . $dataClientes['por'] . '</td>
      <td class="text-center">';
              misDispositivos($MySQLi, $idCliente);
              echo '</td>
      <td class="text-center">
      <button class="btn btn-primary btn-sm btn-icon rounded-circle add_Device"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Añadir un dispositivo a este cliente" id="' . $dataClientes['idCliente'] . '"><i class="fal fa-plus-circle"></i></button>&nbsp;&nbsp;&nbsp;
        <button class="btn btn-primary btn-sm btn-icon rounded-circle editarCliente"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar cliente" id="' . $dataClientes['idCliente'] . '"><i class="far fa-user-edit"></i></button>&nbsp;&nbsp;&nbsp;
        <button  id="' . $dataClientes['idCliente'] . '" class="btn btn-danger btn-sm btn-icon rounded-circle borrarCliente" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar cliente"><i class="far fa-trash-alt"></i></button>
      </td>
    </tr>';
              $Num++;
            }
          }
          // function listaUsuarios($MySQLi, $idUser, $idRango){
          //   $Num              = 1;
          //   $Q_Users          = mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE estado=1 ORDER BY nombre ASC ");
          //   while ($dataUsers = mysqli_fetch_assoc($Q_Users)) { echo'
          //     <tr>
          //       <td class="text-center">'.$Num.'</td>
          //       <td>'.$dataUsers['nombre'].'</td>
          //       <td>'.$dataUsers['sexo'].'</td>
          //       <td>'.$dataUsers['cargo'].'</td>
          //       <td>'.$dataUsers['telefono'].'</td>
          //       <td>'.$dataUsers['email'].'</td>
          //       <td>'.$dataUsers['ciudad'].'</td>
          //       <td>'.$dataUsers['uss'].'</td>
          //       <td>'.$dataUsers['pass'].'</td>
          //       <td class="text-center">
          //         <button class="btn btn-primary btn-sm btn-icon rounded-circle openModal_editarUsuario"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar usuaio" id='.$dataUsers['id'].'><i class="far fa-user-edit"></i></button>&nbsp;';
          //         if ($dataUsers['estado']==1) { echo'<button class="btn btn-danger btn-sm btn-icon rounded-circle turnOff" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Desactivar usuario" id='.$dataUsers['id'].'><i class="far fa-power-off"></i></button>';
          //         }else{ echo'<button class="btn btn-success btn-sm btn-icon rounded-circle turnON" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Activar usuario" id='.$dataUsers['id'].'><i class="far fa-power-off"></i></button>';
          //         } echo'
          //       </td>
          //     </tr>'; $Num++;
          //   }
          // }
          function listamisDispositivos($MySQLi, $idUser, $idRango)
          {
            if ($idRango > 2) {
              $Q_misDispositivos    = mysqli_query($MySQLi, "SELECT * FROM dispositivos WHERE FMI='ON' ORDER BY idDispositivo ASC ");
            } else {
              $Q_misDispositivos    = mysqli_query($MySQLi, "SELECT * FROM dispositivos WHERE idUser='$idUser' AND FMI='ON' ORDER BY idDispositivo ASC ");
            }
            $Num = 1;
            while ($dataDispositivo = mysqli_fetch_assoc($Q_misDispositivos)) {
              $DispoName            = $dataDispositivo['Nombre'] . " " . $dataDispositivo['Modelo'] . " " . $dataDispositivo['Color'] . " " . $dataDispositivo['Capacidad'];
              echo '
    <tr>
      <td class="text-center">' . $Num . '</td>';
              $idCliente          = $dataDispositivo['idCliente'];
              $Q_Cliente          = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idCliente='$idCliente' ");
              $dataCliente        = mysqli_fetch_assoc($Q_Cliente);
              echo '
      <td>' . $dataCliente['Nombre'] . '</td>
      <td>' . $dataDispositivo['IMEISERIAL'] . '</td>
      <td>' . $DispoName . ' &nbsp;
        <button class="btn btn-primary btn-sm btn-icon rounded-circle modal_editDispoName" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar estos datos del dispositivo seleccionado" id=' . $dataDispositivo['idDispositivo'] . '><i class="fal fa-edit"></i></button>
      </td>
      <td class="text-center">
        <button class="btn btn-primary btn-block btn-sm listarTelefonos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="click para mostrar el o los teléfonos registrados a este dispositivo" id=' . $dataDispositivo['idDispositivo'] . '>Teléfono</button></td>
      <td class="text-center">
        <button class="btn btn-primary btn-block btn-sm listarCorreos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="click para mostrar el o los correos registrados a este dispositivo" id=' . $dataDispositivo['idDispositivo'] . '>Correo</button></td>
      <td class="text-center">
        <button class="btn btn-danger btn-sm btn-icon rounded-circle checkFMI" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner fmiCheck bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Este dispositivo en lista aparece como ON, si desea consultar su status actual, haga click" id=' . $dataDispositivo['IMEISERIAL'] . '>ON</button>
      </td>
      <td class="text-center">';
              $idDispositivo  = $dataDispositivo['idDispositivo'];
              $Q_PhoneDispo   = mysqli_query($MySQLi, "SELECT * FROM telefonos_dispositivos WHERE idDispositivo='$idDispositivo' ");
              $ResultQPhoneDis = mysqli_num_rows($Q_PhoneDispo);
              if ($ResultQPhoneDis > 0) {
                $dataPhoneDisp = mysqli_fetch_assoc($Q_PhoneDispo);
                if ($dataPhoneDisp['Telefono'] != '') {
                  echo '
            <button class="btn btn-primary btn-sm btn-icon rounded-circle modalSMS" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Procesar por SMS" id=' . $dataPhoneDisp['idDispositivo'] . '><i class="fal fa-sms"></i></button>&nbsp;&nbsp;&nbsp;';
                }
              }
              $Q_MailDispo    = mysqli_query($MySQLi, "SELECT * FROM correos_dispositivos WHERE idDispositivo='$idDispositivo' ");
              $ResultQMailDisp = mysqli_num_rows($Q_MailDispo);
              if ($ResultQMailDisp > 0) {
                $dataMailDispo = mysqli_fetch_assoc($Q_MailDispo);
                if ($dataMailDispo['Correo'] != '') {
                  echo '
            <button class="btn btn-info btn-sm btn-icon rounded-circle modalCorreo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Procesar por correo" id=' . $dataDispositivo['idDispositivo'] . '><i class="fal fa-envelope-open-text"></i></button>&nbsp;&nbsp;&nbsp;';
                }
              }
              echo '
        <button class="btn btn-danger btn-sm btn-icon rounded-circle borrarDispositivo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar dispositivo" id=' . $dataCliente['idCliente'] . '><i class="fal fa-trash-alt"></i></button>
      </td>
    </tr>';
              $Num++;
            }
          }
          // function error404(){
          //   echo'
          //   <div class="h-alt-f d-flex flex-column align-items-center justify-content-center text-center">
          //     <h1 class="page-error color-fusion-500">
          //       ERROR <span class="text-gradient">404</span>
          //       <small class="fw-500">Algo <u>está</u> mal!</small>
          //     </h1>
          //     <h3 class="fw-500 mb-5">
          //       La página que solicitaste no existe <br>ó aún está en construcción.</h3>
          //     <h4>Si crees que esto es un error, notifica al Administrador.
          //     </h4>
          //   </div>';
          // }
          //funciones no utilizadas

          function recoveryPswd()
          { ?>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle1">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Cras mattis consectetur purus sit amet fermentum. </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div><?php
          }
          function expirado($MySQLi)
          {
            mysqli_close($MySQLi);
            session_destroy(); ?>
  <script type="text/javascript">
    Swal.fire(
      'SESSION EXPIRADA',
      'La sessión expiró, vuelve a ingresar al sistema para efectuar el cambio solicitado',
      'error'
    )
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script> <?php
          }
          function sinAutorizacion($MySQLi)
          {
            mysqli_close($MySQLi); ?>
  <script type="text/javascript">
    Swal.fire(
      'SIN AUTORIZACIÓN',
      'No posees los permisos para esta acción.',
      'error'
    )
  </script> <?php
          }
          function noPermitido()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'ACCIÓN NO PERMITIDA',
      'No es posible desactivar o eliminar a un administrador.<br>Si deseas efectuar esta acción, tendrás que solicitarla al Programador!',
      'error'
    )
  </script> <?php
          }
          function usuarioDesactivado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      "Deshabilitado!",
      "El usuario seleccionado ha sido deshabilitado.",
      "success"
    );
    setTimeout(function() {
      location.reload()
    }, 3500);
  </script> <?php
          }
          function usuarioActivado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO ACTIVADO',
      'El usuario seleccionado, ha sido habilitado.',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script> <?php
          }
          function adminActualizoUsuario()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO actualizado',
      'Los datos del usuario seleccionado fueron cambiados.',
      'success'
    )
    setTimeout(function() {
      location.reload()
    }, 2500);
  </script> <?php
          }
          function errorToken($MySQLi)
          {
            mysqli_close($MySQLi); ?>
  <script type="text/javascript">
    Swal.fire(
      'Petición desconocida',
      'la acción solicitada no existe o está fuera de servicio, favor de contactar con el Administrador.',
      'error'
    )
  </script> <?php
          }
          // function password($length = 8) { 
          //   $chars  = '0123456789';
          //   $count  = mb_strlen($chars);
          //   for ($i = 0, $result = ''; $i < $length; $i++) { 
          //     $index  = rand(0, $count - 1); 
          //     $result .= mb_substr($chars, $index, 1); 
          //   } 
          //   return $result; 
          // }
          function usuarioRegistrado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO REGISTRADO',
      'El usuario recibirá un correo donde encontrará su respectiva contraseña de ingreso al sistema.',
      'success'
    )
    // setTimeout(function(){
    //   location.reload()
    // },2500);
  </script><?php
          }
          function errorMail()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'ERROR!',
      'Hubo un error al intentar enviar el correo',
      'error'
    )
    // setTimeout(function(){
    //   location.reload()
    // },2500);
  </script><?php
          }
          function correoExiste()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'ERROR!',
      'El usuario no puede ser registrado, ya que el correo existe en la base de datos<br>Deberá solicitar al soporte que ese correo sea eliminado o cambie manualmente.',
      'error'
    )
  </script><?php
          }
          function elusuarioYaexiste()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'ERROR!',
      'El usuario no puede ser registrado, ya que existe en la base de datos<br>Deberá solicitar al soporte que ese correo sea eliminado o cambie manualmente.',
      'error'
    )
  </script><?php
          }


          function cuentaMailDesactivada()
          {
            mysqli_close($MySQLi); ?>
  <script type="text/javascript">
    Swal.fire(
      'Cuenta deshabilitada',
      'la cuenta mail seleccionada, ha sido deshabilitada.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          function cuentaMailActivada()
          {
            mysqli_close($MySQLi); ?>
  <script type="text/javascript">
    Swal.fire(
      'Cuenta habilitada',
      'la cuenta mail seleccionada, ha sido habilitada.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          function cuentaMailModificada()
          {
            mysqli_close($MySQLi); ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos actualizados',
      'Los datos del correo seleccionado, han sido modificados.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          function cuentaMailCreada()
          {
            mysqli_close($MySQLi); ?>
  <script type="text/javascript">
    Swal.fire(
      'Cuenta creada',
      'la cuenta ha sido creada exitosamente.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          function TeleEnviado()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Mensaje enviado',
      'El mensaje fue enviado exitosamente.',
      'success'
    )
    setTimeout(function() {
      Swal.close()
    }, 2500);
  </script> <?php
          }
          function nuevoClienteOK()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Cliente Registrado',
      'El nuevo cliente ha sido guardado en la base de datos.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          function ClienteUP_OK()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos actualizados',
      'Los datos del cliente fueron modificados.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          // function aleatorio(){
          //   $code   = uniqid();
          //   $code   = substr($code, -10);
          //   return $code;
          // }
          function fechaInicio($fechaINICIO)
          {
            $inicio   = explode("-", $fechaINICIO);
            $f_inicio = $inicio[2] . "-" . $inicio[1] . "-" . $inicio[0];
            return $f_inicio;
          }
          function fechaFin($fechaFIN)
          {
            $fin      = explode("-", $fechaFIN);
            $f_fin    = $fin[2] . "-" . $fin[1] . "-" . $fin[0];
            return $f_fin;
          }
          function apiTeleActualizada()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'Api Actualizada',
      'La Api fué actualizada con éxito.',
      'success'
    )
    setTimeout(function() {
      location.reload();
    }, 2500);
  </script> <?php
          }
          function apiTelesincambios()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'NO HAY CAMBIOS',
      'no encontramos cambios, así que no podemos guardar nada.',
      'error'
    )
  </script> <?php
          }
          function categoriaActualizada()
          { ?>
  <script type="text/javascript">
    Swal.fire(
      'CATEGORIA ACTUALIZADA',
      '',
      'success'
    )
    setTimeout(function() {
      location.replace("?root=categorias");
    }, 2500);
  </script> <?php
          }
// function contrasenaUPDATED(){ 
//   <script type="text/javascript">
//     Swal.fire(
//       'Contraseña actualizada.',
//       '',
//       'success'
//     )
//     setTimeout(function(){
//       location.reload();
//     },2500);
//   </script> <?php
// } 