<?php
require_once 'init.php';
require 'includes/default2.php';
$_title = 'Emisión Directa ';
$_active_nav = 'facturacion_directa';
//$idRangoDf == 1 ? header("Location: ?root=404") : null; 
?>
<!DOCTYPE html>
<html lang="es"><?php
                include_once APP_PATH . '/includes/head.php';
                include_once APP_PATH . '/includes/funciones.php';  ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?> ">
  <?php
  include_once APP_PATH . '/includes/theme.php'; ?>
  <div class="page-wrapper">
    <div class="page-inner"><?php
                            include_once APP_PATH . '/includes/nav.php'; ?>
      <div class="page-content-wrapper"><?php
                                        include_once APP_PATH . '/includes/header.php';
                                        ?>
        <main id="js-page-content" role="main" class="page-content">
          <ol class="breadcrumb page-breadcrumb"><?= $Fecha ?></ol>

          <div class="row">
            <div class="col">
              <div class="panel">
                <div class="panel-hdr">
                  <?php
                  if (isset($_POST['inicio'])) {
                    $Inicio = $_POST['inicio'];
                    $Fin = $_POST['fin'];
                  } else {
                    $Inicio = $startBusqueda; //startbuskeda = 1 del mes
                    $Fin = $fecha; //fecha = hoy
                  } ?>


                  <h2><span class="fw-300 text-info">FACTURACIÓN EMISIÓN DIRECTA
                      <i> <?php echo $sucurUsuarioDf ?></i>
                    </span>
                    <span class="text-danger">
                    </span> &nbsp; &nbsp; <span class="text-danger"><?= fechaFormato($Fin) ?></span>
                  </h2>

                  <div class="panel-toolbar">
                    <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                  </div>
                </div>
                <div class="panel-container">
                  <div class="panel-content">
                    <div id="content" class="content">
                      <form id="datosFactura">
                        <div class="row mt-2">
                          <div class="col">
                            <label class="form-label" for="clientReasonSocial">Razón social -
                              Cliente</label>
                            <input type="text" class="form-control" id="clientReasonSocial" name="clientReasonSocial" oninput="actualizarclientCode()" placeholder="RAZON SOCIAL" value="">

                          </div>
                          <div class="col">
                            <label for="clientDocumentType" class="form-label">Tipo de documento -
                              Cliente</label>
                            <select name="clientDocumentType" id="clientDocumentType" class="form-control  data-parsley-required=" true">
                              <option disabled="" selected="">Seleccione
                                Tipo de documento
                              </option>
                              <option value="1">CI - CEDULA DE IDENTIDAD</option>
                              <option value="2">CEX - CEDULA DE IDENTIDAD DE EXTRANJERO</option>
                              <option value="3">PAS - PASAPORTE</option>
                              <option value="4">OD - OTRO DOCUMENTO DE IDENTIDAD</option>
                              <option selected value="5">NIT - NÚMERO DE IDENTIFICACIÓN TRIBUTARIA
                              </option>
                            </select>
                          </div>
                          <div class="col">
                            <label class="form-label" for="clientNroDocument">Número Documento -
                              Cliente</label>
                            <input class="form-control" name="clientNroDocument" id="clientNroDocument" placeholder="Número Documento" value="">
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="clientCode" class="form-label">Código de cliente</label>
                            <input type="text" class="form-control" id="clientCode" name="clientCode" placeholder="CODIGO CLIENTE" readonly>
                          </div>
                          <div class="col">
                            <label for="clientCity" class="form-label">Ciudad Cliente</label>
                            <input type="text" class="form-control" name="clientCity" id="clientCity" value="" placeholder="CIUDAD CLIENTE">
                          </div>
                          <div class="col">
                            <label for="clientEmail" class="form-label">Email - Cliente</label>
                            <input type="text" class="form-control" name="clientEmail" id="clientEmail" placeholder="EMAIL@EMAIL.COM" value="">
                          </div>
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <label for="userPos" class="form-label">Vendedor</label>
                            <input type="text" readonly class="form-control" name="userPos" id="userPos" autofocus placeholder="VENDEDOR EN TURNO" value="<?php echo $nombreUsuarioDf; ?>">
                          </div>
                          <div class="col">
                            <label for="paramCurrency" class="form-label">Tipo de moneda</label>
                            <select name="paramCurrency" id="paramCurrency" class="form-control" data-parsley-required="true">
                              <option selected value="1">BOLIVIANO</option>
                            </select>
                          </div>
                          <div class="col">
                            <label for="paramPaymentMethod" class="form-label">Metodo de pago</label>
                            <select name="paramPaymentMethod" id="paramPaymentMethod" class="form-control  data-parsley-required=" true">
                              <option disabled="" selected="">Seleccione
                                Metodo De Pago
                              </option>

                              <option selected value="1"> EFECTIVO</option>
                              <option value="3"> CHEQUE</option>
                              <option value="4"> VALES</option>
                              <option value="5"> OTROS</option>
                              <option value="7"> TRANSFERENCIA BANCARIA</option>
                              <option value="8"> DEPOSITO EN CUENTA</option>
                            </select>
                          </div>
                        </div>
                        <div class="row mt-2">
                        </div>
                        <div class="row mt-2">
                          <div class="col">
                            <input name="tipo_venta" id="tipo_venta" type="hidden" value="directa">
                            <input name="branchIdName" id="branchIdName" type="hidden" value="<?php echo $idTiendaDf; ?>">
                            <input name="idCotizacion" id="idCotizacion" type="hidden" value="-1">
                          </div>
                        </div>
                        <div class="row mt-2 infoProducto">
                          <div class="col-md-6">
                            <label for="ClienteProducto">PRODUCTOS FISCALES <span class="text-info">(
                                *
                                )</span></label>
                            <select name="Producto" id="ClienteProducto" onchange="actualizarclientCode();" class="form-control">
                              <option disabled selected>Seleccione producto</option>
                              <?php
                              include 'includes/conexion_yuli_ventas.php';
                              $queryProd = mysqli_query($MySQLi, "SELECT * FROM productos_fiscales WHERE saldo_fisico > 0 ORDER BY fecha_poliza");
                              while ($dataProd = mysqli_fetch_assoc($queryProd)) {
                                echo "<option value=" . $dataProd['idProducto'] . ">" . $dataProd['fecha_poliza'] . " " . $dataProd['detalle'] . " " . $dataProd['codigo'] . " SaldoFisico[" . $dataProd['saldo_fisico'] . "]" . "</option>";
                              }
                              mysqli_close($MySQLi);
                              ?>
                            </select>
                            <div class="text-danger d-none noSelectProd">No ha seleccionado un producto
                            </div>
                          </div>
                          <div class="col-md-6">
                            <br><br>
                            <button title="Agregar producto fiscal a la factura" type="button" class="btn btn-xs btn-info Add_ProductoEmision d-none PreciosProductoSelected"><i class="fa fa-plus"></i> &nbsp;&nbsp;AGREGAR PRODUCTO FISCAL A LA
                              FACTURA &nbsp;<i class="fas fa-spinner fa-pulse d-none efectAddProduct"></i></button>
                          </div>
                        </div>
                        <div class="row mt-2 d-none PreciosProductoSelected">
                          <div class="col-md-3 d-none  PreciosProductoSelected text-center">
                            <label for="idProducto"><strong>ID PRODUCTO</strong></label>
                            <input type="text" id="idProducto" class="form-control text-center" disabled>
                          </div>
                          <div class="col-md-3 d-none  PreciosProductoSelected text-center">
                            <label for="fecha_poliza"><strong>FECHA POLIZA</strong></label>
                            <input type="text" id="fecha_poliza" class="form-control text-center" disabled>
                          </div>
                          <div class="col-md-3 d-none  PreciosProductoSelected text-center">
                            <label for="codigo"><strong>CODIGO</strong></label>
                            <input type="text" id="codigo" class="form-control text-center" disabled>
                          </div>
                          <div class="col-md-3 d-none">
                            <label for="detalle"><strong>DETALLE</strong></label>
                            <input type="hidden" id="detalle" class="form-control text-center" disabled>
                          </div>
                          <div class="col-md-3 d-none PreciosProductoSelected text-center">
                            <label for="ProdExistenciaCB"><strong>SALDO FISICO (STOCK) </strong></label>
                            <input type="text" id="ProdExistenciaCB" class="form-control text-center" disabled>
                          </div>
                        </div>
                        <div class="row mt-2 d-none PreciosProductoSelected">
                          <div class="col">
                            <label for="PrecioLista"><strong>C/U PARA FACTURAR MINIMO</strong></label>
                            <input type="text" name="PrecioLista" id="PrecioLista" class="form-control" placeholder="Precio de Lista" disabled>
                          </div>

                          <div class="col">
                            <label for="PrecioEspecial"><strong>IMPORTES PARA FACTURAR </label>
                            <input type="text" name="PrecioEspecial" id="PrecioEspecial" class="form-control" placeholder="Precio Especial" disabled>
                            <div class="text-danger d-none emptyPrecioEsp">No ha indicado el precio
                              especial
                            </div>
                          </div>
                          <div class="col">
                            <label for="CantidadProducto"><strong>CANTIDAD</strong></label>
                            <input type="number" name="Cantidad" id="CantidadProducto" class="form-control">
                            <div class="text-danger d-none CantidadEmpty">La cantidad no puede ser
                              negativa, nulo o mayor al Stock</div>
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col">Información: <br>
                            Los productos en la tabla de color <span style="color:aqua;">CELESTE</span>
                            son considerados productos_fiscales y afectan el stock de estos mismos al
                            momento de realizar la facturación.
                          </div>
                        </div>
                        <div class="row mt-4">
                          <div class="col">
                            <table id="tableProductosVendidos" class="table" width="100%">
                              <!-- aki se llena con js la tabla -->
                            </table>
                          </div>
                        </div>

                        <div class="row mt-4">
                          <div class="col">
                            <button id="submitButton" class="btn btn-primary btn-block facturarSintic" type="button">
                              <h4>Facturar</h4><i class="fas d-none efectSaveCotiza fa-spinner fa-pulse"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <?php
          include_once APP_PATH . '/includes/footer.php'; ?>
        </main>
      </div>

    </div>

  </div>
  <?php include_once APP_PATH . '/includes/extra.php'; ?>
  <?php include_once APP_PATH . '/includes/js.php'; ?>
  <script src="assets/js/facturacion_directa.js"></script>

</body>

</html>