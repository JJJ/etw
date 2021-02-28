###*
# Square Credit Card Digital Wallet Handler class.
#
# @since 2.3
###

jQuery( document ).ready ( $ ) ->

	"use strict"

	# Square Credit Card Digital Wallet Handler class.
	#
	# @since 2.3
	class window.WC_Square_Digital_Wallet_Handler


		# Setup handler
		#
		# @since 2.3
		constructor: ( args ) ->
			@args            = args
			@payment_request = args.payment_request
			@wallet          = '#wc-square-digital-wallet'
			@buttons         = '.wc-square-wallet-buttons'

			if $( @wallet ).length == 0
				return

			$( @wallet ).hide()
			$( @buttons ).hide()

			this.build_digital_wallet()
			this.attach_page_events()


		# Fetch a new payment request object and reload the SqPaymentForm
		#
		# @since 2.3
		build_digital_wallet: ->
			this.block_ui()

			this.get_payment_request().then ( response ) =>
				@payment_request = $.parseJSON( response )

				this.load_square_form()
				this.unblock_ui()

			, ( response ) =>

				this.log( '[Square] Could not build payment request. ' + response.message, 'error' )
				$( @wallet ).hide()


		# Add page event listeners
		#
		# @since 2.3
		attach_page_events: ->

			if @args.context is 'product'
				addToCartButton = $( '.single_add_to_cart_button' )

				$( '#wc-square-apple-pay, #wc-square-google-pay' ).on 'click', ( e ) =>
					if addToCartButton.is( '.disabled' )
						e.stopImmediatePropagation()

						if addToCartButton.is( '.wc-variation-is-unavailable' )
							window.alert( wc_add_to_cart_variation_params.i18n_unavailable_text )
						else if addToCartButton.is( '.wc-variation-selection-needed' )
							window.alert( wc_add_to_cart_variation_params.i18n_make_a_selection_text )

						return

					this.add_to_cart()

				$( document.body ).on 'woocommerce_variation_has_changed', () =>
					this.build_digital_wallet()

				$( '.quantity' ).on 'input', '.qty', () =>
					this.build_digital_wallet()

			else if @args.context is 'cart'
				$( document.body ).on 'updated_cart_totals', () =>
					this.build_digital_wallet()

			else if @args.context is 'checkout'
				$( document.body ).on 'updated_checkout', () =>
					this.build_digital_wallet()


		# Load the digital wallet payment form
		#
		# @since 2.3
		load_square_form: ->

			if @payment_form
				this.log( '[Square] Destroying digital wallet payment form' )
				@payment_form.destroy()

			this.log( '[Square] Building digital wallet payment form' )
			@payment_form = new SqPaymentForm( this.get_form_params() )
			@payment_form.build()


		# Gets the Square payment form params.
		#
		# @since 2.3
		get_form_params: =>
			params = {
				applicationId: @args.application_id,
				locationId: @args.location_id,
				autobuild: false,
				applePay: {
					elementId: 'wc-square-apple-pay'
				},
				googlePay: {
					elementId: 'wc-square-google-pay'
				},
				callbacks: {
					paymentFormLoaded:                                => this.unblock_ui()
					createPaymentRequest:                             => this.create_payment_request()
					methodsSupported: ( methods, unsupportedReason )  => this.methods_supported( methods, unsupportedReason )
					shippingContactChanged: ( shippingContact, done ) => this.handle_shipping_address_changed( shippingContact, done )
					shippingOptionChanged: ( shippingOption, done )   => this.handle_shipping_option_changed( shippingOption, done )
					cardNonceResponseReceived: ( errors, nonce, cardData, billingContact, shippingContact, shippingOption ) => this.handle_card_nonce_response( errors, nonce, cardData, billingContact, shippingContact, shippingOption )
				}
			}

			# Fix console errors for Google Pay when there are no shipping options set. See note in Square documentation under shippingOptions: https://developer.squareup.com/docs/api/paymentform#paymentrequestfields
			if @payment_request.requestShippingAddress == false
				delete params.callbacks.shippingOptionChanged

			# Remove support for Google Pay and/or Apple Pay if chosen in settings
			if 'google' in @args.hide_button_options
				delete params.googlePay

			if 'apple' in @args.hide_button_options
				delete params.applePay

			return params


		# Sets the a payment request object for the Square Payment Form
		#
		# @since 2.3
		create_payment_request: ->
			return @payment_request


		# Check which methods are supported and show/hide the correct buttons on frontend
		# Reference: https://developer.squareup.com/docs/api/paymentform#methodssupported
		#
		# @since 2.3
		methods_supported: ( methods, unsupportedReason ) ->

			if methods.applePay == true or methods.googlePay == true
				if methods.applePay == true
					$( '#wc-square-apple-pay' ).show()

				if methods.googlePay == true
					$( '#wc-square-google-pay' ).show()

				$( @wallet ).show()
			else
				this.log( unsupportedReason )


		# Get the payment request on a product page
		#
		# @since 2.3
		get_payment_request: => new Promise ( resolve, reject ) =>
			data = {
				'context'  : @args.context,
				'security' : @args.payment_request_nonce,
			}

			if @args.context is 'product'
				product_data = this.get_product_data()
				$.extend data, product_data

			# retrieve a payment request object
			$.post this.get_ajax_url( 'get_payment_request' ), data, ( response ) =>
				if response.success
					resolve response.data
				else
					reject response.data


		# Handle all shipping address recalculations in the Apple/Google Pay window
		# Reference: https://developer.squareup.com/docs/api/paymentform#shippingcontactchanged
		#
		# @since 2.3
		handle_shipping_address_changed: ( shippingContact, done ) ->
			data = {
				'context'          : @args.context,
				'shipping_contact' : shippingContact.data,
				'security'         : @args.recalculate_totals_nonce
			}

			# send ajax request get_shipping_options
			this.recalculate_totals( data ).then ( response ) =>
				done( response )
			, ( response ) =>
				done({ error: 'Bad Request' })


		# Handle all shipping method changes in the Apple/Google Pay window
		# Reference: https://developer.squareup.com/docs/api/paymentform#shippingoptionchanged
		#
		# @since 2.3
		handle_shipping_option_changed: ( shippingOption, done ) ->
			data = {
				'context'         : @args.context,
				'shipping_option' : shippingOption.data.id,
				'security'        : @args.recalculate_totals_nonce
			}

			this.recalculate_totals( data ).then ( response ) =>
				done( response )
			, ( response ) =>
				done({ error: 'Bad Request' })


		# Handle the payment response.
		#
		# On success, set the checkout billing/shipping data and submit the checkout.
		#
		# @since 2.3
		handle_card_nonce_response: ( errors, nonce, cardData, billingContact, shippingContact, shippingOption ) ->

			if errors
				return this.render_errors( errors )

			if not nonce
				return this.render_errors( @args.general_error )

			this.block_ui()

			data = {
				'action'  : '',
				'_wpnonce': @args.process_checkout_nonce,
				'billing_first_name': if billingContact.givenName then billingContact.givenName else '',
				'billing_last_name': if billingContact.familyName then billingContact.familyName else '',
				'billing_company': '',
				'billing_email': if shippingContact.email then shippingContact.email else '',
				'billing_phone': if shippingContact.phone then shippingContact.phone else '',
				'billing_country': if billingContact.country then billingContact.country.toUpperCase() else '',
				'billing_address_1': if billingContact.addressLines && billingContact.addressLines[0] then billingContact.addressLines[0] else '',
				'billing_address_2': if billingContact.addressLines && billingContact.addressLines[1] then billingContact.addressLines[1] else '',
				'billing_city': if billingContact.city then billingContact.city else '',
				'billing_state': if billingContact.region then billingContact.region else '',
				'billing_postcode': if billingContact.postalCode then billingContact.postalCode else '',
				'shipping_first_name': if shippingContact.givenName then shippingContact.givenName else '',
				'shipping_last_name': if shippingContact.familyName then shippingContact.familyName else '',
				'shipping_company': '',
				'shipping_country': if shippingContact.country then shippingContact.country.toUpperCase() else '',
				'shipping_address_1': if shippingContact.addressLines && shippingContact.addressLines[0] then shippingContact.addressLines[0] else '',
				'shipping_address_2': if shippingContact.addressLines && shippingContact.addressLines[1] then shippingContact.addressLines[1] else '',
				'shipping_city': if shippingContact.city then shippingContact.city else '',
				'shipping_state': if shippingContact.region then shippingContact.region else '',
				'shipping_postcode': if shippingContact.postalCode then shippingContact.postalCode else '',
				'shipping_method': [ if not shippingOption then null else shippingOption.id ],
				'order_comments': '',
				'payment_method': 'square_credit_card',
				'ship_to_different_address': 1,
				'terms': 1,
				'wc-square-credit-card-payment-nonce': nonce,
				'wc-square-credit-card-last-four': if cardData.last_4 then cardData.last_4 else null,
				'wc-square-credit-card-exp-month': if cardData.exp_month then cardData.exp_month else null,
				'wc-square-credit-card-exp-year': if cardData.exp_year then cardData.exp_year else null,
				'wc-square-credit-card-payment-postcode': if cardData.billing_postal_code then cardData.billing_postal_code else null,
				'wc-square-digital-wallet-type': cardData.digital_wallet_type,
			}

			# handle slightly different mapping for Google Pay (Google returns full name as a single string)
			if cardData.digital_wallet_type is 'GOOGLE_PAY'
				if billingContact.givenName
					data.billing_first_name = billingContact.givenName.split( ' ' ).slice( 0, 1 ).join( ' ' )
					data.billing_last_name = billingContact.givenName.split( ' ' ).slice( 1 ).join(' ')

				if shippingContact.givenName
					data.shipping_last_name = shippingContact.givenName.split( ' ' ).slice( 0, 1 ).join( ' ' )
					data.shipping_last_name = shippingContact.givenName.split( ' ' ).slice( 1 ).join( ' ' )

			# if the billing_phone was not found on shippingContact, use the value on billingContact if that exists
			if not data.billing_phone && billingContact.phone
				data.billing_phone = billingContact.phone

			# AJAX process checkout
			this.process_digital_wallet_checkout( data ).then ( response ) =>
				window.location = response.redirect

			, ( response ) =>
				this.log( response, 'error' )
				this.render_errors_html( response.messages )


		# Recalculate totals
		#
		# @since 2.3
		recalculate_totals: ( data ) => new Promise ( resolve, reject ) =>
			$.post this.get_ajax_url( 'recalculate_totals' ), data, ( response ) =>
				if response.success
					resolve response.data
				else
					reject response.data


		# Get the product data for building the payment request on the product page 
		#
		# @since 2.3
		get_product_data: ->
			product_id = $( '.single_add_to_cart_button' ).val()
			attributes = {}

			# Check if product is a variable product.
			if $( '.single_variation_wrap' ).length
				product_id = $( '.single_variation_wrap' ).find( 'input[name="product_id"]' ).val()

				if $( '.variations_form' ).length
					$( '.variations_form' ).find( '.variations select' ).each ( index, select ) =>
						attribute_name = $( select ).data( 'attribute_name' ) || $( select ).attr( 'name' )
						value          = $( select ).val() || ''

						attributes[ attribute_name ] = value;

			return {
				'product_id'            : product_id,
				'quantity'              : $( '.quantity .qty' ).val(),
				'attributes'            : attributes,
			}


		# Add the product to the cart
		#
		# @since 2.3
		add_to_cart: ->
			data = {
				'security' : @args.add_to_cart_nonce,
			}

			product_data = this.get_product_data()
			$.extend data, product_data

			# retrieve a payment request object
			$.post this.get_ajax_url( 'add_to_cart' ), data, ( response ) =>
				if response.error
					window.alert( response.data )
				else
					data = $.parseJSON( response.data )

					@payment_request               = data.payment_request
					@args.payment_request_nonce    = data.payment_request_nonce
					@args.add_to_cart_nonce        = data.add_to_cart_nonce
					@args.recalculate_totals_nonce = data.recalculate_totals_nonce
					@args.process_checkout_nonce   = data.process_checkout_nonce


		# Process the digital wallet checkout
		#
		# @since 2.3
		process_digital_wallet_checkout: ( data ) => new Promise ( resolve, reject ) =>
			$.post this.get_ajax_url( 'process_checkout' ), data, ( response ) =>
				if response.result is 'success'
					resolve response
				else
					reject response


		# Helper function to return the ajax URL for the given request/action
		#
		# @since 2.3
		get_ajax_url: ( request ) ->
			return @args.ajax_url.replace( '%%endpoint%%', 'square_digital_wallet_' + request )


		# Renders errors given the error message HTML
		#
		# @since 2.3
		render_errors_html: ( errors_html ) ->
			# hide and remove any previous errors
			$( '.woocommerce-error, .woocommerce-message' ).remove()

			element = if @args.context == 'product' then $( '.product' ) else $( '.shop_table.cart' ).closest( 'form' )

			# add errors
			element.before errors_html

			# unblock UI
			this.unblock_ui()

			# scroll to top
			$( 'html, body' ).animate( { scrollTop: element.offset().top - 100 }, 1000 )


		# Renders errors
		#
		# @since 2.3
		render_errors: ( errors ) ->
			error_message_html = '<ul class="woocommerce-error"><li>' + errors.join( '</li><li>' ) + '</li></ul>'

			this.render_errors_html( error_message_html )


		# Block the Apple Pay and Google Pay buttons from being clicked which processing certain actions
		#
		# @since 2.3
		block_ui: ->
			$( @buttons ).block( { message: null, overlayCSS: background: '#fff', opacity: 0.6 } )


		# Unblock the wallet buttons
		#
		# @since 2.3
		unblock_ui: ->
			$( @buttons ).unblock()


		# Logs messages to the console when logging is turned on in the settings
		#
		# @since 2.3
		log: ( message, type = 'notice' ) ->
			# if logging is disabled, bail
			return unless @args.logging_enabled

			if type is 'error'
				console.error message
			else
				console.log message
