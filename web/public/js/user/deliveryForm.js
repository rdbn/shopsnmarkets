var CreateForm = {
    getElement : function(element) {
        var value = element.attr('href').split('/');
        
        return {
            'id[shops]' : value['0'],
            'id[delivery]' : value['1']
        };
    },
    getQuery : function(element) {
        element.find('.loadForm').css({'display' : 'block', 'opacity' : '0'});
        element.find('.loadForm').animate({'opacity' : '1'}, 200);
        element.parent().append('<ul class="formDelivery"></ul>');
        
        $.get('/manager/shop/deliveryForm', this.getElement(element), function(data) {
            if (data !== '') {
                element.parent().find('.formDelivery').append(data);
                element.find('.loadForm').animate({'opacity' : '0'}, 200, function() {
                    element.find('.loadForm').css({'display' : 'none', 'opacity' : '0'});
                    element.parent().find('.formDelivery').slideToggle(200);
                });
            }
        });
    },
    getSell : function() {
        $('#content .delivery a').click(function() {
            if ($(this).parent().find('.formDelivery').length === 0) {
                CreateForm.getQuery($(this));
            } else {
                $(this).parent().find('.formDelivery').slideToggle(200);
            }
            
            return false;
        });
    }
};

var AddDelivery = {
    getElement : function(element) {        
        return {
            'ShopsDelivery[shops]' : element.find('input[name="ShopsDelivery[shops]"]').val(),
            'ShopsDelivery[delivery]' : element.find('input[name="ShopsDelivery[delivery]"]').val(),
            'ShopsDelivery[price_duration]' : element.find('input[name="ShopsDelivery[price_duration]"]').val(),
            'ShopsDelivery[duration]' : element.find('input[name="ShopsDelivery[duration]"]').val(),
            'ShopsDelivery[_token]' : element.find('input[name="ShopsDelivery[_token]"]').val()
        };
    },
    getQuery : function(element) {
        element.find('.button').animate({'opacity' : '0'}, 200, function() {
            element.find('.button').css('display', 'none');
            element.find('.load').css({'display' : 'block', 'opacity' : '0'});
            element.find('.load').animate({'opacity' : '1'}, 200);
        });
        
        $.post('/manager/shop/deliverySave', this.getElement(element), function(data) {
            if (data === '0') {
                element.find('.load').animate({'opacity' : '0'}, 200, function() {
                    element.find('.load').css('display', 'none');
                    element.find('.button').css({'display' : 'block', 'opacity' : '0'});
                    element.find('.button').animate({'opacity' : '1'}, 200);
                });
            }
        });
    },
    sendForm : function() {
        $('#content .delivery').on('submit', '#delivery', function() {
            AddDelivery.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function() {
    CreateForm.getSell();
    AddDelivery.sendForm();
});