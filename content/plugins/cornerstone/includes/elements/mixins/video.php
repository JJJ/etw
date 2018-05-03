<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/VIDEO.PHP
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

function x_controls_video( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'video';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $is_bg     = ( isset( $settings['is_bg'] )     ) ? true                   : false;

  $group_setup = $group . ':setup';
  $group_mejs  = $group . ':mejs';


  // Setup - Conditions
  // ------------------

  $conditions              = x_module_conditions( $condition );
  $conditions_video_player = array( $condition, array( 'video_type' => 'player' ) );


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
            'key'     => 'video_type',
            'type'    => 'choose',
            'label'   => __( 'Video Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
                array( 'value' => 'player', 'label' => __( 'Player', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'       => 'video_embed_code',
            'type'      => 'textarea',
            'label'     => __( 'Embed Code', '__x__' ),
            'condition' => array( 'video_type' => 'embed' ),
            'options'   => array(
              'height'    => 4,
              'monospace' => true,
            ),
          ),
          array(
            'key'       => 'mejs_source_files',
            'type'      => 'textarea',
            'label'     => __( 'Sources<br>(1 Per Line)', '__x__' ),
            'condition' => array( 'video_type' => 'player' ),
            'options'   => array(
              'height'    => 2,
              'monospace' => true,
            ),
          ),
          array(
            'key'       => 'mejs_poster',
            'type'      => 'image-source',
            'label'     => __( 'Poster', '__x__' ),
            'condition' => array( 'video_type' => 'player' ),
            'options'   => array(
              'height' => 2,
            ),
          ),
        ),
      ),
    ),
    x_controls_mejs( array( 'group' => $group_mejs, 'condition' => $conditions_video_player, 'type' => 'video' ) )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_video( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group'] : 'video';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Video', '__x__' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group . ':setup' => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':mejs'  => array( 'title' => __( 'Controls', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_video( $settings = array() ) {

  // Setup
  // -----

  $is_bg = ( isset( $settings['is_bg'] ) ) ? true : false;


  // Values
  // ------

  $values = array(
    'video_is_bg'       => x_module_value( $is_bg, 'markup' ),
    'video_type'        => x_module_value( 'embed', 'markup' ),
    'video_embed_code'  => x_module_value( '', 'markup:html', true ),
    'mejs_source_files' => x_module_value( '', 'markup:raw', true ),
    'mejs_poster'       => x_module_value( '', 'markup', true ),
  );

  $values = array_merge(
    $values,
    x_values_mejs( array( 'type' => 'video' ) )
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
