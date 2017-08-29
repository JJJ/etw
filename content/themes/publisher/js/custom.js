jQuery(document).ready(function ($) {

	//Add JS class to html
	$( "html" ).addClass( "js" );

	//Masonry blocks
	var $blocks = $( "#block-container" );

	$blocks.imagesLoaded( function() {
		$blocks.masonry({
			itemSelector: '.block'
		});

		// Fade blocks in after images are ready (prevents jumping and re-rendering)
		$( ".block" ).show();
	});

	$( window ).resize( function() {
		$blocks.masonry();
	});

	//If only one tab, hide tab navigation
	if ( $( ".single-tab-nav li" ).length < 2 ) {
		$( ".single-tab-nav li" ).remove();
	}

	//Single page tabs
	$( "#single-tabs > div").hide();
	$( "#single-tabs div:first" ).fadeIn( 50 );
	$( "#single-tabs ul li:first" ).addClass( "active" );

	$( "#single-tabs > ul > li a" ).click( function() {
		$( "#single-tabs ul li" ).removeClass( "active" );
		$( this ).parent().addClass( "active" );
		var currentTab = $(this).attr( "href" );
		$( "#single-tabs > div" ).fadeOut( 50 );
		$( currentTab ).fadeIn( 50 );
		return false;
	});

	// If the current page hash includes #tab-4, activate that tab to display share and like info.
	// This allows us to link directly to the Likes tab from each homepage block's 'Like' count
	if ( window.location.hash == "#tab-4" ) {
		$( "#single-tabs ul li" ).removeClass( "active" );
		$( ".single-tab-nav .tab-likes" ).addClass( "active" );
		$( "#single-tabs > div" ).hide();
		$( "#tab-4" ).show();
	}

	// Layout posts that arrive via infinite scroll
	infinite_count = 0;
	$( document.body ).on( 'post-load', function () {

		infinite_count = infinite_count + 1;

		// Show the blocks
		$( ".block" ).show();

		var $newItems = $( '#infinite-view-' + infinite_count  ).not('.is--replaced');
		var $elements = $newItems.find('.block');
		$elements.hide();
		$blocks.append($elements);

		$blocks.imagesLoaded( function() {
			$blocks.masonry( "appended", $elements, true ).masonry( "reloadItems" ).masonry( "layout" );
			$elements.fadeIn();
		});

	});

	//Header Toggles

	//Add active class
	$( ".toggle-icons li:first-child a" ).addClass( "current" );

	// Hide Toggles
	$( ".toggle-icons a" ).click( function() {
		$( ".toggle-box" ).hide();
		$( ".toggle-icons a" ).removeClass( "current" );
		return false;
	});

	// Links Toggle
	$( ".toggle-social" ).click( function() {
		$( ".toggle-box-social" ).fadeToggle( 150 );
		$( this ).addClass( "current" );
		return false;
	});

	// Search Toggle
	$( ".toggle-search" ).click( function() {
		$( ".toggle-box-search" ).fadeToggle( 150 );
		$( this ).addClass( "current" );
		$( ".toggle-box-search .field" ).focus();
		return false;
	});

	// Backstretch
	if ( ( publisher_bg_js_vars.bg_image ) && ( publisher_bg_js_vars.bg_image ) == 'enable' && ( publisher_custom_js_vars.bg_image_url ) ) {
		$.backstretch( publisher_custom_js_vars.bg_image_url, { speed: 300 } );
	}

	// Drop menu
	$( ".navigation-wrap .main-navigation ul li" ).hoverIntent( {
		over:navover,
		out:navout,
		timeout:400
	} );

	function navover() {
		$( this ).children( "ul" ).show();
	}
	function navout() {
		$( this ).children( "ul" ).hide();
	}

	// Remove animation on full-screen toggle
	$( document ).on( "webkitfullscreenchange mozfullscreenchange fullscreenchange", function () {
	    $( '.post' ).toggleClass( 'fullscreen' );
	});

});