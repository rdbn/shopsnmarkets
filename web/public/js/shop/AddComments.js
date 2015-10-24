var AddComments = {
    add : function() {
        var users = $('#Comments_users').val();
        var shopsname = $('#Comments_shopname').val();
        var text = $('#Comments_text').val();
        var token = $('#Comments__token').val();
        
        $.post("/app_dev.php/addCommentsShop", {
            type : 'POST',
            'Comments[users]' : users,
            'Comments[shopname]' : shopsname,
            'Comments[text]' : text,
            'Comments[_token]' : token
            },
            function(data){
                if (data !== '') {
                    var html = '<div class="comment">';
                    html += '<img src="'+data['user_img']+'" />';
                    html += '<ul><li><h3>'+data['user_name']+'</h3></li>';
                    html += '<li><p>'+data['text']+'</p></li></ul>';
                    html += '</div>';
                    
                    $('.comments').append(html).show();
                    $('.comments').scrollTop($('.comments').get(0).scrollHeight);
                }
            }, 'json');
    }
};


$(document).ready(function(){
    $('#addComments').submit(function() {
        if ($('#Comments_text').val() !== undefined) {
            AddComments.add();
        }
        
        $('#Comments_text').val('');
        return false;
    });
    
    $('.comments').scrollTop($('.comments').get(0).scrollHeight);
});