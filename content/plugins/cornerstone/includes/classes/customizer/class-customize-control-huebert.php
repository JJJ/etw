<?php

class Cornerstone_Customize_Control_Huebert extends WP_Customize_Control {

  public $type = 'huebert';
  public function enqueue() {
    wp_enqueue_style( 'cs-huebert-style' );
    wp_enqueue_script( 'cs-huebert' );
  }

  public function render_content() {
    include( CS()->locate_view( 'customizer/control-huebert' ) );
  }

}