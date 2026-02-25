<?php
require_once 'init.php';
$_title = 'Usuarios - '.APP_DESCRIPTION;
$_active_nav = 'Usuarios';?>
<!DOCTYPE html>
<html lang="es"><?php 
  include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-bg-1 mod-skin-<?= APP_THEME ?> "><div class="respuesta"></div><?php 
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol><?php
            if ($idRangoDf==1) {
              error404();
            }else{ ?>
              <div id="panel-1" class="panel">
                <div class="panel-hdr">
                  <h2>Lista de <span class="fw-300"><i>Usuarios</i></span>&nbsp;&nbsp;&nbsp;&nbsp;
                    <button class="btn btn-primary btn-xs openModaladdUsuario" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar nuevo usuaario">Agregar <i class="fal fa-user"></i></button>
                  </h2>
                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">                      
                  <div class="panel-content">
                    <table id="listaUsuarios" class="table table-bordered table-hover table-striped w-100">
                      <thead>
                        <tr>
                          <th class="text-center">N&ordm;</th>
                          <th class="text-center">Nombre</th>
                          <th class="text-center">Cargo</th>
                          <th class="text-center">Correo</th>
                          <th class="text-center">Telefono</th>
                          <th class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody><?=listaUsuarios($MySQLi, $idUser, $idRangoDf); ?></tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--   MODAL REGISTRAR NUEVO USUARIO  -->
              <div class="modal fade" id="openModaladdUsuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Formulario nuevo usuario</h4>
                    </div>
                    <div class="modal-body">
                      <form id="registrarnuevoUsuario">
                        <input type="hidden" name="action" value="RegistrarUsuario">
                        <input type="hidden" name="zonaHoraria" value="<?=$zonaHora?>">
                        <div class="row">
                          <!-- Nombre del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="nombreUsuario" class="form-label">Nombre</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombreUsuario"><i class="fad fa-address-card"></i></label>
                              </div>
                              <input type="text" class="form-control" name="nombre" id="nombreUsuario" placeholder="Nombre">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreExcedido d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyNombreCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE CLIENTE</div>
                          </div>
                          <!-- Sexo del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="sexoUsuario" class="form-label">Sexo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="sexoUsuario"><i class="fad fa-address-card"></i></label>
                              </div>
                              <select name="sexo" id="sexoUsuario" class="form-control">
                                <option disabled selected value=0>Seleccione sexo</option>
                                <option value="1">Masculino</option>
                                <option value="2">Femenino</option>
                              </select>
                            </div>
                            <div class="noOptionSexo text-center text-danger mt-2 d-none">SELECCIONE OPCION</div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <!-- Cargo del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="cargoUsuario" class="form-label">Cargo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="cargoUsuario"><i class="fad fa-clipboard-user"></i></label>
                              </div>
                              <input type="text" class="form-control" placeholder="Cargo" name="cargo" id="cargoUsuario" />
                            </div>
                            <div class="limiteCargoExcedido text-center text-danger mt-2 d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyCargoUsuario text-center text-danger mt-2 d-none">INGRESE UN CARGO</div>
                          </div>
                          <!-- Correo del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="correoUsuario" class="form-label">Correo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="correoUsuario"><i class="fad fa-mailbox"></i></label>
                              </div>
                              <input type="email" class="form-control" name="correo" id="correoUsuario" placeholder="correo electrónico">
                            </div>
                            <div class="emptyCorreoUsuario text-center text-danger mt-2 d-none">INGRESE CORREO</div>
                            <div class="correoExiste text-center text-danger mt-2 d-none">CORREO YA EXISTE</div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <!-- Teléfono usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="telefonoUsuario" class="form-label">Telefono</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefonoUsuario"><i class="fad fa-phone-alt"></i></label>
                              </div>
                              <input type="text" class="form-control" placeholder="Telefóno" name="telefono" id="telefonoUsuario"  data-inputmask="'mask': '9999-9999'">
                            </div>
                            <div class="emptyTelefonoCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE CLIENTE</div>
                          </div>
                          <!-- Api telegram -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="idTelegram" class="form-label">API TeleGram</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="idTelegram"><i class="fad fa-paper-plane"></i></label>
                              </div>
                              <input type="text" class="form-control" placeholder="ID Telegram" name="idTelegram" id="idTelegram" required>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <!-- Sucursal usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="sucursalUsuario">Sucursal </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="sucursalUsuario"><i class="fad fa-building"></i></label>
                              </div>
                              <select name="idSucursal" id="sucursalUsuario" class="form-control">
                                <option  value="0" disabled selected>Seleccione sucursal</option><?php
                                $Q_Sucursales = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1");
                                while ($dataSucursal = mysqli_fetch_assoc($Q_Sucursales)) {
                                  echo'<option value='.$dataSucursal['idTienda'].'>'.$dataSucursal['sucursal'].' ('.$dataSucursal['codeTienda'] .')</option>';
                                }?>
                              </select>
                            </div>
                            <div class="noSelectSucursal text-center text-danger mt-2 d-none">SELECCIONE SUCURSAL</div>
                          </div>
                          <!-- Rango usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="rangoUsuario">Rango</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="rangoUsuario"><i class="fad fa-house-user"></i></label>
                              </div>
                              <select name="idRango" class="form-control" id="rangoUsuario" >
                              <option value="0" disabled selected>Seleccione rango</option><?php
                                $QRangos = mysqli_query($MySQLi,"SELECT * FROM rangos WHERE idRango!=3");
                                while ($dataRangos=mysqli_fetch_assoc($QRangos)) {echo'
                                  <option value='.$dataRangos['idRango'].'>'.$dataRangos['rango'].'</option>';
                                } ?>
                            </select>
                            </div>
                            <div class="noSelectRango text-center text-danger mt-2 d-none">SELECCIONE UN RANGO</div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="mt-2 btn btn-primary btn-sm btn-block regNewUser">Registrar</button>
                            <div class="spinner-regNewUser spinner-<?=APP_THEME ?> m-auto d-none">
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
              <!--   MODAL CANCELAR CUENTA DE USUARIO  -->
              <div class="modal fade" id="openModalCancelarUsuario" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">CANELAR CUENTA USUARIO</h4>
                    </div>
                    <div class="modal-body">
                      <form id="cancelarCuentaUsuario">
                        <div class="row">
                          <div class="col">
                            <input type="hidden" name="action" value="cancelarCuentaUsuario">
                            <input type="hidden" name="idUser" id="idUserModalCancelarUsuario">
                            <label for="razonCancelarUsuario">¿Razón? <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="razonCancelarUsuario" name="razon" placeholder="Describa la razón por la cual se cancela esta cuenta."></textarea>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col">
                            <button class="btn btn-primary btn-sm btn-block btnCancelarCuenta">CANCELAR CUENTA</button>
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
                      <h4 class="modal-title">CANELAR CUENTA USUARIO</h4>
                    </div>
                    <div class="modal-body">
                      <form id="telesms">
                        <div class="row">
                          <div class="col">
                            <label for="mensajeTelegram">Mensaje <span class="text-danger">*</span></label>
                            <input type="hidden" name="action" value="enviarSMSTeleGram">
                            <input type="hidden" name="idUser" id="idUser_modalTele">
                            <input type="hidden" name="idTelegram" id="idTelegram_modal">
                            <textarea class="form-control" id="mensajeTelegram" name="mensaje"></textarea>
                          </div>
                        </div>
                        <div class="row mt-3">
                          <div class="col">
                            <button class="btn btn-primary btn-sm btn-block TeleSend">Enviar SMS</button>
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
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--   MODAL EDITAR USUARIO  -->
              <div class="modal fade" id="EditUser_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Formulario editar Usuario</h4>                          
                    </div>
                    <div class="modal-body">
                      <form id="actualizarUsuario">
                        <input type="hidden" name="action" value="actualizarUsuario">
                        <input type="hidden" name="idUser" id="idUser_modal_editUser">
                        <div class="row">
                          <!-- Nombre del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="nombre_Usuario" class="form-label">Nombre</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="nombre_Usuario"><i class="fad fa-address-card"></i></label>
                              </div>
                              <input type="text" class="form-control" name="nombre" id="nombre_Usuario" placeholder="Nombre">
                            </div>
                            <div class="mt-2 text-danger text-center limiteNombreExcedido d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyNombreCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE CLIENTE</div>
                          </div>
                          <!-- Sexo del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="sexo_Usuario" class="form-label">Sexo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="sexo_Usuario"><i class="fad fa-address-card"></i></label>
                              </div>
                              <select name="sexo" id="sexo_Usuario" class="form-control">
                                <option disabled selected value=0>Seleccione sexo</option>
                                <option value="1">Masculino</option>
                                <option value="2">Femenino</option>
                              </select>
                            </div>
                            <div class="noOptionSexo text-center text-danger mt-2 d-none">SELECCIONE OPCION</div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <!-- Cargo del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="cargo_Usuario" class="form-label">Cargo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="cargo_Usuario"><i class="fad fa-clipboard-user"></i></label>
                              </div>
                              <input type="text" class="form-control" placeholder="Cargo" name="cargo" id="cargo_Usuario" />
                            </div>
                            <div class="limiteCargoExcedido text-center text-danger mt-2 d-none">LÍMITE EXCEDIDO</div>
                            <div class="emptyCargoUsuario text-center text-danger mt-2 d-none">INGRESE UN CARGO</div>
                          </div>
                          <!-- Correo del usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="correo_Usuario" class="form-label">Correo</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="correo_Usuario"><i class="fad fa-mailbox"></i></label>
                              </div>
                              <input type="email" class="form-control" name="correo" id="correo_Usuario" placeholder="correo electrónico">
                            </div>
                            <div class="emptyCorreoUsuario text-center text-danger mt-2 d-none">INGRESE CORREO</div>
                            <div class="correoExiste text-center text-danger mt-2 d-none">CORREO YA EXISTE</div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <!-- Teléfono usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="telefono_Usuario" class="form-label">Telefono</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="telefono_Usuario"><i class="fad fa-phone-alt"></i></label>
                              </div>
                              <input type="text" class="form-control" placeholder="Telefóno" name="telefono" id="telefono_Usuario"  data-inputmask="'mask': '9999-9999'">
                            </div>
                            <div class="emptyTelefonoCliente text-center text-danger mt-2 d-none">INGRESE TELÉFONO CLIENTE</div>
                          </div>
                          <!-- Api telegram -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="id_Telegram" class="form-label">API TeleGram</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="id_Telegram"><i class="fad fa-paper-plane"></i></label>
                              </div>
                              <input type="text" class="form-control" placeholder="ID Telegram" name="idTelegram" id="id_Telegram" required>
                            </div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <!-- Sucursal usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="sucursal_Usuario">Sucursal </label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="sucursal_Usuario"><i class="fad fa-building"></i></label>
                              </div>
                              <select name="idSucursal" id="sucursal_Usuario" class="form-control">
                                <option  value="0" disabled selected>Seleccione sucursal</option><?php
                                $Q_Sucursales = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1");
                                while ($dataSucursal = mysqli_fetch_assoc($Q_Sucursales)) {
                                  echo'<option value='.$dataSucursal['idTienda'].'>'.$dataSucursal['sucursal'].' ('.$dataSucursal['codeTienda'] .')</option>';
                                }?>
                              </select>
                            </div>
                            <div class="noSelectSucursal text-center text-danger mt-2 d-none">SELECCIONE SUCRSAL</div>
                          </div>
                          <!-- Rango usuario -->
                          <div class="mt-2 col-lg-6 col-md-12 col-sm-12">
                            <label for="rango_Usuario">Rango</label>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <label class="input-group-text" for="rango_Usuario"><i class="fad fa-house-user"></i></label>
                              </div>
                              <select name="idRango" class="form-control" id="rango_Usuario" >
                              <option value="0" disabled selected>Seleccione rango</option><?php
                                if ($idRangoDf > 2) {
                                  $QRangos = mysqli_query($MySQLi,"SELECT * FROM rangos ");
                                }else{
                                  $QRangos = mysqli_query($MySQLi,"SELECT * FROM rangos WHERE idRango!=3");
                                }
                                while ($dataRangos=mysqli_fetch_assoc($QRangos)) {echo'
                                  <option value='.$dataRangos['idRango'].'>'.$dataRangos['rango'].'</option>';
                                }?>
                            </select>
                            </div>
                            <div class="noSelectRango text-center text-danger mt-2 d-none">SELECCIONE UN RANGO</div>
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button>
                          </div>
                          <div class="col">
                            <button class="mt-2 btn btn-primary btn-sm btn-block btnUpdateUser">Actualizar</button>
                            <div class="spinner-btnUpdateUser spinner-<?=APP_THEME ?> m-auto d-none">
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
              </div><?php
            } ?>
          </main><?php
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/usuarios.js"></script>
  </body>
</html>