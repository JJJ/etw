<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/TABS.PHP
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

    'tabs_base_font_size'                => cs_value( '1em', 'style' ),
    'tabs_width'                         => cs_value( 'auto', 'style' ),
    'tabs_max_width'                     => cs_value( '100%', 'style' ),
    'tabs_bg_color'                      => cs_value( 'transparent', 'style:color' ),
    'tabs_margin'                        => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_padding'                       => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_border_width'                  => cs_value( '0px', 'style' ),
    'tabs_border_style'                  => cs_value( 'none', 'style' ),
    'tabs_border_color'                  => cs_value( 'transparent', 'style:color' ),
    'tabs_border_radius'                 => cs_value( '0px 0px 0px 0px', 'style' ),
    'tabs_box_shadow_dimensions'         => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_box_shadow_color'              => cs_value( 'transparent', 'style:color' ),

    'tabs_tablist_bg_color'              => cs_value( 'transparent', 'style:color' ),
    'tabs_tablist_margin'                => cs_value( '0px 0px -1px 0px', 'style' ),
    'tabs_tablist_padding'               => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_border_width'          => cs_value( '0px', 'style' ),
    'tabs_tablist_border_style'          => cs_value( 'none', 'style' ),
    'tabs_tablist_border_color'          => cs_value( 'transparent', 'style:color' ),
    'tabs_tablist_border_radius'         => cs_value( '0px 0px 0px 0px', 'style' ),
    'tabs_tablist_box_shadow_dimensions' => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tablist_box_shadow_color'      => cs_value( 'transparent', 'style:color' ),

    'tabs_tabs_fill_space'               => cs_value( false, 'style' ),
    'tabs_tabs_justify_content'          => cs_value( 'flex-start', 'style' ),
    'tabs_tabs_min_width'                => cs_value( '0px', 'style' ),
    'tabs_tabs_max_width'                => cs_value( 'none', 'style' ),
    'tabs_tabs_bg_color'                 => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_bg_color_alt'             => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_margin'                   => cs_value( '0px', 'style' ),
    'tabs_tabs_padding'                  => cs_value( '0.75rem 1.5rem 0.75rem 1.5rem', 'style' ),
    'tabs_tabs_border_width'             => cs_value( '0px 0px 1px 0px', 'style' ),
    'tabs_tabs_border_style'             => cs_value( 'solid solid solid solid', 'style' ),
    'tabs_tabs_border_color'             => cs_value( 'transparent transparent transparent transparent', 'style:color' ),
    'tabs_tabs_border_color_alt'         => cs_value( 'transparent transparent rgba(0, 0, 0, 1) transparent', 'style:color' ),
    'tabs_tabs_border_radius'            => cs_value( '0px 0px 0px 0px', 'style' ),
    'tabs_tabs_box_shadow_dimensions'    => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_tabs_box_shadow_color'         => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_box_shadow_color_alt'     => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_font_family'              => cs_value( 'inherit', 'style:font-family' ),
    'tabs_tabs_font_weight'              => cs_value( 'inherit:400', 'style:font-weight' ),
    'tabs_tabs_font_size'                => cs_value( '0.75em', 'style' ),
    'tabs_tabs_letter_spacing'           => cs_value( '0.15em', 'style' ),
    'tabs_tabs_line_height'              => cs_value( '1', 'style' ),
    'tabs_tabs_font_style'               => cs_value( 'normal', 'style' ),
    'tabs_tabs_text_align'               => cs_value( 'none', 'style' ),
    'tabs_tabs_text_decoration'          => cs_value( 'none', 'style' ),
    'tabs_tabs_text_transform'           => cs_value( 'uppercase', 'style' ),
    'tabs_tabs_text_color'               => cs_value( 'rgba(0, 0, 0, 0.5)', 'style:color' ),
    'tabs_tabs_text_color_alt'           => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_tabs_text_shadow_dimensions'   => cs_value( '0px 0px 0px', 'style' ),
    'tabs_tabs_text_shadow_color'        => cs_value( 'transparent', 'style:color' ),
    'tabs_tabs_text_shadow_color_alt'    => cs_value( 'transparent', 'style:color' ),

    'tabs_panels_equal_height'           => cs_value( false, 'markup' ),
    'tabs_panels_bg_color'               => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
    'tabs_panels_flex_justify'           => cs_value( 'flex-start', 'style' ),
    'tabs_panels_flex_align'             => cs_value( 'stretch', 'style' ),
    'tabs_panels_margin'                 => cs_value( '0em 0em 0em 0em', 'style' ),
    'tabs_panels_padding'                => cs_value( '1.5rem', 'style' ),
    'tabs_panels_border_width'           => cs_value( '1px', 'style' ),
    'tabs_panels_border_style'           => cs_value( 'solid', 'style' ),
    'tabs_panels_border_color'           => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'tabs_panels_border_radius'          => cs_value( '0px 0px 0px 0px', 'style' ),
    'tabs_panels_box_shadow_dimensions'  => cs_value( '0em 0.25em 2em 0em', 'style' ),
    'tabs_panels_box_shadow_color'       => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
    'tabs_panels_font_family'            => cs_value( 'inherit', 'style:font-family' ),
    'tabs_panels_font_weight'            => cs_value( 'inherit:400', 'style:font-weight' ),
    'tabs_panels_font_size'              => cs_value( '1em', 'style' ),
    'tabs_panels_letter_spacing'         => cs_value( '0em', 'style' ),
    'tabs_panels_line_height'            => cs_value( '1.4', 'style' ),
    'tabs_panels_font_style'             => cs_value( 'normal', 'style' ),
    'tabs_panels_text_align'             => cs_value( 'none', 'style' ),
    'tabs_panels_text_decoration'        => cs_value( 'none', 'style' ),
    'tabs_panels_text_transform'         => cs_value( 'none', 'style' ),
    'tabs_panels_text_color'             => cs_value( 'rgba(0, 0, 0, 1)', 'style:color' ),
    'tabs_panels_text_shadow_dimensions' => cs_value( '0px 0px 0px', 'style' ),
    'tabs_panels_text_shadow_color'      => cs_value( 'transparent', 'style:color' ),

  ),
  'omega'
);


