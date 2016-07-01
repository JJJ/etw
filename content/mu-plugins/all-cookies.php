<?php

/**
 * Plugin name: Flox - Cookie Overrides
 * Description: Extend authentication cookie to 1 year
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

/**
 * Extend auth cookie expiration length to 1 year
 *
 * @author jjj
 * @param  int $expires Previous cookie expiry (likely 14 days)
 * @return int          1 year cookie expiry length
 */
function flox_extend_auth_cookie_expriation( $expires = '' ) {
	$expires = YEAR_IN_SECONDS;
	return $expires;
}
add_filter( 'auth_cookie_expiration', 'flox_extend_auth_cookie_expriation' );

// Always use secure cookies
add_filter( 'secure_auth_cookie',      '__return_true' );
add_filter( 'secure_logged_in_cookie', '__return_true' );
add_filter( 'secure_signon_cookie',    '__return_true' );
