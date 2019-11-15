<?php

class CS_Accordion_Item extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'           => 'accordion-item',
      'title'          => __( 'Accordion Item', 'cornerstone' ),
      'section'        => '_content',
      'description'    => __( 'Accordion Item description.', 'cornerstone' ),
      'supports'       => array( 'id', 'class', 'style' ),
      'render'         => false,
      'delegate'       => true,
      'alt_breadcrumb' => __( 'Item', 'cornerstone' ),
      'protected_keys' => array( 'title', 'content' ),
      'label_key' => 'title'
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
      __( 'Include your desired content for your Accordion Item here.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'open',
      'toggle',
      __( 'Starts Open', 'cornerstone' ),
      __( 'If the Accordion Items are linked, only one can start open.', 'cornerstone' ),
      false
    );

  }

}
