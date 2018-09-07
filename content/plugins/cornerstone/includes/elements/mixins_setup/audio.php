<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/AUDIO.PHP
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

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'audio';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Audio', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_audio_setup = $group . ':setup';
$group_audio_mejs  = $group . ':mejs';



// Conditions
// =============================================================================

$conditions              = x_module_conditions( $condition );
$conditions_audio_player = array_merge( $conditions, array( array( 'audio_type' => 'player' ) ) );



// Options
// =============================================================================

$options_audio_type = array(
  'choices' => array(
    array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
    array( 'value' => 'player', 'label' => __( 'Player', '__x__' ) ),
  ),
);

$options_audio_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '100%',
  'ranges'          => array(
    'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
    'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
    'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
    '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
  ),
);

$options_audio_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'calc', 'none' ),
  'fallback_value'  => '300px',
  'ranges'          => array(
    'px'  => array( 'min' => 100, 'max' => 500, 'step' => 10  ),
    'em'  => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
    'rem' => array( 'min' => 5,   'max' => 40,  'step' => 0.5 ),
    '%'   => array( 'min' => 0,   'max' => 100, 'step' => 1   ),
  ),
);

$options_audio_source = array(
  'height'    => $is_adv ? 3 : 5,
  'monospace' => true,
);



// Settings
// =============================================================================

$settings_audio = array(
  'k_pre'     => 'audio',
  'group'     => $group_audio_setup,
  'condition' => $conditions,
);

$settings_audio_mejs = array(
  'group'     => $group_audio_mejs,
  'condition' => $conditions_audio_player,
  'type'      => 'audio',
);

$settings_audio_std_design = array(
  'k_pre'     => 'audio',
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_audio_type = array(
  'key'     => 'audio_type',
  'type'    => 'choose',
  'label'   => __( 'Audio Type', '__x__' ),
  'options' => $options_audio_type,
);

$control_audio_width = array(
  'key'     => 'audio_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'title'   => __( 'Width', '__x__' ),
  'options' => $options_audio_width,
);

$control_audio_max_width = array(
  'key'     => 'audio_max_width',
  'type'    => $is_adv ? 'unit' : 'unit-slider',
  'title'   => __( 'Max Width', '__x__' ),
  'options' => $options_audio_max_width,
);

$control_audio_width_and_max_width = array(
  'type'     => 'group',
  'title'    => __( 'Width &amp; Max Width', '__x__' ),
  'controls' => array(
    $control_audio_width,
    $control_audio_max_width,
  ),
);

$control_audio_embed_code = array(
  'key'       => 'audio_embed_code',
  'type'      => 'textarea',
  'label'     => __( 'Embed Code', '__x__' ),
  'condition' => array( 'audio_type' => 'embed' ),
  'options'   => $options_audio_source,
);

$control_audio_mejs_source_files = array(
  'key'       => 'mejs_source_files',
  'type'      => 'textarea',
  'label'     => __( 'Sources<br>(1 Per Line)', '__x__' ),
  'condition' => array( 'audio_type' => 'player' ),
  'options'   => $options_audio_source,
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_audio_adv_setup = array(
  $control_audio_type,
  $control_audio_width_and_max_width,
  $control_audio_embed_code,
  $control_audio_mejs_source_files
);


// Standard
// --------

$control_list_audio_std_content_setup = array(
  $control_audio_embed_code,
  $control_audio_mejs_source_files,
);

$control_list_audio_std_design_setup = array(
  $control_audio_width,
  $control_audio_max_width,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_audio_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_audio_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_audio_adv_setup,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_audio_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Content Setup', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_audio_std_content_setup,
  ),
);

$control_group_audio_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_audio_std_design_setup,
  ),
);
