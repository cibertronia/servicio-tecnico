<?php
$ira = 0;
if (isset($_GET['p']))  {
    $clave = $_GET['p'];
    include 'includes/conexion.php';
    
    if ($clave == "xx"){
        
$sql = "SELECT l.fecha,   l.detalle FROM  logss l where l.tipo = 2 order by l.fecha desc";
    $resultado = mysqli_query($MySQLi, $sql);

     
     echo("<table><tr><td><b>Fecha</b></td><td><b>Detalle</b></td></tr>");
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo("<tr>");
        echo("<td>");
        echo($fila[fecha] . "&nbsp;");
        echo("</td>");
        echo("<td>");
        echo("&nbsp;" . $fila[detalle]);
        echo("</td>");
        echo("</tr>");
                               
    }           
    echo("</table>");        
        
    }
    
    
    else {
    $sql = "SELECT l.fecha,  prod.nombre, l.detalle FROM 
logss l inner JOIN `productos` prod on l.valor= prod.idProducto and l.tipo = 1
where l.valor = $clave 
order by l.fecha desc";
    $resultado = mysqli_query($MySQLi, $sql);

    while ($fila = mysqli_fetch_assoc($resultado)) {
        $titulo = $fila['nombre'];
        break;
    }
    
    
    $resultado = mysqli_query($MySQLi, $sql);
    echo("<table><tr><td colspan='2'><b>$titulo</b></td></tr><tr><td><b>Fecha</b></td><td><b>Detalle</b></td></tr>");
    while ($fila = mysqli_fetch_assoc($resultado)) {
        echo("<tr>");
        echo("<td>");
        echo($fila[fecha] . "&nbsp;");
        echo("</td>");
        echo("<td>");
        echo("&nbsp;" . $fila[detalle]);
        echo("</td>");
        echo("</tr>");
                               
    }           
    echo("</table>");
    }
}
?>