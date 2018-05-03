<?php
 
// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/INTEGRITY.PHP
// -----------------------------------------------------------------------------
// Integrity CSS ouptut.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Site Link Color Accents
//   02. Masthead
//   03. Navbar
//   04. Navbar - Positioning
//   05. Navbar - Dropdowns
//   06. Footer
//   07. Responsive Styling
//   08. Adminbar Styling
// =============================================================================

$x_integrity_design                     = x_get_option( 'x_integrity_design' );
$x_integrity_topbar_transparency_enable = x_get_option( 'x_integrity_topbar_transparency_enable' );
$x_integrity_navbar_transparency_enable = x_get_option( 'x_integrity_navbar_transparency_enable' );
$x_integrity_footer_transparency_enable = x_get_option( 'x_integrity_footer_transparency_enable' );

?>

/* Site Link Color Accents
// ========================================================================== */

/*
// Color.
*/

.x-topbar .p-info a:hover,
.x-widgetbar .widget ul li a:hover {
  color: <?php echo $x_site_link_color; ?>;
}



/* Masthead
// ========================================================================== */

<?php if ( $x_integrity_topbar_transparency_enable == 1 ) : ?>

  .x-topbar { background-color: transparent; }

<?php endif; ?>



/* Navbar
// ========================================================================== */

/*
// Color.
*/

.x-topbar .p-info,
.x-topbar .p-info a,
.x-navbar .desktop .x-nav > li > a,
.x-navbar .desktop .sub-menu a,
.x-navbar .mobile .x-nav li > a,
.x-breadcrumb-wrap a,
.x-breadcrumbs .delimiter {
  color: <?php echo $x_navbar_link_color; ?>;
}

.x-navbar .desktop .x-nav > li > a:hover,
.x-navbar .desktop .x-nav > .x-active > a,
.x-navbar .desktop .x-nav > .current-menu-item > a,
.x-navbar .desktop .sub-menu a:hover,
.x-navbar .desktop .sub-menu .x-active > a,
.x-navbar .desktop .sub-menu .current-menu-item > a,
.x-navbar .desktop .x-nav .x-megamenu > .sub-menu > li > a,
.x-navbar .mobile .x-nav li > a:hover,
.x-navbar .mobile .x-nav .x-active > a,
.x-navbar .mobile .x-nav .current-menu-item > a {
  color: <?php echo $x_navbar_link_color_hover; ?>;
}

<?php if ( $x_integrity_navbar_transparency_enable == 1 ) : ?>

  .x-navbar { background-color: transparent; }

<?php endif; ?>



/* Navbar - Positioning
// ========================================================================== */

<?php if ( $x_navbar_positioning == 'static-top' || $x_navbar_positioning == 'fixed-top' ) : ?>

  .x-navbar .desktop .x-nav > li > a:hover,
  .x-navbar .desktop .x-nav > .x-active > a,
  .x-navbar .desktop .x-nav > .current-menu-item > a {
    box-shadow: inset 0 4px 0 0 <?php echo $x_site_link_color; ?>;
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
    margin-bottom: 1px;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-left' ) : ?>

  .x-navbar .desktop .x-nav > li > a:hover,
  .x-navbar .desktop .x-nav > .x-active > a,
  .x-navbar .desktop .x-nav > .current-menu-item > a {
    box-shadow: inset 8px 0 0 0 <?php echo $x_site_link_color; ?>;
  }

  .x-widgetbar {
    left: <?php echo $x_navbar_width . 'px'; ?>;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-right' ) : ?>

  .x-navbar .desktop .x-nav > li > a:hover,
  .x-navbar .desktop .x-nav > .x-active > a,
  .x-navbar .desktop .x-nav > .current-menu-item > a {
    box-shadow: inset -8px 0 0 0 <?php echo $x_site_link_color; ?>;
  }

  .x-widgetbar {
    right: <?php echo $x_navbar_width . 'px'; ?>;
  }

<?php endif; ?>



/* Navbar - Dropdowns
// ========================================================================== */

.x-navbar .desktop .x-nav > li ul {
  top: <?php echo $x_navbar_height - 15 . 'px'; ?>;;
}



/* Footer
// ========================================================================== */

<?php if ( $x_integrity_design == 'light' ) : ?>

  <?php if ( $x_integrity_footer_transparency_enable == 1 ) : ?>

    .x-colophon.top,
    .x-colophon.bottom {
      border-top: 1px solid #e0e0e0;
      border-top: 1px solid rgba(0, 0, 0, 0.085);
      background-color: transparent;
      box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.8);
    }

  <?php endif; ?>

<?php else : ?>

  <?php if ( $x_integrity_footer_transparency_enable == 1 ) : ?>

    .x-colophon.top,
    .x-colophon.bottom {
      border-top: 1px solid #000;
      border-top: 1px solid rgba(0, 0, 0, 0.75);
      background-color: transparent;
      box-shadow: inset 0 1px 0 0 rgba(255, 255, 255, 0.075);
    }

  <?php endif; ?>

<?php endif; ?>



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

  .admin-bar .x-widgetbar,
  .admin-bar .x-btn-widgetbar {
    top: 32px;
  }

  @media screen and (max-width: 782px) {
    .admin-bar .x-widgetbar,
    .admin-bar .x-btn-widgetbar {
      top: 46px;
    }
  }

<?php endif; ?>