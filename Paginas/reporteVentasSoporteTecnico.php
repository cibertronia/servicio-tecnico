<?php
error_reporting(0);
require_once 'init.php';
$_title = 'Reporte Ventas - ' . APP_TITLE;
$_active_nav = 'reporteVentas'; 

// estados de servicios para selector
$estados = [
  0 => 'Diagnostico',
  1 => 'En Reparación',
  2 => 'Reparados',
  3 => 'Entregados',
  4 => 'Cancelados'
]
?>
<!DOCTYPE html>
<html lang="es"><?php
                include_once APP_PATH . '/includes/head.php'; ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?> "><?php
                                                include_once APP_PATH . '/includes/theme.php'; ?>
  <div class="page-wrapper">
    <div class="page-inner"><?php
                            include_once APP_PATH . '/includes/nav.php'; ?>
      <div class="page-content-wrapper"><?php
                                        include_once APP_PATH . '/includes/header.php'; ?>
        <main id="js-page-content" role="main" class="page-content">
          <ol class="breadcrumb page-breadcrumb">
            <li class="position-absolute pos-top pos-right d-none d-sm-block text-danger"><?= $Fecha ?></li>
          </ol>
          <div id="panel-1" class="panel">
            <div class="panel-hdr"><?php
                                    if (isset($_POST['inicio'])) {
                                      $Inicio     = $_POST['inicio'];
                                      $Fin        = $_POST['fin'];
                                      
                                      $tipob = $_POST['tipob'];
                                      $estado = $_POST['estado'];
                                    } else {
                                      $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                                      $Fin = $fecha; //fecha = hoy
                                      $tipob = '2';
                                      $estado = 3;
                                    }
                                    ?>
              <h2>REPORTE <?php echo ($tipob == '1' ? 'VENTAS' : 'SERVICIOS' ) ?> <span class="fw-300"><i><span class="text-danger"><?= fechaFormato($Inicio) ?></span> - <span class="text-danger"><?= fechaFormato($Fin) ?></span></i></span></h2>

              <div class="panel-toolbar">
                <button type="button" class="btn btn-xs btn-primary Buscar"><i class="far fa-search"></i></button>
                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
              </div>
            </div>
            <div class="panel-container">
              <div class="respuesta"></div>
              <div class="panel-content">
                <form class="" id="buscar" action="?root=reporteVentasSoporteTecnico" method="POST">
                  <div class="row mb-2 my-2">
                    <div class="col-sm-12 col-md-4 col-lg-3">
                      <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                      <input type="hidden" name="idTienda" value="<?php echo $idTiendaDf ?>">
                      <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $Inicio ?>" data-parsley-required="true">
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-3">
                      <label for="fechaFin" class="form-label">Fecha final</label>
                      <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $Fin ?>" data-parsley-required="true">
                    </div>
                    <!-- Estados de servicio -->
                    <div class="col col-lg-3">
                      <label for="estado">Estado del servicio</label>
                      <select name="estado" id="estado" class="form-control">
                        <?php
                        foreach ($estados as $key => $value) {
                          if ($key == $estado) {
                            echo '<option value="' . $key . '" selected>' . $value . '</option>';
                          } else {
                            echo '<option value="' . $key . '">' . $value . '</option>';
                          }
                        }
                        ?>
                      </select>
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-3">
                      <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                      <button class="btn btn-primary btn-block btn-Busca ">Buscar</button>
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-3">
                      <label for="tipob">&nbsp;&nbsp;&nbsp;</label>
                      <input type="hidden" name="tipob" id="tipob" value="2">
                      <?php  $s="//<select name=tipob id=tipob class=form-control>";
                          $s="//<opt7ion value=1 <php if ($tipob == '1') echo('selected');  > >Ventas</option>";
                          $s="//<option  value=2 <php if ($tipob == '2') echo('selected'); >>Servicios</option>";
                         $s="//</select>";
                         ?>
                    </div>  
                  </div>
                </form>
                <table id="listamisVentas2" class="table table-bordered table-hover table-striped w-100">
                  <thead>
                    <tr>
                      <th class="text-center">N&ordm;</th>
                      <th class="text-center">SUCURSAL</th>
                      <th width="30%" class="text-center">EXCEL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    /*$sql_rango = "SELECT idRango FROM `usuarios` WHERE idUser='$idUser'";
                    $data_rango = mysqli_query($MySQLi, $sql_rango);
                    $filaRango = mysqli_fetch_assoc($data_rango);
                    $idRangoDf = $filaRango['idRango'];
                    */
                    $sql_sucursales = $idRangoDf == 1 ? "SELECT * FROM `sucursales` WHERE estado='1' AND idTienda='$idTiendaDf'" : "SELECT * FROM `sucursales` WHERE estado='1'";
                    $data_sucursales = mysqli_query($MySQLi, $sql_sucursales);
                    $nro = 1;
                    while ($fila = mysqli_fetch_assoc($data_sucursales)) {
                      echo '<tr>';
                      echo '<td class="text-center">' . $nro . '</td>';
                      echo '<td class="text-center">' . $fila['sucursal'] . '</td>';
                      echo '<td class="text-center">
                        <div class="row">
                          <div class="col">
                            <a class="btn btn-sm btn-block" style="background-color:#4FC23D" href="reportes/reporteVentasSoporte.php?excel_ventas_soporte=true&id_sucursal=' . $fila['idTienda'] . '&Inicio=' . $Inicio . '&Fin=' . $Fin . '&tipob=' . $tipob. '&id_user=' . $idUser . '&estado=' . $estado .'" title="Historial todos los Productos Fiscales en rango de fechas"><span style="color: white">DESCARGAR</span>&nbsp;&nbsp;
                              <i class="fa fa-download" style="color: white"></i>
                            </a>
                          </div>
                        </div>';
                      echo '
                      </td>';
                      echo '</tr>';
                      $nro++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div id="content" class="content">
                  <div class="panel-content">
                    <hr>
                    <h5>VENTAS REPUESTOS</h5>
                    <hr>
                    <table id="listamisVentas" class="table table-bordered table-hover table-striped w-100">
                      <thead>
                        <tr>
                          <th width="3%" class="text-center"><?php  ?>_Nº</th>
                          <th width="3%" class="text-center">Sucursal</th>
                          <th width="5%" class="text-center">Fecha Recepcion Servicio Técnico</th>
                          <!-- <th width="5%" class="text-center">Fecha Nota Entrega</th> -->
                          <th width="5%" class="text-center">Nº Ingreso/Cotizacion</th>
                          <!-- <th width="5%" class="text-center">Nº Nota Entrega de la venta de la maquina</th> -->
                          <th width="5%" class="text-center">Número Factura</th>

                          <!-- <th width="5%" class="text-center">Garantia: Repuestos - Mano De Obra</th> -->
                          <th width="5%" class="text-center">Nº Nombre Cliente/Numero Cel</th>
                          <!-- <th width="5%" class="text-center">Nombre Maquina/Marca/Modelo</th> -->
                          <th width="5%" class="text-center">Nombre de repuesto</th>
                          <th width="5%" class="text-center">Lista de Precio Repuesto BS</th>

                          <th width="5%" class="text-center">Cantidad Repuestos</th>
                          <th width="5%" class="text-center">Cobro Repuestos/Lista Bs</th>
                          <!-- <th width="5%" class="text-center">Cobro/Insumos Extras Bs</th> -->
                          <!-- <th width="5%" class="text-center">Cobro/Servicios Externos Bs</th> -->
                          <!-- <th width="5%" class="text-center">Cobro/Otros Gastos Bs</th> -->

                          <!-- <th width="5%" class="text-center">Cobro Mano de Obra BS</th> -->
                          <!-- <th width="5%" class="text-center">Costo Adicional BS</th> -->
                          <th width="5%" class="text-center">TOTAL A COBRAR BS</th>
                          <th width="5%" class="text-center">Importe Facturado</th>
                          <th width="5%" class="text-center">Nombre Tecnico</th>

                          <th width="5%" class="text-center">Descripción</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $Num = 1;

                        $total_precio_lista = 0;
                        $total_cantidad = 0;
                        $total_precio_venta = 0;
                        $total_venta = 0;
                        $total_importe_facturado = 0;
                        //$sql = $idRangoDf == 1 ? "SELECT sv.* FROM soporte_ventas sv inner join cotizaciones cot on sv.idCotizacion = cot.idCotizacion and cot.idUser = '$idUser' WHERE (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') ORDER BY fecha_recepcion ASC" : "SELECT *  FROM soporte_ventas WHERE (fecha_completado BETWEEN '$Inicio' AND '$Fin') ORDER BY fecha_recepcion ASC";
                        if ($idRangoDf == 2)                                                                             //  id_sucursal='$id_sucursal' and
                          $sql = "SELECT sv.*  FROM soporte_ventas sv 
                          left  join soporte_sucursales sopsuc on sopsuc.idSoporte = sv.idSoporte  
                          WHERE  (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') AND
                          sv.nro_servicio_recepcion <> '0' and sopsuc.estado = '$estado' ORDER BY sv.fecha_completado ASC ";
                        elseif ($idRangoDf == 1 || $idRangoDf == 4)                                                                        // id_sucursal='$id_sucursal' and
                          $sql = "SELECT sv.*  FROM soporte_ventas sv 
                          left  join soporte_sucursales sopsuc on sopsuc.idSoporte = sv.idSoporte  
                          WHERE   (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') AND
                          sopsuc.estado = '$estado' and (sv.id_user='$idUser' or sv.id_user_entrego = '$idUser')   and sv.nro_servicio_recepcion <> '0' ORDER BY sv.fecha_completado ASC";                            
                                
                        // $sql = "SELECT *  FROM soporte_ventas WHERE (fecha_completado BETWEEN '$Inicio' AND '$Fin') AND id_sucursal='$idTiendaDf'  ORDER BY fecha_recepcion ASC ";
                        $resultado = mysqli_query($MySQLi, $sql);
                        while ($fila = mysqli_fetch_assoc($resultado)) {
                          //dividir ventas directo y si si corresponde servicio llenar de otra forma
                          $idCotizacion = (int) $fila['idCotizacion'];
                          $idSoporte = $fila['idSoporte'];

                          $id_sucursal = $fila['id_sucursal'];
                          $q_sucursales = mysqli_query($MySQLi, "SELECT sucursal FROM sucursales WHERE idTienda='$id_sucursal'AND estado=1");
                          $d_sucursales = mysqli_fetch_assoc($q_sucursales);
                          $nombre_sucursal = $d_sucursales['sucursal'];

                          $ex_nombre_maquinas = $fila['nombre_maquinas'];
                          $ex_total_cobrar_bs = $fila['total_cobrar_bs'];
                          $ex_descripcion_reparacion = $fila['descripcion_reparacion'];
                          // 1  caso que sea de cotizacion
                           if ($tipob == '2') {
                            // A
                            $fecha_recepcion = ($fila['fecha_recepcion']);
                            // B
                            // C
                            $nro_servicio_recepcion = ($fila['nro_servicio_recepcion']); //2
                            // E
                            $invoice_number = ($fila['invoice_number']); //3
                            // G
                            $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte'");
                            $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
                            $telefono_cliente = $d_soporte_sucursales['telCliente'];
                            $nombre_cliente = $fila['nombre_cliente'] . "\n" . $telefono_cliente; //4
                            //R
                            $total_cobrar_bs = ($fila['total_cobrar_bs']); //multiplicar 
                            //S
                            $importe_facturado = ($fila['importe_facturado']);
                            //T
                            $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte' AND estado=3");
                            $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
                            $tecnico_cadena = $d_soporte_sucursales['encargado_diagnostico'];

                            //1er Ficha Tecnica
                            $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte' AND estado=3");
                            $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
                            $clave_soporte = $d_soporte_sucursales['clave_soporte'];
                            //2do Equipos Registrados
                            $q_soporte_claves = mysqli_query($MySQLi, "SELECT * FROM `soporte_claves` WHERE `clave`='$clave_soporte' AND estado=3");
                            while ($d_soporte_claves = mysqli_fetch_assoc($q_soporte_claves)) {
                              //D
                              $notaEntrega = $d_soporte_claves['notaEntrega'];
                              ($notaEntrega);
                              //F
                              $garantia_vigente_repuesto = $d_soporte_claves['garantia_vigente_repuesto'];
                              $garantia_vigente_mano = $d_soporte_claves['garantia_vigente_mano'];
                              $garantia_ambos = strtoupper($garantia_vigente_repuesto . ' , ' . $garantia_vigente_mano);
                              ($garantia_ambos);
                              //H
                              $equipo = $d_soporte_claves['equipo'];
                              $marca = $d_soporte_claves['marca'];
                              $modelo = $d_soporte_claves['modelo'];
                              $maquina_nombre = $equipo . ' ' . $marca . ' ' . $modelo;
                              ($maquina_nombre);
                              //P
                              //Q
                              //U
                              $problema = $d_soporte_claves['problema'];
                              $realizar = $d_soporte_claves['realizar'];
                              $trabajoRealizado = $d_soporte_claves['trabajoRealizado'];
                              $descripcion_reparacion = 'Problema: ' . $problema . ' Realizar: ' . $realizar . ' Trabajo Adicional: ' . $trabajoRealizado;
                              ($descripcion_reparacion);

                              //3ro Repuestos usados en cada equipo
                              $idClave = $d_soporte_claves['idClave'];
                              $q_soporte_claves_repuestos = mysqli_query($MySQLi, "SELECT * FROM `soporte_claves_repuestos` WHERE `idClave`='$idClave'"); //  AND `tipo_repuesto`='repuesto_sistema'
                              $enc = 0;
                              while ($d_soporte_claves_repuestos = mysqli_fetch_assoc($q_soporte_claves_repuestos)) {
                                $enc++;
                                //I
                                $nombre_repuesto = $d_soporte_claves_repuestos['nombre_repuesto'];
                                //J
                                $precioVenta = $d_soporte_claves_repuestos['precioVenta'];
                                //K
                                $cantidad = $d_soporte_claves_repuestos['cantidad'];
                                //L
                                $precioEspecial = $d_soporte_claves_repuestos['precioEspecial'];
                                //M
                                //N
                                //O
                            // ? >
                                if ($d_soporte_sucursales['estado'] <> 0) {
                            echo "<tr class=\"odd gradeX\">";
                            echo   "<td class=\"text-center\"> $Num </td>";
                            echo   "<td class=\"text-center\">  $nombre_sucursal </td>";
                            echo   "<td class=\"text-center\">  $fecha_recepcion </td>";
                            echo   "<td class=\"text-center\">  $nro_servicio_recepcion </td>";
                            echo   "<td class=\"text-center\">  $invoice_number </td>";
                            echo   "<td class=\"text-center\">  $nombre_cliente </td>";
                            echo   "<td class=\"text-center\">  $nombre_repuesto </td>";
                            echo   "<td class=\"text-center\">  $precioVenta </td>";
                            echo   "<td class=\"text-center\">  $cantidad </td>";
                            echo   "<td class=\"text-center\">  $precioEspecial </td>";
                            echo   "<td class=\"text-center\"> ". number_format($cantidad * $precioEspecial, 2)." </td>";
                            echo   "<td class=\"text-center\">  $importe_facturado </td>";
                            echo  " <td class=\"text-center\">  $tecnico_cadena </td>";
                            echo "  <td class=\"text-center\">Venta Soporte Técnico</td>";
                            echo "</tr>";
                                }
                            // < ? php
                                $total_precio_lista += $precioVenta;
                                $total_cantidad += $cantidad;
                                $total_precio_venta += $precioEspecial;
                                $precio_cobrar = number_format($cantidad * $precioEspecial, 2);
                                $total_venta += $precio_cobrar;
                                $total_importe_facturado += $importe_facturado;
                                $Num++;
                              }
                            } //Fin while2 equipos
                            if($enc == 0) {
                            echo "<tr class=\"odd gradeX\">";
                            echo   "<td class=\"text-center\">" . ($Num++) ."</td>";
                            echo   "<td class=\"text-center\">  $nombre_sucursal </td>";
                            echo   "<td class=\"text-center\">  $fecha_recepcion </td>";
                            echo   "<td class=\"text-center\">  $nro_servicio_recepcion </td>";
                            echo   "<td class=\"text-center\">  $invoice_number </td>";
                            echo   "<td class=\"text-center\">  $nombre_cliente </td>";
                            echo   "<td class=\"text-center\">  " . str_replace('"]','',str_replace('["','',$ex_nombre_maquinas)) . "</td>";
                            echo   "<td class=\"text-center\">  $precioVenta </td>";
                            echo   "<td class=\"text-center\">  $cantidad </td>";
                            echo   "<td class=\"text-center\">  $precioEspecial </td>";
                            echo   "<td class=\"text-center\">" .  $ex_total_cobrar_bs . "</td>";
                            echo   "<td class=\"text-center\">  $importe_facturado </td>";
                            echo  " <td class=\"text-center\">  $tecnico_cadena </td>";
                            echo "  <td class=\"text-center\">" . "Venta directa soporte" . "</td>";
                            $total_venta += $ex_total_cobrar_bs;
                            echo "</tr>";
                            }
                          } //Termina If


                        }
                        mysqli_close($MySQLi); ?>
                        <tr class="odd gradeX">
                          <td class="text-center"><?php echo $Num; ?></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>
                          <td class="text-center"></td>

                          <td class="text-center"><?php echo $total_precio_lista; ?></td>
                          <td class="text-center"><?php echo $total_cantidad; ?></td>
                          <td class="text-center"><?php echo $total_precio_venta; ?></td>
                          <td class="text-center"><?php echo $total_venta; ?></td>
                          <td class="text-center"><?php echo $total_importe_facturado; ?></td>

                          <td class="text-center"></td>
                          <td class="text-center"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

            </div>
        </main><?php
                include_once APP_PATH . '/includes/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
  <script src="<?= ASSETS_URL ?>/js/misventas.js"></script>
</body>

</html>