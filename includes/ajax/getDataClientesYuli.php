<?php
error_reporting(0);
include './../conexion_yuli_srl.php';
$idCliente = $_POST['id'];
$queryCliente = mysqli_query($db_yuli_srl, "SELECT * FROM Clientes WHERE idCliente='$idCliente' ");
$dataCliente = mysqli_fetch_assoc($queryCliente);

$queryComprados = mysqli_query($db_yuli_srl, "SELECT * FROM Ventas WHERE idCliente='$idCliente' ");


$comprados = [];
$count = 0;
while ($data = mysqli_fetch_assoc($queryComprados)) {

    $idVenta = $data['idVenta']; // dato para pushear a cada array
    $idProducto = $data['idProducto']; //referencia
    $idEntrega = $data['idEntrega'];

    $queryProd = mysqli_query($db_yuli_srl, "SELECT * FROM Productos WHERE idProducto='$idProducto' ");
    $dataProducto = mysqli_fetch_assoc($queryProd);

    //hacer garantia la logica aca si sigue vigente
    // Your code here!
    $date = $data['Fecha'];
    $garantia_repuesto = date("Y-m-d", strtotime($date . "+ 3 month"));
    $garantia_mano = date("Y-m-d", strtotime($date . "+ 1 year"));

    $fecha_actual = date("Y-m-d");

    if (verifica_rango($date, $garantia_repuesto, $fecha_actual)) {
        //echo '<div class="alert alert-danger">si tengo garantia de repuesto</div>';
        $garantia_vigente_repuesto = 'si';
    } else {
        //echo '<div class="alert alert-success">no tengo garantia de repuesto</strong></div>';
        $garantia_vigente_repuesto = 'no';
    }

    if (verifica_rango($date, $garantia_mano, $fecha_actual)) {
        //echo '<div class="alert alert-danger">si tengo garantia de mano de obra</div>';
        $garantia_vigente_mano = 'si';
    } else {
        // '<div class="alert alert-success">no tengo garantia de mano de obra</strong></div>';
        $garantia_vigente_mano = 'no';
    }

    $comprados[$count] = array(
        'idVenta' => $idVenta,
        'idProducto' => $idProducto,

        'Producto' => $dataProducto['Producto'],
        'Marca' => $dataProducto['Marca'],
        'Modelo' => $dataProducto['Modelo'],
        'idEntrega' => $idEntrega,

        'garantia_vigente_repuesto' => $garantia_vigente_repuesto,
        'garantia_vigente_mano' => $garantia_vigente_mano,
        'FechaVenta' => $date,

    );
    $count++;
}

$idCliente = $dataCliente['idCliente'];

$Nombres = $dataCliente['Nombres'];
$Apellidos = $dataCliente['Apellidos'];
$Correo = $dataCliente['Correo'];
$Empresa = $dataCliente['Empresa'];
$NIT = $dataCliente['NIT'];

$Celular = $dataCliente['Celular'];
$Ciudad = $dataCliente['Ciudad'];
$Fecha_Reg = $dataCliente['Fecha_Reg'];
$CI = $dataCliente['CI'];
$Sucursal = $dataCliente['Sucursal'];

$obj_merged = (object) [];

$obj_merged->idCliente = $idCliente;

$obj_merged->Nombres = $Nombres;
$obj_merged->Apellidos = $Apellidos;
$obj_merged->Correo = $Correo;
$obj_merged->Empresa = $Empresa;
$obj_merged->NIT = $NIT;

$obj_merged->Celular = $Celular;
$obj_merged->Ciudad = $Ciudad;
$obj_merged->Fecha_Reg = $Fecha_Reg;
$obj_merged->CI = $CI;
$obj_merged->Sucursal = $Sucursal;

mysqli_close($db_yuli_srl);


//$obj_merged->cadena = $cadena;
$compras_fusion = ventas_otro_sistema($idCliente, $Nombres, $Apellidos, $comprados, $count);
$compras_fusion = productos_credito($compras_fusion, $count);
$obj_merged->comprados = $compras_fusion; //array de sus productos comprados

echo json_encode($obj_merged);


// verificamos si la fecha compra esta en el rango de garantia
function verifica_rango($date_inicio, $date_fin, $date_nueva)
{
    $date_inicio = strtotime($date_inicio);
    $date_fin = strtotime($date_fin);
    $date_nueva = strtotime($date_nueva);
    if (($date_nueva >= $date_inicio) && ($date_nueva <= $date_fin)) {
        return true;
    }

    return false;
}

