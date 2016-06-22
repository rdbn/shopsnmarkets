var Pagination = {
    getQuery : function(element) {
        element.addClass("disabled");
        var result = $("#result");
        
        $.get('/showProducts/'+element.attr("data-pagination"), function(data) {
            var html = '';
            for (var name in data) {
                var item = data[name];

                html += '<div class="col-md-3"><a href="/products/' + item['id'] + '">';
                html += '<img class="img-responsive img-thumbnail" src="' + item['image'][0]['path'] + '" alt="Product" /></a><h4>';
                html += '<span class="text-danger">' + item['price'] + '</span> <span class="label label-danger">';
                html += 'руб.</span><button class="btn btn-success btn-xs add-like-product" data-toggle="' + item['id'] + '">Хочу ';
                html += '<span class="badge">' + item['likeProduct'][0]['id'] + '</span></button></h4></div>';
            }

            if (data.length < 16) {
                element.remove();
            }

            result.append(html);
            result.animate({"opacity": 1}, 200);
            element.removeClass("disabled");
        });
    },
    button : function() {
        $('#pagination').click(function() {
            Pagination.getQuery($(this));
        });
    }
};

$(document).ready(function() {
    Pagination.button();
});