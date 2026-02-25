<?php
	$idUser 				= $_SESSION['idUser'];
	$Q_onLine 			= mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE onLine=1");
	$resultOnL			= mysqli_num_rows($Q_onLine);
	$Q_Usuario			= mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE idUser='$idUser' ");
	$dataUserDf			= mysqli_fetch_assoc($Q_Usuario);
	$dataUss  	= $dataUserDf;//para servicio tec
	$idRangoDf 			= $dataUserDf['idRango'];	
	$nombreUsuarioDf= $dataUserDf['Nombre'];
	$correoUsuarioDf= $dataUserDf['correo'];
	$telUsuarioDf 	= $dataUserDf['telefono'];
	$cargoUsuarioDf	= $dataUserDf['cargo'];
	$idTiendaDf			= $dataUserDf['idTienda'];
	$idSexoDf				= $dataUserDf['idSexo'];
	$sessionDf 			= $dataUserDf['session'];
	// $miAvatarDf			= $dataUserDf['miAvatar'];
	$idTelegramDf 	= $dataUserDf['idTelegram'];
	$Q_Sucursal 		= mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE idTienda='$idTiendaDf' ");
	$CantidadSucurs = mysqli_num_rows($Q_Sucursal);
	$dataSucursalDf = mysqli_fetch_assoc($Q_Sucursal);
	$sucurUsuarioDf = $dataSucursalDf['sucursal'];
	/*$Q_Avatar 			= mysqli_query($MySQLi,"SELECT * FROM avatar WHERE idRango='$idRangoDf' AND idSexo='$idSexoDf' ");
	$dataAvatarDf		= mysqli_fetch_assoc($Q_Avatar);
	$defaultAvatar  = $dataAvatarDf['avatar'];*/
	$Q_configuracion= mysqli_query($MySQLi,"SELECT * FROM configuraciones");
	$dataConfigs 		= mysqli_fetch_assoc($Q_configuracion);
	$paginaRegistro	= $dataConfigs['registrar'];
	$serviPrecioUSD = $dataConfigs['precioDolar'];
	$serviProveedor = $dataConfigs['proveedores'];
	$serviCategorias= $dataConfigs['categorias'];
	$serviStock 		= $dataConfigs['stock'];
	$tipoHoja   		= $dataConfigs['tipoHoja'];
	$userOnline  		= $dataConfigs['userOnline'];
	function miAvatar($MySQLi,$idUser, $idRangoDf, $idSexoDf){
		$Q_Usuario = mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE idUser='$idUser' ")or die("Error");
		$dataUser  = mysqli_fetch_assoc($Q_Usuario);
		$miAvatar  = $dataUser['miAvatar'];
		if ($miAvatar=='' or $miAvatar==null) {
			$Q_Avatar= mysqli_query($MySQLi,"SELECT * FROM avatar WHERE idRango='$idRangoDf' AND idSexo='$idSexoDf' ");
			$dataAvat= mysqli_fetch_assoc($Q_Avatar);
			$defaultA= $dataAvat['avatar'];
			return $defaultA;
		}else{
			return $miAvatar;
		}
	}
	function numSucursales($MySQLi){
		$Q_Sucursales = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1");
		$ResultSucurs = mysqli_num_rows($Q_Sucursales);
		return $ResultSucurs;
	}
	//constante de las configuraciones 
	define('SETTINGS', $dataConfigs);