<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_ANCHOR.PHP
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
//   11. Control Groups (Standard Design)
// =============================================================================

// Shared
// =============================================================================

include( '_.php' );



// Setup
// =============================================================================
// 01. Available types:
//     -- 'button'
//     -- 'menu-item'
//     -- 'toggle'

$t_pre            = ( isset( $settings['t_pre'] )            ) ? $settings['t_pre'] . ' '      : '';
$k_pre            = ( isset( $settings['k_pre'] )            ) ? $settings['k_pre'] . '_'      : '';
$group            = ( isset( $settings['group'] )            ) ? $settings['group']            : 'anchor';
$group_title      = ( isset( $settings['group_title'] )      ) ? $settings['group_title']      : __( 'Menu Item', '__x__' );
$condition        = ( isset( $settings['condition'] )        ) ? $settings['condition']        : array();
$type             = ( isset( $settings['type'] )             ) ? $settings['type']             : 'menu-item'; // 01
$lr_only          = ( isset( $settings['lr_only'] )          ) ? $settings['lr_only']          : false;
$tb_only          = ( isset( $settings['tb_only'] )          ) ? $settings['tb_only']          : false;
$tbf_only         = ( isset( $settings['tbf_only'] )         ) ? $settings['tbf_only']         : false;
$ctbf_only        = ( isset( $settings['ctbf_only'] )        ) ? $settings['ctbf_only']        : false;
$has_template     = ( isset( $settings['has_template'] )     ) ? $settings['has_template']     : true;
$has_link_control = ( isset( $settings['has_link_control'] ) ) ? $settings['has_link_control'] : false;



// Groups
// =============================================================================

$group_anchor_customize     = $group . ':customize';
$group_anchor_design        = $group . ':design';
$group_anchor_graphic       = $group . ':graphic';
$group_anchor_particles     = $group . ':particles';
$group_anchor_setup         = $group . ':setup';
$group_anchor_sub_indicator = $group . ':sub_indicator';
$group_anchor_text          = $group . ':text';



// Conditions
// =============================================================================

$lr_only   = ( $lr_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) )                      : array();
$tb_only   = ( $tb_only )   ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom' ) )                      : array();
$tbf_only  = ( $tbf_only )  ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'top', 'bottom', 'footer' ) )            : array();
$ctbf_only = ( $ctbf_only ) ? array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) : array();

$conditions                       = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only ); // x_module_conditions( $condition )
$conditions_anchor_text           = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ) );
$conditions_anchor_primary_text   = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ), array( 'key' => $k_pre . 'anchor_text_primary_content', 'op' => 'NOT IN', 'value' => array( '' ) ) );
$conditions_anchor_secondary_text = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_text' => true ), array( 'key' => $k_pre . 'anchor_text_secondary_content', 'op' => 'NOT IN', 'value' => array( '' ) ) );
$conditions_anchor_sub_indicator  = array( $condition, $lr_only, $tb_only, $tbf_only, $ctbf_only, array( $k_pre . 'anchor_sub_indicator' => true ) );



// Options
// =============================================================================

$options_anchor_placeholder_no_output = array(
  'placeholder' => __( 'No Output When Empty', '__x__' ),
);

$options_anchor_text_spacing = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '5px',
);

$options_anchor_interactions = array(
  'choices' => array(
    array( 'value' => 'none',                  'label' => __( 'None', '__x__' )         ),
    array( 'value' => 'x-anchor-slide-top',    'label' => __( 'Slide Top', '__x__' )    ),
    array( 'value' => 'x-anchor-slide-left',   'label' => __( 'Slide Left', '__x__' )   ),
    array( 'value' => 'x-anchor-slide-right',  'label' => __( 'Slide Right', '__x__' )  ),
    array( 'value' => 'x-anchor-slide-bottom', 'label' => __( 'Slide Bottom', '__x__' ) ),
    array( 'value' => 'x-anchor-scale-up',     'label' => __( 'Scale Up', '__x__' )     ),
    array( 'value' => 'x-anchor-scale-down',   'label' => __( 'Scale Down', '__x__' )   ),
    array( 'value' => 'x-anchor-flip-x',       'label' => __( 'Flip X', '__x__' )       ),
    array( 'value' => 'x-anchor-flip-y',       'label' => __( 'Flip Y', '__x__' )       ),
  ),
);

