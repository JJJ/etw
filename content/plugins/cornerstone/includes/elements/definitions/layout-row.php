<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-ROW.PHP
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
    'layout_row_layout_xl'             => cs_value( '50% 50%', 'style' ),
    'layout_row_layout_lg'             => cs_value( '50% 50%', 'style' ),
    'layout_row_layout_md'             => cs_value( '50% 50%', 'style' ),
    'layout_row_layout_sm'             => cs_value( '100%', 'style' ),
    'layout_row_layout_xs'             => cs_value( '100%', 'style' ),

    'layout_row_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_row_z_index'               => cs_value( '1', 'style' ),
    'layout_row_flex_justify'          => cs_value( 'flex-start', 'style' ),
    'layout_row_gap_column'            => cs_value( '1rem', 'style' ),
    'layout_row_flex_align'            => cs_value( 'stretch', 'style' ),
    'layout_row_gap_row'               => cs_value( '1rem', 'style' ),
    'layout_row_reverse'               => cs_value( false, 'style' ),
    'layout_row_grow'                  => cs_value( false, 'style' ),
    'layout_row_global_container'      => cs_value( false, 'all' ),
    'layout_row_width'                 => cs_value( 'auto', 'style' ),
    'layout_row_max_width'             => cs_value( 'none', 'style' ),
    'layout_row_text_align'            => cs_value( 'none', 'style' ),
    'layout_row_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_row_bg_advanced'           => cs_value( false, 'all' ),

    'layout_row_margin'                => cs_value( '0px auto 0px auto', 'style' ),
    'layout_row_padding'               => cs_value( '0px', 'style' ),
    'layout_row_border_width'          => cs_value( '0px', 'style' ),
    'layout_row_border_style'          => cs_value( 'none', 'style' ),
    'layout_row_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_row_border_radius'         => cs_value( '0px', 'style' ),
    'layout_row_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'layout_row_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'bg',
  'omega'
);



// Style
// =============================================================================

