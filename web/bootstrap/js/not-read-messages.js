$(document).ready(function() {
    var domain = window.location.hostname ;
    domain = domain == 'shopsnmarkets.com' ? domain+':88' : 'localhost:8080';

    var message = io.connect('http://'+domain+'/notRead'),
        username = "username_"+$("#not-read").attr('data-toggle');

    message.emit("addUser", {username: username});
    message.on('not-read', function (data) {
        $("#not-read .badge").html(data.count);
    });
});