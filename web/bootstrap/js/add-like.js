$(document).ready(function() {
    var element = $('body');

    element.on("click", ".add-like-shop", function() {
        var element = $(this),
            id = element.attr('data-toggle');
        
        $.get('/app_dev.php/addLikeShop/'+id, function(data) {
            element.find(".badge").text(data);
        });
    });
    
    element.on("click", ".add-like-product", function() {
        var element = $(this),
            id = element.attr('data-toggle');
        
        $.get('/app_dev.php/addLikeProduct/'+id, function(data) {
            element.find(".badge").text(data);
        });
    });
});