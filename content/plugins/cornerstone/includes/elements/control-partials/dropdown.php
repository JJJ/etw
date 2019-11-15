<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/DROPDOWN.PHP
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

function x_control_partial_dropdown( $settings ) {


  // Setup
  // -----

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'dropdown';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : __( 'Dropdown', '__x__' );
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : array();
  $inc_links    = ( isset( $settings['inc_links'] )    ) ? true                      : false;



  // Groups
  // ------

  $group_dropdown_setup  = $group . ':setup';
  $group_dropdown_design = $group . ':design';


  // Settings
  // --------

  $settings_dropdown = array(
    'label_prefix'      => __( 'Dropdown', '__x__' ),
    'group'      => $group_dropdown_design,
    'conditions' => $conditions,
  );

  $settings_dropdown_first = array(
    'label_prefix'      => __( 'First Dropdown', '__x__' ),
    'group'      => $group_dropdown_design,
    'conditions' => $conditions,
  );



  // Individual Controls
  // -------------------

  $control_dropdown_base_font_size = array(
    'key'     => $k_pre . 'dropdown_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_dropdown_width = array(
    'key'     => $k_pre . 'dropdown_width',
    'type'    => 'slider',
    'label'   => __( 'Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'auto' ),
      'fallback_value'  => '250px',
      'ranges'          => array(
        'px'  => array( 'min' => 200, 'max' => 500, 'step' => 1    ),
        'em'  => array( 'min' => 15,  'max' => 35,  'step' => 0.01 ),
        'rem' => array( 'min' => 15,  'max' => 35,  'step' => 0.01 ),
      ),
    ),
  );

  $control_dropdown_bg_color = array(
    'key'   => $k_pre . 'dropdown_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  // Compose Controls
  // ----------------

  return array(
    'controls' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Setup', '__x__' ),
        'group'      => $group_dropdown_setup,
        'conditions' => $conditions,
        'controls'   => array(
          $control_dropdown_base_font_size,
          $control_dropdown_width,
          $control_dropdown_bg_color,
        ),
      ),
      cs_control( 'margin', $k_pre . 'dropdown', $settings_dropdown_first ),
      cs_control( 'border', $k_pre . 'dropdown', $settings_dropdown ),
      cs_control( 'border-radius', $k_pre . 'dropdown', $settings_dropdown ),
      cs_control( 'padding', $k_pre . 'dropdown', $settings_dropdown ),
      cs_control( 'box_shadow', $k_pre . 'dropdown', $settings_dropdown )
    ),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Dropdown Design Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_dropdown_base_font_size,
          $control_dropdown_width,
        ),
      ),
    ),
    'controls_std_design_colors' => array(
      array(
        'type'     => 'group',
        'label'    => __( 'Dropdown Base Colors', '__x__' ),
        'controls' => array(
          array(
            'keys'      => array( 'value' => 'dropdown_box_shadow_color' ),
            'type'      => 'color',
            'label'     => __( 'Box<br>Shadow', '__x__' ),
            'condition' => array( 'key' => 'dropdown_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
          ),
          $control_dropdown_bg_color,
        ),
      ),
      cs_control( 'border', $k_pre . 'dropdown', array(
        'group'      => $group_dropdown_design,
        'options'   => array( 'color_only' => true ),
        'conditions' => array_merge( $conditions, array(
          array( 'key' => 'dropdown_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'dropdown_border_style', 'op' => '!=', 'value' => 'none' ),
        ) ),
      ) )
    ),
    'control_nav' => array(
      $group                 => $group_title,
      $group_dropdown_setup  => __( 'Setup', '__x__' ),
      $group_dropdown_design => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'dropdown', 'x_control_partial_dropdown' );
