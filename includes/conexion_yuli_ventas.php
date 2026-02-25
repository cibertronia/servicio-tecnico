<?php
// prod yuli principal
$Error = "Error Principal con la base de datos<br>En la linea:  " . __LINE__;
$MySQLi = mysqli_connect("167.86.108.223", "letimport_admin", "ES@72900968", "letimport_UPDATE") or die($Error);
$MySQLi->set_charset("utf8");

//pruebas host
// $Error = "Error Principal con la base de datos<br>En la linea: " . __LINE__;
// $MySQLi = mysqli_connect("167.86.108.223", "letimport_integra", "Y^9bC]@NKi}s", "letimport_espejointegracion") or die($Error);
// $MySQLi->set_charset("utf8");


//pruebas local
// $Error = "Error Principal con la base de datos<br>En la linea: " . __LINE__;
// $MySQLi = mysqli_connect("localhost", "root", "", "letimport_espejointegracion") or die($Error);
// $MySQLi->set_charset("utf8");