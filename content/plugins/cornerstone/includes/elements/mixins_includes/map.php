<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/MAP.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Setup)
//   04. Control Group
//   05. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_map_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map.php' );

  $controls = array_merge(
    $control_group_map_adv_setup,
    array( $control_map_markers ),
    $control_group_map_adv_styles
  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_map_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map.php' );

  $controls = array_merge(
    $control_group_map_std_content_setup,
    array( $control_map_markers )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_map_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map.php' );

  $controls = $control_group_map_std_design_setup;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_map( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map.php' );

  $control_groups = array(
    $group           => array( 'title' => $group_title ),
    $group_map_setup => array( 'title' => __( 'Setup', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_map( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/map.php' );


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
    'map_google_styles'     => x_module_value( '', 'markup:raw' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
