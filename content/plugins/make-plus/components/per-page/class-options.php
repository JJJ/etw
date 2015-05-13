<?php
/**
 * @package Make Plus
 */

if ( ! class_exists( 'TTFMP_PerPage_Options' ) ) :
/**
 * Post meta-related functionality.
 *
 * @since 1.0.0.
 */
class TTFMP_PerPage_Options {
	/**
	 * The one instance of TTFMP_PerPage_Options.
	 *
	 * @since 1.0.0.
	 *
	 * @var   TTFMP_PerPage_Options
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMP_PerPage_Options instance.
	 *
	 * @since  1.0.0.
	 *
	 * @return TTFMP_PerPage_Options
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Bootstrap the module
	 *
	 * @since  1.0.0.
	 *
	 * @return TTFMP_PerPage_Options
	 */
	public function __construct() {}

	/**
	 * Get the relevant setting keys for the specified view
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $view    The view.
	 * @return array              The keys.
	 */
	public function get_keys( $view ) {
		// Define options that are allowed to be modified by the Per Page component.
		$allowed_keys = array(
			'post' => array(
				'layout-post-hide-header',
				'layout-post-hide-footer',
				'layout-post-sidebar-left',
				'layout-post-sidebar-right',
				'header-hide-padding-bottom',
				'footer-hide-padding-top',
				'layout-post-featured-images',
				'layout-post-featured-images-alignment',
				'layout-post-post-date',
				'layout-post-post-date-location',
				'layout-post-post-author',
				'layout-post-post-author-location',
				'layout-post-show-categories',
				'layout-post-show-tags',
				'layout-post-comment-count',
				'layout-post-comment-count-location',
			),
			'page' => array(
				'layout-page-hide-header',
				'layout-page-hide-footer',
				'layout-page-sidebar-left',
				'layout-page-sidebar-right',
				'header-hide-padding-bottom',
				'footer-hide-padding-top',
				'layout-page-featured-images',
				'layout-page-featured-images-alignment',
				'layout-page-post-date',
				'layout-page-post-date-location',
				'layout-page-post-author',
				'layout-page-post-author-location',
				'layout-page-comment-count',
				'layout-page-comment-count-location',
				'layout-page-hide-title',
			),
		);

		/**
		 * Filter to change the theme option keys that are allowed to be modified by the Per Page component.
		 *
		 * @since 1.5.1
		 *
		 * @param array     $allowed_keys    The array of option keys that are allowed to be modified by the Per Page component.
		 * @param string    $view            The type of view being modified.
		 */
		$allowed_keys = apply_filters( 'ttfmp_perpage_allowed_keys', $allowed_keys, $view );

		// Check for a valid view
		if ( ! in_array( $view, array_keys( $allowed_keys ) ) ) {
			return array();
		}

		// Get the keys for the specified view.
		$keys = $allowed_keys[ $view ];

		/**
		 * Filter to change the theme option keys that are allowed to be modified for the specified view.
		 *
		 * @since 1.0.0.
		 *
		 * @param array     $keys    The allowed keys for the specified view.
		 * @param string    $view    The specified view. Added in 1.5.1.
		 */
		return apply_filters( 'ttfmp_perpage_keys', $keys, $view );
	}

	/**
	 * Get the global layout settings for the given post type.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $view    The view.
	 * @return array              The layout settings.
	 */
	public function get_global_settings( $view ) {
		// Get setting keys for specified view
		$keys = $this->get_keys( $view );

		$settings = array();

		foreach ( $keys as $key ) {
			$settings[ $key ] = get_theme_mod( $key, ttfmake_get_default( $key ) );
		}

		return $settings;
	}

	/**
	 * Get the "settings" post meta and fill in gaps with default values.
	 *
	 * @since  1.0.0.
	 *
	 * @param  object    $post    The current post.
	 * @param  string    $view    The current view type.
	 * @return array              The settings.
	 */
	public function get_post_settings( $post, $view = '' ) {
		// Get the current view if one isn't specified
		if ( ! $view ) {
			$view = ttfmp_get_perpage()->get_view( $post );
		}

		// Get defaults
		$defaults = $this->get_global_settings( $view );

		// Get post meta
		$meta_key = ttfmp_get_perpage()->prefix . 'settings';
		$settings = get_post_meta( $post->ID, $meta_key, true );

		// Convert old keys
		if ( $this->has_old_keys( $settings ) ) {
			$settings = $this->convert_old_keys( $settings, $view );
		}

		// Parse and return
		if ( empty( $settings ) ) {
			return $defaults;
		} else {
			return wp_parse_args( (array) $settings, $defaults );
		}
	}

	/**
	 * Get the "overrides" post meta and fill in gaps with default values.
	 *
	 * @since  1.0.0.
	 *
	 * @param  object    $post    The current post.
	 * @param  string    $view    The current view type.
	 * @return array              The overrides.
	 */
	public function get_post_overrides( $post, $view = '' ) {
		// Get the current view if one isn't specified
		if ( ! $view ) {
			$view = ttfmp_get_perpage()->get_view( $post );
		}

		// Get defaults
		$keys = $this->get_keys( $view );
		$defaults = array_fill_keys( $keys, 0 );

		// Get post meta
		$meta_key = ttfmp_get_perpage()->prefix . 'overrides';
		$overrides = get_post_meta( $post->ID, $meta_key, true );

		// Convert old keys
		if ( $this->has_old_keys( $overrides ) ) {
			$overrides = $this->convert_old_keys( $overrides, $view );
		}

		// Parse and return
		if ( empty( $overrides ) ) {
			return $defaults;
		} else {
			return wp_parse_args( (array) $overrides, $defaults );
		}
	}

