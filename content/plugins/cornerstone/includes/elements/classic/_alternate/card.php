<?php

class CS_Card extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'        => 'card',
      'title'       => __( 'Card', 'cornerstone' ),
      'section'     => 'content',
      'description' => __( 'Card description.', 'cornerstone' ),
      'supports'    => array( 'id', 'class', 'style' ),
      'autofocus' => array(),
      'protected_keys' => array( 'front_title', 'front_text', 'front_graphic', 'front_icon', 'front_image', 'back_title', 'back_text', 'back_button_text', 'back_button_link' )
    );
  }

  public function controls() {

    //
    // General.
    //

    $this->addControl(
      'animation',
      'choose',
      __( 'Flip Direction', 'cornerstone' ),
      __( 'Specify the animation you would like to use for you Card while it flips.', 'cornerstone' ),
      'flip-from-top',
      array(
        'columns' => '4',
        'choices' => array(
          array( 'value' => 'flip-from-bottom', 'icon' => fa_entity( 'arrow-up' ) ),
          array( 'value' => 'flip-from-left',   'icon' => fa_entity( 'arrow-right' ) ),
          array( 'value' => 'flip-from-top',    'icon' => fa_entity( 'arrow-down' ) ),
          array( 'value' => 'flip-from-right',  'icon' => fa_entity( 'arrow-left' ) )
        )
      )
    );

    $this->addControl(
      'center_vertically',
      'toggle',
      __( 'Center Vertically', 'cornerstone' ),
      __( 'Enabling this control ensures that all of your content is centered vertically in the Card.', 'cornerstone' ),
      true
    );

    $this->addControl(
      'card_padding',
      'dimensions',
      __( 'Padding', 'cornerstone' ),
      __( 'Specify the padding you would like to use for both sides of your Card.', 'cornerstone' ),
      array( '10%', '10%', '10%', '10%', 'linked' )
    );


    //
    // Front text.
    //

    $this->addControl(
      'front_title',
      'text',
      __( 'Front Title', 'cornerstone' ),
      __( 'Set the title for the front of your Card.', 'cornerstone' ),
      __( 'Front Title', 'cornerstone' )
    );

    $this->addControl(
      'front_text',
      'textarea',
      __( 'Front Content', 'cornerstone' ),
      __( 'Set the content for the front of your Card.', 'cornerstone' ),
      __( 'This is the content for the front of your Card. You can put anything you like here! Make sure it&apos;s something not too long though. As Shakespeare once said, &ldquo;Brevity is the soul of wit.&rdquo;', 'cornerstone' ),
      array(
        'expandable' => __( 'Content', 'cornerstone' )
      )
    );


    //
    // Front style.
    //

    $this->addSupport( 'border',
      array(
        'name'         => 'front_border_style',
        'controlTitle' => __( 'Front Border', 'cornerstone' ),
        'defaultValue' => 'solid'
      ),
      array(
        'name'         => 'front_border_color',
        'defaultValue' => '#2772a4',
        'options'      => array(
          'condition' => array(
            'front_border_style:not' => 'none',
          )
        )
      ),
      array(
        'name'         => 'front_border_width',
        'defaultValue' => array( '8px', '8px', '8px', '8px', 'linked' ),
        'options'      => array(
          'condition' => array(
            'front_border_style:not' => 'none',
          )
        )
      )
    );

    $this->addControl(
      'front_color',
      'color',
      __( 'Front Text Color', 'cornerstone' ),
      __( 'Select the text color for the front of your Card.', 'cornerstone' ),
      '#ffffff'
    );

    $this->addControl(
      'front_bg_color',
      'color',
      __( 'Front Background Color', 'cornerstone' ),
      __( 'Select the background color for the front of your Card.', 'cornerstone' ),
      '#3498db'
    );

    $this->addControl(
      'front_graphic',
      'select',
      __( 'Front Graphic', 'cornerstone' ),
      __( 'Choose between an icon and a custom image for your front graphic.', 'cornerstone' ),
      'icon',
      array(
        'columns' => '2',
        'choices' => array(
          array( 'value' => 'icon',  'label' => __( 'Icon', 'cornerstone' ) ),
          array( 'value' => 'image', 'label' => __( 'Image', 'cornerstone' ) )
        )
      )
    );


    //
    // Front icon.
    //

    $this->addControl(
      'front_icon',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Specify the icon you would like to use for your Card.', 'cornerstone' ),
      'ship',
      array(
        'condition' => array(
          'front_graphic' => 'icon'
        )
      )
    );

    $this->addControl(
      'front_icon_size',
      'text',
      __( 'Icon Size', 'cornerstone' ),
      __( 'Specify the size of your icon.', 'cornerstone' ),
      '36px',
      array(
        'condition' => array(
          'front_graphic' => 'icon'
        )
      )
    );

    $this->addControl(
      'front_icon_color',
      'color',
      __( 'Icon Color', 'cornerstone' ),
      __( 'Specify the color of your icon.', 'cornerstone' ),
      '#99cbed',
      array(
        'condition' => array(
          'front_graphic' => 'icon'
        )
      )
    );


    //
    // Front image.
    //

    $this->addControl(
      'front_image',
      'image',
      __( 'Image', 'cornerstone' ),
      __( 'Specify the image you would like to use for your Card.', 'cornerstone' ),
      '',
      array(
        'condition' => array(
          'front_graphic' => 'image'
        )
      )
    );

    $this->addControl(
      'front_image_width',
      'text',
      __( 'Image Width', 'cornerstone' ),
      __( 'Specify the width of your image.', 'cornerstone' ),
      '100px',
      array(
        'condition' => array(
          'front_graphic' => 'image'
        )
      )
    );


    //
    // Back text.
    //

    $this->addControl(
      'back_title',
      'text',
      __( 'Back Title ', 'cornerstone' ),
      __( 'Set the title for the back of your Card.', 'cornerstone' ),
      __( 'Back Title', 'cornerstone' )
    );

    $this->addControl(
      'back_text',
      'textarea',
      __( 'Back Content', 'cornerstone' ),
      __( 'Set the content for the back of your Card.', 'cornerstone' ),
      __( 'This is the content for the back of your Card.', 'cornerstone' ),
      array(
        'expandable' => __( 'Content', 'cornerstone' )
      )
    );


    //
    // Back style.
    //

    $this->addSupport( 'border',
      array(
        'name'         => 'back_border_style',
        'controlTitle' => __( 'Back Border', 'cornerstone' ),
        'defaultValue' => 'solid'
      ),
      array(
        'name'         => 'back_border_color',
        'defaultValue' => '#744288',
        'options'      => array(
          'condition' => array(
            'back_border_style:not' => 'none',
          )
        )
      ),
      array(
        'name'         => 'back_border_width',
        'defaultValue' => array( '8px', '8px', '8px', '8px', 'linked' ),
        'options'      => array(
          'condition' => array(
            'back_border_style:not' => 'none',
          )
        )
      )
    );

    $this->addControl(
      'back_color',
      'color',
      __( 'Back Text Color', 'cornerstone' ),
      __( 'Select the text color for the back of your Card.', 'cornerstone' ),
      '#ffffff'
    );

    $this->addControl(
      'back_bg_color',
      'color',
      __( 'Back Background Color', 'cornerstone' ),
      __( 'Select the background color for the back of your Card.', 'cornerstone' ),
      '#9b59b6'
    );


    //
    // Back button.
    //

    $this->addControl(
      'back_button_enabled',
      'toggle',
      __( 'Back Button', 'cornerstone' ),
      __( 'This will show a button on the back of the card, which you can link anywhere you like.', 'cornerstone' ),
      true
    );

    $this->addControl(
      'back_button_text',
      'text',
      __( 'Back Button Text', 'cornerstone' ),
      __( 'Specify the title and content for the back of your Card.', 'cornerstone' ),
      __( 'Click Me!', 'cornerstone' ),
      array(
        'condition' => array(
          'back_button_enabled' => true
        )
      )
    );

    $this->addControl(
      'back_button_link',
      'text',
      __( 'Back Button Link', 'cornerstone' ),
      __( 'Specify the URL for the button on the back of your Card.', 'cornerstone' ),
      '#',
      array(
        'condition' => array(
          'back_button_enabled' => true
        )
      )
    );

    $this->addControl(
      'back_button_color',
      'color',
      __( 'Back Button Text Color', 'cornerstone' ),
      __( 'Select the text color for button on the back of your Card.', 'cornerstone' ),
      '#ffffff',
      array(
        'condition' => array(
          'back_button_enabled' => true
        )
      )
    );

    $this->addControl(
      'back_button_bg_color',
      'color',
      __( 'Back Button Background Color', 'cornerstone' ),
      __( 'Select the background color for button on the back of your Card.', 'cornerstone' ),
      '#744288',
      array(
        'condition' => array(
          'back_button_enabled' => true
        )
      )
    );

  }

  public function render( $atts ) {

    extract( $atts );

    $extra = $this->extra( array(
      'id'    => $id,
      'class' => $class,
      'style' => $style
    ) );

    $card_padding = implode( ' ', $card_padding );

    if ( $front_graphic == 'icon' ) {
      $front_graphic = "front_icon=\"$front_icon\" front_icon_size=\"$front_icon_size\" front_icon_color=\"$front_icon_color\"";
    } else if ( $front_graphic == 'image' ) {
      $front_graphic = "front_image=\"$front_image\" front_image_width=\"$front_image_width\"";
    }

    $front_border = $this->borderStyle( $front_border_width, $front_border_style, $front_border_color );
    $front_style  = $front_border . ' color: ' . $front_color . '; background-color: ' . $front_bg_color . ';';
    $back_border  = $this->borderStyle( $back_border_width, $back_border_style, $back_border_color );
    $back_style   = $back_border . ' color: ' . $back_color . '; background-color: ' . $back_bg_color . ';';

    $front_title      = cs_clean_shortcode_att( $front_title );
    $front_text       = cs_clean_shortcode_att( $front_text );
    $back_title       = cs_clean_shortcode_att( $back_title );
    $back_text        = cs_clean_shortcode_att( $back_text );
    $back_button_text = cs_clean_shortcode_att( $back_button_text );
    $back_button_link = cs_clean_shortcode_att( $back_button_link );

    if ( 'true' == $back_button_enabled ) {
    	$back_button_atts = " back_button_text=\"$back_button_text\" back_button_link=\"$back_button_link\" back_button_color=\"$back_button_color\" back_button_bg_color=\"$back_button_bg_color\"";
    } else {
    	$back_button_atts = " back_button_enabled=\"false\"";
    }

    $shortcode = "[x_card animation=\"$animation\" center_vertically=\"$center_vertically\" front_style=\"$front_style\" $front_graphic front_title=\"$front_title\" front_text=\"$front_text\" back_style=\"$back_style\" back_title=\"$back_title\" back_text=\"$back_text\" $back_button_atts padding=\"$card_padding\"{$extra}]";

    return $shortcode;

  }

}
