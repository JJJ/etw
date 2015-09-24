/**
 * AJAX handlers for destroying single or multiple sessions on profile.php
 */

( function( $ ) {

	$('.session-destroy-other,.session-destroy-all').on('click',function(e){

		var data = {
			action      : 'wpsm_destroy_sessions',
			_ajax_nonce : wpsm.nonce_multiple,
			user_id     : wpsm.user_id,
			token       : $(this).data('token')
		};

		$.post( ajaxurl, data, function( response ) {

			if ( response.success ) {
				$('#other-locations').fadeOut('slow');
			} else {
				alert( response.data.message );
			}

		}, 'json' );

		e.preventDefault();

	});

} )( jQuery );