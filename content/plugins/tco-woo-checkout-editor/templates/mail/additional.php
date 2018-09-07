<?php
/**
 * Additional Fields Email
 *
 * Return the email content as html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<h2><?php _e( 'Additional info', 'tco_woo_checkout' ); ?></h2>
<ul>
	<?php foreach ( $fields as $field ) : ?>
		<li><strong><?php echo wp_kses_post( $field['label'] ); ?>:</strong> <span class="text"><?php echo wp_kses_post( $field['value'] ); ?></span></li>
	<?php endforeach; ?>
</ul>