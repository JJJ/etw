<?php
 
// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/ICON.PHP
// -----------------------------------------------------------------------------
// Icon CSS ouptut.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Navbar
//   02. Navbar - Positioning
//   03. Navbar - Dropdowns
//   04. Responsive Styling
//   05. Adminbar Styling
// =============================================================================

?>

/* Navbar
// ========================================================================== */

/*
// Color.
*/

.x-navbar .desktop .x-nav > li > a,
.x-navbar .desktop .sub-menu a,
.x-navbar .mobile .x-nav li a {
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



/* Navbar - Positioning
// ========================================================================== */

<?php if ( $x_navbar_positioning == 'static-top' || $x_navbar_positioning == 'fixed-top' ) : ?>

  .x-navbar .desktop .x-nav > li > a {
    height: <?php echo $x_navbar_height . 'px'; ?>;
    padding-top: <?php echo $x_navbar_adjust_links_top . 'px'; ?>;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-left' || $x_navbar_positioning == 'fixed-right' ) : ?>

  .x-navbar .desktop .x-nav > li > a {
    padding-top: calc(<?php echo floor( ( $x_navbar_adjust_links_side - $x_navbar_font_size ) / 2 ) . 'px'; ?> - 0.875em);
    padding-bottom: calc(<?php echo floor( ( $x_navbar_adjust_links_side - $x_navbar_font_size ) / 2 ) . 'px'; ?> - 0.825em);
    padding-left: 35px;
    padding-right: 35px;
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

  .x-widgetbar {
    left: <?php echo $x_navbar_width . 'px'; ?>;
  }

<?php endif; ?>

<?php if ( $x_navbar_positioning == 'fixed-right' ) : ?>

  .x-widgetbar {
    right: <?php echo $x_navbar_width . 'px'; ?>;
  }

<?php endif; ?>



/* Navbar - Dropdowns
// ========================================================================== */

.x-navbar .desktop .x-nav > li ul {
  top: <?php echo $x_navbar_height . 'px'; ?>;
}



/* Responsive Styling
// ========================================================================== */

@media (min-width: 1200px) {
  body.x-sidebar-content-active .x-widgetbar,
  body.x-sidebar-content-active .x-navbar-fixed-top,
  body[class*="page-template-template-blank"].x-sidebar-content-active.x-blank-template-sidebar-active .x-widgetbar,
  body[class*="page-template-template-blank"].x-sidebar-content-active.x-blank-template-sidebar-active .x-navbar-fixed-top {
    left: <?php echo $x_layout_sidebar_width . 'px'; ?>;
  }

  body.x-content-sidebar-active .x-widgetbar,
  body.x-content-sidebar-active .x-navbar-fixed-top,
  body[class*="page-template-template-blank"].x-content-sidebar-active.x-blank-template-sidebar-active .x-widgetbar,
  body[class*="page-template-template-blank"].x-content-sidebar-active.x-blank-template-sidebar-active .x-navbar-fixed-top {
    right: <?php echo $x_layout_sidebar_width . 'px'; ?>;
  }
}

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

  .admin-bar .x-widgetbar     { top: 31px; }
  .admin-bar .x-btn-widgetbar { top: 32px; }

  @media screen and (max-width: 782px) {
    .admin-bar .x-widgetbar     { top: 45px; }
    .admin-bar .x-btn-widgetbar { top: 46px; }
  }

<?php endif; ?>