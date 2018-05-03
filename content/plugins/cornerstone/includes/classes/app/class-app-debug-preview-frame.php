<?php

// add_action('_cornerstone_preview_frame_debug',function() use ($state){
//   echo '<pre>';
//   var_dump( $state );
//   echo '</pre>';
// });

class Cornerstone_App_Debug_Preview_Frame extends Cornerstone_Plugin_Component {

  public function setup() {

    if ( isset( $this->state['debug'] ) && $this->state['debug'] ) {
      add_filter( 'template_include', array( $this, 'debug'), 99999999 );
    }

  }

  public function debug() {
    // header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);

    ?><!DOCTYPE html><html <?php language_attributes(); ?>><head><title>Cornerstone Preview Frame Debug</title><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width, initial-scale=1.0"><?php wp_head(); ?></head><body> <?php

    do_action('_cornerstone_preview_frame_debug');

    wp_footer();?></body></html><?php
    die();
  }

}
