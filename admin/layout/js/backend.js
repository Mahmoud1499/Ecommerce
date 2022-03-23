$(function(){
    'user strict';
    // hide placeholder in focus

    $('[placeholder]').focus(function(){
        $(this).attr('data-text', $(this).attr('placeholder'));
        $(this).attr('placeholder','');
    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));

    });

    //add req filed
    
    $('input').each(function () {
        if($(this).attr('required') === 'required'){
            $(this).after('<span class="asterisk"> * </span>');
        }
    });

    //convert password to texton hover
    var passField = $('.password');

    $('.show-pass').hover(function(){
        passField.attr('type','text')
    }, function(){
        passField.attr('type','password')

    });

    //confirm msg 
    $('.confirm').click(function(){
        return confirm('Are You Sure ?');
    });


});

