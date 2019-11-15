<?php

class Cornerstone_Search extends Cornerstone_Plugin_Component {
 
  public function setup() {

    if( apply_filters('cornerstone_enable_search', '__return_true') && !is_admin() ) {

    	add_filter('posts_where' , array( $this, 'posts_where'), 10, 2 );
    	add_filter('posts_join', array( $this, 'posts_join'), 10, 2);
      add_filter('posts_distinct', array( $this, 'posts_distinct'), 10, 2);

    }

  }

  public function posts_where($where, $query) {

 	  global $wpdb;
 
 	  if ( $query->is_main_query() && $query->is_search() ) { 	  	
 	  	$where = str_replace(')))', $wpdb->prepare(") OR ({$wpdb->postmeta}.meta_key = '_cornerstone_data' AND {$wpdb->postmeta}.meta_value LIKE %s)))", "%{$wpdb->esc_like($query->query_vars['s'])}%"), $where );
 	  }
      
 	  return $where;

  }

  public function posts_join($join, $query) {

 	  global $wpdb;
      
      if ( $query->is_main_query()  && $query->is_search()) {
      	$join .= " LEFT JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id";
      }

      return $join;

  }

  public function posts_distinct ( $distinct, $query ) {

    return  $query->is_main_query()  && $query->is_search() ? 'DISTINCT' : $distinct;

  }

}
