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
  $section_top_separator_content = cs_get_partial_view(
    'separator',
    cs_extract( $_view_data, array( 'section_top_separator' => 'separator' ) )
  );
}


// Separator Partial (Bottom)
// --------------------------

$section_bottom_separator_content = NULL;

if ( $section_bottom_separator === true ) {
  $section_bottom_separator_content = cs_get_partial_view(
    'separator',
    cs_extract( $_view_data, array( 'section_bottom_separator' => 'separator' ) )
  );
}


// Background Partial
// ------------------

$section_bg = NULL;

if ( $section_bg_advanced === true ) {
  $section_bg = cs_get_partial_view( 'bg', cs_extract( $_view_data, array( 'bg' => '' ) ) );
}


// Output
// ------

// var_dump($_view_data);
?>

<div <?php echo x_atts( $atts ); ?>>
  <?php echo $section_top_separator_content; ?>
  <?php echo $section_bg; ?>
  <?php do_action( 'x_section', $_modules ); ?>
  <?php echo $section_bottom_separator_content; ?>
</div>
