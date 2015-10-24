var SecondCategory = {
    women: function() {
        $('.menu .women .click').click(function() {
            if ($('.menu .women .secondMenu').length < 1) {
                $.get('/allCategoryWomen', function(data) {
                    var html = '<ul class="secondMenu">';

                    for (var value in data) {
                        html += '<li><a href="/allProductsCategory/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                    html += '</ul>';

                    $('.menu .women').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .women .secondMenu').slideToggle();
                }, 'json');
            } else {
                $('.menu .women .secondMenu').slideToggle();
            }
        });
    },
    man: function() {
        $('.menu .man .click').click(function() {
            if ($('.menu .man .secondMenu').length < 1) {
                $.get('/allCategoryMan', function(data) {
                    var html = '<ul class="secondMenu">';

                    for (var value in data) {
                        html += '<li><a href="/allProductsCategory/'+data[value]['floor']+'/'+data[value]['id']+'">'+data[value]['name']+'</a></li>';
                    }
                    html += '</ul>';

                    $('.menu .man').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .man .secondMenu').slideToggle();
                }, 'json');
            } else {
                $('.menu .man .secondMenu').slideToggle();
            }
        });
    },
    accessories: function() {
        $('.menu .accessories .click').click(function() {
            if ($('.menu .accessories .secondMenu').length < 1) {
                $.get('/allCategoryAccessories', function(data) {
                    var html = '<ul class="secondMenu">';
                    html += '<li><h3>Мужские</h3></li>';
                    for (var value in data) {
                        if (data[value]['category'] === 13) {
                            html += '<li><a href="/allProductsSubcategory/'+data[value]['floor']+'/'+data[value]['category']+'/'+data[value]['id']+'">';
                            html += data[value]['name']+'</a></li>';
                        }
                    }
                    html += '<li><h3>Женские</h3></li>';
                    for (var value in data) {
                        if (data[value]['category'] === 45) {
                            html += '<li><a href="/allProductsSubcategory/'+data[value]['floor']+'/'+data[value]['category']+'/'+data[value]['id']+'">';
                            html += data[value]['name']+'</a></li>';
                        }
                    }
                    html += '</ul>';

                    $('.menu .accessories').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .accessories .secondMenu').slideToggle();
                }, 'json');
            } else {
                $('.menu .accessories .secondMenu').slideToggle();
            }
        });
    },
    boots: function() {
        $('.menu .boots .click').click(function() {
            if ($('.menu .boots .secondMenu').length < 1) {
                $.get('/allCategoryBoots', function(data) {
                    var html = '<ul class="secondMenu">';
                    html += '<li><h3>Мужские</h3></li>';
                    for (var value in data) {
                        if (data[value]['category'] === 9) {
                            html += '<li><a href="/allProductsSubcategory/'+data[value]['floor']+'/'+data[value]['category']+'/'+data[value]['id']+'">';
                            html += data[value]['name']+'</a></li>';
                        }
                    }
                    html += '<li><h3>Женские</h3></li>';
                    for (var value in data) {
                        if (data[value]['category'] === 44) {
                            html += '<li><a href="/allProductsSubcategory/'+data[value]['floor']+'/'+data[value]['category']+'/'+data[value]['id']+'">';
                            html += data[value]['name']+'</a></li>';
                        }
                    }
                    html += '</ul>';

                    $('.menu .boots').append(html).find('.secondMenu').css('display', 'none');
                    $('.menu .boots .secondMenu').slideToggle();
                }, 'json');
            } else {
                $('.menu .boots .secondMenu').slideToggle();
            }
        });
    }
};
$(document).ready(function(){
    SecondCategory.women();
    SecondCategory.man();
    SecondCategory.accessories();
    SecondCategory.boots();
});