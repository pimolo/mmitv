$(document).ready(function() {
    $.ajax({
        url: 'get-current-video',
        success: function(data) {
            console.log(data);
            $('.youtube').html(data);
            getNext();
        }
    });
    var getNext = function() {
        $.ajax({
            url: 'get-next-video',
            success: function(data) {
                console.log(data);
                setTimeout(function() {
                    $('.youtube').html(data.html);
                    getNext();
                }, data.time_interval);
            }
        });
    };
});
