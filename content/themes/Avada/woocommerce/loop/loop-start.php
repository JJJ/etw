<?php
/**
 * Product Loop Start
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce_loop, $smof_data;


// Reset according to sidebar or fullwidth pages
if( empty( $woocommerce_loop['columns'] ) ) {
	if( is_shop() || is_product_category() || is_product_tag() ) {

		if( is_shop() ) {
			$woocommerce_loop['columns'] = $smof_data['woocommerce_shop_page_columns'];
		}

		if( is_product_category() || 
			is_product_tag()
		) {
			$woocommerce_loop['columns'] = $smof_data['woocommerce_archive_page_columns'];
			$columns = $smof_data['woocommerce_archive_page_columns'];
		}

	}
}
?>
<ul class="products clearfix products-<?php echo $woocommerce_loop['columns']; ?>">