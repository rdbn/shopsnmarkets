function login() {
    $(window).unload(function() {
        parent.document.location = '/';
        parent.$.fancybox.close();
    });
}

SendMessage = {
    getElement : function() {
        return {
            'Message[dialog][send]' : $('#Message_dialog_send').val(),
            'Message[dialog][take]' : $('#Message_dialog_take').val(),
            'Message[users]' : $('#Message_users').val(),
            'Message[text]' : $('#Message_text').val(),
            'Message[_token]' : $('#Message__token').val()
        };
    },
    sendMessage : function() {
        $('#sendMessage').submit(function() {
            parent.$.fancybox.close();
            $.post('/message/addMessage', SendMessage.getElement());
            
            return false;
        });
    }
};

var AddAdderss = {
    getElement : function() {
        return {
            'AddAddress[realname]' : $('#AddAddress_realname').val(),
            'AddAddress[country]' : $('#AddAddress_country').val(),
            'AddAddress[city]' : $('#AddAddress_city').val(),
            'AddAddress[street]' : $('#AddAddress_street').val(),
            'AddAddress[home_index]' : $('#AddAddress_home_index').val(),
            'AddAddress[email]' : $('#AddAddress_email').val(),
            'AddAddress[phone]' : $('#AddAddress_phone').val(),
            'AddAddress[skype]' : $('#AddAddress_skype').val(),
            'AddAddress[_token]' : $('#AddAddress__token').val()
        };
    },
    addInformation : function() {
        $.post('/addAddress', this.getElement(), function(data) {
            if (data !== '') {
                parent.$.fancybox.close();
            } else {
                
            }
        });
    },
    sendForm : function() {
        $('#addAddress').submit(function() {
            AddAdderss.addInformation();
            
            return false;
        });
    }
};

var AddPreview = {
    getElement : function() {
        return {
            'PreviewShop[shopname]' : $('#PreviewShop_shopname').val(),
            'PreviewShop[text_preview]' : $('#PreviewShop_text_preview').val(),
            'PreviewShop[text_main]' : $('#PreviewShop_text_main').val(),
            'PreviewShop[_token]' : $('#PreviewShop__token').val()
        };
    },
    getQuery : function() {
        $('#preview .button').animate({'opacity' : '0'}, 200, function() {
            $('#preview .button').css('display', 'none');
            $('#load').css({'display' : 'block', 'opacity' : '0'});
            $('#load').animate({'opacity' : '1'}, 200);
        });
        
        $.post('/manager/shop/previewSave', this.getElement(), function(data) {
            if (data === '0') {
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $('#load').css('display', 'none');
                    $('#preview .button').css({'display' : 'block', 'opacity' : '0'});
                    $('#preview .button').animate({'opacity' : '1'}, 200);
                });
                
                parent.$.fancybox.close();
            }
        });
    },
    sendForm : function() {
        $('#preview').submit(function() {
            AddPreview.getQuery();
            
            return false;
        });
    }
};


$(document).ready(function() {        
    SendMessage.sendMessage();
    AddAdderss.sendForm();
    AddPreview.sendForm();
    
    $(".auth .vk").click(function(){
        login();
    });
    
    $(".auth .fb").click(function(){
        login();
    });
    
    $(".auth .gl").click(function(){
        login();
    });
});