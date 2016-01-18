var CheckFriends = {
    getValue : function(element) {
        return {
            "user": element.attr('data-user'),
            "type": element.attr('data-type')
        };
    },
    getEndLoad : function(element) {
        element.removeClass('disabled');
        element.parents('.friends').css('opacity', '1');
        element.parents('.friends').animate({'opacity' : '0'}, 300, function() {
            element.parents('.friends').slideToggle(200, function() {
                element.parents('.friends').remove();
            });
        });
    },
    getQuery : function(element) {
        element.addClass('disabled');
        var value = this.getValue(element);
        
        $.get('/friends/add/check/'+value.type+"/"+value.user, function(data){
            if (data === '0') {
                CheckFriends.getEndLoad(element);
            }
        });
    },
    check : function() {
        $('.result-user').on('click', '.type a', function() {
            CheckFriends.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function(){
    CheckFriends.check();
});