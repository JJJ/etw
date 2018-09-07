<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/TABS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Shared
//   02. Setup
//   03. Groups
//   04. Conditions
//   05. Options
//   06. Individual Controls
//   07. Control Lists
//   08. Control Groups (Advanced)
//   09. Control Groups (Standard)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'tabs';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Tabs', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();



// Groups
// =============================================================================

$group_tabs_setup          = $group . ':setup';
$group_tabs_design         = $group . ':design';

$group_tabs_tablist        = $group . '_tablist';
$group_tabs_tablist_setup  = $group . '_tablist:setup';
$group_tabs_tablist_design = $group . '_tablist:design';

$group_tabs_tabs           = $group . '_tabs';
$group_tabs_tabs_setup     = $group . '_tabs:setup';
$group_tabs_tabs_design    = $group . '_tabs:design';
$group_tabs_tabs_text      = $group . '_tabs:text';

$group_tabs_panels         = $group . '_panels';
$group_tabs_panels_setup   = $group . '_panels:setup';
$group_tabs_panels_design  = $group . '_panels:design';
$group_tabs_panels_text    = $group . '_panels:text';



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

$options_tab_sortable = array(
  'element'   => 'tab',
  'label_key' => 'tab_label_content'
);

$options_tabs_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_tabs_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'auto', 'calc' ),
  'fallback_value'  => 'auto',
  'ranges'          => array(
    'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 10  ),
    'em'  => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
    'rem' => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
    '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
  ),
);

$options_tabs_max_width = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'valid_keywords'  => array( 'none', 'calc' ),
  'fallback_value'  => 'none',
  'ranges'          => array(
    'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 10  ),
    'em'  => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
    'rem' => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
    '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
  ),
);

$options_tabs_tabs_justify_content = array(
  'choices' => array(
    array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )         ),
    array( 'value' => 'center',        'label' => __( 'Center', '__x__' )        ),
    array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )           ),
    array( 'value' => 'space-between', 'label' => __( 'Space Between', '__x__' ) ),
    array( 'value' => 'space-around',  'label' => __( 'Space Around', '__x__' )  ),
    array( 'value' => 'space-evenly',  'label' => __( 'Space Evenly', '__x__' )  ),
  ),
);

$options_tabs_tabs_min_width = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '0px',
  'valid_keywords'  => array( 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 100, 'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 5,   'max' => 10,  'step' => 0.1 ),
    'rem' => array( 'min' => 5,   'max' => 10,  'step' => 0.1 ),
  ),
);

$options_tabs_tabs_max_width = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => 'none',
  'valid_keywords'  => array( 'none', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 200, 'max' => 500, 'step' => 10  ),
    'em'  => array( 'min' => 10,  'max' => 20,  'step' => 0.5 ),
    'rem' => array( 'min' => 10,  'max' => 20,  'step' => 0.5 ),
  ),
);

$options_tabs_panels_flex_justify = array(
  'choices' => array(
    array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )         ),
    array( 'value' => 'center',        'label' => __( 'Center', '__x__' )        ),
    array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )           ),
    array( 'value' => 'space-between', 'label' => __( 'Space Between', '__x__' ) ),
    array( 'value' => 'space-around',  'label' => __( 'Space Around', '__x__' )  ),
    array( 'value' => 'space-evenly',  'label' => __( 'Space Evenly', '__x__' )  ),
  ),
);

$options_tabs_panels_flex_align = array(
  'choices' => array(
    array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )   ),
    array( 'value' => 'center',     'label' => __( 'Center', '__x__' )  ),
    array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )     ),
    array( 'value' => 'stretch',    'label' => __( 'Stretch', '__x__' ) ),
  ),
);



// Settings
// =============================================================================

$settings_tabs = array(
  'k_pre'     => 'tabs',
  'group'     => $group_tabs_design,
  'condition' => $conditions,
);

$settings_tabs_tablist = array(
  'k_pre'     => 'tabs_tablist',
  'group'     => $group_tabs_tablist_design,
  'condition' => $conditions,
);

$settings_tabs_tabs_design = array(
  'k_pre'     => 'tabs_tabs',
  'group'     => $group_tabs_tabs_design,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => array(
    'color' => array(
      'label'     => __( 'Base', '__x__' ),
      'alt_label' => __( 'Interaction', '__x__' ),
    ),
  ),
);

