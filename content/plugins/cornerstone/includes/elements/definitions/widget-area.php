<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/WIDGET-AREA.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Define Element
//   02. Builder Setup
//   03. Register Element
// =============================================================================

// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Widget Area', '__x__' ),
  'values' => array_merge(
    array(
      'widget_area_sidebar'               => x_module_value( '', 'markup', true ),
      'widget_area_base_font_size'        => x_module_value( '16px', 'style' ),
      'widget_area_bg_color'              => x_module_value( 'transparent', 'style:color' ),
      'widget_area_margin'                => x_module_value( '0em', 'style' ),
      'widget_area_padding'               => x_module_value( '0em', 'style' ),
      'widget_area_border_width'          => x_module_value( '0px', 'style' ),
      'widget_area_border_style'          => x_module_value( 'none', 'style' ),
      'widget_area_border_color'          => x_module_value( 'transparent', 'style:color' ),
      'widget_area_border_radius'         => x_module_value( '0em', 'style' ),
      'widget_area_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
      'widget_area_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    ),
    x_values_omega()
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_widget_area() {
  return array(
    'control_groups' => array_merge(
      array(
        'widget_area_group'        => array( 'title' => __( 'Widget Area', '__x__' ) ),
        'widget_area_group:setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
        'widget_area_group:design' => array( 'title' => __( 'Design', '__x__' ) ),
      ),
      x_control_groups_omega()
    ),
    'controls' => array_merge(
      array(
        array(
          'type'     => 'group',
          'title'    => __( 'Widget Area Setup', '__x__' ),
          'group'    => 'widget_area_group:setup',
          'controls' => array(
            array(
              'key'   => 'widget_area_sidebar',
              'type'  => 'sidebar',
              'label' => __( 'Sidebar', '__x__' ),
            ),
            array(
              'key'     => 'widget_area_base_font_size',
              'type'    => 'slider',
              'label'   => __( 'Base<br>Font Size', '__x__' ),
              'options' => array(
                'available_units' => array( 'px', 'em', 'rem' ),
                'fallback_value'  => '14px',
                'ranges'          => array(
                  'px'  => array( 'min' => '10', 'max' => '24',  'step' => '1'    ),
                  'em'  => array( 'min' => '1',  'max' => '2.5', 'step' => '0.01' ),
                  'rem' => array( 'min' => '1',  'max' => '2.5', 'step' => '0.01' ),
                ),
              ),
            ),
            array(
              'keys' => array(
                'value' => 'widget_area_bg_color',
              ),
              'type'    => 'color',
              'label'   => __( 'Background', '__x__' ),
              'options' => array(
                'label' => __( 'Select Color', '__x__' ),
              ),
            ),
          ),
        ),
      ),
      x_control_margin( array( 't_pre' => __( 'Widget Area', '__x__' ), 'k_pre' => 'widget_area', 'group' => 'widget_area_group:design' ) ),
      x_control_padding( array( 't_pre' => __( 'Widget Area', '__x__' ), 'k_pre' => 'widget_area', 'group' => 'widget_area_group:design' ) ),
      x_control_border( array( 't_pre' => __( 'Widget Area', '__x__' ), 'k_pre' => 'widget_area', 'group' => 'widget_area_group:design' ) ),
      x_control_border_radius( array( 't_pre' => __( 'Widget Area', '__x__' ), 'k_pre' => 'widget_area', 'group' => 'widget_area_group:design' ) ),
      x_control_box_shadow( array( 't_pre' => __( 'Widget Area', '__x__' ), 'k_pre' => 'widget_area', 'group' => 'widget_area_group:design' ) ),
      x_controls_omega()
    ),
  );
}



// Register Module
// =============================================================================

cornerstone_register_element( 'widget-area', x_element_base( $data ) );
