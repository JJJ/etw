<?php
/**
 * Other Fields Table
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<header><h2><?php _e( 'Additional info', 'tco_woo_checkout' ); ?></h2></header>

<table class="shop_table additional_fields">
	<?php foreach( $fields as $field ) : ?>
	<tr>
		<th><?php echo $field['label'] ? $field['label'] . ':' : ''; ?></th>
		<td><?php echo $field['value'] ?></td>
	</tr>
	<?php endforeach; ?>
</table>