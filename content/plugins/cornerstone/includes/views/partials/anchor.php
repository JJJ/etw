<?php

// =============================================================================
// VIEWS/PARTIALS/ANCHOR.PHP
// -----------------------------------------------------------------------------
// Anchor partial.
// =============================================================================

$mod_id                = ( isset( $mod_id )                ) ? $mod_id                : '';
$atts                  = ( isset( $atts )                  ) ? $atts                  : array();
$anchor_before_content = ( isset( $anchor_before_content ) ) ? $anchor_before_content : '';
$anchor_after_content  = ( isset( $anchor_after_content )  ) ? $anchor_after_content  : '';


// Prepare Attr Values
// -------------------

if ( $anchor_type === 'menu-item' ) {
  $class = '';
}

$classes = array( $mod_id, 'x-anchor', 'x-anchor-' . $anchor_type, $class );


// Atts
// ----

$atts = array_merge( array(
  'class'    => x_attr_class( $classes ),
  'tabindex' => 0
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  if ( $anchor_type === 'button' ) {
    $atts['id'] = $id;
  } else if ( $anchor_type === 'toggle' ) {
    $atts['id'] = $id . '-anchor-' . $anchor_type;
  }
}

if ( isset( $anchor_href ) && ! empty( $anchor_href ) ) {
  $atts['href'] = $anchor_href;
}

if ( isset( $anchor_blank ) && $anchor_blank == true ) {
  $atts['target'] = '_blank';
}

if ( isset( $anchor_nofollow ) && $anchor_nofollow == true ) {
  $atts['rel'] = 'nofollow';
}

if ( $anchor_type == 'toggle' ) {
  $atts['data-x-toggle']     = true;
  $atts['data-x-toggleable'] = $mod_id;
}

if ( isset( $anchor_aria_controls ) ) {
  $atts['aria-controls'] = $anchor_aria_controls;
}

if ( isset( $anchor_aria_expanded ) ) {
  $atts['aria-expanded'] = $anchor_aria_expanded;
}

if ( isset( $anchor_aria_haspopup ) ) {
  $atts['aria-haspopup'] = $anchor_aria_haspopup;
}

if ( isset( $anchor_aria_label ) ) {
  $atts['aria-label'] = $anchor_aria_label;
}

if ( isset( $anchor_aria_selected ) ) {
  $atts['aria-selected'] = $anchor_aria_selected;
}


// Text
// ----

if ( isset( $anchor_text ) && $anchor_text == true ) {

  $p_atts = array( 'class' => 'x-anchor-text-primary'   );
  $s_atts = array( 'class' => 'x-anchor-text-secondary' );

  if ( $anchor_text_interaction != 'none' ) {
    $anchor_text_interaction      = str_replace( 'anchor-', '', $anchor_text_interaction );
    $p_atts['data-x-single-anim'] = $anchor_text_interaction;
    $s_atts['data-x-single-anim'] = $anchor_text_interaction;
  }

  $p = ( ! empty( $anchor_text_primary_content )   ) ? '<span ' . x_atts( $p_atts ) . '>' . $anchor_text_primary_content . '</span>'   : '';
  $s = ( ! empty( $anchor_text_secondary_content ) ) ? '<span ' . x_atts( $s_atts ) . '>' . $anchor_text_secondary_content . '</span>' : '';

  $anchor_text_order   = ( $anchor_text_reverse == true ) ? $s . $p : $p . $s;
  $anchor_text_content = '<span class="x-anchor-text">' . $anchor_text_order . '</span>';

}


// Graphic
// -------

if ( isset( $anchor_graphic ) && $anchor_graphic == true ) {

  $data_graphic           = x_get_partial_data( $_custom_data, array( 'add_in' => array( 'id' => '', 'class' => '' ), 'find_data' => array( 'anchor_graphic' => 'graphic', 'toggle' => '' ) ) );
  $anchor_graphic_content = x_get_view( 'partials', 'graphic', '', $data_graphic, false );

}


// Sub Indicator
// -------------

if ( $anchor_type == 'menu-item' && isset( $anchor_sub_indicator ) && $anchor_sub_indicator == true ) {

  if ( ! empty( $anchor_sub_indicator_icon ) ) {

    $anchor_sub_indicator_atts = array(
      'class'       => 'x-anchor-sub-indicator',
      'data-x-icon' => '&#x' . fa_unicode( $anchor_sub_indicator_icon ) . ';',
      'aria-hidden' => 'true',
    );

    $anchor_sub_indicator_content = '<i ' . x_atts( $anchor_sub_indicator_atts ) . '></i>';

  }

}


// Particles
// ---------

$has_primary_particle   = isset( $anchor_primary_particle ) && $anchor_primary_particle == true;
$has_secondary_particle = isset( $anchor_secondary_particle ) && $anchor_secondary_particle == true;

if ( $has_primary_particle || $has_secondary_particle ) {

  $anchor_particle_content = '';

  if ( $has_primary_particle ) {
    $data_particle_p          = x_get_partial_data( $_custom_data, array( 'add_in' => array( 'particle_class' => 'x-anchor-particle-primary' ), 'find_data' => array( 'anchor_primary_particle' => 'particle' ) ) );
    $anchor_particle_content .= x_get_view( 'partials', 'particle', '', $data_particle_p, false );
  }

  if ( $has_secondary_particle ) {
    $data_particle_s          = x_get_partial_data( $_custom_data, array( 'add_in' => array( 'particle_class' => 'x-anchor-particle-secondary' ), 'find_data' => array( 'anchor_secondary_particle' => 'particle' ) ) );
    $anchor_particle_content .= x_get_view( 'partials', 'particle', '', $data_particle_s, false );
  }

}


// Output
// ------

?>

<a <?php echo x_atts( $atts ); ?>>

  <?php echo $anchor_before_content; ?>

  <span class="x-anchor-content">
    <?php if ( isset( $anchor_graphic_content )       ) : echo $anchor_graphic_content;       endif; ?>
    <?php if ( isset( $anchor_text_content )          ) : echo $anchor_text_content;          endif; ?>
    <?php if ( isset( $anchor_sub_indicator_content ) ) : echo $anchor_sub_indicator_content; endif; ?>
    <?php if ( isset( $anchor_particle_content )      ) : echo $anchor_particle_content;      endif; ?>
  </span>

  <?php echo $anchor_after_content; ?>

</a>