$settings_tabs_tabs_text = array(
  'k_pre'     => 'tabs_tabs',
  'group'     => $group_tabs_tabs_text,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => array(
    'color' => array(
      'label'     => __( 'Base', '__x__' ),
      'alt_label' => __( 'Interaction', '__x__' ),
    ),
  ),
);

$settings_tabs_panels_design = array(
  'k_pre'     => 'tabs_panels',
  'group'     => $group_tabs_panels_design,
  'condition' => $conditions,
);

$settings_tabs_panels_text = array(
  'k_pre'     => 'tabs_panels',
  'group'     => $group_tabs_panels_text,
  'condition' => $conditions,
);

$settings_tabs_std_design = array(
  'k_pre'     => 'tabs',
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_tabs_sortable = array(
  'type'       => 'sortable',
  'title'      => __( 'Add Items', '__x__' ),
  'group'      => $is_adv ? $group_tabs_setup : $group_std_content,
  'conditions' => $conditions,
  'options'    => $options_tab_sortable,
);

$control_tabs_base_font_size = array(
  'key'     => 'tabs_base_font_size',
  'type'    => 'slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_tabs_base_font_size,
);

$control_tabs_width = array(
  'key'     => 'tabs_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_tabs_width,
);

$control_tabs_max_width = array(
  'key'     => 'tabs_max_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_tabs_max_width,
);

$control_tabs_bg_color = array(
  'key'   => 'tabs_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);

$control_tabs_tablist_bg_color = array(
  'key'   => 'tabs_tablist_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);

$control_tabs_tabs_fill_space = array(
  'key'     => 'tabs_tabs_fill_space',
  'type'    => 'choose',
  'label'   => __( 'Fill Space', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_tabs_tabs_justify_content = array(
  'key'       => 'tabs_tabs_justify_content',
  'type'      => 'select',
  'label'     => __( 'Justify Content', '__x__' ),
  'options'   => $options_tabs_tabs_justify_content,
  'condition' => array( 'tabs_tabs_fill_space' => false ),
);

$control_tabs_tabs_min_width = array(
  'key'     => 'tabs_tabs_min_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Min Width', '__x__' ),
  'options' => $options_tabs_tabs_min_width,
);

$control_tabs_tabs_max_width = array(
  'key'     => 'tabs_tabs_max_width',
  'type'    => 'unit-slider',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_tabs_tabs_max_width,
);

$control_tabs_tabs_bg_colors = array(
  'keys' => array(
    'value' => 'tabs_tabs_bg_color',
    'alt'   => 'tabs_tabs_bg_color_alt',
  ),
  'type'    => 'color',
  'title'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_tabs_panels_equal_height = array(
  'key'     => 'tabs_panels_equal_height',
  'type'    => 'choose',
  'label'   => __( 'Equal Height', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_tabs_panels_flex_justify = array(
  'key'       => 'tabs_panels_flex_justify',
  'type'      => 'select',
  'label'     => __( 'Vertical Alignment', '__x__' ),
  'options'   => $options_tabs_panels_flex_justify,
  'condition' => array( 'tabs_panels_equal_height' => true ),
);

$control_tabs_panels_flex_align = array(
  'key'       => 'tabs_panels_flex_align',
  'type'      => 'select',
  'label'     => __( 'Horizontal Alignment', '__x__' ),
  'options'   => $options_tabs_panels_flex_align,
  'condition' => array( 'tabs_panels_equal_height' => true ),
);

$control_tabs_panels_bg_color = array(
  'key'   => 'tabs_panels_bg_color',
  'type'  => 'color',
  'title' => __( 'Background', '__x__' ),
);



// Control Lists
// =============================================================================

// Advanced
// --------

$control_list_tabs_adv_setup = array(
  $control_tabs_base_font_size,
  $control_tabs_width,
  $control_tabs_max_width,
  $control_tabs_bg_color,
);

$control_list_tabs_adv_setup_tabs = array(
  $control_tabs_tabs_fill_space,
  $control_tabs_tabs_justify_content,
  $control_tabs_tabs_min_width,
  $control_tabs_tabs_max_width,
  $control_tabs_tabs_bg_colors,
);

$control_list_tabs_adv_setup_panels = array(
  $control_tabs_panels_equal_height,
  $control_tabs_panels_flex_justify,
  $control_tabs_panels_flex_align,
  $control_tabs_panels_bg_color
);


// Standard
// --------

$control_list_tabs_std_design_setup = array(
  $control_tabs_base_font_size,
  $control_tabs_width,
  $control_tabs_max_width,
);

$control_list_tabs_std_design_setup_tabs = array(
  $control_tabs_tabs_fill_space,
  $control_tabs_tabs_justify_content,
  $control_tabs_tabs_min_width,
  $control_tabs_tabs_max_width,
);

$control_list_tabs_std_design_colors_base = array(
  array(
    'keys'      => array( 'value' => 'tabs_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'tabs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_tabs_bg_color,
);

$control_list_tabs_std_design_colors_tablist = array(
  array(
    'keys'      => array( 'value' => 'tabs_tablist_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'tabs_tablist_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_tabs_tablist_bg_color,
);

$control_list_tabs_std_design_colors_tabs = array(
  array(
    'keys' => array(
      'value' => 'tabs_tabs_text_color',
      'alt'   => 'tabs_tabs_text_color_alt'
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => $options_base_interaction_labels,
  ),
  array(
    'keys' => array(
      'value' => 'tabs_tabs_text_shadow_color',
      'alt'   => 'tabs_tabs_text_shadow_color_alt'
    ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'tabs_tabs_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys' => array(
      'value' => 'tabs_tabs_box_shadow_color',
      'alt'   => 'tabs_tabs_box_shadow_color_alt'
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => 'tabs_tabs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_tabs_tabs_bg_colors,
);

$control_list_tabs_std_design_colors_panels = array(
  array(
    'keys'  => array( 'value' => 'tabs_panels_text_color' ),
    'type'  => 'color',
    'label' => __( 'Text', '__x__' ),
  ),
  array(
    'keys'      => array( 'value' => 'tabs_panels_text_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'tabs_panels_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  array(
    'keys'      => array( 'value' => 'tabs_panels_box_shadow_color' ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'condition' => array( 'key' => 'tabs_panels_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_tabs_panels_bg_color,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_tabs_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_tabs_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_tabs_adv_setup,
  ),
);

$control_group_tabs_adv_setup_tablist = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_tabs_tablist_setup,
    'conditions' => $conditions,
    'controls'   => array(
      $control_tabs_tablist_bg_color,
    ),
  ),
);

$control_group_tabs_adv_setup_tabs = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_tabs_tabs_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_tabs_adv_setup_tabs,
  ),
);

$control_group_tabs_adv_setup_panels = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_tabs_panels_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_tabs_adv_setup_panels,
  ),
);



// Control Groups (Standard)
// =============================================================================

$control_group_tabs_std_design_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_tabs_std_design_setup,
  ),
);

$control_group_tabs_std_design_setup_tabs = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Tabs Design Setup', '__x__' ),
    'group'      => $group_std_design,
    'conditions' => $conditions,
    'controls'   => $control_list_tabs_std_design_setup_tabs,
  ),
);

$control_group_tabs_std_design_colors = array_merge(
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Base Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_tabs_std_design_colors_base,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_tabs,
      array(
        't_pre'     => __( 'Base', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'tabs_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'tabs_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Tab List Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_tabs_std_design_colors_tablist,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_tabs_tablist,
      array(
        't_pre'     => __( 'Tab List', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'tabs_tablist_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'tabs_tablist_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Tabs Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_tabs_std_design_colors_tabs,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_tabs_tabs_design,
      array(
        't_pre'     => __( 'Individual Tabs', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_base_interaction_labels_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'tabs_tabs_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'tabs_tabs_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  ),
  array(
    array(
      'type'       => 'group',
      'title'      => __( 'Panels Colors', '__x__' ),
      'group'      => $group_std_design,
      'conditions' => $conditions,
      'controls'   => $control_list_tabs_std_design_colors_panels,
    ),
  ),
  x_control_border(
    array_merge(
      $settings_tabs_panels_design,
      array(
        't_pre'     => __( 'Panels', '__x__' ),
        'group'     => $group_std_design,
        'options'   => $options_color_only,
        'condition' => array(
          $condition,
          array( 'key' => 'tabs_panels_border_width', 'op' => 'NOT EMPTY' ),
          array( 'key' => 'tabs_panels_border_style', 'op' => '!=', 'value' => 'none' )
        ),
      )
    )
  )
);