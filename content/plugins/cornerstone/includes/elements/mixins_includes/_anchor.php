<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/_ANCHOR.PHP
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

function x_controls_anchor_adv( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_anchor.php' );

  $controls = $control_group_anchor_adv_setup;

  if ( $has_link_control ) {
    $controls = array_merge(
      $controls,
      $control_anchor_link
    );
  }


  // Design
  // ------

  if ( $has_template ) {
    $controls = array_merge(
      $controls,
      x_control_flex_layout_css( $settings_anchor_flex_css )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_anchor_design_no_options ),
    x_control_padding( $settings_anchor_design ),
    x_control_border( $settings_anchor_design ),
    x_control_border_radius( $settings_anchor_design ),
    x_control_box_shadow( $settings_anchor_design )
  );


  // Text
  // ----

  if ( $has_template ) {
    $controls = array_merge(
      $controls,
      $control_group_anchor_adv_text_setup
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_anchor_text_margin ),
    x_control_text_format( $settings_anchor_primary_text ),
    x_control_text_style( $settings_anchor_primary_text ),
    x_control_text_shadow( $settings_anchor_primary_text )
  );

  if ( $has_template ) {
    $controls = array_merge(
      $controls,
      x_control_text_format( $settings_anchor_secondary_text ),
      x_control_text_style( $settings_anchor_secondary_text ),
      x_control_text_shadow( $settings_anchor_secondary_text )
    );
  }


  // Graphic
  // -------

  if ( $has_template ) {
    $controls = array_merge(
      $controls,
      x_controls_graphic_adv( $settings_anchor_graphic_adv )
    );
  }


  // Sub Indicator
  // -------------

  if ( $has_template && $type === 'menu-item' ) {
    $controls = array_merge(
      $controls,
      $control_group_anchor_adv_sub_indicator_setup,
      x_control_margin( $settings_anchor_sub_indicator_margin ),
      x_control_text_shadow( $settings_anchor_sub_indicator_text_shadow )
    );
  }


  // Particles
  // ---------

  if ( $has_template ) {
    $controls = array_merge(
      $controls,
      x_controls_particle( $settings_anchor_particle_primary ),
      x_controls_particle( $settings_anchor_particle_secondary )
    );
  }

  return $controls;

}



// Controls: Standard (Content)
// =============================================================================

function x_controls_anchor_std_content( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_anchor.php' );

  $controls = array();

  if ( $has_link_control ) {
    $controls = array_merge(
      $controls,
      $control_anchor_link
    );
  }

  if ( $has_template ) {
    $controls = array_merge(
      $controls,
      $control_group_anchor_std_content_setup,
      x_controls_graphic_std_content( $settings_anchor_graphic_std_content )
    );
  }

  return $controls;

}



// Controls: Standard (Design - Setup)
// =============================================================================

