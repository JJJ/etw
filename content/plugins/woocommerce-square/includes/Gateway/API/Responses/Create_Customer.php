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

namespace WooCommerce\Square\Gateway\API\Responses;

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;

/**
 * Customer create response.
 *
 * @since 2.0.0
 *
 * @method \SquareConnect\Model\CreateCustomerResponse get_data()
 */
class Create_Customer extends \WooCommerce\Square\Gateway\API\Response implements Framework\SV_WC_Payment_Gateway_API_Customer_Response {


	/**
	 * Gets the new customer ID.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_customer_id() {

		return $this->get_data() instanceof \SquareConnect\Model\CreateCustomerResponse ? $this->get_data()->getCustomer()->getId() : '';
	}


}
