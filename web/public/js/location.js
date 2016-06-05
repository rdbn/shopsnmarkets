function locations(send, take) {
    $('#'+send).change(function() {
        $.get("/city/"+$(this).val(), function(data){
            if (data !== '') {
                var html = '<option value>Выберите город *</option>';
                
                for (var value in data) {
                    html += '<option value="'+data[value]['id']+'">'+data[value]['name']+'</option>';
                }
                
                $('#'+take).html(html).show();
            }
        });
    });
}

$(document).ready(function () {
    locations('shops_country', 'shops_city');
    locations('SearchPartners_country', 'SearchPartners_city');
    locations('search_country', 'search_city');
    locations('user_information_country', 'user_information_city');
    locations('address_country', 'address_city');
});