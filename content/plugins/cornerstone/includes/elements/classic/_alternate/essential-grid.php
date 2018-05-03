<?php

class CS_Essential_Grid extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'essential-grid',
      'title'       => __( 'Essential Grid', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Place an Essential Grid element into your content.', 'cornerstone' ),
      'supports'    => array(),
      'can_preview' => false,
      'undefined_message' => __('This element can not render because Essential Grid is not active.', 'cornerstone' ),
      'protected_keys' => array( 'alias' )
    );
  }

  public function controls() {

    $found = array();

    if ( class_exists( 'Essential_Grid' ) ) {

      $essential_grids = Essential_Grid::get_essential_grids();

      foreach ( $essential_grids as $eg ) {
        $found[] = array(
          'value' => $eg->handle,
          'label' => $eg->name
        );
      }

    }

    if ( empty( $found ) ) {

      $found[] = array(
        'value'    => 'none',
        'label'    => __( 'No Grids Available', 'cornerstone' ),
        'disabled' => true
      );

    }

    $this->addControl(
      'alias',
      'select',
      __( 'Select Grid', 'cornerstone' ),
      __( 'Choose from Essential Grid elements that have already been created.', 'cornerstone' ),
      $found[0]['value'],
      array(
        'choices' => $found
      )
    );

  }

  public function is_active() {
    return class_exists( 'Essential_Grid' );
  }

  public function render( $atts ) {

    extract( $atts );

    // force script enqueue
    $esg = new Essential_Grid();
    $esg->enqueue_scripts();

    $shortcode = "[ess_grid alias=\"$alias\"]";

    return $shortcode;
  }

}
