<?php

/**
 * Element Definition: Column
 */

class CSE_Column {

	public function ui() {
		return array(
      'title' => __( 'Column (v1)', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
      '_no_server_render' => true,
			'context' => '_layout',
			'dynamic_child' => true
		);
	}

	public function _layout_defaults() {
		return array(
			'size' => '1/1',
			'_active' => false
		);
	}

	public function update_defaults( $defaults ) {
		return array_merge($defaults, $this->_layout_defaults() );
	}

	public function register_shortcode() {
  	return false;
  }

	public function update_build_shortcode_atts( $atts ) {

		unset( $atts['_active'] );
		unset( $atts['title'] );

		if ( isset( $atts['size'] ) ) {
			$atts['type'] = $atts['size'];
			unset( $atts['size'] );
		}

		return $atts;

	}

	public function update_build_shortcode_content( $content ) {

		if ( '' == $content ) {
			$content = '&nbsp;';
		}

		return $content;
	}

	public function should_have_markup( $condition, $atts, $content ) {
		return ( isset( $atts['_active'] ) && $atts['_active'] );
	}

}
