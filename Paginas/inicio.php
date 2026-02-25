<?php
require_once 'init.php';
require 'includes/default.php';
$_title = 'Inicio - '.APP_DESCRIPTION;
$_active_nav = 'Inicio';?>
<!DOCTYPE html>
<html lang="es">
  <link rel="stylesheet" media="screen, print" href="<?= ASSETS_URL ?>/css/app.min.css"><?php 
  include_once APP_PATH.'/includes/head.php';
  include_once APP_PATH.'/includes/functions.php';  ?>
  <body class="mod-bg-1 mod-skin-<?= $_theme ?> ">
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><?= $Fecha?></ol>
            <div id="panel-1" class="panel">
              <div class="panel-hdr">
                <h2><?php
                  if ($idSexo==1) {echo "Bienvenido ";}else{echo "Bienvenida ";}?>
                  <span class="fw-300"><i><?=$dataUss['nombre']." ".$dataUss['apellido'] ?></i></span>
                </h2><?php
                if ($idRango==3) { ?>
                  Precio Dolar <strong>&nbsp;&nbsp;Bs&nbsp;&nbsp;</strong>
                  <form id="savePrecioDolar" class="">
                    <input type="hidden" name="action" value="actualizarDolar">
                    <input type="text" name="precio" id="precio" class="form-control-sm text-center text-danger" value="<?= precioDolar($MySQLi) ?>">
                    &nbsp;&nbsp;<button class="btn btn-primary btn-sm btnPrecioDolar">Actualizar</button>
                  </form><?php
                }elseif ($idRango==2) {
                  if ($_SESSION['dolar']==1) { ?>
                    Precio Dolar <strong>&nbsp;&nbsp;Bs&nbsp;&nbsp;</strong>
                    <form id="savePrecioDolar" class="">
                      <input type="hidden" name="action" value="actualizarDolar">
                      <input type="text" name="precio" id="precio" class="form-control-sm text-center text-danger" value="<?= precioDolar($MySQLi) ?>">
                      &nbsp;&nbsp;<button class="btn btn-primary btn-sm btnPrecioDolar">Actualizar</button>
                    </form><?php
                  }else{ ?>
                    <div class="panel-toolbar">
                      <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                      <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                    </div><?php
                  }
                }else{ ?>
                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div><?php
                }?>
              </div>
              <div class="panel-container">
                <div class="panel-content"><?php
                  if ($idRango>1) {
                    $Q_Sucursales   = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1");
                    while ($dataSucursal = mysqli_fetch_assoc($Q_Sucursales)) {
                      if ($dataSucursal['idTienda']==1) {
                        $title = "CENTRAL ".strtoupper($dataSucursal['nombre']);
                      }else{
                        $title = "SUCURSAL ".strtoupper($dataSucursal['nombre']);
                      }?>
                      <!-- LLAMAMOS A TODAS LAS SUCURSALES -->
                    <div class="row">
                      <div class="col text-center">
                        <h3><?= $title?></h3>
                      </div>
                    </div>
                    <div class="row mt-1">
                      <!-- VENTAS DEL MES -->
                      <div class="col">
                        <div class="widget widget-stats bg-success">
                          <div class="stats-icon"><i class="fa fa-dollar-sign" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>TOTAL VENTAS <?php echo strtoupper($mes) ?></h4>
                            <p><?php
                              $queryVentas  = mysqli_query($MySQLi,"SELECT SUM(TotalVentaUS)AS TotalVentaUS FROM Ventas WHERE Sucursal='$Sucursal' AND Fecha BETWEEN '$startBusqueda' AND  '$fecha' ")or die(mysqli_error($MySQLi));
                              $dataVentas   = mysqli_fetch_assoc($queryVentas);
                              $TotalVentas  = $dataVentas['TotalVentaUS'];
                              echo "$ ". number_format(($TotalVentas),2); ?>$ 0.00
                            </p>
                          </div>
                          <div class="stats-link">
                            <a href="?root=reportes">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                      <!-- COTIZACIONES DEL MES -->
                      <div class="col">
                        <div class="widget widget-stats bg-info">
                          <div class="stats-icon"><i class="fa fa-chart-line" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>COTIZACIONES ENTREGADAS</h4>
                            <p><?php
                              // $queryEntregadas  = mysqli_query($MySQLi,"SELECT idCotizacion FROM Cotizaciones WHERE Estado=1 AND Fecha BETWEEN '$startBusqueda' AND '$fecha' AND Sucursal='$Sucursal' ");
                              // $resultGeneradas  = mysqli_num_rows($queryEntregadas);
                              // if ($resultGeneradas>0) {
                              //   echo $resultGeneradas;
                              // }else{
                              //   echo "0";
                              // } ?>0
                            </p>
                          </div>
                          <div class="stats-link">
                            <a href="?root=entregadas">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                      <!-- PRODUCTOS VENDIDO -->
                      <div class="col">
                        <div class="widget widget-stats bg-orange">
                          <div class="stats-icon"><i class="fa fa-chart-pie" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>PRODUCTOS VENDIDOS</h4>
                            <p><?php
                              // $queryCompradas = mysqli_query($MySQLi,"SELECT SUM(Cantidad) AS TotalVentas FROM Ventas WHERE Fecha BETWEEN '$startBusqueda' AND '$fecha' AND Sucursal='$Sucursal' AND Estado=0 ");
                              // $resultCompradas= mysqli_num_rows($queryCompradas);
                              // if ($resultCompradas>0) {
                              //   $datosVentas= mysqli_fetch_assoc($queryCompradas);
                              //   $TotalVentas= $datosVentas['TotalVentas'];
                              //   if ($TotalVentas=='') {
                              //     echo "0";
                              //   }else{
                              //     echo $TotalVentas;
                              //   }
                              // }else{
                              //   echo "0";
                              // } ?>$ 0
                            </p>
                          </div>
                          <div class="stats-link">
                            <a href="?root=reportes">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                      <!-- CLIENTES DEL MES -->
                      <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-red">
                          <div class="stats-icon"><i class="fa fa-users" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>CLIENTES REGISTRADOS</h4>
                            <p><?php
                            // $queryClientes  = mysqli_query($MySQLi,"SELECT * FROM Clientes WHERE  Sucursal='$Sucursal' AND Fecha_Reg BETWEEN '$startBusqueda' AND '$fecha' ");
                            // $resultClientes = mysqli_num_rows($queryClientes);
                            // if ($resultClientes>0) {
                            //   echo $resultClientes;
                            // }else{
                            //   echo "0";
                            // } ?>0
                          </p>  
                        </div>
                        <div class="stats-link">
                          <a href="?root=clientes&Sucursal=<?php //echo $Sucursal ?>">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                        </div>
                      </div>
                    </div>
                  </div><?php }
                  }else{ ?>
                    <div class="row">
                      <!-- MIS VENTAS -->
                      <div class="col">
                        <div class="widget widget-stats bg-success">
                          <div class="stats-icon"><i class="fa fa-dollar-sign" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>MIS VENTAS <?php echo strtoupper($mes) ?></h4>
                            <p><?php
                              // $queryVentas  = mysqli_query($MySQLi,"SELECT SUM(TotalVentaUS)AS TotalVentaUS FROM Ventas WHERE idUser='$idUser' AND Fecha BETWEEN '$startBusqueda' AND  '$fecha' ")or die(mysqli_error($MySQLi));
                              // $dataVentas   = mysqli_fetch_assoc($queryVentas);
                              // $TotalVentas  = ($dataVentas['TotalVentaUS']);
                              // $GranTotal    = $TotalVentas; //+$TotalCredit;//+$TotalAbonos;
                              // echo "$ ". number_format(($GranTotal),2); ?>$ 0.00
                            </p>
                          </div>
                          <div class="stats-link">
                            <a href="?root=ventas">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                      <!-- COTIZACIONES ENTREGADAS -->
                      <div class="col-xl-3 col-md-6">
                        <div class="widget widget-stats bg-info">
                          <div class="stats-icon"><i class="fa fa-chart-line" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>COTIZACIONES ENTREGADAS</h4>
                            <p><?php
                              // $queryEntregadas  = mysqli_query($MySQLi,"SELECT idCotizacion FROM Cotizaciones WHERE Estado=1 AND idUser='$idUser' AND Fecha BETWEEN '$startBusqueda' AND '$fecha' ");
                              // $resultGeneradas  = mysqli_num_rows($queryEntregadas);
                              // if ($resultGeneradas>0) {
                              //   echo $resultGeneradas;
                              // }else{
                              //   echo "0";
                              // } ?>0
                            </p>  
                          </div>
                          <div class="stats-link">
                            <a href="?root=entregadas">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                      <!-- PRODUCTOS VENDIDOS -->
                      <div class="col">
                        <div class="widget widget-stats bg-orange">
                          <div class="stats-icon"><i class="fa fa-chart-pie" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>PRODUCTOS VENDIDOS</h4>
                            <p><?php
                              // $queryCompradas = mysqli_query($MySQLi,"SELECT SUM(Cantidad) AS TotalVentas FROM Ventas WHERE Fecha BETWEEN '$startBusqueda' AND '$fecha' AND idUser='$idUser' AND Estado=0 ");
                              // $resultCompradas= mysqli_num_rows($queryCompradas);
                              // if ($resultCompradas>0) {
                              //   $datosVentas= mysqli_fetch_assoc($queryCompradas);
                              //   $TotalVentas= $datosVentas['TotalVentas'];
                              //   if ($TotalVentas=='') {
                              //     echo "0";
                              //   }else{
                              //     echo $TotalVentas;
                              //   }
                              // } ?>0
                            </p>
                          </div>
                          <div class="stats-link">
                            <a href="?root=ventas">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="widget widget-stats bg-red">
                          <div class="stats-icon"><i class="fa fa-users" style="font-size: 65px"></i></div>
                          <div class="stats-info">
                            <h4>MIS CLIENTES</h4>
                            <p><?php
                              // $queryClientes  = mysqli_query($MySQLi,"SELECT * FROM Clientes WHERE Registrador='$idUser' ");
                              // $resultClientes = mysqli_num_rows($queryClientes);
                              // if ($resultClientes>0) {
                              //   echo $resultClientes;
                              // }else{
                              //   echo "0";
                              // } ?>0
                            </p>  
                          </div>
                          <div class="stats-link">
                            <a href="?root=misclientes">Ver Detalles <i class="fa fa-arrow-alt-circle-right"></i></a>
                          </div>
                        </div>
                      </div>
                    </div><?php
                  }?>
                </div>
              </div>
            </div>
          </main><?php 
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/inicio.js"></script>
  </body>
</html>