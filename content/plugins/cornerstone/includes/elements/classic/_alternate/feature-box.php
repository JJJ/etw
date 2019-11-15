<?php

class CS_Feature_Box extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'feature-box',
      'title'       => __( 'Feature Box', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Feature Box description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'protected_keys' => array( 'title', 'content', 'graphic_icon', 'graphic_image', 'graphic_image_alt_text', 'link_text', 'href', 'href_title', 'href_target' ),
      'label_key' => 'title'
    );
  }

  public function controls() {

    //
    // General.
    //

    $this->addControl(
      'title',
      'text',
      __( 'Title', 'cornerstone' ),
      __( 'Set the title for your Feature Box.', 'cornerstone' ),
      __( 'Feature Box Title', 'cornerstone' )
    );

    $this->addControl(
      'content',
      'text',
      __( 'Title &amp; Content', 'cornerstone' ),
      __( 'Set the content for your Feature Box.', 'cornerstone' ),
      __( 'This is where the text for your Feature Box should go. It&apos;s best to keep it short and sweet.', 'cornerstone' )
    );

    $this->addControl(
      'title_color',
      'color',
      __( 'Title Color', 'cornerstone' ),
      __( 'Optionally specify colors for your title.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'text_color',
      'color',
      __( 'Content Color', 'cornerstone' ),
      __( 'Optionally specify colors for your content.', 'cornerstone' ),
      ''
    );


    //
    // Graphic.
    //

    $this->addControl(
      'graphic',
      'select',
      __( 'Graphic', 'cornerstone' ),
      __( 'Choose between an icon and a custom image for your graphic.', 'cornerstone' ),
      'icon',
      array(
        'choices' => array(
          array( 'value' => 'icon',  'label' => __( 'Icon', 'cornerstone' ) ),
          array( 'value' => 'image', 'label' => __( 'Image', 'cornerstone' ) )
        )
      )
    );


    //
    // Graphic - icon and image.
    //

    $this->addControl(
      'graphic_icon',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Specify the icon you would like to use for your Feature List Item.', 'cornerstone' ),
      'ship',
      array(
        'condition' => array(
          'graphic' => 'icon'
        )
      )
    );

    $this->addControl(
      'graphic_image',
      'image',
      __( 'Image', 'cornerstone' ),
      __( 'Specify the image you would like to use for your Feature List Item.', 'cornerstone' ),
      '',
      array(
        'condition' => array(
          'graphic' => 'image'
        )
      )
    );

    $this->addControl(
      'graphic_image_alt_text',
      'text',
      __( 'Graphic Alt Text', 'cornerstone' ),
      NULL,
      '',
      array(
        'condition' => array(
          'graphic' => 'image'
        )
      )
    );


    //
    // Graphic - size.
    //

    $this->addControl(
      'graphic_size',
      'text',
      __( 'Graphic Size', 'cornerstone' ),
      __( 'Specify the size of your graphic.', 'cornerstone' ),
      '60px'
    );


    //
    // Graphic - colors.
    //

    $this->addControl(
      'graphic_color',
      'color',
      __( 'Graphic Color', 'cornerstone' ),
      __( 'Specify the color of your graphic.', 'cornerstone' ),
      '#ffffff'
    );

    $this->addControl(
      'graphic_bg_color',
      'color',
      __( 'Graphic Background Color', 'cornerstone' ),
      __( 'Specify the background color of your graphic.', 'cornerstone' ),
      '#2ecc71'
    );


    //
    // Graphic - shape.
    //

    $this->addControl(
      'graphic_shape',
      'select',
      __( 'Graphic Shape', 'cornerstone' ),
      __( 'Choose a shape for your Feature Box graphic.', 'cornerstone' ),
      'square',
      array(
        'choices' => array(
          array( 'value' => 'square',  'label' => __( 'Square', 'cornerstone' ) ),
          array( 'value' => 'rounded', 'label' => __( 'Rounded', 'cornerstone' ) ),
          array( 'value' => 'circle',  'label' => __( 'Circle', 'cornerstone' ) ),
          array( 'value' => 'hexagon', 'label' => __( 'Hexagon (Icon Only)', 'cornerstone' ) ),
          array( 'value' => 'badge',   'label' => __( 'Badge (Icon Only)', 'cornerstone' ) )
        )
      )
    );


    //
    // Graphic - border.
    //

    $this->addSupport( 'border',
      array(
        'name'         => 'graphic_border_style',
        'controlTitle' => __( 'Graphic Border', 'cornerstone' ),
        'options'      => array(
          'condition' => array(
            'graphic_shape:not' => array( 'hexagon', 'badge' )
          )
        )
      ),
      array(
        'name'    => 'graphic_border_color',
        'options' => array(
          'condition' => array(
            'graphic_shape:not'        => array( 'hexagon', 'badge' ),
            'graphic_border_style:not' => 'none'
          )
        )
      ),
      array(
        'name'         => 'graphic_border_width',
        'defaultValue' => array( '2px', '2px', '2px', '2px', 'linked' ),
        'options'      => array(
          'condition' => array(
            'graphic_shape:not'        => array( 'hexagon', 'badge' ),
            'graphic_border_style:not' => 'none'
          )
        )
      )
    );


    //
    // Graphic - animation.
    //

    $this->addSupport( 'animation',
      array(
        'name'         => 'graphic_animation',
        'controlTitle' => __( 'Graphic Animation', 'cornerstone' )
      ),
      array(
        'name'         => 'graphic_animation_offset',
        'controlTitle' => __( 'Graphic Animation Offset (%)', 'cornerstone' ),
        'options'      => array(
          'condition' => array(
            'graphic_animation:not' => 'none'
          )
        )
      ),
      array(
        'name'         => 'graphic_animation_delay',
        'controlTitle' => __( 'Graphic Animation Delay (ms)', 'cornerstone' ),
        'options'      => array(
          'condition' => array(
            'graphic_animation:not' => 'none'
          )
        )
      )
    );


    //
    // Link.
    //

    $this->addControl(
      'link_text',
      'text',
      __( 'Link Text', 'cornerstone' ),
      __( 'Enter the text for your Feature Box link. Leave blank to remove.', 'cornerstone' ),
      ''
    );

    $this->addSupport( 'link' );

    $this->addControl(
      'link_color',
      'color',
      __( 'Link Color', 'cornerstone' ),
      __( 'Specify a custom color for your Feature Box link.', 'cornerstone' ),
      ''
    );


    //
    // Alignment.
    //

    $this->addControl(
      'align_h',
      'select',
      __( 'Horizontal Alignment', 'cornerstone' ),
      __( 'Select the horizontal alignment of the Feature Box.', 'cornerstone' ),
      'center',
      array(
        'choices' => array(
          array( 'value' => 'left',   'label' => __( 'Left', 'cornerstone' ) ),
          array( 'value' => 'center', 'label' => __( 'Center', 'cornerstone' ) ),
          array( 'value' => 'right',  'label' => __( 'Right', 'cornerstone' ) )
        )
      )
    );

    $this->addControl(
      'align_v',
      'select',
      __( 'Vertical Alignment', 'cornerstone' ),
      __( 'Select the vertical alignment of the Feature Box.', 'cornerstone' ),
      'top',
      array(
        'choices' => array(
          array( 'value' => 'top',    'label' => __( 'Top', 'cornerstone' ) ),
          array( 'value' => 'middle', 'label' => __( 'Middle', 'cornerstone' ) )
        ),
        'condition' => array(
          'align_h:not' => 'center'
        )
      )
    );

    $this->addControl(
      'side_graphic_spacing',
      'text',
      __( 'Graphic Spacing', 'cornerstone' ),
      __( 'Specify an amount of spacing you want between your side graphic and the content.', 'cornerstone' ),
      '20px',
      array(
        'condition' => array(
          'align_h:not' => 'center'
        )
      )
    );

    $this->addControl(
      'max_width',
      'text',
      __( 'Max Width', 'cornerstone' ),
      __( 'Enter in a max width for your Feature Box if desired. This will keep your Feature Box from stretching out too far on smaller breakpoints.', 'cornerstone' ),
      'none'
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $params = array(
      'title'                 => $title,
      'title_color'           => $title_color,
      'text_color'            => $text_color,
      'graphic'               => $graphic,
      'graphic_size'          => $graphic_size,
      'graphic_shape'         => $graphic_shape,
      'graphic_color'         => $graphic_color,
      'graphic_bg_color'      => $graphic_bg_color,
      'align_h'               => $align_h,
      'align_v'               => $align_v,
      'side_graphic_spacing'  => $side_graphic_spacing,
      'max_width'             => $max_width
    );

    if ( $link_text != '' ) {
      $params['link_text']   = $link_text;
      $params['href']        = $href;
      $params['href_title']  = $href_title;
      $params['href_target'] = ( $href_target == 'true' ) ? 'blank' : '';
      $params['link_color']  = $link_color;
    }

    if ( $graphic_border_style != 'none' ) {
      $params['graphic_border'] = $this->borderStyle( $graphic_border_width, $graphic_border_style, $graphic_border_color );
    }

    if ( $graphic == 'icon' ) {
      $params['graphic_icon'] = $graphic_icon;
    } else if ( $graphic == 'image' ) {
      $params['graphic_image'] = $graphic_image;
      $params['graphic_image_alt_text'] = $graphic_image_alt_text;
    }

    if ( $graphic_animation != 'none' ) {
      $params['graphic_animation']        = $graphic_animation;
      $params['graphic_animation_offset'] = $graphic_animation_offset;
      $params['graphic_animation_delay']  = $graphic_animation_delay;
    }

    $shortcode = cs_build_shortcode( 'x_feature_box', $params, $extra, $content, true );

    return $shortcode;

  }

}
