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

        var html = '<div class="col-md-12 bottom10 message-user">';
        if (isFrom) {
            html += '<div class="well well-sm bottom0 pull-right col-md-4" data-user="'+data.from+'">';
        } else {
            html += '<div class="well well-sm bottom0 col-md-4" data-user="'+data.from+'">';
        }

        html += '<div class="media"><div class="media-left"><a href="#"><img class="media-object" src="'+path+'"></a></div>';
        html += '<div class="media-body"><p class="small text-muted">'+data.date+' <span class="glyphicon glyphicon-ok"></span>';
        html += '</p><p>'+data.message+'</p></div></div></div>';

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
    main: $("#all-messages"),
    getQuery : function(element) {
        var ids = [];
        Delete.main.find('.alert-success').each(function() {
            var element = $(this);
            ids.push(element.attr('data-toggle'));

            element.remove();
        });

        element.addClass('disabled');
        $.post('/app_dev.php/message/messages/remove', {id: ids}, function () {
            element.removeClass('disabled');
        });
    },
    remove : function() {
        $('#remove-message').click(function() {
            Delete.getQuery($(this));
        });
    },
    select : function() {
        Delete.main.on('click', '.message-user', function() {
            if ($(this).hasClass('alert-success')) {
                $(this).removeClass('alert-success');

                if (Delete.main.find('.alert-success').length == 0) {
                    $('#remove-message').addClass('hide');
                }
            } else {
                $(this).addClass('alert-success');

                if (Delete.main.find('.alert-success').length > 0) {
                    $('#remove-message').removeClass('hide');
                }
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
    Delete.remove();

    var main = $("#all-messages");
    main.scrollTop(main.get(0).scrollHeight);
});