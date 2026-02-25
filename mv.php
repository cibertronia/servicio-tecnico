<?php
 if(isset($_GET['i']) && isset($_GET['f']) && isset($_GET['u'])){
    $Inicio = $_GET['i'];
    $Fin = $_GET['f'];
    $idUser = $_GET['u'];
    
    $t=0;
    if (isset($_GET['t']))
        $t = $_GET['t'];
 }
 else
    die();
error_reporting(E_ALL);
include './includes/conexion.php';
require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    // Agregar contenido a la hoja de cálculo
    
    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial narrow');
    $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

    $sheet = $spreadsheet->getActiveSheet();

    $sheet->getStyle('1')->getAlignment()->setWrapText(true);
    $sheet->getStyle('2')->getAlignment()->setWrapText(true);

    //ancho automatico columnas
    //ancho_columnas($sheet);
    //titulos
    $sheet->setCellValue('B1', 'VENTA DE REPUESTOS DEL '. ($_GET['i']) . ' AL ' . ($_GET['f']));
    $sheet->mergeCells('B1:I1');    
                                $sheet->setCellValue('A2', 'FECHA');
                                
                                $sheet->setCellValue('B2', 'No. NOTA VENTA');
                                
                                $sheet->setCellValue('C2', 'No. FACTURA');

                                
                                $sheet->setCellValue('D2', 'CLIENTE/CELULAR/NIT');
                                
                                $sheet->setCellValue('E2', 'MAQUINA REPUESTO');
                                $sheet->setCellValue('F2', 'PRECIO DE LISTA DEL REPUESTO');

                                $sheet->setCellValue('G2', 'CANTIDAD');
                                $sheet->setCellValue('H2', 'COBRO BS');
                                
                                $sheet->setCellValue('I2', 'TOTAL A COBRAR BS');
                                $sheet->setCellValue('J2', 'IMPORTE FACTURADO');
                                $sheet->setCellValue('K2', 'TIPO DE CAMBIO');
                                $sheet->setCellValue('L2', 'NOMBRE VENDEDOR');
                                $sheet->setCellValue('M2', 'OBSERVACIONES');

                               
                              
                                
                              include 'includes/conexion.php';
                              
                              $Num = 1;

                              $total_precio_lista = 0;
                              $total_cantidad = 0;
                              $total_precio_venta = 0;
                              $total_venta = 0;
                              $total_importe_facturado = 0;


                              $resUser = mysqli_query($MySQLi, "select tipo from usuarios where idUser = $idUser"); 
                              $filaUser = mysqli_fetch_assoc($resUser);
                              $tipoUser = $filaUser['tipo'];    
                              //$sql = "SELECT *  FROM soporte_ventas WHERE (fecha_completado BETWEEN '$Inicio' AND '$Fin') AND id_user='$idUser' ORDER BY fecha_recepcion ASC ";
                              if ($tipoUser == 'A') {
                                  $sql = "SELECT sv.*  FROM soporte_ventas sv ";
                                $sql .= " WHERE (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') and sv.idCotizacion > 0 ";
                                if ($t > 0 ) {
                                    $sql .= " and sv.id_sucursal = $t";
                                }
                                $sql .= " ORDER BY fecha_recepcion ASC";
                              }
                              else {
                              $sql = "SELECT sv.*  FROM soporte_ventas sv ";
                              $sql .= " inner join cotizaciones cot on sv.idCotizacion = cot.idCotizacion";
                              $sql .= " and cot.idUser = '$idUser'";
                              $sql .= " WHERE (sv.fecha_completado BETWEEN '$Inicio' AND '$Fin') ORDER BY fecha_recepcion ASC";
                                }
                              
                              $resultado = mysqli_query($MySQLi, $sql);
                              
                              $y = 3;

                              while ($fila = mysqli_fetch_assoc($resultado)) {
                                //dividir ventas directo y si si corresponde servicio llenar de otra forma
                                $idCotizacion = (int) $fila['idCotizacion'];
                                 
                                //IDNOTA DE ENTREGA
                                $Q_NotaEntrega  = mysqli_query($MySQLi, "SELECT idNotaE FROM notaEntrega WHERE idCotizacion='$idCotizacion' ");
                                $dataNotaEntrega = mysqli_fetch_assoc($Q_NotaEntrega);
                                $idNotaEntrega  = $dataNotaEntrega['idNotaE'];
                     /*              echo "SELECT idNotaE FROM notaEntrega WHERE idCotizacion='$idCotizacion' ";
                                  echo "<br>"; */
                                //IDNOTA DE ENTREGA
                                $idSoporte = $fila['idSoporte'];

                                // 1  caso que sea de cotizacion
                                if ($idCotizacion !== 0 && $idSoporte == 0) {
                                  // A
                                  $fecha_recepcion = ($fila['fecha_recepcion']);
                                  // B
                                  // C
                                  $idCotizacion = ($fila['idCotizacion']);
                                  // D
                                  $nota_entrega_venta_maquina = json_decode($fila['nota_entrega_venta_maquina']);
                                  $nota_entrega_venta_maquina = ($nota_entrega_venta_maquina[0]);
                                  // E
                                  $invoice_number = ($fila['invoice_number']);
                                  // F
                                  $garantias_repuestos = json_decode($fila['garantias_repuestos']);
                                  $garantias_mano = json_decode($fila['garantias_mano']);
                                  $garantia_ambos = strtoupper($garantias_repuestos[0] . ' , ' . $garantias_mano[0]);
                                  $garantia_ambos = (string)($garantia_ambos);
                                  // G
                                  $q_cotizaciones = mysqli_query($MySQLi, "SELECT * FROM `cotizaciones` WHERE `idCotizacion`='$idCotizacion'");
                                  $d_cotizaciones = mysqli_fetch_assoc($q_cotizaciones);
                                  $idCliente = $d_cotizaciones['idCliente'];
                                  $q_clientes = mysqli_query($MySQLi, "SELECT * FROM `clientes` WHERE `idCliente`='$idCliente'");
                                  $d_clientes = mysqli_fetch_assoc($q_clientes);
                                  $telefono_cliente = $d_clientes['celular'];
                                  $nombre_cliente = $fila['nombre_cliente'] . "\n" . $telefono_cliente;
                                  $nombre_cliente = (string)($nombre_cliente);
                                  //H
                                  //I
                                  $repuestos_nombres = json_decode($fila['repuestos_nombres']);
                                  $repuestos_nombres = ($repuestos_nombres[0][0]);
                                  //J
                                  $repuestos_precio_lista = json_decode($fila['repuestos_precio_lista']);
                                  $repuestos_precio_lista = ($repuestos_precio_lista[0][0]);
                                  //K
                                  $repuestos_cantidad = json_decode($fila['repuestos_cantidad']);
                                  $repuestos_cantidad = ($repuestos_cantidad[0][0]);
                                  //L
                                  $repuestos_precio_venta = json_decode($fila['repuestos_precio_venta']);
                                  $repuestos_precio_venta = ($repuestos_precio_venta[0][0]);
                                  //M
                                  //N
                                  //O
                                  //P
                                  //Q
                                  //R
                                  $total_cobrar_bs = ($fila['total_cobrar_bs']);
                                  //S
                                  $importe_facturado = ($fila['importe_facturado']);
                                  //T
                                  $id_user = $fila['id_user'];
                                  $q_nombre_user = mysqli_query($MySQLi, "SELECT Nombre FROM usuarios WHERE idUser='$id_user'");
                                  $d_nombre_user = mysqli_fetch_assoc($q_nombre_user);
                                  $Nombre = $d_nombre_user['Nombre']; //el que vendio
                                  $Nombre = (string)($Nombre);
                                  //U
                                  $precio_dolar = $fila['precio_dolar'];
                                //$sheet->setCellValue('A' . $y, $nota_entrega_venta_maquina[0]);
                                
                                $sheet->setCellValue('A' . $y, $fecha_recepcion);
//<!--                            $sheet->setCellValue('C' . $y,  $idCotizacion . '-' . $idNotaEntrega;);
                                    $sheet->setCellValue('B' . $y,  $idNotaEntrega);
                                    $sheet->setCellValue('C' . $y,  $invoice_number);
                                    $sheet->setCellValue('D' . $y,  utf8_decode($nombre_cliente));
                                    $sheet->setCellValue('E' . $y,  ($repuestos_nombres));
                                    $sheet->setCellValue('F' . $y, number_format($repuestos_precio_lista,2));
                                    $sheet->setCellValue('G' . $y, $repuestos_cantidad);
                                    $sheet->setCellValue('H' . $y,  number_format($repuestos_precio_venta,2));
                                    $sheet->setCellValue('I' . $y,  number_format($total_cobrar_bs,2));
                                    $sheet->setCellValue('J' . $y,   number_format($importe_facturado,2));
                                    $sheet->setCellValue('K' . $y,  $precio_dolar );
                                    $sheet->setCellValue('L' . $y,   utf8_decode($Nombre));
                                    $sheet->setCellValue('M' . $y,  'Venta Directa' );
                                  
                                  $total_precio_lista += $repuestos_precio_lista;
                                  $total_cantidad += $repuestos_cantidad;
                                  $total_precio_venta += $repuestos_precio_venta;
                                  $total_venta += $total_cobrar_bs;
                                  $total_importe_facturado += $importe_facturado;
                                  $Num++;
                                  $y++;
                                } else if(1 == 2){
                                
                                  // A
                                  $fecha_recepcion = ($fila['fecha_recepcion']);
                                  // B
                                  // C
                                  $nro_servicio_recepcion = ($fila['nro_servicio_recepcion']); //2
                                  // E
                                  $invoice_number = ($fila['invoice_number']); //3
                                  // G
                                  $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte'");
                                  $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
                                  $telefono_cliente = $d_soporte_sucursales['telCliente'];
                                  $nombre_cliente = $fila['nombre_cliente'] . "\n" . $telefono_cliente; //4
                                  //R
                                  $total_cobrar_bs = ($fila['total_cobrar_bs']); //multiplicar 
                                  //S
                                  $importe_facturado = ($fila['importe_facturado']);
                                  //T
                                  $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte' AND estado=3");
                                  $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
                                  $tecnico_cadena = $d_soporte_sucursales['encargado_diagnostico'];

                                  //1er Ficha Tecnica
                                  $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE idSoporte='$idSoporte' AND estado=3");
                                  $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
                                  $clave_soporte = $d_soporte_sucursales['clave_soporte'];
                                  //2do Equipos Registrados
                                  $q_soporte_claves = mysqli_query($MySQLi, "SELECT * FROM `soporte_claves` WHERE `clave`='$clave_soporte' AND estado=3");
                                  while ($d_soporte_claves = mysqli_fetch_assoc($q_soporte_claves)) {
                                    //D
                                    $notaEntrega = $d_soporte_claves['notaEntrega'];
                                    ($notaEntrega);
                                    //F
                                    $garantia_vigente_repuesto = $d_soporte_claves['garantia_vigente_repuesto'];
                                    $garantia_vigente_mano = $d_soporte_claves['garantia_vigente_mano'];
                                    $garantia_ambos = strtoupper($garantia_vigente_repuesto . ' , ' . $garantia_vigente_mano);
                                    ($garantia_ambos);
                                    //H
                                    $equipo = $d_soporte_claves['equipo'];
                                    $marca = $d_soporte_claves['marca'];
                                    $modelo = $d_soporte_claves['modelo'];
                                    $maquina_nombre = $equipo . ' ' . $marca . ' ' . $modelo;
                                    ($maquina_nombre);
                                    //P
                                    //Q
                                    //U
                                    $problema = $d_soporte_claves['problema'];
                                    $realizar = $d_soporte_claves['realizar'];
                                    $trabajoRealizado = $d_soporte_claves['trabajoRealizado'];
                                    $descripcion_reparacion = 'Problema: ' . $problema . ' Realizar: ' . $realizar . ' Trabajo Adicional: ' . $trabajoRealizado;
                                    ($descripcion_reparacion);

                                    //3ro Repuestos usados en cada equipo
                                    $idClave = $d_soporte_claves['idClave'];
                                    $q_soporte_claves_repuestos = mysqli_query($MySQLi, "SELECT scr.*, ifnull(p.mercaderia,'') mercaderia FROM `soporte_claves_repuestos` scr left join productos p on p.idproducto = scr.idproducto  WHERE scr.idClave='$idClave' AND scr.tipo_repuesto='repuesto_sistema'");
                                    while ($d_soporte_claves_repuestos = mysqli_fetch_assoc($q_soporte_claves_repuestos)) {
                                      //I
                                      $nombre_repuesto = $d_soporte_claves_repuestos['nombre_repuesto'];
                                      $mercaderia = $d_soporte_claves_repuestos['mercaderia'];
                                      //J
                                      $precioVenta = $d_soporte_claves_repuestos['precioVenta'];
                                      //K
                                      $cantidad = $d_soporte_claves_repuestos['cantidad'];
                                      //L
                                      $precioEspecial = $d_soporte_claves_repuestos['precioEspecial'];
                                      //M
                                      //N
                                      //O
                                   /*
                                      <tr class="odd gradeX">
                                        <td class="text-center"><?php echo $fecha_recepcion; ?></td>
                                        <td style="text-align: center"><?php echo $nro_servicio_recepcion; ?></td>
                                        <td style="text-align: center"><?php echo $invoice_number; ?></td>
                                        <td class="text-center"><?php echo utf8_decode($nombre_cliente); ?></td>
                                        <td class="text-center"><?php echo utf8_decode($mercaderia . ' ' .$nombre_repuesto); ?></td>

                                        <td style="text-align: right;background-color: #FF0000;"><?php echo number_format($precioVenta,2); ?></td>
                                        <td style="text-align: center"><?php echo $cantidad; ?></td>
                                        <td style="text-align: right"><?php echo number_format($precioEspecial,2); ?></td>
                                        <td style="text-align: right;background-color: #E2EFDD"><?php echo number_format($cantidad * $precioEspecial, 2); ?></td>
                                        <td style="text-align: right;background-color: #FFF2CD"><?php echo number_format($importe_facturado,2); ?></td>

                                        <td class="text-center"><?php echo utf8_decode($tecnico_cadena); ?></td>
                                        <td class="text-center"><?php echo utf8_decode('Venta Soporte Técnico') ?></td>
                                      </tr>
                              */
                                      $total_precio_lista += $precioVenta;
                                      $total_cantidad += $cantidad;
                                      $total_precio_venta += $precioEspecial;
                                      $precio_cobrar = $cantidad * $precioEspecial;
                                      $total_venta += $precio_cobrar;
                                      $total_importe_facturado += $importe_facturado;
                                      $Num++;
                                    }
                                  } //Fin while2 equipos

                                } //Termina If


                              }
                              mysqli_close($MySQLi); 
                                $sheet->setCellValue('A' . $y,  '');
                                $sheet->setCellValue('B' . $y,  '');
                                $sheet->setCellValue('C' . $y,  '');
                                $sheet->setCellValue('D' . $y,  '');
                                $sheet->setCellValue('E' . $y,  'TOTALES');
                                $sheet->setCellValue('F' . $y,$total_precio_lista);
                                $sheet->setCellValue('G' . $y, $total_cantidad);
                                $sheet->setCellValue('H' . $y,   $total_precio_venta);
                                $sheet->setCellValue('I' . $y,  $total_venta);
                                $sheet->setCellValue('J' . $y,  $total_importe_facturado);
                                $sheet->setCellValue('K' . $y,  '');
                                $sheet->setCellValue('L' . $y,  '');
                                
    $rango_formatear = 'F3:F' . $y;
    $sheet->getStyle($rango_formatear)->getNumberFormat()->setFormatCode('0.00');
    $rango_formatear = 'H3:H' . $y;
    $sheet->getStyle($rango_formatear)->getNumberFormat()->setFormatCode('0.00');
    $rango_formatear = 'I3:I' . $y;
    $sheet->getStyle($rango_formatear)->getNumberFormat()->setFormatCode('0.00');
    $rango_formatear = 'J3:J' . $y;
    $sheet->getStyle($rango_formatear)->getNumberFormat()->setFormatCode('0.00');    
    
    centrar_texto($sheet, 'B');
    centrar_texto($sheet, 'C');
    centrar_texto($sheet, 'G');

    $sheet->getStyle('B1:I1'  )->applyFromArray(['font' => ['bold' => true]]);
    
    $sheet->getStyle('A2:M2'  )->applyFromArray(['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCE5D7']]]);
    $sheet->getStyle("A$y:L$y"  )->applyFromArray(['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FCE5D7']]]);

    $sheet->getStyle("J2:J$y"  )->applyFromArray(['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFF7D']]]);
    $sheet->getStyle("I2:I$y"  )->applyFromArray(['font' => ['bold' => true], 'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2EFDD']]]);    
        
    bordear_celdas("A1:M$y", $sheet);

$file = 'Mis Ventas.xlsx';                                
// Configurar el objeto Writer para crear un archivo Excel
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    // Guardar el archivo en el directorio especificado
    $writer->save($file);
    // Descargar el archivo

    header('Content-Description: Archivo de Excel');
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . basename($file) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    unlink($file);
    exit;                       
    
    function centrar_texto($sheet, $columna)
{
    $estilo = [
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Centrar horizontalmente
        ],
    ];
    $sheet->getStyle($columna)->applyFromArray($estilo);
}

function bordear_celdas($cellRange, $sheet)
{
    $sheet->getStyle($cellRange)->applyFromArray(
        [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN, // tipo de línea de borde
                    'color' => ['argb' => '000000'], // color del borde
                ],
            ],
        ]
    );
}

                              ?>