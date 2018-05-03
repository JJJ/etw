<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/BREADCRUMBS.PHP
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

function x_controls_breadcrumbs( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'breadcrumbs';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup     = $group . ':setup';
  $group_design    = $group . ':design';
  $group_delimiter = $group . ':delimiter';
  $group_links     = $group . ':links';


  // Setup - Conditions
  // ------------------

  $conditions                 = x_module_conditions( $condition );
  $conditions_home_label_text = array_merge( $condition, array( array( 'breadcrumbs_home_label_type' => 'text' ) ) );
  $conditions_home_label_icon = array_merge( $condition, array( array( 'breadcrumbs_home_label_type' => 'icon' ) ) );
  $conditions_delimimter      = array_merge( $condition, array( array( 'breadcrumbs_delimiter' => true ) ) );
  $conditions_delimimter_text = array_merge( $condition, array( array( 'breadcrumbs_delimiter' => true ), array( 'breadcrumbs_delimiter_type' => 'text' ) ) );
  $conditions_delimimter_icon = array_merge( $condition, array( array( 'breadcrumbs_delimiter' => true ), array( 'breadcrumbs_delimiter_type' => 'icon' ) ) );


  // Setup - Settings
  // ----------------

  $settings_breadcrumbs_setup = array(
    'k_pre'     => 'breadcrumbs',
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_breadcrumbs_setup_no_letter_spacing = array(
    'k_pre'             => 'breadcrumbs',
    'group'             => $group_design,
    'condition'         => $conditions,
    'no_letter_spacing' => true,
  );

  $settings_breadcrumbs_links = array(
    'k_pre'     => 'breadcrumbs_links',
    't_pre'     => __( 'Links', '__x__' ),
    'group'     => $group_links,
    'condition' => $conditions,
  );

  $settings_breadcrumbs_links_color = array(
    'k_pre'     => 'breadcrumbs_links',
    't_pre'     => __( 'Links', '__x__' ),
    'group'     => $group_links,
    'condition' => $conditions,
    'alt_color' => true,
    'options'   => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );


  // Returned Value
  // --------------

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'breadcrumbs_home_label_type',
            'type'    => 'choose',
            'label'   => __( 'Home Label Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
                array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'        => 'breadcrumbs_home_label_text',
            'type'       => 'text',
            'label'      => __( 'Home Label', '__x__' ),
            'conditions' => $conditions_home_label_text,
          ),
          array(
            'key'        => 'breadcrumbs_home_label_icon',
            'type'       => 'icon',
            'label'      => __( 'Home Label', '__x__' ),
            'conditions' => $conditions_home_label_icon,
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Width &amp; Max Width', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'breadcrumbs_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'auto' ),
                  'fallback_value'  => 'auto',
                ),
              ),
              array(
                'key'     => 'breadcrumbs_max_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'none' ),
                  'fallback_value'  => 'none',
                ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Justification &amp; Direction', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'breadcrumbs_flex_justify',
                'type'    => 'select',
                'options' => array(
                  'choices' => array(
                    array( 'value' => 'flex-start', 'label' => __( 'Initial', '__x__' )  ),
                    array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
                  ),
                ),
              ),
              array(
                'keys' => array(
                  'reverse' => 'breadcrumbs_reverse',
                ),
                'type'    => 'checkbox-list',
                'options' => array(
                  'list' => array(
                    array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'key'   => 'breadcrumbs_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_text_format( $settings_breadcrumbs_setup_no_letter_spacing ),
    x_control_margin( $settings_breadcrumbs_setup ),
    x_control_padding( $settings_breadcrumbs_setup ),
    x_control_border( $settings_breadcrumbs_setup ),
    x_control_border_radius( $settings_breadcrumbs_setup ),
    x_control_box_shadow( $settings_breadcrumbs_setup ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Delimiter Setup', '__x__' ),
        'group'      => $group_delimiter,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'breadcrumbs_delimiter',
            'type'    => 'choose',
            'label'   => __( 'Enable', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'breadcrumbs_delimiter_type',
            'type'    => 'choose',
            'label'   => __( 'Delimiter Type', '__x__' ),
            'conditions' => $conditions_delimimter,
            'options' => array(
              'choices' => array(
                array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
                array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'       => 'group',
            'label'      => __( 'LTR &amp; RTL Delimiter', '__x__' ),
            'conditions' => $conditions_delimimter_text,
            'controls'   => array(
              array(
                'key'  => 'breadcrumbs_delimiter_ltr_text',
                'type' => 'text',
              ),
              array(
                'key'  => 'breadcrumbs_delimiter_rtl_text',
                'type' => 'text',
              ),
            ),
          ),
          array(
            'type'       => 'group',
            'label'      => __( 'LTR &amp; RTL Delimiter', '__x__' ),
            'conditions' => $conditions_delimimter_icon,
            'controls'   => array(
              array(
                'key'     => 'breadcrumbs_delimiter_ltr_icon',
                'type'    => 'icon',
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
              array(
                'key'     => 'breadcrumbs_delimiter_rtl_icon',
                'type'    => 'icon',
                'options' => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
            ),
          ),
          array(
            'key'        => 'breadcrumbs_delimiter_spacing',
            'type'       => 'unit-slider',
            'title'      => __( 'Spacing', '__x__' ),
            'conditions' => $conditions_delimimter,
            'options'    => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'fallback_value'  => '8px',
              'ranges'          => array(
                'px'  => array( 'min' => 0, 'max' => 20,   'step' => 1 ),
                'em'  => array( 'min' => 0, 'max' => 0.75, 'step' => 0.05 ),
                'rem' => array( 'min' => 0, 'max' => 0.75, 'step' => 0.05 ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'breadcrumbs_delimiter_color',
            ),
            'type'       => 'color',
            'label'      => __( 'Color', '__x__' ),
            'conditions' => $conditions_delimimter,
          ),
        ),
      ),
    ),
    x_control_text_shadow( array( 'k_pre' => 'breadcrumbs_delimiter', 't_pre' => __( 'Delimiter', '__x__' ), 'group' => $group_delimiter, 'condition' => $conditions_delimimter ) ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Links Setup', '__x__' ),
        'group'      => $group_links,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'breadcrumbs_links_base_font_size',
            'type'    => 'unit-slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => array(
              'available_units' => array( 'em' ),
              'valid_keywords'  => array( 'calc' ),
              'ranges'          => array(
                'em' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.05 ),
              ),
            ),
          ),
          array(
            'key'     => 'breadcrumbs_links_min_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Min Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'em' ),
              'valid_keywords'  => array( 'calc' ),
              'fallback_value'  => '0em',
              'ranges'          => array(
                'em' => array( 'min' => 2.5, 'max' => 10, 'step' => 0.1 ),
              ),
            ),
          ),
          array(
            'key'     => 'breadcrumbs_links_max_width',
            'type'    => 'unit-slider',
            'label'   => __( 'Max Width', '__x__' ),
            'options' => array(
              'available_units' => array( 'em' ),
              'valid_keywords'  => array( 'none', 'calc' ),
              'fallback_value'  => 'none',
              'ranges'          => array(
                'em' => array( 'min' => 2.5, 'max' => 10, 'step' => 0.1 ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'breadcrumbs_links_color',
              'alt'   => 'breadcrumbs_links_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Color', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'breadcrumbs_links_bg_color',
              'alt'   => 'breadcrumbs_links_bg_color_alt',
            ),
            'type'    => 'color',
            'label'   => __( 'Background', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Links Text Style &amp; Format', '__x__' ),
        'group'      => $group_links,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'breadcrumbs_links_font_style',
            'type'  => 'font-style',
            'label' => __( 'Font Style', '__x__' ),
          ),
          array(
            'key'   => 'breadcrumbs_links_text_align',
            'type'  => 'text-align',
            'label' => __( 'Text Align', '__x__' ),
          ),
          array(
            'key'   => 'breadcrumbs_links_text_transform',
            'type'  => 'text-transform',
            'label' => __( 'Text Transform', '__x__' ),
          ),
          array(
            'key'     => 'breadcrumbs_links_letter_spacing',
            'type'    => 'unit-slider',
            'label'   => __( 'Letter Spacing', '__x__' ),
            'options' => array(
              'available_units' => array( 'em' ),
              'ranges'          => array(
                'em' => array( 'min' => -0.15, 'max' => 0.5, 'step' => 0.01 ),
              ),
            ),
          ),
          array(
            'key'     => 'breadcrumbs_links_line_height',
            'type'    => 'unit-slider',
            'label'   => __( 'Line Height', '__x__' ),
            'options' => array(
              'unit_mode' => 'unitless',
              'min'       => 1,
              'max'       => 2.5,
              'step'      => 0.1,
            ),
          ),
        ),
      ),
    ),
    x_control_text_shadow( $settings_breadcrumbs_links_color ),
    x_control_margin( $settings_breadcrumbs_links ),
    x_control_padding( $settings_breadcrumbs_links ),
    x_control_border( $settings_breadcrumbs_links_color ),
    x_control_border_radius( $settings_breadcrumbs_links ),
    x_control_box_shadow( $settings_breadcrumbs_links_color )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_breadcrumbs( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'breadcrumbs';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Breadcrumbs', '__x__' );

  $control_groups = array(
    $group                => array( 'title' => $group_title ),
    $group . ':setup'     => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design'    => array( 'title' => __( 'Design', '__x__' ) ),
    $group . ':delimiter' => array( 'title' => __( 'Delimiter', '__x__' ) ),
    $group . ':links'     => array( 'title' => __( 'Links', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_breadcrumbs( $settings = array() ) {

  // Values
  // ------

  $values = array(
    'breadcrumbs_home_label_type'                  => x_module_value( 'text', 'markup' ),
    'breadcrumbs_home_label_text'                  => x_module_value( __( 'Home', '__x__' ), 'markup', true ),
    'breadcrumbs_home_label_icon'                  => x_module_value( 'home', 'markup', true ),
    'breadcrumbs_width'                            => x_module_value( 'auto', 'style' ),
    'breadcrumbs_max_width'                        => x_module_value( 'none', 'style' ),
    'breadcrumbs_flex_justify'                     => x_module_value( 'flex-start', 'style' ),
    'breadcrumbs_reverse'                          => x_module_value( false, 'style' ),
    'breadcrumbs_bg_color'                         => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_font_family'                      => x_module_value( 'inherit', 'style:font-family' ),
    'breadcrumbs_font_weight'                      => x_module_value( 'inherit:400', 'style:font-weight' ),
    'breadcrumbs_font_size'                        => x_module_value( '1em', 'style' ),
    'breadcrumbs_line_height'                      => x_module_value( '1.4', 'style' ),
    'breadcrumbs_margin'                           => x_module_value( '0em', 'style' ),
    'breadcrumbs_padding'                          => x_module_value( '0em', 'style' ),
    'breadcrumbs_border_width'                     => x_module_value( '0px', 'style' ),
    'breadcrumbs_border_style'                     => x_module_value( 'none', 'style' ),
    'breadcrumbs_border_color'                     => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_border_radius'                    => x_module_value( '0em', 'style' ),
    'breadcrumbs_box_shadow_dimensions'            => x_module_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_box_shadow_color'                 => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_delimiter'                        => x_module_value( true, 'all' ),
    'breadcrumbs_delimiter_type'                   => x_module_value( 'text', 'markup' ),
    'breadcrumbs_delimiter_ltr_text'               => x_module_value( '&rarr;', 'markup' ),
    'breadcrumbs_delimiter_rtl_text'               => x_module_value( '&larr;', 'markup' ),
    'breadcrumbs_delimiter_ltr_icon'               => x_module_value( 'angle-right', 'markup' ),
    'breadcrumbs_delimiter_rtl_icon'               => x_module_value( 'angle-left', 'markup' ),
    'breadcrumbs_delimiter_spacing'                => x_module_value( '8px', 'style' ),
    'breadcrumbs_delimiter_color'                  => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_delimiter_text_shadow_dimensions' => x_module_value( '0px 0px 0px', 'style' ),
    'breadcrumbs_delimiter_text_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_base_font_size'             => x_module_value( '1em', 'style' ),
    'breadcrumbs_links_min_width'                  => x_module_value( '0em', 'style' ),
    'breadcrumbs_links_max_width'                  => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_color'                      => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'breadcrumbs_links_color_alt'                  => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'breadcrumbs_links_bg_color'                   => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_bg_color_alt'               => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_font_style'                 => x_module_value( 'normal', 'style' ),
    'breadcrumbs_links_text_align'                 => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_text_transform'             => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_letter_spacing'             => x_module_value( '0em', 'style' ),
    'breadcrumbs_links_line_height'                => x_module_value( '1.3', 'style' ),
    'breadcrumbs_links_text_shadow_dimensions'     => x_module_value( '0px 0px 0px', 'style' ),
    'breadcrumbs_links_text_shadow_color'          => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_text_shadow_color_alt'      => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_margin'                     => x_module_value( '0px 0px 0px 0px', 'style' ),
    'breadcrumbs_links_padding'                    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_links_border_width'               => x_module_value( '0px', 'style' ),
    'breadcrumbs_links_border_style'               => x_module_value( 'none', 'style' ),
    'breadcrumbs_links_border_color'               => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_color_alt'           => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_border_radius'              => x_module_value( '0em', 'style' ),
    'breadcrumbs_links_box_shadow_dimensions'      => x_module_value( '0em 0em 0em 0em', 'style' ),
    'breadcrumbs_links_box_shadow_color'           => x_module_value( 'transparent', 'style:color' ),
    'breadcrumbs_links_box_shadow_color_alt'       => x_module_value( 'transparent', 'style:color' ),
  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
