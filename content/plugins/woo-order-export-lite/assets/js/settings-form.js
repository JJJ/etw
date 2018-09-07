function makeJsonVar( obj ) {
	return encodeURIComponent( makeJson( obj ) ) ;
}
function makeJson( obj ) {
	return JSON.stringify( obj.serializeJSON() )  ;
}

jQuery( document ).ready( function( $ ) {

        $('#d-schedule-4 .datetimes-date').datepicker({
            dateFormat: 'yy-mm-dd',
            constrainInput: false,
            minDate: 0,
	});

	$( '#d-schedule-3 .btn-add' ).click( function(e) {
		var times = $( 'input[name="settings[schedule][times]"]' ).val();
		var weekday = $( '#d-schedule-3 .wc_oe-select-weekday' ).val();
		var time = $( '#d-schedule-3 .wc_oe-select-time' ).val();

		if( times.indexOf( weekday + ' ' + time) != -1 ) {
			return;
		}

		var data = [];
		if( times != '' ) {
			data = times.split( ',' ).map( function( time ) {
				var arr = time.split( ' ' );
				return { weekday: arr[ 0 ], time: arr[ 1 ] };
			} );
		}

		data.push( { weekday: weekday, time: time } );

		var weekdays = {
			'Sun': 1,
			'Mon': 2,
			'Tue': 3,
			'Wed': 4,
			'Thu': 5,
			'Fri': 6,
			'Sat': 7,
		};

		data.sort( function( a, b ) {
			if( weekdays[ a.weekday ] == weekdays[ b.weekday ] ) {
				return new Date( '1970/01/01 ' + a.time ) - new Date( '1970/01/01 ' + b.time );
			} else {
				return weekdays[ a.weekday ] - weekdays[ b.weekday ];
			}
		} );

		var html = data.map( function( elem ) {
			var weekday = settings_form.day_names[elem.weekday] ;
			return '<div class="time"><span class="btn-delete">×</span>'
			       + weekday + ' ' + elem.time + '</div>';
		} ).join( '' );

		times = data.map( function( elem ) {
			return elem.weekday + ' ' + elem.time;
		} ).join();

		$( '#d-schedule-3 .input-times' ).html( html );
		$( '#d-schedule-3 .btn-delete' ).click( shedule3_time_delete );

		$( 'input[name="settings[schedule][times]"]' ).val( times );
	} );

        $( '#d-schedule-4 .btn-add' ).click( function(e) {

                var times = $( 'input[name="settings[schedule][date_times]"]' ).val();
		var date = $( '#d-schedule-4 .datetimes-date' ).val();
		var time = $( '#d-schedule-4 .wc_oe-select-time' ).val();

		if( times.indexOf( date + ' ' + time) !== -1 ) {
			return;
		}

		var data = [];
		if( times !== '' ) {
                    data = times.split( ',' ).map( function( time ) {
                            var arr = time.split( ' ' );
                            return { date: arr[ 0 ], time: arr[ 1 ] };
                    } );
		}

		data.push( { date: date, time: time } );

		data.sort( function( a, b ) {
                    return new Date( a.date + ' ' + a.time ) - new Date( b.date + ' ' + b.time );
		} );

		var html = data.map( function( elem ) {
			return '<div class="time"><span class="btn-delete">×</span>'
			       + elem.date + ' ' + elem.time + '</div>';
		} ).join( '' );

		times = data.map( function( elem ) {
			return elem.date + ' ' + elem.time;
		} ).join();

		$( '#d-schedule-4 .input-date-times' ).html( html );
		$( '#d-schedule-4 .btn-delete' ).click( shedule4_time_delete );

		$( 'input[name="settings[schedule][date_times]"]' ).val( times );
	} );

	$( '#d-schedule-3 .input-times' ).ready( function() {
		var times = $( 'input[name="settings[schedule][times]"]' ).val();
		if( !times || times == '' ) {
			return;
		}
		var data = times.split( ',' );
		var html = data.map( function( elem ) {
			var x = elem.split(' ');
			var weekday = settings_form.day_names[x[0]] + ' ' + x[1];
			return '<div class="time"><span class="btn-delete">×</span>' + weekday + '</div>';
		} ).join( '' );
		$( '#d-schedule-3 .input-times' ).html( html );
		$( '#d-schedule-3 .btn-delete' ).click( shedule3_time_delete );
	} );

	$( '#d-schedule-4 .input-date-times' ).ready( function() {

                var times = $( 'input[name="settings[schedule][date_times]"]' ).val();

                if( !times || times == '' ) {
			return;
		}

                var data = times.split( ',' );

                var html = data.map( function( elem ) {
                    return '<div class="time"><span class="btn-delete">×</span>' + elem + '</div>';
		} ).join( '' );

		$( '#d-schedule-4 .input-date-times' ).html( html );
		$( '#d-schedule-4 .btn-delete' ).click( shedule4_time_delete );
	} );

	function shedule3_time_delete( e ) {
		var index = $( this ).parent().index();
		var data = $( 'input[name="settings[schedule][times]"]' ).val().split( ',' );
		data.splice( index, 1 );
		$( 'input[name="settings[schedule][times]"]' ).val( data.join() );
		$( this ).parent().remove();
	}

	function shedule4_time_delete( e ) {
		var index = $( this ).parent().index();
		var data = $( 'input[name="settings[schedule][date_times]"]' ).val().split( ',' );
		data.splice( index, 1 );
		$( 'input[name="settings[schedule][date_times]"]' ).val( data.join() );
		$( this ).parent().remove();
	}


	$( '#schedule-1,#schedule-2,#schedule-3,#schedule-4' ).change( function() {
		if ( $( '#schedule-1' ).is( ':checked' ) && $( '#schedule-1' ).val() == 'schedule-1' ) {
			$( '#d-schedule-2 input:not(input[type=radio])' ).attr( 'disabled', true )
			$( '#d-schedule-2 select' ).attr( 'disabled', true )
			$( '#d-schedule-1 input:not(input[type=radio])' ).attr( 'disabled', false )
			$( '#d-schedule-1 select' ).attr( 'disabled', false )
			$( '#d-schedule-3 .block' ).addClass( 'disabled' );
                        $( '#d-schedule-4 .block' ).addClass( 'disabled' );
		} else if( $( '#schedule-2' ).is( ':checked' ) && $( '#schedule-2' ).val() == 'schedule-2' ) {
			$( '#d-schedule-1 input:not(input[type=radio])' ).attr( 'disabled', true )
			$( '#d-schedule-1 select' ).attr( 'disabled', true )
			$( '#d-schedule-2 select' ).attr( 'disabled', false )
			$( '#d-schedule-2 input:not(input[type=radio]) ' ).attr( 'disabled', false )
			$( '#d-schedule-3 .block' ).addClass( 'disabled' );
                        $( '#d-schedule-4 .block' ).addClass( 'disabled' );
		} else if( $( '#schedule-3' ).is( ':checked' ) && $( '#schedule-3' ).val() == 'schedule-3' ) {
			$( '#d-schedule-1 input:not(input[type=radio])' ).attr( 'disabled', true )
			$( '#d-schedule-1 select' ).attr( 'disabled', true )

			$( '#d-schedule-2 input:not(input[type=radio])' ).attr( 'disabled', true )
			$( '#d-schedule-2 select' ).attr( 'disabled', true )

			$( '#d-schedule-3 .block' ).removeClass( 'disabled' );

                        $( '#d-schedule-4 .block' ).addClass( 'disabled' );
		} else if( $( '#schedule-4' ).is( ':checked' ) && $( '#schedule-4' ).val() == 'schedule-4' ) {

                        $( '#d-schedule-1 input:not(input[type=radio])' ).attr( 'disabled', true )
			$( '#d-schedule-1 select' ).attr( 'disabled', true )

			$( '#d-schedule-2 input:not(input[type=radio])' ).attr( 'disabled', true )
			$( '#d-schedule-2 select' ).attr( 'disabled', true )

                        $( '#d-schedule-3 .block' ).addClass( 'disabled' );

			$( '#d-schedule-4 .block' ).removeClass( 'disabled' );
		}
	} );
	$( '#schedule-1' ).change()
	$( '.wc_oe-select-interval' ).change( function() {
		var interval = $( this ).val()
		if ( interval == 'custom' ) {
			$( '#custom_interval' ).show()
		} else {
			$( '#custom_interval' ).hide()
		}
	} );
	$( '.wc_oe-select-interval' ).change()

	$( '.output_destination' ).click( function() {
		var input = $( this ).find( 'input' );
		var target = input.val();
		$( '.set-destination:not(#' + target + ')' ).hide();
		$( '.my-icon-triangle' ).removeClass( 'ui-icon-triangle-1-n' );
		$( '.my-icon-triangle' ).addClass( 'ui-icon-triangle-1-s' );
		if ( !jQuery( '#' + target ).is( ':hidden' ) ) {
			jQuery( '#' + target ).hide();
		}
		else {
			if ( jQuery( '#' + target ).is( ':hidden' ) ) {
				jQuery( '#' + target ).show();
				$( '#test_reply_div' ).hide();
				$( input ).next().removeClass( 'ui-icon-triangle-1-s' );
				$( input ).next().addClass( 'ui-icon-triangle-1-n' );
			}
		}
	} );

	var is_unchecked_shown = true;
	$('#hide_unchecked').on('click', function(e) {
		e.preventDefault();
		is_unchecked_shown = !is_unchecked_shown;
		$("#order_fields li input:checkbox:not(:checked)").closest('.mapping_row').toggle(is_unchecked_shown);
		$('#hide_unchecked div').toggle();
	});

	function my_hide( item ) {
		if ( $( item ).is( ':hidden' ) ) {
			$( item ).show();
			return false;
		}
		else {
			$( item ).hide();
			return true;
		}
	}

	$( '.my-hide-parent' ).click( function() {
		my_hide( $( this ).parent() );
	} );

	$( '.my-hide-next' ).click( function() {
		var f = my_hide( $( this ).next() );
		if ( f ) {
			$( this ).find( 'span' ).removeClass( 'ui-icon-triangle-1-n' );
			$( this ).find( 'span' ).addClass( 'ui-icon-triangle-1-s' );
		}
		else {
			$( this ).find( 'span' ).removeClass( 'ui-icon-triangle-1-s' );
			$( this ).find( 'span' ).addClass( 'ui-icon-triangle-1-n' );
		}
		return false;
	} );


	$( '.wc_oe_test' ).click( function() {
		var test = $( this ).attr( 'data-test' );
		var data = 'json=' + makeJsonVar( $( '#export_job_settings' ) )
		data = data + "&action=order_exporter&method=test_destination&mode=" + mode + "&id=" + job_id + "&destination=" + test;
		$( '#test_reply_div' ).hide();
		$.post( ajaxurl, data, function( data ) {
			$( '#test_reply' ).val( data );
			$( '#test_reply_div' ).show();
		} )
	} )

} )

