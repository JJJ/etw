###*
# WooCommerce Square Payment Form handler.
#
# @since 2.0.0
###

jQuery( document ).ready ( $ ) ->

	"use strict"

	# Square Credit Card Payment Form Handler class.
	#
	# @since 2.0.0
	class window.WC_Square_Payment_Form_Handler


		# Setup handler
		#
		# @since 2.3.2-1
		constructor: ( args ) ->

			@id                 = args.id
			@id_dasherized      = args.id_dasherized
			@csc_required       = args.csc_required
			@enabled_card_types = args.enabled_card_types
			@square_card_types  = args.square_card_types

			@logging_enabled  = args.logging_enabled
			@general_error    = args.general_error
			@ajax_url         = args.ajax_url
			@ajax_log_nonce   = args.ajax_log_nonce
			@input_styles     = args.input_styles
			@application_id   = args.application_id

			# which payment form?
			if $( 'form.checkout' ).length
				@form = $( 'form.checkout' )
				this.handle_checkout_page()

			else if $( 'form#order_review' ).length
				@form = $( 'form#order_review' )
				this.handle_pay_page()

			else if $( 'form#add_payment_method' ).length
				@form = $( 'form#add_payment_method' )
				this.handle_add_payment_method_page()

			else
				console.log( 'No payment form found!' )
				return

			# localized error messages
			@params = window[ "sv_wc_payment_gateway_payment_form_params" ]

			# unblock the UI and clear any payment nonces when a server-side error occurs
			$( document.body ).on( 'checkout_error', ->
				$( "input[name=wc-square-credit-card-payment-nonce]" ).val( '' )
			)


			$( document.body ).on( 'click', "#payment_method_#{@id}", ->

				if @payment_form

					this.log 'Recalculating payment form size'
					@payment_form.recalculateSize()
			)


		# Public: Handle required actions on the checkout page
		#
		# Returns nothing.
		handle_checkout_page: ->

			# updated payment fields jQuery object on each checkout update (prevents stale data)
			$( document.body ).on( 'updated_checkout', => this.set_payment_fields() )

			# handle saved payment methods
			# note on the checkout page, this is bound to `updated_checkout` so it
			# fires even when other parts of the checkout are changed
			$( document.body ).on( 'updated_checkout', => this.handle_saved_payment_methods() )

			# validate payment data before order is submitted
			@form.on( "checkout_place_order_#{ @id }", => this.validate_payment_data() )


		# Public: Handle associated actions for saved payment methods
		#
		# Returns nothing.
		handle_saved_payment_methods: ->

			# make available inside change events
			id_dasherized = @id_dasherized

			$new_payment_method_selection = $( "div.js-wc-#{ id_dasherized }-new-payment-method-form" )

			# show/hide the saved payment methods when a saved payment method is de-selected/selected
			$( "input.js-wc-#{ @id_dasherized }-payment-token" ).change ->

				tokenized_payment_method_selected = $( "input.js-wc-#{ id_dasherized }-payment-token:checked" ).val()

				if tokenized_payment_method_selected

					# using an existing tokenized payment method, hide the 'new method' fields
					$new_payment_method_selection.slideUp( 200 )

				else
					# use new payment method, display the 'new method' fields
					$new_payment_method_selection.slideDown( 200 )

			.change()

			# display the 'save payment method' option for guest checkouts if the 'create account' option is checked
			#  but only hide the input if there is a 'create account' checkbox (some themes just display the password)
			$( 'input#createaccount' ).change ->
				$parent_row = $( "input.js-wc-#{ id_dasherized }-tokenize-payment-method" ).closest( 'p.form-row' )

				if $( this ).is( ':checked' )
					$parent_row.slideDown()
					$parent_row.next().show()
				else
					$parent_row.hide()
					$parent_row.next().hide()

			$( 'input#createaccount' ).change() unless $( 'input#createaccount' ).is( ':checked' )


		# Public: Handle required actions on the Order > Pay page
		#
		# Returns nothing.
		handle_pay_page: ->

			this.set_payment_fields()

			# handle saved payment methods
			this.handle_saved_payment_methods()

			# validate payment data before order is submitted
			@form.submit =>

				# but only when one of our payment gateways is selected
				return this.validate_payment_data() if $( '#order_review input[name=payment_method]:checked' ).val() is @id


		# Public: Handle required actions on the Add Payment Method page
		#
		# Returns nothing.
		handle_add_payment_method_page: ->

			this.set_payment_fields()

			# validate payment data before order is submitted
			@form.submit =>

				# but only when one of our payment gateways is selected
				return this.validate_payment_data() if $( '#add_payment_method input[name=payment_method]:checked' ).val() is @id


		# Sets up the Square payment fields
		#
		# @since 2.0.0
		set_payment_fields: =>

			if @payment_form

				this.log 'Destroying payment form'

				@payment_form.destroy()

			this.log 'Building payment form'

			@payment_form = new SqPaymentForm( this.get_form_params() )

			@payment_form.build()


		# Gets the Square payment form params.
		#
		# @since 2.0.0
		#
		# @return Object
		get_form_params: =>

			$card_number = $( "#wc-#{@id_dasherized}-account-number-hosted" )
			$expiration  = $( "#wc-#{@id_dasherized}-expiry-hosted" )
			$csc         = $( "#wc-#{@id_dasherized}-csc-hosted" )
			$postal_code = $( "#wc-#{@id_dasherized}-postal-code-hosted" )

			return {
				applicationId: @application_id
				cardNumber: {
					elementId: $card_number.attr( 'id' )
					placeholder: $card_number.data( 'placeholder' )
				}
				expirationDate: {
					elementId: $expiration.attr( 'id' )
					placeholder: $expiration.data( 'placeholder' )
				}
				cvv: {
					elementId: $csc.attr( 'id' )
					placeholder: $csc.data( 'placeholder' )
				}
				postalCode: {
					elementId: $postal_code.attr( 'id' )
					placeholder: $postal_code.data( 'placeholder' )
				}
				inputClass: "wc-#{@id_dasherized}-payment-field"
				inputStyles: @input_styles
				callbacks: {
					inputEventReceived: ( event ) => this.handle_input_event( event )
					cardNonceResponseReceived: ( errors, nonce, cardData ) => this.handle_response( errors, nonce, cardData )
					unsupportedBrowserDetected: => this.handle_unsupported_browser()
					paymentFormLoaded: => this.handle_form_loaded()
				}
			}


		# Handles when the payment form is fully loaded.
		#
		# @since 2.0.0
		handle_form_loaded: ->

			this.log 'Payment form loaded'

			@payment_form.setPostalCode( $( '#billing_postcode' ).val() )

			# hide the postcode field on the checkout page or if it already has a value
			if $( 'form.checkout' ).length or $( '#billing_postcode' ).val()
				$( ".wc-square-credit-card-card-postal-code-parent" ).addClass( 'hidden' )


		# Handles payment form input changes.
		#
		# @since 2.0.0
		handle_input_event: ( event ) =>

			$input = $( '#' + event.elementId )

			if event.eventType is 'cardBrandChanged'
				this.handle_card_brand_change( event.cardBrand, $input )


		# Handles card number brand changes.
		#
		# @since 2.0.0
		handle_card_brand_change: ( brand, $input ) ->

			this.log "Card brand changed to #{brand}"

			# clear any existing card type class
			$input.attr( 'class', (i, c) -> c.replace( /(^|\s)card-type-\S+/g, '' ) )

			card_class = 'plain'

			if not brand? or brand is 'unknown'
				brand = ''

			if @square_card_types[brand]?
				brand = @square_card_types[brand]

			if brand and brand not in @enabled_card_types
				card_class = 'invalid'
			else
				card_class = brand

			$( "input[name=wc-#{@id_dasherized}-card-type]" ).val( brand )

			$input.addClass( "card-type-#{card_class}" )


		# Used to request a card nonce and submit the form.
		#
		# @since 2.0.0
		validate_payment_data: ->

			# bail when already processing
			return false if @form.is( '.processing' )

			# let through if nonce is already present
			if this.has_nonce()
				this.log 'Payment nonce present, placing order'
				return true

			return true if $( ".payment_method_#{ @id }" ).find( '.js-wc-square-credit-card-payment-token:checked' ).val()

			this.log 'Requesting payment nonce'

			this.block_ui()

			@payment_form.requestCardNonce()

			return false


		# Handles the Square payment form response.
		#
		# @since 2.0.0
		#
		# @param Object[] errors validation errors, if any
		# @param String nonce payment nonce
		handle_response: ( errors, nonce, cardData ) ->

			# if we have real errors to display from Square
			if errors
				return this.handle_errors( errors )

			# no errors, but also no payment data
			if not nonce

				message = 'Nonce is missing from the Square response'

				this.log message, 'error'
				this.log_data message, 'response'

				return this.handle_errors()

			# if we made it this far, we have payment data
			this.log 'Card data received'
			console.log cardData
			this.log_data( cardData, 'response' )

			if cardData.last_4
				$( "input[name=wc-#{@id_dasherized}-last-four]" ).val( cardData.last_4 )

			if cardData.exp_month
				$( "input[name=wc-#{@id_dasherized}-exp-month]" ).val( cardData.exp_month )

			if cardData.exp_year
				$( "input[name=wc-#{@id_dasherized}-exp-year]" ).val( cardData.exp_year )

			if cardData.billing_postal_code
				$( "input[name=wc-square-credit-card-payment-postcode]" ).val( cardData.billing_postal_code )

			# payment nonce data
			$( "input[name=wc-#{@id_dasherized}-payment-nonce]" ).val( nonce )

			# now that we have a nonce, resubmit the form
			@form.submit()


		# Handles unsupported browsers.
		#
		# @since 2.0.0
		handle_unsupported_browser: ->


		# Handle error data.
		#
		# @since 2.0.0
		# @param Object[]
		handle_errors: ( errors = null ) ->

			this.log 'Error getting payment data', 'error'

			messages = []

			if errors

				console.error errors

				$( errors ).each ( index, error ) =>

					# only display the errors that can be helped by the customer
					if error.type in [ 'UNSUPPORTED_CARD_BRAND', 'VALIDATION_ERROR' ]

						messages.push( error.message )

					# otherwise, log more serious errors to the debug log
					else
						this.log_data( errors, 'response' )

			# if no specific messages are set, display a general error
			if messages.length is 0
				messages.push( @general_error )

			this.render_errors( messages )

			this.unblock_ui()


		# Public: Render any new errors and bring them into the viewport
		#
		# Returns nothing.
		render_errors: (errors) ->

			# hide and remove any previous errors
			$( '.woocommerce-error, .woocommerce-message' ).remove()

			# add errors
			@form.prepend '<ul class="woocommerce-error"><li>' + errors.join( '</li><li>' ) + '</li></ul>'

			# unblock UI
			@form.removeClass( 'processing' ).unblock()
			@form.find( '.input-text, select' ).blur()

			# scroll to top
			$( 'html, body' ).animate( { scrollTop: @form.offset().top - 100 }, 1000 )


		# Blocks the payment form UI
		#
		# @since 3.0.0
		block_ui: -> @form.block( message: null, overlayCSS: background: '#fff',opacity: 0.6 )


		# Unblocks the payment form UI
		#
		# @since 3.0.0
		unblock_ui: -> @form.unblock()


		# Determines if a nonce is present in the hidden input.
		#
		# @since 2.0.0
		# @return Bool
		has_nonce: -> $( "input[name=wc-#{@id_dasherized}-payment-nonce]" ).val()


		# Logs data to the debug log via AJAX.
		#
		# @since 2.0.0
		#
		# @param Object data request data
		# @param String type data type
		log_data: ( data, type ) ->

			# if logging is disabled, bail
			return unless @logging_enabled

			ajax_data = {
				'action'     : 'wc_' + @id + '_log_js_data',
				'security'   : @ajax_log_nonce,
				'type'       : type,
				'data'       : data
			}

			$.ajax( url: @ajax_url, data: ajax_data )


		# Logs any messages or errors to the console.
		#
		# @since 2.0.0
		log: ( message, type = 'notice' ) ->

			# if logging is disabled, bail
			return unless @logging_enabled

			if type is 'error'
				console.error 'Square Error: ' + message
			else
				console.log 'Square: ' + message
