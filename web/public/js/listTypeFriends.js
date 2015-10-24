var ListTypeFriends = {
    getValue : function(element) {        
        return {
            'id' : element.attr('href')
        };
    },
    getQuery : function(element) {
        element.addClass('hover');
        element.find('.load').animate({'opacity' : '1'}, 200);
        
        $.get('/friends/addFriends/listTypeFriends', this.getValue(element), function(data){
            if (data !== '') {
                var html = '<ul class="type">';
                
                for (var value in data) {
                    html += '<li><a href="'+data[value]['id_type']+'/'+data[value]['id_user']+'">'+data[value]['name'];
                    html += '<span class="load"><img src="/public/images/load/ajax-loader-button-second.gif" /></span></a></li>';
                }
                html += '</ul>';
                
                element.removeClass('target').html('Потвердить');
                element.parent('.typeFriends').append(html).find('.type').slideToggle('100');
            }
        }, 'json');
    },
    list : function() {
        $('.friends .typeFriends .check').click(function() {
            if ($('.friends .typeFriends .type').length === 0) {
                ListTypeFriends.getQuery($(this));
            } else {
                $('.friends .typeFriends .type').slideToggle('100');
            }
            return false;
        });
    }
};
$(document).ready(function(){
    ListTypeFriends.list();
});