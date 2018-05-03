<?php

class CS_Soliloquy extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'soliloquy',
      'title'       => __( 'Soliloquy', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Place an Soliloquy element into your content.', 'cornerstone' ),
      'supports'    => array(),
      'can_preview' => false,
      'undefined_message' => __('This element can not render because Soliloquy is not active.', 'cornerstone' ),
      'protected_keys' => array( 'source_id' )
    );
  }

  public function controls() {

    $found = array();

    if ( class_exists( 'Soliloquy' ) ) {

      $soliloquy_sliders = Soliloquy::get_instance()->get_sliders();

      if ( is_array( $soliloquy_sliders ) ) {
      	foreach ( $soliloquy_sliders as $ss ) {
	        if ( !isset( $ss['id'] ) && $ss['config']) continue;
	        $found[] = array(
	          'value' => $ss['id'],
	          'label' => $ss['config']['title']
	        );
	      }
      }

    }

    if ( empty( $found ) ) {

      $found[] = array(
        'value'    => 'none',
        'label'    => __( 'No Sliders Available', 'cornerstone' ),
        'disabled' => true
      );

    }

    $this->addControl(
      'source_id',
      'select',
      __( 'Select Slider', 'cornerstone' ),
      __( 'Choose from Soliloquy elements that have already been created.', 'cornerstone' ),
      $found[0]['value'],
      array(
        'choices' => $found
      )
    );

  }

  public function is_active() {
    return class_exists( 'Soliloquy' );
  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[soliloquy id=\"$source_id\"]";

    return $shortcode;

  }

}
