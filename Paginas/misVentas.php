<?php
require_once 'init.php';
$_title = 'Mis Ventas - '.APP_TITLE;
$_active_nav = 'misVentas';?>
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
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block text-danger"><?=$Fecha ?></li></ol>
            <div id="panel-1" class="panel">
              <div class="panel-hdr"><?php
                if (isset($_POST['inicio'])) {
                  $Inicio     = $_POST['inicio'];
                  $Fin        = $_POST['fin']; ?>
                  <h2>Mis Ventas <span class="fw-300"><i>del <span class="text-danger"><?= fechaFormato($Inicio)?></span> al <span class="text-danger"><?=fechaFormato($Fin)?></span></i></span></h2><?php
                }else{ ?>
                  <h2>Mis ventas <span class="fw-300"><i class="text-uppercase"><?=$mes?></i></span>
                </h2><?php
                }?>                
                <div class="panel-toolbar">
                  <button type="button" class="btn btn-xs btn-primary Buscar"><i class="far fa-search"></i></button>
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container"><div class="respuesta"></div>
                <div class="panel-content">
                  <form class="w-75 m-auto d-none" id="buscar" action="?root=misVentas" method="POST">
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
                        <button class="btn btn-primary btn-block btn-Busca ">Buscar</button>
                      </div>
                    </div>
                  </form>
                  <table id="listamisVentas" class="table table-bordered table-hover table-striped w-100">
                    <thead>
                      <tr>
                        <th class="text-center">N&ordm;</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-center">Precio<br>venta <span class="simboloMoneda"></span></th>
                        <th class="text-center">Total<br>venta <span class="simboloMoneda"></span></th>
                        <th class="text-center">Recibo</th>
                        <th class="text-center">Nota E</th>
                      </tr>
                    </thead>
                    <tbody><?php
                      if (isset($_POST['inicio'])) {
                        tabla_misVentas($MySQLi,$idUser,$Inicio,$Fin);
                      }else{
                        tabla_misVentas($MySQLi,$idUser,$startBusqueda,$fecha);
                      }?>                        
                    </tbody>
                  </table>
                </div>
              </div>
              <!--   MODAL REGISTRAR NUEVO CLIENTE  -->
              <div class="modal fade" id="openModalAddCliente" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-body">
                      <h4 class="modal-title">Formulario cliente <small class="text-danger">Los campos marcados con * en este formulario son obligatorios.</small></h4>
                      <form id="formAddNuevoCliente">
                        <div class="row">
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <input type="hidden" name="action" value="RegistrarNuevoCliente">
                            <input type="hidden" name="idTienda" value="<?=$idTiendaDf?>">
                            <!-- NOMBRE CLIENTE -->
                            <label for="nombreCliente" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombreCliente"><i class="fad fa-address-card"></i></label>
                              </div>
                              <input type="text" class="form-control" name="nombreCliente" id="nombreCliente" placeholder="Nombre cliente">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreExcedido d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyNombreCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE CLIENTE</div>
                          </div>
                          <!-- CIUDAD -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
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
                        <div class="row mt-3">
                          <!-- CORREO -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                              <label for="correoCliente" class="form-label">Correo</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="correoCliente"><i class="fad fa-mailbox"></i></label>
                                </div>
                                <input type="email" class="form-control" name="correoCliente" id="correoCliente" placeholder="correo@mail.com">
                              </div>
                              <div class="correoNoValido text-center text-danger mt-2 d-none">CORREO NO VÁLIDO</div>
                            </div>
                          </div>
                          <!-- EMPRESA -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="empresaCliente" class="form-label">Empresa</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="empresaCliente"><i class="fad fa-city"></i></label>
                              </div>
                              <input type="text" class="form-control" name="empresaCliente" id="empresaCliente" placeholder="Empresa">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreEmpresaExcedido d-none">LÍMITE EXCEDIDO</div>
                          </div>                              
                        </div>
                        <div class="row mt-3">
                          <!-- TELÉFONO EMPRESA -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="telefonoEmpresaCliente" class="form-label">Teléfono empresa</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefonoEmpresaCliente"><i class="fad fa-phone-office"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Tel empresa" name="telefonoEmpresa" id="telefonoEmpresaCliente" data-inputmask="'mask': '999-9999'">
                            </div>
                            <div class="emptyTelefonoEmpresa text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                          </div>
                          <!-- EXTENSIÓN -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="exttelefonoEmpresaCliente" class="form-label">extensión</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="exttelefonoEmpresaCliente"><i class="fad fa-phone-office"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Extensión" name="extEmpresa" id="exttelefonoEmpresaCliente" >
                            </div>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <!-- TELÉFONO CLIENTE -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="telefonoCliente" class="form-label">Teléfono cliente <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefonoCliente"><i class="fad fa-phone-alt"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Teléfono cliente" name="telefonoCliente" id="telefonoCliente" data-inputmask="'mask': '9999-9999'">
                            </div>
                            <div class="emptyCelularCliente text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                          </div>
                          <!-- API TELEGRAM -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="apiCliente" class="form-label">Api Telegram</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="apiCliente"><i class="fad fa-paper-plane"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="ID Telegram" name="idTelegram" id="apiCliente" >
                            </div>
                          </div>                              
                        </div>
                        <div class="row mt-3">
                          <!-- DIRECCIÓN -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="direccionCliente" class="form-label">Dirección </label>
                            <textarea name="direccion" id="direccionCliente" class="form-control" placeholder="ingrese una dirección"></textarea>
                          </div>
                          <!-- COMENTARIOS -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="comentariosCliente" class="form-label">Comentarios </label>
                            <textarea name="comentarios" id="comentariosCliente" class="form-control" placeholder="Ingrese comentarios acerca del cliente"></textarea>
                          </div>
                        </div>
                        <!-- BOTONES -->
                        <div class="row mt-3">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary btn-block btnRegistrarNuevoCliente"><i class="fad fa-download"></i> &nbsp; Guardar cliente</button>
                            <div class="spinner-RegistrarNuevoCliente spinner-<?=APP_THEME ?> m-auto d-none">
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
              <!--   MODAL EDITAR CLIENTE  -->
              <div class="modal fade" id="openModaleditCliente" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                    <div class="modal-body">
                      <h4 class="modal-title">Formulario cliente <small class="text-danger">Los campos marcados con * en este formulario son obligatorios.</small></h4>
                      <form id="formEditCliente">
                        <div class="row">
                          <!-- NOMBRE CLIENTE -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="nombreCliente" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="hidden" name="action" value="ActualizarmiCliente">
                            <input type="hidden" name="idCliente" id="idClienteModalEdit">                            
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombre_Cliente"><i class="fad fa-address-card"></i></label>
                              </div>
                              <input type="text" class="form-control" name="nombreCliente" id="nombre_Cliente" placeholder="Nombre cliente">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreExcedido d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyNombreCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE CLIENTE</div>
                          </div>
                          <!-- CIUDAD CLIENTE -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="ciudad_Cliente" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="ciudad_Cliente"><i class="fad fa-car-building"></i></label>
                              </div>
                              <select name="ciudadCliente" id="ciudad_Cliente" class="form-control">
                                <option disabled selected value=0>Seleccione ciudad</option><?=listaCiudades($MySQLi)?>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <!-- COREO CLIENTE -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <div class="form-group">
                            <label for="correo_Cliente" class="form-label">Correo</label>
                              <div class="input-group">
                                <div class="input-group-prepend">
                                  <label class="input-group-text" for="correo_Cliente"><i class="fad fa-mailbox"></i></label>
                                </div>
                                <input type="email" class="form-control" name="correoCliente" id="correo_Cliente" placeholder="correo@mail.com">
                              </div>
                              <div class="correoNoValido text-center text-danger mt-2 d-none">CORREO NO VÁLIDO</div>
                            </div>
                          </div>
                          <!-- EMPRESA CLIENTE -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="empresa_Cliente" class="form-label">Empresa</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="empresa_Cliente"><i class="fad fa-city"></i></label>
                              </div>
                              <input type="text" class="form-control" name="empresaCliente" id="empresa_Cliente" placeholder="Empresa">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreEmpresaExcedido d-none">LÍMITE EXCEDIDO</div>
                          </div>                              
                        </div>
                        <div class="row mt-3">
                          <!-- TELÉFONO EMPRESA -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="telefono_EmpresaCliente" class="form-label">Teléfono empresa</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefono_EmpresaCliente"><i class="fad fa-phone-office"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Teléfono empresa" name="telefonoEmpresa" id="telefono_EmpresaCliente" data-inputmask="'mask': '999-9999'">
                            </div>
                            <div class="emptyTelefonoEmpresa text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                          </div>
                          <!-- EXTENSION EMPRESA -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="exttele_fonoEmpresaCliente" class="form-label">extensión</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="exttele_fonoEmpresaCliente"><i class="fad fa-phone-office"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Extensión" name="extEmpresa" id="exttele_fonoEmpresaCliente" >
                            </div>                            
                          </div>
                        </div>
                        <div class="row mt-3">
                          <!-- TELEFONO CLIENTE -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="telefono_Cliente" class="form-label">Teléfono cliente <span class="text-danger">*</span></label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefono_Cliente"><i class="fad fa-phone-alt"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="Teléfono cliente" name="telefonoCliente" id="telefono_Cliente" data-inputmask="'mask': '9999-9999'">
                            </div>
                            <div class="emptyCelularCliente text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                          </div>
                          <!-- API TELEGRAM -->
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="api_Cliente" class="form-label">Api Telegram</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="api_Cliente"><i class="fad fa-paper-plane"></i></label>
                              </div>
                              <input type="tel" class="form-control" placeholder="API Telegram" name="idTelegram" id="api_Cliente" >
                            </div>                            
                          </div>                              
                        </div>
                        <div class="row mt-3">
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="direccion_Cliente" class="form-label">Dirección </label>
                            <textarea name="direccion" id="direccion_Cliente" class="form-control" placeholder="ingrese una dirección"></textarea>
                          </div>
                          <div class="col-sm-12 col-md-6 col-lg-6">
                            <label for="comentarios_Cliente" class="form-label">Comentarios </label>
                            <textarea name="comentarios" id="comentarios_Cliente" class="form-control" placeholder="Ingrese comentarios acerca del cliente"></textarea>
                          </div>
                        </div> 
                        <div class="row mt-3 row-ActualizarCliente">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary btn-block btnActualizarCliente"><i class="fad fa-upload"></i> &nbsp; Actualizar cliente</button>
                            <div class="spinner-ActualizarCliente spinner-<?=APP_THEME ?> m-auto d-none">
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
              <!--   ENVIAR MENSAJE POR TELEGRAM  -->
              <div class="modal fade" id="openModalTeleGram" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">ENVIAR SMS TELEGRAM
                        <small class="m-0 text-muted">Desde este formulario, puedes enviarle un mensaje directo al cliente seleccionado a su App de telegram.<br><span class="text-danger">Si el ID no es válido, causará un error en el sistema de envio.</span></small>
                      </h4>
                    </div>
                    <div class="modal-body">
                      <form id="telesms">
                        <div class="row">
                          <div class="col">
                            <label for="nombre_Usuario" class="form-label">Mensaje <span class="text-danger">*</span></label>
                            <input type="hidden" name="action" value="enviarSMSTeleGram">
                            <input type="hidden" name="idUser" id="idUserAPI">
                            <input type="hidden" name="idTelegram" id="telegramAPI">
                            <textarea class="form-control" id="mensajeTele" name="mensaje"></textarea>
                          </div>
                        </div>
                        <div class="row mt-5">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="btn btn-primary btn-sm btn-block TeleSend">Enviar &nbsp; <i class="far fa-paper-plane"></i></button>
                            <div class="spinner-TeleSend spinner-<?=$_theme ?> m-auto d-none">
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
          </main><?php
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
    <script src="<?=ASSETS_URL?>/js/misventas.js"></script>
  </body>
</html>