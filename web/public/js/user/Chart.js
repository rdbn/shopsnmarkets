var ValueMessage = {
    getDate : function() {
        var date = new Date();
        var year = date.getFullYear();
        var mouth = (date.getMonth() < 10) ? '0'+(date.getMonth()+1) : date.getMonth();
        var day = (date.getDate() < 10) ? '0'+date.getDate() : date.getDate();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        
        return year+'-'+mouth+'-'+day+' '+hours+':'+minutes+':'+seconds;
    },
    getValue : function() {
        return {
            dialog : $('#dialog').val(),
            user : $('#user').val(),
            path : $('#path').val(),
            realname : $('#realname').val(),
            text : $('#text').val(),
            date : this.getDate()
        };
    }
};

$(document).ready(function(){    
    var socket = io.connect('http://ornest.com:8000');
    
    socket.on('connect', function() {
        socket.emit('message', { id : $('#dialog').val() });
    });
    
    socket.on('message', function(message) {
        if (!message.hasOwnProperty('id')) {
            var html = '';

            html += '<div class="message unread">';
            html += '<span class="tick"></span><img src="'+message.path+'">';
            html += '<ul><li><span id="'+message.id_messages+'" class="messageId"></span></li>';
            html += '<li><h3>'+message.realname+'<span>'+message.date+'</span></h3></li>';
            html += '<li><p>'+message.text+'</p></li></ul></div>';

            $('#text').val('').focus();
            $('#content .messages').append(html);
            $('#content .messages').scrollTop($('#content .messages').get(0).scrollHeight);
        }
    });
    
    $('#text').keypress(function(event) {
        if (event.keyCode === 13) {
            if ($.trim($(this).val()) !== '') {
                var value = ValueMessage.getValue();
                $(this).val('').focus();
                socket.emit('message', value);
            } else {
                $('#text').val('').focus();
            }
        }
    });
    
    $('.formMessage .button').click(function() {
        if ($.trim($(this).val()) !== '') {
            var value = ValueMessage.getValue();
            $(this).val('').focus();
            socket.emit('message', value);
        } else {
            $('#text').val('').focus();
        }
        
        return false;
    });
});