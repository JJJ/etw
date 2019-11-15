<?php

class Cornerstone_Essential_Grid extends Cornerstone_Plugin_Component {

  protected $search_keyword;
 
  public function setup() {

    if( class_exists( 'Essential_Grid' ) ) {

        add_filter('essgrid_get_first_content_image', array( $this, 'first_image' ), 3, 20 );
        add_filter('essgrid_get_first_content_iframe', array( $this, 'first_iframe' ), 3, 20 );
        add_filter('essgrid_get_first_content_youtube', array( $this, 'first_youtube' ), 3, 20 );
        add_filter('essgrid_get_first_content_vimeo', array( $this, 'first_vimeo' ), 3, 20 );
        add_filter('essgrid_get_first_content_wistia', array( $this, 'first_wistia' ), 3, 20 );
        add_filter('essgrid_get_first_content_video', array( $this, 'first_video' ), 3, 20 );
        add_filter('essgrid_get_first_content_soundcloud', array( $this, 'first_soundcloud' ), 3, 20 );

        /* search fix */

        add_filter('output_search_result_ids_pre',  array( $this, 'initialize_query' ), 1, 20);

    }

  }    

  public function get_content ( $post ) {

        $content = get_post_field('post_content', $post->ID, 'raw' );

        if ( strpos( $content, "[cs_content]", 0 ) === false ) return '';

        return do_shortcode ( str_replace("[cs_content]", "[cs_content _p=\"{$post->ID}\" no_wrap=true ]" , $content ) );

  }

  public function first_image ( $first, $post_id, $post ) {

      $_first = '';

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

      if(isset($matches[1][0])) $_first = $matches[1][0];

      if(empty( $_first )) $_first = $first;

      return $_first;

  }

  public function first_iframe ( $first, $post_id, $post ) {

      $_first = '';

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all('/<iframe.+src=[\'"]([^\'"]+)[\'"].*>/i', $content, $matches);

      if(isset($matches[0][0])) $_first = $matches[0][0];

      if( empty($_first) ) $_first = $first;
      
      return $_first;

  }

  public function first_youtube ( $first, $post_id, $post ) {

      $_first = '';

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all('/(http:|https:|:)?\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube\.com(?:\/embed\/|\/v\/|\/watch\?v=|\/ytscreeningroom\?v=|\/feeds\/api\/videos\/|\/user\S*[^\w\-\s]|\S*[^\w\-\s]))([\w\-]{11})[?=&+%\w-]*/i', $content, $matches);

      if(isset($matches[2][0])) $_first = $matches[2][0];

      if( empty($_first) ) $_first = $first;
      
      return $_first;

  }

  public function first_vimeo ( $first, $post_id, $post ) {

      $_first = '';

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all('/(http:|https:|:)?\/\/?vimeo\.com\/([0-9]+)\??|player\.vimeo\.com\/video\/([0-9]+)\??/i', $content, $matches);

      if(isset($matches[2][0]) && !empty($matches[2][0])) $_first = $matches[2][0];
      if(isset($matches[3][0]) && !empty($matches[3][0])) $_first = $matches[3][0];

      if( empty($_first) ) $_first = $first;
      
      return $_first;

  }

  public function first_wistia ( $first, $post_id, $post ) {

      $_first = '';

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all('/(http:|https:|:)?\/\/?wistia\.net\/([0-9]+)\??|player\.wistia\.net\/video\/([0-9]+)\??/i', $content, $matches);

        if(isset($matches[2][0])) $_first = $matches[2][0];

        if( empty($_first) ){

          $output = preg_match_all("/wistia\.com\/(medias|embed)\/([0-9a-z]+)/i", $content, $matches);
          
          if(isset($matches[2][0])) $_first = $matches[2][0];

        }

      if( empty($_first) ) $_first = $first;
      
      return $_first;

  }

  public function first_video ( $first, $post_id, $post ) {

      $_first = false;

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all("'<video>(.*?)</video>'si", $content, $matches);

          if(isset($matches[0][0])){
            $videos = preg_match_all('/<source.+src=[\'"]([^\'"]+)[\'"].*>/i', $matches[0][0], $video_match);
            if(isset($video_match[1]) && is_array($video_match[1])){
              foreach($video_match[1] as $video_source){
                $vid = explode('.', $video_source);
                switch(end($vid)){
                  case 'ogv':
                    $_first['ogv'] = $video_source;
                    break;
                  case 'webm':
                    $_first['webm'] = $video_source;
                    break;
                  case 'mp4':
                    $_first['mp4'] = $video_source;
                    break;
                }
              }
            }
          }


      if( empty($_first) ) $_first = $first;
      
      return $_first;

  }  

  public function first_soundcloud ( $first, $post_id, $post ) {

      $_first = '';

      $content = $this->get_content( $post );

      if ( empty($content) ) return $first;

      $output = preg_match_all('/\/\/api.soundcloud.com\/tracks\/(.[0-9]*)/i', $content, $matches);

      if(isset($matches[1][0])) $_first = $matches[1][0];

      if( empty($_first) ) $_first = $first;
      
      return $_first;

  }

  /* search fix */

  public function initialize_query ( $data ) {

    $this->search_keyword = $data['search'];

    add_filter('essgrid_get_posts', array( $this, 'get_posts'), 90, 2 ); 

    add_filter('posts_where' , array( $this, 'posts_where'), 90, 2 );

    add_filter('posts_join', array( $this, 'posts_join'), 90, 2);

    return $data;

  }

  public function get_posts ( $query, $grid_id ) {

    $query['suppress_filters'] = true;

    return $query;

  }

  public function posts_where($where, $query) {

    global $wpdb;
 
    return str_replace(')))', $wpdb->prepare(") OR ({$wpdb->postmeta}.meta_key = '_cornerstone_data' AND {$wpdb->postmeta}.meta_value LIKE %s)))", "%{$wpdb->esc_like($this->search_keyword)}%"), $where );

  }

  public function posts_join($join, $query) {

    global $wpdb;
    
    return $join . " INNER JOIN {$wpdb->postmeta} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id";

  }

}
