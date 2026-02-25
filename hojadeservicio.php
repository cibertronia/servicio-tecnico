<?php
  include_once 'includes/conexion.php';
  include_once 'includes/date.php';
  include_once 'includes/functions.php';
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
  $idSoporte  = $_GET['idSoporte'];
  $servicio   = $_GET['servicio'];
  $sucursal   = $_GET['Sucursal'];
  
  $baseDatos= "soporte_sucursales"; 

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
  //Servicio 1      = Comprobante de recepción
  //Servicio 2      = detalles de reparacion
  //Servicio 3      = detalles a realizar en la reparacion
  if ($servicio     ==1) {
    $Q_Servicio     = mysqli_query($MySQLi,"SELECT * FROM soporte_sucursales WHERE idSoporte='$idSoporte'AND estado=0")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataServicio   = mysqli_fetch_assoc($Q_Servicio);
    $nombreCliente  = $dataServicio['nombreCliente'];
    $celularCliente = $dataServicio['telCliente'];
    $claveSoporte   = $dataServicio['clave_soporte'];
    $idUser         = $dataServicio['idUser'];
    $Q_Usuario      = mysqli_query($MySQLi,"SELECT Nombre FROM usuarios WHERE idUser='$idUser' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataUser       = mysqli_fetch_assoc($Q_Usuario);
    $nombreUsuario  = $dataUser['nombre'];
    $fechaRegistro  = fechaFormato($dataServicio['fechaRegistro']);
    $fechareparacion= fechaFormato($dataServicio['fechaReparacion']);
    $Q_SoporteClaves= mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$claveSoporte' AND estado=0 AND sucursal='$sucursal' ORDER BY equipo DESC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $txt = '
    <div style="border: 5px solid;height:100%">
      <table autosize="1" style="width:100%;margin:auto;padding:3px;">
        <tr>
          <td width="30%" style="padding:5px">
           
              <img src="https://www.yapame.com.bo/wp-content/uploads/2019/06/logo-350.png" width="150"><br>&nbsp;&nbsp;<br>
             
          </td>
          <td width="40%" style="text-align:center"><u><h1>Comprobante de recepción</h1></u></td>
          <td width="30%" style="text-align: right;color:red;padding:5px;"><h2>N&ordm; &nbsp;'.$ReciboNum.'</h2></td>
        </tr>
        <tr><td colspan="3" style="text-align:right"><h2>Sucursal: '.$sucursal.'</h2></td></tr> 
        <tr><td colspan="3" style="text-align:right"><h2>'.fechaLetras2($fechaRegistro).'</h2></td></tr>         
      </table>
      <table autosize="1" style="width:95%;margin:auto">
        <tr>
          <td width="33%"><b>Nombre: </b> '.$nombreCliente .'</td>
          <td width="33%" style="text-align:center"><b>Tel/cel: </b> '.$celularCliente .'</td>
        </tr>
      </table><br>';
        while ($dataClave = mysqli_fetch_assoc($Q_SoporteClaves)) { $txt.='
          <table autosize="1" style="width:95%;margin:auto;border-collapse: collapse;" border=1>
           <tr>
            <th width="15%">Equipo</th>
            <th width="15%">Marca</th>
            <th width="15%">Modelo</th>
            <th width="15%">Serie</th>
            <th width="15%">Garantia</th>
            <th width="25%">Observaciones</th>
           </tr>
           <tr>
             <td style="text-align:left;padding-left:2px">'.$dataClave['equipo'].'</td>
             <td class="text-center">'.$dataClave['marca'].'</td>
             <td class="text-center">'.$dataClave['modelo'].'</td>
             <td class="text-center">'.$dataClave['serie'].'</td>
             <td class="text-center">'.$dataClave['garantia'].'</td>
             <td style="text-align:left;padding-left:2px">'.$dataClave['observaciones'].'</td>
           </tr>
           <tr>';
            if ($dataClave['garantia']=='si') { $txt.='
              <th>Problema</th>
              <td colspan="2" style="padding-left:2px">'.$dataClave['problema'].'</td>
              <th>Fecha de<br>Compra</th>
              <td style="text-align:center">'.$dataClave['fechaCompra'].'</td>
              <td style="padding-left:2px"><b>N&ordm; Factura </b> '.$dataClave['numFactura'].'</td>';
            }else{ $txt.='
              <th>Problema</th>
              <td colspan="5" style="padding-left:2px">'.$dataClave['problema'].'</td>';
            } $txt.='
           </tr>
         </table><br>';
        } $txt.='
    </div>';$footerSoporte = '
    <div style="padding-left:15px">
      <table autosize="1" style="width:100%;margin:auto;">
        <tr>
          <td width="50%" class="text-center">Firma de recepción</td>
          <td width="50%" class="text-center">Firma del cliente</td>
        </tr>
        <tr>
          <td width="50%;padding:5px" class="text-center">'.$nombreUsuario.'</td>
          <td width="50%;padding:5px" class="text-center">'.$nombreCliente.'</td>
        </tr>
        <tr>
          <td width="50%" class="text-center"></td>
          <td width="50%" class="text-center p-5">C.I___________________</td>
        </tr>
      </table>
      <b>Notas: Toda revisión del equipo tiene un costo en caso de que este no entre al taller.<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La empresa se hace responsable de las máquinas sólo hasta 90 días posteriores a la recepción</b>
    </div>';
    $mpdf->SetHTMLFooter($footerSoporte);
    $NamePDF= "Comprobante de servicio ".$idSoporte;
    $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output($NamePDF.".pdf", "I");
  }elseif ($servicio==2) {
    $Q_Servicio     = mysqli_query($MySQLi,"SELECT * FROM $baseDatos WHERE idSoporte='$idSoporte'AND estado=2");
    $dataServicio   = mysqli_fetch_assoc($Q_Servicio);
    $nombreCliente  = $dataServicio['nombreCliente'];
    $celularCliente = $dataServicio['telCliente'];
    $claveSoporte   = $dataServicio['clave_soporte'];
    $idUser         = $dataServicio['idUser'];
    $Q_Usuario      = mysqli_query($MySQLi,"SELECT nombre FROM usuarios WHERE id='$idUser' ");
    $dataUser       = mysqli_fetch_assoc($Q_Usuario);
    $nombreUsuario  = $dataUser['nombre'];
    $fechaRegistro  = fechaFormato($dataServicio['fechaRegistro']);
    $fechareparacion= fechaFormato($dataServicio['fechaReparacion']);
    $Q_SoporteClaves= mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$claveSoporte' AND estado=2 ORDER BY equipo DESC");
    $txt = '
    <div style="border: 5px solid;height:100%">
      <table autosize="1" style="width:100%;margin:auto;padding:3px">
        <tr>
          <td width="30%" style="padding:5px">';
            if ($sucursal=='Santa Cruz') { $txt.='
              <img src="assets/img/logoEqimport.png" width="150"><br>';
            }else{ $txt.='
              <img src="assets/img/imagenenblanco.png" width="150"><br>&nbsp;&nbsp;<br>';
            } $txt.='
          </td>
          <td width="40%" style="text-align:center"><u><h1>Informe del equipo entregado</h1></u></td>
          <td width="30%" style="text-align: right;color:red;padding:5px;"><h2>N&ordm; &nbsp;'.$ReciboNum.'</h2></td>
        </tr>
        <tr><td colspan="3" style="text-align:right"><h2>Sucursal: '.$sucursal.'</h2></td></tr> 
        <tr><td colspan="3" style="text-align:right"><h2>'.fechaLetras2($fechaRegistro).'</h2></td></tr>          
      </table>
      <table autosize="1" style="width:95%;margin:auto">
        <tr>
          <td width="33%"><b>Nombre: </b> '.$nombreCliente .'</td>
          <td width="33%" style="text-align:center"><b>Tel/cel: </b> '.$celularCliente .'</td>
        </tr>
      </table><br>';
        while ($dataClave = mysqli_fetch_assoc($Q_SoporteClaves)) { $txt.='
          <table autosize="1" style="width:95%;margin:auto;border-collapse: collapse;" border=1>
           <tr>
            <th width="15%">Equipo</th>
            <th width="15%">Marca</th>
            <th width="15%">Modelo</th>
            <th width="15%">Serie</th>
            <th width="15%">Garantia</th>
            <th width="25%">Observaciones</th>
           </tr>
           <tr>
             <td style="padding:3px" style="text-align:left;padding-left:2px">'.$dataClave['equipo'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['marca'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['modelo'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['serie'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['garantia'].'</td>
             <td style="padding:3px" style="text-align:left;padding-left:2px">'.$dataClave['observaciones'].'</td>
           </tr>
           <tr>';
            if ($dataClave['garantia']=='si') { $txt.='
              <th>Problema</th>
              <td colspan="2" style="padding:3px">'.$dataClave['problema'].'</td>
              <th>Fecha de<br>Compra</th>
              <td style="text-align:center">'.$dataClave['fechaCompra'].'</td>
              <td style="padding-left:2px"><b>N&ordm; Factura </b> '.$dataClave['numFactura'].'</td>';
            }else{ $txt.='
              <th>Problema</th>
              <td colspan="5" style="padding:3px">'.$dataClave['problema'].'</td>';
            } $txt.='
           </tr>
           <tr>
            <th>Realizado</th>
            <td colspan="4" style="padding:3px">'.$dataClave['trabajoRealizado'] .'</td>
            <td style="text-align:right;padding-right:2px"><h3>Total Bs &nbsp; '.($dataClave['costo']+$dataClave['costoAdicional']) .'</h3></td>
           </tr>
         </table>';
        } $txt.='
    </div>';$footerSoporte = '
    <div style="padding-left:15px">      
      <table autosize="1" style="width:100%;margin:auto;">
        <tr>
          <td width="50%" class="text-center">Firma de recepción</td>
          <td width="50%" class="text-center">Firma del cliente</td>
        </tr>
        <tr>
          <td width="50%;padding:5px" class="text-center">'.$nombreUsuario.'</td>
          <td width="50%;padding:5px" class="text-center">'.$nombreCliente.'</td>
        </tr>
        <tr>
          <td width="50%" class="text-center"></td>
          <td width="50%" class="text-center p-5">C.I___________________</td>
        </tr>
      </table>
      <b>Notas: Toda revisión del equipo tiene un costo en caso de que este no entre al taller.<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La empresa se hace responsable de las máquinas sólo hasta 90 días posteriores a la recepción</b>
    </div>';
    $mpdf->SetHTMLFooter($footerSoporte);
    $NamePDF= "Informe del equipo entregado ".$idSoporte;
    $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output($NamePDF.".pdf", "I");
  }elseif ($servicio==3) {
    $Q_Servicio     = mysqli_query($MySQLi,"SELECT * FROM $baseDatos WHERE idSoporte='$idSoporte'AND estado=1 ");
    $dataServicio   = mysqli_fetch_assoc($Q_Servicio);
    $nombreCliente  = $dataServicio['nombreCliente'];
    $celularCliente = $dataServicio['telCliente'];
    $claveSoporte   = $dataServicio['clave_soporte'];
    $idUser         = $dataServicio['idUser'];
    $Q_Usuario      = mysqli_query($MySQLi,"SELECT nombre FROM usuarios WHERE id='$idUser' ");
    $dataUser       = mysqli_fetch_assoc($Q_Usuario);
    $nombreUsuario  = $dataUser['nombre'];
    $fechaRegistro  = fechaFormato($dataServicio['fechaRegistro']);
    $fechareparacion= fechaFormato($dataServicio['fechaReparacion']);
    $Q_SoporteClaves= mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$claveSoporte' AND estado=1 AND sucursal='$sucursal' ORDER BY equipo DESC");
    $txt = '
    <div style="border: 5px solid;height:100%">
      <table autosize="1" style="width:100%;margin:auto;padding:3px">
        <tr>
          <td width="30%" style="padding:5px">';
            if ($sucursal=='Santa Cruz') { $txt.='
              <img src="assets/img/logoEqimport.png" width="150"><br>
';
            }else{ $txt.='
              <img src="assets/img/imagenenblanco.png" width="150"><br>&nbsp;&nbsp;<br>';
            } $txt.='
          </td>
          <td width="40%" style="text-align:center"><u><h1>Informe del equipo en reparación</h1></u></td>
          <td width="30%" style="text-align: right;color:red;padding:5px;"><h2>N&ordm; &nbsp;'.$ReciboNum.'</h2></td>
        </tr>
        <tr><td colspan="3" style="text-align:right"><h2>Sucursal: '.$sucursal.'</h2></td></tr> 
        <tr><td colspan="3" style="text-align:right"><h2>'.fechaLetras2($fechaRegistro).'</h2></td></tr>          
      </table>
      <table autosize="1" style="width:95%;margin:auto">
        <tr>
          <td width="33%"><b>Nombre: </b> '.$nombreCliente .'</td>
          <td width="33%" style="text-align:center"><b>Tel/cel: </b> '.$celularCliente .'</td>
        </tr>
      </table><br>';
        while ($dataClave = mysqli_fetch_assoc($Q_SoporteClaves)) { $txt.='
          <table autosize="1" style="width:95%;margin:auto;border-collapse: collapse;" border=1>
           <tr>
            <th width="15%">Equipo</th>
            <th width="15%">Marca</th>
            <th width="15%">Modelo</th>
            <th width="15%">Serie</th>
            <th width="15%">Garantia</th>
            <th width="25%">Observaciones</th>
           </tr>
           <tr>
             <td style="padding:3px" style="text-align:left;padding-left:2px">'.$dataClave['equipo'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['marca'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['modelo'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['serie'].'</td>
             <td style="padding:3px" class="text-center">'.$dataClave['garantia'].'</td>
             <td style="padding:3px" style="text-align:left;padding-left:2px">'.$dataClave['observaciones'].'</td>
           </tr>
           <tr>';
            if ($dataClave['garantia']=='si') { $txt.='
              <th>Problema</th>
              <td colspan="2" style="padding:3px">'.$dataClave['problema'].'</td>
              <th>Fecha de<br>Compra</th>
              <td style="text-align:center">'.$dataClave['fechaCompra'].'</td>
              <td style="padding-left:2px"><b>N&ordm; Factura </b> '.$dataClave['numFactura'].'</td>';
            }else{ $txt.='
              <th>Problema</th>
              <td colspan="5" style="padding:3px">'.$dataClave['problema'].'</td>';
            } $txt.='
           </tr>
           <tr>
            <th>Realizar</th>
            <td colspan="5" style="padding:3px">'.$dataClave['realizar'] .'</td>
           </tr>
         </table>';
        } $txt.='
    </div>';$footerSoporte = '
    <div style="padding-left:15px">      
      <table autosize="1" style="width:100%;margin:auto;">
        <tr>
          <td width="50%" class="text-center">Firma de recepción</td>
          <td width="50%" class="text-center">Firma del cliente</td>
        </tr>
        <tr>
          <td width="50%;padding:5px" class="text-center">'.$nombreUsuario.'</td>
          <td width="50%;padding:5px" class="text-center">'.$nombreCliente.'</td>
        </tr>
        <tr>
          <td width="50%" class="text-center"></td>
          <td width="50%" class="text-center p-5">C.I___________________</td>
        </tr>
      </table>
      <b>Notas: Toda revisión del equipo tiene un costo en caso de que este no entre al taller.<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La empresa se hace responsable de las máquinas sólo hasta 90 días posteriores a la recepción</b>
    </div>';
    $mpdf->SetHTMLFooter($footerSoporte);
    $NamePDF= "Informe del equipo en reparación ".$idSoporte;
    $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output($NamePDF.".pdf", "I");
  }elseif ($servicio==4) {
    $Q_Servicio     = mysqli_query($MySQLi,"SELECT * FROM soporte_sucursales WHERE idSoporte='$idSoporte'AND estado=3 ");
    $dataServicio   = mysqli_fetch_assoc($Q_Servicio);
    $nombreCliente  = $dataServicio['nombreCliente'];
    $celularCliente = $dataServicio['telCliente'];
    $claveSoporte   = $dataServicio['clave_soporte'];
    $idUser         = $dataServicio['idUser_entrego'];
    $Q_Usuario      = mysqli_query($MySQLi,"SELECT nombre FROM usuarios WHERE idUser='$idUser' ");
    $dataUser       = mysqli_fetch_assoc($Q_Usuario);
    $nombreUsuario  = $dataUser['nombre'];
    $fechaRegistro  = fechaFormato($dataServicio['fechaRegistro']);
    $fechareparacion= fechaFormato($dataServicio['fechaEntrega']);
    $Q_SoporteClaves= mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$claveSoporte' AND estado=3 AND sucursal='$sucursal' ORDER BY equipo DESC");
    $txt = '
    <div style="border: 5px solid;height:100%">
      <table autosize="1" style="width:100%;margin:auto;padding:3px">
        <tr>
          <td width="30%" style="padding:5px">';
            if ($sucursal=='Santa Cruz') { $txt.='
              <img src="assets/img/logoEqimport.png" width="150"><br>';
            }else{ $txt.='
              <img src="assets/img/imagenenblanco.png" width="150"><br>&nbsp;&nbsp;<br>';
            } $txt.='
          </td>
          <td width="40%" style="text-align:center"><u><h1>Informe del equipo entregado</h1></u></td>
          <td width="30%" style="text-align: right;color:red;padding:5px;"><h2>N&ordm; &nbsp;'.$ReciboNum.'</h2></td>
        </tr>
        <tr><td colspan="3" style="text-align:right"><h2>Sucursal: '.$sucursal.'</h2></td></tr> 
        <tr><td colspan="3" style="text-align:right"><h2>'.fechaLetras2($fechareparacion).'</h2></td></tr>          
      </table>
      <table autosize="1" style="width:95%;margin:auto">
        <tr>
          <td width="33%"><b>Nombre: </b> '.$nombreCliente.'</td>
          <td width="33%" style="text-align:center"><b>Tel/cel: </b> '.$celularCliente .'</td>
        </tr>
      </table><br>';
        while ($dataClave = mysqli_fetch_assoc($Q_SoporteClaves)) { $txt.='
          <table autosize="1" style="width:95%;margin:auto;border-collapse: collapse;" border=1>
            <tr>
              <th width="15%">Equipo</th>
              <th width="15%">Marca</th>
              <th width="15%">Modelo</th>
              <th width="15%">Serie</th>
              <th width="15%">Garantia</th>
              <th width="25%">Observaciones</th>
            </tr>
            <tr>
              <td style="padding:3px" style="text-align:left;padding-left:2px">'.$dataClave['equipo'].'</td>
              <td style="padding:3px" class="text-center">'.$dataClave['marca'].'</td>
              <td style="padding:3px" class="text-center">'.$dataClave['modelo'].'</td>
              <td style="padding:3px" class="text-center">'.$dataClave['serie'].'</td>
              <td style="padding:3px" class="text-center">'.$dataClave['garantia'].'</td>
              <td style="padding:3px" style="text-align:left;padding-left:2px">'.$dataClave['observaciones'].'</td>
            </tr>
            <tr>';
              if ($dataClave['garantia']=='si') { $txt.='
                <th>Problema</th>
                <td colspan="2" style="padding:3px">'.$dataClave['problema'].'</td>
                <th>Fecha de<br>Compra</th>
                <td style="text-align:center">'.$dataClave['fechaCompra'].'</td>
                <td style="padding-left:2px"><b>N&ordm; Factura </b> '.$dataClave['numFactura'].'</td>';
              }else{ $txt.='
                <th>Problema</th>
                <td colspan="5" style="padding:3px">'.$dataClave['problema'].'</td>';
              } $txt.='
            </tr>
            <tr>
              <th>Realizó</th>
              <td colspan="5" style="padding:3px">'.$dataClave['trabajoRealizado'] .'</td>
            </tr>
            <tr>'; 
              $costoTotal = $dataClave['costo']+$dataClave['costoAdicional'];
              if ($dataServicio['observaciones']=='') { $txt.='
                <td colspan="6" style="text-align:right"><b>TOTAL &nbsp;Bs. &nbsp; '.$costoTotal .'</b></td>';
              }else{ $txt.='
                <th colspan="2">Observaciones al entregar</th>
                <td colspan="3" style="padding:3px">'.$dataServicio['observaciones'] .'</td>
                <td style="text-align:right"><b>TOTAL &nbsp;Bs. &nbsp; '.$costoTotal.'</b></td>';
              } $txt.='
            </tr>
         </table>';
        } $txt.='
    </div>';$footerSoporte = '
    <div style="padding-left:15px">      
      <table autosize="1" style="width:100%;margin:auto;">
        <tr>
          <td width="50%" class="text-center">Firma de recepción</td>
          <td width="50%" class="text-center">Firma del cliente</td>
        </tr>
        <tr>
          <td width="50%;padding:5px" class="text-center">'.$nombreUsuario.'</td>
          <td width="50%;padding:5px" class="text-center">'.$nombreCliente.'</td>
        </tr>
        <tr>
          <td width="50%" class="text-center"></td>
          <td width="50%" class="text-center p-5">C.I___________________</td>
        </tr>
      </table>
      <b>Notas: Toda revisión del equipo tiene un costo en caso de que este no entre al taller.<br>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;La empresa se hace responsable de las máquinas sólo hasta 90 días posteriores a la recepción</b>
    </div>';
    $mpdf->SetHTMLFooter($footerSoporte);
    $NamePDF= "Informe del equipo en entregado ".$idSoporte;
    $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output($NamePDF.".pdf", "I");
  }
?>