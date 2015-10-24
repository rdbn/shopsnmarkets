var AddOrder = {
    getValue : function() {
        var arSize = [];
        $('.size input[type="checkbox"]:checked').each(function() {
            arSize.push($(this).val());
        });
        
        return {
            'OrderItem[shops]' : $('#OrderItem_shops').val(),
            'OrderItem[product]' : $('#OrderItem_product').val(),
            'OrderItem[size]' : (arSize.length !== 0) ? arSize : '',
            'OrderItem[_token]' : $('#OrderItem__token').val()
        };
    },
    getPreLoad : function() {
        $('#orderItem .button').animate({'opacity' : '0'}, 200, function() {
            $('#orderItem .button').css({'display' : 'none'});
            $('#orderItem .load').css({'display' : 'block'});
            $('#orderItem .load').animate({'opacity' : '1'}, 200);
        });
    },
    getEndLoad : function() {
        $('.options .formFields').animate({'opacity' : '0'}, 200, function() {
            $('.options .formFields').slideToggle(300, function() {
                $(this).html('<li><h3 class="chapter check">Товар добавлен в корзину.</h3></li>');
                $(this).slideToggle(300, function() {
                    $('.options .formFields').animate({'opacity' : '1'}, 200);
                });
            });
        });
    },
    getQuery : function() {
        this.getPreLoad();
        $.post("/addProductBasket", this.getValue(), function(data){
            if (data === '0') {
                AddOrder.getEndLoad();
            }
        });
    },
    add : function() {
        $('#orderItem').submit(function() {
            AddOrder.getQuery();

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