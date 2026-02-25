<nav class="shortcut-menu d-none d-sm-block">
  <input type="checkbox" class="menu-open" name="menu-open" id="menu_open" />
  <label for="menu_open" class="menu-open-button ">
    <span class="app-shortcut-icon d-block"></span>
  </label>
  <a href="#" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Subir">
    <i class="fal fa-arrow-up"></i>
  </a>
  <a href="<?= APP_URL ?>/salir.php" class="menu-item btn" data-toggle="tooltip" data-placement="left" title="Salir">
    <i class="fal fa-sign-out"></i>
  </a>
  <a href="#" class="menu-item btn" data-action="app-fullscreen" data-toggle="tooltip" data-placement="left" title="Pantalla completa">
    <i class="fal fa-expand"></i>
  </a>
  <!-- <a href="#" class="menu-item btn" data-action="app-print" data-toggle="tooltip" data-placement="left" title="Imprimir página">
    <i class="fal fa-print"></i>
  </a>
  <a href="#" class="menu-item btn" data-action="app-voice" data-toggle="tooltip" data-placement="left" title="Comando de voz">
    <i class="fal fa-microphone"></i>
  </a> -->
</nav>

<div class="modal fade js-modal-settings modal-backdrop-transparent" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-right modal-md">
    <div class="modal-content">
      <div class="dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center w-100">
        <h4 class="m-0 text-center color-white">
          Opciones de Diseño
          <small class="mb-0 opacity-80">Configuración de la interfaz de usuario</small>
        </h4>
        <button type="button" class="close text-white position-absolute pos-top pos-right p-2 m-1 mr-2" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true"><i class="fal fa-times"></i></span>
        </button>
      </div>
      <div class="modal-body p-0">
        <div class="settings-panel">
          <div class="mt-4 d-table w-100 px-5">
            <div class="d-table-cell align-middle">
              <h5 class="p-0">
                Diseño de la aplicación
              </h5>
            </div>
          </div>
          <div class="list" id="fh">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="header-function-fixed"></a>
            <span class="onoffswitch-title">Encabezado fijo</span>
            <span class="onoffswitch-title-desc">El encabezado es fijo en todo momento.</span>
          </div>
          <div class="list" id="nff">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-fixed"></a>
            <span class="onoffswitch-title">Navegación fija</span>
            <span class="onoffswitch-title-desc">El panel izquierdo está fijo</span>
          </div>
          <div class="list" id="nfm">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-minify"></a>
            <span class="onoffswitch-title">Minimizar la navegación</span>
            <span class="onoffswitch-title-desc">Inclina la navegación para maximizar el espacio</span>
          </div>
          <div class="list" id="nfh">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-hidden"></a>
            <span class="onoffswitch-title">Ocultar navegación</span>
            <span class="onoffswitch-title-desc">Mueva el mouse sobre el borde para revelar</span>
          </div>
          <div class="list" id="nft">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="nav-function-top"></a>
            <span class="onoffswitch-title">Navegación superior</span>
            <span class="onoffswitch-title-desc">Reubicar el panel izquierdo en la parte superior</span>
          </div>
          <div class="list" id="fff">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="footer-function-fixed"></a>
            <span class="onoffswitch-title">Pie de página fijo</span>
            <span class="onoffswitch-title-desc">El pie de página es fijo</span>
          </div>
          <div class="mt-4 d-table w-100 px-5">
            <div class="d-table-cell align-middle">
              <h5 class="p-0">
                Modificaciones globales
              </h5>
            </div>
          </div>
          <div class="list" id="mcbg">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-clean-page-bg"></a>
            <span class="onoffswitch-title">Fondo de página limpio</span>
            <span class="onoffswitch-title-desc">agrega más espacios en blanco</span>
          </div>
          <div class="list" id="mhni">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-hide-nav-icons"></a>
            <span class="onoffswitch-title">Ocultar iconos de navegación</span>
            <span class="onoffswitch-title-desc">iconos de navegación invisible</span>
          </div>
          <div class="list" id="dan">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-disable-animation"></a>
            <span class="onoffswitch-title">Deshabilitar la animación CSS</span>
            <span class="onoffswitch-title-desc">Deshabilita las animaciones basadas en CSS</span>
          </div>
          <div class="list" id="mhic">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-hide-info-card"></a>
            <span class="onoffswitch-title">Ocultar tarjeta de información</span>
            <span class="onoffswitch-title-desc">Oculta la tarjeta de información del panel izquierdo</span>
          </div>
          <div class="list" id="mdn">
            <a href="#" onclick="return false;" class="btn btn-switch" data-action="toggle" data-class="mod-nav-dark"></a>
            <span class="onoffswitch-title">Navegación oscura</span>
            <span class="onoffswitch-title-desc">El fondo de navegación es oscuro</span>
          </div>
          <hr class="mb-0 mt-4">
          <div class="mt-4 d-table w-100 pl-5 pr-3">
            <div class="d-table-cell align-middle">
              <h5 class="p-0">
                Tamaño de fuente global
              </h5>
            </div>
          </div>
          <div class="list mt-1">
            <div class="btn-group btn-group-sm btn-group-toggle my-2" data-toggle="buttons">
              <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-sm" data-target="html">
                <input type="radio" name="changeFrontSize"> SM
              </label>
              <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text" data-target="html">
                <input type="radio" name="changeFrontSize" checked=""> MD
              </label>
              <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-lg" data-target="html">
                <input type="radio" name="changeFrontSize"> LG
              </label>
              <label class="btn btn-default btn-sm" data-action="toggle-swap" data-class="root-text-xl" data-target="html">
                <input type="radio" name="changeFrontSize"> XL
              </label>
            </div>
            <span class="onoffswitch-title-asc d-block mb-0">Los valores se restablece en la actualización de la página</span>
          </div>
          <hr class="mb-0 mt-4">
          <div class="mt-4 d-table w-100 pl-5 pr-3">
            <div class="d-table-cell align-middle">
              <h5 class="p-0 pr-2 d-flex">
                Colores del tema
              </h5>
            </div>
          </div>
          <div class="expanded theme-colors pl-5 pr-3">
            <ul class="m-0">
              <li>
                <a href="#" id="myapp-0" data-action="theme-update" data-themesave data-theme="" data-toggle="tooltip" data-placement="top" title="Wisteria (base css)" data-original-title="Wisteria (base css)"></a>
              </li>
              <li>
                <a href="#" id="myapp-1" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-1.css" data-toggle="tooltip" data-placement="top" title="Tapestry" data-original-title="Tapestry"></a>
              </li>
              <li>
                <a href="#" id="myapp-2" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-2.css" data-toggle="tooltip" data-placement="top" title="Atlantis" data-original-title="Atlantis"></a>
              </li>
              <li>
                <a href="#" id="myapp-3" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-3.css" data-toggle="tooltip" data-placement="top" title="Indigo" data-original-title="Indigo"></a>
              </li>
              <li>
                <a href="#" id="myapp-4" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-4.css" data-toggle="tooltip" data-placement="top" title="Dodger Blue" data-original-title="Dodger Blue"></a>
              </li>
              <li>
                <a href="#" id="myapp-5" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-5.css" data-toggle="tooltip" data-placement="top" title="Tradewind" data-original-title="Tradewind"></a>
              </li>
              <li>
                <a href="#" id="myapp-6" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-6.css" data-toggle="tooltip" data-placement="top" title="Cranberry" data-original-title="Cranberry"></a>
              </li>
              <li>
                <a href="#" id="myapp-7" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-7.css" data-toggle="tooltip" data-placement="top" title="Oslo Gray" data-original-title="Oslo Gray"></a>
              </li>
              <li>
                <a href="#" id="myapp-8" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-8.css" data-toggle="tooltip" data-placement="top" title="Chetwode Blue" data-original-title="Chetwode Blue"></a>
              </li>
              <li>
                <a href="#" id="myapp-9" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-9.css" data-toggle="tooltip" data-placement="top" title="Apricot" data-original-title="Apricot"></a>
              </li>
              <li>
                <a href="#" id="myapp-10" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-10.css" data-toggle="tooltip" data-placement="top" title="Blue Smoke" data-original-title="Blue Smoke"></a>
              </li>
              <li>
                <a href="#" id="myapp-11" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-11.css" data-toggle="tooltip" data-placement="top" title="Green Smoke" data-original-title="Green Smoke"></a>
              </li>
              <li>
                <a href="#" id="myapp-12" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-12.css" data-toggle="tooltip" data-placement="top" title="Wild Blue Yonder" data-original-title="Wild Blue Yonder"></a>
              </li>
              <li>
                <a href="#" id="myapp-13" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-13.css" data-toggle="tooltip" data-placement="top" title="Emerald" data-original-title="Emerald"></a>
              </li>
              <li>
                <a href="#" id="myapp-14" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-14.css" data-toggle="tooltip" data-placement="top" title="Supernova" data-original-title="Supernova"></a>
              </li>
              <li>
                <a href="#" id="myapp-15" data-action="theme-update" data-themesave data-theme="https://smartadmin.lodev09.com/assets/css/themes/cust-theme-15.css" data-toggle="tooltip" data-placement="top" title="Hoki" data-original-title="Hoki"></a>
              </li>
            </ul>
          </div>
          <hr class="mb-0 mt-4">
          <div class="mt-4 d-table w-100 pl-5 pr-3">
            <div class="d-table-cell align-middle">
              <h5 class="p-0 pr-2 d-flex">
                Modos de tema
              </h5>
            </div>
          </div>
          <div class="pl-5 pr-3 py-3">
            <div class="ie-only alert alert-warning d-none">
              <h6>Problema de Internet Explorer</h6>
              Es posible que este componente en particular no funcione como se esperaba en Internet Explorer. Úselo con precaució<n class=""></n>
            </div>
            <div class="row no-gutters">
              <div class="col-4 pr-2 text-center">
                <div id="skin-default" data-action="toggle-replace" data-replaceclass="mod-skin-light mod-skin-dark" data-class="" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-primary rounded overflow-hidden text-success js-waves-on" data-original-title="Tema por Defecto" style="height: 80px">
                  <div class="bg-primary-600 bg-primary-gradient px-2 pt-0 border-right border-primary"></div>
                  <div class="d-flex flex-column flex-1">
                    <div class="bg-white border-bottom border-primary py-1"></div>
                    <div class="bg-faded flex-1 pt-3 pb-3 px-2">
                      <div class="py-3" style="background:url('assets/img/demo/s-1.png') top left no-repeat;background-size: 100%;"></div>
                    </div>
                  </div>
                </div>
                Defecto
              </div>
              <div class="col-4 px-1 text-center">
                <div id="skin-light" data-action="toggle-replace" data-replaceclass="mod-skin-dark" data-class="mod-skin-light" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-secondary rounded overflow-hidden text-success js-waves-on" data-original-title="Modo claro" style="height: 80px">
                  <div class="bg-white px-2 pt-0 border-right border-"></div>
                  <div class="d-flex flex-column flex-1">
                    <div class="bg-white border-bottom border- py-1"></div>
                    <div class="bg-white flex-1 pt-3 pb-3 px-2">
                      <div class="py-3" style="background:url('assets/img/demo/s-1.png') top left no-repeat;background-size: 100%;"></div>
                    </div>
                  </div>
                </div>
                Claro
              </div>
              <div class="col-4 pl-2 text-center">
                <div id="skin-dark" data-action="toggle-replace" data-replaceclass="mod-skin-light" data-class="mod-skin-dark" data-toggle="tooltip" data-placement="top" title="" class="d-flex bg-white border border-dark rounded overflow-hidden text-success js-waves-on" data-original-title="Modo obscuro" style="height: 80px">
                  <div class="bg-fusion-500 px-2 pt-0 border-right"></div>
                  <div class="d-flex flex-column flex-1">
                    <div class="bg-fusion-600 border-bottom py-1"></div>
                    <div class="bg-fusion-300 flex-1 pt-3 pb-3 px-2">
                      <div class="py-3 opacity-30" style="background:url('assets/img/demo/s-1.png') top left no-repeat;background-size: 100%;"></div>
                    </div>
                  </div>
                </div>
                Obscuro
              </div>
            </div>
          </div>
          <hr class="mb-0 mt-4">
          <div class="pl-5 pr-3 py-3 bg-faded">
            <div class="row no-gutters">
              <div class="col-6 pr-1">
                <a href="#" class="btn btn-outline-danger fw-500 btn-block" data-action="app-reset">Reiniciar ajustes</a>
              </div>
              <div class="col-6 pl-1">
                <a href="#" class="btn btn-danger fw-500 btn-block" data-action="factory-reset">Ajustes de fábrica</a>
              </div>
            </div>
          </div>
        </div> <span id="saving"></span>
      </div>
    </div>
  </div>
</div>