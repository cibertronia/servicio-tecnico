<?php
	include_once 'includes/conexion.php';
	include_once 'includes/date.php';
  include_once 'includes/funciones.php';
	require 'vendor/autoload.php';
  $mpdf       = new \Mpdf\Mpdf([
    'mode'              => 'utf-8',
    'format'            => [165, 216],
    'orientation'       => 'L',
    'margin_header'     =>  3,
    'margin_footer'     =>  8,
    'margin_left'       =>  3,
    'margin_top'        =>  3,
    'margin_right'      =>  3,
    'margin_bottom'     =>  3,
  ]);
  $CSS        = file_get_contents('assets/css/reporteCotizacion.css');
  $mpdf->shrink_tables_to_fit = 1;
  $mpdf->use_kwt = true;
  $idSoporte	= $_GET['idSoporte'];
  $idRecibo   = $idSoporte;
  if ($idRecibo   < 10) {
    $ReciboNum='<span style="letter-spacing: 1px">000000'.$idRecibo.'</span>';
  }elseif ($idRecibo< 100) {
    $ReciboNum='<span style="letter-spacing: 1px">00000'.$idRecibo.'</span>';
  }elseif ($idRecibo< 1000) {
    $ReciboNum='<span style="letter-spacing: 1px">0000'.$idRecibo.'</span>';
  }elseif ($idRecibo< 10000) {
    $ReciboNum='<span style="letter-spacing: 1px">000'.$idRecibo.'</span>';
  }elseif ($idRecibo< 100000) {
    $ReciboNum='<span style="letter-spacing: 1px">00'.$idRecibo.'</span>';
  }elseif ($idRecibo< 1000000) {
    $ReciboNum='<span style="letter-spacing: 1px">0'.$idRecibo.'</span>';
  }elseif ($idRecibo< 10000000) {
    $ReciboNum='<span style="letter-spacing: 1px">'.$idRecibo.'</span>';
  }
  $idClave 		= $_GET['idClave'];
  $sucursal 	= $_GET['sucursal'];
  $Q_Claves 	= mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE idClave='$idClave' ");
	$dataClave 	= mysqli_fetch_assoc($Q_Claves);
	$clave 			= $dataClave['clave'];
 
  //$Q_Soporte  = mysqli_query($MySQLi,"SELECT * FROM soporte WHERE idSoporte='$idSoporte' AND sucursal='$sucursal' ");
  // if ($sucursal=='Cochabamba') {
  // 	$Q_Soporte= mysqli_query($MySQLi,"SELECT * FROM soporte_cba WHERE idSoporte='$idSoporte' ");
  // }else{
  $Q_Soporte= mysqli_query($MySQLi,"SELECT * FROM soporte_sucursales WHERE idSoporte='$idSoporte' ");  	
  //}
  $dataSopor  = mysqli_fetch_assoc($Q_Soporte);
  $fechaRegist= $dataSopor['fechaRegistro'];
	$idUser 	  = $dataSopor['idUser'];
	$nombreCli  = $dataSopor['nombreCliente'];
	$celClient  = $dataSopor['telCliente'];
	$Q_Usuario  = mysqli_query($MySQLi,"SELECT Nombre FROM usuarios WHERE idUser='$idUser' ");
  $dataUser   = mysqli_fetch_assoc($Q_Usuario);
  $nombreUss  = $dataUser['nombre'];
  $txt = '
  <div style="border: 5px solid;height:100%">
    <table autosize="1" style="width:100%;margin:auto;padding:3px">
      <tr>
        <td width="30%">';
        	if ($sucursal=='Santa Cruz') { $txt.='
        		<img src="assets/img/logoEqimport.png" width="150"><br>           ';
        	}else{
        		$txt.='<img src="assets/img/imagenenblanco.png" width="150"><br>&nbsp;&nbsp;<br>';
        	} $txt.='
        </td>
        <td width="40%" style="text-align:center;"><u><h1>Informe técnico del equipo en registrados</h1></u></td>
        <td width="30%" style="text-align: right;color:red;padding:5px;"><h2>N&ordm; &nbsp;'.$ReciboNum.'</h2></td>
      </tr>
      <tr><td colspan="3" style="text-align:right"><h2>Sucursal: '.$sucursal.'</h2></td></tr>  
      <tr><td colspan="3" style="text-align:right"><h2>'.fechaLetras2($fechaRegist).'</h2></td></tr>          
    </table>
    <table autosize="1" style="width:95%;margin:auto">
      <tr>
        <td width="33%"><b>Nombre: </b> '.$nombreCli.'</td>
        <td width="33%" style="text-align:center"><b>Tel/cel: </b> '.$celClient.'</td>
      </tr>
    </table><div style="width:95%;margin:auto;">    
  	<table border=1 style="width:100%;margin:auto;border-collapse: collapse;">
  		<tr>
  			<th width="15%">Equipo</th>
  			<th width="15%">Marca</th>
  			<th width="15%">Modelo</th>
  			<th width="15%">Serie</th>
  			<th width="15%">Garantia</th>
  			<th width="25%">Observaciones</th>
  		</tr>
  		<tr>
  			<td style="padding:2px">'.$dataClave['equipo'].'</td>
  			<td style="padding:2px">'.$dataClave['marca'].'</td>
  			<td style="padding:2px">'.$dataClave['modelo'].'</td>
  			<td style="padding:2px;text-align:center">'.$dataClave['serie'].'</td>
  			<td style="padding:2px;text-align:center">'.$dataClave['garantia'].'</td>
  			<td style="padding:2px">'.$dataClave['observaciones'].'</td>
  		</tr>
  		<tr>
  			<th>Problema</th>
  			<td colspan="5" style="padding:2px">'.$dataClave['problema'].'</td>
  		</tr>
  	</table>
    <div style="font-size:17px;font-weight: bold;padding:2px;">Repuestos</div></div>
    <table border=1 autosize="1" style="width:70%;margin:auto;border-collapse: collapse;">
    	<tr>
    		<th width="15%" style="text-align:center">Cantidad</th>
    		<th width="65%" style="text-align:center">Repuestos</th>
    		<th width="20%" style="text-align:center">Bs</th>
    	</tr>
    	<tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
      </tr>
    	<tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
      </tr>
    	<tr>
        <td style="padding:10px"></td>
        <td></td>
        <td></td>
      </tr>
    	<tr>
        <td></td>
        <th style="padding:2px">Total</th>
        <td></td>
      </tr>
    </table>
    <div style="width:95%;margin:auto;">
    <span style="font-size:17px;font-weight: bold;padding:2px">Trabajo realizado</span>
    <table style="width:100%; margin:auto">
    	<tr><td style="padding:9px 4px 4px 4px">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
    	<tr><td style="padding:5px">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
    	<tr><td style="padding:5px">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
    	<tr><td style="padding:5px">--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------</td></tr>
    </table>
    </div>
  </div>';
  $footerSoporte = '<div style="padding-left:15px">
    <table autosize="1" style="width:100%;margin:auto;">
      <tr>
        <td width="50%" class="text-center">Firma encargado</td>
        <td width="50%" class="text-center">Firma del Técnico</td>
      </tr>
      <tr>
        <td width="50%;padding:5px" class="text-center">'.$nombreUss.'</td>
        <td width="50%;padding:5px" class="text-center">Nombre: ____________________</td>
      </tr>
      <tr>
        <td width="50%" class="text-center"></td>
        <td width="50%" class="text-center p-5">C.I___________________</td>
      </tr>
    </table>
  </div>';
  $mpdf->SetHTMLFooter($footerSoporte);
  $NamePDF= "Ficha técnica ".$idSoporte;
  $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
  $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
  $mpdf->Output($NamePDF.".pdf", "I");
?>