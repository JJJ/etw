<?php
/**
 * @package Make Plus
 */

/**
 * Class TTFMP_Panels_Definitions
 *
 * Class to define the Panels section and hook it into the Make Builder.
 *
 * @since 1.6.0.
 */
class TTFMP_Panels_Definitions {
	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.6.0.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.6.0.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * The injected instance of TTFMP_Panels_Settings.
	 *
	 * @since 1.6.0.
	 *
	 * @var TTFMP_Panels_Settings
	 */
	private $settings;

	/**
	 * Set up the class properties.
	 *
	 * @since 1.6.0.
	 *
	 * @param string                   $component_root    Path to the component directory.
	 * @param string                   $url_base          The URI base for the component.
	 * @param TTFMP_Panels_Settings    $settings          The instance of TTFMP_Panels_Settings to inject.
	 *
	 * @return TTFMP_Panels_Definitions
	 */
	function __construct( $component_root, $url_base, $settings ) {
		// Set component properties
		$this->component_root = $component_root;
		$this->url_base = $url_base;

		// Inject the settings class
		if ( 'TTFMP_Panels_Settings' === get_class( $settings ) ) {
			$this->settings = $settings;
		} else {
			$this->settings = new TTFMP_Panels_Settings;
		}
	}

	/**
	 * Initialize the definitions and hook into the Make Builder.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function init() {
		// Register section defaults
		add_filter( 'make_section_defaults', array( $this, 'section_defaults' ) );

		// Register section choices
		add_filter( 'make_section_choices', array( $this, 'section_choices' ), 10, 3 );

		// Add the section
		if ( is_admin() ) {
			add_action( 'after_setup_theme', array( $this, 'add_section' ), 11 );
		}
	}

	/**
	 * Add the Panels section to the Builder.
	 *
	 * @since 1.6.0.
	 *
	 * @return void
	 */
	public function add_section() {
		ttfmake_add_section(
			'panels',
			__( 'Panels', 'make-plus' ),
			$this->url_base . '/img/panels-icon.png',
			__( 'Display content with a series of accordion- or tab-styled panels.', 'make-plus' ),
			array( $this, 'save_section' ),
			'sections/builder-templates/panels',
			'sections/front-end-templates/panels',
			800,
			$this->component_root,
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
	 * @param  array    $defaults    The existing array of section defaults.
	 *
	 * @return array                 The modified array of section defaults.
	 */
	public function section_defaults( $defaults ) {
		$setting_defaults = $this->settings->get_settings( 'default' );
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
	 * @param array     $choices         The array to hold the choices.
	 * @param string    $key             The setting key.
	 * @param string    $section_type    The type of section.
	 *
	 * @return array                     The modified array containing the choices.
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
	 * @param  array    $data    The array of section data to process.
	 *
	 * @return array             The processed array of data.
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
		$defaults = $this->settings->get_settings( 'default' );
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
						$sanitized_value = $this->settings->sanitize_value( $value, $setting_key );

						if ( null === $sanitized_value ) {
							$sanitized_value = $defaults[ $setting_key ];
						}

						$clean_data_items[ $id ][ $setting_key ] = $sanitized_value;
					}
				}
			}
		}

		// Sanitize main section data
		foreach ( $parsed_data as $setting_key => $value ) {
			$sanitized_value = $this->settings->sanitize_value( $value, $setting_key );
			if ( null === $sanitized_value ) {
				$sanitized_value = $defaults[ $setting_key ];
			}
			$clean_data[ $setting_key ] = $sanitized_value;
		}

		// Add the sanitized panel items back in
		$clean_data['panels-items'] = $clean_data_items;

		return $clean_data;
	}
}