<?php

// =============================================================================
// VIEWS/BARS/CARD.PHP
// -----------------------------------------------------------------------------
// Card element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-card', 'is-' . $card_interaction, 'has-not-flipped', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = array_merge( $atts, cs_element_js_atts( 'card', array() ) );


// Data: Partials
// --------------

$data_headline_front = cs_extract( $_view_data, array( 'card_front_text' => 'text' ) );
$data_headline_back  = cs_extract( $_view_data, array( 'card_back_text' => 'text' ) );
$data_anchor         = cs_extract( $_view_data, array( 'anchor' => '' ) );

if ( $card_front_bg_advanced == true ) {
  $data_bg_front = cs_extract( $_view_data, array( 'card_front_bg' => 'bg' ) );
  $card_bg_front = cs_get_partial_view( 'bg', $data_bg_front );
}

if ( $card_back_bg_advanced == true ) {
  $data_bg_back = cs_extract( $_view_data, array( 'card_back_bg' => 'bg' ) );
  $card_bg_back = cs_get_partial_view( 'bg', $data_bg_back );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <div class="x-card-faces">
    <div class="x-card-face is-front">
      <?php echo cs_get_partial_view( 'text', $data_headline_front ); ?>
      <?php if ( isset( $card_bg_front ) ) { echo $card_bg_front; } ?>
    </div>
    <div class="x-card-face is-back">
      <?php echo cs_get_partial_view( 'text', $data_headline_back ); ?>
      <?php echo cs_get_partial_view( 'anchor', $data_anchor ); ?>
      <?php if ( isset( $card_bg_back ) ) { echo $card_bg_back; } ?>
    </div>
  </div>
</div>
