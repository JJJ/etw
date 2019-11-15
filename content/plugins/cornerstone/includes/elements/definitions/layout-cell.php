<?php

// =============================================================================
// FRAMEWORK/FUNCTIONS/PRO/BARS/DEFINITIONS/LAYOUT-CELL.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Controls: Advanced
//   03. Controls: Standard (Design - Setup)
//   04. Controls: Standard (Design - Colors)
//   05. Control Groups
//   06. Values
//   07. Define Element
//   08. Builder Setup
//   09. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'layout_cell_column_start_xs'       => cs_value( '', 'style' ),
    'layout_cell_column_start_sm'       => cs_value( '', 'style' ),
    'layout_cell_column_start_md'       => cs_value( '', 'style' ),
    'layout_cell_column_start_lg'       => cs_value( '', 'style' ),
    'layout_cell_column_start_xl'       => cs_value( '', 'style' ),

    'layout_cell_column_end_xs'         => cs_value( '', 'style' ),
    'layout_cell_column_end_sm'         => cs_value( '', 'style' ),
    'layout_cell_column_end_md'         => cs_value( '', 'style' ),
    'layout_cell_column_end_lg'         => cs_value( '', 'style' ),
    'layout_cell_column_end_xl'         => cs_value( '', 'style' ),

    'layout_cell_row_start_xs'          => cs_value( '', 'style' ),
    'layout_cell_row_start_sm'          => cs_value( '', 'style' ),
    'layout_cell_row_start_md'          => cs_value( '', 'style' ),
    'layout_cell_row_start_lg'          => cs_value( '', 'style' ),
    'layout_cell_row_start_xl'          => cs_value( '', 'style' ),

    'layout_cell_row_end_xs'            => cs_value( '', 'style' ),
    'layout_cell_row_end_sm'            => cs_value( '', 'style' ),
    'layout_cell_row_end_md'            => cs_value( '', 'style' ),
    'layout_cell_row_end_lg'            => cs_value( '', 'style' ),
    'layout_cell_row_end_xl'            => cs_value( '', 'style' ),

    'layout_cell_justify_self_xs'       => cs_value( 'auto', 'style' ),
    'layout_cell_justify_self_sm'       => cs_value( 'auto', 'style' ),
    'layout_cell_justify_self_md'       => cs_value( 'auto', 'style' ),
    'layout_cell_justify_self_lg'       => cs_value( 'auto', 'style' ),
    'layout_cell_justify_self_xl'       => cs_value( 'auto', 'style' ),

    'layout_cell_align_self_xs'         => cs_value( 'auto', 'style' ),
    'layout_cell_align_self_sm'         => cs_value( 'auto', 'style' ),
    'layout_cell_align_self_md'         => cs_value( 'auto', 'style' ),
    'layout_cell_align_self_lg'         => cs_value( 'auto', 'style' ),
    'layout_cell_align_self_xl'         => cs_value( 'auto', 'style' ),

    'layout_cell_flexbox'               => cs_value( false, 'style' ),
    'layout_cell_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_cell_z_index'               => cs_value( 'auto', 'style' ),
    'layout_cell_min_width'             => cs_value( '0px', 'style' ),
    'layout_cell_min_height'            => cs_value( '0px', 'style' ),
    'layout_cell_max_width'             => cs_value( 'none', 'style' ),
    'layout_cell_max_height'            => cs_value( 'none', 'style' ),
    'layout_cell_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_cell_bg_advanced'           => cs_value( false, 'all' ),

    'layout_cell_flex_direction'        => cs_value( 'column', 'style' ),
    'layout_cell_flex_wrap'             => cs_value( true, 'style' ),
    'layout_cell_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_cell_flex_align'            => cs_value( 'flex-start', 'style' ),

    'layout_cell_padding'               => cs_value( '0px', 'style' ),
    'layout_cell_border_width'          => cs_value( '0px', 'style' ),
    'layout_cell_border_style'          => cs_value( 'none', 'style' ),
    'layout_cell_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_cell_border_radius'         => cs_value( '0px', 'style' ),
    'layout_cell_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'layout_cell_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'bg',
  'omega'
);

// Style
// =============================================================================

function x_element_style_layout_cell() {
  return x_get_view( 'styles/elements', 'layout-cell', 'css', array(), false );
}

// Render
// =============================================================================

