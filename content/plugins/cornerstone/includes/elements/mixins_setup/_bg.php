<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_BG.PHP
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

$t_pre     = ( isset( $settings['t_pre'] )     ) ? $settings['t_pre'] . ' ' : '';
$k_pre     = ( isset( $settings['k_pre'] )     ) ? $settings['k_pre'] . '_' : '';
$group     = ( isset( $settings['group'] )     ) ? $settings['group']       : 'bg';
$condition = ( isset( $settings['condition'] ) ) ? $settings['condition']   : array();



// Groups
// =============================================================================
// Parent mixins will pass in group.



// Conditions
// =============================================================================

$conditions                  = x_module_conditions( $condition );
$condition_bg_lower_color    = array( $k_pre . 'bg_lower_type' => 'color' );
$condition_bg_lower_image    = array( $k_pre . 'bg_lower_type' => 'image' );
$condition_bg_lower_video    = array( $k_pre . 'bg_lower_type' => 'video' );
$condition_bg_upper_color    = array( $k_pre . 'bg_upper_type' => 'color' );
$condition_bg_upper_image    = array( $k_pre . 'bg_upper_type' => 'image' );
$condition_bg_upper_video    = array( $k_pre . 'bg_upper_type' => 'video' );
$condition_bg_lower_parallax = array( $k_pre . 'bg_lower_parallax' => true );
$condition_bg_upper_parallax = array( $k_pre . 'bg_upper_parallax' => true );



// Options
// =============================================================================

$options_bg_type = array(
  'choices' => array(
    array( 'value' => 'none',  'icon' => 'ban'        ),
    array( 'value' => 'color', 'icon' => 'eyedropper' ),
    array( 'value' => 'image', 'icon' => 'image'  ),
    array( 'value' => 'video', 'icon' => 'film'       ),
  )
);

$options_bg_image_repeat = array(
  'choices' => array(
    array( 'value' => 'no-repeat', 'label' => __( 'None', '__x__' )   ),
    array( 'value' => 'repeat-x',  'label' => __( 'X Axis', '__x__' ) ),
    array( 'value' => 'repeat-y',  'label' => __( 'Y Axis', '__x__' ) ),
    array( 'value' => 'repeat',    'label' => __( 'Both', '__x__' )   ),
  )
);

$options_bg_video_placeholder = array(
  'placeholder' => 'http://example.com/a.mp4'
);

$options_bg_parallax_size = array(
  'available_units' => array( '%' ),
  'fallback_value'  => '150%',
  'ranges'          => array(
    '%' => array( 'min' => 100, 'max' => 250, 'step' => 5 ),
  ),
);

$options_bg_parallax_direction = array(
  'choices' => array(
    array( 'value' => 'v', 'icon' => 'arrows-v' ),
    array( 'value' => 'h', 'icon' => 'arrows-h' ),
  )
);

$options_bg_image_height = array(
  'height' => $is_adv ? 2 : 5,
);

$options_bg_video_poster_height = array(
  'height' => $is_adv ? 3 : 4,
);



// Settings
// =============================================================================

$settings_bg_border_radius = array(
  'k_pre'     => 'bg',
  't_pre'     => __( 'Background', '__x__' ),
  'group'     => $group,
  'condition' => $condition,
);



// Individual Controls
// =============================================================================

$control_bg_lower_type = array(
  'key'     => $k_pre . 'bg_lower_type',
  'type'    => 'choose',
  'label'   => __( 'Select Type', '__x__' ),
  'options' => $options_bg_type,
);

$control_bg_lower_color = array(
  'key'       => $k_pre . 'bg_lower_color',
  'type'      => 'color',
  'label'     => __( 'Color', '__x__' ),
  'condition' => $condition_bg_lower_color,
);

$control_bg_lower_image = array(
  'keys' => array(
    'img_source' => $k_pre . 'bg_lower_image',
  ),
  'type'      => 'image',
  'label'     => __( 'Image', '__x__' ),
  'condition' => $condition_bg_lower_image,
  'options'   => $options_bg_image_height,
);

