var AddFriends = {
    getValue : function(element) {
        return {
            'id' : element.attr('href')
        };
    },
    getEndLoad : function(element) {
        element.find('.load').animate({'opacity' : '0'}, 200, function() {
            element.removeClass('hover');
            element.parents('.resultUser').css('opacity', '1');
            element.parents('.resultUser').animate({'opacity' : '0'}, 300, function() {
                element.parents('.resultUser').slideToggle(200, function() {
                    element.parents('.resultUser').remove();
                });
            });
        });
    },
    getQuery : function(element) {
        element.addClass('hover');
        element.find('.load').animate({'opacity' : '1'}, 200);
        
        $.get('/friends/addFriends', this.getValue(element), function(data){
            if (data !== '') {
                AddFriends.getEndLoad(element);
            }
        });
    },
    add : function() {
        $('#resualtSearch').on('click', '.resultUser .addFriends', function() {    
            AddFriends.getQuery($(this));
                
            return false;
        });
    }
};
$(document).ready(function(){
    AddFriends.add();
});