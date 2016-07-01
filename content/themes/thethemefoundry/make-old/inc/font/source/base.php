<?php
/**
 * @package Make
 */

/**
 * Class MAKE_Font_Source_Base
 *
 * @since 1.7.0.
 */
abstract class MAKE_Font_Source_Base extends MAKE_Util_Modules implements MAKE_Font_Source_BaseInterface {
	/**
	 * The source ID.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	protected $id = '';

	/**
	 * The source's name in the UI.
	 *
	 * @since 1.7.0.
	 *
	 * @var string
	 */
	protected $label = '';

	/**
	 * The source's order priority. E.g. where its fonts will appear in a list of all fonts.
	 *
	 * @since 1.7.0.
	 *
	 * @var int
	 */
	protected $priority = 10;

	/**
	 * The source's font data.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Getter for the $id property.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Getter for the $label property.
	 *
	 * @since 1.7.0.
	 *
	 * @return string
	 */
	public function get_label() {
		return $this->label;
	}

	/**
	 * Getter for the $priority property.
	 *
	 * @since 1.7.0.
	 *
	 * @return int
	 */
	public function get_priority() {
		return $this->priority;
	}

	/**
	 * Get the data for a particular font, or all of the source's font data.
	 *
	 * @since 1.7.0.
	 *
	 * @param string|null $font
	 *
	 * @return array
	 */
	public function get_font_data( $font = null ) {
		// Return data for a specific font.
		if ( ! is_null( $font ) ) {
			$data = array();

			if ( isset( $this->data[ $font ] ) ) {
				$data = $this->data[ $font ];
			}

			return $data;
		}

		/**
		 * Filter: Modify the font data from a particular source.
		 *
		 * @since 1.7.0.
		 *
		 * @param array    $font_data
		 */
		return apply_filters( "make_font_data_{$this->id}", $this->data );
	}

	/**
	 * Check if this source has a particular font.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $font
	 *
	 * @return bool
	 */
	public function has_font( $font ) {
		$data = $this->get_font_data( $font );
		return ! empty( $data );
	}

	/**
	 * Return a list of this source's fonts in an array format, as used for choice arrays.
	 *
	 * 'font value' => 'font label'
	 *
	 * @since 1.7.0.
	 *
	 * @return array
	 */
	public function get_font_choices() {
		$choices = array();

		foreach ( $this->get_font_data() as $key => $data ) {
			if ( isset( $data['label'] ) ) {
				$choices[ $key ] = $data['label'];
			}
		}

		return $choices;
	}

	/**
	 * Get the font stack for a particular font. If no stack is available, use a default stack instead.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $font
	 * @param string $default_stack
	 *
	 * @return string
	 */
	public function get_font_stack( $font, $default_stack = 'sans-serif' ) {
		$data = $this->get_font_data( $font );
		$stack = '';

		if ( isset( $data['stack'] ) ) {
			$stack = $data['stack'];
		} else {
			$stack = $default_stack;
		}

		return $stack;
	}
}