<?php

/**
 * Element Definition: Section
 */

class CSE_Section {

	public function ui() {
		return array(
      'title'       => __( 'Section', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
      'no_server_render' => true,
			'context' => '_layout',
			'dynamic_child' => true,
			'elements' => array(
				'floor' => 1
			),
      'protected_keys' => array(
        'bg_image',
        'bg_video',
        'bg_video_poster',
      )
		);
	}

	public function _layout_defaults() {
		return array(
			'elements' => array( array( '_type' => 'row' ) )
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

		if ( isset($atts['bg_type'])  ) {

			if ( $atts['bg_type'] == 'image' && isset( $atts['bg_pattern_toggle'] ) && $atts['bg_pattern_toggle'] == 'true' ) {
				$atts['bg_pattern'] = $atts['bg_image'];
				unset( $atts['bg_image'] );
			}

			if ( $atts['bg_type'] != 'image' ) {
				unset( $atts['bg_image'] );
			}

			if ( $atts['bg_type'] != 'video' ) {
				unset( $atts['bg_video'] );
				unset( $atts['bg_video_poster'] );
			}

			if ( $atts['bg_type'] == 'none' ) {
				unset( $atts['bg_color'] );
			}

			unset( $atts['bg_pattern_toggle'] );
			unset( $atts['bg_type'] );

		}

		return $atts;

	}
}
