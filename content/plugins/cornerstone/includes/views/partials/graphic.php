<?php

// =============================================================================
// VIEWS/PARTIALS/GRAPHIC.PHP
// -----------------------------------------------------------------------------
// Graphic partial.
// =============================================================================

$class = ( isset( $class ) ) ? $class : '';
$atts  = ( isset( $atts )  ) ? $atts  : array();


// Clean $graphic_interaction Value
// --------------------------------

if ( $graphic_has_interactions === true ) {
  $graphic_interaction = str_replace( 'anchor-', '', $graphic_interaction );
}


// Prepare Attr Values
// -------------------

$classes = array( 'x-graphic', $class );


// Prepare Atts
// ------------

$atts = array_merge( array(
  'class'       => x_attr_class( $classes ),
  'aria-hidden' => "true",
), $atts );

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Output
// ------

?>

<span <?php echo x_atts( $atts ); ?>>

  <?php

  switch ( $graphic_type ) {


    // Type: Icon
    // ----------
    // 01. Graphic interaction is a class-based transition if primary and
    //     secondary icons are both present.
    // 02. Graphic interaction is an animation if only the primary icon is
    //     present.

    case 'icon' :

      $this_has_alt         = $graphic_has_alt === true && $graphic_icon_alt_enable === true;
      $this_has_interaction = $graphic_has_interactions === true && $graphic_interaction !== 'none';
      $interaction_class    = ( $this_has_alt && $this_has_interaction ) ? $graphic_interaction : ''; // 01


      // Icon Args: Base
      // ---------------

      $add_in = array(
        'class' => x_attr_class( array( 'x-graphic-icon', 'x-graphic-primary', $interaction_class ) ),
      );

      if ( ! $this_has_alt && $this_has_interaction ) {
        $add_in['atts'] = array( 'data-x-single-anim' => $graphic_interaction ); // 02
      }

      $icon_args = array(
        'add_in'    => $add_in,
        'keep_out'  => array( 'graphic_icon_alt' ),
        'find_data' => array( 'graphic_icon' => 'icon' )
      );


      // Icon Args: Alt
      // --------------

      $icon_alt_args = array(
        'add_in'    => array( 'class' => x_attr_class( array( 'x-graphic-icon', 'x-graphic-secondary', $interaction_class ) ) ),
        'keep_out'  => array( 'graphic_icon' ),
        'find_data' => array( 'graphic_icon' => 'icon' )
      );


      // Output
      // ------

      x_get_view( 'partials', 'icon', '', x_get_partial_data( $_custom_data, $icon_args ), true );

      if ( $this_has_alt ) {
        x_get_view( 'partials', 'icon', '', x_get_partial_data( $_custom_data, $icon_alt_args ), true );
      }

      break;


    // Type: Image
    // -----------
    // 01. Graphic interaction is a class-based transition if primary and
    //     secondary icons are both present.
    // 02. Graphic interaction is an animation if only the primary icon is
    //     present.

    case 'image' :

      $this_has_alt         = $graphic_has_alt === true && $graphic_image_alt_enable === true;
      $this_has_interaction = $graphic_has_interactions === true && $graphic_interaction !== 'none';
      $interaction_class    = ( $this_has_alt && $this_has_interaction ) ? $graphic_interaction : ''; // 01


      // Image Args: Base
      // ----------------

      $add_in = array(
        'class' => x_attr_class( array( 'x-graphic-image', 'x-graphic-primary', $interaction_class ) ),
      );

      if ( ! $this_has_alt && $this_has_interaction ) {
        $add_in['atts'] = array( 'data-x-single-anim' => $graphic_interaction ); // 02
      }

      $image_args = array(
        'add_in'    => $add_in,
        'keep_out'  => array( 'graphic_image_src_alt' ),
        'find_data' => array( 'graphic_image' => 'image' )
      );


      // Image Args: Alt
      // ---------------

      $image_alt_args = array(
        'add_in'    => array( 'class' => x_attr_class( array( 'x-graphic-image', 'x-graphic-secondary', $interaction_class ) ) ),
        'keep_out'  => array( 'graphic_image_src' ),
        'find_data' => array( 'graphic_image' => 'image' )
      );


      // Image Output
      // ------------
      
      x_get_view( 'partials', 'image', '', x_get_partial_data( $_custom_data, $image_args ), true );

      if ( $this_has_alt ) {
        x_get_view( 'partials', 'image', '', x_get_partial_data( $_custom_data, $image_alt_args ), true );
      }

      break;


    // Type: Toggle
    // ------------

    case 'toggle' :

      $toggle_args = array(
        'add_in'    => array( 'class' => 'x-graphic-toggle' ),
        'find_data' => array( 'toggle' => '' )
      );


      // Toggle Output
      // -------------

      x_get_view( 'partials', 'toggle', '', x_get_partial_data( $_custom_data, $toggle_args ), true );

      break;

  }

  ?>

</span>