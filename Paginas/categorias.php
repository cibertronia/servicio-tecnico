<?php
require_once 'init.php';
$_title       = 'Categorias - '.APP_TITLE;
$_active_nav  = 'Categorias';?>
<!DOCTYPE html>
<html><?php include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-bg-1 mod-nav-link mod-skin-<?= $_theme ?> "><?php
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol>
            <div id="panelCategorias" class="panel">
              <div class="panel-hdr">
                <h2>Lista de <span class="fw-300"><i>Categorias</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                  <button class="btn btn-primary btn-xs openModaladdProveedor" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar nuevo proveedor">Agregar &nbsp;<i class="fal fa-users-class"></i></button>
                </h2>
                <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">
                <div class="panel-content">
                  <table id="listaCategorias" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                      <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Categoria</th>
                        <th class="text-center">Acciones</th>
                      </tr>
                    </thead>
                    <tbody id="respuesta"><?=listaCategorias($MySQLi, $idUser, $idRangoDf); ?></tbody>
                  </table>
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
    <script src="<?=ASSETS_URL?>/js/categorias.js"></script>
  </body>
</html>