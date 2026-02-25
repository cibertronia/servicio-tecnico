<?php
require_once 'init.php';
$_title = 'Cotizaciones generadas - '.APP_TITLE;
$_active_nav = 'Generadas';?>
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
            <div id="panelCotizacionesGeneradas" class="panel"><div class="respuesta"></div>
              <input type="hidden" id="RangoUsuario" value="<?=$idRangoDf?>">
              <div class="panel-hdr"><?php
                if (isset($_POST['inicio'])) {
                  $Inicio     = $_POST['inicio'];
                  $Fin        = $_POST['fin']; ?>
                  <h2>Cotizaciones generadas <span class="fw-300"><i>del <span class="text-danger"><?= fechaFormato($Inicio)?></span> al <span class="text-danger"><?=fechaFormato($Fin)?></span></i></span></h2><?php
                }else{ ?>
                  <h2>Cotizaciones generadas <span class="fw-300"><i><?=$mes?></i></span></h2><?php
                }?>
                <div class="panel-toolbar">
                  <button type="button" class="btn btn-xs btn-primary Buscar"><i class="far fa-search"></i></button>
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">
                <div class="panel-content">
                  <form class="w-75 m-auto d-none" id="buscar" action="?root=generadas" method="POST">
                    <div class="row mb-2">
                      <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                        <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                        <input type="hidden" name="idTienda" value="<?php echo $idTiendaDf ?>">
                        <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $startBusqueda ?>" data-parsley-required="true">
                      </div>
                      <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                        <label for="fechaFin" class="form-label">Fecha final</label>
                        <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $fecha ?>" data-parsley-required="true">
                      </div>
                      <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                        <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                        <button class="btn btn-primary btn-block btn-Busca ">Buscar cotizaciones</button>
                      </div>
                    </div>
                  </form>
                  <table id="listaGeneradas" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                      <tr>
                        <th width="5%" class="text-center">ID</th>
                        <th width="95%" class="text-center">Detalle Cotizaci&oacute;n</th>
                      </tr>
                    </thead>
                    <tbody><?php
                      if (isset($_POST['inicio'])) {
                        lista_cotizacionesGeneradas($MySQLi,$Inicio,$Fin,$idRangoDf,$idTiendaDf);
                      }else{
                        lista_cotizacionesGeneradas($MySQLi,$startBusqueda,$fecha,$idRangoDf,$idTiendaDf);
                      }?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div id="panelEditarCot" class="panel d-none">
              <div class="panel-hdr">
                <h2>Panel editar  <span class="fw-300"><i>cotizacion</i></span></h2>
                <div class="panel-toolbar">
                  <button type="button" class="btn btn-xs btn-danger cerrarPanel"> cerrar </button>
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container">
                <div class="panel-content">
                  <form id="ActualizarCotizacion">
                    <input type="hidden" name="action" value="ActualizarDatosCotizacion">
                    <input type="hidden" name="sucursales" id="numSucursales" value="<?=numSucursales($MySQLi)?>">
                    <input type="hidden" name="servicioStock" id="serviStock" value="<?=$serviStock?>">
                    <input type="hidden" name="claveTemporal" id="claveTemporal_Panel">
                    <div class="row alertTablaProducto">
                      <div class="col tablaProductosTemporales"></div>
                    </div>
                    <div class="row">
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4 selectorProducto">
                        <label for="selectorProducto" class="form-label">Lista productos</label>
                        <select name="producto" id="selectorProducto" class="select2"></select>
                      </div>
                      <!-- Stock de productos disponibles --><?php
                      if ($serviStock == 1) {
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
                      <!-- YA NO DESEO AGREGAR OTRO PRODUCTO -->
                      <div class="my-2 col-sm-6 col-md-4 col-lg-4 btn-NoMas text-center">
                        <label for="btn-continuar"> &nbsp;&nbsp; </label><br>
                        <button type="button" class="btn btn-sm btn-danger btn-Yano">Ya no deseo agregar otro producto</button>
                      </div>
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
                    </div>
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
                        <textarea name="detallesGarantia" id="detallesGarantia" class="form-control"></textarea>
                      </div>
                      <!-- Observaciones -->
                      <div class="my-2 col-sm-6 col-md-6 col-lg-6">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" placeholder="Ingrese alguna observacion, aclaración o detalle que le parezca importante."></textarea>
                      </div>
                    </div>
                    <div class="row detallesCotizacion d-none">
                      <div class="col text-center">
                        <button class="my-2 btn btn-primary btn-sm guardarCotizacion" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Guardar cotización" >ACTUALIZAR COTIZACIÓN &nbsp; <i class="far fa-save"></i></button>
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
            <!-- Modal enviar cotizacion por correo -->
            <div class="modal fade" id="modal_enviarCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title">Enviar correo</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                  </div>
                  <div class="modal-body">
                    <form id="sendMailAndCotiza">
                      <div class="row">
                        <input type="hidden" name="idCotizacion" id="idCotizacionMail">
                        <input type="hidden" name="idTienda" id="idTiendaCotizacionCorreo">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="correoCliente" class="form-label">Correo</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="correoCliente"><i class="fad fa-envelope-open-text"></i></label>
                            </div>
                            <input type="email" name="correo" id="correoCliente" class="form-control">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="Asunto" class="form-label">Asunto</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="Asunto"><i class="fad fa-font"></i></label>
                            </div>
                            <input type="text" name="asunto" id="Asunto" class="form-control" value="Cotización solicitada">
                          </div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col">
                          <label for="Mensaje" class="form-label">Mensaje</label>
                          <textarea name="mensaje" id="Mensaje" class="form-control js-summernote"></textarea>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col">
                          <button class="btn btn-block btn-primary tbn-change sendCotizacionMail">Enviar Cotización &nbsp;<i class="fas fa-spinner fa-pulse d-none btn-sendCotiza"></i></button>
                          <div class="spinner-sendCotizacionMail spinner-<?=APP_THEME ?> m-auto d-none">
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
            <div class="modal fade" id="openModalAddCliente" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <h4 class="modal-title">Formulario cliente <small class="text-danger">Los campos marcados con * en este formulario son obligatorios.</small></h4>
                    <form id="formAddNuevoCliente">
                      <div class="row">
                        <div class="col">
                          <label for="nombreCliente">Nombre <span class="text-danger">*</span></label>
                          <input type="hidden" name="action" value="RegistrarNuevoCliente">
                          <input type="hidden" name="idTienda" value="<?=$idTiendaDf?>">
                          <input type="text" class="form-control" name="nombre" id="nombreCliente" placeholder="Nombre" >
                        </div>
                        <div class="col">
                          <label for="ciudadCliente">Ciudad <span class="text-danger">*</span></label>
                          <select class="form-control" name="ciudad" id="ciudadCliente">
                            <option disabled selected>Seleccione ciudad</option><?php
                            $Q_Ciudad = mysqli_query($MySQLi,"SELECT * FROM ciudades ORDER by ciudad ASC");
                            while ($dataCiudad = mysqli_fetch_assoc($Q_Ciudad)) {
                             echo'<option value='.$dataCiudad['idCiudad'] .'>'.$dataCiudad['ciudad'] .'</option>'; 
                           }?>
                         </select>
                       </div>
                     </div>
                     <div class="row mt-3">
                      <div class="col">
                        <label for="correoCliente">Correo</label>
                        <input type="email" class="form-control" name="correo" id="correoCliente" placeholder="correo@mail.com">
                      </div>
                      <div class="col">
                        <label for="empresaCliente">Empresa</label>
                        <input type="text" class="form-control" name="empresa" id="empresaCliente" placeholder="Empresa">
                      </div>                              
                    </div>
                    <div class="row mt-3">
                      <div class="col">
                        <label for="telefonoEmpresaCliente">Teléfono empresa</label>
                        <input type="tel" class="form-control" placeholder="Teléfono empresa" name="telefonoEmpresa" id="telefonoEmpresaCliente" >
                      </div>
                      <div class="col">
                        <label for="exttelefonoEmpresaCliente">extensión</label>
                        <input type="tel" class="form-control" placeholder="Teléfono empresa" name="extEmpresa" id="exttelefonoEmpresaCliente" >
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col">
                        <label for="telefonoCliente">Teléfono cliente <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" placeholder="Teléfono cliente" name="telefonoCliente" id="telefonoCliente" >
                      </div>
                      <div class="col">
                        <label for="apiCliente">Api Telegram</label>
                        <input type="tel" class="form-control" placeholder="API Telegram" name="idTelegram" id="apiCliente" >
                      </div>                              
                    </div> 
                    <div class="row mt-3">
                      <div class="col">
                        <label for="direccionCliente">Dirección </label>
                        <textarea name="direccion" id="direccionCliente" class="form-control" placeholder="Ingrese una dirección"></textarea>
                      </div>
                      <div class="col">
                        <label for="comentariosCliente">Comentarios </label>
                        <textarea name="comentarios" id="comentariosCliente" class="form-control" placeholder="Ingrese comentarios acerca del cliente si es necesario"></textarea>
                      </div>
                    </div> 
                    <div class="row mt-3">
                      <div class="col">
                        <button class="btn btn-primary btn-block btnRegistrarNuevoCliente">Registrar</button>
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
          </main><?php
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/generadas.js"></script>
  </body>
</html>