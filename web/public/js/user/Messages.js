var Check = {
    getQuery : function(element) {
        element.removeClass('unread');
        
        $.get('/message/userMessage/check', {'id' : element.find('.messageId').attr('id')});
    },
    over : function() {
        $('#content .messages').on('mouseover', '.message', function() {
            if ($(this).hasClass('unread')) {
                Check.getQuery($(this));
            }
        });
    },
    all : function() {
        var arId = [];
        $('#content').find('.messages .unread').each(function() {
            arId.push($(this).find('.messageId').attr('id'));
        });
        
        if (arId != '') {
            $.get('/message/userMessage/checkAll', {'id' : arId}, function(data) {
                if (data === '0') {
                    $('#content').find('.messages .unread').each(function() {
                        $(this).removeClass('unread');
                    });
                }
            });
        }
    }
};
var Reestablish = {
    getValue : function() {
        var arId = [];
        $('#content').find('.messageBasket .click').each(function() {
            arId.push($(this).find('.messageId').attr('id'));
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
        
        return {'id' : arId};
    },
    click : function() {
        $('#content').on('click', '.addMenu .reestablish', function() {
            $.get('/message/userMessage/checkAll', Reestablish.getValue());
            
            return false;
        });
    }
};
var AllMessage = {
    getValue : function() {        
        return {
            'id' : $('#content .menuMessages .allMessages').attr('href')
        };
    },
    getPreLoad : function() {
        if ($('#content .messages').css('display') === 'block') {
            $('#content .messages').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200);
            });
            $('#content .formMessage').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200);
            });
        }
        if ($('#content').find('.messageBasket').length === 1) {
            $('#content').find('.messageBasket').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200, function() {
                    $(this).remove();
                });
            });
        }
        $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
    },
    getEndLoad : function(data) {
        if (data) {
            var html = '';
            for (var value in data) {
                html += '<div class="message"><span class="tick"></span><img src="'+data[value]['path']+'" />';
                html += '<ul><li><span id="'+data[value]['message']+'" class="messageId"></span></li>';
                html += '<li><h3>'+data[value]['realname']+'<span>'+data[value]['createdAt']['date']+'</span></h3></li>';
                html += '<li>'+data[value]['text']+'</li></ul></div>';
            }
            
            $('#content .messages').html(html);
            $('#content .messages').css({'display' : 'none', 'opacity' : '0'});
            $('#content .messages').slideToggle(200, function() {
                $(this).animate({'opacity' : 1}, 200);
            });
            $('#content .formMessage').slideToggle(200, function() {
                $(this).animate({'opacity' : '1'}, 200);
            });
            
            $('#content .messages').scrollTop($('#content .messages').get(0).scrollHeight);
        }

    },
    getQuery : function() {
        this.getPreLoad();
        
        $.get('/message/userMessage/allMessage', this.getValue(), function(data) {
            AllMessage.getEndLoad(data);
        });
    },
    click : function() {
        $('#content .menuMessages .allMessages').click(function() {
            if ($('#content .messages').css('display') === 'none') {
                AllMessage.getQuery();
            }
            
            return false;
        });
    }
};
var BasketMessage = {
    getValue : function() {        
        return {
            'id' : $('#content .menuMessages .allDelete').attr('href')
        };
    },
    getPreLoad : function() {
        if ($('#content .messages').css('display') === 'block') {
            $('#content .messages').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200);
            });
            $('#content .formMessage').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200);
            });
        }
        $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
    },
    getEndLoad : function(data) {
        if (data) {
            var html = '<div class="messageBasket">';
            for (var value in data) {
                html += '<div class="message"><span class="tick"></span><img src="'+data[value]['path']+'" />';
                html += '<ul><li><span id="'+data[value]['message']+'" class="messageId"></span></li>';
                html += '<li><h3>'+data[value]['realname']+'<span>'+data[value]['createdAt']['date']+'</span></h3></li>';
                html += '<li>'+data[value]['text']+'</li></ul></div>';
            }
            html += '</div>';
            
            
            $('#content').append(html);
            $('#content').find('.messageBasket').slideToggle(200, function() {
                $(this).animate({'opacity' : 1}, 200);
            });
            
        }

    },
    getQuery : function() {
        this.getPreLoad();
        
        $.get('/message/userMessage/basketMessage', this.getValue(), function(data) {
            BasketMessage.getEndLoad(data);
        });
    },
    click : function() {
        $('#content .menuMessages .allDelete').click(function() {
            if ($('#content .messageBasket').length === 0) {
                BasketMessage.getQuery();
            }
            
            return false;
        });
    }
};
var Basket = {
    getValue : function() {
        var arValue = [];
        $('#content .messages').find('.message').each(function() {
            if ($(this).hasClass('click')) {
                arValue.push($(this).find('.messageId').attr('id'));
                Basket.getPreLoad($(this));
            }
        });
        
        return {
            'id' : arValue
        };
    },
    getPreLoad : function(element) {
        element.animate({'opacity' : '0'}, 200, function() {
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
        });
    },
    getQuery : function() {
        $.get('/message/userMessage/basket', this.getValue());
    },
    click : function() {
        $('#content .menuMessages').on('click', '.basket', function() {
            Basket.getQuery();
            
            return false;
        });
    }
};
var Delete = {
    getValue : function() {
        var arValue = [];
        $('#content').find('.messageBasket .click').each(function() {
            arValue.push($(this).find('.messageId').attr('id'));
            $(this).slideToggle(200, function() {
                $(this).remove();
            });
            $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
                $(this).slideToggle(200, function() {
                    $(this).remove();
                });
            });
        });
        
        return {
            'id' : arValue
        };
    },
    getQuery : function() {
        $.get('/message/userMessage/delete', this.getValue());
    },
    click : function() {
        $('#content').on('click', '.addMenu .delete', function() {
            Delete.getQuery();
            
            return false;
        });
    },
    select : function() {
        $('#content').on('click', '.messageBasket .message', function() {
            if (!$(this).hasClass('click')) {
                $(this).addClass('click');
                $(this).find('.tick').animate({'opacity' : '1'}, 200, function() {
                    var html = '<ul class="addMenu"><li><a class="delete" href="#">Удалить</a></li>';
                    html += '<li><a class="reestablish" href="#">Восстановить</a></li></ul>';

                    if ($('#content .menuMessages').find('.addMenu').length === 0) {
                        $('#content .menuMessages').append(html).find('.addMenu').slideToggle(200, function() {
                            $(this).animate({'opacity' : '1'}, 200);
                        });
                    }
                });
            } else {
                $(this).removeClass('click');
                $(this).find('.tick').animate({'opacity' : '0'}, 200, function() {
                    var check = true;
                    $('#content').find('.messageBasket .message').each(function() {
                        if ($(this).find('.tick').css('opacity') === '1') {
                            check = false;
                        }
                    });
                    if (check) {
                        $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
                            $(this).slideToggle(200, function() {
                                $(this).remove();
                            });
                        });
                    }
                });
            }
        });
    }
};

