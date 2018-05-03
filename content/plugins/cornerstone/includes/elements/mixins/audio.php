<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/AUDIO.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Group
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_audio( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'audio';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup = $group . ':setup';
  $group_mejs  = $group . ':mejs';


  // Setup - Conditions
  // ------------------

  $conditions              = x_module_conditions( $condition );
  $conditions_audio_player = array( $condition, array( 'audio_type' => 'player' ) );


  // Setup - Settings
  // ----------------

  $settings_audio = array(
    'k_pre'     => 'audio',
    't_pre'     => __( 'Audio', '__x__' ),
    'group'     => $group_setup,
    'condition' => $conditions,
  );


  // Setup - Options
  // ---------------

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
            'key'     => 'audio_type',
            'type'    => 'choose',
            'label'   => __( 'Audio Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
                array( 'value' => 'player', 'label' => __( 'Player', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'title'    => __( 'Width &amp; Max Width', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'audio_width',
                'type'    => 'unit',
                'options' => $options_audio_width,
              ),
              array(
                'key'     => 'audio_max_width',
                'type'    => 'unit',
                'options' => $options_audio_max_width,
              ),
            ),
          ),
          array(
            'key'       => 'audio_embed_code',
            'type'      => 'textarea',
            'label'     => __( 'Embed Code', '__x__' ),
            'condition' => array( 'audio_type' => 'embed' ),
            'options'   => array(
              'height'    => 3,
              'monospace' => true,
            ),
          ),
          array(
            'key'       => 'mejs_source_files',
            'type'      => 'textarea',
            'label'     => __( 'Sources<br>(1 Per Line)', '__x__' ),
            'condition' => array( 'audio_type' => 'player' ),
            'options'   => array(
              'height'    => 3,
              'monospace' => true,
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_audio ),
    x_controls_mejs( array( 'group' => $group_mejs, 'condition' => $conditions_audio_player, 'type' => 'audio' ) )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_audio( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group'] : 'audio';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Audio', '__x__' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group . ':setup' => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':mejs'  => array( 'title' => __( 'Controls', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_audio( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'audio_type'        => x_module_value( 'embed', 'markup' ),
    'audio_width'       => x_module_value( '100%', 'style' ),
    'audio_max_width'   => x_module_value( 'none', 'style' ),
    'audio_embed_code'  => x_module_value( '', 'markup:html', true ),
    'mejs_source_files' => x_module_value( '', 'markup:raw', true ),
    'audio_margin'      => x_module_value( '0em', 'style' ),
  );

  $values = array_merge(
    $values,
    x_values_mejs( array( 'type' => 'audio' ) )
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
