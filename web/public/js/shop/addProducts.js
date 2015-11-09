$(document).ready(function() {
    $.get("/hashTags", function (data) {
        var tags = [];
        for (var i in data) {
            tags[i] = {value: data[i].name};
        }

        $('#Product_hashTags').tokenfield({
            autocomplete: {
                source: tags,
                delay: 100
            },
            showAutocompleteOnFocus: true
        });
    });

    $("#Product_file").change(function () {
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
                    width: 160,
                    height: 160
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
});