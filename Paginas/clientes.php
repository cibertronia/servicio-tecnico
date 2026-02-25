<?php
require_once 'init.php';
$_title = 'Lista Clientes - '.APP_TITLE;
$_active_nav = 'Clientes';?>
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
            <div class="row">
              <div class="col">
                <div id="panel-1" class="panel">
                  <div class="panel-hdr">
                    <h2>Lista de <span class="fw-300"><i>Clientes</i></span> &nbsp; <?php
                    if ($idRangoDf > 2) { ?>
                      <button class="btn mx-3 btn-primary btn-xs btn-icon rounded-circle tablaClientes" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Respaldar lista de clientes"><i class="fad fa-save"></i></button><?php
                    } ?>
                    </h2>
                    <div class="panel-toolbar">                      
                      <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                      <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                    </div>
                  </div>
                  <div class="panel-container"><div class="respuesta"></div>
                    <div class="panel-content">
                      <table id="listageneralClientes" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                          <tr>
                            <th class="text-center">N&ordm;</th>
                            <th>Sucursal</th>
                            <th class="text-center">Nombre</th>
                            <th class="text-center">Correo</th>
                            <th class="text-center">Empresa</th>
                            <th class="text-center">Telefono<br>Empresa</th>
                            <th class="text-center">Telefono<br>Cliente</th>
                            <th class="text-center">Ciudad</th>
                            <th class="text-center">Acciones</th>
                          </tr>
                        </thead>
                        <tbody><?=lista_generalClientes($MySQLi, $idRangoDf)?>
                        </tbody>
                      </table>
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
                                <input type="hidden" name="action" value="ActualizarCliente">
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
                  <div class="modal fade" id="modalTeleGram" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">ENVIAR SMS TELEGRAM
                            <small class="m-0 text-muted">Desde este formulario, puedes enviarle un mensaje directo al telegram del cliente seleccionado.</small>
                          </h4>
                        </div>
                        <div class="modal-body">
                          <form id="telesms">
                            <div class="row">
                              <div class="col">
                                <label for="nombre_Usuario">Mensaje <span class="text-danger">*</span></label>
                                <input type="hidden" name="action" value="enviarSMSTeleGram">
                                <input type="hidden" name="idUser" id="idUserAPI">
                                <input type="hidden" name="api" id="telegramAPI">
                                <textarea class="form-control" id="mensajeTele" name="mensaje"></textarea>
                              </div>
                            </div>
                            <div class="row mt-5">
                              <div class="col"></div>
                              <div class="col">
                                <button class="btn btn-primary btn-sm btn-block TeleSend">Enviar SMS</button>
                                <div class="spinner m-auto d-none">
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
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/clientes.js"></script>
  </body>
</html>