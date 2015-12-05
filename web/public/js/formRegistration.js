CheckMail = {
    email : function() {
        var value = $('#Registration_email').val();
        
        return value;
    },
    sendMail : function() {
        var check = $.post('/checkEmail', { 'email' : this.email() });
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
var Check = {
    password : function() {
        var valueFirst = $('#Registration_password_first').val();
        var valueSecond = $('#Registration_password_second').val();

        if (valueFirst === valueSecond) {
            $('#checkPassword').text('+').show();
            $('#checkPassword').addClass('plus');
            $('#checkPassword').removeClass('minus');

            return true;
        } else {
            $('#checkPassword').text('-').show();
            $('#checkPassword').addClass('minus');
            $('#checkPassword').removeClass('plus');

            return false;
        }
    },
    form : function() {
        if (Check.password()) {
            return true;
        } else {
            return false;
        }
    }
};
$(document).ready(function(){
    /* check email */
    var registrationEmail = $("#Registration_email");
    registrationEmail.focus(function() {
        CheckMail.checkMail();
    });
    registrationEmail.keyup(function() {
        CheckMail.checkMail();
    });
    registrationEmail.blur(function() {
        CheckMail.checkMail();
    });
    /* Check password */
    $('#Registration_password_second').keyup(function() {
        Check.password();
    });
    /* Ajax for next Step Form Registration */
    $('.formRegistration form').submit(function() {
        if (!Check.form()) {
            $('#Registration_password_second').focus();
            
            return false;
        }
        
        if (!CheckMail.checkMail()) {
            $('#Registration_email').focus();
            
            return false;
        }
        return true;
    });
});