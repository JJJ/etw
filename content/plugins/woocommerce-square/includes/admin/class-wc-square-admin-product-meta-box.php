<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WC_Square_Admin_Product_Meta_Box
 *
 * Adds product specific sync options via meta box.
 *
 */
class WC_Square_Admin_Product_Meta_Box {
	/**
	 * Constructor
	 *
	 * @version 1.0.9
	 * @since 1.0.9
	 */
	public function __construct() {
		// add a sync field to the product general tab
		add_action( 'woocommerce_product_options_general_product_data', array( $this, 'add_product_sync_checkbox_general' ) );

		// save sync field for the product general tab
		add_action( 'woocommerce_process_product_meta_simple', array( $this, 'save_product_sync_checkbox_general' ) );
		add_action( 'woocommerce_process_product_meta_booking', array( $this, 'save_product_sync_checkbox_general' ) );

		// save sync field for variable product general tab
		add_action( 'woocommerce_process_product_meta_variable', array( $this, 'save_product_sync_checkbox_general' ) );

		// add sync to product bulk edit menu
		add_action( 'woocommerce_product_bulk_edit_end', array( $this, 'add_product_bulk_edit_sync' ) );

		// save sync to product bulk edit
		add_action( 'woocommerce_product_bulk_edit_save', array( $this, 'save_product_bulk_edit_sync' ) );
	}

	/**
	 * Add a sync field to the product general tab
	 *
	 * @access public
	 * @since 1.0.9
	 * @version 1.0.9
	 * @return bool
	 */
	public function add_product_sync_checkbox_general() {
		global $post;

		$sync = get_post_meta( $post->ID, '_wcsquare_disable_sync', true );

		// set default to no if nothing is set
		if ( empty( $sync ) ) {
			$sync = 'no';
		}

		$output = '';

		$output .= '<div class="options_group show_if_simple show_if_variable show_if_booking">' . PHP_EOL;

		$output .= '<p class="form-field wcsquare_product_default_sync_field"><label for="wcsquare_product_default_sync">' . wp_kses_post( __( '(Square) Disable Sync', 'woocommerce-square' ) ) . '</label><input type="checkbox" name="_wcsquare_disable_sync" id="wcsquare_product_default_sync" value="yes" ' . checked( 'yes', $sync, false ) . '/>' . PHP_EOL;

		$output .= '<span class="description">' . wp_kses_post( __( 'Check box to disable this product from syncing.', 'woocommerce-square' ) ) . '</span>' . PHP_EOL;

		$output .= '</p>' . PHP_EOL;

		$output .= '</div>';

		echo $output;

		return true;
	}

	/**
	 * Save the sync field for the product general tab
	 *
	 * @access public
	 * @since 1.0.9
	 * @version 1.0.9
	 * @param int $post_id
	 * @return bool
	 */
	public function save_product_sync_checkbox_general( $post_id ) {
		if ( empty( $post_id ) ) {
			return;
		}

		if ( ! empty( $_POST['_wcsquare_disable_sync'] ) ) {
			update_post_meta( $post_id, '_wcsquare_disable_sync', 'yes' );

		} else {

			update_post_meta( $post_id, '_wcsquare_disable_sync', 'no' );
		}

		return true;
	}

	/**
	 * Add sync setting to product bulk edit menu
	 *
	 * @access public
	 * @since 1.0.9
	 * @version 1.0.9
	 * @return bool
	 */
	public function add_product_bulk_edit_sync() {
	?>
		<label>
			<span class="title"><?php esc_html_e( 'Disable Sync', 'woocommerce-square' ); ?></span>
				<span class="input-text-wrap">
					<select class="square-sync-product" name="_wcsquare_disable_sync">
					<?php
					$options = array(
						''    => __( '— No Change —', 'woocommerce-square' ),
						'yes' => __( 'Yes', 'woocommerce-square' ),
						'no'  => __( 'No', 'woocommerce-square' )
					);
					
					foreach ( $options as $key => $value ) {
						echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
					}
					?>
				</select>
			</span>
		</label>
	<?php
	}

	/**
	 * Save sync setting to product bulk edit
	 *
	 * @access public
	 * @since 1.0.9
	 * @version 1.0.9
	 * @param object $product
	 * @return bool
	 */
	public function save_product_bulk_edit_sync( $product ) {
		if ( empty( $product ) ) {
			return;
		}

		if ( ! empty( $_GET['_wcsquare_disable_sync'] ) && 'yes' === $_GET['_wcsquare_disable_sync'] ) {
			update_post_meta( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->id : $product->get_id(), '_wcsquare_disable_sync', 'yes' );

		} else {
			update_post_meta( version_compare( WC_VERSION, '3.0.0', '<' ) ? $product->id : $product->get_id(), '_wcsquare_disable_sync', 'no' );
		}

		return true;		
	}

}

new WC_Square_Admin_Product_Meta_Box();

