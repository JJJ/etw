<?php

// =============================================================================
// CORNERSTONE/INCLUDES/ELEMENTS/MIXINS/_TEXT-FORMAT.PHP
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

function x_control_text_format( $settings = array() ) {

  // Setup
  // -----

  $t_pre             = ( isset( $settings['t_pre'] )             ) ? $settings['t_pre'] . ' ' : '';
  $k_pre             = ( isset( $settings['k_pre'] )             ) ? $settings['k_pre'] . '_' : '';
  $group             = ( isset( $settings['group'] )             ) ? $settings['group']       : 'general';
  $options           = ( isset( $settings['options'] )           ) ? $settings['options']     : array();
  $condition         = ( isset( $settings['condition'] )         ) ? $settings['condition']   : array();
  $no_font_family    = ( isset( $settings['no_font_family'] )    ) ? true                     : false;
  $no_font_weight    = ( isset( $settings['no_font_weight'] )    ) ? true                     : false;
  $no_font_size      = ( isset( $settings['no_font_size'] )      ) ? true                     : false;
  $no_line_height    = ( isset( $settings['no_line_height'] )    ) ? true                     : false;
  $no_letter_spacing = ( isset( $settings['no_letter_spacing'] ) ) ? true                     : false;


  // Data
  // ----

  $data = array(
    'type'       => 'text-format',
    'title'      => __( $t_pre . 'Text Format', '__x__' ),
    'group'      => $group,
    'options'    => $options,
    'conditions' => x_module_conditions( $condition ),
  );


  // Keys
  // ----

  $keys = array(
    'font_family'    => $k_pre . 'font_family',
    'font_weight'    => $k_pre . 'font_weight',
    'font_size'      => $k_pre . 'font_size',
    'line_height'    => $k_pre . 'line_height',
    'letter_spacing' => $k_pre . 'letter_spacing',
  );

  if ( $no_font_family )    { unset( $keys['font_family'] );    }
  if ( $no_font_weight )    { unset( $keys['font_weight'] );    }
  if ( $no_font_size )      { unset( $keys['font_size'] );      }
  if ( $no_line_height )    { unset( $keys['line_height'] );    }
  if ( $no_letter_spacing ) { unset( $keys['letter_spacing'] ); }

  $data['keys'] = $keys;


  // Returned Value
  // --------------

  $control = array( $data );

  return $control;

}
