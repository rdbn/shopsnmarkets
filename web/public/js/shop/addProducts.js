var All = {
    category : function() {
        $('#Product_floor').change(function() {
            var floor = $('#Product_floor').val();
            
            $.post('/addProducts/category', { 
                'floor' : floor
            }, function(data) {
                var html = '<option value="" selected="selected">--- Выберите категорию ---</option>';
                
                for (var value in data) {
                    html += '<option value="'+data[value]['id']+'">'+data[value]['name']+'</option>';
                }
                
                $('#Product_category').html(html).show();
            }, 'json');
        });
    },
    subcategory : function() {
        $('#Product_category').change(function() {
            var category = $('#Product_category').val();
            
            $.post('/addProducts/subcategory', { 
                'category' : category
            }, function(data) {
                var html = '<option value="" selected="selected">--- Выберите подкатегорию ---</option>';
                
                for (var value in data) {
                    html += '<option value="'+data[value]['id']+'">'+data[value]['name']+'</option>';
                }
                
                $('#Product_subcategory').html(html).show();
            }, 'json');
            
            $.post('/addProducts/size', { 
                'category' : category
            }, function(data) {
                var html = '';
                
                for (var value in data) {
                    html += '<input type="checkbox" id="Product_size_'+data[value]['id']+'" name="Product[size][]" value="'+data[value]['id']+'" />';
                    html += '<label for="Product_size_'+data[value]['id']+'">'+data[value]['value']+'</label>';
                }
                
                $('#Product_size').html(html).show();
            }, 'json');
            
            $.post('/addProducts/typeThing', { 
                'category' : category
            }, function(data) {                
                $('#Product_typeThing').val(data);
            }, 'json');
        });
    }
};

var DeleteImage = {
    getValue : function(element) {
        return {
            'name' : element.parent('li').find('.preview_image').attr('src')
        };
    },
    getQuery : function(element) {
        $.post('/addProducts/imagesDelete', this.getValue(element), function(data) {
            if (data === '0') {
                element.parent('li').find('.preview_image').attr('src', '');
                element.parent('li').find('.delete').remove();
            }
        });
    },
    click : function() {
        $('#content .image .mini').on('click', '.delete', function() {
            DeleteImage.getQuery($(this));

            return false;
        });
    }
};

var DeleteMainImage = {
    getValue : function(element) {
        return {
            'name' : element.parent().find('.preview_image_main').attr('src')
        };
    },
    getQuery : function(element) {
        $.post('/addProducts/imagesDelete', this.getValue(element), function(data) {
            if (data === '0') {
                element.parent().find('.preview_image_main').attr('src', '');
                element.parent().find('.delete_main').remove();
            }
        });
    },
    click : function() {
        $('#content .image').on('click', '.delete_main', function() {
            DeleteMainImage.getQuery($(this));

            return false;
        });
    }
};

$(document).ready(function(){
    All.category();
    All.subcategory();
    DeleteImage.click();
    DeleteMainImage.click();
});