// Style
// =============================================================================

function x_element_style_tabs() {
  return x_get_view( 'styles/elements', 'tabs', 'css', array(), false );
}



// Render
// =============================================================================

function x_element_render_tabs( $data ) {

  $tabs = array();

  foreach ( $data['_modules'] as $key => $tab ) {
    $tabs[] = x_element_decorate( $tab, $data );
  }

  $data['tabs'] = $tabs;

  return x_get_view( 'elements', 'tabs', '', $data, false );

}



// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Tabs', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_tabs',
  'style' => 'x_element_style_tabs',
  'render' => 'x_element_render_tabs',
  'icon' => 'native',
  'options' => array(
    'render_children'  => true,
    'default_children' => array(
      array( '_type' => 'tab', 'tab_label_content' => __( 'Tab 1', '__x__' ) ),
      array( '_type' => 'tab', 'tab_label_content' => __( 'Tab 2', '__x__' ), 'tab_content' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque pretium, nisi ut volutpat mollis, leo risus interdum arcu, eget facilisis quam felis id mauris. Ut convallis, lacus nec ornare volutpat, velit turpis scelerisque purus.', '__x__' ) ),
    ),
    'add_new_element' => array( '_type' => 'tab' ),
    'valid_children' => array( 'tab' )
  )
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_tabs() {


  // Settings
  // --------


  $settings_tabs_tabs_design = array(
    'group'      => 'tabs_tabs:design',
    'alt_color'  => true,
    'options'    => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  $settings_tabs_tabs_text = array(
    'group'      => 'tabs_tabs:text',
    'alt_color'  => true,
    'options'    => array(
      'color' => array(
        'label'     => __( 'Base', '__x__' ),
        'alt_label' => __( 'Interaction', '__x__' ),
      ),
    ),
  );

  // Individual Controls
  // -------------------

  $control_tabs_sortable = array(
    'type'       => 'sortable',
    'label'      => __( 'Add Items', '__x__' ),
    'group'      => 'tabs:setup'
  );

  $control_tabs_base_font_size = array(
    'key'     => 'tabs_base_font_size',
    'type'    => 'slider',
    'label'   => __( 'Base Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 36, 'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.01 ),
      ),
    ),
  );

  $control_tabs_width = array(
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
  );

  $control_tabs_max_width = array(
    'key'     => 'tabs_max_width',
    'type'    => 'unit-slider',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '100%',
      'ranges'          => array(
        'px'  => array( 'min' => 500, 'max' => 1000, 'step' => 10  ),
        'em'  => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
        'rem' => array( 'min' => 30,  'max' => 50,   'step' => 0.5 ),
        '%'   => array( 'min' => 50,  'max' => 100,  'step' => 1   ),
      ),
    ),
  );

  $control_tabs_bg_color = array(
    'key'   => 'tabs_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_tabs_tablist_bg_color = array(
    'key'   => 'tabs_tablist_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );

  $control_tabs_tabs_fill_space = array(
    'key'     => 'tabs_tabs_fill_space',
    'type'    => 'choose',
    'label'   => __( 'Fill Space', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_tabs_tabs_justify_content = array(
    'key'       => 'tabs_tabs_justify_content',
    'type'      => 'select',
    'label'     => __( 'Justify Content', '__x__' ),
    'condition' => array( 'tabs_tabs_fill_space' => false ),
    'options'   => array(
      'choices' => array(
        array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )     ),
        array( 'value' => 'center',        'label' => __( 'Center', '__x__' )    ),
        array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )       ),
        array( 'value' => 'space-between', 'label' => __( 'S-Between', '__x__' ) ),
        array( 'value' => 'space-around',  'label' => __( 'S-Around', '__x__' )  ),
        array( 'value' => 'space-evenly',  'label' => __( 'S-Evenly', '__x__' )  ),
      ),
    ),
  );

  $control_tabs_tabs_min_width = array(
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
  );

  $control_tabs_tabs_max_width = array(
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
  );

  $control_tabs_tabs_bg_colors = array(
    'keys' => array(
      'value' => 'tabs_tabs_bg_color',
      'alt'   => 'tabs_tabs_bg_color_alt',
    ),
    'type'    => 'color',
    'label'   => __( 'Background', '__x__' ),
    'options' => cs_recall( 'options_base_interaction_labels' ),
  );

  $control_tabs_panels_equal_height = array(
    'key'     => 'tabs_panels_equal_height',
    'type'    => 'choose',
    'label'   => __( 'Equal Height', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_tabs_panels_flex_justify = array(
    'key'       => 'tabs_panels_flex_justify',
    'type'      => 'select',
    'label'     => __( 'Vertical Alignment', '__x__' ),
    'condition' => array( 'tabs_panels_equal_height' => true ),
    'options'   => array(
      'choices' => array(
        array( 'value' => 'flex-start',    'label' => __( 'Start', '__x__' )     ),
        array( 'value' => 'center',        'label' => __( 'Center', '__x__' )    ),
        array( 'value' => 'flex-end',      'label' => __( 'End', '__x__' )       ),
        array( 'value' => 'space-between', 'label' => __( 'S-Between', '__x__' ) ),
        array( 'value' => 'space-around',  'label' => __( 'S-Around', '__x__' )  ),
        array( 'value' => 'space-evenly',  'label' => __( 'S-Evenly', '__x__' )  ),
      ),
    ),
  );

  $control_tabs_panels_flex_align = array(
    'key'       => 'tabs_panels_flex_align',
    'type'      => 'select',
    'label'     => __( 'Horizontal Alignment', '__x__' ),
    'condition' => array( 'tabs_panels_equal_height' => true ),
    'options'   => array(
      'choices' => array(
        array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )   ),
        array( 'value' => 'center',     'label' => __( 'Center', '__x__' )  ),
        array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )     ),
        array( 'value' => 'stretch',    'label' => __( 'Stretch', '__x__' ) ),
      ),
    ),
  );

  $control_tabs_panels_bg_color = array(
    'key'   => 'tabs_panels_bg_color',
    'type'  => 'color',
    'label' => __( 'Background', '__x__' ),
  );


  // Compose Controls
  // -------------------


  return cs_compose_controls(
    array(
      'controls' => array(
        $control_tabs_sortable,
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'tabs:setup',
          'controls'   => array(
            $control_tabs_base_font_size,
            $control_tabs_width,
            $control_tabs_max_width,
            $control_tabs_bg_color,
          ),
        ),

        cs_control( 'margin', 'tabs', array( 'group' => 'tabs:design') ),
        cs_control( 'padding', 'tabs', array( 'group' => 'tabs:design') ),
        cs_control( 'border', 'tabs', array( 'group' => 'tabs:design') ),
        cs_control( 'border-radius', 'tabs', array( 'group' => 'tabs:design') ),
        cs_control( 'box-shadow', 'tabs', array( 'group' => 'tabs:design') ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'tabs_tablist:setup',
          'controls'   => array(
            $control_tabs_tablist_bg_color,
          ),
        ),

        cs_control( 'margin', 'tabs_tablist', array( 'group' => 'tabs_tablist:design' ) ),
        cs_control( 'padding', 'tabs_tablist', array( 'group' => 'tabs_tablist:design' ) ),
        cs_control( 'border', 'tabs_tablist', array( 'group' => 'tabs_tablist:design' ) ),
        cs_control( 'border-radius', 'tabs_tablist', array( 'group' => 'tabs_tablist:design' ) ),
        cs_control( 'box-shadow', 'tabs_tablist', array( 'group' => 'tabs_tablist:design' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'tabs_tabs:setup',
          'controls'   => array(
            $control_tabs_tabs_fill_space,
            $control_tabs_tabs_justify_content,
            $control_tabs_tabs_min_width,
            $control_tabs_tabs_max_width,
            $control_tabs_tabs_bg_colors,
          ),
        ),

        cs_control( 'margin', 'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'padding', 'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'border', 'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'border-radius', 'tabs_tabs', $settings_tabs_tabs_design ),
        cs_control( 'box-shadow', 'tabs_tabs', $settings_tabs_tabs_design ),

        cs_control( 'text-format', 'tabs_tabs', $settings_tabs_tabs_text ),
        cs_control( 'text-shadow', 'tabs_tabs', $settings_tabs_tabs_text ),

        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'tabs_panels:setup',
          'controls'   => array(
            $control_tabs_panels_equal_height,
            $control_tabs_panels_flex_justify,
            $control_tabs_panels_flex_align,
            $control_tabs_panels_bg_color
          ),
        ),

        cs_control( 'margin', 'tabs_panels', array( 'group' => 'tabs_panels:design' ) ),
        cs_control( 'padding', 'tabs_panels', array( 'group' => 'tabs_panels:design' ) ),
        cs_control( 'border', 'tabs_panels', array( 'group' => 'tabs_panels:design' ) ),
        cs_control( 'border-radius', 'tabs_panels', array( 'group' => 'tabs_panels:design' ) ),
        cs_control( 'box-shadow', 'tabs_panels', array( 'group' => 'tabs_panels:design' ) ),
        cs_control( 'text-format', 'tabs_panels', array( 'group' => 'tabs_panels:text' ) ),
        cs_control( 'text-shadow', 'tabs_panels', array( 'group' => 'tabs_panels:text' ) )

      ),
      'controls_std_content' => array(
        $control_tabs_sortable
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_tabs_base_font_size,
            $control_tabs_width,
            $control_tabs_max_width,
          ),
        ),
        cs_control( 'margin', 'tabs' ),
        array(
          'type'       => 'group',
          'label'      => __( 'Tabs Design Setup', '__x__' ),
          'controls'   => array(
            $control_tabs_tabs_fill_space,
            $control_tabs_tabs_justify_content,
            $control_tabs_tabs_min_width,
            $control_tabs_tabs_max_width,
          ),
        ),
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'tabs_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'tabs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_tabs_bg_color,
          ),
        ),

        cs_control( 'border', 'tabs', array(
          'label_prefix'     => __( 'Base', '__x__' ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'tabs_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'tabs_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) ),
        array(
          'type'       => 'group',
          'label'      => __( 'Tab List Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'      => array( 'value' => 'tabs_tablist_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'tabs_tablist_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_tabs_tablist_bg_color,
          ),
        ),
        cs_control( 'border', 'tabs_tablist', array(
          'k_pre' => '',
          'label_prefix'     => __( 'Tab List', '__x__' ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'tabs_tablist_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'tabs_tablist_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) ),
        array(
          'type'       => 'group',
          'label'      => __( 'Tabs Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys' => array(
                'value' => 'tabs_tabs_text_color',
                'alt'   => 'tabs_tabs_text_color_alt'
              ),
              'type'    => 'color',
              'label'   => __( 'Text', '__x__' ),
              'options' => cs_recall( 'options_base_interaction_labels' ),
            ),
            array(
              'keys' => array(
                'value' => 'tabs_tabs_text_shadow_color',
                'alt'   => 'tabs_tabs_text_shadow_color_alt'
              ),
              'type'      => 'color',
              'label'     => __( 'Text<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'tabs_tabs_text_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            array(
              'keys' => array(
                'value' => 'tabs_tabs_box_shadow_color',
                'alt'   => 'tabs_tabs_box_shadow_color_alt'
              ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'options'   => cs_recall( 'options_base_interaction_labels' ),
              'condition' => array( 'key' => 'tabs_tabs_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_tabs_tabs_bg_colors,
          ),
        ),

        cs_control( 'border', 'tabs_tabs', array_merge(
            $settings_tabs_tabs_design,
            array(
              'label_prefix'     => __( 'Individual Tabs', '__x__' ),
              'options'   => cs_recall( 'options_color_base_interaction_labels_color_only' ),
              'conditions' => array(
                array( 'key' => 'tabs_tabs_border_width', 'op' => 'NOT EMPTY' ),
                array( 'key' => 'tabs_tabs_border_style', 'op' => '!=', 'value' => 'none' )
              ),
            )
          )
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Panels Colors', '__x__' ),
          'controls'   => array(
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
          ),
        ),
        cs_control( 'border', 'tabs_panels', array(
          'label_prefix'     => __( 'Panels', '__x__' ),
          'options'   => array( 'color_only' => true ),
          'conditions' => array(
            array( 'key' => 'tabs_panels_border_width', 'op' => 'NOT EMPTY' ),
            array( 'key' => 'tabs_panels_border_style', 'op' => '!=', 'value' => 'none' )
          ),
        ) )
      ),
      'control_nav' => array(

        'tabs'                => __( 'Tabs', '__x__' ),
        'tabs:setup'          => __( 'Setup', '__x__' ),
        'tabs:design'         => __( 'Design', '__x__' ),

        'tabs_tablist'        => __( 'Tab List', '__x__' ),
        'tabs_tablist:setup'  => __( 'Setup', '__x__' ),
        'tabs_tablist:design' => __( 'Design', '__x__' ),

        'tabs_tabs'           => __( 'Individual Tabs', '__x__' ),
        'tabs_tabs:setup'     => __( 'Setup', '__x__' ),
        'tabs_tabs:design'    => __( 'Design', '__x__' ),
        'tabs_tabs:text'      => __( 'Text', '__x__' ),

        'tabs_panels'         => __( 'Panels', '__x__' ),
        'tabs_panels:setup'   => __( 'Setup', '__x__' ),
        'tabs_panels:design'  => __( 'Design', '__x__' ),
        'tabs_panels:text'    => __( 'Text', '__x__' ),

      ),
    ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'tabs', $data );