//buscamos al cliente si en el otro sistema yuliimport compro algo
function ventas_otro_sistema($idCliente, $Nombres, $Apellidos, $comprados, $count)
{
    include './../conexion_yuli_ventas.php';
    //comparamos si existe el id y si nombres,apellidos son el mismo

    $idCliente = $_POST['id'];
    $queryCliente = mysqli_query($MySQLi, "SELECT * FROM Clientes WHERE idCliente='$idCliente' ");
    $dataCliente = mysqli_fetch_assoc($queryCliente);
    $nro_resultados_cliente   = mysqli_num_rows($queryCliente);

    $queryComprados = mysqli_query($MySQLi, "SELECT * FROM Ventas WHERE idCliente='$idCliente' ");
    $nro_resultados_compras   = mysqli_num_rows($queryComprados);

    //existe mismo id? y hay compras?
    if ($nro_resultados_cliente > 0 && $nro_resultados_compras > 0) {
        //mismo nombre y apellido
        if ($Nombres == $dataCliente['Nombres'] && $Apellidos == $dataCliente['Apellidos']) {

            while ($data = mysqli_fetch_assoc($queryComprados)) {

                $idVenta = $data['idVenta']; // dato para pushear a cada array
                $idProducto = $data['idProducto']; //referencia
                $idEntrega = $data['idEntrega'];

                $queryProd = mysqli_query($MySQLi, "SELECT * FROM Productos WHERE idProducto='$idProducto' ");
                $dataProducto = mysqli_fetch_assoc($queryProd);

                //hacer garantia la logica aca si sigue vigente
                // Your code here!
                $date = $data['Fecha'];
                $garantia_repuesto = date("Y-m-d", strtotime($date . "+ 3 month"));
                $garantia_mano = date("Y-m-d", strtotime($date . "+ 1 year"));

                $fecha_actual = date("Y-m-d");

                if (verifica_rango($date, $garantia_repuesto, $fecha_actual)) {
                    //echo '<div class="alert alert-danger">si tengo garantia de repuesto</div>';
                    $garantia_vigente_repuesto = 'si';
                } else {
                    //echo '<div class="alert alert-success">no tengo garantia de repuesto</strong></div>';
                    $garantia_vigente_repuesto = 'no';
                }

                if (verifica_rango($date, $garantia_mano, $fecha_actual)) {
                    //echo '<div class="alert alert-danger">si tengo garantia de mano de obra</div>';
                    $garantia_vigente_mano = 'si';
                } else {
                    // '<div class="alert alert-success">no tengo garantia de mano de obra</strong></div>';
                    $garantia_vigente_mano = 'no';
                }

                $comprados[$count] = array(
                    'idVenta' => $idVenta,
                    'idProducto' => $idProducto,

                    'Producto' => $dataProducto['Producto'],
                    'Marca' => $dataProducto['Marca'],
                    'Modelo' => $dataProducto['Modelo'],
                    'idEntrega' => $idEntrega,

                    'garantia_vigente_repuesto' => $garantia_vigente_repuesto,
                    'garantia_vigente_mano' => $garantia_vigente_mano,
                    'FechaVenta' => $date,

                );
                $count++;
            }
        }
    }
    mysqli_close($MySQLi);
    return $comprados;
}

//productos que estan en credito 
function productos_credito($comprados, $count)
{
    include './../conexion_yuli_srl.php';
    //comparamos si existe el id y si nombres,apellidos son el mismo

    $idCliente = $_POST['id'];

    $q_Cotizaciones = mysqli_query($db_yuli_srl, "SELECT * FROM Cotizaciones WHERE idCliente='$idCliente' AND Estado='4' ");
    $nro_resultados_creditos   = mysqli_num_rows($q_Cotizaciones);
    //existe creditos activos
    if ($nro_resultados_creditos > 0) {
        while ($d_Cotizaciones = mysqli_fetch_assoc($q_Cotizaciones)) {

            $Clave = $d_Cotizaciones['Clave']; //clave para los productos ligados
            $idCotizacion = $d_Cotizaciones['idCotizacion'];

            $q_notaEntrega = mysqli_query($db_yuli_srl, "SELECT * FROM notaEntrega WHERE idCotizacion='$idCotizacion' ");
            $d_notaEntrega = mysqli_fetch_assoc($q_notaEntrega);
            $idNotaE = $d_notaEntrega['idNotaE'];
            $Fecha = $d_notaEntrega['Fecha'];

            //hacer garantia la logica aca si sigue vigente
            $date = $Fecha;
            $garantia_repuesto = date("Y-m-d", strtotime($date . "+ 3 month"));
            $garantia_mano = date("Y-m-d", strtotime($date . "+ 1 year"));

            $fecha_actual = date("Y-m-d");

            if (verifica_rango($date, $garantia_repuesto, $fecha_actual)) {
                $garantia_vigente_repuesto = 'si';
            } else {
                $garantia_vigente_repuesto = 'no';
            }
            if (verifica_rango($date, $garantia_mano, $fecha_actual)) {
                $garantia_vigente_mano = 'si';
            } else {
                $garantia_vigente_mano = 'no';
            }

            $q_ClaveTemporal = mysqli_query($db_yuli_srl, "SELECT * FROM ClaveTemporal WHERE Clave='$Clave' ");
            while ($d_ClaveTemporal = mysqli_fetch_assoc($q_ClaveTemporal)) {
                $idProducto = $d_ClaveTemporal['idProducto'];
                $q_Productos = mysqli_query($db_yuli_srl, "SELECT * FROM Productos WHERE idProducto='$idProducto' ");
                $d_Productos = mysqli_fetch_assoc($q_Productos);

                $Producto = $d_Productos['Producto'];
                $Marca = $d_Productos['Marca'];
                $Modelo = $d_Productos['Modelo'];

                $comprados[$count] = array(
                    'idVenta' => "0",
                    'idProducto' => $idProducto,

                    'Producto' => $Producto,
                    'Marca' => $Marca,
                    'Modelo' => $Modelo,
                    'idEntrega' => $idNotaE,

                    'garantia_vigente_repuesto' => $garantia_vigente_repuesto,
                    'garantia_vigente_mano' => $garantia_vigente_mano,
                    'FechaVenta' => $date,

                );
                $count++;
            }
        }
    }
    mysqli_close($db_yuli_srl);
    return $comprados;
}
