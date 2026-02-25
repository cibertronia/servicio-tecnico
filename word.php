<?php
	include 'vendor/autoload.php';
	include 'includes/conexion.php';
	include 'includes/funciones.php';
	include 'includes/default.php';
	include 'includes/date.php';
  include 'assets/css/class.php';
  $Q_Configuraciones = mysqli_query($MySQLi,"SELECT monedaP,simbolo FROM configuraciones");
  $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
  $monedaPrincipal   = $dataConfiguracion['monedaP'];
  $simboloMoneda     = $dataConfiguracion['simbolo'];
  $htd                  = new HTML_TO_DOC();
	$idCotizacion 				= $_GET['idCotizacion'];
	$Q_Cotizacion         = mysqli_query($MySQLi,"SELECT * FROM cotizaciones WHERE idCotizacion='$idCotizacion'")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
  $dataCotizacion       = mysqli_fetch_array($Q_Cotizacion);
  $codigoCotizacion 		= $dataCotizacion['codigo'];
  $claveCotizacion      = $dataCotizacion['clave'];
  $idUserCotizacion   	= $dataCotizacion['idUser'];
  $idClienteCotizacion  = $dataCotizacion['idCliente'];
  $idTiendaCotizacion 	= $dataCotizacion['idTienda'];
  $formaPago            = $dataCotizacion['formaPago'];
  $validezOferta        = $dataCotizacion['fechaOferta'];
  $tiempoEntrega        = $dataCotizacion['tiempoEntrega'];
  $garantiaDetalles 		= $dataCotizacion['garantiaDetalles'];
  $comentarios 					= $dataCotizacion['comentarios'];
  $fechaCotizacion 			= mesesSpanish($dataCotizacion['fecha']);
  $horaCotizacion 			= fechaFormato($dataCotizacion['hora']);
  $Q_Cliente 						= mysqli_query($MySQLi,"SELECT nombre,correo,empresa,telEmpresa,ext,celular FROM clientes WHERE idCliente='$idClienteCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
  $dataCliente 					= mysqli_fetch_array($Q_Cliente);
  $nombreCliente 				= $dataCliente['nombre'];
  $correoCliente 				= $dataCliente['correo'];
  $empresaCliente 			= $dataCliente['empresa'];
  $telEmpresaCliente 		= $dataCliente['telEmpresa'];
  $exttelEmpresaCliente	= $dataCliente['ext'];
  $celularCliente 			= $dataCliente['celular'];
  $Q_Usuario 						= mysqli_query($MySQLi,"SELECT cargo,Nombre,telefono FROM usuarios WHERE idUser='$idUserCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
  $dataUsuario 					= mysqli_fetch_array($Q_Usuario);
  $cargoUsuario 				= $dataUsuario['cargo'];
  $nombreUsuario 				= $dataUsuario['Nombre'];
  $telefonoUsuario 			= $dataUsuario['telefono'];
  $Q_CiudadRegistro 		= mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE idTienda='$idTiendaCotizacion' ");
  $dataCiudadRegistro 	= mysqli_fetch_array($Q_CiudadRegistro);
  $ciudadRegistro 			= $dataCiudadRegistro['sucursal'];
  // Tabla # 1
  $txt 									= '
  <table style="margin: 0px 20px 10px 20px;width: 100%;font-family:arial;font-size:9px">
    <tbody>
      <tr>
        <td>Sr(a): '.$nombreCliente.'</td>
        <td style="text-align: right;">'.$ciudadRegistro.", ".$fechaCotizacion.'</td>
      </tr>';
      if ($idCotizacion   < 10) {
		    $Proforma ='<span style="letter-spacing: 1px">000000'.$idCotizacion.'</span>';
		  }elseif ($idCotizacion< 100) {
		    $Proforma ='<span style="letter-spacing: 1px">00000'.$idCotizacion.'</span>';
		  }elseif ($idCotizacion< 1000) {
		    $Proforma ='<span style="letter-spacing: 1px">0000'.$idCotizacion.'</span>';
		  }elseif ($idCotizacion< 10000) {
		    $Proforma ='<span style="letter-spacing: 1px">000'.$idCotizacion.'</span>';
		  }elseif ($idCotizacion< 100000) {
		    $Proforma ='<span style="letter-spacing: 1px">00'.$idCotizacion.'</span>';
		  }elseif ($idCotizacion< 1000000) {
		    $Proforma ='<span style="letter-spacing: 1px">0'.$idCotizacion.'</span>';
		  }elseif ($idCotizacion< 10000000) {
		    $Proforma ='<span style="letter-spacing: 1px">'.$idCotizacion.'</span>';
		  } $txt.='
      <tr><td colspan="2" class="">REF: Proforma  <b>'.$Proforma.'</b></td></tr>
      <tr><td colspan="2">Mediante la presente detallamos la proforma requerida:</td></tr>      
    </tbody>
  </table>';
  $TotalVenta           = 0;
  $Q_Cotizaciones       = mysqli_query($MySQLi,"SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
  while ($dataCotizaciones  = mysqli_fetch_assoc($Q_Cotizaciones)) {
    $idProducto         = $dataCotizaciones['idProducto'];
    $cantidad           = $dataCotizaciones['cantidad'];
    $PrecioLista        = $dataCotizaciones['precioVenta'];
    $PrecioVenta        = $dataCotizaciones['precioEspecial'];
    $subTotal           = $cantidad*$PrecioVenta;
    $TotalVenta         = $TotalVenta+$subTotal;

    $Q_Producto         = mysqli_query($MySQLi,"SELECT nombre,marca,modelo,industria,imagen,descripcion FROM productos WHERE idProducto='$idProducto' ");
    $dataProducto       = mysqli_fetch_assoc($Q_Producto);
    $nombreProducto     = $dataProducto['nombre'];
    $marcaProducto      = $dataProducto['marca'];
    $modeloProducto     = $dataProducto['modelo'];
    $industriaProducto  = $dataProducto['industria'];
    $caracteristicas    = html_entity_decode($dataProducto['descripcion']);
    $imagen             = $dataProducto['imagen'];
    $imagenHTML         = htmlspecialchars($imagen);
    /* BUSCAMOS LA IMAGEN EN LA CARPETA PRDUCTOS */
    $ruta               = "Productos/".$imagen;
    $txt                .= '
    <table style="width: 100%;margin: 0px 20px 10px 20px;page-break-inside:avoid;border-collapse: collapse;font-family:arial;font-size:9px" autosize="1" border="1">
      <thead>
        <tr>
          <th colspan="4" style="text-align:center;padding:5px;background:#6a7eb5;color:#fff" >Producto<br>'.$nombreProducto .'</th>
          <th colspan="2" style="text-align:center;padding:5px;background:#6a7eb5;color:#fff" >Marca<br>'.$marcaProducto .'</th>
          <th colspan="2" style="text-align:center;padding:5px;background:#6a7eb5;color:#fff" >Modelo<br>'.$modeloProducto .'</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td width="50%" style="padding:5px" colspan="4"><b><br>Industria: '.$industriaProducto.'</b><br>'.$caracteristicas.'</td>
          <td width="50%" colspan="4" style="text-align:center;padding:5px">';
            if (file_exists($ruta)) { $txt.='
              <img src="https://yapame.support/'.$ruta.'" width="150" height="150" />';
            }else{ $txt.='
              <img src="https://yapame.support/Productos/nodisponible.jpg" height="150" />';
            } $txt.='
          </td>
        </tr>
        <tr>
          <td style="text-align:center;padding:5px;background:#6a7eb5;color:#fff" colspan="2">Cantidad: '.$cantidad.'</td>
          <th colspan="2" style="text-align:right;padding:5px;background:#6a7eb5;color:#fff">Precio Venta<br>'.$simboloMoneda.' &nbsp; '.number_format($PrecioLista,2).'</th>
          <th colspan="2" style="text-align:right;padding:5px;background:#6a7eb5;color:#fff">Precio especial<br>'.$simboloMoneda.' &nbsp; '.number_format($PrecioVenta,2).'</th>
          <th colspan="2"  style="text-align:right;padding:5px;background:#59C716;color:#fff">Total<br>'.$simboloMoneda.' &nbsp; '.number_format(($cantidad*$PrecioVenta),2) .'</th>
        </tr>';
         $txt.=' 
      </tbody>
    </table><br>';
  }
  $txt .='
  <table autosize="1" style="page-break-inside:avoid;width:100%;margin: 0px 20px 10px 20px;">
    <tbody>
      <tr>
        <td><strong>Total general </strong> '.$simboloMoneda.' &nbsp; '.number_format($TotalVenta,2).'</td>
      </tr>
      <tr>
        <td style="text-align:left"><strong>Precio puesto en: </strong> '.$ciudadRegistro.'</td>
      </tr>
      <tr>
        <td style="text-align:left"><strong>Tiempo de entrega: </strong> '.$tiempoEntrega.'</td>
      </tr>
      <tr>
        <td style="text-align:left"><strong>Forma de pago: </strong> '.$formaPago.'</td>
      </tr>
      <tr>
        <td style="text-align:left"><strong>Validez de la cotización: </strong> '.fechaFormato($validezOferta).'</td>
      </tr>
      <tr>
        <td style="text-align:left"><strong>Garantia: </strong> '.$garantiaDetalles.'</td>
      </tr>
      <tr><td>Cualquier consulta o requerimiento no dude en comunicarse con nosotros.</td></tr>
      <tr><td>&nbsp;&nbsp;</td></tr>    
      <tr><td><strong>Atentamente,</strong></td></tr>
      <tr><td>&nbsp;&nbsp;</td></tr>
      <tr><td>&nbsp;&nbsp;</td></tr>
      <tr><td style="text-align:  center">'.$nombreUsuario.'<br>Auxiliar de ventas<br>'.$telefonoUsuario.'</td></tr>
    </tbody>
  </table>';
  $NameCotizacion = "Cotización ".$idCotizacion;
  $htd->createDoc($txt, $NameCotizacion,1);