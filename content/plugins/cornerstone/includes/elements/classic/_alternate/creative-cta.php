<?php

class CS_Creative_CTA extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'creative-cta',
      'title'       => __( 'Creative CTA', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Creative CTA description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(
    		'text' => '.x-creative-cta',
    	),
      'protected_keys' => array( 'icon_type', 'image', 'link', 'href_target' )
    );
  }

  public function controls() {

    $this->addControl(
      'alt_padding',
      'dimensions',
      __( 'Padding', 'cornerstone' ),
      __( 'Specify the padding you would like to use for your Creative CTA.', 'cornerstone' ),
      array( '25px', '25px', '25px', '25px', 'linked' )
    );

    $this->addControl(
      'text',
      'text',
      __( 'Text', 'cornerstone' ),
      __( 'Specify the text for your Creative CTA.', 'cornerstone' ),
      __( 'Click Here<br>To Learn More!', 'cornerstone' )
    );

    $this->addControl(
      'font_size',
      'text',
      __( 'Text Size', 'cornerstone' ),
      __( 'Specify the size of your text.', 'cornerstone' ),
      '36px'
    );

    $this->addControl(
      'graphic',
      'select',
      __( 'Graphic', 'cornerstone' ),
      __( 'Choose between an icon and a custom image for your graphic.', 'cornerstone' ),
      'icon',
      array(
        'columns' => '2',
        'choices' => array(
          array( 'value' => 'icon',  'label' => __( 'Icon', 'cornerstone' ) ),
          array( 'value' => 'image', 'label' => __( 'Image', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'icon_type',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Specify the icon you would like to use for your Creative CTA.', 'cornerstone' ),
      'lightbulb-o',
      array(
        'condition' => array(
          'graphic' => 'icon'
        )
      )
    );

    $this->addControl(
      'icon_size',
      'text',
      __( 'Icon Size', 'cornerstone' ),
      __( 'Specify the size of your icon.', 'cornerstone' ),
      '48px',
      array(
        'condition' => array(
          'graphic' => 'icon'
        )
      )
    );

    $this->addControl(
      'image',
      'image',
      __( 'Image', 'cornerstone' ),
      __( 'Specify the image you would like to use for your Creative CTA.', 'cornerstone' ),
      '',
      array(
        'condition' => array(
          'graphic' => 'image'
        )
      )
    );

    $this->addControl(
      'image_width',
      'text',
      __( 'Image Width', 'cornerstone' ),
      __( 'Specify the width of your image.', 'cornerstone' ),
      '100px',
      array(
        'condition' => array(
          'graphic' => 'image'
        )
      )
    );

    $this->addControl(
      'animation',
      'choose',
      __( 'Animation', 'cornerstone' ),
      __( 'Specify the animation you would like to use for you Creative CTA.', 'cornerstone' ),
      'slide-top',
      array(
        'columns' => '4',
        'choices' => array(
          array( 'value' => 'slide-top',    'icon' => fa_entity( 'arrow-up' ) ),
          array( 'value' => 'slide-right',  'icon' => fa_entity( 'arrow-right' ) ),
          array( 'value' => 'slide-bottom', 'icon' => fa_entity( 'arrow-down' ) ),
          array( 'value' => 'slide-left',   'icon' => fa_entity( 'arrow-left' ) )
        )
      )
    );

    $this->addControl(
      'link',
      'text',
      __( 'Link', 'cornerstone' ),
      __( 'Specify the URL for your Creative CTA.', 'cornerstone' ),
      '#'
    );

    $this->addControl(
      'href_target',
      'toggle',
      __( 'Open Link in New Window', 'cornerstone' ),
      __( 'Select to open your link in a new window.', 'cornerstone' ),
      false
    );

    $this->addControl(
      'color',
      'color',
      __( 'Text Color', 'cornerstone' ),
      __( 'Select the text color for your Creative CTA.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'bg_color',
      'color',
      __( 'Background Color', 'cornerstone' ),
      __( 'Select the background color for your Creative CTA.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'bg_color_hover',
      'color',
      __( 'Background Color Hover', 'cornerstone' ),
      __( 'Select the background color hover for your Creative CTA.', 'cornerstone' ),
      ''
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $href_target = ( $href_target == 'true' ) ? ' target="blank"' : '';

    $alt_padding = implode( ' ', $alt_padding );

    if ( $graphic == 'icon' ) {
      $graphic = "icon=\"$icon_type\" icon_size=\"$icon_size\"";
    } else if ( $graphic == 'image' ) {
      $graphic = "image=\"$image\" image_width=\"$image_width\"";
    }
    $text = cs_clean_shortcode_att( $text );
    $shortcode = "[x_creative_cta padding=\"$alt_padding\" text=\"$text\" font_size=\"$font_size\" $graphic animation=\"$animation\" link=\"$link\"{$href_target} color=\"$color\" bg_color=\"$bg_color\" bg_color_hover=\"$bg_color_hover\"{$extra}]";

    return $shortcode;

  }

}
