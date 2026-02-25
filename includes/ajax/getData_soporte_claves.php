<?php
include './../conexion.php';
error_reporting(0);
$idClave = $_POST['idClave'];
$queryEquipo = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE idClave='$idClave' ");
$dataEquipo = mysqli_fetch_assoc($queryEquipo);
$clave = $dataEquipo['clave'];

$q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM soporte_sucursales WHERE clave_soporte='$clave'");
$d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
//$encargado_diagnostico = $d_soporte_sucursales['encargado_diagnostico'];

$dataEquipo['encargado_diagnostico'] = $d_soporte_sucursales['encargado_diagnostico'];

echo json_encode($dataEquipo);
