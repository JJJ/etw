<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_IMAGE.PHP
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
// 01. Available types:
//     -- 'standard'
//     -- 'scaling'

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'image';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Image', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$is_retina   = ( isset( $settings['is_retina'] )   ) ? true                     : false;
$width       = ( isset( $settings['width'] )       ) ? true                     : false;
$height      = ( isset( $settings['height'] )      ) ? true                     : false;
$has_link    = ( isset( $settings['has_link'] )    ) ? true                     : false;
$has_info    = ( isset( $settings['has_info'] )    ) ? true                     : false;
$alt_text    = ( isset( $settings['alt_text'] )    ) ? true                     : false;



// Groups
// =============================================================================

$group_image_setup  = $group . ':setup';
$group_image_design = $group . ':design';



// Conditions
// =============================================================================

$conditions          = x_module_conditions( $condition );
$conditions_standard = array( $condition, array( 'image_type' => 'standard' ) );



// Options
// =============================================================================

$options_image_type = array(
  'choices' => array(
    array( 'value' => 'standard', 'label' => __( 'Standard', '__x__' ) ),
    array( 'value' => 'scaling',  'label' => __( 'Scaling', '__x__' ) ),
  ),
);

$options_image_styled_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => 'auto',
  'valid_keywords'  => array( 'auto', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 300, 'step' => 10  ),
    'em'  => array( 'min' => 2.5, 'max' => 20,  'step' => 0.5 ),
    'rem' => array( 'min' => 2.5, 'max' => 20,  'step' => 0.5 ),
    '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
    'vw'  => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
    'vh'  => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
  ),
);

$options_image_styled_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => 'none',
  'valid_keywords'  => array( 'none', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 400, 'max' => 1200, 'step' => 10 ),
    'em'  => array( 'min' => 25,  'max' => 75,   'step' => 1  ),
    'rem' => array( 'min' => 25,  'max' => 75,   'step' => 1  ),
    '%'   => array( 'min' => 0,   'max' => 100,  'step' => 1  ),
    'vw'  => array( 'min' => 0,   'max' => 100,  'step' => 1  ),
    'vh'  => array( 'min' => 0,   'max' => 100,  'step' => 1  ),
  ),
);



// Settings
// =============================================================================

$settings_image_control = array(
  'group' => $group_image_setup,
);

if ( $is_retina === true ) { $settings_image_control['is_retina'] = true; }
if ( $width === true     ) { $settings_image_control['width'] = true;     }
if ( $height === true    ) { $settings_image_control['height'] = true;    }
if ( $has_link === true  ) { $settings_image_control['has_link'] = true;  }
if ( $has_info === true  ) { $settings_image_control['has_info'] = true;  }
if ( $alt_text === true  ) { $settings_image_control['alt_text'] = true;  }

$settings_image_link = array(
  'k_pre'     => 'image',
  'group'     => $group_image_setup,
  'condition' => array( $condition, array( 'image_link' => true ) ),
  'blank'     => true,
  'nofollow'  => true,
);

$settings_image = array(
  'k_pre'     => 'image',
  'group'     => $group_image_design,
  'condition' => $conditions_standard,
);

$settings_image_with_color = array(
  'k_pre'     => 'image',
  'group'     => $group_image_design,
  'condition' => $conditions_standard,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_image_border_radius_outer = array(
  'k_pre'     => 'image_outer',
  't_pre'     => __( 'Outer', '__x__' ),
  'group'     => $group_image_design,
  'condition' => $conditions_standard,
);

$settings_image_border_radius_inner = array(
  'k_pre'     => 'image_inner',
  't_pre'     => __( 'Inner', '__x__' ),
  'group'     => $group_image_design,
  'condition' => $conditions_standard,
);

$settings_image_std_content = array_merge(
  $settings_image_control,
  array( 'group' => $group_std_content )
);
$settings_image_std_content_link = array_merge(
  $settings_image_link,
  array( 'group' => $group_std_content )
);

$settings_image_std_design = array(
  'k_pre'     => 'image',
  'group'     => $group_std_design,
  'condition' => $conditions_standard,
);



// Individual Controls
// =============================================================================

$control_image_type = array(
  'key'       => 'image_type',
  'type'      => 'choose',
  'label'     => __( 'Type', '__x__' ),
  'condition' => array( '_region' => 'top' ),
  'options'   => $options_image_type,
);

$control_image_styled_width = array(
  'key'        => 'image_styled_width',
  'type'       => 'unit-slider',
  'label'      => __( 'Width', '__x__' ),
  'conditions' => $conditions_standard,
  'options'    => $options_image_styled_width,
);

$control_image_styled_max_width = array(
  'key'        => 'image_styled_max_width',
  'type'       => 'unit-slider',
  'label'      => __( 'Max Width', '__x__' ),
  'conditions' => $conditions_standard,
  'options'    => $options_image_styled_max_width,
);

$control_image_bg_colors = array(
  'keys' => array(
    'value' => 'image_bg_color',
    'alt'   => 'image_bg_color_alt',
  ),
  'type'       => 'color',
  'label'      => __( 'Background', '__x__' ),
  'conditions' => $conditions_standard,
  'options'    => $options_base_interaction_labels,
);



// Control Lists
// =============================================================================

$control_list_image_adv_setup = array(
  $control_image_type,
  $control_image_styled_width,
  $control_image_styled_max_width,
  $control_image_bg_colors
);

$control_list_image_std_design_setup = array(
  $control_image_styled_width,
  $control_image_styled_max_width,
);

$control_list_image_std_design_colors_base = array(
  array(
    'keys' => array(
      'value' => 'image_box_shadow_color',
      'alt'   => 'image_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'image_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_image_bg_colors,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_image_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_image_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_image_adv_setup,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_image_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_image_std_design_setup,
  ),
);

$control_group_image_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_image_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_image_with_color,
      array(
        't_pre'     => __( 'Image', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'image_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'image_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);
