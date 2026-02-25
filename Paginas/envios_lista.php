<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Equipos registrados - ' . APP_TITLE;
$_active_nav = 'Lista_envios'; ?>
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
                                                            $Fin = $_POST['fin'];
                                                        } else {
                                                            $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                                                            $Fin = $fecha; //fecha = hoy
                                                        } ?>
                                    <h2>Lista Envios <span class="fw-300"><i>de Repuestos </i></span> &nbsp; &nbsp;del
                                        &nbsp;
                                        <span class="text-danger"><?= fechaFormato($Inicio) ?></span> &nbsp;al &nbsp;
                                        <span class="text-danger"><?= fechaFormato($Fin) ?></span>
                                    </h2>
                                    <button class="btn btn-xs btn-primary Buscar"><i class="far fa-search">
                                            Buscar</i></button>&nbsp;&nbsp;

                                    &nbsp;&nbsp;&nbsp;
                                    <div class="panel-toolbar">
                                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                                    </div>
                                </div>
                                <div class="panel-container">
                                    <div class="panel-content">
                                        <form class="w-75 m-auto d-none" id="buscar" action="?root=envios_lista" method="POST">
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
                                    </div>
                                    <table id="data-table-responsive" class="table table-striped table-bordered table-td-valign-middle w-100">
                                        <div class="respuesta"></div>
                                        <thead>
                                            <tr>
                                                <th width="5%" class="text-center">N&ordm;</th>
                                                <th width="15%" class="text-center">Destino</th>
                                                <th width="15%" class="text-center">Técnico</th>
                                                <th width="15%" class="text-center">Fecha</th>
                                                <th width="15%" class="text-center">Estado</th>
                                                <th width="35%" class="text-center">Acciones</th>
                                            </tr>
                                        </thead><?php
                                                $sqlEnvios = mysqli_query(
                                                    $MySQLi,
                                                    "SELECT * FROM envio_stock WHERE id_origen='$idTiendaDf' AND fecha BETWEEN '$Inicio' AND '$Fin' "
                                                ) or die(mysqli_error($MySQLi) . "<br>Error en la linea: " . __LINE__);
                                                ?>
                                        <tbody><?php
                                                $idNumber         = 1;
                                                while ($dataEnvio = mysqli_fetch_assoc($sqlEnvios)) {
                                                    echo '<tr>
									        	<td class="text-center">' . $idNumber . '</td>

									        	<td class="text-center">';
                                                    $idTienda = $dataEnvio["id_destino"];
                                                    $q_sucursal = mysqli_query(
                                                        $MySQLi,
                                                        "SELECT * FROM sucursales WHERE idTienda='$idTienda'"
                                                    );
                                                    $d_sucursal = mysqli_fetch_assoc($q_sucursal);

                                                    echo  $d_sucursal["sucursal"] . '</td>';


                                                    $idVendedor  = $dataEnvio["id_user"];

                                                    $Vendedor = $dataEnvio["tecnico"];
                                                    echo '
									        	<td>' . $Vendedor . '</td>';

                                                    echo '
									        	<td class="text-center">' . $dataEnvio['fecha'] . " " . $dataEnvio['hora'] . '</td>';
                                                    if ($dataEnvio["estado"] == 0) {
                                                        echo '<td><button class="btn btn-block btn-info" style="pointer-events: none;">Procesando</button></td>';
                                                    } elseif ($dataEnvio["estado"] == 1) {
                                                        echo '<td><button class="btn btn-block btn-success">Completado</button></td>';
                                                    } else {
                                                        echo '<td><button class="btn btn-block btn-danger">Cancelado</button></td>';
                                                    }
                                                    echo '</td>
									        	<td class="text-center">';
                                                    $idEnvio = $dataEnvio["id_envio"];
                                                    if ($dataEnvio['estado'] == 0) {
                                                        echo '<button class="btn btn-sm btn-danger cancelarTodoEnvio" type="button" id=' . $idEnvio . ' title="Cancelar envio ' . $idEnvio . '" ><i class="fa fa-trash"></i></button>&nbsp;';
                                                    }
                                                    echo '
									            <!--<button class="btn btn-sm btn-warning verEnvio"><i class="fa fa-eye"></i></button>&nbsp;&nbsp;-->
									            <a target="_blank" href="reportes/reporte_envio.php?ReporteEnvioStock=' . $idEnvio . '" class="btn btn-sm btn-success" title="Descargar reporte de envio PDF" ><i class="fa fa-file-pdf"></i></a>
									        	</td></ tr>';
                                                    $idNumber++;
                                                } ?>
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
    <script src="assets/js/envios_lista.js"></script>
</body>

</html>