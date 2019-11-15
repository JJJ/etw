<?php

class CS_Settings_Slider_Above extends Cornerstone_Legacy_Setting_Section {

  public function data() {
    return array(
      'name'        => 'slider-above',
      'title'       => __( 'Slider Settings: Above Masthead', 'cornerstone' ),
      'priority' => '25'
    );
  }

  public function condition() {
    return ( apply_filters( 'x_settings_pane', false ) && ( class_exists( 'RevSlider' ) || class_exists( 'LS_Sliders' ) ) );
  }

  public function controls() {

    global $post;

    if ( $post->post_type == 'page') {
      $this->pageControls();
    }

  }

  public function pageControls() {

    global $post;

    $choices = array(
      array( 'value' => '', 'label' => __( 'Deactivated', 'cornerstone' ) )
    );

    $sliders = apply_filters( 'x_sliders_meta', array() );

    foreach ( $sliders as $key => $value ) {
			$choices[] = array( 'value' => $key, 'label' => $value['source'] . ': ' . $value['name'] );
    }

    $default_slider = get_post_meta( $post->ID, '_x_slider_above', true );

    $this->addControl(
      'x_slider_above',
      'select',
      __( 'Slider', 'cornerstone' ),
      '',
      $default_slider,
      array(
        'choices' => $choices,
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_bg_video',
      'text',
      __( 'Optional Background Video', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_slider_above_bg_video', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_bg_video_poster',
      'text',
      __( 'Video Poster Image (For Mobile)', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_slider_above_bg_video_poster', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_enable',
      'toggle',
      __( 'Enable Scroll Bottom Anchor', 'cornerstone' ),
      '',
      ( 'on' == get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_enable', true ) ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $alignments = array(
      array( 'value' => 'top left', 'label'      => __( 'Top Left', 'cornerstone' ) ),
      array( 'value' => 'top center', 'label'    => __( 'Top Center', 'cornerstone' ) ),
      array( 'value' => 'top right', 'label'     => __( 'Top Right', 'cornerstone' ) ),
      array( 'value' => 'bottom left', 'label'   => __( 'Bottom Left', 'cornerstone' ) ),
      array( 'value' => 'bottom center', 'label' => __( 'Bottom Center', 'cornerstone' ) ),
      array( 'value' => 'bottom right', 'label'  => __( 'Bottom Right', 'cornerstone' ) )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_alignment',
      'select',
      __( 'Scroll Bottom Anchor Alignment', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_alignment', true ),
      array(
        'choices' => $alignments,
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_color',
      'text',
      __( 'Scroll Bottom Anchor Color', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_color', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_color_hover',
      'text',
      __( 'Scroll Bottom Anchor Color Hover', 'cornerstone' ),
      '',
      get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_color_hover', true ),
      array(
        'trigger' => 'settings-theme-changed'
      )
    );

  }

  public function handler( $post, $atts ) {

  	if ( 'page' !== $post->post_type ) {
      return;
    }

  	extract( $atts );

    update_post_meta( $post->ID, '_x_slider_above', $x_slider_above );
    update_post_meta( $post->ID, '_x_slider_above_bg_video', $x_slider_above_bg_video );
    update_post_meta( $post->ID, '_x_slider_above_bg_video_poster', $x_slider_above_bg_video_poster );
    update_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_enable', ( $x_slider_above_scroll_bottom_anchor_enable == 'true' ) ? 'on' : '' );
    update_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_alignment', $x_slider_above_scroll_bottom_anchor_alignment );
    update_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_color', $x_slider_above_scroll_bottom_anchor_color );
    update_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_color_hover', $x_slider_above_scroll_bottom_anchor_color_hover );

  }

}
