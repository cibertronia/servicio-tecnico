<?php
function registro_stock_envios($MySQLi, $idTienda, $idProducto, $inicial, $cantidad, $final, $descripcion, $signo)
{
    try {
        $q_productos = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto'");
        $d_productos = mysqli_fetch_assoc($q_productos);
        $mercaderia = ($d_productos['mercaderia'] == '' || $d_productos['mercaderia'] == null) ? '' : $d_productos['mercaderia'];
        $nombre = ($d_productos['nombre'] == '' || $d_productos['nombre'] == null) ? '' : $d_productos['nombre'];
        $marca = ($d_productos['marca'] == '' || $d_productos['marca'] == null) ? '' : $d_productos['marca'];
        $modelo = ($d_productos['modelo'] == '' || $d_productos['modelo'] == null) ? '' : $d_productos['modelo'];

        $idUser = $_SESSION['idUser'];
        $q_usuarios = mysqli_query($MySQLi, "SELECT * FROM usuarios WHERE idUser='$idUser'");
        $d_usuarios = mysqli_fetch_assoc($q_usuarios);

        date_default_timezone_set('America/La_Paz');

        //variables para insertar
        $producto = $mercaderia . ' ' . $nombre . ' ' . $marca . ' ' . $modelo;
        $signo = ($signo == '-') ? -1 : 1;
        $cb = ((int)$idTienda == 1) ? $cantidad * $signo : 0;
        $lp = ((int)$idTienda == 2) ? $cantidad * $signo : 0;
        $sc = ((int)$idTienda == 3) ? $cantidad * $signo : 0;
        $tj = ((int)$idTienda == 4) ? $cantidad * $signo : 0;
        $vendedor = $d_usuarios['Nombre'];
        $dateEmission = date('c');

        mysqli_query(
            $MySQLi,
            "INSERT INTO historial_stock_envios(
        producto,
        inicial,
        cb,
        lp,
        sc,
        tj,
        final,
        vendedor,
        dateEmission,
        descripcion,
        idProducto,
        sucursal
        )
        VALUES(
        '$producto',
        '$inicial',
        '$cb',
        '$lp',
        '$sc',
        '$tj',
        '$final',
        '$vendedor',
        '$dateEmission',
        '$descripcion',
        '$idProducto',
        '$idTienda')"
        ) or die(mysqli_error($MySQLi));
    } catch (Exception $e) {
    }
}
