<?php

class CS_Settings_Responsive_Text extends Cornerstone_Legacy_Setting_Section {

  public function data() {
    return array(
      'name'        => 'responsive-text',
      'title'       => __( 'Responsive Text', 'cornerstone' ),
      'priority' => '30'
    );
  }

  public function controls() {

    global $post;

    $settings = CS()->common()->get_post_settings( $post->ID );

    $items = ( isset( $settings['responsive_text'] ) && is_array($settings['responsive_text']) ) ? $settings['responsive_text'] : array();

    $this->addControl(
      'elements',
      'sortable',
      NULL,
      NULL,
      $items,
      array( 'element' => 'responsive-text' )
    );

  }

  public function handler( $atts ) {

    global $post;
    extract( $atts );

    $settings = CS()->common()->get_post_settings( $post->ID );
    $settings['responsive_text'] = $elements;

    cs_update_serialized_post_meta( $post->ID, '_cornerstone_settings', $settings );


  }


}