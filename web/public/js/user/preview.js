var AddPreview = {
    getElement : function() {
        return {
            'AdditionalInformarion[text_preview]' : $('#AdditionalInformarion_text_preview').val(),
            'AdditionalInformarion[text_main]' : $('#AdditionalInformarion_text_main').val(),
            'AdditionalInformarion[_token]' : $('#AdditionalInformarion__token').val()
        };
    },
    getQuery : function() {
        $('.formAddationalPreview .savePreview').css({'display' : 'block', 'opacity' : '0'}).animate({'opacity' : '1'}, 200);
        
        $.post('/property/addPreviewInformation', this.getElement(), function(data) {
            if (data === '0') {
                $('.formAddationalPreview .savePreview').animate({'opacity' : '0'}, 200, function() {
                    $(this).css('display', 'none');
                });
            }
        });
    },
    click : function() {
        $('#preview').submit(function() {
            if ($('.formAddationalPreview .savePreview').css('display') === 'none') {
                AddPreview.getQuery();
            }
            
            return false;
        });
    }
};

$(document).ready(function() {
    AddPreview.click();
});