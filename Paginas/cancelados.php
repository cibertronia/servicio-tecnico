<?php
error_reporting(0);
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Equipos cancelados - '.APP_TITLE;
$_active_nav = 'cancelados';?>
<!DOCTYPE html>
<html lang="es"><?php 
  include_once APP_PATH.'/includes/head.php';
  include_once APP_PATH.'/includes/funciones.php';  ?>
  <body class="mod-bg-1 mod-skin-<?= $_theme ?> ">
  <?php 
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><?= $Fecha?></ol>
            <?php
            // if ($_SESSION['idRango'] == 4) {
            if (false) {
                echo error403();
            } else {
            ?>
            <div class="row"><div class="respuesta"></div>
              <div class="col">
                <div id="cotGeneradas_lista" class="panel">
                  <div class="panel-hdr"><?php
                    if (isset($_POST['inicio'])) {
                      $Inicio     = $_POST['inicio'];
                      $Fin        = $_POST['fin']; ?>
                      <h2>Equipos <span class="fw-300"><i> cancelados </i></span> &nbsp; &nbsp;del  &nbsp; <span class="text-danger"><?=fechaFormato($Inicio) ?></span>  &nbsp;al  &nbsp; <span class="text-danger"><?=fechaFormato($Fin) ?></span> </h2>
                      <button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
                    }else{ ?>
                      <h2>Equipos <span class="fw-300"><i> cancelados </i></span> &nbsp; &nbsp;<?=$mes ?></h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
                    }?>
                    <a href="?root=registrarServicio">
                      <button class="btn btn-xs btn-primary">Recepcionar Servicio</button>
                    </a>&nbsp;&nbsp;&nbsp;
                    <div class="panel-toolbar">
                      <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                      <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                    </div>
                  </div>
                  <div class="panel-container">
                    <div class="panel-content">
                      <form class="w-75 m-auto d-none" id="buscar" action="?root=cancelados" method="POST">
                        <div class="row mb-2">
                          <div class="col text-center">
                            <label for="fechaInicio">Fecha de inicio</label>
                            <input type="hidden" name="sucursal" value="<?php echo $dataUss['ciudad'] ?>">
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
                      </form><?php
                     
                      $sucursalVendedor = $sucurUsuarioDf;
                      // if ($sucursalVendedor=='Cochabamba') {
                      //   $dataBase = "soporte_cba";
                      // }else{
                      //   $dataBase = "soporte_stc";
                      // }
                      if (isset($_POST['inicio'])) {
                        if ($idRango==2) {
                          $Q_Servicio   = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin' AND estado=4 ORDER BY idClave DESC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                        }else{
                          $Q_Servicio   = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin' AND estado=4 AND idSucursal='$idTiendaDf' ORDER BY idClave DESC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                        }                        
                      }else{
                        if ($idRango==2) {
                          $Q_Servicio = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha' AND estado=4 ORDER BY idClave DESC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                        }else{
                          $Q_Servicio = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha' AND estado=4 AND idSucursal='$idTiendaDf' ORDER BY idClave DESC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                        }
                      } ?>
                      <table id="listaCancelados" class="table table-bordered table-hover table-sm table-striped w-100" style="font-size: 10px;">
                        <thead>
                          <tr>
                            <th width="5%" class="text-center">N&ordm;</th>
                            <th width="95%" class="text-center">Descripción</th>
                          </tr>
                        </thead>
                        <tbody><?php
                        equipsCancelados($MySQLi,$Q_Servicio);
                        ?></tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } ?>
          </main><?php 
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>    
    <script src="assets/js/cancelados.js"></script>
  </body>
</html>