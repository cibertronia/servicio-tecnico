<?php
include 'includes/conexion.php';
$idUser 	= $_POST['idUserDropZone'];
$ruta			=	"Productos/";
$ruta			= $ruta ."idUser".$idUser."_". basename($_FILES['file']['name'], $ruta);	
$img			=	"idUser".$idUser."_".basename($_FILES['file']['name']);

if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta)) {
	$Q_imgTemp 	= mysqli_query($MySQLi,"INSERT INTO imagentemporal (idUser, nombre) VALUES ('$idUser', '$img') ");
	echo "<br>imagen guardada";
}



/*$Q_imagen = mysqli_query($MySQLi,"SELECT * FROM imagentemporal WHERE idUser='$idUser' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
$result_Q = mysqli_num_rows($Q_imagen);
if ($result_Q>0) {
	while ($dataImg = mysqli_fetch_assoc($Q_imagen)) {
		$nombreImg = $dataImg['nombre'];
		$rutaImg   = "Productos/".$nombreImg;
		if (file_exists($rutaImg)) {
			unlink($rutaImg);
			echo "archivo borrado";
		}
	}
	mysqli_query($MySQLi,"DELETE FROM imagentemporal WHERE idUser='$idUser' ");
}*/