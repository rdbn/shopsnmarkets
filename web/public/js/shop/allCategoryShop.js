var AllMain = {
    women: function() {
        $('.menu .women').hover(function() {
            $(this).addClass('hover');
            if ($('.menu .women .categoryWomen').length > 0) {
                $('.menu .women .categoryWomen').show();
                
                return;
            }
            var html = '<div class="categoryWomen"></div>';
            $('.menu .women').append(html).show();
            
            $.get('/allCategoryWomen', function(data) {
                if ($('.menu .women .categoryWomen').length <= 1) {
                    html = '<h3>Женская одежда</h3>';
                    for (var value in data) {
                        html += '<a href="/allProductsPlatform/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a>';
                    }

                    $('.menu .women .categoryWomen').append(html);
                }
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menu .women .categoryWomen').hide();
        });
    },
    man: function() {
        $('.menu .man').hover(function() {
            $(this).addClass('hover');
            if ($('.menu .man .categoryMan').length > 0) {
                $('.menu .man .categoryMan').show();
                
                return;
            }
            var html = '<div class="categoryMan"></div>';
            $('.menu .man').append(html).show();
            
            $.get('/allCategoryMan', function(data) {
                if ($('.menu .man .categoryMan').length <= 1) {
                    html = '<h3>Мужская одежда</h3>';
                    for (var value in data) {
                        html += '<a href="/allProductsPlatform/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a>';
                    }

                    $('.menu .man .categoryMan').append(html);
                }
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menu .man .categoryMan').hide();
        });
    },
    accessories: function() {
        $('.menu .accessories').hover(function() {
            $(this).addClass('hover');
            if ($('.menu .accessories .categoryAccessories').length > 0) {
                $('.menu .accessories .categoryAccessories').show();
                
                return;
            }
            var html = '<div class="categoryAccessories"></div>';
            $('.menu .accessories').append(html).show();
            
            $.get('/allCategoryAccessories', function(data) {
                if ($('.menu .accessories .categoryAccessories').length <= 1) {                
                    html = '<h3>Мужские</h3><h3>Женские</h3><ul>';
                    for (var value in data['man']) {
                        html += '<li><a href="/allAccessoriesPlatform/'+data['man'][value]['floor']+'/'+data['man'][value]['id']+'">'+data['man'][value]['name']+'</a></li>';
                    }
                    html += '</ul><ul>';
                    for (var value in data['women']) {
                        html += '<li><a href="/allAccessoriesPlatform/'+data['women'][value]['floor']+'/'+data['women'][value]['id']+'">'+data['women'][value]['name']+'</a></li>';
                    }
                    html += '</ul>';

                    $('.menu .accessories .categoryAccessories').append(html);
                }
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menu .accessories .categoryAccessories').hide();
        });
    },
    boots: function() {
        $('.menu .boots').hover(function() {      
            $(this).addClass('hover');
            if ($('.menu .boots .categoryBoots').length > 0) {
                $('.menu .boots .categoryBoots').show();
                
                return;
            }
            var html = '<div class="categoryBoots"></div>';
            $('.menu .boots').append(html).show();
            
            $.get('/allCategoryBoots', function(data) {
                if ($('.menu .boots .categoryBoots').length <= 1) {                
                    html = '<h3>Мужская</h3><h3>Женская</h3><ul>';
                    for (var value in data['man']) {
                        html += '<li><a href="/allBootsPlatform/'+data['man'][value]['floor']+'/'+data['man'][value]['id']+'">'+data['man'][value]['name']+'</a></li>';
                    }
                    html += '</ul><ul>';
                    for (var value in data['women']) {
                        html += '<li><a href="/allBootsPlatform/'+data['women'][value]['floor']+'/'+data['women'][value]['id']+'">'+data['women'][value]['name']+'</a></li>';
                    }
                    html += '</ul>';

                    $('.menu .boots .categoryBoots').append(html);
                }
            }, 'json');
        }, function() {
            $(this).removeClass('hover');
            $('.menu .boots .categoryBoots').hide();
        });
    }
};
$(document).ready(function(){
    AllMain.women();
    AllMain.man();
    AllMain.accessories();
    AllMain.boots();
});