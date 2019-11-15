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

namespace WooCommerce\Square\Gateway;

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

class Card_Handler extends Framework\SV_WC_Payment_Gateway_Payment_Tokens_Handler {


	/**
	 * Determines if a token should be deleted locally after a failed API attempt.
	 *
	 * Checks the response code, and if Square indicates the card ID was not found then it's probably safe to delete.
	 *
	 * @since 2.0.0
	 *
	 * @param Framework\SV_WC_Payment_Gateway_Payment_Token $token
	 * @param Framework\SV_WC_Payment_Gateway_API_Response $response
	 * @return bool
	 */
	public function should_delete_token( Framework\SV_WC_Payment_Gateway_Payment_Token $token, Framework\SV_WC_Payment_Gateway_API_Response $response ) {

		return 'NOT_FOUND' === $response->get_status_code();
	}


}
