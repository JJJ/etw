<?php

// =============================================================================
// VIEWS/PARTIALS/TEXT.PHP
// -----------------------------------------------------------------------------
// Text partial.
// =============================================================================

$mod_id      = ( isset( $mod_id ) ) ? $mod_id : '';
$is_headline = $text_type === 'headline';


// Prepare Atts
// ------------

$classes = array( $mod_id, 'x-text', $class );

if ( $is_headline ) {
  $classes[] = 'x-text-headline';
}

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Subheadline
// -----------
// Optional subheadline output for headline text content.

if ( $is_headline && $text_subheadline === true && ! empty( $text_subheadline_content ) ) {
  $text_subheadline_content = '<' . $text_subheadline_tag . ' class="x-text-content-text-subheadline">' . do_shortcode( $text_subheadline_content ) . '</' . $text_subheadline_tag . '>';
} else {
  $text_subheadline_content = NULL;
}


// Graphic
// -------
// Optional graphic output for headlines.

if ( $is_headline && isset( $text_graphic ) && $text_graphic === true ) {
  $data_graphic         = x_get_partial_data( $_custom_data, array( 'add_in' => array( 'class' => '' ), 'find_data' => array( 'text_graphic' => 'graphic' ) ) );
  $text_graphic_content = x_get_view( 'partials', 'graphic', '', $data_graphic, false );
} else {
  $text_graphic_content = NULL;
}


// Text
// ----
// The primary text content. Extra markup structure is applied for headlines.

$the_text_content = '';

if ( $is_headline ) {

  if ( $text_typing === true ) {

    $text_typing_data = array(
      'strings'     => explode( "\n", esc_attr( cs_decode_shortcode_attribute( $text_typing_content ) ) ),
      'type_speed'  => cs_get_unitless_ms( $text_typing_speed ),
      'back_speed'  => cs_get_unitless_ms( $text_typing_back_speed ),
      'start_delay' => cs_get_unitless_ms( $text_typing_delay ),
      'back_delay'  => cs_get_unitless_ms( $text_typing_back_delay ),
      'loop'        => $text_typing_loop,
      'show_cursor' => $text_typing_cursor,
      'cursor'      => cs_decode_shortcode_attribute( $text_typing_cursor_content ),
    );

    $atts = array_merge( $atts, cs_element_js_atts( 'text_type', $text_typing_data ) );

    $the_text_headline = esc_html( $text_typing_prefix ) . '<span class="x-text-typing"></span>' . esc_html( $text_typing_suffix );

  } else {

    $the_text_headline = do_shortcode( $text_content );

  }

  $the_text_content .= '<span class="x-text-content">';
    $the_text_content .= $text_graphic_content;
    $the_text_content .= '<span class="x-text-content-text">';
      $the_text_content .= ( $text_subheadline_reverse === true ) ? $text_subheadline_content : '';
      $the_text_content .= '<' . $text_tag . ' class="x-text-content-text-primary">' . $the_text_headline . '</' . $text_tag . '>';
      $the_text_content .= ( $text_subheadline_reverse === false ) ? $text_subheadline_content : '';
    $the_text_content .= '</span>';
  $the_text_content .= '</span>';

} else {

  $the_text_content .= do_shortcode( $text_content );

}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo $the_text_content; ?>
</div>
