<?php

class Cornerstone_Dynamic_Content_WooCommerce extends Cornerstone_Plugin_Component {


  public function setup() {
    add_filter('cs_dynamic_content_woocommerce', array( $this, 'supply_field' ), 10, 4 );
    add_action('cs_dynamic_content_setup', array( $this, 'register' ) );
    add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragment' ) );
  }

  public function register() {
    cornerstone_dynamic_content_register_group(array(
      'name'  => 'woocommerce',
      'label' => csi18n('app.dc.group-title-woocommerce')
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'shop_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.shop-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'checkout_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.checkout-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'account_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.account-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'terms_url',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.terms-url' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_items',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-item-count' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'cart_total',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.cart-total' )
    ));

    cornerstone_dynamic_content_register_field(array(
      'name'  => 'product_price',
      'group' => 'woocommerce',
      'label' => csi18n( 'app.dc.wc.product-price' ),
      'controls' => array( 'product' )
    ));

  }

  public function supply_field( $result, $field, $args = array() ) {

    if ( 0 === strpos( $field, 'product') ) {
      $product = CS()->component('Dynamic_Content')->get_product_from_args( $args );

      if ( ! $product ) {
        return $result;
      }
    }

    switch ( $field ) {
      case 'shop_url': {
        $result = wc_get_page_permalink( 'shop' );
        break;
      }
      case 'cart_url': {
        $result = wc_get_page_permalink( 'cart' );
        break;
      }
      case 'checkout_url': {
        $result = wc_get_page_permalink( 'checkout' );
        break;
      }
      case 'account_url': {
        $result = wc_get_page_permalink( 'myaccount' );
        break;
      }
      case 'terms_url': {
        $result = wc_get_page_permalink( 'terms' );
        break;
      }
      case 'cart_items': {
        $result = $this->render_cart_items();
        break;
      }
      case 'cart_total': {
        $result = $this->render_cart_total();
        break;
      }
      case 'product_price': {
        $result = $product->get_price();
        break;
      }
    }

    return $result;

  }

  public function render_cart_items() {
    return sprintf('<span data-csdc-wc-cart-items>%d</span>', WC()->cart->get_cart_contents_count());
  }

  public function render_cart_total() {
    return sprintf('<span data-csdc-wc-cart-total>%s</span>', WC()->cart->get_cart_total());
  }

  public function add_to_cart_fragment( $fragments ) {

    $fragments['[data-csdc-wc-cart-items]'] = $this->render_cart_items();
    $fragments['[data-csdc-wc-cart-total]'] = $this->render_cart_total();
    return $fragments;

  }
}
