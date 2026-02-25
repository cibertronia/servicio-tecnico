<?php
require_once 'init.php';
$_title       = 'Mi Perfil - '.APP_TITLE;
$_active_nav  = 'miPerfil';
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
            <div class="row"><div class="respuesta"></div>
            <!-- MI AVATAR -->
            <div class="col-lg-3 col-md-4 col-sm-12">
              <div id="" class="panel">
                <div class="panel-hdr">
                  <h2>Cambiar <span class="fw-300"><i>mi avatar</i></span></h2>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <form id="miAvatar" enctype="multipart/form-data" method="POST">
                      <div class="row text-center">
                        <div class="col">
                          <input type="hidden" name="action" value="cambiaImagendePerfil">
                          <input type="hidden" id="idUserHidden" name="idUser" value="<?=$idUser?>">
                          <input type="hidden" name="idSexo" value="<?=$idSexoDf?>">
                          <input type="hidden" name="idRango" value="<?=$idRangoDf?>">
                          <input type="hidden" id="defaultAvatar" name="avatarAnterior" value="<?=miAvatar($MySQLi,$idUser,$idRangoDf,$idSexoDf)?>">
                          <div id="imgx"></div>
                        </div>
                      </div>
                      <div class="row text-center">
                        <div class="col">
                          <span class="btn btn-sm btn-primary fileinput-button mt-4">
                            <span class="textcambiarImagen">Cambiar imagen</span>
                            <input type="file" name="imagen" id="imgPerfilAvatar" accept="image/png, image/jpeg, image/jpg">
                          </span>                          
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- DATOS PERSONALES -->
            <div class="col-lg col-md-4 col-sm-12">
              <div id="" class="panel">
                <div class="panel-hdr">
                  <h2>Mis <span class="fw-300"><i> datos</i></span></h2>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <form id="actualizaDatos">
                      <input type="hidden" name="action" value="updataUser">
                      <input type="hidden" name="idUser" value="<?=$idUser?>">
                      <div class="row">
                        <!-- NOMBRE USUARIO -->
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="nameUser" class="form-label">Nombre</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="nameUser"><i class="fad fa-address-card"></i></label>
                            </div>
                            <input type="text" name="nombre" id="nameUser" class="form-control" value="<?=$nombreUsuarioDf?>" disabled>
                          </div>
                        </div>
                        <!-- TELÉFONO USUARIO -->
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="telUser" class="form-label">Teléfono</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="telUser"><i class="fad fa-phone-alt"></i></label>
                            </div>
                            <input type="text" name="telefono" id="telUser" class="form-control" value="<?=$telUsuarioDf?>" data-inputmask="'mask': '9999-9999'">
                          </div>
                          <div class="emptyCelularCliente text-center text-danger mt-2 d-none">INGRESE TELÉFONO</div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <!-- SUCURSAL USUARIO -->
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="ciudadUser" class="form-label">Sucursal</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="ciudadUser"><i class="fad fa-car-building"></i></label>
                            </div>
                            <input type="text" name="ciudad" id="ciudadUser" class="form-control" value="<?=$sucurUsuarioDf?>" disabled>
                          </div>                          
                        </div>
                        <!-- CARGO USUARIO -->
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="cargoUser" class="form-label">Cargo</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="ciudadCliente"><i class="fad fa-clipboard-user"></i></label>
                            </div>
                            <input type="text" name="cargo" id="cargoUser" class="form-control" value="<?=$cargoUsuarioDf?>" disabled>
                          </div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <!-- CORREO USUARIO -->
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="mailUser" class="form-label">Correo</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="mailUser"><i class="fad fa-mailbox"></i></label>
                            </div>
                            <input type="email" name="correo" id="mailUser" class="form-control" value="<?=$correoUsuarioDf?>">
                          </div>
                          <div class="emptyCorreo text-center text-danger mt-2 d-none">CORREO VACÍO</div>
                        </div>
                        <!-- TELEGRAM -->
                        <div class="col-sm-6 col-md-6 col-lg-6">
                          <label for="idTelegram" class="form-label">ID Telegram</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="idTelegram"><i class="fad fa-paper-plane"></i></label>
                            </div>
                            <input type="text" name="idTelegram" id="idTelegram" class="form-control" value="<?=$idTelegramDf?>">
                          </div>
                        </div>
                      </div>
                      <div class="row mt-2">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <button class="my-2 btn btn-primary btn-block updateDatos">Actualizar datos</button>
                          <div class="my-2 spinner-updateDatos spinner-<?=APP_THEME ?> m-auto d-none">
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
            <!-- CONTRASEÑA -->
            <?php if($_SESSION['idRango'] == 2) { ?>
            <div class="col-lg-3 col-md-4 col-sm-12">
              <div id="" class="panel">
                <div class="panel-hdr">
                  <h2>Cambiar<span class="fw-300"><i> Mi contraseña</i></span></h2>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <form id="changPswd">
                      <input type="hidden" name="action" value="cambiarPswdmiPerfil">
                      <input type="hidden" name="idUser" value="<?=$idUser?>">
                      <div class="row mt-2">
                        <div class="col">
                          <label for="pswdUser">Contraseña</label>                          
                          <input data-toggle="password" name="password" id="pswdUser" data-placement="after" class="form-control pswdUser" type="password">
                        </div>
                      </div>
                      <div class="row mt-2 responseBtnChangePswd">
                        <div class="col">
                          <button class="my-2 btn btn-primary btn-block btnChangePswd">Cambiar contraseña</button>
                          <div class="my-2 spinner-btnChangePswd spinner-<?=APP_THEME ?> m-auto d-none">
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
            <?php } ?>
            </div>
          </main><?php 
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div><?php 
    include_once APP_PATH.'/includes/extra.php';
    include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/miPerfil.js"></script>
  </body>
</html>