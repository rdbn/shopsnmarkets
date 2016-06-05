var AddPartners = {
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
            element.parents('.resultShop').css('opacity', '1');
            element.parents('.resultShop').animate({'opacity' : '0'}, 300, function() {
                element.parents('.resultShop').slideToggle(200, function() {
                    element.parents('.resultShop').remove();
                });
            });
        });
    },
    getQuery : function(element) {
        element.addClass('hover');
        element.find('.load').animate({'opacity' : '1'}, 200);
        
        $.get('/manager/addPartners', this.getValue(element), function(data){
            if (data === '0') {
                AddPartners.getEndLoad(element);
            }
        });
    },
    add : function() {
        $('#resualtSearch').on('click', '.myShops .add', function() {
            AddPartners.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function(){
    AddPartners.add();
});