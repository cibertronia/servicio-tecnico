<?php
require_once 'init.php';
$_title = 'Sucursales - '.APP_DESCRIPTION;
$_active_nav = 'Sucursales';?>
<!DOCTYPE html>
<html lang="es"><?php 
  include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-bg-1 mod-skin-<?= APP_THEME ?> "><div class="respuesta"></div><?php 
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol><?php
            if ($idRangoDf<3) {
              error404();
            }else{ ?>
              <div id="panel-1" class="panel w-50">
                <div class="panel-hdr">
                  <h2>Lista de <span class="fw-300"><i>Sucursales</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-xs openModaladdSucursal" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar nueva sucursal">Agregar &nbsp;<i class="fal fa-building"></i></button>
                  </h2>
                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <table id="listaSucursales" class="table table-bordered table-hover table-striped w-100">
                      <thead>
                        <tr>
                          <th class="text-center">ID</th>
                          <th class="text-center">Sucursal</th>
                          <th class="text-center">Código</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody><?=lista_generalSucursales($MySQLi, $idRangoDf)?></tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--   MODAL REGISTRAR NUEVA SUCURSAL  -->
              <div class="modal fade" id="openModaladdSucursal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Registrar nueva sucursal</h4>
                    </div>
                    <div class="modal-body">
                      <form id="registrarnuevaSucursal">
                        <input type="hidden" name="action" value="RegistrarSucursal">
                        <input type="hidden" name="serviStock" value="<?=$serviStock?>">                        
                        <div class="row my-2">
                          <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                            <label for="nombreSucursal">Nombre</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombreSucursal"><i class="fad fa-building"></i></label>
                              </div>
                              <input type="text" class="form-control" name="nombre" id="nombreSucursal" placeholder="Nombre sucursal">
                            </div>
                            <div class="emptyNombre text-center text-danger mt-2 d-none">INGRESE NOMBRE</div>
                            <div class="limiteNombreExcedido text-center text-danger mt-2 d-none">LÍMITE EXCEDIDO</div>
                          </div>
                          <div class="col-sm-12 col-md-6 col-lg-6 mb-2">
                            <label for="codigoSucursal">Código</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="codigoSucursal"><i class="fad fa-barcode-alt"></i></label>
                              </div>
                              <input type="text" class="form-control" name="codigo" id="codigoSucursal" placeholder="Código sucursal">
                            </div>
                            <div class="emptyCode text-center text-danger mt-2 d-none">INGRESE CÓDIGO</div>
                            <div class="limiteCodigoExcedido text-center text-danger mt-2 d-none">LÍMITE EXCEDIDO</div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary btn-block regNewSucursal">Registrar nueva sucursal</button>
                            <div class="spinner-regNewSucursal spinner-<?=APP_THEME ?> m-auto d-none">
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
              <!--   MODAL EDITAR SUCURSAL  -->
              <div class="modal fade" id="openModaleditSucursal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Editar sucursal <small class="text-danger">Todos los campos en este formulario son obligatorios.</small></h4>
                    </div>
                    <div class="modal-body">
                      <form id="updateSucursal">
                        <input type="hidden" name="action" value="actualizarSucursal">
                        <input type="hidden" name="idSucursal" id="idSucursalModal">
                        <div class="row">
                          <div class="col">
                            <label for="nombre_Sucursal">Nombre</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombre_Sucursal"><i class="fad fa-building"></i></label>
                              </div>
                              <input type="text" class="form-control" name="nombre" id="nombre_Sucursal" placeholder="Nombre sucursal">
                            </div>
                            <div class="emptyNombre text-center text-danger mt-2 d-none">INGRESE NOMBRE</div>
                            <div class="limiteNombreExcedido text-center text-danger mt-2 d-none">LÍMITE EXCEDIDO</div>
                          </div>
                          <div class="col">
                            <label for="codigo_Sucursal">Código</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="codigo_Sucursal"><i class="fad fa-barcode-alt"></i></label>
                              </div>
                              <input type="text" class="form-control" name="codigo" id="codigo_Sucursal" placeholder="Código sucursal">
                            </div>
                            <div class="emptyCode text-center text-danger mt-2 d-none">INGRESE CÓDIGO</div>
                            <div class="limiteCodigoExcedido text-center text-danger mt-2 d-none">LÍMITE EXCEDIDO</div>
                          </div>
                        </div>
                        <div class="row mt-3 btnActualizarSucursal">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary btn-block actualizarSucursal">Actualizar sucursal</button>
                            <div class="spinner-actualizarSucursal spinner-<?=APP_THEME ?> m-auto d-none">
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
              <?php
            } ?>
          </main><?php
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/sucursal.js"></script>
  </body>
</html>