<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_OFF-CANVAS.PHP
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
//   10. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'off_canvas';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Off Canvas', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$lr_only     = ( isset( $settings['lr_only'] )     ) ? $settings['lr_only']     : false;
$tb_only     = ( isset( $settings['tb_only'] )     ) ? $settings['tb_only']     : false;
$tbf_only    = ( isset( $settings['tbf_only'] )    ) ? $settings['tbf_only']    : false;
$ctbf_only   = ( isset( $settings['ctbf_only'] )   ) ? $settings['ctbf_only']   : false;



// Groups
// =============================================================================

$group_off_canvas_setup  = $group . ':setup';
$group_off_canvas_design = $group . ':design';



// Conditions
// =============================================================================

$lr_only   = ( $lr_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) )                      : array();
$tb_only   = ( $tb_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom' ) )                      : array();
$tbf_only  = ( $tbf_only )  ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) )            : array();
$ctbf_only = ( $ctbf_only ) ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) : array();

$conditions = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only ); // x_module_conditions( $condition )



// Options
// =============================================================================

$options_off_canvas_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '16px',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
  ),
);

$options_off_canvas_location = array(
  'choices' => array(
    array( 'value' => 'left',  'label' => __( 'Left', '__x__' )  ),
    array( 'value' => 'right', 'label' => __( 'Right', '__x__' ) ),
  ),
);

$options_off_canvas_close_dimensions = array(
  'choices' => array(
    array( 'value' => '1',   'label' => __( 'Small', '__x__' ) ),
    array( 'value' => '1.5', 'label' => __( 'Medium', '__x__' ) ),
    array( 'value' => '2',   'label' => __( 'Large', '__x__' ) ),
  ),
);

$options_off_canvas_content_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => '400px',
  'valid_keywords'  => array( 'none' ),
  'ranges'          => array(
    'px'  => array( 'min' => 300, 'max' => 500, 'step' => 1    ),
    'em'  => array( 'min' => 30,  'max' => 50,  'step' => 0.01 ),
    'rem' => array( 'min' => 30,  'max' => 50,  'step' => 0.01 ),
    '%'   => array( 'min' => 80,  'max' => 100, 'step' => 0.01 ),
  ),
);



// Settings
// =============================================================================

$settings_off_canvas_content = array(
  'k_pre'     => 'off_canvas_content',
  't_pre'     => __( 'Content', '__x__' ),
  'group'     => $group,
  'condition' => $conditions
);



// Individual Controls
// =============================================================================

$control_off_canvas_base_font_size = array(
  'key'     => 'off_canvas_base_font_size',
  'type'    => 'slider',
  'title'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_off_canvas_font_size,
);

$control_off_canvas_location = array(
  'key'     => 'off_canvas_location',
  'type'    => 'choose',
  'label'   => __( 'Location', '__x__' ),
  'options' => $options_off_canvas_location,
);

$control_off_canvas_close_size_and_dimensions = array(
  'type'     => 'group',
  'title'    => __( 'Close Size &amp; Dimensions', '__x__' ),
  'controls' => array(
    array(
      'key'     => 'off_canvas_close_font_size',
      'type'    => 'unit',
      'options' => $options_off_canvas_font_size,
    ),
    array(
      'key'     => 'off_canvas_close_dimensions',
      'type'    => 'select',
      'options' => $options_off_canvas_close_dimensions,
    ),
  ),
);

$control_off_canvas_content_max_width = array(
  'key'     => 'off_canvas_content_max_width',
  'type'    => 'slider',
  'title'   => __( 'Content Max Width', '__x__' ),
  'options' => $options_off_canvas_content_max_width,
);

$control_off_canvas_bg_color = array(
  'key'   => 'off_canvas_bg_color',
  'type'  => 'color',
  'title' => __( 'Overlay Background', '__x__' ),
);

$control_off_canvas_close_colors = array(
  'keys' => array(
    'value' => 'off_canvas_close_color',
    'alt'   => 'off_canvas_close_color_alt',
  ),
  'type'    => 'color',
  'title'   => __( 'Close Button', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_off_canvas_content_bg_color = array(
  'key'   => 'off_canvas_content_bg_color',
  'type'  => 'color',
  'title' => __( 'Content Background', '__x__' ),
);



// Control Lists
// =============================================================================

$control_list_off_canvas_adv_setup = array(
  $control_off_canvas_base_font_size,
  $control_off_canvas_location,
  $control_off_canvas_close_size_and_dimensions,
  $control_off_canvas_content_max_width,
);

$control_list_off_canvas_adv_colors = array(
  $control_off_canvas_bg_color,
  $control_off_canvas_close_colors,
  $control_off_canvas_content_bg_color,
);

$control_list_off_canvas_std_design_setup = array(
  $control_off_canvas_base_font_size,
  $control_off_canvas_content_max_width,
);

$control_list_off_canvas_std_design_colors_base = array(
  $control_off_canvas_bg_color,
  $control_off_canvas_close_colors,
  array(
    'keys'      => array( 'value' => 'off_canvas_content_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'off_canvas_content_box_shadow_dimensions', 'op' => 'NOT EMPTY' )
  ),
  $control_off_canvas_content_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_off_canvas_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_off_canvas_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_off_canvas_adv_setup,
  ),
);

$control_group_off_canvas_adv_colors = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Colors', '__x__' ),
    'group'      => $group_off_canvas_design,
    'conditions' => $conditions,
    'controls'   => $control_list_off_canvas_adv_colors,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_off_canvas_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Off Canvas Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_off_canvas_std_design_setup,
  ),
);

$control_group_off_canvas_std_design_colors = array_merge(
  array(
    array(
      'type'     => 'group',
      'title'    => __( 'Off Canvas Base Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_off_canvas_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_off_canvas_content,
      array(
        'group'     => $group_std_design,
        'options'   => array( 'color_only' => true ),
        'condition' => array(
          $condition,
          array( 'key' => 'off_canvas_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'off_canvas_border_style', 'op' => '!=', 'value' => 'none' ),
        ),
      )
    )
  )
);