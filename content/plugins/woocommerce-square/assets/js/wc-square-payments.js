(function ( $ ) {
	'use strict';

	var wcSquarePaymentForm;

	// create namespace to avoid any possible conflicts
	$.wc_square_payments = {
		init: function() {
			// Checkout page
			$( document.body ).on( 'updated_checkout', function() {
				$.wc_square_payments.loadForm();	
			});

			// Pay order form page
			if ( $( 'form#order_review' ).length ) {
				$.wc_square_payments.loadForm();
			}

			var custom_element = square_params.custom_form_trigger_element;

			// custom click trigger for 3rd party forms that initially hides the payment form
			// such as multistep checkout plugins
			if ( custom_element.length ) {
				$( document.body ).on( 'click', custom_element, function() {
					$.wc_square_payments.loadForm();		
				});
			}

			// work around for iFrame not loading if elements being replaced is hidden
			$( document.body ).on( 'click', '#payment_method_square', function() {
				$( '.payment_box.payment_method_square' ).css( { 'display': 'block', 'visibility': 'visible', 'height': 'auto' } );	
			});
		},
		loadForm: function() {
			if ( $( '#payment_method_square' ).length ) {
				// work around for iFrame not loading if elements being replaced is hidden
				if ( ! $( '#payment_method_square' ).is( ':checked' ) ) {
					$( '.payment_box.payment_method_square' ).css( { 'display': 'block', 'visibility': 'hidden', 'height': '0' } );
				}

				// destroy the form and rebuild on each init
				if ( 'object' === $.type( wcSquarePaymentForm ) ) {
					wcSquarePaymentForm.destroy();
				}

				wcSquarePaymentForm = new SqPaymentForm({
					env: square_params.environment,
					applicationId: square_params.application_id,
					inputClass: 'sq-input',
					cardNumber: {
						elementId: 'sq-card-number',
						placeholder: square_params.placeholder_card_number   
					},
					cvv: {
						elementId: 'sq-cvv',
						placeholder: square_params.placeholder_card_cvv
					},
					expirationDate: {
						elementId: 'sq-expiration-date',
						placeholder: square_params.placeholder_card_expiration
					},
					postalCode: {
						elementId: 'sq-postal-code',
						placeholder: square_params.placeholder_card_postal_code
					},
					callbacks: {
						cardNonceResponseReceived: function( errors, nonce, cardData ) {
							if ( errors ) {
								var html = '';

								html += '<ul class="woocommerce_error woocommerce-error">';

								// handle errors
								$( errors ).each( function( index, error ) { 
									html += '<li>' + error.message + '</li>';
								});

								html += '</ul>';

								// append it to DOM
								$( '.payment_method_square fieldset' ).eq(0).prepend( html );
							} else {
								var $form = $( 'form.woocommerce-checkout, form#order_review' );

								// inject nonce to a hidden field to be submitted
								$form.append( '<input type="hidden" class="square-nonce" name="square_nonce" value="' + nonce + '" />' );

								$form.submit();
							}
						},

						paymentFormLoaded: function() {
							wcSquarePaymentForm.setPostalCode( $( '#billing_postcode' ).val() );
						},

						unsupportedBrowserDetected: function() {
							var html = '';

							html += '<ul class="woocommerce_error woocommerce-error">';
							html += '<li>' + square_params.unsupported_browser + '</li>';
							html += '</ul>';

							// append it to DOM
							$( '.payment_method_square fieldset' ).eq(0).prepend( html );
						}
					},
					inputStyles: $.parseJSON( square_params.payment_form_input_styles )
				});

				wcSquarePaymentForm.build();

				// when checkout form is submitted on checkout page
				$( 'form.woocommerce-checkout' ).on( 'checkout_place_order_square', function( event ) {
					// remove any error messages first
					$( '.payment_method_square .woocommerce-error' ).remove();

					if ( $( '#payment_method_square' ).is( ':checked' ) && $( 'input.square-nonce' ).length === 0 ) {
						wcSquarePaymentForm.requestCardNonce();

						return false;
					}

					return true;
				});

				// when checkout form is submitted on pay order page
				$( 'form#order_review' ).on( 'submit', function( event ) {
					// remove any error messages first
					$( '.payment_method_square .woocommerce-error' ).remove();

					if ( $( '#payment_method_square' ).is( ':checked' ) && $( 'input.square-nonce' ).length === 0 ) {
						wcSquarePaymentForm.requestCardNonce();

						return false;
					}

					return true;
				});

				$( document.body ).on( 'checkout_error', function() {
					$( 'input.square-nonce' ).remove();
				});

				// work around for iFrame not loading if elements being replaced is hidden
				setTimeout( function() {
					if ( ! $( '#payment_method_square' ).is( ':checked' ) ) {
						$( '.payment_box.payment_method_square' ).css( { 'display': 'none', 'visibility': 'visible', 'height': 'auto' } );
					}
				}, 1000 );
			}
		}
	}; // close namespace

	$.wc_square_payments.init();
}( jQuery ) );