$options_anchor_base_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'valid_keywords'  => array( 'calc' ),
  'fallback_value'  => '1em',
  'ranges'          => array(
    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
  ),
);

$options_anchor_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => 'auto',
  'valid_keywords'  => array( 'auto', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_anchor_min_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => '0px',
  'valid_keywords'  => array( 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_anchor_max_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
  'fallback_value'  => 'none',
  'valid_keywords'  => array( 'none', 'calc' ),
  'ranges'          => array(
    'px'  => array( 'min' => 50,  'max' => 200, 'step' => 1   ),
    'em'  => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    'rem' => array( 'min' => 2.5, 'max' => 15,  'step' => 0.1 ),
    '%'   => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vw'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
    'vh'  => array( 'min' => 25,  'max' => 100, 'step' => 1   ),
  ),
);

$options_anchor_sub_indicator_font_size = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '1em',
);

$options_anchor_sub_indicator_width_and_height = array(
  'available_units' => array( 'px', 'em', 'rem' ),
  'fallback_value'  => '1em',
  'valid_keywords'  => array( 'auto' ),
);



// Settings
// =============================================================================

$settings_anchor_link = array(
  'k_pre'     => $k_pre . 'anchor',
  't_pre'     => __( $t_pre, '__x__' ),
  'group'     => $is_adv ? $group_anchor_setup : $group_std_content,
  'condition' => $conditions,
  'info'      => true,
  'blank'     => true,
  'nofollow'  => true,
);

