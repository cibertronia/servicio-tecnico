<?php
require_once 'init.php';
require_once 'includes/conexion.php';
$_title = 'Registrar - '.APP_TITLE;
$_head = '';
$Q_Registrar = mysqli_query($MySQLi,"SELECT registrar FROM configuraciones");
$dataRegist  = mysqli_fetch_assoc($Q_Registrar);
$Registrar   = $dataRegist['registrar'];
if ($Registrar==1) { ?>
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
                </div>
                <a href="./" class="btn-link text-white ml-auto">
                  Ingresar
                </a>
              </div>
            </div>
            <div class="flex-1" style="background: url(<?= ASSETS_URL ?>/img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
              <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                <div class="row">
                  <div class="col-sm-6 m-auto">
                    <div class="card p-4 rounded-plus bg-faded">
                      <form id="registrar"><div class="respuesta"></div>
                        <h3 class="pb-3 text-center">FORMULARIO DE REGISTRO</h3>
                        <div class="row">
                          <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                            <label class="form-label" for="nombreUsuario">Nombre</label>
                            <input type="hidden" name="action" value="nuevoUsuario">
                            <input type="text" id="nombreUsuario" name="nombre" class="form-control" placeholder="Ingrese nombre">
                          </div>
                          <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                            <label class="form-label" for="sexoUsuario">Género</label>
                            <select name="sexo" id="sexoUsuario" class="form-control">
                              <option disabled selected value="0">Seleccione género</option>
                              <option value="2">Femenino</option>
                              <option value="1">Masculino</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                            <label class="form-label" for="telefonoUsuario">Teléfono</label>
                            <input type="tel" id="telefonoUsuario" name="telefono" class="form-control" placeholder="Ingrese un teléfono">
                          </div>
                          <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                            <label class="form-label" for="idTelegram">ID TeleGram </label><span class="ml-5"><a href="#">¿Cómo obtener?</a></span>
                            <input type="tel" id="idTelegram" name="idTelegram" minlength="8" maxlength="10" class="form-control" placeholder="ID Telegram">
                          </div>
                        </div>
                        <div class="row mb-2">
                          <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                            <label class="form-label" for="correoUsuario">Correo</label>
                            <input type="email" id="correoUsuario" name="correo" class="form-control" placeholder="usuario@mail.com">
                            <div class="correoExiste text-center text-danger mt-2 d-none">CORREO YA EXISTE</div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-lg-6 mb-2">
                            <label class="form-label" for="sucursalUsuario">Tienda</label>
                            <select name="sucursal" id="sucursalUsuario" class="form-control">
                              <option disabled selected value="0">Seleccione tienda</option><?php
                              $SQLSucursal = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1 ORDER BY sucursal ASC ");
                              while ($dataSu = mysqli_fetch_assoc($SQLSucursal) ) {
                                echo'<option value='.$dataSu['idTienda'].'>'.$dataSu['sucursal'].' ('.$dataSu['codeTienda'].')</option>';
                              } ?>
                            </select>
                          </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg mb-2 registrarCuenta">Registrar cuenta</button>
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
                </div>
                <div class="position-absolute pos-bottom pos-left pos-right p-3 text-center text-white">
                  <?=date('Y') ?> © <?=APP_DESCRIPTION ?> por&nbsp;<a href="<?=APP_OWNER_URL?>" class='text-white opacity-40 fw-500' title="<?=APP_TITLE ?>" target='_blank'><?=APP_OWNER_NAME ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><?php include_once APP_PATH.'/includes/js.php'; ?>
      <script src="<?=ASSETS_URL?>/js/registrar.js"></script>
    </body>
  </html><?php
}else{
  $rutaLocalHost = 'http://localhost/Proyectos/Estandarizado/';
  header("Location: $rutaLocalHost");
}?>