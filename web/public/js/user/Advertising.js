var PaltformAdvertising = {
    getPreLoad : function() {
        $('#content .contentAdvertising').css({'display' : 'block', 'opacity' : '1'}).animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200);
            $('#load').css({'display' : 'block', 'opacity' : '0'}).animate({'opacity' : '1'}, 200);
        });
    },
    getEndLoad : function(data) {
        if (data !== '0') {
            var html = '';
            for (var value in data) {
                 html += '<div class="advertisings"><ul><li><h3 class="chapter">'+data[value]['shopname']+'</h3></li>';
                 html += '<li><p>Место показа: <span>'+data[value]['name']+'</span></p></li>';
                 html += '<li><p>Время начала показа: <span>с '+data[value]['date_start']['date']+':00.</span></p></li>';
                 html += '<li><p>Время окнчания показа: <span>в '+data[value]['date_end']['date']+':00.</span></p></li></ul>';
                 html += '<ul class="preview"><li><a class="previewImg" href="#">Показать картинку</a></li>';
                 
                 if (data[value]['format'] === '1') {
                     html += '<li><img width="817" src="'+data[value]['path']+'" /></li>';
                 } else {
                     html += '<li><img src="'+data[value]['path']+'" /></li>';
                 }
                 
                 html += '</ul></div>';                
            }
            
            $('#load').animate({'opacity' : '0'}, 200, function() {
                $('#load').css('display', 'none');
                $('#content .contentAdvertising').html(html).slideToggle(200, function() {
                    $(this).animate({'opacity' : '1'}, 200);
                });
            });
        }
    },
    getQuery : function() {
        this.getPreLoad();
        
        $.get('/advertising/platform', function(data) {
            PaltformAdvertising.getEndLoad(data);
        });
    },
    click : function() {
        $('.menuAdvertising .paltform').click(function() {
            PaltformAdvertising.getQuery();
            
            return false;
        });
    }
};
var ShopAdvertising = {
    getPreLoad : function() {
        $('#content .contentAdvertising').css({'display' : 'block', 'opacity' : '1'}).animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200);
            $('#load').css({'display' : 'block', 'opacity' : '0'}).animate({'opacity' : '1'}, 200);
        });
    },
    getEndLoad : function(data) {
        if (data !== '0') {
            var html = '';
            for (var values in data) {
                html += '<div class="advertisings"><h3 class="chapter">'+data[values]['name']+'</h3>';
                html += '<h3 class="chapter">Рекламма на слайдаре</h3>';
                for (var value in data[values]['slider']) {
                    html += '<ul class="preview"><li><a class="previewImg" href="#">Показать картинку</a></li>';
                    html += '<li><a class="deleteImg" href="#">Удалить картинку</a></li>';
                    html += '<li><img width=807 src="/public/xml/Shops/'+data[values]['unique_name']+'/advertising/slider/';
                    html += data[values]['slider'][value]+'" /></li></ul>';
                }
                html += '<h3 class="chapter">Рекламма с боку</h3>';
                for (var value in data[values]['side_of']) {
                    html += '<ul class="preview"><li><a class="previewImg" href="#">Показать картинку</a></li>';
                    html += '<li><a class="deleteImg" href="#">Удалить картинку</a></li>';
                    html += '<li><img width=100 src="/public/xml/Shops/'+data[values]['unique_name']+'/advertising/side_of/';
                    html += data[values]['side_of'][value]+'" /></li></ul>';
                }
                html += '</div>';
            }
            
            $('#load').animate({'opacity' : '0'}, 200, function() {
                $('#load').css('display', 'none');
                $('#content .contentAdvertising').html(html).slideToggle(200, function() {
                    $(this).animate({'opacity' : '1'}, 200);
                });
            });
        }
    },
    getQuery : function() {
        this.getPreLoad();
        
        $.get('/advertising/shops', function(data) {
            ShopAdvertising.getEndLoad(data);
        });
    },
    click : function() {
        $('.menuAdvertising .shopAdv').click(function() {
            ShopAdvertising.getQuery();
            
            return false;
        });
    }
};
var DeleteAdvertising = {
    getValue : function(element) {
        return {
            'href' : element.parents('.preview').find('img').attr('src')
        };
    },
    getPreLoad : function(element) {
        element.parents('.preview').animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
    },
    getQuery : function(element) {
        this.getPreLoad(element);
        
        $.get('/advertising/delete', this.getValue(element));
    },
    click : function() {
        $('#content .contentAdvertising').on('click', '.deleteImg', function() {
            DeleteAdvertising.getQuery($(this));
            
            return false;
        });
    }
};

$(document).ready(function(){
    PaltformAdvertising.click();
    ShopAdvertising.click();
    DeleteAdvertising.click();
    
    $('#content').on('click', '.advertisings .previewImg', function() {
        $(this).parents('.preview').find('img').slideToggle(200);
        
        return false;
    });
});