<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_SEARCH.PHP
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
//   05. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_search_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_search.php' );

  $controls = array_merge(

    $control_group_search_adv_setup,
    $control_group_search_adv_content_setup,

    x_control_margin( $settings_search_design_no_options ),
    x_control_border( $settings_search_design ),
    x_control_border_radius( $settings_search_design_no_options ),
    x_control_box_shadow( $settings_search_design ),

    x_control_margin( $settings_search_input ),
    x_control_text_format( $settings_search_input ),
    x_control_text_style( $settings_search_input ),

    $control_group_search_adv_submit_setup,
    x_control_margin( $settings_search_submit ),
    x_control_border( $settings_search_submit ),
    x_control_border_radius( $settings_search_submit ),
    x_control_box_shadow( $settings_search_submit ),

    $control_group_search_adv_clear_setup,
    x_control_margin( $settings_search_clear ),
    x_control_border( $settings_search_clear ),
    x_control_border_radius( $settings_search_clear ),
    x_control_box_shadow( $settings_search_clear )

  );

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_search_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_search.php' );

  $controls = $control_group_search_std_content_setup;

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_search_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_search.php' );

  $controls = array_merge(
    $control_group_search_std_design_setup,
    x_control_margin( $settings_search_std_design_margin )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_search_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_search.php' );

  $controls = $control_group_search_std_design_colors;

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_search( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_search.php' );

  $control_groups = array(
    $group               => array( 'title' => $group_title ),
    $group_search_setup  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_search_design => array( 'title' => __( 'Design', '__x__' ) ),
    $group_search_input  => array( 'title' => __( 'Input', '__x__' ) ),
    $group_search_submit => array( 'title' => __( 'Submit', '__x__' ) ),
    $group_search_clear  => array( 'title' => __( 'Clear', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_search( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_search.php' );


  // Values
  // ------

  $values = array(

    'search_type'                         => x_module_value( $type, 'all' ),

    'search_placeholder'                  => x_module_value( __( 'Search', '__x__' ), 'markup', true ),
    'search_order_input'                  => x_module_value( '2', 'style' ),
    'search_order_submit'                 => x_module_value( '1', 'style' ),
    'search_order_clear'                  => x_module_value( '3', 'style' ),

    'search_base_font_size'               => x_module_value( '1em', 'style' ),
    'search_width'                        => x_module_value( '100%', 'style' ),
    'search_height'                       => x_module_value( 'auto', 'style' ),
    'search_max_width'                    => x_module_value( 'none', 'style' ),
    'search_bg_color'                     => x_module_value( '#ffffff', 'style:color' ),
    'search_bg_color_alt'                 => x_module_value( '#ffffff', 'style:color' ),

    'search_margin'                       => x_module_value( '0em', 'style' ),
    'search_border_width'                 => x_module_value( '0px', 'style' ),
    'search_border_style'                 => x_module_value( 'none', 'style' ),
    'search_border_color'                 => x_module_value( 'transparent', 'style:color' ),
    'search_border_color_alt'             => x_module_value( 'transparent', 'style:color' ),
    'search_border_radius'                => x_module_value( '100em', 'style' ),
    'search_box_shadow_dimensions'        => x_module_value( '0em 0.15em 0.5em 0em', 'style' ),
    'search_box_shadow_color'             => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'search_box_shadow_color_alt'         => x_module_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),

    'search_input_margin'                 => x_module_value( '0em', 'style' ),
    'search_input_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'search_input_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'search_input_font_size'              => x_module_value( '1em', 'style' ),
    'search_input_letter_spacing'         => x_module_value( '0em', 'style' ),
    'search_input_line_height'            => x_module_value( '1.3', 'style' ),
    'search_input_font_style'             => x_module_value( 'normal', 'style' ),
    'search_input_text_align'             => x_module_value( 'none', 'style' ),
    'search_input_text_decoration'        => x_module_value( 'none', 'style' ),
    'search_input_text_transform'         => x_module_value( 'none', 'style' ),
    'search_input_text_color'             => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'search_input_text_color_alt'         => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),

    'search_submit_font_size'             => x_module_value( '1em', 'style' ),
    'search_submit_stroke_width'          => x_module_value( '2', 'markup' ),
    'search_submit_width'                 => x_module_value( '1em', 'style' ),
    'search_submit_height'                => x_module_value( '1em', 'style' ),
    'search_submit_color'                 => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_submit_color_alt'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'search_submit_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'search_submit_bg_color_alt'          => x_module_value( 'transparent', 'style:color' ),
    'search_submit_margin'                => x_module_value( '0.5em 0.5em 0.5em 0.9em', 'style' ),
    'search_submit_border_style'          => x_module_value( 'none', 'style' ),
    'search_submit_border_width'          => x_module_value( '0px', 'style' ),
    'search_submit_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'search_submit_border_color_alt'      => x_module_value( 'transparent', 'style:color' ),
    'search_submit_border_radius'         => x_module_value( '0em', 'style' ),
    'search_submit_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'search_submit_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'search_submit_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),

    'search_clear_font_size'              => x_module_value( '0.9em', 'style' ),
    'search_clear_stroke_width'           => x_module_value( '3', 'markup' ),
    'search_clear_width'                  => x_module_value( '2em', 'style' ),
    'search_clear_height'                 => x_module_value( '2em', 'style' ),
    'search_clear_color'                  => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'search_clear_color_alt'              => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'search_clear_bg_color'               => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),
    'search_clear_bg_color_alt'           => x_module_value( 'rgba(0, 0, 0, 0.3)', 'style:color' ),
    'search_clear_margin'                 => x_module_value( '0.5em', 'style' ),
    'search_clear_border_style'           => x_module_value( 'none', 'style' ),
    'search_clear_border_width'           => x_module_value( '0px', 'style' ),
    'search_clear_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'search_clear_border_color_alt'       => x_module_value( 'transparent', 'style:color' ),
    'search_clear_border_radius'          => x_module_value( '100em', 'style' ),
    'search_clear_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'search_clear_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    'search_clear_box_shadow_color_alt'   => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
