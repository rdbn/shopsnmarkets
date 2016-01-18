function locations(send, take) {
    $('#'+send).change(function() {
        $.get("/app_dev.php/city/"+$(this).val(), function(data){
            if (data !== '') {
                var html = '<option value>Выберите город*</option>';
                
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
    locations('RegistrationUser_country', 'RegistrationUser_city');
    locations('SearchPartners_country', 'SearchPartners_city');
    locations('Search_country', 'Search_city');
    locations('UserInformation_country', 'UserInformation_city');
    locations('Order_address_country', 'Order_address_city');
});