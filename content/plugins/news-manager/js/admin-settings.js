jQuery( document ).ready( function ( $ ) {

	$( document ).on( 'click', 'input#reset_nm_general, input#reset_nm_capabilities, input#reset_nm_permalinks', function () {
		return confirm( nmArgs.resetToDefaults );
	} );
} );