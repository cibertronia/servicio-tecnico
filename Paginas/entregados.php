<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Equipos entregados - ' . APP_TITLE;
$_active_nav = 'entregados'; ?>
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
                    <h2>Equipos <span class="fw-300"><i> entregados </i></span> &nbsp; &nbsp;del &nbsp; <span class="text-danger"><?= fechaFormato($Inicio) ?></span> &nbsp;al &nbsp; <span class="text-danger"><?= fechaFormato($Fin) ?></span> </h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
                                                                                                                                                                                                                                                                                                                                                            } else { ?>
                    <h2>Equipos <span class="fw-300"><i> entregados </i></span> &nbsp; &nbsp;<?= $mes ?></h2><button class="btn btn-xs btn-primary Buscar"><i class="far fa-search"> Buscar</i></button>&nbsp;&nbsp;<?php
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
                    <form class="w-75 m-auto d-none" id="buscar" action="?root=entregados" method="POST">
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
                            $sucursalVendedor = $sucurUsuarioDf;

                            if (isset($_POST['inicio'])) {
                              if ($idRango == 2) {
                                $Q_Servicio   = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin'AND estado=3  ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              } else {
                                $Q_Servicio   = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$Inicio'AND'$Fin'AND estado=3 AND idSucursal='$idTiendaDf' ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              }
                            } else {
                              if ($idRango == 2) {
                                $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha'AND estado=3 ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              } else {
                                $Q_Servicio = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha'AND estado=3 AND idSucursal='$idTiendaDf' ORDER BY idSoporte DESC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                              }
                            } ?>
                    <table id="listaEntregados" class="table table-bordered table-hover table-sm table-striped w-100" style="font-size: 10px;">
                      <thead>
                        <tr>
                          <th width="5%" class="text-center">N&ordm;</th>
                          <th width="90%" class="text-center">Descripción</th>
                          <th width="5%" class="text-center">Acciones</th>
                        </tr>
                      </thead>
                      <tbody><?php
                              $costoGlobal = 0;
                              $total_Global = 0;
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
                                    <th width="1%" class="text-center">Garantia Repuesto</th>
                                    <th width="1%" class="text-center">Garantia Mano de Obra</th>
                                    <th class="text-center">Fecha Compra</th>
                                    <th width="5%" class="text-center">N&ordm; Nota de Entrega</th>
                                    <th class="text-center">Observaciones</th>
                                  </tr>
                                </thead>
                                <tbody><?php
                                        $Clave    = $dataServicio['clave_soporte'];
                                        $Q_Fichas = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=3 ");
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
                                      <th colspan="1" class="text-center">Trabajo<br>adicional</th>
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
                                          $total_Global = $total_Global + $costoTotalEquipo;
                                        }
                                        echo '
                                    <tr>
                                    <td colspan="7"><b><center>COSTO GLOBAL: ' . $total_Global . ' Bs.</center></b></td>
                                    </tr>';
                                        $total_Global = 0; ?>
                                </tbody>
                              </table>
                              <table>
                                <tr>
                                  <th>Fecha de entrega</th>
                                  <td><?= fechaLetras2($dataServicio['fechaEntrega']) ?></td>
                                </tr>
                                <tr>
                                  <th>¿Quién entregó?</th><?php
                                                          $idUser_entrego = $dataServicio['idUser_entrego'];
                                                          $Q_thisUser     = mysqli_query($MySQLi, "SELECT nombre FROM usuarios WHERE idUser='$idUser_entrego' ");
                                                          $dataUsuario    = mysqli_fetch_assoc($Q_thisUser);  ?>
                                  <td><?= $dataUsuario['nombre'] ?></td>
                                </tr>
                                <tr>
                                  <th>Observaciones</th>
                                  <td><?= $dataServicio['observaciones'] ?></td>
                                </tr>
                              </table>
                            </td>
                            <td class="text-center">
                                <a href="d.php?c=<?php echo $dataServicio['clave_soporte'] . "&r=0"?>" onclick= "return confirm ('Volver a diagnostico?')" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Volver a diagnostico."><i class="far fa-edit"></i></a><br>
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed cancelServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cancelar reparación (<?= $dataServicio['idSoporte'] ?>)"><i class="ni ni-ban"></i></button><br> -->

                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-success btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_editServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar hoja de servicio"><i class="fal fa-pencil"></i></button><br> -->

                              <a target="_blank" href="reportes/reporteRecepcionEntrega.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&servicio=4&Sucursal=<?= $sucursalVendedor ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar detalles de reparación PDF <?= $dataServicio['idSoporte'] ?> <?= $sucursalVendedor ?>"><i class="fal fa-file-pdf"></i></a><br>
                              <a target="_blank" href="reportes/reporteRecepcionEntregaWord.php?idSoporte=<?= $dataServicio['idSoporte'] ?>&servicio=4&Sucursal=<?= $sucursalVendedor ?>" class="mt-2 btn btn-dark btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar detalles de reparación Word <?= $dataServicio['idSoporte'] ?> <?= $sucursalVendedor ?>"><i class="fal fa-file-word"></i></a>
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed openModalServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar detalles de reparaciones realizadas."><i class="far fa-handshake"></i></button><br> -->

                              <!-- <button id="<?= $dataServicio['clave_soporte'] ?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_entregarOrden" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cambiar estado a entregado."><i class="far fa-handshake"></i></button><br> --> <?php

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                //if ($_SESSION['Tipo']=='A') { 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                ?>
                              <!-- <button id="<?= $dataServicio['idSoporte'] ?>" class="mt-2 btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed delServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar hoja de servicio (<?= $dataServicio['idSoporte'] ?>)"><i class="fal fa-trash-alt"></i></button> --> <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          //}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                          ?>

                              <br>
                              <button class="mx-2 btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed btnFacturaModalCargarDatos" title="EMITIR FACTURA <?= $dataServicio['idSoporte'] ?>" data-toggle="modal" data-target="#modalFacturaFR" data-dismiss="modal" id="<?= $dataServicio['idSoporte'] ?>"><i class="fas fa-file-invoice" data-toggle="tooltip" title="" data-original-title="EMITIR FACTURA <?= $dataServicio['idSoporte'] ?>" style="font-size: 15px"></i>
                              </button>
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
  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/entregados.js"></script>
  <!-- Modal FACTURACION PANEL -->
  <div id="modalFacturaFR" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 1250px!important;">
      <div class="modal-content">
        <!--=====================================
                                CABEZA DEL MODAL 2
                                ======================================-->
        <div class="modal-header">
          <h4 class="modal-title">FACTURACION EN LINEA</h4>
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <!--=====================================
                                CUERPO DEL MODAL 2
                                ======================================-->
        <div class="modal-body">
          <div class="box-body">

            <form id="datosFactura">

              <div class="row mt-2">
                <div class="col">
                  <label class="form-label" for="clientReasonSocial">Razón social -
                    Cliente</label>
                  <input type="text" class="form-control" id="clientReasonSocial" name="clientReasonSocial" oninput="actualizarclientCode()" placeholder="RAZON SOCIAL" value="' . $NombreCliente . '">

                </div>
                <div class="col">
                  <label for="clientDocumentType" class="form-label">Tipo de documento
                    -
                    Cliente</label>
                  <select name="clientDocumentType" id="clientDocumentType" class="form-control  data-parsley-required=" true">
                    <option disabled="" selected="">Seleccione
                      Tipo de documento
                    </option>
                    <option value="1">CI - CEDULA DE IDENTIDAD</option>
                    <option value="2">CEX - CEDULA DE IDENTIDAD DE EXTRANJERO
                    </option>
                    <option value="3">PAS - PASAPORTE</option>
                    <option value="4">OD - OTRO DOCUMENTO DE IDENTIDAD</option>
                    <option selected value="5">NIT - NÚMERO DE IDENTIFICACIÓN
                      TRIBUTARIA
                    </option>
                  </select>
                </div>
                <div class="col">
                  <label class="form-label" for="clientNroDocument">Numero Documento -
                    Cliente</label>
                  <input class="form-control" name="clientNroDocument" id="clientNroDocument" value="' . $nitCliente . '">
                </div>
              </div>
              <div class="row mt-2">
                <div class="col">
                  <label for="clientCode" class="form-label">Código de cliente</label>
                  <input type="text" class="form-control" id="clientCode" name="clientCode" placeholder="CODIGO CLIENTE" readonly>
                </div>
                <div class="col">
                  <label for="clientCity" class="form-label">Ciudad Cliente</label>
                  <input type="text" class="form-control" name="clientCity" id="clientCity" value="' . $ciudadCliente . '" placeholder="CIUDAD CLIENTE">
                </div>
                <div class="col">
                  <label for="clientEmail" class="form-label">Email - Cliente</label>
                  <input type="text" class="form-control" name="clientEmail" id="clientEmail" placeholder="EMAIL@EMAIL.COM" value="' . $correoCliente . '">
                </div>
              </div>
              <div class="row mt-2">
                <div class="col">
                  <label for="userPos" class="form-label">Vendedor</label>
                  <input type="text" readonly class="form-control" name="userPos" id="userPos" autofocus placeholder="VENDEDOR EN TURNO" value="' . $nombreVendedor . '">
                </div>
                <div class="col">
                  <label for="paramCurrency" class="form-label">Tipo de moneda</label>
                  <select name="paramCurrency" id="paramCurrency" class="form-control" data-parsley-required="true">
                    <option selected value="1">BOLIVIANO</option>
                  </select>
                </div>
                <div class="col">
                  <label for="paramPaymentMethod" class="form-label">Metodo de
                    pago</label>
                  <select name="paramPaymentMethod" id="paramPaymentMethod" class="form-control  data-parsley-required=" true">
                    <option disabled="" selected="">Seleccione
                      Metodo De Pago
                    </option>

                    <option selected value="1"> EFECTIVO</option>
                    <option value="3"> CHEQUE</option>
                    <option value="4"> VALES</option>
                    <option value="5"> OTROS</option>
                    <option value="7"> TRANSFERENCIA BANCARIA</option>
                    <option value="8"> DEPOSITO EN CUENTA</option>
                  </select>
                </div>
              </div>
              <div class="row mt-2">
              </div>
              <div class="row mt-2">
                <div class="col">
                  <input name="tipo_venta" id="tipo_venta" type="hidden" value="servicio_tecnico">
                  <input name="branchIdName" id="branchIdName" type="hidden" value="">
                  <input name="idCotizacion" id="idCotizacion" type="hidden" value="">
                </div>
              </div>
              <div class="row mt-2 infoProducto">
                <div class="col-md-9">
                  <label for="ClienteProducto">PRODUCTOS FISCALES <span class="text-info">(
                      *
                      )</span></label>
                  <select name="Producto" id="ClienteProducto" onchange="actualizarclientCode();" class="form-control">
                    <option disabled selected>Seleccione producto</option>
                    <?php
                    include 'includes/conexion_yuli_ventas.php';
                    $queryProd = mysqli_query($MySQLi, "SELECT * FROM productos_fiscales WHERE saldo_fisico > 0 ORDER BY fecha_poliza");
                    while ($dataProd = mysqli_fetch_assoc($queryProd)) {
                      echo "<option value=" . $dataProd['idProducto'] . ">" . $dataProd['fecha_poliza'] . " " . $dataProd['detalle'] . " " . $dataProd['codigo'] . " SaldoFisico[" . $dataProd['saldo_fisico'] . "]" . "</option>";
                    }
                    mysqli_close($MySQLi);
                    ?>
                  </select>
                  <div class="text-danger d-none noSelectProd">No ha seleccionado un
                    producto
                  </div>
                </div>
                <div class="col-md-3">
                  <br><br>
                  <button title="Agregar producto fiscal a la factura" type="button" class="btn btn-xs btn-info Add_ProductoEmision d-none PreciosProductoSelected"><i class="fa fa-plus"></i> &nbsp;&nbsp;AGREGAR PRODUCTO FISCAL
                    A LA
                    FACTURA &nbsp;<i class="fas fa-spinner fa-pulse d-none efectAddProduct"></i></button>
                </div>
              </div>
              <div class="row mt-2 d-none PreciosProductoSelected">
                <div class="col-md-3 d-none  PreciosProductoSelected text-center">
                  <label for="idProducto"><strong>ID PRODUCTO</strong></label>
                  <input type="text" id="idProducto" class="form-control text-center" disabled>
                </div>
                <div class="col-md-3 d-none  PreciosProductoSelected text-center">
                  <label for="fecha_poliza"><strong>FECHA POLIZA</strong></label>
                  <input type="text" id="fecha_poliza" class="form-control text-center" disabled>
                </div>
                <div class="col-md-3 d-none  PreciosProductoSelected text-center">
                  <label for="codigo"><strong>CODIGO</strong></label>
                  <input type="text" id="codigo" class="form-control text-center" disabled>
                </div>
                <div class="col-md-3 d-none">
                  <label for="detalle"><strong>DETALLE</strong></label>
                  <input type="hidden" id="detalle" class="form-control text-center" disabled>
                </div>
                <div class="col-md-3 d-none PreciosProductoSelected text-center">
                  <label for="ProdExistenciaCB"><strong>SALDO FISICO (STOCK)
                    </strong></label>
                  <input type="text" id="ProdExistenciaCB" class="form-control text-center" disabled>
                </div>
              </div>
              <div class="row mt-2 d-none PreciosProductoSelected">
                <div class="col">
                  <label for="PrecioLista"><strong>C/U PARA FACTURAR
                      MINIMO</strong></label>
                  <input type="text" name="PrecioLista" id="PrecioLista" class="form-control" placeholder="Precio de Lista" disabled>
                </div>

                <div class="col">
                  <label for="PrecioEspecial"><strong>IMPORTES PARA FACTURAR </label>
                  <input type="text" name="PrecioEspecial" id="PrecioEspecial" class="form-control" placeholder="Precio Especial" disabled>
                  <div class="text-danger d-none emptyPrecioEsp">No ha indicado el
                    precio
                    especial
                  </div>
                </div>
                <div class="col">
                  <label for="CantidadProducto"><strong>CANTIDAD</strong></label>
                  <input type="number" name="Cantidad" id="CantidadProducto" class="form-control">
                  <div class="text-danger d-none CantidadEmpty">La cantidad no puede
                    ser
                    negativa, nulo o mayor al Stock</div>
                </div>
              </div>
              <div class="row mt-4">
                <div class="col">Información: <br>
                  Los productos en la tabla de color <span style="color:aqua;">CELESTE</span>
                  son considerados productos_fiscales y afectan el stock de estos
                  mismos al
                  momento de realizar la facturación.
                </div>
              </div>
              <div class="row mt-4">
                <div class="col">
                  <table id="tableProductosVendidos" class="table" width="100%">
                    <!-- aki se llena con js la tabla -->
                  </table>
                </div>
              </div>

              <div class="row mt-4">
                <div class="col">
                  <button id="submitButton" class="btn btn-primary btn-block facturarSintic" type="button">
                    <h4>Facturar</h4><i class="fas d-none efectSaveCotiza fa-spinner fa-pulse"></i>
                  </button>
                </div>

              </div>



          </div>
          <div class="row mt-4">
            <div class="col">
              <div class="respuestaFactura text-center h1 text-success"></div>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>