<?php
error_reporting(0);
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Equipos en reparación - ' . APP_TITLE;
$_active_nav = 'enreparacion'; ?>
<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="assets/sweetchery/sweetchery.css"><?php
                                                                include_once APP_PATH . '/includes/head.php';
                                                                include_once APP_PATH . '/includes/funciones.php';  ?>

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
              <div id="cotGeneradas_lista" class="panel">
                <div class="panel-hdr"><?php
                                        if (isset($_POST['inicio'])) {
                                          $Inicio     = $_POST['inicio'];
                                          $Fin        = $_POST['fin']; ?>
                    <h2>Equipos <span class="fw-300"><i> en Reparación </i></span> &nbsp; &nbsp;del &nbsp; <span class="text-danger"><?= fechaFormato($Inicio) ?></span> &nbsp;al &nbsp; <span class="text-danger"><?= fechaFormato($Fin) ?></span> </h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                              } else { ?>
                    <h2>Equipos <span class="fw-300"><i> en Reparación </i></span> &nbsp; &nbsp;<?= $mes ?></h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
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
                    <form class="w-75 m-auto d-none" id="buscar" action="?root=enReparacion" method="POST">
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
                            //   $dataBase = "soporte_cba";
                            // }else{
                            //   $dataBase = "soporte_stc";
                            // }
                            if (isset($_POST['inicio'])) {
                              if ($idRango == 2) { //rango 2 es admin
                                $Q_Servicio   = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin'AND estado=1 ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              } else {
                                $Q_Servicio   = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin'AND estado=1  AND idSucursal='$idTiendaDf' ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              }
                            } else {
                              if ($idRango == 2) { //rango 2 es admin
                                $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha'AND estado=1  ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              } else {
                                $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha'AND estado=1  AND idSucursal='$idTiendaDf' ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              }
                            }  ?>
                    <table id="listaenReparacion" class="table table-bordered table-hover table-sm table-striped w-100" style="font-size: 10px;">
                      <thead>
                        <tr>
                          <th width="5%" class="text-center">N&ordm;</th>
                          <th width="90%" class="text-center">Descripción</th>
                          <th width="5%" class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody><?php
                              while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) { ?>
                          <tr>
                            <td class="text-center pt-4"><?= $dataServicio['idSoporte'] ?></td>
                            <td>
                              <table>
                                <tr>
                                  <th class="btn-primary">Nombre Cliente</th>
                                  <td><?= $dataServicio['nombreCliente'] ?></td>
                                </tr>
                                <tr>
                                  <th class="btn-secondary">Fecha de registro</th>
                                  <td><?= fechaLetras2($dataServicio['fechaRegistro']) ?></td>
                                </tr>
                                <tr>
                                  <th class="btn-warning">Dirección en la cual se esta realizando el Servicio Técnico</th>
                                  <td><?= $dataServicio['direccion'] ?></td>
                                </tr>
                                <tr>
                                  <th class="btn-info">Sucursal Encargada</th>
                                  <td><?= $dataServicio['sucursal'] ?><input type="hidden" id="sucursalRegistro" value="<?= $dataServicio['sucursal'] ?>"></td>
                                </tr>
                              </table>
                              <table class="table table-bordered table-hover table-sm table-striped w-100">
                                <thead>
                                  <tr>
                                    <th class="text-center">Equipo</th>
                                    <th class="text-center">Serie</th>
                                    <th class="text-center">Garantia Repuesto</th>
                                    <th class="text-center">Garantia Mano</th>
                                    <th class="text-center">Fecha Compra</th>
                                    <th class="text-center">N&ordm; de Nota de Entrega</th>
                                    <th class="text-center">Problema</th>
                                    <th class="text-center">Observaciones</th>
                                    <th class="text-center">Realizar</th>
                                    <th class="text-center">Costo Repuestos</th>
                                    <th class="text-center">Costo Mano de Obra</th>
                                    <th class="text-center">Costo Total</th>
                                  </tr>
                                </thead>
                                <tbody><?php
                                        $Clave    = $dataServicio['clave_soporte'];
                                        $Q_Fichas = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=1 ");
                                        while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) {
                                          $Clave    = $dataFichas['idClave'];
                                          $queryRepuestosEquipo = mysqli_query(
                                            $MySQLi,
                                            "SELECT
                                         SUM(`cantidad`*`precioEspecial`) totalDiagnosticoRepuestos
                                         FROM soporte_claves_repuestos
                                         WHERE `idClave`='$Clave'"
                                          );
                                          $dataRepuestos = mysqli_fetch_assoc($queryRepuestosEquipo);

                                          $queryManoObra = mysqli_query($MySQLi, "SELECT costo FROM soporte_claves WHERE idClave='$Clave' ");
                                          $costoManoObra = mysqli_fetch_assoc($queryManoObra);
                                          if ($costoManoObra['costo'] == null) {
                                            $costo = 0;
                                          } else {
                                            $costo = $costoManoObra['costo'];
                                          }
                                          $totalDiagnostico = $dataRepuestos['totalDiagnosticoRepuestos'] + $costo;
                                          echo '
                                 <tr>
                                   <td>[Nombre] ' . $dataFichas['equipo'] . '<br>[Marca] ' . $dataFichas['marca'] . '<br>[Modelo] ' . $dataFichas['modelo'] . '</td>
                                   <td>' . $dataFichas['serie'] . '</td>
                                   <td>' . $dataFichas['garantia_vigente_repuesto'] . '</td>
                                   <td>' . $dataFichas['garantia_vigente_mano'] . '</td>
                                   <td>' . $dataFichas['fechaCompra'] . '</td>
                                   <td class="text-center">' . $dataFichas['notaEntrega'] . '</td>
                                   <td>' . $dataFichas['problema'] . '</td>
                                   <td>' . $dataFichas['observaciones'] . '</td>
                                   <td>' . $dataFichas['realizar'] . '</td>
                                   <td>' . $dataRepuestos['totalDiagnosticoRepuestos'] . ' Bs.</td>
                                   <td>' . $costo . ' Bs.</td>
                                   <td style="text-align: right;">' . $totalDiagnostico . ' Bs.</td>
                                   </tr>';
                                        } ?>
                                </tbody>
                              </table>
                            </td>
                            <td class="text-center">
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed cancelServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cancelar reparación (<?= $dataServicio['idSoporte'] ?>)"><i class="ni ni-ban"></i></button><br> -->

                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-success btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_editServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar hoja de servicio"><i class="fal fa-pencil"></i></button><br> -->

                              <!-- <a href="hojadeservicio.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&servicio=3&Sucursal=<?= $sucursalVendedor ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar hoja de servicio en PDF"><i class="fal fa-file-pdf"></i></a><br> -->

                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed openModalServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar detalles de reparaciones realizadas."><i class="far fa-handshake"></i></button><br> -->

                              <button id="<?= $dataServicio['clave_soporte'] ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_ingresaDetalles" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Insertar detalles de la reparación."><i class="far fa-handshake"></i></button><br>
                              <a href="d.php?c=<?php echo $dataServicio['clave_soporte'] ?>" onclick= "return confirm ('Volver a diagnostico?')" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Volver a diagnostico."><i class="far fa-edit"></i></a><br>
                              <?php

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                // if ($_SESSION['Tipo']=='A') { 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?>
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed delServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar hoja de servicio (<?= $dataServicio['idSoporte'] ?>)"><i class="fal fa-trash-alt"></i></button> --> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          // }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          ?>
                            </td>
                          </tr><?php
                              } ?>
                      </tbody>
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
                  <button class="btn btn-primary btn-block guardaDetalles">Guardar detalles de reparación</button>
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
                    <span class="text-white bg-success" style="padding: 3px;border-radius: 3px"> SI </span>
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
    <!-- Modal insertar detalles de la reparación -->
    <div class="modal fade" id="openModal_ingresaDetalles" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              TRABAJO ADICIONAL Y COSTO ADICIONAL
              <small class="text-danger">NO DEJE LOS CAMPOS VACIOS O SE GUARDARAN COMO TAL.</small>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fal fa-times"></i></span>
            </button>
          </div>
          <div class="modal-body">
            <form id="detallesRep">
              <input type="hidden" name="action" value="GuardarDetallesdeReparacion">
              <input type="hidden" name="clave" id="claveModalDetalles">
              <input type="hidden" name="sucursal" id="sucursalSoporte_add">
              <div id="detalles"></div>
              <div class="row text-center">
                <div class="col">
                  <button class="btn btn-primary guardaDetalles">Guardar detalles</button>
                  <div class="spinner spinnerDetalles spinner-<?= APP_THEME ?> m-auto d-none">
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
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/sweetchery/sweetchery.js"></script>
  <script src="assets/js/enReparacion.js"></script>
</body>

</html>