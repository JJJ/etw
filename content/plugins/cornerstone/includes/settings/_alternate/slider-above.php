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
      __( 'To activate your slider, select an option from the dropdown. To deactivate your slider, set the dropdown back to "Deactivated."', 'cornerstone' ),
      $default_slider,
      array(
        'choices' => $choices,
        'notLive' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_bg_video',
      'text',
      __( 'Optional Background Video', 'cornerstone' ),
      __( 'Include your video URL(s) here. If using multiple sources, separate them using the pipe character (|) and place fallbacks towards the end (i.e. .webm then .mp4 then .ogv).', 'cornerstone' ),
      get_post_meta( $post->ID, '_x_slider_above_bg_video', true ),
      array(
        'notLive' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_bg_video_poster',
      'text',
      __( 'Video Poster Image (For Mobile)', 'cornerstone' ),
      __( 'Click the button to upload your video poster image to show on mobile devices, or enter it in manually using the text field above. Only select one image for this field. To clear, delete the image URL from the text field and save your page.', 'cornerstone' ),
      get_post_meta( $post->ID, '_x_slider_above_bg_video_poster', true ),
      array(
        'notLive' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_enable',
      'toggle',
      __( 'Enable Scroll Bottom Anchor', 'cornerstone' ),
      __( 'Select to enable the scroll bottom anchor for your slider.', 'cornerstone' ),
      ( 'on' == get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_enable', true ) ),
      array(
        'notLive' => 'settings-theme-changed'
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
      __( 'Select the alignment of the scroll bottom anchor for your slider.', 'cornerstone' ),
      get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_alignment', true ),
      array(
        'choices' => $alignments,
        'notLive' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_color',
      'text',
      __( 'Scroll Bottom Anchor Color', 'cornerstone' ),
      __( 'Select the color of the scroll bottom anchor for your slider.', 'cornerstone' ),
      get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_color', true ),
      array(
        'notLive' => 'settings-theme-changed'
      )
    );

    $this->addControl(
      'x_slider_above_scroll_bottom_anchor_color_hover',
      'text',
      __( 'Scroll Bottom Anchor Color Hover', 'cornerstone' ),
      __( 'Select the hover color of the scroll bottom anchor for your slider.', 'cornerstone' ),
      get_post_meta( $post->ID, '_x_slider_above_scroll_bottom_anchor_color_hover', true ),
      array(
        'notLive' => 'settings-theme-changed'
      )
    );

  }

  public function handler( $atts ) {

		global $post;
  	if ( $post->post_type != 'page')
    	return;

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