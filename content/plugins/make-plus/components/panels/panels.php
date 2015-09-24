<?php
/**
 * @package Make Plus
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class TTFMP_Panels
 *
 * Class to initialize the Panels module, load files, and hook into WordPress.
 *
 * @since 1.6.0.
 */
class TTFMP_Panels {
	/**
	 * Name of the component.
	 *
	 * @since 1.6.0.
	 *
	 * @var   string    The name of the component.
	 */
	var $component_slug = 'panels';

	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.6.0.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * File path to the plugin main file (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component/my-component.php).
	 *
	 * @since 1.6.0.
	 *
	 * @var   string    Path to the plugin's main file.
	 */
	var $file_path = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.6.0.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * Array of other objects for the module.
	 *
	 * @since 1.6.0.
	 *
	 * @var    array    Array of other objects for the module.
	 */
	var $components = array();

	/**
	 * Set the class properties.
	 *
	 * @since 1.6.0.
	 *
	 * @return TTFMP_Panels
	 */
	public function __construct() {
		// Set the main paths for the component
		$this->component_root = ttfmp_get_app()->component_base . '/' . $this->component_slug;
		$this->file_path      = $this->component_root . '/' . basename( __FILE__ );
		$this->url_base       = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Load files and hook into WordPress.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function init() {
		// Load settings
		require_once( trailingslashit( $this->component_root ) . 'settings.php' );
		$this->components['settings'] = new TTFMP_Panels_Settings;

		// Load definitions
		require_once( trailingslashit( $this->component_root ) . 'definitions.php' );
		$this->components['definitions'] = new TTFMP_Panels_Definitions( $this->component_root, $this->url_base, $this->components['settings'] );
		$this->components['definitions']->init();

		// Enqueue scripts for the Builder UI
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// Print JS templates for the Builder UI
		add_action( 'admin_footer', array( $this, 'print_templates' ) );

		// Enqueue scripts for the frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );

		// Add CSS rules to apply Customizer settings to the section
		add_action( 'make_builder_panels_css', array( $this, 'add_css' ) );
	}

	/**
	 * Enqueue scripts for the Builder UI.
	 *
	 * @since 1.6.0.
	 *
	 * @param  string    $hook_suffix    The current admin page.
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
			'panels',
			$this->url_base . '/css/panels-admin.css',
			array(),
			ttfmp_get_app()->version,
			'screen'
		);

		// Model script
		wp_register_script(
			'panels-model',
			$this->url_base . '/js/panels-model.js',
			array(),
			ttfmp_get_app()->version,
			true
		);

		// View script
		wp_register_script(
			'panels-view',
			$this->url_base . '/js/panels-view.js',
			array( 'panels-model' ),
			ttfmp_get_app()->version,
			true
		);

		// Hook up the new JS dependencies
		add_filter( 'ttfmake_builder_js_dependencies', array( $this, 'admin_add_js_dependencies' ) );
	}

	/**
	 * Filter to add new dependencies to the main Builder JS file.
	 *
	 * @since 1.6.0.
	 *
	 * @param  array    $deps    Existing array of dependencies.
	 *
	 * @return array             Modified array of dependencies.
	 */
	public function admin_add_js_dependencies( $deps ) {
		if ( ! is_array( $deps ) ) {
			$deps = array();
		}

		return array_merge( $deps, array(
			'panels-model',
			'panels-view',
		) );
	}

	/**
	 * Print out section UI markup as JS templates.
	 *
	 * @since 1.6.0.
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
				$item_template = trailingslashit( dirname( __FILE__ ) ) . 'sections/builder-templates/section-item.php';
				require_once( $item_template );
				// Create the template
				$template = new TTFMP_Panels_Builder_Section_Item( array(), $ttfmake_is_js_template, 0, $this->components['settings'] );
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
					'panels-frontend',
					$this->url_base . '/css/panels-frontend.css',
					array(),
					ttfmp_get_app()->version,
					'all'
				);

				// Determine which dependencies are needed
				$script_dependencies = array( 'jquery', 'jquery-ui-core' );
				foreach ( $matched_sections as $section_id ) {
					if ( isset( $sections[ $section_id ]['mode'] ) ) {
						$mode = sanitize_title_with_dashes( $sections[ $section_id ]['mode'] ); // ttfmake_get_section_choices is not available on the frontend currently :(
						if ( ! in_array( 'jquery-ui-' . $mode, $script_dependencies ) ) {
							$script_dependencies[] = 'jquery-ui-' . $mode;
						}
					}
				}

				// Script
				wp_enqueue_script(
					'panels-frontend',
					$this->url_base . '/js/panels-frontend.js',
					$script_dependencies,
					ttfmp_get_app()->version,
					true
				);

				// Strings for JS
				wp_localize_script(
					'panels-frontend',
					'ttfmpPanels',
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
	 * @return void
	 */
	public function add_css() {
		// Secondary color
		$color_secondary = maybe_hash_hex_color( get_theme_mod( 'color-secondary', ttfmake_get_default( 'color-secondary' ) ) );
		if ( $color_secondary !== ttfmake_get_default( 'color-secondary' ) ) {
			ttfmake_get_css()->add( array(
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
			ttfmake_get_css()->add( array(
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
			ttfmake_get_css()->add( array(
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
		$color_text = maybe_hash_hex_color( get_theme_mod( 'color-text', ttfmake_get_default( 'color-text' ) ) );
		if ( $color_text !== ttfmake_get_default( 'color-text' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-widget-content',
					'.builder-section-panels .ui-widget-header',
					'.builder-section-panels .ui-widget-header a',
				),
				'declarations' => array(
					'color' => $color_text
				)
			) );
		}

		// Detail color
		$color_detail = maybe_hash_hex_color( get_theme_mod( 'color-detail', ttfmake_get_default( 'color-detail' ) ) );
		if ( $color_detail !== ttfmake_get_default( 'color-detail' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-state-default',
					'.builder-section-panels .ui-widget-content .ui-state-default',
					'.builder-section-panels .ui-widget-header .ui-state-default',
					'.builder-section-panels .ui-state-default a',
					'.builder-section-panels .ui-state-default a:link',
					'.builder-section-panels .ui-state-default a:visited',
				),
				'declarations' => array(
					'color' => $color_detail
				)
			) );
		}

		// Primary color
		$color_primary = maybe_hash_hex_color( get_theme_mod( 'color-primary', ttfmake_get_default( 'color-primary' ) ) );
		if ( $color_primary !== ttfmake_get_default( 'color-primary' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-widget-content a',
				),
				'declarations' => array(
					'color' => $color_primary,
				)
			) );
			ttfmake_get_css()->add( array(
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
		$color_primary_link = maybe_hash_hex_color( get_theme_mod( 'color-primary-link', ttfmake_get_default( 'color-primary-link' ) ) );
		if ( $color_primary_link && $color_primary_link !== ttfmake_get_default( 'color-primary-link' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.builder-section-panels .ui-accordion-content a:hover',
					'.builder-section-panels .ui-accordion-content a:focus',
					'.builder-section-panels .ui-tabs-panel a:hover',
					'.builder-section-panels .ui-tabs-panel a:focus',
				),
				'declarations' => array(
					'color' => $color_primary_link
				)
			) );
		}

		// Remove action so the styles don't get added more than once
		remove_action( 'make_builder_panels_css', array( $this, __METHOD__ ) );
	}
}

$ttfmp_panels = new TTFMP_Panels;
$ttfmp_panels->init();
