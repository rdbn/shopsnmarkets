var SecondCategoryShop = {
    women: function() {
        $('.menu .women .click').click(function() {
            if ($('.menu .women .secondMenu').length < 1) {
                $.get('/categoryWomenShop', { 'id' : $('.menu .women .click').attr('href') }, function(data) {
                    var html = '<ul class="secondMenu">';

                    for (var value in data) {
                        html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                    html += '</ul>';

                    $('.menu .women').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .women .secondMenu').slideToggle(200);
                }, 'json');
            } else {
                $('.menu .women .secondMenu').slideToggle(200);
            }
            
            return false;
        });
    },
    man: function() {
        $('.menu .man .click').click(function() {
            if ($('.menu .man .secondMenu').length < 1) {
                $.get('/categoryManShop', { 'id' : $('.menu .man .click').attr('href') }, function(data) {
                    var html = '<ul class="secondMenu">';

                    for (var value in data) {
                        html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                    html += '</ul>';

                    $('.menu .man').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .man .secondMenu').slideToggle(200);
                }, 'json');
            } else {
                $('.menu .man .secondMenu').slideToggle(200);
            }
            
            return false;
        });
    },
    accessories: function() {
        $('.menu .accessories .click').click(function() {
            if ($('.menu .accessories .secondMenu').length < 1) {
                $.get('/subcategoryAccessoriesShop', { 'id' : $('.menu .accessories .click').attr('href') }, function(data) {
                    var html = '<ul class="secondMenu"><li><h3>Женские</h3></li>';
                    for (var value in data) {
                        if (data[value]['floor'] === 1) {
                            html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/45/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                        }
                    }
                    html += '<li><h3>Мужские</h3></li>';
                    for (var value in data) {
                        if (data[value]['floor'] === 2) {
                            html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/13/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                        }
                    }
                    html += '</ul>';

                    $('.menu .accessories').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .accessories .secondMenu').slideToggle(200);
                }, 'json');
            } else {
                $('.menu .accessories .secondMenu').slideToggle(200);
            }
            
            return false;
        });
    },
    boots: function() {
        $('.menu .boots .click').click(function() {
            if ($('.menu .boots .secondMenu').length < 1) {
                $.get('/subcategoryBootsShop', { 'id' : $('.menu .boots .click').attr('href') }, function(data) {                    
                    var html = '<ul class="secondMenu"><li><h3>Женская</h3></li>';
                    for (var value in data) {
                        if (data[value]['floor'] === 1) {
                            html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/44/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                        }
                    }
                    html += '<li><h3>Мужская</h3></li>';
                    for (var value in data) {
                        if (data[value]['floor'] === 2) {
                            html += '<li><a href="/'+data[value]['unique_name']+'/allProduct/'+data[value]['floor']+'/9/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                        }
                    }
                    html += '</ul>';

                    $('.menu .boots').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .boots .secondMenu').slideToggle(200);
                }, 'json');
            } else {
                $('.menu .boots .secondMenu').slideToggle(200);
            }
            
            return false;
        });
    }
};
$(document).ready(function(){
    SecondCategoryShop.women();
    SecondCategoryShop.man();
    SecondCategoryShop.accessories();
    SecondCategoryShop.boots();
});