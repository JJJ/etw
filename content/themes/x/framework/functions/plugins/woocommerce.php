<?php

// =============================================================================
// FUNCTIONS/GLOBAL/PLUGINS/WOOCOMMERCE.PHP
// -----------------------------------------------------------------------------
// Plugin setup for theme compatibility.
// =============================================================================

// =============================================================================
// TABLE OF CONTENTS
// -----------------------------------------------------------------------------
//   01. Global Setup
//   02. Styles
//   03. Shop
//   04. Product
//   05. Cart
//   06. Related Products
//   07. Upsells
//   08. AJAX
//   09. Classic Navbar Cart
//   10. New Cranium Stuff (To Be Organized Later)
// =============================================================================

// Global Setup
// =============================================================================

// Remove Default Wrapper
// ----------------------

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );


// Remove Page Title
// -----------------

function x_woocommerce_show_page_title() {
  return false;
}

add_filter( 'woocommerce_show_page_title', 'x_woocommerce_show_page_title' );



// Styles
// =============================================================================

function x_woocommerce_enqueue_styles( $stack, $ext ) {
  wp_deregister_style( 'woocommerce-layout' );
  wp_deregister_style( 'woocommerce-general' );
  wp_enqueue_style( 'x-woocommerce', X_TEMPLATE_URL . '/framework/dist/css/site/woocommerce/' . $stack . $ext . '.css', NULL, X_ASSET_REV, 'all' );
}

add_action( 'x_enqueue_styles', 'x_woocommerce_enqueue_styles', 10, 2 );


// Shop
// =============================================================================

// Title
// -----

function x_woocommerce_template_loop_product_title() {
  echo '<h3><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
}

add_action( 'woocommerce_shop_loop_item_title', 'x_woocommerce_template_loop_product_title', 10 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );


// Get Shop Link
// -------------

function x_get_shop_link() {

  $id   = ( function_exists( 'wc_get_page_id' ) ) ? wc_get_page_id( 'shop' ) : woocommerce_get_page_id( 'shop' );
  $link = get_permalink( $id );

  return $link;

}


// Columns and Posts Per Page
// --------------------------

function x_woocommerce_shop_columns() {
  return x_get_option( 'x_woocommerce_shop_columns' );
}

add_filter( 'loop_shop_columns', 'x_woocommerce_shop_columns' );


function x_woocommerce_shop_posts_per_page() {
  return x_get_option( 'x_woocommerce_shop_count' );
}

add_filter( 'loop_shop_per_page', 'x_woocommerce_shop_posts_per_page' );


// Shop Product Thumbnails
// -----------------------

function x_woocommerce_shop_product_thumbnails() {

  GLOBAL $product;

  $id     = get_the_ID();
  $thumb  = 'shop_catalog';
  $rating = ( function_exists( 'wc_get_rating_html' ) ) ? wc_get_rating_html( $product->get_average_rating() ) : $product->get_rating_html();

  woocommerce_show_product_sale_flash();

  echo '<div class="entry-featured">';
    echo '<a href="' . get_the_permalink() . '">';

      echo has_post_thumbnail() ? get_the_post_thumbnail( $id, $thumb ) : '<img src="' . x_woocommerce_shop_placeholder_thumbnail() . '" class="x-shop-placeholder-thumbnail">';

      if ( ! empty( $rating ) ) {
        echo '<div class="star-rating-container aggregate">' . $rating . '</div>';
      }

    echo '</a>';
  echo "</div>";

}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'x_woocommerce_shop_product_thumbnails', 10 );


function x_woocommerce_shop_placeholder_thumbnail() {

  $placeholder = x_get_option( 'x_woocommerce_shop_placeholder_thumbnail' );

  if ( empty( $placeholder ) && function_exists( 'cornerstone_make_placeholder_image_uri' ) ) {

    $sizes = wp_get_additional_image_sizes();
    $image_size = apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' );
    $size = isset($sizes[$image_size]) ? $sizes[$image_size] : array( 'height' => 300, 'width' => 300 );
    $placeholder = cornerstone_make_placeholder_image_uri( $size['height'], $size['width'], 'transparent' );

  }

  return $placeholder;

}

// Shop Item Wrapper
// -----------------

// remove the default opening and closing anchor tag added by woocommerce

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

function x_woocommerce_before_shop_loop_item() {
  echo '<div class="entry-product">';
}

function x_woocommerce_after_shop_loop_item() {
  echo '</div>';
}

function x_woocommerce_before_shop_loop_item_title() {
  echo '<div class="entry-wrap"><header class="entry-header">';
}

function x_woocommerce_after_shop_loop_item_title() {
  woocommerce_template_loop_add_to_cart();
  echo '</header></div>';
}

