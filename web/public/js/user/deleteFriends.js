var DeleteFriends = {
    getValue : function(element) {
        return {
            'id' : element.attr('href')
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
        
        $.get('/friends/deleteFriends', this.getValue(element), function(data) {
            if (data === '0') {
                DeleteFriends.getEndLoad(element);
            }
        });
    },
    deleteFriends : function() {
        $('.friends .delete').click(function() {
            DeleteFriends.getQuery($(this));
            
            return false;
        });
    }
};

$(document).ready(function() {
    DeleteFriends.deleteFriends();
});