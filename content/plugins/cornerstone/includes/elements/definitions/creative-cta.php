<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CREATIVE-CTA.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  'anchor-button',
  'anchor:interactive-content',
  array(
    'anchor_base_font_size'            => cs_value( '1.5em', 'style' ),
    'anchor_width'                     => cs_value( '100%', 'style' ),
    // 'anchor_min_height'                => cs_value( '8em', 'style' ),
    'anchor_bg_color'                  => cs_value( 'rgba(0, 0, 0, 0.05)', 'style:color' ),
    'anchor_bg_color_alt'              => cs_value( 'rgba(0, 0, 0, 0)', 'style:color' ),
    'anchor_padding'                   => cs_value( '2em 1em 2em 1em', 'style' ),
    'anchor_flex_direction'            => cs_value( 'column', 'style' ),
    'anchor_box_shadow_dimensions'     => cs_value( '0em 0em 0em 0em', 'style' ),
    'anchor_box_shadow_dimensions_alt' => cs_value( '0em 0em 0em 0em', 'style' ),
    'anchor_box_shadow_color'          => cs_value( 'transparent', 'style:color' ),
    'anchor_box_shadow_color_alt'      => cs_value( 'transparent', 'style:color' ),
    'anchor_text_primary_content'      => cs_value( __( 'Got Questions?', '__x__' ), 'all:html', true ),
    // 'anchor_text_interaction'          => cs_value( 'x-anchor-slide-top', 'markup' ),
    'anchor_primary_text_align'        => cs_value( 'center', 'style' ),
    'anchor_primary_text_color'        => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_primary_text_color_alt'    => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_secondary_text_align'      => cs_value( 'center', 'style' ),
    'anchor_secondary_text_color'      => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_secondary_text_color_alt'  => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_graphic'                   => cs_value( true, 'all' ),
    'anchor_graphic_icon_font_size'    => cs_value( '1.5em', 'style' ),
    'anchor_graphic_icon'              => cs_value( 'l-hand-pointer', 'markup', true ),
    'anchor_graphic_icon_alt'          => cs_value( 'l-hand-pointer', 'markup', true ),
    'anchor_graphic_icon_color'        => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'anchor_graphic_icon_color_alt'    => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
  ),
  'omega'
);

// Style
// =============================================================================

function x_element_style_creative_cta() {
  return cs_get_partial_style( 'anchor' );
}


// Render
// =============================================================================

function x_element_render_creative_cta( $data ) {
  return cs_get_partial_view( 'anchor', $data );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Creative CTA', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_creative_cta',
  'style' => 'x_element_style_creative_cta',
  'render' => 'x_element_render_creative_cta',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_creative_cta() {
  return cs_compose_controls(
    cs_partial_controls( 'anchor', array(
      'type'                    => 'button',
      'has_link_control'        => true,
      'has_interactive_content' => true,
      'group'                   => 'button_anchor',
      'group_title'             => __( 'Creative CTA', '__x__' ),
    ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'creative-cta', $data );
