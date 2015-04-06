$('document').ready(function() {
    $('#playlistSelect').change(function() {
        $(this).parent('form').submit();
    });
    var $video;
    $('#url-input').change(function() {
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
                    $('#url-input').parent('.form-group').removeClass('has-success');
                    $('#url-input').parent('.form-group').addClass('has-error');
                } else {
                    $('#url-input').parent('.form-group').removeClass('has-error');
                    $('#url-input').parent('.form-group').addClass('has-success');
                    // localStorage.setItem(localStorage.length++, JSON.stringify(data));
                    $('#title-input').val(data.title);
                    $('#auteur span').html(data.author_name);
                    $('#video').html(data.html);
                    // console.log(data);
                }
            }
        });
    });

        // enregistrement
    $('#add-video').click(function() {
        $.ajax({
            url: 'add-youtube-video',
            method: 'POST',
            data: 'url='+$video,
            success: function(data) {
                console.log(data);
                $('input').after($('<span />').html(data));
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
