<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/ETHOS.PHP
// -----------------------------------------------------------------------------
// Ethos CSS ouptut.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Design Options
//   02. Navbar
//   03. Navbar - Positioning
//   04. Navbar - Dropdowns
//   05. Responsive Styling
//   06. Adminbar Styling
// =============================================================================

$x_ethos_topbar_background             = x_post_css_value( x_get_option( 'x_ethos_topbar_background' ), 'color' );
$x_ethos_navbar_background             = x_post_css_value( x_get_option( 'x_ethos_navbar_background' ), 'color' );
$x_ethos_sidebar_widget_headings_color = x_post_css_value( x_get_option( 'x_ethos_sidebar_widget_headings_color' ), 'color' );
$x_ethos_sidebar_color                 = x_post_css_value( x_get_option( 'x_ethos_sidebar_color' ), 'color' );
$x_ethos_post_slider_blog_height       = x_get_option( 'x_ethos_post_slider_blog_height' );
$x_ethos_post_slider_archive_height    = x_get_option( 'x_ethos_post_slider_archive_height' );

$x_ethos_navbar_outer_border_width     = '2';

?>

/* Design Options
// ========================================================================== */

/*
// Background color.
*/

.x-topbar,
.x-colophon.bottom {
  background-color: <?php echo $x_ethos_topbar_background; ?>;
}

.x-logobar,
.x-navbar,
.x-navbar .sub-menu,
.x-colophon.top {
  background-color: <?php echo $x_ethos_navbar_background; ?>;
}



/* Navbar
// ========================================================================== */

/*
// Color.
*/

.x-navbar .desktop .x-nav > li > a,
.x-navbar .desktop .sub-menu a,
.x-navbar .mobile .x-nav li > a,
.x-breadcrumb-wrap a,
.x-breadcrumbs .delimiter {
  color: <?php echo $x_navbar_link_color; ?>;
}

.x-topbar .p-info a:hover,
.x-social-global a:hover,
.x-navbar .desktop .x-nav > li > a:hover,
.x-navbar .desktop .x-nav > .x-active > a,
.x-navbar .desktop .x-nav > .current-menu-item > a,
.x-navbar .desktop .sub-menu a:hover,
.x-navbar .desktop .sub-menu .x-active > a,
.x-navbar .desktop .sub-menu .current-menu-item > a,
.x-navbar .desktop .x-nav .x-megamenu > .sub-menu > li > a,
.x-navbar .mobile .x-nav li > a:hover,
.x-navbar .mobile .x-nav .x-active > a,
.x-navbar .mobile .x-nav .current-menu-item > a,
.x-widgetbar .widget a:hover,
.x-colophon .widget a:hover,
.x-colophon.bottom .x-colophon-content a:hover,
.x-colophon.bottom .x-nav a:hover {
  color: <?php echo $x_navbar_link_color_hover; ?>;
}


/*
// Box shadow.
*/

<?php

$locations = get_nav_menu_locations();
$items     = wp_get_nav_menu_items( $locations['primary'] );

if ( is_array( $items ) ) {
  foreach ( $items as $item ) {
    if ( $item->type == 'taxonomy' && $item->menu_item_parent == 0 ) {

      $t_id   = $item->object_id;
      $accent = x_ethos_category_accent_color( $t_id, $x_site_link_color );

      ?>

      <?php if ( $x_navbar_positioning == 'static-top' || $x_navbar_positioning == 'fixed-top' ) : ?>

        .x-navbar .desktop .x-nav > li.tax-item-<?php echo $t_id; ?> > a:hover,
        .x-navbar .desktop .x-nav > li.tax-item-<?php echo $t_id; ?>.x-active > a {
          box-shadow: 0 <?php echo $x_ethos_navbar_outer_border_width; ?>px 0 0 <?php echo $accent; ?>;
        }

      <?php elseif ( $x_navbar_positioning == 'fixed-left' ) : ?>

        .x-navbar .desktop .x-nav > li.tax-item-<?php echo $t_id; ?> > a:hover,
        .x-navbar .desktop .x-nav > li.tax-item-<?php echo $t_id; ?>.x-active > a {
          box-shadow: <?php echo $x_ethos_navbar_outer_border_width; ?>px 0 0 0 <?php echo $accent; ?>;
        }

      <?php elseif ( $x_navbar_positioning == 'fixed-right' ) : ?>

        .x-navbar .desktop .x-nav > li.tax-item-<?php echo $t_id; ?> > a:hover,
        .x-navbar .desktop .x-nav > li.tax-item-<?php echo $t_id; ?>.x-active > a {
          box-shadow: -<?php echo $x_ethos_navbar_outer_border_width; ?>px 0 0 0 <?php echo $accent; ?>;
        }

      <?php endif; ?>

      <?php

    }
  }
}

