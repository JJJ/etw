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

/**
 * The payment form handler.
 *
 * @since 2.0.0
 */
class Payment_Form extends Framework\SV_WC_Payment_Gateway_Payment_Form {


	/**
	 * Renders the payment fields.
	 *
	 * @since 2.0.0
	 */
	public function render_payment_fields() {

		parent::render_payment_fields();

		$fields = [
			'card-type',
			'last-four',
			'exp-month',
			'exp-year',
			'payment-nonce',
			'payment-postcode',
		];

		foreach ( $fields as $field_id ) {
			echo '<input type="hidden" name="wc-' . esc_attr( $this->get_gateway()->get_id_dasherized() ) . '-' . esc_attr( $field_id ) . '" />';
		}

		$postcode = '';

		if ( is_checkout_pay_page() ) {

			if ( $order = wc_get_order( $this->get_gateway()->get_checkout_pay_page_order_id() ) ) {
				$postcode = $order->get_billing_postcode();
			}

		} elseif ( WC()->customer && ! is_checkout() ) {

			$postcode = WC()->customer->get_billing_postcode();
		}

		if ( $postcode ) {
			echo '<input type="hidden" id="billing_postcode" value="' . esc_attr( $postcode ) . '" />';
		}
	}


	/**
	 * Gets the credit card fields.
	 *
	 * Overridden to add special iframe classes.
	 *
	 * @since 2.0.0
	 *
	 * @return array
	 */
	protected function get_credit_card_fields() {

		$fields = parent::get_credit_card_fields();

		// Square JS requires a postal code field for the form, but this is pre-filled and hidden
		$fields['card-postal-code'] = [
			'id'          => 'wc-' . $this->get_gateway()->get_id_dasherized() . '-postal-code',
			'label'       => __( 'Postal code', 'woocommerce-square' ),
			'class'       => [ 'form-row-wide' ],
			'required'    => true,
			'input_class' => [ 'js-sv-wc-payment-gateway-credit-card-form-input', 'js-sv-wc-payment-gateway-credit-card-form-postal-code' ],
		];

		foreach ( [ 'card-number', 'card-expiry', 'card-csc', 'card-postal-code' ] as $field_key ) {

			if ( isset( $fields[ $field_key ] ) ) {

				// parent div classes - contains both the label and hosted field container div
				$fields[ $field_key ]['class'] = array_merge( $fields[ $field_key ]['class'], [ "wc-{$this->get_gateway()->get_id_dasherized()}-{$field_key}-parent", "wc-{$this->get_gateway()->get_id_dasherized()}-hosted-field-parent" ] );

				// hosted field container classes - contains the iframe element
				$fields[ $field_key ]['input_class'] = array_merge( $fields[ $field_key ]['input_class'], [ "wc-{$this->get_gateway()->get_id_dasherized()}-hosted-field-{$field_key}", "wc-{$this->get_gateway()->get_id_dasherized()}-hosted-field" ] );
			}
		}

		return $fields;
	}


	/**
	 * Renders a payment form field.
	 *
	 * @since 2.0.0
	 *
	 * @param array $field field to render
	 */
	public function render_payment_field( $field ) {

		?>
		<div class="form-row <?php echo implode( ' ', array_map( 'sanitize_html_class', $field['class'] ) ); ?>">
			<label for="<?php echo esc_attr( $field['id'] ) . '-hosted'; ?>"><?php echo esc_html( $field['label'] ); if ( $field['required'] ) : ?><abbr class="required" title="required">&nbsp;*</abbr><?php endif; ?></label>
			<div id="<?php echo esc_attr( $field['id'] ) . '-hosted'; ?>" class="<?php echo implode( ' ', array_map( 'sanitize_html_class', $field['input_class'] ) ); ?>" data-placeholder="<?php echo isset( $field['placeholder'] ) ? esc_attr( $field['placeholder'] ) : ''; ?>"></div>
		</div>
		<?php
	}


	/**
	 * Renders the payment form JS.
	 *
	 * @since 2.0.0
	 */
	public function render_js() {

		$args = [
			'id'                      => $this->get_gateway()->get_id(),
			'id_dasherized'           => $this->get_gateway()->get_id_dasherized(),
			'csc_required'            => $this->get_gateway()->csc_enabled(),
			'logging_enabled'         => $this->get_gateway()->debug_log(),
			'general_error'           => __( 'An error occurred, please try again or try an alternate form of payment.', 'woocommerce-square' ),
			'ajax_url'                => admin_url( 'admin-ajax.php' ),
			'ajax_log_nonce'          => wp_create_nonce( 'wc_' . $this->get_gateway()->get_id() . '_log_js_data' ),
			'application_id'          => $this->get_gateway()->get_application_id(),
		];

		// map the unique square card type string to our framework standards
		$square_card_types = [
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_MASTERCARD => 'masterCard',
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_AMEX       => 'americanExpress',
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_DINERSCLUB => 'discoverDiners',
			Framework\SV_WC_Payment_Gateway_Helper::CARD_TYPE_JCB        => 'JCB',
		];

		$card_types = is_array( $this->get_gateway()->get_card_types() ) ? $this->get_gateway()->get_card_types() : [];

		$framework_card_types = array_map( [ Framework\SV_WC_Payment_Gateway_Helper::class, 'normalize_card_type' ], $card_types );
		$square_card_types    = array_merge( array_combine( $framework_card_types, $framework_card_types ), $square_card_types );

		$args['enabled_card_types'] = $framework_card_types;
		$args['square_card_types']  = array_flip( $square_card_types );

		$input_styles = [
			[
				'backgroundColor' => 'transparent',
				'fontSize'        => '1.3em',
			]
		];

		/**
		 * Filters the the Square payment form input styles.
		 *
		 * @since 2.0.0
		 *
		 * @param array $styles array of input styles
		 */
		$args['input_styles'] = (array) apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_input_styles', $input_styles, $this );

		// TODO remove the deprecated hook in a future version
		if ( has_filter( 'woocommerce_square_payment_input_styles' ) ) {

			_deprecated_hook( 'woocommerce_square_payment_input_styles', '2.0.0', null, 'Use "wc_' . $this->get_gateway()->get_id() . '_payment_form_input_styles" as a replacement.' );

			/**
			 * Filters the input styles (legacy filter).
			 *
			 * @since 1.0.0
			 *
			 * @param string $input_styles styles as JSON encoded array
			 */
			$args['input_styles'] = json_decode( (string) apply_filters( 'woocommerce_square_payment_input_styles', wp_json_encode( $args['input_styles'] ) ), true );
		}

		/**
		 * Payment Gateway Payment Form JS Arguments Filter.
		 *
		 * Filter the arguments passed to the Payment Form handler JS class
		 *
		 * @since 3.0.0
		 *
		 * @param array $result {
		 *   @type string $plugin_id plugin ID
		 *   @type string $id gateway ID
		 *   @type string $id_dasherized gateway ID dasherized
		 *   @type string $type gateway payment type (e.g. 'credit-card')
		 *   @type bool $csc_required true if CSC field display is required
		 * }
		 * @param Payment_Form $this payment form instance
		 */
		$args = apply_filters( 'wc_' . $this->get_gateway()->get_id() . '_payment_form_js_args', $args, $this );

		wc_enqueue_js( sprintf( 'window.wc_%s_payment_form_handler = new WC_Square_Payment_Form_Handler( %s );', esc_js( $this->get_gateway()->get_id() ), json_encode( $args ) ) );
	}


}
