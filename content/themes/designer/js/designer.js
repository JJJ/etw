jQuery(document).ready(function( $ ) {

	// Load masonry on pages that use the tile portfolio
	if ( ( designer_portfolio_js_vars.portfolio_style ) === 'tile' || ( ! designer_portfolio_js_vars.portfolio_style ) ) {
		var $blocks = $( ".tile" );

		$blocks.imagesLoaded( function(){
			$blocks.masonry({
				itemSelector: '.post'
			});
		});

		// Rearrange masonry on resize
		$( window ).resize( function() {
			$blocks.masonry();
		});

		// Infinite scroll
		$( document.body ).on( "post-load", function () {
			var $newItems = $( '.new-infinite-posts' ).css( { opacity: 0 } );
			var $elements = $newItems.find('.portfolio-column');
			// Hide new posts so we can fade them in
			$elements.hide();
			$blocks.append($elements);

			// Once images are loaded, add the new posts via masonry
			$blocks.imagesLoaded( function() {
				$newItems.animate( { opacity: 1 } );
				$blocks.masonry( "appended", $elements, true ).masonry('reloadItems').masonry('layout');
			});
		});
	}

	// Toggle sidebar
	$( ".sidebar-toggle,.site-header .flyout-toggle" ).click( function(e){
		$( ".site-header,.sidebar-toggle,.container" ).toggleClass( "active" );
		return false;
	});

	$( ".sidebar-toggle .site-title a" ).click( function(e) {
		e.stopPropagation();
		return true;
	});

	// Toggle sub menus
	$( ".menu" ).find( "li.menu-item-has-children" ).click( function(){
		$( ".menu li" ).not( this ).find( "ul" ).next().slideUp( 100 );
		$( this ).find( "> ul" ).stop( true, true ).slideToggle( 100 );
		$( this ).toggleClass( "active-sub-menu" );
		return false;
	});

	// Don't fire sub menu toggle if a user is trying to click the link
	$( ".menu-item-has-children a" ).click( function(e) {
		e.stopPropagation();
		return true;
	});

	// Hide the sidebar on full screen video
	$( document ).on( "webkitfullscreenchange mozfullscreenchange fullscreenchange", function () {
	    $( ".sidebar-toggle" ).toggleClass( 'fullscreen' );
	});

});
