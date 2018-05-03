<?php
class Cornerstone_Control_Checkbox extends Cornerstone_Control {

	protected $default_value = false;

	public function sanitize( $item ) {

		if ( $item == 'true' )
			return true;

		if ( $item == 'false' )
			return false;

		return (bool) $item;
	}

	public function transform_for_shortcode( $item ) {
		return ( $item ) ? 'true' : 'false';
	}

}