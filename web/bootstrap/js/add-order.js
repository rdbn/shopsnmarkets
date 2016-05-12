var AddOrder = {
    getQuery : function(element) {
        var product = element.attr("data-toggle");

        $.get("/app_dev.php/addOrder/"+product, function(data) {
            console.log(data);
        });
    },
    add : function() {
        $('#add-order').click(function() {
            AddOrder.getQuery($(this));

            return false;
        });
    }
};

var DeleteOrder = {
    getPreLoad : function(element) {
        element.find('.load').css({'opacity' : '0', 'display' : 'block'});
        element.find('.load').animate({'opacity' : '1'}, 200);
    },
    getEndLoad : function(element) {
        if ($('.basket .order').length === 1) {
            element.parents('.basket').css('opacity', '1');
            element.parents('.basket').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(300, function() {
                    $(this).remove();
                });
            });
        } else {
            element.parents('.order').css('opacity', '1');
            element.parents('.order').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(300, function() {
                    $(this).remove();
                });
            });
        }
    },
    getQuery : function(element) {
        this.getPreLoad(element);
        
        $.get('/deleteOrderUser', { 'id' : element.attr('href') }, function(data) {
            if (data === '0') {
                DeleteOrder.getEndLoad(element);
            }
        });
    },
    del : function() {
        $('.order .delete').click(function() {
            DeleteOrder.getQuery($(this));
            
            return false;
        });
    }
};


$(document).ready(function(){
    AddOrder.add();
    DeleteOrder.del();
});