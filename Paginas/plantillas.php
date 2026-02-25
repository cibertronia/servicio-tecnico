<?php
require_once 'init.php';
$_title       = 'Plantillas html - '.APP_TITLE;
$_active_nav  = 'Plantillas';
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
            <!-- CREAR PLANTILLA HTML -->
            <div class="row"><div class="respuesta"></div>
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div id="panelCrarPlantilla" class="panel d-none">
                  <div class="panel-hdr">
                    <h2>Editor <span class="fw-300"><i>html</i></span></h2>
                    <div class="panel-toolbar">
                      <button class="ml-2 btn btn-danger btn-xs waves-effect waves-themed cerrarEditorHTML" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cerrar editor html">Cerrar editor</button>
                      <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                      <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                    </div>
                  </div>
                  <div class="panel-container">                      
                    <div class="panel-content">
                      <div class="row">
                        <div class="col">
                          <div class="alert alert-danger" role="alert">
                            Para crear una plantilla funcional, tome en cuenta que las palabras <strong>claves</strong>, estan estandarizadas. Aquí algunos ejemplos:
                            <table class="table table-sm table-striped table-responsive table-bordered" style="font-size: 10px;">
                              <tr>
                                <th class="text-center" colspan="2">Usuario</th>
                                <th class="text-center" colspan="2">Cliente</th>
                              </tr>
                              <tr>
                                <th>{nombreUsuario}</th>
                                <td>nombre del usuario</td>
                                <th>{nombreCliente}</th>
                                <td>nombre del cliente</td>
                              </tr>
                              <tr>
                                <th>{correoUsuario}</th>
                                <td>correo del usuario</td>
                                <th>{correoCliente}</th>
                                <td>correo del cliente</td>
                              </tr>
                              <tr>
                                <th>{telefonoUsuario}</th>
                                <td>teléfono del usuario</td>
                                <th>{telefonoCliente}</th>
                                <td>teléfono del cliente</td>
                              </tr>
                            </table>
                            </span>
                          </div>
                        </div>
                      </div>
                      <form id="formPlantilla">
                        <div class="row">                          
                          <div class="col-sm-12 col-md-8 col-lg-8 my-2">
                            <label for="contenidoPlantilla" class="form-label">Contenido de la plantilla</label>
                            <textarea name="contenidoPlantilla" id="contenidoPlantilla" class="js-summernote form-control"></textarea>
                          </div>
                          <div class="col-sm-12 col-md-4 col-lg-4 my-2">
                            <div class="row">
                              <div class="col">
                                <label for="nombrePlantilla" class="form-label">Nombre plantilla</label>
                                <input type="hidden" name="action" id="action" value="actualizarPlantilla">
                                <input type="hidden" name="idPlantilla" id="idPlantilla">
                                <input type="text" name="nombrePlantilla" id="nombrePlantilla" class="form-control" placeholder="nombre de la plantilla">
                              </div>
                            </div>
                            <div class="row my-2">
                              <div class="col btn-actualizarPlantilla d-none">
                                <button class="btn btn-primary btn-block actualizarPlantilla">Actualizar plantilla</button>
                                <div class="spinner-actualizarPlantilla spinner-<?=APP_THEME ?> m-auto d-none">
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
                              <div class="col btn-guardarPlantilla d-none">
                                <button class="btn btn-primary btn-block guardarPlantilla">Guardar plantilla</button>
                                <div class="spinner-guardarPlantilla spinner-<?=APP_THEME ?> m-auto d-none">
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
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <!-- LISTA DE PLANTILLAS -->
              <div class="col-sm-12 col-md-12 col-lg-12">
                <div id="panelListaPlantillas" class="panel">
                  <div class="panel-hdr">
                    <h2>Mis <span class="fw-300"><i>plantillas</i></span><button class="ml-2 btn btn-primary btn-xs waves-effect waves-themed modal_crearPlantillaHTML" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Crear una nueva plantilla html">Crear plantilla &nbsp; <i class="fal fa-code"></i></button></h2>
                    <div class="panel-toolbar">
                      <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                      <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                    </div>
                  </div>
                  <div class="panel-container">                      
                    <div class="panel-content">
                      <table id="listaPlantillas" class="table table-bordered table-hover table-striped w-100">
                        <thead class="text-center">
                          <tr>
                            <th width="5%">N&ordm;</th>
                            <th width="70%">Nombre</th>
                            <th width="25%">Accones</th>
                          </tr>
                        </thead>
                        <tbody><?=listaPlantillasHTML($MySQLi)?></tbody>
                      </table>
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
    <script src="<?=ASSETS_URL ?>/js/plantillas.js"></script>
  </body>
</html>