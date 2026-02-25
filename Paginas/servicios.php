<?php
require_once 'init.php';
$_title       = 'Servicios - '.APP_TITLE;
$_active_nav  = 'Servicios';
$_head        = '';?>
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
            <div id="panel-1" class="panel">
              <div class="panel-hdr">
                <h2>Lista de <span class="fw-300"><i>Servicios</i> </span></h2>
                <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">                      
                <div class="panel-content"><div class="respuesta"></div>
                  <div class="row">
                    <!-- PÁGINA DE REGISTRO -->
                    <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                      <div class="card border mb-0">
                        <div class="card-header bg-<?=$paginaRegistro==1?'success':'danger'?>-500 d-flex pr-2 align-items-center flex-wrap pageRegistrar">
                          <div class="card-title"><span id="pagRegistrar"><?=$paginaRegistro==1?'Deshabilitar':'Habilitar'?></span> página registro</div>
                          <div class="custom-control d-flex ml-auto">
                            <input type="checkbox" class="js-switch paginaRegistrar" <?=$paginaRegistro==1?'checked':'' ?>>
                          </div>
                        </div>
                        <div class="spinner_paginaRegistrar spinner-<?=APP_THEME ?> m-auto d-none">
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
                    <!-- PRECIO DOLAR -->
                    <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                      <div class="card border mb-0">
                        <div class="card-header bg-<?=$serviPrecioUSD==1?'success':'danger'?>-500 d-flex pr-2 align-items-center flex-wrap precioUSD">
                          <div class="card-title"><span id="preUSD"><?=$serviPrecioUSD==1?'Deshabilitar':'Habilitar'?></span> Precio Dólar</div>
                          <div class="custom-control d-flex ml-auto">
                            <input type="checkbox" class="js-switch precioDolar" <?=$serviPrecioUSD==1?'checked':'' ?>>
                          </div>
                        </div>
                        <div class="spinner_precioDolar spinner-<?=APP_THEME ?> m-auto d-none">
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
                  </div>
                  <div class="row">
                    <!-- PROVEEDORES -->
                    <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                      <div class="card border mb-0">
                        <div class="card-header bg-<?=$serviProveedor==1?'success':'danger'?>-500 d-flex pr-2 align-items-center flex-wrap Proveedores">
                          <div class="card-title"><span id="funProveedor"><?=$serviProveedor==1?'Deshabilitar':'Habilitar'?></span> Proveedores</div>
                          <div class="custom-control d-flex ml-auto">
                            <input type="checkbox" class="js-switch proveedores" <?=$serviProveedor==1?'checked':'' ?>>
                          </div>
                        </div>
                        <div class="spinner_proveedores spinner-<?=APP_THEME ?> m-auto d-none">
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
                    <!-- CATEGORIAS -->
                    <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                      <div class="card border mb-0">
                        <div class="card-header bg-<?=$serviCategorias==1?'success':'danger'?>-500 d-flex pr-2 align-items-center flex-wrap Categorias">
                          <div class="card-title"><span id="funCategorias"><?=$serviCategorias==1?'Deshabilitar':'Habilitar'?></span> Categorias</div>
                          <div class="custom-control d-flex ml-auto">
                            <input type="checkbox" class="js-switch categorias" <?=$serviCategorias==1?'checked':'' ?>>
                          </div>
                        </div>
                        <div class="spinner_categorias spinner-<?=APP_THEME ?> m-auto d-none">
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
                  </div>
                  <div class="row">
                    <!-- STOCK -->
                    <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                      <div class="card border mb-0">
                        <div class="card-header bg-<?=$serviStock==1?'success':'danger'?>-500 d-flex pr-2 align-items-center flex-wrap Stock">
                          <div class="card-title"><span id="funStock"><?=$serviStock==1?'Deshabilitar':'Habilitar'?></span> Stock</div>
                          <div class="custom-control d-flex ml-auto">
                            <input type="checkbox" class="js-switch stock" <?=$serviStock==1?'checked=false':'' ?>>
                          </div>
                        </div><?php
                        if ($serviStock==1) {?>
                          <div class="card-footer cardStockFooter">
                            Deshabilitar el stock, implicará borrar el stock existente hasta el momento.<br>
                            Perderá el stock de la base de datos sin poder recuperarlo.
                          </div><?php
                         } ?>
                        <div class="spinner_stock spinner-<?=APP_THEME ?> m-auto d-none">
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
                    <!-- MONEDA PRINCIPAL -->
                    <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                      <div class="card border mb-0">
                        <div class="card-header bg-info-500 d-flex pr-2 align-items-center flex-wrap Stock">
                          <div class="card-title">Moneda principal &nbsp; <span class="simboloMoneda h2"></span></div>
                          <div class="custom-control d-flex ml-auto">
                            <select name="monedaPricipal" id="monedaPrincipal" class="form-control"><?php
                              $Q_Monedas = mysqli_query($MySQLi,"SELECT * FROM monedas WHERE estado=1 ORDER BY moneda ASC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                              while ($dataMoneda = mysqli_fetch_assoc($Q_Monedas)) {
                                echo '<option value='.$dataMoneda['idMoneda'].'>'.$dataMoneda['moneda']." (".$dataMoneda['simbolo'].')</option>';
                              } ?>
                            </select>
                          </div>
                        </div>
                        <div class="spinner_stock spinner-<?=APP_THEME ?> m-auto d-none">
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
                  </div>
                </div>
              </div>
            </div>
          </main><?php 
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div><?php 
    include_once APP_PATH.'/includes/extra.php';
    include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/servicios.js"></script>
  </body>
</html>