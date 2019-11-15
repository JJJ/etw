<?php

class Cornerstone_Shortcode_Finder extends Cornerstone_Plugin_Component {

  protected $shortcodes = array();
  protected $skip = array();

  public function setup() {

      //E&P Shortcode finder

      add_filter('cost_estimation_get_ids', array($this, 'wp_estimation_form') );

      //The grid shortcode finder
      add_filter('option_the_grid_global_library', array($this, 'the_grid'), 9999999 );

      //RevSlider shortcode finder
      add_filter('rs_get_global_settings', array($this, 'revslider'), 9999999 );

      //Pro header integration of both E&P and The Grid shortcode
      add_filter('cs_match_header_assignment', array($this, 'pro_header_footer_shortcodes') );
      add_filter('cs_match_footer_assignment', array($this, 'pro_header_footer_shortcodes') );

  }


/* Integration functions */

  public function wp_estimation_form ( $post ) {

      remove_filter('cost_estimation_get_ids', array($this, 'wp_estimation_form') );

      $shortcode = "estimation_form";

      $this->process_content( $shortcode, $post->ID );

      $this->wp_estimation_form_process_header_footer( $post );

      return $this->get_shortcode_data( $shortcode, 'form_id' );

  }

  public function the_grid( $enable ) {

      if ( !is_admin() ) {

        $shortcode = "the_grid";

        //If it's already global then let's skip everything
        if ( $enable ) {
          $this->skip[] = $shortcode;
          return $enable;
        }

        $post_ID = $this->single_ID();

        if ( $post_ID ) {

            $this->process_content( $shortcode, $post_ID );

        }

        if ( $this->has( $shortcode) ) return true; //since process_content() can be called earlier or anywhere, checking should be done even $post_ID is false.

      }

      return $enable;

  }

  public function revslider ($options) {

    if( !is_admin() ) {


      $shortcode = "rev_slider";

      //If it's already global then let's skip everything
      if ( isset($options['allinclude']) && $options['allinclude'] == "true" ) {
        $this->skip[] = $shortcode;
        return $enable;
      }

      $above = false;
      $below = false;
      
      $post_ID = $this->single_ID();

      if ( $post_ID ) {          

          $this->process_content( $shortcode, $post_ID );

          //Check above and below masthead too
          $above = get_post_meta( $post_ID, '_x_slider_above', true );
          $below = get_post_meta( $post_ID, '_x_slider_below', true );      

          $above = strpos( $above , 'x-slider-' ) !== false && strpos( $above , 'x-slider-ls-' ) === false ? true : false;
          $below = strpos( $below , 'x-slider-' ) !== false && strpos( $below , 'x-slider-ls-' ) === false ? true : false;

      }

      if ( $this->has( $shortcode) || $above || $below ) $options['allinclude'] = "true"; //since process_content() can be called earlier or anywhere, checking should be done even $post_ID is false.

    }

    return $options;

  }


  /* Special code to make Estimation Plugin works with header and footer */

  protected function wp_estimation_form_process_header_footer ( $the_post ) {

    global $wp_query; //since queried object is null which is required for singular and page checking, we'll fill it later too

    global $post;//Currently null, but will be filled below

    $temp_query = $wp_query; //Let's save it first so we can restore it back to make sure it won't affect other Wordpress functionalities



    $front_page = $wp_query->is_page( $the_post ) && get_option( 'page_on_front' ) == $the_post->ID ? true : false; //our own is_front_page()

    $is_shop = function_exists( 'wc_get_page_id' ) && wc_get_page_id( 'shop' )  == $the_post->ID && $wp_query->is_page( $the_post ) ? true : false; //our own is_shop()



    if ( !is_home() ) {

       $post = $the_post;

       setup_postdata( $post );

       if ( $front_page || $is_shop ) {

         $wp_query->queried_object_id = $the_post->ID;
         $wp_query->queried_object = $the_post;

       }

    } //Empty $post automatically default to is_home()


    $header_assignment = CS()->component('Header_Assignments')->locate_assignment();
    $footer_assignment = CS()->component('Footer_Assignments')->locate_assignment();

    wp_reset_postdata();

    unset($post);//Return it to null

    $wp_query = $temp_query;//Return to original wp_query




    $this->process_content( "estimation_form", $header_assignment, false );
    $this->process_content( "estimation_form", $footer_assignment, false );

  }

  /* Standard code to make other plugins work with header and footer */

