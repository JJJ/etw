<?php
class Cornerstone_Control_Multi_Choose extends Cornerstone_Control {

	protected $default_value = array();

	protected $default_options = array(
		'columns' => 2,
		'choices' => array(),
		'delimiter' => ' '
  );

  public function sanitize( $item ) {

		if ( !is_array( $item ) )
			return $this->default_value;

		return array_map( 'sanitize_text_field', $item );

	}

	public function transform_for_shortcode( $item ) {
		return implode($this->options['delimiter'], $item );
	}

}