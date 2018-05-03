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

$x_ethos_topbar_background             = x_get_option( 'x_ethos_topbar_background' );
$x_ethos_navbar_background             = x_get_option( 'x_ethos_navbar_background' );
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
