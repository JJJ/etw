<?php

/**
 * Element Definition: Block Grid Item
 */

class CSE_Block_Grid_Item {

	public function ui() {
		return array(
      'title' => __( 'Block Grid Item', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
			'child' => true,
      'wrapping_tag' => 'li',
			//'dimension_target' => '.x-pricing-column'
			'protected_keys' => array(
        'title',
        'content'
      )
		);
	}

	public function register_shortcode() {
  	return false;
  }

	public function update_build_shortcode_atts( $atts ) {
		return $atts;
	}
}
