<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/MENU.PHP
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

function x_controls_menu( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'dropdown'
  //     -- 'collapsed'
  //     -- 'modal'

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'menu';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $type      = ( isset( $settings['type'] )      ) ? $settings['type']      : 'inline'; // 01

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Settings
  // ----------------

  $settings_menu_flex_css_row = array(
    'k_pre'     => 'menu_row',
    'group'     => $group_design,
    'condition' => array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ),
  );

  $settings_menu_flex_css_col = array(
    'k_pre'     => 'menu_col',
    'group'     => $group_design,
    'condition' => array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) ),
  );


  // Setup - Options
  // ---------------

  $options_menu_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '16px',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    ),
  );

  $options_menu_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%' ),
    'fallback_value'  => 'inherit',
    'valid_keywords'  => array( 'auto', 'inherit' ),
  );


  // Setup - Controls
  // ----------------

  $controls_setup = array(
    array(
      'key'   => 'menu',
      'type'  => 'menu',
      'label' => __( 'Assign Menu', '__x__' ),
    ),
  );

  if ( $type !== 'dropdown' ) {
    $controls_setup[] = array(
      'key'     => 'menu_base_font_size',
      'type'    => 'slider',
      'label'   => __( 'Base Font Size', '__x__' ),
      'options' => $options_menu_font_size,
    );
  }

  if ( $type === 'inline' ) {
    $controls_setup[] = array(
      'key'     => 'menu_align_self',
      'type'    => 'select',
      'label'   => __( 'Align Self', '__x__' ),
      'options' => array(
        'choices' => array(
          array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )   ),
          array( 'value' => 'center',     'label' => __( 'Center', '__x__' )  ),
          array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )     ),
          array( 'value' => 'stretch',    'label' => __( 'Stretch', '__x__' ) ),
        ),
      ),
    );
  }


  // Controls - Setup
  // ----------------

  $controls = array(
    array(
      'type'       => 'group',
      'title'      => __( 'Setup', '__x__' ),
      'group'      => $group_setup,
      'conditions' => $conditions,
      'controls'   => $controls_setup,
    )
  );


  // Controls - Design
  // -----------------

  if ( $type !== 'dropdown' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( array( 'k_pre' => 'menu', 'group' => $group_design, 'condition' => $conditions ) )
    );
  }

  if ( $type === 'inline' ) {
    $controls = array_merge(
      $controls,
      x_control_flex( array( 'k_pre' => 'menu', 't_pre' => __( 'Self', '__x__' ), 'group' => $group_design, 'condition' => $conditions ) ),
      x_control_flex_layout_css( $settings_menu_flex_css_row ),
      x_control_flex_layout_css( $settings_menu_flex_css_col ),
      x_control_flex( array( 'k_pre' => 'menu_items', 't_pre' => __( 'Items', '__x__' ), 'group' => $group_design, 'condition' => $conditions ) )
    );
  }


  // Returned Value
  // --------------

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_menu( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'dropdown'
  //     -- 'collapsed'
  //     -- 'modal'

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'menu';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Menu', '__x__' );
  $type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'inline'; // 01

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group . ':setup' => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  if ( $type !== 'dropdown' ) {
    $control_groups[$group . ':design'] = array( 'title' => __( 'Design', '__x__' ) );
  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_menu( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'inline'
  //     -- 'dropdown'
  //     -- 'collapsed'
  //     -- 'modal'

  $type = ( isset( $settings['type'] ) ) ? $settings['type'] : 'inline'; // 01


  // Values
  // ------
  // 01. Will not change per module. Meant to be used to conditionally load
  //     output for templates and associated styles.

  $values = array(
    'menu_type' => x_module_value( $type, 'all' ), // 01
    'menu'      => x_module_value( 'sample:default', 'all', true ),
  );

  if ( $type !== 'dropdown' ) {
    $values = array_merge(
      $values,
      array(
        'menu_base_font_size' => x_module_value( '1em', 'style' ),
        'menu_margin'         => x_module_value( '0px', 'style' ),
      )
    );
  }

  if ( $type === 'inline' ) {
    $values = array_merge(
      $values,
      array(
        'menu_align_self'         => x_module_value( 'stretch', 'style' ),
        'menu_flex'               => x_module_value( '0 0 auto', 'style' ),
        'menu_row_flex_direction' => x_module_value( 'row', 'style' ),
        'menu_row_flex_wrap'      => x_module_value( false, 'style' ),
        'menu_row_flex_justify'   => x_module_value( 'space-around', 'style' ),
        'menu_row_flex_align'     => x_module_value( 'stretch', 'style' ),
        'menu_col_flex_direction' => x_module_value( 'column', 'style' ),
        'menu_col_flex_wrap'      => x_module_value( false, 'style' ),
        'menu_col_flex_justify'   => x_module_value( 'space-around', 'style' ),
        'menu_col_flex_align'     => x_module_value( 'stretch', 'style' ),
        'menu_items_flex'         => x_module_value( '0 1 auto', 'style' ),
      )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
