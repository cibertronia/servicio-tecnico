<?php
require_once 'init.php';
$_title = 'Cotizaciones vendidas - ' . APP_TITLE;
$_active_nav = 'Vendidas'; ?>
<!DOCTYPE html>
<html lang="es"><?php
                include_once APP_PATH . '/includes/head.php'; ?>

<body class="mod-bg-1 mod-skin-<?= $_theme ?> "><?php
                                                include_once APP_PATH . '/includes/theme.php'; ?>
    <div class="page-wrapper">
        <div class="page-inner"><?php
                                include_once APP_PATH . '/includes/nav.php'; ?>
            <div class="page-content-wrapper"><?php
                                                include_once APP_PATH . '/includes/header.php'; ?>
                <main id="js-page-content" role="main" class="page-content">
                    <ol class="breadcrumb page-breadcrumb">
                        <li class="position-absolute pos-top pos-right d-none d-sm-block"><?= $Fecha ?></li>
                    </ol>
                    <div class="row">
                        <div class="col">
                            <div id="panelCotizacionesGeneradas" class="panel">
                                <input type="hidden" id="RangoUsuario" value="<?= $idRangoDf ?>">
                                <div class="panel-hdr"><?php
                                                        if (isset($_POST['inicio'])) {
                                                            $Inicio     = $_POST['inicio'];
                                                            $Fin        = $_POST['fin']; ?>
                                        <h2>Cotizaciones vendidas <span class="fw-300"><i>del <span class="text-danger"><?= fechaFormato($Inicio) ?></span> al <span class="text-danger"><?= fechaFormato($Fin) ?></span></i></span></h2><?php
                                                                                                                                                                                                                                        } else { ?>
                                        <h2>Cotizaciones vendidas <span class="fw-300"><i><?= $mes ?></i></span></h2><?php
                                                                                                                                                                                                                                        } ?>
                                    <div class="panel-toolbar">
                                        <button type="button" class="btn btn-xs btn-primary Buscar"><i class="far fa-search"></i></button>
                                        <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                                        <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                                    </div>
                                </div>
                                <div class="panel-container">
                                    <div class="respuesta"></div>
                                    <div class="panel-content">
                                        <form class="w-75 m-auto d-none" id="buscar" action="?root=vendidas" method="POST">
                                            <div class="row mb-2">
                                                <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                                                    <label for="fechaInicio" class="form-label">Fecha de inicio</label>
                                                    <input type="hidden" name="idTienda" value="<?php echo $idTiendaDf ?>">
                                                    <input type="date" name="inicio" id="fechaInicio" class="form-control text-center" value="<?php echo $startBusqueda ?>" data-parsley-required="true">
                                                </div>
                                                <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                                                    <label for="fechaFin" class="form-label">Fecha final</label>
                                                    <input type="date" name="fin" id="fechaFin" class="form-control text-center" value="<?php echo $fecha ?>" data-parsley-required="true">
                                                </div>
                                                <div class="my-2 col-sm-12 col-md-4 col-lg-4">
                                                    <label for="buscar">&nbsp;&nbsp;&nbsp;</label>
                                                    <button class="btn btn-primary btn-block btn-Busca ">Buscar
                                                        cotizaciones</button>
                                                </div>
                                            </div>
                                        </form>
                                        <table id="listaVendidas" class="table table-bordered table-hover table-striped w-100">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">ID</th>
                                                    <th width="95%" class="text-center">Detalle Cotizaci&oacute;n</th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                    if (isset($_POST['inicio'])) {
                                                        lista_cotizacionesVendidas($MySQLi, $Inicio, $Fin, $idRangoDf, $idTiendaDf);
                                                    } else {
                                                        lista_cotizacionesVendidas($MySQLi, $startBusqueda, $fecha, $idRangoDf, $idTiendaDf);
                                                    } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal cancelar orden de reparación (Individual -- TERMINADO)-->
                    <div class="modal fade" id="modal_editar_nota_venta" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 800px!important;">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title titulo_modal">
                                        EDITAR NOTA DE VENTA
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true"><i class="fal fa-times"></i></span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="showTable"></div>
                                        <div class="row">
                                            <div class="col">
                                                <input type="hidden" name="actualizar_idNotaE" id="actualizar_idNotaE">
                                                <textarea name="observaciones_editar_nota_venta" id="observaciones_editar_nota_venta" class="form-control" placeholder="Observaciones Nota de Venta" rows="8"></textarea>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col text-center">
                                                <label for="cancelaEstaOrden">&nbsp;&nbsp;</label>
                                                <button class="btn btn-primary actualizar_nota_venta" id="actualizar_nota_venta">ACTUALIZAR</button>
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Modal envicar cotizacion por correo -->
                    <div class="modal fade" id="openModal_VenderCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="panel-title">FORMULARIO RECIBO VENTA</h4>
                                </div>
                                <div class="modal-body">
                                    <form id="formularioVenta">
                                        <input type="hidden" name="serviPrecioDolar" id="serviPrecioDolar" value="<?= $serviPrecioUSD ?>">
                                        <input type="hidden" name="idCotizacion" id="idCotizacionModalVenta">
                                        <input type="hidden" name="idVendedor" id="idVendedorCotizacion">
                                        <input type="hidden" name="nombreVendedor" id="nombreVendedorCotizacion">
                                        <input type="hidden" name="idTienda" id="idTiendaCotizacion">
                                        <input type="hidden" name="clave" id="claveCotizacionVenta">
                                        <input type="hidden" name="action" value="VenderCotizacionCash">
                                        <?php
                                        if ($serviPrecioUSD == 1) { ?>
                                            <div class="row my-2">
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <label for="selectMoneda" class="form-label">MONEDA</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="selectedMoneda"><i class="fad fa-coin"></i></label>
                                                        </div>
                                                        <select name="moneda" id="selectedMoneda" class="form-control"></select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-6 col-lg-6">
                                                    <label for="precioDolar"><strong>Precio Dólar</strong></label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <label class="input-group-text" for="precioDolar"><i class="fad fa-sack-dollar"></i></label>
                                                        </div>
                                                        <input type="text" name="dolar" id="precioDolar" class="form-control text-center" value="<?= precioDolar($MySQLi) ?>">
                                                    </div>
                                                    <div class="emptyPrecioDolar text-center text-danger mt-2 d-none">
                                                        INGRESE PRECIO DÓLAR</div>
                                                </div>
                                            </div><?php
                                                } ?>
                                        <div class="row my-2">
                                            <!-- Código de la cotización -->
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label for="codigoCotizacionVenta" class="form-label">Código
                                                    cotización</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="codigoCotizacionVenta"><i class="fad fa-barcode"></i></label>
                                                    </div>
                                                    <input type="text" name="codigoCotizacion" id="codigoCotizacionVenta" class="form-control">
                                                </div>
                                            </div>
                                            <!-- Por la cantidad de:  -->
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <label for="porCantidad" class="form-label">Por la cantidad de:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="porCantidad"><i class="fad fa-dollar-sign"></i></label>
                                                    </div>
                                                    <input type="tel" name="cantidad" id="porCantidad" autocomplete="off" class="form-control text-center" placeholder="ingresa el monto">
                                                </div>
                                                <div class="emptyCantidadNumeros text-center text-danger mt-2 d-none">
                                                    INGRESE CANTIDAD</div>
                                            </div>
                                        </div>
                                        <!-- Recibí de:  -->
                                        <div class="row my-2">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="recibide" class="form-label">Recibí de:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="recibide"><i class="fad fa-money-check-edit"></i></label>
                                                    </div>
                                                    <input type="hidden" name="idCliente" id="idClienteCotizacionVenta">
                                                    <input type="tel" name="recibide" id="recibide" autocomplete="off" class="form-control" placeholder="nombre del cliente">
                                                </div>
                                                <div class="emptyNombreCliente text-center text-danger mt-2 d-none">
                                                    INGRESE NOMBRE</div>
                                            </div>
                                        </div>
                                        <!-- La suma de:  -->
                                        <div class="row my-2">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="cantidadLetras" class="form-label">La suma de:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="cantidadLetras"><i class="fad fa-money-check-edit-alt"></i></label>
                                                    </div>
                                                    <input type="text" name="cantidadLetras" id="cantidadLetras" autocomplete="off" class="form-control" placeholder="cantidad en letras">
                                                </div>
                                                <div class="emptyCantidadLetras text-center text-danger mt-2 d-none">
                                                    INGRESE CANTIDAD EN LETRAS</div>
                                            </div>
                                        </div>
                                        <!-- En concepto de:  -->
                                        <div class="row my-2">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="enConceptode" class="form-label">En concepto de:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="enConceptode"><i class="fad fa-money-check-edit-alt"></i></label>
                                                    </div>
                                                    <textarea name="concepto" id="enConceptode" class="form-control" placeholder="ingrese la descripción del concepto"></textarea>
                                                </div>
                                                <div class="emptyConcepto text-center text-danger mt-2 d-none">INGRESE
                                                    EL CONCEPTO</div>
                                            </div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-sm-12 col-md-6 col-lg-6"><button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button></div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <button class="btn btn-primary btn-block guardarPago">GUARDAR
                                                    PAGO</button>
                                                <div class="spinner-guardarPago spinner-<?= APP_THEME ?> m-auto d-none">
                                                    <div class="bar1"></div>
                                                    <div class="bar2"></div>
                                                    <div class="bar3"></div>
                                                    <div class="bar4"></div>
                                                    <div class="bar5"></div>
                                                    <div class="bar6"></div>
                                                    <div class="bar7"></div>
                                                    <div class="bar8"></div>
                                                    <div class="bar9"></div>
                                                    <div class="bar10"></div>
                                                    <div class="bar11"></div>
                                                    <div class="bar12"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="openModalNotaEntrega" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h4 class="modal-title">Formulario nota de entrega</h4>
                                    <form id="formNotaEntrega">
                                        <input type="hidden" name="action" value="actualizarNotaEntrega">
                                        <input type="hidden" name="idNotaEntrega" id="idNotaEntregaModal">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12 col-lg-12 tablaProductos_notaE"></div>
                                        </div>
                                        <div class="row my-2">
                                            <div class="col-sm-12 col-md-12 col-lg-12">
                                                <label for="descripcionEntrega" class="form-label">DSCRIPCIÓN DE LA NOTA
                                                    DE ENTREGA:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <label class="input-group-text" for="descripcionEntrega"><i class="fad fa-money-check-edit"></i></label>
                                                    </div>
                                                    <textarea name="descripcion" id="descripcionEntrega" class="form-control" placeholder="Ingrese una descripción">Se entregan los productos descritos en la tabla conforme la cotización solicitada, con la cual, el cliente firma conforme.</textarea>
                                                </div>
                                                <div class="emptyDescripcion text-center text-danger mt-2 d-none">DEBE
                                                    INGRESAR UNA DESCRIPCIÓN</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6 col-lg-6"><button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button></div>
                                            <div class="col-sm-12 col-md-6 col-lg-6">
                                                <button class="btn btn-primary btn-block actualizarNotaE">GUARDAR NOTA
                                                    DE ENTREGA</button>
                                                <div class="spinner-actualizarNotaE spinner-<?= APP_THEME ?> m-auto d-none">
                                                    <div class="bar1"></div>
                                                    <div class="bar2"></div>
                                                    <div class="bar3"></div>
                                                    <div class="bar4"></div>
                                                    <div class="bar5"></div>
                                                    <div class="bar6"></div>
                                                    <div class="bar7"></div>
                                                    <div class="bar8"></div>
                                                    <div class="bar9"></div>
                                                    <div class="bar10"></div>
                                                    <div class="bar11"></div>
                                                    <div class="bar12"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </main><?php
                        include_once APP_PATH . '/includes/footer.php'; ?>
            </div>
        </div>
    </div>
    <?php include_once APP_PATH . '/includes/extra.php'; ?>
    <?php include_once APP_PATH . '/includes/js.php'; ?>
    <script src="<?= ASSETS_URL ?>/js/vendidas.js"></script>
    <!-- Modal FACTURACION PANEL -->
    <div id="modalFacturaFR" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="max-width: 1250px!important;">
            <div class="modal-content">
                <!--=====================================
                                CABEZA DEL MODAL 2
                                ======================================-->
                <div class="modal-header">
                    <h4 class="modal-title">FACTURACION EN LINEA</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <!--=====================================
                                CUERPO DEL MODAL 2
                                ======================================-->
                <div class="modal-body">
                    <div class="box-body">

                        <form id="datosFactura">

                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label" for="clientReasonSocial">Razón social -
                                        Cliente</label>
                                    <input type="text" class="form-control" id="clientReasonSocial" name="clientReasonSocial" oninput="actualizarclientCode()" placeholder="RAZON SOCIAL" value="' . $NombreCliente . '">

                                </div>
                                <div class="col">
                                    <label for="clientDocumentType" class="form-label">Tipo de documento
                                        -
                                        Cliente</label>
                                    <select name="clientDocumentType" id="clientDocumentType" class="form-control  data-parsley-required=" true">
                                        <option disabled="" selected="">Seleccione
                                            Tipo de documento
                                        </option>
                                        <option value="1">CI - CEDULA DE IDENTIDAD</option>
                                        <option value="2">CEX - CEDULA DE IDENTIDAD DE EXTRANJERO
                                        </option>
                                        <option value="3">PAS - PASAPORTE</option>
                                        <option value="4">OD - OTRO DOCUMENTO DE IDENTIDAD</option>
                                        <option selected value="5">NIT - NÚMERO DE IDENTIFICACIÓN
                                            TRIBUTARIA
                                        </option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label" for="clientNroDocument">Numero Documento -
                                        Cliente</label>
                                    <input class="form-control" name="clientNroDocument" id="clientNroDocument" value="' . $nitCliente . '">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="clientCode" class="form-label">Código de cliente</label>
                                    <input type="text" class="form-control" id="clientCode" name="clientCode" placeholder="CODIGO CLIENTE" readonly>
                                </div>
                                <div class="col">
                                    <label for="clientCity" class="form-label">Ciudad Cliente</label>
                                    <input type="text" class="form-control" name="clientCity" id="clientCity" value="' . $ciudadCliente . '" placeholder="CIUDAD CLIENTE">
                                </div>
                                <div class="col">
                                    <label for="clientEmail" class="form-label">Email - Cliente</label>
                                    <input type="text" class="form-control" name="clientEmail" id="clientEmail" placeholder="EMAIL@EMAIL.COM" value="' . $correoCliente . '">
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label for="userPos" class="form-label">Vendedor</label>
                                    <input type="text" readonly class="form-control" name="userPos" id="userPos" autofocus placeholder="VENDEDOR EN TURNO" value="' . $nombreVendedor . '">
                                </div>
                                <div class="col">
                                    <label for="paramCurrency" class="form-label">Tipo de moneda</label>
                                    <select name="paramCurrency" id="paramCurrency" class="form-control" data-parsley-required="true">
                                        <option selected value="1">BOLIVIANO</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="paramPaymentMethod" class="form-label">Metodo de
                                        pago</label>
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
                                    <input name="tipo_venta" id="tipo_venta" type="hidden" value="venta_directa">
                                    <input name="branchIdName" id="branchIdName" type="hidden" value="' . $sucursalCompra . '">
                                    <input name="idCotizacion" id="idCotizacion" type="hidden" value="' . $idCotizacion . '">
                                </div>
                            </div>
                            <div class="row mt-2 infoProducto">
                                <div class="col-md-9">
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
                                    <div class="text-danger d-none noSelectProd">No ha seleccionado un
                                        producto
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <br><br>
                                    <button title="Agregar producto fiscal a la factura" type="button" class="btn btn-xs btn-info Add_ProductoEmision d-none PreciosProductoSelected"><i class="fa fa-plus"></i> &nbsp;&nbsp;AGREGAR PRODUCTO FISCAL
                                        A LA
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
                                    <label for="ProdExistenciaCB"><strong>SALDO FISICO (STOCK)
                                        </strong></label>
                                    <input type="text" id="ProdExistenciaCB" class="form-control text-center" disabled>
                                </div>
                            </div>
                            <div class="row mt-2 d-none PreciosProductoSelected">
                                <div class="col">
                                    <label for="PrecioLista"><strong>C/U PARA FACTURAR
                                            MINIMO</strong></label>
                                    <input type="text" name="PrecioLista" id="PrecioLista" class="form-control" placeholder="Precio de Lista" disabled>
                                </div>

                                <div class="col">
                                    <label for="PrecioEspecial"><strong>IMPORTES PARA FACTURAR </label>
                                    <input type="text" name="PrecioEspecial" id="PrecioEspecial" class="form-control" placeholder="Precio Especial" disabled>
                                    <div class="text-danger d-none emptyPrecioEsp">No ha indicado el
                                        precio
                                        especial
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="CantidadProducto"><strong>CANTIDAD</strong></label>
                                    <input type="number" name="Cantidad" id="CantidadProducto" class="form-control">
                                    <div class="text-danger d-none CantidadEmpty">La cantidad no puede
                                        ser
                                        negativa, nulo o mayor al Stock</div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col">Información: <br>
                                    Los productos en la tabla de color <span style="color:aqua;">CELESTE</span>
                                    son considerados productos_fiscales y afectan el stock de estos
                                    mismos al
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



                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="respuestaFactura text-center h1 text-success"></div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>