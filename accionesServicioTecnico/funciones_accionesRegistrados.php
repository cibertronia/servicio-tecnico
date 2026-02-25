<?php
//funciones
//01 listar repuestos para el equipo
function listarRepuestosEquipo_idClave($MySQLi, $idClave)
{
    ?>
<table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
    <thead>
        <tr>
            <th class="text-center">Nombre Repuesto</th>
            <th class="text-center">Precio En Sistema/Unidad</th>
            <th class="text-center">Precio Especial/Unidad</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Total Costo</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody><?php
$Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='repuesto_sistema'");
    $query_precio_dolar = mysqli_query($MySQLi, "SELECT precio FROM preciodolar");
    $dataPrecio = mysqli_fetch_assoc($query_precio_dolar);
    $precioDolar = $dataPrecio['precio'];
    $resultServ = mysqli_num_rows($Q_Service);
    if ($resultServ > 0) {
        while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) {?>
        <tr>
            <td><?=$dataRegistros['nombre_repuesto']?></td>
            <td><?=$dataRegistros['precioVenta'] * $precioDolar ?></td>
            <td><?=$dataRegistros['precioEspecial']?></td>
            <td><?=$dataRegistros['cantidad']?></td>
            <td>
                <?php $totalCosto = $dataRegistros['precioEspecial'] * $dataRegistros['cantidad'];
            echo $totalCosto;
            ?>
            </td>

            <td class="text-center">
                <button id="<?=$dataRegistros['idClaveRepuesto']?>"
                    class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed removerRepuestoDelDiagnostico"
                    data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>"
                    data-toggle="tooltip" title="Remover Repuesto De La Lista <?=$dataRegistros['idClaveRepuesto']?>"
                    data-original-title="">
                    <i class="ni ni-ban"></i>
                </button>
            </td>
        </tr>
        <?php }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="6">"NO SE UTILIZO REPUESTOS PROVENIENTES DEL SISTEMA"</td>

        </tr>
        <?php
}

    ?>
    </tbody>
</table>
<?php
}
//02 listar InsumosExternos para el equipo
function listarInsumosExternosEquipo_idClave($MySQLi, $idClave)
{
    ?>
<table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
    <thead>
        <tr>
            <th class="text-center">Nombre Repuesto</th>
            <th class="text-center">Precio/Unidad</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Total Costo</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody><?php
$Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='insumo_externo'");
    $resultServ = mysqli_num_rows($Q_Service);
    if ($resultServ > 0) {
        while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) {?>
        <tr>
            <td><?=$dataRegistros['nombre_repuesto']?></td>
            <td><?=$dataRegistros['precioEspecial']?></td>
            <td><?=$dataRegistros['cantidad']?></td>
            <td>
                <?php $totalCosto = $dataRegistros['precioEspecial'] * $dataRegistros['cantidad'];
            echo $totalCosto;
            ?>
            </td>

            <td class="text-center">
                <button id="<?=$dataRegistros['idClaveRepuesto']?>"
                    class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed removerInsumoDelDiagnostico"
                    data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>"
                    data-toggle="tooltip" title="Remover Repuesto De La Lista <?=$dataRegistros['idClaveRepuesto']?>"
                    data-original-title="">
                    <i class="ni ni-ban"></i>
                </button>
            </td>
        </tr>
        <?php }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="8">"NO SE UTILIZO INSUMOS EXTERNOS"</td>
        </tr>
        <?php
}
    ?>
    </tbody>
</table>
<?php
}
function mostrarCostoDiagnosticoEquipo($MySQLi, $idClave)
{
    ?>
<table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
    <thead>
        <tr>
            <th class="text-center">Trabajo a Realizar</th>
            <th class="text-center">Costo</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody><?php
$Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves WHERE idClave='$idClave'");
    $resultServ = mysqli_num_rows($Q_Service);
    if ($resultServ > 0) {
        while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) {?>
        <tr>
            <td><?=$dataRegistros['realizar']?></td>
            <td><?=$dataRegistros['costo']?></td>
            <td class="text-center">
                <button id="<?=$dataRegistros['idClave']?>"
                    class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed removerCostoDelDiagnostico_victor"
                    data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>"
                    data-toggle="tooltip" title="Remover costo mano de obra <?php //$dataRegistros['idClave']?>"
                    data-original-title="">
                    <i class="ni ni-ban"></i>
                </button>
            </td>
        </tr>
        <?php }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="2">"ERROR"</td>
        </tr>
        <?php
}
    ?>
    </tbody>
