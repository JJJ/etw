<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/DEFINITIONS/CARD.PHP
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

$style_headline = array(
  'text_text_align'             => cs_value( 'center', 'style' ),
  'text_flex_direction'         => cs_value( 'column', 'style' ),
  'text_subheadline_text_align' => cs_value( 'center', 'style' ),
);

$style_card_face = array(
  'bg_color'              => cs_value( 'rgba(255, 255, 255, 1)', 'style:color' ),
  'bg_advanced'           => cs_value( false, 'all' ),
  'border_width'          => cs_value( '0px', 'style' ),
  'border_style'          => cs_value( 'none', 'style' ),
  'border_color'          => cs_value( 'transparent', 'style:color' ),
  'padding'               => cs_value( '4rem 1.5rem 4rem 1.5rem', 'style' ),
  'box_shadow_dimensions' => cs_value( '0em 0.35em 2em 0em', 'style' ),
  'box_shadow_color'      => cs_value( 'rgba(0, 0, 0, 0.15)', 'style:color' ),
);

$values = cs_compose_values(
  array(
    'card_base_font_size'      => cs_value( '1em', 'style' ),
    'card_width'               => cs_value( '0px', 'style' ),
    'card_max_width'           => cs_value( 'none', 'style' ),
    'card_interaction'         => cs_value( 'flip-up', 'all' ),
    'card_transition_duration' => cs_value( '0.85s', 'style' ),
    'card_perspective'         => cs_value( '1000px', 'style' ),
    'card_content_justify'     => cs_value( 'center', 'style' ),
    'card_margin'              => cs_value( '0em', 'style' ),
    'card_border_radius'       => cs_value( '0em 0em 0em 0em', 'style' ),
  ),

  // Front
  // -----

  cs_values( $style_card_face, 'card_front'),
  cs_values( 'bg', 'card_front' ),
  cs_values( 'text-headline', 'card_front' ),
  cs_values( $style_headline, 'card_front' ),

  // Back
  // ----

  cs_values( $style_card_face, 'card_back'),
  cs_values( 'bg', 'card_back' ),
  cs_values( 'text-headline', 'card_back' ),
  cs_values( $style_headline, 'card_back' ),

  'anchor-button',
  array(
    'anchor_margin' => cs_value( '1em 0em 0em 0em', 'style' )
  ),

  'omega'
);

// Style
// =============================================================================

function x_element_style_card() {
  return x_get_view( 'styles/elements', 'card', 'css', array(), false );
}


// Render
// =============================================================================

function x_element_render_card( $data ) {
  return x_get_view( 'elements', 'card', '', $data, false );
}


// Define Element
// =============================================================================

$data = array(
  'title'  => __( 'Card', '__x__' ),
  'values' => $values,
  'builder' => 'x_element_builder_setup_card',
  'style' => 'x_element_style_card',
  'render' => 'x_element_render_card',
  'icon' => 'native',
);



// Builder Setup
// =============================================================================

