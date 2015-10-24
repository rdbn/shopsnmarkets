$(document).ready(function(){
    document.getElementById('vk_share_button').innerHTML = VK.Share.button({
        url: window.location.url,
        title: $('.chapter h3').text(),
        description: $('.content .textPreview').text(),
        image: 'http://ornest.com'+$('.menuBok img').attr('src'),
        noparse: true
    }, {
        type: "custom", 
        text: "<img src=\"http://vk.com/images/share_32_eng.png\" width=\"32\" height=\"32\" />", 
        eng: 1
    });
});