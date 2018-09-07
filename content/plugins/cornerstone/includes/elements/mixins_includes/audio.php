<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/AUDIO.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Setup)
//   04. Controls: Standard (Design - Colors)
//   05. Control Group
//   06. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_audio_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/audio.php' );

  $controls = array_merge(
    $control_group_audio_adv_setup,
    x_control_margin( $settings_audio ),
    x_controls_mejs_adv( array_merge( $settings_audio_mejs, array( 'adv' => true ) ) )
  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_audio_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/audio.php' );

  $controls = $control_group_audio_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_audio_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/audio.php' );

  $controls = array_merge(
    $control_group_audio_std_design_setup,
    x_control_margin( $settings_audio_std_design ),
    x_controls_mejs_std_design_setup( $settings_audio_mejs )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_audio_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/audio.php' );

  $controls = x_controls_mejs_std_design_colors( $settings_audio_mejs );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_audio( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/audio.php' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group_audio_setup => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_audio_mejs  => array( 'title' => __( 'Controls', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_audio( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/audio.php' );

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

  return x_bar_mixin_values( $values, $settings );

}
