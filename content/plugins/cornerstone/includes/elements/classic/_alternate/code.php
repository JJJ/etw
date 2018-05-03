<?php

class CS_Code extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'code',
      'title'       => __( 'Code Snippet', 'cornerstone' ),
      'section'     => 'typography',
      'description' => __( 'Code Snippet description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'content' => '.x-code',
    	),
      'protected_keys' => array( 'content' )
    );
  }

  public function controls() {

    $this->addControl(
      'content',
      'textarea',
      __( 'Content', 'cornerstone' ),
      __( 'The content you want output. Keep in mind that this shortcode is meant to display code snippets, not output functioning code.', 'cornerstone' ),
      __( 'This shortcode is great for outputting code snippets or preformatted text.', 'cornerstone' )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_code{$extra}]{$content}[/x_code]";

    return $shortcode;

  }

}
