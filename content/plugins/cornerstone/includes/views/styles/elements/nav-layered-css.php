<?php

// =============================================================================
// NAV-LAYERED-CSS.PHP
// -----------------------------------------------------------------------------
// Generated styling.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Include Partial CSS
// =============================================================================

// Include Partial CSS
// =============================================================================

?>

@if $_region === 'top' || $_region === 'bottom' || $_region === 'footer' {
  <?php

    echo cs_get_partial_style( 'anchor', array(
      'selector' => '.x-anchor-toggle',
      'key_prefix'    => 'toggle'
    ) );

    echo cs_get_partial_style( 'off-canvas' );

  ?>
}

<?php

echo cs_get_partial_style( 'menu' );

echo cs_get_partial_style( 'anchor', array(
  'selector' => '.x-menu .x-anchor',
  'key_prefix'    => ''
) );
