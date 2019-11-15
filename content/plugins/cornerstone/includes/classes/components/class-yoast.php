<?php

class Cornerstone_Yoast extends Cornerstone_Plugin_Component {

  protected $active_post;
  
  protected $processed_post = array();
  
  protected $link_processor;

  public function setup() {

  		add_filter('wpseo_sitemap_urlimages', array($this, 'get_images'), 10, 2 );

      if( class_exists('WPSEO_Link_Content_Processor') && defined( 'WPSEO_PREMIUM_PLUGIN_FILE' ) ) { //If Yoast Premium

          $this->link_processor =  new WPSEO_Link_Content_Processor( new WPSEO_Link_Storage(), new WPSEO_Meta_Storage() );

          add_action( 'save_post', array( $this, 'save_post' ), 90, 2 );

          add_action( 'delete_post', array( $this, 'delete_post' ), 80 );

      }

  }

  public function ajax_yoast_do_shortcode( $data ) {

		if ( ! current_user_can( 'manage_options' ) || ! isset($data['content']) ) {
			return cs_send_json_error();
		}

	    $content = array();

	    foreach ($data['content'] as $shortcodes) {
	      $content[] = do_shortcode( wp_unslash( $shortcodes ) );
	    }

		return cs_send_json_success( array( 'content' => $content ) );

	}

  public function get_images ( $images, $post_id ) { 

     if ( isset( $this->processed_post[ $post_id ] )) return $images; //Prevent infinite loop	

     $this->active_post =  get_post( $post_id );

     add_filter('wpseo_sitemap_content_before_parse_html_images', array( $this, 'post_content' ) );

     $this->processed_post [ $post_id ] = true;


     $image_parser = new WPSEO_Sitemap_Image_Parser();

  	 return array_merge( $images, $image_parser->get_images ( $this->active_post ) );

  }

  public function post_content ( $content ) {

  	 if ( strpos( $content, "[cs_content]", 0 ) === false ) return ""; //We don't want to re-count images from non-cornerstone content

  	 return do_shortcode (str_replace("[cs_content]", "[cs_content _p=\"{$this->active_post->ID}\" no_wrap=true ]" , $content ));

  }

/* Yoast Premium related functions */


  public function save_post ( $post_id, WP_Post $post ) {

      if ( ! WPSEO_Link_Table_Accessible::is_accessible() || ! WPSEO_Meta_Table_Accessible::is_accessible() ) {
      return;
      }

      // When the post is a revision.
      if ( wp_is_post_revision( $post->ID ) ) {
        return;
      }

      $post_statuses_to_skip = array( 'auto-draft', 'trash' );

      if ( in_array( $post->post_status, $post_statuses_to_skip, true ) ) {
        return;
      }

      // When the post isn't processable, just remove the saved links.
      if ( ! $this->is_processable( $post_id ) ) {
        return;
      }

      $this->process( $post_id, $post->post_content );

  }

  public function delete_post ( $post_id ) {

      if ( ! WPSEO_Link_Table_Accessible::is_accessible() || ! WPSEO_Meta_Table_Accessible::is_accessible() ) {
        return;
      }

      // Fetch links to update related linked objects.
      $links = $this->link_processor->get_stored_internal_links( $post_id );

      // Update the storage, remove all links for this post.
      $storage = new WPSEO_Link_Storage();
      $storage->cleanup( $post_id );

      // Update link counts for object and referenced links.
      $this->link_processor->update_link_counts( $post_id, 0, $links );

  }

  protected function is_processable( $post_id ) {
    if ( ! class_exists( 'WPSEO_Post_Type' ) ) {
      return false;
    }
    $post_types = WPSEO_Post_Type::get_accessible_post_types();
    return isset( $post_types[ get_post_type( $post_id ) ] );
  }

  private function process( $post_id, $content ) {

      // Apply the filters to have the same content as shown on the frontend.
      $content = strpos( $content, "[cs_content]", 0 ) === false ? apply_filters( 'the_content', $content ) : do_shortcode ( str_replace("[cs_content]", "[cs_content _p=\"{$post_id}\" no_wrap=true ]" , $content ) );

      $content = str_replace( ']]>', ']]&gt;', $content );

      $this->link_processor->process( $post_id, $content );

  }

/* Yoast Premium related functions */

}
