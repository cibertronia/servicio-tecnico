$(document).ready(function() {
    const idUsuario = $('#js-page-content').data('iduser');
    const idRango = $('#js-page-content').data('idrango');    

    // Toggle del buscador
    $('#toggleBuscador').on('click', function() {
        const $buscar = $('#buscar');
        const $icono = $(this).find('i');
        
        if ($buscar.hasClass('d-none')) {
            // Mostrar con animación
            $buscar.removeClass('d-none').hide().slideDown(300);
            $icono.removeClass('fa-search').addClass('fa-times');
            $(this).removeClass('btn-primary').addClass('btn-danger');
        } else {
            // Ocultar con animación
            $buscar.slideUp(300, function() {
                $(this).addClass('d-none');
            });
            $icono.removeClass('fa-times').addClass('fa-search');
            $(this).removeClass('btn-danger').addClass('btn-primary');
        }
    });

    // Definir columnas base
    const columns = [
        { 
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        { data: 'nombreCliente' },
        { data: 'nombreProducto' },
        { data: 'Nombre' },
        { 
            data: 'fecha',
            render: function(data, type, row) {
                const hora = row.hora;
                const date = new Date(data + 'T' + hora);
                const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit', hour12: true };
                return date.toLocaleString('es-ES', options).replace(',', '');
            }
        },
        { data: 'sucursal' },
        { data: 'observaciones' },
        { 
            data: 'created_at',
            render: function(data, type, row) {
                const date = new Date(data);
                const options = { year: 'numeric', month: '2-digit', day: '2-digit'  };
                return date.toLocaleString('es-ES', options).replace(',', '');
            }
        }
    ];

    // Agregar columna de acciones solo si es administrador
    if (idRango == 2) {
        columns.push({
            data: null,
            orderable: false,
            searchable: false,
            render: function(data, type, row) {
                // <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="${row.id}" title="Editar">
                //     <i class="fas fa-edit"></i>
                // </button>
                return `
                    <div class="btn-group btn-group-xs" role="group">
                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="${row.id}" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
            }
        });
    }

    const tableCapacitaciones = $('#table-capacitaciones').DataTable({
        responsive: true,
        processing: true,
        ajax: {
            url: 'includes/ajax/capacitacionController.php',
            type: 'GET',
            data: function(d) {
                // Si idUsuario tiene valor, agregarlo a los datos enviados
                if (idUsuario) {
                    d.idUsuario = idUsuario;
                }
            }
        },
        columns: columns,
        order: [],
    });

    // Event listeners para los botones de acciones (solo si es administrador)
    if (idRango == 2) {
        $('#table-capacitaciones').on('click', '.btn-edit', function() {
            const id = $(this).data('id');
            // Aquí puedes abrir un modal
            $('#modal-edit-capacitacion').modal('show');
        });

        $('#table-capacitaciones').on('click', '.btn-delete', function() {
            
            Swal.fire({
                title: '¿Está seguro de eliminar?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const id = $(this).data('id');
                    
                    eliminar(id);
                }
            });
        });
    }

    $('#buscar').on('submit', function(e) {
        e.preventDefault();
        // obtener los valores filtrados de fechaInicio y fechaFin del formulario para la tabla
        const fechaInicio = $('#fechaInicio').val();
        const fechaFin = $('#fechaFin').val();
        const idUsuario = $('#idUsuario').val();
        const search = $('#search').val();
        
        // Crear objeto URLSearchParams
        const params = new URLSearchParams();
        
        // Agregar parámetros solo si tienen valor
        if (fechaInicio) params.append('fechaInicio', fechaInicio);
        if (fechaFin) params.append('fechaFin', fechaFin);
        if (idUsuario) params.append('idUsuario', idUsuario);
        if (search) params.append('search', search);
        
        // Construir la URL completa
        const url = `includes/ajax/capacitacionController.php?${params.toString()}`;        
        
        // Recargar la tabla con la nueva URL
        tableCapacitaciones.ajax.url(url).load();
    });
});

function eliminar(id) {
    $.ajax({
        url: 'includes/ajax/capacitacionController.php',
        type: 'POST',
        data: { _method: 'DELETE', id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                $('#table-capacitaciones').DataTable().ajax.reload();
                Swal.fire('Eliminado', response.message, 'success');
            } else {
                Swal.fire('Error', response.message, 'error');
            }
        },
        error: function() {
            Swal.fire('Error', 'Ocurrió un error al procesar la solicitud.', 'error');
        }
    });
}
