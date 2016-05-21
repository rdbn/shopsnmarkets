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
        $.post('/friends/result/search', this.getElement(), function(data) {
            var html = '',
                result = $('#result-search');

            if (data.length > 0) {
                for (var value in data) {
                    var item = data[value],
                        path = (item.path !== null) ? item.path : '';

                    html += '<div class="col-md-12 result-user top20"><div class="media"><div class="media-left"><a href="/user/'+item.id+'">';
                    html += '<img class="media-object img-responsive img-thumbnail" src="'+path+'" /></a></div>';
                    html += '<div class="media-body width-body"><h4 class="media-heading text-success">';
                    html += item.realname+'</h4><div class="btn-group-vertical top20">';
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