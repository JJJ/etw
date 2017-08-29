/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title, .site-description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );

	// Sidebar Toggle color
	wp.customize( 'designer_customizer_toggle', function( value ) {
		value.bind( function( to ) {
			if ( 'dark' === to ) {
				$( '.sidebar-toggle' ).addClass( 'dark' ).removeClass( 'light' );
			} else {
				$( '.sidebar-toggle' ).removeClass( 'dark' ).addClass( 'light' );
			}
		} );
	} );

	// Accent color
	wp.customize( 'designer_customizer_accent', function( value ) {
		value.bind( function( to ) {
			$( '.edit-link a, .mejs-time-current, .mejs-horizontal-volume-current' ).css( 'background', to );

			// Content area border color
			$( '.entry-content p a' ).hover( function() {
			    $( this ).css( 'border-bottom-color', to );
			});

			// Sidebar toggle icon hover
			$( '.sidebar-toggle' ).hover( function() {
				$( '.flyout-toggle' ).css( 'color', to );
			}, function() {
				$( '.flyout-toggle' ).css( 'color', '' );
			});

			// Button hovers
			$( '#infinite-handle span, button, input[type="button"], input[type="reset"], input[type="submit"], .button' ).hover( function() {
				$( this ).css( 'background', to );
			}, function() {
				$( this ).css( 'background', '#383F49' );
			});

			// Featured image background
			$( '.featured-image' ).hover( function() {
				$( this ).css( 'background', to );
			}, function() {
				$( this ).css( 'background', '#fff' );
			});
		} );
	} );

	// Body text color
	wp.customize( 'designer_customizer_body_text', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).css( 'color', to );
		} );
	} );

	// Logo preview
	wp.customize( 'designer_customizer_logo', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '.site-title, .site-description, .site-avatar' ).hide();
				$( '.branding-widget').append( '<h1 class="site-logo"><img /></h1>' );
				$( '.site-logo img').attr( 'src', to );
			} else {
				$( '.site-title, .site-description, .site-avatar' ).show();
				$( '.site-logo, .site-logo img' ).hide();
			}
		} );
	} );

	// Show sidebar
	wp.customize( 'designer_show_sidebar', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( ".site-header, #page" ).addClass( "sidebar-open" );

				$( window ).trigger( "resize" );
				return false;
			} else {
				$( ".site-header, .sidebar-toggle, .container" ).removeClass( "active sidebar-open" );
				$( window ).trigger( "resize" );
			}
		} );
	} );

	// Blog section title
	wp.customize( 'designer_customizer_homepage_blog_title', function( value ) {
		value.bind( function( to ) {
			$( '.blog-section .entry-title' ).text( to );
		} );
	} );

	// Portfolio page text
	wp.customize( 'designer_customizer_portfolio_text', function( value ) {
		value.bind( function( to ) {
			$( '.post-type-archive-jetpack-portfolio .taxonomy-description' ).text( to );
		} );
	} );

} )( jQuery );
