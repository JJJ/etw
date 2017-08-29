/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Site title and description.
	wp.customize('blogname',function(value){
		value.bind(function(to){
			$('.site-title').text(to);
		});
	});


	wp.customize('blogdescription',function(value){
		value.bind(function(to){
			$('.site-description').text(to);
		});
	});


	wp.customize('candid_customizer_border_width',function(value){
		value.bind(function(to){
			$('body').css('border-width',to);

			// Refresh blocks
			var $blocks = $('.gallery-wrapper');

			$blocks.imagesLoaded(function(){
				$blocks.masonry({
					itemSelector:'.post',
					transitionDuration: 0
				});
			});
			$blocks.masonry();
		});
	});

	wp.customize('candid_customizer_border_color',function(value){
		value.bind(function(to){
			$('body').css('border-color',to);
		});
	});


	wp.customize('candid_customizer_accent_color',function(value){
		value.bind(function(to){
			$('.entry-content a').css('border-color',to);
		});
	});


	wp.customize('candid_customizer_button_color',function(value){
		value.bind(function(to){
			$('button,input[type="button"],input[type="reset"],input[type="submit"],.button,.comment-navigation a').css('background-color',to);
		});
	});


	wp.customize('candid_customizer_homepage_title',function(value){
		value.bind(function(to){
			$('.home .entry-header .entry-title').text(to);
		});
	});


	wp.customize('candid_customizer_homepage_text',function(value){
		value.bind(function(to){
			$('.home .entry-header .entry-content').text(to);
		});
	});


	wp.customize('candid_customizer_footer_text',function(value){
		value.bind(function(to){
			$('.site-info').text(to);
		});
	});

})(jQuery);
