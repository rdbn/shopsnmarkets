var SearchPlatform = {
    getElement : function() {
        return {
            'Search[keywords]' : $('#Search_keywords').val(),
            'Search[_token]' : $('#Search__token').val()
        };
    },    
    result : function() {
        $('#resultSearch').css('opacity', '1');
        $('#resualtSearch').animate({'opacity' : 0}, 200, function() {
            $('#resualtSearch').html('').show();
            $('#load').css({'display' : 'block', 'opacity' : 0});
            $('#load').animate({'opacity' : 1}, 200);
        });
        
        $.post('/resultProduct', this.getElement(), function(data) {
            if (data !== '') {
                var html = '';
                
                for (var value in data) {
                    html += '<ul class="products">';
                    html += '<li><a href="/product/'+data[value]['floor']+'/'+data[value]['category']+'/'+data[value]['subcategory'];
                    html += '/'+data[value]['id']+'"><span class="imgHover"></span>';
                    html += '<img src="/media/cache/product_image/'+data[value]['path']+'" alt="'+data[value]['name']+'" /></a></li>';
                    html += '<li><h3>'+data[value]['name']+'</h3></li><li><p>'+data[value]['price']+' руб.</p></li>';
                    html += '</ul>';
                }
                
                $('#load').animate({'opacity' : 0}, 200, function() {
                    $('#load').css('display', 'none');
                    $('#resualtSearch').html(html).show();
                    $('#resualtSearch').animate({'opacity' : 1}, 200);
                });
            } else {
                var html = '<h3>Не чиго не найдено.</h3>';
                
                $('#load').animate({'opacity' : 0}, 200, function() {
                    $('#load').css('display', 'none');
                    $('#result').html(html).show();
                    $('#result').animate({'opacity' : 1}, 200);
                });
            }
        }, 'json');
    }
};

$(document).ready(function() {
    $('#search').submit(function() {
        SearchPlatform.result();
        
        return false;
    });
});