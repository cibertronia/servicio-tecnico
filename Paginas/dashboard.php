<?php
require_once 'init.php';
require_once APP_PATH . '/reportes/servicios.php';
$_title       = 'Dashboard - ' . APP_TITLE;
$_active_nav  = 'Dashboard';
$_head        = ''; ?>
<!DOCTYPE html>
<html><?php include_once APP_PATH . '/includes/head.php'; ?>

<body class="mod-bg-1 mod-nav-link mod-skin-<?= $_theme ?> "><?php
                                                              include_once APP_PATH . '/includes/theme.php'; ?>
  <div class="page-wrapper">
    <div class="page-inner"><?php
                            include_once APP_PATH . '/includes/nav.php'; ?>
      <div class="page-content-wrapper"><?php
                                        include_once APP_PATH . '/includes/header.php'; ?>
        <main id="js-page-content" role="main" class="page-content" data-hasSearch="<?= isset($_POST['inicio']) ?>">
            <?php
            if ($idRangoDf == 2) {
              if ($serviPrecioUSD == 1) {
                echo '
                  Precio Dolar <strong>&nbsp;&nbsp;Bs&nbsp;&nbsp;</strong>
                  <form id="savePrecioDolar" class="">
                    <input type="hidden" name="action" value="updateDolar">
                    <input type="text" name="precio" id="precio" class="form-control-xs text-center text-danger" value=' . precioDolar($MySQLi) . '>
                    &nbsp;&nbsp;<button class="btn btn-primary btn-xs btnPrecioDolar">Actualizar</button>
                  </form>';
              }
              echo '<li class="position-absolute pos-top pos-right d-none d-sm-block text-danger">' . $Fecha . '</li></ol>'; ?>
              <!-- TARJETAS ADMIN -->
              <div id="panelAdmin" class="panel">
                <div class="panel-hdr">
                  <h2><?= $idSexoDf == 1 ? 'Bienvenido' : 'Bienvenida' ?> <span class="fw-300"><i><?= $nombreUsuarioDf ?></i> </span></h2>
                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content"><?php
                                              if ($idRangoDf > 1) {
                                                $Q_Sucursales   = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE estado=1");
                                                while ($dataSucursal = mysqli_fetch_assoc($Q_Sucursales)) {
                                                  if ($dataSucursal['idTienda'] == 1) {
                                                    $title = "CENTRAL " . strtoupper($dataSucursal['sucursal']);
                                                  } else {
                                                    $title = "SUCURSAL " . strtoupper($dataSucursal['sucursal']);
                                                  } ?>
                        <div class="row">
                          <div class="col-sm-12 col-md-12 col-lg-12 text-center">
                            <h4><?= $title ?></h4>
                          </div>
                        </div>
                        <div class="row my-2">
                          <!-- VENTAS DEL MES -->
                          <div class="col-sm-6 col-md-6 col-lg-4 my-2">
                            <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-primary' ?> rounded">
                              <a href="?root=reportes" class="d-flex flex-row align-items-center">
                                <div class="icon-stack display-3 flex-shrink-0">
                                  <i class="fal fa-circle icon-stack-3x opacity-100 color-success-400"></i>
                                  <i class="fad fa-sack-dollar icon-stack-1x opacity-100 color-success-500"></i>
                                </div>
                                <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                                  <strong>TOTAL INGRESOS
                                    <?php echo strtoupper($mes) ?></strong><br><br>
                                  <strong style="font-size: 16px;">
                                    <?php
                                                  $idTienda     = $dataSucursal['idTienda'];
                                                  $queryVentas  = mysqli_query($MySQLi, "SELECT SUM(totalVenta1)AS TotalVenta FROM ventas WHERE idSucursal='$idTienda' AND fecha BETWEEN '$startBusqueda' AND  '$fecha' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                  $dataVentas   = mysqli_fetch_assoc($queryVentas);
                                                  $TotalVentas  = $dataVentas['TotalVenta'];

                                                  // agregando total en USD 
                                                  $q_soporte_ventas  = mysqli_query($MySQLi, "SELECT SUM(total_cobrar_usd) AS total_cobrar_bs FROM soporte_ventas WHERE id_sucursal='$idTienda' AND fecha_completado BETWEEN '$startBusqueda' AND  '$fecha' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                  $d_soporte_ventas   = mysqli_fetch_assoc($q_soporte_ventas);
                                                  $total_soporte  = $d_soporte_ventas['total_cobrar_bs'];

                                                  echo '<span class="simboloMoneda"></span> ' . number_format(($total_soporte), 2);

                                    ?>
                                    </strong>


                                </div>
                              </a>
                            </div>
                          </div>
                          <!-- TOTAL CLIENTES -->
                          <div class="col-sm-6 col-md-6 col-lg-4 my-2">
                            <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-primary' ?> rounded">
                              <a href="?root=reportes" class="d-flex flex-row align-items-center">
                                <div class="icon-stack display-3 flex-shrink-0">
                                  <i class="fal fa-circle icon-stack-3x opacity-100 color-success-400"></i>
                                  <i class="fad fa-users-class icon-stack-1x opacity-100 color-success-500"></i>
                                </div>
                                <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                                  <strong>CLIENTES REGISTRADOS</strong><br><br>
                                  <strong style="font-size: 16px;"><?php
                                                                    $Q_Clientes = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idTienda='$idTienda' ");
                                                                    echo $resultClien = mysqli_num_rows($Q_Clientes); ?></strong>
                                </div>
                              </a>
                            </div>
                          </div>
                          <!-- COTIZACIONES ENTREGADAS -->
                          <div class="col-sm-6 col-md-6 col-lg-4 my-2">
                            <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-primary' ?> rounded">
                              <a href="?root=reportes" class="d-flex flex-row align-items-center">
                                <div class="icon-stack display-3 flex-shrink-0">
                                  <i class="fal fa-circle icon-stack-3x opacity-100 color-success-400"></i>
                                  <i class="fad fa-user-chart icon-stack-1x opacity-100 color-success-500"></i>
                                </div>
                                <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                                  <strong>COTIZACIONES DEL MES</strong><br><br>
                                  <strong style="font-size: 16px;"><?php
                                                                    $Q_Cotizaciones = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE idTienda='$idTienda'AND fecha BETWEEN '$startBusqueda'AND'$fecha' ");
                                                                    echo $resultCoti = mysqli_num_rows($Q_Cotizaciones); ?></strong>
                                </div>
                              </a>
                            </div>
                          </div>
                        </div><?php
                                                }
                                              } ?>
                  </div>
                </div>
              </div>
              <!-- PRODUCTOS MAS VENDIDOS -->
              <div id="panelAdmin2" class="panel">
                <div class="panel-hdr">
                  <h2>MAS VENDIDOS <span class="fw-300"><i class="text-uppercase"><?= $mes ?></i></span>
                  </h2>
                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content"><?php
                                              $Q_Ventas         = mysqli_query($MySQLi, "SELECT idVenta FROM ventas WHERE fecha BETWEEN '$startBusqueda' AND '$fecha' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                              $resultVentas     = mysqli_num_rows($Q_Ventas);
                                              // Verificamos si hay ventas
                                              if ($resultVentas > 0) {
                                                $Q_Productos    = mysqli_query($MySQLi, "SELECT * FROM productos WHERE estado=1");
                                                $resultProductos = mysqli_num_rows($Q_Productos); //nuemro de productos registrados

                                                $Q__Ventas      = mysqli_query($MySQLi, "SELECT SUM(cantidad)AS totalCantidades FROM ventas WHERE fecha BETWEEN'$startBusqueda'AND'$fecha' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                $dataVentas     = mysqli_fetch_assoc($Q__Ventas);
                                                $totalVendido   = $dataVentas['totalCantidades']; //Esto es el 100% de la venta

                                                for ($i = 0; $i < $resultProductos; $i++) {
                                                  $Q_Producto   = mysqli_query($MySQLi, "SELECT idProducto FROM productos WHERE estado=1 LIMIT $i,1 ");
                                                  $dataProductos = mysqli_fetch_assoc($Q_Producto);
                                                  $idProducto   = $dataProductos['idProducto'];
                                                  //Verificamos si el producto está en la tabla ventas
                                                  $Q_VentaProd  = mysqli_query($MySQLi, "SELECT idProducto FROM ventas WHERE idProducto='$idProducto'AND fecha BETWEEN '$startBusqueda' AND '$fecha' ");
                                                  $resultVentPro = mysqli_num_rows($Q_VentaProd);
                                                  if ($resultVentPro > 0) {
                                                    $Q_Venta      = mysqli_query($MySQLi, "SELECT SUM(cantidad)AS totalCantidad FROM ventas WHERE fecha BETWEEN'$startBusqueda'AND'$fecha' AND idProducto='$idProducto' ");
                                                    //$resultVenta= mysqli_num_rows($Q_Venta); 
                                                    $dataVenta    = mysqli_fetch_assoc($Q_Venta);
                                                    $ventaProducto = $dataVenta['totalCantidad']; //Esto es el porcentaje vendido
                                                    $Q_Producto   = mysqli_query($MySQLi, "SELECT imagen,nombre,marca,modelo FROM productos WHERE idProducto='$idProducto' ");
                                                    $dataProducto = mysqli_fetch_assoc($Q_Producto); ?>
                          <table class="table table-striped w-100">
                            <tr>
                              <td width="5%">
                                <?php
                                                    $src      = 'Productos/' . $dataProducto['imagen'];
                                                    $imgArray = redimensionar($src, 30);
                                                    echo '
                                <img src="' . $src . '" width="' . $imgArray[0] . '" height="' . $imgArray[1] . '"/>'; ?>
                              </td>
                              <td width="70%" class="pt-3">
                                <?= $dataProducto['nombre'] . "" . $dataProducto['marca'] . " " . $dataProducto['modelo'] ?>
                              </td>
                              <td width="25%" class="text-right"><?php
                                                                  $porcentaje = ($ventaProducto * 100) / $totalVendido;
                                                                  echo number_format(($porcentaje), 2) . " %"; ?></td>
                            </tr>
                          </table><?php
                                                  }
                                                }
                                              } else { ?>
                      <div class="row text-center">
                        <div class="col">
                          <h2 class="text-danger">NO HAY VENTAS HASTA EL MOMENTO</h2>
                          <p>Vamos equimos!! somos los mejores</p>
                        </div>
                      </div><?php
                                              } ?>
                  </div>
                </div>
              </div>
              <!-- <div id="panelAdmin3" class="panel">
                      <div class="panel-hdr">
                        <h2>NUEVOS <span class="fw-300"><i class="text-uppercase"><?= $mes ?></i></span></h2>
                        <div class="panel-toolbar">
                          <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                          <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                        </div>
                      </div>
                      <div class="panel-container">                      
                        <div class="panel-content"><?php
                                                    $Q_Ventas         = mysqli_query($MySQLi, "SELECT idProducto FROM ventas WHERE fecha BETWEEN'$startBusqueda'AND'$fecha' ORDER BY fecha ASC ");
                                                    while ($dataVenta = mysqli_fetch_assoc($Q_Ventas)) {
                                                      $idProducto     = $dataVenta['idProducto'];
                                                      $Q_Productos    = mysqli_query($MySQLi, "SELECT imagen,nombre,marca,modelo,precio FROM productos WHERE idProducto='$idProducto' ");
                                                      $dataProducto   = mysqli_fetch_assoc($Q_Productos); ?>
                          <table class="table table-striped w-100">
                            <tr>
                              <td width="5%"><?php
                                                      $src      = 'Productos/' . $dataProducto['imagen'];
                                                      //include 'includes/funciones.php';
                                                      $imgArray = redimensionar($src, 30);
                                                      echo '
                              <img src="' . $src . '" width="' . $imgArray[0] . '" height="' . $imgArray[1] . '"/>'; ?>
                              </td>
                              <td width="70%" class="pt-3"><?= $dataProducto['nombre'] . "" . $dataProducto['marca'] . " " . $dataProducto['modelo'] ?></td>
                              <td width="25%" class="text-right">$ <?= number_format(($dataProducto['precio']), 2) ?></td>
                            </tr>
                            
                          </table><?php
                                                    } ?>
                        </div>
                      </div>
                    </div> -->
            <?php
            } elseif($idRangoDf == 1 || $idRangoDf == 4) { 
              if (isset($_POST['inicio']) && isset($_POST['fin'])) {
                $startBusqueda = $_POST['inicio'];
                $fecha         = $_POST['fin']; 
              }
              $resumenServicios = obtenerMisServicios($MySQLi, $_SESSION['idTienda'], $startBusqueda, $fecha);
              // variable para mostrar mes actual o rango de fechas.
              $tiempo = (isset($_POST['inicio'])) ? 'del <span class=" text-danger">'.fechaFormato($startBusqueda) . '</span> al <span class=" text-danger">' . fechaFormato($fecha) . '</span>' : $mes;
            ?>
            <div class="clearfix">
              <button id="toggleBuscador" class="btn btn-xs btn-primary waves-effect waves-themed float-right">
                <i class="far fa-search"></i>
              </button>
              <h2>Servicios de <?=$sucurUsuarioDf?> <?= $tiempo ?></h2>
            </div>

            <form class="mb-3 d-none" id="buscar" action="?root=dashboard" method="POST">
              <div class="d-flex justify-content-center">
                <div class="row">
                    <div class="col text-center">
                        <label for="fechaInicio">Fecha de inicio</label>
                        <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $startBusqueda ?>" data-parsley-required="true">
                    </div>
                    <div class="col text-center">
                        <label for="fechaFin">Fecha final</label>
                        <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $fecha ?>" data-parsley-required="true">
                    </div>
                    <div class="col">
                        <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                        <button type="submit" class="form-control btn btn-xs btn-primary ">Buscar &nbsp;<i class="fas fa-spinner fa-pulse d-none btn-Buscar"></i></button>
                    </div>
                </div>
              </div>
            </form>


            <div class="row">
            <?php foreach ($resumenServicios as $servicio) {?>
            <div class="col-sm-6 col-md-6 col-lg my-2">
              <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-'.$servicio['color'] ?> rounded">
                <a href="?root=<?= $servicio['route'] ?>">
                  <div class="d-flex flex-row align-items-center">
                    <div class="icon-stack display-3 flex-shrink-0">
                      <i class="fal fa-circle icon-stack-3x opacity-100 color-<?= $servicio['color'] ?>-400"></i>
                      <i class="fad fa-<?= $servicio['icono'] ?> icon-stack-1x opacity-100 color-<?= $servicio['color'] ?>-100"></i>
                    </div>
                    <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                      <strong><?= strtoupper($servicio['nombre']) ?></strong><br>
                      <span style="font-size: 24px;"><?= $servicio['total'] ?></span><br>
                    </div>
                  </div>
                </a>
              </div>
            </div>
            <?php } ?>
            </div>

              <div id="panelUser" class="panel mt-5 w-100">
                <div class="panel-hdr">
                  <h2>Totales</h2>
                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <div class="row my-2">
                      <!-- TOTAL INGRESOS SUCURSAL ACTUAL -->
                      <div class="col-sm-6 col-md-6 col-lg-4 my-2">
                        <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-primary' ?> rounded">
                          <a href="?root=reportes" class="d-flex flex-row align-items-center">
                            <div class="icon-stack display-3 flex-shrink-0">
                              <i class="fal fa-circle icon-stack-3x opacity-100 color-success-400"></i>
                              <i class="fad fa-sack-dollar icon-stack-1x opacity-100 color-success-500"></i>
                            </div>
                            <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                              <strong>TOTAL INGRESOS_
                                <?php echo strtoupper($mes) ?></strong><br><br>
                              <strong style="font-size: 16px;">
                              <?php
                                $Q_misVentas  = mysqli_query($MySQLi, "SELECT SUM(totalVenta1)AS TotalVenta FROM ventas WHERE idVendedor='$idUser' AND fecha BETWEEN '$startBusqueda' AND  '$fecha' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                $dataVentas   = mysqli_fetch_assoc($Q_misVentas);
                                $TotalVentas  = $dataVentas['TotalVenta'];

                              
                                //$q_soporte_ventas  = mysqli_query($MySQLi, "SELECT SUM(total_cobrar_bs)AS total_cobrar_bs FROM soporte_ventas WHERE id_user='$idUser' AND fecha_completado BETWEEN '$startBusqueda' AND  '$fecha' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                $q_soporte_ventas  = mysqli_query($MySQLi, "SELECT ifnull(sum(sv.total_cobrar_usd),0) total_cobrar_bs FROM soporte_ventas sv inner join cotizaciones cot on sv.idCotizacion = cot.idCotizacion and cot.idUser = '$idUser' where MONTH(fecha_completado) = MONTH(CURRENT_DATE()) AND YEAR(fecha_completado) = YEAR(CURRENT_DATE()); ");
                                $d_soporte_ventas   = mysqli_fetch_assoc($q_soporte_ventas);
                                $total_ventas  = $d_soporte_ventas['total_cobrar_bs'];

                                $q_soporte_ventas  = mysqli_query($MySQLi, "SELECT ifnull(sum(total_cobrar_usd),0) total_cobrar_bs  FROM soporte_ventas WHERE MONTH(fecha_completado) = MONTH(CURRENT_DATE()) AND YEAR(fecha_completado) = YEAR(CURRENT_DATE()) AND id_user='$idUser' and nro_servicio_recepcion <> '0' ORDER BY fecha_completado ASC;");
                                $d_soporte_ventas   = mysqli_fetch_assoc($q_soporte_ventas);
                                $total_soporte  = $d_soporte_ventas['total_cobrar_bs'];

                                echo "<span class='simboloMoneda'></span> " . number_format(($total_soporte + $total_ventas), 2); 
                            ?></strong>
                            </div>
                          </a>
                        </div>
                      </div>
                      <!-- MIS CLIENTES -->
                      <div class="col-sm-6 col-md-6 col-lg-4 my-2">
                        <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-primary' ?> rounded">
                          <a href="?root=reportes" class="d-flex flex-row align-items-center">
                            <div class="icon-stack display-3 flex-shrink-0">
                              <i class="fal fa-circle icon-stack-3x opacity-100 color-success-400"></i>
                              <i class="fad fa-users-class icon-stack-1x opacity-100 color-success-500"></i>
                            </div>
                            <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                              <strong>MIS CLIENTES</strong><br><br>
                              <strong style="font-size: 16px;"><?php
                                                                $Q_Clientes = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idUser='$idUser' ");
                                                                echo $resultClien = mysqli_num_rows($Q_Clientes); ?></strong>
                            </div>
                          </a>
                        </div>
                      </div>
                      <!-- MIS COTIZACIONES -->
                      <div class="col-sm-6 col-md-6 col-lg-4 my-2">
                        <div class="card-body <?= $_theme == 'dark' ? 'bg-white' : 'bg-primary' ?> rounded">
                          <a href="?root=reportes" class="d-flex flex-row align-items-center">
                            <div class="icon-stack display-3 flex-shrink-0">
                              <i class="fal fa-circle icon-stack-3x opacity-100 color-success-400"></i>
                              <i class="fad fa-user-chart icon-stack-1x opacity-100 color-success-500"></i>
                            </div>
                            <div class="ml-3 <?= $_theme == 'dark' ? 'text-muted' : 'text-white' ?>">
                              <strong>MIS COTIZACIONES</strong><br><br>
                              <strong style="font-size: 16px;"><?php
                                                                $Q_Cotizaciones = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE idUser='$idUser'AND fecha BETWEEN '$startBusqueda'AND'$fecha' ");
                                                                echo $resultCoti = mysqli_num_rows($Q_Cotizaciones); ?></strong>
                            </div>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
        </main><?php
                include_once APP_PATH . '/includes/footer.php'; ?>
      </div>
    </div>
  </div><?php
        include_once APP_PATH . '/includes/extra.php';
        include_once APP_PATH . '/includes/js.php'; ?>
  <script src="<?= ASSETS_URL ?>/js/dashboard.js"></script>
</body>

</html>