<?php

class Cornerstone_Style_Reducer {

	private $styles;

	public function __construct( $styles ) {
		$this->styles = ( is_array( $styles ) ) ? $styles : explode( ';', $styles );
	}

	public function run() {

		$output_styles = array();

		// Clean input
		$input_styles = array_map( array( $this, 'clean' ), $this->styles );

		// Break styles down into properties and values
		$properties = array();
		foreach ( $input_styles as $style ) {
			$parts = explode( ':', $style );
			if ( count( $parts ) < 2 ) {
				continue;
			}
			$output_styles[] = $style;
			$properties[$parts[0]] = trim( $parts[1] );
		}

		$property_keys = array_keys( $properties );
		asort( $property_keys );

		foreach ( $property_keys as $key ) {
			$method = array( $this, str_replace( '-', '_', $key ) );
			if ( is_callable( $method ) ) {
				$properties = call_user_func( $method, $properties, $key, $property_keys );
			}
		}

		if ( empty( $output_styles ) )
			return '';

		$combined = implode( ';', $output_styles ) . ';';
		return $combined;
	}

	/**
	 * Remove semicolon. Remove leading/trailing whitespace
	 */
	public function clean( $style ) {
		return trim( str_replace(';', '', $style ) );
	}

	public function border_style( $properties, $key, $keys ) {

		if ( in_array( 'border-color', $keys, true ) ) {
			// if border width is singular
				// combine border style, color, width
			// else combine style/color
		}

		return $properties;
	}

	public static function reduce( $styles ) {
		$reducer = new self( $styles );
		return $reducer->run();
	}

}