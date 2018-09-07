<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_MENU.PHP
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
//   06. Settings
//   07. Individual Controls
//   08. Control Lists
//   09. Control Groups (Advanced)
//   10. Control Groups (Standard Content)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================
// 01. Available types:
//     -- 'inline'
//     -- 'dropdown'
//     -- 'collapsed'
//     -- 'modal'
//     -- 'layered'

$group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'menu';
$group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Menu', '__x__' );
$condition   = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
$type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'inline'; // 01



// Groups
// =============================================================================

$group_menu_setup  = $group . ':setup';
$group_menu_design = $group . ':design';



// Conditions
// =============================================================================

$conditions = x_module_conditions( $condition );



// Options
// =============================================================================

$options_menu_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '16px',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
  ),
);

$options_menu_align_self = array(
  'choices' => array(
    array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )   ),
    array( 'value' => 'center',     'label' => __( 'Center', '__x__' )  ),
    array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )     ),
    array( 'value' => 'stretch',    'label' => __( 'Stretch', '__x__' ) ),
  ),
);

$options_menu_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%' ),
  'fallback_value'  => 'inherit',
  'valid_keywords'  => array( 'auto', 'inherit' ),
);



// Settings
// =============================================================================

$settings_menu_margin = array(
  'k_pre'     => 'menu',
  'group'     => $group_menu_design,
  'condition' => $conditions
);

$settings_menu_self_flex = array(
  'k_pre'     => 'menu',
  't_pre'     => __( 'Self', '__x__' ),
  'group'     => $group_menu_design,
  'condition' => $conditions
);

$settings_menu_flex_css_row = array(
  'k_pre'     => 'menu_row',
  'group'     => $group_menu_design,
  'condition' => array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ),
);

$settings_menu_flex_css_col = array(
  'k_pre'     => 'menu_col',
  'group'     => $group_menu_design,
  'condition' => array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) ),
);

$settings_menu_items_flex = array(
  'k_pre'     => 'menu_items',
  't_pre'     => __( 'Items', '__x__' ),
  'group'     => $group_menu_design,
  'condition' => $conditions
);



// Individual Controls
// =============================================================================

$control_menu_menu = array(
  'key'   => 'menu',
  'type'  => 'menu',
  'label' => __( 'Assign Menu', '__x__' ),
);

$control_menu_base_font_size = array(
  'key'     => 'menu_base_font_size',
  'type'    => 'slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_menu_font_size,
);

$control_menu_align_self = array(
  'key'     => 'menu_align_self',
  'type'    => 'select',
  'label'   => __( 'Align Self', '__x__' ),
  'options' => $options_menu_align_self,
);

$control_menu_sub_menu_trigger_location = array(
  'key'     => 'menu_sub_menu_trigger_location',
  'type'    => 'choose',
  'label'   => __( 'Sub Menu Trigger', '__x__' ),
  'options' => array(
    'choices' => array(
      array( 'value' => 'anchor',        'label' => __( 'Anchor', '__x__' )        ),
      array( 'value' => 'sub-indicator', 'label' => __( 'Sub Indicator', '__x__' ) ),
    ),
  ),
);

$control_menu_layered_back_label = array(
  'key'   => 'menu_layered_back_label',
  'type'  => 'text',
  'label' => __( 'Back Label', '__x__' ),
);

$control_menu_active_links_highlight_current = array(
  'key'     => 'menu_active_links_highlight_current',
  'type'    => 'choose',
  'label'   => __( 'Current<br>Link', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_menu_active_links_highlight_ancestors = array(
  'key'     => 'menu_active_links_highlight_ancestors',
  'type'    => 'choose',
  'label'   => __( 'Ancestor Links', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_menu_active_links_show_graphic = array(
  'key'     => 'menu_active_links_show_graphic',
  'type'    => 'choose',
  'label'   => __( 'Graphic', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_menu_active_links_show_primary_particle = array(
  'key'     => 'menu_active_links_show_primary_particle',
  'type'    => 'choose',
  'label'   => __( 'Primary Particle', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_menu_active_links_show_secondary_particle = array(
  'key'     => 'menu_active_links_show_secondary_particle',
  'type'    => 'choose',
  'label'   => __( 'Secondary Particle', '__x__' ),
  'options' => $options_choices_off_on_bool,
);



// Control Lists
// =============================================================================

// Advanced Setup
// --------------

$control_list_menu_adv_setup = array(
  $control_menu_menu
);

if ( $type !== 'dropdown' ) {
  $control_list_menu_adv_setup[] = $control_menu_base_font_size;
}

if ( $type === 'inline' ) {
  $control_list_menu_adv_setup[] = $control_menu_align_self;
}

if ( $type === 'collapsed' || $type === 'modal' || $type === 'layered' ) {
  $control_list_menu_adv_setup[] = $control_menu_sub_menu_trigger_location;
}

if ( $type === 'modal' || $type === 'layered' ) {
  $control_list_menu_adv_setup[] = $control_menu_layered_back_label;
}


// Advanced Active Links Setup
// ---------------------------

$control_list_menu_adv_active_links_setup = array(
  $control_menu_active_links_highlight_current,
  $control_menu_active_links_highlight_ancestors,
  $control_menu_active_links_show_graphic,
  $control_menu_active_links_show_primary_particle,
  $control_menu_active_links_show_secondary_particle,
);


// Standard Content
// ----------------

$control_list_menu_std_content_setup = array(
  $control_menu_menu,
);



// Control Groups (Advanced)
// =============================================================================

$control_group_menu_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Setup', '__x__' ),
    'group'      => $group_menu_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_menu_adv_setup,
  ),
);

$control_group_menu_adv_active_links_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Active Links Setup', '__x__' ),
    'group'      => $group_menu_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_menu_adv_active_links_setup,
  ),
);



// Control Groups (Standard Content)
// =============================================================================

$control_group_menu_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( 'Menu', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions,
    'controls'   => $control_list_menu_std_content_setup,
  ),
);
