<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_DROPDOWN.PHP
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
//   05. Control Groups
//   06. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_image_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_image.php' );

  $controls = array_merge(
    $control_group_image_adv_setup,
    x_control_image( $settings_image_control )
  );

  if ( $has_link === true ) {
    $controls = array_merge(
      $controls,
      x_control_link( $settings_image_link )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_image ),
    x_control_padding( $settings_image ),
    x_control_border( $settings_image_with_color ),
    x_control_border_radius( $settings_image_border_radius_outer ),
    x_control_border_radius( $settings_image_border_radius_inner ),
    x_control_box_shadow( $settings_image_with_color )
  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_image_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_image.php' );

  $controls = x_control_image( $settings_image_std_content );

  if ( $has_link === true ) {
    $controls = array_merge(
      $controls,
      x_control_link( $settings_image_std_content_link )
    );
  }

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_image_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_image.php' );

  $controls = array_merge(
    $control_group_image_std_design_setup,
    x_control_margin( $settings_image )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_image_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_image.php' );

  $controls = $control_group_image_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_image( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_image.php' );

  $control_groups = array(
    $group              => array( 'title' => $group_title ),
    $group_image_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_image_design => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_image( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_image.php' );


  // Setup
  // -----

  $is_retina = ( isset( $settings['is_retina'] ) ) ? true : false;
  $width     = ( isset( $settings['width'] )     ) ? true : false;
  $height    = ( isset( $settings['height'] )    ) ? true : false;
  $has_link  = ( isset( $settings['has_link'] )  ) ? true : false;
  $has_info  = ( isset( $settings['has_info'] )  ) ? true : false;
  $alt_text  = ( isset( $settings['alt_text'] )  ) ? true : false;


  // Values
  // ------

  $values = array(
    'image_type'                  => x_module_value( 'standard', 'all' ),
    'image_styled_width'          => x_module_value( 'auto', 'style' ),
    'image_styled_max_width'      => x_module_value( 'none', 'style' ),
    'image_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'image_bg_color_alt'          => x_module_value( 'transparent', 'style:color' ),
    'image_src'                   => x_module_value( '', 'markup', true ),
    'image_margin'                => x_module_value( '0px', 'style' ),
    'image_padding'               => x_module_value( '0px', 'style' ),
    'image_border_width'          => x_module_value( '0px', 'style' ),
    'image_border_style'          => x_module_value( 'solid', 'style' ),
    'image_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'image_border_color_alt'      => x_module_value( 'transparent', 'style:color' ),
    'image_outer_border_radius'   => x_module_value( '0em', 'style' ),
    'image_inner_border_radius'   => x_module_value( '0em', 'style' ),
    'image_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'image_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'image_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
  );

  if ( $is_retina === true ) {
    $values = array_merge(
      $values,
      array(
        'image_retina' => x_module_value( true, 'markup', true ),
      )
    );
  }

  if ( $width === true ) {
    $values = array_merge(
      $values,
      array(
        'image_width' => x_module_value( 48, 'markup', true ),
      )
    );
  }

  if ( $height === true ) {
    $values = array_merge(
      $values,
      array(
        'image_height' => x_module_value( 48, 'markup', true ),
      )
    );
  }

  if ( $has_link === true ) {
    $values = array_merge(
      $values,
      array(
        'image_link'     => x_module_value( false, 'markup', true ),
        'image_href'     => x_module_value( '', 'markup', true ),
        'image_blank'    => x_module_value( false, 'markup', true ),
        'image_nofollow' => x_module_value( false, 'markup', true ),
      )
    );
  }

  if ( $has_info === true ) {
    $values = array_merge(
      $values,
      array(
        'image_info' => x_module_value( false, 'markup', true ),
      )
    );
  }

  if ( $alt_text === true ) {
    $values = array_merge(
      $values,
      array(
        'image_alt' => x_module_value( '', 'markup', true ),
      )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
