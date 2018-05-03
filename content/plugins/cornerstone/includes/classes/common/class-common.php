<?php

/**
 * Commonly used functions and a repository for commonly accessed data.
 */

class Cornerstone_Common extends Cornerstone_Plugin_Component {

	private $fontIcons;

	/**
	 * Instantiate
	 */
	public function setup() {

		$this->fontIcons = $this->plugin->config_group( 'common/font-icons' );
		add_action( 'init', array( $this, 'init' ) );

		$version = CS()->version();

		if ( false !== strpos( $version, '-alpha' ) ) {
			$this->plugin->loadComponent( 'Alpha' );
		}

		if ( false !== strpos( $version, '-' ) ) {
			$this->plugin->loadComponent( 'Prerelease' );
		}

    add_filter( 'cornerstone_save_post_content', array( $this, 'save_post_content' ) );

	}

	public function init() {

		if ( !is_user_logged_in() ) {
			add_action( 'template_redirect', array( $this, 'loginRedirect' ) );
		}

		register_post_status( 'tco-data', array(
			'label'                     => 'Data',
			'label_count'               => 'Data (%s)',
			'internal'                  => true,
		) );

	}

	/**
	 * Get a localized title.
	 * @return string
	 */
	public function properTitle() {
		return __( 'Cornerstone', 'cornerstone' );
	}

	/**
	 * Get an array of post types allowed for Cornerstone.
	 * This is based on both user role, and enabled post types
	 * @return array
	 */
	public function getAllowedPostTypes() {

		$settings = $this->plugin->settings();
		$user = wp_get_current_user();

		$allowed_types   = $settings['allowed_post_types'];
		$permitted_roles = $settings['permitted_roles'];

		if ( ! is_array( $settings['allowed_post_types'] ) ) {
			$allowed_types = explode( ',', $settings['allowed_post_types'] );
		}

    $allowed_types = array_filter( $allowed_types );

		if ( ! is_array( $settings['permitted_roles'] ) ) {
			$permitted_roles = explode( ',', $settings['permitted_roles'] );
		}

		if ( !empty( $user ) && ( user_can( $user, 'manage_options' ) || count( array_intersect( $permitted_roles, (array) $user->roles ) ) > 0 ) )
			return apply_filters( 'cornerstone_allowed_post_types', $allowed_types );

		return array();
	}

	/**
	 * Get Font Icon Unicode Value as a string
	 * @return string
	 */
	public function getFontIcon( $key ) {
		return ( isset( $this->fontIcons[ $key] ) ) ? $this->fontIcons[$key] : 'f00d';
	}

	/**
	 * Return font icon cache
	 * @return array
	 */
	public function getFontIcons() {
		return $this->fontIcons;
	}

	/**
	 * Check if a post's post_type is allowed for Cornerstone
	 * @param  object  $post_id Can also accept a full post object
	 * @return boolean
	 */
	public function isPostTypeAllowed( $post_id = '' ) {

		$post = $this->locatePost( $post_id );

		return ( $post && in_array( $post->post_type, $this->getAllowedPostTypes() ) );

	}

	/**
	 * This is different than the "Allowed" function. It simply returns the global setting
	 * regardless of user capability.
	 * @param  string  $post_id Can also accept a full post object
	 * @return boolean
	 */
	public function isPostTypeEnabled( $post_id = '' ) {

		$settings = $this->plugin->settings();
		$post = $this->locatePost( $post_id );

		$allowed_types = $settings['allowed_post_types'];

		if ( ! is_array( $settings['allowed_post_types'] ) ) {
			$allowed_types = explode( ',', $settings['allowed_post_types'] );
		}

		return ( $post && in_array( $post->post_type, apply_filters( 'cornerstone_allowed_post_types', $allowed_types ) ) );

	}

