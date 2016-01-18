var Search = {
    getElement : function() {
        return {
            'Search[realname]' : $('#Search_realname').val(),
            'Search[country]' : $('#Search_country').val(),
            'Search[city]' : $('#Search_city').val(),
            'Search[_token]' : $('#Search__token').val()
        };
    },    
    result : function() {
        $.post('/app_dev.php/friends/result/search', this.getElement(), function(data) {
            var html = '',
                result = $('#result-search');

            if (data.length > 0) {
                for (var value in data) {
                    var item = data[value],
                        path = (item.path !== null) ? item.path : '';

                    html += '<div class="row result-user"><div class="media"><div class="media-left col-md-3"><a href="/id/'+item.id+'">';
                    html += '<img class="media-object img-responsive img-thumbnail col-md-12" src="'+path+'" /></a></div>';
                    html += '<div class="media-body width-body"><div class="col-md-8"><h4 class="media-heading">';
                    html += item.realname+'</h4></div><div class="col-md-4"><div class="btn-group-vertical">';
                    html += '<button class="btn btn-success btn-sm add-friends" data-user="'+item.id+'">Добавить в друзья</button>';
                    html += '<a class="btn btn-success btn-sm" href="/message/sendMessage/'+item.id+'">Отправить сообщение</a>';
                    html += '</div></div></div></div>';
                }

                result.html(html).show();
                result.animate({'opacity' : '1'}, 200);
            } else {
                html = '<h5 class="text-muted">Не чиго не найдено.</h5>';

                result.html(html).show();
                result.animate({'opacity' : '1'}, 200);
            }
        }, 'json');
    }
};

$(document).ready(function() {    
    $('#search').click(function() {
        Search.result();
        
        return false;
    });
    $('#Search_city').change(function() {
        Search.result();
    });
});