function x_element_builder_setup_card() {



  // Settings
  // --------

  $settings_card_front = array(
    'label_prefix' => __( 'Front', '__x__' ),
    'group'        => 'card:front',
  );

  $settings_card_back = array(
    'label_prefix' => __( 'Back', '__x__' ),
    'group'        => 'card:back',
  );

  // Individual Controls
  // -------------------

  $control_card_base_font_size = array(
    'key'     => 'card_base_font_size',
    'type'    => 'unit-slider',
    'label'   => __( 'Font Size', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '1em',
      'ranges'          => array(
        'px'  => array( 'min' => 8,   'max' => 24, 'step' => 1   ),
        'em'  => array( 'min' => 0.5, 'max' => 4,  'step' => 0.1 ),
        'rem' => array( 'min' => 0.5, 'max' => 4,  'step' => 0.1 ),
      ),
    ),
  );

  $control_card_width = array(
    'key'     => 'card_width',
    'type'    => 'unit',
    'label'   => __( 'Min Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'fallback_value'  => '0px',
      'valid_keywords'  => array( 'calc' ),
    ),
  );

  $control_card_max_width = array(
    'key'     => 'card_max_width',
    'type'    => 'unit',
    'label'   => __( 'Max Width', '__x__' ),
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
      'fallback_value'  => 'none',
      'valid_keywords'  => array( 'none', 'calc' ),
    ),
  );

  $control_card_width_and_max_width = array(
    'type'     => 'group',
    'label'    => __( 'Width &amp; Max Width', '__x__' ),
    'controls' => array(
      $control_card_width,
      $control_card_max_width,
    ),
  );

  $control_card_interaction = array(
    'key'     => 'card_interaction',
    'type'    => 'select',
    'options' => array(
      'choices' => array(
        array( 'value' => 'flip-up',    'label' => __( 'Flip Up', '__x__' ) ),
        array( 'value' => 'flip-down',  'label' => __( 'Flip Down', '__x__' ) ),
        array( 'value' => 'flip-left',  'label' => __( 'Flip Left', '__x__' ) ),
        array( 'value' => 'flip-right', 'label' => __( 'Flip Right', '__x__' ) ),
      ),
    ),
  );

  $control_card_transition_duration = array(
    'key'     => 'card_transition_duration',
    'type'    => 'unit',
    'options' => array( 'unit_mode' => 'time' ),
  );

  $control_card_interaction_setup = array(
    'type'     => 'group',
    'label'    => __( 'Interaction &amp; Duration', '__x__' ),
    'controls' => array(
      $control_card_interaction,
      $control_card_transition_duration,
    ),
  );

  $control_card_perspective = array(
    'key'     => 'card_perspective',
    'type'    => 'unit-slider',
    'label'   => __( 'Perspective', '__x__' ),
    'options' => array(
      'available_units' => array( 'px' ),
      'fallback_value'  => '1000px',
      'ranges'          => array(
        'px' => array( 'min' => 500, 'max' => 1500, 'step' => 1 )
      ),
    ),
  );

  $control_card_content_justify = array(
    'key'     => 'card_content_justify',
    'type'    => 'choose',
    'label'   => __( 'Vertical Alignment', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )  ),
        array( 'value' => 'center',     'label' => __( 'Center', '__x__' ) ),
        array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )    ),
      ),
    ),
  );

  //
  // Front
  //

  $control_card_front_bg_color = array(
    'keys'    => array( 'value' => 'card_front_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Front Background', '__x__' ),
    'options' => array( 'label' => __( 'Select', '__x__' ) ),
  );

  $control_card_front_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'card_front_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_card_front_background = array(
    'type'     => 'group',
    'label'    => __( 'Front Background', '__x__' ),
    'controls' => array(
      $control_card_front_bg_color,
      $control_card_front_bg_advanced,
    ),
  );

  //
  // Back
  //

  $control_card_back_bg_color = array(
    'keys'    => array( 'value' => 'card_back_bg_color' ),
    'type'    => 'color',
    'label'   => __( 'Back Background', '__x__' ),
    'options' => array( 'label' => __( 'Select', '__x__' ) ),
  );

  $control_card_back_bg_advanced = array(
    'keys' => array(
      'bg_advanced' => 'card_back_bg_advanced',
    ),
    'type'    => 'checkbox-list',
    'options' => array(
      'list' => array(
        array( 'key' => 'bg_advanced', 'label' => __( 'Advanced', '__x__' ) ),
      ),
    ),
  );

  $control_card_back_background = array(
    'type'     => 'group',
    'label'    => __( 'Back Background', '__x__' ),
    'controls' => array(
      $control_card_back_bg_color,
      $control_card_back_bg_advanced,
    ),
  );


  // Compose Controls
  // ----------------

  return cs_compose_controls(
    array(
      'controls' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Setup', '__x__' ),
          'group'      => 'card:setup',
          'controls'   => array(
            $control_card_base_font_size,
            $control_card_width_and_max_width,
            $control_card_interaction_setup,
            $control_card_perspective,
            $control_card_content_justify,
          ),
        ),

        cs_control( 'margin', 'card', array( 'group' => 'card:setup' ) ),
        cs_control( 'border-radius', 'card', array( 'group' => 'card:setup' ) ),

        array(
          'type'       => 'group',
          'label'      => __( 'Front Setup', '__x__' ),
          'group'      => 'card:front',
          'controls'   => array( $control_card_front_background )
        )
      ),
      'controls_std_content' => array(
        // array(
        //   'type'       => 'group',
        //   'label'      => __( 'Content', '__x__' ),
        //   'controls'   => array(),
        // ),
      ),
      'controls_std_design_setup' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Design Setup', '__x__' ),
          'controls'   => array(
            $control_card_base_font_size,
            $control_card_width_and_max_width,
            $control_card_interaction_setup,
            $control_card_perspective,
          ),
        ),
        cs_control( 'margin', 'card' )
      ),
      'controls_std_design_colors' => array(
        array(
          'type'       => 'group',
          'label'      => __( 'Front Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'       => array( 'value' => 'card_front_border_color' ),
              'type'       => 'color',
              'label'      => __( 'Border', '__x__' ),
              'conditions' => array(
                array( 'key' => 'card_front_border_width', 'op' => 'NOT EMPTY' ),
                array( 'key' => 'card_front_border_style', 'op' => '!=', 'value' => 'none' ),
              ),
            ),
            array(
              'keys'      => array( 'value' => 'card_front_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'card_front_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_card_front_bg_color,
          ),
        ),
        array(
          'type'       => 'group',
          'label'      => __( 'Back Base Colors', '__x__' ),
          'controls'   => array(
            array(
              'keys'       => array( 'value' => 'card_back_border_color' ),
              'type'       => 'color',
              'label'      => __( 'Border', '__x__' ),
              'conditions' => array(
                array( 'key' => 'card_back_border_width', 'op' => 'NOT EMPTY' ),
                array( 'key' => 'card_back_border_style', 'op' => '!=', 'value' => 'none' ),
              ),
            ),
            array(
              'keys'      => array( 'value' => 'card_back_box_shadow_color' ),
              'type'      => 'color',
              'label'     => __( 'Box<br>Shadow', '__x__' ),
              'condition' => array( 'key' => 'card_back_box_shadow_dimensions', 'op' => 'NOT EMPTY' ),
            ),
            $control_card_back_bg_color,
          ),
        ),
      ),
      'control_nav' => array(
        'card'       => __( 'Card', '__x__' ),
        'card:setup' => __( 'Setup', '__x__' ) ,
        'card:front' => __( 'Front', '__x__' ),
        'card:back'  => __( 'Back', '__x__' ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'label_prefix' => __( 'Front', '__x__' ),
      'k_pre'        => 'card_front',
      'group'        => 'card:setup',
      'condition'    => array( 'card_front_bg_advanced' => true ),
    ) ),
    array(
      'controls' => array(
        cs_control( 'border', 'card_front', $settings_card_front ),
        cs_control( 'padding', 'card_front', $settings_card_front ),
        cs_control( 'box-shadow', 'card_front', $settings_card_front ),
        array(
          'type'       => 'group',
          'label'      => __( 'Back Setup', '__x__' ),
          'group'      => 'card:back',
          'controls'   => array( $control_card_back_background )
        ),
      )
    ),
    cs_partial_controls( 'bg', array(
      'label_prefix' => __( 'Back', '__x__' ),
      'k_pre'        => 'card_back',
      'group'        => 'card:setup',
      'condition'    => array( 'card_back_bg_advanced' => true ),
      'adv'          => true,
    ) ),
    array(
      'controls' => array(
        cs_control( 'border', 'card_back', $settings_card_back ),
        cs_control( 'padding', 'card_back', $settings_card_back ),
        cs_control( 'box-shadow', 'card_back', $settings_card_back )
      )
    ),
    cs_partial_controls( 'text', array(
      'k_pre' => 'card_front',
      'group' => 'card_front_text',
      'group_title' => __( 'Front Content', '__x__' ),
      'label_prefix_std' => __( 'Front Text', '__x__' ),
      'type' => 'headline'
    ) ),
    cs_partial_controls( 'text', array(
      'k_pre' => 'card_back',
      'group' => 'card_back_text',
      'group_title' => __( 'Back Content', '__x__' ),
      'label_prefix_std' => __( 'Back Text', '__x__' ),
      'type' => 'headline'
    ) ),
    cs_partial_controls( 'anchor', array(
      'type'             => 'button',
      'has_link_control' => true,
      'group'            => 'button_anchor',
      'group_title'      => __( 'Back Button', '__x__' ),
      'label_prefix_std' => __( 'Back Button', '__x__' )
    ) ),
    cs_partial_controls( 'omega' )
  );
}



// Register Module
// =============================================================================

cs_register_element( 'card', $data );
