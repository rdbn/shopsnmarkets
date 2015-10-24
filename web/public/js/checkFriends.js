var CheckFriends = {
    getValue : function(element) {
        var url = element.attr('href').split('/');
        
        return {
            'id[type]' : url['0'],
            'id[id]' : url['1']
        };
    },
    getEndLoad : function(element) {
        element.find('.load').animate({'opacity' : '0'}, 200, function() {
            element.removeClass('hover');
            element.parents('.friends').css('opacity', '1');
            element.parents('.friends').animate({'opacity' : '0'}, 300, function() {
                element.parents('.friends').slideToggle(200, function() {
                    element.parents('.friends').remove();
                });
            });
        });
    },
    getQuery : function(element) {
        element.addClass('hover');
        element.find('.load').animate({'opacity' : '1'}, 200);
        
        $.get('/friends/addFriends/checkFriends', this.getValue(element), function(data){
            if (data === '0') {
                CheckFriends.getEndLoad(element);
            }
        });
    },
    check : function() {
        $('.typeFriends').on('click', '.type a', function() {
            CheckFriends.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function(){
    CheckFriends.check();
});