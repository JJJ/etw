<?php

class CS_Text_Type extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'text-type',
      'title'       => __( 'Text Type', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Text Type description.', 'cornerstone' ),
      'supports'    => array( 'text_align', 'id', 'class', 'style' ),
      'autofocus'   => array(
				'prefix' => '.x-text-type .prefix',
		 		'strings' => '.x-text-type .text',
				'suffix' => '.x-text-type .suffix'
    	),
      'protected_keys' => array( 'prefix', 'strings', 'suffix', 'tag', 'looks_like' )
    );
  }

  public function controls() {

    //
    // Content.
    //

    $this->addControl(
      'prefix',
      'text',
      __( 'Prefix', 'cornerstone' ),
      __( 'Enter a prefix to appear before the animating text.', 'cornerstone' ),
      __( 'This is the ', 'cornerstone' )
    );

    $this->addControl(
      'strings',
      'textarea',
      __( 'Strings', 'cornerstone' ),
      __( 'Enter strings to be animated and separate them by a new line.', 'cornerstone' ),
      __( 'first string' . "\n" . 'second string' . "\n" . 'third string', 'cornerstone' ),
      array(
        'expandable' => false
      )
    );

    $this->addControl(
      'suffix',
      'text',
      __( 'Suffix', 'cornerstone' ),
      __( 'Enter a suffix to appear after the animating text.', 'cornerstone' ),
      __( ' of the sentence.', 'cornerstone' )
    );

    $this->addControl(
      'tag',
      'select',
      __( 'Tag', 'cornerstone' ),
      __( 'Specify the HTML tag you would like to use to output this shortcode.', 'cornerstone' ),
      'h3',
      array(
        'choices' => array(
          array( 'value' => 'h1',   'label' => __( 'h1', 'cornerstone' ) ),
          array( 'value' => 'h2',   'label' => __( 'h2', 'cornerstone' ) ),
          array( 'value' => 'h3',   'label' => __( 'h3', 'cornerstone' ) ),
          array( 'value' => 'h4',   'label' => __( 'h4', 'cornerstone' ) ),
          array( 'value' => 'h5',   'label' => __( 'h5', 'cornerstone' ) ),
          array( 'value' => 'h6',   'label' => __( 'h6', 'cornerstone' ) ),
          array( 'value' => 'p',    'label' => __( 'p', 'cornerstone' ) ),
          array( 'value' => 'div',  'label' => __( 'div', 'cornerstone' ) ),
          array( 'value' => 'span', 'label' => __( 'span', 'cornerstone' ) )
        )
      )
    );

    if ( apply_filters( 'cornerstone_looks_like_support', false ) ) {

	    $this->addControl(
	      'looks_like',
	      'select',
	      __( 'Looks Like', 'cornerstone' ),
	      __( 'Allows you to alter the appearance of the heading, while still outputting it as a different HTML tag.', 'cornerstone' ),
	      'h3',
	      array(
	        'choices' => array(
	          array( 'value' => 'h1', 'label' => __( 'h1', 'cornerstone' ) ),
	          array( 'value' => 'h2', 'label' => __( 'h2', 'cornerstone' ) ),
	          array( 'value' => 'h3', 'label' => __( 'h3', 'cornerstone' ) ),
	          array( 'value' => 'h4', 'label' => __( 'h4', 'cornerstone' ) ),
	          array( 'value' => 'h5', 'label' => __( 'h5', 'cornerstone' ) ),
	          array( 'value' => 'h6', 'label' => __( 'h6', 'cornerstone' ) )
	        ),
	        'condition' => array(
	          'tag' => array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' )
	        )
	      )
	    );
	  }


    //
    // Timing.
    //

    $this->addControl(
      'type_speed',
      'number',
      __( 'Type Speed (ms)', 'cornerstone' ),
      __( 'How fast in milliseconds each character should appear.', 'cornerstone' ),
      50
    );

    $this->addControl(
      'start_delay',
      'number',
      __( 'Start Delay (ms)', 'cornerstone' ),
      __( 'How long in milliseconds until typing should start.', 'cornerstone' ),
      0
    );

    $this->addControl(
      'back_speed',
      'number',
      __( 'Back Speed (ms)', 'cornerstone' ),
      __( 'How fast in milliseconds each character should be deleted.', 'cornerstone' ),
      50
    );

    $this->addControl(
      'back_delay',
      'number',
      __( 'Back Delay (ms)', 'cornerstone' ),
      __( 'How long in milliseconds each string should remain visible.', 'cornerstone' ),
      3000
    );


    //
    // Functionality.
    //

    $this->addControl(
      'loop',
      'toggle',
      __( 'Loop', 'cornerstone' ),
      __( 'Enable to have the typing effect loop continuously.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'show_cursor',
      'toggle',
      __( 'Show Cursor', 'cornerstone' ),
      __( 'Enable to display a cursor for your typing effect.', 'cornerstone' ),
      true
    );

    $this->addControl(
      'cursor',
      'text',
      __( 'Cursor', 'cornerstone' ),
      __( 'Specify the character you would like to use for your cursor.', 'cornerstone' ),
      '|',
      array(
        'condition' => array(
          'show_cursor' => true
        )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $strings = htmlspecialchars( str_replace( "\n", '|', $strings ) );


    if ( apply_filters( 'cornerstone_looks_like_support', false ) && ( $tag == 'h1' || $tag == 'h2' || $tag == 'h3' || $tag == 'h4' || $tag == 'h5' || $tag == 'h6' ) ) {
      $looks_like = ' looks_like="' . $looks_like . '"';
    } else {
      $looks_like = '';
    }

    $prefix = cs_clean_shortcode_att( $prefix );
    $suffix = cs_clean_shortcode_att( $suffix );
    $strings = cs_clean_shortcode_att( $strings );
    $cursor = cs_clean_shortcode_att( $cursor );

    $shortcode = "[x_text_type prefix=\"$prefix\" strings=\"$strings\" suffix=\"$suffix\" tag=\"$tag\" type_speed=\"$type_speed\" start_delay=\"$start_delay\" back_speed=\"$back_speed\" back_delay=\"$back_delay\" loop=\"$loop\" show_cursor=\"$show_cursor\" cursor=\"$cursor\"{$looks_like}{$extra}]";

    return $shortcode;

  }

}
