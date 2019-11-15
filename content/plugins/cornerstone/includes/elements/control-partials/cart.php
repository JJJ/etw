<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/CART.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_cart( $settings ) {



  // Setup
  // -----

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'cart';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Cart', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions']   : array();



  // Groups
  // ------

  $group_cart_setup   = $group . ':setup';
  $group_cart_title   = $group . ':title';
  $group_cart_items   = $group . ':items';
  $group_cart_total   = $group . ':total';
  $group_cart_buttons = $group . ':buttons';


  // Options
  // -------

  $options_cart_order_items = array(
    'choices' => array(
      array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
      array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
      array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
    ),
  );

  $options_cart_items_display_remove = array(
    'choices' => array(
      array( 'value' => false, 'label' => __( 'Hide Button', '__x__' ) ),
      array( 'value' => true,  'label' => __( 'Show Button', '__x__' ) ),
    ),
  );

  $options_cart_items_content_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'fallback_value'  => '15px',
    'ranges'          => array(
      'px'  => array( 'min' => '10', 'max' => '25', 'step' => '1' ),
      'em'  => array( 'min' => '1',  'max' => '2',  'step' => '0.01' ),
      'rem' => array( 'min' => '1',  'max' => '2',  'step' => '0.01' ),
    ),
  );

  $options_cart_thumbs_width = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => '80px',
    'ranges'          => array(
      'px'  => array( 'min' => '50',  'max' => '200', 'step' => '1' ),
      'em'  => array( 'min' => '2.5', 'max' => '10',  'step' => '0.01' ),
      'rem' => array( 'min' => '2.5', 'max' => '10',  'step' => '0.01' ),
      '%'   => array( 'min' => '10',  'max' => '35',  'step' => '1' ),
    ),
  );

  $options_cart_buttons_justify_content = array(
    'choices' => array(
      array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' ) ),
      array( 'value' => 'center',        'label' => __( 'Center', '__x__' ) ),
      array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' ) ),
      array( 'value' => 'space-around',  'label' => __( 'Spread', '__x__' ) ),
      array( 'value' => 'space-between', 'label' => __( 'Justify', '__x__' ) ),
    ),
  );



  // Settings
  // --------

  $settings_cart_title = array(
    'k_pre'     => 'cart_title',
    'label_prefix'     => __( 'Title', '__x__' ),
    'group'     => $group_cart_title,
    'conditions' => array_merge( $conditions, array( array( 'key' => 'cart_title', 'op' => 'NOT IN', 'value' => array( '' ) ) ) ),
  );

  $settings_cart_items = array(
    'k_pre'     => 'cart_items',
    'label_prefix'     => __( 'Items', '__x__' ),
    'group'     => $group_cart_items,
    'conditions' => $conditions,
  );

  $settings_cart_items_with_color = array(
    'k_pre'     => 'cart_items',
    'label_prefix'     => __( 'Items', '__x__' ),
    'group'     => $group_cart_items,
    'conditions' => $conditions,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_cart_thumbs = array(
    'k_pre'     => 'cart_thumbs',
    'label_prefix'     => __( 'Items Thumbnail', '__x__' ),
    'group'     => $group_cart_items,
    'conditions' => $conditions,
  );

  $settings_cart_links = array(
    'k_pre'     => 'cart_links',
    'label_prefix'     => __( 'Items Link', '__x__' ),
    'group'     => $group_cart_items,
    'conditions' => $conditions,
  );

  $settings_cart_links_with_color = array(
    'k_pre'     => 'cart_links',
    'label_prefix'     => __( 'Items Link', '__x__' ),
    'group'     => $group_cart_items,
    'conditions' => $conditions,
    'alt_color' => true,
    'options'   => cs_recall( 'options_color_base_interaction_labels' ),
  );

  $settings_cart_quantity = array(
    'k_pre'     => 'cart_quantity',
    'label_prefix'     => __( 'Items Quantity', '__x__' ),
    'group'     => $group_cart_items,
    'conditions' => $conditions,
  );

  $settings_cart_total = array(
    'k_pre'     => 'cart_total',
    'label_prefix'     => __( 'Total', '__x__' ),
    'group'     => $group_cart_total,
    'conditions' => $conditions,
  );

  $settings_cart_buttons = array(
    'k_pre'     => 'cart_buttons',
    'label_prefix'     => __( 'Buttons Container', '__x__' ),
    'group'     => $group_cart_buttons,
    'conditions' => $conditions,
  );



  // Individual Controls
  // -------------------

  $control_cart_title = array(
    'key'   => 'cart_title',
    'type'  => 'text',
    'label' => __( 'Title', '__x__' ),
  );

  $control_cart_order_items = array(
    'key'     => 'cart_order_items',
    'type'    => 'choose',
    'label'   => __( 'Items Placement', '__x__' ),
    'options' => $options_cart_order_items,
  );

  $control_cart_order_total = array(
    'key'     => 'cart_order_total',
    'type'    => 'choose',
    'label'   => __( 'Total Placement', '__x__' ),
    'options' => $options_cart_order_items,
  );

  $control_cart_order_buttons = array(
    'key'     => 'cart_order_buttons',
    'type'    => 'choose',
    'label'   => __( 'Buttons Placement', '__x__' ),
    'options' => $options_cart_order_items,
  );

  $control_cart_items_display_remove = array(
    'key'     => 'cart_items_display_remove',
    'type'    => 'choose',
    'label'   => __( '"Remove" Button', '__x__' ),
    'options' => $options_cart_items_display_remove,
  );

  $control_cart_items_content_spacing = array(
    'key'     => 'cart_items_content_spacing',
    'type'    => 'slider',
    'label'   => __( 'Content Spacing', '__x__' ),
    'options' => $options_cart_items_content_spacing,
  );

  $control_cart_items_bg_colors = array(
    'keys' => array(
      'value' => 'cart_items_bg',
      'alt'   => 'cart_items_bg_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Background', '__x__' ),
    'options'   => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_cart_thumbs_width = array(
    'key'     => 'cart_thumbs_width',
    'type'    => 'slider',
    'label'   => __( 'Thumbnail Width', '__x__' ),
    'options' => $options_cart_thumbs_width,
  );

  $control_cart_total_bg = array(
    'key'   => 'cart_total_bg',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_cart_buttons_justify_content = array(
    'key'     => 'cart_buttons_justify_content',
    'type'    => 'select',
    'label'   => __( 'Horizontal Alignment', '__x__' ),
    'options' => $options_cart_buttons_justify_content,
  );

  $control_cart_buttons_bg = array(
    'key'   => 'cart_buttons_bg',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  // Compose Controls
  // ----------------

  return array(
    'controls' => array_merge(

      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_cart_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_cart_title,
            $control_cart_order_items,
            $control_cart_order_total,
            $control_cart_order_buttons,
          ),
        ),
      ),

      x_control_text_format( $settings_cart_title ),
      x_control_text_shadow( $settings_cart_title ),
      x_control_margin( $settings_cart_title ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Items Setup', '__x__' ),
          'group'      => $group_cart_items,
          'conditions' => $conditions,
          'controls'   => array(
            $control_cart_items_display_remove,
            $control_cart_items_content_spacing,
            $control_cart_items_bg_colors,
          ),
        ),
      ),

      x_control_margin( $settings_cart_items ),
      x_control_padding( $settings_cart_items ),
      x_control_border( $settings_cart_items_with_color ),
      x_control_border_radius( $settings_cart_items ),
      x_control_box_shadow( $settings_cart_items_with_color ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Items Thumbnail Setup', '__x__' ),
          'group'      => $group_cart_items,
          'conditions' => $conditions,
          'controls'   => array(
            $control_cart_thumbs_width,
          ),
        ),
      ),

      x_control_border_radius( $settings_cart_thumbs ),
      x_control_box_shadow( $settings_cart_thumbs ),

      x_control_text_format( $settings_cart_links ),
      x_control_text_shadow( $settings_cart_links_with_color ),

      x_control_text_format( $settings_cart_quantity ),
      x_control_text_shadow( $settings_cart_quantity ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Total Setup', '__x__' ),
          'group'      => $group_cart_total,
          'conditions' => $conditions,
          'controls'   => array(
            $control_cart_total_bg,
          ),
        ),
      ),

      x_control_text_format( $settings_cart_total ),
      x_control_text_shadow( $settings_cart_total ),
      x_control_margin( $settings_cart_total ),
      x_control_padding( $settings_cart_total ),
      x_control_border( $settings_cart_total ),
      x_control_border_radius( $settings_cart_total ),
      x_control_box_shadow( $settings_cart_total ),

      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Buttons Container Setup', '__x__' ),
          'group'      => $group_cart_buttons,
          'conditions' => $conditions,
          'controls'   => array(
            $control_cart_buttons_justify_content,
            $control_cart_buttons_bg,
          ),
        ),
      ),

      x_control_margin( $settings_cart_buttons ),
      x_control_padding( $settings_cart_buttons ),
      x_control_border( $settings_cart_buttons ),
      x_control_border_radius( $settings_cart_buttons ),
      x_control_box_shadow( $settings_cart_buttons )
    ),
    'controls_std_content' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Cart Content', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_cart_title,
        ),
      ),
    ),
    'controls_std_design_colors' => array_merge(
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Title Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'  => array( 'value' => 'cart_title_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'cart_title_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'cart_title_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      ),
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Items Colors', '__x__' ),
          'controls' => array(
            array(
              'keys' => array(
                'value' => 'cart_items_box_shadow_color',
                'alt'   => 'cart_items_box_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'cart_items_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_cart_items_bg_colors,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_cart_items_with_color,
          array(
            'label_prefix'     => __( 'Cart Items', '__x__' ),
            'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'cart_items_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'cart_items_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      ),
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Thumbnails Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'      => array( 'value' => 'cart_thumbs_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'cart_thumbs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      ),
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Links Colors', '__x__' ),
          'controls' => array(
            array(
              'keys' => array(
                'value' => 'cart_links_text_color',
                'alt'   => 'cart_links_text_color_alt',
              ),
              'type'    => 'color',
              'label'   => __( 'Text', '__x__' ),
              'options' => cs_recall( 'options_base_interaction_labels' ),
            ),
            array(
              'keys' => array(
                'value' => 'cart_links_text_shadow_color',
                'alt'   => 'cart_links_text_shadow_color_alt',
              ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'cart_links_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      ),
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Quantity Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'  => array( 'value' => 'cart_quantity_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'cart_quantity_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'cart_quantity_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
          ),
        ),
      ),
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Total Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'  => array( 'value' => 'cart_total_text_color' ),
              'type'  => 'color',
              'label' => __( 'Text', '__x__' ),
            ),
            array(
              'keys'      => array( 'value' => 'cart_total_text_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'cart_total_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys'      => array( 'value' => 'cart_total_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'cart_total_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_cart_total_bg,
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_cart_total,
          array(
            'label_prefix'     => __( 'Cart Total', '__x__' ),
            'options'   => array( 'color_only' => true ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'cart_total_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'cart_total_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      ),
      array(
        array(
          'type'     => 'group',
          'label'    => __( 'Cart Buttons Container Colors', '__x__' ),
          'controls' => array(
            array(
              'keys'      => array( 'value' => 'cart_buttons_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'cart_buttons_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_cart_buttons_bg
          ),
        ),
      ),
      x_control_border(
        array_merge(
          $settings_cart_buttons,
          array(
            'label_prefix'     => __( 'Cart Buttons Container', '__x__' ),
            'options'   => array( 'color_only' => true ),
            'conditions' => array_merge( $conditions, array(
              array( 'key' => 'cart_buttons_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'cart_buttons_border_style', 'op' => '!=', 'value' => 'none' )
            ) ),
          )
        )
      )
    ),
    'control_nav' => array(
      $group              => $group_title,
      $group_cart_setup   => __( 'Setup', '__x__' ),
      $group_cart_title   => __( 'Title', '__x__' ),
      $group_cart_items   => __( 'Items', '__x__' ),
      $group_cart_total   => __( 'Total', '__x__' ),
      $group_cart_buttons => __( 'Buttons Container', '__x__' ),
    )
  );
}

cs_register_control_partial( 'cart', 'x_control_partial_cart' );
