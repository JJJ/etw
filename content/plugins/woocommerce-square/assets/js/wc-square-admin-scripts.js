jQuery( document ).ready( function( $ ) {
	'use strict';

	// create namespace to avoid any possible conflicts
	$.wc_square_admin = {
		/**
		 * Loops through the sync process
		 *
		 * @since 1.0.0
		 * @version 1.0.14
		 * @param int process the current step in the loop
		 * @param string type the type of the AJAX call
		 */
		sync: function( process, type ) {
			var data = {
				security: wc_square_local.ajaxSyncNonce,
				process: parseInt( process, 10 ),
				action: 'wc-to-square' === type ? 'wc_to_square' : 'square_to_wc'
			};

			$.ajax({
				type:    'POST',
				data:    data,
				url:     wc_square_local.admin_ajax_url
			}).done( function( response ) {
				if ( 'done' === response.process ) {
					// Triggers when all processing is done.
					$( 'body' ).trigger( 'woocommerce_square_wc_to_square_sync_complete', [ response ] );

					$( 'table.form-table' ).unblock();

					$( '.wc-square-progress-bar span' ).css( { width: response.percentage + '%' } ).parent( '.wc-square-progress-bar' ).fadeOut( 'slow', function() { 
							alert( response.message );
					});

				} else {
					$( '.wc-square-progress-bar span' ).css( { width: response.percentage + '%' } );

					$.wc_square_admin.sync( parseInt( response.process, 10 ), response.type );
				}
			}).fail( function( jqXHR, textStatus, errorThrown ) {
				$( 'table.form-table' ).unblock();
				console.log( errorThrown );
				alert( errorThrown );
			});
		},

		init_sync_buttons: function() {
			if ( ! wc_square_local.country_currency ) {
				$( '#wc-to-square, #square-to-wc' ).attr( 'disabled', 'disabled' );
				return;
			}

			$( '.woocommerce_page_wc-settings' ).on( 'click', '#wc-to-square, #square-to-wc', function( e ) {
				e.preventDefault();

				var confirmed = confirm( wc_square_local.i18n.confirm_sync );

				if ( ! confirmed ) {
					return;
				}

				var page = $( this ).parents( 'table.form-table' ),
					progress_bar = $( '<div class="wc-square-progress-bar wc-square-stripes"><span class="step"></span></div>' );

				// remove the progress bar on each trigger
				$( '.wc-square-progress-bar' ).remove();

				page.block({
					message: null,
					overlayCSS: {
						background: '#fff',
						opacity: 0.6
					}
				});

				// add the progress bar
				page.after( progress_bar );

				$.wc_square_admin.sync( 0, $( this ).attr( 'id' ) );
			});

		},

		init: function() {
			this.init_sync_buttons();

			$( document.body ).on( 'change', '#woocommerce_square_testmode', function() {
				if ( $( this ).is( ':checked' ) ) {
					$( '#woocommerce_square_application_id' ).parents( 'tr' ).eq(0).hide();
					$( '#woocommerce_square_token' ).parents( 'tr' ).eq(0).hide();

					$( '#woocommerce_square_sandbox_application_id' ).parents( 'tr' ).eq(0).show();
					$( '#woocommerce_square_sandbox_token' ).parents( 'tr' ).eq(0).show();
				} else {
					$( '#woocommerce_square_application_id' ).parents( 'tr' ).eq(0).show();
					$( '#woocommerce_square_token' ).parents( 'tr' ).eq(0).show();

					$( '#woocommerce_square_sandbox_application_id' ).parents( 'tr' ).eq(0).hide();
					$( '#woocommerce_square_sandbox_token' ).parents( 'tr' ).eq(0).hide();
				}
			});

			$( '#woocommerce_square_testmode' ).trigger( 'change' );

			$( document.body ).on( 'change', '#woocommerce_squareconnect_sync_products', function() {
				if ( $( this ).is( ':checked' ) ) {
					$( '#woocommerce_squareconnect_sync_categories' ).parents( 'tr' ).eq(0).show();
					$( '#woocommerce_squareconnect_sync_inventory' ).parents( 'tr' ).eq(0).show();
					$( '#woocommerce_squareconnect_sync_images' ).parents( 'tr' ).eq(0).show();
				} else {
					$( '#woocommerce_squareconnect_sync_categories' ).parents( 'tr' ).eq(0).hide();
					$( '#woocommerce_squareconnect_sync_inventory' ).parents( 'tr' ).eq(0).hide();
					$( '#woocommerce_squareconnect_sync_images' ).parents( 'tr' ).eq(0).hide();
				}
			});

			$( '#woocommerce_squareconnect_sync_products' ).trigger( 'change' );
		}
	}; // close namespace

	$.wc_square_admin.init();
// end document ready
});
