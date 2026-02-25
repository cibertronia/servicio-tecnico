<?php
require_once 'init.php';
$_title = 'Cotizaciones entregadas - '.APP_TITLE;
$_active_nav = 'Entregadas';?>
<!DOCTYPE html>
<html lang="es"><?php 
  include_once APP_PATH.'/includes/head.php'; ?>
  <body class="mod-bg-1 mod-skin-<?= $_theme ?> "><?php 
    include_once APP_PATH.'/includes/theme.php'; ?>
    <div class="page-wrapper">
      <div class="page-inner"><?php 
        include_once APP_PATH.'/includes/nav.php'; ?>
        <div class="page-content-wrapper"><?php 
          include_once APP_PATH.'/includes/header.php'; ?>
          <main id="js-page-content" role="main" class="page-content">
            <ol class="breadcrumb page-breadcrumb"><li class="position-absolute pos-top pos-right d-none d-sm-block"><?=$Fecha ?></li></ol>
            <div class="row">
              <div class="col">
                <div id="panelCotizacionesGeneradas" class="panel">
                  <input type="hidden" id="RangoUsuario" value="<?=$idRangoDf?>">
                  <div class="panel-hdr"><?php
                    if (isset($_POST['inicio'])) {
                      $Inicio     = $_POST['inicio'];
                      $Fin        = $_POST['fin']; ?>
                      <h2>Cotizaciones entregadas <span class="fw-300"><i>del <span class="text-danger"><?= fechaFormato($Inicio)?></span> al <span class="text-danger"><?=fechaFormato($Fin)?></span></i></span></h2><?php
                    }else{ ?>
                      <h2>Cotizaciones entregadas <span class="fw-300"><i><?=$mes?></i></span></h2><?php
                    }?>
                    <div class="panel-toolbar">
                      <button type="button" class="btn btn-xs btn-primary Buscar"><i class="far fa-search"></i></button>
                      <button class="btn btn-panel" data-action="panel-collapse" data-toggle="tooltip" data-offset="0,10" data-original-title="Comprimir"></button>
                      <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip" data-offset="0,10" data-original-title="Pantalla completa"></button>
                    </div>
                  </div>
                  <div class="panel-container"><div class="respuesta"></div>
                    <div class="panel-content">                      
                      <form class="w-75 m-auto d-none" id="buscar" action="?root=entregadas" method="POST">
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
                            <button class="btn btn-primary btn-block btn-Busca ">Buscar cotizaciones</button>
                          </div>
                        </div>
                      </form>
                      <table id="listaEntregadas" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                          <tr>
                            <th width="5%" class="text-center">ID</th>
                            <th width="95%" class="text-center">Detalle Cotizaci&oacute;n</th>
                          </tr>
                        </thead>
                        <tbody><?php
                          if (isset($_POST['inicio'])) {
                            lista_cotizacionesEntregadas($MySQLi,$Inicio,$Fin,$idRangoDf,$idTiendaDf);
                          }else{
                            lista_cotizacionesEntregadas($MySQLi,$startBusqueda,$fecha,$idRangoDf,$idTiendaDf);
                          }?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal vender cotizacion cash -->
            <div class="modal fade" id="openModal_VenderCotizacion" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="panel-title">FORMULARIO RECIBO VENTA</h4>
                  </div>
                  <div class="modal-body">
                    <form id="formularioVenta">
                      <input type="hidden" name="serviPrecioDolar" id="serviPrecioDolar" value="<?=$serviPrecioUSD?>">
                      <input type="hidden" name="serviStock" value="<?=$serviStock?>">
                      <input type="hidden" name="idCotizacion" id="idCotizacionModalVenta">
                      <?php //<input type="hidden" name="idVendedor" id="idVendedorCotizacion">
                      //<input type="hidden" name="nombreVendedor" id="nombreVendedorCotizacion"> ?>
                      <input type="hidden" name="idTienda" id="idTiendaCotizacion">
                      <input type="hidden" name="clave" id="claveCotizacionVenta">                      
                      <input type="hidden" name="action" value="VenderCotizacionCash">
                      <?php
                      if ($serviPrecioUSD==1) { ?>
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
                              <input readonly type="text" name="dolar" id="precioDolar" class="form-control text-center" value="<?=precioDolar($MySQLi) ?>">
                            </div>
                            <div class="emptyPrecioDolar text-center text-danger mt-2 d-none">INGRESE PRECIO DÓLAR</div>
                          </div>
                        </div><?php
                      } ?>
                      <div class="row my-2">
                        <!-- Código de la cotización -->
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <label for="codigoCotizacionVenta" class="form-label">Código cotización</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="codigoCotizacionVenta"><i class="fad fa-barcode"></i></label>
                            </div>
                            <input type="text" name="codigoCotizacion" id="codigoCotizacionVenta" class="form-control">
                          </div>
                        </div>
                        <!-- Por la cantidad de:  -->
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <input type="hidden" id="idMonedaPanel">
                          <label for="porCantidad" class="form-label">Por la cantidad de:</label>
                          <div class="input-group">
                            <!-- <div class="input-group-prepend"> -->
                              <!-- <label class="input-group-text" for="porCantidad"><span class="simboloMoneda"></span></label> -->
                            <!-- </div> -->
                            <input type="tel" name="cantidad" id="porCantidad" autocomplete="off" class="form-control text-center" placeholder="ingresa el monto">
                          </div>
                          <div class="emptyCantidadNumeros text-center text-danger mt-2 d-none">INGRESE CANTIDAD</div>
                        </div>
                      </div>
                      <!-- Recibí de:  -->
                      <div class="row my-2">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <label for="recibide" class="form-label">Recibí de:</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="recibide"><i class="fad fa-money-check-edit"></i></label>
                            </div>
                            <input type="hidden" name="idCliente" id="idClienteCotizacionVenta">
                            <input type="tel" name="recibide" id="recibide" autocomplete="off" class="form-control" placeholder="nombre del cliente">
                          </div>
                          <div class="emptyNombreCliente text-center text-danger mt-2 d-none">INGRESE NOMBRE</div>
                        </div>
                        
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <label for="recibidde" class="form-label">Vendedor:</label>
                          <div class="input-group">

                            <div>
                            <select id="idVendedor" name="idVendedor" class="form-control" style="width: 50%;display: inline-block;">
                                <option value='-1'>NINGUNO</option>
                                <?php
                                    include_once 'includes/conexion.php';
                                    $nombreVendedor = "";
                                    $result = mysqli_query($MySQLi, "SELECT idUser, Nombre FROM usuarios WHERE idTienda='$idTiendaDf' or idTienda=-1 order by Nombre");
                                    while ($row=mysqli_fetch_row($result)) {
                                        echo "<option value='" . $row[0] . "'" . " selected" . ">" . $row[1] . "</option>";
                                    }  
                                ?>
                            </select>
                            <input type="text" name="nombreVendedor" id="nombreVendedor" class="form-control" placeholder="Nombre del vendedor" style="width: 49%;display: inline-block;">
                            </div>
                          </div>
                          <div class="emptyNombreVendedor text-center text-danger mt-2 d-none"></div>
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
                          <div class="emptyCantidadLetras text-center text-danger mt-2 d-none">INGRESE CANTIDAD EN LETRAS</div>
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
                            <textarea name="concepto" id="enConceptode" rows="6" class="form-control" placeholder="ingrese la descripción del concepto"></textarea>
                          </div>
                          <div class="emptyConcepto text-center text-danger mt-2 d-none">INGRESE EL CONCEPTO</div>
                        </div>
                      </div>
                      <div class="row my-2">
                        <div class="col-sm-12 col-md-6 col-lg-6"><button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button></div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <button class="btn btn-primary btn-block guardarPago">GUARDAR PAGO</button>
                          <div class="spinner-guardarPago spinner-<?=APP_THEME ?> m-auto d-none">
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
                      <input type="hidden"name="action" value="actualizarNotaEntrega">
                      <input type="hidden" name="idNotaEntrega" id="idNotaEntregaModal">
                      <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 tablaProductos_notaE"></div>
                      </div>
                      <div class="row my-2">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                          <label for="descripcionEntrega" class="form-label">OBSERVACIONES DE LA NOTA DE VENTA:</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <label class="input-group-text" for="descripcionEntrega"><i class="fad fa-money-check-edit"></i></label>
                            </div>
                            <textarea name="descripcion" id="descripcionEntrega" class="form-control" placeholder="Ingrese una descripción">Se entregan los repuetos descritos en la tabla conforme la cotización solicitada, con la cual, el cliente firma.</textarea>
                          </div>
                          <div class="emptyDescripcion text-center text-danger mt-2 d-none">DEBE INGRESAR UNA DESCRIPCIÓN</div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6"><button type="button" class="btn btn-default" data-dismiss="modal">cerrar</button></div>
                        <div class="col-sm-12 col-md-6 col-lg-6">
                          <button class="btn btn-primary btn-block actualizarNotaE">GUARDAR NOTA DE ENTREGA</button>
                          <div class="spinner-actualizarNotaE spinner-<?=APP_THEME ?> m-auto d-none">
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
          include_once APP_PATH.'/includes/footer.php'; ?>
        </div>
      </div>
    </div>
    <?php include_once APP_PATH.'/includes/extra.php'; ?>
    <?php include_once APP_PATH.'/includes/js.php'; ?>
    <script src="<?=ASSETS_URL?>/js/entregadas.js"></script>
    <script>  
        $(document).ready(function(){
        $("#nombreVendedor").prop("readonly", true);
        $('#idVendedor').on('change', function() {
          if ( this.value == '-1')  {
            $("#nombreVendedor").show();
            $("#nombreVendedor").prop("readonly", false);
            $("#nombreVendedor").focus();
          }
          else  {
            $("#nombreVendedor").prop("readonly", true);
            $("#nombreVendedor").val("");
          }
        });
        });
    </script>
  </body>
</html>