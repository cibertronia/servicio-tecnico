<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Enviar Repuestos - ' . APP_TITLE;
$_active_nav = 'Enviar'; ?>
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

                        <div class="col">
                            <div id="registrados_lista" class="panel">
                                <div class="panel-hdr">
                                    <h2>Enviar <span class="fw-300"><i>Repuestos</i></span> &nbsp; &nbsp;

                                    </h2>

                                    <div class="panel-toolbar">
                                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                                    </div>
                                </div>
                                <div class="panel-container">
                                    <?php
                                    $alert = aleatorio();
                                    $claveSoporte = md5(date("d/m/Y g:i:s") . $alert);
                                    ?>
                                    <input type="hidden" name="clave" id="clave" value="<?= $claveSoporte ?>">

                                    <form class="p-5">
                                        <h1 class="mb-4">ENVÍO DE MERCADERÍA</h1>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <h3>Sucursal origen</h3>
                                                <div class="form-group">
                                                    <label for="sucursal_origen">Selecciona una sucursal:</label>
                                                    <select name="sucursal_origen" id="sucursal_origen" class="form-control">
                                                        <?php
                                                        // include './../includes/conexion.php';
                                                        $q_sucursal = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda ='$idTiendaDf'");
                                                        while ($d_sucursal = mysqli_fetch_assoc($q_sucursal)) {
                                                            echo "<option value=" . $d_sucursal['idTienda'] . ">" .
                                                                " [Sucursal]:  " . $d_sucursal['sucursal'] . " " .
                                                                "</option>";
                                                        }
                                                        ?>
                                                    </select>

                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <h3>Sucursal destino</h3>
                                                <div class="form-group">
                                                    <label for="sucursal_destino">Selecciona una sucursal:</label>
                                                    <select name="sucursal_destino" id="sucursal_destino" class="form-control">
                                                        <?php
                                                        // include './../includes/conexion.php';
                                                        $q_sucursal = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda <>'$idTiendaDf'");
                                                        while ($d_sucursal = mysqli_fetch_assoc($q_sucursal)) {
                                                            echo "<option value=" . $d_sucursal['idTienda'] . ">" .
                                                                " [Sucursal]:  " . $d_sucursal['sucursal'] . " " .
                                                                "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="tecnico">Nombre Tecnico Encargado</label><span class="text-danger"> *</span>
                                                    <input type="text" id="tecnico" name="tecnico" class="form-control" value="<?= $nombreUsuarioDf ?>">
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="observaciones">Observaciones Envio</label>
                                                    <textarea rows="3" type="text" name="observaciones" id="observaciones" class="form-control" placeholder="Utilice este espacio si necesita agregar algun comentario."></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <button class="btn btn-primary btn-block" id="btn_agregar_repuesto_cola" type="button" data-toggle="modal" data-target="#modal_agregar_repuestos_sistema" data-dismiss="modal">
                                                        <i class="far fa-barcode fa-lg">
                                                        </i> &nbsp;&nbsp;AGREGAR REPUESTOS DEL SISTEMA
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <button class="btn btn-secondary btn-block" id="btn_agregar_extras" type="button" data-toggle="modal" data-target="#modal_agregar_extras" data-dismiss="modal">
                                                        <i class="fa fa-archive fa-lg">
                                                        </i> &nbsp;&nbsp;AGREGAR ELEMENTOS ADICIONALES
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="resp_cola_temporal">
                                                </div>
                                                <div class="respuesta_terminar_envio"></div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col">
                                                <div class="resp_cola_extras">
                                                </div>
                                                <!-- <div class="respuesta_terminar_envio"></div> -->
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                    <button type="button" id="terminar_envio" class="btn btn-success btn-block"><i class="fa fa-paper-plane fa-lg">
                                                        </i> &nbsp;&nbsp;PROCEDER AL ENVIO -
                                                        FINALIZAR ENVIO</button>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>&nbsp;</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
                <?php include_once APP_PATH . '/includes/footer.php'; ?>
            </div>
        </div>


        <!-- Modal agregar repuestos del sistema para envio-->
        <div id="modal_agregar_repuestos_sistema" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!--=====================================
                        CABEZA DEL MODAL 2
                        ======================================-->
                    <div class="modal-header">

                        <h4 class="modal-title"> <strong><span>ENVIAR REPUESTOS DEL SISTEMA</span></strong> </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <!--=====================================
                        CUERPO DEL MODAL 2
                        ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="row">
                                <div class="col">

                                    <div class="form-group">
                                        <label for="producto">Lista Repuestos: [Mercaderia][Nombre][Stock][Precio Venta]</label>
                                        <select name="repuestos_enviar" id="repuestos_enviar" class="form-control">
                                            <option disabled selected value="null">Seleccione Repuesto
                                                del Sistema a Enviar
                                            </option>
                                            <?php
                                            // include './../includes/conexion.php';
                                            $queryRepuestos = mysqli_query($MySQLi, "SELECT * FROM productos ORDER BY mercaderia ASC");

                                            while ($dataProductos = mysqli_fetch_assoc($queryRepuestos)) {

                                                $idProducto = $dataProductos['idProducto'];

                                                $queryInventario = mysqli_query(
                                                    $MySQLi,
                                                    "SELECT * FROM inventario WHERE idProducto ='$idProducto' AND idTienda ='$idTiendaDf'"
                                                );
                                                $dataInventario = mysqli_fetch_assoc($queryInventario);
                                                $stock = $dataInventario['stock'];
                                                if ($stock > 0) {
                                                    echo "<option value=" . $dataProductos['idProducto'] . " st=" . $stock . " " . "> " .
                                                        $dataProductos['mercaderia'] . " " .
                                                        $dataProductos['nombre'] . " " .
                                                        $dataProductos['marca'] . " " .
                                                        $dataProductos['modelo'] . "  " .
                                                        " [STOCK " . $sucurUsuarioDf . "]= " . $stock . " " .
                                                        " [PRECIO VENTA]= " . $dataProductos['precio'] . " " .
                                                        "</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="stock_actual">Stock Actual Del Repuesto:</label>
                                        <input readonly type="number" id="stock_actual" name="stock_actual" class="form-control">
                                    </div>
                                    <style>
                                        input[type="number"] {
                                            text-align: center;
                                            direction: rtl;
                                        }
                                    </style>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cantidad">Cantidad a Enviar:</label>
                                        <input type="number" min='0' id="cantidad" name="cantidad" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <hr>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-2">
                            </div>
                            <div class="col">
                                <button type="button" id="agregar-repuesto" class="btn btn-primary form-control">Agregar Repuesto a la
                                    lista para Envio</button>
                            </div>
                            <div class="col-2">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Modal agregar elementos adicionales para envio-->
        <div id="modal_agregar_extras" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <!--=====================================
                        CABEZA DEL MODAL 2
                        ======================================-->
                    <div class="modal-header">
                        <h4 class="modal-title"> <strong><span>ENVIAR ELEMENTOS ADICIONALES</span></strong> </h4>
                        <button type="button" class="close cerrar_modal_extras" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <!--=====================================
                        CUERPO DEL MODAL 2
                        ======================================-->
                    <div class="modal-body">
                        <div class="box-body">
                            <div class="row">
                                <!-- <div class="col">
                                    <div class="form-group">
                                        <label for="nombre_extra">Nombre Elemento Adicional</label>
                                        <input type="text" id="nombre_extra" name="nombre_extra" class="form-control" placeholder="Nombre del elemento Adicional que se agregara a la lista de envios">
                                    </div>
                                </div> -->
                                <div class="col">
                                    <label for="nombre_extra" class="form-label">Nombre Elemento Adicional<span class="text-danger"> (*)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="nombre_extra"><i class="fad fa-archive"></i></label>
                                        </div>
                                        <input type="text" name="nombre_extra" id="nombre_extra" class="form-control" placeholder="Nombre Elemento Adicional">
                                    </div>
                                </div>

                            </div>
                            <div class="row mt-2">
                                <!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="cantidad_extra">Cantidad Elemento Adicional</label>
                                        <input type="number" min='1' id="cantidad_extra" name="cantidad_extra" class="form-control" value="1">
                                    </div>
                                </div> -->
                                <div class="col">
                                    <label for="cantidad_extra" class="form-label">Cantidad Elemento Adicional<span class="text-danger"> (*)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="cantidad_extra"><i class="fa fa-briefcase"></i></label>
                                        </div>
                                        <input type="number" min='1' value="1" name="cantidad_extra" id="cantidad_extra" class="form-control" placeholder="Cantidad">
                                    </div>
                                </div>
                                <!-- <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="precio_extra">Precio Unidad<span class="text-danger"> (Opcional)</span></label>
                                        <input type="number" min='0' id="precio_extra" name="precio_extra" class="form-control" value="0">
                                    </div>
                                </div> -->
                                <div class="col">
                                    <label for="precio_extra" class="form-label">Precio Unidad<span class="text-danger"> (Opcional)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="precio_extra"><i class="fa fa-credit-card"></i></label>
                                        </div>
                                        <input type="number" min='0' value="0" name="precio_extra" id="precio_extra" class="form-control" placeholder="Marca">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="marca_extra" class="form-label">Marca<span class="text-danger"> (Opcional)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="marca_extra"><i class="fa fa-briefcase"></i></label>
                                        </div>
                                        <input type="text" name="marca_extra" id="marca_extra" class="form-control" placeholder="Marca">
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="modelo_extra" class="form-label">Modelo<span class="text-danger"> (Opcional)</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="modelo_extra"><i class="fa fa-briefcase"></i></label>
                                        </div>
                                        <input type="text" name="modelo_extra" id="modelo_extra" class="form-control" placeholder="Modelo">
                                    </div>
                                </div>

                            </div>

                        </div>
                        <hr>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-1">
                            </div>
                            <div class="col">
                                <button type="button" id="btn_agregar_elemento_extra" class="btn btn-primary form-control">Agregar Elemento Adicional a
                                    lista para Envio</button>
                            </div>
                            <div class="col-1">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script src="assets/js/enviar_repuestos.js"></script>
</body>

</html>