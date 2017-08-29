( function( $ ) {

	$( document ).ready(function() {

		// Toggle sidebar
		$( ".sidebar-toggle, .widget-area .flyout-toggle" ).click( function(e) {
			$( ".widget-area, .sidebar-toggle,.container" ).toggleClass( "active" );
			return false;
		} );

		// Escape key toggles sidebar open/close
		$( document ).keyup( function(e) {
			if (e.keyCode == 27) {
				$( ".widget-area, .sidebar-toggle,.container" ).toggleClass( "active" );
			}
		});

		// Detect window width and execute responsive functions
		$( window ).on( "resize load", function () {
			var current_width = $( window ).width();

			// If width is above iPad size
			if( current_width > 769 ) {

				// Move navigation back to header on desktop
				$( ".widget-area" ).find( ".main-navigation" ).prependTo( ".site-header" );

				// Drop menu functions
				function navover() {
					$( this ).children( "ul" ).show();
				}

				function navout() {
					$( this ).children( "ul" ).hide();
				}

				// Show drop down menu
				$( ".site-header .main-navigation ul li" ).hoverIntent( {
					over:navover,
					out:navout,
					timeout:400
				} );
			}

			// If width is below iPad size
			if( current_width < 769 ) {
				// Move navigation into sidebar on tablet and mobile
				$( ".site-header" ).find( ".main-navigation" ).insertAfter( "#secondary .flyout-toggle" );
			}
		} );

		// Toggle sub menus on mobile
		$( ".main-navigation .menu" ).find( "li.menu-item-has-children" ).click( function() {
			$( ".menu li" ).not( this ).find( "ul" ).next().slideUp( 100 );
			$( this ).find( "> ul" ).stop( true, true ).slideToggle( 100 );
			$( this ).toggleClass( "active-sub-menu" );
			return false;
		} );

		// Don't fire sub menu toggle if a user is trying to click the link
		$( ".menu-item-has-children a, .page-template-featured-php .wp-caption-text" ).click( function(e) {
			e.stopPropagation();
			return true;
		} );

	});

	// Slick carousel options
	function run_slick() {

		// Setup each carousel
		$( ".slick-slider" ).each( function() {
			var $carousel = $( this );

			$carousel.slick( {
				dots: false,
				infinite: true,
				speed: 300,
				slidesToShow: 1,
				centerMode: true,
				variableWidth: true,
			});

			// Fade in each gallery like a boss
			$( ".slick" ).each( function() {
				$( this ).fadeTo( 200, 1 );
			});

			// Add next/prev navigation to the carousel
			$carousel.click( function(e) {
				var clickXPosition = e.pageX - this.offsetLeft;

				// Go to the previous image if the click occurs in the left half of gallery,
				// or the next image if the click occurs in the right half.
				if (clickXPosition < $( window ).width() / 2 ) {
					$( this ).slickPrev();
				} else {
					$( this ).slickNext();
				}
				return false;
			} );

            // Add classes to allow next/prev cursor styling
			$carousel.mousemove( function(e){
				var mouseXPosition = e.pageX - this.offsetLeft;
				if (mouseXPosition < $( window ).width() / 2 ) {
					$carousel.removeClass( "right-arrow" );
					$carousel.addClass( "left-arrow" );
				} else {
					$carousel.removeClass( "left-arrow" );
					$carousel.addClass( "right-arrow" );
				}
			});
		});
	}

	// Run Slick carousel
	$( window ).load( function() {
		run_slick();
	});

	// Run Slick Carousel on new Infinite Scroll posts
	// Set a slight delay to let Slick calculate the carousel width
	$( document.body ).on( "post-load", function () {
	    setTimeout( function() {
	        run_slick();
	    }, 500 );
	});

} )( jQuery );