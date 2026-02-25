<?php
require_once 'init.php';
$_title       = 'Agregar Capacitación - '.APP_TITLE;
$_active_nav  = 'agregar';?>
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
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol>
            <h1>Agregar Capacitación</h1>
            <div class="panel">
                <div class="panel-container">
                    <div class="panel-content">
                        <?php include_once APP_PATH.'/includes/components/capacitaciones/form.php'; ?>
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
  </body>
</html>