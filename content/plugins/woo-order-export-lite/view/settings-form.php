<?php
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
add_thickbox();
/**
 * @var WC_Order_Export_Admin $WC_Order_Export WC_Order_Export_Admin instance
 * @var string $mode ( now | profiles | cron | order-action )
 * @var integer $id job id
 * @var string $ajaxurl
 * @var array $show
 *
 */
$settings                 = WC_Order_Export_Manage::get( $mode, $id );
$settings                 = apply_filters('woe_settings_page_prepare', $settings );
$order_custom_meta_fields = WC_Order_Export_Data_Extractor_UI::get_all_order_custom_meta_fields();
$readonly_php = WC_Order_Export_Admin::user_can_add_custom_php() ? '' : 'readonly';
?>

<script>
	var mode = '<?php echo $mode ?>';
	var job_id = '<?php echo $id ?>';
	var output_format = '<?php echo $settings[ 'format' ] ?>';
	var order_fields = <?php echo json_encode( $settings[ 'order_fields' ] ) ?>;
	var order_products_fields = <?php echo json_encode( $settings[ 'order_product_fields' ] ) ?>;
	var order_coupons_fields = <?php echo json_encode( $settings[ 'order_coupon_fields' ] ) ?>;
	var order_custom_meta_fields = <?php echo json_encode( $order_custom_meta_fields ) ?>;
	var order_products_custom_meta_fields = <?php echo json_encode( WC_Order_Export_Data_Extractor_UI::get_product_custom_fields() ) ?>;
	var order_order_item_custom_meta_fields = <?php echo json_encode( WC_Order_Export_Data_Extractor_UI::get_product_itemmeta() ) ?>;
	var order_coupons_custom_meta_fields = <?php echo json_encode( WC_Order_Export_Data_Extractor_UI::get_all_coupon_custom_meta_fields() ) ?>;
	var summary_mode = <?php echo $settings['summary_report_by_products'] ?>;
</script>


