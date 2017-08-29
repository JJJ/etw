/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Site title and description
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

	// Featured content title
	wp.customize('atomic_browse_title',function(value){
		value.bind(function(to){
			$('html, body').animate({
		        scrollTop: $('.category-wrap').offset().top
		    }, 2000);

			$('.category-wrap .category-menu-title').text(to);
		});
	});


	// Hero background opacity
	wp.customize('atomic_bg_opacity', function(value) {
		value.bind(function(to) {
			$('.site-header-bg').css('opacity',to);
		} );
	} );


	// Accent colors
	wp.customize('atomic_button_color',function(value) {
		value.bind( function( to ) {
			$('button:not(.preview-toggle), input[type="button"], input[type="reset"], input[type="submit"], .button, .comment-navigation a, .drawer .tax-widget a, .su-button, h3.comments-title, .page-numbers.current, .page-numbers:hover').css('background-color',to);
		} );
	} );


	// Featured Content hero background
	wp.customize('atomic_header_bg_color',function(value) {
		value.bind(function(to) {
			$('.site-header').css('background',to);
		} );
	} );


	// Featured Content header height
	wp.customize('atomic_header_height',function(value) {
		value.bind(function(to) {
			$('.header-text').css( 'padding', to + '% 0' );
		} );
	} );


	// Create header container
	if ($('.header-text').length) {
	} else {
		$('.site-header .text-container').prepend('<div class="header-text text-empty"></div>');
	}


	// Change Header Title
	wp.customize('atomic_header_title',function(value){
		value.bind(function(to){
			if ($('.header-text h2').length) {
				$('.header-text h2').text(to);
		    } else {
				$('.header-text').removeClass('text-empty');
				$('.header-text').prepend('<h2></h2>');
				$('.header-text h2').text(to);
			}
		});
	});


	// Change Header Subitle
	wp.customize('atomic_header_subtitle',function(value){
		value.bind(function(to){
			if ($('.header-text p').length) {
				$('.header-text p').text(to);
			} else {
				$('.header-text').removeClass('text-empty');
				$('.header-text').append('<p></p>');
				$('.header-text p').text(to);
			}
		});
	});


	// Change footer text
	wp.customize('atomic_footer_text',function(value){
		value.bind(function(to){
			$('.site-info').text(to);
		});
	});

})(jQuery);
