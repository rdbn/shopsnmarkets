var Subategory = {
    all : function() {
        $('.category ul').on('click', '.list', function() {
            var element = $(this);
            var url = element.attr('href').split('?');
            var name = url['1'].split('&');
            var nameShop = name['0'].split('=');
            var id = name['1'].split('=');

            $.get('/subcategory', { 
                'value[name]' : nameShop['1'],
                'value[id]' : id['1']
            }, function(data) {
                element.parent().find('.subcategory').html(data).show();
            });
            
            return false;
        });
    },
};
$(document).ready(function(){
    Subategory.all();
});