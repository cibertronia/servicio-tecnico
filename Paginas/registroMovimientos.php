<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Registro Ventas ';
$_active_nav = 'registro_movimientos';
//$idRangoDf == 1 ? header("Location: ?root=404") : null; 
?>
<!DOCTYPE html>
<html lang="es"><?php
                include_once APP_PATH . '/includes/head.php';
                include_once APP_PATH . '/includes/funciones.php';  ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?> ">
  <?php
  include_once APP_PATH . '/includes/theme.php'; ?>
  <div class="page-wrapper">
    <div class="page-inner"><?php
                            include_once APP_PATH . '/includes/nav.php'; ?>
      <div class="page-content-wrapper"><?php
                                        include_once APP_PATH . '/includes/header.php';
                                        ?>
        <main id="js-page-content" role="main" class="page-content">
          <ol class="breadcrumb page-breadcrumb"><?= $Fecha ?></ol>
          <br>
          <div class="row">
            <div class="respuesta"></div>
            <div class="col">
              <div class="panel">
                <div class="panel-hdr">
                  <?php
                  if (isset($_POST['inicio'])) {
                    $Inicio = $_POST['inicio'];
                    $Fin = $_POST['fin'];
                  } else {
                    $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                    $Fin = $fecha; //fecha = hoy
                  } ?>

                  <h2><span class="fw-300 text-primary">REGISTROS VENTAS
                    </span> &nbsp; &nbsp;del &nbsp;
                    <span class="text-danger"><?= fechaFormato($Inicio) ?>
                    </span> &nbsp;al &nbsp; <span class="text-danger"><?= fechaFormato($Fin) ?></span>
                  </h2>

                  <button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i>
                  </button>&nbsp;&nbsp;

                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <form class="w-75 m-auto d-none" id="buscar" action="?root=registroMovimientos" method="POST">
                      <div class="row mb-2">
                        <div class="col text-center">
                          <label for="fechaInicio">Fecha de inicio</label>
                          <input type="hidden" name="sucursal" value="<?php echo $dataUss['ciudad'] ?>">
                          <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $Inicio ?>" data-parsley-required="true">
                        </div>
                        <div class="col text-center">
                          <label for="fechaFin">Fecha final</label>
                          <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $Fin ?>" data-parsley-required="true">
                        </div>
                        <div class="col">
                          <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                          <button type="submit" class="form-control btn btn-xs btn-primary ">Buscar &nbsp;<i class="fas fa-spinner fa-pulse d-none btn-Buscar"></i></button>
                        </div>
                      </div>
                    </form>
                    <div id="content" class="content">

                      <div class="row">
                        <?php $granTotal = 0;   ?>
                        <!-- total cochabamba -->
                        <div class="col-xl-3 col-md-6">
                          <div class="widget widget-stats bg-warning custom-card">
                            <div class="stats-icon"><i class="fa fa-barcode" style="font-size: 65px"></i>
                            </div>
                            <div class="stats-info">
                              <h4>COCHABAMBA <?php //echo strtoupper($mes) 
                                              ?></h4>
                              <p><?php
                                  $queryVentas  =  mysqli_query($MySQLi, "SELECT SUM(cb) AS amountTotal FROM historial_stock_productos WHERE (DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin') ") or die(mysqli_error($MySQLi));
                                  $dataVentas    =  mysqli_fetch_assoc($queryVentas);
                                  $TotalVentas   =  $dataVentas['amountTotal'];
                                  $cb = $TotalVentas;
                                  $granTotal = $granTotal + $TotalVentas;
                                  echo "Descuento Stock <br>" . ($TotalVentas); ?>
                              </p>
                            </div>

                          </div>
                        </div>
                        <!-- TOTAL LA PAZ -->
                        <div class="col-xl-3 col-md-6">
                          <div class="widget widget-stats bg-primary custom-card">
                            <div class="stats-icon"><i class="fa fa-barcode" style="font-size: 65px"></i>
                            </div>
                            <div class="stats-info">
                              <h4>LA PAZ <?php //echo strtoupper($mes) 
                                          ?></h4>
                              <p><?php
                                  $queryVentas  =  mysqli_query($MySQLi, "SELECT SUM(lp) AS amountTotal FROM historial_stock_productos WHERE (DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin') ") or die(mysqli_error($MySQLi));
                                  $dataVentas    =  mysqli_fetch_assoc($queryVentas);
                                  $TotalVentas   =  $dataVentas['amountTotal'];
                                  $lp = $TotalVentas;
                                  $granTotal = $granTotal + $TotalVentas;
                                  echo "Descuento Stock <br>" . ($TotalVentas); ?>
                              </p>
                            </div>

                          </div>
                        </div>
                        <!-- TOTAL SANTA CRUZ -->
                        <div class="col-xl-3 col-md-6">
                          <div class="widget widget-stats bg-success custom-card">
                            <div class="stats-icon"><i class="fa fa-barcode" style="font-size: 65px"></i>
                            </div>
                            <div class="stats-info">
                              <h4>SANTA CRUZ <?php //echo strtoupper($mes) 
                                              ?></h4>
                              <p><?php
                                  $queryVentas  =  mysqli_query($MySQLi, "SELECT SUM(sc) AS amountTotal FROM historial_stock_productos WHERE (DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin') ") or die(mysqli_error($MySQLi));
                                  $dataVentas    =  mysqli_fetch_assoc($queryVentas);
                                  $TotalVentas   =  $dataVentas['amountTotal'];
                                  $sc = $TotalVentas;
                                  $granTotal = $granTotal + $TotalVentas;
                                  echo "Descuento Stock <br>" . ($TotalVentas); ?>
                              </p>
                            </div>

                          </div>
                        </div>
                        <!-- TOTAL TARIJA -->
                        <div class="col-xl-3 col-md-6">
                          <div class="widget widget-stats bg-info custom-card">
                            <div class="stats-icon"><i class="fa fa-barcode" style="font-size: 65px"></i>
                            </div>
                            <div class="stats-info">
                              <h4>TARIJA <?php //echo strtoupper($mes) 
                                          ?></h4>
                              <p><?php
                                  $queryVentas  =  mysqli_query($MySQLi, "SELECT SUM(tj) AS amountTotal FROM historial_stock_productos WHERE (DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin') ") or die(mysqli_error($MySQLi));
                                  $dataVentas    =  mysqli_fetch_assoc($queryVentas);
                                  $TotalVentas   =  $dataVentas['amountTotal'];
                                  $tj = $TotalVentas;
                                  $granTotal = $granTotal + $TotalVentas;
                                  echo "Descuento Stock <br>" . ($TotalVentas); ?>
                              </p>
                            </div>

                          </div>
                        </div>

                      </div>

                      <hr>
                      <div class="panel-container">
                        <div class="panel-content">
                          <table id="listamisVentas" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                              <tr>
                                <th width="5%" class="text-center">N&ordm;</th>
                                <!-- <th width="5%" class="text-center">idProducto</th> -->
                                <th class="text-center">REPUESTO</th>
                                <th width="5%" class="text-center">INICIAL</th>
                                <th width="5%" class="text-center btn-warning">CB</th>
                                <th width="5%" class="text-center btn-primary">LP</th>
                                <th width="5%" class="text-center btn-success">SC</th>
                                <th width="5%" class="text-center btn-info">TJ</th>
                                <th width="5%" class="text-center">FINAL</th>
                                <th class="text-center">VENDEDOR</th>
                                <th class="text-center">FECHA</th>
                                <th class="text-center">DESCRIPCION</th>
                                <th class="text-center">SUCURSAL</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $Num = 1;
                              $q_historial = mysqli_query($MySQLi, "SELECT * FROM historial_stock_productos WHERE (DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin') ");
                              while ($data = mysqli_fetch_assoc($q_historial)) {
                              ?>
                                <tr class="odd gradeX">
                                  <td class="text-center"><?php echo $Num ?></td>
                                  <td class="text-center"><?php echo $data['producto'] ?></td>
                                  <?php
                                  // $idProducto = $data['idProducto'];
                                  // $dataProducto = mysqli_query($MySQLi, "SELECT* FROM Productos WHERE idProducto='$idProducto' ");
                                  // $dataProducto = mysqli_fetch_assoc($dataProducto);

                                  ?>
                                  <td class="text-center"><?php echo $data['inicial'] ?></td>
                                  <td class="text-center"><?php echo $data['cb'] ?></td>
                                  <td class="text-center"><?php echo $data['lp'] ?></td>
                                  <td class="text-center"><?php echo $data['sc'] ?></td>
                                  <td class="text-center"><?php echo $data['tj'] ?></td>
                                  <td class="text-center"><?php echo $data['final'] ?></td>
                                  <td class="text-center"><?php echo $data['vendedor'] ?> </td>
                                  <td class="text-center"><?php echo $data['dateEmission'] ?> </td>
                                  <td class="text-center"><?php echo $data['descripcion'] ?> </td>
                                  <td class="text-center">
                                    <?php
                                    $idTienda = $data['sucursal'];
                                    $q_sucursales = mysqli_query($MySQLi, "SELECT * FROM `sucursales` WHERE `idTienda` = '$idTienda'");
                                    $d_sucursales = mysqli_fetch_assoc($q_sucursales);
                                    echo $d_sucursales['sucursal'] ?>
                                  </td>
                                </tr>
                              <?php
                                $Num++;
                              }

                              mysqli_close($MySQLi); ?>

                              <tr class="odd gradeX">
                                <td class="text-center"><?php echo $Num ?></td>
                                <!-- <td class="text-center"><?php //echo $data['idProducto'] 
                                                              ?></td> -->
                                <th class="text-center">TOTAL</th>
                                <td class="text-center"></td>
                                <th class="text-center"><?php echo $cb ?></th>
                                <th class="text-center"><?php echo $lp ?></th>
                                <th class="text-center"><?php echo $sc ?></th>
                                <th class="text-center"><?php echo $tj ?></th>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </main><?php
                include_once APP_PATH . '/includes/footer.php'; ?>
      </div>

    </div>
  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
  <script src="assets/js/registroMovimientos.js"></script>
  <style>
    .custom-card {
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }
  </style>

</body>

</html>