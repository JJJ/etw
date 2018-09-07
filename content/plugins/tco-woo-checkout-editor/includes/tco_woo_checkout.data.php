<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

//Supported Form Elements
$this->form_elements = array(
                                'text'                   => __( 'Text',        'tco_woo_checkout' ),
                                'password'               => __( 'Password',    'tco_woo_checkout' ),
                                'tel'                    => __( 'Phone',       'tco_woo_checkout' ),
                                'textarea'               => __( 'Textarea',    'tco_woo_checkout' ),
                                'checkbox'               => __( 'Checkbox',    'tco_woo_checkout' ),
                                'tco_woofile'          => __( 'File',        'tco_woo_checkout' ),
                                'radio'                  => __( 'Radio',       'tco_woo_checkout' ),
                                'select'                 => __( 'Select',      'tco_woo_checkout' ),
                                'tco_woomultiselect'   => __( 'Multi Select','tco_woo_checkout' ),
                            );


//Array of out multi items
$this->multiselect_fields = array('select','tco_woomultiselect','radio');

//Clickable fields
$this->click_fields = array('checkbox','radio');

//Text fields
$this->text_fields = array('text','password','tel','textarea');


//Allowed file types. Add this to settings to be configurable
$this->allowed_file_types = array(
                                    'pdf'  => 'application/pdf',
                                    'jpeg' => 'image/jpeg',
                                    'jpg'  => 'image/jpeg',
                                    'png'  => 'image/png',
                                 );

//Validation options
$this->validation_options = array(
                                    ''          => __('No validation', 'tco_woo_checkout' ),
                                    'postcode'  => __('PostCode',       'tco_woo_checkout'),
                                    'phone'     => __('Phone',          'tco_woo_checkout'),
                                    'email'     => __('Email',          'tco_woo_checkout'),
                                    'state'     => __('State',          'tco_woo_checkout'),
                                    'custom'    => __('Custom',         'tco_woo_checkout')
                                );

//Cart Product validation
$this->cart_options = array(
    1 => __('Cart Contains', 'tco_woo_checkout' ),
    0 =>  __('Cart Not Contains', 'tco_woo_checkout' )
);
?>