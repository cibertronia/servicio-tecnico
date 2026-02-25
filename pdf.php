<?php
session_start();
if (isset($_SESSION['idUser'])) {
  include 'vendor/autoload.php';
  include 'includes/conexion.php';
  include 'includes/funciones.php';
  include 'includes/default.php';
  include 'includes/date.php';
  $Q_Configuraciones = mysqli_query($MySQLi, "SELECT * FROM `monedas` WHERE `idMoneda` = 1");
  $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
  // $monedaPrincipal   = $dataConfiguracion['monedaP'];
  $simboloMoneda     = $dataConfiguracion['simbolo'];
  // obtener el valor del dolar actual
  $dolar = mysqli_query($MySQLi, "SELECT precio FROM preciodolar WHERE idPrecio = 1");
  $dataDolar = mysqli_fetch_assoc($dolar);
  if (isset($_GET['idCotizacion'])) {
    $idCotizacion         = $_GET['idCotizacion'];
    $Q_Cotizacion         = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE idCotizacion='$idCotizacion'") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
    $resultCotizacion     = mysqli_num_rows($Q_Cotizacion);
    if ($resultCotizacion > 0) {
      $dataCotizacion       = mysqli_fetch_array($Q_Cotizacion);
      $codigoCotizacion     = $dataCotizacion['codigo'];
      $claveCotizacion      = $dataCotizacion['clave'];
      $idUserCotizacion     = $dataCotizacion['idUser'];
      $idClienteCotizacion  = $dataCotizacion['idCliente'];
      $idTiendaCotizacion   = $dataCotizacion['idTienda'];
      $formaPago            = $dataCotizacion['formaPago'];
      $validezOferta        = $dataCotizacion['fechaOferta'];
      $tiempoEntrega        = $dataCotizacion['tiempoEntrega'];
      $garantiaDetalles     = $dataCotizacion['garantiaDetalles'];
      $comentarios          = $dataCotizacion['comentarios'];
      $fechaCotizacion      = mesesSpanish($dataCotizacion['fecha']);
      $horaCotizacion       = fechaFormato($dataCotizacion['hora']);
      $Q_Cliente            = mysqli_query($MySQLi, "SELECT nombre,correo,empresa,telEmpresa,ext,celular FROM clientes WHERE idCliente='$idClienteCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataCliente          = mysqli_fetch_array($Q_Cliente);
      $nombreCliente        = $dataCliente['nombre'];
      $correoCliente        = $dataCliente['correo'];
      $empresaCliente       = $dataCliente['empresa'];
      $telEmpresaCliente    = $dataCliente['telEmpresa'];
      $exttelEmpresaCliente = $dataCliente['ext'];
      $celularCliente       = $dataCliente['celular'];
      $Q_Usuario            = mysqli_query($MySQLi, "SELECT cargo,Nombre,telefono FROM usuarios WHERE idUser='$idUserCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataUsuario          = mysqli_fetch_array($Q_Usuario);
      $cargoUsuario         = $dataUsuario['cargo'];
      $nombreUsuario        = $dataUsuario['Nombre'];
      $telefonoUsuario      = $dataUsuario['telefono'];
      $Q_CiudadRegistro     = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idTiendaCotizacion' ");
      $dataCiudadRegistro   = mysqli_fetch_array($Q_CiudadRegistro);
      $ciudadRegistro       = $dataCiudadRegistro['sucursal'];
      // if ($tipoHoja==1) {

      // }else{
      //  $alto         = 280;
      //  $ancho        = 220;
      //  $orientacion  = 'L';
      //  $margenHeader = 0;
      //  $margenFotter = 0;
      //  $margenLeft   = 0;
      //  $margenTop    = 26;
      //  $margenRight  = 0;
      //  $margenBottom = 26;
      // }
      $alto         = 280;
      $ancho        = 220;
      $orientacion  = 'L';
      $margenHeader = 0;
      $margenFotter = 0;
      $margenLeft   = 0;
      $margenTop    = 26;
      $margenRight  = 0;
      $margenBottom = 26;
      $mpdf                 = new \Mpdf\Mpdf([
        'mode'              => 'utf-8',
        'format'            => [$alto, $ancho],
        'orientation'       => $orientacion,
        'margin_header'     => $margenHeader,
        'margin_footer'     => $margenFotter,
        'margin_left'       => $margenLeft,
        'margin_top'        => $margenTop,
        'margin_right'      => $margenRight,
        'margin_bottom'     => $margenBottom,
      ]);
      $CSS                  = file_get_contents('assets/css/pdf.css');
      $mpdf->SetHTMLHeader('<img src="../assets/img/HEADER.png">');
      $mpdf->SetHTMLFooter('<img src="../assets/img/FOOTER.png">');
      $mpdf->shrink_tables_to_fit = 1;
      // Tabla # 1
      $txt                  = '
        <table class="tabla1">
          <tbody>
            <tr>
              <td>Sr(a): ' . $nombreCliente . '</td>
              <td style="text-align: right;">' . $ciudadRegistro . ", " . $fechaCotizacion . '</td>
            </tr>';
      if ($idCotizacion   < 10) {
        $Proforma = '<span style="letter-spacing: 1px">000000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 100) {
        $Proforma = '<span style="letter-spacing: 1px">00000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 1000) {
        $Proforma = '<span style="letter-spacing: 1px">0000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 10000) {
        $Proforma = '<span style="letter-spacing: 1px">000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 100000) {
        $Proforma = '<span style="letter-spacing: 1px">00' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 1000000) {
        $Proforma = '<span style="letter-spacing: 1px">0' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 10000000) {
        $Proforma = '<span style="letter-spacing: 1px">' . $idCotizacion . '</span>';
      }
      $txt .= '
            <tr><td colspan="2" class="pt-20">REF: Proforma  <b>' . $Proforma . '</b></td></tr>
            <tr><td colspan="2">Mediante la presente detallamos la proforma requerida:</td></tr>      
          </tbody>
        </table>';
      $TotalVenta           = 0;
      $Q_Cotizaciones       = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      while ($dataCotizaciones  = mysqli_fetch_assoc($Q_Cotizaciones)) {
        $idProducto         = $dataCotizaciones['idProducto'];
        $cantidad           = $dataCotizaciones['cantidad'];
        $PrecioLista        = $dataCotizaciones['precioVenta'] * $dataDolar['precio'];
        $PrecioVenta        = $dataCotizaciones['precioEspecial'] * $dataDolar['precio'];
        $subTotal           = $cantidad * $PrecioVenta;
        $TotalVenta         = $TotalVenta + $subTotal;

        $Q_Producto         = mysqli_query($MySQLi, "SELECT mercaderia, nombre,marca,modelo,industria,imagen,descripcion FROM productos WHERE idProducto='$idProducto' ");
        $dataProducto       = mysqli_fetch_assoc($Q_Producto);
        $nombreProducto     = $dataProducto['nombre'];
        $mercaderiaProducto     = $dataProducto['mercaderia'];
        $marcaProducto      = $dataProducto['marca'];
        $modeloProducto     = $dataProducto['modelo'];
        $industriaProducto  = $dataProducto['industria'];


        $mercaderia = $dataProducto['mercaderia'];
        $repuesto = $nombreProducto . " " . $marcaProducto . " " . $modeloProducto;


        $caracteristicas    = html_entity_decode($dataProducto['descripcion']);
        $imagen             = $dataProducto['imagen'];
        $imagenHTML         = htmlspecialchars($imagen);
        /* BUSCAMOS LA IMAGEN EN LA CARPETA PRDUCTOS */
        $ruta               = "Productos/" . $imagen;
        $txt                .= '
          <table class="tablaProductos" autosize="1" border="1" style="page-break-inside:avoid;">
            <thead>
              <tr>
                <th colspan="4">Producto<br>' . $mercaderiaProducto . " - " . $nombreProducto . '</th>
                <th colspan="2">Marca<br>' . $marcaProducto . '</th>
                <th colspan="2">Modelo<br>' . $modeloProducto . '</th>
              </tr>
            </thead>
            <tbody>
              <!--tr>
                <td width="50%" style="padding:5px" colspan="4"><b><br>Industria: ' . $industriaProducto . '</b><br>' . $caracteristicas . '</td>
                <td width="50%" colspan="4" style="text-align:center;padding:5px">';
        if (file_exists($ruta)) {
          $txt .= '
                    <img src="Productos/' . $imagenHTML . '" width="150px" />';
        } else {
          $txt .= '
                    <img src="Productos/nodisponible.jpg" width="150px" />';
        }
        $txt .= '
                </td>
              </tr-->
              <tr>
                <th style="text-align:center;padding:5px;" colspan="2">Cantidad: ' . $cantidad . '</td>
                <th colspan="2" style="text-align:right;padding:5px">Precio Venta<br>' . $simboloMoneda . ' &nbsp; ' . number_format($PrecioLista, 2) . '</th>
                <th colspan="2" style="text-align:right;padding:5px">Precio especial<br>' . $simboloMoneda . ' &nbsp; ' . number_format($PrecioVenta, 2) . '</th>
                <th colspan="2"  style="text-align:right;padding:5px;color: red;">Total<br>' . $simboloMoneda . ' &nbsp; ' . number_format(($cantidad * $PrecioVenta), 2) . '</th>
              </tr>';
        $txt .= ' 
            </tbody>
          </table>';
      }
      $txt .= '
        <table autosize="1" style="page-break-inside:avoid;" class="tablaFinal">
          <tbody>
            <tr>
              <td><strong>Total general</strong> ' . $simboloMoneda . ' &nbsp; ' . number_format($TotalVenta, 2) . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Precio puesto en: </strong> ' . $ciudadRegistro . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Tiempo de entrega: </strong> ' . $tiempoEntrega . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Forma de pago: </strong> ' . $formaPago . '</td>
            </tr>
            <tr>
              <td style="text-align:left;"><strong>Validez de la cotización: </strong><span style="color: red;"> ' . fechaFormato($validezOferta) . '</span></td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Observaciones: </strong> ' . $comentarios . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Garantia: </strong> ' . $garantiaDetalles . '</td>
            </tr>
            <tr><td>Cualquier consulta o requerimiento no dude en comunicarse con nosotros.</td></tr>
            <tr><td>&nbsp;&nbsp;</td></tr>    
            <tr><td><strong>Atentamente,</strong></td></tr>
            <tr><td>&nbsp;&nbsp;</td></tr>
            <tr><td style="text-align:  left">' . $nombreUsuario . '<br>Auxiliar de ventas<br>' . $telefonoUsuario . '</td></tr>
          </tbody>
        </table>';
      $NamePDF = "Cotizacion " . $idCotizacion;
      $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
      $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
      $mpdf->Output($NamePDF . ".pdf", "I");
    } else { ?>
      <div style="width:100%;text-align:center;margin-top: 25px;" class="parteI">La cotización solicitada no existe
        ...<br>Notifica al administrador.</div>
    <?php
    }
  } elseif (isset($_GET['idNotaEntrega'])) {
    $idNotaEntrega = $_GET['idNotaEntrega'];
    $Q_NotaEntrega = mysqli_query($MySQLi, "SELECT * FROM notaEntrega WHERE idNotaE='$idNotaEntrega' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
    $resultNotasE = mysqli_num_rows($Q_NotaEntrega);
    if ($resultNotasE > 0) {
      $dataNotaE    = mysqli_fetch_array($Q_NotaEntrega);
      $idCotizacion = $dataNotaE['idCotizacion'];
      $codigoCotiza = $dataNotaE['codigoCotizacion'];
      $claveCotiza  = $dataNotaE['claveCotizacion'];
      $idTienda     = $dataNotaE['idTienda'];
      $idVendedor   = $dataNotaE['idVendedor'];
      $nombreVended = $dataNotaE['nombreVendedor'];
      $idCliente    = $dataNotaE['idCliente'];
      $nombreCliente = $dataNotaE['nombreCliente'];
      $observaciones = $dataNotaE['observaciones'];
      $fechaNotaE   = fechaFormato($dataNotaE['fecha']);
      $Q_Cliente            = mysqli_query($MySQLi, "SELECT correo,empresa,telEmpresa,ext,celular FROM clientes WHERE idCliente='$idCliente' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataCliente          = mysqli_fetch_array($Q_Cliente);
      $correoCliente        = $dataCliente['correo'];
      $empresaCliente       = $dataCliente['empresa'];
      $telEmpresaCliente    = $dataCliente['telEmpresa'];
      $exttelEmpresaCliente = $dataCliente['ext'];
      $celularCliente       = $dataCliente['celular'];
      $Q_CiudadRegistro     = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idTienda' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataCiudadRegistro   = mysqli_fetch_array($Q_CiudadRegistro);
      $ciudadRegistro       = $dataCiudadRegistro['sucursal'];
      // if ($tipoHoja==1) {
      // }else{
      //  $alto         = 280;
      //  $ancho        = 220;
      //  $orientacion  = 'L';
      //  $margenHeader = 0;
      //  $margenFotter = 0;
      //  $margenLeft   = 0;
      //  $margenTop    = 26;
      //  $margenRight  = 0;
      //  $margenBottom = 26;
      // }
      $alto         = 280;
      $ancho        = 220;
      $orientacion  = 'L';
      $margenHeader = 0;
      $margenFotter = 0;
      $margenLeft   = 0;
      $margenTop    = 26;
      $margenRight  = 0;
      $margenBottom = 26;
      $mpdf                 = new \Mpdf\Mpdf([
        'mode'              => 'utf-8',
        'format'            => [$alto, $ancho],
        'orientation'       => $orientacion,
        'margin_header'     => $margenHeader,
        'margin_footer'     => $margenFotter,
        'margin_left'       => $margenLeft,
        'margin_top'        => $margenTop,
        'margin_right'      => $margenRight,
        'margin_bottom'     => $margenBottom,
      ]);
      $CSS                  = file_get_contents('assets/css/pdf.css');
      $mpdf->SetHTMLHeader('<img src="assets/img/imagenesYapame/header.png" >');
      $mpdf->SetHTMLFooter('<img src="assets/img/imagenesYapame/footer.png" >');
      $mpdf->shrink_tables_to_fit = 1;
      // Tabla # 1
      $txt                  = '
        <table class="tabla1NotaEntrega">
          <tbody>
            <tr>
              <td class="tituloMain">NOTA DE ENTREGA</td>';
      if ($idNotaEntrega   < 10) {
        $Proforma = '<span style="letter-spacing: 1px">000000' . $idNotaEntrega . '</span>';
      } elseif ($idNotaEntrega < 100) {
        $Proforma = '<span style="letter-spacing: 1px">00000' . $idNotaEntrega . '</span>';
      } elseif ($idNotaEntrega < 1000) {
        $Proforma = '<span style="letter-spacing: 1px">0000' . $idNotaEntrega . '</span>';
      } elseif ($idNotaEntrega < 10000) {
        $Proforma = '<span style="letter-spacing: 1px">000' . $idNotaEntrega . '</span>';
      } elseif ($idNotaEntrega < 100000) {
        $Proforma = '<span style="letter-spacing: 1px">00' . $idNotaEntrega . '</span>';
      } elseif ($idNotaEntrega < 1000000) {
        $Proforma = '<span style="letter-spacing: 1px">0' . $idNotaEntrega . '</span>';
      } elseif ($idNotaEntrega < 10000000) {
        $Proforma = '<span style="letter-spacing: 1px">' . $idNotaEntrega . '</span>';
      }
      $txt .= '
              <td class="tituloMain" style="text-align: right;color:#FC0C0C">N&ordm; ' . $Proforma . '</td>
            </tr>
            <tr>
              <td style="padding-top: 5px;">Sr(a): ' . $nombreCliente . '</td>
              <td style="text-align: right;">' . $ciudadRegistro . ", " . $fechaNotaE . '</td>              
            </tr>
            <tr>
              <td style="padding-top:5px;padding-bottom:-10px;text-align:left">Dirección de entrega:</td>
              <td style="text-align:right;padding-top:5px;padding-bottom:-10px">Teléfono: ' . $celularCliente . '</td>
            </tr>
          </tbody>
        </table>';
      $Q_clavesTemp   = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotiza' ORDER BY idClave ASC") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $txt .= '
        <table class="tablaProductos" autosize="1" border="1">
          <thead>
            <tr>
              <th width="25%" style="font-size:15px">Cantidad</th>
              <th width="75%" style="font-size:15px">Producto</th>
            </tr>
          </thead>
          <tbody>';
      while ($dataRegistros = mysqli_fetch_assoc($Q_clavesTemp)) {
        $txt .= '
            <tr>               
              <td style="text-align:center;padding:5px; ">' . $dataRegistros['cantidad'] . '</td>';
        $this_idProducto    = $dataRegistros['idProducto'];
        $Q_thisProducto     = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$this_idProducto'");
        $dataProducto       = mysqli_fetch_assoc($Q_thisProducto);
        $this_nameProducto  = $dataProducto['nombre'];
        $this_marcaProduct  = $dataProducto['marca'];
        $this_modeloProduc  = $dataProducto['modelo'];
        $nombreProducto     = $this_nameProducto . " " . $this_marcaProduct . " " . $this_modeloProduc;
        $txt .= '
              <td style="text-align:center;padding:5px; ">' . $nombreProducto . '</td>
            </tr>';
        $Q_Cotizacion   = mysqli_query($MySQLi, "SELECT garantiaDetalles FROM cotizaciones WHERE idCotizacion='$idCotizacion' ");
        $dataGarantia   = mysqli_fetch_assoc($Q_Cotizacion);
        $garantiaDetalle = $dataGarantia['garantiaDetalles'];
      }
      $txt .= '
            <tr>
              <td colspan="2" style="padding:5px"><b>Garantía</b>:<br> ' . $garantiaDetalle . '</td>
            </tr>
            <tr>
              <td colspan="2" style="padding:5px"><b>observaciones</b>:<br> ' . $observaciones . '</td>
            </tr>            
          </tbody>
        </table> 
        <table style="width:100%;margin-left: 20px">
          <tr>
            <td colspan="2" style="padding-top:-10px;font-size:7px">IMPORTANTE: NO SE CUBRE MALA MANIPULACIÓN DE LOS EQUIPOS. NO SE ACEPTAN CAMBIOS NI DEVOLUCIÓN DE DINERO O EQUIPOS</td>
          </tr>
          <tr>
            <td style="text-align:center;padding-top:50px">_________________________</td>
            <td style="text-align:center;padding-top:50px">_________________________</td>
          </tr>
          <tr>
            <td style="text-align:center">FIRMA CLIENTE</td>
            <td style="text-align:center">FIRMA VENDEDOR</td>
          </tr>
        </table>';

      $NamePDF = "Nota de entrega " . $idNotaEntrega;
      $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
      $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
      $mpdf->Output($NamePDF . ".pdf", "I");
    } else { ?>
      <div style="width:100%;text-align:center;margin-top: 25px;" class="parteI">La nota de entrega solicitada no existe
        ...<br>Notifica al administrador.</div>
    <?php
    }
  } elseif (isset($_GET['idRecibo'])) {
    $idRecibo   = $_GET['idRecibo'];
    $Q_Recibo   = mysqli_query($MySQLi, "SELECT * FROM recibos WHERE idRecibo='$idRecibo'");
    $resultRecib = mysqli_num_rows($Q_Recibo);
    if ($resultRecib  > 0) {
      $dataRecibo     = mysqli_fetch_assoc($Q_Recibo);
      $idCotizacion   = $dataRecibo['idCotizacion'];
      $claveCotizacion = $dataRecibo['claveCotizacion'];
      $idTienda       = $dataRecibo['idSucursal'];
      $idVendedor     = $dataRecibo['idVendedor'];
      $nombreVendedor = $dataRecibo['nombreVendedor'];
      $idCliente      = $dataRecibo['idCliente'];
      $nombreCliente  = $dataRecibo['nombreCliente'];
      $idMoneda       = $dataRecibo['idMoneda'];
      $fechaRecibo    = $dataRecibo['fecha'];

      if ($idMoneda == 1) {
        $cantidadNumeros  = $dataRecibo['cantidadNumeros1'];
        $total            = $dataRecibo['total1'];
      } else {
        $cantidadNumeros  = $dataRecibo['cantidadNumeros2'];
        $total            = $dataRecibo['total2'];
      }
      $cantidadLetras = $dataRecibo['cantidadLetras'];
      $concepto       = $dataRecibo['concepto'];
      $tipo           = $dataRecibo['tipo'];
      if ($tipo       != 1) {
        if ($idMoneda == 1) {
          $saldoAnterior  = $dataRecibo['saldoAnterior1'];
          $saldoActual    = $dataRecibo['saldoActual1'];
        } else {
          $saldoAnterior  = $dataRecibo['saldoAnterior2'];
          $saldoActual    = $dataRecibo['saldoActual2'];
        }
      }
      $fechaRecibo        = $dataRecibo['fecha'];
      $Q_Cliente            = mysqli_query($MySQLi, "SELECT correo,empresa,telEmpresa,ext,celular FROM clientes WHERE idCliente='$idCliente' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataCliente          = mysqli_fetch_array($Q_Cliente);
      $correoCliente        = $dataCliente['correo'];
      $empresaCliente       = $dataCliente['empresa'];
      $telEmpresaCliente    = $dataCliente['telEmpresa'];
      $exttelEmpresaCliente = $dataCliente['ext'];
      $celularCliente       = $dataCliente['celular'];
      $Q_CiudadRegistro     = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idTienda' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataCiudadRegistro   = mysqli_fetch_array($Q_CiudadRegistro);
      $ciudadRegistro       = $dataCiudadRegistro['sucursal'];
      $Q_Moneda             = mysqli_query($MySQLi, "SELECT * FROM monedas WHERE idMoneda='$idMoneda' ");
      $dataMoneda           = mysqli_fetch_assoc($Q_Moneda);
      $simbolo              = $dataMoneda['simbolo'];
      // if ($tipoHoja==1) {
      // }else{
      //  $alto         = 280;
      //  $ancho        = 220;
      //  $orientacion  = 'L';
      //  $margenHeader = 0;
      //  $margenFotter = 0;
      //  $margenLeft   = 0;
      //  $margenTop    = 26;
      //  $margenRight  = 0;
      //  $margenBottom = 26;
      // }
      $alto         = 140;
      $ancho        = 220;
      $orientacion  = 'L';
      $margenHeader = 0;
      $margenFotter = 0;
      $margenLeft   = 0;
      $margenTop    = 0;
      $margenRight  = 0;
      $margenBottom = 0;
      $mpdf                 = new \Mpdf\Mpdf([
        'mode'              => 'utf-8',
        'format'            => [$alto, $ancho],
        'orientation'       => $orientacion,
        'margin_header'     => $margenHeader,
        'margin_footer'     => $margenFotter,
        'margin_left'       => $margenLeft,
        'margin_top'        => $margenTop,
        'margin_right'      => $margenRight,
        'margin_bottom'     => $margenBottom,
      ]);
      $CSS                  = file_get_contents('assets/css/recibo.css');
      $mpdf->shrink_tables_to_fit = 1;
      if ($idRecibo   < 10) {
        $Proforma = '<span style="letter-spacing: 1px">000000' . $idRecibo . '</span>';
      } elseif ($idRecibo < 100) {
        $Proforma = '<span style="letter-spacing: 1px">00000' . $idRecibo . '</span>';
      } elseif ($idRecibo < 1000) {
        $Proforma = '<span style="letter-spacing: 1px">0000' . $idRecibo . '</span>';
      } elseif ($idRecibo < 10000) {
        $Proforma = '<span style="letter-spacing: 1px">000' . $idRecibo . '</span>';
      } elseif ($idRecibo < 100000) {
        $Proforma = '<span style="letter-spacing: 1px">00' . $idRecibo . '</span>';
      } elseif ($idRecibo < 1000000) {
        $Proforma = '<span style="letter-spacing: 1px">0' . $idRecibo . '</span>';
      } elseif ($idRecibo < 10000000) {
        $Proforma = '<span style="letter-spacing: 1px">' . $idRecibo . '</span>';
      }
      $txt = '
        <body>
          <div class="lineaNaranja"></div>
          <table class="seccion1">
            <tr>
              <td width="50%" class="logo">
                <img src="https://yapame.support/assets/img/favicon/logo.png" width="250" alt="Logo Yapame">
              </td>
              <td width="50%" class="reciboTitulo"><h1>Recibo de Pago</h1><br><span style="color:red;font-size: 28px">' . $Proforma . '</span></td>
            </tr>
            <tr>
              <td width="50%" class="fecha">' . $ciudadRegistro . ', ' . fechaFormato($fechaRecibo) . '</td>
              <td width="50%" class="lineaSimbolo">
                <span class="simbolo">' . $simbolo . '</span>
                <span class="cantidadNumeros">' . number_format(($cantidadNumeros), 2) . '</span>
              </td>
            </tr>
            <tr>
              <td colspan="2" class="seccion2">Recib&iacute; de: ' . $nombreCliente . ' </td>
            </tr>
            <tr>
              <td colspan="2" class="seccion2">La suma de: ' . $cantidadLetras . ' </td>
            </tr>
            <tr>
              <td colspan="2" class="seccion2" style="padding-bottom: 40px;">En concepto de: ' . $concepto . ' </td>
            </tr>
            <tr>
              <td class="seccion3"><b>Entregu&eacute; conforme:</b> </td>
              <td class="seccion3"><b>Recib&iacute; conforme:</b> </td>
            </tr>
            <tr>
              <td width="50%" class="lineaFirma">__________________________________</td>
              <td width="50%" class="lineaFirma">__________________________________</td>
            </tr>
            <tr>
              <td width="50%" style="text-align: center;">Firma:<br>' . $nombreVendedor . '</td>
              <td width="50%" style="text-align: center;">Firma:<br>' . $nombreCliente . '</td>
            </tr>
          </table>  
        </body>';
    }
    $NamePDF = "Recibo " . $idRecibo;
    $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
    $mpdf->Output($NamePDF . ".pdf", "I");
  } elseif (isset($_GET['enviarCotizacionCorreo'])) {
    $idCotizacion = $_GET['enviarCotizacionCorreo'];
    $Q_Cotizacion         = mysqli_query($MySQLi, "SELECT * FROM cotizaciones WHERE idCotizacion='$idCotizacion'") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
    $resultCotizacion     = mysqli_num_rows($Q_Cotizacion);
    if ($resultCotizacion > 0) {
      $dataCotizacion       = mysqli_fetch_array($Q_Cotizacion);
      $codigoCotizacion     = $dataCotizacion['codigo'];
      $claveCotizacion      = $dataCotizacion['clave'];
      $idUserCotizacion     = $dataCotizacion['idUser'];
      $idClienteCotizacion  = $dataCotizacion['idCliente'];
      $idTiendaCotizacion   = $dataCotizacion['idTienda'];
      $formaPago            = $dataCotizacion['formaPago'];
      $validezOferta        = $dataCotizacion['fechaOferta'];
      $tiempoEntrega        = $dataCotizacion['tiempoEntrega'];
      $garantiaDetalles     = $dataCotizacion['garantiaDetalles'];
      $comentarios          = $dataCotizacion['comentarios'];
      $fechaCotizacion      = mesesSpanish($dataCotizacion['fecha']);
      $horaCotizacion       = fechaFormato($dataCotizacion['hora']);
      $Q_Cliente            = mysqli_query($MySQLi, "SELECT nombre,correo,empresa,telEmpresa,ext,celular FROM clientes WHERE idCliente='$idClienteCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataCliente          = mysqli_fetch_array($Q_Cliente);
      $nombreCliente        = $dataCliente['nombre'];
      $correoCliente        = $dataCliente['correo'];
      $empresaCliente       = $dataCliente['empresa'];
      $telEmpresaCliente    = $dataCliente['telEmpresa'];
      $exttelEmpresaCliente = $dataCliente['ext'];
      $celularCliente       = $dataCliente['celular'];
      $Q_Usuario            = mysqli_query($MySQLi, "SELECT cargo,Nombre,telefono FROM usuarios WHERE idUser='$idUserCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      $dataUsuario          = mysqli_fetch_array($Q_Usuario);
      $cargoUsuario         = $dataUsuario['cargo'];
      $nombreUsuario        = $dataUsuario['Nombre'];
      $telefonoUsuario      = $dataUsuario['telefono'];
      $Q_CiudadRegistro     = mysqli_query($MySQLi, "SELECT * FROM sucursales WHERE idTienda='$idTiendaCotizacion' ");
      $dataCiudadRegistro   = mysqli_fetch_array($Q_CiudadRegistro);
      $ciudadRegistro       = $dataCiudadRegistro['sucursal'];
      // if ($tipoHoja==1) {

      // }else{
      //  $alto         = 280;
      //  $ancho        = 220;
      //  $orientacion  = 'L';
      //  $margenHeader = 0;
      //  $margenFotter = 0;
      //  $margenLeft   = 0;
      //  $margenTop    = 26;
      //  $margenRight  = 0;
      //  $margenBottom = 26;
      // }
      $alto         = 280;
      $ancho        = 220;
      $orientacion  = 'L';
      $margenHeader = 0;
      $margenFotter = 0;
      $margenLeft   = 0;
      $margenTop    = 26;
      $margenRight  = 0;
      $margenBottom = 26;
      $mpdf                 = new \Mpdf\Mpdf([
        'mode'              => 'utf-8',
        'format'            => [$alto, $ancho],
        'orientation'       => $orientacion,
        'margin_header'     => $margenHeader,
        'margin_footer'     => $margenFotter,
        'margin_left'       => $margenLeft,
        'margin_top'        => $margenTop,
        'margin_right'      => $margenRight,
        'margin_bottom'     => $margenBottom,
      ]);
      $CSS                  = file_get_contents('assets/css/pdf.css');
      $mpdf->SetHTMLHeader('<img src="assets/img/imagenesYapame/header.png" >');
      $mpdf->SetHTMLFooter('<img src="assets/img/imagenesYapame/footer.png" >');
      $mpdf->shrink_tables_to_fit = 1;
      // Tabla # 1
      $txt                  = '
        <table class="tabla1">
          <tbody>
            <tr>
              <td>Sr(a): ' . $nombreCliente . '</td>
              <td style="text-align: right;">' . $ciudadRegistro . ", " . $fechaCotizacion . '</td>
            </tr>';
      if ($idCotizacion   < 10) {
        $Proforma = '<span style="letter-spacing: 1px">000000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 100) {
        $Proforma = '<span style="letter-spacing: 1px">00000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 1000) {
        $Proforma = '<span style="letter-spacing: 1px">0000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 10000) {
        $Proforma = '<span style="letter-spacing: 1px">000' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 100000) {
        $Proforma = '<span style="letter-spacing: 1px">00' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 1000000) {
        $Proforma = '<span style="letter-spacing: 1px">0' . $idCotizacion . '</span>';
      } elseif ($idCotizacion < 10000000) {
        $Proforma = '<span style="letter-spacing: 1px">' . $idCotizacion . '</span>';
      }
      $txt .= '
            <tr><td colspan="2" class="pt-20">REF: Proforma  <b>' . $Proforma . '</b></td></tr>
            <tr><td colspan="2">Mediante la presente detallamos la proforma requerida:</td></tr>      
          </tbody>
        </table>';
      $TotalVenta           = 0;
      $Q_Cotizaciones       = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ") or die(mysqli_error($MySQLi) . "<br>Error en la línea: " . __LINE__);
      while ($dataCotizaciones  = mysqli_fetch_assoc($Q_Cotizaciones)) {
        $idProducto         = $dataCotizaciones['idProducto'];
        $cantidad           = $dataCotizaciones['cantidad'];
        $PrecioLista        = $dataCotizaciones['precioVenta'];
        $PrecioVenta        = $dataCotizaciones['precioEspecial'];
        $subTotal           = $cantidad * $PrecioVenta;
        $TotalVenta         = $TotalVenta + $subTotal;

        $Q_Producto         = mysqli_query($MySQLi, "SELECT mercaderia, nombre,marca,modelo,industria,imagen,descripcion FROM productos WHERE idProducto='$idProducto' ");
        $dataProducto       = mysqli_fetch_assoc($Q_Producto);
        $nombreProducto     = $dataProducto['nombre'];
        $mercaderiaProducto     = $dataProducto['mercaderia'];
        $marcaProducto      = $dataProducto['marca'];
        $modeloProducto     = $dataProducto['modelo'];
        $industriaProducto  = $dataProducto['industria'];

        $mercaderia = $dataProducto['mercaderia'];
        $caracteristicas    = html_entity_decode($dataProducto['descripcion']);
        $imagen             = $dataProducto['imagen'];
        $imagenHTML         = htmlspecialchars($imagen);
        /* BUSCAMOS LA IMAGEN EN LA CARPETA PRDUCTOS */
        $ruta               = "Productos/" . $imagen;
        $txt                .= '
          <table class="tablaProductos" autosize="1" border="1" style="page-break-inside:avoid;">
            <thead>
              <tr>
                <th colspan="4">Producto<br>' . $mercaderiaProducto . " - " . $nombreProducto . '</th>
                <th colspan="2">Marca<br>' . $marcaProducto . '</th>
                <th colspan="2">Modelo<br>' . $modeloProducto . '</th>
              </tr>
            </thead>
            <tbody>
              <!--tr>
                <td width="50%" style="padding:5px" colspan="4"><b><br>Industria: ' . $industriaProducto . '</b><br>' . $caracteristicas . '</td>
                <td width="50%" colspan="4" style="text-align:center;padding:5px">';
        if (file_exists($ruta)) {
          $txt .= '
                    <img src="Productos/' . $imagenHTML . '" width="150px" />';
        } else {
          $txt .= '
                    <img src="Productos/nodisponible.jpg" width="150px" />';
        }
        $txt .= '
                </td>
              </tr-->
              <tr>
                <td style="text-align:center;padding:5px;" colspan="2">Cantidad: ' . $cantidad . '</td>
                <th colspan="2" style="text-align:right;padding:5px;">Precio Venta<br>' . $simboloMoneda . ' &nbsp; ' . number_format($PrecioLista, 2) . '</th>
                <th colspan="2" style="text-align:right;padding:5px;">Precio especial<br>' . $simboloMoneda . ' &nbsp; ' . number_format($PrecioVenta, 2) . '</th>
                <th colspan="2"  style="text-align:right;padding:5px;">Total<br>' . $simboloMoneda . ' &nbsp; ' . number_format(($cantidad * $PrecioVenta), 2) . '</th>
              </tr>';
        $txt .= ' 
            </tbody>
          </table>';
      }
      $txt .= '
        <table autosize="1" style="page-break-inside:avoid;" class="tablaFinal">
          <tbody>
            <tr>
              <td><strong>Total general</strong> ' . $simboloMoneda . ' &nbsp; ' . number_format($TotalVenta, 2) . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Precio puesto en: </strong> ' . $ciudadRegistro . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Tiempo de entrega: </strong> ' . $tiempoEntrega . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Forma de pago: </strong> ' . $formaPago . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Validez de la cotización: </strong> ' . fechaFormato($validezOferta) . '</td>
            </tr>
            <tr>
              <td style="text-align:left"><strong>Garantia: </strong> ' . $garantiaDetalles . '</td>
            </tr>
            <tr><td>Cualquier consulta o requerimiento no dude en comunicarse con nosotros.</td></tr>
            <tr><td>&nbsp;&nbsp;</td></tr>    
            <tr><td><strong>Atentamente,</strong></td></tr>
            <tr><td>&nbsp;&nbsp;</td></tr>
            <tr><td>&nbsp;&nbsp;</td></tr>
            <tr><td style="text-align:  left">' . $nombreUsuario . '<br>Auxiliar de ventas<br>' . $telefonoUsuario . '</td></tr>
          </tbody>
        </table>';
      $NamePDF = "Cotizacion " . $idCotizacion;
      $ruta = "Cotizaciones/" . $NamePDF . ".pdf";
      $mpdf->WriteHTML($CSS, \Mpdf\HTMLParserMode::HEADER_CSS);
      $mpdf->WriteHTML($txt, \Mpdf\HTMLParserMode::HTML_BODY);
      $mpdf->Output($ruta);
    } else { ?>
      <div style="width:100%;text-align:center;margin-top: 25px;" class="parteI">La cotización solicitada no existe
        ...<br>Notifica al administrador.</div><?php
                                              }
                                            }
                                          } else {
                                            header("Location: /");
                                          }
