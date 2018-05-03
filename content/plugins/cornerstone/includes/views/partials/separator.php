<?php

// =============================================================================
// VIEWS/PARTIALS/SEPARATOR.PHP
// -----------------------------------------------------------------------------
// Separator partial.
// =============================================================================

$separator_is_top = $separator_location === 'top';


// Prepare Atts
// ------------

$atts = array(
  'class'       => 'x-separator-' . $separator_location . '-' . $separator_type,
  'style'       => 'height: ' . $separator_height . '; color: ' . cornerstone_post_process_color( $separator_color ) . ';',
  'aria-hidden' => 'true',
);


// Content
// -------

switch ( $separator_type ) {
  case 'angle-out' :
    $separator_content = ( $separator_is_top ) ? '<svg class="angle-top-out" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="' . $separator_angle_point . ',0 100,100 0,100"/></svg>'
                                               : '<svg class="angle-bottom-out" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="' . $separator_angle_point . ',100 100,0 0,0"></svg>';
    break;
  case 'angle-in' :
    $separator_content = ( $separator_is_top ) ? '<svg class="angle-top-in" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="0,100 ' . $separator_angle_point . ',100 0,0"/><polygon points="' . $separator_angle_point . ',100 100,100 100,0"/></svg>'
                                               : '<svg class="angle-bottom-in" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 100" preserveAspectRatio="none"><polygon points="0,0 ' . $separator_angle_point . ',0 0,100"/><polygon points="' . $separator_angle_point . ',0 100,0 100,100"/></svg>';
    break;
  case 'curve-out' :
    $separator_content = ( $separator_is_top ) ? '<svg class="curve-top-out" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,50C0,50,22.4,0,50,0s50,50,50,50"/></svg>'
                                               : '<svg class="curve-bottom-out" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,0c0,0,22.4,50,50,50s50-50,50-50"/></svg>';
    break;
  case 'curve-in' :
    $separator_content = ( $separator_is_top ) ? '<svg class="curve-top-in" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,0v50h50C22.4,50,0,0,0,0z"/><path d="M50,50h50V0C100,0,77.6,50,50,50z"/></svg>'
                                               : '<svg class="curve-bottom-in" style="fill: currentColor;" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 100 50" preserveAspectRatio="none"><path d="M0,50V0h50C22.4,0,0,50,0,50z"/><path d="M50,0h50v50C100,50,77.6,0,50,0z"/></svg>';
    break;
  default :
    $separator_content = NULL;
    break;
}


// Output
// ------

?>

<span <?php echo x_atts( $atts ); ?>>
  <?php echo $separator_content; ?>
</span>
