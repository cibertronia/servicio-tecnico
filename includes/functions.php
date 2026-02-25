<?php
//Funciones a usar en Equimport
function alertaFormulario(){
  echo'<div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true"><i class="fal fa-times-square"></i></span>
    </button>
    <strong>Puntos a tomar en cuenta, mientras se familiariza con el sistema:</strong><br><br>
    - Cuenta con 2 opciones: &nbsp; <i><b>Añadir otro equipo</b></i> &nbsp; o &nbsp; <i><b>No añadir mas equipos y continuar</b></i><br>
    Al presionar el botón: <button class="btn btn-primary btn-xs" type="button">Añadir otro equipo</button> &nbsp; deberá llenar todos los campos, ya que son obligatorios.<br>Sí todos los campos estan llenos, se mostrará una tabla con algunos datos del registro.<br>
    <img src="assets/img/ejemplos/tabla.png" alt="tabla" width="100%"><br>Los cuales podrá editar o borrar si así lo desea; pero, los datos del formulario se <i><b>borraran</b></i> (el formulario será limpiado), para que <i><b>Tenga que</b></i> (de caracter obligatorio) ingresar nuevos datos para el próximo equipo a registrar. &nbsp;&nbsp;<b>Qué quiere decir esto?</b><br>
    Que <b>NO podrá </b> preionar el botón <button class="btn btn-primary btn-xs" type="button">No añadir mas equipos y continuar</button> estando los campos del formulario vacío.<br>Sí cumple con los requerimientos del formulario y presiona el botón, los datos del nuevo registro + los mostrados en la tabla, se guardaran en un solo archivo y se mostraran en el siguiente paso que será: <i><b>En reparación.</b></i>
  </div>';
}
function fechaFormato($fecha){
  $newFecha = date('d-m-Y', strtotime($fecha));
  return $newFecha;
}
function fechaLetras($fecha){
  $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  $meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $dia  = $dias[date('w', strtotime($fecha))];
  $diaNumero = date('d', strtotime($fecha));
  $mes  = $meses[date('n', strtotime($fecha))-1];
  $Year = date('Y');
  $Fecha= $dia.", ".$diaNumero." de ".$mes." de ".$Year;
  return $Fecha;
}
function fechaLetras2($fecha){
  $dias = array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  $meses= array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  $dia  = $dias[date('w', strtotime($fecha))];
  $diaNumero = date('d', strtotime($fecha));
  $mes  = $meses[date('n', strtotime($fecha))-1];
  $Year = date('Y');
  $Fecha= $diaNumero." de ".$mes." de ".$Year;
  return $Fecha;
}
function noCambiosUsuario(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'uuups!',
      'Los datos del formulario no han cambiado, si desea modicar los datos, haga los respectivos cambios.',
      'error'
    )
  </script><?php
}
function registroServicioGuardado(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Ficha de servicio guardada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=registrados");
    },2000);
  </script><?php
}
function usuarioActualizado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO ACTUALIZADO!',
      'Los datos del usuario fueron cambiados.',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500)
  </script><?php
}
function productoSoporteActualizado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'EQUIPO ACTUALIZADO!',
      '',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500)
  </script><?php
}
function equipoBorrado_soporteClave(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'EQUIPO BORRADO',
      '',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500)
  </script><?php
}
function productoBorrado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Producto borrado!',
      'El producto seleccionado fué eliminado de la base de datos.',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500)
  </script><?php
}
function equipoReparado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Orden reparada!',
      'Los datos fueron guardados correctamente y la orden pasa a Reparados.',
      'success'
    )
    setTimeout(function(){
      location.replace("?root=reparados");
    },2500)
  </script><?php
}
function fichaServicioActualizada(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Ficha servicio actualizado!',
      '',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500)
  </script><?php
}
function fichaTecnicaBorrada(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Ficha de servicio eliminada!',
      'La ficha de reparación ha sido eliminada definitivamente',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500)
  </script><?php
}
function costosIngresados(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos ingresados correctamente!',
      'Los costos de cada unos de los equipos y el trabajo a realizar fueron ingresados correctamente.',
      'success'
    )
    setTimeout(function(){
      location.replace("?root=enReparacion");
    },3000)
  </script><?php
}
function fichaRegistroGuarada(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Ficha de servicio Guarada!',
      'Los datos de la ficha de servicio fueron guardados exitosamente!',
      'success'
    )
    setTimeout(function(){
      location.replace('?root=enReparacion');
    },2500)
  </script><?php
}
function equipoEntregado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos guardados!',
      'Los datos se guardaron correctamente y la ficha ha sido marcada como entregada!',
      'success'
    )
    setTimeout(function(){
      location.replace('?root=entregados');
    },2500)
  </script><?php
}
function reparacionGuardada(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Equipo Reparado!',
      'El equipo reparado pasará a la lista de reparados',
      'success'
    )
    setTimeout(function(){
      location.replace('?root=reparados');
    },2500)
  </script><?php
}
function precioDolar($MySQLi) {
  $queryDolar = mysqli_query($MySQLi,"SELECT * FROM preciodolar");
  $dataDolar  = mysqli_fetch_assoc($queryDolar);
  $PrecioDolar= $dataDolar['precio'];
  echo $PrecioDolar;
}
function cotizacionGenerada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización generada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=generadas");
    },2000);
  </script><?php
}
function cotizacionGeneradayEntregada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización Generada y Entregada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=entregadas");
    },2000);
  </script><?php
}
function cotizacionyClienteGenerada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización y Cliente Generados!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=generadas");
    },2000);
  </script><?php
}
function productoActualizado(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Producto actualizado!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=productos");
    },2000);
  </script><?php
}
function otroEquipoAgregado(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Equipo agregado!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.reload()
    },2500);
  </script><?php
}
function cotizacionEntregadayClienteGuardado(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización Entregada y Cliente Guardado!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=entregadas");
    },2000);
  </script><?php
}
function cotizacionActualizada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Cotización Actualizada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.reload();
    },2000);
  </script><?php
}
function ordenIndividualCancelada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Orden individual cancelada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=cancelados");
    },2000);
  </script><?php
}
function ordenTotalCancelada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Orden cancelada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=cancelados");
    },2000);
  </script><?php
}
function ordenRestaurada(){ ?>
  <script type="text/javascript">
    Swal.fire({
      icon: 'success',
      title: 'Orden restaurada!',
      animation: false,
      customClass: {
        popup: 'animated bounceInDown'
      }
    })
    setTimeout(function(){
      location.replace("?root=registrados");
    },2000);
  </script><?php
}
function equipsRegistrados($MySQLi,$Q_Servicio){
  while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) { ?>
    <tr>
      <td class="text-center pt-4"><?=$dataServicio['idSoporte'] ?></td>
      <td>
        <table>
          <tr>
            <th>Nombre Cliente</th>
            <td><?=$dataServicio['nombreCliente'] ?></td>
          </tr>
          <tr>
            <th>Fecha de registro</th>
            <td><?=fechaLetras2($dataServicio['fechaRegistro']) ?></td>
          </tr>
          <tr>
            <th>Sucursal</th>
            <td><?=$dataServicio['sucursal'] ?></td>
          </tr>
        </table>
        <table class="table table-bordered table-hover table-sm table-striped w-100">
          <thead>
            <tr>
              <th class="text-center">Equipo</th>
              <th class="text-center">Marca</th>
              <th class="text-center">Modelo</th>
              <th class="text-center">Serie</th>
              <th class="text-center">Garantia</th>
              <th class="text-center">Fecha Compra</th>
              <th class="text-center">N&ordm; Factura</th>
              <th class="text-center">Problema</th>
              <th class="text-center">Observaciones</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody><?php
            $Clave    = $dataServicio['clave_soporte'];
            $Q_Fichas = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=0 ");
            $R_Fichas = mysqli_num_rows($Q_Fichas);
            while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) { echo'
            <tr>
              <td>'.$dataFichas['equipo'].'</td>
              <td>'.$dataFichas['marca'].'</td>
              <td>'.$dataFichas['modelo'].'</td>
              <td>'.$dataFichas['serie'].'</td>
              <td class="text-center">'.$dataFichas['garantia'].'</td>';
              if ($dataFichas['garantia']=='si') { echo'
                <td class="text-center">'.$dataFichas['fechaCompra'].'</td>
                <td class="text-center">'.$dataFichas['numFactura'].'</td>';
              }else{ echo'
                <td class="text-center"><i>No aplica</i></td>
                <td class="text-center"><i>No aplica</i></td>';
              } echo'
              <td>'.$dataFichas['problema'].'</td>
              <td>'.$dataFichas['observaciones'].'</td>
              <td class="text-center">
                <a target="_blank" href="fichaTecnica.php?idClave='.$dataFichas['idClave'].'&sucursal='.$dataServicio['sucursal'].'&idSoporte='.$dataServicio['idSoporte'].'" class="btn btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed downloadPDF" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-secondary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a>

                <button id='.$dataFichas['idClave'].' class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_cancelarOrden_individual" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Remover este equipo de la orden de reparación"><i class="ni ni-ban"></i></button>

                <button id='.$dataFichas['idClave'].' class="btn btn-success btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_editInfoEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar información del producto ('.$dataFichas['idClave'].')"><i class="fal fa-pencil"></i></button>&nbsp;
                
              </td>
            </tr>';
            } ?>
          </tbody>
        </table>
      </td>
      <td class="text-center">
        <button id="<?=$Clave?>" class="mt-2 btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_AddEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar otro equipo"><i class="fal fa-plus"></i></button><br>

        <button id="<?=$dataServicio['clave_soporte']?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_ingresacostos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar a taller"><i class="far fa-handshake"></i></button><br>

        <a target="_blank" href="hojadeservicio.php?idSoporte=<?=$dataServicio['idSoporte']?>&Sucursal=<?=$dataServicio['sucursal'] ?>&servicio=1" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed downloadPDF" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar hoja de servicio en PDF"><i class="fal fa-file-pdf"></i></a><br>
        <!-- <a target="_blank" href="hojadeservicio.php?idSoporte=<?=$dataServicio['idSoporte']?>&Sucursal=<?php //$dataServicio['sucursal'] ?>&servicio=tecnico" class="btn mt-2 btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-light-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a> -->
      </td>
    </tr><?php
  }
}
function equipsRegistradosxSucursal($MySQLi,$Q_Servicio,$sucursalPrimaria){
  while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) { ?>
    <tr>
      <td class="text-center pt-4"><?=$dataServicio['idSoporte'] ?></td>
      <td>
        <table>
          <tr>
            <th>Nombre Cliente</th>
            <td><?=$dataServicio['nombreCliente'] ?></td>
          </tr>
          <tr>
            <th>Fecha de registro</th>
            <td><?=fechaLetras2($dataServicio['fechaRegistro']) ?></td>
          </tr>
        </table>
        <table class="table table-bordered table-hover table-sm table-striped w-100">
          <thead>
            <tr>
              <th class="text-center">Equipo</th>
              <th class="text-center">Marca</th>
              <th class="text-center">Modelo</th>
              <th class="text-center">Serie</th>
              <th class="text-center">Garantia</th>
              <th class="text-center">Fecha Compra</th>
              <th class="text-center">N&ordm; Factura</th>
              <th class="text-center">Problema</th>
              <th class="text-center">Observaciones</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody><?php
            $Clave    = $dataServicio['clave_soporte'];
            $Q_Fichas = mysqli_query($MySQLi,"SELECT* FROM soporte_claves WHERE clave='$Clave' AND estado=0 ");
            $R_Fichas = mysqli_num_rows($Q_Fichas);
            while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) { echo'
            <tr>
              <td>'.$dataFichas['equipo'].'</td>
              <td>'.$dataFichas['marca'].'</td>
              <td>'.$dataFichas['modelo'].'</td>
              <td>'.$dataFichas['serie'].'</td>
              <td class="text-center">'.$dataFichas['garantia'].'</td>';
              if ($dataFichas['garantia']=='si') { echo'
                <td class="text-center">'.$dataFichas['fechaCompra'].'</td>
                <td class="text-center">'.$dataFichas['numFactura'].'</td>';
              }else{ echo'
                <td class="text-center"><i>No aplica</i></td>
                <td class="text-center"><i>No aplica</i></td>';
              } echo'
              <td>'.$dataFichas['problema'].'</td>
              <td>'.$dataFichas['observaciones'].'</td>
              <td class="text-center">
                <a target="_blank" href="fichaTecnica.php?idClave='.$dataFichas['idClave'].'&sucursal='.$dataServicio['sucursal'].'&idSoporte='.$dataServicio['idSoporte'].'" class="btn btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-secondary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a>

                <button id='.$dataFichas['idClave'].' class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_cancelarOrden_individual" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Remover este equipo de la orden de reparación"><i class="ni ni-ban"></i></button>

                <button id='.$dataFichas['idClave'].' class="btn btn-success btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_editInfoEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar información del producto ('.$dataFichas['idClave'].')"><i class="fal fa-pencil"></i></button>&nbsp;
                
              </td>
            </tr>';
            } ?>
          </tbody>
        </table>
      </td>
      <td class="text-center">
        <button id="<?=$Clave?>" class="mt-2 btn btn-info btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_AddEquipo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Agregar otro equipo"><i class="fal fa-plus"></i></button><br>

        <button id="<?=$dataServicio['clave_soporte']?>" class="mt-2 btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed openModal_ingresacostos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Ingresar a taller"><i class="far fa-handshake"></i></button><br>

        <a target="_blank" href="hojadeservicio.php?idSoporte=<?=$dataServicio['idSoporte']?>&Sucursal=<?=$dataServicio['sucursal'] ?>&servicio=1" class="mt-2 btn btn-warning btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-warning-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar hoja de servicio en PDF"><i class="fal fa-file-pdf"></i></a><br>

        <!-- <a target="_blank" href="hojadeservicio.php?idSoporte=<?=$dataServicio['idSoporte']?>&Sucursal=<?php//$dataServicio['sucursal'] ?>&servicio=tecnico" class="btn mt-2 btn-secondary btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-light-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a> -->
      </td>
    </tr><?php
  }
}
function equipsCancelados($MySQLi,$Q_Servicio,$dataBase){
  while ($dataServicio = mysqli_fetch_assoc($Q_Servicio)) {
    $clave  = $dataServicio['clave'];
    $Q_Clave= mysqli_query($MySQLi,"SELECT * FROM $dataBase WHERE clave_soporte='$clave' ");
    $dataClv= mysqli_fetch_assoc($Q_Clave); ?>
    <tr>
      <td class="text-center pt-4"><?=$dataClv['idSoporte'] ?></td>
      <td>
        <table>
          <tr>
            <th>Nombre Cliente</th>
            <td><?=$dataClv['nombreCliente'] ?></td>
          </tr>
          <tr>
            <th>Fecha de registro</th>
            <td><?=fechaLetras2($dataClv['fechaRegistro']) ?></td>
          </tr>
          <tr>
            <th>Sucursal</th>
            <td><?=$dataClv['sucursal'] ?></td>
          </tr>
        </table>
        <table class="table table-bordered table-hover table-sm table-striped w-100">
          <thead>
            <tr>
              <th class="text-center">Equipo</th>
              <th class="text-center">Marca</th>
              <th class="text-center">Modelo</th>
              <th class="text-center">Serie</th>
              <th class="text-center">Garantia</th>
              <th class="text-center">Fecha Compra</th>
              <th class="text-center">N&ordm; Factura</th>
              <th class="text-center">Problema</th>
              <th class="text-center">Observaciones</th>
              <th class="text-center">Realizar</th>
              <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody><?php
            $Clave    = $dataClv['clave_soporte'];
            $Q_Fichas = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$Clave' AND estado=4 ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
            $R_Fichas = mysqli_num_rows($Q_Fichas);
            while ($dataFichas = mysqli_fetch_assoc($Q_Fichas)) { echo'
            <tr>
              <td>'.$dataFichas['equipo'].'</td>
              <td>'.$dataFichas['marca'].'</td>
              <td>'.$dataFichas['modelo'].'</td>
              <td>'.$dataFichas['serie'].'</td>
              <td class="text-center">'.$dataFichas['garantia'].'</td>';
              if ($dataFichas['garantia']=='si') { echo'
                <td class="text-center">'.$dataFichas['fechaCompra'].'</td>
                <td class="text-center">'.$dataFichas['numFactura'].'</td>';
              }else{ echo'
                <td class="text-center"><i>No aplica</i></td>
                <td class="text-center"><i>No aplica</i></td>';
              } echo'
              <td>'.$dataFichas['problema'].'</td>
              <td>'.$dataFichas['observaciones'].'</td>
              <td>'.$dataFichas['realizar'].'</td>
              <td class="text-center"><button id='.$dataFichas['idClave'].' class="mt-2btn btn-primary btn-xs btn-icon rounded-circle waves-effect waves-themed restaurarOrdenSoporte" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Restaurar orden de reparación"><i class="far fa-paper-plane"></i></button></td>
            </tr>
            <tr>
              <th colspan="3">Motivo de la cancelación</th>
              <td colspan="7">'.$dataFichas['motivo'].'</td>
            </tr> ';
            } ?>
          </tbody>
        </table>
      </td>
    </tr><?php
  }
}
//funciones utilizadas en este script
  
