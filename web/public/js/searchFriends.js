var SearchFriends = {
    getElement : function() {
        return {
            'searchUsers[keywords]' : $('#SearchUsers_keywords').val(),
            'searchUsers[country]' : $('#SearchUsers_country').val(),
            'searchUsers[city]' : $('#SearchUsers_city').val(),
            'searchUsers[_token]' : $('#SearchUsers__token').val()
        };
    },    
    result : function() {
        $('#resualtSearch').css('opacity', '1');
        $('#resualtSearch').animate({'opacity' : '0'}, 200, function() {
            $('#load').css({'display' : 'block', 'opacity' : '1'});
            $('#load').animate({'opacity' : '1'}, 200);
        });
        
        $.post('/friends/resualtSearch', this.getElement(), function(data) {
            if (data !== '') {
                var html = '';
                var path = '';
                
                for (var value in data) {
                    path = (data[value]['path'] !== null)?data[value]['path']:'';
                    html += '<div class="resultUser">';
                    html += '<a href="/id/'+data[value]['id']+'"><img src="'+path+'" /></a>';
                    html += '<h3>'+data[value]['realname']+'</h3><ul>';
                    html += '<li><a class="addFriends" href="'+data[value]['id']+'">Добавить в друзья';
                    html += '<span class="load"><img src="/public/images/load/ajax-loader-button-second.gif" /></span></a></li>';
                    html += '<li><a class="sendMessage" href="/message/sendMessage/'+data[value]['id']+'">Отправить сообщение</a></li>';
                    html += '</ul></div>';
                }
                
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $('#load').css({'display' : 'none'});
                    $('#resualtSearch').html(html).show();
                    $('#resualtSearch').animate({'opacity' : '1'}, 200);
                });
            } else {
                var html = '<h3>Не чиго не найдено.</h3>';
                
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $('#load').css({'display' : 'none'});
                    $('#resualtSearch').html(html).show();
                    $('#resualtSearch').animate({'opacity' : '1'}, 200);
                });
            }
        }, 'json');
    }
};

$(document).ready(function() {    
    $('#formSearchUsers').submit(function() {
        SearchFriends.result();
        
        return false;
    });
    $('#SearchUsers_city').change(function() {
        SearchFriends.result();
    });
});