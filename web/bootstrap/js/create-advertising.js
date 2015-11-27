$(document).ready(function(){
    $('.advertising .shop label').click(function() {
        if ( $(this).find('.check_img').css('opacity') !== '1') {
            $('.advertising .shop label .check_img').animate({'opacity': '0'}, 100);
            $(this).find('.check_img').animate({'opacity': '1'}, 100);
        }
    });

    $('#Advertising_date_start').change(function() {
        if ($('#Advertising_date_end').val()) {
            var value = $('#Advertising_date_end').val();
            
            $('.advertising .formFields .price p').html((value * 5)+' руб.');
        }
    });
    $('#Advertising_date_end').change(function() {
        if ($('#Advertising_date_start').val()) {
            var value = $('#Advertising_date_end').val();
            
            $('.advertising .formFields .price p').html((value * 5)+' руб.');
        }
    });


    /**
     * Add Image Advertising Shop
     * */
    $("#AdvertisingShop_files").change(function () {
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

    $("#AdvertisingShop_save").click(function () {
        var formData = new FormData(),
            format = $('#format input:checked').val(),
            shops = $('#AdvertisingShop_shops input:checked').val(),
            files = $("#AdvertisingShop_files").prop("files"),
            token = $("#AdvertisingShop__token").val();

        formData.append("AdvertisingShop[format]", format);
        formData.append("AdvertisingShop[shops]", shops);

        for (var i in files) {
            if (typeof files[i] == "object") {
                formData.append("AdvertisingShop[files][]", files[i]);
            }
        }
        formData.append("AdvertisingShop[_token]", token);

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