function x_element_style_layout_row() {
  return x_get_view( 'styles/elements', 'layout-row', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_layout_row( $data ) {
  return x_get_view( 'elements', 'layout-row', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'   => __( 'Row', '__x__' ),
  'values'  => $values,
  'builder' => 'x_element_builder_setup_layout_row',
  'style'   => 'x_element_style_layout_row',
  'render'  => 'x_element_render_layout_row',
  'icon'    => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_row() {

  // Options
  // -------

  $options_layout_row_gap = array(
    'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1rem',
    'ranges'          => array(
      'px'   => array( 'min' => 0, 'max' => 50, 'step' => 1    ),
      'em'   => array( 'min' => 0, 'max' => 3,  'step' => 0.25 ),
      'rem'  => array( 'min' => 0, 'max' => 3,  'step' => 0.25 ),
      'vw'   => array( 'min' => 0, 'max' => 25, 'step' => 1    ),
      'vmin' => array( 'min' => 0, 'max' => 25, 'step' => 1    ),
      'vh'   => array( 'min' => 0, 'max' => 25, 'step' => 1    ),
      'vmax' => array( 'min' => 0, 'max' => 25, 'step' => 1    ),
    ),
  );


  // Individual Controls
  // -------------------

  $control_layout_row_sortable = array(
    'type'       => 'sortable',
    'label'      => __( 'Columns', '__x__' ),
    'group'      => 'layout_row:setup'
  );

  $control_layout_row_layout = array(
    'keys' => array(
      'xs' => 'layout_row_layout_xs',
      'sm' => 'layout_row_layout_sm',
      'md' => 'layout_row_layout_md',
      'lg' => 'layout_row_layout_lg',
      'xl' => 'layout_row_layout_xl'
    ),
    'type'  => 'layout-row',
    'label' => __( 'Layout', '__x__' ),
    'group' => 'layout_row:setup',
  );

  $control_layout_align_axis_main = array(
    'key'     => 'layout_row_flex_justify',
    'type'    => 'placement',
    'label'   => __( 'Align Horizontal', '__x__' ),
    'options' => array( 'display' => 'flex', 'axis' => 'main', 'context' => 'content', 'icon_direction' => 'x' ),
  );

  $control_layout_align_axis_cross = array(
    'key'     => 'layout_row_flex_align',
    'type'    => 'placement',
    'label'   => __( 'Align Vertical', '__x__' ),
    'options' => array( 'display' => 'flex', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'y' ),
  );

  $control_layout_row_gap_row = array(
    'key'     => 'layout_row_gap_row',
    'type'    => 'unit-slider',
    'label'   => __( 'Gap Height', '__x__' ),
    'options' => $options_layout_row_gap,
  );

  $control_layout_row_gap_column = array(
    'key'     => 'layout_row_gap_column',
    'type'    => 'unit-slider',
    'label'   => __( 'Gap Width', '__x__' ),
    'options' => $options_layout_row_gap,
  );

  $control_layout_row_options = array(
    'keys' => array(
      'reverse'   => 'layout_row_reverse',
      'grow'      => 'layout_row_grow',
    ),
    'type'    => 'checkbox-list',
    'label'   => __( 'Layout<br/>Options', '__x__' ),
    'options' => array(
      'list'   => array(
        array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
        array( 'key' => 'grow',    'label' => __( 'Grow', '__x__' ) ),
      ),
    ),
  );

  $control_layout_row_base_font_size = array(
    'key'     => 'layout_row_base_font_size',
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

  $control_layout_row_z_index = array(
    'key'     => 'layout_row_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_row_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_layout_row_base_font_size,
      $control_layout_row_z_index,
    ),
  );

  $control_layout_row_global_container = array(
    'key'     => 'layout_row_global_container',
    'type'    => 'choose',
    'label'   => __( 'Global Container', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_layout_row_width = array(
    'key'       => 'layout_row_width',
    'type'      => 'unit',
    'condition' => array( 'layout_row_global_container' => false ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc', 'auto' ),
      'fallback_value'  => 'auto',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
        'em'  => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
        'rem' => array( 'min' => 0, 'max' => 40,   'step' => 0.5 ),
        '%'   => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
        'vw'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
        'vh'  => array( 'min' => 0, 'max' => 100,  'step' => 1   ),
      ),
    ),
  );

  $control_layout_row_max_width = array(
    'key'       => 'layout_row_max_width',
    'type'      => 'unit',
    'condition' => array( 'layout_row_global_container' => false ),
    'options'   => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'valid_keywords'  => array( 'calc', 'none' ),
      'fallback_value'  => 'none',
      'ranges'          => array(
        'px'  => array( 'min' => 0, 'max' => 1500, 'step' => 10  ),
        'em'  => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
        'rem' => array( 'min' => 0, 'max' => 40,  'step' => 0.5  ),
        '%'   => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
        'vw'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
        'vh'  => array( 'min' => 0, 'max' => 100, 'step' => 1    ),
      ),
    ),
  );

  $control_layout_row_width_and_max_width = array(
    'type'      => 'group',
    'label'     => __( 'Width &amp; Max Width', '__x__' ),
    'condition' => array( 'layout_row_global_container' => false ),
    'controls'  => array(
      $control_layout_row_width,
      $control_layout_row_max_width,
    ),
  );

  $control_layout_row_text_align = array(
    'key'   => 'layout_row_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );

  $control_layout_row_bg_color = array(
    'keys'  => array( 'value' => 'layout_row_bg_color' ),
    'type'  => 'color',
    'label' => __( 'Background', '__x__' )
  );

  $control_layout_row_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_row_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_row_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_row_bg_color,
      $control_layout_row_bg_advanced
    ),
  );


  // Control Groups (Advanced)
  // -------------------------

  $control_group_layout_row_adv_setup = array(
    'type'     => 'group',
    'label'    => __( 'Setup', '__x__' ),
    'group'    => 'layout_row:setup',
    'controls' => array(
      $control_layout_row_font_size_and_z_index,
      $control_layout_align_axis_main,
      $control_layout_align_axis_cross,
      $control_layout_row_gap_column,
      $control_layout_row_gap_row,
      $control_layout_row_options,
      $control_layout_row_global_container,
      $control_layout_row_width_and_max_width,
      $control_layout_row_text_align,
      $control_layout_row_background,
    ),
  );



  // Control Groups (Standard)
  // -------------------------

  $control_group_layout_row_std_design_setup = array(
    'type'     => 'group',
    'label'    => __( 'Design Setup', '__x__' ),
    'controls' => array(
      $control_layout_row_font_size_and_z_index,
      $control_layout_row_text_align,
      $control_layout_row_global_container,
      $control_layout_row_width_and_max_width,
    )
  );

  $control_group_layout_row_std_design_colors = array(
    array(
      'type'     => 'group',
      'label'    => __( 'Base Colors', '__x__' ),
      'controls' => array(
        array(
          'keys'      => array( 'value' => 'layout_row_box_shadow_color' ),
          'type'      => 'color',
          'label'     => __( 'Box<br>Shadow', '__x__' ),
          'condition' => array( 'key' => 'layout_row_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
        ),
        $control_layout_row_bg_color
      ),
    ),
    cs_control( 'border', 'layout_row', array(
      'options'    => array( 'color_only' => true ),
      'conditions' => array(
        array( 'key' => 'layout_row_border_width', 'op' => 'NOT EMPTY' ),
        array( 'key' => 'layout_row_border_style', 'op' => '!=', 'value' => 'none' )
      ),
    ) )
  );

  return array_merge(
    cs_compose_controls(
      array(
        'controls' => array(
          $control_layout_row_sortable,
          $control_layout_row_layout,
          $control_group_layout_row_adv_setup
        ),
        'controls_std_content' => array(
          $control_layout_row_sortable,
          $control_layout_row_layout
        ),
        'controls_std_design_setup' => array(
          $control_group_layout_row_std_design_setup
        ),
        'controls_std_design_colors' => $control_group_layout_row_std_design_colors,
        'control_nav' => array(
          'layout_row'        => __( 'Row', '__x__' ),
          'layout_row:setup'  => __( 'Setup', '__x__' ),
          'layout_row:design' => __( 'Design', '__x__' ),
        )
      ),
      cs_partial_controls( 'bg', array(
        'group'     => 'layout_row:design',
        'condition' => array( 'layout_row_bg_advanced' => true ),
      ) ),
      array(
        'controls' => array(
          cs_control( 'margin', 'layout_row', array(
            'group'   => 'layout_row:design',
            'options' => array(
              'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
              'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
            )
          ) ),
          cs_control( 'padding', 'layout_row', array( 'group' => 'layout_row:design' ) ),
          cs_control( 'border', 'layout_row', array( 'group' => 'layout_row:design' ) ),
          cs_control( 'border-radius', 'layout_row', array( 'group' => 'layout_row:design' ) ),
          cs_control( 'box-shadow', 'layout_row', array( 'group' => 'layout_row:design' ) )
        ),
      ),
      cs_partial_controls( 'omega' )
    ),
    array(
      'options' => array(
        'valid_children'    => array( 'layout-column' ),
        'index_labels'      => true,
        'is_draggable'      => false,
        'library'           => array( 'content' ),
        'empty_placeholder' => false,
        'add_new_element'   => array( '_type' => 'layout-column' ),
        'contrast_keys'     => array(
          'bg:layout_row_bg_advanced',
          'layout_row_bg_color'
        )
      )
    )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'layout-row', $data );
