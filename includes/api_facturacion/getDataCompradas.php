<?php
include './../conexion.php';
session_start();
$idCotizacion = $_POST['id'];

$sqlCotizacion = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE idCotizacion='$idCotizacion' ");
$dataCotiza = mysqli_fetch_assoc($sqlCotizacion);
$sucursalCompra = $dataCotiza['idTienda'];
$codigoCotizacion = $dataCotiza['codigo'];
$idCliente = $dataCotiza['idCliente'];
$idUsuario = $dataCotiza['idUser'];
$clave = $dataCotiza['clave'];

$sqlCliente = mysqli_query($MySQLi, "SELECT * FROM clientes WHERE idCliente='$idCliente' ");
$dataCliente = mysqli_fetch_assoc($sqlCliente);
$NombreCliente = $dataCliente['nombre'];
$nitCliente = '';

$ciudadCliente = $dataCliente['idCiudad'];
$q_ciudad = mysqli_query($MySQLi, "SELECT * FROM ciudades WHERE idCiudad='$ciudadCliente' ");
$d_ciudad = mysqli_fetch_assoc($q_ciudad);
$ciudadCliente=$d_ciudad['ciudad'];

$correoCliente = $dataCliente['correo'];

$sqlUsuario = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUsuario' ");
$dataUsuario = mysqli_fetch_assoc($sqlUsuario);
$nombreVendedor = $dataUsuario['Nombre'];

$sqlPrecioDolar = mysqli_query($MySQLi, "SELECT * FROM preciodolar ");
$dolarBd = mysqli_fetch_assoc($sqlPrecioDolar);

$sqlClave = mysqli_query($MySQLi, "SELECT * FROM clavetemporal WHERE claveTemporal='$clave' ");
//productos array
$datos = array();
$_SESSION["carrito"] = [];
$count = 0;
while ($data = mysqli_fetch_assoc($sqlClave)) {

    $idProducto = $data['idProducto'];
    $sqlProducto = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
    $dataProducto = mysqli_fetch_assoc($sqlProducto);
    $codeProduct = $dataProducto['modelo'];
    $codeProductSin = '99794';//usar codesin mas usado mejor si es desde bd
    $ProductoName = $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'];

    $qty = $data['cantidad'];
    $priceUnit = number_format(($data['precioEspecial']), 2, ".", "");

    $datos[$count] = array(
        'activityEconomic' => '465000',
        'unitMeasure' => 62,
        'codeProductSin' => $codeProductSin,
        'codeProduct' => $codeProduct,
        'description' => $ProductoName,
        'qty' => (int) $qty,
        'priceUnit' => $priceUnit,
        'idProducto' => $idProducto,
    );
    $count++;
}
$_SESSION["carrito"] = $datos;

$sqlClave2 = mysqli_query($MySQLi, "SELECT SUM(cantidad*precioEspecial)AS total FROM clavetemporal WHERE claveTemporal='$clave' ");
$dataTotal = mysqli_fetch_assoc($sqlClave2);
$dataTotal = number_format($dataTotal['total'], 2, ".", "");

//superjson
//$obj_merged = (object) array_merge((array) $dataCotiza, (array) $dataCliente,(array) $dataUsuario);

$obj_merged = (object) [];

$obj_merged->idCotizacion = $idCotizacion;
$obj_merged->sucursalCompra = $sucursalCompra;
$obj_merged->codigoCotizacion = $codigoCotizacion;
$obj_merged->idCliente = $idCliente;

$obj_merged->idUsuario = $idUsuario;
$obj_merged->clave = $clave;
$obj_merged->NombreCliente = $NombreCliente;

$obj_merged->nitCliente = $nitCliente;
$obj_merged->ciudadCliente = $ciudadCliente;
$obj_merged->correoCliente = $correoCliente;

$obj_merged->nombreVendedor = $nombreVendedor;
$obj_merged->productosVendidos = $datos; //array con los productos vendidos
$obj_merged->dataTotal = $dataTotal;

echo json_encode($obj_merged);
