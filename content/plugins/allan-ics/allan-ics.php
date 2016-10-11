<?php

/**
 * Plugin Name: Mods for Allan ICS
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     0.1.0
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

//* Customize the credits
function allan_footer_creds_text() {
	ob_start();

	?>

	<div class="creds">
		<p>
			Copyright &copy; <?php echo date( 'Y' ); ?>
			Allan Integrated Control Systems. All rights reserved.
		</p>
		<p>
			<a href="https://24.123.82.146:10443" target="_blank">AICS employee login</a>
		</p>
	</div>

	<?php

	// Output footer
	echo ob_end_clean();
}
add_filter( 'genesis_footer_creds_text', 'allan_footer_creds_text' );
