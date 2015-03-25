$('document').ready(function() {
    $('input').eq(0).change(function() {
        var $video = $(this).val();
        $.ajax({
            url: 'http://noembed.com/embed',
            data: { url: $video },
            dataType: 'json',
            success: function(data) {
                $('#titre').append(data.title);
                $('#titre').append(data.author_name);
                $('#video').append(data.html);
                console.log(data);
            }
        });
    });
});
