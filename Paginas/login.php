<?php
require_once 'init.php';
$_title = 'Login - '.APP_TITLE;
$_head = '';?>
<!DOCTYPE html>
<html><?php 
  include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-skin-<?= $_theme ?>">
    <div class="page-wrapper auth">
      <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
          <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
            <div class="d-flex align-items-center container p-0">
              <div class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                <a href="<?= APP_URL ?>" class="page-logo-link press-scale-down d-flex align-items-center">
                  <img src="<?= ASSETS_URL ?>/img/favicon/icono.png" alt="SmartAdmin WebApp" aria-roledescription="logo">
                  <span class="page-logo-text mr-1"><?=APP_DESCRIPTION ?></span>
                </a>
              </div><?php
              $Q_Registrar = mysqli_query($MySQLi,"SELECT registrar FROM configuraciones");
              $dataRegist  = mysqli_fetch_assoc($Q_Registrar);
              $Registrar   = $dataRegist['registrar'];
              if ($Registrar==5) { ?>
                <a href="registrar.php" class="btn-link text-white ml-auto">Registrar</a><?php
              } ?>
            </div>
          </div>
          <div class="flex-1" style="background: url(<?= ASSETS_URL ?>/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
            <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
              <div class="row">
                <!--<div class="col col-md-6 col-lg-7 hidden-sm-down">
                  <h2 class="fs-xxl fw-500 mt-4 text-white">
                    ¿Por qué usar los servicios de Yapame?
                    <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60">
                      <?=APP_ABOUT ?>
                    </small>
                  </h2>
                  
                  <div class="d-sm-flex flex-column align-items-center justify-content-center d-md-block">
                    <div class="px-0 py-1 mt-5 text-white fs-nano opacity-50">Síguenos en nuestras redes</div>
                    <div class="d-flex flex-row opacity-70">
                      <a target="_blank" href="https://www.facebook.com/YapamePues" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-facebook-square"></i>
                      </a> &nbsp; 
                      <a target="_blank" href="https://wa.me/message/V273V33JVHCHH1" class="mr-2 fs-xxl text-white">
                        <i class="fab fa-whatsapp"></i>
                      </a>
                      
                    </div>
                  </div>
                </div>-->
                <div class="col-4"></div>
                <div class="col">
                  <!-- <h1 class="text-white fw-300 mb-3 d-sm-block d-md-none">
                    Secure login
                  </h1> -->
                  <div class="card p-4 rounded-plus bg-faded">
                    <form id="login"><div class="respuesta"></div>
                      <div class="row">
                      <div class="col"></div>
                      <div class="col">
                        <img src="<?=ASSETS_URL ?>/img/favicon/logo.png" alt="logo" Width="250" class="mb-4" id="imgLogo">
                      </div>
                        <div class="col"></div>
                      </div>
                      <div class="form-group">
                        <label class="form-label" for="emailuser">Usuario</label>
                        <input type="hidden" name="action" value="Login">
                        <input type="text" id="emailuser" name="usuario" class="form-control form-control-lg" placeholder="Correo de acceso">
                      </div>
                      <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <input type="password" id="password" name="pswd" class="form-control form-control-lg" placeholder="Contrseña">
                      </div>
                      <!-- <div class="form-group text-left">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                          <label class="custom-control-label" for="remember"> Recordarme 24 Hrs</label>
                        </div>
                      </div> -->
                      <button class="btn btn-primary btn-block btn-lg mb-2 login">Ingresar al sistema</button>
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
                    </form>
                  </div>
                </div>
                <div class="col-4"></div>
              </div>
              <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                <?=date('Y') ?> © <?=APP_DESCRIPTION ?> desarrollado por:&nbsp;<a href="<?=APP_OWNER_URL?>" class='text-white opacity-40 fw-500' title="<?=APP_TITLE ?>" target='_blank'><?=APP_OWNER_NAME ?></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/login.js"></script>
  </body>
</html>