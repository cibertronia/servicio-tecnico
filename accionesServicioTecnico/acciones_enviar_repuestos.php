<?php
session_start();
error_reporting(0);
include './../includes/conexion.php';
include './../includes/date.php';
include './../includes/funciones.php';
include './../vendor/autoload.php';
include './../init.php';
include 'funciones_accionesRegistrados.php';
include './includes/historial_repuestos/historial_stock_envios.php';

$Acciones = filter_var($_POST['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
switch ($Acciones) {
    case 'agregar_repuesto_cola':

        $clave = $_POST['clave'];
        $id_producto = $_POST['id_producto'];
        $cantidad = $_POST['cantidad'];

        $insertDatos = mysqli_query(
            $MySQLi,
            "INSERT INTO `envio_claves`(`clave`, `id_producto`, `cantidad`)
             VALUES ('$clave','$id_producto','$cantidad')"
        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

        listar_envio_temporal($MySQLi, $clave);

        break;
    case 'remover_repuesto_temporal':
        $clave = $_POST['clave'];
        $id_clave = $_POST['id_clave'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM envio_claves
            WHERE id_clave = '$id_clave'"
        );

        listar_envio_temporal($MySQLi, $clave);

        break;
    case 'guardar_envio_stock':
        if (isset($_SESSION['idUser'])) {

            $clave = $_POST['clave'];
            $id_user = $_SESSION['idUser'];
            $id_origen = $_POST['id_origen'];
            $id_destino = $_POST['id_destino'];
            $tecnico = $_POST['tecnico'];
            $observaciones = $_POST['observaciones'];

            //GUARDAR ENVIO
            $q_guardar_envio = mysqli_query(
                $MySQLi,
                "INSERT INTO `envio_stock`(`clave`, `id_user`, `id_origen`, `id_destino`, `tecnico`, `observaciones`, `fecha`, `hora`, `estado`) 
                VALUES ('$clave','$id_user','$id_origen','$id_destino','$tecnico','$observaciones','$fecha','$hora','0')"
            );
            //ACTUALIZAR INVENTARIO
            $q_claves = mysqli_query($MySQLi, "SELECT * FROM envio_claves WHERE clave='$clave'");
            while ($d_claves = mysqli_fetch_assoc($q_claves)) {
                $id_producto = $d_claves['id_producto'];

                $q_inventario = mysqli_query($MySQLi, "SELECT * FROM inventario WHERE idProducto='$id_producto' AND idTienda='$id_origen'");
                $d_inventario = mysqli_fetch_assoc($q_inventario);

                $stock_actual = $d_inventario['stock']; //cantidad en inventario actual
                $cantidad = $d_claves['cantidad']; //cantidad extraer o enviar
                $stock_nuevo = $stock_actual - $cantidad; //nuevo stock
                registro_stock_envios($MySQLi, $id_origen, $id_producto, $stock_actual, $cantidad, $stock_nuevo, 'Descuento Envió', '-');
                //actualizamos
                $q_update_inventario = mysqli_query(
                    $MySQLi,
                    "UPDATE inventario SET stock='$stock_nuevo' WHERE idProducto='$id_producto' AND idTienda='$id_origen'"
                );
            }

            if ($q_guardar_envio && $q_update_inventario) {
                echo json_encode('ok');
            } else {
                echo json_encode('error');
            }
        }
        break;
    case 'cancelarProcesoStock':
        if (isset($_SESSION['idUser'])) {
            $id_envio                             = $_POST['idEnvio'];
            $sqlEnvioStock                 = mysqli_query($MySQLi, "SELECT * FROM envio_stock WHERE id_envio='$id_envio' AND estado='0' ");
            $cantidad_registros = mysqli_num_rows($sqlEnvioStock);
            if ($cantidad_registros > 0) {
                $dataEnvio                         = mysqli_fetch_assoc($sqlEnvioStock);

                $clave                     = $dataEnvio['clave'];
                $id_origen                       = $dataEnvio['id_origen'];

                $sqlClaves                         = mysqli_query($MySQLi, "SELECT * FROM envio_claves WHERE clave='$clave'");
                while ($dataClave         = mysqli_fetch_assoc($sqlClaves)) {
                    $id_producto                 = $dataClave['id_producto'];
                    $sqlProducto                 = mysqli_query($MySQLi, "SELECT * FROM inventario WHERE idProducto='$id_producto' AND idTienda='$id_origen'");
                    $data_Producto             = mysqli_fetch_assoc($sqlProducto);

                    $stockActual                 = $data_Producto['stock']; //cantidad en inventario actual
                    $cantidad                     = $dataClave['cantidad']; //cantidad devolver
                    $stock_nuevo = $stockActual + $cantidad;
                    registro_stock_envios($MySQLi, $id_origen, $id_producto, $stockActual, $cantidad, $stock_nuevo, 'Envió Cancelado', '+');
                    //actualizar
                    $q_update_inventario = mysqli_query(
                        $MySQLi,
                        "UPDATE inventario SET stock='$stock_nuevo' WHERE idProducto='$id_producto' AND idTienda='$id_origen' "
                    );
                }
                $q_update_envio = mysqli_query($MySQLi, "UPDATE envio_stock SET estado=2 WHERE id_envio='$id_envio' ");

                if ($q_update_envio && $q_update_inventario) {
                    echo json_encode('ok');
                } else {
                    echo json_encode('error');
                }
            } else {
                echo json_encode('error');
            }
        }
        break;
    case 'confirmarEnvioStock': //trabajar aki
        if (isset($_SESSION['idUser'])) {
            $id_envio = $_POST['idEnvio'];
            $q_envios = mysqli_query($MySQLi, "SELECT * FROM envio_stock WHERE id_envio='$id_envio' AND estado='0'");
            $cantidad_registros = mysqli_num_rows($q_envios);
            if ($cantidad_registros > 0) {
                $d_envios = mysqli_fetch_assoc($q_envios);

                $clave = $d_envios['clave'];
                $id_destino = $d_envios['id_destino'];

                $q_claves     = mysqli_query($MySQLi, "SELECT * FROM envio_claves WHERE clave='$clave'");
                while ($d_claves = mysqli_fetch_assoc($q_claves)) {
                    $id_producto = $d_claves['id_producto'];

                    $q_inventario = mysqli_query($MySQLi, "SELECT * FROM inventario WHERE idProducto='$id_producto' AND idTienda='$id_destino'");
                    $d_inventario = mysqli_fetch_assoc($q_inventario);

                    $stock_actual = $d_inventario['stock']; //cantidad en inventario actual
                    $cantidad = $d_claves['cantidad']; //cantidad adicionar por recepcion
                    $stock_nuevo = $stock_actual + $cantidad; //nuevo stock
                    registro_stock_envios($MySQLi, $id_destino, $id_producto, $stock_actual, $cantidad, $stock_nuevo, 'Envió recibido', '+');
                    //actualizamos
                    $q_update_inventario = mysqli_query(
                        $MySQLi,
                        "UPDATE inventario SET stock='$stock_nuevo' WHERE idProducto='$id_producto' AND idTienda='$id_destino'"
                    );
                }

                date_default_timezone_set('America/La_Paz');
                $fecha_recibido = date('c');

                $q_guardar_envio = mysqli_query($MySQLi, "UPDATE envio_stock SET estado='1', fecha_recibido='$fecha_recibido' WHERE id_envio='$id_envio'");
                if ($q_guardar_envio && $q_update_inventario) {
                    echo json_encode('ok');
                } else {
                    echo json_encode('error');
                }
            } else {
                echo json_encode('error');
            }
        }
        break;

    case 'agregar_elemento_extra_cola':

        $clave = $_POST['clave'];
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];
        $precio = $_POST['precio'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];

        $insertDatos = mysqli_query(
            $MySQLi,
            "INSERT INTO `envio_extras`(`clave`, `nombre`, `cantidad`,`precio`,`marca`,`modelo`)
                 VALUES ('$clave','$nombre','$cantidad','$precio','$marca','$modelo')"
        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

        listar_elementos_extras_temporales($MySQLi, $clave);

        break;
    case 'remover_elemento_extra_temporal':
        $clave = $_POST['clave'];
        $id = $_POST['id'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM envio_extras
                WHERE id = '$id'"
        );
        listar_elementos_extras_temporales($MySQLi, $clave);
        break;

    default:
        alert_peticionDesconocida();
        break;
}
function listar_envio_temporal($MySQLi, $clave)
{
?>
    <h3>Lista Repuestos-Sistema para ser enviados:</h3>
    <table id="tabla_temporales" class="table table-striped table-bordered table-td-valign-middle w-100">
        <thead>
            <tr>
                <th class="text-center btn-primary">N&ordm;</th>
                <th class="text-center btn-primary">Nombre Repuesto</th>
                <th class="text-center btn-primary">Cantidad a Enviar</th>
                <th class="text-center btn-primary">Eliminar de la lista</th>
            </tr>
        </thead>
        <tbody><?php
                $num = 1;
                $Q_Service = mysqli_query($MySQLi, "SELECT * FROM envio_claves WHERE clave='$clave'");
                $cantidad_temporales = mysqli_num_rows($Q_Service);
                while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) { ?>
                <tr>
                    <td class="text-center"><?php echo $num;
                                            $num++; ?></td>
                    <td>
                        <?php
                        $idProducto = $dataRegistros['id_producto'];
                        $queryRepuestos = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto'");
                        $dataProductos = mysqli_fetch_assoc($queryRepuestos);
                        echo $dataProductos['nombre'] . " " .
                            $dataProductos['marca'] . " " .
                            $dataProductos['modelo'];

                        ?>
                    </td>
                    <td class="text-center"><?= $dataRegistros['cantidad'] ?></td>

                    <td class="text-center">
                        <button id="<?= $dataRegistros['id_clave'] ?>" class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed remover_repuesto_temporal" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="Remover Repuesto De La Lista <?= $dataRegistros['id_clave'] ?>" data-original-title="">
                            <i class="ni ni-ban"></i>
                        </button>
                    </td>
                </tr>
            <?php }


            ?>
        </tbody>
    </table>
    <input type="hidden" id="cantidad_temporales" name="cantidad_temporales" value="<?php echo $cantidad_temporales; ?>">
<?php
}

function listar_elementos_extras_temporales($MySQLi, $clave)
{
?>
    <h3>Lista Elementos Adicionales para ser enviados:</h3>
    <table id="tabla_temporales" class="table table-striped table-bordered table-td-valign-middle w-100">
        <thead>
            <tr>
                <th class="text-center btn-secondary">N&ordm;</th>
                <th class="text-center btn-secondary">Nombre Elemento Adicional</th>
                <th class="text-center btn-secondary">Cantidad</th>
                <th class="text-center btn-secondary">Precio Unidad<span class="text-warning"> (Opcional)</span></th>
                <th class="text-center btn-secondary">Eliminar de la lista</th>
            </tr>
        </thead>
        <tbody><?php
                $num = 1;
                $Q_Service = mysqli_query($MySQLi, "SELECT * FROM envio_extras WHERE clave='$clave'");
                $cantidad_temporales = mysqli_num_rows($Q_Service);
                while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) { ?>
                <tr>
                    <td class="text-center"><?php echo $num;
                                            $num++; ?></td>
                    <td>
                        <?php
                        echo  $dataRegistros['nombre'] . ' ' . $dataRegistros['marca'] . ' ' . $dataRegistros['modelo'];
                        ?>
                    </td>
                    <td class="text-center"><?= $dataRegistros['cantidad'] ?></td>
                    <td class="text-center"><?= $dataRegistros['precio'] ?></td>

                    <td class="text-center">
                        <button id="<?= $dataRegistros['id'] ?>" class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed remover_elemento_extra_temporal" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="Remover Repuesto De La Lista <?= $dataRegistros['id'] ?>" data-original-title="">
                            <i class="ni ni-ban"></i>
                        </button>
                    </td>
                </tr>
            <?php }


            ?>
        </tbody>
    </table>
    <input type="hidden" id="cantidad_temporales" name="cantidad_temporales" value="<?php echo $cantidad_temporales; ?>">
<?php
}
