var Category = {
    women: function() {
        $('.menuProduct .women').hover(function() {
            $(this).addClass('hover');
            $('.menuProduct .man .categoryMan').hide();
            if ($('.menuProduct .women .categoryWomen').length > 0) {
                $('.menuProduct .women .categoryWomen').show();
                
                return;
            }
            var id = $('.menuProduct .women a').attr('href');
            var html = '<div class="categoryWomen"><p><img class="loadMenu" src="/public/images/load/ajax-loader-button.gif" /></p></div>';
            $('.menuProduct .women').append(html).show();
            $('.menuProduct .women .categoryWomen p').css('display', 'block');
            $('.menuProduct .women .categoryWomen p').animate({'opacity' : 1}, 200);
            
            
            $.get('/categoryWomenShop', { 'id' : id }, function(data) {
                if ($('.menuProduct .women .categoryWomen').length <= 1) {
                    html = '<h3>Женская одежда</h3>';
                    for (var value in data) {
                        html += '<a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a>';
                    }
                    $('.menuProduct .women .categoryWomen p').animate({'opacity' : 0}, 200, function() {
                        $('.menuProduct .women .categoryWomen p').css('display', 'none');
                        $('.menuProduct .women .categoryWomen').append(html);
                    });
                }
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menuProduct .women .categoryWomen').hide();
        });
    },
    man: function() {
        $('.menuProduct .man').hover(function() {
            $(this).addClass('hover');
            if ($('.menuProduct .man .categoryMan').length > 0) {
                $('.menuProduct .man .categoryMan').show();
                
                return;
            }
            var id = $('.menuProduct .man a').attr('href');
            var html = '<div class="categoryMan"><p><img class="loadMenu" src="/public/images/load/ajax-loader-button.gif" /></p></div>';
            $('.menuProduct .man').append(html).show();
            $('.menuProduct .man .categoryMan p').css('display', 'block');
            $('.menuProduct .man .categoryMan p').animate({'opacity' : 1}, 200);
            
            $.get('/categoryManShop', { 'id' : id }, function(data) {
                if ($('.menuProduct .man .categoryMan').length <= 1) {
                    html = '<h3>Мужская одежда</h3>';
                    for (var value in data) {
                        html += '<a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a>';
                    }
                    $('.menuProduct .man .categoryMan p').animate({'opacity' : 0}, 200, function() {
                        $('.menuProduct .man .categoryMan p').css('display', 'none');
                        $('.menuProduct .man .categoryMan').append(html);
                    });
                }
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menuProduct .man .categoryMan').hide();
        });
    },
    accessories: function() {
        $('.menuProduct .accessories').hover(function() {
            $(this).addClass('hover');
            if ($('.menuProduct .accessories .categoryAccessories').length > 0) {
                $('.menuProduct .accessories .categoryAccessories').show();
                
                return;
            }
            var id = $('.menuProduct .accessories a').attr('href');
            var html = '<div class="categoryAccessories"><p><img class="loadMenu" src="/public/images/load/ajax-loader-button.gif" /></p></div>';
            $('.menuProduct .accessories').append(html).show();
            $('.menuProduct .accessories .categoryAccessories p').css('display', 'block');
            $('.menuProduct .accessories .categoryAccessories p').animate({'opacity' : 1}, 200);
            
            $.get('/subcategoryAccessoriesShop', { 'id' : id }, function(data) {                
                html = '<ul><li><h3>Женские</h3></li>';
                for (var value in data) {
                    if (data[value]['floor'] === 1) {
                        html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/45/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                }
                html += '</ul><ul><li><h3>Мужские</h3></li>';
                for (var value in data) {
                    if (data[value]['floor'] === 2) {
                        html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/13/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                }
                html += '</ul>';
                $('.menuProduct .accessories .categoryAccessories p').animate({'opacity' : 0}, 200, function() {
                    $('.menuProduct .accessories .categoryAccessories p').css('display', 'none');
                    $('.menuProduct .accessories .categoryAccessories').append(html);
                });
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menuProduct .accessories .categoryAccessories').hide();
        });
    },
    boots: function() {
        $('.menuProduct .boots').hover(function() {
            $(this).addClass('hover');
            if ($('.menuProduct .boots .categoryBoots').length > 0) {
                $('.menuProduct .boots .categoryBoots').show();
                
                return;
            }
            var id = $('.menuProduct .boots a').attr('href');
            var html = '<div class="categoryBoots"><p><img class="loadMenu" src="/public/images/load/ajax-loader-button.gif" /></p></div>';
            $('.menuProduct .boots').append(html).show();
            $('.menuProduct .boots .categoryBoots p').css('display', 'block');
            $('.menuProduct .boots .categoryBoots p').animate({'opacity' : 1}, 200);
            
            $.get('/subcategoryBootsShop', { 'id' : id }, function(data) {
                html = '<ul><li><h3>Женская</h3></li>';
                for (var value in data) {
                    if (data[value]['floor'] === 1) {
                        html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/44/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                }
                html += '</ul><ul><li><h3>Мужская</h3></li>';
                for (var value in data) {
                    if (data[value]['floor'] === 2) {
                        html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/9/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                }
                html += '</ul>';
                $('.menuProduct .boots .categoryBoots p').animate({'opacity' : 0}, 200, function() {
                    $('.menuProduct .boots .categoryBoots p').css('display', 'none');
                    $('.menuProduct .boots .categoryBoots').append(html);
                });
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menuProduct .boots .categoryBoots').hide();
        });
    }
};


$(document).ready(function(){
    Category.women();
    Category.man();
    Category.accessories();
    Category.boots();
    $('.menuProduct .women a').click(function() {
        return false;
    });
    $('.menuProduct .man a').click(function() {
        return false;
    });
    $('.menuProduct .accessories a').click(function() {
        return false;
    });
    $('.menuProduct .boots a').click(function() {
        return false;
    });
});