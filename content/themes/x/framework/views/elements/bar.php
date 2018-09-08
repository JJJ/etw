<?php

// =============================================================================
// VIEWS/ELEMENTS/BAR.PHP
// -----------------------------------------------------------------------------
// Bar element.
// =============================================================================

$bar_region_is_lr  = $_region === 'left' || $_region === 'right';
$bar_region_is_tbf = $_region === 'top' || $_region === 'bottom' || $_region === 'footer';
$bar_is_sticky     = $_region === 'top' && $bar_sticky === true;


// Prepare Classes
// ---------------

$class_region_specific = 'x-bar-' . $_region;
$class_region_general  = ( $bar_region_is_lr ) ? 'x-bar-v' : 'x-bar-h';
$class_position        = 'x-bar-' . $bar_position;
$class_sticky          = ( $bar_is_sticky ) ? 'x-bar-is-sticky' : '';
$class_hide_initially  = ( $bar_is_sticky && $bar_sticky_hide_initially ) ? 'x-bar-is-initially-hidden' : '';

$classes = array( $mod_id, 'x-bar', $class_region_specific, $class_region_general, $class_position, $class_sticky, $class_hide_initially, $class );

if ( $bar_scroll === false ) {
  $classes[] = 'x-bar-outer-spacers';
}


// Prepare Data
// ------------

$bar_data = array(
  'id'     => $mod_id,
  'region' => $_region,
);

if ( $bar_region_is_lr ) {
  $bar_data['width'] = $bar_width;
}

if ( $bar_region_is_tbf ) {
  $bar_data['height'] = $bar_height;
}

if ( $bar_is_sticky ) {
  $bar_data['keepMargin']      = $bar_sticky_keep_margin;
  $bar_data['hideInitially']   = $bar_sticky_hide_initially;
  $bar_data['zStack']          = $bar_sticky_z_stack;
  $bar_data['triggerOffset']   = $bar_sticky_trigger_offset;
  $bar_data['triggerSelector'] = $bar_sticky_trigger_selector;
  $bar_data['shrink']          = $bar_sticky_shrink;
}


// Atts: Bar
// ---------

$atts_bar = array(
  'class'      => x_attr_class( $classes ),
  'data-x-bar' => x_attr_json( $bar_data ),
);

if ( isset( $id ) && ! empty( $id ) ) {
  $atts_bar['id'] = $id;
}


// Atts: Bar Scroll
// ----------------

$bar_scroll_begin = '';
$bar_scroll_end   = '';

if ( $bar_scroll === true && $bar_height !== 'auto' ) {

  $suppress_scroll      = ( $bar_region_is_tbf ) ? 'suppressScrollY' : 'suppressScrollX';
  $atts_bar_scroll_data = array( $suppress_scroll => true );
  $atts_bar_scroll      = array( 'class' => x_attr_class( array( $mod_id, 'x-bar-scroll', 'x-bar-outer-spacers' ) ), 'data-x-scrollbar' => x_attr_json( $atts_bar_scroll_data ) );

  $bar_scroll_begin = '<div ' . x_atts( $atts_bar_scroll ) . '>';
  $bar_scroll_end   = '</div>';

  // $atts_bar_scroll_outer = array( 'class' => x_attr_class( array( $mod_id, 'x-bar-scroll-outer' ) ) );
  // $atts_bar_scroll_inner = array( 'class' => x_attr_class( array( $mod_id, 'x-bar-scroll-inner', 'x-bar-outer-spacers' ) ) );

  // $bar_scroll_begin = '<div ' . x_atts( $atts_bar_scroll_outer ) . '><div ' . x_atts( $atts_bar_scroll_inner ) . '>';
  // $bar_scroll_end   = '</div></div>';

}


// Defer Bar Spaces
// ----------------
// Runs concurrently with code from the bar setup functions to allow for
// proper output of spaces to hooks.
//
// 01. Always tie bottom bars into the footer
// 02. If we are previewing, attach the hooks for left and right bars
//     Right bars have a different action in the preview.

if ( $bar_position === 'fixed' ) {

  if ( 'bottom' === $_region ) { // 01
    x_set_view( 'x_before_site_end', 'elements', 'bar', 'space', $_custom_data );
  }

  $preview_bar_space_actions = array(
    'left'   => 'x_before_site_begin',
    'right'  => 'x_after_site_end', // 02
  );

  if ( did_action( 'cs_element_rendering' ) && isset( $preview_bar_space_actions[$_region] ) ) { // 02
    x_set_view( $preview_bar_space_actions[$_region], 'elements', 'bar', 'space', $_custom_data );
  }

}


// Background Partial
// ------------------

if ( $bar_bg_advanced == true ) {
  $data_bg = x_get_partial_data( $_custom_data, array( 'find_data' => array( 'bg' => '' ) ) );
  $bar_bg  = x_get_view( 'partials', 'bg', '', $data_bg, false );
}


// Output
// ------

if ( $bar_position_top === 'relative' && $bar_is_sticky && ! $bar_sticky_hide_initially ) {
  ob_start();
  x_get_view( 'elements', 'bar', 'space', $_custom_data );
  $top_bar_space = ob_get_clean();
  if ( ! did_action( 'cs_element_rendering' ) ) {
    echo $top_bar_space;
  }
}

?>

<div <?php echo x_atts( $atts_bar ); ?>>

  <?php if ( isset( $top_bar_space ) && did_action( 'cs_element_rendering' ) ) { echo $top_bar_space; } ?>
  <?php if ( isset( $bar_bg ) ) { echo $bar_bg; } ?>

  <?php echo $bar_scroll_begin; ?>
    <div class="<?php echo $mod_id; ?> x-bar-content">
      <?php do_action( 'x_bar', $_modules, $global ); ?>
    </div>
  <?php echo $bar_scroll_end; ?>

</div>
