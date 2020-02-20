$(function () {
    $('.like').on('click mouseenter', function () {
        $('.emoji').fadeIn();
    });
    $('.like').on('click mouseclick', function () {
        $('.emoji').fadeOut();
    });

    $('.reaction').click(function () {
        var data_reaction = $(this).attr('data-reaction');
        $('.like-details').html(' personnes , et toi aiment ce blog');

        $('.like').text(data_reaction).removeClass().addClass('like').addClass("active");;
        $('.like').addClass('like-main-' + data_reaction.toLowerCase()).addClass('holynoob');
        $('.alert-emo').html('<span class="like-btn-' + data_reaction.toLowerCase() + '"></span>');
        if (data_reaction == "Like")
            $(".like-emo").html('<span ></span>');
        else
            $(".like-emo").html('<span ></span><span class="like-btn-' + data_reaction.toLowerCase() + '"></span>');
        $('.notif-alert').fadeIn().delay(1500).fadeOut('slow')
        $('.emoji').delay(300).fadeOut();
    });

    $('.like').on('click', function () {
        if ($(this).hasClass('active')) {
            $('.like-details').html('Houssem & 3 autres');
            $('.like-emo').html('<span class="like-btn-like"></span>');
            $(this).text('Like').removeClass().addClass('like');
            $('.alert-emo').html('');
        }
        else if ($(this).hasClass('like-main-like')) {
            $('.like-details').html('Houssem & 3 autres');
            $(this).removeClass('like-main-like');
        } else {
            $('.like-details').html('Toi , Houssem & 3 autres');
            $(this).addClass('like-main-like').addClass('holynoob');
        }
    });
    $('.reaction, .like').mousedown(function () {
        $('.like').removeClass('holynoob');
    });


    $('#myTextArea').on('focus blur', function (e) {
        if (e.type === 'focus') {
            $('#myTextArea').attr('placeholder', 'Hit enter when youre ready');
            $('html, body').animate({
                scrollTop: $('p').offset().top
            });
        }
        if (e.type === 'blur') {
            $('#myTextArea').attr('placeholder', 'Write a comment..');
        }
    });





}); //end dsa