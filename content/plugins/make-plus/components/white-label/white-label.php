<?php
/**
 * @package Make Plus
 */

if ( class_exists( 'TTFMP_Customizer_Definitions' ) ) :
/**
 * Class TTFMP_Customizer_White_Label
 *
 * Add a White Label section with an option to hide the theme credit line.
 *
 * Migrated from an old Make Plus module called 'TTFMP_Customizer'.
 *
 * @since 1.5.0.
 */
class TTFMP_Customizer_White_Label extends TTFMP_Customizer_Definitions {
	/**
	 * @since 1.5.0.
	 */
	protected function hooks() {
		parent::hooks();

		// Enable White Label setting
		add_filter( 'ttfmake_show_footer_credit', array( $this, 'show_credit' ) );
	}

	/**
	 * @since 1.5.0.
	 */
	public function defaults( $defaults ) {
		$new_defaults = array(
			// Hide credit
			'footer-hide-credit' => 0,
		);

		return array_merge( $defaults, $new_defaults );
	}

	/**
	 * @since 1.5.0.
	 */
	public function definitions( $sections ) {
		$panel = 'ttfmake_general';
		$new_sections = array();

		$new_sections['white-label'] = array(
			'panel' => $panel,
			'title' => __( 'White Label', 'make-plus' ),
			'options' => array(
				'footer-hide-credit' => array(
					'setting' => array(
						'sanitize_callback'	=> 'absint',
					),
					'control' => array(
						'label' => __( 'Hide theme credit', 'make-plus' ),
						'type'  => 'checkbox',
					),
				),
			),
		);

		return array_merge( $sections, $new_sections );
	}

	/**
	 * Return the value of the White Label setting.
	 *
	 * @since  1.5.0.
	 *
	 * @param  bool    $bool    The original boolean
	 *
	 * @return bool             The modified boolean
	 */
	public function show_credit( $bool ) {
		return ! (bool) get_theme_mod( 'footer-hide-credit', ttfmake_get_default( 'footer-hide-credit' ) );
	}
}

new TTFMP_Customizer_White_Label;

endif;