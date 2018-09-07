<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/VIDEO.PHP
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
//   06. Individual Controls
//   07. Control Lists
//   08. Control Groups (Advanced)
//   09. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'video';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Video', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$is_bg       = ( isset( $settings['is_bg'] )       ) ? true                     : false;



// Groups
// =============================================================================

$group_video_setup = $group . ':setup';
$group_video_mejs  = $group . ':mejs';



// Conditions
// =============================================================================

$conditions              = x_module_conditions( $condition );
$conditions_video_player = array_merge( $conditions, array( array( 'video_type' => 'player' ) ) );


// Options
// =============================================================================

$options_video_type = array(
  'choices' => array(
    array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
    array( 'value' => 'player', 'label' => __( 'Player', '__x__' ) ),
  ),
);

$options_video_embed_code = array(
  'height'    => $is_adv ? 4 : 5,
  'monospace' => true,
);

$options_video_mejs_source_files = array(
  'height'    => $is_adv ? 2 : 3,
  'monospace' => true,
);

$options_video_mejs_poster = array(
  'height' => 2,
);



// Settings
// =============================================================================

$settings_video_mejs = array(
  'group'     => $group_video_mejs,
  'condition' => $conditions_video_player,
  'type'      => 'video',
);



// Individual Controls
// =============================================================================

$control_video_type = array(
  'key'     => 'video_type',
  'type'    => 'choose',
  'label'   => __( 'Video Type', '__x__' ),
  'options' => $options_video_type,
);

$control_video_embed_code = array(
  'key'       => 'video_embed_code',
  'type'      => 'textarea',
  'label'     => __( 'Embed Code', '__x__' ),
  'condition' => array( 'video_type' => 'embed' ),
  'options'   => $options_video_embed_code,
);

$control_video_mejs_source_files = array(
  'key'       => 'mejs_source_files',
  'type'      => 'textarea',
  'label'     => __( 'Sources<br>(1 Per Line)', '__x__' ),
  'condition' => array( 'video_type' => 'player' ),
  'options'   => $options_video_mejs_source_files,
);

$control_video_mejs_poster = array(
  'key'       => 'mejs_poster',
  'type'      => 'image-source',
  'label'     => __( 'Poster', '__x__' ),
  'condition' => array( 'video_type' => 'player' ),
  'options'   => $options_video_mejs_poster,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_video_adv_setup = array(
  $control_video_type,
  $control_video_embed_code,
  $control_video_mejs_source_files,
  $control_video_mejs_poster,
);


// Standard
// --------

$control_list_video_std_content_setup = array(
  $control_video_embed_code,
  $control_video_mejs_source_files,
  $control_video_mejs_poster,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_video_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_video_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_video_adv_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_video_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_video_std_content_setup,
  ),
);
