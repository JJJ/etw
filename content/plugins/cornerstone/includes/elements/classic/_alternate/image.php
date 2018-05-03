<?php

class CS_Image extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'image',
      'title'       => __( 'Image', 'cornerstone' ),
      'section'     => 'media',
      'description' => __( 'Image description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'empty'       => array( 'src' => '' ),
      'protected_keys' => array( 'src', 'alt', 'link', 'href', 'href_title', 'href_target', 'info_content' )
    );
  }

  public function controls() {

    $this->addControl(
      'image_style',
      'select',
      __( 'Style', 'cornerstone' ),
      __( 'Select the image style.', 'cornerstone' ),
      'none',
      array(
        'choices' => array(
          array( 'value' => 'none',      'label' => __( 'None', 'cornerstone' ) ),
          array( 'value' => 'thumbnail', 'label' => __( 'Thumbnail', 'cornerstone' ) ),
          array( 'value' => 'rounded',   'label' => __( 'Rounded', 'cornerstone' ) ),
          array( 'value' => 'circle',    'label' => __( 'Circle', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'src',
      'image',
      __( 'Src', 'cornerstone' ),
      __( 'Enter your image.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'alt',
      'text',
      __( 'Alt', 'cornerstone' ),
      __( 'Enter in the alt text for your image', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'link',
      'toggle',
      __( 'Link', 'cornerstone' ),
      __( 'Select to wrap your image in an anchor tag.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'href',
      'text',
      __( 'Href', 'cornerstone' ),
      __( 'Enter in the URL you want to link to.', 'cornerstone' ),
      '#',
      array(
      	'condition' => array(
          'link' => true
        )
      )

    );

    $this->addControl(
      'href_title',
      'text',
      __( 'Link Title Attribute', 'cornerstone' ),
      __( 'Enter in the title attribute you want for your link.', 'cornerstone' ),
      '',
      array(
      	'condition' => array(
          'link' => true
        )
      )
    );

    $this->addControl(
      'href_target',
      'toggle',
      __( 'Open Link in New Window', 'cornerstone' ),
      __( 'Select to open your link in a new window.', 'cornerstone' ),
      false,
      array(
      	'condition' => array(
          'link' => true
        )
      )
    );

    $this->addControl(
      'info',
      'select',
      __( 'Info', 'cornerstone' ),
      __( 'Select whether or not you want to add a popover or tooltip to your image.', 'cornerstone' ),
      'none',
      array(
        'choices' => array(
          array( 'value' => 'none',    'label' => __( 'None', 'cornerstone' ), ),
          array( 'value' => 'popover', 'label' => __( 'Popover', 'cornerstone' ), ),
          array( 'value' => 'tooltip', 'label' => __( 'Tooltip', 'cornerstone' ), )
        ),
        'condition' => array(
          'link' => true
        )
      )
    );

    $this->addControl(
      'info_place',
      'choose',
      __( 'Info Placement', 'cornerstone' ),
      __( 'Select where you want your popover or tooltip to appear.', 'cornerstone' ),
      'top',
      array(
        'columns' => '4',
        'choices' => array(
          array( 'value' => 'top',    'icon' => fa_entity('arrow-up'),    'tooltip' => __( 'Top', 'cornerstone' ) ),
          array( 'value' => 'right',  'icon' => fa_entity('arrow-right'), 'tooltip' => __( 'Right', 'cornerstone' ) ),
          array( 'value' => 'bottom', 'icon' => fa_entity('arrow-down'),  'tooltip' => __( 'Bottom', 'cornerstone' ) ),
          array( 'value' => 'left',   'icon' => fa_entity('arrow-left'),  'tooltip' => __( 'Left', 'cornerstone' ) )
        ),
        'condition' => array(
          'link' => true,
          'info' => array( 'popover', 'tooltip' )
        )
      )
    );

    $this->addControl(
      'info_trigger',
      'select',
      __( 'Info Trigger', 'cornerstone' ),
      __( 'Select what actions you want to trigger the popover or tooltip.', 'cornerstone' ),
      'hover',
      array(
        'choices' => array(
          array( 'value' => 'hover', 'label' => __( 'Hover', 'cornerstone' ) ),
          array( 'value' => 'click', 'label' => __( 'Click', 'cornerstone' ) ),
          array( 'value' => 'focus', 'label' => __( 'Focus', 'cornerstone' ) )
        ),
        'condition' => array(
          'link' => true,
          'info' => array( 'popover', 'tooltip' )
        )
      )
    );

    $this->addControl(
      'info_content',
      'text',
      __( 'Info Content', 'cornerstone' ),
      __( 'Extra content for the popover.', 'cornerstone' ),
      '',
      array(
        'condition' => array(
          'link' => true,
          'info' => array( 'popover', 'tooltip' )
        )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $href_target = ( $href_target == 'true' ) ? 'blank' : '';

    $shortcode = "[x_image type=\"$image_style\" src=\"$src\" alt=\"$alt\" link=\"$link\" href=\"$href\" title=\"$href_title\" target=\"$href_target\" info=\"$info\" info_place=\"$info_place\" info_trigger=\"$info_trigger\" info_content=\"$info_content\"{$extra}]";

    return $shortcode;

  }

}
