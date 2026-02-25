<?php
require_once 'init.php';
$_title = 'Mensajería - '.APP_TITLE;
$_active_nav = 'MensajeriaSMS';?>
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
            
            <div id="panelCotizacionesGeneradas" class="panel w-50">
              <input type="hidden" id="RangoUsuario" value="<?=$idRangoDf?>">
              <div class="panel-hdr">
                <h2>Sistema de mensajeria <span class="fw-300"><i>sms</i></span></h2>
                <div class="panel-toolbar">
                  <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                  <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                </div>
              </div>
              <div class="panel-container"><div class="respuesta"></div>
                <div class="panel-content">
                  <form id="enviarSMS">
                    <input type="hidden" name="action" value="EnviarSMS">
                    <!-- <input type="hidden" name="idCliente" id="idClienteModal"> -->
                    <input type="hidden" name="idUsuario" value="<?=$idUser?>">
                    <div class="row">
                      <div class="col mt-3">
                        <div class="alert alert-primary" role="alert">
                          <strong>Para usar esta opción,</strong> deberá contar con una cuenta de mensajería y tener saldo suficiente para el envio de cada uno de los mensajes de texto a sus clientes.<br><strong><a target="_blank" href="https://yapame.com.bo/soporte/">Cunsultar a soporte.</a></strong>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-ms-12 col-md-12 col-lg-12 my-2">
                        <label for="listaClientes" class="form-label">LISTA DE CLIENTES</label>
                        <select name="cliente[]" id="listaClientes" class="form-control select2" multiple="multiple" data-placeholder="Seleccione uno o mas clientes"></select>
                        <div class="text-muted" style="font-size: 9px;">Puede enviar mensajes a los clientes de forma individual o grupal.<br>Si selecciona <i><b>enviar a todos los clientes, </b></i>se le enviará un mensaje a todos y cada uno de los clientes que posean un número de telefono válido. Pero, si selecciona esta opción, no deberá seleccionar a ningun otro cliente, ya que, al cliente extra, se le enviará doble mensaje y por lo tanto doble cobro.</div>
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-ms-12 col-md-12 col-lg-12 my-2">
                        <label for="mensajeModal" class="form-label">MENSAJE: <span class="text-danger">No ingresar caracteres especiales como á é í ó ú</span></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <label class="input-group-text" for="mensajeModal"><i class="fad fa-money-check-edit"></i></label>
                          </div>
                          <textarea name="mensaje" id="mensajeModal" class="form-control" placeholder="160 caracteres máximo"></textarea>
                        </div>
                        <div id="contadorSMS"></div>
                        <div class="emptyMensaje text-center text-danger mt-2 d-none">INGRESE EL MENSAJE</div>
                        <div class="limiteExcedido text-center text-danger mt-2 d-none">EXCEDIÓ EL MÁXIMO DE CARACTERES</div>
                      </div>
                    </div>
                    <div class="row ">
                      <div class="col-sm-12 col-md-12 col-lg-12">
                        <button class="btn btn-primary btn-block sendSMS">ENVIAR SMS</button>
                        <div class="spinner-sendSMS spinner-<?=APP_THEME ?> m-auto d-none">
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
    <script src="<?=ASSETS_URL?>/js/sms.js"></script>
  </body>
</html>