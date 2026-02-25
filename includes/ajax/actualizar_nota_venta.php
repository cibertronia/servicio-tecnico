<?php
include './../conexion.php';
error_reporting(0);
$idNotaE = $_POST['idNotaEntrega'];
$observaciones = $_POST['observaciones'];
$q_notaentrega = mysqli_query($MySQLi, "UPDATE `notaEntrega` SET `observaciones`='$observaciones' WHERE `idNotaE` ='$idNotaE'");

echo $q_notaentrega ?  json_encode('ok') : json_encode('error');
