<?php

class Cornerstone_Global_Blocks_Index_Preview_Frame extends Cornerstone_Plugin_Component {

  protected $state = array();

  public function setup() {
    $this->state = $this->plugin->component( 'Preview_Frame_Loader' )->get_state();
    add_action('template_redirect', array( $this, 'template_redirect' ), 0 );
  }

  public function template_redirect() {
    if ( isset( $this->state['global_block_preview_id'] ) ) {
      add_action('x_output_header', '__return_false' );
      add_action('x_output_footer', '__return_false' );
      add_filter('template_include', array( $this, 'set_blank_preview_template' ) );
    }
  }

  public function set_blank_preview_template( $template ) {

    if ( $this->plugin->common()->override_global_post( (int) $this->state['global_block_preview_id'] ) ) {
      $template = $this->plugin->path('includes/views/global-blocks/preview-bootstrap.php');
    }

    return $template;

  }

}
