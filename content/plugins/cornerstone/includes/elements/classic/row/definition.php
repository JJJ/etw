<?php

/**
 * Element Definition: Section
 */

class CSE_Row {

	public function ui() {
		return array(
      'title' => __( 'Row', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
      'no_server_render' => true,
			'context' => '_layout',
			'dynamic_child' => true
		);
	}

	public function _layout_defaults() {
		return array(
			'_column_layout' => '1/1',
			'elements' => array(
				array( '_type' => 'column', '_active' => true ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
				array( '_type' => 'column' ),
			)
		);
	}

	public function update_defaults( $defaults ) {
		return array_merge($defaults, $this->_layout_defaults() );
	}

	public function register_shortcode() {
  	return false;
  }

	public function update_build_shortcode_atts( $atts ) {

		unset( $atts['title'] );
		unset( $atts['_column_layout'] );

		return $atts;

	}

}
