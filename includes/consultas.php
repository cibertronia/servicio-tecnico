<?php
  session_start();
  include 'conexion.php';
  include 'funciones.php';
  include 'date.php';
  require '../vendor/autoload.php';
  if (isset($_POST['idCotiza'])) {
    $idUser               = 55;
    $idCot                = $_POST['idCotiza'];
    $queryCotizacion      = mysqli_query($Equimp,"SELECT * FROM cotizaciones WHERE id='$idCot'");
    $data                 = mysqli_fetch_array($queryCotizacion);
    $id_cotizacion        = $data['id_cotizacion'];
    $ConsultaUsuario      = mysqli_query($Equimp,"SELECT * FROM usuarios WHERE id='$idUser' ");
    $User                 = mysqli_fetch_array($ConsultaUsuario);
    $Nombre               = $data['nombre'];
    $Telefono             = $data['telefono'];
    $Ciudad               = $data['ciudad'];
    $Ciudad               = $data['ciudad'];
    $Registro             = $data['id'];
    $Validez              = $data['oferta'];
    $Tiempo_E             = $data['entrega'];
    $Forma_p              = $data['pago'];
    $Observac             = $data['observaciones'];
    $Correo               = $data['email'];
    $Usuario              = $User['nombre'];
    $Cargo                = $User['cargo'];
    $MyCorreo             = $User['email'];
    $Tienda               = $User['ciudad'];
    $txt                  = '
    <table width="100%">
      <tbody>
        <tr>
          <img src="https://sistema.equimport.com.bo/pdf/img/pie.png" height="100">
        </tr>
        <tr>
          <td>Sr(a): '.$Nombre.'</td>
          <td style="text-align: right;">'.$Fecha.'</td>
        </tr>
        <tr><td colspan="2">'.$Tienda.'</td></tr>
        <tr><td colspan="2" class="pt-20">REF: Proforma  000'.$Registro.'</td></tr>
        <tr><td colspan="2">Mediante la presente detallamos la proforma requerida:</td></tr>      
      </tbody>
    </table>
    <table border=1>
      <tbody>
        <tr>
          <th class="p-3 text-center" colspan="6" bgcolor="#008000">
            <h1><font color="#ffff66">Producto</font></h1>
          </th>
        </tr>
        <tr>
          <td class="text-center" width="5%">Cant.</td>
          <td class="text-center" width="45%">Descripción</td>
          <td class="text-center" width="10%">P. Venta</td>
          <td class="text-center" width="10%">P. Especial</td>
          <td class="text-center" width="10%">SubTotal</td>
          <td class="text-center" width="20%">Imagen</td>
        </tr>';
        $tg             = 0;
        $Q_Productos    = mysqli_query($Equimp,"SELECT * FROM cotizaciones_productos WHERE id_cotizacion='$id_cotizacion' ");
        $ResultProduct  = mysqli_num_rows($Q_Productos);
        if ($ResultProduct>0) {
          while ($dataProducto = mysqli_fetch_assoc($Q_Productos)) {
            $id         = $dataProducto['id'];
            $cantidad   = $dataProducto['cantidad'];
            $producto   = $dataProducto['producto'];
            $referencial= $dataProducto['referencial'];
            $especial   = $dataProducto['especial'];
            $subTotal   = $cantidad*$especial;
            $tg         =  $tg +  $subTotal;
            $txt        .='<tr>
              <td class="col-lg-1 col-md-1 col-sm-1" align="center" valign="top" align="center" width="5%"> '.$cantidad.'</td>
              <td class="col-lg-5 col-md-5 col-sm-5" align="left" valign="top" width="45%">';
              $sqlProd    = "SELECT producto, marca, modelo, caracteristicas, industria FROM `productos` WHERE id = '$producto'";
              $resultado  = $Equimp->query($sqlProd);
              if ($resultado->num_rows > 0) {
                $pro = $resultado->fetch_assoc();
                $prodNombre   =  utf8_decode($pro['producto']);
                $marca = $pro['marca'];
                $modelo = $pro['modelo'];
                $industria = $pro['industria'];
                //$caracteristicasUTF8 = utf8_decode($pro['caracteristicas']);
                $caracteristicas = html_entity_decode($pro['caracteristicas']);
                //$caracteristicas = "";
                $txt .= "<div><b>Nombre Producto:</b>".$prodNombre."<br>";
                $txt .= "<b>Marca:</b>".$marca."<br>";
                $txt .= "<b>Modelo:</b>".$modelo."<br>";
                $txt .= "<b>Industria:</b>".$industria."<br>";
                $txt .= "<b>Caracter&iacute;sticas:</b> ".$caracteristicas."<br>";
                $txt .= "</div>";
              }
              $sqlProd = "";
              $resultado ="";
              $pro = ""; $txt .='
              </td>
              <td class="col-lg-2 col-md-2 col-sm-2 detalles" align="right"  nowrap="nowrap" valign="top">USD '.number_format($especial,2).'</td>
              <td class="col-lg-2 col-md-2 col-sm-2 detalles" align="right"  nowrap="nowrap" valign="top">USD '.number_format($especial,2).'</td>
              <td class="col-lg-2 col-md-2 col-sm-2 detalles" align="right"  nowrap="nowrap" valign="top">USD '.number_format($subTotal,2).'</td>
              <td class="col-lg-2 col-md-2 col-sm-2 detalles" align="center">';
              $Q_ImgProd = mysqli_query($Equimp,"SELECT imagen FROM productos WHERE id='$producto' ");
              $ResultImg = mysqli_num_rows($Q_ImgProd);
              if ($ResultImg>0) {
                $dataImg = mysqli_fetch_assoc($Q_ImgProd);
                $img     = $dataImg['imagen'];
                $txt    .= '<img src="https://sistema.equimport.com.bo/Productos/'.$img.'" width="100" height="100" class="imgProd" >';
              }else{
                $txt    .= '<img src="https://sistema.equimport.com.bo/Productos/nodisponible.jpg" width="100" height="100" class="imgProd" >';
              }
               $txt .='</td>
            </tr>';
          }
        } $txt .='
      </tbody>
    </table><br><br>
    <p style="width:95%;margin:auto;">TOTAL GENERAL: USD '.number_format($tg,2).' &nbsp;&nbsp;&nbsp;(Precio entregado en: '.$User['ciudad'].')</p>
    <p style="width:95%;margin:auto;">
      <span><strong>VALIDEZ DE LA OFERTA: </strong>'.$Validez.'</span><br>
      <span><strong>TIEMPO DE ENTREGA: </strong>'.$Tiempo_E.'</span><br>
      <span><strong>FORMA DE PAGO: </strong>'.$Forma_p.'</span><br>
      <span><strong>OBSERVACIONES: </strong>'.$Observac.'</span>
    </p><br>
    <p style="width:95%;margin:auto;">Cualquier consulta o requerimiento no dude en comunicarse con nosotros</p>
    <p style="width:95%;margin:auto;" align="right"><span><strong>Atte: </strong>'.$Usuario.'</span><br>
    <span>'.$Cargo.' </span></p><br> ';
    echo $txt;
  }elseif (isset($_POST['obteneriDTelegram'])) {
    $idUser = $_POST['obteneriDTelegram'];
    $Q_User = mysqli_query($MySQLi,"SELECT idTelegram FROM usuarios WHERE idUser='$idUser' ");
    $dataTel= mysqli_fetch_assoc($Q_User);
    echo json_encode($dataTel);
  }elseif (isset($_POST['obteneriDTelegramCliente'])) {
    $idCliente = $_POST['obteneriDTelegramCliente'];
    $Q_Cliente = mysqli_query($MySQLi,"SELECT idTelegram FROM clientes WHERE idCliente='$idCliente' ");
    $dataTel   = mysqli_fetch_assoc($Q_Cliente);
    echo json_encode($dataTel);
  }elseif(isset($_POST['editarUsuarioJSON'])){
    $idUser     = $_POST['editarUsuarioJSON'];
    $Q_usuario  = mysqli_query($MySQLi,"SELECT idUser,idSexo,idRango,idTienda,cargo,Nombre,correo,telefono,idTelegram FROM usuarios WHERE idUser='$idUser' ");
    $dataUsuario= mysqli_fetch_assoc($Q_usuario);
    echo json_encode($dataUsuario);
  }elseif (isset($_POST['buscarAvatarUsuario'])) {
    $idUser     = $_POST['buscarAvatarUsuario'];
    $Q_usuario  = mysqli_query($MySQLi,"SELECT miAvatar FROM usuarios WHERE idUser='$idUser' ");
    $dataUsuario= mysqli_fetch_assoc($Q_usuario);
    echo json_encode($dataUsuario);
  }elseif (isset($_POST['editarSucursalJSON'])) {
    $idSucursal = $_POST['editarSucursalJSON'];
    $Q_Sucursal = mysqli_query($MySQLi,"SELECT sucursal, codeTienda FROM sucursales WHERE idTienda='$idSucursal'AND estado=1");
    $dataSucursa= mysqli_fetch_assoc($Q_Sucursal);
    echo json_encode($dataSucursa);
  }elseif (isset($_POST['editarClienteJSON'])) {
    $idCliente  = $_POST['editarClienteJSON'];
    $Q_Cliente  = mysqli_query($MySQLi,"SELECT nombre,idCiudad,correo,empresa,telEmpresa,ext,celular,idTelegram,direccion,comentarios FROM clientes WHERE idCliente='$idCliente' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataCliente= mysqli_fetch_assoc($Q_Cliente);
    echo json_encode($dataCliente);
  }elseif (isset($_POST['funcionRefrescar'])) {
    $idUser     = $_POST['funcionRefrescar'];
    $Q_usuario  = mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE onLine=1 AND idUser='$idUser' ");
    $dataUsuario= mysqli_fetch_assoc($Q_usuario);
    $tiempoSaved= $dataUsuario['session'];
    $tiempoExtra= 1800;
    $nuevoTiempo= $tiempoSaved + $tiempoExtra;
    $_SESSION['time'] = $nuevoTiempo;
    mysqli_query($MySQLi,"UPDATE usuarios SET session='$nuevoTiempo' WHERE idUser='$idUser' ");
    echo "nuevo tiempo guardado a: ".$nuevoTiempo;
  }elseif (isset($_POST['buscarImagenesExistentesPro'])) {
    $Q_imagenes     = mysqli_query($MySQLi,"SELECT nombre,imagen FROM productos WHERE estado=1");
    while ($dataImg = mysqli_fetch_assoc($Q_imagenes)) {
      $thisImagen   = $dataImg['imagen'];
      echo'<option value='.$thisImagen.'><img src="Productos/$thisImagen" alt="IMG Producto" width="50"><br>'.$dataImg['nombre'].'</option>';
    }
  }elseif (isset($_POST['buscarProductosxFiltro'])) {
    $filtro         = $_POST['buscarProductosxFiltro'];
    $clave         = $_POST['clave'];
    if ($filtro     =='nombre') {
      $Q_Productos  = mysqli_query($MySQLi,"SELECT * FROM productos WHERE nombre LIKE '$clave%' ORDER BY nombre ASC ");
    }elseif ($filtro=='modelo') {
      $Q_Productos  = mysqli_query($MySQLi,"SELECT * FROM productos WHERE modelo LIKE '$clave%' ORDER BY nombre ASC ");
    }elseif ($filtro=='indicio') {
      $Q_Productos  = mysqli_query($MySQLi,"SELECT * FROM productos WHERE modelo LIKE '%$clave%' ORDER BY nombre ASC ");
    }
    $ResultProduct  = mysqli_num_rows($Q_Productos);
    if ($ResultProduct>0) {
      $Num = 1;
      while ($data = mysqli_fetch_assoc($Q_Productos)) { echo'
        <tr>
          <td class="text-center">'.$Num.'</td>
          <td>'.$data['nombre'] .'</td>
          <td>'.$data['marca'] .'</td>
          <td>'.$data['modelo'] .'</td>
          <td>stock</td>
          <td>precio</td>
          <td class="text-center">
            <a target="_blank" href="http://localhost/Proyectos/Estandarizado/Productos/'.$data['imagen'] .'"><img src="productos/'.$data['imagen'] .'" alt="imagen" height="30px"></a>           
          </td>
          <td class="text-center">
            <button class="btn btn-danger btn-sm btn-icon rounded-circle openModalCancelarCuentaUsuario" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Cancelar la cuenta de este usuario" id='.$data['idProducto'].'><i class="far fa-trash-alt"></i></button>
          </td>
        </tr>';$Num++;
      }
    }else{ echo'<tr>
        <td colspan="7" class="text-danger text-center">NO HAY COINCIDENCIAS</td>
      </tr>';
    }
  }elseif (isset($_POST['buscarDatosProductoJSON'])) {
    $idProducto = $_POST['buscarDatosProductoJSON'];
    $Q_Producto = mysqli_query($MySQLi,"SELECT idProveedor,idCategoria,mercaderia, nombre,marca,modelo,industria,precio,descripcion, observaciones FROM productos WHERE idProducto='$idProducto' ");
    $dataProduct= mysqli_fetch_assoc($Q_Producto);
    echo json_encode($dataProduct);
  }elseif (isset($_POST['llamarImagenproducto'])) {
    $idProducto = $_POST['llamarImagenproducto'];
    $Q_Producto = mysqli_query($MySQLi,"SELECT imagen FROM productos WHERE idProducto='$idProducto' ");
    $dataImagen = mysqli_fetch_assoc($Q_Producto);
    echo json_encode($dataImagen);
  }elseif (isset($_POST['obtenerListaClientesGenerar'])){
    echo "<option>Seleccionar un cliente</option>";
    $Q_Clientes = mysqli_query($MySQLi,"SELECT idCliente,nombre FROM clientes ORDER BY nombre ASC");
    while ($dataCientes = mysqli_fetch_assoc($Q_Clientes)) {
      echo '<option value='.$dataCientes['idCliente'].'>'.$dataCientes['nombre'].'</option>';
    }
  }elseif (isset($_POST['obtenerListaClientesJSON'])){
    $idCliente  = $_POST['obtenerListaClientesJSON'];
    $Q_Cliente  = mysqli_query($MySQLi,"SELECT idCiudad,nombre,celular,correo,empresa,telEmpresa,ext,direccion,comentarios,idTelegram FROM clientes WHERE idCliente='$idCliente' ");
    $dataCliente= mysqli_fetch_assoc($Q_Cliente);
    echo json_encode($dataCliente);
  }elseif (isset($_POST['buscaPrecioProductoJSON'])) {
    $idProducto = $_POST['buscaPrecioProductoJSON'];
    $Q_Producto = mysqli_query($MySQLi,"SELECT precio FROM productos WHERE idProducto='$idProducto' ");
    $dataProduct= mysqli_fetch_assoc($Q_Producto);
    echo json_encode($dataProduct);
  }elseif (isset($_POST['selectorProductosGenerarCotizacion'])){
    $Q_selectProd = mysqli_query($MySQLi,"SELECT * FROM productos ORDER BY mercaderia ASC , nombre ASC ");
    echo'<option selected disabled>Seleccione Repuesto</option>';
    while ($dataPr= mysqli_fetch_assoc($Q_selectProd)) {
      $nombreProdu= $dataPr['mercaderia']." ".$dataPr['nombre']." ".$dataPr['marca']." ".strtolower($dataPr['modelo']);
      $idProducto = $dataPr['idProducto'];
      echo'<option value='.$idProducto.'>'.$nombreProdu.'</option>';
    }
  }elseif (isset($_POST['selectorProveedoresGenerarCotizacion'])){
    $Q_Proveedor  = mysqli_query($MySQLi,"SELECT idProveedor,proveedor FROM proveedores ORDER BY proveedor ASC ");
    echo'<option selected disabled>Seleccione proveedor</option>';
    while ($dataPr= mysqli_fetch_assoc($Q_Proveedor)) {
      $idProveedor = $dataPr['idProveedor'];
      echo'<option value='.$idProveedor.'>'.$dataPr['proveedor'].'</option>';
    }
  }elseif (isset($_POST['selectorCategoriasGenerarCotizacion'])){
    $Q_Categorias  = mysqli_query($MySQLi,"SELECT idCategoria,categoria FROM categorias WHERE estado=1 ORDER BY categoria ASC ");
    echo'<option selected disabled>Seleccione categoria</option>';
    while ($dataPr= mysqli_fetch_assoc($Q_Categorias)) {
      $idCategoria = $dataPr['idCategoria'];
      echo'<option value='.$idCategoria.'>'.$dataPr['categoria'].'</option>';
    }
  }elseif (isset($_POST['buscarCorreoClienteJSON'])) {
    $idCotizacion = $_POST['buscarCorreoClienteJSON'];
    $Q_Cotizacion = mysqli_query($MySQLi,"SELECT idCliente FROM cotizaciones WHERE idCotizacion='$idCotizacion' ");
    $dataCotiza   = mysqli_fetch_assoc($Q_Cotizacion);
    $idCliente    = $dataCotiza['idCliente'];
    $Q_Cliente    = mysqli_query($MySQLi,"SELECT idTienda,nombre,correo FROM clientes WHERE idCliente='$idCliente' ");
    $dataCliente  = mysqli_fetch_assoc($Q_Cliente);
    echo json_encode($dataCliente);
  }elseif (isset($_POST['buscardatosUsuarioJSON'])) {
    $idCotizacion = $_POST['buscardatosUsuarioJSON'];
    $Q_Cotizacion = mysqli_query($MySQLi,"SELECT idUser FROM cotizaciones WHERE idCotizacion='$idCotizacion' ");
    $dataCotiza   = mysqli_fetch_assoc($Q_Cotizacion);
    $idUser       = $dataCotiza['idUser'];
    $Q_Usuario    = mysqli_query($MySQLi,"SELECT Nombre,cargo FROM usuarios WHERE idUser='$idUser' ");
    $dataUsuario  = mysqli_fetch_assoc($Q_Usuario);
    echo json_encode($dataUsuario);
  }elseif (isset($_POST['obtenerDatosPlantilla'])) {
    $idPlantilla  = $_POST['obtenerDatosPlantilla'];
    $Q_Plantilla  = mysqli_query($MySQLi,"SELECT * FROM plantillasHTML WHERE idPlantilla='$idPlantilla' ");
    $dataPlantilla= mysqli_fetch_assoc($Q_Plantilla);
    echo json_encode($dataPlantilla);
  }elseif (isset($_POST['validarIDTelegram'])) {
    $idTelegram = $_POST['validarIDTelegram'];
    $bottoken =  "831308895:AAE5FHf7G3IhNAiJ260yz-zr1IThvq5kv-0";
    $website  = "https://api.telegram.org/bot".$bottoken;
    $update   = file_get_contents('php://input');
    $update   = json_decode($update, TRUE);
    $info     = "\n\nMensaje enviado de prueba";
    $url      = $website."/sendMessage?chat_id=".$idTelegram."&parse_mode=HTML&text=".urlencode($info);
    //file_get_contents($url);
    if (!file_get_contents($url)) {
      $resultado = array('error' => '1');
      echo json_encode($resultado);
    }else{
      $resultado = array('error' => '0');
      echo json_encode($resultado);
    }
  }elseif (isset($_POST['BuscarStockInventario'])) {
    $idProducto   = $_POST['BuscarStockInventario'];
    $i            = $_POST['i']; //Posición de la sucursales    
    $Q_Sucursal = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE estado=1 LIMIT $i,1 ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataSucur  = mysqli_fetch_assoc($Q_Sucursal);
    $codeTienda = $dataSucur['codeTienda'];
    $Q_StockPr  = mysqli_query($MySQLi,"SELECT stock FROM inventario WHERE idProducto='$idProducto' LIMIT $i,1 ");
    $dataStock  = mysqli_fetch_assoc($Q_StockPr);
    $stock      = $dataStock['stock'];
    $Respuesta  = array('codigoTienda'=>'stock_'.$codeTienda,'stockTienda'=>$stock);
    echo json_encode($Respuesta);
  }elseif (isset($_POST['buscarStockProductoJSON'])) {
    $idProducto = $_POST['buscarStockProductoJSON'];
    $i          = $_POST['i'];
    $Q_Stock    = mysqli_query($MySQLi,"SELECT idTienda,stock FROM inventario WHERE idProducto='$idProducto' LIMIT $i,1 ");
    $dataStock  = mysqli_fetch_assoc($Q_Stock);
    $stock      = $dataStock['stock'];
    $idTienda   = $dataStock['idTienda'];
    $Q_Sucursal = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE idTienda='$idTienda' ");
    $dataSucursa= mysqli_fetch_assoc($Q_Sucursal);
    $codeTienda = $dataSucursa['codeTienda'];
    $Respuesta  = array('stock' => $stock, 'codeTienda' => $codeTienda,'posicion'=>$i );
    echo json_encode($Respuesta);

    //echo json_encode($dataStock);
    /*$Q_Producto = mysqli_query($MySQLi,"SELECT stock FROM productos WHERE idProducto='$idProducto' ");
    $dataProduct= mysqli_fetch_assoc($Q_Producto);
    echo json_encode($dataProduct);*/
  }elseif (isset($_POST['download'])) {
    function backupDatabaseTables($dbHost,$dbUsername,$dbPassword,$dbName,$tables){
      //connect & select the database
      $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
      //get all of the tables
      if($tables == '*'){
        $tables = array();
        $result = $db->query("SHOW TABLES");
        while($row = $result->fetch_row()){
          $tables[] = $row[0];
        }
      }else{
        $tables = is_array($tables)?$tables:explode(',',$tables);
      }
      //loop through the tables
      foreach($tables as $table){
        $result = $db->query("SELECT * FROM $table");
        $numColumns = $result->field_count;
        $return .= "DROP TABLE $table;";
        $result2 = $db->query("SHOW CREATE TABLE $table");
        $row2 = $result2->fetch_row();
        $return .= "nn".$row2[1].";nn";
        for($i = 0; $i < $numColumns; $i++){
          while($row = $result->fetch_row()){
            $return .= "INSERT INTO $table VALUES(";
              for($j=0; $j < $numColumns; $j++){
                $row[$j] = addslashes($row[$j]);
                $row[$j] = ereg_replace("n","n",$row[$j]);
                if (isset($row[$j])) { $return .= '"'.$row[$j].'"' ; } else { $return .= '""'; }
                if ($j < ($numColumns-1)) { $return.= ','; }
              }
              $return .= ");n";
            }
          }
          $return .= "nnn";
      }
      //save file
      $handle = fopen('db-backup-'.time().'.sql','w+');
      fwrite($handle,$return);
      fclose($handle);
    }
    backupDatabaseTables('75.119.156.102', 'suportyapa_admin', 'ES@72900968', 'suportyapa_sistemav3', 'clientes');
  }elseif (isset($_POST['consultaMonedas'])) {
    $Q_Monedas = mysqli_query($MySQLi,"SELECT * FROM monedas ORDER BY moneda DESC");
    while ($data = mysqli_fetch_assoc($Q_Monedas)) {
      echo'<option value='.$data['idMoneda'].'>'.$data['moneda']." ".$data['simbolo'].'</option>';
    }
  }elseif (isset($_POST['idCotizacionVenta'])) {
    $idCotizacion   = $_POST['idCotizacionVenta'];
    $Q_Cotizacion   = mysqli_query($MySQLi,"SELECT codigo,clave,idUser,idCliente,idTienda FROM cotizaciones WHERE idCotizacion='$idCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataCotizacion = mysqli_fetch_assoc($Q_Cotizacion);
    $codigoCotiza   = $dataCotizacion['codigo'];
    $claveCotizacion= $dataCotizacion['clave'];
    $idUserCotiza   = $dataCotizacion['idUser'];
    $idClienteCotiza= $dataCotizacion['idCliente'];
    $idTiendaCotiza = $dataCotizacion['idTienda'];
    //  DATOS DEL CLIENTE
    $Q_Cliente      = mysqli_query($MySQLi,"SELECT nombre FROM clientes WHERE idCliente='$idClienteCotiza' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataCliente    = mysqli_fetch_assoc($Q_Cliente);
    $nombreCliente  = $dataCliente['nombre'];
    //  DATOS DEL USUARIO
    $Q_Usuario      = mysqli_query($MySQLi,"SELECT Nombre FROM usuarios WHERE idUser='$idUserCotiza' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataUsuario    = mysqli_fetch_assoc($Q_Usuario);
    $nombreUsuario  = $dataUsuario['Nombre'];
    //  DATOS DE LOS PRODUCTOS
    $Q_clave        = mysqli_query($MySQLi,"SELECT SUM(cantidad*precioEspecial) AS Total FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    while ($dataClv = mysqli_fetch_assoc($Q_clave)) {
      $Total        = $dataClv['Total'];
    }

    $sql_lista_prod = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ");
    while ($data = mysqli_fetch_assoc($sql_lista_prod)) {           
    $idProducto = $data['idProducto'];
    //consultamos nombre del producto 
    $sqlProducto = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
    $dataProducto = mysqli_fetch_assoc($sqlProducto);
    $ProductoName = "CANTIDAD:".$data['cantidad'] . "  PRODUCTO: " . $dataProducto['mercaderia'] . " " . $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'] . "  PRECIO OFERTA:" .$data['precioEspecial']. "  SUBTOTAL:" .number_format($data['cantidad']*$data['precioEspecial'],2);
    $Prod = $Prod.$ProductoName."\n" ;
    }
    $Prod=$Prod."\n"."TOTAL:".$Total;


    $Respuesta        = array(
      'idUser'        =>  $idUserCotiza,
      'idTienda'      =>  $idTiendaCotiza,
      'idCliente'     =>  $idClienteCotiza,
      'nombreCliente' =>  $nombreCliente,
      'codigoCotiza'  =>  $codigoCotiza,
      'nombreVendedor'=>  $nombreUsuario,
      'claveCotizacion'=> $claveCotizacion,
      'TotalVenta'    =>  $Total,
      'Prod'          =>  $Prod
    );
    echo json_encode($Respuesta);
  }elseif (isset($_POST['buscarCodigosTienda'])) {
    $sucursales   = $_POST['i'];
    $Q_Sucursal   = mysqli_query($MySQLi,"SELECT codeTienda FROM sucursales WHERE estado=1 LIMIT $sucursales,1");
    $dataSucurs   = mysqli_fetch_assoc($Q_Sucursal);
    echo $codeTienda   = $dataSucurs['codeTienda'];
  }elseif (isset($_POST['buscarDatosStockSucursal'])) {
    $idInventario = $_POST['buscarDatosStockSucursal'];
    $Q_Inventario = mysqli_query($MySQLi,"SELECT idTienda,stock FROM inventario WHERE idInventario='$idInventario' ");
    $dataInvent   = mysqli_fetch_assoc($Q_Inventario);
    $idTienda     = $dataInvent['idTienda'];
    $stock        = $dataInvent['stock'];
    $Q_Sucursales = mysqli_query($MySQLi,"SELECT * FROM sucursales WHERE idTienda='$idTienda' ");
    $dataTienda   = mysqli_fetch_assoc($Q_Sucursales);
    $nombreTienda = $dataTienda['sucursal'];
    $Respuesta    = array('stock' => $stock, 'nombreTienda' => $nombreTienda );
    echo json_encode($Respuesta);
  }elseif (isset($_POST['editarProductoTablaTemporal'])) {
    $idClave  = $_POST['editarProductoTablaTemporal'];
    $Q_clave  = mysqli_query($MySQLi,"SELECT idProducto,cantidad,precioEspecial,claveTemporal FROM claveTemporal WHERE idClave='$idClave' ");
    $dataClave= mysqli_fetch_assoc($Q_clave);
    echo json_encode($dataClave);
  }elseif (isset($_POST['obtenerDetallesCotizacion'])) {
    $claveCotizacion  = $_POST['obtenerDetallesCotizacion'];
    $Q_Cotizacion     = mysqli_query($MySQLi,"SELECT * FROM cotizaciones WHERE clave='$claveCotizacion' ");
    $dataCotizacion   = mysqli_fetch_assoc($Q_Cotizacion);
    echo json_encode($dataCotizacion);
  }elseif (isset($_POST['monedaPrincipal'])) {
    $Q_Configuraciones = mysqli_query($MySQLi,"SELECT monedaP,simbolo FROM configuraciones");
    $dataConfiguracion = mysqli_fetch_assoc($Q_Configuraciones);
    echo json_encode($dataConfiguracion);
  }elseif (isset($_POST['listaClientesconTelefono'])) {
    echo "<option value='Todos'>Enviar a todos los clientes</option>";
    $Q_Clientes  = mysqli_query($MySQLi,"SELECT nombre,celular,idCliente FROM clientes WHERE celular!='' ORDER BY nombre ASC ");
    while ($dataCientes = mysqli_fetch_assoc($Q_Clientes)) {
      echo '<option value='.$dataCientes['idCliente'].'>'.$dataCientes['nombre'].'</option>';
    }
  }elseif (isset($_POST['llenarFormSendSMS'])) {
    $idCliente = $_POST['llenarFormSendSMS'];
    $Q_Cliente = mysqli_query($MySQLi,"SELECT celular FROM clientes WHERE idCliente='$idCliente' ");
    $dataCliente = mysqli_fetch_assoc($Q_Cliente);
    echo json_encode($dataCliente);
  }
  elseif (isset($_POST['idCotizacionVentaBs'])) {
    $idCotizacion   = $_POST['idCotizacionVentaBs'];
    $Q_Cotizacion   = mysqli_query($MySQLi,"SELECT codigo,clave,idUser,idCliente,idTienda FROM cotizaciones WHERE idCotizacion='$idCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataCotizacion = mysqli_fetch_assoc($Q_Cotizacion);
    $codigoCotiza   = $dataCotizacion['codigo'];
    $claveCotizacion= $dataCotizacion['clave'];
    $idUserCotiza   = $dataCotizacion['idUser'];
    $idClienteCotiza= $dataCotizacion['idCliente'];
    $idTiendaCotiza = $dataCotizacion['idTienda'];

    $query_precio_dolar = mysqli_query($MySQLi, "SELECT precio FROM preciodolar");
    $dataPrecio = mysqli_fetch_assoc($query_precio_dolar);
    $precioDolar = $dataPrecio['precio'];

    //  DATOS DEL CLIENTE
    $Q_Cliente      = mysqli_query($MySQLi,"SELECT nombre FROM clientes WHERE idCliente='$idClienteCotiza' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataCliente    = mysqli_fetch_assoc($Q_Cliente);
    $nombreCliente  = $dataCliente['nombre'];
    //  DATOS DEL USUARIO
    $Q_Usuario      = mysqli_query($MySQLi,"SELECT Nombre FROM usuarios WHERE idUser='$idUserCotiza' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $dataUsuario    = mysqli_fetch_assoc($Q_Usuario);
    $nombreUsuario  = $dataUsuario['Nombre'];
    //  DATOS DE LOS PRODUCTOS
    $Q_clave        = mysqli_query($MySQLi,"SELECT SUM(cantidad*precioEspecial) AS Total FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    while ($dataClv = mysqli_fetch_assoc($Q_clave)) {
      $Total        = $dataClv['Total'];
    }

    $sql_lista_prod = mysqli_query($MySQLi, "SELECT * FROM claveTemporal WHERE claveTemporal='$claveCotizacion' ");
    while ($data = mysqli_fetch_assoc($sql_lista_prod)) {           
    $idProducto = $data['idProducto'];
    //consultamos nombre del producto 
    $sqlProducto = mysqli_query($MySQLi, "SELECT * FROM productos WHERE idProducto='$idProducto' ");
    $dataProducto = mysqli_fetch_assoc($sqlProducto);
    $ProductoName = "CANTIDAD:".$data['cantidad'] . "  PRODUCTO: " . $dataProducto['mercaderia'] . " " . $dataProducto['nombre'] . " " . $dataProducto['marca'] . " " . $dataProducto['modelo'] . "  PRECIO OFERTA:" .$data['precioEspecial'] * $precioDolar. "  SUBTOTAL:" .number_format($data['cantidad']*$data['precioEspecial']*$precioDolar,2);
    $Prod = $Prod.$ProductoName."\n" ;
    }
    $Prod=$Prod."\n"."TOTAL:".number_format($Total*$precioDolar,2);


    $Respuesta        = array(
      'idUser'        =>  $idUserCotiza,
      'idTienda'      =>  $idTiendaCotiza,
      'idCliente'     =>  $idClienteCotiza,
      'nombreCliente' =>  $nombreCliente,
      'codigoCotiza'  =>  $codigoCotiza,
      'nombreVendedor'=>  $nombreUsuario,
      'claveCotizacion'=> $claveCotizacion,
      'TotalVenta'    =>  $Total,
      'Prod'          =>  $Prod
    );
    echo json_encode($Respuesta);
  }
  // TODO SERVICIO REPARACION-------------------------------------------------------------SERVICIO REPARACION
  elseif(isset($_POST['callProductos'])) {
    $idProducto = $_POST['callProductos'];
    $queryProd  = mysqli_query($MySQLi,"SELECT precio FROM productos WHERE id='$idProducto' ");
    $dataProd   = mysqli_fetch_assoc($queryProd);
    echo json_encode($dataProd);
  }elseif (isset($_POST['callDataCliente'])) {
    $idCliente  = $_POST['callDataCliente'];
    $Q_Cliente  = mysqli_query($MySQLi,"SELECT id, nombre, empresa, telefono, celular, email, ciudad, cr FROM registros WHERE id='$idCliente' ");
    $dataCliente= mysqli_fetch_assoc($Q_Cliente);
    echo json_encode($dataCliente);
  }elseif (isset($_POST['editarCotizacion'])) {
    $idCotizacion=$_POST['editarCotizacion'];
    $Q_Cotiza   = mysqli_query($MySQLi,"SELECT id_cotizacion, entrega, oferta, forma, observaciones, aclaraciones FROM cotizaciones WHERE id='$idCotizacion' ");
    $dataCotiza = mysqli_fetch_assoc($Q_Cotiza);
    echo json_encode($dataCotiza);
  }elseif(isset($_POST['editarTablaProductos_cotiza'])){
    $ClaveTemporal  = $_POST['editarTablaProductos_cotiza']; echo "<br>";
    $idCotizacion   = $_POST['idCotizacion']; ?>
    <table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
      <thead>
        <tr>
          <th style="padding: 3px" width="5%" class="text-center">Cant</th>
          <th style="padding: 3px" width="55%" class="text-center">Descripción</th>
          <th style="padding: 3px" width="10%" class="text-center">Pre Venta</th>
          <th style="padding: 3px" width="10%" class="text-center">Pre Especial</th>
          <th style="padding: 3px" width="10%" class="text-center">Total</th>
          <th style="padding: 3px" width="10%" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody><?php
        $queryRegTem= mysqli_query($MySQLi,"SELECT * FROM cotizaciones_productos WHERE id_cotizacion='$ClaveTemporal' ORDER BY id DESC ");
        $resulRegTem= mysqli_num_rows($queryRegTem);
        if ($resulRegTem>0) {
          while ($dataRegistros = mysqli_fetch_assoc($queryRegTem)) { ?>
          <tr>                
            <td class="text-center"><?php echo $dataRegistros['cantidad'] ?></td>
            <td class=""><?php
              $id_Producto  = $dataRegistros['producto'];
              $sqlProducto  = mysqli_query($MySQLi,"SELECT * FROM productos WHERE id='$id_Producto'");
              $DataProductos= mysqli_fetch_assoc($sqlProducto);
              $Product      = $DataProductos['producto'];
              $MarcProduct  = $DataProductos['marca'];
              $ModeloProduct= $DataProductos['modelo'];
              $DescProduct  = $Product." / ".$MarcProduct." / ".$ModeloProduct;
              echo $DescProduct; ?>
            </td>
            <td class="text-center">$ <?php echo number_format($dataRegistros['referencial'],2) ?></td>
            <td class="text-center">$ <?php echo number_format($dataRegistros['especial'],2) ?></td>
            <td class="text-center">$ <?php echo number_format($dataRegistros['especial']*$dataRegistros['cantidad'],2) ?></td>
            <td class="text-center"><?php
              $ClaveABuscar   = $dataRegistros['id_cotizacion'];
              $consultaClave  = mysqli_query($MySQLi,"SELECT * FROM cotizaciones_productos WHERE id_cotizacion='$ClaveABuscar' ");
              $resultBusqueda = mysqli_num_rows($consultaClave);
              if ($resultBusqueda>1 ) { ?>
                <button type="button" title="Borrar Producto (<?php echo $dataRegistros['id'] ?>)" class="btn btn-xs btn-danger deleteProdTemp" id="<?php echo $dataRegistros['id'] ?>"><i class="far fa-trash-alt"></i></button>&nbsp;
                <?php
              }?>
            </td>
          </tr><?php }
        }else{
          echo'<tr>               
            <td colspan="6" class="text-center text-danger" style="letter-spacing: 1px">NO HAY PRODUCTOS QUE MOSTRAR</td>
          </tr>';
        } ?>
      </tbody>
    </table><?php
  }elseif (isset($_POST['callDataClienteSELECT'])) {
    $idCliente = $_POST['callDataClienteSELECT'];
    $Q_Clientes= mysqli_query($MySQLi,"SELECT * FROM registros");
    echo'<option selected disabled>Seleccione un Cliente</option>';
    while ($dataCliente = mysqli_fetch_assoc($Q_Clientes)) {
      echo'<option value='.$dataCliente['id'] .'>'.utf8_decode($dataCliente['nombre']).'</option>';
    }
  }elseif (isset($_POST['llamarFichaTecnica'])) {
    $idServicio = $_POST['llamarFichaTecnica'];
    $Q_Servicio = mysqli_query($MySQLi,"SELECT * FROM soporte WHERE idSoporte='$idServicio' ");
    $dataServi  = mysqli_fetch_assoc($Q_Servicio);
    $claveServicio = $dataServi['clave_soporte']; echo'
    <table class="table table-striped table-bordered table-td-valign-middle w-100">
      <thead>
        <tr>
          <th class="text-center">Equipo</th>
          <th class="text-center">Marca</th>
          <th class="text-center">Modelo</th>
          <th class="text-center">Serie</th>
          <th class="text-center">Garantia</th>
          <th class="text-center">Acciones</th>             
        </tr>
      </thead>
      <tbody>';
        $Q_Service  = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$claveServicio' ORDER BY equipo ASC ");
        $resultServ = mysqli_num_rows($Q_Service);
        if ($resultServ>0) {
          while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) { echo'
          <tr>                
            <td>'.$dataRegistros['equipo'].'</td>
            <td>'.$dataRegistros['marca'].'</td>
            <td>'.$dataRegistros['modelo'].'</td>
            <td>'.$dataRegistros['serie'].'</td>';
            if ($dataRegistros['garantia']==0) {
              echo'<td class="text-center">No</td>';
            }else{
              echo'<td class="text-center">Sí</td>';
            } echo'
            <td class="text-center">
              <button class="btn btn-success btn-sm btn-icon rounded-circle openModalEditServicio" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-success-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Editar Servicio ('.$dataRegistros['idClave'].')" id='.$dataRegistros['idClave'].'><i class="fal fa-edit"></i></button>&nbsp;&nbsp;';
              if ($resultServ>1) { echo'
                <button class="btn btn-danger btn-sm btn-icon rounded-circle deleteServicio"  data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Eliminar servicio ('.$dataRegistros['idClave'].')" id='.$dataRegistros['idClave'].'><i class="fal fa-trash-alt"></i></button>';
              } echo'
            </td>
          </tr>'; }
        }else{ echo'<tr>
          <td colspan="6" class="text-center text-danger" style="letter-spacing: 1px">NO HAY SERVICIOS QUE MOSTRAR</td></tr>';
        } echo'
      </tbody>
    </table>';
  }elseif (isset($_POST['editarUsuarioJSON'])) {
    $idUser   = $_POST['editarUsuarioJSON'];
    $Q_User   = mysqli_query($MySQLi,"SELECT * FROM usuarios WHERE id='$idUser' ");
    $dataUss  = mysqli_fetch_assoc($Q_User);
    echo json_encode($dataUss);
  }elseif (isset($_POST['llamarDatosProductoJSON'])) {
    $idProducto = $_POST['llamarDatosProductoJSON'];
    $Q_Producto = mysqli_query($MySQLi,"SELECT producto, marca, modelo, industria, precio, caracteristicas, imagen FROM productos WHERE id='$idProducto' ");
    $dataProduct= mysqli_fetch_assoc($Q_Producto);
    echo json_encode($dataProduct);
  }elseif (isset($_POST['llamarImagenproducto'])) {
    $idProducto = $_POST['llamarImagenproducto'];
    $Q_Producto = mysqli_query($MySQLi,"SELECT imagen FROM productos WHERE id='$idProducto' ");
    $dataImagen = mysqli_fetch_assoc($Q_Producto);
    echo json_encode($dataImagen);
  }elseif (isset($_POST['llamarServicioProductoJSON'])) {
    $idClave = $_POST['llamarServicioProductoJSON'];
    $Q_Clave = mysqli_query($MySQLi,"SELECT sucursal, clave, equipo, marca, modelo, serie, problema, observaciones, garantia, fechaCompra, numFactura FROM soporte_claves WHERE idClave='$idClave' ");
    $dataClv = mysqli_fetch_assoc($Q_Clave);
    // $Clave   = $dataClv['clave'];
    // $Q_Suppor= mysqli_query($MySQLi,"SELECT * FROM soporte WHERE clave_soporte='$Clave' ");
    // $dataSupp= mysqli_fetch_assoc($Q_Suppor);
    echo json_encode($dataClv);
    // echo json_encode($dataSupp);
  }elseif (isset($_POST['llamarEquiposSoporteHTML'])) {
    $clave      = $_POST['llamarEquiposSoporteHTML'];
    $Q_equipos  = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$clave' AND estado=0 ");    
    while ($data= mysqli_fetch_assoc($Q_equipos)) {
      echo'
      <label for="costo_'.$data['idClave'].'">'.$data['equipo'].' - '.$data['modelo'].' - <b>Garantía: &nbsp;'.strtoupper($data['garantia']).'</b></label>
      <input type="text" name= "costo[]" class="form-control mb-2" id="costo_'.$data['idClave'].'" placeholder="Costo TOTAL">
      <input type="hidden" name="idClave[]" value='.$data['idClave'].'>
      <textarea name="realizar[]" class="form-control mb-2" placeholder="describa el trabajo a realizar a '.$data['equipo'].' - '.$data['modelo'].'"></textarea>';
      /*if ($data['garantia']=='si') { echo'
        <input type="text" name= "costo[]" class="form-control mb-2" id="costo_'.$data['idClave'].'" placeholder="Costo TOTAL">
        <input type="hidden" name="idClave[]" value='.$data['idClave'].'>';
      }else{ echo'
        <input type="text" name= "costo[]" class="form-control mb-2" id="costo_'.$data['idClave'].'" placeholder="Costo TOTAL">
        <input type="hidden" name="idClave[]" value='.$data['idClave'].'>';
      }*/
    }
  }elseif (isset($_POST['obtenerClavexID'])) {
    $idClave = $_POST['obtenerClavexID'];
    $Q_Clave = mysqli_query($MySQLi,"SELECT clave FROM soporte_claves WHERE idClave='$idClave' ");
    $dataClv = mysqli_fetch_assoc($Q_Clave);
    echo json_encode($dataClv);
  }elseif (isset($_POST['sucursalRegistrados'])) {
    $sucursal = $_POST['sucursalRegistrados'];
    if ($sucursal=='Cochabamba') {
      $dataBase = "soporte_cba";
    }else{
      $dataBase = "soporte_stc";
    }
    $Q_Servicio = mysqli_query($MySQLi,"SELECT * FROM $dataBase WHERE fechaRegistro BETWEEN '$startBusqueda'AND'$fecha' AND estado=0 ORDER BY fechaRegistro DESC")or die(mysqli_error($MySQLi)."<br>Error en la línea: ".__LINE__);
    $resultServ = mysqli_num_rows($Q_Servicio);?>
    
      <thead>
        <tr>
          <th width="5%" class="text-center">N&ordm;</th>
          <th width="90%" class="text-center">Descripción</th>
          <th width="5%" class="text-center">Acciones</th>
        </tr>
      </thead>
      <tbody><?php
      if ($resultServ>0) {
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
                      <a target="_blank" href="fichaTecnica.php?idClave='.$dataFichas['idClave'].'&sucursal='.$dataServicio['sucursal'].'&idSoporte='.$dataServicio['idSoporte'].'" class="btn btn-light btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-light-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a>

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

              <!-- <a target="_blank" href="hojadeservicio.php?idSoporte=<?=$dataServicio['idSoporte']?>&Sucursal=<?php //$dataServicio['sucursal'] ?>&servicio=tecnico" class="btn mt-2 btn-light btn-xs btn-icon rounded-circle waves-effect waves-themed" data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-light-500&quot;></div></div>" data-toggle="tooltip" title="" data-original-title="Descargar ficha en PDF para el técnico"><i class="fal fa-file-pdf"></i></a> -->
            </td>
          </tr><?php
        }
      }else{ ?>
        <tr><td colspan="3" class="text-center text-danger"><H1>NO HAY RESULTADOS QUE MOSTRAR</H1></td></tr><?php
      } ?>
      </tbody><?php
  }elseif (isset($_POST['obtenerRegistrosClave'])) {
    $clave    = $_POST['obtenerRegistrosClave'];
    $Q_Clave  = mysqli_query($MySQLi,"SELECT * FROM soporte_claves WHERE clave='$clave' AND estado=1 ");
    while ($dataClv = mysqli_fetch_assoc($Q_Clave)) {
      $idClave= $dataClv['idClave'];
      $nombreP= $dataClv['equipo']." ".$dataClv['marca'];
      echo'<div class="row mb-2">
        <div class=col>
          <label for="realizado_'.$idClave.'">Trabajo Adicional: '.$nombreP.'</label>          
          <textarea class="form-control" name="realizado[]" id="realizado_'.$idClave.'" placeholder="Ingrese el trabajo realizado de '.$nombreP.'" required></textarea>
          <input name="idClave[]" type="hidden" value='.$idClave.'>
        </div>
      </div>
      <div class="row mb-2">
        <div class="col">
          <label for="adicionalCosto_'.$idClave.'">¿Costo adicional?</label>
          <input type="text" class="form-control" name="costo[]" placeholder="0" id="adicionalCosto_'.$idClave.'" value=0>
        </div>
      </div> ';
    }
  }elseif (isset($_POST['BuscarSucursalxClave'])) {
    $clave = $_POST['BuscarSucursalxClave'];
    $Q_Sucursal = mysqli_query($MySQLi,"SELECT sucursal FROM soporte_claves WHERE clave='$clave' ");
    $dataSucur  = mysqli_fetch_assoc($Q_Sucursal);
    echo $sucursal   = $dataSucur['sucursal'];

  }