$settings_anchor_design = array(
  'k_pre'     => $k_pre . 'anchor',
  't_pre'     => __( $t_pre, '__x__' ),
  'group'     => $group_anchor_design,
  'condition' => $conditions,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_anchor_design_no_options = array(
  'k_pre'     => $k_pre . 'anchor',
  't_pre'     => __( $t_pre, '__x__' ),
  'group'     => $group_anchor_design,
  'condition' => $conditions,
);

$settings_anchor_flex_css = array(
  'k_pre'     => $k_pre . 'anchor',
  't_pre'     => __( $t_pre . ' Content', '__x__' ),
  'group'     => $group_anchor_design,
  'condition' => $conditions,
);

$settings_anchor_text_margin = array(
  'k_pre'     => $k_pre . 'anchor_text',
  't_pre'     => __( $t_pre . ' Text', '__x__' ),
  'group'     => $group_anchor_text,
  'condition' => $conditions_anchor_text,
);

$settings_anchor_primary_text = array(
  'k_pre'     => $k_pre . 'anchor_primary',
  't_pre'     => __( $t_pre . ' Primary', '__x__' ),
  'group'     => $group_anchor_text,
  'condition' => $conditions_anchor_text,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_anchor_secondary_text = array(
  'k_pre'     => $k_pre . 'anchor_secondary',
  't_pre'     => __( $t_pre . ' Secondary', '__x__' ),
  'group'     => $group_anchor_text,
  'condition' => $conditions_anchor_secondary_text,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_anchor_graphic_adv = array(
  'k_pre'               => $k_pre . 'anchor',
  'group'               => $group_anchor_graphic,
  'condition'           => $conditions,
  'has_alt'             => true,
  'has_interactions'    => true,
  'has_sourced_content' => false,
  'has_toggle'          => false,
  'adv'                 => true,
);

$settings_anchor_graphic_std_content = array(
  'k_pre'               => $k_pre . 'anchor',
  'group'               => $group_std_content,
  'condition'           => $conditions,
  'has_alt'             => true,
  'has_interactions'    => true,
  'has_sourced_content' => false,
  'has_toggle'          => false,
);

$settings_anchor_graphic_std_design = array(
  'k_pre'               => $k_pre . 'anchor',
  'group'               => $group_std_design,
  'condition'           => $conditions,
  'has_alt'             => true,
  'has_interactions'    => true,
  'has_sourced_content' => false,
  'has_toggle'          => false,
);

if ( ! $is_adv ) {
  $settings_anchor_graphic_adv['t_pre']         = $t_pre;
  $settings_anchor_graphic_std_content['t_pre'] = $t_pre;
  $settings_anchor_graphic_std_design['t_pre']  = $t_pre;
}

if ( $type === 'menu-item' ) {
  $settings_anchor_graphic_adv['has_sourced_content']         = true;
  $settings_anchor_graphic_std_content['has_sourced_content'] = true;
  $settings_anchor_graphic_std_design['has_sourced_content']  = true;
}

if ( $type === 'toggle' ) {
  $settings_anchor_graphic_adv['has_toggle']         = true;
  $settings_anchor_graphic_std_content['has_toggle'] = true;
  $settings_anchor_graphic_std_design['has_toggle']  = true;
}

$settings_anchor_sub_indicator_margin = array(
  'k_pre'     => $k_pre . 'anchor_sub_indicator',
  't_pre'     => __( $t_pre . ' Sub Indicator', '__x__' ),
  'group'     => $group_anchor_sub_indicator,
  'condition' => $conditions_anchor_sub_indicator,
);

$settings_anchor_sub_indicator_text_shadow = array(
  'k_pre'     => $k_pre . 'anchor_sub_indicator',
  't_pre'     => __( $t_pre . ' Sub Indicator', '__x__' ),
  'group'     => $group_anchor_sub_indicator,
  'condition' => $conditions_anchor_sub_indicator,
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels,
);

$settings_anchor_particle_primary = array(
  't_pre'     => __( 'Primary', '__x__' ),
  'k_pre'     => $k_pre . 'anchor_primary',
  'group'     => $group_anchor_particles,
  'condition' => $conditions,
);

$settings_anchor_particle_secondary = array(
  't_pre'     => __( 'Secondary', '__x__' ),
  'k_pre'     => $k_pre . 'anchor_secondary',
  'group'     => $group_anchor_particles,
  'condition' => $conditions,
);

$settings_anchor_std_design_border = array(
  'k_pre'     => $k_pre . 'anchor',
  't_pre'     => __( $t_pre . 'Base', '__x__' ),
  'group'     => $group_std_design,
  'condition' => array(
    $condition,
    array( 'key' => $k_pre . 'anchor_border_width', 'op' => 'NOT EMPTY' ),
    array( 'key' => $k_pre . 'anchor_border_style', 'op' => '!=', 'value' => 'none' ),
  ),
  'alt_color' => true,
  'options'   => $options_color_base_interaction_labels_color_only
);

$settings_anchor_std_design_margin = array(
  'k_pre'     => $k_pre . 'anchor',
  't_pre'     => __( $t_pre, '__x__' ),
  'group'     => $group_std_design,
  'condition' => $conditions,
);



// Individual Controls
// =============================================================================

$control_anchor_base_font_size = array(
  'key'     => $k_pre . 'anchor_base_font_size',
  'type'    => 'unit-slider',
  'label'   => __( 'Base Font Size', '__x__' ),
  'options' => $options_anchor_base_font_size,
);

$control_anchor_width = array(
  'key'     => $k_pre . 'anchor_width',
  'type'    => 'unit',
  'label'   => __( 'Width', '__x__' ),
  'options' => $options_anchor_width_and_height,
);

$control_anchor_height = array(
  'key'     => $k_pre . 'anchor_height',
  'type'    => 'unit',
  'label'   => __( 'Height', '__x__' ),
  'options' => $options_anchor_width_and_height,
);

$control_anchor_width_and_height = array(
  'type'     => 'group',
  'label'    => __( 'Width &amp; Height', '__x__' ),
  'controls' => array(
    $control_anchor_width,
    $control_anchor_height,
  ),
);

$control_anchor_min_width = array(
  'key'     => $k_pre . 'anchor_min_width',
  'type'    => 'unit',
  'label'   => __( 'Min Width', '__x__' ),
  'options' => $options_anchor_min_width_and_height,
);

$control_anchor_min_height = array(
  'key'     => $k_pre . 'anchor_min_height',
  'type'    => 'unit',
  'label'   => __( 'Min Height', '__x__' ),
  'options' => $options_anchor_min_width_and_height,
);

$control_anchor_min_width_and_height = array(
  'type'     => 'group',
  'label'    => __( 'Min Width &amp; Height', '__x__' ),
  'controls' => array(
    $control_anchor_min_width,
    $control_anchor_min_height,
  ),
);

$control_anchor_max_width = array(
  'key'     => $k_pre . 'anchor_max_width',
  'type'    => 'unit',
  'label'   => __( 'Max Width', '__x__' ),
  'options' => $options_anchor_max_width_and_height,
);

$control_anchor_max_height = array(
  'key'     => $k_pre . 'anchor_max_height',
  'type'    => 'unit',
  'label'   => __( 'Max Height', '__x__' ),
  'options' => $options_anchor_max_width_and_height,
);

$control_anchor_max_width_and_height = array(
  'type'     => 'group',
  'label'    => __( 'Max Width &amp; Height', '__x__' ),
  'controls' => array(
    $control_anchor_max_width,
    $control_anchor_max_height,
  ),
);

$control_anchor_bg_colors = array(
  'keys' => array(
    'value' => $k_pre . 'anchor_bg_color',
    'alt'   => $k_pre . 'anchor_bg_color_alt',
  ),
  'type'    => 'color',
  'label'   => __( 'Background', '__x__' ),
  'options' => $options_base_interaction_labels,
);

$control_anchor_link = x_control_link( $settings_anchor_link );

$control_anchor_text = array(
  'key'     => $k_pre . 'anchor_text',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_anchor_text_content_local_primary = array(
  'key'        => $k_pre . 'anchor_text_primary_content',
  'type'       => 'text',
  'label'      => __( 'Primary Text', '__x__' ),
  'conditions' => $conditions_anchor_text,
  'options'    => $options_anchor_placeholder_no_output,
);

$control_anchor_text_content_local_secondary = array(
  'key'        => $k_pre . 'anchor_text_secondary_content',
  'type'       => 'text',
  'label'      => __( 'Secondary Text', '__x__' ),
  'conditions' => $conditions_anchor_text,
  'options'    => $options_anchor_placeholder_no_output,
);

$control_anchor_text_content_sourced_primary = array(
  'key'        => $k_pre . 'anchor_text_primary_content',
  'type'       => 'choose',
  'label'      => __( 'Primary Text', '__x__' ),
  'conditions' => $conditions_anchor_text,
  'options'    => $options_choices_off_on_string,
);

$control_anchor_text_content_sourced_secondary = array(
  'key'        => $k_pre . 'anchor_text_secondary_content',
  'type'       => 'choose',
  'label'      => __( 'Secondary Text', '__x__' ),
  'conditions' => $conditions_anchor_text,
  'options'    => $options_choices_off_on_string,
);

$control_anchor_text_content_spacing_and_order = array(
  'type'       => 'group',
  'label'      => __( 'Spacing &amp; Order', '__x__' ),
  'conditions' => $conditions_anchor_secondary_text,
  'controls'   => array(
    array(
      'key'     => $k_pre . 'anchor_text_spacing',
      'type'    => 'unit',
      'label'   => __( 'Spacing', '__x__' ),
      'options' => $options_anchor_text_spacing,
    ),
    array(
      'keys' => array(
        'text_reverse' => $k_pre . 'anchor_text_reverse',
      ),
      'type'    => 'checkbox-list',
      'label'   => __( 'Order', '__x__' ),
      'options' => array(
        'list' => array(
          array( 'key' => 'text_reverse', 'label' => __( 'Reverse', '__x__' ) ),
        ),
      ),
    ),
  ),
);

$control_anchor_text_interaction = array(
  'key'     => $k_pre . 'anchor_text_interaction',
  'type'    => 'select',
  'options' => $options_anchor_interactions,
);

$control_anchor_text_overflow = array(
  'keys' => array(
    'text_overflow' => $k_pre . 'anchor_text_overflow',
  ),
  'type'    => 'checkbox-list',
  'options' => array(
    'list' => array(
      array( 'key' => 'text_overflow', 'label' => __( 'Hidden', '__x__' ) ),
    ),
  ),
);

$control_anchor_text_content_interaction_and_overflow = array(
  'type'       => 'group',
  'label'      => __( 'Interaction &amp; Overflow', '__x__' ),
  'conditions' => $conditions_anchor_text,
  'controls'   => array(
    $control_anchor_text_interaction,
    $control_anchor_text_overflow,
  ),
);

$control_anchor_sub_indicator = array(
  'key'     => $k_pre . 'anchor_sub_indicator',
  'type'    => 'choose',
  'label'   => __( 'Enable', '__x__' ),
  'options' => $options_choices_off_on_bool,
);

$control_anchor_sub_indicator_font_size = array(
  'key'        => $k_pre . 'anchor_sub_indicator_font_size',
  'type'       => 'unit-slider',
  'label'      => __( 'Font Size', '__x__' ),
  'conditions' => $conditions_anchor_sub_indicator,
  'options'    => $options_anchor_sub_indicator_font_size,
);

$control_anchor_sub_indicator_width = array(
  'key'     => $k_pre . 'anchor_sub_indicator_width',
  'type'    => 'unit',
  'options' => $options_anchor_sub_indicator_width_and_height,
);

$control_anchor_sub_indicator_height = array(
  'key'     => $k_pre . 'anchor_sub_indicator_height',
  'type'    => 'unit',
  'options' => $options_anchor_sub_indicator_width_and_height,
);

$control_anchor_sub_indicator_width_and_height = array(
  'type'       => 'group',
  'title'      => __( 'Width &amp; Height', '__x__' ),
  'conditions' => $conditions_anchor_sub_indicator,
  'controls'   => array(
    $control_anchor_sub_indicator_width,
    $control_anchor_sub_indicator_height,
  ),
);

$control_anchor_sub_indicator_icon = array(
  'key'        => $k_pre . 'anchor_sub_indicator_icon',
  'type'       => 'icon',
  'label'      => __( 'Icon', '__x__' ),
  'conditions' => $conditions_anchor_sub_indicator,
);

$control_anchor_sub_indicator_colors = array(
  'keys' => array(
    'value' => $k_pre . 'anchor_sub_indicator_color',
    'alt'   => $k_pre . 'anchor_sub_indicator_color_alt',
  ),
  'type'       => 'color',
  'label'      => __( 'Color', '__x__' ),
  'conditions' => $conditions_anchor_sub_indicator,
  'options'    => $options_base_interaction_labels,
);



// Control Lists
// =============================================================================

// Advanced Setup
// --------------

$control_list_anchor_adv_setup = array(
  $control_anchor_base_font_size,
  $control_anchor_width_and_height,
  $control_anchor_min_width_and_height,
  $control_anchor_max_width_and_height,
  $control_anchor_bg_colors,
);


// Advanced Text Setup
// -------------------

$control_list_anchor_adv_text_setup = array();

$control_list_anchor_adv_text_setup[] = $control_anchor_text;

if ( $type !== 'menu-item' ) {

  $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_local_primary;
  $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_local_secondary;

} else if ( $type === 'menu-item' ) {

  $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_sourced_primary;
  $control_list_anchor_adv_text_setup[] = $control_anchor_text_content_sourced_secondary;

}

$control_list_anchor_adv_text_setup[] = $control_anchor_text_content_spacing_and_order;
$control_list_anchor_adv_text_setup[] = $control_anchor_text_content_interaction_and_overflow;


// Advanced Sub Indicator Setup
// ----------------------------

$control_list_anchor_adv_sub_indicator_setup = array(
  $control_anchor_sub_indicator,
  $control_anchor_sub_indicator_font_size,
  $control_anchor_sub_indicator_width_and_height,
  $control_anchor_sub_indicator_icon,
  $control_anchor_sub_indicator_colors,
);


// Standard Content Setup
// ----------------------

$control_list_anchor_std_content_setup = array();

if ( $type !== 'menu-item' ) {

  $control_list_anchor_std_content_setup[] = $control_anchor_text_content_local_primary;
  $control_list_anchor_std_content_setup[] = $control_anchor_text_content_local_secondary;

} else if ( $type === 'menu-item' ) {

  $control_list_anchor_std_content_setup[] = $control_anchor_text_content_sourced_primary;
  $control_list_anchor_std_content_setup[] = $control_anchor_text_content_sourced_secondary;

}


// Standard Design Setup
// ---------------------

$control_list_anchor_std_design_setup = array(
  $control_anchor_base_font_size,
  $control_anchor_width_and_height,
  $control_anchor_max_width_and_height,
  array(
    'key'        => $k_pre . 'anchor_primary_text_align',
    'type'       => 'text-align',
    'label'      => __( 'Primary Text Align', '__x__' ),
    'conditions' => $conditions_anchor_primary_text,
  ),
);

if ( $has_template ) {
  $control_list_anchor_std_design_setup[] = array(
    'key'        => $k_pre . 'anchor_secondary_text_align',
    'type'       => 'text-align',
    'label'      => __( 'Secondary Text Align', '__x__' ),
    'conditions' => $conditions_anchor_secondary_text,
  );
}


// Standard Design Colors (Base)
// -----------------------------

$control_list_anchor_std_design_colors_base = array(
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_primary_text_color',
      'alt'   => $k_pre . 'anchor_primary_text_color_alt',
    ),
    'type'       => 'color',
    'label'      => __( 'Text', '__x__' ),
    'options'    => $options_base_interaction_labels,
    'conditions' => $conditions_anchor_text,
  ),
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_primary_text_shadow_color',
      'alt'   => $k_pre . 'anchor_primary_text_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Text<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array_merge(
      $conditions_anchor_text,
      array( 'key' => $k_pre . 'anchor_primary_text_shadow_dimensions', 'op' => 'NOT EMPTY' )
    ),
  ),
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_box_shadow_color',
      'alt'   => $k_pre . 'anchor_box_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Box<br>Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => $k_pre . 'anchor_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
  $control_anchor_bg_colors,
  array(
    'type'       => 'group',
    'label'      => __( 'Particles', '__x__' ),
    'conditions' => array( array( 'key' => $k_pre . 'anchor_primary_particle', 'value' => true ), array( 'key' => $k_pre . 'anchor_secondary_particle', 'value' => true, 'or' => true ) ),
    'controls'   => array(
      array(
        'keys'      => array( 'value' => $k_pre . 'anchor_primary_particle_color' ),
        'type'      => 'color',
        'label'     => __( 'Primary', '__x__' ),
        'options'   => array( 'label' => __( 'Primary', '__x__' ) ),
        'condition' => array( $k_pre . 'anchor_primary_particle' => true ),
      ),
      array(
        'keys'      => array( 'value' => $k_pre . 'anchor_secondary_particle_color' ),
        'type'      => 'color',
        'label'     => __( 'Secondary', '__x__' ),
        'options'   => array( 'label' => __( 'Secondary', '__x__' ) ),
        'condition' => array( $k_pre . 'anchor_secondary_particle' => true ),
      ),
    ),
  ),
);


