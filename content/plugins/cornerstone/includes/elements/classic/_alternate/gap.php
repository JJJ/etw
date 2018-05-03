<?php

class CS_Gap extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'gap',
      'title'       => __( 'Gap', 'cornerstone' ),
      'section'     => 'structure',
      'description' => __( 'Gap description.', 'cornerstone' ),
      'supports'    => array( 'visibility', 'id', 'class', 'style' ),
      'render'      => false,
      'safe_container' => true,
      'autofocus' => array(
    		'gap_size' => '.cs-gap',
    	)
    );
  }

  public function controls() {

    $this->addControl(
      'gap_size',
      'text',
      __( 'Size', 'cornerstone' ),
      __( 'Enter in the size of your gap. Pixels, ems, and percentages are all valid units of measurement.', 'cornerstone' ),
      '50px',
      array(
        'placeholder' => __( '50px (accepts CSS units)', 'cornerstone' )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_gap size=\"$gap_size\"{$extra}]";

    return $shortcode;

  }

}
