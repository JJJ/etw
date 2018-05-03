<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_FLEX-LAYOUT-CSS.PHP
// -----------------------------------------------------------------------------
// V2 element mixins.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Control
// =============================================================================

// Control
// =============================================================================

function x_control_flex_layout_css( $settings = array() ) {

  // Setup
  // -----

  $t_pre      = ( isset( $settings['t_pre'] )       ) ? $settings['t_pre'] . ' ' : '';
  $k_pre      = ( isset( $settings['k_pre'] )       ) ? $settings['k_pre'] . '_' : '';
  $group      = ( isset( $settings['group'] )       ) ? $settings['group']       : 'general';
  $options    = ( isset( $settings['options'] )     ) ? $settings['options']     : array();
  $condition  = ( isset( $settings['condition'] )   ) ? $settings['condition']   : array();
  $no_wrap    = ( isset( $settings['no_wrap'] )     ) ? true                     : false;
  $no_justify = ( isset( $settings['no_justify'] )  ) ? true                     : false;
  $no_align   = ( isset( $settings['no_nofollow'] ) ) ? true                     : false;


  // Data
  // ----

  $data = array(
    'type'       => 'flex-layout',
    'title'      => __( $t_pre . 'Flex Layout', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Keys
  // ----

  $keys = array(
    'direction' => $k_pre . 'flex_direction',
    'wrap'      => $k_pre . 'flex_wrap',
    'justify'   => $k_pre . 'flex_justify',
    'align'     => $k_pre . 'flex_align',
  );

  if ( $no_wrap === true )    { unset( $keys['wrap'] );    }
  if ( $no_justify === true ) { unset( $keys['justify'] ); }
  if ( $no_align === true )   { unset( $keys['align'] );   }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}
