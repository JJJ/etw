<?php

// =============================================================================
// VIEWS/BARS/QUOTE.PHP
// -----------------------------------------------------------------------------
// Quote element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-quote', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Quote Marks
// -----------

$the_opening_mark = ( $quote_marks_opening_graphic === true ) ? x_get_view( 'partials', 'graphic', '', x_get_partial_data( $_custom_data, array( 'add_in' => array( 'id' => '', 'class' => 'x-quote-mark-opening' ), 'find_data' => array( 'quote_marks_opening_graphic' => 'graphic' ) ) ), false ) : '';
$the_closing_mark = ( $quote_marks_closing_graphic === true ) ? x_get_view( 'partials', 'graphic', '', x_get_partial_data( $_custom_data, array( 'add_in' => array( 'id' => '', 'class' => 'x-quote-mark-closing' ), 'find_data' => array( 'quote_marks_closing_graphic' => 'graphic' ) ) ), false ) : '';


// Quote
// -----

$the_quote = '<div class="x-quote-text">' . do_shortcode( $quote_content ) . '</div>';


// Cite
// ----

if ( isset( $quote_cite_content ) && ! empty( $quote_cite_content ) ) {

  $quote_cite_content = '<span class="x-quote-cite-text">' . $quote_cite_content . '</span>';

  $the_cite = '<footer class="x-quote-cite">';

  if ( $quote_cite_graphic === true ) {
    $the_cite_mark  = x_get_view( 'partials', 'graphic', '', x_get_partial_data( $_custom_data, array( 'add_in' => array( 'id' => '', 'class' => 'x-quote-cite-mark' ), 'find_data' => array( 'quote_cite_graphic' => 'graphic' ) ) ), false );
    $the_cite      .= $the_cite_mark . $quote_cite_content;
  } else {
    $the_cite .= $quote_cite_content;
  }

  $the_cite .= '</footer>';

}


// Output
// ------

?>

<blockquote <?php echo x_atts( $atts ); ?>>
  <?php echo $the_opening_mark; ?>
  <div class="x-quote-content">
    <?php echo $the_quote; ?>
    <?php echo $the_cite; ?>
  </div>
  <?php echo $the_closing_mark; ?>
</blockquote>