function remove_custom_field( item ) {
	jQuery( item ).parent().parent().remove();
	return false;
}

function create_fields( format , format_changed) {
	jQuery( '#export_job_settings' ).prepend( jQuery( "#fields_control_products" ) );
	jQuery( '#export_job_settings' ).prepend( jQuery( "#fields_control_coupons" ) );
	jQuery( "#order_fields" ).html();
	jQuery( "#modal_content" ).html( "" );

	var html = '';
	jQuery.each( window['order_fields'], function( index, value ) {
		var checked = ( value.checked == 1 ) ? 'checked' : '';
		var colname = value.colname;

		colname     = escapeStr(colname);
		value.label = escapeStr(value.label);
		index       = escapeStr(index);
		value.value = escapeStr(value.value);

//                         console.log(index);
//                         console.log(value);

		if(format_changed) {
			if( is_flat_format( format ) )
				colname = value.label;
			else if ( is_xml_format( format ) )
				colname = to_xml_tags( index );
			else
				colname = index;;
		}


		if ( index == 'products' || index == 'coupons' ) {
			var sel_rows = ( value.repeat == 'rows' ) ? 'checked' : '';
			var sel_cols = ( value.repeat == 'columns' ) ? 'checked' : '';
			var max_cols = ( typeof(value.max_cols) !== 'undefined' ) ? value.max_cols : "10";
			var modal = '<div id="modal-manage-' + index + '" style="display:none;"><p>';
			modal += create_modal_fields( format, index, format_changed);
			modal += '</p></div>';
			jQuery( "#modal_content" ).append( modal );
			var row = '<li class="mapping_row segment_' + value.segment + '">\
                                                        <div class="mapping_col_1">\
                                                                <input type=hidden name="orders[segment][' + index + ']"  value="' + value.segment + '">\
                                                                <input type=hidden name="orders[label][' + index + ']"  value="' + value.label + '">\
                                                                <input type=hidden name="orders[exported][' + index + ']"  value="0">\
                                                                <input type=checkbox name="orders[exported][' + index + ']"  ' + checked + ' value="1">\
                                                        </div>\
                                                        <div class="mapping_col_2">' + value.label + '</div>\
                                                        <div class="mapping_col_3">';
			if ( is_flat_format( format ) ) {

				var popup_options = localize_settings_form.js_tpl_popup;
				popup_options = popup_options.replace('%s', '<input type=radio name="orders[repeat][' + index + ']" value="columns" ' + sel_cols + ' >')
				popup_options = popup_options.replace('%s', '<input type=text size=2 name="orders[max_cols][' + index + ']" value="'+max_cols+'">')
				popup_options = popup_options.replace('%s', '<input type=radio name="orders[repeat][' + index + ']" value="rows" ' + sel_rows + ' >')
				row += 	popup_options;
			}
			row += '<input class="mapping_fieldname" type=input name="orders[colname][' + index + ']" value="' + colname + '">\
                                                        <input type="button" class="button-primary" id="btn_modal_manage_' + index + '" value="' + localize_settings_form.set_up_fields_to_export + '" /><a href="#TB_inline?width=600&height=550&inlineId=modal-manage-' + index + '" class="thickbox " id="link_modal_manage_' + index + '"> </a></div>\
                                                </li>\
                        ';
		}
		else {
			var value_part = ''
			var label_part = '';
			if ( index.indexOf( 'custom_field' ) >= 0 ) {
				value_part = '<div class="mapping_col_3"><input class="mapping_fieldname" type=input name="orders[value][' + index + ']" value="' + value.value + '"></div>';
				label_part = '<a href="#" onclick="return remove_custom_field(this);" style="float: right;"><span class="ui-icon ui-icon-trash"></span></a>';
			}
			else if ( index.charAt( 0 ) == '_'  || !value.default) {
				label_part = '<a href="#" onclick="return remove_custom_field(this);" style="float: right;"><span class="ui-icon ui-icon-trash"></span></a>';
			}

			var row = '<li class="mapping_row segment_' + value.segment + '">\
                                                        <div class="mapping_col_1">\
                                                                <input type=hidden name="orders[segment][' + index + ']"  value="' + value.segment + '">\
                                                                <input type=hidden name="orders[label][' + index + ']"  value="' + value.label + '">\
                                                                <input type=hidden name="orders[exported][' + index + ']"  value="0">\
                                                                <input type=checkbox name="orders[exported][' + index + ']"  ' + checked + ' value="1">\
                                                        </div>\
                                                        <div class="mapping_col_2">' + value.label + label_part + '</div>\
                                                        <div class="mapping_col_3"><input class="mapping_fieldname" type=input name="orders[colname][' + index + ']" value="' + colname + '"></div> ' + value_part + '\
                                                </li>\
                        ';
		}
		html += row;
	} );

	jQuery( "#order_fields" ).html( html );
	jQuery( '#modal-manage-products' ).prepend( jQuery( "#fields_control_products" ) );
	jQuery( '#modal-manage-coupons' ).prepend( jQuery( "#fields_control_coupons" ) );
	jQuery( "#fields_control_products" ).css( 'display', 'inline-block' );
	jQuery( "#fields_control_coupons" ).css( 'display', 'inline-block' );
	add_bind_for_custom_fields( 'products', output_format, jQuery( "#sort_products" ) );
	add_bind_for_custom_fields( 'coupons', output_format, jQuery( "#sort_coupons" ) );

}



