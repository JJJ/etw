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
 * Get customer response.
 *
 * @since 2.0.0
 *
 * @method \SquareConnect\Model\RetrieveCustomerResponse|array get_data()
 */
class Get_Customer extends \WooCommerce\Square\Gateway\API\Response implements Framework\SV_WC_Payment_Gateway_API_Get_Tokenized_Payment_Methods_Response {


	/**
	 * Returns any payment tokens.
	 *
	 * @since 1.0.0
	 *
	 * @return Framework\SV_WC_Payment_Gateway_Payment_Token[]
	 */
	public function get_payment_tokens() {

		$cards  = $this->get_data() instanceof \SquareConnect\Model\RetrieveCustomerResponse ? $this->get_data()->getCustomer()->getCards() : [];
		$tokens = [];

		if ( is_array( $cards ) ) {

			foreach ( $cards as $card ) {

				$token_id  = $card->getId();
				$card_type = 'AMERICAN_EXPRESS' === $card->getCardBrand() ? Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_AMEX : $card->getCardBrand();

				$tokens[ $token_id ] = new Framework\SV_WC_Payment_Gateway_Payment_Token(
					$token_id,
					[
						'type'      => 'credit_card',
						'card_type' => $card_type,
						'last_four' => $card->getLast4(),
						'exp_month' => $card->getExpMonth(),
						'exp_year'  => $card->getExpYear(),
					]
				);
			}
		}

		return $tokens;
	}


}