add_action( 'woocommerce_before_shop_loop_item', 'x_woocommerce_before_shop_loop_item', 10 );
add_action( 'woocommerce_after_shop_loop_item', 'x_woocommerce_after_shop_loop_item', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'x_woocommerce_before_shop_loop_item_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'x_woocommerce_after_shop_loop_item_title', 10 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );



// Product
// =============================================================================

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );


// Remove Sale Badge
// -----------------

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );


// Product Wrapper
// ---------------

function x_woocommerce_before_single_product() {
  echo '<div class="entry-wrap"><div class="entry-content">';
}

function x_woocommerce_after_single_product() {
  echo '</div></div>';
}

add_action( 'woocommerce_before_single_product', 'x_woocommerce_before_single_product', 10 );
add_action( 'woocommerce_after_single_product', 'x_woocommerce_after_single_product', 10 );


// Add/Remove Product Tabs
// -----------------------

function x_woocommerce_add_remove_product_tabs( $tabs ) {

  if ( x_get_option( 'x_woocommerce_product_tab_description_enable' ) == '' ) {
    unset( $tabs['description'] );
  }

  if ( x_get_option( 'x_woocommerce_product_tab_additional_info_enable' ) == '' ) {
    unset( $tabs['additional_information'] );
  }

  if ( x_get_option( 'x_woocommerce_product_tab_reviews_enable' ) == '' ) {
    unset( $tabs['reviews'] );
  }

  return $tabs;

}

add_filter( 'woocommerce_product_tabs', 'x_woocommerce_add_remove_product_tabs', 98 );



// Cart
// =============================================================================

// Get Cart Link
// -------------

function x_get_cart_link() {

  if ( function_exists( 'wc_get_cart_url' ) ) {
    $link = wc_get_cart_url();
  } else {
    $link = WC()->cart->get_cart_url();
  }

  return $link;

}


// No Shipping Available HTML
// --------------------------

function x_woocommerce_cart_no_shipping_available_html() {

  if ( is_cart() ) {
    return '<div class="woocommerce-info x-alert x-alert-info x-alert-block"><p>' . __( 'There doesn&lsquo;t seem to be any available shipping methods. Please double check your address, or contact us if you need any help.', '__x__' ) . '</p></div>';
  } else {
    return '<p>' . __( 'There doesn&lsquo;t seem to be any available shipping methods. Please double check your address, or contact us if you need any help.', '__x__' ) . '</p>';
  }

}

add_filter( 'woocommerce_cart_no_shipping_available_html', 'x_woocommerce_cart_no_shipping_available_html' );


// Cart Actions
// ------------
// 01. Check based off of wc_coupons_enabled(), which is only available in
//     WooCommerce v2.5+.

function x_woocommerce_cart_actions() {

  $output = '';

  if ( apply_filters( 'woocommerce_coupons_enabled', 'yes' === get_option( 'woocommerce_enable_coupons' ) ) ) { // 01
    $output .= '<button type="submit" class="button" name="apply_coupon" value="' . esc_attr__( 'Apply Coupon', '__x__' ) . '">' . esc_attr__( 'Apply Coupon', '__x__' ) . '</button>';
  }

  echo $output;

}

add_action( 'woocommerce_cart_actions', 'x_woocommerce_cart_actions' );


// Cross Sells
// -----------

function x_woocommerce_cross_sells_columns() {
  return x_get_option( 'x_woocommerce_cart_cross_sells_columns' );
}

add_filter( 'woocommerce_cross_sells_columns', 'x_woocommerce_cross_sells_columns' );


function x_woocommerce_cross_sells_count() {
  return x_get_option( 'x_woocommerce_cart_cross_sells_count' );
}

add_filter( 'woocommerce_cross_sells_total', 'x_woocommerce_cross_sells_count' );



// Related Products
// =============================================================================

function x_woocommerce_output_related_products() {

  $count   = x_get_option( 'x_woocommerce_product_related_count' );
  $columns = x_get_option( 'x_woocommerce_product_related_columns' );

  $args = array(
    'posts_per_page' => $count,
    'columns'        => $columns,
    'orderby'        => 'rand'
  );

  woocommerce_related_products( $args, true, true );

}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products', 10 );
add_action( 'woocommerce_after_single_product_summary', 'x_woocommerce_output_related_products', 20 );



// Upsells
// =============================================================================

function x_woocommerce_output_upsells() {

  $count   = x_get_option( 'x_woocommerce_product_upsell_count' );
  $columns = x_get_option( 'x_woocommerce_product_upsell_columns' );

  woocommerce_upsell_display( $count, $columns, 'rand' );

}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display', 10 );
add_action( 'woocommerce_after_single_product_summary', 'x_woocommerce_output_upsells', 21 );



// AJAX
// =============================================================================

