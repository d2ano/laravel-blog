
(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#flash').delay(3000).fadeOut();

    $('.login').find('input[type=email]').focus();

    $('.createPost').find('input[type=text]').focus();

    // $('.editPost').find('input[type=text]').focus();
    $('.editPost').find('textarea').select();

    $('.mainMinNavMenu').on('click' ,function (event) {
        event.preventDefault();
        console.log('debil');
        $('.mainNav ul').toggle();
    });


    //DELETE COMENT
    $('.post').on('click' ,'.del',function(event) {
        event.preventDefault();

        var hrefId = $(this).attr('href');

        hrefId = hrefId.replace(window.location.origin+'/comment/','');

        var linkForm = $('#del-'+hrefId);
        
        var req = $.ajax({
            url: linkForm.attr('action'),
            type: 'DELETE',
            data: linkForm.serialize(),
        });

        req.done(function (data) {
            if ( data.status==='ok' ) {
                $.ajax({
                    url: '/',
                    type: 'get',
                    data: linkForm.serialize()
                }).done(function() {

                    $('#'+hrefId).fadeOut();
                  });
            }
        });

        $('.commentAdd').find('textarea').val('').focus();
    });


    $('.commentAdd').find('button').on('click' , function (event) {
        event.preventDefault();

        var form = $('.commentAdd').find('form');

        $.ajax({
            url: form.attr('action'),
            method: 'post',
            data: form.serialize(),
            dataType: 'json',
            success: function(data) {
                if (data.id) {
                    console.log(data.id);
                    var req = $.ajax({
                        url: window.location.origin + '/comment/'+data.id,
                        type: 'get',
                    });

                    req.done(function (html) {
                        $(html).hide().appendTo('.commentA').fadeIn(); 
                    
                        form.find('textarea').val('').focus();
                    });
                }
            },
            error: function(xhr , error) {
                var error = xhr.responseJSON.errors.text;

                error.forEach(element => {
                    error = element;
                });

                console.log(error);
            }
        });

    });


}(jQuery));