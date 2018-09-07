<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_SETUP/_.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Setup
//   02. Groups
//   03. Options
//   04. Settings
// =============================================================================

// Setup
// =============================================================================

$is_adv = ( isset( $settings['adv'] ) ) ? $settings['adv'] : false;



// Groups
// =============================================================================

$group_std           = 'std';
$group_std_content   = $group_std . ':content';
$group_std_design    = $group_std . ':design';
$group_std_customize = $group_std . ':customize';



// Options
// =============================================================================

$options_choices_off_on_bool = array(
  'choices' => array(
    array( 'value' => false, 'label' => __( 'Off', '__x__' ) ),
    array( 'value' => true,  'label' => __( 'On', '__x__' )  ),
  ),
);

$options_choices_off_on_string = array(
  'choices' => array(
    array( 'value' => '',   'label' => __( 'Off', '__x__' ) ),
    array( 'value' => 'on', 'label' => __( 'On', '__x__' )  ),
  ),
);

$options_color_only = array(
  'color_only' => true,
);

$options_base_interaction_labels = array(
  'label'     => __( 'Base', '__x__' ),
  'alt_label' => __( 'Interaction', '__x__' ),
);

$options_base_interaction_labels_color_only = array(
  'color_only' => true,
  'label'      => __( 'Base', '__x__' ),
  'alt_label'  => __( 'Interaction', '__x__' ),
);

$options_color_base_interaction_labels = array(
  'color' => array(
    'label'     => __( 'Base', '__x__' ),
    'alt_label' => __( 'Interaction', '__x__' ),
  ),
);

$options_color_base_interaction_labels_color_only = array(
  'color_only' => true,
  'color'      => array(
    'label'      => __( 'Base', '__x__' ),
    'alt_label'  => __( 'Interaction', '__x__' ),
  ),
);



// Settings
// =============================================================================

$settings_std_customize = array(
  'group' => $group_std_customize,
  'title' => __( 'Customize', '__x__' ),
  'condition' => array( 'user_can:{context}.customize_controls' => true )
);
