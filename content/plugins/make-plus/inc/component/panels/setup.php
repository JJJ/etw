<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Panels_Setup
 *
 * @since 1.6.0.
 * @since 1.7.0. Changed class name from TTFMP_Panels.
 */
final class MAKEPLUS_Component_Panels_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'theme'           => 'MAKE_APIInterface',
		'panels_settings' => 'MAKEPLUS_Component_Panels_SettingsInterface',
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
	 * MAKEPLUS_Component_Panels_Setup constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface $api
	 * @param array                 $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api, array $modules = array() ) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'panels_settings' => 'MAKEPLUS_Component_Panels_Settings',
		) );

		// Load dependencies.
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

		// Register section defaults
		add_filter( 'make_section_defaults', array( $this, 'section_defaults' ) );

		// Register section choices
		add_filter( 'make_section_choices', array( $this, 'section_choices' ), 10, 3 );

		// Add the section
		if ( is_admin() ) {
			add_action( 'after_setup_theme', array( $this, 'add_section' ), 11 );
		}

		// Enqueue scripts for the Builder UI
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Hook up the new JS dependencies
		add_filter( 'make_builder_js_dependencies', array( $this, 'admin_add_js_dependencies' ) );

		// Print JS templates for the Builder UI
		add_action( 'admin_footer', array( $this, 'print_templates' ) );

		// Enqueue scripts for the frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ), 20 );

		// Add CSS rules to apply Customizer settings to the section
		add_action( 'make_builder_panels_css', array( $this, 'add_css' ), 10, 3 );

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
	 * Add the Panels section to the Builder.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return void
	 */
	public function add_section() {
		// Bail if we aren't in the admin
		if ( ! is_admin() ) {
			return;
		}

		ttfmake_add_section(
			'panels',
			__( 'Panels', 'make-plus' ),
			makeplus_get_plugin_directory_uri() . 'css/panels/img/panels-icon.png',
			__( 'Display content with a series of accordion- or tab-styled panels.', 'make-plus' ),
			array( $this, 'save_section' ),
			'sections/builder-templates/panels',
			'sections/front-end-templates/panels',
			800,
			makeplus_get_plugin_directory() . 'inc/component/panels',
			array(
				100 => array(
					'type'  => 'section_title',
					'name'  => 'title',
					'label' => __( 'Enter section title', 'make-plus' ),
					'class' => 'ttfmake-configuration-title ttfmake-section-header-title-input',
					'default' => ttfmake_get_section_default( 'title', 'panels' ),
				),
				200 => array(
					'type'    => 'select',
					'name'    => 'mode',
					'label'   => __( 'Mode', 'make-plus' ),
					'class'   => 'ttfmp-panels-mode',
					'default' => ttfmake_get_section_default( 'mode', 'panels' ),
					'options' => ttfmake_get_section_choices( 'mode', 'panels' ),
				),
				300 => array(
					'type'    => 'select',
					'name'    => 'height-style',
					'label'   => __( 'Section height', 'make-plus' ),
					'class'   => 'ttfmp-panels-height-style',
					'default' => ttfmake_get_section_default( 'height-style', 'panels' ),
					'options' => ttfmake_get_section_choices( 'height-style', 'panels' ),
				),
				400 => array(
					'type'  => 'image',
					'name'  => 'background-image',
					'label' => __( 'Background image', 'make-plus' ),
					'class' => 'ttfmake-configuration-media',
					'default' => ttfmake_get_section_default( 'background-image', 'panels' ),
				),
				500 => array(
					'type'    => 'checkbox',
					'label'   => __( 'Darken background to improve readability', 'make-plus' ),
					'name'    => 'background-image-darken',
					'default' => ttfmake_get_section_default( 'background-image-darken', 'panels' ),
				),
				600 => array(
					'type'    => 'select',
					'name'    => 'background-image-style',
					'label'   => __( 'Background image style', 'make-plus' ),
					'class'   => 'ttfmp-panels-mode',
					'default' => ttfmake_get_section_default( 'background-image-style', 'panels' ),
					'options' => ttfmake_get_section_choices( 'background-image-style', 'panels' ),
				),
				700 => array(
					'type'    => 'color',
					'label'   => __( 'Background color', 'make-plus' ),
					'name'    => 'background-color',
					'class'   => 'ttfmake-panels-background-color ttfmake-configuration-color-picker',
					'default' => ttfmake_get_section_default( 'background-color', 'panels' ),
				),
			)
		);
	}

	/**
	 * Extract the setting defaults and add them to Make's section defaults system.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked filter make_section_defaults
	 *
	 * @param array $defaults    The existing array of section defaults.
	 *
	 * @return array             The modified array of section defaults.
	 */
	public function section_defaults( $defaults ) {
		$setting_defaults = $this->panels_settings()->get_settings( 'default' );
		$new_defaults = array();
		foreach ( $setting_defaults as $setting_key => $default ) {
			$new_defaults[ 'panels-' . $setting_key ] = $default;
		}
		
		return array_merge( $defaults, $new_defaults );
	}

	/**
	 * Define choices for select-style settings and add them to Make's section choices system.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked filter make_section_choices
	 *
	 * @param array  $choices         The array to hold the choices.
	 * @param string $key             The setting key.
	 * @param string $section_type    The type of section.
	 *
	 * @return array                  The modified array containing the choices.
	 */
	public function section_choices( $choices, $key, $section_type ) {
		if ( count( $choices ) > 1 || ! in_array( $section_type, array( 'panels' ) ) ) {
			return $choices;
		}

		$choice_id = "$section_type-$key";

		switch ( $choice_id ) {
			case 'panels-mode' :
				$choices = array(
					'accordion' => __( 'Accordion', 'make-plus' ),
					'tabs' => __( 'Tabs', 'make-plus' ),
				);
				break;
			case 'panels-background-image-style' :
				$choices = array(
					'tile' => __( 'Tile', 'make-plus' ),
					'cover' => __( 'Cover', 'make-plus' ),
				);
				break;
			case 'panels-height-style' :
				$choices = array(
					'auto' => __( 'Set to largest panel', 'make-plus' ),
					'content' => __( 'Scale to current panel', 'make-plus' ),
				);
				break;
		}

		return $choices;
	}

	/**
	 * Callback to save the Panels section data.
	 *
	 * @since 1.6.0.
	 *
	 * @param array $data    The array of section data to process.
	 *
	 * @return array         The processed array of data.
	 */
	public function save_section( $data ) {
		// Section type, state, and ID are handled by the Builder's core save function
		$ignore = array( 'section-type', 'state', 'id' );
		foreach ( $ignore as $key ) {
			if ( isset( $data[ $key ] ) ) {
				unset( $data[ $key ] );
			}
		}

		// Checkbox fields will not be set if they are unchecked.
		$checkboxes = array( 'background-image-darken' );
		foreach ( $checkboxes as $key ) {
			if ( ! isset( $data[$key] ) ) {
				$data[$key] = 0;
			}
		}

		// Get defaults and parse
		$defaults = $this->panels_settings()->get_settings( 'default' );
		$parsed_data = wp_parse_args( $data, $defaults );

		// Set up multi-parameter sanitization
		$parsed_data['mode'] = array( $parsed_data['mode'], 'mode', 'panels' );
		$parsed_data['height-style'] = array( $parsed_data['height-style'], 'height-style', 'panels' );
		$parsed_data['background-image-style'] = array( $parsed_data['background-image-style'], 'background-image-style', 'panels' );

		// Label
		if ( ! $parsed_data['label'] ) {
			$parsed_data['label'] = $parsed_data['title'];
		}

		// Clean data
		$clean_data = array();

		// Panel item data
		$panels_items = array();
		if ( isset( $parsed_data['panels-items'] ) ) {
			$panels_items = $parsed_data['panels-items'];
			unset( $parsed_data['panels-items'] );
		}

		// Sanitize panel item data first
		$clean_data_items = array();
		if ( ! empty( $panels_items ) ) {
			foreach ( $panels_items as $id => $item ) {
				if ( is_array( $item ) ) {
					foreach ( $item as $setting_key => $value ) {
						if ( isset( $defaults[ $setting_key ] ) ) {
							$sanitized_value = $this->panels_settings()->sanitize_value( $value, $setting_key );

							if ( null === $sanitized_value ) {
								$sanitized_value = $defaults[ $setting_key ];
							}

							$clean_data_items[ $id ][ $setting_key ] = $sanitized_value;
						}
					}
				}
			}
		}

		// Sanitize main section data
		foreach ( $parsed_data as $setting_key => $value ) {
			if ( isset( $defaults[ $setting_key ] ) ) {
				$sanitized_value = $this->panels_settings()->sanitize_value( $value, $setting_key );

				if ( null === $sanitized_value ) {
					$sanitized_value = $defaults[ $setting_key ];
				}

				$clean_data[ $setting_key ] = $sanitized_value;
			}
		}

		// Add the sanitized panel items back in
		$clean_data['panels-items'] = $clean_data_items;

		return $clean_data;
	}

	/**
	 * Enqueue scripts for the Builder UI.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 *
	 * @param string $hook_suffix    The current admin page.
	 *
	 * @return void
	 */
	public function admin_scripts( $hook_suffix ) {
		// Only load resources if they are needed on the current page
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) || ! ttfmake_post_type_supports_builder( get_post_type() ) ) {
			return;
		}

		// Stylesheet
		wp_enqueue_style(
			'makeplus-panels-admin',
			makeplus_get_plugin_directory_uri() . 'css/panels/admin.css',
			array(),
			MAKEPLUS_VERSION,
			'screen'
		);

		// Model script
		wp_register_script(
			'makeplus-panels-model',
			makeplus_get_plugin_directory_uri() . 'js/panels/builder-model.js',
			array(),
			MAKEPLUS_VERSION,
			true
		);

		// View script
		wp_register_script(
			'makeplus-panels-view',
			makeplus_get_plugin_directory_uri() . 'js/panels/builder-view.js',
			array( 'makeplus-panels-model' ),
			MAKEPLUS_VERSION,
			true
		);
	}

	/**
	 * Filter to add new dependencies to the main Builder JS file.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked filter make_builder_js_dependencies
	 *
	 * @param array $deps    Existing array of dependencies.
	 *
	 * @return array         Modified array of dependencies.
	 */
	public function admin_add_js_dependencies( $deps ) {
		if ( ! is_array( $deps ) ) {
			$deps = array();
		}

		return array_merge( $deps, array(
			'makeplus-panels-model',
			'makeplus-panels-view',
		) );
	}

	/**
	 * Print out section UI markup as JS templates.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked action admin_footer
	 *
	 * @return void
	 */
	public function print_templates() {
		global $hook_suffix, $typenow, $ttfmake_is_js_template;

		$ttfmake_is_js_template = true;

		// Only show when adding/editing pages
		if ( ! ttfmake_post_type_supports_builder( $typenow ) || ! in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )) {
			return;
		}

		// Print the templates
		?>
		<script type="text/html" id="tmpl-ttfmake-panels-item">
			<?php
			// Load the file for the section item class
			$item_template = dirname( __FILE__ ) . '/sections/builder-templates/section-item.php';
			require_once( $item_template );

			// Create the template
			$template = new TTFMP_Panels_Builder_Section_Item( array(), $ttfmake_is_js_template, 0, $this->panels_settings() );
			$template->render();
			?>
		</script>
		<?php

		unset( $GLOBALS['ttfmake_is_js_template'] );
	}

	/**
	 * Enqueue scripts for the section on the frontend, if the current page has it.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked action wp_enqueue_scripts
	 *
	 * @return void
	 */
	public function frontend_scripts() {
		if ( function_exists( 'ttfmake_is_builder_page' ) && ttfmake_is_builder_page() ) {
			$sections = ttfmake_get_section_data( get_the_ID() );
			
			// Bail if there are no sections
			if ( empty( $sections ) ) {
				return;
			}
			
			// Parse the sections included on the page.
			$section_types = wp_list_pluck( $sections, 'section-type' );
			$matched_sections = array_keys( $section_types, 'panels' );

			// Only enqueue if there is at least one Panels section.
			if ( ! empty( $matched_sections ) ) {
				// Stylesheet
				wp_enqueue_style(
					'makeplus-panels-frontend',
					makeplus_get_plugin_directory_uri() . 'css/panels/frontend.css',
					array(),
					MAKEPLUS_VERSION,
					'all'
				);

				// If current theme is a child theme of Make, load the stylesheet
				// before the child theme stylesheet so styles can be customized.
				if ( $this->has_module( 'theme' ) && is_child_theme() ) {
					$this->theme()->scripts()->add_dependency( 'make-main', 'makeplus-panels-frontend', 'style' );
				}

				// Determine which dependencies are needed
				$script_dependencies = array( 'jquery', 'jquery-ui-core', 'make-frontend' );
				foreach ( $matched_sections as $section_id ) {
					if ( isset( $sections[ $section_id ]['mode'] ) ) {
						$mode = sanitize_key( $sections[ $section_id ]['mode'] ); // ttfmake_get_section_choices is not available on the frontend currently :(
						if ( ! in_array( 'jquery-ui-' . $mode, $script_dependencies ) ) {
							$script_dependencies[] = 'jquery-ui-' . $mode;
						}
					}
				}

				// Script
				wp_enqueue_script(
					'makeplus-panels-frontend',
					makeplus_get_plugin_directory_uri() . 'js/panels/frontend.js',
					$script_dependencies,
					MAKEPLUS_VERSION,
					true
				);

				// Strings for JS
				wp_localize_script(
					'makeplus-panels-frontend',
					'MakePlusPanels',
					array(
						'tabsPlaceholder' => sprintf(
						// Translators: %s is a placeholder for a link to a bug report
							__( 'Panels sections in Tabs mode won\'t work correctly in the Customizer because of a bug in WordPress (%s). However, they\'ll still work on the front end.', 'make-plus' ),
							sprintf(
								'<a href="%1$s" target="_blank">%1$s</a>',
								esc_url( 'https://core.trac.wordpress.org/ticket/23225' )
							)
						)
					)
				);
			}
		}
	}

	/**
	 * Add additional CSS rules for Make's Customizer settings to style the section.
	 *
	 * @since 1.6.0.
	 *
	 * @hooked action make_builder_panels_css
	 *
	 * @param                             $data
	 * @param                             $id
	 * @param MAKE_Style_ManagerInterface $style
	 *
	 * @return void
	 */
	public function add_css( $data, $id, MAKE_Style_ManagerInterface $style ) {
		// Secondary color
		if ( ! $style->thememod()->is_default( 'color-secondary' ) ) {
			$color_secondary = $style->thememod()->get_value( 'color-secondary' );

			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-state-hover',
					'.builder-section-panels .ui-widget-content .ui-state-hover',
					'.builder-section-panels .ui-widget-header .ui-state-hover',
					'.builder-section-panels .ui-state-focus',
					'.builder-section-panels .ui-widget-content .ui-state-focus',
					'.builder-section-panels .ui-widget-header .ui-state-focus',
					'.builder-section-panels .ui-state-hover a',
					'.builder-section-panels .ui-state-hover a:hover',
					'.builder-section-panels .ui-state-hover a:link',
					'.builder-section-panels .ui-state-hover a:visited',
					'.builder-section-panels .ui-state-focus a',
					'.builder-section-panels .ui-state-focus a:hover',
					'.builder-section-panels .ui-state-focus a:link',
					'.builder-section-panels .ui-state-focus a:visited',
					'.builder-section-panels .ui-state-active',
					'.builder-section-panels .ui-widget-content .ui-state-active',
					'.builder-section-panels .ui-widget-header .ui-state-active',
					'.builder-section-panels .ui-state-active a',
					'.builder-section-panels .ui-state-active a:link',
					'.builder-section-panels .ui-state-active a:visited',
				),
				'declarations' => array(
					'color' => $color_secondary,
				)
			) );
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-widget-header',
					'.builder-section-panels .ui-state-default',
					'.builder-section-panels .ui-widget-content .ui-state-default',
					'.builder-section-panels .ui-widget-header .ui-state-default',
				),
				'declarations' => array(
					'background-color' => $color_secondary
				)
			) );
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-state-default',
					'.builder-section-panels .ui-widget-content .ui-state-default',
					'.builder-section-panels .ui-widget-header .ui-state-default',
				),
				'declarations' => array(
					'border-color' => $color_secondary
				)
			) );
		}

		// Text color
		if ( ! $style->thememod()->is_default( 'color-text' ) ) {
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-widget-content',
					'.builder-section-panels .ui-widget-header',
					'.builder-section-panels .ui-widget-header a',
				),
				'declarations' => array(
					'color' => $style->thememod()->get_value( 'color-text' )
				)
			) );
		}

		// Detail color
		if ( ! $style->thememod()->is_default( 'color-detail' ) ) {
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-state-default',
					'.builder-section-panels .ui-widget-content .ui-state-default',
					'.builder-section-panels .ui-widget-header .ui-state-default',
					'.builder-section-panels .ui-state-default a',
					'.builder-section-panels .ui-state-default a:link',
					'.builder-section-panels .ui-state-default a:visited',
				),
				'declarations' => array(
					'color' => $style->thememod()->get_value( 'color-detail' )
				)
			) );
		}

		// Primary color
		if ( ! $style->thememod()->is_default( 'color-primary' ) ) {
			$color_primary = $style->thememod()->get_value( 'color-primary' );

			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-widget-content a',
				),
				'declarations' => array(
					'color' => $color_primary,
				)
			) );
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-state-hover',
					'.builder-section-panels .ui-widget-content .ui-state-hover',
					'.builder-section-panels .ui-widget-header .ui-state-hover',
					'.builder-section-panels .ui-state-focus',
					'.builder-section-panels .ui-widget-content .ui-state-focus',
					'.builder-section-panels .ui-widget-header .ui-state-focus',
					'.builder-section-panels .ui-state-active',
					'.builder-section-panels .ui-widget-content .ui-state-active',
					'.builder-section-panels .ui-widget-header .ui-state-active',
				),
				'declarations' => array(
					'background-color' => $color_primary,
					'border-color' => $color_primary,
				)
			) );
		}

		// Link Hover/Focus Color
		if ( ! $style->thememod()->is_default( 'color-primary-link' ) ) {
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-accordion-content a:hover',
					'.builder-section-panels .ui-accordion-content a:focus',
					'.builder-section-panels .ui-tabs-panel a:hover',
					'.builder-section-panels .ui-tabs-panel a:focus',
				),
				'declarations' => array(
					'color' => $style->thememod()->get_value( 'color-primary-link' )
				)
			) );
		}

		// Remove action so the styles don't get added more than once
		remove_action( 'make_builder_panels_css', array( $this, __METHOD__ ) );
	}
}