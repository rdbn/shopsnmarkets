$(document).ready(function() {
    $.get("/hashTags", function (data) {
        var tags = [];
        for (var i in data) {
            tags[i] = {value: data[i].name};
        }

        $('#product_hashTags').tokenfield({
            autocomplete: {
                source: tags,
                delay: 100
            },
            showAutocompleteOnFocus: true
        });
    });

    $("#preview-img").on("click", ".remove-image", function () {
        var element = $(this),
            value = element.attr("data-toggle");

        element.addClass("disabled");
        $.post("/app_dev.php/removeProductImage", {image: value}, function () {
            element.parent(".image").remove();

            if ($("#preview-img .image").length == 0) {
                var html = '<div class="col-md-3 image">';
                html += '<button class="btn btn-danger disabled" type="button">Удалить</button>';
                html += '<img class="img-thumbnail preview-img top10" width="150" height="150" /></div>';

                $("#preview-img").html(html);
            }
        });
    });

    $("#product_image_file").change(function () {
        var files = $(this).prop("files"),
            formData = new FormData();

        if (files.length == 0) return false;

        for (var count in files) {
            var file = files[count];
            if (!(file instanceof File)) break;
            formData.append("product_image[file][]", file);
        }

        formData.append("product_image[_token]", $("#product_image__token").val());

        $.ajax({
            url: "/app_dev.php/addImageProduct",
            type: "post",
            dataType: "text",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            enctype: 'multipart/form-data',
            success: function (data) {
                var parent = $("#preview-img"),
                    value = JSON.parse(data),
                    html = '';

                for (var i in value.images) {
                    var key = value.images[i].match(/upload_product_image\/(.*)/i),
                        image = value.images[i];

                    html += '<div class="col-md-3 image">';
                    html += '<button class="btn btn-danger remove-image" data-toggle="' + key[1] + '" type="button">Удалить</button>';
                    html += '<img class="img-thumbnail top10" src="' + image + '" width="150" height="150" /></div>';
                }

                if (parent.find('.image img').attr('src') == undefined) {
                    parent.find('.image').remove();
                    parent.html(html);
                } else {
                    parent.append(html);
                }
            }
        });
    });

    $("#product_save").click(function () {
        var error = $("#empty-image"),
            src = $("#preview-img .image img").attr('src');
        if (src == undefined) {
            error.removeClass("hide");

            return false;
        }

        if (!error.hasClass("hide")) {
            error.addClass("hide");
        }

        return true;
    });
});