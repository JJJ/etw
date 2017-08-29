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

	// Logo preview
	wp.customize( 'camera_customizer_logo', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '.site-title, .site-description, .site-avatar' ).hide();
				$( '.site-title-wrap').append( '<h1 class="site-logo"><img /></h1>' );
				$( '.site-logo img').attr( 'src', to );
			} else {
				$( '.site-title, .site-description, .site-avatar' ).show();
				$( '.site-logo, .site-logo img' ).hide();
			}
		} );
	} );

	// Avatar
	wp.customize( 'camera_show_avatar', function( value ) {
		value.bind( function( to ) {
			if ( to ) {
				$( '.site-avatar' ).css( 'display', 'inline-block' );
			} else {
				$( '.site-avatar' ).hide();
			}
		} );
	} );

	// Dark color scheme
	wp.customize( 'camera_color_scheme', function( value ) {
		value.bind( function( to ) {
			if ( 'dark' === to ) {
				$( 'body' ).addClass( 'dark' );
			} else {
				$( 'body' ).removeClass( 'dark' );
			}
		} );
	} );

} )( jQuery );
