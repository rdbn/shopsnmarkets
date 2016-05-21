$(document).ready(function() {
    var element = $('body');

    element.on("click", ".add-like-shop", function() {
        var element = $(this),
            id = element.attr('data-toggle');
        
        $.get('/addLikeShop/'+id, function(data) {
            element.find(".badge").text(data);
        });
    });
    
    element.on("click", ".add-like-product", function() {
        var element = $(this),
            id = element.attr('data-toggle');
        
        $.get('/addLikeProduct/'+id, function(data) {
            element.find(".badge").text(data);
        });
    });
});