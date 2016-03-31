<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Settings_ThemeMod
 *
 * A child class of MAKE_Settings_Base for defining and managing theme mod settings and their values.
 *
 * @since 1.7.0.
 */
final class MAKE_Settings_ThemeMod extends MAKE_Settings_Base implements MAKE_Settings_ThemeModInterface, MAKE_Util_HookInterface, MAKE_Util_LoadInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error'         => 'MAKE_Error_CollectorInterface',
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
		'choices'       => 'MAKE_Choices_ManagerInterface',
		'font'          => 'MAKE_Font_ManagerInterface',
	);

	/**
	 * The type of settings.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	protected $type = 'thememod';

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private $loaded = false;

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

		// Add filters to adjust sanitize callback parameters.
		add_filter( 'make_settings_thememod_sanitize_callback_parameters', array( $this, 'add_sanitize_choice_parameters' ), 10, 3 );
		add_filter( 'make_settings_thememod_sanitize_callback_parameters', array( $this, 'wrap_array_values' ), 10, 3 );

		// Handle cache settings
		add_action( 'customize_save_after', array( $this, 'clear_thememod_cache' ) );

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
	 * Load data files.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		// Load the default setting definitions
		$file = dirname( __FILE__ ) . '/definitions/thememod.php';
		if ( is_readable( $file ) ) {
			include $file;
		}

		// Loading has occurred.
		$this->loaded = true;

		/**
		 * Action: Fires at the end of the ThemeMod settings object's load method.
		 *
		 * This action gives a developer the opportunity to add or modify setting definitions
		 * and run additional load routines.
		 *
		 * @since 1.7.0.
		 *
		 * @param MAKE_Settings_ThemeMod    $settings     The settings object that has just finished loading.
		 */
		do_action( 'make_settings_thememod_loaded', $this );
	}

	/**
	 * Check if the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 * Extension of parent class's add_settings method to account for compatibility message.
	 *
	 * @since 1.7.0.
	 *
	 * @param array      $settings
	 * @param array      $default_props
	 * @param bool|false $overwrite
	 *
	 * @return bool
	 */
	public function add_settings( $settings, $default_props = array(), $overwrite = false ) {
		// Make sure we're not doing it wrong.
		if ( "make_settings_{$this->type}_loaded" !== current_action() && did_action( "make_settings_{$this->type}_loaded" ) ) {
			$this->compatibility()->doing_it_wrong(
				__FUNCTION__,
				__( 'This function should only be called during or before the <code>make_settings_thememod_loaded</code> action.', 'make' ),
				'1.7.0'
			);

			return false;
		}

		return parent::add_settings( $settings, $default_props, $overwrite );
	}

	/**
	 * Extension of the parent class's get_settings method to account for a deprecated filter.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $property
	 *
	 * @return array|mixed|void
	 */
	public function get_settings( $property = 'all' ) {
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		$settings = parent::get_settings( $property );

		// Check for deprecated filter.
		if ( 'default' === $property && has_filter( 'make_setting_defaults' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_setting_defaults',
				'1.7.0',
				sprintf(
					esc_html__( 'To add or modify theme settings, use the %1$s method instead. See %2$s.', 'make' ),
					'<code>add_settings</code>',
					'<code>MAKE_Settings_ThemeMod</code>'
				)
			);

			/**
			 * Deprecated: Filter the default values for the settings.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param array    $defaults    The list of default settings.
			 */
			$settings = apply_filters( 'make_setting_defaults', $settings );
		}

		return $settings;
	}

	/**
	 * Set a new value for a particular theme_mod setting.
	 *
	 * @since 1.7.0.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to set.
	 * @param  mixed     $value         The value to assign to the theme_mod.
	 *
	 * @return bool                     True if value was successfully set.
	 */
	public function set_value( $setting_id, $value ) {
		if ( $this->setting_exists( $setting_id ) ) {
			// Sanitize the value before saving it.
			$sanitized_value = $this->sanitize_value( $value, $setting_id, 'database' );
			if ( $this->undefined !== $sanitized_value ) {
				// This function doesn't return anything, so we assume success here.
				set_theme_mod( $setting_id, $sanitized_value );
				return true;
			}
		}

		return false;
	}

	/**
	 * Remove a particular theme_mod setting.
	 *
	 * @since 1.7.0.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to remove.
	 *
	 * @return bool                     True if the theme_mod was successfully removed.
	 */
	public function unset_value( $setting_id ) {
		if ( $this->setting_exists( $setting_id ) ) {
			// This function doesn't return anything, so we assume success here.
			remove_theme_mod( $setting_id );
			return true;
		}

		return false;
	}

	/**
	 * Get the stored value of a theme_mod, unaltered.
	 *
	 * @since 1.7.0.
	 *
	 * @param  string    $setting_id    The name of the theme_mod to retrieve.
	 *
	 * @return mixed|null               The value of the theme_mod as it is in the database, or undefined if the theme_mod isn't set.
	 */
	public function get_raw_value( $setting_id ) {
		$value = $this->undefined;

		if ( $this->setting_exists( $setting_id ) ) {
			$value = get_theme_mod( $setting_id, $this->undefined );
		}

		return $value;
	}

	/**
	 * Extension of the parent class's get_default method to account for a deprecated filter.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $setting_id
	 *
	 * @return mixed|null|void
	 */
	public function get_default( $setting_id ) {
		$default_value = parent::get_default( $setting_id );

		// Check for deprecated filter.
		if ( has_filter( 'make_get_default' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_get_default',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_default_value</code>'
				)
			);

			/**
			 * Deprecated: Filter the retrieved default value.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param mixed     $default    The default value.
			 * @param string    $option     The name of the default value.
			 */
			$default_value = apply_filters( 'make_get_default', $default_value, $setting_id );
		}

		return $default_value;
	}

	/**
	 * Extension of the parent class's sanitize_value method to account for how the Customizer handles sanitize callbacks.
	 *
	 * @since 1.7.0.
	 *
	 * @param  mixed     $value         The value to sanitize.
	 * @param  string    $setting_id    The ID of the setting to retrieve.
	 * @param  string    $context       Optional. The context in which a setting needs to be sanitized.
	 *
	 * @return mixed
	 */
	public function sanitize_value( $value, $setting_id, $context = '' ) {
		// Is this being called by the Customizer?
		if ( $setting_id instanceof WP_Customize_Setting ) {
			$setting_id = $setting_id->id;
		}

		return parent::sanitize_value( $value, $setting_id, $context );
	}

	/**
	 * Get the choice set for a particular setting.
	 *
	 * This can either return the set (an array of choices) or simply the ID of the choice set.
	 *
	 * @param string    $setting_id
	 * @param bool      $id_only
	 *
	 * @return mixed|void
	 */
	public function get_choice_set( $setting_id, $id_only = false ) {
		$choice_set_id = $this->undefined;
		$choice_set = $this->undefined;

		if ( $this->setting_exists( $setting_id, 'choice_set_id' ) ) {
			$setting = $this->get_setting( $setting_id );
			$choice_set_id = $setting['choice_set_id'];
		}

		/**
		 * Filter: Modify the choice set ID for a particular setting.
		 *
		 * @since 1.7.0.
		 *
		 * @param array     $choice_set_id    The choice set for the setting.
		 * @param string    $setting_id       The id of the setting.
		 */
		$choice_set_id = apply_filters( "make_settings_{$this->type}_choice_set_id", $choice_set_id, $setting_id );

		// Return just the ID.
		if ( true === $id_only ) {
			return sanitize_key( $choice_set_id );
		}

		// Get the choice set array.
		$choice_set = $this->choices()->get_choice_set( $choice_set_id );

		// Check for deprecated filter.
		if ( has_filter( 'make_setting_choices' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_setting_choices',
				'1.7.0',
				sprintf(
					esc_html__( 'To add or modify theme setting choices, use the %1$s method instead. See %2$s', 'make' ),
					'<code>add_choice_sets</code>',
					'<code>MAKE_Choices_Manager</code>'
				)
			);

			/**
			 * Deprecated: Filter the setting choices.
			 *
			 * @since 1.2.3.
			 *
			 * @param array     $choices    The choices for the setting.
			 * @param string    $setting    The setting name.
			 */
			$choice_set = apply_filters( 'make_setting_choices', $choice_set, $setting_id );
		}

		// Return the array of choices.
		return $choice_set;
	}

	/**
	 * Sanitize the value of a theme mod that has a choice set.
	 *
	 * @since 1.7.0.
	 *
	 * @param  mixed     $value      The value given to sanitize.
	 * @param $setting_id
	 *
	 * @return mixed|void
	 */
	public function sanitize_choice( $value, $setting_id ) {
		// Sanitize the value.
		$sanitized_value = $this->choices()->sanitize_choice( $value, $this->get_choice_set( $setting_id, true ), $this->get_default( $setting_id ) );

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_choice' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_choice',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_current_value</code>'
				)
			);

			/**
			 * Deprecated: Filter the sanitized value.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param mixed     $value      The sanitized value.
			 * @param string    $setting    The key for the setting.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_choice', $sanitized_value, $setting_id );
		}

		return $sanitized_value;
	}

	/**
	 * Sanitize the value of a theme mod with a font family choice set.
	 *
	 * @since 1.7.0.
	 *
	 * @param  string    $value
	 * @param  string    $setting_id
	 *
	 * @return mixed|void
	 */
	public function sanitize_font_choice( $value, $setting_id ) {
		// Sanitize the value.
		$sanitized_value = $this->font()->sanitize_font_choice( $value, null, $this->get_default( $setting_id ) );

		// Check for deprecated filter.
		if ( has_filter( 'make_sanitize_font_choice' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_font_choice',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_current_value</code>'
				)
			);

			/**
			 * Deprecated: Filter the sanitized font choice.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $value    The chosen font value.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_font_choice', $sanitized_value );
		}

		return $sanitized_value;
	}

	/**
	 * Add items to the array of parameters to feed into the sanitize callback.
	 *
	 * @since 1.7.0.
	 *
	 * @param  mixed     $value
	 * @param  string    $callback
	 * @param  string    $setting_id
	 *
	 * @return array
	 */
	public function add_sanitize_choice_parameters( $value, $callback, $setting_id ) {
		// Only run this in the proper hook context.
		if ( 'make_settings_thememod_sanitize_callback_parameters' !== current_filter() ) {
			return $value;
		}

		$choice_settings = array_merge(
			array_keys( $this->get_settings( 'choice_set_id' ), true ),
			array_keys( $this->get_settings( 'is_font' ), true )
		);

		if ( in_array( $setting_id, $choice_settings ) ) {
			$value = (array) $value;
			$value[] = $setting_id;
		}

		return $value;
	}

	/**
	 * Wrap setting values that are arrays in another array so that the data will remain intact
	 * when it passes through call_user_func_array().
	 *
	 * @since 1.7.0.
	 *
	 * @param $value
	 * @param $callback
	 * @param $setting_id
	 *
	 * @return array
	 */
	public function wrap_array_values( $value, $callback, $setting_id ) {
		// Only run this in the proper hook context.
		if ( 'make_settings_thememod_sanitize_callback_parameters' !== current_filter() ) {
			return $value;
		}

		if ( in_array( $setting_id, array_keys( $this->get_settings( 'is_array' ), true ) ) ) {
			$value = array( $value );
		}

		return $value;
	}

	/**
	 * Sanitize the value of the font-subset setting.
	 *
	 * @since 1.7.0.
	 *
	 * @param  string    $value
	 *
	 * @return string
	 */
	public function sanitize_google_font_subset( $value ) {
		// Make sure the Google font source is available.
		if ( ! $this->font()->has_source( 'google' ) ) {
			return '';
		}

		$sanitized_value = $this->font()->get_source( 'google' )->sanitize_subset( $value, $this->get_default( 'font-subset' ) );

		// Check for deprecated filter
		if ( has_filter( 'make_sanitize_font_subset' ) ) {
			$this->compatibility()->deprecated_hook(
				'make_sanitize_font_subset',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make' ),
					'<code>make_settings_thememod_current_value</code>'
				)
			);

			/**
			 * Filter the sanitized subset choice.
			 *
			 * @since 1.2.3.
			 * @deprecated 1.7.0.
			 *
			 * @param string    $value    The chosen subset value.
			 */
			$sanitized_value = apply_filters( 'make_sanitize_font_subset', $value );
		}

		return $sanitized_value;
	}

	/**
	 * Sanitize the individual items in the social icons array.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $icon_data
	 *
	 * @return array
	 */
	public function sanitize_socialicons( array $icon_data ) {
		$sanitized_icon_data = array();

		// Options
		$settings = array_keys( $this->get_settings( 'social_icon_option' ) );
		foreach ( $settings as $setting_id ) {
			$option_id = str_replace( 'social-icons-', '', $setting_id );
			if ( isset( $icon_data[ $option_id ] ) ) {
				$sanitized_icon_data[ $option_id ] = $this->sanitize_value( $icon_data[ $option_id ], $setting_id );
			} else {
				$sanitized_icon_data[ $option_id ] = $this->get_default( $setting_id );
			}
		}

		// Items
		if ( isset( $icon_data['items'] ) && is_array( $icon_data['items'] ) ) {
			$raw_items = $icon_data['items'];
		} else {
			$raw_items = array();
		}
		$sanitized_icon_data['items'] = array();
		foreach ( $raw_items as $key => $item ) {
			$item = wp_parse_args( (array) $item, array( 'type' => '', 'content' => '' ) );
			$sanitized_icon_data['items'][ $key ] = array();
			$sanitized_icon_data['items'][ $key ]['type'] = $type = $this->sanitize_value( $item['type'], 'social-icons-item-type' );
			$sanitized_icon_data['items'][ $key ]['content'] = $this->sanitize_value( $item['content'], 'social-icons-item-content-' . $type );
		}

		// Email item
		if ( true === $sanitized_icon_data[ 'email-toggle' ] && ! in_array( 'email', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			array_push(
				$sanitized_icon_data['items'],
				array(
					'type'    => 'email',
					'content' => $this->get_default( 'social-icons-item-content-email' ),
				)
			);
		} else if ( true !== $sanitized_icon_data[ 'email-toggle' ] && $key = array_search( 'email', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			unset( $sanitized_icon_data['items'][ $key ] );
		}

		// RSS item
		if ( true === $sanitized_icon_data[ 'rss-toggle' ] && ! in_array( 'rss', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			array_push(
				$sanitized_icon_data['items'],
				array(
					'type'    => 'rss',
					'content' => $this->get_default( 'social-icons-item-content-rss' ),
				)
			);
		} else if ( true !== $sanitized_icon_data[ 'rss-toggle' ] && $key = array_search( 'rss', wp_list_pluck( $sanitized_icon_data['items'], 'type' ) ) ) {
			unset( $sanitized_icon_data['items'][ $key ] );
		}

		return $sanitized_icon_data;
	}

	/**
	 * Convert the social icons JSON string into an array and sanitize it for storage in the database.
	 *
	 * @since 1.7.0.
	 *
	 * @param $json
	 *
	 * @return array
	 */
	public function sanitize_socialicons_from_customizer( $json ) {
		$value = json_decode( $json, true );
		return $this->sanitize_socialicons( $value );
	}

	/**
	 * Sanitize the social icons array from the database for use in the Customizer.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $icon_data
	 *
	 * @return bool|false|string
	 */
	public function sanitize_socialicons_to_customizer( array $icon_data ) {
		$value = $this->sanitize_socialicons( $icon_data );
		return wp_json_encode( $value );
	}

	/**
	 * Clear values for settings that have the is_cache property.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function clear_thememod_cache() {
		// Only run this in the proper hook context.
		if ( ! in_array( current_action(), array( 'customize_save_after' ) ) ) {
			return;
		}

		$cache_settings = array_keys( $this->get_settings( 'is_cache' ), true );

		foreach ( $cache_settings as $setting_id ) {
			$this->unset_value( $setting_id );
		}
	}
}