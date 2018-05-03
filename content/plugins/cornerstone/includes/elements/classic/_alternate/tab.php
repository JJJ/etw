<?php

class CS_Tab extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'tab',
      'title'       => __( 'Tab', 'cornerstone' ),
      'section'     => '_content',
      'description' => __( 'Tab description.', 'cornerstone' ),
      'supports'    => array( 'class' ),
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
      __( 'Include your desired content for your Tab here.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'active',
      'toggle',
      __( 'Initial Active Tab', 'cornerstone' ),
      __( 'Only one tab must be specified as the initial active Tab. If no active Tab or multiple active Tabs are specified, there will be layout errors.', 'cornerstone' ),
      false
    );

  }

}