function create_modal_fields( format, index_p, format_changed ) {
	//console.log( 'order_' + index_p + '_fields', window['order_' + index_p + '_fields'] );

	var modal = "<div id='sort_" + index_p + "'>";
	jQuery.each( window['order_' + index_p + '_fields'], function( index, value ) {
		var checked = ( value.checked == 1 ) ? 'checked' : '';
		var colname = value.colname;

//                         console.log(index);
//                         console.log(value);


		colname     = escapeStr(colname);
		value.label = escapeStr(value.label);
		index       = escapeStr(index);
		value.value = escapeStr(value.value);

		if(format_changed) {
			if( is_flat_format( format ) )
				colname = value.label;
			else if ( is_xml_format( format ) )
				colname = to_xml_tags( index );
			else
				colname = index;;
		}

		var value_part = ''
		var label_part = '';
		if ( index.indexOf( 'custom_field' ) >= 0 ) {
			value_part = '<div class="mapping_col_3"><input class="mapping_fieldname" type=input name="' + index_p + '[value][' + index + ']" value="' + value.value + '"></div>';
			label_part = '<a href="#" onclick="return remove_custom_field(this);" style="float: right;"><span class="ui-icon ui-icon-trash"></span></a>';
		}
		else if ( index.charAt( 0 ) == '_'  || index.substr( 0,3 ) == 'pa_' || !value.default) {
			label_part = '<a href="#" onclick="return remove_custom_field(this);" style="float: right;"><span class="ui-icon ui-icon-trash"></span></a>';
		}

		var row = '<li class="mapping_row segment_modal_' + index + '">\
                                                        <div class="mapping_col_1">\
                                                                <input type=hidden name="' + index_p + '[label][' + index + ']"  value="' + value.label + '">\
                                                                <input type=hidden name="' + index_p + '[exported][' + index + ']"  value="0">\
                                                                <input type=checkbox name="' + index_p + '[exported][' + index + ']"  ' + checked + ' value="1">\
                                                        </div>\
                                                        <div class="mapping_col_2">' + value.label + label_part + '</div>\
                                                        <div class="mapping_col_3"><input class="mapping_fieldname" type=input name="' + index_p + '[colname][' + index + ']" value="' + colname + '"></div>' + value_part + '\
                                                </li>\
                        ';
		modal += row;
	} );
	modal += "</div>";
	return modal;
}

