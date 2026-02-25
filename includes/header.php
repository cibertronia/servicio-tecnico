<header class="page-header" role="banner">
  <div class="page-logo">
    <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
      <img src="<?= ASSETS_URL ?>/img/favicon/logo.png" alt="<?=APP_DESCRIPTION ?>" aria-roledescription="logo">
      <span class="page-logo-text mr-1"><?= APP_DESCRIPTION ?></span>
      <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
      <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
    </a>
  </div>
  <div class="hidden-md-down dropdown-icon-menu position-relative">
    <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Ocultar menú">
      <i class="ni ni-menu"></i>
    </a>
    <ul>
      <li>
        <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minimizar menú">
          <i class="ni ni-minify-nav"></i>
        </a>
      </li>
      <li>
        <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Bloquear menú">
          <i class="ni ni-lock-nav"></i>
        </a>
      </li>
    </ul>
  </div>
  <!-- DOC: mobile button appears during mobile width -->
  <div class="hidden-lg-up">
    <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
      <i class="ni ni-menu"></i>
    </a>
  </div>
  <div class="ml-auto d-flex"><?php
    // SELECTOR DE HOJAS Y TAMAÑOS
    if ($tipoHoja==1) { ?>
      <div>
        <a href="#" class="header-icon" data-toggle="dropdown" title="Personalizar tamaño de hoja" aria-expanded="false">
          <i class="fad fa-file-pdf"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
          <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
            <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
              <div class="info-card-text">
                <div class="row my-2">
                  <div class="col">
                    <label for="sizes" class="form-label">Seleccione tipo de hoja</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="sizes"><i class="fad fa-file-pdf"></i></label>
                      </div>
                      <select name="sizes" id="sizes" class="form-control"><?=medidasHoja($MySQLi)?></select>
                    </div>
                  </div>
                </div>
                <div class="row my-2 personalizado">
                  <div class="col">
                    <label for="sizeAlto" class="form-label">Alto</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="sizeAlto"><i class="fad fa-arrows-v"></i></label>
                      </div>
                      <input type="tel" name="alto" id="sizeAlto" class="form-control" placeholder="milímetros">
                    </div>
                  </div>
                  <div class="col">
                    <label for="sizeAncho" class="form-label">Ancho</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="sizeAncho"><i class="fad fa-arrows-h"></i></label>
                      </div>
                      <input type="tel" name="ancho" id="sizeAncho" class="form-control" placeholder="milímetros">
                    </div>
                  </div>
                </div>
                <div class="row my-2 horientacion">
                  <div class="col">
                    <label for="orientacionPage" class="form-label">Orientación</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <label class="input-group-text" for="orientacionPage"><i class="fad fa-arrows"></i></label>
                      </div>
                      <select name="orientacion" id="orientacionPage" class="form-control">
                        <option value="L">Vertical</option>
                        <option value="H">Horizontal</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="dropdown-divider m-0"></div>
        </div>
      </div><?php
    }
    // USUARIOS EN LÍNEA
    if ($userOnline==1) {?>
      <div class="">
        <a href="#" class="header-icon" data-toggle="dropdown" title="Hay <?=$resultOnL?> <?= $resultOnL==1?'usuario':'usuarios' ?> en línea" aria-expanded="false">
          <i class="fal fa-user"></i>
          <span class="badge badge-icon"><?=$resultOnL ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-animated dropdown-xl" style="">
          <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top mb-2">
            <h4 class="m-0 text-center color-white">
              <small class="mb-0 opacity-80">USUARIOS EN LÍNEA</small>
              <?=$resultOnL?>
            </h4>
          </div>        
          <div class="tab-content tab-notification">
            <div class="tab-pane active" id="tab-messages" role="tabpanel">
              <div class="custom-scroll h-100">
                <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 100%;">
                  <ul class="notification" style="overflow: hidden; width: auto; height: 100%;"><?php
                    while ($dataOnLine = mysqli_fetch_assoc($Q_onLine)) {
                      $thisUserID      = $dataOnLine['idUser'];
                      $thisUserName    = $dataOnLine['Nombre'];
                      $thisUserPhone   = $dataOnLine['telefono'];
                      $thisUserRango   = $dataOnLine['idRango'];
                      $thisUserSexo    = $dataOnLine['idSexo'];
                      $thisUserSession = $dataOnLine['session'];
                      $thisUserCargo   = $dataOnLine['cargo'];
                      $idTiendaThisUser= $dataOnLine['idTienda'];
                      $thisUserAvatar  = $dataOnLine['miAvatar'];
                      $Q_thisAvatar    = mysqli_query($MySQLi,"SELECT * FROM avatar WHERE idSexo='$thisUserSexo' AND idRango='$thisUserRango' ");
                      $dataThisAvatar  = mysqli_fetch_assoc($Q_thisAvatar);
                      $DfThisUserAvatar= $dataThisAvatar['avatar'];
                      $Q_thisTienda    = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE idTienda='$idTiendaThisUser' ");
                      $dataThisTienda  = mysqli_fetch_assoc($Q_thisTienda);
                      $thisUserTienda = $dataThisTienda['sucursal']; ?>
                      <li class="unread">
                        <a href="#" class="d-flex align-items-center">
                          <span class="status status-success mr-2">
                            <img class="profile-image rounded-circle d-inline-block" src="<?= ASSETS_URL ?>/img/avatars/<?=$thisUserAvatar==''?$DfThisUserAvatar:$thisUserAvatar ?>" alt="Avatar">
                          </span>
                          <span class="d-flex flex-column flex-1 ml-1">
                            <span class="name"><?=$thisUserName ?> <span class="badge badge-primary fw-n position-absolute pos-top pos-right mt-1" title="Enviar sms por telegram"><i class="fas fa-paper-plane"></i></span></span>
                            <span class="msg-a fs-sm"><?=$thisUserTienda?></span>
                            <span class="msg-b fs-xs"><?=$thisUserCargo?></span>
                            <!-- <span class="fs-nano text-muted mt-1">activo hace <?php ?></span> -->
                          </span>
                        </a>
                        </li><?php
                    } ?>
                  </ul>
                  <div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.6) none repeat scroll 0% 0%; width: 4px; position: absolute; top: 0px; opacity: 0.4; display: block; border-radius: 7px; z-index: 99; right: 4px;"></div>
                  <div class="slimScrollRail" style="width: 4px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(250, 250, 250) none repeat scroll 0% 0%; opacity: 0.2; z-index: 90; right: 4px;"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div><?php
    } ?>
    <div>
      <a href="#" data-toggle="dropdown" title="<?=$nombreUsuarioDf?>" class="header-icon d-flex align-items-center justify-content-center ml-2">
        <img src="<?= ASSETS_URL ?>/img/avatars/<?=miAvatar($MySQLi,$idUser,$idRangoDf,$idSexoDf)?>" class="profile-image rounded-circle" alt="<?=$nombreUsuarioDf ?>">
      </a>
      <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
        <div class="dropdown-header bg-trans-gradient d-flex flex-row py-4 rounded-top">
          <div class="d-flex flex-row align-items-center mt-1 mb-1 color-white">
            <span class="mr-2">
              <img src="<?= ASSETS_URL ?>/img/avatars/<?=miAvatar($MySQLi,$idUser,$idRangoDf,$idSexoDf)?>" class="rounded-circle profile-image" alt="<?=$nombreUsuarioDf?>">
            </span>
            <div class="info-card-text">
              <div class="fs-lg text-truncate text-truncate-lg"><?=$nombreUsuarioDf?></div>
              <span class="text-truncate text-truncate-md opacity-80"><?=$correoUsuarioDf?></span>
            </div>
          </div>
        </div>
        <div class="dropdown-divider m-0"></div><?php
        if ($idRangoDf>1) { ?>
          <a href="#" class="dropdown-item" data-action="app-reset">
            <span data-i18n="drpdwn.reset_layout">Restaurar página</span>
          </a>
          <?php
        } ?> 
          <a href="#" class="dropdown-item" data-toggle="modal" data-target=".js-modal-settings">
            <span data-i18n="drpdwn.settings">Configuraciones</span>
          </a>       
        <div class="dropdown-divider m-0"></div>
        <a class="dropdown-item fw-500 pt-3 pb-3" href="<?= APP_URL ?>/salir.php">
          <span data-i18n="drpdwn.page-logout">Salir</span>
          <span class="float-right fw-n"><i class="fal fa-sign-out-alt text-danger"></i></span>
        </a>
      </div>
    </div>
  </div>
</header>