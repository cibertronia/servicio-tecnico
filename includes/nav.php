<aside class="page-sidebar">
  <div class="page-logo">
    <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
      <img src="<?= ASSETS_URL ?>/img/favicon/icono.png" alt="<?=APP_TITLE ?>" aria-roledescription="logo">
      <span class="page-logo-text mr-1"><?=APP_TITLE ?></span>
      <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
      <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
    </a>
  </div>
  <nav id="js-primary-nav" class="primary-nav" role="navigation">
    <div class="nav-filter">
      <div class="position-relative">
        <input type="text" id="nav_filter_input" placeholder="Filtrar menú" class="form-control" tabindex="0">
        <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
          <i class="fal fa-chevron-up"></i>
        </a>
      </div>
    </div>
    <div class="info-card">      
      <!-- AQUI INICIA LA INFORMACION DEL USUARIO -->
      <img src="<?= ASSETS_URL ?>/img/avatars/<?=miAvatar($MySQLi,$idUser, $idRangoDf, $idSexoDf)?>" class="profile-image rounded-circle" alt="miAvatar">
      <div class="info-card-text">
        <a href="#" class="d-flex align-items-center text-white">
          <span class="text-truncate text-truncate-sm d-inline-block"><?=$nombreUsuarioDf?></span>
        </a>
        <span class="d-inline-block text-truncate text-truncate-sm"><?=$cargoUsuarioDf?></span>
      </div>
      <!-- AQUI FINALIZA LA INFORMACION DEL USUARIO -->
      <img src="<?= ASSETS_URL ?>/img/card.jpg" class="cover" alt="cover">
      <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
        <i class="fal fa-angle-down"></i>
      </a>
    </div>
    <div class="text-center mt-2 text-muted"><?=strtoupper($sucurUsuarioDf) ?></div><?php
    if (isset($_nav)) {
      (new \Bootstrap\Components\Nav($_nav, isset($_active_nav) ? $_active_nav : null))
      ->printHtml();
    }?>
    <div class="filter-message js-filter-message bg-success-600"></div>
  </nav>
  <div class="nav-footer shadow-top">
    <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify" class="hidden-md-down">
      <i class="ni ni-chevron-right"></i>
      <i class="ni ni-chevron-right"></i>
    </a>
    <ul class="list-table m-auto nav-footer-buttons">
      <!-- <li>
        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Chat logs">
          <i class="fal fa-comments"></i>
        </a>
      </li> -->
      <li>
        <a target="_blank" href="https://yapame.com.bo/soporte/" data-toggle="tooltip" data-placement="top" title="Reportar un problema al soporte de YAPAME">
          <i class="fal fa-life-ring"></i>
        </a>
      </li>
      <li>
        <a href="salir.php" data-toggle="tooltip" data-placement="top" title="Salir del sistema">
          <i class="fal fa-power-off"></i>
        </a>
      </li>
      <!-- <li>
        <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top" title="Make a call">
          <i class="fal fa-phone"></i>
        </a>
      </li> -->
    </ul>
  </div>
</aside>