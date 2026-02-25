<?php 
$db_yuli_srl = mysqli_connect("167.86.108.223", "importyuli_kukiracle", "x!ziy.&QSo{J", "importyuli_produccion_yulisrl") or die($error_db_yuli_srl);
$db_yuli_srl->set_charset("utf8");
    if (!isset($_GET['q']) || ($_GET['q'] == ""))
    $queryCliente = mysqli_query($db_yuli_srl, "SELECT * FROM Clientes limit 5 order by Nombres");
    else
    $queryCliente = mysqli_query($db_yuli_srl, "SELECT * FROM Clientes where Nombres like '%" . $_GET['q'] . "%' or Apellidos like '%" . $_GET['q'] . "%' order by Nombres");
    $json = [];
                                    while ($dataCliente = mysqli_fetch_assoc($queryCliente)) {
                                           $json[] = ['id'=>$dataCliente['idCliente'], 'text'=>$dataCliente['Nombres'] ." ". $dataCliente['Apellidos'] . ", " . $dataCliente['Ciudad']];
                                    }
                                    mysqli_close($db_yuli_srl); 
                       
 echo json_encode($json);
 

