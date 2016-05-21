var shop = window.location.pathname.match(/delivery\/(.+[^\/])/i);

var AddForm = {
    add: function (element) {
        var parentsElement = element.parents(".media-heading"),
            form = $("#formValue").attr("data-prototype"),
            index = parentsElement.attr("datatype"),
            newForm = form.replace(/__name__/g, index);

        element.parent().remove();
        parentsElement.append(newForm);

        parentsElement.find(".delivery-shops").val(shop[1]);
        parentsElement.find(".delivery-delivery").val(parseInt(index) + 1);

        var mainElement = $('#delivery_shopsDelivery_'+index);
        mainElement.find('div').addClass("form-group");
    },
    click: function () {
        $(".addForm").click(function () {
            AddForm.add($(this));
        });
    }
};

var AddDelivery = {
    getQuery : function(element) {
        var getElement = {
                delivery: {
                    shopsDelivery: [],
                    _token: $('#delivery__token').val()
                }
            },
            count = 0;

        $(".media").each(function () {
            var element = $(this);
            if (element.find(".delivery-shops").length > 0) {
                getElement.delivery.shopsDelivery[count] = {
                    shops: element.find('.delivery-shops').val(),
                    delivery: element.find('.delivery-delivery').val(),
                    price: element.find('.delivery-price').val(),
                    duration: element.find('.delivery-duration').val()
                };

                count++;
            }
        });

        $.post('/user/shop/addDelivery/'+shop[1], getElement, function() {
            element.removeClass("disabled");
        });
    },
    sendForm : function() {
        $('#formValue').on("click", ".add-delivery", function() {
            $(this).addClass("disabled");
            AddDelivery.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function() {
    AddForm.click();
    AddDelivery.sendForm();
});