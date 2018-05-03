<?php

// =============================================================================
// VIEWS/GLOBAL/_FOOTER-WIDGET-AREAS.PHP
// -----------------------------------------------------------------------------
// Outputs the widget areas for the footer.
// =============================================================================

$n = x_get_option( 'x_footer_widget_areas' );

?>

<?php if ( $n != 0 ) : ?>

  <footer class="x-colophon top">
    <div class="x-container max width">

      <?php

      $i = 0; while ( $i < $n ) : $i++;

        $last = ( $i == $n ) ? ' last' : '';

        echo '<div class="x-column x-md x-1-' . $n . $last . '">';
          dynamic_sidebar( 'footer-' . $i );
        echo '</div>';

      endwhile;

      ?>

    </div>
  </footer>

<?php endif; ?>
