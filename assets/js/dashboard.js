$(function() {
	const hayBusqueda = $('#js-page-content').data('hassearch');
	
    // Si hay búsqueda activa, mostrar el formulario y cambiar el botón
    if (hayBusqueda) {
        $('#buscar').removeClass('d-none');
        $('#toggleBuscador').find('i').removeClass('fa-search').addClass('fa-times');
        $('#toggleBuscador').removeClass('btn-primary').addClass('btn-danger');
    }
    
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

	$.ajax({
		url: 'includes/consultas.php',
		type: 'POST',
		dataType: 'json',
		data: {monedaPrincipal: ''},
		success:function(data){
			$(".simboloMoneda").html(data.simbolo)
		}
	})
	//procesar form #savePrecioDolar
	$('#savePrecioDolar').on('submit', function(event) {
		event.preventDefault();

		let precioDolar = $('#precio').val();

		if(precioDolar == ''){
			alert('Ingrese un precio');
			return false;
		}
		$.ajax({
			url: 'do.php',
			type: 'POST',
			dataType: 'Html',
			data: $(this).serialize(),
			success:function(){
				Swal.fire({
					title: "Exito!",
					text: "Precio del dolar actualizado",
					icon: "success"
				}).then((result)=>{
					location.reload();
				});
			}
		})
	});
});