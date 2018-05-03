<?php
class Cornerstone_Control_Editor extends Cornerstone_Control {
	protected $default_context = 'content';
	protected $default_options = array( 'expandable' => true );

	public function sanitize( $data ) {
		return Cornerstone_Control::sanitize_html( $data );
	}

}