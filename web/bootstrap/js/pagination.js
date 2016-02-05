var Pagination = {
    getQuery : function(element) {
        element.addClass("disabled");
        var result = $("#result-search");
        
        $.get('/paginationsProducts/'+element.attr("data-pagination"), function(data) {
            var html = '';
            for (var name in data) {
                html += '<div class="col-sm-4 col-md-3"><div class="thumbnail"><a href="/products/' + data[name]['id'] + '">';
                html += '<img src="' + data[name]['path'] + '" alt="Product" /></a><div class="caption"><h4>';
                html += '<span class="text-danger">' + data[name]['price'] + '</span> <span class="label label-danger">';
                html += 'руб.</span><button id="product-like" class="btn btn-success btn-xs pull-right">Хочу ';
                html += '<span class="badge">' + data[name]['likes'] + '</span></button></h4></div></div></div>';
            }

            if (data.length < 16) {
                element.remove();
            }

            result.append(html);
            result.animate({"opacity": 1}, 200);
            element.removeClass("disabled");
        }, 'json');
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