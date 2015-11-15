$(document).ready(function(){
    /* Ajax for upload logo */
    $('#logo').change(function() {
        $(this).submit();
        
        $('#contentIframe').animate({'opacity' : '0'}, 200, function() {
            $(this).css('display', 'none');
            $('#load').css({'display' : 'block', 'opacity' : '0' });
            $('#load').animate({'opacity' : '1'}, 200);
        });
        
        $('#iframe').load(function(){
            var error = $(this).contents().find('#errors').html();
            if (error === undefined) {
                var path = $(this).contents().find('body').html();                
                $('#contentIframe').html('<img width="200" src="/'+path+'" />');
                
                $('#load').animate({'opacity' : '0'}, 200, function() {
                    $(this).css('display', 'none');
                    $('#contentIframe').css({'display' : 'block', 'opacity' : '0' });
                    $('#contentIframe').animate({'opacity' : '1'}, 200);
                });
            } else {
                $('#contentIframe').html(error).show();
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

        $(this).add("disabled");
        $.post("/app_dev.php/manager/createShop/addDescription", value, function () {
            $("#Description_save").removeClass("disabled");
        });
    });
});