	/**
	 * Get a URL that can be used to access Cornerstone for a given post.
	 * @param  string $post Accepts a post object, or post ID. Uses queried object if one isn't provided
	 * @return string
	 */
	public function get_edit_url( $post = '' ) {

		$post = $this->locatePost( $post );

		if ( !$post)
			return null;

    $url = $this->get_app_route_url( 'content', $post->ID, 'builder' );

		// $args = apply_filters( 'cornerstone_edit_url_query_args', array( 'cornerstone' => 1 ) );
    //
		// $no_permalinks = apply_filters( 'cornerstone_no_permalinks', false );
    //
		// // if ( $no_permalinks ) {
		// // 	add_filter( 'page_link', array( $this, 'direct_page_link'), 10, 3 );
		// // 	add_filter( 'post_link', array( $this, 'direct_post_link'), 10, 3 );
		// // 	add_filter( 'post_type_link', array( $this, 'direct_custom_post_type_link'), 10, 4 );
		// // }
    //
		// $url = add_query_arg( $args, get_permalink( $post->ID ) );
    //
		// // if ( $no_permalinks ) {
		// // 	remove_filter( 'page_link', array( $this, 'direct_page_link') );
		// // 	remove_filter( 'post_link', array( $this, 'direct_post_link') );
		// // 	remove_filter( 'post_type_link', array( $this, 'direct_custom_post_type_link') );
		// // }

		if ( force_ssl_admin() ) {
      $url = preg_replace( '#^http://#', 'https://', $url );
    }

		return $url;

	}

	public function direct_page_link( $link, $post_id, $sample ) {
		return home_url( '?page_id=' . $post_id );
	}

	public function direct_post_link( $permalink, $post, $leavename ) {
		return home_url('?p=' . $post->ID);
	}

	public function direct_custom_post_type_link( $post_link, $post, $leavename, $sample ) {
		return home_url( add_query_arg(array('post_type' => $post->post_type, 'p' => $post->ID), '') );
	}

	/**
	 * Get a WP_Post object from an ID or an automatic source
	 * If $post_id is left black, it will be automatically populated (works in dashboard or on front end)
	 * @param  string $post_id
	 * @return WP_Post
	 */
	public function locatePost( $post_id = '') {

		// Allow pass through of full post objects
		if ( isset( $post_id->ID ) )
			return $post_id;

		// Get post by ID
		if ( is_int( $post_id ) )
			return get_post( $post_id );

		// Or, in the dashboard use a query string
		if ( is_admin() && isset($_GET['post']) )
			return get_post( $_GET['post'] );

		// Or, use the queried object
		if ( '' == $post_id ) {
			$post = get_queried_object();
			if ( is_a( $post, 'WP_POST' ))
				return $post;
		}

		// Otherwise there's just no way...
		return false;

	}

	public function get_post_settings( $post_id ) {
		$settings = cs_get_serialized_post_meta( $post_id, '_cornerstone_settings', true );
		return ( is_array( $settings ) ) ? $settings : array();
	}

	/**
	 * Detect if a post has saved Cornerstone data
	 * @return bool true is Cornerstone meta exists
	 */
	public function uses_cornerstone( $post_id = '' ) {

		$post = $this->locatePost( $post_id );

		if (!$post)
			return false;

		$rows = cs_get_serialized_post_meta( $post->ID, '_cornerstone_data', true );
		$override = get_post_meta( $post->ID, '_cornerstone_override', true );

		if ( !$rows || $override )
			return false;

		return true;
	}

	/**
	 * Potentially redirect a logged out user who was attempting to edit a page in Cornerstone.
	 * @return none
	 */
	public function loginRedirect() {
		if ( isset($_GET['cornerstone']) && $_GET['cornerstone'] == 1 && $this->isPostTypeEnabled() ) {
			wp_redirect( add_query_arg( array(
				'cornerstone' => '1'
			), wp_login_url( get_the_permalink() ) ) );
		}
	}

	/**
	 * Previusly returned appropriate js extension depending on SCRIPT_DEBUG.
   * This was removed in 2.0.3 in favor of always serving minified files with sourcemaps
	 * @return string
	 */
	public function jsSuffix() {
		return '.js';
	}

