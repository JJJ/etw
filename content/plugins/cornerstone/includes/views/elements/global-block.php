<?php

// =============================================================================
// VIEWS/ELEMENTS/GLOBAL-BLOCK.PHP
// -----------------------------------------------------------------------------
// Global Block element.
// =============================================================================

$mod_id = ( isset( $mod_id ) ) ? $mod_id : '';
$class  = ( isset( $class )  ) ? $class  : '';
$global_block_id = (int) $global_block_id;



// Start Rendering Isolation
// -------------------

$gb_top_level = false;

if ( ! apply_filters( '_cs_rendering_global_block', false ) ) {
  $gb_top_level = true;
  do_action( '_cs_rendering_global_block_begin' );
  add_filter('_cs_rendering_global_block', '__return_true' );
}



// Prepare Attr Values
// -------------------

$classes = array( $mod_id, 'cs-content', 'x-global-block' );

$classes[] = "x-global-block-$global_block_id";
$classes[] = $class;


// Prepare Atts
// ------------

$atts = array(
  'class' => x_attr_class( $classes ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts['id'] = $id;
}


// Validation
// ------------------------

if ( ! $global_block_id ) {
  return;
}

$error = false;
$current_id = (int) get_the_ID();
$global_block_post = get_post( $global_block_id );
if ( ! is_a($global_block_post, 'WP_Post' ) ) {
  $error = 'Unable to locate Global Block';
} else if ( 'cs_global_block' !== $global_block_post->post_type ) {
  $error = 'The Global Block element was passed a non Global Block ID.';
}



// Prevent Self Referencing
// ------------------------

global $cs_global_block_ancestory;

if ( ! isset( $cs_global_block_ancestory ) ) {
  $cs_global_block_ancestory = array();
}

//
// If a Global block ever attempts to reference itself (even through nesting)
// we need to abort and show an error message to avoid an infinite loop.
//

if ( in_array( $global_block_id, $cs_global_block_ancestory, true) || $global_block_id === $current_id ) {

  $error = 'Global Blocks can not reference themselves';

}


// Prepare Content
// ---------------

if ( ! $error ) {

  array_push( $cs_global_block_ancestory, $global_block_id );
  $content = str_replace( '[cs_content]', '[cs_content _p="' . $global_block_id . '" no_wrap=true]', $global_block_post->post_content );
  $content = do_shortcode( $content );
  array_pop( $cs_global_block_ancestory );

  $post_settings = CS()->common()->get_post_settings( $global_block_id );

  if ( apply_filters( '_cornerstone_custom_css', isset( $post_settings['custom_css'] ) ) ) {
    CS()->loadComponent('Styling')->add_styles( "$global_block_id-custom", $post_settings['custom_css'] );
  }

  if ( isset( $post_settings['custom_js'] ) ) {
    $content .= '<script>' . $post_settings['custom_js'] . '</script>';
  }

  if ( ! $content ) {
    $error = 'This Global Block does not have any content.';
  }

}

if ( $error ) {
  $content = apply_filters( 'cs_global_block_error', "<div style=\"padding: 35px; line-height: 1.5; text-align: center; color: #000; background-color: #fff;\">$error</div>");
}



// End Rendering Isolation
// -------------------

if ( $gb_top_level ) {
  remove_filter('_cs_rendering_global_block', '__return_true' );
  do_action( '_cs_rendering_global_block_end' );
}



// Output
// ------

?>

<div <?php echo x_atts( apply_filters( 'cs_global_block_atts', $atts, $global_block_id ) ); ?>><?php echo $content; ?></div>