$control_bg_lower_image_repeat = array(
  'key'       => $k_pre . 'bg_lower_image_repeat',
  'type'      => 'choose',
  'label'     => __( 'Repeat', '__x__' ),
  'condition' => $condition_bg_lower_image,
  'options'   => $options_bg_image_repeat,
);

$control_bg_lower_image_size_and_position = array(
  'type'      => 'group',
  'title'     => __( 'Size &amp; Position', '__x__' ),
  'condition' => $condition_bg_lower_image,
  'controls'  => array(
    array(
      'key'  => $k_pre . 'bg_lower_image_size',
      'type' => 'text',
    ),
    array(
      'key'  => $k_pre . 'bg_lower_image_position',
      'type' => 'text',
    ),
  ),
);

$control_bg_lower_video = array(
  'key'       => $k_pre . 'bg_lower_video',
  'type'      => 'text',
  'label'     => __( 'Video Source', '__x__' ),
  'condition' => $condition_bg_lower_video,
  'options'   => $options_bg_video_placeholder,
);

$control_bg_lower_video_poster = array(
  'keys' => array(
    'img_source' => $k_pre . 'bg_lower_video_poster',
  ),
  'type'      => 'image',
  'label'     => __( 'Poster Image', '__x__' ),
  'condition' => $condition_bg_lower_video,
  'options'   => $options_bg_video_poster_height,
);

$control_bg_upper_type = array(
  'key'     => $k_pre . 'bg_upper_type',
  'type'    => 'choose',
  'label'   => __( 'Select Type', '__x__' ),
  'options' => $options_bg_type,
);

$control_bg_upper_color = array(
  'key'       => $k_pre . 'bg_upper_color',
  'type'      => 'color',
  'label'     => __( 'Color', '__x__' ),
  'condition' => $condition_bg_upper_color,
);

$control_bg_upper_image = array(
  'keys' => array(
    'img_source' => $k_pre . 'bg_upper_image',
  ),
  'type'      => 'image',
  'label'     => __( 'Image', '__x__' ),
  'condition' => $condition_bg_upper_image,
  'options'   => $options_bg_image_height,
);

$control_bg_upper_image_repeat = array(
  'key'       => $k_pre . 'bg_upper_image_repeat',
  'type'      => 'choose',
  'label'     => __( 'Repeat', '__x__' ),
  'condition' => $condition_bg_upper_image,
  'options'   => $options_bg_image_repeat,
);

$control_bg_upper_image_size_and_position = array(
  'type'      => 'group',
  'title'     => __( 'Size &amp; Position', '__x__' ),
  'condition' => $condition_bg_upper_image,
  'controls'  => array(
    array(
      'key'  => $k_pre . 'bg_upper_image_size',
      'type' => 'text',
    ),
    array(
      'key'  => $k_pre . 'bg_upper_image_position',
      'type' => 'text',
    ),
  ),
);

$control_bg_upper_video = array(
  'key'       => $k_pre . 'bg_upper_video',
  'type'      => 'text',
  'label'     => __( 'Video Source', '__x__' ),
  'condition' => $condition_bg_upper_video,
  'options'   => $options_bg_video_placeholder,
);

$control_bg_upper_video_poster = array(
  'keys' => array(
    'img_source' => $k_pre . 'bg_upper_video_poster',
  ),
  'type'      => 'image',
  'label'     => __( 'Poster Image', '__x__' ),
  'condition' => $condition_bg_upper_video,
  'options'   => $options_bg_video_poster_height,
);

$control_bg_parallax = array(
  'keys' => array(
    'lower_parallax' => $k_pre . 'bg_lower_parallax',
    'upper_parallax' => $k_pre . 'bg_upper_parallax',
  ),
  'type'    => 'checkbox-list',
  'label'   => __( 'Enable', '__x__' ),
  'options' => array(
    'list' => array(
      array( 'key' => 'lower_parallax', 'label' => __( 'Lower Layer', '__x__' ), 'half' => true ),
      array( 'key' => 'upper_parallax', 'label' => __( 'Upper Layer', '__x__' ), 'half' => true ),
    ),
  ),
);