//for XML labels
function to_xml_tags( str ) {
	var arr = str.split( /_/ );
	for ( var i = 0, l = arr.length; i < l; i++ ) {
		arr[i] = arr[i].substr( 0, 1 ).toUpperCase() + ( arr[i].length > 1 ? arr[i].substr( 1 ).toLowerCase() : "" );
	}
	return arr.join( "_" );
}


function change_filename_ext() {
	if ( jQuery( '#export_filename' ).size() ) {
		var filename = jQuery( '#export_filename input' ).val();
		var ext = output_format.toLowerCase();
		if( ext=='xls'  && !jQuery( '#format_xls_use_xls_format' ).prop('checked') ) //fix for XLSX
			ext = 'xlsx';

		var file = filename.replace( /^(.*)\..+$/, "$1." + ext );
		if( file.indexOf(".") == -1)  //no dots??
			file = file + "." + ext;
		jQuery( '#export_filename input' ).val( file );
		show_summary_report(output_format);
	}
}

function show_summary_report(ext) {
	if( is_flat_format(ext) ) {
		jQuery( '#summary_report_by_products' ).show();
	} else  {
		jQuery( '#summary_report_by_products' ).hide();
		jQuery( '#summary_setup_fields' ).hide();
		jQuery( '#summary_report_by_products_checkbox' ).prop('checked', false);
	}
}

