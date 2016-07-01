<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_PerPage_Settings
 *
 * Manage the layout settings for individual posts and pages.
 *
 * @since 1.0.0.
 * @since 1.7.0. Changed class name from TTFMP_PerPage_Options.
 */
class MAKEPLUS_Component_PerPage_Settings extends MAKEPLUS_Util_Modules implements MAKEPLUS_Component_PerPage_SettingsInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKEPLUS_Compatibility_MethodsInterface',
		'theme'         => 'MAKE_APIInterface',
	);

	/**
	 * Namespacing prefix.
	 *
	 * @since  1.0.0.
	 *
	 * @var    string    Prefix for name strings.
	 */
	private $prefix = 'ttfmp_per-page_';

	/**
	 * Getter for the $prefix property.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_prefix() {
		return $this->prefix;
	}

	/**
	 * Wrapper method to get the view in either a standard or admin context.
	 *
	 * Also accommodates a deprecated filter hook.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_view() {
		$context = ( is_admin() ) ? 'admin' : '';
		$view_id = $this->theme()->view()->get_current_view( $context );

		// Check for deprecated filter.
		if ( 'admin' === $context && has_filter( 'ttfmp_perpage_view' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_perpage_view',
				'1.7.0',
				sprintf(
					wp_kses(
						__( 'To add or modify theme views, use the %1$s function instead. See the <a href="%2$s" target="_blank">View API documentation</a>.', 'make-plus' ),
						array( 'a' => array( 'href' => true, 'target' => true ) )
					),
					'<code>make_update_view_definition()</code>',
					'https://thethemefoundry.com/docs/make-docs/code/apis/view-api/'
				)
			);

			/**
			 * Filter: Modify the view ID.
			 *
			 * @since 1.0.0.
			 * @deprecated 1.7.0.
			 *
			 * @param string  $view_id
			 * @param WP_Post $post
			 */
			$view_id = apply_filters( 'ttfmp_perpage_view', $view_id, get_post() );
		}

		return $view_id;
	}

	/**
	 * Get the Per Page setting IDs for a particular view.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $view_id
	 *
	 * @return array
	 */
	private function get_view_setting_ids( $view_id ) {
		$setting_ids = array();
		$view = $this->theme()->view()->get_view( $view_id );

		if ( isset( $view[ 'makeplus_perpage_settings' ] ) && is_array( $view[ 'makeplus_perpage_settings' ] ) ) {
			foreach ( $view[ 'makeplus_perpage_settings' ] as $setting_id ) {
				if ( $this->theme()->thememod()->setting_exists( $setting_id ) ) {
					$setting_ids[] = $setting_id;
				}
			}

			// Check for deprecated filter.
			if ( has_filter( 'ttfmp_perpage_keys' ) ) {
				$this->compatibility()->deprecated_hook(
					'ttfmp_perpage_keys',
					'1.7.0',
					sprintf(
						wp_kses(
							__( 'To add or modify theme views, use the %1$s function instead. See the <a href="%2$s" target="_blank">View API documentation</a>.', 'make-plus' ),
							array( 'a' => array( 'href' => true, 'target' => true ) )
						),
						'<code>make_update_view_definition()</code>',
						'https://thethemefoundry.com/docs/make-docs/code/apis/view-api/'
					)
				);

				/**
				 * Filter to change the theme option keys that are allowed to be modified for the specified view.
				 *
				 * @since 1.0.0.
				 * @deprecated 1.7.0.
				 *
				 * @param array     $keys    The allowed keys for the specified view.
				 * @param string    $view    The specified view. Added in 1.5.1.
				 */
				$setting_ids = apply_filters( 'ttfmp_perpage_keys', $setting_ids, $view );
			}
		}

		return $setting_ids;
	}

	/**
	 * Get the global layout settings for the given post type.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $view_id    The view.
	 *
	 * @return array             The layout settings.
	 */
	public function get_global_settings( $view_id ) {
		$setting_ids = $this->get_view_setting_ids( $view_id );
		$global_settings = array();

		if ( ! empty( $setting_ids ) ) {
			foreach ( $setting_ids as $setting_id ) {
				$global_settings[ $setting_id ] = $this->theme()->thememod()->get_value( $setting_id );
			}
		}

		return $global_settings;
	}

	/**
	 * Get the "settings" post meta and fill in gaps with default values.
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Post|null $post              The current post.
	 * @param bool         $merge_defaults    Whether to merge default values into returned array.
	 *
	 * @return array                          The settings.
	 */
	public function get_post_settings( WP_Post $post = null, $merge_defaults = true ) {
		if ( is_null( $post ) ) {
			$post = get_post();
		}

		$view_id = $this->get_view();
		$post_settings = array();

		if ( ! is_null( $post ) && $view_id ) {
			// Get post meta
			$settings = get_post_meta( $post->ID, $this->get_prefix() . 'settings', true );

			// Convert old keys
			if ( $this->has_old_keys( $settings ) ) {
				$settings = $this->convert_old_keys( $settings, $view_id );
			}

			// Sanitize
			foreach ( (array) $settings as $setting_id => $value ) {
				if ( $this->theme()->thememod()->setting_exists( $setting_id ) ) {
					$post_settings[ $setting_id ] = $this->theme()->thememod()->sanitize_value( $value, $setting_id );
				}
			}
		}

		// Parse and return
		if ( $merge_defaults ) {
			// Get defaults
			$defaults = $this->get_global_settings( $view_id );

			return wp_parse_args( $post_settings, $defaults );
		} else {
			return $post_settings;
		}
	}

	/**
	 * Get the "overrides" post meta and fill in gaps with default values.
	 *
	 * @since 1.0.0.
	 *
	 * @param WP_Post|null $post    The current post.
	 *
	 * @return array                The overrides.
	 */
	public function get_post_overrides( WP_Post $post = null ) {
		if ( is_null( $post ) ) {
			$post = get_post();
		}
		
		$view_id = $this->get_view();
		$setting_ids = $this->get_view_setting_ids( $view_id );
		$defaults = array();
		$post_overrides = array();

		if ( ! is_null( $post ) && ! empty( $setting_ids ) ) {
			// Defaults
			$defaults = array_fill_keys( $setting_ids, 0 );

			// Get post meta
			$overrides = get_post_meta( $post->ID, $this->prefix . 'overrides', true );

			// Convert old keys
			if ( $this->has_old_keys( $overrides ) ) {
				$overrides = $this->convert_old_keys( $overrides, $view_id );
			}

			// Sanitize
			foreach ( (array) $overrides as $setting_id => $value ) {
				if ( isset( $defaults[ $setting_id ] ) ) {
					$post_overrides[ $setting_id ] = wp_validate_boolean( $value );
				}
			}
		}

		// Parse and return
		if ( ! empty( $post_overrides ) ) {
			return wp_parse_args( $post_overrides, $defaults );
		} else {
			return $defaults;
		}
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
	 * @param array $array    A Per Page post meta array for a particular post.
	 *
	 * @return bool           True if old keys are present in the array.
	 */
	private function has_old_keys( $array ) {
		if ( ! is_array( $array ) ) {
			return false;
		}

		$all_old_keys = $this->get_old_keys();
		$existing_old_keys = array_intersect( array_keys( $array ), $all_old_keys );

		return ! empty( $existing_old_keys );
	}

	/**
	 * Convert old keys to new keys in a Per Page post meta array.
	 *
	 * @since 1.5.1.
	 *
	 * @param array  $array    A Per Page post meta array for a particular post.
	 * @param string $view     The view associated with that post.
	 *
	 * @return array           The converted array.
	 */
	private function convert_old_keys( array $array, $view ) {
		$all_old_keys = $this->get_old_keys();

		foreach ( $array as $old_key => $value ) {
			if ( in_array( $old_key, $all_old_keys ) ) {
				$new_key = 'layout-' . $view . '-' . $old_key;
				$array[ $new_key ] = $value;
				unset( $array[ $old_key ] );
			}
		}

		return $array;
	}
}