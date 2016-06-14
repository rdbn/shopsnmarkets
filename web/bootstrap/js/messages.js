var SendMessage = {
    username: null,
    usernameTo: null,
    chat: null,
    addMessage: function (data, isFrom) {
        var element = $("#all-messages"),
            path = element.attr('data-path-to');

        if (isFrom) {
            path = element.attr('data-path-from');
        }

        var html = '<div class="col-md-12 bottom10">';
        if (isFrom) {
            html += '<div class="well well-sm bottom0 pull-right col-md-4" data-user="'+data.from+'">';
        } else {
            html += '<div class="well well-sm bottom0 col-md-4" data-user="'+data.from+'">';
        }

        html += '<div class="media"><div class="media-left"><a href="#"><img class="media-object" src="'+path+'">';
        html += '</a></div><div class="media-body"><p class="small text-muted">'+data.date+'</p><p>'+data.message+'</p>';
        html += '</div></div></div>';

        return html;
    },
    connect: function () {
        var domain = window.location.hostname ;
        domain = domain == 'shopsnmarkets.com' ? domain+':88' : 'localhost:8080';

        SendMessage.chat = io.connect('http://'+domain+'/chat');

        var element = $("#all-messages");
        SendMessage.username = "username_"+element.attr('data-user');
        SendMessage.usernameTo = "username_"+element.attr('data-to');

        SendMessage.chat.emit("addUser", {
            username: SendMessage.username
        });
    },
    take: function () {
        SendMessage.chat.on('message', function (data) {
            var main = $("#all-messages");
            main.append(SendMessage.addMessage(data, false));
            main.scrollTop(main.get(0).scrollHeight);
        });
    },
    send: function () {
        var main = $("#all-messages"),
            date = new Date();

        $('#messages_text').keypress(function(event) {
            if (event.keyCode === 10 && $(this).val() !== '') {
                var data = {
                    from: SendMessage.username,
                    to: SendMessage.usernameTo,
                    message: $(this).val(),
                    date: date.format("yyyy-mm-dd HH:MM:ss")
                };

                $(this).val("");

                SendMessage.chat.emit('message', data);
                main.append(SendMessage.addMessage(data, true));
                main.scrollTop(main.get(0).scrollHeight);
            }
        });

        $('#messages_save').click(function() {
            var element = $('#messages_text'),
                text = element.val();
            if (text !== '') {
                var data = {
                    from: SendMessage.username,
                    to: SendMessage.usernameTo,
                    message: text,
                    date: date.format("yyyy-mm-dd HH:MM:ss")
                };

                element.val("");

                SendMessage.chat.emit('message', data);
                main.append(SendMessage.addMessage(data, true));
                main.scrollTop(main.get(0).scrollHeight);
            }
        });
    }
};
var CheckMessage = {
    username: null,
    usernameTo: null,
    chat: null,
    connect: function () {
        var domain = window.location.hostname ;
        domain = domain == 'shopsnmarkets.com' ? domain+':88' : 'localhost:8080';

        CheckMessage.chat = io.connect('http://'+domain+'/checkRead');
    },
    take: function () {
        CheckMessage.chat.on('check-read', function (data) {
            $("#all-messages").find('.message-user .unread-message').each(function () {
                var element = $(this);
                element.removeClass('unread-message');
                element.find("span").addClass('text-success');
            });
        });
    },
    send: function () {
        var element = $("#all-messages");
        CheckMessage.username = "username_"+element.attr('data-user');
        CheckMessage.usernameTo = "username_"+element.attr('data-to');

        CheckMessage.chat.emit("check", {
            from: CheckMessage.username,
            to: CheckMessage.usernameTo
        });
    }
};

var Delete = {
    getValue : function() {
        var arValue = [];
        $('#content').find('.messageBasket .click').each(function() {
            arValue.push($(this).find('.messageId').attr('id'));
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
            $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200, function() {
                    $(this).remove();
                });
            });
        });
        
        return {
            'id' : arValue
        };
    },
    getQuery : function() {
        $.get('/message/userMessage/delete', this.getValue());
    },
    click : function() {
        $('#content').on('click', '.addMenu .delete', function() {
            Delete.getQuery();
            
            return false;
        });
    },
    select : function() {
        $('#content').on('click', '.messageBasket .message', function() {
            if (!$(this).hasClass('click')) {
                $(this).addClass('click');
                $(this).find('.tick').animate({'opacity' : '1'}, 200, function() {
                    var html = '<ul class="addMenu"><li><a class="delete" href="#">Удалить</a></li>';
                    html += '<li><a class="reestablish" href="#">Восстановить</a></li></ul>';

                    if ($('#content .menuMessages').find('.addMenu').length === 0) {
                        $('#content .menuMessages').append(html).find('.addMenu').slideToggle(200, function() {
                            $(this).animate({'opacity' : '1'}, 200);
                        });
                    }
                });
            } else {
                $(this).removeClass('click');
                $(this).find('.tick').animate({'opacity' : '0'}, 200, function() {
                    var check = true;
                    $('#content').find('.messageBasket .message').each(function() {
                        if ($(this).find('.tick').css('opacity') === '1') {
                            check = false;
                        }
                    });
                    if (check) {
                        $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
                            $(this).slideToggle(200, function() {
                                $(this).remove();
                            });
                        });
                    }
                });
            }
        });
    }
};

$(document).ready(function() {
    SendMessage.connect();
    SendMessage.take();
    SendMessage.send();

    CheckMessage.connect();
    CheckMessage.take();
    CheckMessage.send();

    Delete.select();
    Delete.click();

    var main = $("#all-messages");
    main.scrollTop(main.get(0).scrollHeight);

    $('#content').on('click', '.messages .message', function() {
        if (!$(this).hasClass('click')) {
            $(this).addClass('click');
            $(this).find('.tick').animate({'opacity' : '1'}, 200, function() {
                var html = '<ul class="addMenu"><li><a class="basket" href="#">В корзину</a></li></ul>';

                if ($('#content .menuMessages').find('.addMenu').length === 0) {
                    $('#content .menuMessages').append(html).find('.addMenu').slideToggle(200, function() {
                        $(this).animate({'opacity' : '1'}, 200);
                    });
                }
            });
        } else {
            $(this).removeClass('click');
            $(this).find('.tick').animate({'opacity' : '0'}, 200, function() {
                var check = true;
                $('#content').find('.messages .message').each(function() {
                    if ($(this).find('.tick').css('opacity') === '1') {
                        check = false;
                    }
                });
                if (check) {
                    $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
                        $(this).slideToggle(200, function() {
                            $(this).remove();
                        });
                    });
                }
            });
        }
    });
});