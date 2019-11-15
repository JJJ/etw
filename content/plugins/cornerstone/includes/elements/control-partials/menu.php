<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/CONTROL-PARTIALS/MENU.PHP
// -----------------------------------------------------------------------------
// Element Controls
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
// =============================================================================

// Controls
// =============================================================================

function x_control_partial_menu( $settings ) {


  // Setup
  // -----

  // 01. Available types:
  //     -- 'inline'
  //     -- 'dropdown'
  //     -- 'collapsed'
  //     -- 'modal'
  //     -- 'layered'

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'menu';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Menu', '__x__' );
  $conditions  = ( isset( $settings['conditions'] )  ) ? $settings['conditions'] : array();
  $type        = ( isset( $settings['type'] )        ) ? $settings['type']        : 'inline'; // 01



  // Groups
  // ------

  $group_menu_setup  = $group . ':setup';
  $group_menu_design = $group . ':design';


  // Settings
  // -------

  $settings_menu_margin = array(
    'k_pre'     => 'menu',
    'group'     => $group_menu_design,
    'conditions' => $conditions
  );

  $settings_menu_flexbox = array(
    'k_pre'     => 'menu',
    'group'     => $group_menu_design,
    'conditions' => $conditions
  );

  $settings_menu_flexbox_row = array(
    'layout_pre' => 'row',
    'conditions'  => array( array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'content', 'top', 'bottom', 'footer' ) ) ),
  );

  $settings_menu_flexbox_col = array(
    'layout_pre' => 'col',
    'conditions'  => array( array( 'key' => '_region', 'op' => 'IN', 'value' => array( 'left', 'right' ) ) ),
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
    'options' => array(
      'available_units' => array( 'px', 'em', 'rem' ),
      'valid_keywords'  => array( 'calc' ),
      'fallback_value'  => '16px',
      'ranges'          => array(
        'px'  => array( 'min' => 10,  'max' => 24,  'step' => 1    ),
        'em'  => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
        'rem' => array( 'min' => 0.5, 'max' => 1.5, 'step' => 0.01 ),
      ),
    ),
  );

  $control_menu_align_self = array(
    'key'     => 'menu_align_self',
    'type'    => 'select',
    'label'   => __( 'Align Self', '__x__' ),
    'options' => array(
      'choices' => array(
        array( 'value' => 'flex-start', 'label' => __( 'Start', '__x__' )   ),
        array( 'value' => 'center',     'label' => __( 'Center', '__x__' )  ),
        array( 'value' => 'flex-end',   'label' => __( 'End', '__x__' )     ),
        array( 'value' => 'stretch',    'label' => __( 'Stretch', '__x__' ) ),
      ),
    ),
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
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_menu_active_links_highlight_ancestors = array(
    'key'     => 'menu_active_links_highlight_ancestors',
    'type'    => 'choose',
    'label'   => __( 'Ancestor Links', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_menu_active_links_show_graphic = array(
    'key'     => 'menu_active_links_show_graphic',
    'type'    => 'choose',
    'label'   => __( 'Graphic', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_menu_active_links_show_primary_particle = array(
    'key'     => 'menu_active_links_show_primary_particle',
    'type'    => 'choose',
    'label'   => __( 'Primary Particle', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

  $control_menu_active_links_show_secondary_particle = array(
    'key'     => 'menu_active_links_show_secondary_particle',
    'type'    => 'choose',
    'label'   => __( 'Secondary Particle', '__x__' ),
    'options' => cs_recall( 'options_choices_off_on_bool' ),
  );

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

  // Compose Controls
  // ----------------

  $controls = array(
    array(
      'type'       => 'group',
      'label'      => __( 'Setup', '__x__' ),
      'group'      => $group_menu_setup,
      'conditions' => $conditions,
      'controls'   => $control_list_menu_adv_setup,
    ),
    array(
      'type'       => 'group',
      'label'      => __( 'Active Links Setup', '__x__' ),
      'group'      => $group_menu_setup,
      'conditions' => $conditions,
      'controls'   => array(
        $control_menu_active_links_highlight_current,
        $control_menu_active_links_highlight_ancestors,
        $control_menu_active_links_show_graphic,
        $control_menu_active_links_show_primary_particle,
        $control_menu_active_links_show_secondary_particle,
      ),
    )
  );

  if ( $type !== 'dropdown' ) {
    $controls[] = cs_control( 'margin', 'menu', array(
      'group'     => $group_menu_design,
      'conditions' => $conditions
    ) );
  }


  if ( $type === 'inline' ) {
    $controls = array_merge(
      $controls,
      x_control_flexbox( array_merge( $settings_menu_flexbox, $settings_menu_flexbox_row ) ),
      x_control_flexbox( array_merge( $settings_menu_flexbox, $settings_menu_flexbox_col ) ),
      array(
        array(
          'key'        => 'menu_items_flex',
          'type'       => 'flex',
          'label'      => __( '{{prefix}} Flex', '__x__' ),
          'label_vars' => array( 'prefix' => __( 'Items', '__x__' ) ),
          'group'      => $group_menu_design,
          'conditions' => $conditions,
        )
      )
    );
  }

  $controls_std_design_setup = array();

  if ( $type !== 'dropdown' ) {
    $controls_std_design_setup[] = cs_control( 'margin', 'menu', array(
      'group'      => $group_menu_design,
      'conditions' => $conditions
    ) );
  }

  $control_nav = array(
    $group            => $group_title,
    $group_menu_setup => __( 'Setup', '__x__' ),
  );

  if ( $type !== 'dropdown' ) {
    $control_nav[$group_menu_design] = __( 'Design', '__x__' );
  }

  return array(
    'controls' => $controls,
    'controls_std_content' => array(
      array(
        'type'       => 'group',
        'label'      => __( 'Menu', '__x__' ),
        'conditions' => $conditions,
        'controls'   => array(
          $control_menu_menu,
        ),
      ),
    ),
    'controls_std_design_setup' => $controls_std_design_setup,
    'control_nav' => $control_nav,
  );
}

cs_register_control_partial( 'menu', 'x_control_partial_menu' );
