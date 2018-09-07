<?php
if ( ! class_exists( 'WC_Abstract_Privacy' ) ) {
	return;
}

class WC_Square_Privacy extends WC_Abstract_Privacy {
	/**
	 * Constructor
	 *
	 */
	public function __construct() {
		parent::__construct( __( 'Square', 'woocommerce-square' ) );

		$this->add_exporter( 'woocommerce-square-customer-data', __( 'WooCommerce Square Customer Data', 'woocommerce-square' ), array( $this, 'customer_data_exporter' ) );
		$this->add_eraser( 'woocommerce-square-customer-data', __( 'WooCommerce Square Customer Data', 'woocommerce-square' ), array( $this, 'customer_data_eraser' ) );
	}

	/**
	 * Gets the message of the privacy to display.
	 *
	 */
	public function get_message() {
		return wpautop( sprintf( __( 'By using this extension, you may be storing personal data or sharing data with an external service. <a href="%s" target="_blank">Learn more about how this works, including what you may want to include in your privacy policy.</a>', 'woocommerce-square' ), 'https://docs.woocommerce.com/document/privacy-payments/#woocommerce-square' ) );
	}

	/**
	 * Handle exporting data for Orders.
	 *
	 * @param string $email_address E-mail address to export.
	 * @param int    $page          Pagination of data.
	 *
	 * @return array
	 */
	public function order_data_exporter( $email_address, $page = 1 ) {
		$done           = false;
		$data_to_export = array();

		$done = true;

		return array(
			'data' => $data_to_export,
			'done' => $done,
		);
	}

	/**
	 * Finds and exports customer data by email address.
	 *
	 * @since 3.4.0
	 * @param string $email_address The user email address.
	 * @param int    $page  Page.
	 * @return array An array of personal data in name value pairs
	 */
	public function customer_data_exporter( $email_address, $page ) {
		$user           = get_user_by( 'email', $email_address ); // Check if user has an ID in the DB to load stored personal data.
		$data_to_export = array();

		if ( $user instanceof WP_User ) {
			$data_to_export[] = array(
				'group_id'    => 'woocommerce_customer',
				'group_label' => __( 'Customer Data', 'woocommerce-square' ),
				'item_id'     => 'user',
				'data'        => array(
					array(
						'name'  => __( 'Square customer id', 'woocommerce-square' ),
						'value' => get_user_meta( $user->ID, '_square_customer_id', true ),
					),
				),
			);
		}

		return array(
			'data' => $data_to_export,
			'done' => true,
		);
	}

	/**
	 * Finds and erases customer data by email address.
	 *
	 * @since 3.4.0
	 * @param string $email_address The user email address.
	 * @param int    $page  Page.
	 * @return array An array of personal data in name value pairs
	 */
	public function customer_data_eraser( $email_address, $page ) {
		$page = (int) $page;
		$user = get_user_by( 'email', $email_address ); // Check if user has an ID in the DB to load stored personal data.

		$square_customer_id = get_user_meta( $user->ID, '_square_customer_id', true );

		$items_removed  = false;
		$messages       = array();

		if ( ! empty( $square_customer_id ) ) {
			$items_removed = true;
			delete_user_meta( $user->ID, '_square_customer_id' );
			$messages[] = __( 'Square User Data Erased.', 'woocommerce-square' );
		}

		return array(
			'items_removed'  => $items_removed,
			'items_retained' => false,
			'messages'       => $messages,
			'done'           => true,
		);
	}
}

new WC_Square_Privacy();
