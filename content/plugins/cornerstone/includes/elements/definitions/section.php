<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/SECTION.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Values
//   02. Style
//   03. Render
//   04. Define Element
//   05. Builder Setup
//   06. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'section_base_font_size' => cs_value( '1em', 'style' ),
    'section_z_index'        => cs_value( '1', 'style' ),
    'section_text_align'     => cs_value( 'none', 'style' ),
    'section_bg_color'       => cs_value( 'transparent', 'style:color' ),
    'section_bg_advanced'    => cs_value( false, 'all' ),
  ),
  'bg',
  cs_values( 'separator-top', 'section_top' ),
  cs_values( 'separator-bottom', 'section_bottom' ),
  array(
    'section_margin'                => cs_value( '0em', 'style' ),
    'section_padding'               => cs_value( '45px 0px 45px 0px', 'style' ),
    'section_border_width'          => cs_value( '0px', 'style' ),
    'section_border_style'          => cs_value( 'none', 'style' ),
    'section_border_color'          => cs_value( 'transparent', 'style:color' ),
    'section_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'section_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'omega',
  'omega:style'
);



// Style
// =============================================================================

function x_element_style_section() {
  return x_get_view( 'styles/elements', 'section', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_section( $data ) {
  return x_get_view( 'elements', 'section', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Section', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_section',
  'style'   => 'x_element_style_section',
  'render'  => 'x_element_render_section',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_section() {

  $default_child = array( '_type' => 'layout-row', 'layout_row_global_container' => true );


  // Individual Controls
  // -------------------

  $control_section_sortable = array(
    'type'       => 'sortable',
    'label'      => __( 'Rows', '__x__' ),
    'group'      => 'section:setup',
  );

  $control_section_base_font_size = array(
    'key'     => 'section_base_font_size',
    'type'    => 'unit',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_section_z_index = array(
    'key'     => 'section_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_section_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_section_base_font_size,
      $control_section_z_index,
    ),
  );

  $control_section_text_align = array(
    'key'   => 'section_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );

  $control_section_bg_color = array(
    'keys'    => array( 'value' => 'section_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_section_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'section_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_section_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_section_bg_color,
      $control_section_bg_advanced
    ),
  );


  // Compose Controls
  // ----------------

  return array_merge(
    cs_compose_controls(
      array(
        'controls' => array(
          $control_section_sortable,
          array(
            'type'     => 'group',
            'label'    => __( 'Setup', '__x__' ),
            'group'    => 'section:setup',
            'controls' => array(
              $control_section_font_size_and_z_index,
              $control_section_text_align,
              $control_section_background,
            ),
          ),
        ),
        'controls_std_content' => array(
          $control_section_sortable
        ),
        'controls_std_design_setup' => array(
          array(
            'type'       => 'group',
            'label'      => __( 'Design Setup', '__x__' ),
            'controls'   => array(
              $control_section_font_size_and_z_index,
              $control_section_text_align,
            ),
          ),
        ),
        'controls_std_design_colors' => array(
          array(
            'type'       => 'group',
            'label'      => __( 'Base Colors', '__x__' ),
            'controls'   => array(
              array(
                'keys'      => array( 'value' => 'section_box_shadow_color' ),
                'type'      => 'color',
                'label'     => __( 'Box<br>Shadow', '__x__' ),
                'condition' => array( 'key' => 'section_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
              ),
              $control_section_bg_color
            ),
          ),
          cs_control( 'border', 'section', array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array(
              array( 'key' => 'section_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'section_border_style', 'op' => '!=', 'value' => 'none' )
            ),
          ) )
        ),
        'control_nav' => array(
          'section'        => __( 'Section', '__x__' ),
          'section:setup'  => __( 'Setup', '__x__' ),
          'section:design' => __( 'Design', '__x__' ),
        ),
      ),
      cs_partial_controls( 'bg', array(
        'group'     => 'section:design',
        'condition' => array( 'section_bg_advanced' => true ),
      ) ),
      array(
        'controls_std_design_setup' => array(
          cs_control( 'margin', 'section' )
        )
      ),
      cs_partial_controls( 'separator', array(
        'label_prefix'    => __( 'Top', '__x__' ),
        'k_pre'    => 'section_top',
        'group'    => 'section:design',
        'location' => 'top'
      ) ),
      cs_partial_controls( 'separator', array(
        'label_prefix'    => __( 'Bottom', '__x__' ),
        'k_pre'    => 'section_bottom',
        'group'    => 'section:design',
        'location' => 'bottom'
      ) ),
      array(
        'controls' => array(
          cs_control( 'margin', 'section', array( 'group' => 'section:design' ) ),
          cs_control( 'padding', 'section', array( 'group' => 'section:design' ) ),
          cs_control( 'border', 'section', array( 'group' => 'section:design' ) ),
          cs_control( 'box-shadow', 'section', array( 'group' => 'section:design' ) )
        ),
      ),
      cs_partial_controls( 'omega', array( 'add_style' => true ) )
    ),
    array(
      'options' => array(
        'valid_children'    => array( 'row', 'layout-row', 'layout-grid'  ),
        'index_labels'      => true,
        'library'           => false,
        'empty_placeholder' => false,
        'default_children' => array( $default_child ),
        'add_new_element'  => $default_child,
        'contrast_keys' => array(
          'bg:section_bg_advanced',
          'section_bg_color'
        )
      ),
    )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'section', $data );
