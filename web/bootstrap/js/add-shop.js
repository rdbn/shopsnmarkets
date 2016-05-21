var CheckUniqueName = {
    howBad: function (element) {
        if (element.hasClass("has-success")) {
            element.removeClass("has-success");
            element.removeClass("has-feedback");
            element.find(".glyphicon-ok").addClass("hide");
        }

        element.addClass("has-error has-feedback");
        element.find(".glyphicon-remove").removeClass("hide");
    },
    send: function(element) {
        var id = $('#shops_id').val(),
            parent = element.parents(".form-group");

        if (id.length > 0) {
            id = "/"+id;
        }

        $.ajax({
            method: "GET",
            url: '/app_dev.php/user/shop/uniqueName/'+$('#shops_uniqueName').val()+id,
            statusCode: {
                200: function() {
                    if (parent.hasClass("has-error")) {
                        parent.removeClass("has-error");
                        parent.removeClass("has-feedback");
                        parent.find(".glyphicon-remove").addClass("hide");
                    }

                    parent.addClass("has-success has-feedback");
                    parent.find(".glyphicon-ok").removeClass("hide");
                },
                403: function() {
                    CheckUniqueName.howBad(parent);
                }
            }
        });
    },
    check: function(element) {
        element.val(element.val().replace(/[^\da-z0-9]/gi, ''));

        if (element.val().length > 4) {
            this.send(element);
            
            return true;
        } else {
            var parent = element.parents(".form-group");
            CheckUniqueName.howBad(parent);

            return false;
        }
    }
};

$(document).ready(function() {
    $.get("/hashTags", function (data) {
        var tags = [];
        for (var i in data) {
            tags[i] = {value: data[i].name};
        }

        $('#shops_shopTags').tokenfield({
            autocomplete: {
                source: tags,
                delay: 100
            },
            showAutocompleteOnFocus: true
        });
    });

    var element = $('#shops_uniqueName');
    element.keyup(function() {
        CheckUniqueName.check(element);
    });
    element.keydown(function() {
        CheckUniqueName.check(element);
    });

    $("#shops_save").click(function () {
        var parent = element.parents(".form-group");
        if (parent.hasClass("has-error")) {
            element.focus();

            return false;
        }

        return true;
    });

    /**
     *  Ajax for upload logo
     */
    $('#upload_logo_file').change(function() {
        var formData = new FormData(),
            file = $(this).prop("files")[0],
            token = $("#upload_logo__token").val();

        formData.append("upload_logo[file]", file);
        formData.append("upload_logo[_token]", token);

        $.ajax({
            url: "/user/shop/addLogo",
            type: "post",
            dataType: "text",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            enctype: 'multipart/form-data',
            success: function (data) {
                var path = JSON.parse(data).path;
                $("#preview-img").attr("src", path);
            }
        });
    });
});