<?php

// =============================================================================
// VIEWS/BARS/STATBAR.PHP
// -----------------------------------------------------------------------------
// Statbar element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-statbar', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = array_merge( $atts, cs_element_js_atts( 'statbar', array( 'triggerOffset' => $statbar_trigger_offset ) ) );


// Label
// -----

$statbar_label_content = NULL;

if ( $statbar_label === true ) {

  $statbar_label_class = ( $statbar_label_always_show === true ) ? 'x-statbar-label x-active' : 'x-statbar-label';

  $statbar_label_content  = '<div class="' . $statbar_label_class . '"><span>';
  $statbar_label_content .= ( $statbar_label_custom_text === true ) ? $statbar_label_text_content : $statbar_bar_length;
  $statbar_label_content .= '</span></div>';

}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <div class="x-statbar-bar"><?php echo $statbar_label_content; ?></div>
</div>