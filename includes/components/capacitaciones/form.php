<form id="capacitacionForm" action="includes/ajax/capacitacionController.php" method="POST" autocomplete="off">
    <input type="hidden" name="idUsuario" value="<?= $_SESSION['idUser'] ?>">
    <input type="hidden" name="idSucursal" value="<?= $_SESSION['idTienda'] ?>">
    <input type="hidden" name="nombreCliente" id="nombreClienteHidden">
    <input type="hidden" name="nombreEquipo" id="nombreEquipoHidden">

    <div class="row">
        <div class="col-12 col-sm-4 mb-3 mb-sm-0">
            <label for="idCliente">Cliente <span class=" badge badge-warning">requerido</span></label>
            <select name="idCliente" class="form-control" id="idCliente" required>
                <option value="" disabled selected>Seleccione cliente</option>
            </select>
        </div>
        <div class="col col-sm-4 col-md-6">
            <label for="nombreCliente">Nombre</label>
            <input type="text" class="form-control" name="nombreCliente" id="nombreCliente" disabled>
        </div>
        <div class="col col-sm-4 col-md-2">
            <label for="telCliente">Teléfono</label>
            <input type="text" class="form-control" id="telCliente" disabled>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 col-sm-4 mb-3 mb-sm-0">
            <label for="idProduct">Equipos <span class=" badge badge-warning">requerido</span></label>
            <select name="idProducto" id="idProduct" class="form-control" required>
                <option value="" disabled selected>Seleccione equipo</option>
            </select>
        </div>
        <div class="col col-sm-8 col-md-8">
            <label for="nombreEquipo">Equipo</label>
            <input type="text" class="form-control" name="nombreEquipo" id="nombreEquipo" disabled>
        </div>
       
    </div>
    <div class="row mt-3">
        <div class="col col-sm-4">
            <label for="marcaEquipo">Marca</label>
            <input type="text" class="form-control" id="marcaEquipo" disabled>
        </div>
        <div class="col col-sm-4">
            <label for="modeloEquipo">Modelo</label>
            <input type="text" class="form-control" id="modeloEquipo" disabled>
        </div> 
        <div class="col col-sm-4">
            <label for="fechaVenta">Fecha de Venta</label>
            <input type="text" class="form-control" id="fechaVenta" disabled>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col col-sm-3">
            <label for="fechaCapacitacion">Fecha <span class="badge badge-warning">requerido</span></label>
            <input type="date" class="form-control" name="fecha" id="fechaCapacitacion" min="<?= date('Y-m-d'); ?>" required>
        </div>
        <div class="col col-sm-2">
            <label for="horaCapacitacion">Hora <span class="badge badge-warning">requerido</span></label>
            <input type="time" class="form-control" name="hora" id="horaCapacitacion" step="900" required>
        </div>
        <div class="col col-sm-7">
            <label for="nota">Observaciones</label>
            <textarea name="nota" class="form-control" rows="2" id="nota"></textarea>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col align-content-center">
            <button class="btn btn-primary btn-block" type="submit">Guardar</button>
        </div>
    </div>
</form>

<script src="<?= APP_URL ?>/assets/js/capacitacion/create.js"></script>