<?php
require_once 'init.php';
$_title = 'Agregar producto - '.APP_TITLE;
$_active_nav = 'AddProducto';?>
<!DOCTYPE html>
<html lang="es"><?php 
  include_once APP_PATH.'/includes/head.php'; ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?>"><?php 
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
        <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
            <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
                <main id="js-page-content" role="main" class="page-content">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="position-absolute pos-top pos-right d-none d-sm-block text-danger"><?=$Fecha ?></li>
                    </ol>
                    <div id="panel-1" class="panel">
                        <div class="panel-hdr">
                            <h2>Formulario <span class="fw-300"><i>AGREGAR REPUESTO</i></span>
                            </h2>
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip"
                                    data-offset="0,10" data-original-title="Comprimir"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                                    data-offset="0,10" data-original-title="Pantalla completa"></button>
                            </div>
                        </div>
                        <!-- Formlario agregar producto -->
                        <div class="panel-container">
                            <div class="respuesta"></div>
                            <div class="panel-content">
                                <!-- INICIA EL FORMULARIO -->
                                <form id="formProducto" enctype="multipart/form-data" method="POST">
                                    <input type="hidden" name="action" value="GuardarProducto">
                                    <input type="hidden" name="servicioProveedor" id="configuracionProveedor"
                                        value="<?=$serviProveedor?>">
                                    <input type="hidden" name="servicioCategorias" id="configuracionCategorias"
                                        value="<?=$serviCategorias?>">
                                    <input type="hidden" name="servicioStock" id="configuracionStock"
                                        value="<?=$serviStock?>">
                                    <div class="row">
                                        <!-- ÁREA DE LA IMAGEN -->
                                        <div class="col-lg-4 col-md-4 col-sm-12 text-center">
                                            <div class="row pt-2">
                                                <div class="col">
                                                    <div id="imgx"></div>
                                                </div>
                                            </div>
                                            <div class="row pb-2">
                                                <div class="col">
                                                    <span
                                                        class="btn btn-sm btn-warning fileinput-button mt-4 text-white">
                                                        <span class="textcambiarImagen"><i class="fad fa-upload"></i>
                                                            &nbsp; CARGAR IMAGEN</span>
                                                        <input type="file" name="imagen" id="imgProducto"
                                                            accept="image/png, image/jpeg, image/jpg">
                                                    </span>
                                                </div>
                                            </div>
                                            <!-- <div class="row mt-3">
                          <div class="col mt-1">
                            <label for="codigoProducto" class="form-label">Código producto</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="codigoProducto"><i class="fad fa-barcode"></i></label>
                                </div>
                                <input type="text" name="codigoProducto" id="codigoProducto" class="form-control" placeholder="código 000000-00-0-000">
                              </div>
                              <div class="text-muted mt-1">Utilizar con el código de barras o cree ud uno mismo</div>
                          </div>
                        </div> -->
                                        </div>
                                        <!-- DATOS DEL REPUESTO -->
                                        <div class="col">
                                            <div class="row"><?php
                          //AREA PROVEEDOR
                          if ($serviProveedor==1) { ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="proveedor" class="form-label">Proveedores <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="proveedor"><i
                                                                    class="fad fa-box-open"></i></label>
                                                        </div>
                                                        <select name="proveedor" id="proveedor" class="form-control">
                                                            <option disabled selected>Seleccione proveedor</option><?php
                                  $Q_Proveedor = mysqli_query($MySQLi,"SELECT * FROM proveedores WHERE estado=1");
                                  while ($dataProveedor = mysqli_fetch_assoc($Q_Proveedor)) {
                                    echo'<option value='.$dataProveedor['idProveedor'].'>'.$dataProveedor['proveedor'] .'</option>';
                                  } ?>
                                                        </select>
                                                    </div>
                                                    <div class="noSelectProveedor text-center text-danger mt-2 d-none">
                                                        SELECCIONE PROVEEDOR</div>
                                                </div><?php
                          }
                          //AREA CATEGORIA
                          if ($serviCategorias==1) { ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="categorias" class="form-label">Categorias <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="categorias"><i
                                                                    class="fad fa-box-open"></i></label>
                                                        </div>
                                                        <select name="categorias" id="categorias" class="form-control">
                                                            <option disabled selected>Seleccione categoria</option><?php
                                  $Q_Categoria = mysqli_query($MySQLi,"SELECT * FROM categorias WHERE estado=1");
                                  while ($dataCategoria = mysqli_fetch_assoc($Q_Categoria)) {
                                    echo'<option value='.$dataCategoria['idCategoria'].'>'.$dataCategoria['categoria'] .'</option>';
                                  } ?>
                                                        </select>
                                                    </div>
                                                    <div class="noSelectCategoria text-center text-danger mt-2 d-none">
                                                        SELECCIONE CATEGORIA</div>
                                                </div><?php
                          } ?>
                                            </div>
                                            <div class="row mt-2">
                                                <!-- NOMBRE MERCADERIA -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="mercaderia" class="form-label">Mercaderia <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="mercaderia"><i
                                                                    class="fad fa-address-card"></i></label>
                                                        </div>
                                                        <input type="text" name="mercaderia" id="mercaderia"
                                                            class="form-control" placeholder="Nombre Mercaderia">
                                                    </div>
                                                    <div
                                                        class="emptyNombreRepuesto text-center text-danger mt-2 d-none">
                                                        INGRESE MERCADERIA</div>
                                                </div>
                                                <!-- Mraca DEL REPUESTO -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">


                                                    <label for="marcaProducto" class="form-label">Marca <span
                                                            class="text-danger">(Opcional)</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="marcaProducto"><i
                                                                    class="fad fa-address-card"></i></label>
                                                        </div>
                                                        <input type="text" name="marcaProducto" id="marcaProducto"
                                                            class="form-control" placeholder="Marca repuesto">
                                                    </div>
                                                    <div class="emptyMarcaProducto text-center text-danger mt-2 d-none">
                                                        INGRESE MARCA REPUESTO</div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">

                                                <!-- Nombre DEL REPUESTO -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="nombreProducto" class="form-label">Nombre Repuesto <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="nombreProducto"><i
                                                                    class="fad fa-address-card"></i></label>
                                                        </div>
                                                        <input type="text" name="nombreProducto" id="nombreProducto"
                                                            class="form-control" placeholder="Nombre repuesto">
                                                    </div>
                                                    <div
                                                        class="emptyNombreProducto text-center text-danger mt-2 d-none">
                                                        INGRESE NOMBRE REPUESTO</div>

                                                </div>
                                                <!-- MODELO DEL REPUESTO -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="modeloProducto" class="form-label">Modelo <span
                                                            class="text-danger">(Opcional)</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="modeloProducto"><i
                                                                    class="fad fa-address-card"></i></label>
                                                        </div>
                                                        <input type="text" name="modeloProducto" id="modeloProducto"
                                                            class="form-control" placeholder="Modelo repuesto">
                                                    </div>
                                                    <div
                                                        class="emptyModeloProducto text-center text-danger mt-2 d-none">
                                                        INGRESE MODELO REPUESTO</div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <!-- observaciones -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="observaciones" class="form-label">Observaciones
                                                        <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="observaciones"><i
                                                                    class="fa fa-question-circle"></i></label>
                                                        </div>
                                                        <input type="tel" name="observaciones" id="observaciones"
                                                            class="form-control" value='Sin Observaciones'
                                                            placeholder="observaciones">
                                                    </div>
                                                </div>
                                                <!-- INDUSTRIA DEL PRODUCTO -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="industriaProducto" class="form-label">Industria <span
                                                            class="text-danger">(Opcional)</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="industriaProducto"><i
                                                                    class="fad fa-address-card"></i></label>
                                                        </div>
                                                        <input type="text" name="industriaProducto"
                                                            id="industriaProducto" class="form-control"
                                                            placeholder="Industria del  repuesto">
                                                    </div>
                                                    <div
                                                        class="emptyIndustriaProducto text-center text-danger mt-2 d-none">
                                                        INGRESE INDUSTRIA REPUESTO</div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                <!-- PRECIO DEL PRODUCTO -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="precioProducto" class="form-label">Precio Unitario en
                                                        <span class="simboloMoneda"></span><span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="precioProducto"><i
                                                                    class="fad fa-sack-dollar"></i></label>
                                                        </div>
                                                        <input type="tel" name="precioProducto" id="precioProducto"
                                                            class="form-control" placeholder="Precio">
                                                    </div>
                                                    <div
                                                        class="emptyPrecioProducto text-center text-danger mt-2 d-none">
                                                        INGRESE PRECIO REPUESTO</div>
                                                    <div
                                                        class="noValidoPrecioProducto text-center text-danger mt-2 d-none">
                                                        PRECIO NO VÁLIDO</div>
                                                </div>

                                                <?php
                          $Q_Sucursales     = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1");
                          $ResultSucursales = mysqli_num_rows($Q_Sucursales);?>
                                                <input type="hidden" name="numeroSucursales" id="numeroSucursales"
                                                    value="<?=$ResultSucursales?>"><?php
                          if ($serviStock==1 & $ResultSucursales == 1) { ?>
                                                <!-- STOCK PRODUCTOS CON UNA SUCURSAL -->
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="stockProducto" class="form-label">Stock <span
                                                            class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="stockProducto"><i
                                                                    class="fad fa-box-open"></i></label>
                                                        </div>
                                                        <input type="tel" name="stockProducto[]" id="stockProducto"
                                                            class="form-control" placeholder="Stock disponible">
                                                    </div>
                                                    <div class="stockVacio text-center text-danger mt-2 d-none">INGRESE
                                                        STOCK</div>
                                                    <div class="stockNoValido text-center text-danger mt-2 d-none">STOCK
                                                        NO VÁLIDO</div>
                                                </div><?php
                          } ?>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row mt-2 "><?php
                      if ($serviStock==1 AND $ResultSucursales>1 ) { ?>
                                        <div class="col-sm-12 col-md-8 col-lg-8">
                                            <label for="caracteristicasProducto" class="form-label">Características
                                                <span class="text-danger">( Opcional )</span></label>
                                            <textarea name="caracteristicasProducto" id="caracteristicasProducto"
                                                class="js-summernote form-control"></textarea>
                                        </div>
                                        <div class="col">
                                        <label for="stocks" class="form-label"> STOCKS POR SUCURSAL <span
                                                            class="text-danger">*</span></label>
                                            <?php
                          $Filas_Sucursales = ceil($ResultSucursales/2);
                          if ($ResultSucursales>2) {
                            for ($i=0; $i < $Filas_Sucursales ; $i++) { echo'
                          <div class="row">';
                            while ($dataSu= mysqli_fetch_assoc($Q_Sucursales)) { echo'
                            <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                              <label for="stock_'.$dataSu['codeTienda'].'" class="form-label">'.$dataSu['sucursal'].' <span class="text-danger">*</span></label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="stock_'.$dataSu['codeTienda'].'"><i class="fad fa-box-open"></i></label>
                                </div>
                                <input type="hidden" name="idTienda[]" value='.$dataSu['idTienda'].'>
                                <input type="text" name="stockProducto[]" id="stock_'.$dataSu['codeTienda'].'" class="form-control" placeholder="Stock" required>
                              </div>
                              <div class="stockNoValido text-center text-danger mt-2 d-none">STOCK NO VÁLIDO</div>
                            </div>';} echo'
                          </div>';}
                          }else{ echo'
                          <div class="row mt-3">';
                            for ($i=0; $i <= $Filas_Sucursales ; $i++) {
                              $Q_sucursales = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1 LIMIT $i,$Filas_Sucursales ");
                              while ($dataSu= mysqli_fetch_assoc($Q_sucursales)) { echo'
                            <div class="col-sm-12 col-md-6 col-lg-6">
                              <label for="stock_'.$dataSu['codeTienda'].'" class="form-label">'.$dataSu['sucursal'].' <span class="text-danger">*</span></label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="stock_'.$dataSu['codeTienda'].'"><i class="fad fa-box-open"></i></label>
                                </div>
                                <input type="hidden" name="idTienda[]" value='.$dataSu['idTienda'].'>
                                <input type="text" name="stockProducto[]" id="stock_'.$dataSu['codeTienda'].'" class="form-control" placeholder="Stock" required>
                              </div>
                              <div class="stockNoValido text-center text-danger mt-2 d-none">STOCK NO VÁLIDO</div>
                            </div>';}} echo'
                          </div>';} ?>
                                            <button type="submit"
                                                class="btn btn-primary btn-block btnGuardarProducto my-3"><i
                                                    class="fad fa-cloud-upload fa-2x"></i> &nbsp; GUARDAR
                                                REPUESTO</button>
                                            <div
                                                class="my-3 spinner-GuardarProducto spinner-<?=APP_THEME ?> m-auto d-none">
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
                                        </div><?php
                      }else{ ?>
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label for="caracteristicasProducto  " class="form-label">Características
                                                <span class="text-danger">( Opcional )</span></label>
                                            <textarea name="caracteristicasProducto" id="caracteristicasProducto"
                                                class="js-summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3 text-center">
                                        <div class="col-sm-12 col-md-12 col-lg-12 my-3">
                                            <button type="submit"
                                                class="btn btn-primary btn-block btnGuardarProducto my-3"><i
                                                    class="fad fa-cloud-upload fa-2x"></i> &nbsp; GUARDAR
                                                REPUESTO</button>
                                            <div
                                                class="my-3 spinner-GuardarProducto spinner-<?=APP_THEME ?> m-auto d-none">
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
    <script src="<?=ASSETS_URL?>/js/agregarProducto.js"></script>
</body>

</html>