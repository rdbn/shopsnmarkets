var SearchPartners = {
    getElement : function() {
        return {
            'Search[keywords]' : $('#Search_keywords').val(),
            'Search[country]' : $('#Search_country').val(),
            'Search[city]' : $('#Search_city').val(),
            'Search[_token]' : $('#Search__token').val()
        };
    },
    getQuery : function() {
        var element = $('#result-search');
        element.css('opacity', '1');
        element.animate({'opacity' : '0'}, 200);
        
        $.post("/app_dev.php/partners/result", SearchPartners.getElement(), function(data) {
            var html = '';
            if (data !== '') {
                for (var value in data) {
                    html += '<div class="resultShop"><a href="/'+data[value]['uniqueName']+'">';
                    html += '<img src="/media/cache/logo_shop/'+data[value]['path']+'" /></a>';
                    html += '<ul class="infShop"><li><a href="/'+data[value]['uniqueName']+'">'+data[value]['shopname']+'</a></li>';
                    html += '<li><p>Подписчиков: '+data[value]['users']+'</p></li><li><p>Рейтинг: '+data[value]['rating']+'</p></li>';
                    html += '<li><p>Понравилось: '+data[value]['likes']+'</p></li></ul><div class="listPartners">';
                    html += '<a class="addPartners" href="'+data[value]['id']+'">Предложить партнерство';
                    html += '<span class="load"><img src="/public/images/load/ajax-loader-button-second.gif" /></span></a></div></div>';
                }


                element.html(html).show();
                element.animate({'opacity' : '1'}, 200);
            } else {
                html = '<h3>Не чиго не найдено.</h3>';

                element.html(html).show();
                element.animate({'opacity' : '1'}, 200);
            }
        }, 'json');
    }
};

$(document).ready(function() {
    $('#search').click(function() {
        SearchPartners.getQuery();
        
        return false;
    });

    $('#Search_city').change(function() {
        SearchPartners.getQuery();
    });
});