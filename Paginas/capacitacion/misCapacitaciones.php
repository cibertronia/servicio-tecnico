<?php
require_once 'init.php';
$_title       = 'Mis Capacitaciones - '.APP_TITLE;
$_active_nav  = 'MisCapacitaciones';?>
<!DOCTYPE html>
<html><?php include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-bg-1 mod-nav-link mod-skin-<?= $_theme ?> ">
    <?php include_once APP_PATH.'/includes/theme.php'; ?>
    <!-- BEGIN Page Wrapper -->
    <div class="page-wrapper">
      <div class="page-inner">
        <?php include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content" data-iduser="<?= $_SESSION['idUser'] ?>">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol>
            <div class="mt-3">
              <button id="toggleBuscador" class="btn btn-xs btn-primary waves-effect waves-themed float-right mx-3">
                <i class="far fa-search"></i>
              </button>
              <a href="?root=capacitacion/agregar" class="btn btn-info btn-xs float-right">
                <i class="fal fa-plus mr-1"></i>
                Agregar
              </a>
              <h1>Mis Capacitaciones</h1>
            </div>

            <form class="mb-3 d-none" id="buscar" action="#" method="GET">
                <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $_SESSION['idUser']; ?>">
                <div class="row w-75 mx-auto">
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <label for="fechaInicio">Fecha de inicio</label>
                        <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="<?php echo $startBusqueda ?>" data-parsley-required="true">
                    </div>
                    <div class="col-12 col-md-3 col-lg-2 text-center">
                        <label for="fechaFin">Fecha final</label>
                        <input type="date" name="fechaFin" id="fechaFin" class="form-control" value="<?php echo $fecha ?>" data-parsley-required="true">
                    </div>
                    <div class="col-12 col-md-4 text-center">
                        <label for="search">Cliente o Equipo</label>
                        <input type="text" name="search" id="search" class="form-control" placeholder="Nombre, Apellido o Equipo"> 
                    </div>
                    <div class="col">
                        <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                        <button type="submit" class="form-control btn btn-xs btn-primary ">Buscar &nbsp;<i class="fas fa-spinner fa-pulse d-none btn-Buscar"></i></button>
                    </div>
                </div>
            </form>

            <div class="panel mt-3">
                <div class="panel-container">
                    <div class="panel-content">
                      <table class="table table-bordered table-hover table-striped w-100" id="table-capacitaciones">
                        <thead>
                          <tr>
                            <th>N°</th>
                            <th>Cliente</th>
                            <th>Equipo</th>
                            <th>Tecnico</th>
                            <th>Fecha y hora</th>
                            <th>Sucursal</th>
                            <th>Observaciones</th>
                            <th>Registrado</th>
                            <!-- <th>Acción</th> -->
                          </tr>
                        </thead>
                      </table>
                    </div>
                </div>
            </div>
          </main><?php 
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script src="<?= ASSETS_URL ?>/js/capacitacion/lista.js"></script>
  </body>
</html>