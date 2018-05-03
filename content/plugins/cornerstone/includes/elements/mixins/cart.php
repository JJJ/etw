<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/CART.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_cart( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'cart';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup   = $group . ':setup';
  $group_title   = $group . ':title';
  $group_items   = $group . ':items';
  $group_total   = $group . ':total';
  $group_buttons = $group . ':buttons';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Settings
  // ----------------

  $settings_cart_title = array(
    'k_pre'     => 'cart_title',
    't_pre'     => __( 'Title', '__x__' ),
    'group'     => $group_title,
    'condition' => array( $condition, array( 'key' => 'cart_title', 'op' => 'NOT IN', 'value' => array( '' ) ) ),
  );

  $settings_cart_items = array(
    'k_pre'     => 'cart_items',
    't_pre'     => __( 'Items', '__x__' ),
    'group'     => $group_items,
    'condition' => $conditions,
  );

  $settings_cart_items_with_color = array(
    'k_pre'     => 'cart_items',
    't_pre'     => __( 'Items', '__x__' ),
    'group'     => $group_items,
    'condition' => $conditions,
    'alt_color' => true,
    'options'   => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_cart_thumbs = array(
    'k_pre'     => 'cart_thumbs',
    't_pre'     => __( 'Items Thumbnail', '__x__' ),
    'group'     => $group_items,
    'condition' => $conditions,
  );

  $settings_cart_links = array(
    'k_pre'     => 'cart_links',
    't_pre'     => __( 'Items Link', '__x__' ),
    'group'     => $group_items,
    'condition' => $conditions,
  );

  $settings_cart_links_with_color = array(
    'k_pre'     => 'cart_links',
    't_pre'     => __( 'Items Link', '__x__' ),
    'group'     => $group_items,
    'condition' => $conditions,
    'alt_color' => true,
    'options'   => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_cart_quantity = array(
    'k_pre'     => 'cart_quantity',
    't_pre'     => __( 'Items Quantity', '__x__' ),
    'group'     => $group_items,
    'condition' => $conditions,
  );

  $settings_cart_total = array(
    'k_pre'     => 'cart_total',
    't_pre'     => __( 'Total', '__x__' ),
    'group'     => $group_total,
    'condition' => $conditions,
  );

  $settings_cart_buttons = array(
    'k_pre'     => 'cart_buttons',
    't_pre'     => __( 'Buttons Container', '__x__' ),
    'group'     => $group_buttons,
    'condition' => $conditions,
  );


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'cart_title',
            'type'  => 'text',
            'label' => __( 'Title', '__x__' ),
          ),
          array(
            'key'     => 'cart_order_items',
            'type'    => 'choose',
            'label'   => __( 'Items Placement', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
                array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
                array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'cart_order_total',
            'type'    => 'choose',
            'label'   => __( 'Total Placement', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
                array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
                array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'cart_order_buttons',
            'type'    => 'choose',
            'label'   => __( 'Buttons Placement', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => '1', 'label' => __( '1st', '__x__' ) ),
                array( 'value' => '2', 'label' => __( '2nd', '__x__' ) ),
                array( 'value' => '3', 'label' => __( '3rd', '__x__' ) ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_control_text_format( $settings_cart_title ),
    x_control_text_style( $settings_cart_title ),
    x_control_text_shadow( $settings_cart_title ),
    x_control_margin( $settings_cart_title ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Items Setup', '__x__' ),
        'group'      => $group_items,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'cart_items_display_remove',
            'type'    => 'choose',
            'label'   => __( '"Remove" Button', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Hide Button', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'Show Button', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'cart_items_content_spacing',
            'type'    => 'slider',
            'title'   => __( 'Content Spacing', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'fallback_value'  => '15px',
              'ranges'          => array(
                'px'  => array( 'min' => '10', 'max' => '25', 'step' => '1' ),
                'em'  => array( 'min' => '1',  'max' => '2',  'step' => '0.01' ),
                'rem' => array( 'min' => '1',  'max' => '2',  'step' => '0.01' ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'cart_items_bg',
              'alt'   => 'cart_items_bg_alt',
            ),
            'type'      => 'color',
            'label'     => __( 'Background', '__x__' ),
            'options'   => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
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
        'title'      => __( 'Items Thumbnail Setup', '__x__' ),
        'group'      => $group_items,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'cart_thumbs_width',
            'type'    => 'slider',
            'title'   => __( 'Thumbnail Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem', '%' ),
              'fallback_value'  => '80px',
              'ranges'          => array(
                'px'  => array( 'min' => '50',  'max' => '200', 'step' => '1' ),
                'em'  => array( 'min' => '2.5', 'max' => '10',  'step' => '0.01' ),
                'rem' => array( 'min' => '2.5', 'max' => '10',  'step' => '0.01' ),
                '%'   => array( 'min' => '10',  'max' => '35',  'step' => '1' ),
              ),
            ),
          ),
        ),
      ),
    ),
    x_control_border_radius( $settings_cart_thumbs ),
    x_control_box_shadow( $settings_cart_thumbs ),
    x_control_text_format( $settings_cart_links ),
    x_control_text_style( $settings_cart_links_with_color ),
    x_control_text_shadow( $settings_cart_links_with_color ),
    x_control_text_format( $settings_cart_quantity ),
    x_control_text_style( $settings_cart_quantity ),
    x_control_text_shadow( $settings_cart_quantity ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Total Setup', '__x__' ),
        'group'      => $group_total,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'cart_total_bg',
            'type'  => 'color',
            'label' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_text_format( $settings_cart_total ),
    x_control_text_style( $settings_cart_total ),
    x_control_text_shadow( $settings_cart_total ),
    x_control_margin( $settings_cart_total ),
    x_control_padding( $settings_cart_total ),
    x_control_border( $settings_cart_total ),
    x_control_border_radius( $settings_cart_total ),
    x_control_box_shadow( $settings_cart_total ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Buttons Container Setup', '__x__' ),
        'group'      => $group_buttons,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'cart_buttons_justify_content',
            'type'    => 'select',
            'label'   => __( 'Horizontal Alignment', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' ) ),
                array( 'value' => 'center',        'label' => __( 'Center', '__x__' ) ),
                array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' ) ),
                array( 'value' => 'space-around',  'label' => __( 'Spread', '__x__' ) ),
                array( 'value' => 'space-between', 'label' => __( 'Justify', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'   => 'cart_buttons_bg',
            'type'  => 'color',
            'label' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_cart_buttons ),
    x_control_padding( $settings_cart_buttons ),
    x_control_border( $settings_cart_buttons ),
    x_control_border_radius( $settings_cart_buttons ),
    x_control_box_shadow( $settings_cart_buttons )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_cart( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'cart';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Cart', '__x__' );

  $control_groups = array(
    $group              => array( 'title' => $group_title ),
    $group . ':setup'   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':title'   => array( 'title' => __( 'Title', '__x__' ) ),
    $group . ':items'   => array( 'title' => __( 'Items', '__x__' ) ),
    $group . ':total'   => array( 'title' => __( 'Total', '__x__' ) ),
    $group . ':buttons' => array( 'title' => __( 'Buttons Container', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_cart( $settings = array() ) {

  // Values
  // ------

  $values = array(

    'cart_title'                           => x_module_value( __( 'Your Items', '__x__' ), 'all', true ),
    'cart_order_items'                     => x_module_value( '1', 'style' ),
    'cart_order_total'                     => x_module_value( '2', 'style' ),
    'cart_order_buttons'                   => x_module_value( '3', 'style' ),

    'cart_title_font_family'               => x_module_value( 'inherit', 'style:font-family' ),
    'cart_title_font_weight'               => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_title_font_size'                 => x_module_value( '2em', 'style' ),
    'cart_title_letter_spacing'            => x_module_value( '-0.035em', 'style' ),
    'cart_title_line_height'               => x_module_value( '1.1', 'style' ),
    'cart_title_font_style'                => x_module_value( 'normal', 'style' ),
    'cart_title_text_align'                => x_module_value( 'none', 'style' ),
    'cart_title_text_decoration'           => x_module_value( 'none', 'style' ),
    'cart_title_text_transform'            => x_module_value( 'none', 'style' ),
    'cart_title_text_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_title_text_shadow_dimensions'    => x_module_value( '0px 0px 0px', 'style' ),
    'cart_title_text_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'cart_title_margin'                    => x_module_value( '0px 0px 15px 0px', 'style' ),

    'cart_items_display_remove'            => x_module_value( true, 'style' ),
    'cart_items_content_spacing'           => x_module_value( '15px', 'style' ),
    'cart_items_bg'                        => x_module_value( 'transparent', 'style:color' ),
    'cart_items_bg_alt'                    => x_module_value( 'transparent', 'style:color' ),
    'cart_items_margin'                    => x_module_value( '0px', 'style' ),
    'cart_items_padding'                   => x_module_value( '15px 0px 15px 0px', 'style' ),
    'cart_items_border_width'              => x_module_value( '1px 0px 0px 0px', 'style' ),
    'cart_items_border_style'              => x_module_value( 'solid', 'style' ),
    'cart_items_border_color'              => x_module_value( 'rgba(0, 0, 0, 0.065) transparent transparent transparent', 'style:color' ),
    'cart_items_border_color_alt'          => x_module_value( 'rgba(0, 0, 0, 0.065) transparent transparent transparent', 'style:color' ),
    'cart_items_border_radius'             => x_module_value( '0px', 'style' ),
    'cart_items_box_shadow_dimensions'     => x_module_value( '0em 0em 0em 0em', 'style' ),
    'cart_items_box_shadow_color'          => x_module_value( 'transparent', 'style:color' ),
    'cart_items_box_shadow_color_alt'      => x_module_value( 'transparent', 'style:color' ),

    'cart_thumbs_width'                    => x_module_value( '70px', 'style' ),
    'cart_thumbs_border_radius'            => x_module_value( '5px', 'style' ),
    'cart_thumbs_box_shadow_dimensions'    => x_module_value( '0em 0.15em 1em 0em', 'style' ),
    'cart_thumbs_box_shadow_color'         => x_module_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),

    'cart_links_font_family'               => x_module_value( 'inherit', 'style:font-family' ),
    'cart_links_font_weight'               => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_links_font_size'                 => x_module_value( '1em', 'style' ),
    'cart_links_letter_spacing'            => x_module_value( '0em', 'style' ),
    'cart_links_line_height'               => x_module_value( '1.4', 'style' ),
    'cart_links_font_style'                => x_module_value( 'normal', 'style' ),
    'cart_links_text_align'                => x_module_value( 'none', 'style' ),
    'cart_links_text_decoration'           => x_module_value( 'none', 'style' ),
    'cart_links_text_transform'            => x_module_value( 'none', 'style' ),
    'cart_links_text_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_links_text_color_alt'            => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'cart_links_text_shadow_dimensions'    => x_module_value( '0px 0px 0px', 'style' ),
    'cart_links_text_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'cart_links_text_shadow_color_alt'     => x_module_value( 'transparent', 'style:color' ),

    'cart_quantity_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'cart_quantity_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_quantity_font_size'              => x_module_value( '0.85em', 'style' ),
    'cart_quantity_letter_spacing'         => x_module_value( '0em', 'style' ),
    'cart_quantity_line_height'            => x_module_value( '1.9', 'style' ),
    'cart_quantity_font_style'             => x_module_value( 'normal', 'style' ),
    'cart_quantity_text_align'             => x_module_value( 'none', 'style' ),
    'cart_quantity_text_decoration'        => x_module_value( 'none', 'style' ),
    'cart_quantity_text_transform'         => x_module_value( 'none', 'style' ),
    'cart_quantity_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_quantity_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'cart_quantity_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    'cart_total_bg'                        => x_module_value( 'transparent', 'style' ),
    'cart_total_font_family'               => x_module_value( 'inherit', 'style:font-family' ),
    'cart_total_font_weight'               => x_module_value( 'inherit:400', 'style:font-weight' ),
    'cart_total_font_size'                 => x_module_value( '1em', 'style' ),
    'cart_total_letter_spacing'            => x_module_value( '0em', 'style' ),
    'cart_total_line_height'               => x_module_value( '1', 'style' ),
    'cart_total_font_style'                => x_module_value( 'normal', 'style' ),
    'cart_total_text_align'                => x_module_value( 'center', 'style' ),
    'cart_total_text_decoration'           => x_module_value( 'none', 'style' ),
    'cart_total_text_transform'            => x_module_value( 'none', 'style' ),
    'cart_total_text_color'                => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'cart_total_text_shadow_dimensions'    => x_module_value( '0px 0px 0px', 'style' ),
    'cart_total_text_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'cart_total_margin'                    => x_module_value( '0px', 'style' ),
    'cart_total_padding'                   => x_module_value( '10px 0px 10px 0px', 'style' ),
    'cart_total_border_width'              => x_module_value( '1px 0px 1px 0px', 'style' ),
    'cart_total_border_style'              => x_module_value( 'solid', 'style' ),
    'cart_total_border_color'              => x_module_value( 'rgba(0, 0, 0, 0.065) transparent rgba(0, 0, 0, 0.065) transparent', 'style:color' ),
    'cart_total_border_radius'             => x_module_value( '0px', 'style' ),
    'cart_total_box_shadow_dimensions'     => x_module_value( '0em 0em 0em 0em', 'style' ),
    'cart_total_box_shadow_color'          => x_module_value( 'transparent', 'style:color' ),

    'cart_buttons_justify_content'         => x_module_value( 'space-between', 'style' ),
    'cart_buttons_bg'                      => x_module_value( 'transparent', 'style:color' ),
    'cart_buttons_margin'                  => x_module_value( '15px 0px 0px 0px', 'style' ),
    'cart_buttons_padding'                 => x_module_value( '0px', 'style' ),
    'cart_buttons_border_width'            => x_module_value( '0px', 'style' ),
    'cart_buttons_border_style'            => x_module_value( 'solid', 'style' ),
    'cart_buttons_border_color'            => x_module_value( 'transparent', 'style:color' ),
    'cart_buttons_border_radius'           => x_module_value( '0px', 'style' ),
    'cart_total_box_shadow_dimensions'     => x_module_value( '0em 0em 0em 0em', 'style' ),
    'cart_total_box_shadow_color'          => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
