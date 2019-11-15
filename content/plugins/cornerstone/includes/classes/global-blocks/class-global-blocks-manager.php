<?php

class Cornerstone_Global_Blocks_Manager extends Cornerstone_Plugin_Component {

  public function setup() {

    register_post_type( 'cs_global_block', array(
      'labels'          => csi18n( 'common.global-block-labels' ),
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false
    ) );

    add_action('cs_before_preview_frame', array( $this, 'preview_setup' ) );

  }

  public function get_builder_class( $class ){
    $page_id = get_queried_object_id();
    return "cs-content cs-global-block-builder x-global-block x-global-block-$page_id";
  }


  public function preview_setup( $state ) {
    if ( isset( $state['global_block_preview_id'] ) ) {
      add_action('x_output_header', '__return_false' );
      add_action('x_output_footer', '__return_false' );
      $this->preview_id = (int) $state['global_block_preview_id'];
      add_filter('template_include', array( $this, 'set_blank_preview_template' ) );
      add_action('x_head_css', array( $this, 'output_css' ), 99999 );
      add_filter('builder_class', array( $this, 'get_builder_class' ), 11 );
    }
  }

  public function output_css(){
    echo '.cs-global-block-builder { font-size: ' . get_option( 'x_content_font_size_rem', '1' ) . 'rem; }';
  }

  public function set_blank_preview_template( $template ) {

    if ( isset($this->preview_id) && $this->plugin->common()->override_global_post( $this->preview_id ) ) {
      $template = $this->plugin->path('includes/views/global-blocks/preview-bootstrap.php');
    }

    return $template;

  }

}
