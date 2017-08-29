/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($){

	// Change site title
	wp.customize('blogname',function(value){
		value.bind(function(to){
			$('.site-title').text(to);
		});
	});

	// Change site description
	wp.customize('blogdescription',function(value){
		value.bind(function(to){
			$('.site-description').text(to);
		});
	});

	// Show sidebar
	wp.customize('baseline_logo_text', function(value) {
		value.bind(function(to) {
			if (to) {
				$('.titles-wrap').show();
			} else {
				$('.titles-wrap').hide();
			}
		});
	});

	// Change browse button label
	wp.customize('baseline_customizer_browse_label',function(value){
		value.bind(function(to){
			$('.browse-toggle span').text(to);
		});
	});

	// Change menu button label
	wp.customize('baseline_customizer_menu_label',function(value){
		value.bind(function(to){
			$('.menu-toggle span').text(to);
		});
	});

	// Change button color
	wp.customize('baseline_customizer_button_color',function(value){
		value.bind(function(to){
			$('button,input[type="button"],input[type="reset"],input[type="submit"],.button,.comment-navigation a').css('background-color',to);
		});
	});

	// Change footer text
	wp.customize('baseline_customizer_footer_text',function(value){
		value.bind(function(to){
			$('.site-info').text(to);
		});
	});

	// Change menu button label
	wp.customize('baseline_customizer_menu_label',function(value){
		value.bind(function(to){
			if (to) {
				$('.menu-toggle span').text(to);
			} else {
				$('.menu-toggle span').text('Sidebar');
			}
		});
	});

	// Featured content height
	wp.customize('baseline_featured_height', function(value) {
		value.bind(function(to) {
			$('.featured-content .post').css('padding',to + '% 0');
		});
	});

	// Header background image opacity
	wp.customize('baseline_bg_opacity', function( value ) {
		value.bind(function(to) {
			$('.site-header .background-effect').css('opacity',to);
		});
	});


	// Header background color
	wp.customize('baseline_header_background_color', function(value) {
		value.bind(function(to) {
			$('.site-title-wrap').css('background-color',to);
		});
	});

	// Header title color
	wp.customize('header_textcolor', function(value) {
		value.bind(function(to) {
			$('.site-title a,.site-description').css('color',to);
		});
	});

	// Header height
	wp.customize('baseline_header_height', function(value) {
		value.bind(function(to) {
			$('.site-title-wrap').css('padding',to + '% 0');
		});
	});

})(jQuery);
