<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Mis Ventas';
$_active_nav = 'misVentasSoporte'; ?>
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
          <div class="row">
            <div class="respuesta"></div>
            <div class="col">
              <div class="panel">
                <div class="panel-hdr">
                  <?php
                  if (isset($_POST['inicio'])) {
                    $Inicio = $_POST['inicio'];
                    $Fin = $_POST['fin'];
                  } else {
                    $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                    $Fin = $fecha; //fecha = hoy
                  } ?>

                  <h2><span class="fw-300 text-primary">MIS VENTAS
                    </span> &nbsp; &nbsp;del &nbsp;
                    <span class="text-danger"><?= fechaFormato($Inicio) ?>
                    </span> &nbsp;al &nbsp; <span class="text-danger"><?= fechaFormato($Fin) ?></span>
                  </h2>

                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <form class="w-50 m-auto" id="buscar" action="?root=misVentasSoporte" method="POST">
                      <div class="row mb-2">
                        <div class="col text-center">
                          <label for="fechaInicio">Fecha de inicio</label>
                          <input type="hidden" name="sucursal" value="<?php echo $dataUss['ciudad'] ?>">
                          <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $Inicio ?>" data-parsley-required="true">
                        </div>
                        <div class="col text-center">
                          <label for="fechaFin">Fecha final</label>
                          <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $Fin ?>" data-parsley-required="true">
                        </div>
                        <div class="col">
                          <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                          <button type="submit" class="form-control btn btn-xs btn-primary ">Buscar &nbsp;<i class="fas fa-spinner fa-pulse d-none btn-Buscar"></i></button>
                          
                                                  <?php
                        echo "<a class='form-control btn btn-default' href='mv.php?i=$Inicio&f=$Fin&u=$idUser'>Excel</a>";
                    ?>                          
                        </div>
                      </div>
                    </form>
                    
                    
                    
                  
                <?php
                    /*$sql_rango = "SELECT idRango FROM `usuarios` WHERE idUser='$idUser'";
                    $data_rango = mysqli_query($MySQLi, $sql_rango);
                    $filaRango = mysqli_fetch_assoc($data_rango);
                    $idRangoDf = $filaRango['idRango'];
                    */
                  $resUser = mysqli_query($MySQLi, "select tipo from usuarios where idUser = $idUser"); 
                  $filaUser = mysqli_fetch_assoc($resUser);
                  $tipoUser = $filaUser['tipo'];    
                 ?>
                 
                 <table id="listamisVentas2" class="table table-bordered table-hover table-striped w-100">
                     <?php 
                     if ($tipoUser == 'A') {
                  echo ('<thead>');
                  echo ('  <tr>');
                      echo ('<th class="text-center">N&ordm;</th>');
                      echo ('<th class="text-center">SUCURSAL</th>');
                      echo ('<th width="30%" class="text-center">EXCEL</th>');
                    echo ('</tr>');
                  echo ('</thead>');
                  echo ('<tbody>');
                      
                   
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
                      //echo "<a class='form-control btn btn-default' href='mv.php?i=$Inicio&f=$Fin&u=$idUser'>Excel</a>";
                      echo '<td class="text-center">
                        <div class="row">
                          <div class="col">
                            <a class="btn btn-sm btn-block" style="background-color:#4FC23D" href="mv.php?t=' . $fila['idTienda'] . '&i=' . $Inicio . '&f=' . $Fin . '&u=' . $idUser . '" title="Historial todos los Productos Fiscales en rango de fechas"><span style="color: white">DESCARGAR</span>&nbsp;&nbsp;
                              <i class="fa fa-download" style="color: white"></i>
                            </a>
                          </div>
                        </div>';
                      echo '
                      </td>';
                      echo '</tr>';
                      $nro++;
                    }
                
                  echo('</tbody>');
                echo('');
                }
              ?>
               </table>    
                    
                      
                    <div id="content" class="content">
                      <hr>
                      <div class="panel-container">
                        <div class="panel-content">
                          <table id="listamisVentas" class="table table-bordered table-hover table-striped w-100">
                            <thead>
                              <tr>
                                <th width="5%" class="text-center">FECHA</th>
                                <!-- <th width="5%" class="text-center">Fecha Nota Entrega</th> -->
                                <th width="5%" class="text-center">No. NOTA VENTA</th>
                                <!-- <th width="5%" class="text-center">Nº Nota Entrega de la venta de la maquina</th> -->
                                <th width="5%" class="text-center">No. FACTURA</th>

                                <!-- <th width="5%" class="text-center">Garantia: Repuestos - Mano De Obra</th> -->
                                <th width="5%" class="text-center">CLIENTE/CELULAR/NIT</th>
                                <!-- <th width="5%" class="text-center">Nombre Maquina/Marca/Modelo</th> -->
                                <th width="5%" class="text-center">MAQUINA REPUESTO</th>
                                <th width="5%" class="text-center">PRECIO DE LISTA DEL REPUESTO</th>

                                <th width="5%" class="text-center">CANTIDAD</th>
                                <th width="5%" class="text-center">COBRO BS</th>
                                <!-- <th width="5%" class="text-center">Cobro/Insumos Extras Bs</th> -->
                                <!-- <th width="5%" class="text-center">Cobro/Servicios Externos Bs</th> -->
                                <!-- <th width="5%" class="text-center">Cobro/Otros Gastos Bs</th> -->

                                <!-- <th width="5%" class="text-center">Cobro Mano de Obra BS</th> -->
                                <!-- <th width="5%" class="text-center">Costo Adicional BS</th> -->
                                <th width="5%" class="text-center">TOTAL A COBRAR BS</th>
                                <th width="5%" class="text-center">IMPORTE FACTURADO</th>
                                <th width="5%" class="text-center">NOMBRE VENDEDOR</th>

                                <th width="5%" class="text-center">OBSERVACIONES</th>

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


                              //$sql = "SELECT *  FROM soporte_ventas WHERE (fecha_completado BETWEEN '$Inicio' AND '$Fin') AND id_user='$idUser' ORDER BY fecha_recepcion ASC ";
                              if ($tipoUser == 'A') {
                                  $sql = "SELECT notaEntrega.idNotaE nota_id, sv.*  FROM soporte_ventas sv ";
                                  $sql .= " LEFT JOIN notaEntrega ON sv.idCotizacion = notaEntrega.idCotizacion";
                                  $sql .= " WHERE (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') and sv.idCotizacion > 0 ORDER BY fecha_recepcion ASC";
                              }
                              else {
                                $sql = "SELECT notaEntrega.idNotaE nota_id, sv.*  FROM soporte_ventas sv ";
                                $sql .= " inner join cotizaciones cot on sv.idCotizacion = cot.idCotizacion";
                                $sql .= " and cot.idUser = '$idUser'";
                                $sql .= " LEFT JOIN notaEntrega ON cot.idCotizacion = notaEntrega.idCotizacion";
                                $sql .= " WHERE (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') ORDER BY fecha_recepcion ASC";
                              }
                              $resultado = mysqli_query($MySQLi, $sql);
                              while ($fila = mysqli_fetch_assoc($resultado)) {
                                //dividir ventas directo y si si corresponde servicio llenar de otra forma
                                $idCotizacion = (int) $fila['idCotizacion'];
                                $idSoporte = $fila['idSoporte'];

                                // 1  caso que sea de cotizacion
                                if ($idCotizacion !== 0 && $idSoporte == 0) {
                                  // A
                                  $fecha_recepcion = ($fila['fecha_recepcion']);
                                  // B
                                  $nota_id = ($fila['nota_id']);
                                  // C
                                  $idCotizacion = ($fila['idCotizacion']);
                                  // D
                                  $nota_entrega_venta_maquina = json_decode($fila['nota_entrega_venta_maquina']);
                                  $nota_entrega_venta_maquina = ($nota_entrega_venta_maquina[0]);
                                  // E
                                  $invoice_number = ($fila['invoice_number']);
                                  // F
                                  $garantias_repuestos = json_decode($fila['garantias_repuestos']);
                                  $garantias_mano = json_decode($fila['garantias_mano']);
                                  $garantia_ambos = strtoupper($garantias_repuestos[0] . ' , ' . $garantias_mano[0]);
                                  $garantia_ambos = (string)($garantia_ambos);
                                  // G
                                  $q_cotizaciones = mysqli_query($MySQLi, "SELECT * FROM `cotizaciones` WHERE `idCotizacion`='$idCotizacion'");
                                  $d_cotizaciones = mysqli_fetch_assoc($q_cotizaciones);
                                  $idCliente = $d_cotizaciones['idCliente'];
                                  $q_clientes = mysqli_query($MySQLi, "SELECT * FROM `clientes` WHERE `idCliente`='$idCliente'");
                                  $d_clientes = mysqli_fetch_assoc($q_clientes);
                                  $telefono_cliente = $d_clientes['celular'];
                                  $nombre_cliente = $fila['nombre_cliente'] . "\n" . $telefono_cliente;
                                  $nombre_cliente = (string)($nombre_cliente);
                                  //H
                                  //I
                                  $repuestos_nombres = json_decode($fila['repuestos_nombres']);
                                  $repuestos_nombres = ($repuestos_nombres[0][0]);
                                  //J
                                  $repuestos_precio_lista = json_decode($fila['repuestos_precio_lista']);
                                  $repuestos_precio_lista = ($repuestos_precio_lista[0][0]);
                                  //K
                                  $repuestos_cantidad = json_decode($fila['repuestos_cantidad']);
                                  $repuestos_cantidad = ($repuestos_cantidad[0][0]);
                                  //L
                                  $repuestos_precio_venta = json_decode($fila['repuestos_precio_venta']);
                                  $repuestos_precio_venta = ($repuestos_precio_venta[0][0]);
                                  //M
                                  //N
                                  //O
                                  //P
                                  //Q
                                  //R
                                  $total_cobrar_bs = ($fila['total_cobrar_bs']);
                                  //S
                                  $importe_facturado = ($fila['importe_facturado']);
                                  //T
                                  $id_user = $fila['id_user'];
                                  $q_nombre_user = mysqli_query($MySQLi, "SELECT Nombre, tipo FROM usuarios WHERE idUser='$id_user'");
                                  $d_nombre_user = mysqli_fetch_assoc($q_nombre_user);
                                  $Nombre = $d_nombre_user['Nombre']; //el que vendio
                                  $Nombre = (string)($Nombre);
                                  //U
                              
                                    echo("<tr class='odd gradeX'>");
                                    echo("<td class='text-center'>  $fecha_recepcion </td>");
                                    echo("<td class='text-center'>  $nota_id </td>");
                                    echo("<td class='text-center'>  $invoice_number </td>");
                                    echo("<td class='text-center'>  $nombre_cliente </td>");
                                    echo("<td class='text-center'>  $repuestos_nombres </td>");

                                    echo("<td class='text-center'>  $repuestos_precio_lista </td>");
                                    echo("<td class='text-center'>  $repuestos_cantidad </td>");
                                    echo("<td class='text-center'>  $repuestos_precio_venta </td>");
                                    echo("<td class='text-center'>  $total_cobrar_bs </td>");
                                    echo("<td class='text-center'>  $importe_facturado </td>");

                                    echo("<td class='text-center'> $Nombre </td>");
                                    echo("<td class='text-center'> Venta Directa </td>");
                                  echo("</tr>");
                                  
                              
                                  $total_precio_lista += $repuestos_precio_lista;
                                  $total_cantidad += $repuestos_cantidad;
                                  $total_precio_venta += $repuestos_precio_venta;
                                  $total_venta += $total_cobrar_bs;
                                  $total_importe_facturado += $importe_facturado;
                                  $Num++;
                                } else if (1 == 2){
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
                                    $q_soporte_claves_repuestos = mysqli_query($MySQLi, "SELECT * FROM `soporte_claves_repuestos` WHERE `idClave`='$idClave' AND `tipo_repuesto`='repuesto_sistema'");
                                    while ($d_soporte_claves_repuestos = mysqli_fetch_assoc($q_soporte_claves_repuestos)) {
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
                                  ?>
                                      <tr class="odd gradeX">
                                        <td class="text-center"><?php echo $fecha_recepcion; ?></td>
                                        <td class="text-center"><?php echo $nro_servicio_recepcion; ?></td>
                                        <td class="text-center"><?php echo $invoice_number; ?></td>
                                        <td class="text-center"><?php echo $nombre_cliente; ?></td>
                                        <td class="text-center"><?php echo $nombre_repuesto; ?></td>

                                        <td class="text-center"><?php echo $precioVenta; ?></td>
                                        <td class="text-center"><?php echo $cantidad; ?></td>
                                        <td class="text-center"><?php echo $precioEspecial; ?></td>
                                        <td class="text-center"><?php echo number_format($cantidad * $precioEspecial, 2); ?></td>
                                        <td class="text-center"><?php echo $importe_facturado; ?></td>

                                        <td class="text-center"><?php echo $tecnico_cadena; ?></td>
                                        <td class="text-center"><?php echo 'Venta Soporte Técnico' ?></td>
                                      </tr>
                              <?php
                                      $total_precio_lista += $precioVenta;
                                      $total_cantidad += $cantidad;
                                      $total_precio_venta += $precioEspecial;
                                      $precio_cobrar = number_format($cantidad * $precioEspecial, 2);
                                      $total_venta += $precio_cobrar;
                                      $total_importe_facturado += $importe_facturado;
                                      $Num++;
                                    }
                                  } //Fin while2 equipos

                                } //Termina If


                              }
                              mysqli_close($MySQLi); ?>
                              <tr class="odd gradeX">
                                <td class="text-center">TOTALES</td>
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
                </div>
              </div>
            </div>
          </div>
        </main>

        <?php
        include_once APP_PATH . '/includes/footer.php'; ?>
      </div>
    </div>
  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/datagrid/datatables/datatables.export.js"></script>
  <script src="<?= ASSETS_URL ?>/js/misVentasSoporte.js"></script>
</body>

</html>