<?php

/**
 * Plugin name: Flox - Make Overrides (Network)
 * Description: Filter Make settings
 * Author:      The Flox Team
 * Author URI:  https://flox.io
 * Version:     0.0.1
 */

// No credit
add_filter( 'make_show_footer_credit', '__return_false', PHP_INT_MAX );
