var CheckMail = {
    showBad: function (element) {
        if (element.hasClass("has-success")) {
            element.removeClass("has-success");
            element.removeClass("has-feedback");
            element.find(".glyphicon-ok").addClass("hide");
        }

        element.addClass("has-error has-feedback");
        element.find(".glyphicon-remove").removeClass("hide");
    },
    sendMail : function(element) {
        $.ajax({
            method: "GET",
            url: '/checkEmail/'+$('#registration_username').val(),
            statusCode: {
                200: function() {
                    if (element.hasClass("has-error")) {
                        element.removeClass("has-error");
                        element.removeClass("has-feedback");
                        element.find(".glyphicon-remove").addClass("hide");
                    }

                    element.addClass("has-success has-feedback");
                    element.find(".glyphicon-ok").removeClass("hide");

                    $('#emails-valid')
                        .html('<div class="alert alert-success" role="alert">Нет пользователя с таким <strong>Email</strong></div>');
                },
                402: function() {
                    CheckMail.showBad(element);
                    $('#emails-valid')
                        .html('<div class="alert alert-danger" role="alert">Не коректный <strong>Email</strong></div>');
                },
                403: function() {
                    CheckMail.showBad(element);
                    $('#emails-valid')
                        .html('<div class="alert alert-danger" role="alert"><strong>Email</strong> уже занят!</div>');
                }
            }
        });
    },
    checkMail : function(element) {
        var parent = element.parents(".form-group");
        if (element.val().length > 7) {
            this.sendMail(parent);
        } else {
            CheckMail.showBad(parent);
            $('#emails-valid')
                .html('<div class="alert alert-danger" role="alert">Не коректный <strong>Email</strong></div>');
        }
    }
};

var Check = {
    password : function() {
        var first = $('#registration_password_first'),
            second = $('#registration_password_second'),
            element = second.parents(".form-group");

        if (first.val() === second.val()) {
            if (element.hasClass("has-error")) {
                element.removeClass("has-error");
                element.removeClass("has-feedback");
                element.find(".glyphicon-remove").addClass("hide");
            }

            element.addClass("has-success has-feedback");
            element.find(".glyphicon-ok").removeClass("hide");

            $("#password-valid")
                .html('<div class="alert alert-success" role="alert">Пароли <strong>совпадают</strong></div>');
        } else {
            if (element.hasClass("has-success")) {
                element.removeClass("has-success");
                element.removeClass("has-feedback");
                element.find(".glyphicon-ok").addClass("hide");
            }

            element.addClass("has-error has-feedback");
            element.find(".glyphicon-remove").removeClass("hide");

            $("#password-valid")
                .html('<div class="alert alert-danger" role="alert">Пароли <strong>не совпадают</strong></div>');
        }
    }
};

$(document).ready(function(){
    /** check email */
    var registrationEmail = $("#registration_username");
    registrationEmail.keyup(function() {
        CheckMail.checkMail($(this));
    });
    registrationEmail.keydown(function() {
        CheckMail.checkMail($(this));
    });
    registrationEmail.blur(function() {
        CheckMail.checkMail($(this));
    });

    /** check password */
    var registrationPassword = $("#registration_password_second");
    registrationPassword.keyup(function() {
        Check.password();
    });
    registrationPassword.keyup(function() {
        Check.password();
    });
    registrationPassword.blur(function() {
        Check.password();
    });

    /** Ajax for next Step Form Registration */
    $('#registration_save').click(function() {
        if ($("#emails-valid").find(".alert-danger").length > 0) {
            return false;
        }

        if ($("#password-valid").find(".alert-danger").length > 0) {
            return false;
        }
    });
});