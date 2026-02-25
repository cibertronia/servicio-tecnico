<?php
include './../conexion.php';
error_reporting(0);
$idClave = $_POST['idClave'];
$queryRepuestosEquipo = mysqli_query($MySQLi, 
"SELECT 
SUM(`cantidad`*`precioEspecial`) totalDiagnosticoRepuestos 
FROM soporte_claves_repuestos 
WHERE `idClave`='$idClave'");
$dataRepuestos = mysqli_fetch_assoc($queryRepuestosEquipo);


$queryManoObra = mysqli_query($MySQLi, "SELECT costo FROM soporte_claves WHERE idClave='$idClave' ");
$costoManoObra = mysqli_fetch_assoc($queryManoObra);

$totalDiagnostico=$dataRepuestos['totalDiagnosticoRepuestos']+$costoManoObra['costo'];

$obj = (object) [];
$obj->totalDiagnostico = $totalDiagnostico;

echo json_encode($obj);

