<?php

/**
 * Element Definition: Responsive Text
 */

class CSE_Responsive_Text {

	public function ui() {
		return array(
      'title' => __( 'Responsive Text', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
			'context' => '_internal',
			'child' => true
		);
	}

	public function register_shortcode() {
  	return false;
  }

	public function defaults() {
		return array(
			'title' => '',
			'selector' => '',
			'compression' => '1.0',
			'min_size' => '',
			'max_size' => ''
		);
	}

	public function controls() {
		return array(
			'common' => 'none',
			'title' => array(
				'type' => 'title',
				'context' => 'content',
		    'suggest' => __( 'Responsive Text Item', 'cornerstone' ),
			),
			'selector' => array(
				'ui' => array(
					'title'   => __( 'Selector', 'cornerstone' ),
					'tooltip' => __( 'Enter in the selector for your Responsive Text (e.g. if your class is "h-responsive" enter ".h-responsive").', 'cornerstone' ),
				),
				'context' => 'content',
		    'suggest' => '.h-responsive',
			),
			'compression' => array(
				'type' => 'text',
				'ui' => array(
					'title'   => __( 'Compression', 'cornerstone' ),
					'tooltip' => __( 'Enter the compression for your Responsive Text. Adjust up and down to desired level in small increments (e.g. 0.95, 1.15, et cetera).', 'cornerstone' ),
				)
			),
			'min_size' => array(
				'type' => 'text',
				'ui' => array(
					'title'   => __( 'Minimum Size', 'cornerstone' ),
					'tooltip' => __( 'Enter the minimum size of your Responsive Text.', 'cornerstone' ),
				)
			),
			'max_size' => array(
				'type' => 'text',
				'ui' => array(
					'title'   => __( 'Maximum Size', 'cornerstone' ),
					'tooltip' => __( 'Enter the maximum size of your Responsive Text.', 'cornerstone' ),
				)
			)
		);
	}

	public function update_build_shortcode_atts( $atts ) {

		unset( $atts['title'] );

		return $atts;

	}

}