?>



/* Navbar - Positioning
// ========================================================================== */

<?php if ( $x_navbar_positioning == 'static-top' || $x_navbar_positioning == 'fixed-top' ) : ?>

  .x-navbar .desktop .x-nav > li > a:hover,
  .x-navbar .desktop .x-nav > .x-active > a,
  .x-navbar .desktop .x-nav > .current-menu-item > a {
    box-shadow: 0 <?php echo $x_ethos_navbar_outer_border_width; ?>px 0 0 <?php echo $x_site_link_color; ?>;
  }

  .x-navbar .desktop .x-nav > li > a {
    height: <?php echo $x_navbar_height . 'px'; ?>;
    padding-top: <?php echo $x_navbar_adjust_links_top . 'px'; ?>;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-left' || $x_navbar_positioning == 'fixed-right' ) : ?>

  .x-navbar .desktop .x-nav > li > a {
    padding-top: <?php echo round( ( $x_navbar_adjust_links_side - $x_navbar_font_size ) / 2 ) . 'px'; ?>;
    padding-bottom: <?php echo round( ( $x_navbar_adjust_links_side - $x_navbar_font_size ) / 2 ) . 'px'; ?>;
    padding-left: 7%;
    padding-right: 7%;
  }

  .desktop .x-megamenu > .sub-menu {
    width: <?php echo 879 - $x_navbar_width . 'px'; ?>
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-top' ) : ?>

  .x-navbar-fixed-top-active .x-navbar-wrap {
    margin-bottom: 2px;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-left' ) : ?>

  .x-navbar .desktop .x-nav > li > a:hover,
  .x-navbar .desktop .x-nav > .x-active > a,
  .x-navbar .desktop .x-nav > .current-menu-item > a {
    box-shadow: <?php echo $x_ethos_navbar_outer_border_width; ?>px 0 0 0 <?php echo $x_site_link_color; ?>;
  }

  .x-widgetbar {
    left: <?php echo $x_navbar_width . 'px'; ?>;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-right' ) : ?>

  .x-navbar .desktop .x-nav > li > a:hover,
  .x-navbar .desktop .x-nav > .x-active > a,
  .x-navbar .desktop .x-nav > .current-menu-item > a {
    box-shadow: -<?php echo $x_ethos_navbar_outer_border_width; ?>px 0 0 0 <?php echo $x_site_link_color; ?>;
  }

  .x-widgetbar {
    right: <?php echo $x_navbar_width . 'px'; ?>;
  }

<?php endif; ?>



/* Navbar - Dropdowns
// ========================================================================== */

.x-navbar .desktop .x-nav > li ul {
  top: <?php echo $x_navbar_height + $x_ethos_navbar_outer_border_width . 'px'; ?>;
}



/* Responsive Styling
// ========================================================================== */

@media (max-width: 979px) {

  <?php if ( $x_navbar_positioning == 'fixed-top' ) : ?>

    .x-navbar-fixed-top-active .x-navbar-wrap {
      margin-bottom: 0;
    }

  <?php endif; ?>

}



/* Adminbar Styling
// ========================================================================== */

<?php if ( is_admin_bar_showing() ) : ?>

  html body #wpadminbar {
    z-index: 99999 !important;
  }


  /*
  // Fixed navbar.
  */

  .admin-bar .x-navbar-fixed-top,
  .admin-bar .x-navbar-fixed-left,
  .admin-bar .x-navbar-fixed-right {
    top: 32px;
  }

  @media (max-width: 979px) {
    .admin-bar .x-navbar-fixed-top,
    .admin-bar .x-navbar-fixed-left,
    .admin-bar .x-navbar-fixed-right {
      top: 0;
    }
  }


  /*
  // Widgetbar.
  */

  .admin-bar .x-widgetbar     { top: 30px; }
  .admin-bar .x-btn-widgetbar { top: 32px; }

  @media screen and (max-width: 782px) {
    .admin-bar .x-widgetbar     { top: 44px; }
    .admin-bar .x-btn-widgetbar { top: 46px; }
  }

<?php endif; ?>
