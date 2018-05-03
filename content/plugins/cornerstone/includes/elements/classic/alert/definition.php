<?php

/**
 * Element Definition: Alert
 */

class CSE_Alert {

	public function ui() {
		return array(
      'title'       => __( 'Alert', 'cornerstone' ),
      'autofocus' => array(
    		'heading' => '.x-alert .h-alert',
				'content' => '.x-alert'
    	)
    );
	}

  public function flags() {
    return array(
      'attr_keys' => array( 'type' ),
      'protected_keys' => array(
        'heading',
        'content'
      )
    );
  }

}
