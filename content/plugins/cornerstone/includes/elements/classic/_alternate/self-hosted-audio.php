<?php

class CS_Self_Hosted_Audio extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'self-hosted-audio',
      'title'       => __( 'Audio Player', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Audio Player description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'src' => '' ),
    );
  }

  public function controls() {

    $this->addControl(
      'src',
      'text',
      __( 'Audio Src URL', 'cornerstone' ),
      __( 'Include your audio URL(s) here. If using multiple sources, separate them using the pipe character (|) and place fallbacks towards the end (i.e. .mp3 then .ogg).', 'cornerstone' ),
      '',
      array(
        'expandable' => false,
        'placeholder' => home_url( __( 'audio.mp3', 'cornerstone' ) )
      )
    );

    // $this->addControl(
    //   'mp3',
    //   'text',
    //   __( 'MP3', 'cornerstone' ),
    //   __( 'Include a .mp3 version of your audio.', 'cornerstone' ),
    //   ''
    // );

    // $this->addControl(
    //   'oga',
    //   'text',
    //   __( 'OGA', 'cornerstone' ),
    //   __( 'Include a .oga version of your audio for additional native browser support.', 'cornerstone' ),
    //   ''
    // );

    $this->addControl(
      'advanced_controls',
      'toggle',
      __( 'Advanced Controls', 'cornerstone' ),
      __( 'Enable audio player\'s advanced controls.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'preload',
      'select',
      __( 'Preload', 'cornerstone' ),
      __( 'Specifies if and how the audio should be loaded when the page loads. "None" means the audio is not loaded when the page loads, "Auto" loads the audio entirely, and "Metadata" loads only metadata.', 'cornerstone' ),
      'none',
      array(
        'choices' => array(
          array( 'value' => 'none',     'label' => __( 'None', 'cornerstone' ) ),
          array( 'value' => 'auto',     'label' => __( 'Auto', 'cornerstone' ) ),
          array( 'value' => 'metadata', 'label' => __( 'Metadata', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'autoplay',
      'toggle',
      __( 'Autoplay', 'cornerstone' ),
      __( 'Enable audio player\'s autoplay.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'loop',
      'toggle',
      __( 'Loop', 'cornerstone' ),
      __( 'Enable audio player\'s loop.', 'cornerstone' ),
      false
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $src = cs_clean_shortcode_att( $src );

    $shortcode = "[x_audio_player src=\"$src\" advanced_controls=\"$advanced_controls\" preload=\"$preload\" autoplay=\"$autoplay\" loop=\"$loop\"{$extra}]";

    return $shortcode;

  }
}
