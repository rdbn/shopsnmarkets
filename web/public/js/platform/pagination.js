var Pagination = {
    getValue : function(element) {
        var href = element.attr('href').split('/');
        var value = href['1'].split('?');
        var parseValue = value['1'].split('&');
        var arValue = {};
        
        for (var index in parseValue) {
            var value = parseValue[index].split('=');
            arValue[value['0']] = value['1'];
        }
        
        return arValue;
    },
    getPreLoad : function(element) {
        
    },
    getEndLoad : function(element) {
        
    },
    getQuery : function(element) {
        this.getPreLoad(element);
        
        $.get('/allProducts', this.getValue(element), function() {
            Pagination.getEndLoad(element);
        }, 'json');
    },
    button : function() {
        $('.pagination .next a').click(function() {
            Pagination.getQuery($(this));
            
            return false;
        });
    }
};
$(document).ready(function() {
    Pagination.button();
});