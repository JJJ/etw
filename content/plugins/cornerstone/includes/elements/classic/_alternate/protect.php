<?php

class CS_Protect extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'protect',
      'title'       => __( 'Protect', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Protect description.', 'cornerstone' ),
      'helpText'    => array(
        'title'     => __( 'How does this work?', 'cornerstone' ),
        'message'   => __( 'This element offers simple protection based on being logged in. Logged out users will be prompted to login before viewing the content.', 'cornerstone' ),
      ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'content' => '' ),
      'protected_keys' => array( 'heading', 'content' )
    );
  }

  public function controls() {

    $this->addControl(
      'heading',
      'text',
      __( 'Login Heading', 'cornerstone' ),
      __( 'Edit the heading promting users to login.', 'cornerstone' ),
      '',
      array(
        'placeholder' => __( 'Restricted Content Login', 'cornerstone' )
      )
    );

    $this->addControl(
      'content',
      'textarea',
      __( 'Content', 'cornerstone' ),
      __( 'Enter the text to go inside your Protect shortcode. This will only be visible to users who are logged in.', 'cornerstone' ),
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );
    $heading = ( $heading != '' ) ? "heading=\"$heading\"": '';
    $shortcode = "[x_protect {$heading} {$extra}]{$content}[/x_protect]";

    return $shortcode;

  }

}
