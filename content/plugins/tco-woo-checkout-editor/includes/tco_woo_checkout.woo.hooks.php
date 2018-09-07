<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Tco_Woo_Hooks' ) ) {

    /**
	 * TcoWooCheckout WooCommerce Hooks class
     *
	 * Checkout Field Hooks for WooCommerce.
     *
	 * @package TcoWooCheckout
	 * @since 1.0.0
	 */
    class Tco_Woo_Hooks{

        /**
         * The single instance of the class
         *
         * @since 1.0.0
         */
        protected static $_instance = null;


        /**
         * Get the instance
         *
         * @since 1.0.0
         */
        public static function instance() {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }


        public function __construct() {
            //User Filters
            $this->add_filter('billing');
            $this->add_filter('shipping');
            //Add other fields
            add_filter( 'woocommerce_checkout_fields', array(__CLASS__, 'other_fields'), 99, 1 );

            //Admin Filters
            add_filter( 'woocommerce_admin_billing_fields',  array(__CLASS__, 'admin_billing_fields'), 100, 1 );
            add_filter( 'woocommerce_admin_shipping_fields', array(__CLASS__, 'admin_shipping_fields'), 100, 1 );

            //Admin order filters
            add_filter( 'woocommerce_order_formatted_billing_address', array(__CLASS__, 'order_formatted_billing_address'), 10, 2 );
            add_filter( 'woocommerce_order_formatted_shipping_address', array(__CLASS__, 'order_formatted_shipping_address'), 10, 2 );

            //Admin order actions
            add_action( 'woocommerce_order_details_after_order_table', array( __CLASS__, 'other_info_table' ), 10, 1 );

            // Custom address format.
            add_filter( 'woocommerce_localisation_address_formats', array(__CLASS__,'localisation_address_formats'), 100, 1 );
            add_filter( 'woocommerce_formatted_address_replacements', array(__CLASS__,'formatted_address_replacements'), 10, 2 );

            //Our custom checkout field type
            add_filter( "woocommerce_form_field_tco_woofile", array(__CLASS__,'add_file_type'), 10, 4 );
            add_filter( 'woocommerce_form_field_tco_woomultiselect', array(__CLASS__, 'add_multiselect_type' ), 10, 4 );

            //Add Other Fields to Email
            add_action( 'woocommerce_email_after_order_table', array(__CLASS__,'email_other_fields_list'), 10, 4 );

            //Add Additional Fields to order meta
            add_action( 'woocommerce_checkout_update_order_meta', array(__CLASS__,'add_other_fields_meta'), 10, 2 );


            // validate fields
		    add_action( 'woocommerce_after_checkout_validation', array(__CLASS__, 'validate_fields' ), 10, 1 );

            //Conditional Script after checkout form
            add_action( 'woocommerce_after_checkout_form', array(__CLASS__, 'conditional_validation' ), 10, 1 );
        }

        /**
         * Remove Woocommerce Filters
         *
         * @since 1.0.0
         * @param String $type
         * @return void
         */
        static function remove_filter($type){
            remove_filter( 'woocommerce_' . $type . '_fields', array(__CLASS__, $type .'_fields'), 100 );
        }

        /**
         * Add Woocommerce Filters
         *
         * @since 1.0.0
         * @param String $type
         * @return void
         */
        static function add_filter($type){
            add_filter( 'woocommerce_' . $type . '_fields', array(__CLASS__, $type .'_fields'), 100, 1 );
        }

        /**
         * Load our billing fields for the user checkout page
         *
         * @since 1.0.0
         * @param array $old
         * @return array
         */
        static function billing_fields($old){
            $new = Tco_Woo_Functions::checkout_fields('billing',false);
            if( empty( $new ) ) {
                return $old;
            }
            // remove disabled
            foreach( $new as $key => &$value ){
                if( isset( $value['enabled'] ) && ! $value['enabled'] ) {
                    unset( $new[$key] );
                }
            }

            return $new;
        }


        /**
         * Load our shipping fields for the user checkout page
         *
         * @since 1.0.0
         * @param array $old
         * @return array
         */
        static function shipping_fields($old){
            $new = Tco_Woo_Functions::checkout_fields('shipping',false);
            if( empty( $new ) ) {
                return $old;
            }
            // remove disabled
            foreach( $new as $key => &$value ){
                if( isset( $value['enabled'] ) && ! $value['enabled'] ) {
                    unset( $new[$key] );
                }
            }

            return $new;
        }

        /**
         * Load our other fields for the user checkout page
         *
         * @since 1.0.0
         * @param array $fields
         * @return array
         */
        static function other_fields($fields){
            $new = Tco_Woo_Functions::checkout_fields('other',false);

            if ( empty( $new )) {
                return $fields;
            }
            // remove disabled
            foreach ( $new as $key => &$value ) {
                if ( isset( $value['enabled'] ) && ! $value['enabled'] ) {
                    unset( $new[ $key ] );
                }
            }

            $fields['order'] = $new;

            $fields = self::conditional_fields($fields);

            return $fields;
        }

        /**
         * Load our billing fields for the admin section
         *
         * @since 1.0.0
         * @param array $old
         * @return array
         */
        static function admin_billing_fields($old){
            $fields = Tco_Woo_Functions::checkout_fields('billing', false);

            if( ! is_array( $fields ) || empty( $fields ) ) {
                return $old;
            }
            return Tco_Woo_Functions::admin_order_filter( $fields, $old, 'billing' );
        }

        /**
         * Load our shipping fields for the admin section
         *
         * @since 1.0.0
         * @param array $old
         * @return array
         */
        static function admin_shipping_fields($old){
            $fields = Tco_Woo_Functions::checkout_fields('shipping', false);

            if( ! is_array( $fields ) || empty( $fields ) ) {
                return $old;
            }
            return Tco_Woo_Functions::admin_order_filter( $fields, $old, 'shipping' );
        }


        /**
         * Adds field to formatted billing address for order's view
         *
         * @since 1.0.0
         * @param array $billing_fields - Default billing fields
         * @param \WC_Order Order object
         * @return array
         */
        static function order_formatted_billing_address($billing_fields, $order){

            $custom_fields = Tco_Woo_Functions::order_fields( 'billing' );
            if( empty( $custom_fields ) ) {
                return $billing_fields;
            }

            foreach( $custom_fields as $custom_field ) {
                $billing_fields[ $custom_field ] = get_post_meta( $order->id, '_billing_' . $custom_field, true );
            }

            return $billing_fields;
        }

        /**
         * Adds field to formatted shipping address for order's view
         *
         * @since 1.0.0
         * @param array $shipping_fields - Default shipping fields
         * @param \WC_Order Order object
         * @return array
         */
        static function order_formatted_shipping_address($shipping_fields, $order){
            $custom_fields = Tco_Woo_Functions::order_fields( 'shipping' );
            if( empty( $custom_fields ) ) {
                return $shipping_fields;
            }

            foreach( $custom_fields as $custom_field ) {
                $shipping_fields[ $custom_field ] = get_post_meta( $order->id, '_shipping_' . $custom_field, true );
            }

            return $shipping_fields;
        }


        /**
		 * Add additional field table on view order
		 *
		 * @param object $order
         *
         * @since 1.0.0
		 */
        static function other_info_table($order){
            $fields = Tco_Woo_Functions::order_fields( 'other' );

			// build template content
			$content = array();
			foreach ( $fields as $key => $field ) {
				// check if value exists for order
				$value = get_post_meta( $order->id, $key, true );
                $content[$key] = array(
                    'label' => isset($field['label']) ? $field['label'] : '',
                    'value' => $value
                );
			}

			if( empty( $content ) ) {
				return;
			}

			wc_get_template( 'other-fields.php', array( 'fields' => $content ), '', TCOW_PLUGIN_DIR . '/templates/' );
        }

        /**
	     * Update address formats
	     *
	     * @param $formats array Array of available formats, indexed for nation code
	     * @return array Filtered array of available formats
         *
	     * @since 1.0.0
	     */
        static function localisation_address_formats($formats){
            $new_replacement = Tco_Woo_Functions::localisation_address_formats( 'all' , false ,true);

		    foreach ( $formats as $country => &$value ) {
			    $value .= $new_replacement;
		    }

		    return $formats;
        }

        /**
	     * Update address replacement
	     *
	     *
	     * @param $replacements array Array of available replacements
	     * @param $args array Array of arguments to use in replacements
	     *
	     * @return array Filtered array of replacements
         *
	     * @since 1.0.0
	     */
        static function formatted_address_replacements($replacements, $args){
            $custom_fields = Tco_Woo_Functions::localisation_address_formats( 'all', true);

            if( empty( $custom_fields ) ) {
                return $replacements;
            }

            foreach ( $custom_fields as $value ) {
                if(isset( $args[$value] )){
                    $field = $args[$value];
                    if (filter_var($field, FILTER_VALIDATE_URL)) {
                        //Call out filter
                        add_filter( "esc_html", array(__CLASS__,'esc_html'));
                    }else{
                        remove_filter( 'esc_html', array(__CLASS__, 'esc_html'));
                    }
                    $replacements['{'.$value.'}'] = $field;
                }else{
                    $replacements['{'.$value.'}'] = '';
                }
            }

            return $replacements;
        }



        /**
	     * Add our custom form field type
	     *
	     *
	     * @param $field String - Field name
         * @param $key String
         * @param $args array
	     * @param $value String - Field value
	     *
	     * @return array Filtered array of replacements
         *
	     * @since 1.0.0
	     */
        static function add_file_type($field = '', $key, $args, $value){
            $upload_name = ( !empty($args['placeholder'] ) ? esc_attr( $args['placeholder'] ) : __( 'Upload Files', 'tco_woo_checkout' ) );
            if( ( !empty( $args['clear'] ) ) ) {
                $after = '<div class="clear"></div>';
            } else {
                $after = '';
            }


            if( $args['required'] ) {
                $args['class'][] = 'validate-required';
                $required = ' <abbr class="required" title="' . esc_attr__( 'required', 'tco_woo_checkout'  ) . '">*</abbr>';
            } else {
                $required = '';
            }


            if( !empty( $args['validate'] ) ) {
                foreach( $args['validate'] as $validate ) {
                    $args['class'][] = 'validate-' . $validate;
                }
            }

            $field = '<p class="form-row ' . esc_attr( implode( ' ', $args['class'] ) ) .'" id="' . esc_attr( $args['id'] ) . '_field">';

            if( $args['label'] ) {
                $field .= '<label for="' . esc_attr( $args['id'] ) . '" class="' . esc_attr( implode( ' ', $args['label_class'] ) ) .'">' . $args['label'] . $required . '</label>';
            }

            $field .= '
                      <input type="hidden" name="' . esc_attr( $key ) . '" id="' . esc_attr( $key ) . '_file" value="" />
                      <input type="hidden" id="' . esc_attr( $key ) . '_secret" value="'.wp_create_nonce( "tco_woo_file_upload" ).'"/>
                      <input style="display:none;" type="file" name="' . esc_attr( $key ) . '_file" id="' . esc_attr( $key ) . '" />
                      <button type="button" class="button tco_woo_file_upload start">'.$upload_name.'</button>
                      <img id="' . esc_attr( $key ) . '_loading" style="display:none;"/>
                      <span style="display:none;" id="' . esc_attr( $key ) . '_ok">&nbsp;&nbsp;&nbsp;DONE!</span>
					  ';

	        $field .= '</p>' . $after;

	        return $field;
        }

        /**
	     * Add our custom form multiselect field type
	     *
	     *
	     * @param $field String - Field name
         * @param $key String
         * @param $args array
	     * @param $value String - Field value
	     *
	     * @return array Filtered array of replacements
         *
	     * @since 1.0.0
	     */
        static function add_multiselect_type($field = '', $key, $args, $value){
            $required = $args['required'] ? ' <abbr class="required" title="' . esc_attr__( 'required', 'tco_woo_checkout'  ) . '">*</abbr>' : '';
            // get value as array
			$value = $value ? explode( ', ', $value ) : array();

			ob_start();
			?>

			<label for="<?php esc_attr( $args['id'] ) ?>" class="<?php echo esc_attr( implode( ' ', $args['label_class'] ) ) ?>">
				<?php echo esc_html( $args['label'] ) . $required ?>
			</label>
			<select name="<?php echo esc_attr( $key ) ?>[]" id="<?php echo esc_attr( $args['id'] ) ?>" class="tco_woo_checkout-multiselect-tco_woomultiselect" multiple="multiple" data-placeholder="<?php echo esc_attr( $args['placeholder'] )?>">
				<?php foreach( $args['options'] as $key => $option ) : ?>
					<option value="<?php echo $key ?>" <?php echo in_array( $key, $value ) ? 'selected=selected' : ''; ?>><?php echo $option ?></option>
				<?php endforeach; ?>
			</select>

			<?php
			$field = ob_get_clean();

            // set id
			$container_id = esc_attr( $args['id'] ) . '_field';
			// set class
			$container_class = ! empty( $args['class'] ) ? 'form-row ' . esc_attr( implode( ' ', $args['class'] ) ) : '';
			// set clear
			$after = ! empty( $args['clear'] ) ? '<div class="clear"></div>' : '';

			return '<p class="'.$container_class.'" id="'.$container_id.'">' . $field . '</p>' . $after;
        }

        /**
	     * Overide the current filter on WordPress so we can get our link to work
	     *
	     *
	     * @param $field String - url
	     * @return String
         *
	     * @since 1.0.0
	     */
        static function esc_html($text){
            if (filter_var($text, FILTER_VALIDATE_URL)) {
                $file_name = basename($text);
                return "<a href='$text' rel='noopener noreferrer' target='_blank'>$file_name</a>";
            }else{
                $safe_text = wp_check_invalid_utf8( $text );
	            $safe_text = _wp_specialchars( $safe_text, ENT_QUOTES );
                return $safe_text;
            }
        }

        /**
	     * Add the other fields list to order email
	     *
	     * @param object $order
	     * @param boolean $sent_to_admin
	     * @param boolean $plain_text
	     * @param $email
         *
         * @since 1.0.0
	     */
        static function email_other_fields_list($order, $sent_to_admin, $plain_text, $email){
            $fields = Tco_Woo_Functions::checkout_fields('other',false);

            // build template content
            $content = array();
            foreach ( $fields as $key => $field ) {
                // check if value exists for order
                $value = get_post_meta( $order->id, $key, true );
                $content[$key] = array(
                    'label' => $field['label'],
                    'value' => $value
                );
            }

            if( empty( $content ) ) {
                return;
            }

            if( $plain_text ){
                wc_get_template( 'additional_plain.php', array( 'fields' => $content ), '', TCOW_PLUGIN_DIR . '/templates/mail/' );
            }
            else {
                wc_get_template( 'additional.php', array( 'fields' => $content ), '', TCOW_PLUGIN_DIR . '/templates/mail/' );
            }
        }

        /**
	     * Order meta for other fields
	     *
	     * @param int $order_id
	     * @param array $posted
         *
         * @since 1.0.0
	     */
        static function add_other_fields_meta($order_id, $posted){
            // get additional fields key
            $fields = Tco_Woo_Functions::checkout_fields('other',false);
            $default_keys = Tco_Woo_Functions::default_woocommerce_checkout_fields( 'other' );

            foreach ( $fields as $key => $field ) {
                if( in_array( $key, $default_keys ) || empty( $posted[$key] ) ){
                    continue;
                }
                update_post_meta( $order_id, $key, $posted[$key] );
            }
        }

        /**
		 * Custom validation for fields
		 *
		 * @param  array $posted Array of posted params
         *
         * @since 1.0.0
		 */
        static function validate_fields($posted){
            $checkout_fields = WC()->checkout->checkout_fields;
            foreach ( $checkout_fields as $fieldset_key => $fieldset ) {
                foreach ( $fieldset as $key => $field ) {
                    if ( ! empty( $posted[ $key ] ) ) {
                        if ( ! empty( $field['validate'] ) && is_array( $field['validate'] ) && !empty($field['regex']) ) {
                            foreach ( $field['validate'] as $rule ) {
                                switch ( $rule ) {
                                    case 'custom' :
                                        if(!empty($field['regex'])){
                                            $regex = $field['regex'];

                                            $error = false;
                                            $res = preg_match( $regex, $posted[ $key ] );
                                            if( ! $res || $res == 0 ) {
                                                $error = true;
                                            }
                                            if( $error ) {
                                                wc_add_notice( __( 'The value you have entered seems to be wrong. Please, check it.', 'tco_woo_checkout' ), 'error' );
                                            }
                                        }
                                    break;
                                    default :
										if( $rule )
											do_action( 'tco_woo_checkout_validation_field_' . $rule, $posted );
										break;
                                }
                            }
                        }
                    }
                }
            }
        }


        /**
         * Conditional Fields afte the form
         *
         * @param Object $checkout - The checkout object
         *
         * @since 1.0.0
         *
         * @return String
         */
        static function conditional_validation($checkout){
            global $tco_woo_woo_checkout;
            $script_string = '';
            $checkout_fields = $checkout->checkout_fields;
            foreach ( $checkout_fields as $fieldset_key => $fieldset ) {
                foreach ( $fieldset as $key => $field ) {
                    if ( ! empty( $field['conditional'] ) && $field['conditional']) {
                        $conditional_fields = $field['conditional_fields'];
                        if(!empty($conditional_fields) && !empty($field['conditional_value'])){
                            $field_js_array = ' var string_fields = "'.$conditional_fields.'";
                                                var conditional_fields = string_fields.split(",");
                                                ';
                            $action = '';
                            if(in_array($field['type'], $tco_woo_woo_checkout->multiselect_fields )){
                                $action = 'change';
                            }else if(in_array($field['type'], $tco_woo_woo_checkout->click_fields )){
                                $action = 'click';
                            }else if(in_array($field['type'], $tco_woo_woo_checkout->text_fields )){
                                $action = 'input';

                            }
                            if(!empty($action)){
                                $script_string .= $field_js_array;
                                $script_string .= '
                                    jQuery(document).on("'.$action.'", "#'.$key.'", function(e) {
                                        if(jQuery(this).val() === "'.$field['conditional_value'].'"){
                                            jQuery.each(conditional_fields, function(index, item) {
                                                jQuery("#"+item).parent().show();
                                            });
                                        }else{
                                            jQuery.each(conditional_fields, function(index, item) {
                                                jQuery("#"+item).parent().hide();
                                            });
                                        }
                                    });
                                    jQuery.each(conditional_fields, function(index, item) {
                                        jQuery("#"+item).parent().hide();
                                    });

                                ';
                            }
                        }
                    }
                    if ( ! empty( $field['validate'] ) && is_array( $field['validate'] )  && ! empty( $field['validation_field'] )) {
                        foreach ( $field['validate'] as $rule ) {
                            switch ( $rule ) {
                                case 'custom' :
                                    if(! empty( $field['validation_field'] )){
                                        $parent_field_id = $field['validation_field'];
                                        $script_string .= '
                                            jQuery(document).on("input blur change", "#'.$key.'", function(e) {
                                                if(jQuery(this).val() === jQuery("#'.$parent_field_id.'").val()){
                                                    jQuery(this).parent().removeClass("woocommerce-invalid").addClass("woocommerce-validated");
                                                }else{
                                                    jQuery(this).parent().removeClass("woocommerce-validated").addClass("woocommerce-invalid");
                                                    jQuery(this).focus();
                                                }
                                            });
                                        ';
                                    }
                                    break;
                            }
                        }
                    }
                }
            }
            if(!empty($script_string)){
                ?>
                <script type="text/javascript">
                jQuery(document).ready(function() {
                    <?php echo $script_string; ?>
                });
                </script>
                <?php
            }
        }


        /**
         * Conditionally remove a checkout field based on products in the cart
         *
         * @param Array $fields - The fields
         *
         * @since 1.0.0
         *
         * @return Array $fields
         */
        static function conditional_fields($fields){
            $cart = WC()->cart->get_cart(); //Get the cart

            // Products currently in the cart
            $cart_ids = array();

            // Find each product in the cart and add it to the $cart_ids array
            foreach( $cart as $cart_item_key => $cart_item ) {
                $cart_ids[]   = $product_id  = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
            }


            foreach ( $fields as $key => $value ) {
                foreach ( $value as $k => $field) {
                    if ( ! empty( $field['conditional'] ) && $field['conditional']) {
                        $condition = $field['products_condition']; // Is And/OR

                        //Check if its to be in cart or not in cart
                        $first_condition = "";
                        $second_condition = "";

                        $first_condition_product_ids = array();
                        if ( ! empty( $field['product_fields'] ) && isset( $field['product_fields'] )) {
                            $first_condition_product_ids = $field['product_fields'];
                            $first_condition_product_ids = explode(",", $first_condition_product_ids);
                            $first_condition = $field['product_fields_validation'];
                        }

                        $second_condition_product_ids = array();
                        if ( ! empty( $field['product_fields_second'] ) && isset( $field['product_fields_second'] )) {
                            $second_condition_product_ids = $field['product_fields_second'];
                            $second_condition_product_ids = explode(",", $second_condition_product_ids);
                            $second_condition = $field['product_fields_validation_second'];
                        }

                        if($condition === 'and'){
                            if(!empty($first_condition_product_ids) && !empty($second_condition_product_ids)){
                                if((!$first_condition && !$second_condition) || ($first_condition && !$second_condition) || (!$first_condition && $second_condition)){
                                    $products_found = count(array_intersect($first_condition_product_ids, $cart_ids)) == count($first_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                    $products_found = count(array_intersect($second_condition_product_ids, $cart_ids)) == count($second_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                }
                            }else if(!empty($first_condition_product_ids)){
                                if(!$first_condition){
                                    //Cart does not contain field
                                    $products_found = count(array_intersect($first_condition_product_ids, $cart_ids)) == count($first_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                }
                            }else if(!empty($second_condition_product_ids)){
                                if(!$second_condition){
                                    //Cart does not contain field
                                    $products_found = count(array_intersect($second_condition_product_ids, $cart_ids)) == count($second_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                }
                            }
                        }else{
                            if(!empty($first_condition_product_ids) && !empty($second_condition_product_ids)){
                                if((!$first_condition || !$second_condition) || ($first_condition || !$second_condition) || (!$first_condition || $second_condition)){
                                    $products_found = count(array_intersect($first_condition_product_ids, $cart_ids)) == count($first_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                    $products_found = count(array_intersect($second_condition_product_ids, $cart_ids)) == count($second_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                }
                            }else if(!empty($first_condition_product_ids)){
                                if(!$first_condition){
                                    //Cart does not contain field
                                    $products_found = count(array_intersect($first_condition_product_ids, $cart_ids)) == count($first_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                }
                            }else if(!empty($second_condition_product_ids)){
                                if(!$second_condition){
                                    //Cart does not contain field
                                    $products_found = count(array_intersect($second_condition_product_ids, $cart_ids)) == count($second_condition_product_ids);
                                    if(!$products_found){
                                        unset($fields[$key][$k]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            return $fields;
        }

    }

    Tco_Woo_Hooks::instance();
}
?>
