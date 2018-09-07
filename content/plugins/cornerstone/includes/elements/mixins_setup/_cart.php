<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_CART.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Conditions
//   05. Options
//   06. Settings
//   07. Individual Controls
//   08. Control Lists
//   09. Control Groups (Advanced)
//   10. Control Groups (Standard Content)
//   11. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'cart';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Cart', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_cart_setup   = $group . ':setup';
$group_cart_title   = $group . ':title';
$group_cart_items   = $group . ':items';
$group_cart_total   = $group . ':total';
$group_cart_buttons = $group . ':buttons';



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

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
// =============================================================================

$settings_cart_title = array(
  'k_pre'     => 'cart_title',
  't_pre'     => __( 'Title', '__x__' ),
  'group'     => $group_cart_title,
  'condition' => array( $condition, array( 'key' => 'cart_title', 'op' => 'NOT IN', 'value' => array( '' ) ) ),
);

$settings_cart_items = array(
  'k_pre'     => 'cart_items',
  't_pre'     => __( 'Items', '__x__' ),
  'group'     => $group_cart_items,
  'condition' => $conditions,
);

$settings_cart_items_with_color = array(
  'k_pre'     => 'cart_items',
  't_pre'     => __( 'Items', '__x__' ),
  'group'     => $group_cart_items,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_cart_thumbs = array(
  'k_pre'     => 'cart_thumbs',
  't_pre'     => __( 'Items Thumbnail', '__x__' ),
  'group'     => $group_cart_items,
  'condition' => $conditions,
);

$settings_cart_links = array(
  'k_pre'     => 'cart_links',
  't_pre'     => __( 'Items Link', '__x__' ),
  'group'     => $group_cart_items,
  'condition' => $conditions,
);

$settings_cart_links_with_color = array(
  'k_pre'     => 'cart_links',
  't_pre'     => __( 'Items Link', '__x__' ),
  'group'     => $group_cart_items,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_cart_quantity = array(
  'k_pre'     => 'cart_quantity',
  't_pre'     => __( 'Items Quantity', '__x__' ),
  'group'     => $group_cart_items,
  'condition' => $conditions,
);

$settings_cart_total = array(
  'k_pre'     => 'cart_total',
  't_pre'     => __( 'Total', '__x__' ),
  'group'     => $group_cart_total,
  'condition' => $conditions,
);

$settings_cart_buttons = array(
  'k_pre'     => 'cart_buttons',
  't_pre'     => __( 'Buttons Container', '__x__' ),
  'group'     => $group_cart_buttons,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

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
  'title'   => __( 'Content Spacing', '__x__' ),
  'options' => $options_cart_items_content_spacing,
);

$control_cart_items_bg_colors = array(
  'keys' => array(
    'value' => 'cart_items_bg',
    'alt'   => 'cart_items_bg_alt',
  ),
  'type'      => 'color',
  'label'     => __( 'Background', '__x__' ),
  'options'   => $options_base_interaction_labels,
);

$control_cart_thumbs_width = array(
  'key'     => 'cart_thumbs_width',
  'type'    => 'slider',
  'title'   => __( 'Thumbnail Width', '__x__' ),
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



// Control Lists
// =============================================================================

// Advanced Setup
// --------------

$control_list_cart_adv_setup = array(
  $control_cart_title,
  $control_cart_order_items,
  $control_cart_order_total,
  $control_cart_order_buttons,
);


// Advanced Items Setup
// --------------------

$control_list_cart_adv_items_setup = array(
  $control_cart_items_display_remove,
  $control_cart_items_content_spacing,
  $control_cart_items_bg_colors,
);


// Advanced Buttons Container Setup
// --------------------------------

$control_list_cart_adv_buttons_container_setup = array(
  $control_cart_buttons_justify_content,
  $control_cart_buttons_bg,
);


// Standard Content Setup
// ----------------------

$control_list_cart_std_content_setup = array(
  $control_cart_title,
);


// Standard Design Colors Title
// ----------------------------

$control_list_cart_std_design_colors_title = array(
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
);


// Standard Design Colors Items
// ----------------------------

$control_list_cart_std_design_colors_items = array(
  array(
    'keys' => array(
      'value' => 'cart_items_box_shadow_color',
      'alt'   => 'cart_items_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'cart_items_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_cart_items_bg_colors,
);


// Standard Design Colors Thumbs
// -----------------------------

$control_list_cart_std_design_colors_thumbs = array(
  array(
    'keys'      => array( 'value' => 'cart_thumbs_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'cart_thumbs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);


// Standard Design Colors Links
// ----------------------------

$control_list_cart_std_design_colors_links = array(
  array(
    'keys' => array(
      'value' => 'cart_links_text_color',
      'alt'   => 'cart_links_text_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => $options_base_interaction_labels,
  ),
  array(
    'keys' => array(
      'value' => 'cart_links_text_shadow_color',
      'alt'   => 'cart_links_text_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'cart_links_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);


// Standard Design Colors Quantity
// -------------------------------

$control_list_cart_std_design_colors_quantity = array(
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
);


// Standard Design Colors Total
// ----------------------------

$control_list_cart_std_design_colors_total = array(
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
);


// Standard Design Colors Buttons Container
// ----------------------------------------

$control_list_cart_std_design_colors_buttons_container = array(
  array(
    'keys'      => array( 'value' => 'cart_buttons_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'cart_buttons_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_cart_buttons_bg
);



// Control Groups (Advanced)
// =============================================================================

$control_group_cart_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_cart_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_cart_adv_setup,
  ),
);

$control_group_cart_adv_items_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Items Setup', '__x__' ),
    'group'      => $group_cart_items,
    'conditions' => $conditions,
    'controls'   => $control_list_cart_adv_items_setup,
  ),
);

$control_group_cart_adv_items_thumbnail_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Items Thumbnail Setup', '__x__' ),
    'group'      => $group_cart_items,
    'conditions' => $conditions,
    'controls'   => array(
      $control_cart_thumbs_width,
    ),
  ),
);

$control_group_cart_adv_total_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Total Setup', '__x__' ),
    'group'      => $group_cart_total,
    'conditions' => $conditions,
    'controls'   => array(
      $control_cart_total_bg,
    ),
  ),
);

$control_group_cart_adv_buttons_container_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Buttons Container Setup', '__x__' ),
    'group'      => $group_cart_buttons,
    'conditions' => $conditions,
    'controls'   => $control_list_cart_adv_buttons_container_setup,
  ),
);



// Control Groups (Standard Content)
// =============================================================================

$control_group_cart_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Cart Content', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_cart_std_content_setup,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_cart_std_design_colors = array_merge(
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Title Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_title,
    ),
  ),
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Items Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_items,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_cart_items_with_color,
      array(
        't_pre'     => __( 'Cart Items', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'cart_items_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'cart_items_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Thumbnails Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_thumbs,
    ),
  ),
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Links Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_links,
    ),
  ),
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Quantity Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_quantity,
    ),
  ),
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Total Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_total,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_cart_total,
      array(
        't_pre'     => __( 'Cart Total', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'cart_total_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'cart_total_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Cart Buttons Container Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_cart_std_design_colors_buttons_container,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_cart_buttons,
      array(
        't_pre'     => __( 'Cart Buttons Container', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'cart_buttons_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'cart_buttons_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);