<?php include 'modal-controls.php'; ?>
<form method="post" id="export_job_settings">
	<?php if ( $mode !== WC_Order_Export_Manage::EXPORT_NOW ): ?>
		<div style="width: 100%;">&nbsp;</div>
	<?php endif; ?>

	<div id="my-left" style="float: left; width: 49%; max-width: 500px;">
		<?php 
			if ( $mode === WC_Order_Export_Manage::EXPORT_PROFILE ): 
				include 'pro-version/top-profile.php';
			elseif ( $mode === WC_Order_Export_Manage::EXPORT_ORDER_ACTION ): 
				include 'pro-version/top-order-actions.php';
			elseif ( $mode === WC_Order_Export_Manage::EXPORT_SCHEDULE ): 
				include 'pro-version/top-scheduled-jobs.php';
			endif; 
		?>

		<?php if ( $show[ 'date_filter' ] ) : ?>
			<div id="my-export-date-field" class="my-block">
				<div class="wc-oe-header">
					<?php _e( 'Filter orders by', 'woo-order-export-lite' ) ?>:
				</div>
				<label>
					<input type="radio" name="settings[export_rule_field]" class="width-100" <?php echo (!isset( $settings[ 'export_rule_field' ] ) || ($settings[ 'export_rule_field' ] == 'date')) ? 'checked' : '' ?> value="date" >
					<?php _e( 'Order Date', 'woo-order-export-lite' ) ?>
				</label>
				&#09;&#09;
				<label>
					<input type="radio" name="settings[export_rule_field]" class="width-100" <?php echo (isset( $settings[ 'export_rule_field' ] ) && ($settings[ 'export_rule_field' ] == 'modified')) ? 'checked' : '' ?> value="modified" >
					<?php _e( 'Modification Date', 'woo-order-export-lite' ) ?>
				</label>
				&#09;&#09;
				<label>
					<input type="radio" name="settings[export_rule_field]" class="width-100" <?php echo (isset( $settings[ 'export_rule_field' ] ) && ($settings[ 'export_rule_field' ] == 'date_paid')) ? 'checked' : '' ?> value="date_paid" >
					<?php _e( 'Paid Date', 'woo-order-export-lite' ) ?>
				</label>
				&#09;&#09;
				<label>
					<input type="radio" name="settings[export_rule_field]" class="width-100" <?php echo (isset( $settings[ 'export_rule_field' ] ) && ($settings[ 'export_rule_field' ] == 'date_completed')) ? 'checked' : '' ?> value="date_completed" >
					<?php _e( 'Completed Date', 'woo-order-export-lite' ) ?>
				</label>
			</div>
			<br>
			<div id="my-date-filter" class="my-block" title = "<?php _e( 'This date range should not be saved in the scheduled task', 'woo-order-export-lite' ) ?>">
				<div style="display: inline;">
					<span class="wc-oe-header"><?php _e( 'Date range', 'woo-order-export-lite' ) ?></span>
					<input type=text class='date' name="settings[from_date]" id="from_date" value='<?php echo $settings[ 'from_date' ] ?>'>
					<?php _e( 'to', 'woo-order-export-lite' ) ?>
					<input type=text class='date' name="settings[to_date]" id="to_date" value='<?php echo $settings[ 'to_date' ] ?>'>
				</div>

				<button id="my-quick-export-btn" class="button-primary"><?php _e( 'Express export', 'woo-order-export-lite' ) ?></button>
				<div id="summary_report_by_products" style="display:inline-block"><input type="hidden" name="settings[summary_report_by_products]" value="0"/><label><input type="checkbox" id=summary_report_by_products_checkbox name="settings[summary_report_by_products]" value="1" <?php checked($settings[ 'summary_report_by_products' ]) ?> /> <?php _e( "Summary Report By Products", 'woo-order-export-lite' ) ?></label>
					&nbsp;&nbsp;<label id="summary_setup_fields"><a href="#TB_inline?width=600&height=550&inlineId=modal-manage-products" class="thickbox " id="link_modal_manage_products_summary"><?php _e( 'Set up fields', 'woo-order-export-lite' ) ?></a></label>
				</div>
			</div>
			<br>
		<?php endif; ?>

			<div id="my-export-file" class="my-block">
				<div class="wc-oe-header">
					<?php _e( 'Export filename', 'woo-order-export-lite' ) ?>:
				</div>
				<label id="export_filename" class="width-100">
					<input type="text" name="settings[export_filename]" class="width-100" value="<?php echo isset( $settings[ 'export_filename' ] ) ? $settings[ 'export_filename' ] : 'orders-%y-%m-%d-%h-%i-%s.xlsx' ?>" >
				</label>
			</div>
			<br>


		<div id="my-format" class="my-block">
			<span class="wc-oe-header"><?php _e( 'Format', 'woo-order-export-lite' ) ?></span><br>
			<p>
				<?php foreach ( WC_Order_Export_Admin::$formats as $format ) { ?>
					<label class="button-secondary">
						<input type=radio name="settings[format]" class="output_format" value="<?php echo $format ?>"
							   <?php if ( $format == $settings[ 'format' ] ) echo 'checked'; ?> ><?php echo $format ?>
						<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span>
					</label>
				<?php } ?>
			</p>

			<div id='XLS_options' style='display:none'><strong><?php _e( 'XLS options', 'woo-order-export-lite' ) ?></strong><br>
				<input type=hidden name="settings[format_xls_use_xls_format]" value=0>
				<input type=hidden name="settings[format_xls_display_column_names]" value=0>
				<input type=hidden name="settings[format_xls_auto_width]" value=0>
				<input type=hidden name="settings[format_xls_populate_other_columns_product_rows]" value=0>
				<input type=hidden name="settings[format_xls_direction_rtl]" value=0>
				<input type=checkbox name="settings[format_xls_use_xls_format]" value=1 <?php if ( @$settings[ 'format_xls_use_xls_format' ] ) echo 'checked'; ?>  id="format_xls_use_xls_format">  <?php _e( 'Export as .xls (Binary File Format)', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox checked disabled><?php _e( 'Use sheet name', 'woo-order-export-lite' ) ?></b><input type=text name="settings[format_xls_sheet_name]" value='<?php echo $settings[ 'format_xls_sheet_name' ] ?>' size=10><br>
				<input type=checkbox name="settings[format_xls_display_column_names]" value=1 <?php if ( @$settings[ 'format_xls_display_column_names' ] ) echo 'checked'; ?>  >  <?php _e( 'Output column titles as first line', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_xls_auto_width]" value=1 <?php if ( @$settings[ 'format_xls_auto_width' ] ) echo 'checked'; ?>  >  <?php _e( 'Auto column width', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_xls_populate_other_columns_product_rows]" value=1 <?php if ( @$settings[ 'format_xls_populate_other_columns_product_rows' ] ) echo 'checked'; ?>  >  <?php _e( 'Populate other columns if products exported as rows', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_xls_direction_rtl]" value=1 <?php if ( @$settings[ 'format_xls_direction_rtl' ] ) echo 'checked'; ?>  >  <?php _e( 'Right-to-Left direction', 'woo-order-export-lite' ) ?><br>
			</div>
			<div id='CSV_options' style='display:none'><strong><?php _e( 'CSV options', 'woo-order-export-lite' ) ?></strong><br>
				<input type=hidden name="settings[format_csv_add_utf8_bom]" value=0>
				<input type=hidden name="settings[format_csv_display_column_names]" value=0>
				<input type=hidden name="settings[format_csv_populate_other_columns_product_rows]" value=0>
				<input type=hidden name="settings[format_csv_delete_linebreaks]" value=0>
				<input type=hidden name="settings[format_csv_item_rows_start_from_new_line]" value=0>
				<input type=checkbox name="settings[format_csv_add_utf8_bom]" value=1 <?php if ( @$settings[ 'format_csv_add_utf8_bom' ] ) echo 'checked'; ?>  > <?php _e( 'Output UTF-8 BOM', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_csv_display_column_names]" value=1 <?php if ( @$settings[ 'format_csv_display_column_names' ] ) echo 'checked'; ?>  >  <?php _e( 'Output column titles as first line', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_csv_populate_other_columns_product_rows]" value=1 <?php if ( @$settings[ 'format_csv_populate_other_columns_product_rows' ] ) echo 'checked'; ?>  >  <?php _e( 'Populate other columns if products exported as rows', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_csv_delete_linebreaks]" value=1 <?php if ( @$settings[ 'format_csv_delete_linebreaks' ] ) echo 'checked'; ?>  >  <?php _e( 'Convert line breaks to literals', 'woo-order-export-lite' ) ?><br>
				<input type=checkbox name="settings[format_csv_item_rows_start_from_new_line]" value=1 <?php if ( @$settings[ 'format_csv_item_rows_start_from_new_line' ] ) echo 'checked'; ?>  >  <?php _e( 'Item rows start from new line', 'woo-order-export-lite' ) ?><br>
				<?php _e( 'Enclosure', 'woo-order-export-lite' ) ?> <input type=text name="settings[format_csv_enclosure]" value='<?php echo $settings[ 'format_csv_enclosure' ] ?>' size=1>
				<?php _e( 'Field Delimiter', 'woo-order-export-lite' ) ?> <input type=text name="settings[format_csv_delimiter]" value='<?php echo $settings[ 'format_csv_delimiter' ] ?>' size=1>
				<?php _e( 'Line Break', 'woo-order-export-lite' ) ?><input type=text name="settings[format_csv_linebreak]" value='<?php echo $settings[ 'format_csv_linebreak' ] ?>' size=4><br>
				<?php if ( function_exists( 'iconv' ) ): ?>
					<?php _e( 'Character encoding', 'woo-order-export-lite' ) ?><input type=text name="settings[format_csv_encoding]" value="<?php echo $settings[ 'format_csv_encoding' ] ?>"><br>
				<?php endif ?>
			</div>
			<div id='XML_options' style='display:none'><strong><?php _e( 'XML options', 'woo-order-export-lite' ) ?></strong><br>
				<input type=hidden name="settings[format_xml_self_closing_tags]" value=0>
				<span class="xml-title"><?php _e( 'Prepend XML', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_xml_prepend_raw_xml]" value='<?php echo $settings[ 'format_xml_prepend_raw_xml' ] ?>'><br>
				<span class="xml-title"><?php _e( 'Root tag', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_xml_root_tag]" value='<?php echo $settings[ 'format_xml_root_tag' ] ?>'><br>
				<span class="xml-title"><?php _e( 'Order tag', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_xml_order_tag]" value='<?php echo $settings[ 'format_xml_order_tag' ] ?>'><br>
				<span class="xml-title"><?php _e( 'Product tag', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_xml_product_tag]" value='<?php echo $settings[ 'format_xml_product_tag' ] ?>'><br>
				<span class="xml-title"><?php _e( 'Coupon tag', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_xml_coupon_tag]" value='<?php echo $settings[ 'format_xml_coupon_tag' ] ?>'><br>
				<span class="xml-title"><?php _e( 'Append XML', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_xml_append_raw_xml]" value='<?php echo $settings[ 'format_xml_append_raw_xml' ] ?>'><br>
				<span class="xml-title"><?php _e( 'Self closing tags', 'woo-order-export-lite' ) ?></span><input type=checkbox name="settings[format_xml_self_closing_tags]" value=1 <?php if ( @$settings[ 'format_xml_self_closing_tags' ] ) echo 'checked'; ?>  ><br>
			</div>
			<div id='JSON_options' style='display:none'><strong><?php _e( 'JSON options', 'woo-order-export-lite' ) ?></strong><br>
				<span class="xml-title"><?php _e( 'Start tag', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_json_start_tag]" value='<?php echo @$settings[ 'format_json_start_tag' ] ?>'><br>
				<span class="xml-title"><?php _e( 'End tag', 'woo-order-export-lite' ) ?></span><input type=text name="settings[format_json_end_tag]" value='<?php echo @$settings[ 'format_json_end_tag' ] ?>'>
			</div>
            <div id='TSV_options' style='display:none'><strong><?php _e( 'TSV options', 'woo-order-export-lite' ) ?></strong><br>
                <input type=hidden name="settings[format_tsv_add_utf8_bom]" value=0>
                <input type=hidden name="settings[format_tsv_display_column_names]" value=0>
                <input type=hidden name="settings[format_tsv_populate_other_columns_product_rows]" value=0>
                <input type=checkbox name="settings[format_tsv_add_utf8_bom]" value=1 <?php if ( @$settings[ 'format_tsv_add_utf8_bom' ] ) echo 'checked'; ?>  > <?php _e( 'Output UTF-8 BOM', 'woo-order-export-lite' ) ?><br>
                <input type=checkbox name="settings[format_tsv_display_column_names]" value=1 <?php if ( @$settings[ 'format_tsv_display_column_names' ] ) echo 'checked'; ?>  >  <?php _e( 'Output column titles as first line', 'woo-order-export-lite' ) ?><br>
                <input type=checkbox name="settings[format_tsv_populate_other_columns_product_rows]" value=1 <?php if ( @$settings[ 'format_tsv_populate_other_columns_product_rows' ] ) echo 'checked'; ?>  >  <?php _e( 'Populate other columns if products exported as rows', 'woo-order-export-lite' ) ?><br>
				<?php _e( 'Line Break', 'woo-order-export-lite' ) ?><input type=text name="settings[format_tsv_linebreak]" value='<?php echo $settings[ 'format_tsv_linebreak' ] ?>' size=4><br>
				<?php if ( function_exists( 'iconv' ) ): ?>
					<?php _e( 'Character encoding', 'woo-order-export-lite' ) ?><input type=text name="settings[format_tsv_encoding]" value="<?php echo $settings[ 'format_tsv_encoding' ] ?>"><br>
				<?php endif ?>
            </div>

			<br>
			<div id="my-date-time-format" class="">
				<div id="date_format_block">
					<span class="wc-oe-header"><?php _e( 'Date', 'woo-order-export-lite' ) ?></span>
					<?php
					$date_format = array(
							'',
							'F j, Y',
							'Y-m-d',
							'm/d/Y',
							'd/m/Y',
					);
					$date_format = apply_filters( 'woe_date_format', $date_format );
					?>
					<select>
						<?php foreach( $date_format as $format ):  ?>
							<option value="<?php echo $format ?>" <?php echo selected( @$settings[ 'date_format' ], $format ) ?> ><?php echo !empty( $format ) ? current_time( $format ) : __( '-', 'woo-order-export-lite' ) ?></option>
						<?php endforeach; ?>
						<option value="custom" <?php echo selected( in_array( @$settings[ 'date_format' ], $date_format ), false) ?> ><?php echo __( 'custom', 'woo-order-export-lite' ) ?></option>
					</select>
					<div id="custom_date_format_block" style="<?php echo in_array( @$settings[ 'date_format' ], $date_format ) ? 'display: none' : '' ?>">
						<input type="text" name="settings[date_format]" value="<?php echo $settings[ 'date_format' ] ?>">
					</div>
				</div>

				<div id="time_format_block">
					<span class="wc-oe-header"><?php _e( 'Time', 'woo-order-export-lite' ) ?></span>
					<?php
					$time_format = array(
							'',
							'g:i a',
							'g:i A',
							'H:i',
					);
					$time_format = apply_filters( 'woe_time_format', $time_format );
					?>
					<select>
						<?php foreach( $time_format as $format ):  ?>
							<option value="<?php echo $format ?>" <?php echo selected( @$settings[ 'time_format' ], $format ) ?> ><?php echo !empty( $format ) ? current_time( $format ) : __( '-', 'woo-order-export-lite' ) ?></option>
						<?php endforeach; ?>
						<option value="custom" <?php echo selected( in_array( @$settings[ 'time_format' ], $time_format ), false) ?> ><?php echo __( 'custom', 'woo-order-export-lite' ) ?></option>
					</select>
					<div id="custom_time_format_block" style="<?php echo in_array( @$settings[ 'time_format' ], $time_format ) ? 'display: none' : '' ?>">
						<input type="text" name="settings[time_format]" value="<?php echo $settings[ 'time_format' ] ?>">
					</div>
				</div>		
			</div>
		</div>
		<br/>
		<div id="my-sort" class="my-block">
			<?php
			$sort = array(
				'order_id'      => __( 'Order ID', 'woo-order-export-lite' ),
				'post_date'     => __( 'Order Date', 'woo-order-export-lite' ),
				'post_modified' => __( 'Modification Date', 'woo-order-export-lite' ),
			);
			ob_start();
			?>
            <select name="settings[sort]">
				<?php foreach( $sort as $value => $text ):  ?>
                	<option value='<?php echo $value ?>' <?php echo selected( @$settings[ 'sort' ], $value ) ?> ><?php echo  $text; ?></option>
				<?php endforeach; ?>
            </select>
            <?php
            $sort_html = ob_get_clean();

			ob_start();
			?>
            <select name="settings[sort_direction]">
                <option value='DESC' <?php echo selected( @$settings[ 'sort_direction' ], 'DESC') ?> ><?php _e( 'Descending', 'woo-order-export-lite' ) ?></option>
                <option value='ASC'  <?php echo selected( @$settings[ 'sort_direction' ], 'ASC') ?> ><?php _e( 'Ascending', 'woo-order-export-lite' ) ?></option>
            </select>
            <?php
            $sort_direction_html = ob_get_clean();

            echo sprintf( __( 'Sort orders by %s in %s order', 'woo-order-export-lite' ), $sort_html, $sort_direction_html );
            ?>

			<?php if ( $mode === WC_Order_Export_Manage::EXPORT_SCHEDULE ): ?>
                <div>
                    <label for="change_order_status_to"><?php _e( 'Change order status to', 'woo-order-export-lite' ) ?></label>
                    <select id="change_order_status_to" name="settings[change_order_status_to]">
                        <option value="" <?php if ( empty( $settings[ 'change_order_status_to' ] ) ) echo 'selected'; ?>><?php _e( "- don't modify -", 'woo-order-export-lite' ) ?></option>
		                <?php foreach ( wc_get_order_statuses() as $i => $status ) { ?>
                            <option value="<?php echo $i ?>" <?php if ( $i === $settings[ 'change_order_status_to' ] ) echo 'selected'; ?>><?php echo $status ?></option>
		                <?php } ?>
                    </select>
                </div>
			<?php endif; ?>
		</div>
        <br>
        <div class="my-block">
			<span class="my-hide-next "><?php _e( 'Misc settings', 'woo-order-export-lite' ) ?>
                <span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
            <div id="my-misc" hidden="hidden">
                <div>
                    <input type="hidden" name="settings[format_number_fields]" value="0"/>
                    <label><input type="checkbox" name="settings[format_number_fields]" value="1" <?php checked($settings['format_number_fields']) ?>/><?php _e( 'Format numbers (use WC decimal separator)', 'woo-order-export-lite' ) ?></label>
                </div>
                <div>
                    <input type="hidden" name="settings[export_all_comments]" value="0"/>
                    <label><input type="checkbox" name="settings[export_all_comments]" value="1" <?php checked($settings['export_all_comments']) ?>/><?php _e( 'Export all order notes', 'woo-order-export-lite' ) ?></label>
                </div>
                <div>
                    <input type="hidden" name="settings[export_refund_notes]" value="0"/>
                    <label><input type="checkbox" name="settings[export_refund_notes]" value="1" <?php checked($settings['export_refund_notes']) ?>/><?php _e( 'Export refund notes as Customer Note', 'woo-order-export-lite' ) ?></label>
                </div>
                <div>
                    <input type="hidden" name="settings[strip_tags_product_fields]" value="0"/>
                    <label><input type="checkbox" name="settings[strip_tags_product_fields]" value="1" <?php checked($settings['strip_tags_product_fields']) ?>/><?php _e( 'Strip tags from Product Description/Variation', 'woo-order-export-lite' ) ?></label>
                </div>
                <div>
                    <input type="hidden" name="settings[cleanup_phone]" value="0"/>
                    <label><input type="checkbox" name="settings[cleanup_phone]" value="1" <?php checked($settings['cleanup_phone']) ?>/><?php _e( 'Cleanup phone (export only digits)', 'woo-order-export-lite' ) ?></label>
                </div>
                <div>
                    <input type="hidden" name="settings[enable_debug]" value="0"/>
                    <label><input type="checkbox" name="settings[enable_debug]" value="1" <?php checked($settings['enable_debug']) ?>/><?php _e( 'Enable debug output', 'woo-order-export-lite' ) ?></label>
                </div>
				<div>
                    <input type="hidden" name="settings[custom_php]" value="0"/>
                    <label><input type="checkbox" name="settings[custom_php]" value="1" <?php checked($settings['custom_php']) ?>/><?php _e( 'Custom PHP code to modify output', 'woo-order-export-lite' ) ?></label>
					<textarea  placeholder="<?php _e( 'Use only unnamed functions!', 'woo-order-export-lite' ) ?>" name="settings[custom_php_code]" <?php echo $readonly_php?> class="width-100" rows="10" <?php echo $settings['custom_php'] ? '' : 'style="display: none"' ?>><?php echo $settings['custom_php_code'] ?></textarea>
				</div>
            </div>
        </div>
	</div>

	<div id="my-right" style="float: left; width: 48%; margin: 0px 10px; max-width: 500px;">
		<?php 
		if ( in_array( $mode, array( WC_Order_Export_Manage::EXPORT_SCHEDULE, WC_Order_Export_Manage::EXPORT_ORDER_ACTION ) ) ):
			include "pro-version/destinations.php";
		endif; ?>

		<div class="my-block">
			<span class="my-hide-next "><?php _e( 'Filter by order', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-order" hidden="hidden">
				<div><input type="hidden" name="settings[skip_suborders]" value="0"/><label><input type="checkbox" name="settings[skip_suborders]" value="1" <?php checked($settings[ 'skip_suborders' ]) ?> /> <?php _e( "Don't export child orders", 'woo-order-export-lite' ) ?></label></div>
				<div><input type="hidden" name="settings[export_refunds]" value="0"/><label><input type="checkbox" name="settings[export_refunds]" value="1" <?php checked($settings[ 'export_refunds' ]) ?> /> <?php _e( "Export refunds", 'woo-order-export-lite' ) ?></label></div>
				<div><input type="hidden" name="settings[mark_exported_orders]" value="0"/><label><input type="checkbox" name="settings[mark_exported_orders]" value="1" <?php checked($settings[ 'mark_exported_orders' ]) ?> /> <?php _e( "Mark exported orders", 'woo-order-export-lite' ) ?></label></div>
				<div><input type="hidden" name="settings[export_unmarked_orders]" value="0"/><label><input type="checkbox" name="settings[export_unmarked_orders]" value="1" <?php checked($settings[ 'export_unmarked_orders' ]) ?> /> <?php _e( "Export unmarked orders only", 'woo-order-export-lite' ) ?></label></div>
				<span class="wc-oe-header"><?php _e( 'Order statuses', 'woo-order-export-lite' ) ?></span>
				<select id="statuses" name="settings[statuses][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php foreach ( apply_filters('woe_settings_order_statuses', wc_get_order_statuses() ) as $i => $status ) { ?>
						<option value="<?php echo $i ?>" <?php if ( in_array( $i, $settings[ 'statuses' ] ) ) echo 'selected'; ?>><?php echo $status ?></option>
					<?php } ?>
				</select>

				<span class="wc-oe-header"><?php _e( 'Custom fields', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="custom_fields" style="width: auto;">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_order_custom_fields() as $cf_name ) { ?>
						<option><?php echo $cf_name; ?></option>
					<?php } ?>
				</select>

				<select id="custom_fields_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
					<option>LIKE</option>
					<option>&gt;</option>
					<option>&gt;=</option>
					<option>&lt;</option>
					<option>&lt;=</option>
					<option>NOT SET</option>
					<option>IS SET</option>
				</select>

				<input type="text" id="text_custom_fields" disabled class="like-input" style="display: none;">

				<button id="add_custom_fields" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="custom_fields_check" multiple name="settings[order_custom_fields][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'order_custom_fields' ] )
						foreach ( $settings[ 'order_custom_fields' ] as $prod ) {
							?>
							<option selected value="<?php echo $prod; ?>"> <?php echo $prod; ?></option>
						<?php } ?>
				</select>

			</div>
		</div>

		<br>

		<div class="my-block">
			<div id=select2_warning style='display:none;color:red;font-size: 120%;'><?php _e( "The filters won't work correctly.<br>Another plugin(or theme) has loaded outdated Select2.js", 'woo-order-export-lite' ) ?></div>
			<span class="my-hide-next "><?php _e( 'Filter by product', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-products" hidden="hidden">
				<div><input type="hidden" name="settings[all_products_from_order]" value="0"/><label><input type="checkbox" name="settings[all_products_from_order]" value="1" <?php checked($settings[ 'all_products_from_order' ]) ?> /> <?php _e( 'Export all products from a order', 'woo-order-export-lite' ) ?></label></div>
				<div><input type="hidden" name="settings[skip_refunded_items]" value="0"/><label><input type="checkbox" name="settings[skip_refunded_items]" value="1" <?php checked($settings[ 'skip_refunded_items' ]) ?> /> <?php _e( 'Skip fully refunded items', 'woo-order-export-lite' ) ?></label></div>
				<span class="wc-oe-header"><?php _e( 'Product categories', 'woo-order-export-lite' ) ?></span>
				<select id="product_categories" name="settings[product_categories][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'product_categories' ] )
						foreach ( $settings[ 'product_categories' ] as $cat ) {
							$cat_term = get_term( $cat, 'product_cat' );
							?>
							<option selected value="<?php echo $cat_term->term_id ?>"> <?php echo $cat_term->name; ?></option>
						<?php } ?>
				</select>
				<span class="wc-oe-header"><?php _e( 'Vendor/creator', 'woo-order-export-lite' ) ?></span>
				<select id="product_vendors" name="settings[product_vendors][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'product_vendors' ] )
						foreach ( $settings[ 'product_vendors' ] as $user_id ) {
							$user = get_user_by( 'id', $user_id );
							?>
							<option selected value="<?php echo $user_id ?>"> <?php echo $user->display_name; ?></option>
						<?php } ?>
				</select>

                <?php do_action("woe_settings_filter_by_product_after_vendors", $settings); ?>

				<span class="wc-oe-header"><?php _e( 'Product', 'woo-order-export-lite' ) ?></span>

				<select id="products" name="settings[products][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'products' ] )
						foreach ( $settings[ 'products' ] as $prod ) {
							$p = get_the_title( $prod );
							?>
							<option selected value="<?php echo $prod ?>"> <?php echo $p; ?></option>
						<?php } ?>
				</select>

				<span class="wc-oe-header"><?php _e( 'Product taxonomies', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="taxonomies" style="width: auto;">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_product_taxonomies() as $attr_id => $attr_name ) { ?>
						<option><?php echo $attr_name; ?></option>
					<?php } ?>
				</select>

                <select id="taxonomies_compare" class="select_compare">
                    <option>=</option>
                    <option>&lt;&gt;</option>
                </select>

                <input type="text" id="text_taxonomies" disabled style="display: none;">

                <button id="add_taxonomies" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="taxonomies_check" multiple name="settings[product_taxonomies][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'product_taxonomies' ] )
						foreach ( $settings[ 'product_taxonomies' ] as $prod ) {
							?>
							<option selected value="<?php echo $prod; ?>"> <?php echo $prod; ?></option>
						<?php } ?>
				</select>

				<span class="wc-oe-header"><?php _e( 'Product custom fields', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="product_custom_fields" style="width: auto;">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_product_custom_fields() as $cf_name ) { ?>
						<option><?php echo $cf_name; ?></option>
					<?php } ?>
				</select>

				<select id="product_custom_fields_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
					<option>LIKE</option>
					<option>&gt;</option>
					<option>&gt;=</option>
					<option>&lt;</option>
					<option>&lt;=</option>
				</select>

				<input type="text" id="text_product_custom_fields" disabled class="like-input" style="display: none;">

				<button id="add_product_custom_fields" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="product_custom_fields_check" multiple name="settings[product_custom_fields][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'product_custom_fields' ] )
						foreach ( $settings[ 'product_custom_fields' ] as $prod ) {
							?>
							<option selected value="<?php echo $prod; ?>"> <?php echo $prod; ?></option>
						<?php } ?>
				</select>

				<span class="wc-oe-header"><?php _e( 'Variable product attributes', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="attributes" style="width: auto;">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_product_attributes() as $attr_id => $attr_name ) { ?>
						<option><?php echo $attr_name; ?></option>
					<?php } ?>
				</select>

				<select id="attributes_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
					<option>LIKE</option>
				</select>

				<input type="text" id="text_attributes" disabled class="like-input" style="display: none;">

				<button id="add_attributes" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="attributes_check" multiple name="settings[product_attributes][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'product_attributes' ] )
						foreach ( $settings[ 'product_attributes' ] as $prod ) {
							?>
							<option selected value="<?php echo $prod; ?>"> <?php echo $prod; ?></option>
						<?php } ?>
				</select>

                <span class="wc-oe-header"><?php _e( 'Item meta data', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="itemmeta" style="width: auto;">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_product_itemmeta() as $attr_name ) { ?>
						<option data-base64="<?php echo base64_encode($attr_name); ?>"  ><?php echo $attr_name; ?></option>
					<?php } ?>
				</select>

				<select id="itemmeta_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
					<option>LIKE</option>
					<option>&gt;</option>
					<option>&gt;=</option>
					<option>&lt;</option>
					<option>&lt;=</option>
				</select>

				<input type="text" id="text_itemmeta" disabled class="like-input" style="display: none;">

				<button id="add_itemmeta" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="itemmeta_check" multiple name="settings[product_itemmeta][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'product_itemmeta' ] )
						foreach ( $settings[ 'product_itemmeta' ] as $prod ) {
							?>
							<option selected value="<?php echo $prod; ?>"> <?php echo $prod; ?></option>
						<?php } ?>
				</select>

			</div>
		</div>

		<br>

		<div class="my-block">
			<span class="my-hide-next "><?php _e( 'Filter by customers', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-users" hidden="hidden">
				<span class="wc-oe-header"><?php _e( 'User roles', 'woo-order-export-lite' ) ?></span>
				<select id="user_roles" name="settings[user_roles][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php
					global $wp_roles;
					foreach ( $wp_roles->role_names as $k => $v ) { ?>
						<option value="<?php echo $k ?>" <?php echo ( in_array($k, $settings[ 'user_roles' ] ) ? selected(true) : '') ?>> <?php echo $v ?></option>
					<?php } ?>
				</select>

				<span class="wc-oe-header"><?php _e( 'Usernames', 'woo-order-export-lite' ) ?></span>
				<select id="user_names" name="settings[user_names][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'user_names' ] )
						foreach ( $settings[ 'user_names' ] as $user_id ) {
							$user = get_user_by( 'id', $user_id );
							?>
							<option selected value="<?php echo $user_id ?>"> <?php echo $user->display_name; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<br>

		<div class="my-block">
			<span class="my-hide-next "><?php _e( 'Filter by coupons', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-coupons" hidden="hidden">
                <div>
                    <input type="hidden" name="settings[any_coupon_used]" value="0"/>
                    <label><input type="checkbox" name="settings[any_coupon_used]" value="1" <?php checked($settings['any_coupon_used']) ?>/><?php _e( 'Any coupon used', 'woo-order-export-lite' ) ?></label>
                </div>
				<span class="wc-oe-header"><?php _e( 'Coupons', 'woo-order-export-lite' ) ?></span>
				<select id="coupons" name="settings[coupons][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings['coupons'] )
						foreach ( $settings['coupons'] as $coupon ) {
							?>
							<option selected value="<?php echo $coupon; ?>"> <?php echo $coupon; ?></option>
						<?php } ?>
				</select>
			</div>
		</div>

		<br>

		<div class="my-block">
			<span class="my-hide-next "><?php _e( 'Filter by billing', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-billing" hidden="hidden">
                <span class="wc-oe-header"><?php _e( 'Billing locations', 'woo-order-export-lite' ) ?></span>
                <br>
                <select id="billing_locations">
                    <option>City</option>
                    <option>State</option>
                    <option>Postcode</option>
                    <option>Country</option>
                </select>
                <select id="billing_compare" class="select_compare">
                    <option>=</option>
                    <option>&lt;&gt;</option>
                </select>

                <button id="add_billing_locations" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
                <br>
                <select id="billing_locations_check" multiple name="settings[billing_locations][]" style="width: 100%; max-width: 25%;">
                    <?php
                    if ( $settings[ 'billing_locations' ] )
                        foreach ( $settings[ 'billing_locations' ] as $location ) {
                            ?>
                            <option selected value="<?php echo $location; ?>"> <?php echo $location; ?></option>
                        <?php } ?>
                </select>

				<span class="wc-oe-header"><?php _e( 'Payment methods', 'woo-order-export-lite' ) ?></span>
				<select id="payment_methods" name="settings[payment_methods][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php foreach ( WC()->payment_gateways->payment_gateways() as $gateway ) { ?>
						<option value="<?php echo $gateway->id ?>" <?php if ( in_array( $gateway->id, $settings[ 'payment_methods' ] ) ) echo 'selected'; ?>><?php echo $gateway->get_title() ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<br>

		<div class="my-block">
			<span class="my-hide-next "><?php _e( 'Filter by shipping', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-shipping" hidden="hidden">
				<span class="wc-oe-header"><?php _e( 'Shipping locations', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="shipping_locations">
					<option>City</option>
					<option>State</option>
					<option>Postcode</option>
					<option>Country</option>
				</select>
				<select id="shipping_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
				</select>

				<button id="add_shipping_locations" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="shipping_locations_check" multiple name="settings[shipping_locations][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'shipping_locations' ] )
						foreach ( $settings[ 'shipping_locations' ] as $location ) {
							?>
							<option selected value="<?php echo $location; ?>"> <?php echo $location; ?></option>
						<?php } ?>
				</select>

				<span class="wc-oe-header"><?php _e( 'Shipping methods', 'woo-order-export-lite' ) ?></span>
				<select id="shipping_methods" name="settings[shipping_methods][]" multiple="multiple" style="width: 100%; max-width: 25%;">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_shipping_methods() as $i => $title ) { ?>
						<option value="<?php echo $i ?>" <?php if ( in_array( $i, $settings[ 'shipping_methods' ] ) ) echo 'selected'; ?>><?php echo $title ?></option>
					<?php } ?>
				</select>
			</div>
		</div>

		<br>
		
		<div class="my-block">
			<span class="my-hide-next "><?php _e( 'Filter by item and metadata', 'woo-order-export-lite' ) ?>
				<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
			<div id="my-items-meta" hidden="hidden">
				<span class="wc-oe-header"><?php _e( 'Item names', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="item_names">
					<option>coupon</option>
					<option>fee</option>
					<option>line_item</option>
					<option>shipping</option>
					<option>tax</option>
				</select>
				<select id="item_name_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
				</select>
				<button id="add_item_names" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="item_names_check" multiple name="settings[item_names][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'item_names' ] )
						foreach ( $settings[ 'item_names' ] as $name ) {
							?>
							<option selected value="<?php echo $name; ?>"> <?php echo $name; ?></option>
						<?php } ?>
				</select>
				
				<span class="wc-oe-header"><?php _e( 'Item metadata', 'woo-order-export-lite' ) ?></span>
				<br>
				<select id="item_metadata">
					<?php foreach ( WC_Order_Export_Data_Extractor_UI::get_item_meta_keys() as $type=>$meta_keys ) { ?>
						<optgroup label="<?php echo ucwords($type); ?>">
						<?php foreach ( $meta_keys as $item_meta_key ) { ?>
							<option value="<?php echo $type.":".$item_meta_key; ?>" ><?php echo $item_meta_key; ?></option>
						<?php } ?>				
						</optgroup>
					<?php } ?>				
				</select>
				<select id="item_metadata_compare" class="select_compare">
					<option>=</option>
					<option>&lt;&gt;</option>
				</select>
				<button id="add_item_metadata" class="button-secondary"><span class="dashicons dashicons-plus-alt"></span></button>
				<br>
				<select id="item_metadata_check" multiple name="settings[item_metadata][]" style="width: 100%; max-width: 25%;">
					<?php
					if ( $settings[ 'item_metadata' ] )
						foreach ( $settings[ 'item_metadata' ] as $meta) {
							?>
							<option selected value="<?php echo $meta; ?>"> <?php echo $meta; ?></option>
						<?php } ?>
				</select>
				
			</div>
		</div>
		
	</div>

	<div class="clearfix"></div>
	<br>
	<div class="my-block">
		<span id='adjust-fields-btn' class="my-hide-next "><?php _e( 'Set up fields to export', 'woo-order-export-lite' ) ?>
			<span class="ui-icon ui-icon-triangle-1-s my-icon-triangle"></span></span>
		<div id="manage_fields" style="display: none;">
			<br>
			<div id='fields_control' style='display:none'>
				<div class='div_meta' style='display:none'>
					<label style="width: 40%;"><?php _e( 'Meta key', 'woo-order-export-lite' ) ?>:
					<select id='select_custom_meta_order'>
							<?php
							foreach ( $order_custom_meta_fields as $meta_id => $meta_name ) {
								echo "<option value='$meta_name' >$meta_name</option>";
							};
							?>
						</select></label>
					<label style="width: 40%;"><?php _e( 'Column name', 'woo-order-export-lite' ) ?>:<input type='text' id='colname_custom_meta'/></label>

					<div id="custom_meta_order_mode">
						<label style="width: 40%;"><input style="width: 80%;" type='text' id='text_custom_meta_order' placeholder="<?php _e('or type meta key here', 'woo-order-export-lite') ?>"/><br></label>
						<label><input id="custom_meta_order_mode_used" type="checkbox" name="custom_meta_order_mode" value="used"> <?php _e('Hide unused fields', 'woo-order-export-lite') ?></label>
					</div>
					<div style="text-align: right;">
						<button  id='button_custom_meta' class='button-secondary'><?php _e( 'Confirm', 'woo-order-export-lite' ) ?></button>
						<button  class='button-secondary button_cancel'><?php _e( 'Cancel', 'woo-order-export-lite' ) ?></button>
					</div>
				</div>
				<div class='div_custom' style='display:none;'>
					<label style="width: 40%;"><?php _e( 'Column name', 'woo-order-export-lite' ) ?>:<input type='text' id='colname_custom_field'/></label>
					<label style="width: 40%;"><?php _e( 'Value', 'woo-order-export-lite' ) ?>:<input type='text' id='value_custom_field'/></label>
					<div style="text-align: right;">
						<button  id='button_custom_field' class='button-secondary'><?php _e( 'Confirm', 'woo-order-export-lite' ) ?></button>
						<button   class='button-secondary button_cancel'><?php _e( 'Cancel', 'woo-order-export-lite' ) ?></button>
					</div>
				</div>
				<div class='div1'><span><strong><?php _e( 'Use sections', 'woo-order-export-lite' ) ?>:</strong></span> <?php
					foreach ( WC_Order_Export_Data_Extractor_UI::get_order_segments() as $section_id => $section_name ) {
						echo "<label ><input type=checkbox value=$section_id checked class='field_section'>$section_name &nbsp;</label>";
					}
					?>
				</div>
				<div class='div2'>
					<span><strong><?php _e( 'Actions', 'woo-order-export-lite' ) ?>:</strong></span>
					<button  id='orders_add_custom_meta' class='button-secondary'><?php _e( 'Add field', 'woo-order-export-lite' ) ?></button>
					<br><br>
					<button  id='orders_add_custom_field' class='button-secondary'><?php _e( 'Add static field', 'woo-order-export-lite' ) ?></button>
                    <br><br>
                    <button id='hide_unchecked' class='button button-secondary'>
                        <div style="padding:0px;"><?php _e( 'Hide unused fields', 'woo-order-export-lite' ) ?></div>
                        <div style="padding:0px;display:none"><?php _e( 'Show unused fields', 'woo-order-export-lite' ) ?></div>
                    </button>
				</div>
			</div>
			<div id='fields' style='display:none;'>
				<br>
				<div class="mapping_col_2">
					<label style="margin-left: 3px;">
						<input type="checkbox" name="orders_all"> <?php _e( 'Select all', 'woo-order-export-lite' ) ?></label>
				</div>
				<label class="mapping_col_3" style="color: red; font-size: medium;">
					<?php _e( 'Drag rows to reorder exported fields', 'woo-order-export-lite' ) ?>
				</label>
				<br>
				<ul id="order_fields"></ul>

			</div>
			<div id="modal_content" style="display: none;"></div>
		</div>

	</div>
     <?php do_action("woe_settings_above_buttons", $settings); ?>
	<div id=JS_error_onload style='color:red;font-size: 120%;'><?php echo sprintf(__( "If you see this message after page load, user interface won't work correctly!<br>There is a JS error (<a target=blank href='%s'>read here</a> how to view it). Probably, it's a conflict with another plugin or active theme.", 'woo-order-export-lite' ) , "https://codex.wordpress.org/Using_Your_Browser_to_Diagnose_JavaScript_Errors#Step_3:_Diagnosis"); ?></div>
	<p class="submit">
		<input type="submit" id='preview-btn' class="button-secondary preview-btn"  data-limit="<?php echo ($mode === WC_Order_Export_Manage::EXPORT_ORDER_ACTION ? 1 : 5); ?>" value="<?php _e( 'Preview', 'woo-order-export-lite' ) ?>" title="<?php _e( 'Might be different from actual export!', 'woo-order-export-lite' ) ?>" />
		<input type="submit" id='save-btn' class="button-primary" value="<?php _e( 'Save settings', 'woo-order-export-lite' ) ?>" />
		<?php if ( $show[ 'export_button' ] ) { ?>
			<input type="submit" id='export-btn' class="button-secondary" value="<?php _e( 'Export', 'woo-order-export-lite' ) ?>" />
		<?php } ?>
		<?php if ( $show[ 'export_button_plain' ] ) { ?>
			<input type="submit" id='export-wo-pb-btn' class="button-secondary" value="<?php _e( 'Export [w/o progressbar]', 'woo-order-export-lite' ) ?>" title="<?php _e( 'It might not work for huge datasets!', 'woo-order-export-lite' ) ?>"/>
		<?php } ?>
		<?php if ( $mode === WC_Order_Export_Manage::EXPORT_NOW && $WC_Order_Export::is_full_version() ): ?>
            <input type="submit" id='copy-to-profiles' class="button-secondary" value="<?php _e( 'Save as a profile', 'woo-order-export-lite' ) ?>" />
		<?php endif; ?>
		<span id="preview_actions" class="hide">
			<strong id="output_preview_total"><?php echo sprintf( __( 'Export total: %s orders', 'woo-order-export-lite' ), '<span></span>') ?></strong>
			<?php _e( 'Preview size', 'woo-order-export-lite' ); ?>
			<?php foreach( array( 5, 10, 25, 50 ) as $n ): ?>
				<button class="button-secondary preview-btn" data-limit="<?php echo $n; ?>"><?php echo $n; ?></button>
			<?php endforeach ?>
		</span>
	</p>
	<?php if ( $show[ 'export_button' ] OR $show[ 'export_button_plain' ] ) { ?>
		<div id="progress_div" style="display: none;">
			<h1 class="title-cancel"><?php _e( "Press 'Esc' to cancel the export", 'woo-order-export-lite' ) ?></h1>
			<h1 class="title-download"><a target=_blank><?php _e( "Click here to download", 'woo-order-export-lite' ) ?></a></h1>
			<div id="progressBar"><div></div></div>
		</div>
		<div id="background"></div>
	<?php } ?>

</form>
<textarea rows=10 id='output_preview' style="overflow: auto;" wrap='off'></textarea>
<div id='output_preview_csv' style="overflow: auto;width:100%"></div>

<iframe id='export_new_window_frame' width=0 height=0 style='display:none'></iframe>

<form id='export_wo_pb_form' method='post' target='export_wo_pb_window'>
	<input name="action" type="hidden" value="order_exporter">
	<input name="method" type="hidden" value="plain_export">
	<input name="mode" type="hidden" value="<?php echo $mode ?>">
	<input name="id" type="hidden" value="<?php echo $id ?>">
	<input name="json" type="hidden">
</form>