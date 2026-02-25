<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Productos Fiscales - ' . APP_TITLE;
$_active_nav = 'productos_fiscales'; ?>
<!DOCTYPE html>
<html lang="es">
<link rel="stylesheet" href="assets/sweetchery/sweetchery.css">
<?php
include_once APP_PATH . '/includes/head.php';
include_once APP_PATH . '/includes/funciones.php';

error_reporting(0); ?>

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
                                        <h2>Productos Fiscales <span class="fw-300"><i> </i></span> &nbsp; &nbsp;del
                                            &nbsp;
                                            <span class="text-danger"><?= fechaFormato($Inicio) ?></span> &nbsp;al &nbsp;
                                            <span class="text-danger"><?= fechaFormato($Fin) ?></span>
                                        </h2>
                                        <button class="btn btn-xs btn-primary Buscar"><i class="far fa-search">
                                                Buscar</i></button>&nbsp;&nbsp;<?php
                                                                            } else { ?>
                                        <h2>Productos Fiscales <span class="fw-300"><i> </i></span> &nbsp;
                                            &nbsp;<?= $mes ?>
                                        </h2>
                                        <?php
                                                                            }

                                                                            if (isset($_POST['inicio'])) {
                                                                                $Inicio = $_POST['inicio'];
                                                                                $Fin = $_POST['fin'];
                                                                            } else {
                                                                                $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                                                                                $Fin = $fecha; //fecha = hoy
                                                                            }


                                                                                ?>
                                       
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
                                        </form>


                                        <table id="listaProductosFiscales" name="listaProductosFiscales" class="table table-striped table-bordered table-td-valign-middle w-100">
                                            <thead>
                                                <tr>
                                                    <th width="3%" class="text-center">N&ordm;</th>
                                                    <th width="10%" class="text-center">IdProducto</th>
                                                    <th width="10%" class="text-center">FECHA POLIZA</th>
                                                    <th width="10%" class="text-center">CODIGO</th>
                                                    <th width="20%" class="text-center">DETALLE</th>
                                                    <th width="10%" class="text-center btn-success">SALDO FISICO
                                                        <br>(ACTUAL)
                                                    </th>

                                                

                                                    <th width="20%" class="text-center">C/U PARA FACTURAR MINIMO</th>
                                                    <th width="20%" class="text-center">IMPORTES PARA FACTURAR</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                include 'includes/conexion_yuli_ventas.php';
                                                $query = "SELECT * FROM productos_fiscales ORDER BY idProducto ASC";
                                                $queryProductos    =    mysqli_query($MySQLi, $query);


                                                $Num = 1;

                                                $GranTotalSaldoFisico = 0;

                                                $GranTotalInicial = 0;
                                                $GranTotalFinal = 0;

                                                $GranTotalMinuendo = 0;
                                                $GranTotalSustraendo = 0;
                                                $GrantTotalExtraendo = 0;


                                                while ($dataProductos = mysqli_fetch_assoc($queryProductos)) {
                                                    $idProducto = $dataProductos['idProducto'];



                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td class="text-center"><?php echo $Num; ?></td>
                                                        <td class="text-center"> <?php echo $dataProductos['idProducto']; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo $dataProductos['fecha_poliza']; ?> </td>
                                                        <td class="text-center"> <?php echo $dataProductos['codigo']; ?>
                                                        </td>
                                                        <td class=""> <?php
                                                                        echo $dataProductos['detalle']; ?> </td>
                                                        <td class="text-center">
                                                            <?php

                                                            echo $dataProductos['saldo_fisico'];
                                                            $GranTotalSaldoFisico = $GranTotalSaldoFisico + $dataProductos['saldo_fisico'];
                                                            ?>

                                                        </td>

                                                        <td class="text-center">
                                                            <?php echo $dataProductos['c_u_facturar_minimo']; ?>
                                                        </td>
                                                        <td class="text-center">
                                                            <?php echo $dataProductos['importes_para_facturar']; ?>
                                                        </td>
                                                        
                                                    </tr>
                                                    <?php $Num++;  ?>
                                                <?php  }
                                                mysqli_close($MySQLi); ?>

                                                <tr>
                                                    <th width="10%" class="text-center"><?php echo $Num; ?></th>
                                                    <th width="10%" class="text-center"></th>
                                                    <th width="10%" class="text-center"></th>
                                                    <th width="20%" class="text-center"></th>
                                                    <th width="20%" class="text-center">Totales: </th>
                                                    <th width="10%" class="text-center btn-success">
                                                        <?php echo $GranTotalSaldoFisico ?>
                                                    </th>
                                                    <th width="20%" class="text-center"></th>
                                                    <th width="20%" class="text-center"></th>
                                                    
                                                    

                                                </tr>
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



    </div>
    <!-- FIN Modal AGREGAR DIAGNOSTICO AL EQUIPO -->

    </div>
    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script src="assets/js/productosFiscales.js"></script>
</body>

</html>