function modal_buttons()
{
	jQuery('body').on('click', '#btn_modal_manage_products', function() {

		jQuery('input[name=custom_meta_products_mode]').change();
		jQuery('#link_modal_manage_products').click();

		return false;
	});

	jQuery('body').on('click', '#btn_modal_manage_coupons', function() {

		jQuery('#custom_meta_coupons_mode_all').attr('checked', 'checked');
		jQuery('#custom_meta_coupons_mode_all').change();
		jQuery('#custom_meta_coupons_mode_all').change();
		jQuery('#link_modal_manage_coupons').click();

		return false;
	});

}

jQuery( document ).ready( function( $ ) {

	try {
		select2_inits();
	}
	catch ( err ) {
		console.log( err.message );
		jQuery( '#select2_warning' ).show();
	}

	jQuery( "#settings_title" ).focus();

	bind_events();
	jQuery( '#taxonomies' ).change();
	jQuery( '#attributes' ).change();
	if ( jQuery( '#itemmeta option' ).length>0 )
		jQuery( '#itemmeta' ).change();
	jQuery( '#custom_fields' ).change();
	jQuery( '#product_custom_fields' ).change();
	jQuery( '#shipping_locations' ).change();
	jQuery( '#billing_locations' ).change();
	jQuery( '#item_names' ).change();
	jQuery( '#item_metadata' ).change();
//		jQuery( '#' + output_format + '_options' ).show();

	//jQuery('#fields').toggle(); //debug
	create_fields( output_format, false );
	$( '#test_reply_div' ).hide();
//		jQuery( '#' + output_format + '_options' ).hide();

	jQuery( "#sort_products" ).sortable()/*.disableSelection()*/;
	jQuery( "#sort_coupons" ).sortable()/*.disableSelection()*/;
	jQuery( "#order_fields" ).sortable({ scroll: true, scrollSensitivity: 100, scrollSpeed: 100 });/*.disableSelection()*/;


	modal_buttons();

	jQuery( '.date' ).datepicker( {
		dateFormat: 'yy-mm-dd',
		constrainInput: false
	} );

	jQuery( '#adjust-fields-btn' ).click( function() {
		jQuery( '#fields' ).toggle();
		jQuery( '#fields_control' ).toggle();
		return false;
	} );

	jQuery( '.field_section' ).click( function() {
		var section = jQuery( this ).val();
		var checked = jQuery( this ).is( ':checked' );

		jQuery( '.segment_' + section ).each( function( index ) {
			if ( checked ) {
				jQuery( this ).show();
				//jQuery(this).find('input:checkbox:first').attr('checked', true);
			}
			else {
				jQuery( this ).hide();
				jQuery( this ).find( 'input:checkbox:first' ).attr( 'checked', false );
			}
		} );
	} );

	jQuery( '.output_format' ).click( function() {
		var new_format = jQuery( this ).val();
		jQuery( '#my-format .my-icon-triangle' ).removeClass( 'ui-icon-triangle-1-n' );
		jQuery( '#my-format .my-icon-triangle' ).addClass( 'ui-icon-triangle-1-s' );

		if ( new_format != output_format ) {
			jQuery( this ).next().removeClass( 'ui-icon-triangle-1-s' );
			jQuery( this ).next().addClass( 'ui-icon-triangle-1-n' );
			jQuery( '#' + output_format + '_options' ).hide();
			jQuery( '#' + new_format + '_options' ).show();
			output_format = new_format;
			create_fields( output_format, true )
			jQuery( '#output_preview, #output_preview_csv' ).hide();
//				jQuery( '#fields' ).hide();
//				jQuery( '#fields_control' ).hide();
			change_filename_ext();
		}
		else {
			if ( !jQuery( '#' + new_format + '_options' ).is( ':hidden' ) ) {
				jQuery( '#' + new_format + '_options' ).hide();
			}
			else {
				if ( jQuery( '#' + new_format + '_options' ).is( ':hidden' ) ) {
					jQuery( '#' + new_format + '_options' ).show();
					jQuery( this ).next().removeClass( 'ui-icon-triangle-1-s' );
					jQuery( this ).next().addClass( 'ui-icon-triangle-1-n' );
				}
			}
		}

	} );

	$( '#date_format_block select' ).change( function() {
		var value = $( this ).val();
		if( value == 'custom' ) {
			$( '#custom_date_format_block' ).show();
		} else {
			$( '#custom_date_format_block' ).hide();
			$( 'input[name="settings[date_format]"]' ).val( value );
		}
	} );

	$( '#time_format_block select' ).change( function() {
		var value = $( this ).val();
		if( value == 'custom' ) {
			$( '#custom_time_format_block' ).show();
		} else {
			$( '#custom_time_format_block' ).hide();
			$( 'input[name="settings[time_format]"]' ).val( value );
		}
	} );

	$( 'input[type="checkbox"][name="settings[custom_php]"]' ).change( function() {
		$( 'textarea[name="settings[custom_php_code]"]' ).toggle( $( this ).is( ':checked' ) );
	} );

	$( '#order_fields input[type=checkbox]' ).change( function() {
		if ( $( '#order_fields input[type=checkbox]:not(:checked)' ).size() ) {
			$( 'input[name=orders_all]' ).attr( 'checked', false );
		}
		else {
			$( 'input[name=orders_all]' ).attr( 'checked', true );
		}
	} );

	$( 'input[name=orders_all]' ).change( function() {
		if ( $( 'input[name=orders_all]' ).is( ':checked' ) ) {
			$( '#order_fields input[type=checkbox]' ).attr( 'checked', true );
		}
		else {
			$( '#order_fields input[type=checkbox]' ).attr( 'checked', false );
		}
	} );

	if ( $( '#order_fields input[type=checkbox]' ).size() ) {
		$( '#order_fields input[type=checkbox]:first' ).change();
	}




	$( ".preview-btn" ).click( function() {
		preview(jQuery(this).attr('data-limit'));
		return false;
	} );

	$( '#progress_div .title-download' ).click( function() {
		$( '#progress_div .title-download' ).hide();
		$( '#progress_div .title-cancel' ).show();
		$( '#progressBar' ).show();
		jQuery( '#progress_div' ).hide();
		closeWaitingDialog();
	});

	function preview(size) {
		jQuery( '#output_preview, #output_preview_csv' ).hide();
		var data = 'json=' + makeJsonVar( $( '#export_job_settings' ) );
		var estimate_data = data + "&action=order_exporter&method=estimate&mode=" + mode + "&id=" + job_id;
		$.post( ajaxurl, estimate_data, function( response ) {
				if ( response.total !== undefined ) {
					jQuery( '#output_preview_total' ).find( 'span' ).html( response.total );
					jQuery( '#preview_actions' ).removeClass( 'hide' );
				}
			}, "json"
		);

		function showPreview( response ) {
			var id = 'output_preview';
			if ( is_flat_format( output_format ) )
				id = 'output_preview_csv';
			if ( is_object_format( output_format ) ) {
				jQuery( '#' + id ).text( response );
			}
			else {
				jQuery( '#' + id ).html( response );
			}
			jQuery( '#' + id ).show();
			window.scrollTo( 0, document.body.scrollHeight );
		}

		data = data + "&action=order_exporter&method=preview&limit="+size+"&mode=" + mode + "&id=" + job_id;
		$.post( ajaxurl, data, showPreview, "html" ).fail( function( xhr, textStatus, errorThrown ) {
			showPreview( xhr.responseText );
		});
	}
// EXPORT FUNCTIONS
	function get_data() {
		var data = new Array();
		data.push( { name: 'json', value: makeJson( $( '#export_job_settings' ))  } );
		data.push( { name: 'action', value: 'order_exporter' } );
		data.push( { name: 'mode', value: mode } );
		data.push( { name: 'id', value: job_id } );
		return data;
	}

	function progress( percent, $element ) {

		if ( percent == 0 ) {
			$element.find( 'div' ).html( percent + "%&nbsp;" ).animate( { width: 0 }, 0 );
			waitingDialog();
			jQuery( '#progress_div' ).show();
		}
		else {
			var progressBarWidth = percent * $element.width() / 100;
			$element.find( 'div' ).html( percent + "%&nbsp;" ).animate( { width: progressBarWidth }, 200 );

			if ( percent >= 100 ) {
				if(!is_iPad_or_iPhone()) {
					jQuery( '#progress_div' ).hide();
					closeWaitingDialog();
				}
			}
		}
	}

	function get_all( start, percent, method ) {
		if (window.cancelling) {
			return;
		}

		progress( parseInt( percent, 10 ), jQuery( '#progressBar' ) );

		if ( percent < 100 ) {
			data = get_data();
			data.push( { name: 'method', value: method } );
			data.push( { name: 'start', value: start } );
			data.push( { name: 'file_id', value: window.file_id } );

			jQuery.ajax( {
				type: "post",
				data: data,
				cache: false,
				url: ajaxurl,
				dataType: "json",
				error: function( xhr, status, error ) {
					alert( xhr.responseText );
					progress( 100, jQuery( '#progressBar' ) );
				},
				success: function( response ) {
					get_all( response.start, ( response.start / window.count ) * 100, method )
				}
			} );
		}
		else {
			data = get_data();
			data.push( { name: 'method', value: 'export_finish' } );
			data.push( { name: 'file_id', value: window.file_id } );
			jQuery.ajax( {
				type: "post",
				data: data,
				cache: false,
				url: ajaxurl,
				dataType: "json",
				error: function( xhr, status, error ) {
					alert( xhr.responseText );
				},
				success: function( response ) {
					var download_format = output_format;
					if( output_format=='XLS' && !jQuery( '#format_xls_use_xls_format' ).prop('checked') )
						download_format =  'XLSX';

					if(is_iPad_or_iPhone()) {
						$( '#progress_div .title-download a' ).attr( 'href', ajaxurl + (ajaxurl.indexOf('?') === -1? '?':'&')+'action=order_exporter&method=export_download&format=' + download_format + '&file_id=' + window.file_id );
						$( '#progress_div .title-download' ).show();
						$( '#progress_div .title-cancel' ).hide();
						$( '#progressBar' ).hide();
					} else {
						$( '#export_new_window_frame' ).attr( "src", ajaxurl + (ajaxurl.indexOf('?') === -1? '?':'&')+'action=order_exporter&method=export_download&format=' + download_format + '&file_id=' + window.file_id );
					}

					reset_date_filter_for_cron();
				}
			} );
		}
	}

	function is_iPad_or_iPhone() {
		return navigator.platform.match(/i(Phone|Pad)/i)
	}

	function waitingDialog() {
		jQuery( "#background" ).addClass( "loading" );
		jQuery( '#wpbody-content' ).keydown(function(event) {
			if ( event.keyCode == 27 ) {
				if (!window.cancelling) {
					event.preventDefault();
					window.cancelling = true;

					jQuery.ajax( {
						type: "post",
						data: {
							action: 'order_exporter',
							method: 'cancel_export',
							file_id: window.file_id,
						},
						cache: false,
						url: ajaxurl,
						dataType: "json",
						error: function( xhr, status, error ) {
							alert( xhr.responseText );
							progress( 100, jQuery( '#progressBar' ) );
						},
						success: function( response ) {
							progress( 100, jQuery( '#progressBar' ) );
						}
					} );

					window.count = 0;
					window.file_id = '';
					jQuery( '#wpbody-content' ).off('keydown');
				}
				return false;
			}
		});
	}
	function closeWaitingDialog() {
		jQuery( "#background" ).removeClass( "loading" );
	}

	function openFilter(object_id, verify_checkboxes) {
		verify_checkboxes = verify_checkboxes || 0;
		var f = false;
		$( '#'+object_id+' ul' ).each( function( index ) {
			if ( $( this ).find( 'li:not(:first)' ).size() ) {
				f = true;
			}
		} );

		// show checkboxes for order and coupon section  ?
		if ( f  ||  verify_checkboxes && $('#'+object_id+" input[type='checkbox']:checked").length ) {
			$( '#'+object_id ).prev().click();
		}
	}

	function validateExport() {
		if ( ( mode == settings_form.EXPORT_PROFILE ) && ( !$( "[name='settings[title]']" ).val() ) ) {
			alert( export_messages.empty_title );
			$( "[name='settings[title]']" ).focus();
			return false;
		}

		if ( ( $( "#from_date" ).val() ) && ( $( "#to_date" ).val() ) ) {
			var d1 = new Date( $( "#from_date" ).val() );
			var d2 = new Date( $( "#to_date" ).val() );
			if ( d1.getTime() > d2.getTime() ) {
				alert( export_messages.wrong_date_range );
				return false;
			}
		}
		if ( $( '#order_fields input[type=checkbox]:checked' ).size() == 0 )
		{
			alert( export_messages.no_fields );
			return false;
		}

		return true;
	}
// EXPORT FUNCTIONS END
	$( "#export-wo-pb-btn" ).click( function() {
		$( '#export_wo_pb_form' ).attr( "action", ajaxurl );
		$( '#export_wo_pb_form' ).find( '[name=json]' ).val( makeJson( $( '#export_job_settings' ) ) );
		$( '#export_wo_pb_form' ).submit();
		return false;
	} );

	$( "#export-btn, #my-quick-export-btn" ).click( function() {
		window.cancelling = false;

		data = get_data();

		data.push( { name: 'method', value: 'export_start' } );
		if ( ( $( "#from_date" ).val() ) && ( $( "#to_date" ).val() ) ) {
			var d1 = new Date( $( "#from_date" ).val() );
			var d2 = new Date( $( "#to_date" ).val() );
			if ( d1.getTime() > d2.getTime() ) {
				alert( export_messages.wrong_date_range );
				return false;
			}
		}

		if ( $( '#order_fields input[type=checkbox]:checked' ).size() == 0 )
		{
			alert( export_messages.no_fields );
			return false;
		}


		jQuery.ajax( {
			type: "post",
			data: data,
			cache: false,
			url: ajaxurl,
			dataType: "json",
			error: function( xhr, status, error ) {
				alert( xhr.responseText.replace(/<\/?[^>]+(>|$)/g, "") );
			},
			success: function( response ) {
				window.count = response['total'];
				window.file_id = response['file_id'];
				console.log( window.count );

				if ( window.count > 0 )
					get_all( 0, 0, 'export_part' );
				else {
					alert( export_messages.no_results );
					reset_date_filter_for_cron();
				}
			}
		} );

		return false;
	} );
	$( "#save-btn" ).click( function() {
		if (!validateExport()) {
			return false;
		}
		setFormSubmitting();

		var data = 'json=' + makeJsonVar( $( '#export_job_settings' ) )
		data = data + "&action=order_exporter&method=save_settings&mode=" + mode + "&id=" + job_id;
		$.post( ajaxurl, data, function( response ) {
//			if ( mode == '<?php echo WC_Order_Export_Manage::EXPORT_SCHEDULE; ?>' ) {
//				document.location = '<?php echo admin_url( 'admin.php?page=wc-order-export&tab=schedules&save=y' ) ?>';
//			} else if ( mode == '<?php echo WC_Order_Export_Manage::EXPORT_PROFILE; ?>' ) {
//				document.location = '<?php echo admin_url( 'admin.php?page=wc-order-export&tab=profiles&save=y' ) ?>';
//			} else if ( mode == '<?php echo WC_Order_Export_Manage::EXPORT_ORDER_ACTION; ?>' ) {
//				document.location = '<?php echo admin_url( 'admin.php?page=wc-order-export&tab=order_actions&save=y' ) ?>';
//			} else {
//				document.location = '<?php echo admin_url( 'admin.php?page=wc-order-export&tab=export&save=y' ) ?>';
//			}
			document.location = settings_form.save_settings_url;
		}, "json" );
		return false;
	} );
	$( "#copy-to-profiles" ).click( function() {
		if (!validateExport()) {
			return false;
		}

		var data = 'json=' + makeJsonVar( $( '#export_job_settings' ) )
		data = data + "&action=order_exporter&method=save_settings&mode=" + settings_form.EXPORT_PROFILE + "&id=";
		$.post( ajaxurl, data, function( response ) {
			document.location =settings_form.copy_to_profiles_url  + '&profile_id=' + response.id;
		}, "json" );
		return false;
	} );

	openFilter('my-order', 1);

	openFilter('my-products');

	openFilter('my-shipping');

	openFilter('my-users');

	openFilter('my-coupons', 1);

	openFilter('my-billing');

	openFilter('my-items-meta');

	if ( mode == settings_form.EXPORT_SCHEDULE )
		setup_alert_date_filter();
	//for XLSX
	$('#format_xls_use_xls_format').click(function() {
		change_filename_ext();
	});

	show_summary_report( output_format );
	if( !summary_mode )
		jQuery('#summary_setup_fields').hide();
	//logic for setup link
	jQuery( "#summary_report_by_products_checkbox" ).change( function() {
		if( jQuery(this).prop('checked') )
			jQuery('#summary_setup_fields').show();
		else
			jQuery('#summary_setup_fields').hide();
	});

	// this line must be last , we don't have any errors
	jQuery('#JS_error_onload').hide();
} );

function is_flat_format(format) {
	return (settings_form.flat_formats.indexOf(format) > -1);
}
function is_object_format(format) {
	return (settings_form.object_formats.indexOf(format) > -1);
}
function is_xml_format(format) {
	return (settings_form.xml_formats.indexOf(format) > -1);
}
function reset_date_filter_for_cron() {
	if(mode == 'cron') {
		jQuery( "#from_date" ).val("");
		jQuery( "#to_date" ).val("");
		try_color_date_filter();
	}
}