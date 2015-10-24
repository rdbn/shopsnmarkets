function shop() {
    $('#Advertising_file').change(function(evt) {
        var maxFiles = '3';
        var files = evt.target.files;
        var element = $('.advertising .file .preview_img').html('');
        
        if ($('.advertising .file .error').css('display') === 'block') {
            $('.advertising .file .error').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200);
            });
        }
        
        if (files.length <= maxFiles) {
            for (var i = 0, f; f = files[i]; i++) {            
                if (!f.type.match('image.*')) {
                    var elem = $('.advertising .file .error').html('Загружать можно только изображения!');
                    if (elem.css('display') === 'none') {
                        elem.slideToggle(200, function() {
                            $(this).animate({'opacity' : '1'}, 200);
                        });
                    }
                    
                    continue;
                }

                var reader = new FileReader();

                reader.onloadend = function(e) {
                    var image = new Image();
                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');

                    image.src = e.target.result;
                    ctx.drawImage(image, 0, 0, 300, 150);
                    element.append(canvas);
                };

                reader.readAsDataURL(f);
            }
        } else {
            var elem = $('.advertising .file .error').html('Вы не можете загружать больше '+maxFiles+' изображений!');
            
            if (elem.css('display') === 'none') {
                elem.slideToggle(200, function() {
                    $(this).animate({'opacity' : '1'}, 200);
                });
            }
            
            files.length = 0; return;
        }
    });
    $('#formAdvertising').submit(function() {
        if ($('#load').css('opacity') === '0' && $('.advertising .file h3').css('display') === 'none') {
            var element = $('#content .advertising .advertisingInf');
            if (element.css('dispaly') === 'none') {
                $('#load').css({'display' : 'block', 'opacity' : '0' });
                $('#load').animate({'opacity' : '1'}, 200);
            } else {
                element.animate({'opacity' : '0'}, 200, function() {
                    element.css('display', 'none');
                    $('#load').css({'display' : 'block' }).animate({'opacity' : '1'}, 200);
                });
            }

            $('#uploadAdvertising').load(function(){
                var content = $(this).contents().find('body pre').html();
                var value = jQuery.parseJSON(content);

                if (value !== '0') {
                    var format = '';
                    if (value.format === 1) {
                        format = 'slider';
                        value.format = 'Реклама на слайдаре';
                    } else {
                        format = 'side_of';
                        value.format = 'Боковая реклама';
                    } 
                    
                    var html = '<h3>'+value.format+'</h3>';
                    html += '<ul><li><p>Название магазина: <span>'+value.shop+'</span></p></li></ul>';
                    for (var index in value['image']) {
                        html += '<img src="/public/xml/Shops/'+value.unique_name+'/advertising/'+format+'/'+value['image'][index]+'" />';
                    }

                    element.html(html);

                    $('#load').animate({'opacity' : '0'}, 200, function() {
                        $(this).css('display', 'none');
                        element.css({'display' : 'block'}).animate({'opacity' : '1'}, 200, function() {
                            $("html,body").animate({scrollTop: $('#advInf').offset().top}, 200);
                        });
                    });
                } else {
                    element.html('<h3 class="error">'+value+'</h3>');

                    $('#load').animate({'opacity' : '0'}, 200, function() {
                        $(this).css('display', 'none');
                        element.css({'display' : 'block'}).animate({'opacity' : '1'}, 200, function() {
                            $("html,body").animate({scrollTop: $('#advInf').offset().top}, 200);
                        });
                    });
                }
            });
        } else {
            return false;
        }
    });
}

