<?php

// =============================================================================
// VIEWS/PARTIALS/RATING.PHP
// -----------------------------------------------------------------------------
// Rating partial.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';
$atts   = ( isset( $atts )   ) ? $atts   : array();


// Prepare Attr Values
// -------------------

$classes = x_attr_class( array( $mod_id, 'x-rating', $class ) );


// Prepare Values
// --------------
// 01. This was an option initially, but we've hard-coded it for now to keep
//     things more simple.

$rating_scale_min_integer     = intval( cs_dynamic_content( $rating_scale_min_content ) );
$rating_scale_max_integer     = intval( cs_dynamic_content( $rating_scale_max_content ) );

if (!$rating_scale_min_integer || $rating_scale_min_integer < 0 ) {
  $rating_scale_min_integer = 0;
}

if (!$rating_scale_max_integer || $rating_scale_max_integer < 1 ) {
  $rating_scale_max_integer = 1;
}

$rating_value_float           = floatval( cs_dynamic_content( $rating_value_content ) );
$rating_value_maybe_rounded   = $rating_round ? round( $rating_value_float ) : $rating_value_float;
$rating_value_clamped         = max( 0, min( $rating_scale_max_integer, $rating_value_maybe_rounded ) );
$rating_value_integer         = intval( $rating_value_clamped );
$rating_value_decimal         = $rating_value_clamped - $rating_value_integer;

$rating_empty_integer         = $rating_scale_max_integer - $rating_value_integer - 1;

$rating_half_lower_threshhold = apply_filters( 'cs_rating_half_lower_threshhold', 0.25 );
$rating_half_upper_threshhold = apply_filters( 'cs_rating_half_upper_threshhold', 0.75 );

$rating_text_content_find     = array( '{{rating}}', '{{min}}', '{{max}}' );
$rating_text_content_replace  = array( $rating_value_clamped, $rating_scale_min_integer, $rating_scale_max_integer );
$rating_text_content          = apply_filters( 'cs_preview_decode_markup', $rating_text_content );
$rating_text_content          = $rating_text && ! empty( $rating_text_content ) ? str_replace( $rating_text_content_find, $rating_text_content_replace, $rating_text_content ) : "{$rating_value_clamped} / {$rating_scale_max_integer}";


// Partials
// --------

$the_graphic_full  = ( $rating_graphic_type == 'icon' ) ? cs_get_partial_view( 'icon', cs_extract( cs_without( $_view_data, array( 'mod_id' ) ), array( 'rating_graphic_full_icon' => 'icon' ) ) )  : cs_get_partial_view( 'image', cs_extract( cs_without( $_view_data, array( 'mod_id' ) ), array( 'rating_graphic_full_image_src' => 'image_src' ) ) );
$the_graphic_half  = ( $rating_graphic_type == 'icon' ) ? cs_get_partial_view( 'icon', cs_extract( cs_without( $_view_data, array( 'mod_id' ) ), array( 'rating_graphic_half_icon' => 'icon' ) ) )  : cs_get_partial_view( 'image', cs_extract( cs_without( $_view_data, array( 'mod_id' ) ), array( 'rating_graphic_half_image_src' => 'image_src' ) ) );
$the_graphic_empty = ( $rating_graphic_type == 'icon' ) ? cs_get_partial_view( 'icon', cs_extract( cs_without( $_view_data, array( 'mod_id' ) ), array( 'rating_graphic_empty_icon' => 'icon' ) ) ) : cs_get_partial_view( 'image', cs_extract( cs_without( $_view_data, array( 'mod_id' ) ), array( 'rating_graphic_empty_image_src' => 'image_src' ) ) );


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class' => $classes,
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}

$atts_graphic = array(
  'class'      => 'x-rating-graphic',
  'role'       => 'img',
  'aria-label' => esc_attr( $rating_text_content ),
);


// Output
// ------

?>

<span <?php echo x_atts( $atts ); ?>>

  <span <?php echo x_atts( $atts_graphic ); ?>>
    <?php
      for ( $i = 0; $i < $rating_value_integer; $i++ ) {
        echo $the_graphic_full;
      }

      if ( $rating_value_clamped < $rating_scale_max_integer ) {
        switch ( true ) {
          case $rating_value_decimal < $rating_half_lower_threshhold :
            if ( $rating_empty ) {
              echo $the_graphic_empty;
            }
            break;
          case $rating_value_decimal > $rating_half_upper_threshhold :
            echo $the_graphic_full;
            break;
          default :
            echo $the_graphic_half;
            break;
        }

        if ( $rating_empty ) {
          for ( $i = 0; $i < $rating_empty_integer; $i++ ) {
            echo $the_graphic_empty;
          }
        }
      }
    ?>
  </span>

  <?php if ( $rating_text ) : ?>
    <span class="x-rating-text">
      <?php echo apply_filters( 'cs_preview_encode_markup', $rating_text_content ); ?>
    </span>
  <?php endif; ?>

  <?php

  if ( $rating_schema ) :

  $the_item_reviewed_type = ( ! empty( $rating_schema_item_reviewed_type ) ) ? esc_attr( $rating_schema_item_reviewed_type ) : 'Organization';

  $the_item_reviewed_schema = array(
    '@type' => $the_item_reviewed_type,
    'name'  => esc_attr( $rating_schema_item_name_content ),
    'image' => esc_attr( $rating_schema_item_image_src ),
  );

  if ( ! empty ( $rating_schema_item_telephone_content ) ) {
    $the_item_reviewed_schema['telephone'] = esc_attr( $rating_schema_item_telephone_content );
  }

  if ( ! empty ( $rating_schema_item_address_content ) ) {
    $the_item_reviewed_schema['address'] = array(
      '@type' => 'PostalAddress',
      'name'  => esc_attr( $rating_schema_item_address_content ),
    );
  }

  $the_schema = array(
    '@context'     => 'http://schema.org/',
    '@type'        => 'Review',
    'author'       => esc_attr( $rating_schema_author_content ),
    'reviewBody'   => esc_attr( $rating_schema_review_body_content ),
    'itemReviewed' => $the_item_reviewed_schema,
    'reviewRating' => array(
      '@type'        => 'Rating',
      'ratingValue'  => esc_attr( $rating_value_clamped ),
      'worstRating'  => esc_attr( $rating_scale_min_integer ),
      'bestRating'   => esc_attr( $rating_scale_max_integer ),
      'reviewAspect' => 'General Review',
    ),
  );

  ?>
    <script type="application/ld+json"><?php echo json_encode( $the_schema ); ?></script>
  <?php endif; ?>

</span>
