<?php

// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/RENEW.PHP
// -----------------------------------------------------------------------------
// Renew CSS ouptut.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Masthead
//   02. Navbar
//   03. Navbar - Positioning
//   04. Navbar - Dropdowns
//   05. Colophon
//   06. Adminbar Styling
// =============================================================================

$x_renew_topbar_text_color              = x_post_css_value( x_get_option( 'x_renew_topbar_text_color' ), 'color' );
$x_renew_topbar_link_color_hover        = x_post_css_value( x_get_option( 'x_renew_topbar_link_color_hover' ), 'color' );
$x_renew_topbar_background              = x_post_css_value( x_get_option( 'x_renew_topbar_background' ), 'color' );
$x_renew_logobar_background             = x_post_css_value( x_get_option( 'x_renew_logobar_background' ), 'color' );
$x_renew_navbar_button_color            = x_post_css_value( x_get_option( 'x_renew_navbar_button_color' ), 'color' );
$x_renew_navbar_background              = x_post_css_value( x_get_option( 'x_renew_navbar_background' ), 'color' );
$x_renew_navbar_button_background_hover = x_post_css_value( x_get_option( 'x_renew_navbar_button_background_hover' ), 'color' );
$x_renew_navbar_button_background       = x_post_css_value( x_get_option( 'x_renew_navbar_button_background' ), 'color' );
$x_renew_footer_background              = x_post_css_value( x_get_option( 'x_renew_footer_background' ), 'color' );
$x_renew_footer_text_color              = x_post_css_value( x_get_option( 'x_renew_footer_text_color' ), 'color' );

?>

/* Masthead
// ========================================================================== */

.x-topbar .p-info,
.x-topbar .p-info a,
.x-topbar .x-social-global a {
  color: <?php echo $x_renew_topbar_text_color; ?>;
}

.x-topbar .p-info a:hover {
  color: <?php echo $x_renew_topbar_link_color_hover; ?>;
}

.x-topbar {
  background-color: <?php echo $x_renew_topbar_background; ?>;
}

<?php if ( $x_logo_navigation_layout == 'stacked' ) : ?>

  .x-logobar {
    background-color: <?php echo $x_renew_logobar_background; ?>;
  }

<?php endif; ?>



/* Navbar
// ========================================================================== */

.x-navbar .desktop .x-nav > li:before {
  padding-top: <?php echo $x_navbar_adjust_links_top . 'px'; ?>;
}


/*
// Color.
*/

.x-navbar .desktop .x-nav > li > a,
.x-navbar .desktop .sub-menu li > a,
.x-navbar .mobile .x-nav li a {
  color: <?php echo $x_navbar_link_color; ?>;
}

.x-navbar .desktop .x-nav > li > a:hover,
.x-navbar .desktop .x-nav > .x-active > a,
.x-navbar .desktop .x-nav > .current-menu-item > a,
.x-navbar .desktop .sub-menu li > a:hover,
.x-navbar .desktop .sub-menu li.x-active > a,
.x-navbar .desktop .sub-menu li.current-menu-item > a,
.x-navbar .desktop .x-nav .x-megamenu > .sub-menu > li > a,
.x-navbar .mobile .x-nav li > a:hover,
.x-navbar .mobile .x-nav li.x-active > a,
.x-navbar .mobile .x-nav li.current-menu-item > a {
  color: <?php echo $x_navbar_link_color_hover; ?>;
}

.x-btn-navbar,
.x-btn-navbar:hover {
  color: <?php echo $x_renew_navbar_button_color; ?>;
}


/*
// Background color.
*/

.x-navbar .desktop .sub-menu li:before,
.x-navbar .desktop .sub-menu li:after {
  background-color: <?php echo $x_navbar_link_color; ?>;
}

.x-navbar,
.x-navbar .sub-menu {
  background-color: <?php echo $x_renew_navbar_background; ?> !important;
}

.x-btn-navbar,
.x-btn-navbar.collapsed:hover {
  background-color: <?php echo $x_renew_navbar_button_background_hover; ?>;
}

.x-btn-navbar.collapsed {
  background-color: <?php echo $x_renew_navbar_button_background; ?>;
}


/*
// Box shadow.
*/

.x-navbar .desktop .x-nav > li > a:hover > span,
.x-navbar .desktop .x-nav > li.x-active > a > span,
.x-navbar .desktop .x-nav > li.current-menu-item > a > span {
  box-shadow: 0 2px 0 0 <?php echo $x_navbar_link_color_hover; ?>;
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
    padding-top: <?php echo round( ( $x_navbar_adjust_links_side - $x_navbar_font_size ) / 2 ) . 'px'; ?>;
    padding-bottom: <?php echo round( ( $x_navbar_adjust_links_side - $x_navbar_font_size ) / 2 ) . 'px'; ?>;
    padding-left: 10%;
    padding-right: 10%;
  }

  .desktop .x-megamenu > .sub-menu {
    width: <?php echo 879 - $x_navbar_width . 'px'; ?>
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



/* Colophon
// ========================================================================== */

.x-colophon.bottom {
  background-color: <?php echo $x_renew_footer_background; ?>;
}

.x-colophon.bottom,
.x-colophon.bottom a,
.x-colophon.bottom .x-social-global a {
  color: <?php echo $x_renew_footer_text_color; ?>;
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
