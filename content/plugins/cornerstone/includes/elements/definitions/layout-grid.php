<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/LAYOUT-GRID.PHP
// -----------------------------------------------------------------------------
// V2 element definitions.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Controls: Advanced
//   03. Controls: Standard (Content)
//   04. Controls: Standard (Design - Setup)
//   05. Controls: Standard (Design - Colors)
//   06. Control Groups
//   07. Values
//   08. Define Element
//   09. Builder Setup
//   10. Register Element
// =============================================================================

// Values
// =============================================================================

$values = cs_compose_values(
  array(
    'layout_grid_template_columns_xs'   => cs_value( '1fr', 'style' ),
    'layout_grid_template_columns_sm'   => cs_value( '1fr', 'style' ),
    'layout_grid_template_columns_md'   => cs_value( '1fr 1fr', 'style' ),
    'layout_grid_template_columns_lg'   => cs_value( '1fr 1fr', 'style' ),
    'layout_grid_template_columns_xl'   => cs_value( '1fr 1fr 1fr 1fr', 'style' ),

    'layout_grid_template_rows_xs'      => cs_value( 'auto', 'style' ),
    'layout_grid_template_rows_sm'      => cs_value( 'auto', 'style' ),
    'layout_grid_template_rows_md'      => cs_value( 'auto', 'style' ),
    'layout_grid_template_rows_lg'      => cs_value( 'auto', 'style' ),
    'layout_grid_template_rows_xl'      => cs_value( 'auto', 'style' ),

    'layout_grid_base_font_size'        => cs_value( '1em', 'style' ),
    'layout_grid_z_index'               => cs_value( 'auto', 'style' ),
    'layout_grid_justify_content'       => cs_value( 'center', 'style' ),
    'layout_grid_align_content'         => cs_value( 'start', 'style' ),
    'layout_grid_justify_items'         => cs_value( 'stretch', 'style' ),
    'layout_grid_align_items'           => cs_value( 'stretch', 'style' ),
    'layout_grid_gap_column'            => cs_value( '1rem', 'style' ),
    'layout_grid_gap_row'               => cs_value( '1rem', 'style' ),
    'layout_grid_global_container'      => cs_value( false, 'all' ),
    'layout_grid_width'                 => cs_value( 'auto', 'style' ),
    'layout_grid_max_width'             => cs_value( 'none', 'style' ),
    'layout_grid_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'layout_grid_bg_advanced'           => cs_value( false, 'all' ),

    'layout_grid_margin'                => cs_value( '0px auto 0px auto', 'style' ),
    'layout_grid_padding'               => cs_value( '0px', 'style' ),
    'layout_grid_border_width'          => cs_value( '0px', 'style' ),
    'layout_grid_border_style'          => cs_value( 'none', 'style' ),
    'layout_grid_border_color'          => cs_value( 'transparent', 'style:color' ),
    'layout_grid_border_radius'         => cs_value( '0px', 'style' ),
    'layout_grid_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'layout_grid_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'bg',
  'omega'
);

// Style
// =============================================================================

function x_element_style_layout_grid() {
  return x_get_view( 'styles/elements', 'layout-grid', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_layout_grid( $data ) {
  return x_get_view( 'elements', 'layout-grid', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Grid', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_layout_grid',
  'style' => 'x_element_style_layout_grid',
  'render' => 'x_element_render_layout_grid',
  'icon' => 'native',
  'options' => array(
    'valid_children'    => array( 'layout-cell' ),
    'index_labels'      => true,
    'is_draggable'      => false,
    'library'           => array( 'content' ),
    'empty_placeholder' => false,
    'add_new_element'   => array( '_type' => 'layout-cell' ),
    'contrast_keys' => array(
      'bg:layout_grid_bg_advanced',
      'layout_grid_bg_color'
    )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_layout_grid() {

  // Options
  // -------

  $options_layout_grid_gap = array(
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
  // =============================================================================

  $control_layout_grid_sortable = array(
    'type'       => 'sortable',
    'label'      => __( 'Cells', '__x__' ),
    'group'      => 'layout_grid:setup'
  );

  $control_layout_grid_layout = array(
    'keys' => array(
      'template_columns_xs' => 'layout_grid_template_columns_xs',
      'template_columns_sm' => 'layout_grid_template_columns_sm',
      'template_columns_md' => 'layout_grid_template_columns_md',
      'template_columns_lg' => 'layout_grid_template_columns_lg',
      'template_columns_xl' => 'layout_grid_template_columns_xl',
      'template_rows_xs'    => 'layout_grid_template_rows_xs',
      'template_rows_sm'    => 'layout_grid_template_rows_sm',
      'template_rows_md'    => 'layout_grid_template_rows_md',
      'template_rows_lg'    => 'layout_grid_template_rows_lg',
      'template_rows_xl'    => 'layout_grid_template_rows_xl',
    ),
    'type'  => 'layout-grid',
    'label' => __( 'Layout', '__x__' ),
    'group' => 'layout_grid:setup',
  );

  $control_layout_grid_justify_content = array(
    'key'     => 'layout_grid_justify_content',
    'type'    => 'placement',
    'label'   => __( 'Content X', '__x__' ),
    'options' => array( 'display' => 'grid', 'axis' => 'main', 'context' => 'content', 'icon_direction' => 'x' ),
  );

  $control_layout_grid_align_content = array(
    'key'     => 'layout_grid_align_content',
    'type'    => 'placement',
    'label'   => __( 'Content Y', '__x__' ),
    'options' => array( 'display' => 'grid', 'axis' => 'cross', 'context' => 'content', 'icon_direction' => 'y' ),
  );

  $control_layout_grid_place_content = array(
    'type'     => 'group',
    'label'    => __( 'X &amp; Y<br/>Content', '__x__' ),
    'controls' => array(
      $control_layout_grid_justify_content,
      $control_layout_grid_align_content,
    ),
  );

  $control_layout_grid_justify_items = array(
    'key'     => 'layout_grid_justify_items',
    'type'    => 'placement',
    'label'   => __( 'Items X', '__x__' ),
    'options' => array( 'display' => 'grid', 'axis' => 'main', 'context' => 'items', 'icon_direction' => 'x' ),
  );

  $control_layout_grid_align_items = array(
    'key'     => 'layout_grid_align_items',
    'type'    => 'placement',
    'label'   => __( 'Items Y', '__x__' ),
    'options' => array( 'display' => 'grid', 'axis' => 'cross', 'context' => 'items', 'icon_direction' => 'y' ),
  );

  $control_layout_grid_place_items = array(
    'type'     => 'group',
    'label'    => __( 'X &amp; Y<br/>Items', '__x__' ),
    'controls' => array(
      $control_layout_grid_justify_items,
      $control_layout_grid_align_items,
    ),
  );

  $control_layout_grid_gap_column = array(
    'key'     => 'layout_grid_gap_column',
    'type'    => 'unit',
    'label'   => __( 'Horizontal<br/>Gap', '__x__' ),
    'options' => $options_layout_grid_gap,
  );

  $control_layout_grid_gap_row = array(
    'key'     => 'layout_grid_gap_row',
    'type'    => 'unit',
    'label'   => __( 'Vertical<br/>Gap', '__x__' ),
    'options' => $options_layout_grid_gap,
  );

  $control_layout_grid_gap = array(
    'type'     => 'group',
    'label'    => __( 'X &amp; Y<br/>Gap', '__x__' ),
    'controls' => array(
      $control_layout_grid_gap_column,
      $control_layout_grid_gap_row,
    ),
  );

  $control_layout_grid_base_font_size = array(
    'key'     => 'layout_grid_base_font_size',
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

  $control_layout_grid_z_index = array(
    'key'     => 'layout_grid_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_layout_grid_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_layout_grid_base_font_size,
      $control_layout_grid_z_index,
    ),
  );

  $control_layout_grid_global_container = array(
    'key'     => 'layout_grid_global_container',
    'type'    => 'choose',
    'label'   => __( 'Global Container', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_layout_grid_width = array(
    'key'       => 'layout_grid_width',
    'type'      => 'unit',
    'condition' => array( 'layout_grid_global_container' => false ),
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

  $control_layout_grid_max_width = array(
    'key'       => 'layout_grid_max_width',
    'type'      => 'unit',
    'condition' => array( 'layout_grid_global_container' => false ),
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

  $control_layout_grid_width_and_max_width = array(
    'type'      => 'group',
    'label'     => __( 'Width &amp; Max Width', '__x__' ),
    'condition' => array( 'layout_grid_global_container' => false ),
    'controls'  => array(
      $control_layout_grid_width,
      $control_layout_grid_max_width,
    ),
  );

  $control_layout_grid_bg_color = array(
    'keys'    => array( 'value' => 'layout_grid_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_layout_grid_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'layout_grid_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_layout_grid_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_layout_grid_bg_color,
      $control_layout_grid_bg_advanced
    ),
  );

  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        $control_layout_grid_sortable,
        $control_layout_grid_layout,
        array(
          'type'     => 'group',
          'label'    => __( 'Setup', '__x__' ),
          'group'    => 'layout_grid:setup',
          'controls' => array(
            $control_layout_grid_font_size_and_z_index,
            $control_layout_grid_place_content,
            $control_layout_grid_place_items,
            $control_layout_grid_gap,
            $control_layout_grid_global_container,
            $control_layout_grid_width_and_max_width,
            $control_layout_grid_background,
          ),
        ),
      ),
      'controls_std_content' => array(
        $control_layout_grid_sortable,
        $control_layout_grid_layout
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_layout_grid_font_size_and_z_index,
            $control_layout_grid_global_container,
            $control_layout_grid_width_and_max_width,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'layout_grid_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'layout_grid_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_layout_grid_bg_color
          ),
        ),
        cs_control( 'border', 'layout_grid', array(
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'layout_grid_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'layout_grid_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(
        'layout_grid'        => __( 'Grid', '__x__' ),
        'layout_grid:design' => __( 'Setup', '__x__' ),
        'layout_grid:setup'  => __( 'Design', '__x__' ),
      ),
    ),
    cs_partial_controls( 'bg', array(
      'group'      => 'layout_grid:design',
      'condition' => array( 'layout_grid_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        cs_control( 'margin', 'layout_grid', array( 'group' => 'layout_grid:design' ) ),
        cs_control( 'padding', 'layout_grid', array( 'group' => 'layout_grid:design' ) ),
        cs_control( 'border', 'layout_grid', array( 'group' => 'layout_grid:design' ) ),
        cs_control( 'border-radius', 'layout_grid', array( 'group' => 'layout_grid:design' ) ),
        cs_control( 'box-shadow', 'layout_grid', array( 'group' => 'layout_grid:design' ) )
      )
    ),
    cs_partial_controls( 'omega' )
  );

}



// Register Module
// =============================================================================

cs_register_element( 'layout-grid', $data );
