<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/MAP-MARKER.PHP
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

function x_controls_map_marker( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map-marker.php' );

  $controls = array(
    array(
      'type'     => 'group',
      'title'    => __( 'Setup', '__x__' ),
      'group'    => $is_adv ? $group_map_marker_setup : $group_std_content,
      'controls' => array(
        array(
          'type'     => 'group',
          'title'    => __( 'Latitude &amp; Longitude', '__x__' ),
          'controls' => array(
            array(
              'key'  => 'map_marker_lat',
              'type' => 'text',
            ),
            array(
              'key'  => 'map_marker_lng',
              'type' => 'text',
            ),
          ),
        ),
        array(
          'key'     => 'map_marker_content_start',
          'type'    => 'choose',
          'label'   => __( 'Content Start', '__x__' ),
          'options' => array(
            'choices' => array(
              array( 'value' => 'open',   'label' => __( 'Open', '__x__' )   ),
              array( 'value' => 'closed', 'label' => __( 'Closed', '__x__' ) ),
            ),
          ),
        ),
        array(
          'key'     => 'map_marker_content',
          'type'    => 'textarea',
          'label'   => __( 'Content', '__x__' ),
          'options' => array(
            'height' => 3,
          ),
        ),
      ),
    ),
    array(
      'keys' => array(
        'img_source' => 'map_marker_image_src',
        'is_retina'  => 'map_marker_image_retina',
        'width'      => 'map_marker_image_width',
        'height'     => 'map_marker_image_height',
      ),
      'type'  => 'image',
      'title' => __( 'Custom Image', '__x__' ),
      'group' => $is_adv ? $group_map_marker_setup : $group_std_design,
    ),
    array(
      'type'      => 'group',
      'title'     => __( 'Image Offset', '__x__' ),
      'group'     => $is_adv ? $group_map_marker_setup : $group_std_design,
      'condition' => $condition_map_marker_has_image,
      'controls'  => array(
        array(
          'key'     => 'map_marker_offset_x',
          'type'    => 'unit-slider',
          'label'   => __( 'Offset X', '__x__' ),
          'options' => $settings_map_marker_offset_x,
        ),
        array(
          'key'     => 'map_marker_offset_y',
          'type'    => 'unit-slider',
          'label'   => __( 'Offset Y', '__x__' ),
          'options' => $settings_map_marker_offset_y,
        ),
      ),
    ),
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_map_marker( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map-marker.php' );

  $control_groups = array(
    $group                  => array( 'title' => $group_title ),
    $group_map_marker_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_map_marker( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map-marker.php' );

  $values = array(
    'map_marker_lat'           => x_module_value( '40.674', 'markup', true ),
    'map_marker_lng'           => x_module_value( '-73.945', 'markup', true ),
    'map_marker_content_start' => x_module_value( 'closed', 'markup', true ),
    'map_marker_content'       => x_module_value( '', 'markup:html', true ),
    'map_marker_image_src'     => x_module_value( '', 'markup', true ),
    'map_marker_image_retina'  => x_module_value( true, 'markup', true ),
    'map_marker_image_width'   => x_module_value( 48, 'markup', true ),
    'map_marker_image_height'  => x_module_value( 48, 'markup', true ),
    'map_marker_offset_x'      => x_module_value( '0%', 'markup', true ),
    'map_marker_offset_y'      => x_module_value( '-50%', 'markup', true ),
  );

  return x_bar_mixin_values( $values, $settings );

}
