<?php
include './../conexion.php';
error_reporting(0);
$idNotaE = $_POST['idNotaEntrega'];
$q_notaentrega = mysqli_query($MySQLi, "SELECT * FROM `notaEntrega` WHERE `idNotaE` ='$idNotaE'");
$d_notaentrega = mysqli_fetch_assoc($q_notaentrega);

echo json_encode($d_notaentrega);
