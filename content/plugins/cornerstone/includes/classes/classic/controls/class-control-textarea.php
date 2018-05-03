<?php
class Cornerstone_Control_Textarea extends Cornerstone_Control {
	protected $default_context = 'content';

	protected $default_options = array(
		'expandable'  => true,
		'placeholder' => '',
	);

	public function sanitize( $data ) {
		return Cornerstone_Control::sanitize_html( $data );
	}

}
