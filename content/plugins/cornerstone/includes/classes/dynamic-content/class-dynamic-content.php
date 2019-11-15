<?php

class Cornerstone_Dynamic_Content extends Cornerstone_Plugin_Component {

  protected $fields = array();
  protected $groups = array();
  protected $cache = array();

  public function setup() {

    $this->plugin->component( 'Dynamic_Content_Post' );

    $this->plugin->component( 'Dynamic_Content_Archive' );
    $this->plugin->component( 'Dynamic_Content_User' );
    $this->plugin->component( 'Dynamic_Content_Global' );

    if ( class_exists( 'ACF' ) ) {
      $this->plugin->component( 'Dynamic_Content_ACF' );
    }

    if ( defined( 'WPCF_VERSION' ) ) {
      $this->plugin->component( 'Dynamic_Content_Toolset' );
    }

    if ( function_exists( 'WC' ) ) {
      $this->plugin->component( 'Dynamic_Content_WooCommerce' );
    }


    // Front End
    add_filter( 'cs_decode_shortcode_attribute', array( $this, 'expand' ) );
    add_filter( 'cs_content_shortcode_output', array( $this, 'expand' ) );
    add_filter( 'cs_content_late', array( $this, 'expand' ) );
    add_filter( 'cs_render_bar_output', array( $this, 'expand' ) );
    add_filter( 'cs_css_post_process', array( $this, 'expand' ) );

    // API - use this filter to expand DC directives.
    // Example: $expanded_content = apply_filters( 'cs_dynamic_content', $my_content );
    add_filter( 'cs_dynamic_content', array( $this, 'expand' ) );

    // Preview
    add_filter( 'cs_render_element_template', array( $this, 'expand' ) );
    add_filter( 'cs_render_the_content', array( $this, 'expand' ) ); // Classic
    add_filter( 'cs_render_element_isolate_html', array( $this, 'expand' ) );
    add_filter( 'cs_render_element_zone_output', array( $this, 'expand' ) );
    add_filter( 'cs_element_update_build_shortcode_content', array( $this, 'expand_in_preview' ) );
  }

  public function register_field($field) {

    if (isset($field['name']) && isset($field['group']) ) {
      $key = $field['group'] . ':' . $field['name'];
      $this->fields[$key] = $field;
    }

  }

  public function register_group( $group ) {

    if (isset($group['name']) ) {
      $this->groups[$group['name']] = cs_define_defaults( $group, array(
        'label' => 'Group'
      ) );
    }

  }

  public function get_dynamic_fields() {

    do_action( 'cs_dynamic_content_setup' );

    return apply_filters( 'cs_dynamic_content_ui', array(
      'fields' => $this->fields,
      'groups' => $this->groups
    ) );
  }

  public function expand_in_preview( $content ) {
    return did_action( 'cs_element_rendering' ) ? $this->expand( $content ) : $content;
  }

  public function expand( $content ) {

    if ( ! apply_filters( 'cs_dynamic_content_should_expand', true ) ) {
      return $content;
    }

    $content = apply_filters( 'cs_dynamic_content_before_expand', $content );

    // for {{dc}}
    $content = preg_replace_callback(
      '/{{dc:([A-Za-z0-9_-]*):?([A-Za-z0-9_-]*)(.*?)}}/',
      array( $this, 'expand_callback' ),
      $content
    );

    // For encoded version (e.g. Subject, Telephone)
    $content = preg_replace_callback(
      '/%7B%7Bdc:([A-Za-z0-9_-]*):?([A-Za-z0-9_-]*)(.*?)%7D%7D/',
      array( $this, 'expand_callback_encoded' ),
      $content
    );

    return apply_filters( 'cs_dynamic_content_after_expand', $content );

  }

  public function expand_callback_encoded( $matches ){
    return $this->expand_callback( $matches, true );
  }

  public function expand_callback( $matches, $encode_uri = false ) {

    $type  = isset($matches[1]) ? $matches[1] : '';
    $field = isset($matches[2]) ? $matches[2] : '';
    $args  = isset($matches[3]) ? $this->parse_args( trim($matches[3]) ) : array();

    $result = apply_filters( "cs_dynamic_content_{$type}", '', $field, $args );
    $result = apply_filters( "cs_dynamic_content_{$type}_{$field}", $result, $args );

    if ( ! $result && isset( $args['fallback'] ) ) {
      $result = $args['fallback'];
    }

    // if URL must be encoded
    if( $encode_uri ){
      $result = rawurlencode( $result );
    }

    return is_string($result) ? $result : '';

  }

