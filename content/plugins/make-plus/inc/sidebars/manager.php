<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Sidebars_Manager
 *
 * A class to manage dynamic- and user-generated sidebars.
 *
 * @since 1.7.0.
 */
class MAKEPLUS_Sidebars_Manager extends MAKEPLUS_Util_Modules implements MAKEPLUS_Sidebars_ManagerInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode' => 'MAKEPLUS_Setup_ModeInterface',
	);

	/**
	 * The option key for storing the sidebars array.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	private $option_key = 'makeplus-sidebars';

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Register sidebars
		add_action( 'widgets_init', array( $this, 'register_sidebars' ), 20 );

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Retrieve the sidebars array from the options table and sanitize it.
	 *
	 * @since 1.7.0.
	 *
	 * @param string|null $context
	 * @param bool        $skip_filter
	 *
	 * @return array
	 */
	public function get_sidebars( $context = null, $skip_filter = false ) {
		$sidebars = get_option( $this->option_key, array() );

		if ( true !== $skip_filter ) {
			/**
			 * Filter: Modify sidebar data before use without modifying values stored in the database.
			 *
			 * @since 1.7.0.
			 *
			 * @param array $sidebars The array of sidebar data.
			 */
			$sidebars = apply_filters( 'makeplus_get_sidebars', $sidebars );
		}

		// Sanitize sidebar data
		$sidebars = $this->sanitize_sidebars( $sidebars );

		// Only return sidebars with the specified context.
		if ( ! is_null( $context ) ) {
			$contexts = array_combine( array_keys( $sidebars ), wp_list_pluck( $sidebars, 'context' ) );
			$subset_ids = array_keys( $contexts, $context );
			$subset = array();
			foreach ( $subset_ids as $id ) {
				$subset[ $id ] = $sidebars[ $id ];
			}

			return $subset;
		}

		// Return all sidebars.
		return $sidebars;
	}

	/**
	 * Check if any sidebars exist, or if $id is specified, a particular sidebar.
	 *
	 * @since 1.7.0.
	 *
	 * @param string|null $id
	 *
	 * @return bool
	 */
	public function has_sidebar( $id = null ) {
		$sidebars = $this->get_sidebars();

		if ( is_null( $id ) ) {
			return ! empty( $sidebars );
		}

		return isset( $sidebars[ $id ] );
	}

	/**
	 * Add a new sidebar to the sidebars array.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $id
	 * @param string $name
	 * @param string $description
	 * @param string $context
	 *
	 * @return bool    True if the sidebar was successfully added. Otherwise false.
	 */
	public function add_sidebar( $id, $name, $description, $context = '' ) {
		// Get unfiltered sidebars, so changes made via filter won't be saved to the dB.
		$sidebars = $this->get_sidebars( null, true );

		$new_sidebar = array(
			$id => array(
				'name'        => $name,
				'description' => $description,
				'context'     => $context,
			)
		);

		$sanitized_sidebar = $this->sanitize_sidebars( $new_sidebar );

		if ( ! empty( $sanitized_sidebar ) ) {
			$sidebars = array_merge( $sidebars, $sanitized_sidebar );

			// Set autoload to true since the sidebars will be registered with every page load.
			return update_option( $this->option_key, $sidebars, true );
		}

		// Parameters weren't valid. No sidebar added.
		return false;
	}

	/**
	 * Remove a sidebar from the sidebars array.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $id
	 *
	 * @return bool    True if the sidebar was successfully removed. Otherwise false.
	 */
	public function remove_sidebar( $id ) {
		// Get unfiltered sidebars
		$sidebars = $this->get_sidebars( null, true );

		// Remove the sidebar and update the option array.
		if ( isset( $sidebars[ $id ] ) ) {
			unset( $sidebars[ $id ] );
			return update_option( $this->option_key, $sidebars );
		}

		// Sidebar didn't exist. No sidebar removed.
		return false;
	}

	/**
	 * Sanitize and normalize the array of sidebar data.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $sidebars
	 *
	 * @return array
	 */
	public function sanitize_sidebars( $sidebars ) {
		if ( ! is_array( $sidebars ) ) {
			return array();
		}

		$sanitized_sidebars = array();

		foreach ( $sidebars as $sidebar_id => $sidebar_data ) {
			if ( ! is_array( $sidebar_data ) || empty( $sidebar_data ) ) {
				continue;
			}

			// ID
			$sidebar_id = sanitize_key( $sidebar_id );

			// Name, description, context
			$data_defaults = array(
				'name'        => ucwords( preg_replace( '/\-_+/', ' ', $sidebar_id ) ),
				'description' => '',
				'context'     => '',
			);
			$sidebar_data = wp_parse_args( (array) $sidebar_data, $data_defaults );
			$sidebar_data['name'] = $this->sanitize_sidebar_name( $sidebar_data['name'], ucwords( preg_replace( '/\-_+/', ' ', $sidebar_id ) ) );
			$sidebar_data['description'] = $this->sanitize_sidebar_description( $sidebar_data['description'], '' );
			$sidebar_data['context'] = sanitize_key( $sidebar_data['context'] );

			// Only keep the sidebar if there is a valid ID and name
			if ( $sidebar_id && $sidebar_data['name'] ) {
				// Add item to sanitized array
				$sanitized_sidebars[ $sidebar_id ] = $sidebar_data;
			}
		}

		return $sanitized_sidebars;
	}

	/**
	 * Sanitize the name of a sidebar. This name may be displayed in the user interface.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $string
	 * @param string $default
	 *
	 * @return string
	 */
	private function sanitize_sidebar_name( $string, $default ) {
		$sanitized_string = sanitize_text_field( $string );

		if ( ! $sanitized_string ) {
			return trim( $default );
		}

		return $sanitized_string;
	}

	/**
	 * Sanitize the description for a sidebar. This description may be displayed in the user interface.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $string
	 * @param string $default
	 *
	 * @return string
	 */
	private function sanitize_sidebar_description( $string, $default ) {
		// Strip unwanted tags
		$sanitized_string = wp_strip_all_tags( $string );

		if ( ! $sanitized_string ) {
			return trim( $default );
		}

		// Truncate to 20 words
		$sanitized_string = wp_trim_words( $sanitized_string, 20 );

		return $sanitized_string;
	}

	/**
	 * Register the sidebar data with WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action widgets_init
	 *
	 * @return void
	 */
	public function register_sidebars() {
		$sidebars = $this->get_sidebars();

		foreach ( $sidebars as $sidebar_id => $sidebar_data ) {
			// Remove the "context" array item
			unset( $sidebar_data['context'] );

			// Get widget display args
			if ( $this->mode()->has_make_api() ) {
				$widget_defaults = Make()->widgets()->get_widget_display_args( $sidebar_id );
			} else {
				$widget_defaults = array(
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h4 class="widget-title">',
					'after_title'   => '</h4>',
				);
			}

			$args = array_merge( array( 'id' => $sidebar_id ), $sidebar_data, $widget_defaults );

			register_sidebar( $args );
		}
	}
}