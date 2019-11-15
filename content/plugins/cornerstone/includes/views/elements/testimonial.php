<?php

// =============================================================================
// VIEWS/BARS/TESTIMONIAL.PHP
// -----------------------------------------------------------------------------
// Testimonial element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';


// Conditions
// ----------

$has_cite    = isset( $testimonial_cite_content ) && ! empty( $testimonial_cite_content );
$has_graphic = isset( $testimonial_graphic ) && $testimonial_graphic === true;
$has_rating  = isset( $testimonial_rating ) && $testimonial_rating === true;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( array( $mod_id, 'x-testimonial', $class ) ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Graphic
// -------

$the_graphic = "";

if ( $has_graphic ) {
  $the_graphic = cs_get_partial_view(
    'graphic',
    array_merge(
      cs_extract( $_view_data, array( 'testimonial_graphic' => 'graphic' ) ),
      array( 'id' => '' )
    )
  );
}


// Testimonial
// -----------

$the_testimonial = '<div class="x-testimonial-text">' . do_shortcode( $testimonial_content ) . '</div>';


// Rating
// ------

$the_rating = "";

if ( $has_rating ) {
  $the_rating = cs_get_partial_view(
    'rating',
    array_merge(
      cs_extract( $_view_data, array( 'testimonial_rating' => 'rating' ) ),
      array( 'mod_id' => '', 'id' => '' )
    )
  );
}


// Citation
// --------

$the_citation = "";

if ( $has_cite || $has_graphic || $has_rating ) {

  $the_cite_text            = ( $has_cite                                 ) ? '<span class="x-testimonial-cite-text">' . $testimonial_cite_content . '</span>'    : '';
  $the_cite_content_ordered = ( $testimonial_rating_position === 'before' ) ? $the_rating . $the_cite_text                                                        : $the_cite_text . $the_rating;
  $the_cite_content         = ( $has_cite || $has_rating                  ) ? '<span class="x-testimonial-cite-content">' . $the_cite_content_ordered . '</span>' : '';
  $the_citation             = '<span class="x-testimonial-cite">';

  if ( $has_graphic && $testimonial_graphic_position === 'cite' ) {
    $the_citation .= $the_graphic . $the_cite_content;
  } else {
    $the_citation .= $the_cite_content;
  }

  $the_citation .= '</span>';

}


// Output
// ------

?>

<blockquote <?php echo x_atts( $atts ); ?>>
  <?php if ( $has_graphic && $testimonial_graphic_position === 'outer' ) : ?>
    <?php echo $the_graphic; ?>
  <?php endif; ?>
  <div class="x-testimonial-content">
    <?php echo $the_testimonial; ?>
    <?php echo $the_citation; ?>
  </div>
</blockquote>
