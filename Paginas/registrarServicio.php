<?php
$alert = aleatorio();
$claveSoporte = md5(date("d/m/Y g:i:s") . $alert);
require_once 'init.php';
require 'includes/default2.php';
// require 'includes/default.php';
$_title = 'Registrar servicio técnico - ' . APP_TITLE;
$_active_nav = 'regReparacion'; ?>
<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="assets/sweetchery/sweetchery.css"><?php
                                                                include_once APP_PATH . '/includes/head.php';
                                                                include_once APP_PATH . '/includes/funciones.php'; ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?> ">
    <?php
    include_once APP_PATH . '/includes/theme.php'; ?>
    <div class="page-wrapper">
        <div class="page-inner"><?php
                                include_once APP_PATH . '/includes/nav.php'; ?>
            <div class="page-content-wrapper"><?php
                                                include_once APP_PATH . '/includes/header.php'; ?>
                <main id="js-page-content" role="main" class="page-content">
                    <ol class="breadcrumb page-breadcrumb"><?= $Fecha ?></ol>
                    <?php
                    if ($_SESSION['idRango'] == 4) {
                        echo error403();
                    } else {
                    ?>
                    <div class="row">
                        <div class="col">
                            <div id="panel-1" class="panel">
                                <div class="panel-hdr">
                                    <h2>Recepcion <span class="fw-300"><i>Servicio técnico </i></span></h2>
                                    <div class="panel-toolbar">
                                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                                    </div>
                                </div>
                                <div class="panel-container">
                                    <div class="panel-content">
                                        <div class="respuesta"></div>
                                        <form id="registrarServicio">

                                            <div class="row none ModoColaRecepcion">
                                                <div class="col-md-7">
                                                    <label for="optionUser">Cliente Existente en Sistema de Ventas
                                                        Yuliimport.com?</label>
                                                    <p>
                                                        &nbsp;&nbsp;&nbsp;
                                                        <input id="opttionUser" name="optionUser" type="checkbox" class="js-switch checkb">&nbsp;&nbsp;&nbsp;

                                                        <span class="text-white bg-success d-none siExistente" style="padding: 3px;border-radius: 4px">SI</span>
                                                        <span class="text-white bg-danger  noExistente" style="padding: 3px;border-radius: 3px">NO</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row none ModoColaRecepcion">
                                                <div class="col-md-7 d-none ClienteXistente">
                                                    <label for="ClienteProducto">Lista Clientes - Sistema de Ventas
                                                        Yuliimport.com <span class="text-danger">( *
                                                            )</span></label>
                                                            
                                                   <select name="Producto" id="ClienteProducto" class="cliente_id form-control">
                                  
                                </select>
                                                    <div class="text-danger d-none noSelectProd">No ha seleccionado un
                                                        producto
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-7">
                                                    <label for="nombreCliente">Nombre</label>
                                                    <input type="hidden" name="action" value="GuardarnuevoServicio">
                                                    <input type="hidden" name="sucursal" id="sucursalUsuario" value="<?= $sucurUsuarioDf; ?>">
                                                    <input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idTiendaDf; ?>">


                                                    <input type="hidden" name="claveSoporte" id="claveSoporte" value="<?= $claveSoporte ?>">
                                                    <input type="text" name="nombre" id="nombreCliente" placeholder="Nombre del cliente" class="form-control">
                                                </div>
                                                <div class="col">
                                                    <label for="telCliente">Celular</label>
                                                    <input type="tel" name="celular" id="telCliente" class="form-control" minlength="7" maxlength="8" placeholder="Celular">
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col">
                                                    <label for="direccion">Dirección en la cual se realizara el Servicio Técnico </label>
                                                    <textarea type="text" name="direccion" id="direccion" class="form-control">Sucursal Servicio Técnico Yuli <?= $sucurUsuarioDf; ?></textarea>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="formularioRegistro">
                                                <div class="row">
                                                    <div class="col-md-7 d-none equipoExistenteCol">
                                                        <label for="EquipoExistente">Lista Equipos Comprados - Sistema
                                                            de Ventas Yuliimport.com <span class="text-danger">( *
                                                                )</span></label>
                                                        <select name="EquipoExistente" id="EquipoExistente" class="form-control">
                                                            <option disabled selected value="null">Seleccione Equipo
                                                            </option>
                                                        </select>
                                                        <div class="text-danger d-none noSelectProd">No ha seleccionado
                                                            un producto
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        <label for="equipoNombre">Equipo</label>
                                                        <input type="text" name="equipo" id="equipoNombre" placeholder="Equipo" class="form-control">
                                                    </div>
                                                    <div class="col fechaVentaCol">
                                                        <label for="fechaVenta">Fecha Compra-Venta Equipo <span class="text-danger">( *
                                                                )</span></label>
                                                        <input type="date" name="fechaVenta" id="fechaVenta" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col">
                                                        <label for="marcaEquipo">Marca</label>
                                                        <input type="text" name="marca" id="marcaEquipo" class="form-control" placeholder="Marca">
                                                    </div>
                                                    <div class="col">
                                                        <label for="modeloEquipo">Modelo</label>
                                                        <input type="text" name="modelo" id="modeloEquipo" class="form-control" placeholder="Modelo">
                                                    </div>
                                                    <div class="col">
                                                        <label for="serieEquipo">N&ordm; Serie</label>
                                                        <input type="text" name="serie" id="serieEquipo" class="form-control" placeholder="N&ordm; de serie">
                                                    </div>
                                                </div>
                                                <hr>
                                                <div hidden class="row mt-3">
                                                    <div class="col">
                                                        <!-- <label for="getDataClientesYuliJson">getDataClientesYuliJson
                                                            Input</label> -->
                                                        <input hidden type="text" name="getDataClientesYuliJson" id="getDataClientesYuliJson" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="row mt-3">
                                                    <div class="col">
                                                        <label for="problemaEquipo">Problema </label>
                                                        <textarea type="text" name="problema" id="problemaEquipo" placeholder="Ingrese una breve descripción del problema" class="form-control"></textarea>
                                                    </div>
                                                    <div class="col">
                                                        <label for="observacionesEquipo">Observaciones</label>
                                                        <textarea type="text" name="observaciones" id="observacionesEquipo" class="form-control" placeholder="Utilice este espacio si necesita agregar algun comentario"></textarea>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="row mt-3">
                                                        <div class="col">
                                                            <label for="garantiaEquipoRepuesto" class="label">¿Cuenta con
                                                                Garantía de Repuesto? (3 Meses)</label>
                                                            <!-- <option selected disabled>Seleccione una opción</option> -->
                                                            <select name="garantiaEquipoRepuesto" id="garantiaEquipoRepuesto" class="form-control">
                                                                <option value="no">No</option>
                                                                <option value="si">Si</option>
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <label for="garantiaEquipoMano" class="label">¿Cuenta con
                                                                Garantía de Mano? (1 Año)</label>

                                                            <!-- <option selected disabled>Seleccione una opción</option> -->
                                                            <select name="garantiaEquipoMano" id="garantiaEquipoMano" class="form-control">
                                                                <option value="no">No</option>
                                                                <option value="si">Si</option>
                                                            </select>
                                                        </div>
                                                        </select>

                                                        <div class="col opcionesGarantia d-none">
                                                            <label for="fechaCompra">Fecha compra</label>
                                                            <input type="date" name="fechaCompra" id="fechaCompra" class="form-control">
                                                        </div>
                                                        <div class="col opcionesGarantia">
                                                            <label for="numeroFactura">N&ordm; de Nota de Entrega</label>
                                                            <input type="text" name="numeroFactura" id="numeroFactura" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mt-3 botonesRegistro d-none">
                                                    <div class="col text-center">
                                                        <label for="btnMasCampos">&nbsp;&nbsp;</label>
                                                        <button class="btn btn-primary" id="btnMasCampos">Agregar Equipo a la Cola</button>
                                                        <input type="hidden" value='0' name="controladorEquipos" id="controladorEquipos">
                                                        <div class="spinner spinnerMasCampos spinner-<?= APP_THEME ?> m-auto d-none">
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
                                                    <div class="col text-center">
                                                        <label for="btnContinuar">&nbsp;&nbsp;</label>
                                                        <button class="btn btn-primary" id="btnContinuar">Finalizar Recepción</button>
                                                        <div class="spinner spinnerContinuar spinner-<?= APP_THEME ?> m-auto d-none">
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
                    <?php } ?>
                </main><?php
                        include_once APP_PATH . '/includes/footer.php'; ?>
            </div>
        </div>
    </div>
    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script type="text/javascript" src="assets/js/bootstrap-show-password.js"></script>
    <script src="assets/sweetchery/sweetchery.js"></script>
    <script src="assets/js/registrarServicio.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
      $('#ClienteProducto').select2({
        placeholder: 'Selecciona un cliente',
        ajax: {
          url: 'getcli.php',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results: data
            };
          },
          minimumInputLength: 3,
          cache: true
        }
      });
    });
</script>
</body>

</html>