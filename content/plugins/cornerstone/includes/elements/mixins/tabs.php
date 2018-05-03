<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/TABS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Groups
//   03. Values
// =============================================================================

// Controls
// =============================================================================

function x_controls_tabs( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'tabs';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup          = $group . ':setup';
  $group_design         = $group . ':design';

  $group_tablist_setup  = $group . '_tablist:setup';
  $group_tablist_design = $group . '_tablist:design';

  $group_tabs_setup     = $group . '_tabs:setup';
  $group_tabs_design    = $group . '_tabs:design';
  $group_tabs_text      = $group . '_tabs:text';

  $group_panels_setup   = $group . '_panels:setup';
  $group_panels_design  = $group . '_panels:design';
  $group_panels_text    = $group . '_panels:text';


  // Setup - Conditions
  // ------------------

  $conditions = x_module_conditions( $condition );


  // Setup - Settings
  // ----------------

  $settings_tabs = array(
    'k_pre'     => 'tabs',
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_tablist = array(
    'k_pre'     => 'tabs_tablist',
    'group'     => $group_tablist_design,
    'condition' => $conditions,
  );

  $settings_tabs_tabs_design = array(
    'k_pre'     => 'tabs_tabs',
    'group'     => $group_tabs_design,
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
    'group'     => $group_tabs_text,
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
    'group'     => $group_panels_design,
    'condition' => $conditions,
  );

  $settings_tabs_panels_text = array(
    'k_pre'     => 'tabs_panels',
    'group'     => $group_panels_text,
    'condition' => $conditions,
  );


  // Setup - Options
  // ---------------

  $options_tabs_font_size = array(
    'available_units' => array( 'px', 'em', 'rem' ),
    'valid_keywords'  => array( 'calc' ),
    'fallback_value'  => '1em',
    'ranges'          => array(
      'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
      'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
    ),
  );


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'sortable',
        'title'      => __( 'Add Items', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'options'    => array(
          'element' => 'tab'
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'tabs_base_font_size',
            'type'    => 'slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_tabs_font_size,
          ),
          array(
            'key'     => 'tabs_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem', '%' ),
              'valid_keywords'  => array( 'auto', 'calc' ),
              'fallback_value'  => 'auto',
              'ranges'          => array(
                'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 10  ),
                'em'  => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
                'rem' => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
                '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
              ),
            ),
          ),
          array(
            'key'     => 'tabs_max_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Max Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem', '%' ),
              'valid_keywords'  => array( 'none', 'calc' ),
              'fallback_value'  => 'none',
              'ranges'          => array(
                'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 10  ),
                'em'  => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
                'rem' => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
                '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
              ),
            ),
          ),
          array(
            'key'   => 'tabs_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_tabs ),
    x_control_padding( $settings_tabs ),
    x_control_border( $settings_tabs ),
    x_control_border_radius( $settings_tabs ),
    x_control_box_shadow( $settings_tabs ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_tablist_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'tabs_tablist_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_tablist ),
    x_control_padding( $settings_tablist ),
    x_control_border( $settings_tablist ),
    x_control_border_radius( $settings_tablist ),
    x_control_box_shadow( $settings_tablist ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_tabs_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'tabs_tabs_justify_content',
            'type'    => 'select',
            'label'   => __( 'Justify Content', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )         ),
                array( 'value' => 'center',        'label' => __( 'Center', '__x__' )        ),
                array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )           ),
                array( 'value' => 'space-between', 'label' => __( 'Space Between', '__x__' ) ),
                array( 'value' => 'space-around',  'label' => __( 'Space Around', '__x__' )  ),
                array( 'value' => 'space-evenly',  'label' => __( 'Space Evenly', '__x__' )  ),
              ),
            ),
          ),
          array(
            'key'     => 'tabs_tabs_fill_space',
            'type'    => 'choose',
            'label'   => __( 'Fill Space', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => true,  'label' => __( 'On', '__x__' )  ),
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'tabs_tabs_min_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Min Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'fallback_value'  => '0px',
              'valid_keywords'  => array( 'calc' ),
              'ranges'          => array(
                'px'  => array( 'min' => 100, 'max' => 200, 'step' => 1   ),
                'em'  => array( 'min' => 5,   'max' => 10,  'step' => 0.1 ),
                'rem' => array( 'min' => 5,   'max' => 10,  'step' => 0.1 ),
              ),
            ),
          ),
          array(
            'key'     => 'tabs_tabs_max_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Max Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'fallback_value'  => 'none',
              'valid_keywords'  => array( 'none', 'calc' ),
              'ranges'          => array(
                'px'  => array( 'min' => 200, 'max' => 500, 'step' => 10  ),
                'em'  => array( 'min' => 10,  'max' => 20,  'step' => 0.5 ),
                'rem' => array( 'min' => 10,  'max' => 20,  'step' => 0.5 ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'tabs_tabs_bg_color',
              'alt'   => 'tabs_tabs_bg_color_alt',
            ),
            'type'    => 'color',
            'title'   => __( 'Background', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_tabs_tabs_design ),
    x_control_padding( $settings_tabs_tabs_design ),
    x_control_border( $settings_tabs_tabs_design ),
    x_control_border_radius( $settings_tabs_tabs_design ),
    x_control_box_shadow( $settings_tabs_tabs_design ),
    x_control_text_format( $settings_tabs_tabs_text ),
    x_control_text_style( $settings_tabs_tabs_text ),
    x_control_text_shadow( $settings_tabs_tabs_text ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_panels_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'tabs_panels_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_tabs_panels_design ),
    x_control_padding( $settings_tabs_panels_design ),
    x_control_border( $settings_tabs_panels_design ),
    x_control_border_radius( $settings_tabs_panels_design ),
    x_control_box_shadow( $settings_tabs_panels_design ),
    x_control_text_format( $settings_tabs_panels_text ),
    x_control_text_style( $settings_tabs_panels_text ),
    x_control_text_shadow( $settings_tabs_panels_text )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_tabs( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'tabs';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Tabs', '__x__' );

  $control_groups = array(

    $group                     => array( 'title' => $group_title ),
    $group . ':setup'          => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design'         => array( 'title' => __( 'Design', '__x__' ) ),

    $group . '_tablist'        => array( 'title' => __( 'Tablist', '__x__' ) ),
    $group . '_tablist:setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_tablist:design' => array( 'title' => __( 'Design', '__x__' ) ),

    $group . '_tabs'           => array( 'title' => __( 'Tabs', '__x__' ) ),
    $group . '_tabs:setup'     => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_tabs:design'    => array( 'title' => __( 'Design', '__x__' ) ),
    $group . '_tabs:text'      => array( 'title' => __( 'Text', '__x__' ) ),

    $group . '_panels'         => array( 'title' => __( 'Panels', '__x__' ) ),
    $group . '_panels:setup'   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_panels:design'  => array( 'title' => __( 'Design', '__x__' ) ),
    $group . '_panels:text'    => array( 'title' => __( 'Text', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_tabs( $settings = array() ) {

  // Values
  // ------

  $values = array(

    'tabs_base_font_size'                => x_module_value( '1em', 'style' ),
    'tabs_width'                         => x_module_value( '100%', 'style' ),
    'tabs_max_width'                     => x_module_value( 'none', 'style' ),
    'tabs_bg_color'                      => x_module_value( 'transparent', 'style:color' ),
    'tabs_margin'                        => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_padding'                       => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_border_width'                  => x_module_value( '0px', 'style' ),
    'tabs_border_style'                  => x_module_value( 'none', 'style' ),
    'tabs_border_color'                  => x_module_value( 'transparent', 'style:color' ),
    'tabs_border_radius'                 => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_box_shadow_dimensions'         => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_box_shadow_color'              => x_module_value( 'transparent', 'style:color' ),

    'tabs_tablist_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'tabs_tablist_margin'                => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_padding'               => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_border_width'          => x_module_value( '0px', 'style' ),
    'tabs_tablist_border_style'          => x_module_value( 'none', 'style' ),
    'tabs_tablist_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'tabs_tablist_border_radius'         => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_tablist_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

    'tabs_tabs_justify_content'          => x_module_value( 'flex-start', 'style' ),
    'tabs_tabs_fill_space'               => x_module_value( false, 'style' ),
    'tabs_tabs_min_width'                => x_module_value( '0px', 'style' ),
    'tabs_tabs_max_width'                => x_module_value( 'none', 'style' ),
    'tabs_tabs_bg_color'                 => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_bg_color_alt'             => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_margin'                   => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tabs_padding'                  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tabs_border_width'             => x_module_value( '0px', 'style' ),
    'tabs_tabs_border_style'             => x_module_value( 'none', 'style' ),
    'tabs_tabs_border_color'             => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_border_color_alt'         => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_border_radius'            => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_tabs_box_shadow_dimensions'    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tabs_box_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_box_shadow_color_alt'     => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_font_family'              => x_module_value( 'inherit', 'style:font-family' ),
    'tabs_tabs_font_weight'              => x_module_value( 'inherit:400', 'style:font-weight' ),
    'tabs_tabs_font_size'                => x_module_value( '1em', 'style' ),
    'tabs_tabs_letter_spacing'           => x_module_value( '0em', 'style' ),
    'tabs_tabs_line_height'              => x_module_value( '1', 'style' ),
    'tabs_tabs_font_style'               => x_module_value( 'normal', 'style' ),
    'tabs_tabs_text_align'               => x_module_value( 'none', 'style' ),
    'tabs_tabs_text_decoration'          => x_module_value( 'none', 'style' ),
    'tabs_tabs_text_transform'           => x_module_value( 'none', 'style' ),
    'tabs_tabs_text_color'               => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_tabs_text_color_alt'           => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'tabs_tabs_text_shadow_dimensions'   => x_module_value( '0px 0px 0px', 'style' ),
    'tabs_tabs_text_shadow_color'        => x_module_value( 'transparent', 'style:color' ),
    'tabs_tabs_text_shadow_color_alt'    => x_module_value( 'transparent', 'style:color' ),

    'tabs_panels_bg_color'               => x_module_value( 'transparent', 'style:color' ),
    'tabs_panels_margin'                 => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_panels_padding'                => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_panels_border_width'           => x_module_value( '0px', 'style' ),
    'tabs_panels_border_style'           => x_module_value( 'none', 'style' ),
    'tabs_panels_border_color'           => x_module_value( 'transparent', 'style:color' ),
    'tabs_panels_border_radius'          => x_module_value( '0px 0px 0px 0px', 'style' ),
    'tabs_panels_box_shadow_dimensions'  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'tabs_panels_box_shadow_color'       => x_module_value( 'transparent', 'style:color' ),
    'tabs_panels_font_family'            => x_module_value( 'inherit', 'style:font-family' ),
    'tabs_panels_font_weight'            => x_module_value( 'inherit:400', 'style:font-weight' ),
    'tabs_panels_font_size'              => x_module_value( '1em', 'style' ),
    'tabs_panels_letter_spacing'         => x_module_value( '0em', 'style' ),
    'tabs_panels_line_height'            => x_module_value( '1', 'style' ),
    'tabs_panels_font_style'             => x_module_value( 'normal', 'style' ),
    'tabs_panels_text_align'             => x_module_value( 'none', 'style' ),
    'tabs_panels_text_decoration'        => x_module_value( 'none', 'style' ),
    'tabs_panels_text_transform'         => x_module_value( 'none', 'style' ),
    'tabs_panels_text_color'             => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_panels_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'tabs_panels_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
