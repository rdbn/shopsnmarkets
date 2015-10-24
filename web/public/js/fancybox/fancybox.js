$(document).ready(function(){
    $("#content .image .button").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            preload   : false,
            width: '950',
            minHeight : '500',
            maxHeight : '500',
            afterClose : function() {
                $.get('/addProducts/images', function(data) {
                    if (data !== '1') {
                        if (0 in data) {
                            $('#content .image .main').attr('src', data['0']);
                            $('#content .image').append('<span class="delete_main">&times;</span>');
                        }
                        if (1 in data) { 
                            $('#content .image .mini_1').attr('src', data['1']); 
                            $('#content .image .mini li').append('<span class="delete">&times;</span>');
                        }
                        if (2 in data) { 
                            $('#content .image .mini_2').attr('src', data['2']); 
                            $('#content .image .mini li').append('<span class="delete">&times;</span>');
                        }
                        if (3 in data) { 
                            $('#content .image .mini_3').attr('src', data['3']); 
                            $('#content .image .mini li').append('<span class="delete">&times;</span>');
                        }
                    }
                });
            }
        });
        
        return false;
    });
    
    $("#content .addationalPreview .preview").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            preload   : false,
            width: '400',
            minHeight : '350',
            maxHeight : '350'
        });
        
        return false;
    });
    
    $("#content .address a").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            preload   : false,
            width: '450',
            minHeight : '450',
            maxHeight : '450'
        });
        
        return false;
    });
    
    $("#content .sendMessage").on('click', function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            preload   : false,
            width: '450',
            minHeight : '400',
            maxHeight : '400'
        });
        
        return false;
    });
    
    $("#resualtSearch").on('click', '.sendMessage', function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            preload   : false,
            width: '450',
            minHeight : '400',
            maxHeight : '400'
        });
        
        return false;
    });
    
    $("#headerTop .content .enter").fancybox({
        href : '/enter',
        type : 'ajax',
        preload : false,
        maxWidth : '800',
        minWidth : '800',
        minHeight : '250'        
    });
    
    $(".menu .shopInformation").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            width: '500',
            minHeight : '400',
            maxHeight : '400'
        });
        
        return false;
    });
    $(".menu .shopPartners").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            width: '500',
            minHeight : '400',
            maxHeight : '400'
        });
        
        return false;
    });
    $(".menu .shopComments").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            width: '500',
            minHeight : '400',
            maxHeight : '400'
        });
        
        return false;
    });
    $(".menu .shopDelivery").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            width: '450',
            minHeight : '300',
            maxHeight : '300'
        });
        
        return false;
    });
    $(".menu .shopPayment").click(function() {
        var href = $(this).attr('href');
        
        $.fancybox.open({
            href : href,
            type : 'iframe',
            width: '500',
            minHeight : '400',
            maxHeight : '400'
        });
        
        return false;
    });
});