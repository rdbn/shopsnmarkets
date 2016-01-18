var AddFriends = {
    getValue : function(element) {
        return element.attr('data-user');
    },
    getEndLoad : function(element) {
        element.removeClass('disabled');
        element.parents('.result-user').css('opacity', '1');
        element.parents('.result-user').animate({'opacity' : '0'}, 300, function() {
            element.parents('.result-user').slideToggle(200, function() {
                element.parents('.result-user').remove();
            });
        });
    },
    getQuery : function(element) {
        element.addClass('disabled');
        
        $.get('/friends/add/'+this.getValue(element), function(data){
            if (data !== '') {
                AddFriends.getEndLoad(element);
            }
        });
    },
    add : function() {
        $('#result-search').on('click', '.add-friends', function() {
            AddFriends.getQuery($(this));
                
            return false;
        });
    }
};
$(document).ready(function(){
    AddFriends.add();
});