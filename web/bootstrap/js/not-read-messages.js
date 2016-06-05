$(document).ready(function() {
    var message = io.connect('http://localhost:8080/notRead'),
        username = "username_"+$("#not-read").attr('data-toggle');

    message.emit("addUser", {username: username});
    message.on('not-read', function (data) {
        $("#not-read .badge").html(data);
    });
});