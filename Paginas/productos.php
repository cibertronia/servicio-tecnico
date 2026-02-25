<?php
require_once 'init.php';
$_title = 'Lista Repuestos - ' . APP_TITLE;
$_active_nav = 'ListaProductos'; ?>
<!DOCTYPE html>
<html lang="es"><?php
                include_once APP_PATH . '/includes/head.php'; ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?> "><?php
                                                include_once APP_PATH . '/includes/theme.php'; ?>
    <div class="page-wrapper">
        <div class="page-inner"><?php
                                include_once APP_PATH . '/includes/nav.php'; ?>
            <div class="page-content-wrapper"><?php
                                                include_once APP_PATH . '/includes/header.php'; ?>
                <main id="js-page-content" role="main" class="page-content" data-rango="<?= $_SESSION['idRango'] ?>">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="position-absolute pos-top pos-right d-none d-sm-block"><?= $Fecha ?></li>
                    </ol>
                    <div id="panelProductos" class="panel">
                        <div class="panel-hdr">
                            <h2>LISTA DE<span class="fw-300"><i>REPUESTOS</i></span>  &nbsp;&nbsp;&nbsp;<a href="l.php?p=xx" target="_blank">Logs</a>
                            </h2>
                            <div class="panel-heading-btn">
                                <form method="POST" enctype="multipart/form-data" id="filesForm">
                                    <span class="btn btn-success fileinput-button">
                                        <i class="fa fa-file"><span id="imgName">&nbsp; SELECCIONAR ARCHIVO EXCEL</span>
                                        </i>
                                        <input type="file" name="dataCliente" id="file-input" class="form-control" accept=".csv" onChange="onLoadImage(event.target.files)" />
                                    </span>
                            </div>
                            &nbsp;
                            <div class="panel-heading-btn">
                                <button type="button" name="subir" class="btn btn-info form-control fa fa-upload buttonexcel"> CARGAR</button>
                                </form>

                            </div>
                            &nbsp;
                            &nbsp;
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                            </div>
                        </div>
                        <div class="panel-container">
                            <div class="respuesta"></div>
                            <div class="panel-content">
                                <!-- LISTA DE PRODUCTOS -->
                                <?php if ($_SESSION['idRango'] == 2) { ?>
                                <div class="row">
                                    <div class="col-3">
                                        <a class="btn btn-sm btn-block" style="background-color:#4FC23D" href="reportes/reporte_lista_repuestos.php?reporte_lista_repuestos=true" title="Descargar Lista Repuestos">
                                            <span style="color: white">DESCARGAR EXCEL</span>&nbsp;&nbsp;
                                            <i class="fa fa-download" style="color: white"></i>
                                        </a>
                                    </div>
                                    <div class="col mt-9">
                                    </div>
                                    <div>
                                        <a href="./includes/recibir_excel_csv/plantillaSubirRepuestos.csv"><i class="btn btn-primary fa fa-download" style="font-size: 11px">&nbsp;&nbsp;Descargar Plantilla.CSV</i>
                                        </a>
                                    </div>
                                </div>
                                <br>
                                <?php } ?>
                                <table id="listamisVentas" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th class="text-center">N&ordm;</th>
                                            <th class="text-center">Mercaderia</th>
                                            <th class="text-center">Nombre Repuesto</th>
                                            <!-- <th class="text-center">Marca</th>
                                            <th class="text-center">Modelo</th> -->
                                            <th class="text-center">Precio Unitario <?php echo SETTINGS['simbolo']; ?></th>
                                            <th class="text-center">Observaciones</th>

                                            <th class="text-center">Imagen</th>
                                            <?php
                                            if ($serviStock == 1) {
                                                $Q_Sucursales = mysqli_query($MySQLi, "SELECT codeTienda FROM sucursales WHERE estado=1 ORDER BY idTienda ASC");
                                                while ($dataSu = mysqli_fetch_assoc($Q_Sucursales)) {
                                                    echo '<th class="text-center">' . $dataSu['codeTienda'] . '</th>';
                                                }
                                            } ?>
                                            <!-- <th class="text-center">Código</th> -->
                                            <th class="text-center" style="background-color: white;">Total Stock</th>
                                            <th class="text-center">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="listaProductos"><?= listaProductos($MySQLi, $serviStock) ?></tbody>
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
                                                <button class="btn btn-primary btn-block d-none btnActualizaImgProducto">Guardar
                                                    cambios</button>
                                                <div class="spinner spinner-<?= APP_THEME ?> m-auto d-none">
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
                            <h2>Lista de <span class="fw-300"><i>Repuestos</i></span></h2>
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
                                    <input type="hidden" name="servicioProveedor" id="configuracionProveedor" value="<?= $serviProveedor ?>">
                                    <input type="hidden" name="servicioCategorias" id="configuracionCategorias" value="<?= $serviCategorias ?>">
                                    <input type="hidden" id="configuracionStock" value="<?= $serviStock ?>">
                                    <div class="row">
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
                                    <!-- DATOS DEL PRODUCTO -->
                                    <div class="col">
                                        <div class="row"><?php
                                                            //AREA PROVEEDOR
                                                            if ($serviProveedor == 1) { ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="proveedor" class="form-label">Proveedores <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="proveedor"><i class="fad fa-box-open"></i></label>
                                                        </div>
                                                        <select name="proveedor" id="proveedor" class="form-control">
                                                            <option disabled selected>Seleccione proveedor</option>
                                                            <?php
                                                                $Q_Proveedor = mysqli_query($MySQLi, "SELECT * FROM proveedores WHERE estado=1");
                                                                while ($dataProveedor = mysqli_fetch_assoc($Q_Proveedor)) {
                                                                    echo '<option value=' . $dataProveedor['idProveedor'] . '>' . $dataProveedor['proveedor'] . '</option>';
                                                                } ?>
                                                        </select>
                                                    </div>
                                                    <div class="noSelectProveedor text-center text-danger mt-2 d-none">
                                                        SELECCIONE PROVEEDOR</div>
                                                </div><?php
                                                            }
                                                            //AREA CATEGORIA
                                                            if ($serviCategorias == 1) { ?>
                                                <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                    <label for="categorias" class="form-label">Categorias <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="categorias"><i class="fad fa-box-open"></i></label>
                                                        </div>
                                                        <select name="categorias" id="categorias" class="form-control">
                                                            <option disabled selected>Seleccione categoria</option>
                                                            <?php
                                                                $Q_Categoria = mysqli_query($MySQLi, "SELECT * FROM categorias WHERE estado=1");
                                                                while ($dataCategoria = mysqli_fetch_assoc($Q_Categoria)) {
                                                                    echo '<option value=' . $dataCategoria['idCategoria'] . '>' . $dataCategoria['categoria'] . '</option>';
                                                                } ?>
                                                        </select>
                                                    </div>
                                                    <div class="noSelectCategoria text-center text-danger mt-2 d-none">
                                                        SELECCIONE CATEGORIA</div>
                                                </div><?php
                                                            } ?>
                                        </div>
                                        <div class="row mt-2">
                                            <!-- MERCADERIA DEL PRODUCTO -->
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="mercaderiaProducto" class="form-label">Mercaderia <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="mercaderiaProducto"><i class="fad fa-address-card"></i></label>
                                                    </div>
                                                    <input type="text" name="mercaderiaProducto" id="mercaderiaProducto" class="form-control" placeholder="Mercaderia producto">
                                                </div>
                                                <div class="emptyMercaderiaProducto text-center text-danger mt-2 d-none">
                                                    INGRESE MERCADERIA REPUESTO</div>
                                            </div>                                            
                                            <!-- NOMBRE DEL PRODUCTO -->
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="nombreProducto" class="form-label">Nombre <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="nombreProducto"><i class="fad fa-address-card"></i></label>
                                                    </div>
                                                    <input type="text" name="nombreProducto" id="nombreProducto" class="form-control" placeholder="Nombre producto">
                                                </div>
                                                <div class="emptyNombreProducto text-center text-danger mt-2 d-none">
                                                    INGRESE NOMBRE REPUESTO</div>
                                            </div>
                                            <!-- MARCA DEL PRODUCTO -->
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="marcaProducto" class="form-label">Marca <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="marcaProducto"><i class="fad fa-address-card"></i></label>
                                                    </div>
                                                    <input type="text" name="marcaProducto" id="marcaProducto" class="form-control" placeholder="Marca producto">
                                                </div>
                                                <div class="emptyMarcaProducto text-center text-danger mt-2 d-none">
                                                    INGRESE MARCA REPUESTO</div>
                                            </div>
                                            
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="obsProducto" class="form-label">Observaciones <span class="text-danger"></span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="obsProducto"><i class="fad fa-address-card"></i></label>
                                                    </div>
                                                    <input type="text" name="obsProducto" id="obsProducto" class="form-control" placeholder="Observaciones">
                                                </div>
                                                <div class="emptyMarcaProducto text-center text-danger mt-2 d-none">
                                                    INGRESE OBSERVACIONES REPUESTO</div>
                                            </div>
                                            
                                        </div>
                                        <div class="row mt-2">
                                            <!-- MODELO DEL PRODUCTO -->
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="modeloProducto" class="form-label">Modelo <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="modeloProducto"><i class="fad fa-address-card"></i></label>
                                                    </div>
                                                    <input type="text" name="modeloProducto" id="modeloProducto" class="form-control" placeholder="Modelo producto">
                                                </div>
                                                <div class="emptyModeloProducto text-center text-danger mt-2 d-none">
                                                    INGRESE MODELO REPUESTO</div>
                                            </div>
                                            <!-- INDUSTRIA DEL PRODUCTO -->
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="industriaProducto" class="form-label">Industria <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="industriaProducto"><i class="fad fa-address-card"></i></label>
                                                    </div>
                                                    <input type="text" name="industriaProducto" id="industriaProducto" class="form-control" placeholder="Industria del producto">
                                                </div>
                                                <div class="emptyIndustriaProducto text-center text-danger mt-2 d-none">
                                                    INGRESE INDUSTRIA REPUESTO</div>
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <!-- PRECIO DEL PRODUCTO -->
                                            <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                                <label for="precioProducto" class="form-label">Precio <span class="simboloMoneda"></span><span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="precioProducto"><i class="fad fa-sack-dollar"></i></label>
                                                    </div>
                                                    <input type="tel" name="precioProducto" id="precioProducto" class="form-control" placeholder="Precio">
                                                </div>
                                                <div class="emptyPrecioProducto text-center text-danger mt-2 d-none">
                                                    INGRESE PRECIO REPUESTO</div>
                                                <div class="noValidoPrecioProducto text-center text-danger mt-2 d-none">
                                                    PRECIO NO VÁLIDO</div>
                                            </div>

                                            <?php
                                            if ($idRangoDf > 1) {
                                            ?>
                                                <!-- borrar producto repuesto -->
                                                <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                                    <label for="eliminar_produto" class="form-label">Eliminar Repuesto </span><span class="text-danger">!</span></label>
                                                    <div class="input-group">
                                                        <a class="btn btn-warning btn-xm btn-block eliminar_repuesto" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="¿Eliminar repuesto?" id=""><i class="far fa-ban"> </i> ¿ELIMINAR REPUESTO?</a>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mt-2 ">
                                        <div class="col-sm-12 col-md-12 col-lg-12">
                                            <label for="caracteristicasProducto  " class="form-label">Características
                                                <span class="text-danger">*</span></label>
                                            <textarea name="caracteristicasProducto" id="caracteristicasProducto" class="js-summernote form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="row mt-3 text-center">
                                        <div class="col-sm-12 col-md-12 col-lg-12 my-3">
                                            <button type="submit" class="btn btn-primary btn-block btnActualizarProducto my-3"><i class="fad fa-cloud-upload fa-2x"></i> &nbsp; ACTUALIZAR
                                                REPUESTO</button>
                                            <div class="my-3 spinner-ActualizarProducto spinner-<?= APP_THEME ?> m-auto d-none">
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
                    <!-- Modal stock sucursal -->
                    <div class="modal fade" id="stockSucursal_modal" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">STOCK <span class="nombreSucursal text-uppercase"></span>
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form id="formStockSucursal">
                                        <input type="hidden" name="action" value="ActualizarStockSucursal">
                                        <input type="hidden" name="idInventario" id="idInventario_modal">
                                        <input type="hidden" name="sucursal" id="nombreSucursal_modal">
                                        <input type="hidden" name="serviStock" value="<?= $serviStock ?>">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <label for="stockSucursalModal" class="form-label">Stock actual</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="stockSucursalModal"><i class="fad fa-box-open"></i></label>
                                                    </div>
                                                    <input type="tel" name="stock" id="stockSucursalModal" class="form-control text-center" placeholder="stock">
                                                </div>
                                                <div class="stockVacio text-center text-danger my-2 d-none">STOCK VACÍO
                                                </div>
                                            </div>
                                            <div class="col-sm-4 text-center">
                                                <label for="emptyButton" class="form-label"> &nbsp; &nbsp; </label>
                                                <div class="input-group">
                                                    <!-- <div class="input-group-prepend">
                              <label class="input-group-text" for="emptyButton"><i class="fad fa-box-open"></i></label>
                            </div> -->
                                                    <button id="emptyButton" class="btn btn-sm btn-primary btnActualizarStock" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="actualizar stock"><i class="fad fa-upload"></i></button>
                                                </div>
                                            </div>
                                            
                                            <div class="col-sm-8">
                                                <label for="stockSucursalModal1" class="form-label">El nuevo stock debe ser mayor al actual</label>
                                                </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main><?php
                        include_once APP_PATH . '/includes/footer.php'; ?>
            </div>
        </div>
    </div>
    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
    <script src="<?= ASSETS_URL ?>/js/productos.js"></script>
</body>

</html>