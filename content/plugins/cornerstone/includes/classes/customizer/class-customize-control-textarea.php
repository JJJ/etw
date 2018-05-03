<?php

class Cornerstone_Customize_Control_Textarea extends WP_Customize_Control {

  public $type = 'cstextarea';

  public function render_content() {
    include( CS()->locate_view( 'customizer/control-textarea' ) );
  }

}