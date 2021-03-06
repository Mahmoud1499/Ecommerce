$(function(){
    'user strict';
    //dashboard
    $('.toggle-info').click(function () {

		$(this).toggleClass('selected').parent().next('.card-body').fadeToggle(100);

		if ($(this).hasClass('selected')) {

			$(this).html('<i class="fa fa-minus fa-lg"></i>');

		} else {

			$(this).html('<i class="fa fa-plus fa-lg"></i>');

		}

	});
  // Calls the selectBoxIt method on your HTML select box and uses the default theme
  $("select").selectBoxIt({
      autoWidth:false,
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

    // view option
    $('.cat h3').click(function(){
      $(this).next('.full-view').fadeToggle(200);
    });

    $('.option span').click(function(){
        $(this).addClass('active').siblings('span').removeClass('active') ;

        if($(this).data('view') === 'full'){
            $('.cat .full-view').fadeIn(200);
        }else{
            $('.cat .full-view').fadeOut(200);

        }
    });
   
    	//  Delete Button 

	$('.child-link').hover(function () {

		$(this).find('.show-delete').fadeIn(400);

	}, function () {

		$(this).find('.show-delete').fadeOut(400);

	});


});

