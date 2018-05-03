<?php

class Cornerstone_Customize_Control_Code_Editor extends WP_Customize_Control {

  public $type = 'cscodeeditor';
  public $options = array();

  public function enqueue() {
    Cornerstone_Code_Editor::enqueue();
  }

  public function render_content() {
    include( CS()->locate_view( 'customizer/control-code-editor' ) );
  }

}