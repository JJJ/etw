<?php

// Options
// =============================================================================

$label_off = __( 'Off', '__x__' );
$label_on = __( 'On', '__x__' );

cs_remember( 'options_choices_off_on_bool', array(
  'choices' => array(
    array( 'value' => false, 'label' => $label_off ),
    array( 'value' => true,  'label' => $label_on ),
  ),
) );

cs_remember( 'options_choices_off_on_string', array(
  'choices' => array(
    array( 'value' => '',   'label' => $label_off ),
    array( 'value' => 'on', 'label' => $label_on  ),
  )
) );

$label_base = __( 'Base', '__x__' );
$label_interaction = __( 'Interaction', '__x__' );

cs_remember( 'options_base_interaction_labels', array(
  'label'     => $label_base,
  'alt_label' => $label_interaction,
) );

cs_remember( 'options_color_base_interaction_labels', array(
  'color' => array(
    'label'     => $label_base,
    'alt_label' => $label_interaction,
  )
) );

cs_remember( 'options_color_base_interaction_labels_color_only', array(
  'color_only' => true,
  'color'      => array(
    'label'      => $label_base,
    'alt_label'  => $label_interaction,
  )
) );

// Settings
// =============================================================================


cs_remember( 'settings_anchor:toggle', array(
  'type'             => 'toggle',
  'k_pre'            => 'toggle',
  'group'            => 'toggle_anchor',
  'group_title'      => __( 'Toggle', '__x__' ),
  'label_prefix_std' => __( 'Toggle', '__x__' )
) );

cs_remember( 'settings_anchor:cart-toggle', array(
  'type'             => 'toggle',
  'k_pre'            => 'toggle',
  'group'            => 'cart_toggle_anchor',
  'group_title'      => __( 'Toggle', '__x__' ),
  'label_prefix_std' => __( 'Toggle', '__x__' )
) );


cs_remember( 'settings_anchor:cart-button', array(
  'type'             => 'button',
  'k_pre'            => 'cart',
  'group'            => 'cart_button_anchor',
  'group_title'      => __( 'Cart Buttons', '__x__' ),
  'has_template'     => false,
  'label_prefix_std' => __( 'Cart Buttons', '__x__' )
) );