	/**
	 * Determine if we are debugging / developing
	 * @return boolean
	 */
	public function isDebug() {
		$wp_debug = ( defined('WP_DEBUG') && WP_DEBUG );
		$cs_debug = ( isset($_REQUEST['cs_debug']) && $_REQUEST['cs_debug'] == 1 );
		return ( $wp_debug || $cs_debug );
	}

	/**
	 * Create an image URI of a blank SVG image to be used as a placeholder
	 * @return string
	 */
	public function placeholderImage( $height = '300', $width = '250', $color = '#eeeeee' ) {
		return 'data:image/svg+xml;base64,' . base64_encode( "<svg xmlns='http://www.w3.org/2000/svg' width='{$width}px' height='{$height}px' viewBox='0 0 {$width} {$height}' version='1.1'><rect fill='{$color}' x='0' y='0' width='{$width}' height='{$height}'></rect></svg>" );
	}

	public function classMap( $group = '', $classes ) {

		$single = false;

		if ( ! is_array( $classes ) ) {
			$single = true;
			$classes = array( $classes );
		}

		if ( ! isset( $this->cssClassMap ) ) {
			$this->cssClassMap = $this->plugin->config_group( 'common/class-map' );
		}

		if ( ! isset( $this->cssClassMap[ $group ] ) ) {
			trigger_error( "Cornerstone_Common::classMap group: $group doesn't exist in class map.", E_USER_WARNING );
			return array( '' );
		}

		$this->cssClassMapGroup = $this->cssClassMap[ $group ];

		$map = array_map( array( $this, 'classMapHandler' ), $classes );

		return ( $single ) ? $map[0] : $map;

	}

	protected function classMapHandler( $class ) {

		if ( ! isset( $this->cssClassMapGroup[ $class ] ) ) {
			return '';
		}

		return $this->cssClassMapGroup[ $class ];

	}

	public function set_default_post_types( $types = array() ) {

		if ( is_array( $types ) ) {
			$this->default_post_types = $types;
		}

		add_filter( 'cornerstone_config_common_default-settings', array( $this, 'filter_default_post_types' ) );

	}

	public function filter_default_post_types( $config ) {
		$config['allowed_post_types'] = $this->default_post_types;
		return $config;
	}

	public function is_validated() {
		return ( get_option( 'cs_product_validation_key', false ) !== false );
	}

	public function get_post_capability( $post_id = false, $cap ) {

		$post = $this->locatePost( $post_id );

    if ( ! is_a( $post, 'WP_POST' ) ) {
      return $cap;
    }

		return $this->get_post_type_capability( $post->post_type, $cap );

	}

  public function get_post_type_capability( $post_type, $cap ) {

    $post_type_object = get_post_type_object( $post_type );
		$caps = (array) $post_type_object->cap;
		return $caps[ $cap ];

  }


  public function get_app_slug() {

    $settings = $this->plugin->settings();

    $slug = apply_filters( 'cornerstone_default_app_slug', 'cornerstone' );

    if ( isset( $settings['custom_app_slug'] ) && '' !== $settings['custom_app_slug'] ) {
      $slug = sanitize_title_with_dashes( $settings['custom_app_slug'] );
    }

    return $slug;

  }

  public function get_app_url() {
    return untrailingslashit( home_url( $this->plugin->common()->get_app_slug() ) );
  }

	public function get_launch_url() {
    return $this->get_app_route_url();
	}

  public function get_app_route_url( $route = '', $model_id = '', $route_context = '') {

    if ( ! $this->plugin->component( 'Router' )->is_permalink_structure_valid() ) {
      $args = array('cs-launch' => 1);
      if ( $route ) {
        $args['cs_route'] = esc_attr($route);
        if ( $route_context ) {
          $args['cs_route'] .= ".$route_context";
        }
        if ( $model_id ) {
          $args['cs_route'] .= "/$model_id";
        }
      }
      return add_query_arg( $args, home_url() );
    }

    $url = $this->get_app_url();

    if ( $route ) {
      $route = str_replace('.', '/', $route );
      $url .= "/#/$route";
      if ( $model_id ) {
        $url .= "/$model_id";
      }
    }

    return $url;

	}


