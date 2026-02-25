<?php
error_reporting(0);
$invoice_id = (int)$_POST['invoiceCode1'];
$motivo_id = (int)$_POST['codeMotive1'];
$branchId = $_POST['branchId1'];
$invoiceNumber = (int)$_POST['invoiceNumber1'];


$respuesta_api = AnularFactura($invoice_id, $motivo_id);
if ($respuesta_api->{'response'} == 'ok') {
  restaurar_fiscales($invoice_id, $branchId, $invoiceNumber);
  echo json_encode('ok');
} else {
  echo json_encode('error');
}


function AnularFactura($invoice_id, $motivo_id)
{
  include './../conexion_yuli_ventas.php';
  $sqlurlyapame = mysqli_query($MySQLi, "SELECT * FROM token_access");
  $dataurlyapame = mysqli_fetch_assoc($sqlurlyapame) or die(mysqli_error($MySQLi));

  $urlyapame = $dataurlyapame['urlcucu'];
  $token = $dataurlyapame['token'];

  $ch = curl_init();
  $url = $urlyapame . "/api/invoices/" . $invoice_id . "/void";
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
  curl_setopt($ch, CURLOPT_HEADER, FALSE);

  curl_setopt($ch, CURLOPT_POST, TRUE);

  curl_setopt($ch, CURLOPT_POSTFIELDS, "{
  \"invoice_id\": $invoice_id,
  \"motivo_id\": $motivo_id
}");

  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: application/json",
    "Authorization: Bearer $token"
  ));

  $response = curl_exec($ch);
  curl_close($ch);
  mysqli_close($MySQLi);
  // print_r($response);
  $response_decode = json_decode($response);
  return $response_decode;
}

function restaurar_fiscales($invoice_id, $branchId, $invoiceNumber)
{
  include './../conexion.php';
  //905 = anulada
  $sql = mysqli_query(
    $MySQLi,
    "UPDATE factura SET siatDescriptionStatus='ANULACION CONFIRMADA',siatCodeState=905 WHERE invoiceCode='$invoice_id' AND invoiceNumber='$invoiceNumber'"
  ) or die(mysqli_error($MySQLi));

  //actualizamos productos fiscales sumando el anulado a la tabla prodfiscales
  $prodF = mysqli_query($MySQLi, "SELECT * FROM detailInvoice WHERE invoiceNumber='$invoiceNumber' and prodF='si' and branchId='$branchId' "); //bd servicio tec
  while ($dataprodF = mysqli_fetch_assoc($prodF)) {
    $detailId = $dataprodF['detailId']; //idproducto detail invoice
    $qtydevolver = (int)$dataprodF['qty']; //cantidad a devolver
    restaurar_producto_fiscal($detailId, $qtydevolver); //bd yuli
  }
}

function restaurar_producto_fiscal($detailId, $qtydevolver) //bd yuli
{
  include './../conexion_yuli_ventas.php';
  $prodFis = mysqli_query($MySQLi, "SELECT * FROM productos_fiscales WHERE idProducto='$detailId'");
  $dataprodFis = mysqli_fetch_assoc($prodFis);

  $idProducto = $dataprodFis['idProducto'];
  $stockActual = (int) $dataprodFis['saldo_fisico'];
  $stockNuevo = $stockActual + $qtydevolver;
  $updateProdFi = mysqli_query($MySQLi, "UPDATE productos_fiscales SET saldo_fisico='$stockNuevo' WHERE idProducto='$idProducto' ");
  mysqli_close($MySQLi);
}
