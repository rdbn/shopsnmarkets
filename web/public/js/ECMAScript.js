function getTimeUser() {
    var nameDay = ["Воскресенье","Понедельник", "Вторник","Среда","Четверг", "Пятница","Суббота"];
    
    var time = new Date();
    
    var timeMinut = time.getMinutes();
    var timeHours = time.getHours();
    
    var getTime = ((timeHours<10)?"0":"")+timeHours;
    getTime+=":";
    getTime+=((timeMinut<10)?"0":"")+timeMinut;
    
    getTime = nameDay[time.getDay()]+' '+getTime;
    
    return getTime;
}
function privateOffice() {
    var display = $('.privateOffice .profile').css('display');
        
    if (display === 'block') {
        $('.privateOffice .profile').slideToggle(180);
    } else {
        $('.privateOffice .profile').slideToggle(180);
        $('.privateOffice .profile .time').html(getTimeUser()).show();
    }

    setInterval(function() {
        $('.privateOffice .profile .time').html(getTimeUser()).show();
    }, 10000);
}

$(document).ready(function(){
    $('#headerTop .content').on('click', '.privateOffice .showMenu', function() {        
        privateOffice();
        
        return false;
    });
    
    $('#content .showMenu').click(function() {
        var display = $('#content .menuInfo ul').css('display');
        
        if (display === 'block') {
            $('#content .menuInfo ul').slideToggle(180);
        } else {
            $('#content .menuInfo ul').slideToggle(180);
        }
        
        return false;
    });
});