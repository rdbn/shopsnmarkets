$(document).ready(function() {
    $('#content .subscribe').click(function() {
        var element = $(this);
        var id = element.attr('href');
        
        $.get('/subscribeShop', { 'id' : id }, function(data) {
            if (data === '0') {
                var subscribe = Number(element.parent('.menuBok').find('.count').text());
                var count = subscribe + 1;
                element.parent('.menuBok').find('.count').text(count);
                element.remove();
            }
        });
        
        return false;
    });
});