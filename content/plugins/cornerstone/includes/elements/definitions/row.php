<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/ROW.PHP
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
  array(
    'row_base_font_size'        => cs_value( '1em', 'style' ),
    'row_z_index'               => cs_value( '1', 'style' ),
    'row_width'                 => cs_value( 'auto', 'style' ),
    'row_max_width'             => cs_value( 'none', 'style' ),
    'row_inner_container'       => cs_value( false, 'markup' ),
    'row_marginless_columns'    => cs_value( false, 'markup' ),
    'row_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'row_bg_advanced'           => cs_value( false, 'all' ),
    'row_text_align'            => cs_value( 'none', 'style' ),
    'row_margin'                => cs_value( '0em auto 0em auto', 'style' ),
    'row_padding'               => cs_value( '0em', 'style' ),
    'row_border_width'          => cs_value( '0px', 'style' ),
    'row_border_style'          => cs_value( 'none', 'style' ),
    'row_border_color'          => cs_value( 'transparent', 'style:color' ),
    'row_border_radius'         => cs_value( '0px', 'style' ),
    'row_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'row_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),
  ),
  'bg',
  'omega',
  'omega:style'
);


// Style
// =============================================================================

function x_element_style_row() {
  return x_get_view( 'styles/elements', 'row', 'css', array(), false );
}




// Render
// =============================================================================

function x_element_render_row( $data ) {
  return x_get_view( 'elements', 'row', '', $data, false );
}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Classic Row (v2)', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_row',
  'style' => 'x_element_style_row',
  'render' => 'x_element_render_row',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_row() {

  $default_child = array( '_type' => 'column', '_active' => true );


  // Individual Controls
  // =============================================================================

  $control_row_columns = array(
    'type'    => '_columns',
    'label'   => __( 'Columns', '__x__' ),
    'group'   => 'row:setup'
  );

  $control_row_base_font_size = array(
    'key'     => 'row_base_font_size',
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

  $control_row_z_index = array(
    'key'     => 'row_z_index',
    'type'    => 'unit',
    'label'   => __( 'Z-Index', '__x__' ),
    'options' => array(
      'unit_mode'      => 'unitless',
      'valid_keywords' => array( 'auto' ),
      'fallback_value' => 'auto',
    ),
  );

  $control_row_font_size_and_z_index =array(
    'type'     => 'group',
    'label'    => __( 'Font Size &amp; Z-Index', '__x__' ),
    'controls' => array(
      $control_row_base_font_size,
      $control_row_z_index,
    ),
  );

  $control_row_inner_container = array(
    'key'     => 'row_inner_container',
    'type'    => 'choose',
    'label'   => __( 'Inner Container', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_row_width = array(
    'key'       => 'row_width',
    'type'      => 'unit',
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
    'condition' => array( 'row_inner_container' => false ),
  );

  $control_row_max_width = array(
    'key'       => 'row_max_width',
    'type'      => 'unit',
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
    'condition' => array( 'row_inner_container' => false ),
  );

  $control_row_width_and_max_width = array(
    'type'      => 'group',
    'label'     => __( 'Width &amp; Max Width', '__x__' ),
    'condition' => array( 'row_inner_container' => false ),
    'controls'  => array(
      $control_row_width,
      $control_row_max_width,
    ),
  );

  $control_row_marginless_columns = array(
    'key'     => 'row_marginless_columns',
    'type'    => 'choose',
    'label'   => __( 'Marginless Columns', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_row_bg_color = array(
    'keys'    => array( 'value' => 'row_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' )
  );

  $control_row_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'row_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_row_background = array(
    'type'     => 'group',
    'label'    => __( 'Background', '__x__' ),
    'controls' => array(
      $control_row_bg_color,
      $control_row_bg_advanced
    ),
  );

  $control_row_text_align = array(
    'key'   => 'row_text_align',
    'type'  => 'text-align',
    'label' => __( 'Text Align', '__x__' ),
  );


  // Compose Controls
  // ----------------

  return array_merge(
    cs_compose_controls(
      array(
        'controls' => array(
          $control_row_columns,
          array(
            'type'     => 'group',
            'label'    => __( 'Setup', '__x__' ),
            'group'    => 'row:setup',
            'controls' => array(
              $control_row_font_size_and_z_index,
              $control_row_inner_container,
              $control_row_width_and_max_width,
              $control_row_marginless_columns,
              $control_row_background
            ),
          )
        ),
        'controls_std_content' => array(
          $control_row_columns
        ),
        'controls_std_design_setup' => array(
          array(
            'type'       => 'group',
            'label'      => __( 'Design Setup', '__x__' ),
            'controls'   => array(
              $control_row_font_size_and_z_index,
              $control_row_inner_container,
              $control_row_width_and_max_width,
              $control_row_marginless_columns,
              $control_row_text_align,
            ),
          ),
        ),
        'controls_std_design_colors' => array(
          array(
            'type'       => 'group',
            'label'      => __( 'Base Colors', '__x__' ),
            'controls'   => array(
              array(
                'keys'      => array( 'value' => 'row_box_shadow_color' ),
                'type'      => 'color',
                'label'     => __( 'Box<br>Shadow', '__x__' ),
                'condition' => array( 'key' => 'row_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
              ),
              $control_row_bg_color
            ),
          ),
          cs_control( 'border', 'row', array(
            'options'   => array( 'color_only' => true ),
            'conditions' => array(
              array( 'key' => 'row_border_width', 'op' => 'NOT EMPTY' ),
              array( 'key' => 'row_border_style', 'op' => '!=', 'value' => 'none' )
            ),
          ) )
        ),
        'control_nav' => array(
          'row'        => __( 'Row', '__x__' ),
          'row:setup'  => __( 'Setup', '__x__' ),
          'row:design' => __( 'Design', '__x__' ),
        )
      ),
      cs_partial_controls( 'bg', array(
        'group' => 'row:design',
        'condition' => array( 'row_bg_advanced' => true )
      ) ),
      array(
        'controls' => array(
          array(
            'type'     => 'group',
            'label'    => __( 'Formatting', '__x__' ),
            'controls' => array(
              $control_row_text_align
            ),
          ),

          cs_control( 'margin', 'row', array(
            'group'   => 'row:design',
            'options' => array(
              'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
              'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
            ),
          ) ),
          cs_control( 'padding', 'row', array( 'group' => 'row:design' ) ),
          cs_control( 'border', 'row', array( 'group' => 'row:design' ) ),
          cs_control( 'border-radius', 'row', array( 'group' => 'row:design' ) ),
          cs_control( 'box-shadow', 'row', array( 'group' => 'row:design' ) )
        ),
        'controls_std_design_setup' => array(
          cs_control( 'margin', 'row', array(
            'options' => array(
              'left'  => array( 'disabled' => true, 'fallback_value' => 'auto' ),
              'right' => array( 'disabled' => true, 'fallback_value' => 'auto' ),
            ),
          ) )
        )
      ),
      cs_partial_controls( 'omega', array( 'add_style' => true ) )
    ),
    array(
      'options' => array(
        'valid_children'    => array( 'column' ),
        'index_labels'      => true,
        'is_draggable'      => false,
        'library'           => false,
        'empty_placeholder' => false,
        'default_children' => array( $default_child ),
        'add_new_element'  => $default_child,
        'contrast_keys' => array(
          'bg:row_bg_advanced',
          'row_bg_color'
        )
      )
    )
  );

}



// Register Element
// =============================================================================

cs_register_element( 'row', $data );