	public function sanitize_value( $value, $html = false ) {

    // Pass through non string values.
    // This Preserves data types, but watch out for arrays since we don't handle nested data here.
    if ( ! is_string( $value ) ) {
      return $value;
    }

    // Sanitize
    if ( $html ) {
      return $this->sanitize_html( $value );
    } else {
      return sanitize_text_field( $value );
    }

	}

  public function escape_value( $value, $html = false ) {

    // Pass through non string values.
    // This Preserves data types, but watch out for arrays since we don't handle nested data here.
    if ( ! is_string( $value ) ) {
      return $value;
    }

    return ( $html ) ? $value : esc_html( $value );

	}

	public function sanitize_value_deep( $value, $html = false ) {

		if ( is_array( $value ) ) {
			$cleaned = array();
			foreach ($value as $key => $val) {
				$cleaned[$key] = $this->sanitize_value_deep($val, $html);
			}
			return $cleaned;
		}

		return $this->sanitize_value( $value );

	}

	public function sanitize_html( $data ) {

    if ( current_user_can( 'unfiltered_html' ) ) {
      return $data;
    }

		return wp_kses( $data, $this->ksesTags() );
	}

  public function ksesTags() {

		$tags = wp_kses_allowed_html( 'post' );

		$tags['iframe'] = array (
	    'align'       => true,
	    'frameborder' => true,
	    'height'      => true,
	    'width'       => true,
	    'sandbox'     => true,
	    'seamless'    => true,
	    'scrolling'   => true,
	    'srcdoc'      => true,
	    'src'         => true,
	    'class'       => true,
	    'id'          => true,
	    'style'       => true,
	    'border'      => true,
	    'list'        => true //YouTube embeds
		);

		return $tags;

	}

	public function theme_integration_options() {
		$defaults = $this->plugin->config_group( 'options/defaults' );
    $retrieved = array();
    foreach ($defaults as $name => $default) {
      $retrieved[$name] = get_option( $name, $default );
    }
    return $retrieved;
	}

  public function save_post_content( $content ) {

		// Move all <!--nextpage--> directives to outside their section.
		$content = preg_replace( '#(?:<!--nextpage-->.*?)(\[\/cs_section\])#', '$0<!--nextpage-->', $content );

		//Strip all <!--nextpage--> directives still within sections
		$content = preg_replace( '#(?<!\[\/cs_section\])<!--nextpage-->#', '', $content );

		$content = str_replace( '<!--more-->', '', $content );

		return $content;

  }

	public function get_preview_zones() {
		return apply_filters('cs_preview_zones', array( 'cs_content', 'x_after_masthead_begin', 'x_before_site_begin', 'x_before_site_end', 'x_masthead', 'x_colophon' ));
	}

  /**
   * Call inside the template_include filter to replace the global $post
   */
  public function override_global_post( $post_id, $args = array() ) {

    $args = array_merge( array(
      'post_count'    => 1,
      'found_posts'   => 1,
      'max_num_pages' => 0,
      'is_404'        => false,
      'is_page'       => true,
      'is_singular'   => true
    ), $args );

    $target_post = get_post( $post_id );

    if ( ! is_a( $target_post, 'WP_Post' ) ) {
      return false;
    }

    global $wp_query;
    global $post;

    $post = $target_post;

    $wp_query->posts             = array( $post );
    $wp_query->queried_object_id = $post->ID;
    $wp_query->queried_object    = $post;

    foreach ($args as $key => $value) {
      $wp_query->$key = $value;
    }

    setup_postdata( $post );

    return true;
  }

}
