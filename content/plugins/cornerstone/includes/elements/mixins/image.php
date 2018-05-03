<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/DROPDOWN.PHP
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

function x_controls_image( $settings = array() ) {

  // Setup
  // -----
  // 01. Available types:
  //     -- 'standard'
  //     -- 'scaling'

  $group     = ( isset( $settings['group'] )     ) ? $settings['group']     : 'image';
  $condition = ( isset( $settings['condition'] ) ) ? $settings['condition'] : array();
  $is_retina = ( isset( $settings['is_retina'] ) ) ? true                   : false;
  $width     = ( isset( $settings['width'] )     ) ? true                   : false;
  $height    = ( isset( $settings['height'] )    ) ? true                   : false;
  $has_link  = ( isset( $settings['has_link'] )  ) ? true                   : false;
  $has_info  = ( isset( $settings['has_info'] )  ) ? true                   : false;
  $alt_text  = ( isset( $settings['alt_text'] )  ) ? true                   : false;

  $group_setup  = $group . ':setup';
  $group_design = $group . ':design';


  // Setup - Conditions
  // ------------------

  $conditions          = x_module_conditions( $condition );
  $conditions_standard = array( $condition, array( 'image_type' => 'standard' ) );


  // Setup - Settings
  // ----------------

  $settings_image_control = array(
    'group' => $group_setup,
  );

  if ( $is_retina === true ) {
    $settings_image_control['is_retina'] = true;
  }

  if ( $width === true ) {
    $settings_image_control['width'] = true;
  }

  if ( $height === true ) {
    $settings_image_control['height'] = true;
  }

  if ( $has_link === true ) {
    $settings_image_control['has_link'] = true;
  }

  if ( $has_info === true ) {
    $settings_image_control['has_info'] = true;
  }

  if ( $alt_text === true ) {
    $settings_image_control['alt_text'] = true;
  }

  $settings_image_link = array(
    'k_pre'     => 'image',
    'group'     => $group_setup,
    'condition' => array( $condition, array( 'image_link' => true ) ),
    'blank'     => true,
    'nofollow'  => true,
  );

  $settings_image = array(
    'k_pre'     => 'image',
    'group'     => $group_design,
    'condition' => $conditions_standard,
  );

  $settings_image_with_color = array(
    'k_pre'     => 'image',
    'group'     => $group_design,
    'condition' => $conditions_standard,
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
            'key'       => 'image_type',
            'type'      => 'choose',
            'label'     => __( 'Type', '__x__' ),
            'condition' => array( '_region' => 'top' ),
            'options'   => array(
              'choices' => array(
                array( 'value' => 'standard', 'label' => __( 'Standard', '__x__' ) ),
                array( 'value' => 'scaling',  'label' => __( 'Scaling', '__x__' ) ),
              ),
            ),
          ),
          array(
            'key'        => 'image_styled_width',
            'type'       => 'unit',
            'label'      => __( 'Width', '__x__' ),
            'conditions' => $conditions_standard,
            'options'    => array(
              'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
              'valid_keywords'  => array( 'auto', 'calc' ),
            ),
          ),
          array(
            'key'        => 'image_styled_max_width',
            'type'       => 'unit',
            'label'      => __( 'Max Width', '__x__' ),
            'conditions' => $conditions_standard,
            'options'    => array(
              'available_units' => array( 'px', 'em', 'rem', '%', 'vw', 'vh' ),
              'valid_keywords'  => array( 'none', 'calc' ),
            ),
          ),
          array(
            'keys' => array(
              'value' => 'image_bg_color',
              'alt'   => 'image_bg_color_alt',
            ),
            'type'       => 'color',
            'label'      => __( 'Background Color', '__x__' ),
            'conditions' => $conditions_standard,
            'options'    => array(
              'label'     => __( 'Base', '__x__' ),
              'alt_label' => __( 'Interaction', '__x__' ),
            ),
          ),
        ),
      ),
    ),
    x_control_image( $settings_image_control )
  );

  if ( $has_link === true ) {
    $controls = array_merge(
      $controls,
      x_control_link( $settings_image_link )
    );
  }

  $controls = array_merge(
    $controls,
    x_control_margin( $settings_image ),
    x_control_padding( $settings_image ),
    x_control_border( $settings_image_with_color ),
    x_control_border_radius( array(
      'k_pre'     => 'image_outer',
      't_pre'     => __( 'Outer', '__x__' ),
      'group'     => $group_design,
      'condition' => $conditions_standard,
    ) ),
    x_control_border_radius( array(
      'k_pre'     => 'image_inner',
      't_pre'     => __( 'Inner', '__x__' ),
      'group'     => $group_design,
      'condition' => $conditions_standard,
    ) ),
    x_control_box_shadow( $settings_image_with_color )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_image( $settings = array() ) {

  $group       = ( isset( $settings['group'] )       ) ? $settings['group']       : 'image';
  $group_title = ( isset( $settings['group_title'] ) ) ? $settings['group_title'] : __( 'Image', '__x__' );

  $control_groups = array(
    $group             => array( 'title' => $group_title ),
    $group . ':setup'  => array( 'title' => __( 'Setup', '__x__' ) ),
    $group . ':design' => array( 'title' => __( 'Design', '__x__' ) ),
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_image( $settings = array() ) {

  // Setup
  // -----

  $is_retina = ( isset( $settings['is_retina'] ) ) ? true : false;
  $width     = ( isset( $settings['width'] )     ) ? true : false;
  $height    = ( isset( $settings['height'] )    ) ? true : false;
  $has_link  = ( isset( $settings['has_link'] )  ) ? true : false;
  $has_info  = ( isset( $settings['has_info'] )  ) ? true : false;
  $alt_text  = ( isset( $settings['alt_text'] )  ) ? true : false;


  // Values
  // ------

  $values = array(
    'image_type'                  => x_module_value( 'standard', 'all' ),
    'image_styled_width'          => x_module_value( 'auto', 'style' ),
    'image_styled_max_width'      => x_module_value( 'none', 'style' ),
    'image_bg_color'              => x_module_value( 'transparent', 'style:color' ),
    'image_bg_color_alt'          => x_module_value( 'transparent', 'style:color' ),
    'image_src'                   => x_module_value( '', 'markup', true ),
    'image_margin'                => x_module_value( '0px', 'style' ),
    'image_padding'               => x_module_value( '0px', 'style' ),
    'image_border_width'          => x_module_value( '0px', 'style' ),
    'image_border_style'          => x_module_value( 'solid', 'style' ),
    'image_border_color'          => x_module_value( 'transparent', 'style:color' ),
    'image_border_color_alt'      => x_module_value( 'transparent', 'style:color' ),
    'image_outer_border_radius'   => x_module_value( '0em', 'style' ),
    'image_inner_border_radius'   => x_module_value( '0em', 'style' ),
    'image_box_shadow_dimensions' => x_module_value( '0em 0em 0em 0em', 'style' ),
    'image_box_shadow_color'      => x_module_value( 'transparent', 'style:color' ),
    'image_box_shadow_color_alt'  => x_module_value( 'transparent', 'style:color' ),
  );

  if ( $is_retina === true ) {
    $values = array_merge(
      $values,
      array(
        'image_retina' => x_module_value( true, 'markup', true ),
      )
    );
  }

  if ( $width === true ) {
    $values = array_merge(
      $values,
      array(
        'image_width' => x_module_value( 48, 'markup', true ),
      )
    );
  }

  if ( $height === true ) {
    $values = array_merge(
      $values,
      array(
        'image_height' => x_module_value( 48, 'markup', true ),
      )
    );
  }

  if ( $has_link === true ) {
    $values = array_merge(
      $values,
      array(
        'image_link'     => x_module_value( false, 'markup', true ),
        'image_href'     => x_module_value( '', 'markup', true ),
        'image_blank'    => x_module_value( false, 'markup', true ),
        'image_nofollow' => x_module_value( false, 'markup', true ),
      )
    );
  }

  if ( $has_info === true ) {
    $values = array_merge(
      $values,
      array(
        'image_info' => x_module_value( false, 'markup', true ),
      )
    );
  }

  if ( $alt_text === true ) {
    $values = array_merge(
      $values,
      array(
        'image_alt' => x_module_value( '', 'markup', true ),
      )
    );
  }


  // Returned Value
  // --------------

  return x_bar_mixin_values( $values, $settings );

}
