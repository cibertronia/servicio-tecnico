$(document).ready(function() {
    let productos = [];

    $('#idCliente').select2({
        placeholder: 'Seleccione Cliente',
        ajax: {
            url: 'getcli.php',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data
                };
            },
            cache: true
        },
        minimumInputLength: 3
    });    

    $('#idProduct').select2({
        placeholder: 'Seleccione Equipo',
    });

    $("#idCliente").change(function () {
        const idCliente = $(this).val();
        //limpiamos el select de equipos
        const $selectEquipo = $("#idProduct");
        $selectEquipo.empty();
        $selectEquipo.append($("<option disabled selected>Seleccione equipo</option>"));

        if (idCliente !== null) {
            $.ajax({
                url: 'includes/ajax/getDataClientesYuli.php',
                type: 'POST',
                dataType: 'json',
                data: { id: idCliente },
                success: function (data) {
                    $("#nombreCliente").val(data.Nombres + ' ' + data.Apellidos);
                    $("#nombreClienteHidden").val(data.Nombres + ' ' + data.Apellidos);
                    $("#telCliente").val(data.Celular);

                    productos = data.comprados;

                    $selectEquipo.empty();
                    $selectEquipo.append($("<option disabled selected>Seleccione Equipo</option>"));
                    for (let i = 0; i < data.comprados.length; i++) {

                        $selectEquipo.append($("<option>", {
                            value: data.comprados[i].idVenta,
                            text: data.comprados[i].Producto + ' ' + data.comprados[i].Marca + ' ' + data.comprados[i].Modelo
                        }));
                    }

                }
            })
        }
    });

    $("#idProduct").change(function () {
        const idVenta = $(this).val();

        const producto = productos.find(p => p.idVenta == idVenta);

        if (producto) {
            $("#nombreEquipo").val(producto.Producto);
            $("#nombreEquipoHidden").val(producto.Producto);
            $("#marcaEquipo").val(producto.Marca);
            $("#modeloEquipo").val(producto.Modelo);
            $("#fechaVenta").val(producto.FechaVenta);
        } else {
            $("#nombreEquipo").val('');
            $("#marcaEquipo").val('');
            $("#modeloEquipo").val('');
            $("#fechaVenta").val('');
        }
    });

    $('#capacitacionForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                        confirmButtonText: 'OK',
                        timer: 3000,
                        timerProgressBar: true,
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result)=>{
                        if (result.isConfirmed) {
                            window.location.href = '?root=capacitacion/misCapacitaciones';
                        }
                    })

                    setTimeout(function() {
                        window.location.href = '?root=capacitacion/misCapacitaciones';
                    }, 3000);

                    cleanForm();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message,
                        confirmButtonText: 'OK'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.',
                    confirmButtonText: 'OK'
                });
            }
        });
    });

});

function cleanForm(){
    $('form')[0].reset();
    $('#idCliente').val(null).trigger('change');
    $('#idProduct').val(null).trigger('change');
    $("#marcaEquipo").val('');
    $("#modeloEquipo").val('');
    $("#serieEquipo").val('');
    $("#fechaVenta").val('');
    $("#nombreEquipo").val('');
    $("#nombreEquipoHidden").val('');
    $("#nombreCliente").val('');
    $("#nombreClienteHidden").val('');
    $("#telCliente").val('');
}