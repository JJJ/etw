<?php

/**
 * Plugin name: Flox - WordPress Embeds
 * Description: WordPress core embed hacks
 * Author:      John James Jacoby
 * Author URI:  http://jjj.me
 * Version:     1.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

/**
 * Replace http with https in WordPress autoembeds
 *
 * @param string $html
 * @return string
 */
function flox_embed_oembed_html( $html = '' ) {
    return preg_replace( '@src="https?:@', 'src="https:', $html );
}
add_filter( 'bp_embed_oembed_html', 'flox_embed_oembed_html' );
add_filter(    'embed_oembed_html', 'flox_embed_oembed_html' );
