<?php
session_start();
include 'includes/conexion.php';
if (isset($_SESSION['time'])) {
	include 'includes/default.php';
	include 'includes/funciones.php';
	include 'includes/date.php';
	$pagina = isset($_GET['root']) ? $_GET['root'] : 'dashboard';
	$resto = $_SESSION['time'] - time();
	$idUser = $_SESSION['idUser'];
	if ($resto > 0) {
		$Q_Sesiones = mysqli_query($MySQLi, "SELECT idUser, session FROM usuarios WHERE onLine=1");
		$resultSess = mysqli_num_rows($Q_Sesiones);
		if ($resultSess > 0) {
			while ($dataUsers = mysqli_fetch_assoc($Q_Sesiones)) {
				$idUser_sess = $dataUsers['idUser'];
				$Session_idUser = $dataUsers['session'];
				if (time() > $Session_idUser) {
					mysqli_query($MySQLi, "UPDATE usuarios SET onLine=0 WHERE idUser='$idUser_sess'");
				}
			}
		}
		$nuevo = $_SESSION['time'] + 360;
		mysqli_query($MySQLi, "UPDATE usuarios SET session='$nuevo' WHERE onLine=1 AND idUser='$idUser'");
		$_SESSION['time'] = $nuevo;
		if (file_exists('Paginas/' . $pagina . '.php')) {
			include 'Paginas/' . $pagina . '.php';
		}
		else {
			header("HTTP/1.0 404 Not found", true, 404);
			include_once 'Paginas/404.php';
		}
	}
	else {
		mysqli_query($MySQLi, "UPDATE usuarios SET onLine=0 WHERE idUser='$idUser'");
		session_unset();
		session_destroy();
		include 'Paginas/login.php';
	}
}
else {
	include 'Paginas/login.php';
}
?>