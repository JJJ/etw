<?php
/**
 * @package Make
 */


final class MAKE_Font_Source_Generic extends MAKE_Font_Source_Base {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'compatibility' => 'MAKE_Compatibility_MethodsInterface',
	);

	/**
	 * MAKE_Font_Source_Generic constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKE_APIInterface $api
	 * @param array             $modules
	 */
	public function __construct( MAKE_APIInterface $api = null, array $modules = array() ) {
		// Load dependencies.
		parent::__construct( $api, $modules );

		// Set the ID.
		$this->id = 'generic';

		// Set the label.
		$this->label = __( 'Generic Fonts', 'make' );

		// Set the font data.
		$this->data = array(
			'serif' => array(
				'label' => __( 'Serif', 'make' ),
				'stack' => 'Georgia,Times,"Times New Roman",serif'
			),
			'sans-serif' => array(
				'label' => __( 'Sans Serif', 'make' ),
				'stack' => '"Helvetica Neue",Helvetica,Arial,sans-serif'
			),
			'monospace' => array(
				'label' => __( 'Monospaced', 'make' ),
				'stack' => 'Monaco,"Lucida Sans Typewriter","Lucida Typewriter","Courier New",Courier,monospace'
			)
		);
	}

	/**
	 * Extension of the parent class's get_font_data method to account for a deprecated filter.
	 *
	 * @since x.x.x.
	 *
	 * @param string|null $font
	 *
	 * @return array
	 */
	public function get_font_data( $font = null ) {
		$data = parent::get_font_data( $font );

		// Check for deprecated filters
		if ( is_null( $font ) ) {
			if ( has_filter( 'make_get_standard_fonts' ) ) {
				$this->compatibility()->deprecated_hook(
					'make_get_standard_fonts',
					'1.7.0',
					sprintf(
						esc_html__( 'To add or modify Generic/Standard fonts, use the %s hook instead.', 'make' ),
						'<code>make_font_data_generic</code>'
					)
				);

				/**
				 * Allow for developers to modify the standard fonts.
				 *
				 * @since 1.2.3.
				 * @deprecated 1.7.0.
				 *
				 * @param array    $fonts    The list of standard fonts.
				 */
				$data = apply_filters( 'make_get_standard_fonts', $data );
			}

			if ( has_filter( 'make_all_fonts' ) ) {
				$this->compatibility()->deprecated_hook(
					'make_all_fonts',
					'1.7.0',
					sprintf(
						esc_html__( 'To add or modify fonts, use a hook for a specific font source instead, such as %s.', 'make' ),
						'<code>make_font_data_generic</code>'
					)
				);

				/**
				 * Allow for developers to modify the full list of fonts.
				 *
				 * @since 1.2.3.
				 * @deprecated 1.7.0.
				 *
				 * @param array    $fonts    The list of all fonts.
				 */
				$data = apply_filters( 'make_all_fonts', $data );
			}
		}

		return $data;
	}
}