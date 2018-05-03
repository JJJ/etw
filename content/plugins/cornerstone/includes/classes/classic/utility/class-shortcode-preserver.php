<?php

/**
 * Utility class for preserving shortcode content. This prevents filters
 * like wptexturize and wpautop from affecting your content.
 */

class Cornerstone_Shortcode_Preserver {

	/**
	 * I am a singleton
	 * @var object
	 */
	private static $instance;

	/**
	 * By default we hook into the_content
	 * By specifying a hook, you can create a sandboxed equivilant of
	 * the_content with only WordPress native
	 * @var string
	 */
	private $hook;

	/**
	 * List of shortcode tags.
	 * @var array
	 */
	private $shortcodes;

	/**
	 * Internal cache of placeholders and content.
	 * @var array
	 */
	private $cache;

	/**
	 * Setup shortcode preservation
	 * @param string $hook hook to use. Defaults to the_content
	 */
	public function __construct( $hook = '' ) {

		$this->shortcodes = array();
		$this->cache = array();
		$this->attach_hooks( ( '' === $hook ) ? 'the_content' : $hook );

	}

	/**
	 * Attach preservation and restoration hooks to the filter being used
	 * for the_content. If we're using a custom hook, we'll load the sandbox filters.
	 * @param  string $hook Custom hook for filtering
	 * @return none
	 */
	public function attach_hooks( $hook ) {

		if ( 'the_content' !== $hook ) {
			$this->sandbox_hooks( $hook );
		}

		add_filter( $hook, array( $this, 'preserve_shortcodes' ), 9 );
		add_filter( $hook, array( $this, 'restore_shortcodes' ), 11 );

	}

	/**
	 * Wire-up WordPress native filters to a custom hook to emulate the_content
	 * as closely as possible.
	 * @param  string $hook Custom hook for the_content emulation.
	 * @return none
	 */
	public function sandbox_hooks( $hook ) {

		add_filter( $hook, array( $GLOBALS['wp_embed'], 'run_shortcode' ), 8 );
		add_filter( $hook, array( $GLOBALS['wp_embed'], 'autoembed' ), 8 );
		add_filter( $hook, 'capital_P_dangit', 11 );
		add_filter( $hook, 'wptexturize' );
		add_filter( $hook, 'convert_smilies' );
		add_filter( $hook, 'wpautop' );
		add_filter( $hook, 'shortcode_unautop' );
		add_filter( $hook, 'prepend_attachment' );

		if ( function_exists( 'wp_make_content_images_responsive' ) ) {
			add_filter( $hook, 'wp_make_content_images_responsive' ); // Added in WP 4.4
		}

		add_filter( $hook, 'do_shortcode', 11 ); // AFTER wpautop()

	}

	/**
	 * Pre-filter the_content and replace our shortcodes with placeholders using
	 * a regex filter similar to the original WordPress shortcode replacements.
	 * @param  string $content Original content, before WordPress filters applied.
	 * @return string          Content with placeholders
	 */
	public function preserve_shortcodes( $content ) {

		$this->shortcodes = apply_filters( 'cs_preserve_shortcodes', $this->shortcodes );

		if ( empty( $this->shortcodes ) ) {
			return $content;
		}

		global $shortcode_tags;
		$original = $shortcode_tags;
		remove_all_shortcodes();

		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode, '__return_empty_string' );
		}

		$pattern = get_shortcode_regex();

		$content = preg_replace_callback( "/$pattern/s", array( $this, 'preserve_shortcode' ), $content );
		$shortcode_tags = $original; // WPCS: override ok.

		return $content;
	}

	/**
	 * Swap out placeholders for the original unscathed content.
	 * @param  string $content Content after WordPress filters have been applied.
	 * @return string          Final content
	 */
	public function restore_shortcodes( $content ) {

		foreach ($this->cache as $key => $value) {

			if ( apply_filters( 'cs_preserve_shortcodes_no_wrap', false ) ) {
				$content = str_replace( '<p>' . $key . '</p>', $key, $content );
			}

			$content = str_replace( $key, $value, $content );

		}

		return do_shortcode( $content, true );

	}

	/**
	 * Callback for regex replacement. This caches the match, and returns a placeholder.
	 * @param  array $matches Matches for an individual shortcode
	 * @return string         A placeholder we can target later.
	 */
	public function preserve_shortcode( $matches ) {
		$placeholder = '{{{'. uniqid() . '}}}';
		$this->cache[ $placeholder ] = $matches[0];
		return $placeholder;
	}

	/**
	 * Alias for ::instance
	 * For semantics. init can be called when the intention is the first initialization
	 * @return object Cornerstone_Shortcode_Preserver::$instance
	 */
	public static function init( $hook = '' ) {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new Cornerstone_Shortcode_Preserver( $hook );
		}
		return self::$instance;
	}

	/**
	 * Create an isolated filter equivalent to the_content but with only WordPress
	 * native filters. This can help with custom formatting in areas sensitive to
	 * plugin conflicts.
	 * @param  string $hook Name of filter to use
	 * @return none
	 */
	public static function sandbox( $hook = '' ) {
		if ( 'the_content' !== $hook ) {
			self::init()->attach_hooks( $hook );
		}
	}

	/**
	 * Mark a shortcode for preservation. A more direct approach than using the filter.
	 * @param  string $shortcode Tag of shortcode to preserve.
	 * @return none
	 */
	public static function preserve( $shortcode ) {
		if ( ! isset( self::$instance ) || in_array( $shortcode, self::$instance->shortcodes, true ) ) {
			return;
		}

		self::$instance->shortcodes[] = $shortcode;
	}

}
