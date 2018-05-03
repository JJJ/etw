<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/MAP.PHP
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

function x_controls_map( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'map';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup  = $group . ':setup';


  // Setup - Conditions
  // ------------------

  $conditions            = x_module_conditions( $condition );
  $conditions_map_google = array( $condition, array( 'map_type' => 'google' ) );


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
            'key'     => 'map_type',
            'type'    => 'choose',
            'label'   => __( 'Map Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'embed',  'label' => __( 'Embed', '__x__' ) ),
                array( 'value' => 'google', 'label' => __( 'Google', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'       => 'map_embed_code',
            'type'      => 'textarea',
            'label'     => __( 'Embed Code', '__x__' ),
            'condition' => array( 'map_type' => 'embed' ),
            'options'   => array(
              'height'    => 4,
              'monospace' => true,
            ),
          ),
          array(
            'key'       => 'map_google_api_key',
            'type'      => 'text',
            'label'     => __( 'API Key', '__x__' ),
            'condition' => array( 'map_type' => 'google' ),
          ),
          array(
            'type'      => 'group',
            'label'     => __( 'Latitude &amp; Longitude', '__x__' ),
            'condition' => array( 'map_type' => 'google' ),
            'controls'  => array(
              array(
                'key'  => 'map_google_lat',
                'type' => 'text',
              ),
              array(
                'key'  => 'map_google_lng',
                'type' => 'text',
              ),
            ),
          ),
          array(
            'keys' => array(
              'drag' => 'map_google_drag',
              'zoom' => 'map_google_zoom',
            ),
            'type'      => 'checkbox-list',
            'label'     => __( 'Enable Controls', '__x__' ),
            'condition' => array( 'map_type' => 'google' ),
            'options'   => array(
              'list' => array(
                array( 'key' => 'drag', 'label' => __( 'Drag', '__x__' ), 'half' => true ),
                array( 'key' => 'zoom', 'label' => __( 'Zoom', '__x__' ), 'half' => true ),
              ),
            ),
          ),
          array(
            'key'       => 'map_google_zoom_level',
            'type'      => 'unit-slider',
            'label'     => __( 'Zoom Level', '__x__' ),
            'condition' => array( 'map_type' => 'google' ),
            'options'   => array(
              'unit_mode' => 'unitless',
              'min'       => 0,
              'max'       => 18,
              'step'      => 1
            ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Google Map Styles', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions_map_google,
        'controls'   => array(
          array(
            'key'     => 'map_google_styles',
            'type'    => 'textarea',
            'label'   => __( 'JSON', '__x__' ) . '<a href="https://mapstyle.withgoogle.com/" target="_blank" style="display: -webkit-flex; display: flex; -webkit-justify-content: center; justify-content: center; -webkit-align-items: center; align-items: center; position: absolute; top: 50%; right: 10px; width: 2.75em; height: 1.5em; border-radius: 2px; font-size: 1em; line-height: 1; text-align: center; text-decoration: none; background-color: currentColor; transform: translate3d(0, -50%, 0);"><span style="color: #ffffff;">↪</span></a>',
            'options' => array(
              'monospace' => true,
            ),
          ),
        ),
      ),
    )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_map( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group'] : 'map';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Map', '__x__' );

  $control_groups = array(
    $group            => array( 'title' => $group_title ),
    $group . ':setup' => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_map( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'map_type'              => x_module_value( 'embed', 'markup' ),
    'map_embed_code'        => x_module_value( '', 'markup:html', true ),
    'map_google_api_key'    => x_module_value( '', 'markup', true ),
    'map_google_lat'        => x_module_value( '40.674', 'markup', true ),
    'map_google_lng'        => x_module_value( '-73.945', 'markup', true ),
    'map_google_drag'       => x_module_value( true, 'markup' ),
    'map_google_zoom'       => x_module_value( true, 'markup' ),
    'map_google_zoom_level' => x_module_value( 12, 'markup' ),
    'map_google_styles'     => x_module_value( '', 'markup' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
