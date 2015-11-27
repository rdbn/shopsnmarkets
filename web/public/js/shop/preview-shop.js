$(document).ready(function(){
    var path = window.location.pathname.split("/");
    var shopname = path[path.length-1];

    /**
     *  Ajax for upload logo
     */
    $('#UploadLogoShop_file').change(function() {
        var formData = new FormData(),
            file = $(this).prop("files")[0],
            token = $("#UploadLogoShop__token").val();

        formData.append("UploadLogoShop[file]", file);
        formData.append("UploadLogoShop[_token]", token);

        $.ajax({
            url: "/manager/createShop/addLogo/"+shopname,
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
        $.post("/manager/createShop/description/"+shopname, value, function () {
            $("#Description_save").removeClass("disabled");
        });
    });
});