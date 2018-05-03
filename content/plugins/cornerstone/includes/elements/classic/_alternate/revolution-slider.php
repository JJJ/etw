<?php

class CS_Revolution_Slider extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'revolution-slider',
      'title'       => __( 'Revolution Slider', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Place a Revolution Slider element into your content.', 'cornerstone' ),
      'supports'    => array(),
      'can_preview' => false,
      'undefined_message' => __('This element can not render because Revolution Slider is not active.', 'cornerstone' ),
      'protected_keys' => array( 'alias' )
    );
  }

  public function controls() {

    $found = array();

    if ( class_exists( 'RevSlider' ) ) {

      $new_rev_slider = new RevSlider();
      $rev_sliders    = $new_rev_slider->getArrSliders();

      foreach ( $rev_sliders as $rs ) {
        $found[] = array(
          'value' => $rs->getAlias(),
          'label' => $rs->getTitle()
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
      'alias',
      'select',
      __( 'Select Slider', 'cornerstone' ),
      __( 'Choose from Revolution Slider elements that have already been created.', 'cornerstone' ),
      $found[0]['value'],
      array(
        'choices' => $found
      )
    );

  }

  public function is_active() {
    return class_exists( 'RevSlider' );
  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[rev_slider $alias]";

    return $shortcode;

  }

}
