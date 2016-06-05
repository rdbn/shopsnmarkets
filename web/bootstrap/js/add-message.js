var AddMessages = {
    getQuery : function(element) {
        var id = element.attr('data-user'),
            text = $("#messages_text"),
            message = {
                'messages[text]': text.val(),
                'messages[_token]': $("#messages__token").val()
            };

        text.val("");
        $.post('/message/dialog/add/'+id, message);
    },
    add : function() {
        $('#messages_save').click(function() {
            var text = $("#messages_text").val();
            if (text) {
                AddMessages.getQuery($(this));
            }
                
            return false;
        });
    }
};
$(document).ready(function(){
    AddMessages.add();

    var element = $("#friends");
    if (element.length > 0) {
        element.on("click", ".send-message", function () {
            $('#messages_save').attr('data-user', $(this).attr('data-user'))
        })
    } else {
        $('#add-message').click(function () {
            $('#messages_save').attr('data-user', $(this).attr('data-user'))
        });
    }
});