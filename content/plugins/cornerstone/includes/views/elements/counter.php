<?php

// =============================================================================
// VIEWS/BARS/COUNTER.PHP
// -----------------------------------------------------------------------------
// Counter element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Attr Values
// -------------------

$counter_data = array(
  'numStart' => floatval( $counter_start ),
  'numEnd'   => floatval( $counter_end ),
  'numSpeed' => floatval( cs_get_unitless_ms( $counter_duration ) ),
  'selector' => '.x-counter-number'
);


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-counter', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts = array_merge( $atts, cs_element_js_atts( 'counter', $counter_data ) );


// Content
// -------

$counter_before_content        = ( $counter_before_after === true && ! empty( $counter_before_content ) ) ? '<div class="x-counter-before">' . $counter_before_content . '</div>' : '';
$counter_after_content         = ( $counter_before_after === true && ! empty( $counter_after_content )  ) ? '<div class="x-counter-after">' . $counter_after_content . '</div>' : '';
$counter_number_prefix_content = ( ! empty( $counter_number_prefix_content ) ) ? '<span class="x-counter-number-prefix">' . $counter_number_prefix_content . '</span>' : '';
$counter_number_suffix_content = ( ! empty( $counter_number_suffix_content ) ) ? '<span class="x-counter-number-suffix">' . $counter_number_suffix_content . '</span>' : '';

$counter_content = $counter_before_content
                   . '<div class="x-counter-number-wrap">'
                     . $counter_number_prefix_content
                     . '<span class="x-counter-number">' . $counter_start . '</span>'
                     . $counter_number_suffix_content
                   . '</div>'
                 . $counter_after_content;


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo $counter_content; ?>
</div>
