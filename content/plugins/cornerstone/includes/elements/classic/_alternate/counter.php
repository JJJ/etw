<?php

class CS_Counter extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'counter',
      'title'       => __( 'Counter', 'cornerstone' ),
      'section'     => 'information',
      'description' => __( 'Counter description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'text_above' => '.text-above',
    		'text_below' => '.text-below',
    	),
      'protected_keys' => array( 'num_start', 'num_end', 'num_prefix', 'num_suffix', 'text_above', 'text_below' )
    );
  }

  public function controls() {

    $this->addControl(
      'num_start',
      'number',
      __( 'Starting Number', 'cornerstone' ),
      __( 'Enter in the number that you would like your counter to start from.', 'cornerstone' ),
      '0'
    );

    $this->addControl(
      'num_end',
      'number',
      __( 'Ending Number', 'cornerstone' ),
      __( 'Enter in the number that you would like your counter to end at. This must be higher than your starting number.', 'cornerstone' ),
      '1000'
    );

    $this->addControl(
      'num_speed',
      'number',
      __( 'Counter Speed', 'cornerstone' ),
      __( 'The amount of time to transition between numbers in milliseconds.', 'cornerstone' ),
      '1500'
    );

    $this->addControl(
      'num_prefix',
      'text',
      __( 'Number Prefix', 'cornerstone' ),
      __( 'Prefix your number with a symbol or text.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'num_suffix',
      'text',
      __( 'Number Suffix', 'cornerstone' ),
      __( 'Suffix your number with a symbol or text.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'num_color',
      'color',
      __( 'Number Color', 'cornerstone' ),
      __( 'Select the color of your number.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'text_above',
      'text',
      __( 'Text Above', 'cornerstone' ),
      __( 'Optionally include text above your number.', 'cornerstone' ),
      __( 'There Are', 'cornerstone' )
    );

    $this->addControl(
      'text_below',
      'text',
      __( 'Text Below', 'cornerstone' ),
      __( 'Optionally include text below your number.', 'cornerstone' ),
      __( 'Options', 'cornerstone' )
    );

    $this->addControl(
      'text_color',
      'color',
      __( 'Text Color', 'cornerstone' ),
      __( 'Select the color of your text above and below the number if you have include any.', 'cornerstone' ),
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_counter num_start=\"$num_start\" num_end=\"$num_end\" num_speed=\"$num_speed\" num_prefix=\"$num_prefix\" num_suffix=\"$num_suffix\" num_color=\"$num_color\" text_above=\"$text_above\" text_below=\"$text_below\" text_color=\"$text_color\"{$extra}]";

    return $shortcode;

  }

}
