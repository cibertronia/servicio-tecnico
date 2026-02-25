<?php
function extractoProducto($MySQLi, $idProducto, $FechaInicio, $FechaCierre, $Sucursal)
{
    error_reporting(0);

    $totalExtraido = 0;

    //contamos los extraidos por envios
    $queryEnvios = mysqli_query(
        $MySQLi,
        "SELECT * FROM envio_stock WHERE fecha BETWEEN '$FechaInicio' AND '$FechaCierre'  AND (estado = '0' OR estado ='1') AND id_origen = '$Sucursal'"
    );
    $totalExtraidoEnvios = 0;

    while ($datosEnvio = mysqli_fetch_assoc($queryEnvios)) {
        $clave = $datosEnvio['clave'];
        $queryTemp = mysqli_query($MySQLi, "SELECT * FROM envio_claves WHERE clave = '$clave' ");
        while ($datosTemp = mysqli_fetch_assoc($queryTemp)) {
            if ($idProducto == $datosTemp['id_producto']) {
                $totalExtraidoEnvios = $totalExtraidoEnvios + $datosTemp['cantidad'];
            }
        }
    }

    //contamos los extraidos cuando se entrego en credito , compradas (antes solo era 4 xd)
    $queryCreditos = mysqli_query(
        $MySQLi,
        "SELECT * FROM cotizaciones WHERE fecha BETWEEN '$FechaInicio' AND '$FechaCierre'  AND (estado IN(2,4)) AND idTienda = '$Sucursal' "
    );
    $totalExtraidoCreditos = 0;

    while ($datosCreditos = mysqli_fetch_assoc($queryCreditos)) {
        $clave = $datosCreditos['clave'];
        $queryTempCreditos = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal = '$clave' ");
        $resultTempCreditos = mysqli_num_rows($queryTempCreditos);
        if ($resultTempCreditos > 0) {
            while ($datosTempCreditos = mysqli_fetch_assoc($queryTempCreditos)) {
                if ($idProducto == $datosTempCreditos['idProducto']) {
                    $totalExtraidoCreditos = $totalExtraidoCreditos + $datosTempCreditos['cantidad'];
                }
            }
        }
    }

    // //anticipo completado,
    // $q_anticipo_completado = mysqli_query(
    //     $MySQLi,
    //     "SELECT * FROM cotizaciones WHERE Completada BETWEEN '$FechaInicio' AND '$FechaCierre'  AND Estado = 6 AND Sucursal = '$Sucursal' "
    // );
    // $total_extraido_abono_completado = 0;
    // while ($d_anticipo_completado = mysqli_fetch_assoc($q_anticipo_completado)) {
    //     $clave = $d_anticipo_completado['Clave'];
    //     $queryTempAbonoCompletado = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE Clave = '$clave' ");
    //     while ($d_temp_abono = mysqli_fetch_assoc($queryTempAbonoCompletado)) {
    //         if ($idProducto == $d_temp_abono['idProducto']) {
    //             $total_extraido_abono_completado = $total_extraido_abono_completado + $d_temp_abono['cantidad'];
    //         }
    //     }
    // }

    $total = $totalExtraido + $totalExtraidoEnvios + $totalExtraidoCreditos;
    return $total;
}

function recepcionProducto($MySQLi, $idProducto, $FechaInicio, $FechaCierre, $id_destino)
{

    $queryRecepcion = mysqli_query(
        $MySQLi,
        "SELECT * FROM envio_stock WHERE (DATE_FORMAT(fecha_recibido, '%Y-%m-%d') BETWEEN '$FechaInicio' AND '$FechaCierre')  AND estado ='1' AND id_destino = '$id_destino'"
    );
    $totalExtraidoEnvios = 0;

    while ($datosEnvio = mysqli_fetch_assoc($queryRecepcion)) {
        $clave = $datosEnvio['clave'];
        $queryTemp = mysqli_query($MySQLi, "SELECT * FROM envio_claves WHERE clave = '$clave' ");
        while ($datosTemp = mysqli_fetch_assoc($queryTemp)) {
            if ($idProducto == $datosTemp['id_producto']) {
                $totalExtraidoEnvios = $totalExtraidoEnvios + $datosTemp['cantidad'];
            }
        }
    }

    $totalRecepcionado = $totalExtraidoEnvios;
    return  $totalRecepcionado;
}

function captura_producto($MySQLi, $idProducto, $FechaCierre)
{

    $queryCaptura = mysqli_query(
        $MySQLi,
        "SELECT *
        FROM `capturas_productos`
    WHERE DATE_FORMAT(fecha, '%Y-%m-%d')='$FechaCierre'  order by id desc LIMIT 1 "
    );
    $rowcount = mysqli_num_rows($queryCaptura); //si existe
    if ($rowcount > 0) {

        $data = mysqli_fetch_assoc($queryCaptura);
        $captura = (string)$data['captura'];
        $captura = json_decode($captura);

        $productos = $captura->{'productos'}; //array con datos del producto
        $stocks = [];
        for ($i = 0; $i < count($productos); ++$i) {
            if ($productos[$i][0] == $idProducto) {

                $stocks = array(
                    'idProducto' => $productos[$i][0],
                    'StockCB' => $productos[$i][1],
                    'StockLP' => $productos[$i][2],
                    'StockSC' => $productos[$i][3],
                    'StockTJ' => $productos[$i][4],
                    'StockTotal' => $productos[$i][5],
                );
            }
        }

        return $stocks;
    } else {

        return false;
    }
}
