$(document).ready(function() {
    $('.shop .like').click(function() {
        var element = $(this);
        var id = element.attr('href');
        element.find('.countLike').animate({'opacity' : 0}, 200);
        
        $.get('/addLikeShop', { 'id' : id }, function(data) {
            if (data === '0') {
                var like = Number(element.find('.countLike').text());
                var count = like + 1;
                element.find('.countLike').text(count);
                element.find('.countLike').animate({'opacity' : 1}, 200);
            } else {
                element.find('.countLike').animate({'opacity' : 1}, 200);
            }
        });
        
        return false;
    });
    
    $('.products .like').click(function() {
        var element = $(this);
        var id = element.attr('href');
        element.find('.countLike').animate({'opacity' : 0}, 200);
        
        $.get('/addLikeProduct', { 'id' : id }, function(data) {
            if (data === '0') {
                var like = Number(element.find('.countLike').text());
                var count = like + 1;
                element.find('.countLike').text(count);
                element.find('.countLike').animate({'opacity' : 1}, 200);
            } else {
                element.find('.countLike').animate({'opacity' : 1}, 200);
            }
        });
        
        return false;
    });
})