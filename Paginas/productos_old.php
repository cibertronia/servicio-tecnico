<?php
require_once 'init.php';
$_title = 'Lista productos - '.APP_TITLE;
$_active_nav = 'ListaProductos';?>
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
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol>
            <div id="panelProductos" class="panel">
              <div class="panel-hdr">
                <h2>Lista de <span class="fw-300"><i>Productos</i></span>
                </h2>
                <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container"><div class="respuesta"></div>
                <div class="panel-content">
                  <!-- LISTA DE PRODUCTOS -->
                  <table id="listaProductos" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                      <tr>
                        <th class="text-center">N&ordm;</th>
                        <th class="text-center">Imagen</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Marca</th>
                        <th class="text-center">Modelo</th>
                        <th class="text-center">Precio</th><?php
                        if ($serviStock==1) { echo'
                          <th class="text-center">Stock</th>';
                        }?>
                        <th class="text-center">Código</th>
                        <th class="text-center">Acciones</th>
                      </tr>
                    </thead>
                    <tbody><?=listaProductos($serviStock)?></tbody>
                  </table>
                </div>
              </div>
            </div>
            <!-- Modal editar imagen producto -->
            <div class="modal fade" id="openModalEditImagen" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">
                      Editar imagen
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true"><i class="fal fa-times"></i></span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form id="actualizaImagen" enctype="multipart/form-data" method="POST">
                      <div class="row">
                        <div class="col text-center w-100">
                          <input type="hidden" name="action" value="actualzarImagenProducto">
                          <input type="hidden" name="idProducto" id="idProductoImagenModal">
                          <div id="imgx"></div>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col text-center w-100">
                          <span class="btn btn-primary fileinput-button mt-4">
                            <i class="far fa-plus"></i>
                            <span>Cambiar imagen</span>
                            <input type="file" name="imagen" id="img_file">
                          </span>
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col">
                          <button class="btn btn-primary btn-block d-none btnActualizaImgProducto">Guardar cambios</button>
                          <div class="spinner spinner-<?=APP_THEME ?> m-auto d-none">
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
            <!-- PANEL EDITAR PRODUCTO -->
            <div id="panelEditarProducto" class="panel d-none">
              <div class="panel-hdr">
                <h2>Lista de <span class="fw-300"><i>Productos</i></span></h2>
                <div class="panel-toolbar">
                  <button class="btn btn-danger btn-xs cerrarPanelEditar" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cancelar editar este producto" id=""><i class="far fa-ban"> </i> CANCELAR</button>
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">
                <div class="panel-content">
                  <form id="formProducto" enctype="multipart/form-data" method="POST">
                    <input type="hidden" name="action" value="acualizarDatosProducto">
                    <input type="hidden" name="idProducto" id="idProductoPanelEdit">
                    <div class="row">
                      <div class="col">
                        <div class="row"><?php
                          if ($serviProveedor==1) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                              <label for="proveedor">Proveedores</label>
                              <select name="proveedor" id="proveedor" class="form-control">
                                <option disabled selected>Seleccione proveedor</option><?php
                                $Q_Proveedor = mysqli_query($MySQLi,"SELECT * FROM proveedores WHERE estado=1");
                                while ($dataProveedor = mysqli_fetch_assoc($Q_Proveedor)) {
                                  echo'<option value='.$dataProveedor['idProveedor'].'>'.$dataProveedor['proveedor'] .'</option>';
                                } ?>
                              </select>
                            </div><?php
                          }
                          if ($serviCategorias==1) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                              <label for="cateorias">Categorias</label>
                              <select name="cateorias[]" id="cateorias" class="form-control multiple">
                                <option disabled selected>Seleccione categoria</option><?php
                                $Q_Categoria = mysqli_query($MySQLi,"SELECT * FROM categorias WHERE estado=1");
                                while ($dataCategoria = mysqli_fetch_assoc($Q_Categoria)) {
                                  echo'<option value='.$dataCategoria['idCategoria'].'>'.$dataCategoria['categoria'] .'</option>';
                                } ?>
                              </select>
                            </div><?php
                          } ?>
                        </div>
                        <div class="row mt-2">
                          <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                            <label for="nombreProducto">Nombre</label>
                            <input type="text" name="nombreProducto" id="nombreProducto" class="form-control" placeholder="Nombre producto">
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                            <label for="marcaProducto">Marca</label>
                            <input type="text" name="marcaProducto" id="marcaProducto" class="form-control" placeholder="Marca">
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                            <label for="modeloProducto">Modelo</label>
                            <input type="text" name="modeloProducto" id="modeloProducto" class="form-control" placeholder="Modelo">
                          </div>
                          <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                            <label for="industriaProducto">Industria</label>
                              <input type="text" name="industriaProducto" id="industriaProducto" class="form-control" placeholder="Industria">
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                            <label for="precioProducto">Precio</label>
                            <input type="text" name="precioProducto" id="precioProducto" class="form-control" placeholder="Precio">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row mt-2"><?php
                      if ($serviStock==1) { ?>
                        <div class="col-sm-12 col-md-8 col-lg-8">
                          <label for="caracteristicasProducto  " class="form-label">Características</label>
                          <textarea name="caracteristicasProducto" id="caracteristicasProducto" class="js-summernote form-control"></textarea>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4"><?php
                          $Q_Sucursales     = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1");
                          $ResultSucursales = mysqli_num_rows($Q_Sucursales);
                          $Filas_Sucursales = ceil($ResultSucursales/2);
                          if ($ResultSucursales>2) {
                            for ($i=0; $i < $Filas_Sucursales ; $i++) { echo'
                              <div class="row">';
                                while ($dataSu= mysqli_fetch_assoc($Q_Sucursales)) { echo'
                                  <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                                    <span class="form-control bg-primary text-white">'.$dataSu['sucursal'].'</span>
                                    <div class="row mb-2">
                                      <div class="col">
                                        <label class="mt-2" for="stock_'.$dataSu['codeTienda'].'">STOCK</label>
                                        <input type="hidden" name="idTienda[]" value='.$dataSu['idTienda'].'>
                                        <input type="text" name="stock[]" id="stock_'.$dataSu['codeTienda'].'" class="form-control" placeholder="Stock" required>
                                      </div>
                                    </div>
                                  </div>';
                                } echo'
                              </div>';
                            }
                          }else{ echo'
                            <div class="row mt-3">';
                              for ($i=0; $i <= $Filas_Sucursales ; $i++) {
                                $Q_sucursales = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1 LIMIT $i,$Filas_Sucursales ");
                                while ($dataSu= mysqli_fetch_assoc($Q_sucursales)) { echo'
                                  <div class="col-sm-12 col-md-6 col-lg-6 text-center">
                                    <span class="form-control bg-primary text-white">'.$dataSu['sucursal'].'</span>
                                    <div class="row mb-2">
                                      <div class="col">
                                        <label class="mt-2" for="stock_'.$dataSu['codeTienda'].'">STOCK</label>
                                        <input type="hidden" name="idTienda[]" value='.$dataSu['idTienda'].'>
                                        <input type="text" name="stock[]" id="stock_'.$dataSu['codeTienda'].'" class="form-control" placeholder="Stock" required>
                                      </div>
                                    </div>
                                  </div>';
                                }
                              } echo'
                            </div>';
                          } ?>
                          <div class="row mt-3 text-center">
                            <div class="col mt-3">
                              <button class="btn btn-primary btn-block btnActualizarProducto">ACTUALIZAR PRODUCTO</button>
                              <div class="spinner spinner-<?=APP_THEME ?> m-auto d-none">
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
                        </div><?php
                      }else{ ?>
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <label for="caracteristicasProducto  " class="form-label">Características</label>
                          <!-- <div class="js-summernote" id="saveToLocal"></div> -->
                          <textarea name="caracteristicasProducto" id="caracteristicasProducto" class="js-summernote form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mt-3 text-center">
                      <div class="col mt-3">
                        <button class="btn btn-primary btn-block btnActualizarProducto">ACTUALIZARR PRODUCTO</button>
                        <div class="spinner spinner-<?=APP_THEME ?> m-auto d-none">
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
                    </div><?php } ?>
                  </form>
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
    <script src="<?=ASSETS_URL?>/js/productos.js"></script>
  </body>
</html>