$(document).ready(function(){
    AllMessage.click();
    BasketMessage.click();
    Reestablish.click();
    Check.over();
    Basket.click();
    Delete.select();
    Delete.click();
    
    $('#Message_text').keypress(function(event) {
        if (event.keyCode === 13 && $('#Message_text').val() !== '') {
            
        }
    });
    
    $('#content').on('click', '.messages .message', function() {        
        if (!$(this).hasClass('click')) {
            $(this).addClass('click');
            $(this).find('.tick').animate({'opacity' : '1'}, 200, function() {
                var html = '<ul class="addMenu"><li><a class="basket" href="#">В корзину</a></li></ul>';
                
                if ($('#content .menuMessages').find('.addMenu').length === 0) {
                    $('#content .menuMessages').append(html).find('.addMenu').slideToggle(200, function() {
                        $(this).animate({'opacity' : '1'}, 200);
                    });
                }
            });
        } else {
            $(this).removeClass('click');
            $(this).find('.tick').animate({'opacity' : '0'}, 200, function() {
                var check = true;
                $('#content').find('.messages .message').each(function() {
                    if ($(this).find('.tick').css('opacity') === '1') {
                        check = false;
                    }
                });
                if (check) {
                    $('#content .menuMessages').find('.addMenu').animate({'opacity' : '0'}, 200, function() {
                        $(this).slideToggle(200, function() {
                            $(this).remove();
                        });
                    });
                }
            });
        }
    });
    
    $('#content .messages').scrollTop($('#content .messages').get(0).scrollHeight);
    
    setInterval(function() {
        Check.all();
    }, 10000);
});