<?php
require_once 'init.php';
require 'includes/default.php';
$_title = 'Perfil - '.APP_DESCRIPTION;
$_active_nav = 'miPerfil';?>
<!DOCTYPE html>
<html lang="es">
  <link rel="stylesheet" media="screen, print" href="<?= ASSETS_URL ?>/css/app.min.css"><?php
  $_head = '  <link rel="stylesheet" media="screen, print" href="'.ASSETS_URL.'/css/formplugins/dropzone/dropzone.css">
'; 
  include_once APP_PATH.'/includes/head.php';
  include_once APP_PATH.'/includes/functions.php';  ?>
  <body class="mod-bg-1 mod-skin-<?= $_theme ?> ">
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><?= $Fecha?></ol>
            <div class="row"><div class="respuesta"></div>
              <!-- IMAGEN DE PERFIL -->
              <div class="col-3">
                <div id="" class="panel">
                  <div class="panel-hdr">
                    <h2>Cambiar 
                      <span class="fw-300"><i>mi avatar</i></span>
                    </h2>
                  </div>
                  <div class="panel-container">
                    <div class="panel-content">
                      <form enctype="multipart/form-data" method="POST" action="?root=perfil">
                        <div class="row text-center">
                          <div class="col">
                            <input type="hidden" id="idUserHidden" value="<?=$idUser ?>">
                            <input type="hidden" id="defaultAvatar" value="<?=miAvatar($MySQLi,$idUser, $idRangoDf, $idSexoDf) ?>">
                            <div id="imgx"></div>
                          </div>
                        </div>
                        <div class="row text-center">
                          <div class="col">
                            <span class="btn btn-sm btn-primary fileinput-button mt-4">
                              <span>Cambiar imagen</span>
                              <input type="file" name="imagen" id="img_file" accept="image/png, image/jpeg, image/jpg" required="">
                            </span>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- DATOS PERSONALES -->
              <div class="col-6">
                <div id="" class="panel">
                  <div class="panel-hdr">
                    <h2>Mis 
                      <span class="fw-300"><i> datos</i></span>
                    </h2>
                  </div>
                  <div class="panel-container">
                    <div class="panel-content">
                      <form id="actualizaDatos">
                        <div class="row">
                          <div class="col">
                            <input type="hidden" name="accion" value="updataUser">
                            <input type="hidden" name="idUser" value="<?= $idUser ?>">
                            <label for="nameUser">Nombre</label>
                            <input type="text" name="nombre" id="nameUser" class="form-control" value="<?= $dataUss['nombre']." ".$dataUss['apellido'] ?>" disabled>
                          </div>
                          <div class="col">
                            <label for="telUser">Teléfono</label>
                            <input type="text" name="telefono" id="telUser" class="form-control" value="<?= $dataUss['telefono'] ?>">
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="ciudadUser">Sucursal</label><?php
                            $idTienda   = $dataUss['idTienda'];
                            $Q_Tienda   = mysqli_query($MySQLi,"SELECT nombre, codeTienda FROM sucursales WHERE idTienda='$idTienda' ");
                            $dataTienda = mysqli_fetch_assoc($Q_Tienda);
                            ?>
                            <input type="text" name="ciudad" id="ciudadUser" class="form-control" value="<?= $dataTienda['nombre']." (".$dataTienda['codeTienda'].")" ?>" disabled>
                          </div>
                          <div class="col">
                            <label for="cargoUser">Cargo</label>
                            <input type="text" name="cargo" id="cargoUser" class="form-control" value="<?= $dataUss['cargo'] ?>" disabled>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="mailUser">Correo</label>
                            <input type="email" name="correo" id="mailUser" class="form-control" value="<?= $dataUss['correo'] ?>">
                          </div>
                          <div class="col">
                            <label for="idTelegram">ID Telegram</label>
                            <input type="text" name="idTelegram" id="idTelegram" class="form-control" value="<?= $dataUss['idTelegram'] ?>">
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="btnUpdate">&nbsp;&nbsp;</label>
                            <button class="btn btn-primary btn-block updateDatoss">Actualizar datos</button>
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
              <!-- CONTRASEÑA -->
              <div class="col-3">
                <div id="" class="panel">
                  <div class="panel-hdr">
                    <h2>Cambiar
                      <span class="fw-300"><i> Mi contraseña</i></span>
                    </h2>
                  </div>
                  <div class="panel-container">
                    <div class="panel-content">
                      <form>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="pswdUser">Contraseña</label>
                            <input data-toggle="password" name="password" id="pswdUser" data-placement="after" class="form-control" type="password" >
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="btnUpdate">&nbsp;&nbsp;</label>
                            <button class="btn btn-primary btn-block">Cambiar contraseña</button>
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
          </main><?php 
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>    
    <script src="<?=ASSETS_URL?>/js/perfil.js"></script>
  </body>
</html>