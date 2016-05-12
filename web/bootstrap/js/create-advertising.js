/*$('.advertising .shop label').click(function() {
    if ( $(this).find('.check_img').css('opacity') !== '1') {
        $('.advertising .shop label .check_img').animate({'opacity': '0'}, 100);
        $(this).find('.check_img').animate({'opacity': '1'}, 100);
    }
});*/
$(document).ready(function(){
    /**
     * Add Advertising Platform
     * */
    var watch = $('#advertising_platform_date_start'), duration = $('#advertising_platform_date_end');
    watch.change(function() {
        var val = duration.val();
        if (val.length > 0) $('#price').html((val * 5)+' руб.');
    });

    duration.change(function() {
        if (watch.val().length > 0) $('#price').html((duration.val() * 5)+' руб.');
    });

    $("#advertising_platform_file").change(function () {
        var file = this.files[0], previewElement = $("#preview-img");
        if (file.length == 0) return false;

        previewElement.html("");

        var reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = function(event) {
            var canvas = $("<canvas />", {
                class: "img-thumbnail preview-img",
                width: 150,
                height: 150
            })[0];

            var context = canvas.getContext('2d');

            var img = new Image();
            img.onload = function(){
                canvas.width = img.width;
                canvas.height = img.height;
                context.drawImage(img, 0, 0);
            };
            img.src = event.target.result;

            previewElement.append(canvas);
        };
    });

    $("#advertising_platform_save").click(function () {
        var formData = new FormData();
        formData.append("advertising_platform[format]", $('#format input:checked').val());
        formData.append("advertising_platform[date_start]", $('#advertising_platform_date_start').val());
        formData.append("advertising_platform[date_end]", $('#advertising_platform_date_end').val());
        formData.append("advertising_platform[shops]", $('#advertising_platform_shops input:checked').val());
        formData.append("advertising_platform[file]", $("#advertising_platform_file").prop("files")[0]);
        formData.append("advertising_platform[_token]", $("#advertising_platform__token").val());

        //$(this).prop("disabled", true);

        $.ajax({
            url: "/app_dev.php/advertising/createPlatform",
            type: "post",
            dataType: "text",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            enctype: 'multipart/form-data',
            success: function (data) {
                data = JSON.parse(data);

                var html = "Место рекламы: "  + data.format;
                html += "Название магазина: "  + data.shop;
                html += "<img class='img-thumbnail top20' src='"+data.path+"' />";

                $("#result").html(html);
            }
        });

        return false;
    });


    /**
     * Add Image Advertising Shop
     * */
    $("#advertising_shop_files").change(function () {
        var files = this.files, previewElement = $("#preview-img");
        if (files.length == 0) return false;

        previewElement.html("");
        for (var count = 0 in files) {
            var file = files[count];
            if (!(file instanceof File)) break;

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                var canvas = $("<canvas />", {
                    class: "img-thumbnail preview-img",
                    width: 150,
                    height: 150
                })[0];

                var context = canvas.getContext('2d');

                var img = new Image();
                img.onload = function(){
                    canvas.width = img.width;
                    canvas.height = img.height;
                    context.drawImage(img, 0, 0);
                };
                img.src = event.target.result;

                previewElement.append(canvas);
            };

            if (count == 3) break;
        }
    });

    $("#advertising_shop_save").click(function () {
        var formData = new FormData(),
            format = $('#format input:checked').val(),
            shops = $('#advertising_shop_shops input:checked').val(),
            files = $("#advertising_shop_files").prop("files"),
            token = $("#advertising_shop__token").val();

        formData.append("advertising_shop[format]", format);
        formData.append("advertising_shop[shops]", shops);

        for (var i in files) {
            if (typeof files[i] == "object") {
                formData.append("advertising_shop[files][]", files[i]);
            }
        }
        formData.append("advertising_shop[_token]", token);

        $(this).prop("disabled", true);

        $.ajax({
            url: "/app_dev.php/advertising/createShop",
            type: "post",
            dataType: "text",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            enctype: 'multipart/form-data',
            success: function (data) {
                data = JSON.parse(data);

                var html = "";
                for (var i in data) {
                    html += "<img class='img-thumbnail top20' src='"+data[i]+"' />";
                }

                $("#result").html(html);
            }
        });

        return false;
    });
});