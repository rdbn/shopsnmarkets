var CheckPartners = {
    getValue : function(element) {
        var id = element.attr('href').split('/');
        
        return {
            'id[shop]' : id['0'],
            'id[partners]' : id['1']
        };
    },
    getEndLoad : function(element) {
        element.find('.load').animate({'opacity' : '0'}, 200, function() {
            element.removeClass('hover');
            element.parents('.application').css('opacity', '1');
            element.parents('.application').animate({'opacity' : '0'}, 300, function() {
                element.parents('.application').slideToggle(200, function() {
                    element.parents('.application').remove();
                });
            });
        });
    },
    getQuery : function(element) {
        element.addClass('hover');
        element.find('.load').animate({'opacity' : '1'}, 200);
        
        $.get('/manager/addPartners/checkPartners', this.getValue(element), function(data){
            if (data === '0') {
                CheckPartners.getEndLoad(element);
            }
        });
    },
    check : function() {
        $('.application .check').click(function() {
            CheckPartners.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function(){
    CheckPartners.check();
});