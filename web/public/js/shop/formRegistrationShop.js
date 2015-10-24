CheckUniqueName = {
    name : function() {
        var value = $('#shops_uniqueName').val();
        
        return value;
    },
    sendName : function() {
        var check = $.post('/manager/createShop/uniqueName', { 'name' : this.name() });
        check.done(function(data) {
            if (data === '0') {
                $('#checkName').text('+').show();
                $('#checkName').addClass('plus');
                $('#checkName').removeClass('minus');

                return true;
            } else {
                $('#checkName').text('-').show();
                $('#checkName').addClass('minus');
                $('#checkName').removeClass('plus');

                return false;
            }
        });
    },
    checkName : function() {
        if (this.name().length > 4) {
            this.sendName();
            
            return true;
        } else {
            return false;
        }
    }
};
$(document).ready(function(){    
    /* check unique_name */
    $("#shops_uniqueName").focus(function(){
        CheckUniqueName.checkName();
    });
    $("#shops_uniqueName").keyup(function(){
        CheckUniqueName.checkName();
    });
    $("#shops_uniqueName").blur(function(){
        CheckUniqueName.checkName();
    });
});