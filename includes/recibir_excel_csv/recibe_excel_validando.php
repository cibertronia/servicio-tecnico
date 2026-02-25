<?php
error_reporting(0);
require('./../conexion.php');
try {
    $tipo = $_FILES['dataCliente']['type'];
    $tamanio = $_FILES['dataCliente']['size'];
    $archivotmp = $_FILES['dataCliente']['tmp_name'];
    $lineas = file($archivotmp);
    $i = 0;
    date_default_timezone_set('America/La_Paz');
    $fechaActual = date('c');

    foreach ($lineas as $linea) {
        $cantidad_registros = count($lineas);
        $cantidad_regist_agregados = ($cantidad_registros - 1);

        if ($i != 0) {

            $datos = explode(";", $linea);

            $mercaderia = !empty($datos[0]) ? ($datos[0]) : '';
            $mercaderia = formatearCadena($mercaderia);
            //$mercaderia = mb_convert_encoding($mercaderia, 'HTML-ENTITIES', 'UTF-8');


            $nombre = !empty($datos[1]) ? ($datos[1]) : '';
            $nombre = formatearCadena($nombre);
            //$nombre = mb_convert_encoding($nombre, 'HTML-ENTITIES', 'UTF-8');

            $precio = !empty($datos[2]) ? ($datos[2]) : '0';  //precio unitario
            $cochabamba = !empty($datos[3]) ? ($datos[3]) : '0';
            $cochabamba = (int)$cochabamba;
            $la_paz =  !empty($datos[4]) ? ($datos[4]) : '0';
            $la_paz = (int)$la_paz;
            $santa_cruz = !empty($datos[5]) ? ($datos[5]) : '0';
            $santa_cruz = (int)$santa_cruz;
            $tarija = !empty($datos[6]) ? ($datos[6]) : '0';
            $tarija = (int)$tarija;

            $total = !empty($datos[7]) ? ($datos[7]) : '0';
            $observaciones = !empty($datos[8]) ? ($datos[8]) : '';
            $observaciones = formatearCadena($observaciones);

            //eliminamos "." puntos en los numeros
            $precio = str_replace('.', '', $precio);
            //cambiamos "," comas por puntos para guardar correctamente
            $precio = str_replace(',', '.', $precio);



            $insertarData = "INSERT INTO productos
            ( `idCategoria`, `idProveedor`,`codigoProducto`, `nombre`,
               `precio`,`fecha`, `estado`,`observaciones`, `mercaderia`,`imagen`) 
                  VALUES('0', '0','0', '$nombre',
                    '$precio','$fechaActual','1','$observaciones','$mercaderia','0000defaultCsv.jpg') ";

            $query = mysqli_query($MySQLi, $insertarData);

            if ($query) {
                //ultimo id producto adicionado
                $idProducto = mysqli_insert_id($MySQLi);
                //actualizacmos inventario
                mysqli_query($MySQLi, "INSERT INTO inventario() VALUES (null, '$idProducto', '1', '$cochabamba') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                mysqli_query($MySQLi, "INSERT INTO inventario() VALUES (null, '$idProducto', '2', '$la_paz') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                mysqli_query($MySQLi, "INSERT INTO inventario() VALUES (null, '$idProducto', '3', '$santa_cruz') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
                mysqli_query($MySQLi, "INSERT INTO inventario() VALUES (null, '$idProducto', '4', '$tarija') ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
            } else {
                echo json_encode('error');
                echo $insertarData;
            }
        }
        $i++;
    }
    if ($query) {
        echo json_encode('ok');
?>
<?php


    } else {
        echo json_encode('error');  ?>
<?php
    }
} catch (Error $e) {
    echo  json_encode($e->getMessage());
}
function formatearCadena($cadena)
{
    // Realizar la transliteración y eliminar caracteres especiales
    $cadenaFormateada = iconv('UTF-8', 'ASCII//TRANSLIT', $cadena);

    // Reemplazar espacios en blanco con guiones bajos
    //$cadenaFormateada = preg_replace('/\s+/', ' ', $cadenaFormateada);

    // Convertir a minúsculas
    //$cadenaFormateada = strtolower($cadenaFormateada);

    return $cadenaFormateada;
}
