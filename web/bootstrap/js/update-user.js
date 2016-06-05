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
            url: '/checkEmail/'+$("#user_information_username").val(),
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

$(document).ready(function() {
    /** check email */
    var element = $("#user_information_username");
    element.keyup(function() {
        CheckMail.checkMail($(this));
    });
    element.keydown(function() {
        CheckMail.checkMail($(this));
    });
    element.blur(function() {
        CheckMail.checkMail($(this));
    });

    /** Ajax for next Step Form Registration */
    $('#user_information_save').click(function() {
        if ($("#emails-valid").find(".alert-danger").length > 0) {
            element.focus();

            return false;
        }
    });
});