<?php

// =============================================================================
// VIEWS/BARS/ALERT.PHP
// -----------------------------------------------------------------------------
// Alert element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-alert' );

if ( $alert_close === true ) {
  $classes[] = 'fade';
  $classes[] = 'in';
} else {
  $classes[] = 'x-alert-block';
}

$classes[] = $class;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Content
// -------

$alert_close_content = NULL;

if ( $alert_close === true ) {
  $alert_close_content = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo $alert_close_content; ?>
  <?php echo $alert_content; ?>
</div>