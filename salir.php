<?php
	include 'includes/conexion.php';
	session_start();
	$idUser 	= $_SESSION['idUser'];
	mysqli_query($MySQLi,"UPDATE usuarios SET onLine=0 WHERE idUser='$idUser' ");
	session_destroy();
	header("Location: / ");	
?>