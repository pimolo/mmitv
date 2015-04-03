$('document').ready(function() {
    var $video;
    $('#url').change(function() {
        $video = $(this).val();
        // prévisualisation
        $.ajax({
            url: 'http://noembed.com/embed',
            data: { url: $video },
            dataType: 'json',
            success: function(data) {
                $('#infos div').html('');
                if (data.error) {
                    $('input').after($('<span />').html("L'url n'est pas supportée...").css('color', 'red'));
                } else {
                    localStorage.setItem(localStorage.length++, JSON.stringify(data));
                    $('#titre span').html(data.title);
                    $('#auteur span').html(data.author_name);
                    $('#video span').html(data.html);
                    $('#add').show();
                    console.log(data);
                }
            }
        });
    });

        // enregistrement
    $('#add').click(function() {
        $.ajax({
            url: 'add-youtube-video',
            method: 'POST',
            data: 'url='+$video,
            dataType: 'json',
            success: function(data) {
                $('#add').after(data);
            }
        });
    });

    // $('body').on('click', 'button', function(e) {
    //     console.log('test');
    //     for (var i = localStorage.length - 1; i >= 0; i--) {
    //         var infos = JSON.parse(localStorage.getItem(i));
    //         $.ajax({
    //             url: 'add-video',
    //             method: 'POST',
    //             data: {
    //                 title: infos.title,
    //                 author: infos.author_name,
    //                 duration: 120,
    //                 html: infos.html
    //             },
    //         });
    //         localStorage.clear();
    //     }
    // });
});