$control_bg_lower_parallax_size = array(
  'key'       => $k_pre . 'bg_lower_parallax_size',
  'type'      => 'slider',
  'label'     => __( 'Lower Layer Size', '__x__' ),
  'options'   => $options_bg_parallax_size,
  'condition' => $condition_bg_lower_parallax,
);

$control_bg_lower_parallax_direction_and_reverse = array(
  'type'      => 'group',
  'title'     => __( 'Lower Layer Direction', '__x__' ),
  'condition' => $condition_bg_lower_parallax,
  'controls'  => array(
    array(
      'key'     => $k_pre . 'bg_lower_parallax_direction',
      'type'    => 'choose',
      'options' => $options_bg_parallax_direction,
    ),
    array(
      'keys' => array(
        'lower_parallax_reverse' => $k_pre . 'bg_lower_parallax_reverse',
      ),
      'type'    => 'checkbox-list',
      'options' => array(
        'list' => array(
          array( 'key' => 'lower_parallax_reverse', 'label' => __( 'Reverse', '__x__' ) ),
        ),
      ),
    ),
  ),
);

$control_bg_upper_parallax_size = array(
  'key'       => $k_pre . 'bg_upper_parallax_size',
  'type'      => 'slider',
  'label'     => __( 'Upper Layer Size', '__x__' ),
  'options'   => $options_bg_parallax_size,
  'condition' => $condition_bg_upper_parallax,
);

$control_bg_upper_parallax_direction_and_reverse = array(
  'type'      => 'group',
  'title'     => __( 'Upper Layer Direction', '__x__' ),
  'condition' => $condition_bg_upper_parallax,
  'controls'  => array(
    array(
      'key'     => $k_pre . 'bg_upper_parallax_direction',
      'type'    => 'choose',
      'options' => $options_bg_parallax_direction,
    ),
    array(
      'keys' => array(
        'upper_parallax_reverse' => $k_pre . 'bg_upper_parallax_reverse',
      ),
      'type'    => 'checkbox-list',
      'options' => array(
        'list' => array(
          array( 'key' => 'upper_parallax_reverse', 'label' => __( 'Reverse', '__x__' ) ),
        ),
      ),
    ),
  ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_bg_adv_lower_layer = array(
  $control_bg_lower_type,
  $control_bg_lower_color,
  $control_bg_lower_image,
  $control_bg_lower_image_repeat,
  $control_bg_lower_image_size_and_position,
  $control_bg_lower_video,
  $control_bg_lower_video_poster,
);

$control_list_bg_adv_upper_layer = array(
  $control_bg_upper_type,
  $control_bg_upper_color,
  $control_bg_upper_image,
  $control_bg_upper_image_repeat,
  $control_bg_upper_image_size_and_position,
  $control_bg_upper_video,
  $control_bg_upper_video_poster,
);

$control_list_bg_adv_parallax = array(
  $control_bg_parallax,
  $control_bg_lower_parallax_size,
  $control_bg_lower_parallax_direction_and_reverse,
  $control_bg_upper_parallax_size,
  $control_bg_upper_parallax_direction_and_reverse,
);


// Standard
// --------

$control_list_bg_std_lower_layer = array(
  $control_bg_lower_color,
  $control_bg_lower_image,
  $control_bg_lower_video,
  $control_bg_lower_video_poster,
);

$control_list_bg_std_upper_layer = array(
  $control_bg_upper_color,
  $control_bg_upper_image,
  $control_bg_upper_video,
  $control_bg_upper_video_poster,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_bg_adv_lower_layer = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Background Lower Layer', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_bg_adv_lower_layer,
  ),
);

$control_group_bg_adv_upper_layer = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Background Upper Layer', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_bg_adv_upper_layer,
  ),
);

$control_group_bg_adv_parallax = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Background Parallax', '__x__' ),
    'group'      => $group,
    'conditions' => $conditions,
    'controls'   => $control_list_bg_adv_parallax,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_bg_std_lower_layer = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Background Lower Layer', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_bg_std_lower_layer,
  ),
);

$control_group_bg_std_upper_layer = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Background Upper Layer', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_bg_std_upper_layer,
  ),
);
