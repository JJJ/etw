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

namespace WooCommerce\Square\Gateway\API\Requests;

defined( 'ABSPATH' ) || exit;

use SquareConnect\Api\RefundsApi;
use SquareConnect\Model\RefundPaymentRequest;
use WooCommerce\Square\Utilities\Money_Utility;

/**
 * The Refunds API request class.
 *
 * @since 2.2.0
 */
class Refunds extends \WooCommerce\Square\API\Request {

	/**
	 * Initializes a new refund request.
	 *
	 * @since 2.2.0
	 * @param \SquareConnect\ApiClient $api_client the API client
	 */
	public function __construct( $api_client ) {
		$this->square_api = new RefundsApi( $api_client );
	}


	/**
	 * Sets the data for refund a payment.
	 *
	 * @since 2.2.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function set_refund_data( \WC_Order $order ) {

		$this->square_api_method = 'refundPayment';

		// The refund objects are sorted by date DESC, so the last one created will be at the start of the array
		$refunds    = $order->get_refunds();
		$refund_obj = $refunds[0];

		$this->square_request = new RefundPaymentRequest();
		$this->square_request->setIdempotencyKey( wc_square()->get_idempotency_key( $order->get_id() . ':' . $refund_obj->get_id() ) );
		$this->square_request->setPaymentId( $order->refund->tender_id );
		$this->square_request->setReason( $order->refund->reason );

		$this->square_request->setAmountMoney( Money_Utility::amount_to_money( $order->refund->amount, $order->get_currency() ) );

		$this->square_api_args = array(
			$this->square_request,
		);
	}
}
