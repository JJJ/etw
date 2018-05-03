<?php
 
// =============================================================================
// FUNCTIONS/GLOBAL/ADMIN/CUSTOMIZER/OUTPUT/WOOCOMMERCE.PHP
// -----------------------------------------------------------------------------
// Global CSS output for WooCommerce.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Navbar Cart
// =============================================================================

?>

<?php if ( X_WOOCOMMERCE_IS_ACTIVE ) : ?>

  /* Navbar Cart
  // ========================================================================== */

  <?php if ( x_get_option( 'x_woocommerce_header_menu_enable' ) == '1' ) : ?>

    <?php $x_woocommerce_outer_color       = x_get_option( 'x_woocommerce_header_cart_content_outer_color' ); ?>
    <?php $x_woocommerce_outer_color_hover = x_get_option( 'x_woocommerce_header_cart_content_outer_color_hover' ); ?>
    <?php $x_woocommerce_inner_color       = x_get_option( 'x_woocommerce_header_cart_content_inner_color' ); ?>
    <?php $x_woocommerce_inner_color_hover = x_get_option( 'x_woocommerce_header_cart_content_inner_color_hover' ); ?>

    .x-navbar .x-nav > li.x-menu-item-woocommerce > a .x-cart > span {
      padding-right: calc(0.625em - <?php echo $x_navbar_letter_spacing . 'px'; ?>);
    }

    .x-navbar-static-active .x-navbar .desktop .x-nav > li.x-menu-item-woocommerce > a,
    .x-navbar-fixed-top-active .x-navbar .desktop .x-nav > li.x-menu-item-woocommerce > a {
      padding-top: <?php echo x_get_option( 'x_woocommerce_header_cart_adjust' ) . 'px'; ?>;
    }

    .x-navbar .x-nav > li.x-menu-item-woocommerce > a .x-cart {
      color: <?php echo $x_woocommerce_outer_color; ?>;
      background-color: <?php echo $x_woocommerce_inner_color; ?>;
    }

    .x-navbar .x-nav > li.x-menu-item-woocommerce > a:hover .x-cart {
      color: <?php echo $x_woocommerce_outer_color_hover; ?>;
      background-color: <?php echo $x_woocommerce_inner_color_hover; ?>;
    }

    .x-navbar .x-nav > li.x-menu-item-woocommerce > a .x-cart > span.outer {
      color: <?php echo $x_woocommerce_inner_color; ?>;
      background-color: <?php echo $x_woocommerce_outer_color; ?>;
    }

    .x-navbar .x-nav > li.x-menu-item-woocommerce > a:hover .x-cart > span.outer {
      color: <?php echo $x_woocommerce_inner_color_hover; ?>;
      background-color: <?php echo $x_woocommerce_outer_color_hover; ?>;
    }

    <?php if ( $x_navbar_positioning == 'static-top' || $x_navbar_positioning == 'fixed-top' ) : ?>
      <?php if ( $x_stack != 'icon' ) : ?>
        <?php if ( is_rtl() ) : ?>

          .x-navbar .desktop .x-nav > li.x-menu-item-woocommerce {
            margin-right: <?php echo $x_navbar_adjust_links_top_spacing . 'px'; ?>;
          }

        <?php else : ?>

          .x-navbar .desktop .x-nav > li.x-menu-item-woocommerce {
            margin-left: <?php echo $x_navbar_adjust_links_top_spacing . 'px'; ?>;
          }

        <?php endif; ?>
      <?php else : ?>
        <?php if ( is_rtl() ) : ?>

          .x-navbar .desktop .x-nav > li.x-menu-item-woocommerce {
            margin-left: 5px;
            margin-right: calc(1.25em + <?php echo $x_navbar_adjust_links_top_spacing . 'px'; ?>);
          }

        <?php else : ?>

          .x-navbar .desktop .x-nav > li.x-menu-item-woocommerce {
            margin-left: calc(1.25em + <?php echo $x_navbar_adjust_links_top_spacing . 'px'; ?>);
            margin-right: 5px;
          }

        <?php endif; ?>
      <?php endif; ?>
    <?php endif; ?>

  <?php endif; ?>

<?php endif; ?>