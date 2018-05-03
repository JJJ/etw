<?php

class CS_Embedded_Video extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'embedded-video',
      'title'       => __( 'Embedded Video', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Embedded Video description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'content' => '' ),
      'protected_keys' => array( 'content' )
    );
  }

  public function controls() {

    $this->addControl(
      'content',
      'textarea',
      __( 'Embed Code', 'cornerstone' ),
      __( 'Input your &lt;iframe&gt; or &lt;embed&gt; code from a third party service.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'aspect_ratio',
      'select',
      __( 'Aspect Ratio', 'cornerstone' ),
      __( 'Select your aspect ratio.', 'cornerstone' ),
      '16:9',
      array(
        'choices' => array(
          array( 'value' => '16:9', 'label' => __( '16:9', 'cornerstone' ), ),
          array( 'value' => '5:3',  'label' => __( '5:3', 'cornerstone' ), ),
          array( 'value' => '5:4',  'label' => __( '5:4', 'cornerstone' ), ),
          array( 'value' => '4:3',  'label' => __( '4:3', 'cornerstone' ), ),
          array( 'value' => '3:2',  'label' => __( '3:2', 'cornerstone' ), )
        )
      )
    );

    $this->addControl(
      'no_container',
      'toggle',
      __( 'No Container', 'cornerstone' ),
      __( 'Select to remove the container around the video.', 'cornerstone' ),
      false
    );

  }

  public function is_active() {
    return current_user_can( 'unfiltered_html' );
  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_video_embed no_container=\"$no_container\" type=\"$aspect_ratio\"{$extra}]{$content}[/x_video_embed]";

    return $shortcode;

  }

}