function x_element_render_layout_cell( $data ) {
  return x_get_view( 'elements', 'layout-cell', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Cell', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_layout_cell',
  'style' => 'x_element_style_layout_cell',
  'render' => 'x_element_render_layout_cell',
  'icon' => 'native',
  'options'            => array(
    'valid_children'    => array( '*' ),
    'index_labels'      => true,
    'library'           => false,
    'empty_placeholder' => false,
    'fallback_content'  => '&nbsp;',
    'contrast_keys' => array(
      'bg:layout_cell_bg_advanced',
      'layout_cell_bg_color'
    )
  ),
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_cell() {


  // Options
  // -------

  $options_layout_cell_min_width_and_height = array(
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

  $options_layout_cell_max_width_and_height = array(
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

  $control_layout_cell_layout = array(
    'keys' => array(
      'column_start_xs' => 'layout_cell_column_start_xs',
      'column_start_sm' => 'layout_cell_column_start_sm',
      'column_start_md' => 'layout_cell_column_start_md',
      'column_start_lg' => 'layout_cell_column_start_lg',
      'column_start_xl' => 'layout_cell_column_start_xl',
      'column_end_xs'   => 'layout_cell_column_end_xs',
      'column_end_sm'   => 'layout_cell_column_end_sm',
      'column_end_md'   => 'layout_cell_column_end_md',
      'column_end_lg'   => 'layout_cell_column_end_lg',
      'column_end_xl'   => 'layout_cell_column_end_xl',
      'row_start_xs'    => 'layout_cell_row_start_xs',
      'row_start_sm'    => 'layout_cell_row_start_sm',
      'row_start_md'    => 'layout_cell_row_start_md',
      'row_start_lg'    => 'layout_cell_row_start_lg',
      'row_start_xl'    => 'layout_cell_row_start_xl',
      'row_end_xs'      => 'layout_cell_row_end_xs',
      'row_end_sm'      => 'layout_cell_row_end_sm',
      'row_end_md'      => 'layout_cell_row_end_md',
      'row_end_lg'      => 'layout_cell_row_end_lg',
      'row_end_xl'      => 'layout_cell_row_end_xl',
      'justify_self_xs' => 'layout_cell_justify_self_xs',
      'justify_self_sm' => 'layout_cell_justify_self_sm',
      'justify_self_md' => 'layout_cell_justify_self_md',
      'justify_self_lg' => 'layout_cell_justify_self_lg',
      'justify_self_xl' => 'layout_cell_justify_self_xl',
      'align_self_xs'   => 'layout_cell_align_self_xs',
      'align_self_sm'   => 'layout_cell_align_self_sm',
      'align_self_md'   => 'layout_cell_align_self_md',
      'align_self_lg'   => 'layout_cell_align_self_lg',
      'align_self_xl'   => 'layout_cell_align_self_xl',
    ),
    'type'  => 'layout-cell',
    'label' => __( 'Layout', '__x__' ),
    'group' => 'layout_cell:setup',
  );

  $control_layout_cell_flexbox = array(
    'key'     => 'layout_cell_flexbox',
    'type'    => 'choose',
    'label'   => __( 'Flexbox Layout', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_layout_cell_base_font_size = array(
    'key'     => 'layout_cell_base_font_size',
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

  $control_layout_cell_z_index = array(
    'key'     => 'layout_cell_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_cell_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_layout_cell_base_font_size,
      $control_layout_cell_z_index,
    ),
  );

  $control_layout_cell_min_width = array(
    'key'     => 'layout_cell_min_width',
    'type'    => 'unit',
    'options' => $options_layout_cell_min_width_and_height,
  );

  $control_layout_cell_min_height = array(
    'key'     => 'layout_cell_min_height',
    'type'    => 'unit',
    'options' => $options_layout_cell_min_width_and_height,
  );

  $control_layout_cell_min_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Min Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_layout_cell_min_width,
      $control_layout_cell_min_height,
    ),
  );

  $control_layout_cell_max_width = array(
    'key'     => 'layout_cell_max_width',
    'type'    => 'unit',
    'options' => $options_layout_cell_max_width_and_height,
  );

  $control_layout_cell_max_height = array(
    'key'     => 'layout_cell_max_height',
    'type'    => 'unit',
    'options' => $options_layout_cell_max_width_and_height,
  );

  $control_layout_cell_max_width_and_height = array(
    'type'     => 'group',
    'label'    => __( 'Max Width &amp; Height', '__x__' ),
    'controls' => array(
      $control_layout_cell_max_width,
      $control_layout_cell_max_height,
    ),
  );

  $control_layout_cell_bg_color = array(
    'keys'    => array( 'value' => 'layout_cell_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_layout_cell_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_cell_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_cell_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_cell_bg_color,
      $control_layout_cell_bg_advanced
    ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_cell_layout,
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'layout_cell:setup',
          'controls' => array(
            $control_layout_cell_flexbox,
            $control_layout_cell_font_size_and_z_index,
            $control_layout_cell_min_width_and_height,
            $control_layout_cell_max_width_and_height,
            $control_layout_cell_background
          ),
        ),
      ),
      'controls_std_design_setup' => array(
        $control_layout_cell_layout,
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_layout_cell_font_size_and_z_index,
            $control_layout_cell_min_width_and_height,
            $control_layout_cell_max_width_and_height,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'layout_cell_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'layout_cell_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_layout_cell_bg_color
          ),
        ),

        cs_control( 'border', 'layout_cell', array(
          'k_pre' => 'layout_cell',
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'layout_cell_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'layout_cell_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )

      ),
      'control_nav' => array(
        'layout_cell'        => __( 'Cell', '__x__' ),
        'layout_cell:setup'  => __( 'Setup', '__x__' ),
        'layout_cell:design' => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'bg', array(
      'group'      => 'layout_cell:design',
      'condition' => array( 'layout_cell_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        cs_control( 'flexbox', 'layout_cell', array( 'group' => 'layout_cell:design', 'conditions' => array( array( 'layout_cell_flexbox' => true ) ) ) ),
        cs_control( 'padding', 'layout_cell', array( 'group' => 'layout_cell:design' ) ),
        cs_control( 'border', 'layout_cell', array( 'group' => 'layout_cell:design' ) ),
        cs_control( 'border-radius', 'layout_cell', array( 'group' => 'layout_cell:design' ) ),
        cs_control( 'box-shadow', 'layout_cell', array( 'group' => 'layout_cell:design' ) )
      )
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'layout-cell', $data );
