<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/TOGGLE.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
//   02. Values
// =============================================================================

// Control
// =============================================================================

function x_controls_toggle( $settings = array() ) {

  // Setup
  // -----

  $t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
  $k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
  $group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'general';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();

  $options_toggle_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'ranges'          => array(
      'px'  => array( 'min' => 1,   'max' => 10, 'step' => 1     ),
      'em'  => array( 'min' => 0.1, 'max' => 1,  'step' => 0.001 ),
      'rem' => array( 'min' => 0.1, 'max' => 1,  'step' => 0.001 ),
    ),
  );

  $options_toggle_spacing = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'ranges'          => array(
      'px'  => array( 'min' => 1, 'max' => 15, 'step' => 1   ),
      'em'  => array( 'min' => 1, 'max' => 10, 'step' => 0.1 ),
      'rem' => array( 'min' => 1, 'max' => 10, 'step' => 0.1 ),
    ),
  );

  $options_toggle_width = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'ranges'          => array(
      'px'  => array( 'min' => 1, 'max' => 50, 'step' => 1   ),
      'em'  => array( 'min' => 1, 'max' => 20, 'step' => 0.1 ),
      'rem' => array( 'min' => 1, 'max' => 20, 'step' => 0.1 ),
    ),
  );

  $condition_burger = array(
    'key'   => $k_pre . 'toggle_type',
    'op'    => 'IN',
    'value' => array( 'burger-1' ),
  );

  $condition_grid = array(
    'key'   => $k_pre . 'toggle_type',
    'op'    => 'IN',
    'value' => array( 'grid-1' ),
  );

  $condition_more = array(
    'key'   => $k_pre . 'toggle_type',
    'op'    => 'IN',
    'value' => array( 'more-h-1', 'more-v-1' ),
  );


  // Data
  // ----

  $data = array(
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . 'Toggle', '__x__' ),
      'group'      => $group,
      'conditions' => x_module_conditions( $condition ),
      'controls'   => array(
        array(
          'key'     => $k_pre . 'toggle_type',
          'type'    => 'select',
          'label'   => __( 'Type', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'burger-1', 'label' => __( 'Burger', '__x__' ) ),
              array( 'value' => 'grid-1',   'label' => __( 'Grid', '__x__' ) ),
              array( 'value' => 'more-h-1', 'label' => __( 'More Horizontal', '__x__' ) ),
              array( 'value' => 'more-v-1', 'label' => __( 'More Vertical', '__x__' ) ),
            ),
          ),
        ),
        array(
          'key'       => $k_pre . 'toggle_burger_size',
          'type'      => 'slider',
          'title'     => __( 'Burger Size', '__x__' ),
          'options'   => $options_toggle_size,
          'condition' => $condition_burger,
        ),
        array(
          'key'       => $k_pre . 'toggle_burger_spacing',
          'type'      => 'slider',
          'title'     => __( 'Burger Spacing', '__x__' ),
          'options'   => $options_toggle_spacing,
          'condition' => $condition_burger,
        ),
        array(
          'key'       => $k_pre . 'toggle_burger_width',
          'type'      => 'slider',
          'title'     => __( 'Burger Width', '__x__' ),
          'options'   => $options_toggle_width,
          'condition' => $condition_burger,
        ),
        array(
          'key'       => $k_pre . 'toggle_grid_size',
          'type'      => 'slider',
          'title'     => __( 'Grid Size', '__x__' ),
          'options'   => $options_toggle_size,
          'condition' => $condition_grid,
        ),
        array(
          'key'       => $k_pre . 'toggle_grid_spacing',
          'type'      => 'slider',
          'title'     => __( 'Grid Spacing', '__x__' ),
          'options'   => $options_toggle_spacing,
          'condition' => $condition_grid,
        ),
        array(
          'key'       => $k_pre . 'toggle_more_size',
          'type'      => 'slider',
          'title'     => __( 'More Size', '__x__' ),
          'options'   => $options_toggle_size,
          'condition' => $condition_more,
        ),
        array(
          'key'       => $k_pre . 'toggle_more_spacing',
          'type'      => 'slider',
          'title'     => __( 'More Spacing', '__x__' ),
          'options'   => $options_toggle_spacing,
          'condition' => $condition_more,
        ),
        array(
          'keys' => array(
            'value' => $k_pre . 'toggle_color',
            'alt'   => $k_pre . 'toggle_color_alt',
          ),
          'type'      => 'color',
          'label'     => __( 'Color', '__x__' ),
          'options'   => array(
            'label'     => __( 'Base', '__x__' ),
            'alt_label' => __( 'Interaction', '__x__' ),
          ),
        ),
      ),
    ),
  );


  // Returned Value
  // --------------

  $controls = $data;

  return $controls;

}



// Values
// =============================================================================

function x_values_toggle( $settings = array() ) {

  // Setup
  // -----
  // Requires some extra steps as the toggle is a 2nd level mixin to be used in
  // other 1st level mixins, such as the anchor.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }


  // Values
  // ------

  $values = array(
    $k_pre . 'toggle_type'           => x_module_value( 'burger-1', 'all' ),
    $k_pre . 'toggle_burger_size'    => x_module_value( '0.1em', 'style' ),
    $k_pre . 'toggle_burger_spacing' => x_module_value( '3.25em', 'style' ),
    $k_pre . 'toggle_burger_width'   => x_module_value( '12em', 'style' ),
    $k_pre . 'toggle_grid_size'      => x_module_value( '0.25em', 'style' ),
    $k_pre . 'toggle_grid_spacing'   => x_module_value( '1.75em', 'style' ),
    $k_pre . 'toggle_more_size'      => x_module_value( '0.35em', 'style' ),
    $k_pre . 'toggle_more_spacing'   => x_module_value( '1.75em', 'style' ),
    $k_pre . 'toggle_color'          => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    $k_pre . 'toggle_color_alt'      => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
