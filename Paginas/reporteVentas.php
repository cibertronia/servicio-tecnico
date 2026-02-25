<?php
require_once 'init.php';
$_title = 'Reporte Ventas - '.APP_TITLE;
$_active_nav = 'reporteVentas';?>
<!DOCTYPE html>
<html lang="es"><?php 
  include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-bg-1 mod-skin-<?= $_theme ?> "><?php 
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block text-danger"><?=$Fecha ?></li></ol>
            <div id="panel-1" class="panel">
              <div class="panel-hdr"><?php
                if (isset($_POST['inicio'])) {
                  $Inicio     = $_POST['inicio'];
                  $Fin        = $_POST['fin']; ?>
                  <h2>Reporte Ventas <span class="fw-300"><i><span class="text-danger"><?= fechaFormato($Inicio)?></span> - <span class="text-danger"><?=fechaFormato($Fin)?></span></i></span></h2><?php
                }else{ ?>
                  <h2>Reporte ventas <span class="fw-300"><i class="text-uppercase"><?=$mes?></i></span>
                </h2><?php
                }?>                
                <div class="panel-toolbar">
                  <button type="button" class="btn btn-xs btn-primary Buscar"><i class="far fa-search"></i></button>
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container"><div class="respuesta"></div>
                <div class="panel-content">
                  <form class="w-75 m-auto d-none" id="buscar" action="?root=reporteVentas" method="POST">
                    <div class="row mb-2">
                      <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                        <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                        <input type="hidden" name="idTienda" value="<?php echo $idTiendaDf ?>">
                        <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $startBusqueda ?>" data-parsley-required="true">
                      </div>
                      <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                        <label for="fechaFin" class="form-label">Fecha final</label>
                        <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $fecha ?>" data-parsley-required="true">
                      </div>
                      <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                        <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                        <button class="btn btn-primary btn-block btn-Busca ">Buscar</button>
                      </div>
                    </div>
                  </form>
                  <table id="listamisVentas" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                      <tr>
                        <th class="text-center">N&ordm;</th><?php
                        if ($serviStock == 1) {
                          $numSucursales = numSucursales($MySQLi);
                          if ($numSucursales > 1) { ?>
                            <th class="text-center">Sucursal</th><?php
                          }
                         } ?>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio<br>venta <span class="simboloMoneda"></span></th>
                        <th class="text-center">Total<br>venta <span class="simboloMoneda"></span></th>
                        <th class="text-center">Recibo</th>
                        <th class="text-center">Nota E</th>
                      </tr>
                    </thead>
                    <tbody><?php
                      if (isset($_POST['inicio'])) {
                        tabla_Ventas($MySQLi,$idUser,$Inicio,$Fin,$serviStock,$numSucursales);
                      }else{
                        tabla_Ventas($MySQLi,$idUser,$startBusqueda,$fecha,$serviStock,$numSucursales);
                      }?>                        
                    </tbody>                    
                  </table>
                </div>
              </div>              
              <!--   ENVIAR MENSAJE POR TELEGRAM  -->
              <div class="modal fade" id="openModalTeleGram" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">ENVIAR SMS TELEGRAM
                        <small class="m-0 text-muted">Desde este formulario, puedes enviarle un mensaje directo al cliente seleccionado a su App de telegram.<br><span class="text-danger">Si el ID no es válido, causará un error en el sistema de envio.</span></small>
                      </h4>
                    </div>
                    <div class="modal-body">
                      <form id="telesms">
                        <div class="row">
                          <div class="col">
                            <label for="nombre_Usuario" class="form-label">Mensaje <span class="text-danger">*</span></label>
                            <input type="hidden" name="action" value="enviarSMSTeleGram">
                            <input type="hidden" name="idUser" id="idUserAPI">
                            <input type="hidden" name="idTelegram" id="telegramAPI">
                            <textarea class="form-control" id="mensajeTele" name="mensaje"></textarea>
                          </div>
                        </div>
                        <div class="row mt-5">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary btn-sm btn-block TeleSend">Enviar &nbsp; <i class="far fa-paper-plane"></i></button>
                            <div class="spinner-TeleSend spinner-<?=$_theme ?> m-auto d-none">
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
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
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
    <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
    <script src="<?=ASSETS_URL?>/js/misventas.js"></script>
  </body>
</html>