// Standard Design Colors (Secondary)
// ----------------------------------

$control_list_anchor_std_design_colors_secondary = array(
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_secondary_text_color',
      'alt'   => $k_pre . 'anchor_secondary_text_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => $options_base_interaction_labels,
  ),
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_secondary_text_shadow_color',
      'alt'   => $k_pre . 'anchor_secondary_text_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Text Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => $k_pre . 'anchor_secondary_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);


// Standard Design Colors (Sub Indicator)
// --------------------------------------

$control_list_anchor_std_design_colors_sub_indicator = array(
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_sub_indicator_color',
      'alt'   => $k_pre . 'anchor_sub_indicator_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Text', '__x__' ),
    'options' => $options_base_interaction_labels,
  ),
  array(
    'keys' => array(
      'value' => $k_pre . 'anchor_sub_indicator_text_shadow_color',
      'alt'   => $k_pre . 'anchor_sub_indicator_text_shadow_color_alt',
    ),
    'type'      => 'color',
    'label'     => __( 'Text Shadow', '__x__' ),
    'options'   => $options_base_interaction_labels,
    'condition' => array( 'key' => $k_pre . 'anchor_sub_indicator_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
  ),
);



// Control Groups (Advanced)
// =============================================================================

$control_group_anchor_adv_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Setup', '__x__' ),
    'group'      => $group_anchor_setup,
    'conditions' => $conditions,
    'controls'   => $control_list_anchor_adv_setup,
  ),
);

