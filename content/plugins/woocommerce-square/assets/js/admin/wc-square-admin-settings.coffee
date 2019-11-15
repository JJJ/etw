"use strict"

###*
# WooCommerce Square scripts for admin product pages.
#
# @since 2.0.0
###
jQuery( document ).ready ( $ ) ->

	typenow = window.typenow ? ''
	pagenow = window.pagenow ? ''


	# bail if not on the admin settings page
	if ( 'woocommerce_page_wc-settings' isnt pagenow )
		return


	# toggle the "hide products" setting depending on the SOR
	$( '#wc_square_system_of_record' ).change( ->

		system_of_record = $( this ).val()

		$inventory_sync     = $( '#wc_square_enable_inventory_sync' )
		$inventory_sync_row = $inventory_sync.closest( 'tr' )

		# toggle the "Sync inventory" setting depending on the SOR
		if system_of_record in [ 'square', 'woocommerce' ]

			$inventory_sync.next( 'span' ).html( wc_square_admin_settings.i18n.sync_inventory_label[system_of_record] )

			$inventory_sync_row.find( '.description' ).html( wc_square_admin_settings.i18n.sync_inventory_description[system_of_record] )

			$inventory_sync_row.show()
		else
			$inventory_sync_row.hide()

		# toggle the "Hide missing products" setting depending on the SOR
		if 'square' is system_of_record
			$( '#wc_square_hide_missing_products' ).closest( 'tr' ).show()
		else
			$( '#wc_square_hide_missing_products' ).closest( 'tr' ).hide()

	).change()

	$( '.js-import-square-products' ).on 'click', ( e ) ->
		e.preventDefault()

		new $.WCBackboneModal.View
			target : 'wc-square-import-products'

		$( '#btn-close' ).on 'click', ( e ) ->
			e.preventDefault()
			$( 'button.modal-close' ).trigger( 'click' )

		$( '#btn-ok' ).on 'click', ( e ) ->
			e.preventDefault()
			$( this ).unbind()

			data =
				action   : 'wc_square_import_products_from_square'
				dispatch : wc_square_admin_settings.sync_in_background
				security : wc_square_admin_settings.import_products_from_square

			$.post wc_square_admin_settings.ajax_url, data, ( response ) ->

				message = if response.data then response.data else null

				if response.success and message
					alert( message )
				else if not response.success and message
					alert( message )

				location.reload()

	# initiate a manual sync
	$( '#wc-square-sync' ).on 'click', ( e ) ->
		e.preventDefault()

		# open a modal dialog
		new $.WCBackboneModal.View
			target : 'wc-square-sync'

		# enable cancel sync button
		$( '#btn-close' ).on 'click', ( e ) ->
			e.preventDefault()
			$( 'button.modal-close' ).trigger( 'click' )

		# upon confirming, start a background process to sync products with Square
		$( '#btn-ok' ).on 'click', ( e ) ->
			e.preventDefault()
			$( this ).unbind()

			$( 'table.sync' ).block
				message    : null
				overlayCSS :
					'opacity' : '0.2'
			$( 'table.records' ).block
				message    : null
				overlayCSS :
					'opacity' : '0.2'
			$( '#wc-square_clear-sync-records' ).prop( 'disabled', true )

			data =
				action   : 'wc_square_sync_products_with_square'
				dispatch : wc_square_admin_settings.sync_in_background
				security : wc_square_admin_settings.sync_products_with_square

			$.post wc_square_admin_settings.ajax_url, data, ( response ) ->
				if response and response.success
					location.reload()
				else
					$( '#wc-square_clear-sync-records' ).prop( 'disabled', false )
					$( 'table.sync' ).unblock()
					$( 'table.records' ).unblock()
					console.log( response )


	# sync record handling
	noRecordsFoundRow = '<tr><td colspan="4"><em>' + wc_square_admin_settings.i18n.no_records_found + '</em></td></tr>'

	# clear sync records history
	$( '#wc-square_clear-sync-records' ).on 'click', ( e ) ->
		e.preventDefault()

		$( 'table.records' ).block
			message    : null
			overlayCSS :
				'opacity' : '0.2'

		data =
			action   : 'wc_square_handle_sync_records'
			id       : 'all'
			handle   : 'delete'
			security : wc_square_admin_settings.handle_sync_with_square_records

		$.post wc_square_admin_settings.ajax_url, data, ( response ) ->
			if response and response.success
				$( 'table.records tbody' ).html( noRecordsFoundRow )
				$( '#wc-square_clear-sync-records').prop( 'disabled', true )
			else
				if ( response.data )
					alert( response.data )
				console.log( response )

			$( 'table.records' ).unblock()

	# individual sync records actions
	$( '.records .actions button.action' ).on 'click', ( e ) ->
		e.preventDefault()

		$( 'table.records' ).block
			message    : null
			overlayCSS :
				'opacity' : '0.2'

		recordId = $( this ).data( 'id' )
		action   = $( this ).data( 'action' )
		data     =
			action     : 'wc_square_handle_sync_records'
			id         : recordId
			handle     : action
			security   : wc_square_admin_settings.handle_sync_with_square_records

		$.post wc_square_admin_settings.ajax_url, data, ( response ) ->
			if response and response.success

				rowId = '#record-' + recordId

				if 'delete' is action

					$( rowId ).remove()

					if not $( 'table.records tbody tr' ).length
						$( 'table.records tbody' ).html( noRecordsFoundRow )
						$( '#wc-square_clear-sync-records').prop( 'disabled', true )

				else if 'resolve' is action or 'unsync' is action

					$( rowId + ' .type' ).html( '<mark class="resolved"><span>' + wc_square_admin_settings.i18n.resolved  + '</span></mark>' )
					$( rowId + ' .actions' ).html( '&mdash;' )

			else
				if response and response.data
					alert( response.data )
				console.log( {
					record   : recordId
					action   : action
					response : response
				} )

			$( 'table.records' ).unblock()


	###*
	# Returns a job sync status.
	#
	# @since 2.0.0
	#
	# @param {string} job_id
	###
	getSyncStatus = ( job_id ) ->

		$progress = $( 'span.progress' )

		if not $progress or $progress.length is 0
			# note: the space below in the inserted string is intended
			$( 'p.sync-result' ).append( ' <span class="progress" style="display:block"></span>' )
			$progress = $( 'span.progress' )

		data =
			action :   'wc_square_get_sync_with_square_status'
			security : wc_square_admin_settings.get_sync_with_square_status_nonce
			job_id :   job_id

		$.post wc_square_admin_settings.ajax_url, data, ( response ) ->
			if response and response.data
				if response.success and response.data.id

					# start the progress spinner
					$( 'table.sync .spinner' ).css( 'visibility', 'visible' )
					# disable interacting with records as more could be added during a sync process
					$( '#wc-square_clear-sync-records' ).prop( 'disabled', true )
					$( 'table.records .actions button' ).prop( 'disabled', true )

					# continue if the job is in progression
					if response.data.status not in [ 'completed', 'failed' ]

						progress = ' '

						# update progress info in table cell
						if 'product_import' is response.data.action
							progress += wc_square_admin_settings.i18n.skipped + ': ' + parseInt( response.data.skipped_products_count, 10 ) + '<br/>'
							progress += wc_square_admin_settings.i18n.imported + ': ' + parseInt( response.data.processed_products_count, 10 )
						else if response.data.percentage
							progress += parseInt( response.data.percentage, 10 ) + '%'

						$progress.html( progress )

						# recursion update loop until we're 'completed' (add a long timeout to avoid missing callback return output)
						return setTimeout( ->
							getSyncStatus( response.data.id )
						, 30 * 1000 )

					# reload page, display updated sync dates and any sync records messages
					else
						location.reload()

				else # unlikely job processing exception
					$( '#wc-square_clear-sync-records' ).prop( 'disabled', false )
					$( 'table.records .actions button' ).prop( 'disabled', false )
					$( 'table.sync .spinner' ).css( 'visibility', 'hidden' )
					console.log( response )

	# run once on page load
	if wc_square_admin_settings.existing_sync_job_id
		getSyncStatus( wc_square_admin_settings.existing_sync_job_id )
