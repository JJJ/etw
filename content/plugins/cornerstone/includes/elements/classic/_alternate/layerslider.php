<?php

class CS_Layerslider extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'layerslider',
      'title'       => __( 'LayerSlider', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Place a LayerSlider element into your content.', 'cornerstone' ),
      'supports'    => array(),
      'can_preview' => false,
      'undefined_message' => __('This element can not render because Layer Slider is not active.', 'cornerstone' ),
      'protected_keys' => array( 'source_id' )
    );
  }

  public function controls() {

    $found = array();

    if ( class_exists( 'LS_Sliders' ) ) {

      $layersliders = LS_Sliders::find( array( 'order' => 'ASC', 'limit' => 100 ) );

      foreach ( $layersliders as $ls ) {
        $found[] = array(
          'value' => $ls['id'],
          'label' => $ls['name']
        );
      }

    }

    if ( empty( $found ) ) {

      $found[] = array(
        'value'    => 'none',
        'label'    => __( 'No Slider Available', 'cornerstone' ),
        'disabled' => true
      );

    }

    $this->addControl(
      'source_id',
      'select',
      __( 'Select Slider', 'cornerstone' ),
      __( 'Choose from LayerSlider elements that have already been created.', 'cornerstone' ),
      $found[0]['value'],
      array(
        'choices' => $found
      )
    );

  }

  public function is_active() {
    return class_exists( 'LS_Sliders' );
  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[layerslider id=\"$source_id\"]";

    return $shortcode;

  }

}
