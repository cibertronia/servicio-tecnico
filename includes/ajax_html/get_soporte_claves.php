<?php
  session_start();
  include './../conexion.php';
 
if (isset($_POST['llamarEquiposSoporteHTML'])) {
    $clave      = $_POST['llamarEquiposSoporteHTML'];
    $Q_equipos  = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$clave' AND estado=0 ");    
    $str = '';
    $total_Global = 0;
    while ($data= mysqli_fetch_assoc($Q_equipos)) {
      $idClave = $data['idClave'];
      if($data['costo']==null){
        $costo=0;
      }
      else{
        $costo=$data['costo'];
      }
      $str.='<hr>
      <label for="costo_'.$data['idClave'].'"><b>
      '.$data['equipo'].' - 
      '.$data['modelo'].'
      '.$data['marca'].'
      </b>
      <b><br>Garantía Repuesto: &nbsp;'.strtoupper($data['garantia_vigente_repuesto']).'</br>
       Garantía Asistencia Tecníca: &nbsp;'.strtoupper($data['garantia_vigente_mano']).'
       
       <br>Costo Mano de Obra: &nbsp;'.strtoupper($costo).' Bs. </br>
       </b></label>
      <br></br>
      <table>
      <tr>
      <td width=20%><center><b>Nombre del Repuesto</b></center></td>
      <td width=20%><center><b>Cantidad</b></center></td>
      <td width=20%><center><b>Precio Especial</b></center></td>
      <td width=20%><center><b>Total</b></center></td>
      </tr>';
      $totalrepuestos = 0;
      $Q_repuestos = mysqli_query($MySQLi,"SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave'");     
      while ($row= mysqli_fetch_assoc($Q_repuestos)) {
      $str.='
      <tr>
      <td width=20%">'.strtoupper($row['nombre_repuesto']).'</td>
      <td width=20%"><center>'.strtoupper($row['cantidad']).'</center></td>
      <td width=20%"><center>'.strtoupper($row['precioEspecial']).' Bs.</center></td>
      <td width=20%"><center>'.strtoupper($row['cantidad']*$row['precioEspecial']).' Bs.</center></td>
      </tr>';
      $totalrepuestos = $totalrepuestos + ($row['cantidad']*$row['precioEspecial']);
       }
      $totalrepuestos = $totalrepuestos + $data['costo'];     
      $str.='
      <tr> <td width=33%"></td></tr>
      <tr>
      <td width=20%"></td>
      <td width=35%"><center><b>COSTO TOTAL REPUESTOS + COSTO MANO DE OBRA:  '.$totalrepuestos.' Bs</b></td>
      <td width=20%"><center></td>
      </tr>';
      $total_Global = $total_Global + $totalrepuestos;
      $str.='</table><br></br>'; 
       echo $str;
       $str='';
    } 
     echo  $str.='
     <center><b>TOTAL COSTO GENERAL: '.$total_Global.' Bs</b></center>';
    

    
  }