$control_group_anchor_adv_text_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Text Setup', '__x__' ),
    'group'      => $group_anchor_text,
    'conditions' => $conditions,
    'controls'   => $control_list_anchor_adv_text_setup,
  ),
);

$control_group_anchor_adv_sub_indicator_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( $t_pre . ' Sub Indicator Setup', '__x__' ),
    'group'    => $group_anchor_sub_indicator,
    'controls' => $control_list_anchor_adv_sub_indicator_setup,
  ),
);



// Control Groups (Standard Content)
// =============================================================================

$control_group_anchor_std_content_setup = array(
  array(
    'type'       => 'group',
    'title'      => __( $t_pre . ' Content', '__x__' ),
    'group'      => $group_std_content,
    'conditions' => $conditions_anchor_text,
    'controls'   => $control_list_anchor_std_content_setup,
  ),
);



// Control Groups (Standard Design)
// =============================================================================

$control_group_anchor_std_design_setup = array(
  array(
    'type'     => 'group',
    'title'    => __( $t_pre . 'Design Setup', '__x__' ),
    'group'    => $group_std_design,
    'controls' => $control_list_anchor_std_design_setup,
  ),
);


// Conditional Secondary Text
// --------------------------
// Based on whether or not a template is used for the anchor.

$control_group_anchor_std_design_colors_secondary_text = array();

if ( $has_template ) {

  $control_group_anchor_std_design_colors_secondary_text = array(
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . 'Secondary Text Colors', '__x__' ),
      'group'      => $group_std_design,
      'controls'   => $control_list_anchor_std_design_colors_secondary,
      'conditions' => $conditions_anchor_secondary_text,
    ),
  );

}


// Colors Output
// -------------

$control_group_anchor_std_design_colors = array_merge(
  array(
    array(
      'type'     => 'group',
      'title'    => __( $t_pre . 'Base Colors', '__x__' ),
      'group'    => $group_std_design,
      'controls' => $control_list_anchor_std_design_colors_base,
    ),
  ),
  x_control_border( $settings_anchor_std_design_border ),
  $control_group_anchor_std_design_colors_secondary_text,
  array(
    array(
      'type'       => 'group',
      'title'      => __( $t_pre . 'Sub Indicator Colors', '__x__' ),
      'group'      => $group_std_design,
      'controls'   => $control_list_anchor_std_design_colors_sub_indicator,
      'conditions' => $conditions_anchor_sub_indicator,
    ),
  )
);