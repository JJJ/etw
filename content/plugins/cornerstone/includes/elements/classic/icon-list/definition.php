<?php

/**
 * Element Definition: Icon List
 */

class CSE_Icon_List {

	public function ui() {
		return array(
      'title'       => __( 'Icon List', 'cornerstone' ),
    );
	}

	public function flags() {
		return array(
			'dynamic_child' => true
		);
	}

}