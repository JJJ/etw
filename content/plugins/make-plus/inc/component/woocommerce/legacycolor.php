<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_WooCommerce_Legacy_Color
 *
 * Support color settings for versions of WooCommerce before 2.3.
 *
 * @since 1.5.0.
 * @since 1.7.0. Changed class name from TTFMP_WooCommerce_Legacy_Color.
 */
final class MAKEPLUS_Component_WooCommerce_LegacyColor extends MAKEPLUS_Util_Modules implements MAKEPLUS_Component_WooCommerce_LegacyColorInterface, MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'theme' => 'MAKE_APIInterface',
		'wc'    => 'WooCommerce',
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
	 * MAKEPLUS_Component_WooCommerce_LegacyColor constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface|null $api
	 * @param array                      $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api = null, array $modules = array() ) {
		// Module defaults.
		if ( function_exists( 'WC' ) ) {
			$modules = wp_parse_args( $modules, array(
				'wc' => WC(),
			) );
		}

		// Load dependencies
		parent::__construct( $api, $modules );
	}

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

		// Modify the WooCommerce General Settings page
		add_action( 'woocommerce_settings_general', array( $this, 'modify_wc_settings' ) );

		// Filter the frontend color settings
		add_filter( 'pre_option_woocommerce_frontend_css_colors', array( $this, 'frontend_css_colors' ) );

		// Use a preview version of the WooCommerce stylesheet while in the Theme Customizer
		add_action( 'wp', array( $this, 'compile_preview_styles' ) );

		// Re-compile the WooCommerce CSS file when settings are saved
		add_action( 'customize_save_after', array( $this, 'save_frontend_styles' ) );

		// Add description for Highlight Color control
		add_filter( 'makeplus_ecommerce_colorhighlight_description', array( $this, 'color_highlight_description' ) );

		// Add style definitions
		add_action( 'make_style_loaded', array( $this, 'add_styles' ) );

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
	 * Replace the color pickers in the Frontend styles section of the UI with a note
	 * directing users to the Customizer.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action woocommerce_settings_general
	 *
	 * @return void
	 */
	public function modify_wc_settings() {
		// Determine the callback to remove
		$callback = $this->has_method_filter( 'woocommerce_admin_field_frontend_styles', 'WC_Settings_General', 'frontend_styles_setting' );

		if ( false !== $callback ) {
			// Replace the Frontend styles options in WooCommerce settings with
			// blurb about settings in the Customizer
			remove_action( 'woocommerce_admin_field_frontend_styles', $callback );
			add_action( 'woocommerce_admin_field_frontend_styles', array( $this, 'frontend_styles_setting' ) );
		}
	}

	/**
	 * Add Frontend styles message.
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action woocommerce_admin_field_frontend_styles
	 *
	 * @return void
	 */
	public function frontend_styles_setting() {
		?>
		<tr valign="top" class="woocommerce_frontend_css_colors">
			<th scope="row" class="titledesc">
				<?php esc_html_e( 'Frontend Styles', 'make-plus' ); ?>
			</th>
			<td class="forminp">
				<span class="description">
			<?php // File writability check
			$base_file = $this->wc()->plugin_path() . '/assets/css/woocommerce-base.less';
			$css_file  = $this->wc()->plugin_path() . '/assets/css/woocommerce.css';
			if ( is_writable( $base_file ) && is_writable( $css_file ) ) {
				// Get the URL
				$url = add_query_arg( 'return', urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ), admin_url( 'customize.php' ) );
				$shop = get_option( 'woocommerce_shop_page_id' );
				if ( $shop ) {
					$url = add_query_arg( 'url', urlencode( get_permalink( $shop ) ), $url );
				}
				// Add the message
				printf(
					// Translators: %s is a placeholder for a link to the Customizer
					wp_kses( __( 'These styles can be customized in the Color &rarr; Global section of the <a href="%s">Customizer</a>.', 'make-plus' ), array( 'a' => array( 'href' => true ) ) ),
					esc_url( $url )
				);
			} else {
				echo __( 'To edit colours <code>woocommerce/assets/css/woocommerce-base.less</code> and <code>woocommerce.css</code> need to be writable. See <a href="http://codex.wordpress.org/Changing_File_Permissions">the Codex</a> for more information.', 'make-plus' );
			}
			?>
				</span>
			</td>
		</tr>
	<?php
	}

	/**
	 * Override the WooCommerce frontend color options with the Make color settings
	 *
	 * @since 1.0.0.
	 *
	 * @hooked filter pre_option_woocommerce_frontend_css_colors
	 *
	 * @param bool $colors    Unused
	 *
	 * @return array          The Make color settings array
	 */
	public function frontend_css_colors( $colors ) {
		$colors = array(
			'primary'    => $this->theme()->thememod()->get_value( 'color-primary' ),
			'secondary'  => $this->theme()->thememod()->get_value( 'color-secondary' ),
			'highlight'  => $this->theme()->thememod()->get_value( 'color-highlight' ),
			'content_bg' => $this->theme()->thememod()->get_value( 'main-background-color' ),
			'subtext'    => $this->theme()->thememod()->get_value( 'color-detail' ),
		);

		return $colors;
	}

	/**
	 * Swap the normal woocommerce CSS file with the preview file in the style queue
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function preview_frontend_styles() {
		if ( ! is_customize_preview() ) {
			return;
		}

		$uploads = wp_upload_dir();
		$preview_file = trailingslashit( $uploads['basedir'] ) . 'ttfmp-woocommerce-preview.css';

		if ( file_exists( $preview_file ) ) {
			wp_dequeue_style( 'woocommerce-general' );
			wp_deregister_style( 'woocommerce-general' );
			wp_enqueue_style(
				'woocommerce-general',
				trailingslashit( $uploads['baseurl'] ) . 'ttfmp-woocommerce-preview.css',
				array(),
				time()
			);
		}
	}

	/**
	 * Build a preview version of the woocommerce CSS file
	 *
	 * Based on woocommerce_compile_less_styles() in version 2.1.9 of WooCommerce
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action wp
	 *
	 * @return void
	 */
	public function compile_preview_styles() {
		if ( ! is_customize_preview() ) {
			return;
		}

		$uploads = wp_upload_dir();

		$colors    = array_map( 'esc_attr', (array) get_option( 'woocommerce_frontend_css_colors' ) );
		$base_file = $this->wc()->plugin_path() . '/assets/css/woocommerce-base.less';
		$less_file = $this->wc()->plugin_path() . '/assets/css/woocommerce.less';
		$css_file  = trailingslashit( $uploads['basedir'] ) . 'ttfmp-woocommerce-preview.css';

		if ( ! file_exists( $css_file ) ) {
			$new_file = file_put_contents( $css_file, '' );
			if ( false === $new_file ) {
				return;
			}
		}

		if ( is_writable( $base_file ) && is_writable( $css_file ) ) {
			if ( ! class_exists( 'lessc' ) ) {
				include_once( $this->wc()->plugin_path() . '/includes/libraries/class-lessc.php' );
			}
			if ( ! class_exists( 'cssmin' ) ) {
				include_once( $this->wc()->plugin_path() . '/includes/libraries/class-cssmin.php' );
			}

			try {
				// Write new color to base file
				$color_rules = "
@primary:       " . $colors['primary'] . ";
@primarytext:   " . wc_light_or_dark( $colors['primary'], 'desaturate(darken(@primary,50%),18%)', 'desaturate(lighten(@primary,50%),18%)' ) . ";

@secondary:     " . $colors['secondary'] . ";
@secondarytext: " . wc_light_or_dark( $colors['secondary'], 'desaturate(darken(@secondary,60%),18%)', 'desaturate(lighten(@secondary,60%),18%)' ) . ";

@highlight:     " . $colors['highlight'] . ";
@highlightext:  " . wc_light_or_dark( $colors['highlight'], 'desaturate(darken(@highlight,60%),18%)', 'desaturate(lighten(@highlight,60%),18%)' ) . ";

@contentbg:     " . $colors['content_bg'] . ";

@subtext:       " . $colors['subtext'] . ";
            ";

				// Save the original base for later
				$original_base = file_get_contents( $base_file, null, null, null, 1024 );

				if ( trim( $color_rules ) != trim( $original_base ) ) {
					file_put_contents( $base_file, $color_rules );

					$less         = new lessc;
					$compiled_css = $less->compileFile( $less_file );
					$compiled_css = CssMin::minify( $compiled_css );

					if ( $compiled_css ) {
						file_put_contents( $css_file, $compiled_css );
					}
				}

				// Swap the woocommerce.css file with the new preview file in the style queue
				add_action( 'wp_enqueue_scripts', array( $this, 'preview_frontend_styles' ), 20 );

				// Reset the base
				file_put_contents( $base_file, $original_base );
			} catch ( exception $ex ) {
				wp_die( esc_html__( 'Could not compile woocommerce.less:', 'make-plus' ) . ' ' . $ex->getMessage() );
			}
		}
	}

	/**
	 * Re-compile the WooCommerce stylesheet when color changes are saved
	 *
	 * @since 1.0.0.
	 *
	 * @hooked action customize_save_after
	 *
	 * @return void
	 */
	public function save_frontend_styles() {
		// Load the LESS compile function
		if ( class_exists( 'WC' ) && ! function_exists( 'woocommerce_compile_less_styles' ) ) {
			// Include the file with the compile function
			$file = $this->wc()->plugin_path() . '/includes/admin/wc-admin-functions.php';
			if ( file_exists( $file ) ) {
				include_once( $file );
			}
		}

		// If the function was successfully loaded, run it
		if ( function_exists( 'woocommerce_compile_less_styles' ) ) {
			woocommerce_compile_less_styles();
		}
	}

	/**
	 * Utility function to determine if an action/filter hook has a particular class method added to it.
	 *
	 * @since 1.0.0.
	 *
	 * @param string $tag       The action/filter hook tag.
	 * @param string $class     The class.
	 * @param string $method    The class method.
	 *
	 * @return bool|string      The encoded class/method id attached to the hook.
	 */
	private function has_method_filter( $tag, $class, $method ) {
		global $wp_filter;
		$callback = false;

		if ( isset( $wp_filter[$tag] ) ) {
			foreach ( $wp_filter[$tag] as $priority ) {
				foreach ( $priority as $cb => $action ) {
					if ( is_array( $action['function'] ) && $class === get_class( $action['function'][0] ) && $method === $action['function'][1] ) {
						$callback = $cb;
						break;
					}
				}
				if ( false !== $callback ) {
					break;
				}
			}
		}

		return $callback;
	}

	/**
	 * Add a description to the Highlight Color control.
	 *
	 * @since 1.5.0.
	 *
	 * @hooked filter makeplus_ecommerce_colorhighlight_description
	 *
	 * @param string $text
	 *
	 * @return string
	 */
	public function color_highlight_description( $text ) {
		$description = esc_html__( 'For WooCommerce, used for prices, in stock labels, and sales flash.', 'make-plus' );

		if ( '' !== $text ) {
			$text .= '<br />';
		}

		return $text . $description;
	}

	/**
	 * Add styles.
	 *
	 * The $style parameter is used within the included file.
	 *
	 * @since 1.7.0.
	 *
	 * @hooked action make_style_loaded
	 *
	 * @param MAKE_Style_ManagerInterface $style
	 *
	 * @return void
	 */
	public function add_styles( MAKE_Style_ManagerInterface $style ) {
		// Load the style definitions
		$file = dirname( __FILE__ ) . '/legacycolor-definitions.php';
		if ( is_readable( $file ) ) {
			include $file;
		}
	}
}