<?php
error_reporting(0);
session_start();
include 'conexion.php';
include 'funciones.php';
include 'historial_repuestos/historial_stock_productos.php';
if (isset($_SESSION['idUser'])) {
    $idCotizacion = $_POST['idCotizacion'];

    //buscamos cotizacion por id
    $q_cotizacion = mysqli_query($MySQLi, "SELECT * FROM `cotizaciones` WHERE `idCotizacion` = '$idCotizacion' AND estado=2");
    $nro_resultados = mysqli_num_rows($q_cotizacion);
    if ($nro_resultados > 0) {
        $d_cotizacion = mysqli_fetch_assoc($q_cotizacion);
        $clave = $d_cotizacion['clave'];
        $idTienda = $d_cotizacion['idTienda'];


        //borramos el recibo
        mysqli_query($MySQLi, "DELETE FROM `recibos` WHERE `idCotizacion`='$idCotizacion' AND `claveCotizacion`='$clave'");

        //borramos el nota venta
        mysqli_query($MySQLi, "DELETE FROM `notaentrega` WHERE `idCotizacion`='$idCotizacion' AND `claveCotizacion`='$clave'");


        //Restaurar los productos de la venta a sus inventarios correspondientes
        $q_claveTemporal = mysqli_query($MySQLi, "SELECT idProducto, cantidad, idSucursal FROM ventas WHERE idCotizacion ='$idCotizacion'");
        while ($d_claveTemporal = mysqli_fetch_assoc($q_claveTemporal)) {
            $idProducto = $d_claveTemporal['idProducto'];
            $cantidadProducto = $d_claveTemporal['cantidad'];
            $idTienda2 = $d_claveTemporal['idSucursal'];
            
            $Q_Inventario = mysqli_query($MySQLi, "SELECT stock FROM inventario WHERE idProducto='$idProducto' AND idTienda='$idTienda2' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
            $dataInventario = mysqli_fetch_assoc($Q_Inventario);
            $stockProducto = $dataInventario['stock'];
            $nuevoStock = $stockProducto + $cantidadProducto;
            //historial stock cotizaciones
            registro_stock_repuestos($MySQLi, $idTienda, $idProducto, $stockProducto, $cantidadProducto, $nuevoStock, 'Adición Stock - Venta Eliminada', '+');

            mysqli_query($MySQLi, "UPDATE inventario SET stock='$nuevoStock' WHERE idProducto='$idProducto'AND idTienda='$idTienda' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
        }
        $q_venta_borrada = mysqli_query($MySQLi, "UPDATE cotizaciones SET estado ='0' WHERE idCotizacion='$idCotizacion' AND estado=2");

        // borrar de ventas buscar por cotizacion y clavecoti
        mysqli_query($MySQLi, "DELETE FROM `ventas` WHERE `idCotizacion`='$idCotizacion' AND `claveCotizacion` ='$clave'");

        //borrar de soporte_ventas buscar por cotizacion y clave 
        mysqli_query($MySQLi, "DELETE FROM `soporte_ventas` WHERE `idCotizacion`='$idCotizacion' AND `idSoporte`='0'");


        echo $q_venta_borrada ?  json_encode('ok') : json_encode('error');
    } else {
        echo json_encode('error');
    }
}