function x_controls_anchor_std_design_setup( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_anchor.php' );

  $controls = array_merge(
    $control_group_anchor_std_design_setup,
    x_control_margin( $settings_anchor_std_design_margin )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Controls: Standard (Design - Colors)
// =============================================================================

function x_controls_anchor_std_design_colors( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_anchor.php' );

  $controls = array_merge(
    $control_group_anchor_std_design_colors,
    x_controls_graphic_std_design_colors( $settings_anchor_graphic_std_design )
  );

  return array_map( 'x_controls_inject_std_design_controls_condition', $controls );

}



// Control Groups
// =============================================================================

function x_control_groups_anchor( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_anchor.php' );

  $control_groups = array(
    $group                      => array( 'title' => $group_title ),
    $group_anchor_setup         => array( 'title' => __( 'Setup', '__x__' ) ),
    $group_anchor_design        => array( 'title' => __( 'Design', '__x__' ) ),
    $group_anchor_text          => array( 'title' => __( 'Text', '__x__' ) ),
    $group_anchor_graphic       => array( 'title' => __( 'Graphic', '__x__' ) ),
    $group_anchor_sub_indicator => array( 'title' => __( 'Sub Indicator', '__x__' ) ),
    $group_anchor_particles     => array( 'title' => __( 'Particles', '__x__' ) ),
  );

  if ( ! $has_template ) {
    unset( $control_groups[$group_anchor_setup] );
    unset( $control_groups[$group_anchor_graphic] );
  }

  if ( $type !== 'menu-item' ) {
    unset( $control_groups[$group_anchor_sub_indicator] );
  }

  return $control_groups;

}



// Values
// =============================================================================

function x_values_anchor( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/_anchor.php' );


  // Values
  // ------
  // 01. Will not change per module. Meant to be used to conditionally load
  //     output for templates and associated styles.

  $values = array(

    $k_pre . 'anchor_type'                           => x_module_value( $type, 'all' ),             // 01
    $k_pre . 'anchor_has_template'                   => x_module_value( $has_template, 'all' ),     // 01
    $k_pre . 'anchor_has_link_control'               => x_module_value( $has_link_control, 'all' ), // 01

    $k_pre . 'anchor_base_font_size'                 => x_module_value( '1em', 'style' ),
    $k_pre . 'anchor_width'                          => x_module_value( 'auto', 'style' ),
    $k_pre . 'anchor_height'                         => x_module_value( 'auto', 'style' ),
    $k_pre . 'anchor_min_width'                      => x_module_value( '0px', 'style' ),
    $k_pre . 'anchor_min_height'                     => x_module_value( '0px', 'style' ),
    $k_pre . 'anchor_max_width'                      => x_module_value( 'none', 'style' ),
    $k_pre . 'anchor_max_height'                     => x_module_value( 'none', 'style' ),
    $k_pre . 'anchor_bg_color'                       => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'anchor_bg_color_alt'                   => x_module_value( 'transparent', 'style:color' ),

    $k_pre . 'anchor_margin'                         => x_module_value( '0em', 'style' ),
    $k_pre . 'anchor_padding'                        => x_module_value( '0.575em 0.85em 0.575em 0.85em', 'style' ),
    $k_pre . 'anchor_border_width'                   => x_module_value( '0px', 'style' ),
    $k_pre . 'anchor_border_style'                   => x_module_value( 'none', 'style' ),
    $k_pre . 'anchor_border_color'                   => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'anchor_border_color_alt'               => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'anchor_border_radius'                  => x_module_value( '0em', 'style' ),

    $k_pre . 'anchor_box_shadow_dimensions'          => x_module_value( '0em 0em 0em 0em', 'style' ),
    $k_pre . 'anchor_box_shadow_color'               => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'anchor_box_shadow_color_alt'           => x_module_value( 'transparent', 'style:color' ),

    $k_pre . 'anchor_text_margin'                    => x_module_value( '5px', 'style' ),

    $k_pre . 'anchor_primary_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    $k_pre . 'anchor_primary_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    $k_pre . 'anchor_primary_font_size'              => x_module_value( '1em', 'style' ),
    $k_pre . 'anchor_primary_letter_spacing'         => x_module_value( '0em', 'style' ),
    $k_pre . 'anchor_primary_line_height'            => x_module_value( '1', 'style' ),
    $k_pre . 'anchor_primary_font_style'             => x_module_value( 'normal', 'style' ),
    $k_pre . 'anchor_primary_text_align'             => x_module_value( 'none', 'style' ),
    $k_pre . 'anchor_primary_text_decoration'        => x_module_value( 'none', 'style' ),
    $k_pre . 'anchor_primary_text_transform'         => x_module_value( 'none', 'style' ),
    $k_pre . 'anchor_primary_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    $k_pre . 'anchor_primary_text_color_alt'         => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    $k_pre . 'anchor_primary_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    $k_pre . 'anchor_primary_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    $k_pre . 'anchor_primary_text_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),

  );

  if ( $has_link_control ) {
    $values = array_merge(
      $values,
      array(
        $k_pre . 'anchor_href'     => x_module_value( '#', 'attr:html', true ),
        $k_pre . 'anchor_info'     => x_module_value( false, 'markup', true ),
        $k_pre . 'anchor_blank'    => x_module_value( false, 'markup', true ),
        $k_pre . 'anchor_nofollow' => x_module_value( false, 'markup', true ),
      )
    );
  }

  if ( $has_template ) {

    $values = array_merge(
      $values,
      array(
        $k_pre . 'anchor_flex_direction'                   => x_module_value( 'row', 'style' ),
        $k_pre . 'anchor_flex_wrap'                        => x_module_value( false, 'style' ),
        $k_pre . 'anchor_flex_justify'                     => x_module_value( 'center', 'style' ),
        $k_pre . 'anchor_flex_align'                       => x_module_value( 'center', 'style' ),

        $k_pre . 'anchor_text'                             => x_module_value( true, 'all' ),
        $k_pre . 'anchor_text_overflow'                    => x_module_value( false, 'style' ),
        $k_pre . 'anchor_text_interaction'                 => x_module_value( 'none', 'markup' ),

        $k_pre . 'anchor_text_reverse'                     => x_module_value( false, 'all' ),
        $k_pre . 'anchor_text_spacing'                     => x_module_value( '0.35em', 'style' ),

        $k_pre . 'anchor_secondary_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
        $k_pre . 'anchor_secondary_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
        $k_pre . 'anchor_secondary_font_size'              => x_module_value( '0.75em', 'style' ),
        $k_pre . 'anchor_secondary_letter_spacing'         => x_module_value( '0em', 'style' ),
        $k_pre . 'anchor_secondary_line_height'            => x_module_value( '1', 'style' ),
        $k_pre . 'anchor_secondary_font_style'             => x_module_value( 'normal', 'style' ),
        $k_pre . 'anchor_secondary_text_align'             => x_module_value( 'none', 'style' ),
        $k_pre . 'anchor_secondary_text_decoration'        => x_module_value( 'none', 'style' ),
        $k_pre . 'anchor_secondary_text_transform'         => x_module_value( 'none', 'style' ),
        $k_pre . 'anchor_secondary_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
        $k_pre . 'anchor_secondary_text_color_alt'         => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
        $k_pre . 'anchor_secondary_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
        $k_pre . 'anchor_secondary_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
        $k_pre . 'anchor_secondary_text_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
      ),
      x_values_graphic( $settings_anchor_graphic_adv ),
      x_values_particle( array( 'k_pre' => $k_pre . 'anchor_primary' ) ),
      x_values_particle( array( 'k_pre' => $k_pre . 'anchor_secondary' ) )
    );

    if ( $type === 'menu-item' ) {
      $values = array_merge(
        $values,
        array(
          $k_pre . 'anchor_text_primary_content'                 => x_module_value( 'on', 'all', true ),
          $k_pre . 'anchor_text_secondary_content'               => x_module_value( '', 'all', true ),
          $k_pre . 'anchor_sub_indicator'                        => x_module_value( true, 'all' ),
          $k_pre . 'anchor_sub_indicator_font_size'              => x_module_value( '1em', 'style' ),
          $k_pre . 'anchor_sub_indicator_width'                  => x_module_value( 'auto', 'style' ),
          $k_pre . 'anchor_sub_indicator_height'                 => x_module_value( 'auto', 'style' ),
          $k_pre . 'anchor_sub_indicator_icon'                   => x_module_value( 'angle-down', 'markup' ),
          $k_pre . 'anchor_sub_indicator_color'                  => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
          $k_pre . 'anchor_sub_indicator_color_alt'              => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
          $k_pre . 'anchor_sub_indicator_margin'                 => x_module_value( '5px', 'style' ),
          $k_pre . 'anchor_sub_indicator_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
          $k_pre . 'anchor_sub_indicator_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
          $k_pre . 'anchor_sub_indicator_text_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
        )
      );
    }

    if ( $type !== 'menu-item' ) {
      $values = array_merge(
        $values,
        array(
          $k_pre . 'anchor_text_primary_content'   => x_module_value( __( 'Learn More', '__x__' ), 'all:html', true ),
          $k_pre . 'anchor_text_secondary_content' => x_module_value( '', 'all:html', true ),
        )
      );
    }

  }

  if ( ! $has_template ) {
    if ( $type === 'button' ) {
      $values = array_merge(
        $values,
        array( $k_pre . 'anchor_text' => x_module_value( true, 'all' ) )
      );
    }
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