  public function parse_args( $arg_string ) {

    $args = array();

    // un wptexturize
    $arg_string = str_replace( '&#8220;', '"', $arg_string ); // opening curly double quote
    $arg_string = str_replace( '&#8221;', '"', $arg_string ); // closing curly double quote
    $arg_string = str_replace( '&#8217;', "'", $arg_string ); // apostrophe
    $arg_string = str_replace( '&#8242;', "'", $arg_string ); // prime
    $arg_string = str_replace( '&#8243;', '"', $arg_string ); // double prime
    $arg_string = str_replace( '&#8216;', "'", $arg_string ); // opening curly single quote
    $arg_string = str_replace( '&#8217;', "'", $arg_string ); // closing curly single quote

    $arg_string = str_replace('&amp;quot;', '&quot;', $arg_string );
    $arg_string = str_replace('&amp;apos;', '&apos;', $arg_string );
    $arg_string = preg_replace_callback( '%(?:[^\\\](?:(&quot;)|(&apos;)))%', array( $this, 'parse_args_normalize_quotes' ), $arg_string);
    $arg_string = preg_replace_callback( '%(?:[^\\\](?:(&quot;)|(&apos;)))%', array( $this, 'parse_args_normalize_quotes' ), $arg_string);

    preg_match_all( '%(\w+)\s*=\s*(?:"((?:[^"\\\]++|\\\.)*+)"|\'((?:[^\'\\\]++|\\\.)*+)\')%', $arg_string, $matches );

    foreach( $matches[1] as $index => $key ) {
      $arg = '';
      if ( isset( $matches[2][$index] ) && $matches[2][$index] ) $arg = $matches[2][$index];
      if ( isset( $matches[3][$index] ) && $matches[3][$index] ) $arg = $matches[3][$index];
      $args[$key] = str_replace( '\}', '}', wp_unslash( $arg ) );
    }

    return $args;
  }

  public function parse_args_normalize_quotes($matches) {
    return str_replace('&apos;', "'", str_replace('&quot;', '"', $matches[0]));
  }

  public function get_post_from_args( $args ) {
    return $this->get_cached_post(
      isset( $args['post'] ) ? $args['post'] : get_the_ID()
    );
  }

  public function get_cached_post( $post_id ) {

    $key = "post:$post_id";

    if ( ! isset( $this->cache[$key] ) ) {

      $post = null;
      $current_id = get_the_ID();

      if ( 'next' === $post_id ) {
        $next = get_next_post();
        if ( is_a( $next, 'WP_Post' ) && $current_id !== $next->ID ) {
          $post = $next;
        }
      } elseif ( 'prev' === $post_id ) {
        $prev = get_previous_post();
        if ( $prev && is_a( $prev, 'WP_Post' ) && $current_id !== $prev->ID ) {
          $post = $prev;
        }
      } elseif ( (int) $post_id > 0 ) {
        $post = get_post( (int) $post_id );
      }

      $this->cache[$key] = is_a( $post, 'WP_Post' ) ? $post : null;

    }

    return $this->cache[$key];

  }

  public function get_term_from_args( $args ) {

    if ( isset( $args['term'] ) ) {
      $cache_args['term'] = $args['term'];
    } else {
      $cache_args['post'] = get_the_ID();
    }

    return $this->get_cached_term( $cache_args );

  }

  public function get_product_from_args( $args ) {
    if ( isset( $args['product'] ) ) {
      $product_id = $args['product'];
    } else {
      $product_id = get_the_ID();
    }

    return $this->get_cached_product( $product_id );
  }

  public function get_cached_product( $product_id ) {
    $key = "product:$product_id";

    if ( ! isset( $this->cache[$key] ) ) {
      $this->cache[$key] = wc_get_product( $product_id );
    }

    return $this->cache[$key];
  }

  public function get_cached_term( $args ) {

    if ( isset( $args['term'] ) ) {
      $key = 'term:' . $args['term'];
    }

    if ( isset( $args['post'] ) ) {
      $key = 'term-post:' . $args['post'];
    }

    if ( $key && ! isset( $this->cache[$key] ) ) {

      $term_id = null;

      if ( isset( $args['term'] ) ) {
        $term_id = $args['term'];
      }

      if ( isset( $args['post'] ) ) {

        // Check if it's being viewed from an archives page
        if( is_archive() ){

          // it must return the archive data based on the actual term being viewed
          $term_id = get_queried_object_id();

        }else{ // being viewed from a post page

          $post_terms = get_the_category( (int) $args['post'] );

          if ( isset( $post_terms[0] ) && is_a( $post_terms[0], 'WP_Term' ) ) {
            $term_id = $post_terms[0]->term_id;
          }

        }
      }

      if ( $term_id ) {
        $this->cache[$key] = get_term( $term_id );
      } else {
        $this->cache[$key] = null;
      }

    }

    return $this->cache[$key];
  }

  public function get_user_from_args( $args ) {
    $user_id = isset($args['user']) ? $args['user'] : get_current_user_id();

    if ('author' === $user_id) {
      $user_id = get_the_author_meta('ID');
    }
    return $this->get_cached_user( $user_id );
  }

  public function get_cached_user( $user_id ) {
    if ( !$user_id ) {
      return null;
    }

    $key = "user:$user_id";
    if ( ! isset( $this->cache[$key] ) ) {
      $user = get_user_by( 'ID', (int) $user_id );
      if ( ! $user ) {
        return null;
      }
      $this->cache[$key] = $user;
    }

    return $this->cache[$key];
  }

}
