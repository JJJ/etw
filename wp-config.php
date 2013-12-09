<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 * @package WordPress
 */

if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
  include( dirname( __FILE__ ) . '/local-config.php' );
  define( 'WP_LOCAL_DEV', true );
} else {
  define( 'DB_NAME',     '' );
  define( 'DB_USER',     '' );
  define( 'DB_PASSWORD', '' );
  define( 'DB_HOST',     '' );
}

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 */
define('AUTH_KEY',         'HDDoryiNV!--3R6}&/>jh=!fT2F-LqFh^pO29t]R(39RgMcMAD]r_5^hYTxF1t2A');
define('SECURE_AUTH_KEY',  '+*<V+KWc@i)y+rF-k_S-v++(gQKd+N3LfH9yKv@0oqpG 4|DqYS7%u7aM0i(cn/y');
define('LOGGED_IN_KEY',    '2E;}DXOES/PSM[1wQJ&`/8-<?bAF)@5+G?sfxNt,&cpHmJE}#_Ii{^)G+X&9%z||');
define('NONCE_KEY',        'V^]kX9r[gzAr4=Nn~5Lx+JffI-D|UCJNPo$qf% aHHXF!9kn+vf4gd&1l]Q &c.w');
define('AUTH_SALT',        'Ko0y#>!^c)v;=9V+k,.%BFq8]=GM^b7~7BEE@vK(x+^= J),X;0x$>2<fbR{8@Z?');
define('SECURE_AUTH_SALT', '`FP3$B:B@7Y;wSPiNv1Pa tD)g5!Oz~l9>!@MQ]:h.0HdX-QEICJ/Y8Y#v=!c7/p');
define('LOGGED_IN_SALT',   '4VMd,xfr6Q=B6mnk0X{6bc:9.H*o%`VO.]|dE=JTm,o1$dq<c-~n-Qs)I4HCjLwd');
define('NONCE_SALT',       '[*(9R$$|K6p%uBf]|Z|*tEj_VsN=ePh[]W3(k.>^j84n*VvI&a6x9I|!@)SAhATF');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

// Debug
define( 'WP_DEBUG', false );

// Custom Content Directory
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/etw-content' );
define( 'WP_CONTENT_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/etw-content' );

// Load a Memcached config if we have one
if ( file_exists( dirname( __FILE__ ) . '/memcached.php' ) ) {
	$memcached_servers = include( dirname( __FILE__ ) . '/memcached.php' );
}

// Bootstrap WordPress
if ( !defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wordpress/' );
}

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
