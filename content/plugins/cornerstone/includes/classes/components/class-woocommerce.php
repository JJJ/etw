<?php

class Cornerstone_WooCommerce extends Cornerstone_Plugin_Component {

  public function setup() {
    
    if( !class_exists( 'WC_API' ) ){
        return;
    }

    add_filter( 'cs_element_post_id', array( $this, 'cs_element_target_id' ) );

  }

  function cs_element_target_id( $target_post_id ){
  
    if( is_checkout() ){
      return wc_terms_and_conditions_page_id();
    }

    return $target_post_id;

  }
  
  

}