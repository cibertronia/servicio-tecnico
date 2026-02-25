<?php
	// $DB_HOST = '75.119.156.102';
	// $DB_USER = 'suportyapa_admin';
	// $DB_PSWD = 'ES@72900968';
	// $DB_NAME = 'suportyapa_sistemav3';

	$DB_HOST = '167.86.108.223';
	$DB_USER = 'letimport_kuky';
	$DB_PSWD = '.s=Kya+aD~yw';
	$DB_NAME = 'letimport_servicioTecnico';

	// $DB_HOST = 'localhost';
	// $DB_USER = 'root';
	// $DB_PSWD = '';
	// $DB_NAME = 'yuli_serviciotecnico';

	$MySQLi  = mysqli_connect($DB_HOST,$DB_USER,$DB_PSWD,$DB_NAME);
	$MySQLi->set_charset("utf8");
?>