</table>
<?php
}

//04 listar ServiciosExternos para el equipo
function listarServiciosExternosEquipo_idClave($MySQLi, $idClave)
{
    ?>
<table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
    <thead>
        <tr>
            <th class="text-center">Nombre Repuesto</th>
            <th class="text-center">Precio/Unidad</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Total Costo</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody><?php
$Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='servicio_externo'");
    $resultServ = mysqli_num_rows($Q_Service);
    if ($resultServ > 0) {
        while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) {?>
        <tr>
            <td><?=$dataRegistros['nombre_repuesto']?></td>
            <td><?=$dataRegistros['precioEspecial']?></td>
            <td><?=$dataRegistros['cantidad']?></td>
            <td>
                <?php $totalCosto = $dataRegistros['precioEspecial'] * $dataRegistros['cantidad'];
            echo $totalCosto;
            ?>
            </td>
            
            <td class="text-center">
                <button id="<?=$dataRegistros['idClaveRepuesto']?>"
                    class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed removerServicioExternoDelDiagnostico"
                    data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>"
                    data-toggle="tooltip" title="Remover Repuesto De La Lista <?=$dataRegistros['idClaveRepuesto']?>"
                    data-original-title="">
                    <i class="ni ni-ban"></i>
                </button>
            </td>
        </tr>
        <?php }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="8">"NO SE UTILIZO SERVICIOS EXTERNOS"</td>
        </tr>
        <?php
}
    ?>
    </tbody>
</table>
<?php
}

//05 listar OtrosGastos para el equipo
function listarOtrosGastos($MySQLi, $idClave)
{
    ?>
<table id="data-table" class="table table-striped table-bordered table-td-valign-middle w-100">
    <thead>
        <tr>
            <th class="text-center">Nombre</th>
            <th class="text-center">Precio/Unidad</th>
            <th class="text-center">Cantidad</th>
            <th class="text-center">Total Costo</th>
            <th class="text-center">Acciones</th>
        </tr>
    </thead>
    <tbody><?php
$Q_Service = mysqli_query($MySQLi, "SELECT * FROM soporte_claves_repuestos WHERE idClave='$idClave' AND tipo_repuesto='otros_gastos'");
    $resultServ = mysqli_num_rows($Q_Service);
    if ($resultServ > 0) {
        while ($dataRegistros = mysqli_fetch_assoc($Q_Service)) {?>
        <tr>
            <td><?=$dataRegistros['nombre_repuesto']?></td>
            <td><?=$dataRegistros['precioEspecial']?></td>
            <td><?=$dataRegistros['cantidad']?></td>
            <td>
                <?php $totalCosto = $dataRegistros['precioEspecial'] * $dataRegistros['cantidad'];
            echo $totalCosto;
            ?>
            </td>
            
            <td class="text-center">
                <button id="<?=$dataRegistros['idClaveRepuesto']?>"
                    class="btn btn-danger btn-xs btn-icon rounded-circle waves-effect waves-themed removerOtrosGastosDelDiagnostico"
                    data-template="<div class=&quot;tooltip&quot; role=&quot;tooltip&quot;><div class=&quot;tooltip-inner bg-danger-500&quot;></div></div>"
                    data-toggle="tooltip" title="Remover Repuesto De La Lista <?=$dataRegistros['idClaveRepuesto']?>"
                    data-original-title="">
                    <i class="ni ni-ban"></i>
                </button>
            </td>
        </tr>
        <?php }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="8">"NO SE UTILIZO OTROS GASTOS"</td>
        </tr>
        <?php
}
    ?>
    </tbody>
</table>
<?php
}