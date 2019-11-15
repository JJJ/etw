<?php

// =============================================================================
// FRAMEWORK/FUNCTIONS/PRO/BARS/DEFINITIONS/LAYOUT-COLUMN.PHP
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
//   06. Register Module
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'layout_column_flexbox'               => cs_value( false, 'style' ),
    'layout_column_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_column_z_index'               => cs_value( '1', 'style' ),
    'layout_column_min_width'             => cs_value( '0px', 'style' ),
    'layout_column_min_height'            => cs_value( '0px', 'style' ),
    'layout_column_max_width'             => cs_value( 'none', 'style' ),
    'layout_column_max_height'            => cs_value( 'none', 'style' ),
    'layout_column_text_align'            => cs_value( 'none', 'style' ),
    'layout_column_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_column_bg_advanced'           => cs_value( false, 'all' ),

    'layout_column_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_column_flex_wrap'             => cs_value( true, 'style' ),
    'layout_column_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_column_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_column_padding'               => cs_value( '0px', 'style' ),
    'layout_column_border_width'          => cs_value( '0px', 'style' ),
    'layout_column_border_style'          => cs_value( 'none', 'style' ),
    'layout_column_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_column_border_radius'         => cs_value( '0px', 'style' ),
    'layout_column_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'layout_column_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'bg',
  'omega'
);



// Style
// =============================================================================

function x_element_style_layout_column() {
  return x_get_view( 'styles/elements', 'layout-column', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_layout_column( $data ) {
  return x_get_view( 'elements', 'layout-column', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Column', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_layout_column',
  'style'   => 'x_element_style_layout_column',
  'render'  => 'x_element_render_layout_column',
  'icon'    => 'native',
  'options' => array(
    'valid_children'    => array( '*' ),
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'contrast_keys'     => array(
      'bg:layout_column_bg_advanced',
      'layout_column_bg_color'
    )
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_column() {

  // Options
  // -------

  $options_layout_column_min_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => '0px',
    'valid_keywords'  => array( 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 1000, 'step' => 20 ),
      'em'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      'rem' => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    ),
  );

  $options_layout_column_max_width_and_height = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'fallback_value'  => 'none',
    'valid_keywords'  => array( 'none', 'calc' ),
    'ranges'          => array(
      'px'  => array( 'min' => 0, 'max' => 1000, 'step' => 20 ),
      'em'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      'rem' => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
      'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1  ),
    ),
  );


  // Individual Controls
  // -------------------

  $control_layout_column_flexbox = array(
    'key'     => 'layout_column_flexbox',
    'type'    => 'choose',
    'label'   => __( 'Flexbox Layout', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_layout_column_base_font_size = array(
    'key'     => 'layout_column_base_font_size',
    'type'    => 'unit',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_layout_column_z_index = array(
    'key'     => 'layout_column_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_column_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_layout_column_base_font_size,
      $control_layout_column_z_index,
    ),
  );

  $control_layout_column_min_width = array(
    'key'     => 'layout_column_min_width',
    'type'    => 'unit',
    'options' => $options_layout_column_min_width_and_height,
  );

  $control_layout_column_min_height = array(
    'key'     => 'layout_column_min_height',
    'type'    => 'unit',
    'options' => $options_layout_column_min_width_and_height,
  );

  $control_layout_column_min_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Min Width &amp; Min Height', '__x__' ),
    'controls' => array(
      $control_layout_column_min_width,
      $control_layout_column_min_height,
    ),
  );

  $control_layout_column_max_width = array(
    'key'     => 'layout_column_max_width',
    'type'    => 'unit',
    'options' => $options_layout_column_max_width_and_height,
  );

  $control_layout_column_max_height = array(
    'key'     => 'layout_column_max_height',
    'type'    => 'unit',
    'options' => $options_layout_column_max_width_and_height,
  );

  $control_layout_column_max_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Max&nbsp;Width&nbsp;&amp; Max Height', '__x__' ),
    'controls' => array(
      $control_layout_column_max_width,
      $control_layout_column_max_height,
    ),
  );

  $control_layout_column_text_align = array(
    'key'   => 'layout_column_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );

  $control_layout_column_bg_color = array(
    'keys'  => array( 'value' => 'layout_column_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' )
  );

  $control_layout_column_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_column_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_column_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_column_bg_color,
      $control_layout_column_bg_advanced
    ),
  );


  // Control Groups (Advanced)
  // -------------------------

  $control_group_layout_column_adv_setup = array(

  );



  // Control Groups (Standard)
  // -------------------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'layout_column:setup',
          'controls' => array(
            $control_layout_column_flexbox,
            $control_layout_column_font_size_and_z_index,
            $control_layout_column_min_width_and_height,
            $control_layout_column_max_width_and_height,
            $control_layout_column_text_align,
            $control_layout_column_background,
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_layout_column_font_size_and_z_index,
            $control_layout_column_text_align,
            $control_layout_column_min_width_and_height,
            $control_layout_column_max_width_and_height,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'layout_column_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'layout_column_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_layout_column_bg_color
          ),
        ),
        cs_control( 'border', 'layout_column', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'layout_column_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'layout_column_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(
        'layout_column'        => __( 'Column', '__x__' ),
        'layout_column:setup'  => __( 'Setup', '__x__' ),
        'layout_column:design' => __( 'Design', '__x__' ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'group'      => 'layout_column:design',
      'condition' => array( 'layout_column_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        cs_control( 'flexbox', 'layout_column', array(
          'group'      => 'layout_column:design',
          'conditions' => array( array( 'layout_column_flexbox' => true ) ),
        ) ),
        cs_control( 'padding', 'layout_column', array( 'group' => 'layout_column:design' ) ),
        cs_control( 'border', 'layout_column', array( 'group' => 'layout_column:design' ) ),
        cs_control( 'border-radius', 'layout_column', array( 'group' => 'layout_column:design' ) ),
        cs_control( 'box-shadow', 'layout_column', array( 'group' => 'layout_column:design' ) )
      )
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'layout-column', $data );
