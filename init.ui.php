<?php
$_theme = APP_THEME;
if (isset($idRangoDf)) {
    // Nuevo menú para Capacitaciones
    $capacitaciones = [
        'title' => 'Capacitaciones',
        'icon' => 'fal fa-chalkboard-teacher',
        'items' =>[
            'agregar' => [
                'title' => 'Agregar',
                'url' => APP_URL . '/?root=capacitacion/agregar',
                'icon' => 'fal fa-plus-circle',
            ],
            'MisCapacitaciones' => [
                'title' => 'Mis Capacitaciones',
                'url' => APP_URL . '/?root=capacitacion/misCapacitaciones',
                'icon' => 'fal fa-chalkboard',
            ],
        ]
    ];

    if ($idRangoDf == 1 || $idRangoDf == 4) {
        // Construir items de Servicio Técnico dinámicamente
        $servicioTecnicoItems = [];

        if ($idRangoDf == 1) {
            $servicioTecnicoItems['regReparacion'] = [
                'title' => 'Recepcion',
                'url' => APP_URL . '/?root=registrarServicio',
            ];
        }

        $_nav = [
            'Dashboard' => [
                'title' => 'Inicio',
                'icon' => 'fal fa-home',
                'url' => '/',
            ],
            'misClientes' => [
                'title' => 'Mis Clientes',
                'icon' => 'fal fa-users',
                'url' => APP_URL . '/?root=misClientes',
            ],
            $capacitaciones,
            'productos_fiscales' => [
                'title' => 'Productos Fiscales',
                'icon' => 'fa fa-archive',
                'url' => APP_URL . '/?root=productosFiscales',
            ],
            'SERVICOTECNICO' => [
                'title' => 'Servicio Técnico',
                'icon' => 'fal fa-construction',
                'items' => array_merge($servicioTecnicoItems, [
                    'registrados' => [
                        'title' => 'Diagnostico',
                        'url' => APP_URL . '/?root=registrados',
                    ],
                    'enreparacion' => [
                        'title' => 'En reparación',
                        'url' => APP_URL . '/?root=enReparacion',
                    ],
                    'equiposListos' => [
                        'title' => 'Reparados',
                        'url' => APP_URL . '/?root=reparados',
                    ],
                    'entregados' => [
                        'title' => 'Entregados',
                        'url' => APP_URL . '/?root=entregados',
                    ],
                    'cancelados' => [
                        'title' => 'Cancelados',
                        'url' => APP_URL . '/?root=cancelados',
                    ],
                ]),
            ],
            'Productos' => [
                'title' => 'Repuestos',
                'icon' => 'far fa-barcode',
                'items' => [
                    'AddProducto' => [
                        'title' => 'Agregar',
                        'icon' => 'far fa-cloud-upload',
                        'url' => APP_URL . '/?root=agregarProducto',
                    ],
                    'ListaProductos' => [
                        'title' => 'Lista repuestos',
                        'icon' => 'far fa-list-ol',
                        'url' => APP_URL . '/?root=productos',
                    ],
                    'historial_productos' => [
                        'title' => 'Historial Lista',
                        'icon' => 'far fa-calendar',
                        'url' => APP_URL . '/?root=productosHistorial',
                    ],
                ],
            ],
            'Envios' => [
                'title' => 'Envios Repuestos',
                'icon' => 'fa fa-paper-plane',
                'items' => [
                    'Enviar' => [
                        'title' => 'Enviar',
                        'icon' => 'fa fa-paper-plane',
                        'url' => APP_URL . '/?root=enviar_repuestos',
                    ],
                    'Lista_envios' => [
                        'title' => 'Lista Envios',
                        'icon' => 'far fa-list-ol',
                        'url' => APP_URL . '/?root=envios_lista',
                    ],
                    'Recibir' => [
                        'title' => 'Recibir Repuestos',
                        'icon' => 'fa fa-truck',
                        'url' => APP_URL . '/?root=envios_recibir',
                    ],

                ],
            ],
            'Cotizaciones' => [
                'title' => 'Cotizar Repuesto',
                'icon' => 'fal fa-folder-open',
                'items' => [
                    'GenerarCoti' => [
                        'title' => 'Generar',
                        'url' => APP_URL . '/?root=generar',
                    ],
                    'Generadas' => [
                        'title' => 'Generadas',
                        'url' => APP_URL . '/?root=generadas',
                    ],
                    'Entregadas' => [
                        'title' => 'Entregadas',
                        'url' => APP_URL . '/?root=entregadas',
                    ],
                    'Vendidas' => [
                        'title' => 'Vendidas',
                        'url' => APP_URL . '/?root=vendidas',
                    ],
                    /*'Vencidas'        =>    [
                'title'            =>    'Vencidas',
                'url'                =>    APP_URL.'/?root=vencidas'
                ],*/
                ],
            ],
            'facturacion' => [
                'title' => 'Facturación',
                'icon' => 'fas fa-file-invoice',
                'items' => [
                    'listado' => [
                        'title' => 'Lista Facturas',
                        'icon' => 'fa fa-list',
                        'url' => APP_URL . '/?root=facturacion_listado',
                    ],
                    'facturacion_directa' => [
                        'title' => 'Emisión Directa',
                        'icon' => 'fa fa-print',
                        'url' => APP_URL . '/?root=facturacion_directa',
                    ],
                ],
            ],
            'misVentasSoporte' => [
                'title' => 'Mis Ventas',
                'icon' => 'fal fa-sack-dollar',
                'url' => APP_URL . '/?root=misVentasSoporte',
            ],
            'reporteVentas' => [
                'title' => 'Mis servicios',
                'icon' => 'fal fa-chart-line',
                'url' => APP_URL . '/?root=reporteVentasSoporteTecnico',
            ],
            'miPerfil' => [
                'title' => 'Mi Perfil',
                'icon' => 'fal fa-file-image',
                'url' => APP_URL . '/?root=miPerfil',
            ],
        ];
    } elseif ($idRangoDf == 2 || $idRangoDf == 3) {
        // Agregar item de lista de capacitaciones para rangos 2 y 3
        $capacitaciones['items']['lista'] = [
            'title' => 'Lista',
            'url' => APP_URL . '/?root=capacitacion/lista',
            'icon' => 'fal fa-list',
        ];
        $_nav = [
            'Dashboard' => [
                'title' => 'Inicio',
                'icon' => 'fal fa-home',
                'url' => '/',
            ],
            'misClientes' => [
                'title' => 'Mis Clientes',
                'icon' => 'fal fa-users',
                'url' => APP_URL . '/?root=misClientes',
            ],
            $capacitaciones,
            'productos_fiscales' => [
                'title' => 'Productos Fiscales',
                'icon' => 'fa fa-archive',
                'url' => APP_URL . '/?root=productosFiscales',
            ],
            'SERVICOTECNICO' => [
                'title' => 'Servicio Técnico',
                'icon' => 'fal fa-construction',
                'items' => [
                    'regReparacion' => [
                        'title' => 'Recepcion',
                        'url' => APP_URL . '/?root=registrarServicio',
                    ],
                    'registrados' => [
                        'title' => 'Diagnostico',
                        'url' => APP_URL . '/?root=registrados',
                    ],
                    'enreparacion' => [
                        'title' => 'En reparación',
                        'url' => APP_URL . '/?root=enReparacion',
                    ],
                    'equiposListos' => [
                        'title' => 'Reparados',
                        'url' => APP_URL . '/?root=reparados',
                    ],
                    'entregados' => [
                        'title' => 'Entregados',
                        'url' => APP_URL . '/?root=entregados',
                    ],
                    'cancelados' => [
                        'title' => 'Cancelados',
                        'url' => APP_URL . '/?root=cancelados',
                    ],
                ],
            ],
            'Productos' => [
                'title' => 'Repuestos',
                'icon' => 'far fa-barcode',
                'items' => [
                    'AddProducto' => [
                        'title' => 'Agregar',
                        'icon' => 'far fa-cloud-upload',
                        'url' => APP_URL . '/?root=agregarProducto',
                    ],
                    'ListaProductos' => [
                        'title' => 'Lista repuestos',
                        'icon' => 'far fa-list-ol',
                        'url' => APP_URL . '/?root=productos',
                    ],
                    'historial_productos' => [
                        'title' => 'Historial Lista',
                        'icon' => 'far fa-calendar',
                        'url' => APP_URL . '/?root=productosHistorial',
                    ],
                ],
            ],
            'Envios' => [
                'title' => 'Envios Repuestos',
                'icon' => 'fa fa-paper-plane',
                'items' => [
                    'Enviar' => [
                        'title' => 'Enviar',
                        'icon' => 'fa fa-paper-plane',
                        'url' => APP_URL . '/?root=enviar_repuestos',
                    ],
                    'Lista_envios' => [
                        'title' => 'Lista Envios',
                        'icon' => 'far fa-list-ol',
                        'url' => APP_URL . '/?root=envios_lista',
                    ],
                    'Recibir' => [
                        'title' => 'Recibir Repuestos',
                        'icon' => 'fa fa-truck',
                        'url' => APP_URL . '/?root=envios_recibir',
                    ],

                ],
            ],
            'Cotizaciones' => [
                'title' => 'Cotizar Repuesto',
                'icon' => 'fal fa-folder-open',
                'items' => [
                    'GenerarCoti' => [
                        'title' => 'Generar',
                        'url' => APP_URL . '/?root=generar',
                    ],
                    'Generadas' => [
                        'title' => 'Generadas',
                        'url' => APP_URL . '/?root=generadas',
                    ],
                    'Entregadas' => [
                        'title' => 'Entregadas',
                        'url' => APP_URL . '/?root=entregadas',
                    ],
                    'Vendidas' => [
                        'title' => 'Vendidas',
                        'url' => APP_URL . '/?root=vendidas',
                    ],
                    /*'Vencidas'        =>    [
                'title'            =>    'Vencidas',
                'url'                =>    APP_URL.'/?root=vencidas'
                ],*/
                ],
            ],
            'facturacion' => [
                'title' => 'Facturación',
                'icon' => 'fas fa-file-invoice',
                'items' => [
                    'listado' => [
                        'title' => 'Lista Facturas',
                        'icon' => 'fa fa-list',
                        'url' => APP_URL . '/?root=facturacion_listado',
                    ],
                    'facturacion_directa' => [
                        'title' => 'Emisión Directa',
                        'icon' => 'fa fa-print',
                        'url' => APP_URL . '/?root=facturacion_directa',
                    ],
                ],
            ],
            'registros' => [
                'title' => 'Registros Stock',
                'icon' => 'far fa-calendar',
                'items' => [
                    'registro_movimientos' => [
                        'title' => 'Registro Ventas',
                        'icon' => 'far fa-calendar',
                        'url' => APP_URL . '/?root=registroMovimientos',
                    ],
                    'registro_envios' => [
                        'title' => 'Registro Envios',
                        'icon' => 'far fa-truck',
                        'url' => APP_URL . '/?root=registroEnvios',
                    ],
                ],
            ],
            'miPerfil' => [
                'title' => 'Mi Perfil',
                'icon' => 'fal fa-file-image',
                'url' => APP_URL . '/?root=miPerfil',
            ],
            'Administracion' => [
                'title' => 'Administración',
                'icon' => 'fal fa-cog',
                'items' => [
                    'Usuarios' => [
                        'title' => 'Lista usuarios',
                        'icon' => 'fal fa-users',
                        'url' => APP_URL . '/?root=usuarios',
                    ],
                    'Clientes' => [
                        'title' => 'Lista clientes',
                        'icon' => 'fal fa-users-class',
                        'url' => APP_URL . '/?root=clientes',
                    ],
                    'misVentasSoporte' => [
                        'title' => 'Ventas',
                        'icon' => 'fal fa-sack-dollar',
                        'url' => APP_URL . '/?root=misVentasSoporte',
                    ],
                    'reporteVentas' => [
                        'title' => 'Servicios',
                        'icon' => 'fal fa-chart-line',
                        'url' => APP_URL . '/?root=reporteVentasSoporteTecnico',
                    ],                                
                    'facturacion_reportes' => [
                        'title' => 'Reporte Facturas',
                        'icon' => 'fa fa-list-alt',
                        'url' => APP_URL . '/?root=facturacion_reportes',
                    ],
                    // 'Sucursales' => [
                    //     'title' => 'Sucursales',
                    //     'icon' => 'fal fa-car-building',
                    //     'url' => APP_URL . '/?root=sucursales',
                    // ],
                    // 'Proveedores' => [
                    //     'title' => 'Proveedores',
                    //     'icon' => 'fal fa-users-cog',
                    //     'url' => APP_URL . '/?root=proveedores',
                    // ],
                    // 'Categorias' => [
                    //     'title' => 'Categorias',
                    //     'icon' => 'fal fa-users-cog',
                    //     'url' => APP_URL . '/?root=categorias',
                    // ],
                    // 'Servicios' => [
                    //     'title' => 'Servicios',
                    //     'icon' => 'far fa-satellite-dish',
                    //     'url' => APP_URL . '/?root=servicios',
                    // ],
                ],
            ],
        ];
    }
}