  public function pro_header_footer_shortcodes ( $match, $assignments = array(), $post = false ) {

    if ( $match ) {

        $shortcodes = array (
          "the_grid",
          "revslider"
        );

        foreach ($shortcodes as $shortcode) {
            if ( !in_array( $shortcode, $this->skip ) ) {
              $this->process_content( $shortcode, $match, false );
            }
        }

    }

    return $match;

  }

/* common functions */
  
  public function single_ID() {

      global $post;

      return is_a( $post, 'WP_POST' ) ? $post->ID : false;

  }

  public function has ( $shortcode ) { //Use to detect shortcode even without attributes

    return isset( $this->shortcodes[$shortcode]);

  }

  public function get_shortcode_data ( $shortcode, $attribute = false, $index = 0 ) {

        return !$attribute ? $this->shortcodes[$shortcode]['single'][ $index ] : $this->shortcodes[$shortcode]['group'][$attribute];

  }

  public function process_content ( $shortcode, $post_ID, $meta = true ) {

      if ( $meta ) { //Cornerstone and global block data

          $post_data = get_post_meta( $post_ID, '_cornerstone_data', true );

      } else { //Pro header and footer data

          $post = get_post( $post_ID );

          $post_data = $post->post_content;

      }

      if ( is_array($post_data) ) {//An array of data is very rare, we don't want to incorporate maybe_serialize() everytime
          $post_data = maybe_serialize ( $post_data );
      }
      
      $post_data = str_replace( '\"', '"', apply_filters('cs_read_post_data', maybe_serialize($post_data), $post_ID ) );

      $shortcode = trim( $shortcode, '[] ');

      if ( strpos($post_data, $shortcode) !== false ) {

          //Shortcode pattern based on https://codex.wordpress.org/Function_Reference/get_shortcode_regex

          preg_match_all('/\[(\[?)('.$shortcode.')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/U', $post_data, $matches);

          if ( is_array($matches) && is_array($matches[0]) && count($matches[0]) > 0 ) {

              if( !$this->has ( $shortcode ) ) {
                $this->shortcodes[$shortcode] = array(); //Let initialize it first in case it has no attributes but we still want to detect if the shortcode exist later
              }

              //Make sure the counter doesn't reset everytime process_content() is called, like in nested global_block.
              $offset = isset($this->shortcodes[$shortcode]['single']) ? count ( $this->shortcodes[$shortcode]['single'] ) : 0;

              foreach ($matches[3] as $index => $attributes ) {

                    preg_match_all('/([\w\-]+)\s*=\s*"([\w\- ]+)"/U', $attributes, $matched_attributes);

                    if ( is_array($matched_attributes) && count($matched_attributes[0]) > 0 ) {

                          foreach ($matched_attributes[1] as $key => $atts) {

                              $this->shortcodes[$shortcode]['single'][$offset + $index][$atts] = $matched_attributes[2][$key];
                              $this->shortcodes[$shortcode]['group'][$atts][] = $matched_attributes[2][$key];

                          }

                    }


              }

          }

      }

      //All good, then we need to check global block as well

      $this->check_global_block( $shortcode, $post_data, true ); //Global block element

      $this->check_global_block( $shortcode, $post_data, false ); //Global block shortcode


  }

  protected function check_global_block ( $shortcode, $post_data, $element = true ) {

    if( $element ) { // If global block element

        if ( strpos($post_data, 'global_block_id') !== false ) {

          preg_match_all('/"global_block_id":"(\w+)"/U', $post_data, $global_blocks);

          if ( is_array($global_blocks) && count($global_blocks[0]) > 0 ) {

            foreach ($global_blocks[1] as $block_id ) {

              $this->process_content( $shortcode, $block_id );

            }

          }

        }

    } else { // If global block shortcode

         if ( strpos($post_data, 'cs_gb') !== false ) {

            preg_match_all('/\[(\[?)cs_gb(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/U', $post_data, $matches);

            if ( is_array($matches) && count($matches[0]) > 0 ) {

                foreach ($matches[2] as $global_block_attribute ) {

                    preg_match_all('/(\w+)\s*=\s*(\d+(\.\d{1,2})?)/', $global_block_attribute, $matched_attributes);

                    if ( is_array($matched_attributes) && count($matched_attributes[0]) > 0 ) {

                          foreach ($matched_attributes[1] as $key => $atts) {

                              $this->process_content( $shortcode, $matched_attributes[2][$key] );

                          }

                    }

                }

            }


         }
    }

  }


}

