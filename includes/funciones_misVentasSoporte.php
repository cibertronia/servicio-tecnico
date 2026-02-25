<?php
function lista_misVentasSoporte($MySQLi, $id_sucursal, $Inicio, $Fin)
{

    // Realizamos la consulta a la base de datos
    $sql = "SELECT *  FROM soporte_ventas WHERE (fecha_completado BETWEEN '$Inicio' AND '$Fin') AND id_sucursal='$id_sucursal'  ORDER BY fecha_recepcion ASC ";
    $resultado = mysqli_query($MySQLi, $sql);
    // Iteramos sobre los resultados de la consulta
    $i = 2;
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $i++;
        $fila_inicial = $i;
        //dividir ventas directo y si si corresponde servicio llenar de otra forma
        $idCotizacion = (int) $fila['idCotizacion'];
        $idSoporte = $fila['idSoporte'];

        // 1  caso que sea de cotizacion
        if ($idCotizacion !== 0 && $idSoporte == 0) {
            // A
            $sheet->setCellValue('A' . $i, $fila['fecha_recepcion']);
            // B
            // $fecha_nota_entrega_yuli = json_decode($fila['fecha_nota_entrega_yuli']);
            // $sheet->setCellValue('B' . $i, $fecha_nota_entrega_yuli[0]);
            // C
            $sheet->setCellValue('C' . $i, $fila['idCotizacion']);
            // D
            $nota_entrega_venta_maquina = json_decode($fila['nota_entrega_venta_maquina']);
            $sheet->setCellValue('D' . $i, $nota_entrega_venta_maquina[0]);
            // E
            $sheet->setCellValue('E' . $i, $fila['invoice_number']);
            // F
            $garantias_repuestos = json_decode($fila['garantias_repuestos']);
            $garantias_mano = json_decode($fila['garantias_mano']);
            $garantia_ambos = strtoupper($garantias_repuestos[0] . ' , ' . $garantias_mano[0]);
            $sheet->setCellValue('F' . $i, $garantia_ambos);
            // G
            $q_cotizaciones = mysqli_query($MySQLi, "SELECT * FROM `cotizaciones` WHERE `idCotizacion`='$idCotizacion'");
            $d_cotizaciones = mysqli_fetch_assoc($q_cotizaciones);
            $idCliente = $d_cotizaciones['idCliente'];
            $q_clientes = mysqli_query($MySQLi, "SELECT * FROM `clientes` WHERE `idCliente`='$idCliente'");
            $d_clientes = mysqli_fetch_assoc($q_clientes);
            $telefono_cliente = $d_clientes['celular'];
            $nombre_cliente = $fila['nombre_cliente'] . "\n" . $telefono_cliente;
            $sheet->setCellValue('G' . $i, $nombre_cliente);
            //H
            // $nombre_maquinas = json_decode($fila['nombre_maquinas']);
            // $sheet->setCellValue('H' . $i, $nombre_maquinas[0]);
            //I
            $repuestos_nombres = json_decode($fila['repuestos_nombres']);
            $sheet->setCellValue('I' . $i, $repuestos_nombres[0][0]);
            //J
            $repuestos_precio_lista = json_decode($fila['repuestos_precio_lista']);
            $sheet->setCellValue('J' . $i, $repuestos_precio_lista[0][0]);
            //K
            $repuestos_cantidad = json_decode($fila['repuestos_cantidad']);
            $sheet->setCellValue('K' . $i, $repuestos_cantidad[0][0]);
            //L
            $repuestos_precio_venta = json_decode($fila['repuestos_precio_venta']);
            $sheet->setCellValue('L' . $i, $repuestos_precio_venta[0][0]);
            //M
            // $insumo_externo = json_decode($fila['insumo_externo']);
            // $sheet->setCellValue('M' . $i, $insumo_externo[0][0]);
            //O
            // $otros_gastos = json_decode($fila['otros_gastos']);
            // $sheet->setCellValue('O' . $i, $otros_gastos[0][0]);
            //P
            // $precio_mano_obra = json_decode($fila['precio_mano_obra']);
            // $sheet->setCellValue('P' . $i, $precio_mano_obra[0]);
            //Q
            // $costo_adicional = json_decode($fila['costo_adicional']);
            // $sheet->setCellValue('Q' . $i, $costo_adicional[0]);
            //R
            $sheet->setCellValue('R' . $i, $fila['total_cobrar_bs']);
            //S
            $sheet->setCellValue('S' . $i, $fila['importe_facturado']);
            //T
            $id_user = $fila['id_user'];
            $q_nombre_user = mysqli_query($MySQLi, "SELECT Nombre FROM usuarios WHERE idUser='$id_user'");
            $d_nombre_user = mysqli_fetch_assoc($q_nombre_user);
            $Nombre = $d_nombre_user['Nombre']; //el que vendio
            $sheet->setCellValue('T' . $i, $Nombre);
            //U
            // $descripcion_reparacion = json_decode($fila['descripcion_reparacion']);
            // $sheet->setCellValue('U' . $i, $descripcion_reparacion[0]);
        } else {
            // A
            $sheet->setCellValue('A' . $i, $fila['fecha_recepcion']);
            // B
            $array_fecha_nota_entrega_yuli = json_decode($fila['fecha_nota_entrega_yuli']);
            $fecha_nota_entrega_yuli = '';
            foreach ($array_fecha_nota_entrega_yuli as $valor) {
                $fecha_nota_entrega_yuli .= "$valor \n";
            }
            $fecha_nota_entrega_yuli = eliminar_ultimo_salto_n($fecha_nota_entrega_yuli);
            $sheet->setCellValue('B' . $i, $fecha_nota_entrega_yuli);
            // C
            $sheet->setCellValue('C' . $i, $fila['nro_servicio_recepcion']);
            // E
            $sheet->setCellValue('E' . $i, $fila['invoice_number']);
            // G
            $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte'");
            $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
            $telefono_cliente = $d_soporte_sucursales['telCliente'];
            $nombre_cliente = $fila['nombre_cliente'] . "\n" . $telefono_cliente;
            $sheet->setCellValue('G' . $i, $nombre_cliente);
            //R
            $sheet->setCellValue('R' . $i, $fila['total_cobrar_bs']);
            //S
            $sheet->setCellValue('S' . $i, $fila['importe_facturado']);
            //T
            $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte' AND estado=3");
            $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
            $tecnico_cadena = $d_soporte_sucursales['encargado_diagnostico'];
            $sheet->setCellValue('T' . $i, $tecnico_cadena);

            //1er Ficha Tecnica
            $q_soporte_sucursales = mysqli_query($MySQLi, "SELECT * FROM `soporte_sucursales` WHERE `idSoporte`='$idSoporte' AND estado=3");
            $d_soporte_sucursales = mysqli_fetch_assoc($q_soporte_sucursales);
            $clave_soporte = $d_soporte_sucursales['clave_soporte'];
            //2do Equipos Registrados
            $q_soporte_claves = mysqli_query($MySQLi, "SELECT * FROM `soporte_claves` WHERE `clave`='$clave_soporte' AND estado=3");
            $num_fila_equipos = 1;
            while ($d_soporte_claves = mysqli_fetch_assoc($q_soporte_claves)) {
                $num_fila_equipos = ($num_fila_equipos == 1) ? 0 : $i++;
                $fila_inicial_2 = $i;
                //D
                $notaEntrega = $d_soporte_claves['notaEntrega'];
                $sheet->setCellValue('D' . $i, $notaEntrega);
                //F
                $garantia_vigente_repuesto = $d_soporte_claves['garantia_vigente_repuesto'];
                $garantia_vigente_mano = $d_soporte_claves['garantia_vigente_mano'];
                $garantia_ambos = strtoupper($garantia_vigente_repuesto . ' , ' . $garantia_vigente_mano);
                $sheet->setCellValue('F' . $i, $garantia_ambos);
                //H
                $equipo = $d_soporte_claves['equipo'];
                $marca = $d_soporte_claves['marca'];
                $modelo = $d_soporte_claves['modelo'];
                $maquina_nombre = $equipo . ' ' . $marca . ' ' . $modelo;
                $sheet->setCellValue('H' . $i, $maquina_nombre);
                //P
                $costo = $d_soporte_claves['costo'];
                $sheet->setCellValue('P' . $i, $costo);
                //Q
                $costoAdicional = $d_soporte_claves['costoAdicional'];
                $sheet->setCellValue('Q' . $i, $costoAdicional);
                //U
                $problema = $d_soporte_claves['problema'];
                $realizar = $d_soporte_claves['realizar'];
                $trabajoRealizado = $d_soporte_claves['trabajoRealizado'];
                $descripcion_reparacion = 'Problema: ' . $problema . ' Realizar: ' . $realizar . ' Trabajo Adicional: ' . $trabajoRealizado;
                $sheet->setCellValue('U' . $i, $descripcion_reparacion);

                //3ro Repuestos usados en cada equipo
                $idClave = $d_soporte_claves['idClave'];
                $q_soporte_claves_repuestos = mysqli_query($MySQLi, "SELECT * FROM `soporte_claves_repuestos` WHERE `idClave`='$idClave'");
                $num_fila_repuestos = 1;
                while ($d_soporte_claves_repuestos = mysqli_fetch_assoc($q_soporte_claves_repuestos)) {
                    $num_fila_repuestos = ($num_fila_repuestos == 1) ? 0 : $i++;
                    //I
                    $tipo_repuesto = $d_soporte_claves_repuestos['tipo_repuesto'];
                    $nombre_repuesto = $d_soporte_claves_repuestos['nombre_repuesto'];
                    switch ($tipo_repuesto) {
                        case "repuesto_sistema":
                            break;
                        case "insumo_externo":
                            $nombre_repuesto = 'Insumo Externo: ' . $nombre_repuesto;
                            break;
                        case "servicio_externo":
                            $nombre_repuesto = 'Servicio Externo: ' . $nombre_repuesto;
                            break;
                        case "otros_gastos":
                            $nombre_repuesto = 'Otros Gastos: ' . $nombre_repuesto;
                            break;
                    }
                    $sheet->setCellValue('I' . $i, $nombre_repuesto);
                    //J
                    $precioVenta = $d_soporte_claves_repuestos['precioVenta'];
                    ($tipo_repuesto == 'repuesto_sistema') ? $sheet->setCellValue('J' . $i, $precioVenta) : null;
                    //K
                    $cantidad = $d_soporte_claves_repuestos['cantidad'];
                    ($tipo_repuesto == 'repuesto_sistema') ? $sheet->setCellValue('K' . $i, $cantidad) : null;
                    //L
                    $precioEspecial = $d_soporte_claves_repuestos['precioEspecial'];
                    ($tipo_repuesto == 'repuesto_sistema') ? $sheet->setCellValue('L' . $i, $precioEspecial) : null;
                    //M
                    ($tipo_repuesto == 'insumo_externo') ? $sheet->setCellValue('M' . $i, $precioEspecial) : null;
                    //N
                    ($tipo_repuesto == 'servicio_externo') ? $sheet->setCellValue('N' . $i, $precioEspecial) : null;
                    //O
                    ($tipo_repuesto == 'otros_gastos') ? $sheet->setCellValue('O' . $i, $precioEspecial) : null;
                }
                // estilo_vertical('H' . $i, $sheet);
                $worksheet = $spreadsheet->getActiveSheet();
                $worksheet->mergeCells('D' . $fila_inicial_2 . ':D' . $i . '');
                $worksheet->mergeCells('F' . $fila_inicial_2 . ':F' . $i . '');
                $worksheet->mergeCells('H' . $fila_inicial_2 . ':H' . $i . '');
                $worksheet->mergeCells('P' . $fila_inicial_2 . ':P' . $i . '');
                $worksheet->mergeCells('Q' . $fila_inicial_2 . ':Q' . $i . '');
                $worksheet->mergeCells('U' . $fila_inicial_2 . ':U' . $i . '');
                $style = ['alignment' => ['vertical' => Alignment::VERTICAL_CENTER]];
                $sheet->getStyle('D' . $fila_inicial)->applyFromArray($style);
                $sheet->getStyle('F' . $fila_inicial)->applyFromArray($style);
                $sheet->getStyle('H' . $fila_inicial)->applyFromArray($style);
                $sheet->getStyle('P' . $fila_inicial)->applyFromArray($style);
                $sheet->getStyle('Q' . $fila_inicial)->applyFromArray($style);
                $sheet->getStyle('U' . $fila_inicial)->applyFromArray($style);
            } //Fin while2 equipos

        } //Termina If

        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->mergeCells('A' . $fila_inicial . ':A' . $i . '');
        $worksheet->mergeCells('B' . $fila_inicial . ':B' . $i . '');
        $worksheet->mergeCells('C' . $fila_inicial . ':C' . $i . '');
        $worksheet->mergeCells('E' . $fila_inicial . ':E' . $i . '');
        $worksheet->mergeCells('G' . $fila_inicial . ':G' . $i . '');
        $worksheet->mergeCells('R' . $fila_inicial . ':R' . $i . '');
        $worksheet->mergeCells('S' . $fila_inicial . ':S' . $i . '');
        $worksheet->mergeCells('T' . $fila_inicial . ':T' . $i . '');
        // Aplicar alineación vertical centrada a la celda
        $style = ['alignment' => ['vertical' => Alignment::VERTICAL_CENTER]];
        $sheet->getStyle('A' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('B' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('C' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('E' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('G' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('R' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('S' . $fila_inicial)->applyFromArray($style);
        $sheet->getStyle('T' . $fila_inicial)->applyFromArray($style);
    } //Fin while1 ficha tecnica Y ventas directas
}
