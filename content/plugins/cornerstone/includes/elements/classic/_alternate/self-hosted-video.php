<?php

class CS_Self_Hosted_Video extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'self-hosted-video',
      'title'       => __( 'Video Player', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Video Player description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'src' => '' ),
      'protected_keys' => array( 'src' )
    );
  }

  public function controls() {

    $this->addControl(
      'src',
      'text',
      __( 'Video Src URL', 'cornerstone' ),
      __( 'Include your video URL(s) here. If using multiple sources, separate them using the pipe character (|) and place fallbacks towards the end (i.e. .webm then .mp4 then .ogv).', 'cornerstone' ),
      '',
      array(
        'expandable' => false,
        'placeholder' => home_url( __( 'video.mp4', 'cornerstone' ) )
      )
    );

    // $this->addControl(
    //   'm4v',
    //   'text',
    //   __( 'MP4', 'cornerstone' ),
    //   __( 'Include a .mp4 version of your video.', 'cornerstone' ),
    //   ''
    // );

    // $this->addControl(
    //   'ogv',
    //   'text',
    //   __( 'OGV', 'cornerstone' ),
    //   __( 'Include a .ogv version of your video for additional native browser support.', 'cornerstone' ),
    //   ''
    // );

    $this->addControl(
      'poster',
      'image',
      __( 'Video Poster Image', 'cornerstone' ),
      __( 'Include a poster image to appear before the video is played.', 'cornerstone' ),
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
      'hide_controls',
      'toggle',
      __( 'Hide Controls', 'cornerstone' ),
      __( 'Select to hide the controls on your self-hosted video.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'autoplay',
      'toggle',
      __( 'Autoplay', 'cornerstone' ),
      __( 'Select to automatically play your self-hosted video.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'no_container',
      'toggle',
      __( 'No Container', 'cornerstone' ),
      __( 'Select to remove the container around the video.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'preload',
      'select',
      __( 'Preload', 'cornerstone' ),
      __( 'Specifies if and how the video should be loaded when the page loads. "None" means the video is not loaded when the page loads, "Auto" loads the video entirely, and "Metadata" loads only metadata.', 'cornerstone' ),
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
      'advanced_controls',
      'toggle',
      __( 'Advanced Controls', 'cornerstone' ),
      __( 'Enable video player\'s advanced controls.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'muted',
      'toggle',
      __( 'Mute', 'cornerstone' ),
      __( 'Mute video player\'s audio.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'loop',
      'toggle',
      __( 'Loop', 'cornerstone' ),
      __( 'Enable looping of video playback.', 'cornerstone' ),
      false
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $src = cs_clean_shortcode_att( $src );

    $shortcode = "[x_video_player type=\"$aspect_ratio\" src=\"$src\" hide_controls=\"$hide_controls\" autoplay=\"$autoplay\" no_container=\"$no_container\" preload=\"$preload\" advanced_controls=\"$advanced_controls\" muted=\"$muted\" loop=\"$loop\"{$extra} poster=\"{$poster}\"]";

    return $shortcode;

  }

}
