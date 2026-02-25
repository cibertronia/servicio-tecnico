<?php
//error_reporting(0);
	$idUser   	= $_SESSION['idUser'];	//ya ta
	$Q_User   	= mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE idUser='$idUser' ");//yta ta
	$dataUss  	= mysqli_fetch_assoc($Q_User);// ya ta

	if ($_SESSION['idRango']=='2') {
		$idRango  = 2;
	}else{
		$idRango  = 1;
	}
	$Q_Avatar 	= mysqli_query($MySQLi,"SELECT * FROM avatar WHERE idRango='$idRango' ");
	$avatar   	= mysqli_fetch_assoc($Q_Avatar);
	$Q_Rango  	= mysqli_query($MySQLi,"SELECT * FROM rangos WHERE idRango='$idRango' ");
	$dataRango	= mysqli_fetch_assoc($Q_Rango);
?>