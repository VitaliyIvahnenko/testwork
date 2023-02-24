$(document).ready(function(){
  var page = 1;
  var records_per_page = 10;

  // Загрузка данных при открытии страницы
  load_data(page, records_per_page);

  // Обработка изменения поля ввода
  $('input, select').on('input', function(){
    load_data(page, records_per_page);
  });

  function load_data(page, records_per_page){
    var region = $('#region').val();
    var city = $('#city').val();
    var brand = $('#brand').val();
    var model = $('#model').val();
    var engine = $('#engine').val();
    var mileage = $('#mileage').val();
    var owners = $('#owners').val();

    $.ajax({
      url: "get_ads.php",
      method: "GET",
      data: {
        page: page,
        records_per_page: records_per_page,
        brand: brand,
        region: region,
        city: city,
        model: model,
        engine: engine,
        mileage: mileage,
        owners: owners
      },
      dataType: "json",
      success: function(data){
        if(data.ads.length > 0){
          var html = '';
          $.each(data.ads, function(index, ad){
            html += '<div class="col-md-4">';
            html += '<div class="card mb-4 box-shadow">';
            if(ad.image != null){
              html += '<img class="card-img-top" src="'+ad.image+'" alt="Card image cap">';
            } else {
              html += '<img class="card-img-top" src="no-image.png" alt="Card image cap">';
            }
            html += '<div class="card-body">';
            html += '<h5 class="card-title">'+ad.brand+' '+ad.model+'</h5>';
            html += '<p class="card-text">Пробег: '+ad.mileage+' км</p>';
            html += '<p class="card-text">Объем двигателя: '+ad.engine+' л</p>';
            html += '<p class="card-text">Область: '+ad.region+'</p>';
            html += '<p class="card-text">Город: '+ad.city+'</p>';
            html += '<p class="card-text">Количество владельцев: '+ad.owners+'</p>';
            html += '</div>';
            html += '<div class="card-footer">';
            html += '<small class="text-muted">Опубликовано: '+ad.created_at+'</small>';
            html += '</div>';
            html += '</div>';
            html += '</div>';
          });
          $('#ads-list').html(html);

          // Отображение пагинации
          var total_pages = data.total_pages;
          var pagination_html = '';
          if(total_pages > 1){
            pagination_html += '<ul class="pagination">';
            for(var i = 1; i <= total_pages; i++){
              if(i == page){
                pagination_html += '<li class="page-item active"><a class="page-link" href="#">'+i+'</a></li>';
              } else {
                pagination_html += '<li class="page-item"><a class="page-link" href="#">'+i+'</a></li>';
              }
            }
            pagination_html += '</ul>';
          }
          $('#pagination').html(pagination_html);
        } else {
          $('#ads-list').html('<p>No ads found</p>');
        }
      },
      error: function(jqXHR, textStatus, errorThrown){
        console.log(textStatus, errorThrown);
      }
    });
  }

  // Обработка клика на страницу
  $(document).on('click', '.pagination li a', function(event){
    event.preventDefault();
    if(!$(this).parent().hasClass('active') && !$(this).parent().hasClass('disabled')){
      var page_num = $(this).text();
      load_data(page_num, records_per_page);
    }
  });
});
