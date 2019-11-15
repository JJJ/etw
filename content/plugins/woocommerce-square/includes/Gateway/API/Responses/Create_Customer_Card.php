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
 * Create customer response class.
 *
 * @since 2.0.0
 *
 * @method \SquareConnect\Model\CreateCustomerCardResponse get_data()
 */
class Create_Customer_Card extends \WooCommerce\Square\Gateway\API\Response implements Framework\SV_WC_Payment_Gateway_API_Create_Payment_Token_Response {


	/**
	 * Gets the created payment token.
	 *
	 * @since 2.0.0
	 *
	 * @return Framework\SV_WC_Payment_Gateway_Payment_Token|null
	 */
	public function get_payment_token() {

		$card = $this->get_data() instanceof \SquareConnect\Model\CreateCustomerCardResponse ? $this->get_data()->getCard() : null;
		$token = null;

		if ( $card ) {

			$card_type = 'AMERICAN_EXPRESS' === $card->getCardBrand() ? Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_AMEX : $card->getCardBrand();

			$token = new Framework\SV_WC_Payment_Gateway_Payment_Token(
				$card->getId(),
				[
					'type'      => 'credit_card',
					'card_type' => $card_type,
					'last_four' => $card->getLast4(),
					'exp_month' => $card->getExpMonth(),
					'exp_year'  => $card->getExpYear(),
				]
			);
		}

		return $token;
	}


}
