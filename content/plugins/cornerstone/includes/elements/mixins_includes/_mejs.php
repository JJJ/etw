<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_MEJS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Design - Setup)
//   03. Controls: Standard (Design - Colors)
//   04. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_mejs_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_mejs.php' );

  $controls = array_merge(
    $control_group_mejs_adv_setup,
    $control_group_mejs_adv_controls_colors
  );

  if ( $type === 'video' ) {
    $controls = array_merge(
      $controls,
      x_control_margin( $settings_mejs_video_controls_margin )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_padding( $settings_mejs_controls ),
    x_control_border( $settings_mejs_controls ),
    x_control_border_radius( $settings_mejs_controls ),
    x_control_box_shadow( $settings_mejs_controls ),
    x_control_border_radius( $settings_mejs_controls_time_rail ),
    x_control_box_shadow( $settings_mejs_controls_time_rail )
  );

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_mejs_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_mejs.php' );

  $controls = $control_group_mejs_std_design_setup;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_mejs_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_mejs.php' );

  $controls = $control_group_mejs_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Values
// =============================================================================

function x_values_mejs( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_mejs.php' );


  // Values
  // ------

  $values = array(
    'mejs_type'                                     => x_module_value( $type, 'style' ),
    'mejs_preload'                                  => x_module_value( 'metadata', 'markup' ),
    'mejs_advanced_controls'                        => x_module_value( false, 'markup' ),
    'mejs_autoplay'                                 => x_module_value( false, 'markup' ),
    'mejs_loop'                                     => x_module_value( false, 'markup' ),
    'mejs_controls_button_color'                    => x_module_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
    'mejs_controls_button_color_alt'                => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'mejs_controls_time_total_bg_color'             => x_module_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
    'mejs_controls_time_loaded_bg_color'            => x_module_value( 'rgba(255, 255, 255, 0.25)', 'style:color' ),
    'mejs_controls_time_current_bg_color'           => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'mejs_controls_color'                           => x_module_value( 'rgba(255, 255, 255, 0.5)', 'style:color' ),
    'mejs_controls_bg_color'                        => x_module_value( 'rgba(0, 0, 0, 0.8)', 'style:color' ),
    'mejs_controls_padding'                         => x_module_value( '0px', 'style' ),
    'mejs_controls_border_width'                    => x_module_value( '0px', 'style' ),
    'mejs_controls_border_style'                    => x_module_value( 'none', 'style' ),
    'mejs_controls_border_color'                    => x_module_value( 'transparent', 'style' ),
    'mejs_controls_border_radius'                   => x_module_value( '3px', 'style' ),
    'mejs_controls_box_shadow_dimensions'           => x_module_value( '0em 0em 0em 0em', 'style' ),
    'mejs_controls_box_shadow_color'                => x_module_value( 'transparent', 'style' ),
    'mejs_controls_time_rail_border_radius'         => x_module_value( '2px', 'style' ),
    'mejs_controls_time_rail_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'mejs_controls_time_rail_box_shadow_color'      => x_module_value( 'transparent', 'style' ),
  );

  if ( $type === 'video' ) {
    $values = array_merge(
      $values,
      array(
        'mejs_hide_controls'   => x_module_value( false, 'markup' ),
        'mejs_muted'           => x_module_value( false, 'markup' ),
        'mejs_controls_margin' => x_module_value( 'auto 15px 15px 15px', 'style' ),
      )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
