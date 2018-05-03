<?php

class CS_Icon extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'icon',
      'title'       => __( 'Icon', 'cornerstone' ),
      'section'     => 'typography',
      'description' => __( 'Icon description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'attr_keys'   => array( 'icon_color', 'bg_color' ),
      'protected_keys' => array( 'type' )
    );
  }

  public function controls() {

    $this->addControl(
      'type',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Specify the icon you would like to use.', 'cornerstone' ),
      'check'
    );

    $this->addControl(
      'icon_color',
      'color',
      __( 'Icon Color &amp; Background Color', 'cornerstone' ),
      __( 'Specify custom colors for your icon if desired.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'bg_color',
      'color',
      NULL,
      NULL,
      ''
    );

    $this->addControl(
      'icon_size',
      'text',
      __( 'Icon Size &amp; Background Size', 'cornerstone' ),
      __( 'Specify custom dimensions for your icon for use in situations other than inline.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'bg_size',
      'text',
      NULL,
      NULL,
      ''
    );

    $this->addControl(
      'bg_border_radius',
      'text',
      __( 'Background Border Radius', 'cornerstone' ),
      __( 'Give your icon\'s background a custom border radius.', 'cornerstone' ),
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $shortcode = "[x_icon type=\"{$type}\" icon_color=\"{$icon_color}\" bg_color=\"{$bg_color}\" icon_size=\"{$icon_size}\" bg_size=\"{$bg_size}\" bg_border_radius=\"{$bg_border_radius}\"{$extra}]";

    return $shortcode;

  }

}