function listaClientes($MySQLi, $idUser, $idRango){
  if ($idRango>2) {
    $Q_misClientes    = mysqli_query($MySQLi,"SELECT * FROM clientes ORDER BY Nombre ASC ");
  }else{
    $Q_misClientes    = mysqli_query($MySQLi,"SELECT * FROM clientes WHERE idRegistrador='$idUser' ORDER BY Nombre ASC ");
  } $Num=1;
  while ($dataClientes= mysqli_fetch_assoc($Q_misClientes)) { $idCliente = $dataClientes['idCliente']; echo'
    <tr>
      <td class="text-center">'.$Num.'</td>
      <td>'.$dataClientes['Nombre'].'</td>
      <td>'.$dataClientes['Correo'].'</td>
      <td class="text-center">';
        if ($dataClientes['Codigo']!='' and $dataClientes['Telefono']!='') {
          echo '('.$dataClientes['Codigo'].") ".$dataClientes['Telefono'];
        }else{
          echo'';
        }
        if ($dataClientes['ApiTelegram']!='') { echo'
          <button class="btn btn-primary btn-sm btn-icon rounded-circle modalTelegram"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Enviar mensaje por Telegram" id='.$dataClientes['idCliente'].'><i class="fal fa-paper-plane"></i></button>';
        } echo'
      </td>
      <td>'.$dataClientes['por'].'</td>
      <td class="text-center">'; misDispositivos($MySQLi,$idCliente); echo'</td>
      <td class="text-center">
      <button class="btn btn-primary btn-sm btn-icon rounded-circle add_Device"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Añadir un dispositivo a este cliente" id="'.$dataClientes['idCliente'].'"><i class="fal fa-plus-circle"></i></button>&nbsp;&nbsp;&nbsp;
        <button class="btn btn-primary btn-sm btn-icon rounded-circle editarCliente"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar cliente" id="'.$dataClientes['idCliente'].'"><i class="far fa-user-edit"></i></button>&nbsp;&nbsp;&nbsp;
        <button  id="'.$dataClientes['idCliente'].'" class="btn btn-danger btn-sm btn-icon rounded-circle borrarCliente" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar cliente"><i class="far fa-trash-alt"></i></button>
      </td>
    </tr>'; $Num++;
  }
}
function listaUsuarios($MySQLi, $idUser, $idRango){
  $Num              = 1;
  $Q_Users          = mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE estado=1 ORDER BY nombre ASC ");
  while ($dataUsers = mysqli_fetch_assoc($Q_Users)) { echo'
    <tr>
      <td class="text-center">'.$Num.'</td>
      <td>'.$dataUsers['nombre'].'</td>
      <td>'.$dataUsers['sexo'].'</td>
      <td>'.$dataUsers['cargo'].'</td>
      <td>'.$dataUsers['telefono'].'</td>
      <td>'.$dataUsers['email'].'</td>
      <td>'.$dataUsers['ciudad'].'</td>
      <td>'.$dataUsers['uss'].'</td>
      <td>'.$dataUsers['pass'].'</td>
      <td class="text-center">
        <button class="btn btn-primary btn-sm btn-icon rounded-circle openModal_editarUsuario"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar usuaio" id='.$dataUsers['id'].'><i class="far fa-user-edit"></i></button>&nbsp;';
        if ($dataUsers['estado']==1) { echo'<button class="btn btn-danger btn-sm btn-icon rounded-circle turnOff" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Desactivar usuario" id='.$dataUsers['id'].'><i class="far fa-power-off"></i></button>';
        }else{ echo'<button class="btn btn-success btn-sm btn-icon rounded-circle turnON" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Activar usuario" id='.$dataUsers['id'].'><i class="far fa-power-off"></i></button>';
        } echo'
      </td>
    </tr>'; $Num++;
  }
}
function listamisDispositivos($MySQLi, $idUser, $idRango){
  if ($idRango>2) {
    $Q_misDispositivos    = mysqli_query($MySQLi,"SELECT * FROM dispositivos WHERE FMI='ON' ORDER BY idDispositivo ASC ");
  }else{
    $Q_misDispositivos    = mysqli_query($MySQLi,"SELECT * FROM dispositivos WHERE idUser='$idUser' AND FMI='ON' ORDER BY idDispositivo ASC ");
  } $Num=1;
  while ($dataDispositivo = mysqli_fetch_assoc($Q_misDispositivos)) {
    $DispoName            = $dataDispositivo['Nombre']." ".$dataDispositivo['Modelo']." ".$dataDispositivo['Color']." ".$dataDispositivo['Capacidad']; echo'
    <tr>
      <td class="text-center">'.$Num.'</td>';
      $idCliente          = $dataDispositivo['idCliente'];
      $Q_Cliente          = mysqli_query($MySQLi,"SELECT * FROM clientes WHERE idCliente='$idCliente' ");
      $dataCliente        = mysqli_fetch_assoc($Q_Cliente); echo'
      <td>'.$dataCliente['Nombre'].'</td>
      <td>'.$dataDispositivo['IMEISERIAL'].'</td>
      <td>'.$DispoName.' &nbsp;
        <button class="btn btn-primary btn-sm btn-icon rounded-circle modal_editDispoName" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar estos datos del dispositivo seleccionado" id='.$dataDispositivo['idDispositivo'].'><i class="fal fa-edit"></i></button>
      </td>
      <td class="text-center">
        <button class="btn btn-primary btn-block btn-sm listarTelefonos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="click para mostrar el o los teléfonos registrados a este dispositivo" id='.$dataDispositivo['idDispositivo'].'>Teléfono</button></td>
      <td class="text-center">
        <button class="btn btn-primary btn-block btn-sm listarCorreos" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="click para mostrar el o los correos registrados a este dispositivo" id='.$dataDispositivo['idDispositivo'].'>Correo</button></td>
      <td class="text-center">
        <button class="btn btn-danger btn-sm btn-icon rounded-circle checkFMI" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner fmiCheck bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Este dispositivo en lista aparece como ON, si desea consultar su status actual, haga click" id='.$dataDispositivo['IMEISERIAL'].'>ON</button>
      </td>
      <td class="text-center">';
        $idDispositivo  = $dataDispositivo['idDispositivo'];
        $Q_PhoneDispo   = mysqli_query($MySQLi,"SELECT * FROM telefonos_dispositivos WHERE idDispositivo='$idDispositivo' ");
        $ResultQPhoneDis= mysqli_num_rows($Q_PhoneDispo);
        if ($ResultQPhoneDis>0) {
          $dataPhoneDisp= mysqli_fetch_assoc($Q_PhoneDispo);
          if ($dataPhoneDisp['Telefono']!='') { echo'
            <button class="btn btn-primary btn-sm btn-icon rounded-circle modalSMS" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-primary-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Procesar por SMS" id='.$dataPhoneDisp['idDispositivo'].'><i class="fal fa-sms"></i></button>&nbsp;&nbsp;&nbsp;';
          }
        }
        $Q_MailDispo    = mysqli_query($MySQLi,"SELECT * FROM correos_dispositivos WHERE idDispositivo='$idDispositivo' ");
        $ResultQMailDisp= mysqli_num_rows($Q_MailDispo);
        if ($ResultQMailDisp>0) {
          $dataMailDispo= mysqli_fetch_assoc($Q_MailDispo);
          if ($dataMailDispo['Correo']!='') { echo'
            <button class="btn btn-info btn-sm btn-icon rounded-circle modalCorreo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-info-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Procesar por correo" id='.$dataDispositivo['idDispositivo'].'><i class="fal fa-envelope-open-text"></i></button>&nbsp;&nbsp;&nbsp;';
          }
        }echo'
        <button class="btn btn-danger btn-sm btn-icon rounded-circle borrarDispositivo" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Borrar dispositivo" id='.$dataCliente['idCliente'].'><i class="fal fa-trash-alt"></i></button>
      </td>
    </tr>'; $Num++;
  }
}  
function error404(){
  echo'
  <div class="h-alt-f d-flex flex-column align-items-center justify-content-center text-center">
    <h1 class="page-error color-fusion-500">
      ERROR <span class="text-gradient">404</span>
      <small class="fw-500">Algo <u>está</u> mal!</small>
    </h1>
    <h3 class="fw-500 mb-5">
      La página que solicitaste no existe <br>ó aún está en construcción.</h3>
    <h4>Si crees que esto es un error, notifica al Administrador.
    </h4>
  </div>';
}
//funciones no utilizadas

