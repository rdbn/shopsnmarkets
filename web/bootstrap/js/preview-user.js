$(document).ready(function() {
    /**
     *  Ajax for upload logo
     */
    $('#UploadLogoUser_file').change(function() {
        var formData = new FormData(),
            file = $(this).prop("files")[0],
            token = $("#UploadLogoUser__token").val();

        formData.append("UploadLogoUser[file]", file);
        formData.append("UploadLogoUser[_token]", token);

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
    $("#Description_save").click(function () {
        var value = {
            "Description": {
                "description": $("#Description_description").val(),
                "_token": $("#Description__token").val()
            }
        };

        $(this).addClass("disabled");
        $.post("/app_dev.php/add/description", value, function () {
            $("#Description_save").removeClass("disabled");
        });

        return false;
    });
});