<?php

class CS_Visibility extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'visibility',
      'title'       => __( 'Visibility', 'cornerstone' ),
      'context'     => 'generator'
    );
  }

  public function render( $atts ) {
  	return '';
  }

}