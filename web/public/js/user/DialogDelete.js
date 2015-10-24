var Delete = {
    getValue : function(element) {
        return {
            'id' : element.attr('id')
        };
    },
    getPreLoad : function(element) {
        element.parents('.user').animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
    },
    getQuery : function(element) {
        this.getPreLoad(element);
        
        $.get('/message/userMessage/deleteDialog', this.getValue(element));
    },
    click : function() {
        $('#content .allMessage').on('click', '.user .delete', function() {
            Delete.getQuery($(this));
            
            return false;
        });
    }
};

$(document).ready(function(){
    Delete.click();
    
    $('#content .allMessage .user').hover(function() {
        $(this).find('.delete').stop().animate({'opacity' : '1'}, 400);
    }, function() {
        $(this).find('.delete').stop().animate({'opacity' : '0'}, 400);
    });
});