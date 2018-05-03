<?php

class CS_Feature_Headline extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'feature-headline',
      'title'       => __( 'Feature Headline', 'cornerstone' ),
      'section'     => 'typography',
      'description' => __( 'Feature Headline description.', 'cornerstone' ),
      'supports'    => array( 'text_align', 'id', 'class', 'style' ),
      'empty'       => array( 'content' => '' ),
      'autofocus' => array(
        'content' => '.h-feature-headline',
      ),
      'attr_keys' => array( 'text_color', 'icon_color', 'icon_bg_color', 'text_align' ),
      'protected_keys' => array( 'content', 'level', 'looks_like', 'icon_type' )
    );
  }

  public function controls() {

    $headingChoices = array(
      array( 'value' => 'h1', 'label' => __( 'h1', 'cornerstone' ) ),
      array( 'value' => 'h2', 'label' => __( 'h2', 'cornerstone' ) ),
      array( 'value' => 'h3', 'label' => __( 'h3', 'cornerstone' ) ),
      array( 'value' => 'h4', 'label' => __( 'h4', 'cornerstone' ) ),
      array( 'value' => 'h5', 'label' => __( 'h5', 'cornerstone' ) ),
      array( 'value' => 'h6', 'label' => __( 'h6', 'cornerstone' ) )
    );

    $this->addControl(
      'content',
      'textarea',
      __( 'Text', 'cornerstone' ),
      __( 'Text to be placed inside the heading element.', 'cornerstone' ),
      __( 'Feature Headline', 'cornerstone' )
    );

    $this->addControl(
      'level',
      'select',
      __( 'Heading Level', 'cornerstone' ),
      __( 'Determines which heading level should be used in the actual HTML.', 'cornerstone' ),
      'h2',
      array(
        'choices' => $headingChoices
      )
    );

    if ( apply_filters( 'cornerstone_looks_like_support', false ) ) {
      $this->addControl(
        'looks_like',
        'select',
        __( 'Looks Like', 'cornerstone' ),
        __( 'Allows you to alter the appearance of the heading, while still outputting it as a different HTML tag.', 'cornerstone' ),
        'h3',
        array(
          'choices' => $headingChoices
        )
      );
    }

    $this->addControl(
      'text_color',
      'color',
      __( 'Text Color', 'cornerstone' ),
      __( 'Choose a specific color for the headline text. Reset the color picker to inherit a color.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'icon_type',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Icon to be displayed next to the Feature Headline.', 'cornerstone' ),
      'lightbulb-o'
    );

    $this->addControl(
      'icon_color',
      'color',
      __( 'Icon Color &amp; Background Color', 'cornerstone' ),
      __( 'Choose a specific color for the icon. Reset the color picker to inherit a color.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'icon_bg_color',
      'color',
      NULL,
      NULL,
      ''
    );


  }

  public function render( $atts ) {

    extract( $atts );

    $looks_like = ( apply_filters( 'cornerstone_looks_like_support', false ) ) ? "looks_like=\"$looks_like\"" : '';

    $icon_color = ( '' != $icon_color ) ? " icon_color=\"$icon_color\"" : '';
    $icon_bg_color = ( '' != $icon_bg_color ) ? " icon_bg_color=\"$icon_bg_color\"" : '';

    $shortcode = "[x_feature_headline level=\"$level\" {$looks_like} icon=\"$icon_type\"{$icon_color}{$icon_bg_color}{$extra}]{$content}[/x_feature_headline]";

    return $shortcode;

  }
}
