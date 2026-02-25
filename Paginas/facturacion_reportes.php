<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Facturación Reportes ' . APP_TITLE;
$_active_nav = 'facturacion_reportes';
$idRangoDf == 1 ? header("Location: ?root=404") : null; ?>
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
          <div class="row">
            &nbsp; &nbsp;
            <a href="?root=facturacion_reportes" class="btn btn-warning">COCHABAMBA</a>&nbsp;
            <a href="?root=facturacion_reportes_la_paz" class="btn btn-primary">LA PAZ</a>&nbsp;
            <a href="?root=facturacion_reportes_santa_cruz" class="btn btn-success">SANTA CRUZ</a>&nbsp;
            <a href="?root=facturacion_reportes_tarija" class="btn btn-info">TARIJA</a>
          </div><br>
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

                  <h2><span class="fw-300 text-warning">LISTA FACTURAS
                      <i> COCHABAMBA </i>
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
                    <form class="w-75 m-auto d-none" id="buscar" action="?root=facturacion_reportes" method="POST">
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
                        &nbsp;
                      </div>

                      <!-- TABLA DE FACTURAS  agregar y kitar d-none -->
                      <div class="row tableUsers">
                        <div class="col-md-12">
                          <div class="panel panel-warning">

                            <div class="panel-body">
                              <div class="row">
                                <!-- total facturado validadas Bs -->
                                <div class="col-xl-3 col-md-6">
                                  <div class="widget widget-stats bg-primary custom-card">
                                    <div class="stats-icon"><i class="fa fa-dollar-sign text-white" style="font-size: 65px"></i></div>
                                    <div class="stats-info text-white">
                                      <h4>MONTO TOTAL FACTURADO <?php // echo strtoupper($mes) 
                                                                ?></h4>
                                      <p><?php
                                          $queryVentas  =  mysqli_query($MySQLi, "SELECT
                                        SUM(amountTotal) AS amountTotal
                                    FROM
                                        factura
                                    WHERE
                                        branchId = 1 AND siatCodeState = 908 AND ( DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin' )") or die(mysqli_error($MySQLi));
                                          $dataVentas    =  mysqli_fetch_assoc($queryVentas);
                                          $TotalVentas   =  $dataVentas['amountTotal'];
                                          echo "Bs " . number_format(($TotalVentas), 2); ?>
                                      </p>
                                    </div>

                                  </div>
                                </div>
                                <!-- Cantidad facturas validadas -->
                                <div class="col-xl-3 col-md-6">
                                  <div class="widget widget-stats bg-success custom-card">
                                    <div class="stats-icon"><i class="fas fa-file-invoice text-white" style="font-size: 65px"></i>
                                    </div>
                                    <div class="stats-info text-white">
                                      <h4>CANTIDAD FACTURAS VALIDADAS</h4>
                                      <p><?php
                                          $queryEntregadas  =  mysqli_query($MySQLi, "SELECT *
                                        FROM
                                        factura
                                    WHERE
                                        branchId = 1 AND siatCodeState = 908 AND ( DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin' )");
                                          $resultGeneradas   =  mysqli_num_rows($queryEntregadas);
                                          if ($resultGeneradas > 0) {
                                            echo $resultGeneradas;
                                          } else {
                                            echo "0";
                                          } ?>
                                      </p>
                                    </div>

                                  </div>
                                </div>
                                <!-- facturas cantidad anuladas -->
                                <div class="col-xl-3 col-md-6">
                                  <div class="widget widget-stats bg-danger custom-card">
                                    <div class="stats-icon"><i class="fa fa-window-close text-white" style="font-size: 65px"></i>
                                    </div>
                                    <div class="stats-info text-white">
                                      <h4>CANTIDAD FACTURAS ANULADAS</h4>
                                      <p><?php
                                          $queryCantidadAnuladas  =  mysqli_query($MySQLi, "SELECT *
                                        FROM
                                        factura
                                    WHERE
                                        branchId = 1 AND siatCodeState = 905 AND ( DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin' )");
                                          $resultCantidadAnuladas  =  mysqli_num_rows($queryCantidadAnuladas);

                                          if ($resultCantidadAnuladas > 0) {
                                            echo $resultCantidadAnuladas;
                                          } else {
                                            echo "0";
                                          }
                                          ?>
                                      </p>


                                      </p>
                                    </div>

                                  </div>
                                </div>
                                <!-- TOTAL PRODUCTODS FACTURADOS -->
                                <div class="col-xl-3 col-md-6">
                                  <div class="widget widget-stats bg-info custom-card">
                                    <div class="stats-icon"><i class="fa fa-shopping-bag text-white" style="font-size: 65px"></i>
                                    </div>
                                    <div class="stats-info text-white">
                                      <h4>CANTIDAD TOTAL DE PRODUCTOS FACTURADOS Y VALIDADOS</h4>
                                      <p><?php


                                          $totalfacturado = 0;
                                          $QueryFactura = mysqli_query($MySQLi, "SELECT* FROM detailInvoice WHERE branchId=1  AND( DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin' ) ORDER BY invoiceNumber DESC");

                                          while ($data = mysqli_fetch_assoc($QueryFactura)) {

                                            $nroFactura = $data['invoiceNumber'];
                                            $qtyFactura = $data['qty'];
                                            $QueryFacturaCabezera = mysqli_query($MySQLi, "SELECT* FROM factura WHERE branchId=1 AND invoiceNumber='$nroFactura'  ");
                                            $dataFacturaCabezera = mysqli_fetch_assoc($QueryFacturaCabezera);

                                            if ($dataFacturaCabezera['siatCodeState'] == 908) {
                                              $totalfacturado = $totalfacturado + $qtyFactura;
                                            }
                                          }



                                          if ($totalfacturado > 0) {
                                            echo $totalfacturado;
                                          } else {
                                            echo "0";
                                          } ?>
                                      </p>
                                    </div>

                                  </div>
                                </div>
                              </div>
                              <table id="tabla_facturas" width="100%" class="table table-striped table-bordered table-td-valign-middle w-100">
                                <thead>
                                  <tr>
                                    <th width="5%" class="text-center">#FACTURA</th>
                                    <th class="text-center">RAZON SOCIAL</th>
                                    <th class="text-center">NIT CLIENTE</th>
                                    <th class="text-center">FECHA EMISION</th>
                                    <th class="text-center">VENDEDOR</th>

                                    <th class="text-center">PRODUCTO FACTURADO</th>
                                    <th width="5%" class="text-center">CANTIDAD FACTURADA</th>
                                    <th width="5%" class="text-center">PRECIO UNIDAD</th>
                                    <th class="text-center">IMPORTE FACTURADO</th>
                                    <th class="text-center">IMPORTE ANULADO</th>

                                    <th class="text-center">ESTADO DE LA FACTURA - SIAT</th>


                                    <th width="13%" class="text-center">ACCIONES</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php
                                  include 'includes/conexion.php';

                                  $sqlurlcucu = mysqli_query($MySQLi, "SELECT * FROM token_access");
                                  $dataurlcucu = mysqli_fetch_assoc($sqlurlcucu) or die(mysqli_error($MySQLi));
                                  $urlcucu = $dataurlcucu['urlcucu'];

                                  $QueryFactura = mysqli_query($MySQLi, "SELECT* FROM detailInvoice WHERE branchId=1 AND(DATE_FORMAT(dateEmission, '%Y-%m-%d') BETWEEN '$Inicio' AND '$Fin' )  ORDER BY invoiceNumber DESC");
                                  while ($data = mysqli_fetch_assoc($QueryFactura)) {

                                    $nroFactura = $data['invoiceNumber'];
                                    $QueryFacturaCabezera = mysqli_query($MySQLi, "SELECT* FROM factura WHERE branchId=1 AND invoiceNumber='$nroFactura' ");
                                    $dataFacturaCabezera = mysqli_fetch_assoc($QueryFacturaCabezera);
                                    // $QueryFacturaCabezera = mysqli_query($MySQLi, "SELECT* FROM factura WHERE branchId=1 AND invoiceNumber='$nroFactura' ");
                                    // $dataFacturaCabezera = mysqli_fetch_assoc($QueryFacturaCabezera);


                                  ?>
                                    <tr class="odd gradeX">
                                      <td class="text-center"><?php echo $nroFactura ?></td>
                                      <td class="text-center"><?php echo $dataFacturaCabezera['clientReasonSocial'] ?>
                                      </td>
                                      <td class="text-center"><?php echo $dataFacturaCabezera['clientNroDocument'] ?>
                                      </td>
                                      <td class="text-center"><?php echo $dataFacturaCabezera['dateEmission'] ?></td>
                                      <td class="text-center"><?php echo $dataFacturaCabezera['userCashier'] ?></td>

                                      <td class="text-center"><?php echo $data['description'] ?></td>
                                      <td class="text-center"><?php echo $data['qty'] ?></td>

                                      <td class="text-center"><?php echo $data['priceUnit'] ?></td>


                                      <td class="text-center"><?php

                                                              if ($dataFacturaCabezera['siatCodeState'] == 908) {

                                                                echo $data['subTotal'];
                                                              }
                                                              ?>
                                      </td>
                                      <td class="text-center"><?php

                                                              if ($dataFacturaCabezera['siatCodeState'] == 905) {

                                                                echo $data['subTotal'];
                                                              }
                                                              ?>
                                      </td>


                                      <td class="text-center">
                                        <?php echo $dataFacturaCabezera['siatDescriptionStatus'] ?></td>


                                      <form method="post" action="./../includes/api_facturacion/factura_pdf.php" id='pdfFactura' target="_blank">
                                        <td class="text-center">

                                          <input type="hidden" name="invoiceCode" id="invoiceCode" value='<?php echo $dataFacturaCabezera['invoiceCode'] ?>'>
                                          <button id="<?php echo $dataFacturaCabezera['invoiceCode'] ?>" class="btn btn-xs btn-primary ver_pdf" title="Ver PDF Factura IC=<?php echo $dataFacturaCabezera['invoiceCode'] ?>"><a><i class="fa fa-file" style="font-size: 16px"></i></a></button>

                                          <?php $urlpdf = $dataFacturaCabezera['invoiceUrl'] ?>


                                          <button title="ANULAR FACTURA ID=<?php echo $dataFacturaCabezera['id'] ?>" data-toggle="modal" data-target="#modal_anular" data-dismiss="modal" id="<?php echo $dataFacturaCabezera['id'] ?>" class="btn btn-xs btn-danger boton_llenar_modal_anular">
                                            <i class="fa fa-times" style="font-size: 15px">
                                            </i>
                                          </button>&nbsp;

                                          <!-- <button title="REENVIAR FACTURA" id="<?php echo $dataFacturaCabezera['id'] ?>" title=" ID=<?php echo $dataFacturaCabezera['id'] ?>" class="btn btn-xs btn-success btnEmail2"><i class="fa fa-envelope" style="font-size: 15px"></i></button>&nbsp; -->


                                        </td>
                                      </form>
                                    </tr><?php }
                                        mysqli_close($MySQLi); ?>
                                </tbody>
                              </table>
                            </div>
                            <!-- end panel-body -->
                          </div>
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
      <!-- Modal ANULAR FACTURA -->
      <div id="modal_anular" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 1250px!important;">
          <div class="modal-content">
            <!--=====================================
                                CABEZA DEL MODAL 2
                                ======================================-->
            <div class="modal-header">
              <h4 class="modal-title">ANULACIÓN FACTURA</h4>
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <!--=====================================
                                CUERPO DEL MODAL 2
                                ======================================-->
            <div class="modal-body">
              <div class="box-body">
                <form id="form_anular">
                  <!--form---->
                  <div class="row">
                    <div class="col">
                      <label for="invoiceNumber1">NUMERO DE FACTURA</label>
                      <input type="text" name="invoiceNumber1" id="invoiceNumber1" class="form-control" placeholder="invoiceNumber1" readonly maxlength="">
                    </div>
                    <div class="col">
                      <label for="invoiceCode1">CODIGO DE FACTURA</label>
                      <input type="text" name="invoiceCode1" id="invoiceCode1" class="form-control" placeholder="invoiceCode1" readonly maxlength="">
                    </div>
                    <div class="col-3">
                      <label for="branchId1">SUCURSAL</label>
                      <input type="text" name="branchId1" id="branchId1" class="form-control" readonly>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <div class="col">
                      <label for="codeMotive1">MOTIVO ANULACION</label>
                      <select name="codeMotive1" id="codeMotive1" class="form-control">
                        <option selected value="1"> FACTURA MAL EMITIDA</option>
                        <option value="3"> DATOS DE EMISION INCORRECTOS</option>
                        <!-- <option value="2"> NOTA DE CREDITO-DEBITO MAL EMITIDA</option> -->
                        <!-- <option value="4"> FACTURA O NOTA DE CREDITO-DEBITO DEVUELTA</option> -->
                      </select>
                    </div>
                    <div class="col">
                      <label for="tipoFactura1">TIPO DE FACTURA</label>
                      <select name="tipoFactura1" id="tipoFactura1" class="form-control">
                        <option value="1"> COMPRA Y VENTA</option>
                        <!-- <option value="24"> DEBITO CREDITO</option> -->
                      </select>
                    </div>
                    <div class="col">
                      <label for="clientEmail1">EMAIL CLIENTE</label>
                      <input type="email" name="clientEmail1" id="clientEmail1" class="form-control" placeholder="Correo">
                    </div>

                  </div>
                  <div class="row mt-3">
                    <div class="col">
                      <label for="submit">&nbsp;&nbsp;</label>
                      <button class="btn btn-xs btn-primary form-control boton_anular_api" value="ANULAR FACTURA">ANULAR FACTURA</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/facturacion_reportes.js"></script>
  <style>
    .custom-card {
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 10px;
    }
  </style>

</body>

</html>