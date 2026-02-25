<?php
error_reporting(0);
session_start();
include 'conexion.php';
if (isset($_SESSION['idUser'])) {
    $idProducto = $_POST['idProducto'];
    
    
        $q_repuesto_borrado = mysqli_query($MySQLi, "select nombre FROM `productos` WHERE `idProducto`='$idProducto'");
        $dataP = mysqli_fetch_assoc($q_repuesto_borrado);
        $dataP = $dataP['nombre'];

        $q_repuesto_borrado = mysqli_query($MySQLi, "select correo FROM `usuarios` WHERE `idUser`=" . $_SESSION['idUser']);
        $dataU = mysqli_fetch_assoc($q_repuesto_borrado);
        $dataU = $dataU['correo'];
        
        
        $sqll = "insert into logss values(now(),2,$idProducto,'$dataU borro, $dataP')";
                         mysqli_query($MySQLi, $sqll);
                         
    
    
    mysqli_query($MySQLi, "DELETE FROM `productos` WHERE `idProducto`='$idProducto'");
    
    
    echo $q_repuesto_borrado ?  json_encode('ok') : json_encode('error');
}
