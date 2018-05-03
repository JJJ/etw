<?php

class CS_Columnize extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'columnize',
      'title'       => __( 'Columnize', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Columnize description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'content' => '' ),
      'autofocus' => array(
    		'content' => '.x-columnize',
    	),
      'protected_keys' => array( 'content' )
    );
  }

  public function controls() {

    $this->addControl(
      'content',
      'editor',
      NULL,
      NULL,
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_columnize{$extra}]{$content}[/x_columnize]";

    return $shortcode;

  }

}