	/**
	 * Sanitize a value for storage in post meta.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string    $key      The array key
	 * @param  mixed     $value    The value to sanitize
	 * @param  string    $view     The view type
	 * @return mixed               The sanitized value
	 */
	public function sanitize_post_meta( $key, $value, $view ) {
		$functions = array(
			//
			'header-hide-padding-bottom' => 'absint',
			'footer-hide-padding-top' => 'absint',
			//
			'layout-post-hide-header' => 'absint',
			'layout-post-hide-footer' => 'absint',
			'layout-post-sidebar-left' => 'absint',
			'layout-post-sidebar-right' => 'absint',
			'layout-post-shop-sidebar' => 'ttfmake_sanitize_choice',
			'layout-post-featured-images' => 'ttfmake_sanitize_choice',
			'layout-post-featured-images-alignment' => 'ttfmake_sanitize_choice',
			'layout-post-post-date' => 'ttfmake_sanitize_choice',
			'layout-post-post-date-location' => 'ttfmake_sanitize_choice',
			'layout-post-post-author' => 'ttfmake_sanitize_choice',
			'layout-post-post-author-location' => 'ttfmake_sanitize_choice',
			'layout-post-show-categories' => 'absint',
			'layout-post-show-tags' => 'absint',
			'layout-post-comment-count' => 'ttfmake_sanitize_choice',
			'layout-post-comment-count-location' => 'ttfmake_sanitize_choice',
			//
			'layout-page-hide-header' => 'absint',
			'layout-page-hide-footer' => 'absint',
			'layout-page-sidebar-left' => 'absint',
			'layout-page-sidebar-right' => 'absint',
			'layout-page-shop-sidebar' => 'ttfmake_sanitize_choice',
			'layout-page-featured-images' => 'ttfmake_sanitize_choice',
			'layout-page-featured-images-alignment' => 'ttfmake_sanitize_choice',
			'layout-page-post-date' => 'ttfmake_sanitize_choice',
			'layout-page-post-date-location' => 'ttfmake_sanitize_choice',
			'layout-page-post-author' => 'ttfmake_sanitize_choice',
			'layout-page-post-author-location' => 'ttfmake_sanitize_choice',
			'layout-page-comment-count' => 'ttfmake_sanitize_choice',
			'layout-page-comment-count-location' => 'ttfmake_sanitize_choice',
			'layout-page-hide-title' => 'absint',
			//
			'layout-shop-hide-header' => 'absint',
			'layout-shop-hide-footer' => 'absint',
			'layout-shop-sidebar-left' => 'absint',
			'layout-shop-sidebar-right' => 'absint',
			'layout-shop-shop-sidebar' => 'ttfmake_sanitize_choice',
			//
			'layout-product-hide-header' => 'absint',
			'layout-product-hide-footer' => 'absint',
			'layout-product-sidebar-left' => 'absint',
			'layout-product-sidebar-right' => 'absint',
			'layout-product-shop-sidebar' => 'ttfmake_sanitize_choice',
		);

		if ( ! function_exists( $functions[ $key ] ) ) {
			return false;
		} else {
			$args = array( $value );
			if ( 'ttfmake_sanitize_choice' === $functions[ $key ] ) {
				$args[] = $key;
			}
			return call_user_func_array( $functions[ $key ], $args );
		}
	}

	/**
	 * Check to see if a specific option key exists in the defaults array.
	 *
	 * @since 1.5.1.
	 *
	 * @param  string    $key    The theme option key to test.
	 *
	 * @return bool              True if the defaults array contains the key.
	 */
	public function option_exists( $key ) {
		$defaults = ttfmake_option_defaults();

		if ( isset( $defaults[ $key ] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Define the old option keys that need to be converted, if present.
	 *
	 * @since 1.5.1.
	 *
	 * @return array    The array of old option keys.
	 */
	private function get_old_keys() {
		return array(
			'hide-header',
			'hide-footer',
			'sidebar-left',
			'sidebar-right',
			'shop-sidebar',
			'featured-images',
			'featured-images-alignment',
			'post-date',
			'post-date-location',
			'post-author',
			'post-author-location',
			'show-categories',
			'show-tags',
			'comment-count',
			'comment-count-location',
			'hide-title',
		);
	}

	/**
	 * Determine if a Per Page post meta array has any old keys in it.
	 *
	 * @since 1.5.1.
	 *
	 * @param  array    $array    A Per Page post meta array for a particular post.
	 *
	 * @return bool               True if old keys are present in the array.
	 */
	public function has_old_keys( $array ) {
		$all_old_keys = $this->get_old_keys();
		$existing_old_keys = array_intersect( array_keys( (array) $array ), $all_old_keys );

		return ! empty( $existing_old_keys );
	}

	/**
	 * Convert old keys to new keys in a Per Page post meta array.
	 *
	 * @since 1.5.1.
	 *
	 * @param  array     $array    A Per Page post meta array for a particular post.
	 * @param  string    $view     The view associated with that post.
	 *
	 * @return array               The converted array.
	 */
	public function convert_old_keys( $array, $view ) {
		$all_old_keys = $this->get_old_keys();

		foreach ( (array) $array as $old_key => $value ) {
			if ( in_array( $old_key, $all_old_keys ) ) {
				$new_key = 'layout-' . $view . '-' . $old_key;
				$array[ $new_key ] = $value;
				unset( $array[ $old_key ] );
			}
		}

		return $array;
	}
}
endif;

if ( ! function_exists( 'ttfmp_get_perpage_options' ) ) :
/**
 * Instantiate or return the one TTFMP_PerPage_Options instance.
 *
 * @since  1.0.0.
 *
 * @return TTFMP_PerPage_Options
 */
function ttfmp_get_perpage_options() {
	return TTFMP_PerPage_Options::instance();
}
endif;
