var Unread = {
    getUrl : function() {
        var href = location.href.split('/');
        var url = '/message/unread/';
        
        if (4 in href) {
            url += href['4'];
        } else {
            this.url = url += 'all';
        }
        
        return url;
    },
    getPreLoad : function() {
        $('#content .allMessage').animate({'opacity' : '0'}, 200, function() {
            $('#content .allMessage').slideToggle('200');
            $('#load').css({'opacity' : '0', 'display' : 'block'});
            $('#load').animate({'opacity' : '1'}, 200);
        });
    },
    getEndLoad : function(data) {
        var html = '';
        
        if ('take' in data) {
            for (var value in data) {
                for (var index in data[value]) {
                    html += '<a class="user" href="/message/userMessage/'+data[value][index]['id']+'">';
                    html += '<img src="/media/cache/mini_avatar/'+data[value][index]['path']+'" />';
                    html += '<span class="name">'+data[value][index]['realname']+'</span>';
                    html += '<span class="text">'+data[value][index]['text']+'</span></a>';
                }
            }
        } else {
            for (var value in data) {
                html += '<a class="user" href="/message/userMessage/'+data[value]['id']+'">';
                html += '<img src="/media/cache/mini_avatar/'+data[value]['path']+'" />';
                html += '<span class="name">'+data[value]['realname']+'</span>';
                html += '<span class="text">'+data[value]['text']+'</span></a>';
            }
        }
        
        $('#content .allMessage').html(html).slideToggle('200', function() {
            $('#load').animate({'opacity' : '0'}, 200, function() {
                $(this).css('display', 'none');
                $('#content .allMessage').animate({'opacity' : '1'}, 200);
            });
        });
    },
    getQuery : function() {
        this.getPreLoad();
        
        $.get(this.getUrl(), function(data) {
            if (data !== null) {
                Unread.getEndLoad(data);
            }
        });
    },
    click : function() {
        $('#content .unread a').click(function() {
            Unread.getQuery($(this));
            
            return false;
        });
    }
};
var Draft = {
    getValue : function(element) {
        return {
            'id' : element.attr('id')
        };
    },
    getPreLoad : function(element) {
        element.parents('.user').animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
    },
    getQuery : function(element) {
        this.getPreLoad(element);
        
        $.get('/message/userMessage/basketDialog', this.getValue(element));
    },
    click : function() {
        $('#content .allMessage').on('click', '.user .delete', function() {
            Draft.getQuery($(this));
            
            return false;
        });
    }
};

$(document).ready(function(){
    Unread.click();
    Draft.click();
    
    $('#content .allMessage .user').hover(function() {
        $(this).find('.delete').stop().animate({'opacity' : '1'}, 400);
    }, function() {
        $(this).find('.delete').stop().animate({'opacity' : '0'}, 400);
    });
});