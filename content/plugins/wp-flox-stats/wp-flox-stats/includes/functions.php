<?php

/**
 * Flox Stats Functions
 *
 * @package Plugin/Flox/Stats/Functions
 */

// Exit if accessed directly
defined( 'ABSPATH' ) || exit;

/**
 * Get option for current network (or site on single-site)
 *
 * @since 0.1.0
 */
function wp_flox_stats_get_site_id() {
	$site_id = 0;

	// Site
	if ( $site_id = get_option( 'wp_flox_stats_site_id', 0 ) ) {
		return $site_id;

	// Network
	} elseif ( $site_id = get_site_option( 'wp_flox_stats_site_id', 0 ) ) {
		return $site_id;
	}

	return $site_id;
}

/**
 * Get option for current network (or site on single-site)
 *
 * @since 0.1.0
 */
function wp_flox_get_stats_cookie_domain() {
	$cookie_domain = get_current_site()->cookie_domain;
	return '*.' . ltrim( $cookie_domain, '.' );
}

/**
 * Output stats tracking code
 *
 * @since 0.1.0
 */
function wp_flox_stats_footer() {
	echo wp_flox_get_stats_tracking_code();
}

/**
 * Get stats tracking code, with Stats site ID & cookie domain
 *
 * @since 0.1.0
 *
 * @return string
 */
function wp_flox_get_stats_tracking_code() {

	// Buffer
	ob_start();

	// Get site ID
	$site_id = wp_flox_stats_get_site_id();

	// No tracking code if no site exists
	if ( empty( $site_id ) ) {
		return;
	}

	// Get the cookie domain
	$cookie_domain = wp_flox_get_stats_cookie_domain();

?><script type="text/javascript" id="wp-flox-stats-js">
  var _paq = _paq || [];
  _paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
  _paq.push(["setCookieDomain", "<?php echo esc_js( $cookie_domain ); ?>"]);
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//stats.flox.io/";
    _paq.push(['setTrackerUrl', u+'piwik.php']);
    _paq.push(['setSiteId', 1]);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<noscript><p><img src="//stats.flox.io/piwik.php?idsite=<?php echo (int) $site_id; ?>" style="border:0;" alt="" /></p></noscript><?php

	// Done
	return ob_get_clean();
}
