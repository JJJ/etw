<?php

// =============================================================================
// VIEWS/PARTIALS/DROPDOWN.PHP
// -----------------------------------------------------------------------------
// Dropdown partial.
// =============================================================================

$mod_id = ( isset( $mod_id )                                ) ? $mod_id : '';
$tag    = ( isset( $dropdown_is_list ) && $dropdown_is_list ) ? 'ul' : 'div';


// Prepare Attr Values
// -------------------

$id_slug = ( isset( $id ) && ! empty( $id ) ) ? $id . '-dropdown' : $mod_id . '-dropdown';
$classes = x_attr_class( array( $mod_id, 'x-dropdown', $class ) );


// Prepare Atts
// ------------

$atts = array(
  'id'                => $id_slug,
  'class'             => $classes,
  'data-x-stem'       => NULL,
  'data-x-stem-top'   => NULL,
  'data-x-toggleable' => $mod_id,
  'aria-hidden'       => 'true',
);

if ( isset( $_region ) && $_region === 'left' ) {
  $atts['data-x-stem-top'] = 'h';
}

if ( isset( $_region ) && $_region === 'right' ) {
  $atts['data-x-stem-top'] = 'rh'; 
}


// Output
// ------

?>

<<?php echo $tag ?> <?php echo x_atts( $atts ); ?>>
  <?php echo do_shortcode( $dropdown_content ); ?>
</<?php echo $tag ?>>
