<?php

class CS_Slider extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'slider',
      'title'       => __( 'Slider', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Slider description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'renderChild' => true
    );
  }

  public function controls() {

    $this->addControl(
      'elements',
      'sortable',
      __( 'Slides', 'cornerstone' ),
      __( 'Add a new slide to your slider.', 'cornerstone' ),
      array(
        array( 'title' => __( 'Slide 1', 'cornerstone' ), 'content' => '<img src="http://placehold.it/1200x600/3498db/2980b9" alt="Placeholder">' ),
        array( 'title' => __( 'Slide 2', 'cornerstone' ), 'content' => '<img src="http://placehold.it/1200x600/9b59b6/8e44ad" alt="Placeholder">' )
      ),
      array(
      	'element'  => 'slide',
        'newTitle' => __( 'Slide %s', 'cornerstone' ),
        'floor'    => 1
      )
    );

    $this->addControl(
      'animation',
      'select',
      __( 'Animation', 'cornerstone' ),
      __( 'Choose between a fade and a slide animation.', 'cornerstone' ),
      'slide',
      array(
        'choices' => array(
          array( 'value' => 'fade',  'label' => __( 'Fade', 'cornerstone' ) ),
          array( 'value' => 'slide', 'label' => __( 'Slide', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'slide_speed',
      'number',
      __( 'Animation Speed', 'cornerstone' ),
      __( 'The amount of time in milliseconds the transition between each slide should take.', 'cornerstone' ),
      '1000'
    );

    $this->addControl(
      'slideshow',
      'toggle',
      __( 'Slideshow', 'cornerstone' ),
      __( 'Enabling this control will have your slider automatically cycle through like a slideshow.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'slide_time',
      'number',
      __( 'Slide Duration', 'cornerstone' ),
      __( 'The amount of time in milliseconds each slide should remain visible before transitioning to the next one.', 'cornerstone' ),
      '7000',
      array(
        'condition' => array(
          'slideshow' => true
        )
      )
    );

    $this->addControl(
      'pause_on_hover',
      'toggle',
      __( 'Pause On Hover', 'cornerstone' ),
      __( 'Pause the transition delay when the mouse is over the slider.', 'cornerstone' ),
      false,
      array(
        'condition' => array(
          'slideshow' => true
        )
      )
    );

    $this->addControl(
      'random',
      'toggle',
      __( 'Random', 'cornerstone' ),
      __( 'Select to have your slider appear in a random order each time the page loads.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'control_nav',
      'toggle',
      __( 'Control Navigation', 'cornerstone' ),
      __( 'Select to enable the control navigation, which displays how many slides you have in your slider.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'prev_next_nav',
      'toggle',
      __( 'Prev/Next Navigation', 'cornerstone' ),
      __( 'Select to enable the prev/next navigation, which displays two arrows for you to cycle through the slides in your slider.', 'cornerstone' ),
      true
    );

    $this->addControl(
      'no_container',
      'toggle',
      __( 'No Container', 'cornerstone' ),
      __( 'Select to remove the container around the slider.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'touch',
      'toggle',
      __( 'Touch Navigation', 'cornerstone' ),
      __( 'Allow touch devices to navigate with a swipe guesture.', 'cornerstone' ),
      true
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $contents = '';

    foreach ( $elements as $e ) {

      $contents .= cs_build_shortcode( 'x_slide', array(), $this->extra( $e ), $e['content'], true );

    }

    $touch = ($touch == 'false') ? 'touch="false" ' : '';
    $pause_on_hover = ( $pause_on_hover == 'true' ) ? 'pause_on_hover="true" ' : '';

    $shortcode = "[x_slider animation=\"$animation\" slide_time=\"$slide_time\" slide_speed=\"$slide_speed\" slideshow=\"$slideshow\" random=\"$random\" control_nav=\"$control_nav\" prev_next_nav=\"$prev_next_nav\" no_container=\"$no_container\" {$touch}{$pause_on_hover}{$extra}]{$contents}[/x_slider]";

    return $shortcode;

  }

}
