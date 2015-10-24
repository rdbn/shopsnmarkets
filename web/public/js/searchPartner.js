var SearchParnters = {
    getElement : function() {
        return {
            'SearchPartners[keywords]' : $('#SearchPartners_keywords').val(),
            'SearchPartners[country]' : $('#SearchPartners_country').val(),
            'SearchPartners[city]' : $('#SearchPartners_city').val(),
            'SearchPartners[_token]' : $('#SearchPartners__token').val()
        };
    },
    getQuery : function() {
        $('#resualtSearch').css('opacity', '1');
        $('#resualtSearch').animate({'opacity' : '0'}, 200, function() {
            $('#load').css({'display' : 'block', 'opacity' : '1'});
            $('#load').animate({'opacity' : '1'}, 200);
        });
        
        $.post("/manager/resualtSearch", SearchParnters.getElement(), function(data){
            if (data !== '') {
                var html = '';
                
                for (var value in data) {
                    html += '<div class="resultShop"><a href="/'+data[value]['unique_name']+'">';
                    html += '<img src="/media/cache/logo_shop/'+data[value]['path']+'" /></a>';
                    html += '<ul class="infShop"><li><a href="/'+data[value]['unique_name']+'">'+data[value]['shopname']+'</a></li>';
                    html += '<li><p>Подписчиков: '+data[value]['users']+'</p></li><li><p>Рейтинг: '+data[value]['rating']+'</p></li>';
                    html += '<li><p>Понравилось: '+data[value]['likes']+'</p></li></ul><div class="listPartners">';
                    html += '<a class="addPartners" href="'+data[value]['id']+'">Предложить партнерство';
                    html += '<span class="load"><img src="/public/images/load/ajax-loader-button-second.gif" /></span></a></div></div>';
                }
                
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $('#load').css({'display' : 'none'});
                    $('#resualtSearch').html(html).show();
                    $('#resualtSearch').animate({'opacity' : '1'}, 200);
                });
            } else {
                var html = '<h3>Не чиго не найдено.</h3>';
                
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $('#load').css({'display' : 'none'});
                    $('#resualtSearch').html(html).show();
                    $('#resualtSearch').animate({'opacity' : '1'}, 200);
                });
            }
        }, 'json');
    }
};

$(document).ready(function(){    
    $('#formSearchPartners').submit(function() {
	SearchParnters.getQuery();
        
        return false;
    });
    $('#SearchPartners_city').change(function() {
	SearchParnters.getQuery();
    });
});