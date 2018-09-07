<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS_INCLUDES/GLOBAL-BLOCK.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Controls
//   02. Control Group
//   03. Values
// =============================================================================

// Controls: Advanced
// =============================================================================

function x_controls_global_block( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/global-block.php' );

  $controls = array_merge(
    array(
      array(
        'type'       => 'group',
        'title'      => __( 'Setup', '__x__' ),
        'group'      => $is_adv ? $group_global_block_setup : $group_std_content,
        'conditions' => $conditions,
        'controls'   => array(
          array(
            'key'     => 'global_block_id',
            'type'    => 'post-picker',
            'label'   => __( 'Global<br>Block', '__x__' ),
            'options' => array( 
              'post_type'         => 'cs_global_block',
              'post_status'       => 'tco-data',
              'empty_placeholder' => 'No Global Blocks',
              'placeholder'       => 'Select Global Block'
            ),
          ),
        )
      )
    )
  );

  return $controls;

}



// Control Groups
// =============================================================================

function x_control_groups_global_block( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/global-block.php' );

  $control_groups = array(
    $group                    => array( 'title' => $group_title ),
    $group_global_block_setup => array( 'title' => __( 'Setup', '__x__' ) )
  );

  return $control_groups;

}



// Values
// =============================================================================

function x_values_global_block( $settings = array() ) {

  include( dirname( __FILE__ ) . '/../mixins_setup/global-block.php' );

  $values = array(
    'global_block_id' => x_module_value( '', 'all', true )
  );

  return x_bar_mixin_values( $values, $settings );

}
