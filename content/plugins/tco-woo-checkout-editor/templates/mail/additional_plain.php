<?php
/**
 * Additional Fields Plain Email
 *
 * Echo the email content
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

echo strtoupper( __( 'Additional info', 'tco_woo_checkout' ) ) . "\n\n";

foreach ( $fields as $field ) {
	echo wp_kses_post( $field['label'] ) . ': ' . wp_kses_post( $field['value'] ) . "\n";
}

?>