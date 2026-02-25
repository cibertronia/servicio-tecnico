<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Equipos registrados - ' . APP_TITLE;
$_active_nav = 'registrados'; ?>
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
                    <div class="row">
                        <div class="respuesta"></div>
                        <div class="col">
                            <div id="registrados_lista" class="panel">
                                <div class="panel-hdr"><?php
                                                        if (isset($_POST['inicio'])) {
                                                            $Inicio = $_POST['inicio'];
                                                            $Fin = $_POST['fin']; ?>
                                        <h2>Diagnostico <span class="fw-300"><i>de Equipos </i></span> &nbsp; &nbsp;del
                                            &nbsp;
                                            <span class="text-danger"><?= fechaFormato($Inicio) ?></span> &nbsp;al &nbsp;
                                            <span class="text-danger"><?= fechaFormato($Fin) ?></span>
                                        </h2>
                                        <button class="btn btn-xs btn-primary Buscar"><i class="far fa-search">
                                                Buscar</i></button>&nbsp;&nbsp;<?php
                                                                            } else { ?>
                                        <h2>Diagnostico <span class="fw-300"><i>de Equipos </i></span> &nbsp;
                                            &nbsp;<?= $mes ?>
                                        </h2>
                                        <button class="btn btn-xs btn-primary Buscar"><i class="far fa-search">
                                                Buscar</i></button>&nbsp;&nbsp;<?php
                                                                            } ?>
                                        <a href="?root=registrarServicio">
                                            <button class="btn btn-xs btn-primary">Recepcionar Servicio</button>
                                        </a>&nbsp;&nbsp;&nbsp;
                                        <div class="panel-toolbar">
                                            <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                            <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                                        </div>
                                </div>
                                <div class="panel-container">
                                    <div class="panel-content">
                                        <form class="w-75 m-auto d-none" id="buscar" action="?root=registrados" method="POST">
                                            <div class="row mb-2">
                                                <div class="col text-center">
                                                    <label for="fechaInicio">Fecha de inicio</label>
                                                    <input type="hidden" name="sucursal" value="<?php echo $dataUss['ciudad'] ?>">
                                                    <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $startBusqueda ?>" data-parsley-required="true">
                                                </div>
                                                <div class="col text-center">
                                                    <label for="fechaFin">Fecha final</label>
                                                    <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $fecha ?>" data-parsley-required="true">
                                                </div>
                                                <div class="col">
                                                    <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                                                    <button type="submit" class="form-control btn btn-xs btn-primary ">Buscar &nbsp;<i class="fas fa-spinner fa-pulse d-none btn-Buscar"></i></button>
                                                </div>
                                            </div>
                                        </form><?php
                                                // $sucursalVendedor = $dataUss['ciudad'];

                                                // if ($sucursalVendedor=='Cochabamba') {
                                                //   $baseDatos  = "soporte_sucursales";
                                                // }else{
                                                //   $baseDatos  = "soporte_sucursales";
                                                // }
                                                if (isset($_POST['inicio'])) {
                                                    if ($idRango == 2) { //rango 2 es admin
                                                        $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin' AND estado=0  ORDER BY fechaRegistro DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                    } else {
                                                        $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin' AND estado=0 AND idSucursal='$idTiendaDf' ORDER BY fechaRegistro DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                    }
                                                } else {
                                                    if ($idRango == 2) { //rango 2 es admin
                                                        $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha' AND estado=0  ORDER BY fechaRegistro DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                    } else {
                                                        $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha' AND estado=0 AND idSucursal='$idTiendaDf' ORDER BY fechaRegistro DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                                                    }
                                                } ?>
                                        <table id="listaRegistrados" class="table table-bordered table-hover table-sm table-striped w-100 asc responsive" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th width="1%" class="text-center">N&ordm;</th>
                                                    <th width="80%" class="text-center">Descripción</th>
                                                    <th width="1%" class="text-center">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody><?= equipsRegistrados($MySQLi, $Q_Servicio); ?></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main><?php
                        include_once APP_PATH . '/includes/footer.php'; ?>
            </div>
        </div>
        <!-- Modal editar informacion del equipo (terminado) -->
        <div class="modal fade" id="openModal_editInfoEquipo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Formulario equipo seleccionado
                            <small class="m-0 text-muted">
                                Edite los campos necesarios
                            </small>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateThisEquipo">
                            <div class="row">
                                <div class="col">
                                    <label for="eqNombre">Equipo</label>
                                    <input type="hidden" name="action" value="ActualizaDatosEquipoSoporte">
                                    <input type="hidden" name="sucursal" id="sucursalModaleditInfoEquipo">
                                    <input type="hidden" name="idClave" id="idClaveEq">
                                    <input type="text" name="equipo" id="eqNombre" placeholder="Maquina" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="marcaEq">Marca</label>
                                    <input type="text" name="marca" id="marcaEq" class="form-control" placeholder="Marca">
                                </div>
                                <div class="col">
                                    <label for="modeloEq">Modelo</label>
                                    <input type="text" name="modelo" id="modeloEq" class="form-control" placeholder="Modelo">
                                </div>
                                <div class="col">
                                    <label for="serieEq">N&ordm; Serie</label>
                                    <input type="text" name="serie" id="serieEq" class="form-control" placeholder="N&ordm; de serie">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="problemaEq">Problema </label>
                                    <textarea type="text" name="problema" id="problemaEq" placeholder="Problemas de este equipo" class="form-control"></textarea>
                                </div>
                                <div class="col">
                                    <label for="observacionesEq">Observaciones</label>
                                    <textarea type="text" name="observaciones" id="observacionesEq" class="form-control" placeholder="Observaciones de este equipo"></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4 text-center">
                                    <label for="garantiaEq" class="label">Cuenta con garantía?</label>
                                    <select name="garantia" id="garantiaEq" class="form-control">
                                        <option selected disabled>Seleccione una opción</option>
                                        <option value="no">No</option>
                                        <option value="si">Si</option>
                                    </select>
                                </div>
                                <div class="col opcionGarantia_div">
                                    <label for="fechaCompraEq">Fecha compra</label>
                                    <input type="date" name="fechaCompra" id="fechaCompraEq" class="form-control">
                                </div>
                                <div class="col opcionGarantia_div">
                                    <label for="numeroFacturaEq">Factura N&ordm;</label>
                                    <input type="text" name="numeroFactura" id="numeroFacturaEq" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <label for="btnActualizaEq">&nbsp;&nbsp;</label>
                                    <button class="btn btn-primary" id="btnActualizaEq">Actualizar datos</button>
                                    <div class="spinner spinnerActEq spinner-<?= APP_THEME ?> m-auto d-none">
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
        <!-- Modal agregar nuevo equipo (terminado)-->
        <div class="modal fade" id="openModal_AddEquipo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Formulario Ingresar nuevo equipo
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="showTable"></div>
                        <form id="nuevoEquipo">
                            <div class="row">
                                <div class="col">
                                    <label for="eq_Nombre">Equipo</label>
                                    <input type="hidden" name="action" value="GuardarClaveServicio">
                                    <input type="hidden" name="clave" id="claveOtroEquipo">
                                    <input type="text" name="equipo" id="eq_Nombre" placeholder="Maquina" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="marca_Eq">Marca</label>
                                    <input type="text" name="marca" id="marca_Eq" class="form-control" placeholder="Marca">
                                </div>
                                <div class="col">
                                    <label for="modelo_Eq">Modelo</label>
                                    <input type="text" name="modelo" id="modelo_Eq" class="form-control" placeholder="Modelo">
                                </div>
                                <div class="col">
                                    <label for="serie_Eq">N&ordm; Serie</label>
                                    <input type="text" name="serie" id="serie_Eq" class="form-control" placeholder="N&ordm; de serie">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="problema_Eq">Problema </label>
                                    <textarea type="text" name="problema" id="problema_Eq" placeholder="Problemas de este equipo" class="form-control"></textarea>
                                </div>
                                <div class="col">
                                    <label for="observaciones_Eq">Observaciones</label>
                                    <textarea type="text" name="observaciones" id="observaciones_Eq" class="form-control" placeholder="Observaciones de este equipo"></textarea>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="row mt-3">
                                    <div class="col">
                                        <label for="garantiaEquipoRepuestoModal" class="label">¿Cuenta con
                                            Garantía de Repuesto? <br>(3 Meses)</label>
                                        <!-- <option selected disabled>Seleccione una opción</option> -->
                                        <select name="garantiaEquipoRepuestoModal" id="garantiaEquipoRepuestoModal" class="form-control">
                                            <option value="no">No</option>
                                            <option value="si">Si</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="garantiaEquipoManoModal" class="label">¿Cuenta con
                                            Garantía de Mano? <br>(1 Año)</label>

                                        <!-- <option selected disabled>Seleccione una opción</option> -->
                                        <select name="garantiaEquipoManoModal" id="garantiaEquipoManoModal" class="form-control">
                                            <option value="no">No</option>
                                            <option value="si">Si</option>
                                        </select>
                                    </div>
                                    </select>

                                    <div class="col fechaVentaCol">
                                        <br>
                                        <label for="fechaVenta">Fecha Compra-Venta Equipo <span class="text-danger">( *
                                                )</span></label>
                                        <input type="date" name="fechaVenta" id="fechaVenta" class="form-control">
                                    </div>
                                    <div class="col opcionesGarantiaModal">
                                        <br>
                                        <br>
                                        <label for="numeroFacturaModal">N&ordm; de Nota de Entrega</label>
                                        <input type="text" name="numeroFacturaModal" id="numeroFacturaModal" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="sucursal" id="sucursalUsuario" value="<?= $sucurUsuarioDf; ?>">
                            <input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idTiendaDf; ?>">
                            <br>
                            <div class="row btnBotones">
                                <div class="col text-center">
                                    <label for="btn_Continuar">&nbsp;&nbsp;</label>
                                    <button class="btn btn-primary" id="btn_Continuar">Añadir Equipo y
                                        Continuar</button>
                                    <div class="spinner spinnerContinuar spinner-<?= APP_THEME ?> m-auto d-none">
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal cancelar orden de reparación (Individual -- TERMINADO)-->
        <div class="modal fade" id="openModal_cancelarOrden_individual" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Cancelar esta orden de reparación
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="showTable"></div>
                        <form id="formCancelaestaOrden">
                            <div class="row">
                                <div class="col">
                                    <label for="motivo_Cancelacion">Motivo de cancelación</label>
                                    <input type="hidden" name="action" value="CancelarOrdenparticularReparacion">
                                    <input type="hidden" name="idClave" id="idClaveCancelacionIndividual">
                                    <input type="hidden" name="sucursal" value="<?= $dataUss['ciudad'] ?>">
                                    <input type="hidden" name="clave" id="claveModalReparacion">
                                    <textarea name="motivo" id="motivo_Cancelacion" class="form-control" placeholder="Por qué motivo se cancela este equipo de la  orden de reparación?"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <label for="cancelaEstaOrden">&nbsp;&nbsp;</label>
                                    <button class="btn btn-primary" id="cancelaEstaOrden">Cancelar orden</button>
                                    <div class="spinner spinner-<?= APP_THEME ?> m-auto d-none">
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
        <!-- Modal costos de reparación (terminado)-->
        <div class="modal fade" id="openModal_ingresacostos" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" style="max-width: 90%!important;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            <b>Equipos Diagnosticados</b>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="showTable"></div>
                        <form id="formCostosReparacion">
                            <!-- <input type="text" name="action" value="IngresaCostosReparacion"> -->
                            <input type="hidden" name="action" value="IngresarTallerEquipos">
                            <input type="hidden" name="sucursal" value="<?= $sucurUsuarioDf; ?>">
                            <input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idTiendaDf; ?>">

                            <input type="hidden" name="clave" id="claveCostos">
                            <div class="row">
                                <div class="col costos"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <label for="guardaCostos">&nbsp;&nbsp;</label>
                                    <!-- <button class="btn btn-primary" id="guardaCostos">Guardar datos</button> -->
                                    <button class="btn btn-primary" id="IngresarTallerEquipos" data-dismiss="modal">Ingresar Taller Estos Equipos</button>
                                    <div class="spinner spinner-<?= APP_THEME ?> m-auto d-none">
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
        <!-- ------------------------------------------------------------------------------------------ -->
        <!-- Modal ficha de reparaciones-->
        <div class="modal fade" id="openModal_Servicio" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Ficha de soporte técnico
                            <small class="m-0 text-muted">
                                Ingresar las reparaciones realizadas
                            </small>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="agregarReparaciones">
                            <div class="row">
                                <div class="col">
                                    <input type="hidden" name="idServicio" id="idServicioModal">
                                    <input type="hidden" name="action" value="IngresarReparaciones">
                                    <label for="nombreCliente">Nombre</label>
                                    <input type="text" id="nombreCliente" placeholder="Nombre cliente" class="form-control" disabled>
                                </div>
                                <div class="col">
                                    <label for="telefonoCliente">Teléfono</label>
                                    <input type="tel" id="telefonoCliente" class="form-control" placeholder="Teléfono" disabled>
                                </div>

                            </div>
                            <div class="row mt-1">
                                <div class="col">
                                    <label for="celularCliente">Celular </label>
                                    <input type="tel" id="celularCliente" class="form-control" placeholder="Celular" disabled>
                                </div>

                                <div class="col">
                                    <label for="fechaRecibido">Fecha </label>
                                    <input type="date" id="fechaRecibido" class="form-control" disabled>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col">
                                    <label for="maquinaCliente">Maquina </label>
                                    <input type="text" id="maquinaCliente" placeholder="maquinaCliente" class="form-control" disabled>
                                </div>
                                <div class="col">
                                    <label for="marcaCliente">Marca</label>
                                    <input type="text" name="marca" id="marcaCliente" class="form-control" placeholder="Marca" disabled>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col">
                                    <label for="modeloCliente">Modelo</label>
                                    <input type="text" name="modelo" id="modeloCliente" class="form-control" placeholder="Modelo" disabled>
                                </div>
                                <div class="col">
                                    <label for="serieCliente">N&ordm; de serie</label>
                                    <input type="text" name="industria" id="serieCliente" class="form-control" placeholder="Industria" disabled>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col">
                                    <label for="Observaciones">Observaciones </label>
                                    <textarea type="text" id="Observaciones" placeholder="Observaciones" class="form-control" disabled></textarea>
                                </div>
                                <div class="col">
                                    <label for="Trabajo">Trabajo</label>
                                    <textarea type="text" id="Trabajo" class="form-control" placeholder="Trabajo a realizar" disabled></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="trabajoRealizado">trabajo Realizado </label>
                                    <textarea type="text" name="realizado" id="trabajoRealizado" placeholder="describa el trabajo que se realizó" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <button class="btn btn-primary btn-block guardaDetalles">Guardar detalles de
                                        reparación</button>
                                    <div class="spinner spinner-<?= APP_THEME ?> m-auto d-none">
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
        <!-- Modal cancelar toda la odern de reparación (terminado)-->
        <div class="modal fade" id="openModal_cancelarOrden" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Cancelar orden de reparación
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="showTable"></div>
                        <form id="formCancelaOrden">
                            <div class="row">
                                <div class="col">
                                    <label for="motivoCancelacion">Motivo de cancelación</label>
                                    <input type="hidden" name="action" value="CancelarOrdenReparacion">
                                    <input type="hidden" name="idSoporte" id="idSoporteCancelacion">
                                    <textarea name="motivo" id="motivoCancelacion" class="form-control" placeholder="Por qué motivo se cancela la orden de reparación?"></textarea>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <label for="cancelaOrden">&nbsp;&nbsp;</label>
                                    <button class="btn btn-primary" id="cancelaOrden">Cancelar orden</button>
                                    <div class="spinner spinner-<?= APP_THEME ?> m-auto d-none">
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
        <!-- Modal editar ficha re reparación -->
        <div class="modal fade" id="openModal_editServicio" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Ficha de soporte técnico
                            <small class="m-0 text-muted">
                                Edite los campos necesarios
                            </small>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="tablaEquipos"></div>
                        <form id="registrarServicio">
                            <div class="row">
                                <div class="col">
                                    <label for="nombreCliente">Nombre</label>
                                    <input type="hidden" name="action" value="registrarNuevoServicio">
                                    <input type="hidden" name="sucursal" id="sucrsalUsuario">
                                    <input type="hidden" name="claveSoporte" id="claveSoporte">
                                    <input type="text" name="nombre" id="nombreCliente" placeholder="Nombre del cliente" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="telCliente">Celular</label>
                                    <input type="tel" name="celular" id="telCliente" class="form-control" placeholder="Celular">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="equipoNombre">Equipo</label>
                                    <input type="text" name="equipo[]" id="equipoNombre" placeholder="Maquina" class="form-control">
                                </div>
                                <div class="col">
                                    <label for="marcaEquipo">Marca</label>
                                    <input type="text" name="marca[]" id="marcaEquipo" class="form-control" placeholder="Marca">
                                </div>
                                <div class="col">
                                    <label for="modeloEquipo">Modelo</label>
                                    <input type="text" name="modelo[]" id="modeloEquipo" class="form-control" placeholder="Modelo">
                                </div>
                                <div class="col">
                                    <label for="serieEquipo">N&ordm; Serie</label>
                                    <input type="text" name="serie[]" id="serieEquipo" class="form-control" placeholder="N&ordm; de serie">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col">
                                    <label for="problemaEquipo">Problema </label>
                                    <textarea type="text" name="problema[]" id="problemaEquipo" placeholder="Problemas de este equipo" class="form-control"></textarea>
                                </div>
                                <div class="col">
                                    <label for="observacionesEquipo">Observaciones</label>
                                    <textarea type="text" name="observaciones[]" id="observacionesEquipo" class="form-control" placeholder="Observaciones de este equipo"></textarea>
                                </div>
                                <div class="col">
                                    <label for="trabajoRealizar">Realizar</label>
                                    <textarea type="text" name="realizar[]" id="trabajoRealizar" class="form-control" placeholder="Descripción del trabajo a realizar de este equipo"></textarea>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-4 text-center">
                                    <label for="opcionGarantia">Tiene garantía?</label>
                                    <p>
                                        <span class="text-white bg-danger" style="padding: 3px;border-radius: 3px">NO</span>&nbsp;&nbsp;&nbsp;
                                        <input id="opcionGarantia" name="garantia" checked="" type="checkbox" class="js-switch">&nbsp;&nbsp;&nbsp;
                                        <span class="text-white bg-success" style="padding: 3px;border-radius: 3px"> SI
                                        </span>
                                    </p>
                                </div>
                                <div class="col opcionGarantia_div">
                                    <label for="fechaCompra">Fecha compra</label>
                                    <input type="date" name="fechaCompra[]" id="fechaCompra" class="form-control">
                                </div>
                                <div class="col opcionGarantia_div">
                                    <label for="numeroFactura">Factura N&ordm;</label>
                                    <input type="text" name="numeroFactura" id="numeroFactura" class="form-control">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col text-center">
                                    <label for="btnMasCampos">&nbsp;&nbsp;</label>
                                    <button class="btn btn-primary masCampos">Añadir otro equipo</button>
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
                                    <button class="btn btn-primary Continuar">No añadir mas equipos y continuar</button>
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
        <!-- Modal AGREGAR DIAGNOSTICO AL EQUIPO -->
        <div id="modalDiagnosticoEquipo" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg" style="max-width: 90%!important;">
                <div class="modal-content">
                    <!--=====================================
                        CABEZA DEL MODAL 2
                        ======================================-->
                    <div class="modal-header">

                        <h4 class="modal-title">DIAGNOSTICO PARA EL EQUIPO REGISTRADO: <strong><span name="nombreEquipo" id="nombreEquipo"></span></strong> </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <!--=====================================
                        CUERPO DEL MODAL 2
                        ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <input type="hidden" name="sucursal" id="sucursalUsuario" value="<?= $sucurUsuarioDf; ?>">
                            <input type="hidden" name="idSucursal" id="idSucursal" value="<?= $idTiendaDf; ?>">
                            <input type="hidden" name="idClaveEquipo" id="idClaveEquipo" value="" placeholder="idClave Equipo">
                            <div class="row">
                                <div class="form-inline col-md-6">
                                    <label for="garantiaEquipoRepuesto" class="col-md-3">Cuenta con garantía de
                                        repuesto?</label>
                                    <div class="col-md-3">
                                        <input type="text" name="garantiaEquipoRepuesto" id="garantiaEquipoRepuesto" class="form-control col-md-6" style="text-transform:uppercase;" readonly>
                                    </div>
                                    <label for="garantiaEquipoMano" class="col-md-3">Cuenta con
                                        garantía de mano?</label>
                                    <div class="col-md-3">
                                        <input type="text" name="garantiaEquipoMano" id="garantiaEquipoMano" class="form-control col-md-6" style="text-transform:uppercase;" readonly>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="input-group">
                                        <span class="input-group-text">BS</span>
                                        <input type="text" name="costoTotalDiagnostico" id="costoTotalDiagnostico" class="form-control" aria-label="Amount (to the nearest dollar)" readonly>
                                        <span class="input-group-text">COSTO TOTAL DIAGNOSTICO</span>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label for="encargado_diagnostico" class="form-label">Técnico Encargado Diagnostico <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text text-primary"><i class="fa fa-user-md" aria-hidden="true"></i></span>
                                        <input type="text" name="encargado_diagnostico" id="encargado_diagnostico" class="form-control" placeholder="Encargado del diagnostico">
                                        <span class="input-group-text text-primary">ENCARGADO DIAGNOSTICO</span>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <label for="costoReparacionEquipo">1) Costo Asistencia Tecnica - Mano de
                                        obra</label>
                                    <input type="number" name="costoReparacionEquipo" id="costoReparacionEquipo" class="form-control" min="0" value="0" maxlength="8" placeholder="Costo Reparacion Equipo">
                                    <br>
                                    <textarea type="text" name="realizarTrabajo" id="realizarTrabajo" class="form-control" placeholder="Descripción del trabajo a realizar en este equipo"></textarea>
                                </div>

                                <div class="col-6">
                                    <div class="respuestaCostoAsistenciaTecnica">
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-5">

                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col">
                                    <label for="btnActualizarPrecioAsistenciaTecnica"></label>
                                    <button class="btn btn-primary" name="btnActualizarPrecioAsistenciaTecnica" id="btnActualizarPrecioAsistenciaTecnica">
                                        Agregar Costo De Asistencia Tecnica al Diagnostico
                                    </button>
                                    <div class="spinner spinnerMasCampos spinner-<?= APP_THEME ?> m-auto d-none">
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col">
                                    <label for="repuestosBD">2) Agregar Repuesto del sistema [Mercaderia][Nombre][Stock][Precio Venta]
                                    </label>
                                    <select name="repuestosBD" id="repuestosBD" class="form-control">
                                        <option disabled selected value="null">Seleccione Repuesto del Sistema
                                        </option>
                                        <?php
                                        $queryRepuestos = mysqli_query($MySQLi, "SELECT * FROM productos ORDER BY mercaderia ASC , nombre ASC");
                                        // ADD PRECIO DEL DOLAR
                                        $query_precio_dolar = mysqli_query($MySQLi, "SELECT precio FROM preciodolar");
                                        $dataPrecio = mysqli_fetch_assoc($query_precio_dolar);
                                        $precioDolar = $dataPrecio['precio'];

                                        while ($dataProductos = mysqli_fetch_assoc($queryRepuestos)) {

                                            $idProducto = $dataProductos['idProducto'];

                                            $queryInventario = mysqli_query(
                                                $MySQLi,
                                                "SELECT * FROM inventario WHERE idProducto ='$idProducto' AND idTienda ='$idTiendaDf'"
                                            );
                                            $dataInventario = mysqli_fetch_assoc($queryInventario);
                                            $stock = $dataInventario['stock'];

                                            echo "<option value=" . $dataProductos['idProducto'] . "> " .
                                                "[MERCADERIA] " . $dataProductos['mercaderia'] . " " .
                                                "[REPUESTO] " . $dataProductos['nombre'] . " " .
                                                $dataProductos['marca'] . " " .
                                                $dataProductos['modelo'] . " " .
                                                "[STOCK " . $sucurUsuarioDf . "] " . $stock . " " .
                                                "[PRECIO VENTA]  " . $dataProductos['precio'] * $precioDolar . " " .
                                                "</option>";
                                        }
                                        ?>
                                    </select>
                                    <div class="text-danger d-none noSelectProd">No ha seleccionado un
                                        repuesto
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="repuestosBDcantidad">Cantidad Repuesto</label>
                                            <input type="number" name="repuestosBDcantidad" id="repuestosBDcantidad" class="form-control" min="1" value="1" maxlength="8" placeholder="repuestosBDcantidad">
                                        </div>
                                        <div class="col">
                                            <label for="repuestosBDcantidad">Precio Especial/Unidad</label>
                                            <input type="number" name="precioEspecial" id="precioEspecial" class="form-control" min="0" value="0" maxlength="8" placeholder="precioEspecial">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="btnMasRepuestosBD"></label>
                                            <button class="btn btn-primary" name="btnMasRepuestosBD" id="btnMasRepuestosBD">
                                                Agregar Repuesto Al Diagnostico
                                            </button>
                                            <div class="spinner spinnerMasCampos spinner-<?= APP_THEME ?> m-auto d-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="respuestaRepuestosEquipo">
                                    </div>
                                </div>
                            </div>
                            <br>

                            <hr>
                            <div class="row">
                                <div class="col">
                                    <label for="nombreInsumo"> 3) Insumos Externos</label>
                                    <input type="text" name="nombreInsumo" id="nombreInsumo" class="form-control" placeholder="Nombre Insumo">
                                    <div class="row">
                                        <div class="col">
                                            <label for="insumosCantidad">Cantidad Repuesto</label>
                                            <input type="number" name="insumosCantidad" id="insumosCantidad" class="form-control" min="1" value="1" maxlength="8" placeholder="insumosCantidad">
                                        </div>
                                        <div class="col">
                                            <label for="precioInsumo">Precio Especial/Unidad</label>
                                            <input type="number" name="precioInsumo" id="precioInsumo" class="form-control" min="0" value="0" maxlength="8" placeholder="precioInsumo">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="btnMasInsumosBD"></label>
                                            <button class="btn btn-primary" name="btnMasInsumosBD" id="btnMasInsumosBD">
                                                Agregar Insumos Al Diagnostico
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="respuestaInsumosExternos">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <label for="serviciosExternos"> 4) Servicios Externos</label>
                                    <input type="text" name="serviciosExternos" id="serviciosExternos" class="form-control" placeholder="Nombre Servicio Externo">
                                    <div class="row">
                                        <div class="col">
                                            <label for="serviciosCantidad">Cantidad Repuesto</label>
                                            <input type="number" name="serviciosCantidad" id="serviciosCantidad" class="form-control" min="1" value="1" maxlength="8" placeholder="serviciosCantidad">
                                        </div>
                                        <div class="col">
                                            <label for="precioServicioExterno">Precio Especial/Unidad</label>
                                            <input type="number" name="precioServicioExterno" id="precioServicioExterno" class="form-control" min="0" value="0" maxlength="8" placeholder="precioServicioExterno">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="btnMasServiciosExternos"></label>
                                            <button class="btn btn-primary" name="btnMasServiciosExternos" id="btnMasServiciosExternos">
                                                Agregar Servicios Externos Al Diagnostico
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="respuestaServiciosExternos">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <label for="serviciosExternos"> 5) Otros Gastos</label>
                                    <input type="text" name="otrosGastos" id="otrosGastos" class="form-control" placeholder="Nombre otro Gasto">
                                    <div class="row">
                                        <div class="col">
                                            <label for="otrosGastosCantidad">Cantidad</label>
                                            <input type="number" name="otrosGastosCantidad" id="otrosGastosCantidad" class="form-control" min="1" value="1" maxlength="8" placeholder="otrosGastosCantidad">
                                        </div>
                                        <div class="col">
                                            <label for="otrosGastosPrecio">Precio Especial/Unidad</label>
                                            <input type="number" name="otrosGastosPrecio" id="otrosGastosPrecio" class="form-control" min="0" value="0" maxlength="8" placeholder="otrosGastosPrecio">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <label for="btnMasOtrosGastosPrecio"></label>
                                            <button class="btn btn-primary" name="btnMasOtrosGastosPrecio" id="btnMasOtrosGastosPrecio">
                                                Agregar Otros Gastos Al Diagnostico
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="respuestaOtrosGastosPrecio">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <hr>
                        <div class="row mt-3">
                            <div class="col">
                            </div>
                            <div class="col">
                                <button class="btn btn-primary btn-block" name="closeModal" id="closeModal">FINALIZAR DIAGNOSTICO</button>
                            </div>
                            <div class="col">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FIN Modal AGREGAR DIAGNOSTICO AL EQUIPO -->

    </div>
    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script src="assets/js/registrados.js"></script>
</body>

</html>