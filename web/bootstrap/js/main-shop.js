var ShopProducts = {
    add: function(element) {
        var shopname = element.attr("data-toggle");

        element.addClass("disabled");
        var result = $("#result");

        $.get('/'+shopname+'/showProducts/0', function(data) {
            var html = '';
            for (var name in data) {
                var product = data[name];

                html += '<div class="col-sm-4 col-md-3"><div class="thumbnail"><a href="/products/' + product.id + '">';
                html += '<img src="' + product.image[0].path + '" alt="Product" /></a><div class="caption"><h4>';
                html += '<span class="text-danger">' + product.price + '</span> <span class="label label-danger">';
                html += 'руб.</span><button id="product-like" class="btn btn-success btn-xs pull-right">Хочу ';
                html += '<span class="badge">' + product.likeProduct[0].id + '</span></button></h4></div></div></div>';
            }

            result.html(html);
            element.removeClass("disabled");
        }, 'json');
    },
    click: function() {
        $('#shop-products').click(function() {
            ShopProducts.add($(this));
        });
    }
};

var ShopInformation = {
    add: function (element) {
        var shopname = element.attr("data-toggle");

        element.addClass("disabled");
        $.get("/"+shopname+"/information", function (data) {
            var html = "<div class='col-md-8'><h3 class=\"text-success\">Информация о магазине</h3>";
            html += "<div class=\"media\"><div class=\"media-left media-middle\">";
            html += "<img class='media-object img-thumbnail' src=\""+data.path+"\" alt=\""+data.shopname+"\" /></div>";
            html += "<div class=\"media-body text-success\"><div class='media-heading'><h3>"+data.shopname+"</h3></div>";
            html += "<p><span class='text-muted'>Страна:</span> "+data.city.country.name+"</p>";
            html += "<p><span class='text-muted'>Город:</span> "+data.city.name+"</p>";
            html += "<p><span class='text-muted'>Телефон:</span> "+data.phone+"</p>";
            html += "<p><span class='text-muted'>Email:</span> "+data.email+"</p></div></div>";

            html += "<h3 class=\"text-success\">Подробное описание:</h3><p class=\"text-muted\">"+data.description+"</p></div>";

            html += "<div class=\"col-md-4\"><h3 class='text-success'>Способы доставки:</h3>";
            for (var value in data.shops_delivery) {
                var delivery = data.shops_delivery[value];
                html += "<div class=\"media\"><div class=\"media-left media-middle\">";
                html += "<img src=\"/"+delivery.delivery.image+"\" /></div>";
                html += "<div class=\"media-body text-success\"><div class='media-heading'>"+delivery.delivery.name+"</div>";
                html += "<p><span class='text-muted'>Стоимость:</span> "+delivery.price+" руб.</p>";
                html += "<p><span class='text-muted'>Время:</span> "+delivery.duration+"</p></div>";
            }

            html += "</div>";

            element.removeClass("disabled");
            $('#result').html(html);
        });
    },
    click: function () {
        $("#shop-information").click(function () {
            ShopInformation.add($(this));
        });
    }
};

var ShowComments = {
    add: function(element) {
        var id = element.attr("datatype");

        element.addClass("disabled");
        $.get('/shopComments/'+id+'/0', function(data) {
            var html = '';
            for (var i in data) {
                var comments = data[i];

                html += "<div class=\"media\"><div class=\"media-left\">";
                if (comments.users.path == undefined) {
                    html += "<img class=\"media-object preview-comments\" />";
                } else {
                    html += "<img class=\"media-object\" src=\"" + comments.users.path + "\" />";
                }

                html += "</div><div class=\"media-body\"><h4 class=\"media-heading text-success\">";
                html += comments.users.realname+"</h4><p class='text-muted'>"+comments.text+"</p>";
                html += "</div></div>";
            }

            element.removeClass("disabled");

            var commentsList = $("#comments-list");
            commentsList
                .html(html)
                .animate({opacity: 1}, 100, function () {
                    commentsList.scrollTop(commentsList.get(0).scrollHeight);
                });
        }, 'json');
    },
    click: function() {
        $('#show-comments').click(function() {
            ShowComments.add($(this));
        });
    }
};

var AddComments = {
    add: function(element) {
        var shopname = $("#comments_shops").val(),
            user = $("#comments_users").val(),
            text = $("#comments_text"),
            token = $("#comments__token").val();

        var comments = {
            comments: {
                shops: shopname,
                users: user,
                text: text.val(),
                _token: token
            }
        };

        text.val("");
        element.addClass("disabled");
        $.post('/'+shopname+'/addCommentsShop', comments, function(data) {
            $("#comments_text").val("");

            var html = "<div class=\"media\"><div class=\"media-left\">";
            if (data.users.path == undefined) {
                html += "<img class=\"media-object preview-comments\" />";
            } else {
                html += "<img class=\"media-object\" src=\"" + data.users.path + "\" />";
            }

            html += "</div><div class=\"media-body\"><h4 class=\"media-heading text-success\">";
            html += data.users.realname+"</h4><p class='text-muted'>"+data.text+"</p>";
            html += "</div></div>";

            element.removeClass("disabled");

            var commentsList = $("#comments-list");
            commentsList
                .append(html)
                .animate({opacity: 1}, 100, function () {
                    commentsList.scrollTop(commentsList.get(0).scrollHeight);
                });
        }, 'json');
    },
    click: function() {
        $('#comments_save').click(function() {
            AddComments.add($(this));

            return false;
        });
    }
};

$(document).ready(function() {
    ShopProducts.click();
    ShopInformation.click();
    ShowComments.click();
    AddComments.click();
});