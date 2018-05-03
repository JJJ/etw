<?php

class CS_Feature_List_Item extends Cornerstone_Element_Base {

  public function data() {
    return array(
      'name'           => 'feature-list-item',
      'title'          => __( 'Feature List Item', 'cornerstone' ),
      'section'        => '_content',
      'description'    => __( 'Feature List Item description.', 'cornerstone' ),
      'supports'       => array( 'id', 'class', 'style' ),
      'render'         => false,
      'delegate'       => true,
      'alt_breadcrumb' => __( 'Item', 'cornerstone' ),
      'protected_keys' => array( 'title', 'content', 'graphic_icon', 'graphic_image', 'graphic_image_alt_text', 'link_text', 'href', 'href_title', 'href_target' )
    );
  }

  public function controls() {

    //
    // General.
    //

    $this->addControl(
      'title',
      'title',
      NULL,
      NULL,
      ''
    );

    $this->addControl(
      'content',
      'text',
      __( 'Content', 'cornerstone' ),
      __( 'Specify the content for your Feature List Item.', 'cornerstone' ),
      __( 'This is where the text for your Feature List Item should go. It&apos;s best to keep it short and sweet.', 'cornerstone' )
    );

    $this->addControl(
      'title_color',
      'color',
      __( 'Title &amp; Content Colors', 'cornerstone' ),
      __( 'Optionally specify colors for your title and content.', 'cornerstone' ),
      ''
    );

    $this->addControl(
      'text_color',
      'color',
      NULL,
      NULL,
      ''
    );


    //
    // Graphic - icon and image.
    //

    $this->addControl(
      'graphic_icon',
      'icon-choose',
      __( 'Icon', 'cornerstone' ),
      __( 'Specify the icon you would like to use for your Feature List Item.', 'cornerstone' ),
      'ship'//,
      // array(
      //   'condition' => array(
      //     'parent:graphic' => 'icon'
      //   )
      // )
    );

    $this->addControl(
      'graphic_image',
      'image',
      __( 'Image', 'cornerstone' ),
      __( 'Specify the image you would like to use for your Feature List Item.', 'cornerstone' ),
      ''//,
      // array(
      //   'condition' => array(
      //     'parent:graphic' => 'image'
      //   )
      // )
    );


    //
    // Graphic - colors.
    //

    $this->addControl(
      'graphic_color',
      'color',
      __( 'Graphic Color &amp; Background Color', 'cornerstone' ),
      __( 'Specify the color and background color of your graphic.', 'cornerstone' ),
      '#ffffff'
    );

    $this->addControl(
      'graphic_bg_color',
      'color',
      NULL,
      NULL,
      '#2ecc71'
    );


    //
    // Graphic - shape.
    //

    $this->addControl(
      'graphic_shape',
      'select',
      __( 'Graphic Shape', 'cornerstone' ),
      __( 'Choose a shape for your Feature List Item graphic.', 'cornerstone' ),
      'square',
      array(
        'choices' => array(
          array( 'value' => 'square',  'label' => __( 'Square', 'cornerstone' ) ),
          array( 'value' => 'rounded', 'label' => __( 'Rounded', 'cornerstone' ) ),
          array( 'value' => 'circle',  'label' => __( 'Circle', 'cornerstone' ) ),
          array( 'value' => 'hexagon', 'label' => __( 'Hexagon (Icon and Numbers Only)', 'cornerstone' ) ),
          array( 'value' => 'badge',   'label' => __( 'Badge (Icon and Numbers Only)', 'cornerstone' ) )
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
    // Link.
    //

    $this->addControl(
      'link_text',
      'text',
      __( 'Link Text', 'cornerstone' ),
      __( 'Enter the text for your Feature List Item link. Leave blank to remove.', 'cornerstone' ),
      ''
    );

    $this->addSupport( 'link' );

    $this->addControl(
      'link_color',
      'color',
      __( 'Link Color', 'cornerstone' ),
      __( 'Specify a custom color for your Feature List Item link.', 'cornerstone' ),
      ''
    );

  }

  public function migrate( $element, $version ) {

  	if ( version_compare( $version, '1.0.10', '<' ) ) {
  		if ( !isset( $element['content'] ) || '' == $element['content'] && isset( $element['text'] ) ) {
				$element['content'] = $element['text'];
				unset($element['text']);
			}
  	}

		return $element;

  }

}
