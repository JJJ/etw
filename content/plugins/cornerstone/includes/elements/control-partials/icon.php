<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/ICON.PHP
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

function x_control_partial_icon( $settings ) {

  // Setup
  // -----

  // 01. Available types:
  //     -- 'standard'
  //     -- 'graphic'

  $label_prefix = ( isset( $settings['label_prefix'] ) ) ? $settings['label_prefix'] : '';
  $k_pre        = ( isset( $settings['k_pre'] )        ) ? $settings['k_pre'] . '_'  : '';
  $group        = ( isset( $settings['group'] )        ) ? $settings['group']        : 'icon';
  $group_title  = ( isset( $settings['group_title'] )  ) ? $settings['group_title']  : __( 'Icon', '__x__' );
  $conditions   = ( isset( $settings['conditions'] )   ) ? $settings['conditions']   : array();
  $type         = ( isset( $settings['type'] )         ) ? $settings['type']         : 'standard'; // 01



  // Groups
  // =============================================================================

  $group_icon_setup   = $group . ':setup';
  $group_icon_design  = $group . ':design';


  // Options
  // -------

  $options_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'auto', 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10, 'max' => 200, 'step' => 1   ),
      'em'  => array( 'min' => 1,  'max' => 8,   'step' => 0.5 ),
      'rem' => array( 'min' => 1,  'max' => 8,   'step' => 0.5 ),
    ),
  );



  // Settings
  // --------

  $settings_icon_design = array(
    'k_pre'     => $k_pre . 'icon',
    'group'     => $group_icon_design,
    'conditions' => $conditions,
  );

  // Individual Controls
  // -------------------

  $control_icon_font_size = array(
    'key'     => $k_pre . 'icon_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10, 'max' => 100, 'step' => 1   ),
        'em'  => array( 'min' => 1,  'max' => 8,   'step' => 0.5 ),
        'rem' => array( 'min' => 1,  'max' => 8,   'step' => 0.5 ),
      ),
    ),
  );

  $control_icon = array(
    'key'   => $k_pre . 'icon',
    'type'  => 'icon',
    'label' => __( 'Icon', '__x__' ),
  );

  $control_icon_width = array(
    'key'     => $k_pre . 'icon_width',
    'type'    => $type ? 'unit-slider' : 'unit',
    'label'   => __( 'Width', '__x__' ),
    'options' => $options_width_and_height,
  );

  $control_icon_height = array(
    'key'     => $k_pre . 'icon_height',
    'type'    => $type ? 'unit-slider' : 'unit',
    'label'   => __( 'Height', '__x__' ),
    'options' => $options_width_and_height,
  );

  $control_icon_color = array(
    'keys'  => array( 'value' => $k_pre . 'icon_color' ),
    'type'  => 'color',
    'label' => __( 'Icon', '__x__' ),
  );

  $control_icon_bg_color = array(
    'keys'  => array( 'value' => $k_pre . 'icon_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_icon_color_and_bg_color = array(
    'type'     => 'group',
    'group'    => $group_icon_design,
    'label'    => __( 'Color &amp; Background', '__x__' ),
    'controls' => array(
      $control_icon_color,
      $control_icon_bg_color,
    ),
  );

  // Compose Controls
  // ----------------

  return array(
    'controls' => array_merge(
      array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => $group_icon_setup,
          'conditions' => $conditions,
          'controls'   => array(
            $control_icon_font_size,
            $control_icon,
            $control_icon_width,
            $control_icon_height,
            $control_icon_color_and_bg_color
          ),
        ),
      ),
      x_control_margin( $settings_icon_design ),
      x_control_border( $settings_icon_design ),
      x_control_border_radius( $settings_icon_design ),
      x_control_box_shadow( $settings_icon_design ),
      x_control_text_shadow( $settings_icon_design )
    ),
    'controls_std_content' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Content', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_icon,
        ),
      ),
    ),
    'controls_std_design_setup' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Design Setup', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_icon_font_size,
          $control_icon_width,
          $control_icon_height,
        ),
      ),
      cs_control( 'margin', $k_pre . 'icon', array( 'conditions' => $conditions ) )
    ),
    'controls_std_design_colors' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Base Colors', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_icon_color,
          array(
            'keys'      => array( 'value' => $k_pre . 'icon_text_shadow_color' ),
            'type'      => 'color',
            'label'     => __( 'Text<br>Shadow', '__x__' ),
            'condition' => array( 'key' => $k_pre . 'icon_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
          ),
          array(
            'keys'       => array( 'value' => $k_pre . 'icon_border_color' ),
            'type'       => 'color',
            'label'      => __( 'Border', '__x__' ),
            'conditions' => array(
              array( 'key' => $k_pre . 'icon_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => $k_pre . 'icon_border_style', 'op' => '!=', 'value' => 'none' ),
            ),
          ),
          array(
            'keys'      => array( 'value' => $k_pre . 'icon_box_shadow_color' ),
            'type'      => 'color',
            'label'     => __( 'Box<br>Shadow', '__x__' ),
            'condition' => array( 'key' => $k_pre . 'icon_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
          ),
          $control_icon_bg_color,
        ),
      ),
    ),
    'control_nav' => array(
      $group             => $group_title,
      $group_icon_setup  => __( 'Setup', '__x__' ) ,
      $group_icon_design => __( 'Design', '__x__' ),
    )
  );
}

cs_register_control_partial( 'icon', 'x_control_partial_icon' );
