<?php
session_start();
include './../includes/conexion.php';
include './../includes/date.php';
include './../includes/funciones.php';
include './../vendor/autoload.php';
include './../init.php';
include 'funciones_accionesRegistrados.php';
include './includes/historial_repuestos/historial_stock_productos.php';

$Acciones = filter_var($_POST['action'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
switch ($Acciones) {
    case 'agregarRepuestoClave':

        $idClave = $_POST['idClave'];
        $idProducto = $_POST['idProducto'];
        $idTienda = $_POST['idSucursal'];

        $queryRepuestos = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
        $dataProductos = mysqli_fetch_assoc($queryRepuestos);
        $nombre_repuesto = $dataProductos['mercaderia'] . " " . $dataProductos['nombre'] . " " . $dataProductos['marca'] . " " . $dataProductos['modelo'];

        $cantidad = $_POST['cantidad'];
        $precioVenta = $dataProductos['precio'];
        $precioEspecial = $_POST['precioEspecial'];
        $tipo_repuesto = 'repuesto_sistema';
        $insertDatos = mysqli_query(
            $MySQLi,
            "INSERT INTO soporte_claves_repuestos
            (idClave,idProducto,idTienda,nombre_repuesto,cantidad,precioVenta,precioEspecial,tipo_repuesto)
            VALUES ('$idClave', '$idProducto','$idTienda','$nombre_repuesto','$cantidad','$precioVenta','$precioEspecial','$tipo_repuesto') "
        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

        listarRepuestosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'agregarInsumoExterno':

        $idClave = $_POST['idClave'];
        $nombre_repuesto = $_POST['nombre_repuesto'];
        $idTienda = $_POST['idSucursal'];
        $cantidad = $_POST['cantidad'];
        $precioVenta = $_POST['precioEspecial'];
        $precioEspecial = $_POST['precioEspecial'];
        $tipo_repuesto = 'insumo_externo';
        $insertDatos = mysqli_query(
            $MySQLi,
            "INSERT INTO soporte_claves_repuestos
                (idClave,idTienda,nombre_repuesto,cantidad,precioVenta,precioEspecial,tipo_repuesto)
                VALUES ('$idClave','$idTienda','$nombre_repuesto','$cantidad','$precioVenta','$precioEspecial','$tipo_repuesto') "
        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

        listarInsumosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'ListarRepuestosEquipoidClave':
        //01 lista repuestos del equipo
        $idClave = $_POST['idClave'];
        listarRepuestosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'ListarInsumosExternosEquipo':
        //02 lista insumos externos Equipo
        $idClave = $_POST['idClave'];
        listarInsumosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'removerRepuestoDelDiagnostico':
        $idClave = $_POST['idClave'];
        $idClaveRepuesto = $_POST['idClaveRepuesto'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM soporte_claves_repuestos
        WHERE idClaveRepuesto = '$idClaveRepuesto'"
        );

        listarRepuestosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'removerInsumoDelDiagnostico':
        $idClave = $_POST['idClave'];
        $idClaveRepuesto = $_POST['idClaveRepuesto'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM soporte_claves_repuestos
            WHERE idClaveRepuesto = '$idClaveRepuesto'"
        );

        listarInsumosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'btnActualizarPrecioAsistenciaTecnica':
        $idClave = $_POST['idClave'];
        $costo = $_POST['costo'];
        $realizar = $_POST['realizar'];
        $update_costo = mysqli_query(
            $MySQLi,
            "UPDATE soporte_claves
            SET costo = '$costo',realizar='$realizar'
            WHERE idClave='$idClave'"
        );
        mostrarCostoDiagnosticoEquipo($MySQLi, $idClave);
        break;
    case 'removerCostoDelDiagnostico_victor':
        $idClave = $_POST['idClave'];
        $idClaveRepuesto = $_POST['idClaveRepuesto'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "update soporte_claves set costo = null, realizar = null WHERE idClave = '$idClave'"
        );

        //   listarInsumosExternosEquipo_idClave($MySQLi, $idClave);
        mostrarCostoDiagnosticoEquipo($MySQLi, $idClave);
        break;        
    case 'ListarPrecioAsistenciaTecnica':
        //02 lista insumos externos Equipo
        $idClave = $_POST['idClave'];
        mostrarCostoDiagnosticoEquipo($MySQLi, $idClave);

        break;
    case 'ListarServiciosExternos':
        //04 lista servicios externos Equipo
        $idClave = $_POST['idClave'];
        listarServiciosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'agregarServicioExterno':

        $idClave = $_POST['idClave'];
        $nombre_repuesto = $_POST['nombre_repuesto'];
        $idTienda = $_POST['idSucursal'];
        $cantidad = $_POST['cantidad'];
        $precioVenta = $_POST['precioEspecial'];
        $precioEspecial = $_POST['precioEspecial'];
        $tipo_repuesto = 'servicio_externo';
        $insertDatos = mysqli_query(
            $MySQLi,
            "INSERT INTO soporte_claves_repuestos
                    (idClave,idTienda,nombre_repuesto,cantidad,precioVenta,precioEspecial,tipo_repuesto)
                    VALUES ('$idClave','$idTienda','$nombre_repuesto','$cantidad','$precioVenta','$precioEspecial','$tipo_repuesto') "
        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

        listarServiciosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'removerServicioExternoDelDiagnostico':
        $idClave = $_POST['idClave'];
        $idClaveRepuesto = $_POST['idClaveRepuesto'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM soporte_claves_repuestos
                WHERE idClaveRepuesto = '$idClaveRepuesto'"
        );

        listarServiciosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'mostrar_costoTotalDiagnostico':
        $idClave = $_POST['idClave'];
        $idClaveRepuesto = $_POST['idClaveRepuesto'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM soporte_claves_repuestos
                    WHERE idClaveRepuesto = '$idClaveRepuesto'"
        );

        listarServiciosExternosEquipo_idClave($MySQLi, $idClave);

        break;
    case 'agregarOtrosGastosPrecio':

        $idClave = $_POST['idClave'];
        $nombre_repuesto = $_POST['nombre_repuesto'];
        $idTienda = $_POST['idSucursal'];
        $cantidad = $_POST['cantidad'];
        $precioVenta = $_POST['precioEspecial'];
        $precioEspecial = $_POST['precioEspecial'];
        $tipo_repuesto = 'otros_gastos';
        $insertDatos = mysqli_query(
            $MySQLi,
            "INSERT INTO soporte_claves_repuestos
                        (idClave,idTienda,nombre_repuesto,cantidad,precioVenta,precioEspecial,tipo_repuesto)
                        VALUES ('$idClave','$idTienda','$nombre_repuesto','$cantidad','$precioVenta','$precioEspecial','$tipo_repuesto') "
        ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);

        listarOtrosGastos($MySQLi, $idClave);

        break;
    case 'removerOtrosGastosDelDiagnostico':
        $idClave = $_POST['idClave'];
        $idClaveRepuesto = $_POST['idClaveRepuesto'];

        $delete_repuesto = mysqli_query(
            $MySQLi,
            "DELETE FROM soporte_claves_repuestos
                    WHERE idClaveRepuesto = '$idClaveRepuesto'"
        );

        listarOtrosGastos($MySQLi, $idClave);

        break;
    case 'ListarOtrosGastos':
        //05 lista OtrosGastos Equipo
        $idClave = $_POST['idClave'];
        listarOtrosGastos($MySQLi, $idClave);

        break;
    case 'IngresarTallerEquipos':
        if (isset($_SESSION['idUser'])) {
            $sucursal = $_POST['sucursal']; //ok
            $idSucursal = $_POST['idSucursal']; //ok
            $clave = $_POST['clave']; //ok
            /********************************/

            mysqli_query(
                $MySQLi,
                "UPDATE soporte_claves SET  estado=1 WHERE clave='$clave' AND sucursal='$sucursal' AND idSucursal='$idSucursal' AND estado=0"
            );
            mysqli_query($MySQLi, "UPDATE soporte_sucursales SET estado=1 WHERE clave_soporte='$clave' AND idSucursal='$idSucursal' ");

            $query_equipos_agregados_al_taller = mysqli_query(
                $MySQLi,
                "SELECT * FROM soporte_claves WHERE  estado='1' AND clave='$clave' AND sucursal='$sucursal' AND idSucursal='$idSucursal' "
            );

            while ($data_equipos = mysqli_fetch_assoc($query_equipos_agregados_al_taller)) {

                $idClave = $data_equipos['idClave'];

                $query_repuestos = mysqli_query(
                    $MySQLi,
                    "SELECT * FROM soporte_claves_repuestos
                    WHERE idClave='$idClave'"
                );

                while ($data_repuestos = mysqli_fetch_assoc($query_repuestos)) {

                    $idProducto = $data_repuestos['idProducto'];
                    if ($idProducto != null) {
                        $idTienda = $data_repuestos['idTienda'];
                        $cantidad = $data_repuestos['cantidad'];

                        $query_inventario = mysqli_query(
                            $MySQLi,
                            "SELECT *
                        FROM inventario
                        WHERE  idProducto='$idProducto'
                        AND idTienda='$idTienda'"
                        );

                        $data_inventario = mysqli_fetch_assoc($query_inventario);
                        $stockOriginal = $data_inventario['stock'];
                        $nuevoStock = $stockOriginal - $cantidad;

                        registro_stock_repuestos($MySQLi, $idTienda, $idProducto, $stockOriginal, $cantidad, $nuevoStock, 'Descuento Stock Servicio Técnico', '-');

                        mysqli_query(
                            $MySQLi,
                            "UPDATE inventario SET  stock='$nuevoStock'
                        WHERE idProducto='$idProducto'
                        AND idTienda='$idTienda'"
                        );
                    }
                }
            }

            costosIngresados();
        } else {
            expirado($MySQLi);
        }
        break;
    case 'agregarOtroEquipo':
        if (isset($_SESSION['idUser'])) {
            $claveServicio = $_POST['Clave'];
            $equipo = $_POST['equipo'];
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $serie = $_POST['serie'];
            $problema = $_POST['problema'];
            $observaciones = $_POST['observaciones'];
            $fechaCompra = $_POST['fechaCompra'];
            if ($fechaCompra == '') {

                $fechaCompra = '0000-00-00';
            }

            $garantiaEquipoRepuesto = $_POST['garantiaEquipoRepuesto']; //nuevos campos
            $garantiaEquipoMano = $_POST['garantiaEquipoMano']; //nuevos campos
            $notaEntrega = $_POST['notaEntrega'];

            $sucursal = $_POST['sucursal'];
            $idSucursal = $_POST['idSucursal'];

            $insertDatos = mysqli_query(
                $MySQLi,
                "INSERT INTO soporte_claves (sucursal,idSucursal,
             clave, equipo, marca, modelo, serie, problema,
           observaciones, fechaCompra,garantia_vigente_repuesto,garantia_vigente_mano,notaEntrega)
            VALUES ('$sucursal', '$idSucursal',
             '$claveServicio', '$equipo', '$marca', '$modelo', '$serie', '$problema',
              '$observaciones',  '$fechaCompra','$garantiaEquipoRepuesto','$garantiaEquipoMano','$notaEntrega') "
            ) or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
        } else {
            expirado($MySQLi);
        }
        break;
    case 'guardar_encargado_diagnostico':
        if (isset($_SESSION['idUser'])) {
            $idClave = $_POST['idClave']; //para buscar en soporte claves
            $encargado_diagnostico = $_POST['encargado_diagnostico']; //para insertar en soporte_sucursal

            $q_soporte_claves = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE idClave='$idClave' ");
            $d_soporte_claves = mysqli_fetch_assoc($q_soporte_claves);
            $clave = $d_soporte_claves['clave'];
            //echo $clave;
            $u_soporte_sucursales = mysqli_query($MySQLi, "UPDATE `soporte_sucursales` SET `encargado_diagnostico`='$encargado_diagnostico' WHERE `clave_soporte`='$clave'");
            echo $u_soporte_sucursales ? json_encode('ok') : json_encode('Error al guardar encargado diagnostico');
        } else {
            expirado($MySQLi);
        }
        break;

    default:
        alert_peticionDesconocida();
        break;
}
