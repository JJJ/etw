<?php

class CS_Promo extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'promo',
      'title'       => __( 'Promo', 'cornerstone' ),
      'section'     => 'marketing',
      'description' => __( 'Promo description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'content' => '.x-promo-content',
    	),
      'protected_keys' => array( 'content', 'image', 'alt' )
    );
  }


  public function controls() {

    $this->addControl(
      'content',
      'editor',
      __( 'Content', 'cornerstone' ),
      __( 'Enter your Promo content.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'image',
      'image',
      __( 'Promo Image &amp; Alt Text', 'cornerstone' ),
      __( 'Include an image for your Promo element and provide the alt text in the input below. Alt text is used to describe an image to search engines.', 'cornerstone' ),
      CS()->common()->placeholderImage( 650, 1500 )
    );


    $this->addControl(
      'alt',
      'text',
      NULL,
      NULL,
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_promo image=\"$image\" alt=\"$alt\"{$extra}]{$content}[/x_promo]";

    return $shortcode;

  }

}
