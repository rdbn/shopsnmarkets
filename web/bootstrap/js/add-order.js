var AddOrder = {
    add: function(element) {
        var product = element.attr("data-toggle");

        element.addClass("disabled");
        $.get("/addOrder/"+product, function() {
            element.removeClass("disabled");
        });
    },
    click: function() {
        $('#add-order').click(function() {
            AddOrder.add($(this));

            return false;
        });
    }
};

var RemoveOrder = {
    add: function(element) {
        var product = element.attr("data-toggle");

        element.addClass("disabled");
        $.get('/removeOrder/'+product, function() {
            element.parents('.media').remove();
        });
    },
    click: function() {
        $('.delete-order').click(function() {
            RemoveOrder.add($(this));

            return false;
        });
    }
};

var UpdateNumber = {
    add: function(element, sign) {
        var order = element.attr("data-toggle");

        element.addClass("disabled");
        $.get("/updateNumberOrder/"+order+'/'+sign, function(data) {
            var parents = element.parents('p');
            if (data.number == 1) {
                parents.find(".minus-number-order").remove();
            } else {
                if (parents.find(".minus-number-order").length == 0) {
                    var html = '<button class="btn btn-success btn-xs minus-number-order" data-toggle="'+order+'">';
                    html += '<span class="glyphicon glyphicon-minus"></span></button>';

                    parents.append(html);
                }
            }

            parents.find('.number-order').html(data.number);
            element.removeClass("disabled");
        });
    },
    plus: function() {
        $('.plus-number-order').click(function() {
            UpdateNumber.add($(this), 1);

            return false;
        });
    },
    minus: function() {
        $('.media').on("click", ".minus-number-order", function() {
            UpdateNumber.add($(this), 0);

            return false;
        });
    }
};

$(document).ready(function(){
    AddOrder.click();
    RemoveOrder.click();
    UpdateNumber.plus();
    UpdateNumber.minus();
});