<?php

// =============================================================================
// VIEWS/ICON/WP-SIDEBAR.PHP
// -----------------------------------------------------------------------------
// Sidebar output for Icon.
// =============================================================================

?>

<?php if ( x_get_content_layout() != 'full-width' ) : ?>

  <aside class="x-sidebar" role="complementary">
    <div class="max width">
      <?php if ( get_option( 'ups_sidebars' ) != array() ) : ?>
        <?php dynamic_sidebar( apply_filters( 'ups_sidebar', 'sidebar-main' ) ); ?>
      <?php else : ?>
        <?php dynamic_sidebar( 'sidebar-main' ); ?>
      <?php endif; ?>
    </div>
  </aside>

<?php endif; ?>
