/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery( document ).ready( function( $ ) {
	var $masthead = $( '.navigation-wrap' );

	$.fn.smallMenu = function() {
		$masthead.find( '.site-navigation' ).removeClass( 'main-navigation' ).addClass( 'main-small-navigation' );

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$masthead.find( '.menu' ).slideToggle(200);
			$( this ).toggleClass( 'toggled-on' );
			$('.menu-search,.backstretch').toggle();
		} );
	};

	// Create the measurement node to compensate for scroll
	var scrollDiv = document.createElement("div");
	scrollDiv.className = "scrollbar-measure";
	document.body.appendChild(scrollDiv);

	// Get the scrollbar width
	var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth;

	// Delete the DIV
	document.body.removeChild(scrollDiv);

	// Check viewport width on first load.
	$( window ).on( "resize load", function () {
		var current_width = $(window).width();

		// Add the width of the scrollbar
		var total_width = current_width + scrollbarWidth;

		// If width is below iPad size
		if( total_width < 769 ) {
			$.fn.smallMenu();
		} else {
			$masthead.find( '.site-navigation' ).removeClass( 'main-small-navigation' ).addClass( 'main-navigation' );
			$masthead.find( '.menu' ).removeAttr( 'style' );
			$('.menu-search').hide();
		}

	});


} );