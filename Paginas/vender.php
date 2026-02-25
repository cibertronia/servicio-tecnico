<?php
$alert        = aleatorio();
$claveTemporal= md5(date("d/m/Y g:i:s").$alert);
require_once 'init.php';
$_title       = 'Ventas directas - '.APP_TITLE;
$_active_nav  = 'VentasDirectas';
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
            <ol class="breadcrumb page-breadcrumb">
              <li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol>
            <div id="panel-1" class="panel">
              <div class="panel-hdr">
                <h2>Ventas <span class="fw-300"><i>directas</i> </span></h2>
                <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">                      
                <div class="panel-content"><div class="respuesta"></div>
                  <form>
                    <input type="hidden" name="clienteExistente" id="idCliente_existente">
                    <input type="hidden" name="claveTemporal" id="claveTemporal" value="<?=$claveTemporal ?>">
                    <input type="hidden" name="serviStock" id="serviStock" value="<?=$serviStock?>">
                    <input type="hidden" name="serviProveedor" id="serviProveedor" value="<?=$serviProveedor?>">
                    <input type="hidden" name="serviCategoria" id="serviCategoria" value="<?=$serviCategorias?>">
                    <input type="hidden" name="numerodeSucursale" id="numerodeSucursales" value="<?=numSucursales($MySQLi)?>">                    
                    <div class="row">
                      <div class="col-sm-12 col-md-7 col-lg-7 col-xl-7">
                        <div class="row">
                          <!-- NOMBRE DEL VENDEDOR -->
                          <div class="my-2 col-sm-12 col-md-6 col-lg-6">
                            <label for="nombreVendedor" class="form-label">Vendedor </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombreVendedor"><i class="fad fa-address-card"></i></label>
                              </div>
                              <input type="hidden" id="nombre_Vendedor" value="<?=$nombreUsuarioDf ?>">
                              <select name="idVendedor" id="nombreVendedor" class="form-control" readonly>
                                <option selected value="<?=$idUser?>"><?=$nombreUsuarioDf?></option><?php
                                $Q_Vendedores = mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE estado=1 AND idUser!='$idUser' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
                                while ($dataVe= mysqli_fetch_assoc($Q_Vendedores)) {
                                  echo'<option value='.$dataVe['idUser'] .'>'.$dataVe['Nombre'].'</option>';
                                } ?>
                              </select>
                            </div>
                          </div>
                          <!-- NUMERO DE FACTURAS -->
                          <div class="my-2 col-sm-12 col-md-6 col-lg-6">
                            <label for="numFactura" class="form-label">Factura N&ordm; </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="numFactura"><i class="fad fa-barcode"></i></label>
                              </div>
                              <input type="text" name="numFactura" id="numFactura" class="form-control" readonly>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <!-- BOTON CLIENTE EXISTENTE -->
                          <div class="col-sm-6 col-md-6 col-lg-6 my-2 text-center">
                            <label for="clienteExistente" class="form-label">¿Cliente existente? &nbsp;</label><br><label for="clienteExistente" class="form-label text-danger">No &nbsp;</label>
                            <input type="checkbox" id="clienteExistente" class="js-switch" checked>
                            <label for="clienteExistente" class="form-label text-success">  &nbsp;Sí</label>
                          </div>
                          <!-- LISTA DE CLIENTES -->
                          <div class="col-sm-6 col-md-6 col-lg-6 my-2 selectListaClientes d-none">
                            <label for="idCliente_lista" class="form-label">Lista de clientes</label>
                            <select name="idCliente" id="idCliente_lista" class="select2"></select>
                          </div>
                          <!-- CARGANDO CLIENTES -->
                          <div class="col-sm-6 col-md-6 col-lg-6 my-2 cargandoClientes text-center d-none">
                            <label class="form-label" style="letter-spacing: 2px;">Cargando clientes</label>
                            <div class="spinner-<?=APP_THEME ?> m-auto">
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
                        <!-- CARGANDO...  -->
                        <div class="row my-2 text-center loaderDatosClientes d-none">
                          <div class="col">
                            <label style="letter-spacing: 2px;">CARGANDO...</label>
                            <div class="spinner-<?=APP_THEME ?> m-auto">
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
                        <!-- DATOS DEL CLIENTE -->
                        <div class="row datosCliente d-none">
                          <!-- NOMBRE CLIENTE -->
                          <div class="my-2 col-sm-6 col-md-6 col-lg-6">
                            <label for="nombreCliente" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombreCliente"><i class="fad fa-address-card"></i></label>
                              </div>
                              <input type="text" name="nombreCliente" id="nombreCliente" class="form-control" placeholder="nombre cliente">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreExcedido d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyNombreCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE CLIENTE</div>                        
                          </div>
                          <!-- CELULAR -->
                          <div class="my-2 col-sm-6 col-md-6 col-lg-6">
                            <label for="celularCliente" class="form-label">Celular <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefonoCliente"><i class="fad fa-phone-alt"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Teléfono cliente" name="telefonoCliente" id="telefonoCliente" data-inputmask="'mask': '9999-9999'">
                            </div>
                            <div class="emptyCelularCliente text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                          </div>
                        </div>  
                        <div class="row alertTablaProducto">
                          <div class="col tablaProductosTemporales"></div>
                        </div>                  
                        <!-- PRODUCTO -->
                        <div class="row cargandoProductos text-center d-none">
                          <!-- SPINNER CARGANDO PRODUCTOS -->
                          <div class="my-2 col-sm-6 col-md-6 col-lg-6">
                            <div class="spinner-cargandoProductos spinner-<?=APP_THEME ?> m-auto">
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
                            <label for="spinner" class="form-label" style="letter-spacing: 2px;">Un momento por favor...</label>
                          </div>
                        </div>
                        <!-- LISTA DE PRODUCTOS -->
                        <div class="row">
                          <!-- BOTONES AGREGAR OTROS PRODUCTO -->
                          <div class="my-2 col-sm-12 col-md-12 col-lg-12 text-center d-none btn-agregarotroProducto">
                            <label for="btn-continuar" class="form-label">¿Desea agregar otro producto?</label><br>
                            <button type="button" class="btn btn-sm btn-success btn-Sicontinuar">Sí</button> &nbsp; 
                            <button type="button" class="btn btn-sm btn-danger btn-Nocontinuar">No</button>
                          </div><?php
                          /*if ($serviProveedor==1) { echo'
                            <div class="my-2 col-sm-6 col-md-3 col-lg-3 selectorProducto d-none">
                              <label for="selectorProveedor" class="form-label">Lista proveedores</label>
                              <select name="producto" id="selectorProveedor" class="select2"></select>
                            </div>';
                          }*/
                          /*if ($serviCategorias==1) { echo'
                            <div class="my-2 col-sm-6 col-md-3 col-lg-3 selectorProducto d-none">
                              <label for="selectorCategorias" class="form-label">Lista categorias</label>
                              <select name="producto" id="selectorCategorias" class="select2"></select>
                            </div>';
                          }*/ ?>
                          <!-- SELECTOR DE PRODUCTOS -->
                          <div class="my-2 col-sm-6 col-md-6 col-lg-6 selectorProducto d-none">
                            <label for="selectorProducto" class="form-label">Lista productos</label>
                            <select name="producto" id="selectorProducto" class="select2"></select>
                          </div>
                          <!-- Stock de productos disponibles --><?php
                          if ($serviStock==1) {
                            $numeroSucursales = numSucursales($MySQLi);
                            for ($i=0; $i < $numeroSucursales; $i++) { echo'
                              <div class="my-2 col-sm-6 col-md-3 col-lg-3 stockProducto d-none">
                                <label for="stockDisponible_'.$i.'" class="form-label">stock <span class="codigoTienda_'.$i.'"></span></label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="stockDisponible_'.$i.'"><i class="fad fa-box-open"></i></label>
                                  </div>
                                  <input type="tel" id="stockDisponible_'.$i.'" class="form-control" disabled>
                                </div>
                              </div>';
                            }
                          } ?>
                          <div class="my-2 col-sm-6 col-md-6 col-lg-6 btn-NoMas text-center d-none">
                            <label for="btn-continuar"> &nbsp;&nbsp; </label><br>
                            <button type="button" class="btn btn-sm btn-danger form-control btn-Yano">Ya no deseo agregar otro producto</button>
                          </div>
                        </div><?php
                        /*  PENDIENTE DE CONFIGURACION  */
                        /*if ($serviStock==1) { echo'
                          <div class="row">';
                            $Q_Inventario = mysqli_query($MySQLi,"SELECT * FROM inventario");
                            $resultInvent = mysqli_num_rows($Q_Inventario);
                            if ($resultInvent>0) { echo'
                              <div class="my-2 col-sm-6 col-md-3 col-lg-3">
                                <label for="stockSucursal" class="form-label"></label>
                                <input type="text" name="stock[]" id="stockSucursal">
                              </div>';
                            }else{ echo'
                              <div class="my-2 col text-center text-danger">INVENTARIO NO DEFINIDO</div>';
                            } echo'                      
                          </div>';
                        }*/ ?>
                        <div class="row spinner-consultaPrecio d-none">
                          <div class="col text-center my-2">
                            <div class="spinner-<?=APP_THEME ?> m-auto">
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
                            <label for="spinner" class="form-label" style="letter-spacing: 2px;">Cargando datos del producto...</label>
                          </div>
                        </div>
                        <div class="row datosProducto d-none">
                          <!-- Precio venta -->
                          <div class="my-2 col-sm-6 col-md-3 col-lg-3">
                            <label for="precioVenta" class="form-label">Precio venta <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="precioVenta"><span class="simboloMoneda"></span></label>
                              </div>
                              <input type="text" name="precioVenta" id="precioVenta" class="form-control" placeholder="precio venta">
                            </div>
                            <div class="emptyPrecioVenta text-center text-danger mt-2 d-none">INGRESE PRECIO</div>
                            <div class="invalidPrecioVenta text-center text-danger mt-2 d-none">VALOR INVÁLIDO</div>
                          </div>
                          <!-- Cantidad -->
                          <div class="my-2 col-sm-6 col-md-3 col-lg-3">
                            <label for="cantidadProducto" class="form-label">Cantidad <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="cantidadProducto"><i class="fad fa-box-open"></i></label>
                              </div>
                              <input type="text" name="cantidadProducto" id="cantidadProducto" class="form-control" placeholder="cantidad">
                            </div>
                            <div class="emptyCantidadProducto text-center text-danger mt-2 d-none">INGRESE CANTIDAD</div>
                            <div class="invalidCantidadProducto text-center text-danger mt-2 d-none">VALOR INVÁLIDO</div>
                          </div>
                          <!-- Precio especial -->
                          <div class="my-2 col-sm-6 col-md-3 col-lg-3">
                            <label for="precioEspecial" class="form-label">Precio especial <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="precioEspecial"><span class="simboloMoneda"></span></label>
                              </div>
                              <input type="text" name="precioEspecial" id="precioEspecial" class="form-control" placeholder="precio especial">
                            </div>
                            <div class="emptyPrecioEspecial text-center text-danger mt-2 d-none">INGRESE PRECIO</div>
                            <div class="invalidPrecioEspecial text-center text-danger mt-2 d-none">VALOR INVÁLIDO</div>
                          </div>
                          <!-- Boton agregar mas productos -->
                          <div class="my-2 col-sm-6 col-md-3 col-lg-3">
                            <label for="btn-masProductos" class="form-label labelBtn">&nbsp;&nbsp;</label>
                            <button type="button" id="btn-masProductos" class="btn btn-primary btn-block btn-masProductos"><i class="far fa-cart-arrow-down"></i></button>
                            <div class="spinner-masProductos spinner-<?=APP_THEME ?> m-auto d-none">
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
                      <!-- VISTA FACTURA -->
                      <div class="col-sm-12 col-md-5 col-lg-5 col-xl-5">
                        <table class="table table-striped table-bordered table-td-valign-middle w-100"style="font-size:10px;">
                          <tr>
                            <td colspan="2" class="text-center">FACTURA N&ordm; <span class="numFactura text-danger"></span></td>
                          </tr>
                          <tr>
                            <td>
                              Cliente: <span id="nombre_Cliente"></span>
                            </td>
                            <td>Teléfono: <span id="telefono_Cliente"></span>                              
                            </td>
                          </tr>
                          <tr><td colspan="2">Vendedor: <span class="nombreVendedor"></span></td></tr>
                          <tr>
                            <td colspan="2" class="tablaProductosFactura"></td>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </form>
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
    <script src="<?=ASSETS_URL?>/js/vender.js"></script>
  </body>
</html>