/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery( document ).ready( function( $ ) {
	var $masthead = $( '.navigation-wrap' ),
	    timeout = false;

	$.fn.smallMenu = function() {
		$masthead.find( '.site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );
		$masthead.find( '.site-navigation #menu-button' ).removeClass( 'assistive-text' ).addClass( 'menu-toggle' );

		$('.header-search').find('.toggle-icons').appendTo('.site-navigation');

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).slideToggle(200);
			$( this ).toggleClass( 'toggled-on' );
			$('.header-search,.toggle-icons').toggle();
		} );
	};

	// Check viewport width on first load.
	if ( $( window ).width() < 769 )
		$.fn.smallMenu();

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {
		var browserWidth = $( window ).width();

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( browserWidth < 769 ) {
				$.fn.smallMenu();
			} else {
				$masthead.find( '.site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
				$masthead.find( '.site-navigation #menu-button' ).removeClass( 'menu-toggle' ).addClass( 'assistive-text' );
				$masthead.find( '.menu' ).removeAttr( 'style' );
				$('.header-search,.toggle-icons').show();
			}
		}, 200 );
	} );
} );
