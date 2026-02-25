<?php
require_once 'init.php';
include 'includes/funcionesHistorialRepuestos.php';
error_reporting(0);
$_title = 'Historial Repuestos';
$_active_nav = 'historial_productos'; ?>
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
                        <li class="position-absolute pos-top pos-right d-none d-sm-block"><?= $Fecha ?></li>
                    </ol>
                    <div id="panelProductos" class="panel">
                        <div class="panel-hdr">
                            <h2>HISTORIAL <span class="fw-300"><i>LISTA DE REPUESTOS</i></span>
                            </h2>
                            &nbsp;
                            &nbsp;
                            <div class="panel-toolbar">
                                <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                            </div>
                            <?php
                            if (isset($_POST['inicio'])) {
                                $Inicio = $_POST['inicio'];
                                $Fin = $_POST['fin'];
                            } else {
                                $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                                $Fin = $fecha; //fecha = hoy
                            } ?>

                        </div>
                        <div class="panel-container">
                            <div class="panel-content">
                                <form class="w-75 m-auto" id="buscar" action="?root=productosHistorial" method="POST">
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
                                        </div>
                                    </div>
                                </form>
                                <!-- LISTA DE PRODUCTOS -->
                                <table id="productosHistorial" class="table table-bordered table-hover table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th width="3%" class="text-center">N&ordm;</th>
                                            <th width="3%" class="text-center">Mercaderia</th>
                                            <th width="10%" class="text-center">Nombre Repuesto</th>
                                            <th width="3%" class="text-center">Precio Unitario <?php echo SETTINGS['simbolo']; ?> </th>
                                            <?php
                                            if ($serviStock == 1) {
                                                $Q_Sucursales = mysqli_query($MySQLi, "SELECT codeTienda FROM sucursales WHERE estado=1 ORDER BY idTienda ASC");
                                                while ($dataSu = mysqli_fetch_assoc($Q_Sucursales)) {
                                                    echo '<th width="3%" class="text-center">' . $dataSu['codeTienda'] . ' ' .  $Fin . '</th>';
                                                }
                                            } ?>
                                            <th width="3%" class="text-center" title="<?php echo " " . "$Fin"; ?>">Total Stock </th>

                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Extraidos CB</th>
                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Recepcionados CB</th>

                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Extraidos LP</th>
                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Recepcionados LP</th>

                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Extraidos SC</th>
                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Recepcionados SC</th>

                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Extraidos TJ</th>
                                            <th width="3%" class="text-center" title="<?php echo "$Inicio" . ' / ' . "$Fin"; ?>">Recepcionados TJ</th>
                                        </tr>
                                    </thead>
                                    <tbody class="listaProductos">
                                        <?php



                                        $totalextractoCB = 0;
                                        $totalRecepcionCB = 0;

                                        $totalextractoLP = 0;
                                        $totalRecepcionLP = 0;

                                        $totalextractoSC = 0;
                                        $totalRecepcionSC = 0;

                                        $totalextractoTJ = 0;
                                        $totalRecepcionTJ = 0;

                                        $totalCapturaCB = 0;  //1
                                        $totalCapturaLP = 0; //2
                                        $totalCapturaSC = 0; //3
                                        $totalCapturaTJ = 0; //4
                                        $totalCapturaStockTotal = 0; //5

                                        $totalHoyCB = 0;  //1
                                        $totalHoyLP = 0; //2
                                        $totalHoySC = 0; //3
                                        $totalHoyTJ = 0; //4
                                        $totalHoyStockTotal = 0; //5


                                        $Q_Productos    = mysqli_query($MySQLi, "SELECT * FROM productos WHERE estado=1 ORDER BY idProducto ASC");
                                        $num            = 1;
                                        while ($dataProd = mysqli_fetch_assoc($Q_Productos)) {
                                            $idProducto = $dataProd['idProducto'];
                                            $mercaderia = ($dataProd['mercaderia'] == '' || $dataProd['mercaderia'] == null) ? ' ' : $dataProd['mercaderia'];
                                            $nombre = ($dataProd['nombre'] == '' || $dataProd['nombre'] == null) ? ' ' : $dataProd['nombre'];
                                            echo '
                                            <tr>
                                            <td class="text-center">' . $num . '</td>
                                            <td>' . mb_convert_encoding($mercaderia, 'HTML-ENTITIES', 'UTF-8') . '</td>
                                            <td>' . mb_convert_encoding($nombre, 'HTML-ENTITIES', 'UTF-8') . '</td>';
                                            $Q_Configuraciones = mysqli_query($MySQLi, "SELECT simbolo FROM configuraciones");
                                            $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
                                            $simbolo           = $dataConfiguracion['simbolo'];
                                            echo '
                                                <td class="text-right">' . number_format($dataProd['precio'], 2) . '</td>';
                                            $producto = [];
                                            for ($i = 0; $i < 4; $i++) {
                                                $q_inventario = mysqli_query($MySQLi, "SELECT * FROM inventario WHERE idProducto='$idProducto' LIMIT $i,1 ");
                                                $d_inventario  = mysqli_fetch_assoc($q_inventario);
                                                $stockProduc = ($d_inventario['stock'] == '' || $d_inventario['stock'] == null) ? "0" : $d_inventario['stock'];
                                                $producto[$i] = $stockProduc;
                                            }
                                            $q_stock_total = mysqli_query(
                                                $MySQLi,
                                                "SELECT
                                            idProducto,
                                            SUM(stock) AS total_stock
                                            FROM
                                            inventario
                                            WHERE
                                            idProducto = '$idProducto'"
                                            );
                                            $d_stock_total  = mysqli_fetch_assoc($q_stock_total);
                                            $total_stock = $d_stock_total['total_stock'];
                                            $producto[4] = $total_stock;

                                            if ($Fin != $fecha) {
                                                $capturaProducto = captura_producto($MySQLi, $idProducto, $Fin);
                                            }
                                        ?>
                                            <td style="text-align:center;background-color:#FFF2CC">
                                                <?php
                                                if ($Fin == $fecha) {
                                                    echo $producto[0];
                                                    $totalHoyCB += $producto[0];
                                                } else {
                                                    if ($capturaProducto) {
                                                        echo $capturaProducto['StockCB'];
                                                        $totalCapturaCB += $capturaProducto['StockCB'];
                                                    } else {
                                                        echo 'Sin registro en  ' . $Fin;
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td style="text-align:center;background-color:#DDEBF7">
                                                <?php
                                                if ($Fin == $fecha) {
                                                    echo $producto[1];
                                                    $totalHoyLP += $producto[1];
                                                } else {
                                                    if ($capturaProducto) {
                                                        echo $capturaProducto['StockLP'];
                                                        $totalCapturaLP += $capturaProducto['StockLP'];
                                                    } else {
                                                        echo 'Sin registro en  ' . $Fin;
                                                    }
                                                }

                                                ?>
                                            </td>
                                            <td style="text-align:center;background-color:#E2EFDA">
                                                <?php
                                                if ($Fin == $fecha) {
                                                    echo $producto[2];
                                                    $totalHoySC += $producto[2];
                                                } else {
                                                    if ($capturaProducto) {
                                                        echo $capturaProducto['StockSC'];
                                                        $totalCapturaSC += $capturaProducto['StockSC'];
                                                    } else {
                                                        echo 'Sin registro en  ' . $Fin;
                                                    }
                                                }
                                                ?>

                                            </td>
                                            <td style="text-align:center;background-color: #FCE4D6">
                                                <?php
                                                if ($Fin == $fecha) {
                                                    echo $producto[3];
                                                    $totalHoyTJ += $producto[3];
                                                } else {
                                                    if ($capturaProducto) {
                                                        echo $capturaProducto['StockTJ'];
                                                        $totalCapturaTJ += $capturaProducto['StockTJ'];
                                                    } else {
                                                        echo 'Sin registro en  ' . $Fin;
                                                    }
                                                }
                                                ?>
                                            </td>

                                            <td style="text-align:center;background-color:#FFA500<?php // echo (((int)$producto[4] <= 5 && $Fin == $fecha) || ($capturaProducto['StockTotal'] <= 5 && $Fin != $fecha)) ? '#F04E4E' : '#FFA500';                                                                                                    
                                                                                                    ?>">
                                                <?php
                                                if ($Fin == $fecha) {
                                                    echo $producto[4];
                                                    $totalHoyStockTotal += $producto[4];
                                                } else {
                                                    if ($capturaProducto) {
                                                        echo $capturaProducto['StockTotal'];
                                                        $totalCapturaStockTotal += $capturaProducto['StockTotal'];
                                                    } else {
                                                        echo 'Sin registro en  ' . $Fin;
                                                    }
                                                }
                                                ?>
                                            </td>

                                            <?php

                                            //extractos recevidos
                                            $extractoCB = extractoProducto($MySQLi, $idProducto, $Inicio, $Fin, '1');
                                            $totalextractoCB = $totalextractoCB + $extractoCB;
                                            $recepcionadoCB = recepcionProducto($MySQLi, $idProducto, $Inicio, $Fin, '1');
                                            $totalRecepcionCB += $recepcionadoCB;

                                            $extractoLP = extractoProducto($MySQLi, $idProducto, $Inicio, $Fin, '2');
                                            $totalextractoLP = $totalextractoLP + $extractoLP;
                                            $recepcionadoLP = recepcionProducto($MySQLi, $idProducto, $Inicio, $Fin, '2');
                                            $totalRecepcionLP += $recepcionadoLP;

                                            $extractoSC = extractoProducto($MySQLi, $idProducto, $Inicio, $Fin, '3');
                                            $totalextractoSC = $totalextractoSC + $extractoSC;
                                            $recepcionadoSC = recepcionProducto($MySQLi, $idProducto, $Inicio, $Fin, '3');
                                            $totalRecepcionSC += $recepcionadoSC;

                                            $extractoTJ = extractoProducto($MySQLi, $idProducto, $Inicio, $Fin, '4');
                                            $totalextractoTJ = $totalextractoTJ + $extractoTJ;
                                            $recepcionadoTJ = recepcionProducto($MySQLi, $idProducto, $Inicio, $Fin, '4');
                                            $totalRecepcionTJ += $recepcionadoTJ;

                                            ?>

                                            <td style="text-align:center; background-color: #FFF2CC">
                                                <?php echo $extractoCB * -1; ?>
                                            </td>
                                            <td style="text-align:center; background-color: #FFF2CC">
                                                <?php echo $recepcionadoCB; ?>
                                            </td>


                                            <td style="text-align:center; background-color: #DDEBF7">
                                                <?php echo $extractoLP * -1; ?>
                                            </td>
                                            <td style="text-align:center; background-color: #DDEBF7">
                                                <?php echo $recepcionadoLP; ?>
                                            </td>


                                            <td style="text-align:center; background-color: #E2EFDA">
                                                <?php echo $extractoSC * -1; ?>
                                            </td>
                                            <td style="text-align:center; background-color: #E2EFDA">
                                                <?php echo $recepcionadoSC; ?>
                                            </td>


                                            <td style="text-align:center; background-color: #FCE4D6">
                                                <?php echo $extractoTJ * -1; ?>
                                            </td>
                                            <td style="text-align:center; background-color: #FCE4D6">
                                                <?php echo $recepcionadoTJ; ?>
                                            </td>



                                        <?php
                                            echo '</tr>';
                                            $num++;
                                        }




                                        ?>
                                        <tr>
                                            <td class="text-center"><?php echo $num; ?></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td style="text-align:center;background-color: #FFF2CC"><strong><?php echo ($Fin == $fecha) ? $totalHoyCB : $totalCapturaCB; ?></strong></td>
                                            <td style="text-align:center;background-color: #DDEBF7"> <strong> <?php echo ($Fin == $fecha) ? $totalHoyLP : $totalCapturaLP; ?> </strong> </td>
                                            <td style="text-align:center;background-color: #E2EFDA"> <strong> <?php echo ($Fin == $fecha) ? $totalHoySC : $totalCapturaSC; ?> </strong> </td>
                                            <td style="text-align:center;background-color: #FCE4D6"> <strong> <?php echo ($Fin == $fecha) ? $totalHoyTJ : $totalCapturaTJ; ?> </strong> </td>
                                            <td style="text-align:center;background-color: #FFA500"> <strong> <?php echo ($Fin == $fecha) ? $totalHoyStockTotal : $totalCapturaStockTotal; ?> </strong> </td>
                                            <td style="text-align:center; background-color: #FFF2CC"><?php echo $totalextractoCB * -1; ?></td>
                                            <td style="text-align:center; background-color: #FFF2CC"><?php echo $totalRecepcionCB; ?></td>

                                            <td style="text-align:center; background-color: #DDEBF7"><?php echo $totalextractoLP * -1; ?></td>
                                            <td style="text-align:center; background-color: #DDEBF7"><?php echo $totalRecepcionLP; ?></td>

                                            <td style="text-align:center; background-color: #E2EFDA"><?php echo $totalextractoSC * -1; ?></td>
                                            <td style="text-align:center; background-color: #E2EFDA"><?php echo $totalRecepcionSC; ?></td>

                                            <td style="text-align:center; background-color: #FCE4D6"><?php echo $totalextractoTJ * -1; ?></td>
                                            <td style="text-align:center; background-color: #FCE4D6"><?php echo $totalRecepcionTJ; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
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
    <script src="<?= ASSETS_URL ?>/js/productosHistorial.js"></script>
</body>

</html>