var ChangePassword = {
    getValue : function() {
        return {
            'Password[old_password]' : $('#Password_old_password').val(),
            'Password[password_first]' : $('#Password_password_first').val(),
            'Password[password_second]' : $('#Password_password_second').val(),
            'Password[captcha]' : $('#Password_captcha').val(),
            'Password[_token]' : $('#Password__token').val()
        };
    },
    getPreLoad : function() {
        $('.userInformation .button').animate({'opacity' : '0'}, 200, function() {
            $(this).css('display', 'none');
            $('#load').css({'display' : 'block', 'opacity' : '0'}).animate({'opacity' : '1'}, 200);
        });
        
        if ($('#error').find('h3').length > 0) {
            $('#error').stop().animate({'opacity' : '0'}, 200, function() {
                $(this).stop().slideToggle(100, function() {
                    $(this).html('');
                });
            });
        }
    },
    getError : function(data) {
        var html = '';
        var arName = {
            'old_password' : 'Старый пароль', 'password_first' : 'Пароль', 'password_second' : 'Повторить', 'captcha' : 'Капча'
        };
        
        for (var value in data) {
            html += '<h3>'+arName[value]+': '+data[value]+'</h3>';
        }
        
        $('#load').animate({'opacity' : '0'}, 200, function() {
            $(this).css('display', 'none');
            $('.userInformation .button').css('display', 'block').stop().animate({'opacity' : '1'}, 200, function() {
                $('#error').css({'display' : 'none', 'opacity' : '0'}).html(html).slideToggle(100, function() {
                    $('html, body').animate({scrollTop: $(this).offset().top}, 200, function() {
                        $('#error').stop().animate({'opacity' : '1'}, 100);
                    });
                });
            });
        });
    },
    getQuery : function() {
        this.getPreLoad();
        
        $.post('/property/changePassword', this.getValue(), function(data) {
            if (data === '0') {
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $(this).css('display', 'none');
                });
            } else {
                ChangePassword.getError(data);
            } 
        });
    },
    click : function() {
        $('#Password').submit(function() {
            if ($('#load').css('display') === 'none') {
                ChangePassword.getQuery();
            }     
            
            return false;
        });
    }
};

$(document).ready(function() {    
    ChangePassword.click();
});