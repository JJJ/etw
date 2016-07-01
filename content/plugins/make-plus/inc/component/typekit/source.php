<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_Typekit_Source
 *
 * @since 1.7.0.
 */
final class MAKEPLUS_Component_Typekit_Source extends MAKE_Font_Source_Base implements MAKEPLUS_Util_LoadInterface {
	/**
	 * An associative array of required modules.
	 *
	 * These dependencies are from Make instead of Make Plus because the source gets loaded into Make's Font module.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'error'    => 'MAKE_Error_CollectorInterface',
		'thememod' => 'MAKE_Settings_ThemeModInterface',
	);

	/**
	 * Indicator of whether the load routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private $loaded = false;

	/**
	 * MAKEPLUS_Component_Typekit_Source constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKE_APIInterface|null $api
	 * @param array                  $modules
	 */
	public function __construct( MAKE_APIInterface $api = null, array $modules = array() ) {
		// Parent constructor.
		parent::__construct(
			'typekit',
			__( 'Typekit Fonts', 'make-plus' ),
			array(), // Data is loaded separately when needed.
			5,
			$api,
			$modules
		);
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

		$kit_id = $this->thememod()->get_value( 'typekit-id' );
		$kit_fonts = $this->thememod()->get_value( 'typekit-fonts' );

		// Get previously loaded data
		if ( ! empty( $kit_fonts ) && $kit_id === $kit_fonts['kit_id'] ) {
			$this->data = $kit_fonts['choices'];
		}
		// Get data from Typekit using kit ID
		else if ( $kit_id ) {
			$raw_font_data = $this->request_font_data( $kit_id );

			if ( is_array( $raw_font_data ) && ! empty( $raw_font_data ) ) {
				$value = array(
					'kit_id'  => $kit_id,
					'choices' => $raw_font_data,
				);

				$sanitized_font_data = $this->thememod()->sanitize_value( $value, 'typekit-fonts' );

				if ( ! empty( $sanitized_font_data ) ) {
					$this->data = $sanitized_font_data['choices'];

					if ( ! is_admin() && ! is_customize_preview() ) {
						$this->thememod()->set_value( 'typekit-fonts', $sanitized_font_data );
					}
				}
			} else if ( is_string( $raw_font_data ) && $raw_font_data ) {
				$this->error()->add_error( 'makeplus_typekit_loader', $raw_font_data );
			}
		}
		// Remove old data
		else if ( ! empty( $kit_fonts ) && ! $kit_id ) {
			if ( ! is_admin() && ! is_customize_preview() ) {
				$this->thememod()->unset_value( 'typekit-fonts' );
			}
		}

		// Loading has occurred.
		$this->loaded = true;
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
	 * Get a kit's font data via the Typekit API.
	 *
	 * @since 1.7.0.
	 *
	 * @param $kit_id
	 *
	 * @return array|string
	 */
	public function request_font_data( $kit_id ) {
		$api = new MAKEPLUS_Component_Typekit_API( $kit_id );
		$families = $api->get_kit_fonts();

		if ( ! empty( $families ) ) {
			return $this->parse_font_data( $families );
		}

		return $api->get_error();
	}

	/**
	 * Normalize font data from Typekit.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $families
	 *
	 * @return array
	 */
	private function parse_font_data( array $families ) {
		$data = array();

		foreach ( $families as $family ) {
			if ( is_object( $family ) ) {
				$data[ $family->slug ] = array(
					'label'    => $family->name,
					'stack'    => $family->css_stack,
					'variants' => $family->variations,
				);
			}
		}

		return $data;
	}

	/**
	 * Wrapper to ensure the load routine has run before returning the source's font data.
	 *
	 * @since 1.7.0.
	 *
	 * @param string|null $font
	 *
	 * @return array|mixed|void
	 */
	public function get_font_data( $font = null ) {
		// Load the font data if necessary.
		if ( ! $this->is_loaded() ) {
			$this->load();
		}

		return parent::get_font_data( $font );
	}
}