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
$anchor_is_active      = ( isset( $anchor_is_active )      ) ? $anchor_is_active      : false;


// Prepare Attr Values
// -------------------

if ( $anchor_type === 'menu-item' ) {
  if ( ! $anchor_is_active ) {
    $class = '';
  }
}

$classes = array( $mod_id, 'x-anchor', 'x-anchor-' . $anchor_type, $class );

if ( isset( $anchor_interactive_content ) && $anchor_interactive_content == true ) {
  $classes[] = 'has-int-content';
}


// Atts - Foundation
// -----------------

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


// Atts - Sharing / Linking
// ------------------------

if ( isset( $anchor_share_enabled ) && isset( $anchor_share_type ) && isset( $anchor_share_title ) && $anchor_share_enabled ) {

  $atts = cs_atts_for_social_sharing( $atts, $anchor_share_type, $anchor_share_title );

} else {

  if ( isset( $anchor_href ) && ! empty( $anchor_href ) ) {
    $atts['href'] = $anchor_href;
  }

  if ( isset( $anchor_nofollow ) && $anchor_nofollow == true ) {
    $atts['rel'] = 'nofollow';
  }

  if ( isset( $anchor_blank ) && $anchor_blank == true ) {
    $atts['target'] = '_blank';
    $atts = cs_atts_with_targeted_link_rel( $atts );
  }

}


// Atts - Toggle
// -------------

if ( $anchor_type == 'toggle' ) {
  $atts['data-x-toggle']     = true;
  $atts['data-x-toggleable'] = $mod_id;
  if ( ! empty( $toggle_hash ) ) {
    $atts['data-x-toggle-hash'] = $toggle_hash;
  }
}


// Atts - Accessibility
// --------------------

if ( isset( $anchor_aria_controls ) ) { $atts['aria-controls'] = $anchor_aria_controls; }
if ( isset( $anchor_aria_expanded ) ) { $atts['aria-expanded'] = $anchor_aria_expanded; }
if ( isset( $anchor_aria_haspopup ) ) { $atts['aria-haspopup'] = $anchor_aria_haspopup; }
if ( isset( $anchor_aria_label )    ) { $atts['aria-label']    = $anchor_aria_label;    }
if ( isset( $anchor_aria_selected ) ) { $atts['aria-selected'] = $anchor_aria_selected; }


// Content Classes
// ---------------

$classes_content = array( 'x-anchor-content' );

if ( isset( $anchor_interactive_content ) && $anchor_interactive_content == true ) {
  $classes_content[] = $anchor_interactive_content_interaction;
}


// Text
// ----

if ( isset( $anchor_text ) && $anchor_text == true ) {

  $anchor_text_content = cs_anchor_text_content( $_view_data, 'main' );

  if ( isset( $anchor_interactive_content ) && $anchor_interactive_content == true ) {
    $anchor_text_interactive_content = cs_anchor_text_content( $_view_data, 'interactive' );
  }

}


// Graphic
// -------

if ( isset( $anchor_graphic ) && $anchor_graphic == true ) {

  $data_anchor_graphic_content = array_merge( $_view_data, array( 'anchor_is_active' => $anchor_is_active ) );
  $anchor_graphic_content      = cs_anchor_graphic_content( $data_anchor_graphic_content, 'main' );

  if ( isset( $anchor_interactive_content ) && $anchor_interactive_content == true ) {
    $anchor_graphic_interactive_content = cs_anchor_graphic_content( $data_anchor_graphic_content, 'interactive' );
  }

  if ( $anchor_type === 'menu-item' && isset( $anchor_graphic_menu_item_display ) && $anchor_graphic_menu_item_display === 'off' ) {
    unset( $anchor_graphic_content );

    if ( isset( $anchor_interactive_content ) && $anchor_interactive_content == true ) {
      unset( $anchor_graphic_interactive_content );
    }
  }

}


// Sub Indicator
// -------------

if ( $anchor_type == 'menu-item' && isset( $anchor_sub_indicator ) && $anchor_sub_indicator == true ) {

  if ( ! empty( $anchor_sub_indicator_icon ) ) {

    $anchor_sub_indicator_atts = array(
      'class'               => 'x-anchor-sub-indicator',
      'data-x-skip-scroll'  => 'true',
      'aria-hidden'         => 'true',
    );

    $icon_data = fa_get_attr( $anchor_sub_indicator_icon );

    $anchor_sub_indicator_atts[$icon_data['attr']] = $icon_data['entity'];

    if ( isset( $anchor_sub_menu_trigger_location ) && $anchor_sub_menu_trigger_location === 'sub-indicator' ) {
      $anchor_sub_indicator_atts['data-x-toggle-nested-trigger'] = true;
    }

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
    $primary_particle_class   = ( $anchor_is_active && isset( $anchor_primary_particle_always_active ) && $anchor_primary_particle_always_active === true ) ? 'x-anchor-particle-primary x-always-active' : 'x-anchor-particle-primary';
    $anchor_particle_content .= cs_get_partial_view(
      'particle',
      array_merge(
        cs_extract( $_view_data, array( 'anchor_primary_particle' => 'particle' ) ),
        array( 'particle_class' => $primary_particle_class )
      )
    );
  }

  if ( $has_secondary_particle ) {
    $secondary_particle_class = ( $anchor_is_active && isset( $anchor_secondary_particle_always_active ) && $anchor_secondary_particle_always_active === true ) ? 'x-anchor-particle-secondary x-always-active' : 'x-anchor-particle-secondary';
    $anchor_particle_content .= cs_get_partial_view(
      'particle',
      array_merge(
        cs_extract( $_view_data, array( 'anchor_secondary_particle' => 'particle' ) ),
        array( 'particle_class' => $secondary_particle_class )
      )
    );
  }

}


// Interactive Content
// -------------------

if ( isset( $anchor_interactive_content ) && $anchor_interactive_content == true ) {

  $classes_interactive_content        = array_merge( $classes_content, array( 'is-int' ) );
  $anchor_graphic_interactive_content = ( isset( $anchor_graphic_interactive_content ) ) ? $anchor_graphic_interactive_content : '';
  $anchor_text_interactive_content    = ( isset( $anchor_text_interactive_content )    ) ? $anchor_text_interactive_content    : '';

  $anchor_interactive_content_content = '<div class="' . x_attr_class( $classes_interactive_content ) . '">'
                                        . $anchor_graphic_interactive_content
                                        . $anchor_text_interactive_content
                                      . '</div>';

}


// Output
// ------

?>

<a <?php echo x_atts( $atts ); ?>>

  <?php echo $anchor_before_content; ?>

  <div class="<?php echo x_attr_class( $classes_content ); ?>">
    <?php if ( isset( $anchor_graphic_content )       ) : echo $anchor_graphic_content;       endif; ?>
    <?php if ( isset( $anchor_text_content )          ) : echo $anchor_text_content;          endif; ?>
    <?php if ( isset( $anchor_sub_indicator_content ) ) : echo $anchor_sub_indicator_content; endif; ?>
  </div>

  <?php if ( isset( $anchor_interactive_content_content ) ) : echo $anchor_interactive_content_content; endif; ?>
  <?php if ( isset( $anchor_particle_content )            ) : echo $anchor_particle_content;            endif; ?>

  <?php echo $anchor_after_content; ?>

</a>