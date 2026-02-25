<?php

$error_db_yuli_srl = "Error Principal con la base de datos<br>En la linea:  " . __LINE__;
$db_yuli_srl = mysqli_connect("167.86.108.223", "importyuli_kukiracle", "x!ziy.&QSo{J", "importyuli_produccion_yulisrl") or die($error_db_yuli_srl);
$db_yuli_srl->set_charset("utf8");

