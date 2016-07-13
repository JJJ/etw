jQuery( document ).ready( function ( $ ) {

	$( document ).on( 'change', '.taxonomy-select-tags', function () {
		if ( $( this ).val() === 'selected' ) {
			$( this ).parent().find( '.checkbox-list-tags' ).fadeIn( 300 );
		} else if ( $( this ).val() === 'all' ) {
			$( this ).parent().find( '.checkbox-list-tags' ).fadeOut( 300 );
		}
	} );

	$( document ).on( 'change', '.taxonomy-select-cats', function () {
		if ( $( this ).val() === 'selected' ) {
			$( this ).parent().find( '.checkbox-list-cats' ).fadeIn( 300 );
		} else if ( $( this ).val() === 'all' ) {
			$( this ).parent().find( '.checkbox-list-cats' ).fadeOut( 300 );
		}
	} );
} );