<?php
/**
 * WooCommerce Square
 *
 * This source file is subject to the GNU General Public License v3.0
 * that is bundled with this package in the file license.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.html
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@woocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade WooCommerce Square to newer
 * versions in the future. If you wish to customize WooCommerce Square for your
 * needs please refer to https://docs.woocommerce.com/document/woocommerce-square/
 *
 * @author    WooCommerce
 * @copyright Copyright: (c) 2019, Automattic, Inc.
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */

namespace WooCommerce\Square\Handlers;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

defined( 'ABSPATH' ) or exit;

/**
 * Order handler class.
 *
 * @since 2.0.0
 */
class Order {


	/**
	 * Sets up Square order handler.
	 *
	 * @since 2.0.0
	 */
	public function __construct() {

		// remove Square variation IDs from order item meta
		add_action( 'woocommerce_hidden_order_itemmeta', [ $this, 'hide_square_order_item_meta' ] );
	}


	/**
	 * Ensures the Square order item meta is hidden.
	 *
	 * @since 2.0.0
	 *
	 * @param string[] $hidden the hidden order item meta
	 * @return string[] updated meta
	 */
	public function hide_square_order_item_meta( $hidden ) {

		$hidden[] = '_square_item_variation_id';

		return $hidden;
	}


}
