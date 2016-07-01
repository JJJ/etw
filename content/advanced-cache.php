<?php

/**
 * Plugin name: Spider-Cache
 * Plugin URI:  https://store.flox.io/plugins/spider-cache/
 * Description: Fully rendered pages stored in & served from Memcache.
 * Version:     2.0.0
 */

// WordPress or bust
defined( 'ABSPATH' ) || exit();

// Require drop-in
require_once WP_CONTENT_DIR . '/plugins/wp-spider-cache/drop-ins/advanced-cache.php';
