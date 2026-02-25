<?php
include './../conexion.php';
session_start();
$idSoporte = $_POST['id'];

$sqlCotizacion = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE idSoporte='$idSoporte' ");
$d_soporte = mysqli_fetch_assoc($sqlCotizacion);
$sucursalCompra = $d_soporte['idSucursal'];
$codigoCotizacion = $d_soporte['clave_soporte'];
$idCliente = -1;
$clave = $d_soporte['clave_soporte'];

$NombreCliente = $d_soporte['nombreCliente'];
$nitCliente = '';

$ciudadCliente = $d_soporte['idSucursal'];
$q_ciudad = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$ciudadCliente' ");
$d_ciudad = mysqli_fetch_assoc($q_ciudad);
$ciudadCliente = $d_ciudad['sucursal'];

$correoCliente = '';

$idUsuario = $_SESSION['idUser'];
$sqlUsuario = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUsuario' ");
$dataUsuario = mysqli_fetch_assoc($sqlUsuario);
$nombreVendedor = $dataUsuario['Nombre'];

$sqlPrecioDolar = mysqli_query($MySQLi, "SELECT * FROM preciodolar ");
$dolarBd = mysqli_fetch_assoc($sqlPrecioDolar);

$sqlClave = mysqli_query($MySQLi, "SELECT * FROM clavetemporal WHERE claveTemporal='$clave' ");
//productos array
$datos = array();
$datos[0] = array(
    'activityEconomic' => '465000',
    'unitMeasure' => 62,
    'codeProductSin' => '99794',
    'codeProduct' => '$codeProduct',
    'description' => '$ProductoName',
    'qty' =>  1,
    'priceUnit' => 1,
    'idProducto' => 1,
);

$dataTotal = 1;

//superjson

$obj_merged = (object) [];

$obj_merged->idCotizacion = $idSoporte;
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