function paltform() {
    $('#Advertising_file').change(function(evt) {
        var file = evt.target.files['0'];
        var element = $('.advertising .file .preview_img').html('');
        
        if (!file.type.match('image.*')) {
            var elem = $('.advertising .file .error').html('Загружать можно только изображения!');
            if (elem.css('display') === 'none') {
                elem.slideToggle(200, function() {
                    $(this).animate({'opacity' : '1'}, 200);
                });
            }
        } else {
            if ($('.advertising .file .error').css('opacity') === '1') {
                $('.advertising .file .error').animate({'opacity' : '0'}, 200, function() {
                    $(this).slideToggle(200);
                });
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                var image = new Image();
                var canvas = document.createElement('canvas');
                var ctx = canvas.getContext('2d');

                image.src = e.target.result;
                ctx.drawImage(image, 0, 0, 300, 150);
                element.append(canvas);
            };

            reader.readAsDataURL(file);
        }
    });
    $('#formAdvertising').submit(function() {
        if ($('#load').css('opacity') === '0') {
            var element = $('#content .advertising .advertisingInf');
            if (element.css('dispaly') === 'none') {
                $('#load').css({'display' : 'block', 'opacity' : '0' });
                $('#load').animate({'opacity' : '1'}, 200);
            } else {
                element.animate({'opacity' : '0'}, 200, function() {
                    element.css('display', 'none');
                    $('#load').css({'display' : 'block' }).animate({'opacity' : '1'}, 200);
                });
            }

            $('#uploadAdvertising').load(function(){
                var content = $(this).contents().find('body pre').html();
                var value = jQuery.parseJSON(content);

                if ('shop' in value) {
                    var html = '<h3>'+value.format+'</h3>';
                    html += '<ul><li><p>Название магазина: <span>'+value.shop+'</span></p></li>';
                    html += '<li><p>Начало показа: <span>'+value.start.date+'</span></p></li>';
                    html += '<li><p>Окончание показа: <span>'+value.end.date+'</span></p></li></ul>';
                    html += '<img src="'+value.path+'" />';

                    element.html(html);

                    $('#load').animate({'opacity' : '0'}, 200, function() {
                        $(this).css('display', 'none');
                        element.css({'display' : 'block'}).animate({'opacity' : '1'}, 200, function() {
                            $("html,body").animate({scrollTop: $('#advInf').offset().top}, 200);
                        });
                    });
                } else {
                    element.html('<h3 class="error">'+value+'</h3>');

                    $('#load').animate({'opacity' : '0'}, 200, function() {
                        $(this).css('display', 'none');
                        element.css({'display' : 'block'}).animate({'opacity' : '1'}, 200, function() {
                            $("html,body").animate({scrollTop: $('#advInf').offset().top}, 200);
                        });
                    });
                }
            });
        } else {
            return false;
        }
    });
}
$(document).ready(function(){
    $('.adFormat li label').click(function() {
        $('.adFormat li span').removeClass('click');
        $('.adFormat li label').removeClass('click');
        $(this).addClass('click');
        $(this).parent('li').find('span').addClass('click');
    });
    $('.format li label').click(function() {
        $('.format li span').removeClass('click');
        $('.format li label').removeClass('click');
        $(this).addClass('click');
        $(this).parent('li').find('span').addClass('click');
    });
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
    $('.advertising .adFormat input[type="radio"]').click(function() {
        $("#Advertising_file").replaceWith($("#Advertising_file").clone());
        
        if ($('#content .formFields .preview_img').find('canvas').length !== 0) {
            $('#content .formFields .preview_img').html('');
        }
        
        var elemDuration = $('.advertising .formFields .duration').parent();
        var elemPrice = $('.advertising .formFields .price').parent();
            
        if ($(this).val() === 'platform') {
            if (elemDuration.css('display') === 'none') {
                $('.advertising .file_chapter').html('5. Добавте картинку:');
                elemDuration.animate({'opacity' : '1'}, 200, function() {
                    elemDuration.slideToggle('200');
                });
                elemPrice.animate({'opacity' : '1'}, 200, function() {
                    elemPrice.slideToggle('200');
                });

                $('#formAdvertising').attr('action', '/advertising/createPlatform');
                var file = $('#Advertising_file');
                file.attr('name', 'Advertising[file]');
                file.removeAttr('multiple');
            }
            
            paltform();
        } else {
            if (elemDuration.css('display') === 'block') {
                $('.advertising .file_chapter').html('4. Добавте картинку:');
                elemDuration.css({'display' : 'block', 'opacity' : '1'}).animate({'opacity' : '0'}, 200, function() {
                    elemDuration.slideToggle('200');
                });
                elemPrice.css({'display' : 'block', 'opacity' : '1'}).animate({'opacity' : '0'}, 200, function() {
                    elemPrice.slideToggle('200');
                });

                $('#formAdvertising').attr('action', '/advertising/createShop');
                var file = $('#Advertising_file');
                file.attr('name', 'Advertising[file][]');
                file.attr('multiple', 'multiple');
            }
            
            shop();
        }
    });
});