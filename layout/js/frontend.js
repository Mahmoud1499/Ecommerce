$(function(){
 'use strict';
   
 
 
 //switch between login | Signup
 $(".login-page h1 span").click(function(){

    $(this).addClass("selected").siblings().removeClass("selected")
    $('.login-page form').hide();
    $('.' + $(this).data('class')).fadeIn(100);
 });


// selectBoxIt

 $("select").selectBoxIt({
    autoWidth:false
});




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

    

    //confirm msg 
    $('.confirm').click(function(){
        return confirm('Are You Sure ?');
    });

    // view option
    $('.cat h3').click(function(){
      $(this).next('.full-view').fadeToggle(200);
    });


});

