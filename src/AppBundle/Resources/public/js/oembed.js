$('document').ready(function() {
    $('input').eq(0).change(function() {
        var $video = $(this).val();
        $.ajax({
            url: 'http://noembed.com/embed',
            data: { url: $video },
            dataType: 'json',
            success: function(data) {
                if (data.error) {
                    $('input').after($('<span />').html("L'url n'est pas supportée...").css('color', 'red'));
                } else {
                    localStorage.setItem(localStorage.length++, JSON.stringify(data));
                    $('#titre').append(data.title);
                    $('#auteur').append(data.author_name);
                    $('#video').append(data.html);
                    $('<button />').html('Ajouter').appendTo($('#infos'));
                    console.log(data);
                }
            }
        });
    });
    $('body').on('click', 'button', function(e) {
        console.log('test');
        for (var i = localStorage.length - 1; i >= 0; i--) {
            var infos = JSON.parse(localStorage.getItem(i));
            $.ajax({
                url: 'add-video',
                method: 'POST',
                data: {
                    title: infos.title,
                    author: infos.author_name,
                    duration: 120,
                    html: infos.html
                },
            });
            localStorage.clear();
        }
    });
});
