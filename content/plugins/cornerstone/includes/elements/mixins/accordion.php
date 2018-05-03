<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/ACCORDION.PHP
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

function x_controls_accordion( $settings = array() ) {

  // Setup
  // -----

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'accordion';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();

  $group_setup               = $group . ':setup';
  $group_design              = $group . ':design';

  $group_items_setup         = $group . '_items:setup';
  $group_items_design        = $group . '_items:design';

  $group_item_header_setup   = $group . '_item_header:setup';
  $group_item_header_design  = $group . '_item_header:design';
  $group_item_header_text    = $group . '_item_header:text';

  $group_item_content_setup  = $group . '_item_content:setup';
  $group_item_content_design = $group . '_item_content:design';
  $group_item_content_text   = $group . '_item_content:text';


  // Setup - Conditions
  // ------------------

  $conditions                  = x_module_conditions( $condition );
  $conditions_header_indicator = array( $condition, array( 'accordion_header_indicator' => true ) );


  // Setup - Settings
  // ----------------

  $settings_accordion = array(
    'k_pre'     => 'accordion',
    'group'     => $group_design,
    'condition' => $conditions,
  );

  $settings_accordion_item_design = array(
    'k_pre'     => 'accordion_item',
    't_pre'     => __( 'Item', '__x__' ),
    'group'     => $group_items_design,
    'condition' => $conditions,
  );

  $settings_accordion_header_design = array(
    'k_pre'     => 'accordion_header',
    't_pre'     => __( 'Header', '__x__' ),
    'group'     => $group_item_header_design,
    'condition' => $conditions,
    'alt_color' => true,
    'options'   => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_accordion_header_text = array(
    'k_pre'     => 'accordion_header',
    't_pre'     => __( 'Header', '__x__' ),
    'group'     => $group_item_header_text,
    'condition' => $conditions,
    'alt_color' => true,
    'options'   => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_accordion_content_design = array(
    'k_pre'     => 'accordion_content',
    't_pre'     => __( 'Content', '__x__' ),
    'group'     => $group_item_content_design,
    'condition' => $conditions,
  );

  $settings_accordion_content_text = array(
    'k_pre'     => 'accordion_content',
    't_pre'     => __( 'Content', '__x__' ),
    'group'     => $group_item_content_text,
    'condition' => $conditions,
  );


  // Setup - Options
  // ---------------

  $options_accordion_font_size = array(
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
          'element'   => 'accordion-item',
          'label_key' => 'accordion_item_header_content'
        ),
      ),
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $group_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'accordion_base_font_size',
            'type'    => 'slider',
            'label'   => __( 'Base Font Size', '__x__' ),
            'options' => $options_accordion_font_size,
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Width &amp; Max Width', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'accordion_width',
                'type'    => 'unit',
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem', '%' ),
                  'valid_keywords'  => array( 'auto' ),
                  'fallback_value'  => 'auto',
                ),
              ),
              array(
                'key'     => 'accordion_max_width',
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
            'key'     => 'accordion_grouped',
            'type'    => 'choose',
            'label'   => __( 'Enable Grouping', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'       => 'accordion_group',
            'type'      => 'text',
            'label'     => __( 'Custom Group', '__x__' ),
            'condition' => array( 'accordion_grouped' => true ),
          ),
          array(
            'key'   => 'accordion_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_accordion ),
    x_control_padding( $settings_accordion ),
    x_control_border( $settings_accordion ),
    x_control_border_radius( $settings_accordion ),
    x_control_box_shadow( $settings_accordion ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Item Setup', '__x__' ),
        'group'      => $group_items_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'accordion_item_overflow',
            'type'    => 'choose',
            'label'   => __( 'Overflow', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'accordion_item_spacing',
            'type'    => 'unit-slider',
            'label'   => __( 'Spacing', '__x__' ),
            'options' => array(
              'available_units' => array( 'px', 'em', 'rem' ),
              'valid_keywords'  => array( 'calc' ),
              'fallback_value'  => '1em',
              'ranges'          => array(
                'px'  => array( 'min' => 0, 'max' => 25, 'step' => 1   ),
                'em'  => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
                'rem' => array( 'min' => 0, 'max' => 1,  'step' => 0.1 ),
              ),
            ),
          ),
          array(
            'key'   => 'accordion_item_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_padding( $settings_accordion_item_design ),
    x_control_border( $settings_accordion_item_design ),
    x_control_border_radius( $settings_accordion_item_design ),
    x_control_box_shadow( $settings_accordion_item_design ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Header Setup', '__x__' ),
        'group'      => $group_item_header_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'accordion_header_text_overflow',
            'type'    => 'choose',
            'label'   => __( 'Overflow', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'     => 'accordion_header_indicator',
            'type'    => 'choose',
            'label'   => __( 'Indicator', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
                array( 'value' => true,  'label' => __( 'On', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'      => 'group',
            'label'     => __( 'Spacing &amp; Direction', '__x__' ),
            'condition' => array( 'accordion_header_indicator' => true ),
            'controls'  => array(
              array(
                'key'     => 'accordion_header_content_spacing',
                'type'    => 'unit',
                'label'   => __( 'Indicator Spacing', '__x__' ),
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'valid_keywords'  => array( 'calc' ),
                  'fallback_value'  => '1em',
                ),
              ),
              array(
                'keys' => array(
                  'reverse' => 'accordion_header_content_reverse',
                ),
                'type'    => 'checkbox-list',
                'label'   => __( 'Indicator Reverse', '__x__' ),
                'options' => array(
                  'list' => array(
                    array( 'key' => 'reverse', 'label' => __( 'Reverse', '__x__' ) ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'accordion_header_bg_color',
              'alt'   => 'accordion_header_bg_color_alt',
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
      array(
        'type'       => 'group',
        'title'      => __( 'Header Indicator Setup', '__x__' ),
        'group'      => $group_item_header_setup,
        'conditions' => $conditions_header_indicator,
        'controls'   => array(
          array(
            'key'     => 'accordion_header_indicator_type',
            'type'    => 'choose',
            'label'   => __( 'Type', '__x__' ),
            'options' => array(
              'choices' => array(
                array( 'value' => 'text', 'label' => __( 'Text', '__x__' ) ),
                array( 'value' => 'icon', 'label' => __( 'Icon', '__x__' ) ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Indicator &amp; Font Size', '__x__' ),
            'controls' => array(
              array(
                'key'       => 'accordion_header_indicator_text',
                'type'      => 'text',
                'label'     => __( 'Indicator', '__x__' ),
                'condition' => array( 'accordion_header_indicator_type' => 'text' ),
              ),
              array(
                'key'       => 'accordion_header_indicator_icon',
                'type'      => 'icon',
                'label'     => __( 'Indicator', '__x__' ),
                'condition' => array( 'accordion_header_indicator_type' => 'icon' ),
                'options'   => array(
                  'label' => __( 'Select', '__x__' ),
                ),
              ),
              array(
                'key'     => 'accordion_header_indicator_font_size',
                'type'    => 'unit',
                'label'   => __( 'Font Size', '__x__' ),
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'valid_keywords'  => array( 'calc' ),
                  'fallback_value'  => '1em',
                  'ranges'          => array(
                    'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
                    'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.25 ),
                    'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.25 ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Width &amp; Height', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'accordion_header_indicator_width',
                'type'    => 'unit',
                'label'   => __( 'Width', '__x__' ),
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'valid_keywords'  => array( 'auto', 'calc' ),
                  'fallback_value'  => 'auto',
                  'ranges'          => array(
                    'px'  => array( 'min' => 10,  'max' => 40,  'step' => 1    ),
                    'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
                    'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
                  ),
                ),
              ),
              array(
                'key'     => 'accordion_header_indicator_height',
                'type'    => 'unit',
                'label'   => __( 'Height', '__x__' ),
                'options' => array(
                  'available_units' => array( 'px', 'em', 'rem' ),
                  'valid_keywords'  => array( 'calc' ),
                  'fallback_value'  => '1em',
                  'ranges'          => array(
                    'px'  => array( 'min' => 10,  'max' => 40,  'step' => 1    ),
                    'em'  => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
                    'rem' => array( 'min' => 0.5, 'max' => 2.5, 'step' => 0.25 ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'type'     => 'group',
            'label'    => __( 'Start &amp; End Rotation', '__x__' ),
            'controls' => array(
              array(
                'key'     => 'accordion_header_indicator_rotation_start',
                'type'    => 'unit',
                'label'   => __( 'Starting Rotation', '__x__' ),
                'options' => array(
                  'unit_mode'       => 'angle',
                  'available_units' => array( 'deg' ),
                  'fallback_value'  => '0deg',
                  'ranges'          => array(
                    'deg'  => array( 'min' => 0, 'max' => 360, 'step' => 1 ),
                  ),
                ),
              ),
              array(
                'key'     => 'accordion_header_indicator_rotation_end',
                'type'    => 'unit',
                'label'   => __( 'Ending Rotation', '__x__' ),
                'options' => array(
                  'unit_mode'       => 'angle',
                  'available_units' => array( 'deg' ),
                  'fallback_value'  => '0deg',
                  'ranges'          => array(
                    'deg'  => array( 'min' => 0, 'max' => 360, 'step' => 1 ),
                  ),
                ),
              ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'accordion_header_indicator_color',
              'alt'   => 'accordion_header_indicator_color_alt',
            ),
            'type'    => 'color',
            'title'   => __( 'Color', '__x__' ),
            'options' => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_accordion_header_design ),
    x_control_padding( $settings_accordion_header_design ),
    x_control_border( $settings_accordion_header_design ),
    x_control_border_radius( $settings_accordion_header_design ),
    x_control_box_shadow( $settings_accordion_header_design ),
    x_control_text_format( $settings_accordion_header_text ),
    x_control_text_style( $settings_accordion_header_text ),
    x_control_text_shadow( $settings_accordion_header_text ),
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Content Setup', '__x__' ),
        'group'      => $group_item_content_setup,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'   => 'accordion_content_bg_color',
            'type'  => 'color',
            'title' => __( 'Background', '__x__' ),
          ),
        ),
      ),
    ),
    x_control_margin( $settings_accordion_content_design ),
    x_control_padding( $settings_accordion_content_design ),
    x_control_border( $settings_accordion_content_design ),
    x_control_border_radius( $settings_accordion_content_design ),
    x_control_box_shadow( $settings_accordion_content_text ),
    x_control_text_format( $settings_accordion_content_text ),
    x_control_text_style( $settings_accordion_content_text ),
    x_control_text_shadow( $settings_accordion_content_text )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_accordion( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'accordion';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Accordion', '__x__' );

  $control_groups = array(

    $group                          => array( 'title' => $group_title ),
    $group . ':setup'               => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design'              => array( 'title' => __( 'Design', '__x__' ) ),

    $group . '_items'               => array( 'title' => __( 'Items', '__x__' ) ),
    $group . '_items:setup'         => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_items:design'        => array( 'title' => __( 'Design', '__x__' ) ),

    $group . '_item_header'         => array( 'title' => __( 'Header', '__x__' ) ),
    $group . '_item_header:setup'   => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_item_header:design'  => array( 'title' => __( 'Design', '__x__' ) ),
    $group . '_item_header:text'    => array( 'title' => __( 'Text', '__x__' ) ),

    $group . '_item_content'        => array( 'title' => __( 'Content', '__x__' ) ),
    $group . '_item_content:setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . '_item_content:design' => array( 'title' => __( 'Design', '__x__' ) ),
    $group . '_item_content:text'   => array( 'title' => __( 'Text', '__x__' ) ),

  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_accordion( $settings = array() ) {

  // Values
  // ------

  $values = array(

    'accordion_base_font_size'                  => x_module_value( '1em', 'style' ),
    'accordion_width'                           => x_module_value( '100%', 'style' ),
    'accordion_max_width'                       => x_module_value( 'none', 'style' ),
    'accordion_grouped'                         => x_module_value( false, 'markup' ),
    'accordion_group'                           => x_module_value( '', 'markup' ),
    'accordion_bg_color'                        => x_module_value( 'transparent', 'style:color' ),

    'accordion_margin'                          => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_padding'                         => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_border_width'                    => x_module_value( '0px', 'style' ),
    'accordion_border_style'                    => x_module_value( 'none', 'style' ),
    'accordion_border_color'                    => x_module_value( 'transparent', 'style:color' ),
    'accordion_border_radius'                   => x_module_value( '0px 0px 0px 0px', 'style' ),
    'accordion_box_shadow_dimensions'           => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_box_shadow_color'                => x_module_value( 'transparent', 'style:color' ),

    'accordion_item_overflow'                   => x_module_value( true, 'style' ),
    'accordion_item_spacing'                    => x_module_value( '25px', 'style' ),
    'accordion_item_bg_color'                   => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_item_padding'                    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_item_border_width'               => x_module_value( '0px', 'style' ),
    'accordion_item_border_style'               => x_module_value( 'none', 'style' ),
    'accordion_item_border_color'               => x_module_value( 'transparent', 'style:color' ),
    'accordion_item_border_radius'              => x_module_value( '0.35em 0.35em 0.35em 0.35em', 'style' ),
    'accordion_item_box_shadow_dimensions'      => x_module_value( '0em 0.15em 0.65em 0em', 'style' ),
    'accordion_item_box_shadow_color'           => x_module_value( 'rgba(0, 0, 0, 0.25)', 'style:color' ),

    'accordion_header_text_overflow'            => x_module_value( false, 'style' ),
    'accordion_header_indicator'                => x_module_value( true, 'all' ),
    'accordion_header_content_spacing'          => x_module_value( '0.5em', 'style' ),
    'accordion_header_content_reverse'          => x_module_value( false, 'all' ),
    'accordion_header_bg_color'                 => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'accordion_header_bg_color_alt'             => x_module_value( 'rgba(255, 255, 255, 1)', 'style:color' ),

    'accordion_header_indicator_type'           => x_module_value( 'text', 'markup' ),
    'accordion_header_indicator_text'           => x_module_value( '&#x25b8;', 'attr:html' ),
    'accordion_header_indicator_icon'           => x_module_value( 'caret-right', 'markup' ),
    'accordion_header_indicator_font_size'      => x_module_value( '1em', 'style' ),
    'accordion_header_indicator_width'          => x_module_value( 'auto', 'style' ),
    'accordion_header_indicator_height'         => x_module_value( '1em', 'style' ),
    'accordion_header_indicator_rotation_start' => x_module_value( '0deg', 'style' ),
    'accordion_header_indicator_rotation_end'   => x_module_value( '90deg', 'style' ),
    'accordion_header_indicator_color'          => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_indicator_color_alt'      => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),

    'accordion_header_margin'                   => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_header_padding'                  => x_module_value( '15px 20px 15px 20px', 'style' ),
    'accordion_header_border_width'             => x_module_value( '0px', 'style' ),
    'accordion_header_border_style'             => x_module_value( 'none', 'style' ),
    'accordion_header_border_color'             => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_border_color_alt'         => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_border_radius'            => x_module_value( '0px 0px 0px 0px', 'style' ),
    'accordion_header_box_shadow_dimensions'    => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_header_box_shadow_color'         => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_box_shadow_color_alt'     => x_module_value( 'transparent', 'style:color' ),

    'accordion_header_font_family'              => x_module_value( 'inherit', 'style:font-family' ),
    'accordion_header_font_weight'              => x_module_value( 'inherit:400', 'style:font-weight' ),
    'accordion_header_font_size'                => x_module_value( '1em', 'style' ),
    'accordion_header_letter_spacing'           => x_module_value( '0em', 'style' ),
    'accordion_header_line_height'              => x_module_value( '1.3', 'style' ),
    'accordion_header_font_style'               => x_module_value( 'normal', 'style' ),
    'accordion_header_text_align'               => x_module_value( 'left', 'style' ),
    'accordion_header_text_decoration'          => x_module_value( 'none', 'style' ),
    'accordion_header_text_transform'           => x_module_value( 'none', 'style' ),
    'accordion_header_text_color'               => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_header_text_color_alt'           => x_module_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'accordion_header_text_shadow_dimensions'   => x_module_value( '0px 0px 0px', 'style' ),
    'accordion_header_text_shadow_color'        => x_module_value( 'transparent', 'style:color' ),
    'accordion_header_text_shadow_color_alt'    => x_module_value( 'transparent', 'style:color' ),

    'accordion_content_bg_color'                => x_module_value( 'transparent', 'style:color' ),

    'accordion_content_margin'                  => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_content_padding'                 => x_module_value( '20px 20px 20px 20px', 'style' ),
    'accordion_content_border_width'            => x_module_value( '1px 0 0 0', 'style' ),
    'accordion_content_border_style'            => x_module_value( 'solid', 'style' ),
    'accordion_content_border_color'            => x_module_value( 'rgba(225, 225, 225, 1) transparent transparent transparent', 'style' ),
    'accordion_content_border_radius'           => x_module_value( '0px 0px 0px 0px', 'style' ),
    'accordion_content_box_shadow_dimensions'   => x_module_value( '0em 0em 0em 0em', 'style' ),
    'accordion_content_box_shadow_color'        => x_module_value( 'transparent', 'style:color' ),

    'accordion_content_font_family'             => x_module_value( 'inherit', 'style:font-family' ),
    'accordion_content_font_weight'             => x_module_value( 'inherit:400', 'style:font-weight' ),
    'accordion_content_font_size'               => x_module_value( '1em', 'style' ),
    'accordion_content_letter_spacing'          => x_module_value( '0em', 'style' ),
    'accordion_content_line_height'             => x_module_value( '1.6', 'style' ),
    'accordion_content_font_style'              => x_module_value( 'normal', 'style' ),
    'accordion_content_text_align'              => x_module_value( 'none', 'style' ),
    'accordion_content_text_decoration'         => x_module_value( 'none', 'style' ),
    'accordion_content_text_transform'          => x_module_value( 'none', 'style' ),
    'accordion_content_text_color'              => x_module_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'accordion_content_text_shadow_dimensions'  => x_module_value( '0px 0px 0px', 'style' ),
    'accordion_content_text_shadow_color'       => x_module_value( 'transparent', 'style:color' ),

  );


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
