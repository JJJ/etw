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
 * The Charge API response object.
 *
 * @since 2.0.0
 *
 * @method \SquareConnect\Model\ChargeResponse get_data()
 */
class Charge extends \WooCommerce\Square\Gateway\API\Response implements Framework\SV_WC_Payment_Gateway_API_Authorization_Response {


	/**
	 * Determines if the charge was held.
	 *
	 * @since 2.0.0
	 *
	 * @return bool
	 */
	public function transaction_held() {

		$held = parent::transaction_held();

		// ensure the tender is CAPTURED
		if ( $this->get_tender() ) {
			$held = 'AUTHORIZED' === $this->get_tender()->getCardDetails()->getStatus();
		}

		return $held;
	}


	/** Getter methods ************************************************************************************************/


	/**
	 * Gets the authorization code.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_authorization_code() {

		return $this->get_tender() ? $this->get_tender()->getId() : '';
	}


	/**
	 * Gets the transaction ID.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_transaction_id() {

		return $this->get_transaction() ? $this->get_transaction()->getId() : '';
	}


	/**
	 * Gets the location ID.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_location_id() {

		return $this->get_transaction() ? $this->get_transaction()->getLocationId() : '';
	}


	/**
	 * Gets the Square order ID, if any.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_square_order_id() {

		return $this->get_transaction() ? $this->get_transaction()->getOrderId() : '';
	}


	/**
	 * Gets the Square tender (auth) object.
	 *
	 * @since 2.0.0
	 *
	 * @return \SquareConnect\Model\Tender|null
	 */
	public function get_tender() {

		return $this->get_transaction() ? current( $this->get_transaction()->getTenders() ) : null;
	}


	/**
	 * Gets the Square transaction object.
	 *
	 * @since 2.0.0
	 *
	 * @return \SquareConnect\Model\Transaction|null
	 */
	public function get_transaction() {

		return ! $this->has_errors() && $this->get_data()->getTransaction() ? $this->get_data()->getTransaction() : null;
	}


	/**
	 * Gets the message to display to the user.
	 *
	 * @since 2.0.0
	 *
	 * @return string
	 */
	public function get_user_message() {

		$message_id = '';

		switch ( $this->get_status_code() ) {

			case 'CARD_DECLINED':
				$message_id = 'card_declined';
			break;

			case 'INVALID_EXPIRATION':
				$message_id = 'card_expiry_invalid';
			break;

			case 'VERIFY_AVS_FAILURE':
				$message_id = 'avs_mismatch';
			break;

			case 'VERIFY_CVV_FAILURE':
				$message_id = 'csc_mismatch';
			break;
		}

		$helper = new Framework\SV_WC_Payment_Gateway_API_Response_Message_Helper();

		return $helper->get_user_message( $message_id );
	}


	/** No-op methods *************************************************************************************************/


	public function get_avs_result() { }

	public function get_csc_result() { }

	public function csc_match() { }


}
