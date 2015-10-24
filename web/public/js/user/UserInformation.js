var UserInformation = {
    getValue : function() {
        return {
            'UserInformation[realname]' : $('#UserInformation_realname').val(),
            'UserInformation[email]' : $('#UserInformation_email').val(),
            'UserInformation[country]' : $('#UserInformation_country').val(),
            'UserInformation[city]' : $('#UserInformation_city').val(),
            'UserInformation[street]' : $('#UserInformation_street').val(),
            'UserInformation[home_index]' : $('#UserInformation_home_index').val(),
            'UserInformation[phone]' : $('#UserInformation_phone').val(),
            'UserInformation[skype]' : $('#UserInformation_skype').val(),
            'UserInformation[captcha]' : $('#UserInformation_captcha').val(),
            'UserInformation[_token]' : $('#UserInformation__token').val()
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
            'realname' : 'Фамилия/Имя', 'email' : 'Email', 'email_check' : 'Email', 'country' : 'Страна', 'city' : 'Город',
            'street' : 'Улица', 'home_index' : 'Индекс', 'phone' : 'Телефон', 'skype' : 'Skype', 'captcha' : 'Капча'
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
        
        $.post('/property/addInformation', this.getValue(), function(data) {
            if (data === '0') {
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $(this).css('display', 'none');
                });
            } else {
                UserInformation.getError(data);
            } 
        });
    },
    click : function() {
        $('#UserInformation').submit(function() {
            if (!CheckMail.checkMail()) {
                $('#UserInformation_email').focus();
            } else {
                if ($('#load').css('display') === 'none') {
                    UserInformation.getQuery();
                }
            }            
            
            return false;
        });
    }
};
CheckMail = {
    email : function() {
        var value = $('#UserInformation_email').val();
        
        return value;
    },
    sendMail : function() {
        var check = $.post('/emailProperty', { 'email' : this.email() });
        check.done(function(data) {
            if (data === '0') {
                $('#checkEmail').text('+').show();
                $('#checkEmail').addClass('plus');
                $('#checkEmail').removeClass('minus');

                return true;
            } else {
                $('#checkEmail').text('-').show();
                $('#checkEmail').addClass('minus');
                $('#checkEmail').removeClass('plus');

                return false;
            }
        });
    },
    checkMail : function() {
        if (this.email().length >10) {
            this.sendMail();
            
            return true;
        } else {
            return false;
        }
    }
};

$(document).ready(function() {
    /* check email */
    $("#UserInformation_email").focus(function(){
        CheckMail.checkMail();
    });
    $("#UserInformation_email").keyup(function(){
        CheckMail.checkMail();
    });
    $("#UserInformation_email").blur(function(){
        CheckMail.checkMail();
    });
    
    UserInformation.click();
});