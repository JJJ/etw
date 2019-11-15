<?php

/**
 * Element Definition: Alert
 */

class CSE_Undefined {

	public function ui() {
		return array();
	}

	public function flags() {
		return array( 'context' => '_internal' );
	}

	public function controls() {
		return array();
	}

	public function shortcode_output() {
  	return '<!--cs_undefined-->';
  }

	public function defaults() {
		return array();
	}

	public function preview() {
		return '';
	}
}
