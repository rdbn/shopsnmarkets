$(document).ready(function() {
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
            url: "/avatar/upload",
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

    /**
     * Добавляем описание для магазина
     */
    $("#description_save").click(function () {
        var value = {
            "description": {
                "description": $("#description_description").val(),
                "_token": $("#description__token").val()
            }
        };

        $(this).addClass("disabled");
        $.post("/app_dev.php/add/description", value, function () {
            $("#description_save").removeClass("disabled");
        });

        return false;
    });
});