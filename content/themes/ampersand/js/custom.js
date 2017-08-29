jQuery(document).ready(function ($) {

	//Add JS class to html
	$( "html" ).addClass( "js" );

	//Fitvids
	$( ".post-text,.fitvid,#secondary aside" ).fitVids();

	//Gallery
	$( ".portfolio-single .comments-section" ).fadeIn( 100 );
	$( ".portfolio-single .gallery,.portfolio-single .tiled-gallery" ).prependTo( ".gallery-wrap" );
	$( ".portfolio-gallery dl.gallery-item:last-of-type" ).addClass( "last-portfolio-item" );
	$( ".portfolio-single .fluid-width-video-wrapper,[class^='embed']" ).prependTo( ".portfolio-gallery" );

	//Header Toggles

	//Add active class
	$( ".toggle-icons li:first-child a" ).addClass( "current" );

	//Menu Toggle
	$( ".menu-search-toggle" ).click( function() {
	  //Show search
	  $( ".navigation-toggle" ).toggle();
	  $( ".menu-search" ).toggle();

	  //Toggle icons
	  $( ".menu-search-toggle .fa-search" ).toggle();
	  $( ".menu-search-toggle .fa-times" ).toggle();

	  $( "#menu-search-input" ).focus();
	  return false;
	});

	//Center Nav
	$( ".main-navigation li" ).each( function() {
	    if( $( this ).find( "ul" ).length > 0 )
	    {
	        var parent_width = $( this ).outerWidth( true );
	        var child_width = $( this ).find( "ul" ).outerWidth( true );
	        var new_width = parseInt( ( child_width - parent_width )/2 );
	        $( this ).find( "ul" ).css( 'margin-left', -new_width+"px" );
	    }
	});

	//Backstretch
	if ( ( ampersand_header_js_vars.header_bg ) !== 'disable' && ( ampersand_custom_js_vars.bg_image_url ) ) {
		$( ".header-wrap" ).backstretch( ampersand_custom_js_vars.bg_image_url, { speed: 600 } );
	}

	//Center elements
	function Midway(){
		var $centerHorizontal = $( ".midway-horizontal" ),
			$centerVertical = $( ".midway-vertical" );

		$centerHorizontal.each(function(){
			$(this).css( "marginLeft", -$( this ).outerWidth()/2 );
		});
		$centerVertical.each(function(){
			$(this).css( "marginTop", -$( this ).outerHeight()/2 );
		});
		$centerHorizontal.css({
			'display' : 'inline',
			'position' : 'absolute',
			'left' : '50%'
		});
		$centerVertical.css({
			'display' : 'inline',
			'position' : 'absolute',
			'top' : '50%',
		});
	}
	$( window ).on( "load", Midway );
	$( window ).on( "resize", Midway );

	//Wrap share modules
	$( "body:not(.wpcom) .post-content .sharedaddy" ).wrapAll( "<div id='jp-post-flair'></div>" );

	// Drop menu
	$( ".main-navigation li" ).hoverIntent( {
		over:navover,
		out:navout,
		timeout: 100
	} );

	function navover() {
		$( this ).children( "ul" ).fadeIn( 50 );
	}
	function navout() {
		$( this ).children( "ul" ).fadeOut( 50 );
	}

});