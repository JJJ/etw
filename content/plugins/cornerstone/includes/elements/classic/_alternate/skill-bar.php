<?php

class CS_Skill_Bar extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'skill-bar',
      'title'       => __( 'Skill Bar', 'cornerstone' ),
      'section'     => 'information',
      'description' => __( 'Skill Bar description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'heading' => '.h-skill-bar',
    		'bar_text' => '.x-skill-bar',
    	),
      'protected_keys' => array( 'heading', 'percent', 'bar_text' )
    );
  }

  public function controls() {

    $this->addControl(
      'heading',
      'text',
      __( 'Heading', 'cornerstone' ),
      __( 'Enter the heading of your Skill Bar.', 'cornerstone' ),
      __( 'Skill Bar Title', 'cornerstone' )
    );

    $this->addControl(
      'percent',
      'text',
      __( 'Percent', 'cornerstone' ),
      __( 'Enter the percentage of your skill and be sure to include the percentage sign (e.g. 90%).', 'cornerstone' ),
      '90%'
    );

    $this->addControl(
      'bar_text',
      'text',
      __( 'Bar Text', 'cornerstone' ),
      __( 'Enter in some alternate text in place of the percentage inside the Skill Bar.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'bar_bg_color',
      'color',
      __( 'Bar Background Color', 'cornerstone' ),
      __( 'Select the background color of your Skill Bar.', 'cornerstone' ),
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_skill_bar heading=\"$heading\" percent=\"$percent\" bar_text=\"$bar_text\" bar_bg_color=\"{$bar_bg_color}\"{$extra}]";

    return $shortcode;

  }

}