function recoveryPswd(){ ?>
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle1">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        Cras mattis consectetur purus sit amet fermentum. </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div><?php
}
function expirado($MySQLi){
  mysqli_close($MySQLi); session_destroy();?>
  <script type="text/javascript">
    Swal.fire(
      'SESSION EXPIRADA',
      'La sessión expiró, vuelve a ingresar al sistema para efectuar el cambio solicitado',
      'error'
    )
    setTimeout(function(){
      location.reload()
    },2500);
  </script> <?php
}
function sinAutorizacion($MySQLi){
  mysqli_close($MySQLi);?>
  <script type="text/javascript">
    Swal.fire(
      'SIN AUTORIZACIÓN',
      'No posees los permisos para esta acción.',
      'error'
    )
  </script> <?php
}
function noPermitido(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'ACCIÓN NO PERMITIDA',
      'No es posible desactivar o eliminar a un administrador.<br>Si deseas efectuar esta acción, tendrás que solicitarla al Programador!',
      'error'
    )
  </script> <?php
}
function usuarioDesactivado(){?>
  <script type="text/javascript">
    Swal.fire(
      "Deshabilitado!",
      "El usuario seleccionado ha sido deshabilitado.",
      "success"
    );
    setTimeout(function(){
      location.reload()
    },3500);
  </script> <?php
}
function usuarioActivado(){?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO ACTIVADO',
      'El usuario seleccionado, ha sido habilitado.',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500);
  </script> <?php
}
function adminActualizoUsuario(){?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO actualizado',
      'Los datos del usuario seleccionado fueron cambiados.',
      'success'
    )
    setTimeout(function(){
      location.reload()
    },2500);
  </script> <?php
}
function errorToken($MySQLi){
  mysqli_close($MySQLi);?>
  <script type="text/javascript">
    Swal.fire(
      'Petición desconocida',
      'la acción solicitada no existe o está fuera de servicio, favor de contactar con el Administrador.',
      'error'
    )
  </script> <?php
}
function password($length = 8) { 
  $chars  = '0123456789';
  $count  = mb_strlen($chars);
  for ($i = 0, $result = ''; $i < $length; $i++) { 
    $index  = rand(0, $count - 1); 
    $result .= mb_substr($chars, $index, 1); 
  } 
  return $result; 
}
function usuarioRegistrado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'USUARIO REGISTRADO',
      'El usuario recibirá un correo donde encontrará su respectiva contraseña de ingreso al sistema.',
      'success'
    )
    // setTimeout(function(){
    //   location.reload()
    // },2500);
  </script><?php
}
function errorMail(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'ERROR!',
      'Hubo un error al intentar enviar el correo',
      'error'
    )
    // setTimeout(function(){
    //   location.reload()
    // },2500);
  </script><?php
}
function correoExiste(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'ERROR!',
      'El usuario no puede ser registrado, ya que el correo existe en la base de datos<br>Deberá solicitar al soporte que ese correo sea eliminado o cambie manualmente.',
      'error'
    )
  </script><?php
}
function elusuarioYaexiste(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'ERROR!',
      'El usuario no puede ser registrado, ya que existe en la base de datos<br>Deberá solicitar al soporte que ese correo sea eliminado o cambie manualmente.',
      'error'
    )
  </script><?php
}
  
  
function cuentaMailDesactivada(){
  mysqli_close($MySQLi);?>
  <script type="text/javascript">
    Swal.fire(
      'Cuenta deshabilitada',
      'la cuenta mail seleccionada, ha sido deshabilitada.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function cuentaMailActivada(){
  mysqli_close($MySQLi);?>
  <script type="text/javascript">
    Swal.fire(
      'Cuenta habilitada',
      'la cuenta mail seleccionada, ha sido habilitada.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function cuentaMailModificada(){
  mysqli_close($MySQLi);?>
  <script type="text/javascript">
    Swal.fire(
      'Datos actualizados',
      'Los datos del correo seleccionado, han sido modificados.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function cuentaMailCreada(){
  mysqli_close($MySQLi);?>
  <script type="text/javascript">
    Swal.fire(
      'Cuenta creada',
      'la cuenta ha sido creada exitosamente.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function TeleEnviado(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Mensaje enviado',
      'El mensaje fue enviado exitosamente.',
      'success'
    )
    setTimeout(function(){
      Swal.close()
    },2500);
  </script> <?php
}
function nuevoClienteOK(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Cliente Registrado',
      'El nuevo cliente ha sido guardado en la base de datos.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function ClienteUP_OK(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Datos actualizados',
      'Los datos del cliente fueron modificados.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function aleatorio(){
  $code   = uniqid();
  $code   = substr($code, -10);
  return $code;
}
function fechaInicio($fechaINICIO){
  $inicio   = explode("-", $fechaINICIO);
  $f_inicio = $inicio[2]."-".$inicio[1]."-".$inicio[0];
  return $f_inicio;
}
function fechaFin($fechaFIN){
  $fin      = explode("-", $fechaFIN);
  $f_fin    = $fin[2]."-".$fin[1]."-".$fin[0];
  return $f_fin;
}  
function apiTeleActualizada(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Api Actualizada',
      'La Api fué actualizada con éxito.',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
}
function apiTelesincambios(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'NO HAY CAMBIOS',
      'no encontramos cambios, así que no podemos guardar nada.',
      'error'
    )
  </script> <?php
}
function categoriaActualizada(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'CATEGORIA ACTUALIZADA',
      '',
      'success'
    )
    setTimeout(function(){
      location.replace("?root=categorias");
    },2500);
  </script> <?php
}
function contrasenaUPDATED(){ ?>
  <script type="text/javascript">
    Swal.fire(
      'Contraseña actualizada.',
      '',
      'success'
    )
    setTimeout(function(){
      location.reload();
    },2500);
  </script> <?php
} 