if ( ! function_exists( 'x_woocommerce_navbar_cart_ajax_notification' ) ) :
  function x_woocommerce_navbar_cart_ajax_notification() {

    if ( x_is_product_index() && get_option( 'woocommerce_enable_ajax_add_to_cart' ) == 'yes' ) {
      $notification = '<div class="x-cart-notification">'
                      . '<div class="x-cart-notification-icon loading">'
                        . '<i class="x-icon-cart-arrow-down" data-x-icon-s="&#xf218;" aria-hidden="true"></i>'
                      . '</div>'
                      . '<div class="x-cart-notification-icon added">'
                        . '<i class="x-icon-check" data-x-icon-s="&#xf00c;" aria-hidden="true"></i>'
                      . '</div>'
                    . '</div>';
    } else {
      $notification = '';
    }

    echo $notification;

  }
  add_action( 'x_before_site_end', 'x_woocommerce_navbar_cart_ajax_notification' );
endif;



// Classic Navbar Cart
// =============================================================================

if ( ! function_exists( 'x_woocommerce_navbar_cart' ) ) :
  function x_woocommerce_navbar_cart() {

    $cart_info   = x_get_option( 'x_woocommerce_header_cart_info' );
    $cart_layout = x_get_option( 'x_woocommerce_header_cart_layout' );
    $cart_style  = x_get_option( 'x_woocommerce_header_cart_style' );
    $cart_outer  = x_get_option( 'x_woocommerce_header_cart_content_outer' );
    $cart_inner  = x_get_option( 'x_woocommerce_header_cart_content_inner' );

    $data = array(
      'icon'  => '<i class="x-icon-shopping-cart" data-x-icon-s="&#xf07a;" aria-hidden="true"></i>',
      'total' => WC()->cart->get_cart_total(),
      'count' => sprintf( _n( '%d Item', '%d Items', WC()->cart->cart_contents_count, '__x__' ), WC()->cart->cart_contents_count )
    );

    $modifiers = array(
      $cart_info,
      strpos( $cart_info, '-' ) === false ? 'inline' : $cart_layout,
      $cart_style
    );

    $cart_output = '<div class="x-cart ' . implode( ' ', $modifiers ) . '">';

      foreach ( explode( '-', $cart_info ) as $info ) {
        $key = ( $info == 'outer' ) ? $cart_outer : $cart_inner;
        $cart_output .= '<span class="' . $info . '">' . $data[$key] . '</span>';
      }

    $cart_output .= '</div>';

    return $cart_output;

  }
endif;



// Cart Fragment
// -------------

if ( ! function_exists( 'x_woocommerce_navbar_cart_fragment' ) ) :
  function x_woocommerce_navbar_cart_fragment( $fragments ) {

    $fragments['div.x-cart'] = x_woocommerce_navbar_cart();

    return $fragments;

  }
  add_filter( 'woocommerce_add_to_cart_fragments', 'x_woocommerce_navbar_cart_fragment' );
endif;



// Cart Menu Item
// --------------

if ( ! function_exists( 'x_woocommerce_navbar_menu_item' ) ) :
  function x_woocommerce_navbar_menu_item( $items, $args ) {

    if ( $args->theme_location == 'primary' && x_get_option( 'x_woocommerce_header_menu_enable' ) == '1' && did_action( 'x_classic_headers' ) ) {

      if ( x_get_option( 'x_woocommerce_header_hide_empty_cart' ) != '1' || WC()->cart->get_cart_contents_count() > 0 ) {

          $items .= '<li class="menu-item current-menu-parent x-menu-item x-menu-item-woocommerce">'
                    . '<a href="' . x_get_cart_link() . '" class="x-btn-navbar-woocommerce">'
                      . x_woocommerce_navbar_cart()
                    . '</a>'
                  . '</li>';
      }

    }

    return $items;

  }
  add_filter( 'wp_nav_menu_items', 'x_woocommerce_navbar_menu_item', 9999, 2 );
endif;



// New Cranium Stuff (To Be Organized Later)
// =============================================================================

// Fragments
// ---------

function x_woocommerce_fragment_total() {
  return '<span data-x-wc-fragment="total">' . WC()->cart->get_cart_total() . '</span>';
}

function x_woocommerce_fragment_count() {
  return '<span data-x-wc-fragment="count">' . WC()->cart->cart_contents_count . '</span>';
}

function x_woocommerce_fragments( $fragments ) {

  $fragments['[data-x-wc-fragment="total"]'] = x_woocommerce_fragment_total();
  $fragments['[data-x-wc-fragment="count"]'] = x_woocommerce_fragment_count();

  return $fragments;

}

add_filter( 'woocommerce_add_to_cart_fragments', 'x_woocommerce_fragments' );
