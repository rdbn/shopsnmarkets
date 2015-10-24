var ListMyShops = {
    getValue : function(element) {
        return {
            id : element.attr('href')
        };
    },
    getPreLoad : function(element) {
        element.addClass('hover');
        element.find('.load').animate({'opacity' : '1'}, 200, function() {            
            var html = '<ul class="myShops"></ul>';
            element.parent().append(html);
        });
    },
    getEndLoad : function(data, element) {
        var html = '';
                
        for (var value in data) {
            html += '<li><a class="add" href="'+data[value]['id']+'/'+ListMyShops.getValue(element).id+'">'+data[value]['shopname'];
            html += '<span class="load"><img src="/public/images/load/ajax-loader-button-second.gif" /></span></a></li>';
        }
        
        element.find('.load').animate({'opacity' : '0'}, 200, function() {
            element.removeClass('hover');
            element.parent().find('.myShops').append(html);
            element.parent().find('.myShops').css('display', 'none');
            element.parent().find('.myShops').slideToggle(200);
        });
    },
    getQuery : function(element) {
        this.getPreLoad(element);

        $.get('/manager/addPartners/listMyShops', function(data){
            if (data !== '') {
                ListMyShops.getEndLoad(data, element);
            }
        }, 'json');
    },
    getList : function() {
        $('#resualtSearch').on('click', '.listPartners .addPartners', function() {
            if ($(this).parent().find('.myShops').length === 0) {
                ListMyShops.getQuery($(this));
            } else {
                $(this).parent().find('.myShops').slideToggle(200);
            }
            return false;
        });
    }
};
$(document).ready(function(){
    ListMyShops.getList();
});