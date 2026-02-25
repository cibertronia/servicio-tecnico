$(document).ready(function () {  
  $(document).on('click', '#combos_start', function(event) {
    $('.primeraLinea').addClass('d-none');
    $('.primeraLinea').before('<div class="row combos">'+
      '<div class="col">'+
        '<div class="d-flex justify-content-around">'+
          '<button class="btn btn-primary">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Regresar</label>'+
          '</button>'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 1</label>'+
          '</button>'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 2</label>'+
          '</button>'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 3</label>'+
          '</button>'+
        '</div>'+
      '</div></div>'+
    '<div class="row mt-3">'+
      '<div class="col">'+
        '<div class="d-flex justify-content-around">'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 4</label>'+
          '</button>'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 5</label>'+
          '</button>'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 6</label>'+
          '</button>'+
          '<button class="btn btn-default">'+
            '<i class="fal fa-burger-soda fa-3x"></i><br>'+
            '<label for="" class="my-2">Combo 7</label>'+
          '</button>'+
        '</div>'+
      '</div>'+
    '</div>');
    event.preventDefault();
  });
  $(document).on('click', '.callCotiza', function(event) {
    let idCotiza = Math.floor(Math.random() * 1000) + 1;
    $(".callCotiza").addClass('d-none');
    $(".spinnerCallCotiza").removeClass('d-none');
    $.ajax({
      url: 'includes/consultas.php',
      type: 'POST',
      dataType: 'html',
      data: {idCotiza},
      success:function(data){
        $(".callCotiza").removeClass('d-none');
        $(".spinnerCallCotiza").addClass('d-none');
        $("#contenidoHTML").html(data);
        $('.download').removeClass('d-none');
      }
    })
    event.preventDefault();
  });
});