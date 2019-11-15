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
    // 02. Always active state is passed through to determine if state changes
    //     should be executed when interacted with.
    // 03. Graphic interaction is an animation if only the primary icon is
    //     present.

    case 'icon' :

      $this_has_alt         = $graphic_has_alt === true && $graphic_icon_alt_enable === true;
      $this_has_interaction = $graphic_has_interactions === true && $graphic_interaction !== 'none';
      $interaction_class    = ( $this_has_alt && $this_has_interaction ) ? $graphic_interaction : ''; // 01
      $always_active_class  = ( isset( $graphic_is_active ) && $graphic_is_active === true ) ? 'x-always-active' : ''; // 02


      // Icon Args: Base
      // ---------------

      $add_in = array(
        'class' => x_attr_class( array( 'x-graphic-icon', 'x-graphic-primary', $interaction_class, $always_active_class ) ),
      );

      if ( ! $this_has_alt && $this_has_interaction ) {
        $add_in['atts'] = array( 'data-x-single-anim' => $graphic_interaction ); // 03
      }


      // Output
      // ------

      echo cs_get_partial_view(
        'icon',
        array_merge(
          cs_extract(
            cs_without( $_view_data, array( 'mod_id', 'graphic_icon_alt' ) ),
            array( 'graphic_icon' => 'icon' )
          ),
          $add_in
        )
      );

      if ( $this_has_alt ) {
        echo cs_get_partial_view(
          'icon',
          array_merge(
            cs_extract(
              cs_without( $_view_data, array( 'mod_id', 'graphic_icon' ) ),
              array( 'graphic_icon' => 'icon' )
            ),
            array( 'class' => x_attr_class( array( 'x-graphic-icon', 'x-graphic-secondary', $interaction_class, $always_active_class ) ) )
          )
        );
      }

      break;


    // Type: Image
    // -----------
    // 01. Graphic interaction is a class-based transition if primary and
    //     secondary icons are both present.
    // 02. Always active state is passed through to determine if state changes
    //     should be executed when interacted with.
    // 03. Graphic interaction is an animation if only the primary icon is
    //     present.

    case 'image' :

      $this_has_alt         = $graphic_has_alt === true && $graphic_image_alt_enable === true;
      $this_has_interaction = $graphic_has_interactions === true && $graphic_interaction !== 'none';
      $interaction_class    = ( $this_has_alt && $this_has_interaction ) ? $graphic_interaction : ''; // 01
      $always_active_class  = ( isset( $graphic_is_active ) && $graphic_is_active === true ) ? 'x-always-active' : ''; // 02


      // Image Args: Base
      // ----------------

      $add_in = array(
        'class' => x_attr_class( array( 'x-graphic-image', 'x-graphic-primary', $interaction_class, $always_active_class ) ),
      );

      if ( ! $this_has_alt && $this_has_interaction ) {
        $add_in['atts'] = array( 'data-x-single-anim' => $graphic_interaction ); // 03
      }

      // Image Output
      // ------------

      echo cs_get_partial_view(
        'image',
        array_merge(
          cs_extract(
            cs_without( $_view_data, array( 'graphic_image_src_alt', 'graphic_image_alt_alt' ) ),
            array( 'graphic_image' => 'image' )
          ),
          $add_in
        )
      );

      if ( $this_has_alt ) {
        echo cs_get_partial_view(
          'image',
          array_merge(
            cs_extract(
              cs_without( $_view_data, array( 'graphic_image_src', 'graphic_image_alt' ) ),
              array( 'graphic_image' => 'image' )
            ),
            array( 'class' => x_attr_class( array( 'x-graphic-image', 'x-graphic-secondary', $interaction_class, $always_active_class ) ) )
          )
        );
      }

      break;


    // Type: Toggle
    // ------------

    case 'toggle' :


      // Toggle Output
      // -------------

      echo cs_get_partial_view(
        'toggle',
        array_merge(
          cs_extract( $_view_data, array( 'toggle' => '' ) ),
          array( 'class' => 'x-graphic-toggle' )
        )
      );

      break;

  }

  ?>

</span>
