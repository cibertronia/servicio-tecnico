el sistema base cuenta con:

/*	POR DEFAULT  */ $300 por ejemplo
1) tabla usuarios
	1.1) Rangos: usuario y admin
	1.2) Nombre, sexo, correo, telefono, cargo, avatar
	1.3) Registrar nuevo usuario
	1.4) editar usuario

2) tabla clientes
	2.1) Nombre, correo, empresa, telEmpresa, ext, celular, dirección, comentarios, ciudad
	2.2) Registrar nuevo cliente
	2.3) editar cliente

3) ciudades (para identificar la ciudad del cliente)

/*	OPCIONALES O POR PETICION	*/
4) sucursales o tiendas
	4.1) nombre de la sucursal, código sucursal
5) doble moneda (USD/Bs)
6) tabla categorias
	6.1) nombre de la categoria
7) tabla proveedores
	7.1) nombre del proveedor, telEmpresa, ext, encargado, celular
/* OPCIONALES IMPORTANTES */
8) tabla productos
	8.1) nombre del producto, marca,modelo, industria, precio, imagen, descripción
	8.2) Agregar nuevo producto
	8.3) editar el producto
9) tabla inventarios
	9.1) id del producto, *id del la tienda*, cantidad(stock), **precio (por si los precios son diferenciados)
	** solo si el cliente lo solicita
10) tabla cotizaciones
	10.1) generar una cotización
		10.1.1) preguntar si cliente existente o nuevo cliente
	10.2) opcion de solo generar o de generar y entregar la cotización
	10.3) tabla cotizaciones generadas o entregadas (segun lo decida el cliente)
	10.4) tabla cotizaciones vendidas o compradas
	10.5) tabla cotizaciones ventas al crédito
		10.5.1) *********************************
	10.6) tabla cotizaciones ventas por anticipo
		10.6.1) *********************************
	10.7) tabla cotizaciones vencidas /**

** VENCIDAS ** 
	// PASAR LAS VENCIADAS A SU TABLA SEGUN FECHA DE CADUCIDAD EN:
	1) VALIDEZ DE LA COTIZACION
	2) DESPUES DE 3 MESES //
	DESPUES DE 90 DIAS, LAS COTIZACIONES CAMBIARAN SU ESTADO A VENCIDAS
	EN VENCIDAS, COLOCAR LA OPCION DE RESTABLECER LA COTIZACION POR 10 DÍAS.