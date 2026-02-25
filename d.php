<?php
$ira = 0;
if (isset($_GET['r']) && $_GET['r'] == 1) 
    $ira = 1;
if (isset($_GET['c'])) {
    $clave = $_GET['c'];
    include 'includes/conexion.php';
    $sql = "select sopsuc.idSoporte, sopsuc.idSucursal, sopsuc.clave_soporte, sopsuc.estado, sopsuc.fechaRegistro, sopcla.estado, sopcla.idclave, sopclarep.cantidad, sopclarep.idProducto, sopcla.fechaRegistro 
    from soporte_sucursales sopsuc 
    left join soporte_claves sopcla on sopsuc.clave_soporte = sopcla.clave 
    left join soporte_claves_repuestos sopclarep on sopclarep.idClave = sopcla.idClave where sopsuc.clave_soporte='$clave'";
    $resultado = mysqli_query($MySQLi, $sql);
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $idproducto = $fila['idProducto'];
        $fechaRegistro = $fila['fechaRegistro'];
        $idSucursal = $fila['idSucursal'];
        $cantidad = $fila['cantidad'];
        $idSoporte = $fila['idSoporte'];  
        $idclave = $fila['idclave'];
        if ($ira == 0) { // de enrepacacion a diagostinco
            $sql = "delete from historial_stock_productos where idproducto = $idproducto and date(dateEmission) = '$fechaRegistro' and ";
            $sql .= "sucursal = $idSucursal and (case when sucursal = 1 then abs(cb) when sucursal = 2 then abs(lp) when sucursal = 3 then abs(sc) when sucursal = 4 then abs(tj) end) = $cantidad limit 1";
            mysqli_query($MySQLi, $sql);
            mysqli_query($MySQLi, "update inventario set stock = stock + $cantidad where idproducto = $idproducto  and idTienda = $idSucursal");            
            mysqli_query($MySQLi, "update soporte_claves set estado = 0  where idClave = $idclave");            
        }
        else
            mysqli_query($MySQLi, "update soporte_claves set estado = $ira  where idClave = $idclave");        
            
        mysqli_query($MySQLi, "update soporte_sucursales set estado = $ira  where idSoporte = $idSoporte");
    
     mysqli_query($MySQLi,"delete from soporte_ventas where 
                               nro_servicio_recepcion =$$idSoporte  and
                               idSoporte = $idSoporte and
                               estado = 1");
                               
    }
    

                               
                               
    //
    if ($ira == 0)
        header('Location: '. "index.php?root=registrados");
    else if ($ira == 1)
        header('Location: '. "index.php?root=enReparacion");        
}
?>