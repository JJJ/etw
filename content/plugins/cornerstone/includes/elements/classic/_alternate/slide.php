<?php

class CS_Slide extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'slide',
      'title'       => __( 'Slide', 'cornerstone' ),
      'section'     => '_content',
      'description' => __( 'Slide description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'render'      => false,
      'delegate'    => true,
      'protected_keys' => array( 'title', 'content' )
    );
  }

  public function controls() {

    $this->addControl(
      'title',
      'title',
      NULL,
      NULL,
      ''
    );

    $this->addControl(
      'content',
      'editor',
      __( 'Content', 'cornerstone' ),
      __( 'Include your desired content for your Slide here.', 'cornerstone' ),
      ''
    );

  }

  // public function render( $atts ) {

  //   extract( $atts );

  //   $extra = $this->extra( array(
  //     'id'    => $id,
  //     'class' => $class,
  //     'style' => $style
  //   ) );

  //   $shortcode = "[x_slide{$extra}][/x_slide]";

  //   return $shortcode;

  // }

}
