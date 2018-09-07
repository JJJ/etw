<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


if ( ! class_exists( 'Tco_Woo_Functions' ) ) {

    /**
	 * TcoWooCheckout WooCommerce Functions class
     *
	 * Holds all functions common to multiple classes
     *
	 * @package TcoWooCheckout
	 * @since 1.0.0
	 */
    class Tco_Woo_Functions{

        /**
         * Return the checkout fields
         *
         * @param String type . The type of fields to return (shipping or billing)
         * @param Boolean clean . Clean the output for out edit table
         * @return Array
         * @since 1.0.0
         */
        static function checkout_fields($type = 'billing', $clean = true){
            $fields = get_option( 'tco_woo_fields_' . $type . '_options', array() );
            if( empty( $fields ) ) {
                $fields = self::default_woocommerce_checkout_fields($type);
            }
            return $clean ?  self::clean_woo_fields($fields) : $fields;
        }

        /**
         * Return the default checkout fields of WooCommerce
         *
         * @param String type . The type of fields to return (shipping or billing)
         * @return Array
         * @since 1.0.0
         */
        static function default_woocommerce_checkout_fields($type = 'billing'){
            if( $type == 'billing' || $type == 'shipping' ) {
                //Remove filters so we dont get a recurring loop
                Tco_Woo_Hooks::remove_filter($type);
                $fields = WC()->countries->get_address_fields( $country = '', $type . '_' );
                //Return the filter for the checkout page
                Tco_Woo_Hooks::add_filter($type);
                return $fields;
            }else{
                return apply_filters( 'tco_woo_default_extra_fields', array(
                    'order_comments' => array(
                        'type'        => 'textarea',
                        'class'       => array('notes'),
                        'label'       => __( 'Order notes', 'tco_woo_checkout' ),
                        'placeholder' => _x( 'Notes on your order, e.g. special notes concerning delivery.', 'placeholder', 'tco_woo_checkout' )
                    )
                ) );
            }
        }

        /**
         * Return the default checkout keys of WooCommerce
         *
         * @param String type . The type of fields to return (shipping or billing)
         * @return Array
         * @since 1.0.0
         */
        static function default_woocommerce_checkout_keys($type = 'billing'){
            $fields = self::default_woocommerce_checkout_fields( $type );

		    return is_array( $fields ) ? array_keys( $fields ) : array();
        }


        /**
         * Clean the fields returned by WooCommerce so we dont get any errors
         *
         * @param Array fields
         * @return Array
         * @since 1.0.0
         */
        static function clean_woo_fields( $fields ) {

            if( empty( $fields ) ){
                return array();
            }

            foreach( $fields as &$field ) {
                // type standard text fo not set
                ! isset( $field['type'] ) &&  $field['type'] = 'text';
                // label empty if not set
                ! isset( $field['label'] ) && $field['label'] = '';
                // placeholder empty if not set
                ! isset( $field['placeholder'] ) && $field['placeholder'] = '';
                // set options for select type
			    $field['options'] = ( isset( $field['options'] ) && is_array( $field['options'] ) )  ? implode( '|', $field['options'] ) : '';
                // set class and position for field
                $field['class'] = ( isset( $field['class'] ) && is_array( $field['class'] ) ) ? implode( ',', $field['class'] ) : '';
                if( isset( $field['class'] ) && is_array( $field['class'] ) ) {
                    $field['class'] = implode( ',', $field['class'] );
                }
                // set validation
                $field['validate'] = ( isset( $field['validate'] ) && is_array( $field['validate'] ) ) ?  implode( ',', $field['validate'] ) : '';
                ! isset( $field['regex'] ) && $field['regex'] = '';
                ! isset( $field['validation_field'] ) && $field['validation_field'] = '';
                //Set conditional (default false)
                $field['conditional'] = ( ! isset( $field['conditional'] ) || ! $field['conditional'] ) ? '0' : '1';
                ! isset( $field['conditional_value'] ) && $field['conditional_value'] = '';
                ! isset( $field['conditional_fields'] ) && $field['conditional_fields'] = '';
                ! isset( $field['product_fields'] ) && $field['product_fields'] = '';
                ! isset( $field['products_condition'] ) && $field['products_condition'] = '';
                ! isset( $field['product_fields_validation'] ) && $field['product_fields_validation'] = '';
                ! isset( $field['product_fields_second'] ) && $field['product_fields_second'] = '';
                ! isset( $field['product_fields_validation_second'] ) && $field['product_fields_validation_second'] = '';

                // set required ( default false )
                $field['required'] = ( ! isset( $field['required'] ) || ! $field['required'] ) ? '0' : '1';
                // set enabled ( default true )
                $field['enabled'] = ( isset( $field['enabled'] ) && ! $field['enabled'] ) ? '0': '1';
            }

            return $fields;
        }

        /**
         * Save the Chckout fields and their position
         *
         * @since 1.0.0
         */
        static function save_checkout_fields(){

            $section = isset( $_POST['tco_woo_section'] ) ? $_POST['tco_woo_section'] : '';
			$names = isset( $_POST['field_name'] ) ? $_POST['field_name'] : array();
			if( empty( $names ) ) {
				return;
			}
            // get max number
			$max = count($names);
			$new_fields = array();


			for( $i = 0; $i <= $max; $i++ ){

				if(isset($names[$i])){
					// get name
					$name =  wc_clean( stripslashes( $names[$i] ) );
					$name = str_replace( ' ', '_', $name );

					$new_fields[ $name ]                                        = array();
					$new_fields[ $name ]['type']                                = ! empty( $_POST['field_type'][ $i ] ) ? $_POST['field_type'][ $i ] : 'text';
					$new_fields[ $name ]['label']                               = ! empty( $_POST['field_label'][ $i ] ) ? $_POST['field_label'][ $i ] : '';
					$new_fields[ $name ]['placeholder']                         = ! empty( $_POST['field_placeholder'][ $i ] ) ? $_POST['field_placeholder'][ $i ] : '';
                    $new_fields[ $name ]['options']                             = ! empty( $_POST['field_options'][ $i ] ) ? self::options_array( $_POST['field_options'][ $i ] ) : array();
					$new_fields[ $name ]['class']                               = ! empty( $_POST['field_class'][ $i ] ) ?  explode( ',', $_POST['field_class'][ $i ] ) : array();
					$new_fields[ $name ]['validate']                            = ! empty( $_POST['field_validate'][ $i ] ) ? explode( ',', $_POST['field_validate'][ $i ] ) : '';
                    $new_fields[ $name ]['regex']                               = ! empty( $_POST['field_regex'][ $i ] ) ? $_POST['field_regex'][ $i ] : '';
                    $new_fields[ $name ]['validation_field']                    = ! empty( $_POST['field_validation_field'][ $i ] ) ? $_POST['field_validation_field'][ $i ] : '';
                    $new_fields[ $name ]['conditional']                         = ! empty( $_POST['field_conditional'][ $i ] ) ? ( $_POST['field_conditional'][ $i ] == 1) : false;
                    $new_fields[ $name ]['conditional_value']                   = ! empty( $_POST['field_conditional_value'][ $i ] ) ? $_POST['field_conditional_value'][ $i ] : '';
                    $new_fields[ $name ]['conditional_fields']                  = ! empty( $_POST['field_conditional_fields'][ $i ] ) ? $_POST['field_conditional_fields'][ $i ] : '';
                    $new_fields[ $name ]['product_fields']                      = ! empty( $_POST['field_products_fields'][ $i ] ) ? $_POST['field_products_fields'][ $i ] : '';
                    $new_fields[ $name ]['products_condition']                  = ! empty( $_POST['field_products_condition'][ $i ] ) ? $_POST['field_products_condition'][ $i ] : '';
                    $new_fields[ $name ]['product_fields_validation']           = ! empty( $_POST['field_products_fields_validation'][ $i ] ) ? $_POST['field_products_fields_validation'][ $i ] : '';
                    $new_fields[ $name ]['product_fields_second']               = ! empty( $_POST['field_products_fields_second'][ $i ] ) ? $_POST['field_products_fields_second'][ $i ] : '';
                    $new_fields[ $name ]['product_fields_validation_second']    = ! empty( $_POST['field_products_fields_validation_second'][ $i ] ) ? $_POST['field_products_fields_validation_second'][ $i ] : '';
					$new_fields[ $name ]['required']                            = ! empty( $_POST['field_required'][ $i ] ) ? ( $_POST['field_required'][ $i ] == 1) : false;
					$new_fields[ $name ]['enabled']                             = ! empty( $_POST['field_enabled'][ $i ] ) ? ( $_POST['field_enabled'][ $i ] == 1) : false;
				}

			}

			if( ! empty( $new_fields ) ) {
				// save option
				update_option( 'tco_woo_fields_' . $section . '_options', $new_fields );
			}
        }

        /**
		 * Create options array for field
		 *
		 * @param string $options
         *
		 * @return array
         *
         * @since 1.0.2
		 */
        static function options_array( $options ) {

			$options_array = array();

			$options = array_map( 'wc_clean', explode( '|', $options ) ); // create array from string
			$options = array_unique( $options ); // remove double entries

			foreach ( $options as $option ) {
				// create key
				$key = sanitize_title_with_dashes( $option );
				$options_array[ $key ] = $option;
			}

			return $options_array;
		}

		/**
         * Reset Checkout Fields
         *
         * @since 1.0.0
         */
		static function reset_checkout_fields(){
			$section = isset( $_POST['tco_woo_section'] ) ? $_POST['tco_woo_section'] : '';
			update_option( 'tco_woo_fields_' . $section . '_options', array() );
		}


        /**
         * Get custom fields key for section on order page filtered by location( billing | shipping )
         *
         * @param string $type
         * @return array
         * @since 1.0.0
         */
        static function order_fields($type = 'billing'){
            global $pagenow;

            $fields = get_option( 'tco_woo_fields_' . $type . '_options', array() );

            if( empty( $fields ) ) {
                return array();
            }

            $access_location = false;

            //Check current access location
            if( ( is_admin() &&
                ( ( $pagenow == 'edit.php' && isset( $_GET['post_type'] ) && $_GET['post_type'] == 'shop_order' )
                    || ( $pagenow == 'post.php' && isset( $_GET['action'] ) && $_GET['action'] == 'edit' ) ) ) || is_account_page() ) {

                $access_location = '';
            }
            elseif( is_order_received_page() ) {
                $access_location = 'show_in_order';
            }
            else {
                $access_location = 'show_in_email';
            }
            // remove fields based on where I am
            if( $access_location ) {
                foreach ( $fields as $key => $value ) {
                    if( isset( $value[ $access_location ] ) && ! $value[ $access_location ] ) {
                        unset( $fields[$key] );
                    };
                }
            }

            //Default WooCommerce fields
            $woo_keys = self::default_woocommerce_checkout_keys( $type );

            // fields keys
            $fields_keys = array_keys( $fields );

            // filtr out our custom keys
            $fields_custom = array_diff( $fields_keys, $woo_keys );

            // remove type
            foreach ( $fields_custom as &$value ) {
                $value = str_replace( $type . '_', '', $value );
            }

            return $fields_custom;
        }

        /**
	     * Remove specified prefix from array keys
	     *
	     * @param Array $fields - Our Fields
	     * @param Array $old - the old WooCommerce Fields
	     * @param string $type
	     * @return array
         *
         * @since 1.0.0
	     */
        static function admin_order_filter($fields, $old, $type = 'billing'){

            global $theorder, $post; //Get the current order and post

			if ( ! is_object( $theorder ) ) {
				$theorder = wc_get_order( $post->ID );
			}

            $type = $type.'_'; //Add the suffix

            $output = array();

            foreach ( $fields as $key => $opt ) {
                $key = str_replace( $type, '', $key );
                $output[ $key ] = array();

                // if exists load default
                if( array_key_exists( $key, $old ) ) {
                    $output[ $key ] = $old[$key];
                    // update label
                    if(isset($opt['label']))
                        $output[ $key ]['label'] = $opt['label'];
                }
                else {
                    // get value
                    $value = get_post_meta( $theorder->id, '_' . $type . $key, true );

                    switch( $opt['type'] ) {
                        case 'select' :
                        case 'radio' :
                            $output[ $key ]['type'] = 'select';
                            $output[ $key ]['class'] = 'select short';
                            // set options
                            ! empty( $opt['options'] ) && $output[ $key ]['options'] = $opt['options'];

                            break;

                        case 'multiselect' :
                            $new[ $key ]['type'] = 'select';
                            $new[ $key ]['class'] = 'select short tco_woomultiselect_admin';
                            $new[ $key ]['custom_attributes'] = array(
                                'multiple' =>'multiple',
                                'data-value' => $value
                            );
                            // set options
                            ! empty( $opt['options'] ) && $new[ $key ]['options'] = $opt['options'];

                            break;


                        case 'checkbox' :

                            $output[ $key ]['type'] = 'checkbox';
                            $output[ $key ]['value'] = '1';

                            break;

                        default :
                            break;
                    }

                    $output[ $key ]['show'] = false;
                    // set label
                    isset( $opt['label'] ) && $output[ $key ]['label'] = $opt['label'];
                }
            }

            return $output;
        }

        /**
	     * Add address localisation formats
	     *
	     *
	     * @param string $type billing | shipping | all
	     * @param boolean $return - return keys
	     * @return string | array
         *
         * @since 1.0.0
	     */
        static function localisation_address_formats($type = 'billing', $return = false, $show_label = false){
            $fields = array();

            switch($type){

                case 'all' :
                    $fields_billing = self::order_fields( 'billing' );
                    $fields_shipping = self::order_fields( 'shipping' );
                    $fields = array_merge( $fields_billing, $fields_shipping );

                    $billing_fileds = self::checkout_fields('billing');
                    $shipping_fields = self::checkout_fields('shipping');
                    $all_fields = array_merge( $billing_fileds, $shipping_fields );
                    break;

                default :
                    $fields = self::order_fields( $type );
                    $all_fields = self::checkout_fields($type);
                    break;
            }

            if( $return ) {
                return $fields;
            }

            if( empty( $fields ) ) {
                return '';
            }
            $replace = '';
            foreach( $fields as $field) {
                if($show_label){
                    if(isset($all_fields[$field])){
                        $field_label = $all_fields[$field]['label'];
                        $replace .= "\n <strong>$field_label</strong> : {{$field}}";
                    }else{
                         $replace .= "\n{{$field}}";
                    }
                }else{
                    $replace .= "\n{{$field}}";
                }

            }

            return $replace;
        }
    }

}
?>
