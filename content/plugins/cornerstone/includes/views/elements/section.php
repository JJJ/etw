<?php

// =============================================================================
// CORNERSTONE/INCLUDES/VIEWS/ELEMENTS/SECTION.PHP
// -----------------------------------------------------------------------------
// Section element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$atts   = ( isset( $atts )   ) ? $atts   : array();


// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'x-section', $class );


// Atts
// ----

$atts = array_merge( array(
  'class' => x_attr_class( $classes ),
), $atts );

if ( isset( $style ) && ! empty( $style ) ) {
  $atts['style'] = $style;
}

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Separator Partial (Top)
// -----------------------

$section_top_separator_content = NULL;

if ( $section_top_separator === true ) {
  $data_section_top_separator    = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'section_top_separator' => 'separator' ) ) );
  $section_top_separator_content = x_get_view( 'partials', 'separator', '', $data_section_top_separator, false );
}


// Separator Partial (Bottom)
// --------------------------

$section_bottom_separator_content = NULL;

if ( $section_bottom_separator === true ) {
  $data_section_bottom_separator    = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'section_bottom_separator' => 'separator' ) ) );
  $section_bottom_separator_content = x_get_view( 'partials', 'separator', '', $data_section_bottom_separator, false );
}


// Background Partial
// ------------------

$section_bg = NULL;

if ( $section_bg_advanced === true ) {
  $data_bg    = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'bg' => '' ) ) );
  $section_bg = x_get_view( 'partials', 'bg', '', $data_bg, false );
}


// Output
// ------

?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo $section_top_separator_content; ?>
  <?php echo $section_bg; ?>
  <?php do_action( 'x_section', $_modules ); ?>
  <?php echo $section_bottom_separator_content; ?>
</div>
