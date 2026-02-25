<?php
$alert        = aleatorio();
$claveTemporal= md5(date("d/m/Y g:i:s").$alert);
require_once 'init.php';
$_title       = 'Generar cotización - '.APP_TITLE;
$_active_nav  = 'GenerarCoti';
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
                <h2>Generar <span class="fw-300"><i>nueva cotización</i> </span></h2>
                <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">                      
                <div class="panel-content"><div class="respuesta"></div>
                  <!-- <div class="row">
                    <div class="col">
                      <h1 class="text-danger text-center">Estoy trabajando en esta área, por favor no usar</h1>
                    </div>
                  </div> -->
                  <form id="generarCotizacion">
                    <div class="row">
                      <!-- BOTON CLIENTE EXISTENTE -->
                      <div class="col-sm-6 col-md-6 col-lg-6 my-2 text-center">
                        <label for="clienteExistente" class="form-label">¿Cliente existente? &nbsp;</label><br><label for="clienteExistente" class="form-label text-danger">No &nbsp;</label>
                        <input type="hidden" name="action" value="generarCotizacion">
                        <input type="hidden" name="serviStock" id="serviStock" value="<?=$serviStock?>">
                        <input type="hidden" name="serviProveedor" id="serviProveedor" value="<?=$serviProveedor?>">
                        <input type="hidden" name="serviCategoria" id="serviCategoria" value="<?=$serviCategorias?>">
                        <input type="hidden" name="numerodeSucursale" id="numerodeSucursales" value="<?=numSucursales($MySQLi)?>">
                        <input type="hidden" name="clienteExistente" id="idCliente_existente">
                        <input type="hidden" name="claveTemporal" id="claveTemporal" value="<?=$claveTemporal ?>">
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
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
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
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="celularCliente" class="form-label">Celular <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="telefonoCliente"><i class="fad fa-phone-alt"></i></label>
                          </div>
                          <input type="tel" class="form-control" placeholder="Teléfono cliente" name="telefonoCliente" id="telefonoCliente" data-inputmask="'mask': '9999-9999'">
                        </div>
                        <div class="emptyCelularCliente text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                      </div>
                      <!-- CIUDAD -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="ciudadCliente" class="form-label">Ciudad <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="ciudadCliente"><i class="fad fa-car-building"></i></label>
                          </div>
                          <select name="ciudadCliente" id="ciudadCliente" class="form-control">
                            <option disabled selected value=0>Seleccione ciudad</option><?=listaCiudades($MySQLi)?>
                          </select>
                        </div>
                        <div class="emptyCiudadCliente text-center text-danger mt-2 d-none">SELECCIONE CIUDAD</div>
                      </div>
                    </div>
                    <div class="row datosCliente d-none">
                      <!-- CORREO CLIENTE -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="correoCliente" class="form-label">Correo</label>
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="correoCliente"><i class="fad fa-mailbox"></i></label>
                            </div>
                            <input type="email" class="form-control" name="correo" id="correoCliente" placeholder="correo@mail.com">
                          </div>
                          <div class="correoNoValido text-center text-danger mt-2 d-none">CORREO NO VÁLIDO</div>
                        </div>
                      </div>
                      <!-- EMPRESA CLIENTE -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="empresaCliente" class="form-label">Empresa</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="empresaCliente"><i class="fad fa-city"></i></label>
                          </div>
                          <input type="text" name="empresaCliente" id="empresaCliente" class="form-control" placeholder="Empresa cliente">
                        </div>
                        <div class="mt-2 text-danger text-center limiteNombreEmpresaExcedido d-none">LÍMITE EXCEDIDO</div>
                      </div>
                      <!-- TELEFONO EMPRESA -->
                      <div class="my-2 col-sm-6 col-md-2 col-lg-2">
                        <label for="telempresaCliente" class="form-label">Tel Empresa</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="telempresaCliente"><i class="fad fa-phone-office"></i></label>
                          </div>
                          <input type="tel" class="form-control" placeholder="Tel empresa" name="telefonoEmpresa" id="telempresaCliente" data-inputmask="'mask': '999-9999'">
                        </div>
                        <div class="emptyTelefonoEmpresa text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                      </div>
                      <!-- EXTENSION EMPRESA -->
                      <div class="my-2 col-sm-6 col-md-2 col-lg-2">
                        <label for="exttelempresaCliente" class="form-label">Ext Empresa</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="exttelefonoEmpresaCliente"><i class="fad fa-phone-office"></i></label>
                          </div>
                          <input type="tel" class="form-control" placeholder="Extensión" name="extEmpresa" id="exttelefonoEmpresaCliente" >
                        </div>
                        <!-- <input type="tel" name="exttelempresaCliente" id="exttelempresaCliente" class="form-control" placeholder="Ext Empresa"> -->
                      </div>
                    </div>
                    <div class="row datosCliente d-none">
                      <!-- DIRECCION -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="direccionCliente" class="form-label">Dirección</label>
                        <textarea name="direccion" id="direccionCliente" class="form-control" placeholder="ingrese una dirección"></textarea>
                      </div>
                      <!-- COMENTARIOS -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="comentariosCliente" class="form-label">Comentarios </label>
                        <textarea name="comentarios" id="comentariosCliente" class="form-control" placeholder="Ingrese comentarios acerca del cliente si es necesario"></textarea>
                      </div>
                      <!-- TELEGRAM -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="idTelegram" class="form-label">ID Telegram</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="idTelegram"><i class="fad fa-paper-plane"></i></label>
                          </div>
                          <input type="tel" class="form-control" placeholder="ID Telegram" name="idTelegram" id="idTelegram" >
                        </div>
                      </div>
                    </div>
                    <div class="row alertTablaProducto">
                      <div class="col tablaProductosTemporales"></div>
                    </div>
                    <!-- PRODUCTO -->
                    <div class="row cargandoProductos text-center d-none">
                      <!-- SPINNER CARGANDO PRODUCTOS -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
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
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4 selectorProducto d-none">
                        <label for="selectorProducto" class="form-label">Lista Repuestos [Mercaderia][Nombre]</label>
                        <select name="producto" id="selectorProducto" class="select2"></select>
                      </div>
                      <!-- Stock de productos disponibles --><?php
                      if ($serviStock==1) {
                        $numeroSucursales = numSucursales($MySQLi);
                        for ($i=0; $i < $numeroSucursales; $i++) { echo'
                          <div class="my-2 col-sm-6 col-md-2 col-lg-2 stockProducto d-none">
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
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4 btn-NoMas text-center d-none">
                        <label for="btn-continuar"> &nbsp;&nbsp; </label><br>
                        <button type="button" class="btn btn-sm btn-danger btn-Yano">Ya no deseo agregar otro producto</button>
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
                      <div class="my-2 col-sm-6 col-md-3 col-lg-3 text-center">
                        <label for="btn-masProductos" class="form-label labelBtn" style="letter-spacing: 2px;">&nbsp;&nbsp;</label>
                        <button type="button" id="btn-masProductos" class="btn btn-primary btn-block btn-masProductos"><i class="far fa-cart-arrow-down"></i> &nbsp; AGREGAR PRODUCTO</button>
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
                    <!-- DETALLES DE LA COTIZACIÓN -->
                    <div class="row detallesCotizacion d-none">
                      <!-- Forma de pago -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="formaPago" class="form-label">Forma de pago <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="formaPago"><i class="fad fa-handshake"></i></label>
                          </div>
                          <select name="formaPago" id="formaPago" class="form-control">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="Efectivo">Efectivo</option>
                            <option value="Cheque">Cheque</option>
                            <option value="Tranferencia bancaria">Tranferencia bancaria</option>
                          </select>
                        </div>
                        <div class="emptyFormaPago text-center text-danger mt-2 d-none">SELECCIONE FORMA PAGO</div>                        
                      </div>
                      <!-- Tiempo de entrega -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="tiempoEntrega" class="form-label">Tiempo de entrega <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="tiempoEntrega"><i class="fad fa-calendar-alt"></i></label>
                          </div>
                          <select name="tiempoEntrega" id="tiempoEntrega" class="form-control">
                            <option selected disabled>Seleccione una opción</option>
                            <option value="Inmediata">Inmediata</option>
                            <option value="A coordinar">A coordinar</option>
                          </select>
                        </div>
                        <div class="emptyTiempoEntrega text-center text-danger mt-2 d-none">SELECCIONE ENTREGA</div>
                      </div>
                      <!-- Validez cotizacion -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4">
                        <label for="validezCotizacion" class="form-label">Validez cotización <span class="text-danger">*</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="validezCotizacion"><i class="fad fa-calendar-alt"></i></label>
                          </div>
                          <input type="date" name="validezCotizacion" id="validezCotizacion" class="form-control">
                        </div>
                        <div class="emptyValidezOferta text-center text-danger mt-2 d-none">SELECCIONE FECHA</div>                        
                      </div>
                    </div>
                    <div class="row detallesCotizacion d-none">
                      <!-- Detalles de garantía -->
                      <div class="my-2 col-sm-6 col-md-6 col-lg-6">
                        <label for="detallesGarantia" class="form-label">Detalles de garantía <span class="text-danger">*</span></label>
                        <textarea name="detallesGarantia" id="detallesGarantia" class="form-control" placeholder="Ingrese detalles de la garantía."></textarea>
                      </div>
                      <!-- Observaciones -->
                      <div class="my-2 col-sm-6 col-md-6 col-lg-6">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" placeholder="Ingrese alguna observacion, aclaración o detalle que le parezca importante."></textarea>
                      </div>
                    </div>
                    <div class="row detallesCotizacion d-none">
                      <div class="col text-center">
                        <button class="my-2 btn btn-primary btn-sm guardarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Guardar cotización" >GUARDAR COTIZACIÓN &nbsp; <i class="far fa-save"></i></button>
                        <div class="spinner-guardarCotizacion spinner-<?=APP_THEME ?> m-auto d-none">
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
                  <!-- Modal editar producto -->
                  <div class="modal fade" id="modal_editarProductoTemporal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Editar producto</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                          <form id="formEditProducto">
                            <input type="hidden" name="action" value="ActualizarProductoTemporal">
                            <input type="hidden" name="idClave" id="idClave_ProductoTemporal">
                            <input type="hidden" name="claveTemporal" id="claveTemporal_modal">
                            <div class="row">
                              <!-- CANTIDAD PRODUCTO -->
                              <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                                <label for="cantidadProducto_modal" class="form-label">Cantidad</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="cantidadProducto_modal"><i class="fad fa-cart-arrow-down"></i></label>
                                  </div>
                                  <input type="tel" name="cantidad" id="cantidadProducto_modal" class="form-control" placeholder="Cantidad">
                                </div>
                                <div class="emptyCantidadProducto text-center text-danger mt-2 d-none">INGRESE CANTIDAD</div>
                                <div class="cantidadNoValida text-center text-danger mt-2 d-none">CANTIDAD NO VÁLIDA</div>
                              </div>
                              <!-- PRECIO ESPECIAL -->
                              <div class="col-sm-12 col-md-6 col-lg-6 my-2">
                                <label for="precioVenta_modal" class="form-label">Precio evnta</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <label class="input-group-text" for="precioVenta_modal"><i class="fad fa-sack-dollar"></i></label>
                                  </div>
                                  <input type="tel" name="precioEspecial" id="precioVenta_modal" class="form-control" placeholder="Precio venta">
                                </div>
                                <div class="emptyPrecioProducto text-center text-danger mt-2 d-none">INGRESE PRECIO</div>
                                <div class="precioEspNoValido text-center text-danger mt-2 d-none">VALOR NO VÁLIDO</div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col">
                                <button type="button" class="btn btn-default my-3" data-dismiss="modal">cerrar</button>
                              </div>
                              <div class="col">
                                <button type="submit" class="btn btn-primary btn-block btnActualizarProducto my-3"><i class="fad fa-cloud-upload"></i> &nbsp; ACTUALIZAR</button>
                                <div class="my-3 spinner-ActualizarProducto spinner-<?=APP_THEME ?> m-auto d-none">
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
    <script src="<?=ASSETS_URL?>/js/generar.js"></script>
  </body>
</html>