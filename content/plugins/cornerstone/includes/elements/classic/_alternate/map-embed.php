<?php

class CS_Map_Embed extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'map-embed',
      'title'       => __( 'Map Embed', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Map Embed description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'content' => '' ),
      'protected_keys' => array( 'content' )
    );
  }

  public function controls() {

    $this->addControl(
      'content',
      'textarea',
      __( 'Embed Code', 'cornerstone' ),
      __( 'Input your &lt;iframe&gt; or &lt;embed&gt; code from a third party service.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'no_container',
      'toggle',
      __( 'No Container', 'cornerstone' ),
      __( 'Select to remove the container around the map.', 'cornerstone' ),
      false
    );

  }

  public function is_active() {
    return current_user_can( 'unfiltered_html' );
  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_map no_container=\"$no_container\"{$extra}]{$content}[/x_map]";

    return $shortcode;

  }

}
