<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_GRAPHIC.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls: Advanced
//   02. Controls: Standard (Content)
//   03. Controls: Standard (Design - Colors)
//   04. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_graphic_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_graphic.php' );

  $controls = array_merge(
    $control_group_graphic_adv_setup,
    x_control_margin( $settings_graphic_margin ),

    $control_group_graphic_adv_icon,
    x_control_border( $settings_graphic_icon_variable_alt_color ),
    x_control_border_radius( $settings_graphic_icon_border_radius ),
    x_control_box_shadow( $settings_graphic_icon_variable_alt_color ),
    x_control_text_shadow( $settings_graphic_icon_variable_alt_color ),

    $control_group_graphic_adv_image,
    array(
      $control_graphic_local_image_primary,
      $control_group_graphic_local_image_secondary,
      $control_group_graphic_sourced_images
    )
  );

  if ( $has_toggle ) {
    $controls = array_merge(
      $controls,
      x_controls_toggle_adv( $settings_graphic_toggle )
    );
  }

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_graphic_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_graphic.php' );

  $controls = array_merge(
    $control_group_graphic_std_icon,
    array(
      $control_graphic_local_image_primary,
      $control_group_graphic_local_image_secondary,
      $control_group_graphic_sourced_images
    )
  );

  return $controls;

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_graphic_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_graphic.php' );

  $controls = $control_group_graphic_std_icon_colors;

  if ( $has_toggle ) {
    $controls = array_merge(
      $controls,
      x_controls_toggle_std_design_colors( $settings_graphic_toggle )
    );
  }

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Values
// =============================================================================

function x_values_graphic( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_graphic.php' );


  // Setup
  // -----
  // Requires some extra steps as the toggle is a 2nd level mixin to be used in
  // other 1st level mixins, such as the anchor.

  if ( isset( $settings['k_pre'] ) && ! empty( $settings['k_pre'] ) ) {

    $ends_with_underscore = substr( $settings['k_pre'], -1 ) == '_';

    $k_pre = ( $ends_with_underscore ) ? $settings['k_pre'] : $settings['k_pre'] . '_';

  } else {

    $k_pre = '';

  }


  // Values
  // ------
  // 01. Will not change per module. Meant to be used to conditionally load
  //     output for templates and associated styles.

  $values = array(

    $k_pre . 'graphic_has_alt'                     => x_module_value( $has_alt, 'all' ),             // 01
    $k_pre . 'graphic_has_interactions'            => x_module_value( $has_interactions, 'all' ),    // 01
    $k_pre . 'graphic_has_sourced_content'         => x_module_value( $has_sourced_content, 'all' ), // 01
    $k_pre . 'graphic_has_toggle'                  => x_module_value( $has_toggle, 'all' ),          // 01

    $k_pre . 'graphic'                             => x_module_value( false, 'all' ),
    $k_pre . 'graphic_type'                        => x_module_value( 'icon', 'all', true ),

    $k_pre . 'graphic_margin'                      => x_module_value( '5px', 'style' ),

    $k_pre . 'graphic_icon_font_size'              => x_module_value( '1.25em', 'style' ),
    $k_pre . 'graphic_icon_width'                  => x_module_value( '1em', 'style' ),
    $k_pre . 'graphic_icon_height'                 => x_module_value( '1em', 'style' ),
    $k_pre . 'graphic_icon_color'                  => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    $k_pre . 'graphic_icon_bg_color'               => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_border_width'           => x_module_value( '0px', 'style' ),
    $k_pre . 'graphic_icon_border_style'           => x_module_value( 'none', 'style' ),
    $k_pre . 'graphic_icon_border_color'           => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_border_radius'          => x_module_value( '0em 0em 0em 0em', 'style' ),
    $k_pre . 'graphic_icon_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    $k_pre . 'graphic_icon_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'graphic_icon_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    $k_pre . 'graphic_icon_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    $k_pre . 'graphic_image_max_width'             => x_module_value( 'none', 'style' ),
    $k_pre . 'graphic_image_retina'                => x_module_value( true, 'markup', true ),

  );

  if ( $has_alt ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_icon_alt_enable'            => x_module_value( false, 'markup' ),
        $k_pre . 'graphic_icon_color_alt'             => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
        $k_pre . 'graphic_icon_bg_color_alt'          => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_icon_border_color_alt'      => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_icon_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_icon_text_shadow_color_alt' => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'graphic_image_alt_enable'           => x_module_value( false, 'markup' ),
      )
    );
  }

  if ( ! $has_sourced_content && $has_alt ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_icon_alt'      => x_module_value( 'hand-spock-o', 'markup', true ),
        $k_pre . 'graphic_image_src_alt' => x_module_value( '', 'markup', true ),
      )
    );
  }

  if ( $has_interactions ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_interaction' => x_module_value( 'none', 'markup' ),
      )
    );
  }

  if ( ! $has_sourced_content ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'graphic_icon'         => x_module_value( 'hand-pointer-o', 'markup', true ),
        $k_pre . 'graphic_image_src'    => x_module_value( '', 'markup', true ),
        $k_pre . 'graphic_image_width'  => x_module_value( 48, 'markup', true ),
        $k_pre . 'graphic_image_height' => x_module_value( 48, 'markup', true ),
      )
    );
  }

  if ( $has_toggle ) {
    $values = array_merge(
      $values,
      x_values_toggle()
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
