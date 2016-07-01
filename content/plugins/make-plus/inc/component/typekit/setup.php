<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Typekit_Setup
 *
 * Add support for Typekit fonts.
 *
 * @since 1.0.0.
 * @since 1.7.0. Changed class name from TTFMP_Typekit.
 */
final class MAKEPLUS_Component_Typekit_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Component_Typekit_SetupInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'theme' => 'MAKE_APIInterface',
	);

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

		// Register the setting
		add_action( 'make_settings_thememod_loaded', array( $this, 'add_setting' ) );

		// Add the font source
		add_action( 'make_font_loaded', array( $this, 'add_typekit_source' ) );

		// Setup the Customizer
		add_action( 'customize_register', array( $this, 'setup_control_types' ) );
		add_action( 'customize_register', array( $this, 'add_control' ), 20 );

		// Preview kit fonts
		add_filter( 'theme_mod_typekit-id', array( $this, 'preview_kit_id' ) );

		// Enqueue scripts
		add_action( 'customize_controls_enqueue_scripts', array( $this, 'enqueue_customizer_controls_scripts' ) );
		add_action( 'customize_preview_init', array( $this, 'enqueue_customizer_preview_scripts' ) );

		// Add to preview font data
		add_filter( 'make_preview_font_data', array( $this, 'add_preview_font_data' ), 10, 2 );

		// Refresh kit Ajax
		add_action( 'wp_ajax_makeplus-typekit-refresh', array( $this, 'refresh_kit_ajax' ) );

		// Add the font loader script and styles on the front end
		add_action( 'wp_head', array( $this, 'print_typekit_loader_script' ), 1 );

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
	 * Register the Theme Mod setting.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_settings_thememod_loaded
	 *
	 * @param MAKE_Settings_ThemeMod $thememod
	 *
	 * @return bool
	 */
	public function add_setting( MAKE_Settings_ThemeMod $thememod ) {
		return $thememod->add_settings( array(
			'typekit-id' => array(
				'default'  => '',
				'sanitize' => array( $this, 'sanitize_id' ),
			),
			'typekit-fonts' => array(
				'default'  => array(),
				'sanitize' => array( $this, 'sanitize_fonts' ),
				'is_array' => true,
				'is_cache' => true,
			),
		) );
	}

	/**
	 * Ensure that Typekit IDs are [a-z0-9] only.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $value    The dirty ID.
	 *
	 * @return string          The clean ID.
	 */
	public function sanitize_id( $value ) {
		$value = trim( $value );

		if ( preg_match( '/[^0-9a-zA-Z]+/', $value ) ) {
			return '';
		}

		return strtolower( $value );
	}

	/**
	 * Sanitize an array of data for the currently set font kit.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $fonts
	 *
	 * @return array
	 */
	public function sanitize_fonts( $fonts ) {
		if ( ! is_array( $fonts ) ) {
			return array();
		}

		// Kit ID
		$kit_id = ( isset( $fonts['kit_id'] ) && $fonts['kit_id'] ) ? $this->sanitize_id( $fonts['kit_id'] ) : false;

		// Choices
		$choices = array();
		if ( isset( $fonts['choices'] ) && is_array( $fonts['choices'] ) ) {
			foreach ( $fonts['choices'] as $key => $data ) {
				$key = wp_strip_all_tags( $key );
				$label = ( isset( $data['label'] ) ) ? wp_strip_all_tags( $data['label'] ) : '';
				$stack = ( isset( $data['stack'] ) ) ? wp_strip_all_tags( $data['stack'] ) : '';
				$variants = ( isset( $data['variants'] ) && is_array( $data['variants'] ) ) ? array_map( 'wp_strip_all_tags', $data['variants'] ) : array();

				if ( $key && $label && $stack && ! empty( $variants ) ) {
					$choices[ $key ] = array(
						'label'    => $label,
						'stack'    => $stack,
						'variants' => $variants,
					);
				}
			}
		}

		// Return the data if both exist.
		if ( $kit_id && ! empty( $choices ) ) {
			return array(
				'kit_id'  => $kit_id,
				'choices' => $choices,
			);
		}

		return array();
	}

	/**
	 * Add the Typekit font source.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_font_loaded
	 *
	 * @param MAKE_Font_Manager $font
	 *
	 * @return bool
	 */
	public function add_typekit_source( MAKE_Font_Manager $font ) {
		$source = new MAKEPLUS_Component_Typekit_Source( $this->theme() );
		return $font->add_source( 'typekit', $source );
	}

	/**
	 * Preliminary setup for the custom control class.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_register
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function setup_control_types( WP_Customize_Manager $wp_customize ) {
		$wp_customize->register_control_type( 'MAKEPLUS_Component_Typekit_Control' );
	}

	/**
	 * Add the Typekit section and control to the Customizer.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_register
	 *
	 * @param WP_Customize_Manager $wp_customize
	 *
	 * @return void
	 */
	public function add_control( WP_Customize_Manager $wp_customize ) {
		// Typekit section
		$panel_id = 'ttfmake_typography';
		$section_id = 'ttfmake_font-typekit';
		$section_args = array(
			'title' => __( 'Typekit Fonts', 'make-plus' ),
			'description' => esc_html__( 'Add fonts from Typekit to the font list by entering your kit ID. Refresh your kit after publishing new kit settings.', 'make-plus' ),
		);
		if ( $wp_customize->get_panel( $panel_id ) ) {
			$panel_sections = $this->theme()->customizer_controls()->get_panel_sections( $wp_customize, $panel_id );
			$last_priority = (int) $this->theme()->customizer_controls()->get_last_priority( $panel_sections );

			$section_args['panel'] = $panel_id;
			$section_args['priority'] = $last_priority + 5;
		}
		$wp_customize->add_section( $section_id, $section_args );

		// Setting
		$setting_id = 'typekit-id';
		$wp_customize->add_setting( $setting_id, array(
			'default'              => $this->theme()->thememod()->get_default( $setting_id ),
			'sanitize_callback'    => array( $this->theme()->customizer_controls(), 'sanitize' ),
			'sanitize_js_callback' => array( $this->theme()->customizer_controls(), 'sanitize_js' ),
			'transport'            => 'postMessage',
		) );

		// Control
		$control_id = 'ttfmake_' . $setting_id;
		$wp_customize->add_control( new MAKEPLUS_Component_Typekit_Control( $wp_customize, $control_id, array(
			'settings' => $setting_id,
			'section'  => $section_id,
		) ) );
	}

	/**
	 * Enable a temporary kit ID when retrieving kit data via Ajax.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter theme_mod_typekit-id
	 *
	 * @param string $value
	 *
	 * @return string
	 */
	public function preview_kit_id( $value ) {
		// Only apply the preview on Ajax requests
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$kit_id = ( isset( $_POST['makeplus-typekit-id'] ) ) ? $_POST['makeplus-typekit-id'] : false;

			if ( false !== $kit_id ) {
				$value = $kit_id;
			}
		}

		return $value;
	}

	/**
	 * Enqueue the Customizer controls script and add relevant JS data.
	 *
	 * @since 1.6.5.
	 *
	 * @hooked action customize_controls_enqueue_scripts
	 *
	 * @return void
	 */
	public function enqueue_customizer_controls_scripts() {
		// Control styles
		wp_enqueue_style(
			'makeplus-typekit-customizer-controls',
			makeplus_get_plugin_directory_uri() . 'css/typekit/customizer-controls.css',
			array(),
			MAKEPLUS_VERSION
		);

		// Control script
		wp_enqueue_script(
			'makeplus-typekit-customizer-controls',
			makeplus_get_plugin_directory_uri() . 'js/typekit/customizer-controls.js',
			array( 'jquery', 'make-customizer-controls' ),
			MAKEPLUS_VERSION,
			true
		);

		// Translation strings
		wp_localize_script(
			'makeplus-typekit-customizer-controls',
			'MakePlusTypekit',
			array(
				'webfonturl' => esc_url( $this->theme()->scripts()->get_url( 'web-font-loader', 'script' ) ),
				'spinner'    => esc_url( admin_url( 'images/spinner.gif' ) ),
			)
		);
	}

	/**
	 * Enqueue the Customizer preview script and add relevant JS data.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action customize_preview_init
	 *
	 * @return void
	 */
	public function enqueue_customizer_preview_scripts() {
		// Preview script
		wp_enqueue_script(
			'makeplus-typekit-customizer-preview',
			makeplus_get_plugin_directory_uri() . 'js/typekit/customizer-preview.js',
			array( 'jquery', 'customize-preview', 'make-customizer-preview' ),
			MAKEPLUS_VERSION,
			true
		);
	}

	/**
	 * Add data to the array that gets sent to the Web Font Loader.
	 *
	 * If Typekit fonts are being used, this adds an element to the data array.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked filter make_preview_font_data
	 *
	 * @param array $data
	 * @param array $fonts
	 *
	 * @return array
	 */
	public function add_preview_font_data( array $data, array $fonts ) {
		$typekit_data = array();
		$using = false;

		foreach ( $fonts as $font ) {
			if ( $this->theme()->font()->get_source( 'typekit' )->has_font( $font ) ) {
				$using = true;
				break;
			}
		}

		if ( $using ) {
			$typekit_data['typekit'] = array(
				'id' => $this->theme()->thememod()->get_value( 'typekit-id' ),
			);
		}

		return array_merge( $data, $typekit_data );
	}

	/**
	 * Clear out cached kit data so that it will be retrieved from Typekit again.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action wp_ajax_makeplus-typekit-refresh
	 *
	 * @return void
	 */
	public function refresh_kit_ajax() {
		// Only run this during an Ajax request.
		if ( 'wp_ajax_makeplus-typekit-refresh' !== current_action() ) {
			return;
		}

		$kit_id = ( isset( $_POST['kit_id'] ) ) ? $_POST['kit_id'] : '';
		$cached_data = $this->theme()->thememod()->get_value( 'typekit-fonts' );

		if ( isset( $cached_data['kit_id'] ) && $kit_id === $cached_data['kit_id'] ) {
			$this->theme()->thememod()->unset_value( 'typekit-fonts' );
			wp_send_json_success( $cached_data );
		}

		wp_send_json_success();
	}

	/**
	 * Output a script for asynchronous loading of a Typekit font kit.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action wp_head
	 *
	 * @return void
	 */
	public function print_typekit_loader_script() {
		// Don't add the script in the Customizer preview pane, which uses the Web Font Loader instead
		if ( is_customize_preview() ) {
			return;
		}

		// Kit ID
		$id = $this->theme()->thememod()->get_value( 'typekit-id' );

		// Output the loader scripts
		if ( $id && $this->using_typekit() ) {
			?>
			<link rel="dns-prefetch" href="//use.typekit.net" />
			<?php
			/**
			 * Filter: Modify the async property of the Typekit font loading script.
			 *
			 * @since 1.7.0.
			 *
			 * @param bool $async
			 */
			$async = apply_filters( 'makeplus_typekit_async', false );

			if ( $async ) : ?>
				<!-- Make Plus Typekit Loader, async = true -->
				<script type="text/javascript">
					(function(d) {
						var config = {
								kitId: '<?php echo $id; ?>',
								scriptTimeout: 3000,
								async: true
							},
							h=d.documentElement,
							t=setTimeout(function(){h.className=h.className.replace(/\bmakeplus-typekit-loading\b/g,"")+" makeplus-typekit-inactive";},config.scriptTimeout),
							tk=d.createElement("script"),
							f=false,
							s=d.getElementsByTagName("script")[0],
							a;
						h.className+=" makeplus-typekit-loading";
						tk.src='//use.typekit.net/'+config.kitId+'.js';
						tk.async=true;
						tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};
						s.parentNode.insertBefore(tk,s);
					})(document);
				</script>
			<?php else : ?>
				<!-- Make Plus Typekit Loader, async = false -->
				<script type="text/javascript" src="https://use.typekit.net/<?php echo $id; ?>.js"></script>
				<script type="text/javascript">try{Typekit.load({ async: false });}catch(e){}</script>
			<?php endif;
		}
	}

	/**
	 * Check to see if the theme is set to use any Typekit fonts
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function using_typekit() {
		$font_keys = array_keys( $this->theme()->thememod()->get_settings( 'is_font' ) );
		$fonts = array();

		foreach ( $font_keys as $font_key ) {
			$font = $this->theme()->thememod()->get_value( $font_key );
			if ( $font ) {
				$fonts[] = $font;
			}
		}

		$fonts = array_unique( $fonts );

		foreach ( $fonts as $font ) {
			if ( $this->theme()->font()->get_source( 'typekit' )->has_font( $font ) ) {
				return true;
			}
		}

		return false;
	}
}
