<?php

class Cornerstone_Global_Blocks_Manager extends Cornerstone_Plugin_Component {

  public function setup() {

    register_post_type( 'cs_global_block', array(
      'labels'          => array(
        'name'               => __( 'Global Blocks', 'cornerstone' ),
        'singular_name'      => __( 'Global Block', 'cornerstone' ),
        'add_new'            => __( 'Add New Global Block', 'cornerstone' ),
        'add_new_item'       => __( 'Add New Global Block', 'cornerstone' ),
        'edit_item'          => __( 'Edit Global Block', 'cornerstone' ),
        'new_item'           => __( 'Add New Global Block', 'cornerstone' ),
        'view_item'          => __( 'View Global Block', 'cornerstone' ),
        'search_items'       => __( 'Search Global Blocks', 'cornerstone' ),
        'not_found'          => __( 'No Global Blocks found', 'cornerstone' ),
        'not_found_in_trash' => __( 'No Global Blocks found in trash', 'cornerstone' )
      ),
      'public'          => false,
      'capability_type' => 'page',
      'supports'        => false
    ) );

    add_action('cs_before_preview_frame', array( $this, 'preview_setup' ) );
  }

  public function preview_setup( $state ) {
    if ( isset( $state['global_block_preview_id'] ) ) {
      add_action('x_output_header', '__return_false' );
      add_action('x_output_footer', '__return_false' );
      $this->preview_id = (int) $state['global_block_preview_id'];
      add_filter('template_include', array( $this, 'set_blank_preview_template' ) );
    }
  }

  public function set_blank_preview_template( $template ) {

    if ( isset($this->preview_id) && $this->plugin->common()->override_global_post( $this->preview_id ) ) {
      $template = $this->plugin->path('includes/views/global-blocks/preview-bootstrap.php');
    }

    return $template;

  }

}
