<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Equipos reparados - ' . APP_TITLE;
$_active_nav = 'equiposListos'; ?>
<!DOCTYPE html>
<html lang="es"><?php
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
          <?php
          // if ($_SESSION['idRango'] == 4) {
          if (false) {
              echo error403();
          } else {
          ?>
          <div class="row">
            <div class="respuesta"></div>
            <div class="col">
              <div id="cotGeneradas_lista" class="panel">
                <div class="panel-hdr"><?php
                                        if (isset($_POST['inicio'])) {
                                          $Inicio     = $_POST['inicio'];
                                          $Fin        = $_POST['fin']; ?>
                    <h2>Equipos <span class="fw-300"><i> reparados </i></span> &nbsp; &nbsp;del &nbsp; <span class="text-danger"><?= fechaFormato($Inicio) ?></span> &nbsp;al &nbsp; <span class="text-danger"><?= fechaFormato($Fin) ?></span> </h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                          } else { ?>
                    <h2>Equipos <span class="fw-300"><i> reparados </i></span> &nbsp; &nbsp;<?= $mes ?></h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
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
                    <form class="w-75 m-auto d-none" id="buscar" action="?root=reparados" method="POST">
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
                            $sucursalVendedor = $sucurUsuarioDf;
                            if (isset($_POST['inicio'])) {
                              if ($idRango == 2) {
                                $Q_Servicio   = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin'AND estado=2 ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              } else {
                                $Q_Servicio   = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin'AND estado=2 AND idSucursal='$idTiendaDf' ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              }
                            } else {
                              if ($idRango == 2) {
                                $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha'AND estado=2 ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              } else {
                                $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha'AND estado=2 AND idSucursal='$idTiendaDf' ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              }
                            }  ?>
                    <table id="listaReparados" class="table table-bordered table-hover table-sm table-striped w-100" style="font-size: 10px;">
                      <thead>
                        <tr>
                          <th width="5%" class="text-center">N&ordm;</th>
                          <th width="90%" class="text-center">Descripción</th>
                          <th width="5%" class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody><?php
                              $costoGlobal = 0;
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
                                  <th class="btn-secondary">Fecha de recepcion</th>
                                  <td><?= fechaLetras2($dataServicio['fechaRegistro']) ?></td>
                                </tr>
                                <tr>
                                  <th class="btn-dark">Fecha de reparacion</th>
                                  <td><?= fechaLetras2($dataServicio['fechaReparacion']) ?></td>
                                </tr>
                                <tr>
                                  <th class="btn-warning">Dirección en la cual se realizó el Servicio Técnico</th>
                                  <td><?= $dataServicio['direccion'] ?></td>
                                </tr>
                                <tr>
                                  <th class="btn-info">Sucursal Encargada</th>
                                  <td><?= $dataServicio['sucursal'] ?></td>
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
                                    <th class="text-center">Observaciones</th>
                                  </tr>
                                </thead>
                                <tbody><?php
                                        $Clave    = $dataServicio['clave_soporte'];
                                        $Q_Fichas = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=2 ");
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
                                          $totalDiagnostico = $dataRepuestos['totalDiagnosticoRepuestos'] +  $costo;
                                          $costoTotalEquipo = $totalDiagnostico +  $dataFichas['costoAdicional'];
                                          $costoGlobal = $costoGlobal + $costoTotalEquipo;
                                          echo '
                                   <tr>
                                     <td>[Nombre] ' . $dataFichas['equipo'] . '<br>[Marca] ' . $dataFichas['marca'] . '<br>[Modelo] ' . $dataFichas['modelo'] . '</td>
                                     <td>' . $dataFichas['serie'] . '</td>
                                     <td>' . $dataFichas['garantia_vigente_repuesto'] . '</td>
                                     <td>' . $dataFichas['garantia_vigente_mano'] . '</td>
                                     <td>' . $dataFichas['fechaCompra'] . '</td>
                                     <td class="text-center">' . $dataFichas['notaEntrega'] . '</td>
                                     <td>' . $dataFichas['observaciones'] . '</td>
                                   </tr>
                                   <tr>
                                     <th colspan="1" class="text-center">Problema</th>
                                     <th colspan="2" class="text-center">Trabajo a<br>realizar</th>
                                     <th class="text-center">Costo<br>Repuestos</th>
                                     <th class="text-center">Costo<br>Mano de Obra</th>
                                     <th colspan="1" class="text-center">Trabajo<br>Adicional</th>
                                     <th class="text-center">Precio<br>adicional</th>
                                   </tr>
                                   <tr>
                                     <td colspan="1">' . $dataFichas['problema'] . '</td>
                                     <td colspan="2">' . $dataFichas['realizar'] . '</td>
                                     <td>' . $dataRepuestos['totalDiagnosticoRepuestos'] . ' Bs.</td>
                                     <td colspan="1">' . $costo . ' Bs.</td>
                                     <td colspan="1">' . $dataFichas['trabajoRealizado'] . '</td>
                                     <td style="text-align: right;">' . number_format($dataFichas['costoAdicional'], 2) . ' Bs.</td>
                                   </tr> 
                                   <tr>
                                   <td colspan="1"></td>
                                   <td colspan="2"></td>
                                   <td style="text-align: right;"></td>
                                   <th colspan="2" class="text-center">Costo Total Equipo:</td>
                                   <td style="text-align: right;">' . $costoTotalEquipo . ' Bs.</td>
                                   </tr>';
                                        }
                                        echo '
                                   <tr class="thead-dark">
                                   <td colspan="7"><b><center>COSTO GLOBAL: ' . $costoGlobal . ' Bs.</center></b></td>
                                   </tr>';
                                        $costoGlobal = 0; ?>
                                </tbody>
                              </table>
                            </td>
                            <td class="text-center">
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed cancelServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cancelar reparación (<?= $dataServicio['idSoporte'] ?>)"><i class="ni ni-ban"></i></button><br> -->

                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-success btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_editServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar hoja de servicio"><i class="fal fa-pencil"></i></button><br> -->

                              <!-- <a href="hojadeservicio.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&servicio=2&Sucursal=<?= $sucursalVendedor ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar detalles de reparación"><i class="fal fa-file-pdf"></i></a><br> -->

                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed openModalServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar detalles de reparaciones realizadas."><i class="far fa-handshake"></i></button><br> -->

                                <a href="d.php?c=<?php echo $dataServicio['clave_soporte'] . "&r=1"?>" onclick= "return confirm ('Volver a reparacion?')" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Volver a reparación."><i class="far fa-edit"></i></a><br>
                                
                              <button id="<?= $dataServicio['clave_soporte'] ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_entregarOrden" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cambiar estado a entregado."><i class="far fa-handshake"></i></button><br>
                              <a target="_blank" href="reportes/reporteImprimirReparadoWord.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&servicio=4&Sucursal=<?= $sucursalVendedor ?>" class="mt-2 btn btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar en Word <?= $dataServicio['idSoporte'] ?>"><i class="fal fa-file-word"></i></a>

                              <?php

                                //if ($_SESSION['Tipo']=='A') { 
                              ?>
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed delServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar hoja de servicio (<?= $dataServicio['idSoporte'] ?>)"><i class="fal fa-trash-alt"></i></button> --> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          //}
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
          <?php } ?>
        </main><?php
                include_once APP_PATH . '/includes/footer.php'; ?>
      </div>
    </div>
    <!-- Modal entregar orden de equipo reparado-->
    <div class="modal fade" id="openModal_entregarOrden" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">
              Ficha de entrega de reparación
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true"><i class="fal fa-times"></i></span>
            </button>
          </div>
          <div class="modal-body">
            <form id="EntregarOrdendeEquipo">
              <div class="row mb-2">
                <div class="col">
                  <input type="hidden" name="clave" id="claveModalEntrega">
                  <input type="hidden" name="idUser" value="<?= $_SESSION['idUser'] ?>">
                  <input type="hidden" name="action" value="EntregarOrdendeEquipo">
                  <input type="hidden" name="sucursal" id="sucursalOrden">
                  <label for="descripcionEntrega">¿Algun dato relevante?</label>
                  <textarea name="descripcion" id="descripcionEntrega" class="form-control" placeholder="Ingrese algún dato, detalle o información que sea relevante, si no existe nada relevante, favor dejar en blanco y proceder a entregar."></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <button class="btn btn-primary btn-block entregaOrden">Proceder a entregar</button>
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
  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
  <script src="assets/js/reparados.js"></script>
</body>

</html>