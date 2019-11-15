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

defined( 'ABSPATH' ) or exit;

use SkyVerge\WooCommerce\PluginFramework\v5_4_0 as Framework;
use SquareConnect\Model as SquareModel;
use WooCommerce\Square\API;

/**
 * The customers API request class.
 *
 * @since 2.0.0
 */
class Customers extends API\Requests\Customers {


	/**
	 * Sets the data for creating a new customer.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function set_create_customer_data( \WC_Order $order ) {

		$this->square_api_method = 'createCustomer';

		// set the customer email as the WP user email, if available
		try {

			if ( ! $order->get_user_id() ) {
				throw new Framework\SV_WC_Plugin_Exception( 'No user account' );
			}

			$customer = new \WC_Customer( $order->get_user_id() );

			$email = $customer->get_email();

		// otherwise, use the order billing email
		} catch ( \Exception $exception ) {

			$email = $order->get_billing_email();
		}

		$customer_request = new SquareModel\CreateCustomerRequest();
		$customer_request->setGivenName( $order->get_billing_first_name() );
		$customer_request->setFamilyName( $order->get_billing_last_name() );
		$customer_request->setCompanyName( $order->get_billing_company() );
		$customer_request->setEmailAddress( $email );
		$customer_request->setPhoneNumber( $order->get_billing_phone() );

		if ( $order->get_user_id() ) {
			$customer_request->setReferenceId( (string) $order->get_user_id() );
		}

		$customer_request->setAddress( $this->get_address_from_order( $order ) );

		$this->square_request = $customer_request;

		$this->square_api_args = [
			$this->square_request,
		];
	}


	/**
	 * Sets the data for creating a new customer card.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 */
	public function set_create_card_data( \WC_Order $order ) {

		$this->square_api_method = 'createCustomerCard';

		$request = new SquareModel\CreateCustomerCardRequest();

		$request->setCardNonce( $order->payment->nonce );
		$request->setBillingAddress( $this->get_address_from_order( $order ) );
		$request->setCardholderName( $order->get_formatted_billing_full_name() );

		$this->square_request = $request;

		$this->square_api_args = [
			$order->customer_id,
			$this->square_request,
		];
	}


	/**
	 * Sets the data for deleting an existing card.
	 *
	 * @since 2.0.0
	 *
	 * @param string $customer_id Square customer ID
	 * @param string $card_id Square card ID
	 */
	public function set_delete_card_data( $customer_id, $card_id ) {

		$this->square_api_method = 'deleteCustomerCard';

		$this->square_api_args = [
			$customer_id,
			$card_id,
		];
	}


	/**
	 * Gets a billing address model from a WC order.
	 *
	 * @since 2.0.0
	 *
	 * @param \WC_Order $order order object
	 * @return SquareModel\Address
	 */
	protected function get_address_from_order( \WC_Order $order ) {

		$address = new SquareModel\Address();
		$address->setFirstName( $order->get_billing_first_name() );
		$address->setLastName( $order->get_billing_last_name() );
		$address->setOrganization( $order->get_billing_company() );
		$address->setAddressLine1( $order->get_billing_address_1() );
		$address->setAddressLine2( $order->get_billing_address_2() );
		$address->setLocality( $order->get_billing_city() );
		$address->setAdministrativeDistrictLevel1( $order->get_billing_state() );
		$address->setPostalCode( $order->get_billing_postcode() );

		if ( $order->get_billing_country() ) {
			$address->setCountry( $order->get_billing_country() );
		}

		return $address;
	}


}
