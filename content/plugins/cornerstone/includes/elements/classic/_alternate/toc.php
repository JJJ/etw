<?php

class CS_Toc extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'toc',
      'title'       => __( 'Table of Contents', 'cornerstone' ),
      'section'     => 'typography',
      'context'     => 'generator'
    );
  }

  public function controls() { }

  public function render( $atts ) {
  	return '';
  }

}