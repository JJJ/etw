<?php

class CS_Embedded_Audio extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'embedded-audio',
      'title'       => __( 'Embedded Audio', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Embedded Audio description.', 'cornerstone' ),
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

  }

  public function is_active() {
    return current_user_can( 'unfiltered_html' );
  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_audio_embed{$extra}]{$content}[/x_audio_embed]";

    return $shortcode;

  }

}
