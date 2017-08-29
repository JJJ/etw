<?php
/**
 * WooCommerce related functions
 *
 * @package Atomic
 */


/**
 * Register widget area
 */
function atomic_woo_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Shop Archive Sidebar', 'atomic' ),
		'id'            => 'sidebar-shop',
		'description'   => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce shop page.', 'atomic' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'atomic_woo_widgets_init' );


/**
 * Add a sidebar to the shop page
 */
function atomic_shop_sidebar() {
	if ( is_active_sidebar( 'sidebar-shop' ) ) {
		echo '<button class="woo-expand"><span>' . esc_html__( 'Expand', 'atomic' ) . '</span><span>' . esc_html__( 'Close', 'atomic' ) . '</span></button>';
		echo '<div class="widget-area shop-sidebar">';
			do_action( 'atomic_above_shop_sidebar' );
			dynamic_sidebar( 'sidebar-shop' );
			do_action( 'atomic_below_shop_sidebar' );
		echo '</div>';
	}
}
add_action( 'woocommerce_product_sidebar', 'atomic_shop_sidebar', 1 );


/**
 * Disable the auto output of the sidebar
 */
function atomic_remove_sidebar () {
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
}
add_action( 'template_redirect', 'atomic_remove_sidebar' );


/**
 * Change the default product thumbnail
 */
function atomic_product_thumbnail() {
	add_filter( 'woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src' );

	function custom_woocommerce_placeholder_img_src( $src ) {
		$src = get_template_directory_uri() . '/images/product-thumb.jpg';
		return $src;
	}
}
add_action( 'init', 'atomic_product_thumbnail' );


/**
 * Change the number of products per page
 */
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 9;' ), 20 );


/**
 * Change the number of related products
 */
function woo_related_products_limit() {
  global $product;

	$args['posts_per_page'] = 3;
	return $args;
}

function atomic_related_products_args( $args ) {
	$args['posts_per_page'] = 3; // 3 related products
	$args['columns'] = 1; // arranged in 1 column
	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'atomic_related_products_args' );


/**
 * Change the number of upsells
 */
if ( ! function_exists( 'atomic_woocommerce_output_upsells' ) ) {
	function atomic_woocommerce_output_upsells() {
	    woocommerce_upsell_display( 3,1 ); // Display 3 products in rows of 1
	}
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
add_action( 'woocommerce_after_single_product_summary', 'atomic_woocommerce_output_upsells', 15 );
