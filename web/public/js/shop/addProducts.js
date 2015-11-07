$(document).ready(function() {
    $.get("/hashTags", function (data) {
        $('#Product_hashTags').tokenfield({
            autocomplete: {
                source: data,
                delay: 100
            },
            showAutocompleteOnFocus: true
        })
    });
});