"use strict"

###*
# WooCommerce Square admin general scripts for the settings page and update tab.
#
# @since 2.0.0
###
jQuery( document ).ready ( $ ) ->

	typenow = window.typenow ? ''
	pagenow = window.pagenow ? ''

	# bail if not on product admin pages
	if 'product' isnt typenow
		return

	# bail if product sync is disabled
	if not wc_square_admin_products.is_product_sync_enabled
		return


	# products edit screen
	if 'edit-product' is pagenow


		# when clicking the quick edit button fetch the default Synced with Square checkbox
		$( '#the-list' ).on 'click', '.editinline', ->

			$row   = $( this ).closest( 'tr' )
			postID = $row.find( 'th.check-column input' ).val()
			data   =
				action     : 'wc_square_get_quick_edit_product_details'
				security   : wc_square_admin_products.get_quick_edit_product_details_nonce
				product_id : $row.find( 'th.check-column input' ).val()

			$.post wc_square_admin_products.ajax_url, data, ( response ) ->

				$editRow           = $( 'tr#edit-' + postID )
				$squareSynced      = $editRow.find( 'select.square-synced' )
				$errors            = $editRow.find( '.wc-square-sync-with-square-errors' )

				if ! response.success and response.data
					# if the product has multiple attributes we show an inline error message and bail
					if 'multiple_attributes' is response.data
						$squareSynced.prop( 'checked', false )
						$squareSynced.prop( 'disabled', true )
						$errors.find( '.multiple_attributes' ).show()
						return
					# if the product has variations without an SKU we show an inline error message and bail
					else if 'missing_variation_sku' is response.data
						$squareSynced.prop( 'checked', false )
						$squareSynced.prop( 'disabled', true )
						$errors.find( '.missing_variation_sku' ).show()
						return

				$sku                  = $editRow.find( 'input[name=_sku]' )
				$stockStatus          = $editRow.find( 'select[name=_stock_status]' )
				$stockQty             = $editRow.find( 'input[name=_stock]' )
				$manageStockLabel     = $editRow.find( '.manage_stock_field .manage_stock' )
				$manageStockInput     = $editRow.find( 'input[name=_manage_stock]' )
				$manageStockDesc      = '<span class="description"><a href="' + wc_square_admin_products.settings_url + '">' + wc_square_admin_products.i18n.synced_with_square + '</a></span>'
				edit_url              = response.data.edit_url
				i18n                  = response.data.i18n
				is_variable           = response.data.is_variable

				$squareSynced.val( response.data.is_synced_with_square )

				# if the SKU changes, enabled or disable Synced with Square checkbox accordingly
				$sku.on 'change keyup keypress', ( e ) ->
					if '' is $( this ).val() and ! is_variable
						$squareSynced.val( 'no' )
						$squareSynced.prop( 'disabled', true )
						$errors.find( '.missing_sku' ).show()
					else
						$squareSynced.prop( 'disabled', false )
						$squareSynced.trigger 'change'
						$errors.find( '.missing_sku' ).hide()
				.trigger 'change'

				# if Synced with Square is enabled, we might as well disable stock management (without verbose explanations as in the product page)
				$squareSynced.on 'change', ( e ) ->
					if 'no' is $( this ).val()
						$manageStockInput.off()
						$manageStockInput.add( $stockQty ).css( { 'opacity': 1 } )
						$manageStockLabel.find( '.description' ).remove()
						# Stock input manipulation will differ depending on whether product is variable or simple
						if is_variable
							if $manageStockInput.is( ':checked' )
								$( '.stock_qty_field' ).show()
								$( '.backorder_field' ).show()
							else
								$( '.stock_status_field' ).show()
						else
							$stockQty.prop( 'readonly', false )
							$stockStatus.prop( 'readonly', false )
					else
						$manageStockInput.prop( 'checked', true );
						$manageStockInput.on 'click', -> false
						$manageStockInput.add( $stockQty ).css( { 'opacity': '0.5' } )
						$manageStockLabel.append( $manageStockDesc )
						if wc_square_admin_products.is_woocommerce_sor and edit_url and i18n
							$manageStockLabel.append( '<p class="description"><a href="' + edit_url + '">' + i18n + '</a></p>' )
						if is_variable
							$( '.stock_status_field' ).hide()
							$( '.stock_qty_field' ).hide()
							$( '.backorder_field' ).hide()
						else
							$stockQty.prop( 'readonly', true )
							$stockStatus.prop( 'readonly', true )
				.trigger 'change'

	# individual product edit screen
	if 'product' is pagenow

		syncCheckboxID = '#_' + wc_square_admin_products.synced_with_square_taxonomy


		isVariable = ->
			return $( '#product-type' ).val() in wc_square_admin_products.variable_product_types


		###*
		# Checks whether the product has a SKU.
		#
		# @since 2.0.0
		###
		hasSKU = ->
			return $( '#_sku' ).val().trim() isnt ''


		###*
		# Checks whether the product variations all have SKUs.
		#
		# @since 2.2.3
		###
		hasVariableSKUs = ( skus ) ->

			return false if not skus.length

			valid = skus.filter ->
				return true if $( this ).val().trim() isnt ''

			return valid.length is skus.length


		###*
		# Checks whether the given skus are unique.
		#
		# @since 2.2.3
		###
		hasUniqueSKUs = ( skus ) ->

			skuValues = skus.map ( sku ) ->
				$( this ).val()

			skuValues = $.makeArray( skuValues )

			return skuValues.every ( sku ) ->
				skuValues.indexOf( sku ) is skuValues.lastIndexOf( sku )


		###*
		# Checks whether the product has more than one variation attribute.
		#
		# @since 2.0.0
		###
		hasMultipleAttributes = ->

			$variation_attributes = $( '.woocommerce_attribute_data input[name^="attribute_variation"]:checked' )

			return isVariable() and $variation_attributes and $variation_attributes.length > 1


		###*
		# Displays the given error and disables the sync checkbox
		# Accepted errors are 'missing_sku', 'missing_variation_sku', and 'multiple_attributes'
		#
		# @since 2.2.3
		###
		showError = ( error ) ->
			$( '.wc-square-sync-with-square-error.' + error ).show()
			$( syncCheckboxID ).prop( 'disabled', true )
			$( syncCheckboxID ).prop( 'checked', false )


		###*
		# Hides the given error and maybe enables the sync checkbox
		# Accepted errors are 'missing_sku', 'missing_variation_sku', and 'multiple_attributes'
		#
		# @since 2.2.3
		###
		hideError = ( error, enable = true ) ->
			$( '.wc-square-sync-with-square-error.' + error ).hide()
			if enable
				$( syncCheckboxID ).prop( 'disabled', false )


		###*
		# Handle SKU.
		#
		# Disables the Sync with Square checkbox and toggles an inline notice when no SKU is set on a product.
		#
		# @since 2.0.0
		###
		handleSKU = ( syncCheckboxID ) ->

			if isVariable()
				$( '#_sku' ).off 'change keypress keyup'
				hideError( 'missing_sku', not hasMultipleAttributes() )

				skus = $( 'input[id^="variable_sku"]' )

				skus.on 'change keypress keyup', ( e ) ->
					if not hasVariableSKUs( skus ) or not hasUniqueSKUs( skus )
						showError( 'missing_variation_sku' )
					else
						hideError( 'missing_variation_sku', not hasMultipleAttributes() )
					$( syncCheckboxID ).triggerHandler 'change'
				.triggerHandler 'change'

			else
				$( 'input[id^="variable_sku"]' ).off 'change keypress keyup'
				hideError( 'missing_variation_sku', not hasMultipleAttributes() )

				$( '#_sku' ).on 'change keypress keyup', ( e ) ->
					if '' is $( this ).val().trim()
						showError( 'missing_sku' )
					else
						hideError( 'missing_sku', not hasMultipleAttributes() )
					$( syncCheckboxID ).trigger 'change'
				.trigger 'change'


		###*
		# Handle attributes.
		#
		# Disables the Sync with Square checkbox and toggles an inline notice when more than one attribute is set on the product.
		#
		# @since 2.0.0
		###
		handleAttributes = ( syncCheckboxID ) ->

			$( '#variable_product_options' ).on 'reload', ( e ) ->

				if hasMultipleAttributes()
					showError( 'multiple_attributes' )
				else
					hideError( 'multiple_attributes', if isVariable() then hasVariableSKUs else hasSKU() )
				$( syncCheckboxID ).trigger( 'change' )

			.trigger( 'reload' )


		###*
		# Triggers an update to the sync checkbox, checking for relevant errors.
		#
		# @since 2.2.3
		###
		triggerUpdate = ->
			handleSKU( syncCheckboxID )
			# handleSKU misses cases where product is variable with no variations
			if isVariable() and not $( 'input[id^="variable_sku"]' ).length
				showError( 'missing_variation_sku' )


		# fire once on page load
		handleAttributes( syncCheckboxID )


		###*
		# Handle stock management.
 		#
		# If product is managed by Square, handle stock fields according to chosen SoR.
		###
		$stockFields = $( '.stock_fields' )
		$stockInput  = $stockFields.find( '#_stock' )
		$stockStatus = $( '.stock_status_field' )
		$manageField = $( '._manage_stock_field' )
		$manageInput = $manageField.find( '#_manage_stock' )
		$manageDesc  = $manageField.find( '.description' )
		# keep note of the original manage stock checkbox description, if we need to restore it later
		manageDescOriginal  = $manageDesc.text()
		# keep track of the original manage stock checkbox status, if we need to restore it later
		manageStockOriginal = $( '#_manage_stock' ).is( ':checked' )

		$( syncCheckboxID ).on 'change', ( e ) ->

			# only handle stock fields if inventory sync is enabled
			if not wc_square_admin_products.is_inventory_sync_enabled
				return

			variableProduct = $.inArray( $( '#product-type' ).val(), wc_square_admin_products.variable_product_types ) isnt -1

			if $( this ).is( ':checked' ) and $( '#_square_item_variation_id' ).length > 0

				useSquare = true

				$manageDesc.html( '<a href="' + wc_square_admin_products.settings_url + '">' + wc_square_admin_products.i18n.synced_with_square + '</a>' )
				$manageInput.prop( 'disabled', true ).prop( 'checked', not variableProduct )
				$stockFields.hide()
				$stockStatus.hide()
				$stockInput.prop( 'readonly', true )

				if not variableProduct
					$stockFields.show()

				# WooCommerce SoR - note: for variable products, the stock can be fetched for individual variations
				if wc_square_admin_products.is_woocommerce_sor and not variableProduct

					# add inline note with a toggle to fetch stock from Square manually via AJAX (sanity check to avoid appending multiple times)
					if $( 'p._stock_field span.description' ).length is 0
						$stockInput.after( '<span class="description" style="display:block;clear:both;"><a href="#" id="fetch-stock-with-square">' + wc_square_admin_products.i18n.fetch_stock_with_square + '</a><div class="spinner" style="float:none;"></div></span>' )

					$( '#fetch-stock-with-square' ).on 'click', ( e ) ->
						e.preventDefault()

						$spinner = $( 'p._stock_field span.description .spinner' )
						$spinner.css( 'visibility', 'visible' )

						data =
							action     : 'wc_square_fetch_product_stock_with_square'
							security   : wc_square_admin_products.fetch_product_stock_with_square_nonce
							product_id : $( '#post_ID' ).val()

						$.post wc_square_admin_products.ajax_url, data, ( response ) ->

							if response and response.success

								quantity = response.data

								$stockInput.val( quantity )
								$stockFields.find( 'input[name=_original_stock]' ).val( quantity )
								$stockInput.prop( 'readonly', false )
								$( 'p._stock_field span.description' ).remove()

							else

								if response.data
									$( '.inventory-fetch-error' ).remove()
									$spinner.after( '<span class="inventory-fetch-error" style="display:inline-block;color:red;">' + response.data + '</span>' )

								$spinner.css( 'visibility', 'hidden' )
								console.log( response )

				# Square SoR
				else if wc_square_admin_products.is_square_sor

					# add inline note explaining stock is managed by Square (sanity check to avoid appending multiple times)
					if $( 'p._stock_field span.description' ).length is 0
						$stockInput.after( '<span class="description" style="display:block;clear:both;">' + wc_square_admin_products.i18n.managed_by_square + '</span>' )


			# restore defaults when user chooses to disable Sync with Square checkbox
			else

				useSquare = false

				# remove any inline note to WooCommerce core stock fields that may have been added when Synced with Square is enabled
				$( 'p._stock_field span.description' ).remove()

				$stockInput.prop( 'readonly', false )
				$manageDesc.html( manageDescOriginal )
				$manageInput.prop( 'disabled', false ).prop( 'checked', manageStockOriginal )

				if manageStockOriginal
					$stockFields.show()
					$stockStatus.hide()
				else
					$stockStatus.show()
					$stockFields.hide()


			# handle variations data separately (HTML differs from parent UI!)
			$( '.woocommerce_variation' ).each ->

				# fetch relevant variables for each variation
				variationID           = $( this ).find( 'h3 > a' ).attr( 'rel' )
				$variationManageInput = $( this ).find( '#wc_square_variation_manage_stock' )
				$variationManageField = $variationManageInput.parent()
				$variationStockInput  = $( this ).find( '.wc_input_stock' )
				$variationStockField  = $variationStockInput.parent()

				# Square manages variations stock
				if useSquare

					# disable stock management inputs
					$variationManageInput.prop( 'disabled', true ).prop( 'checked', true )
					$variationStockInput.prop( 'readonly', true )
					$( '#wc_square_variation_manage_stock' ).prop( 'disabled', false )

					# add a note that the variation stock is managed by square, but check if it wasn't added already to avoid duplicates
					if 0 is $variationManageField.find( '.description' ).length
						$variationManageInput.after( '<span class="description">(' + wc_square_admin_products.i18n.managed_by_square + ')</span>' )

					if wc_square_admin_products.is_woocommerce_sor

						fetchVariationStockActionID = 'fetch-stock-with-square-' + variationID

						# add inline note with a toggle to fetch stock from Square manually via AJAX (sanity check to avoid appending multiple times)
						if 0 is $variationStockField.find( 'span.description' ).length
							$variationStockInput.after( '<span class="description" style="display:block;clear:both;"><a href="#" id="' + fetchVariationStockActionID + '">' + wc_square_admin_products.i18n.fetch_stock_with_square + '</a><div class="spinner" style="float:none;"></div></span>' )

						# listen for requests to update stock with Square for the individual variation
						$( '#' + fetchVariationStockActionID ).on 'click', ( e ) ->
							e.preventDefault()

							$spinner = $( this ).next( '.spinner' )
							$spinner.css( 'visibility', 'visible' )

							data =
								action     : 'wc_square_fetch_product_stock_with_square'
								security   : wc_square_admin_products.fetch_product_stock_with_square_nonce
								product_id : variationID

							$.post wc_square_admin_products.ajax_url, data, ( response ) ->

								if response and response.success

									quantity = response.data

									$variationStockInput.val( quantity )
									$variationStockField.parent().find( 'input[name^="variable_original_stock"]' ).val( quantity )
									$variationStockInput.prop( 'readonly', false )
									$variationStockField.find( '.description' ).remove()

								else

									if response.data
										$( '.inventory-fetch-error' ).remove()
										$spinner.after( '<span class="inventory-fetch-error" style="display:inline-block;color:red;">' + response.data + '</span>' )

									$spinner.css( 'visibility', 'hidden' )
									console.log( response )


				# restore WooCommerce stock when user chooses to disable Sync with Square checkbox
				else
					$variationStockInput.prop( 'readonly', false )
					$variationManageInput.prop( 'disabled', false )
					$variationManageInput.next( '.description' ).remove()
					$( this ).find( '#wc_square_variation_manage_stock' ).prop( 'disabled', true )

		# initial page load handling
		.trigger 'change'


		# trigger an update if the product type changes
		$( '#product-type' ).on 'change', ( e ) ->
			triggerUpdate()

		# trigger an update for variable products when variations are loaded, added, or removed.
		$( '#woocommerce-product-data' ).on 'woocommerce_variations_loaded woocommerce_variations_added woocommerce_variations_removed', ( e ) ->
			triggerUpdate()
