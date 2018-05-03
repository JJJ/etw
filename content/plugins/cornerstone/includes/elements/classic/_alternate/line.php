<?php

class CS_Line extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'line',
      'title'       => __( 'Line', 'cornerstone' ),
      'section'     => 'structure',
      'description' => __( 'Line description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'attr_keys'   => array( 'line_color' )
    );
  }

  public function controls() {

  	$this->addControl(
      'line_color',
      'color',
      __( 'Color', 'cornerstone' ),
      __( 'Choose a specific color for this line. Reset the color picker to inherit a color.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'line_height',
      'text',
      __( 'Height', 'cornerstone' ),
      __( 'Specify a height for this line.', 'cornerstone' ),
      '1px'
    );

  }

  public function attribute_injections( $inject, $atts ) {

  	if ( isset( $atts['line_color'] ) && '' != $atts['line_color'] )
			$inject['styles'][] = 'border-top-color: ' . $atts['line_color'] . ';';

		if ( isset( $atts['line_height'] ) && '' != $atts['line_height'] )
			$inject['styles'][] = 'border-top-width: ' . $atts['line_height'] . ';';

		return $inject;

  }


  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_line{$extra}]";

    return $shortcode;

  }

}