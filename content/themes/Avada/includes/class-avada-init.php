<?php

class Avada_Init {

    public function __construct() {

        add_action( 'after_setup_theme', array( $this, 'load_textdomain' ) );
        add_action( 'after_setup_theme', array( $this, 'set_builder_status' ), 10 );
        add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ), 10 );
        add_action( 'after_setup_theme', array( $this, 'register_nav_menus' ) );
        add_action( 'after_setup_theme', array( $this, 'add_image_size' ) );
        add_action( 'after_setup_theme', array( $this, 'migrate' ) );
        add_action( 'wp', array( $this, 'set_theme_version' ) );
        // Allow shortcodes in widget text
        add_filter( 'widget_text', 'do_shortcode' );

        add_filter( 'wp_nav_menu_args', array( $this, 'main_menu_args' ) );
        add_action( 'admin_init', array( $this, 'theme_activation' ) );


    }

    /**
	 * Load the theme textdomain
	 */
	public function load_textdomain(){
		load_theme_textdomain( 'Avada', get_template_directory() . '/languages' );
	}

	/**
	 * Conditionally add theme_support for fusion_builder
	 */
	public function set_builder_status() {

		global $smof_data;

		if( ! $smof_data['disable_builder'] ) {
			add_theme_support( 'fusion_builder' );
		}

	}

	/**
	 * Stores the theme version in the options table in the WordPress database.
	 */
	public function set_theme_version() {

		if ( function_exists( 'wp_get_theme' ) ) {
			$theme_obj = wp_get_theme();
			$theme_version = $theme_obj->get( 'Version' );

			if( $theme_obj->parent_theme ) {
				$template_dir = basename( get_template_directory() );
				$theme_obj = wp_get_theme( $template_dir );
				$theme_version = $theme_obj->get( 'Version' );
			}

			update_option( 'avada_theme_version', $theme_version );
		}

	}

	/**
	 * Add theme_supports
	 */
	public function add_theme_supports() {

		// Default RSS feed links
		add_theme_support( 'automatic-feed-links' );
		// Default custom header
		add_theme_support( 'custom-header' );
		// Default custom backgrounds
		add_theme_support( 'custom-background' );
		// Woocommerce Support
		add_theme_support( 'woocommerce' );
        // Post Formats
        add_theme_support( 'post-formats', array( 'gallery', 'link', 'image', 'quote', 'video', 'audio', 'chat' ) );
        // Add post thumbnail functionality
        add_theme_support('post-thumbnails');

	}

    /**
     * Add image sizes
     */
     public function add_image_size() {

         add_image_size( 'blog-large', 669, 272, true );
         add_image_size( 'blog-medium', 320, 202, true );
         add_image_size( 'tabs-img', 52, 50, true );
         add_image_size( 'related-img', 180, 138, true );
         add_image_size( 'portfolio-full', 940, 400, true );
         add_image_size( 'portfolio-one', 540, 272, true );
         add_image_size( 'portfolio-two', 460, 295, true );
         add_image_size( 'portfolio-three', 300, 214, true );
         add_image_size( 'portfolio-four', 220, 161, true );
         add_image_size( 'portfolio-five', 177, 142, true );
         add_image_size( 'portfolio-six', 147, 118, true );
         add_image_size( 'recent-posts', 700, 441, true );
         add_image_size( 'recent-works-thumbnail', 66, 66, true );
     }

	/**
	 * Migrate script to decode theme options
	 */
    function migrate() {
    	if ( get_option( 'avada_38_migrate' ) != 'done' ) {
	     	$theme_version = get_option( 'avada_theme_version' );

	    	if( $theme_version == '1.0.0' ) { // child theme check failure
	    		$this->set_theme_version();
	    	}

	    	$theme_version = get_option( 'avada_theme_version' );

    		if ( version_compare( $theme_version, '3.8', '>=' ) && version_compare( $theme_version, '3.8.5', '<' ) ) {
    			$smof_data_to_decode = get_option( 'Avada_options' );

				$encoded_field_names = array( 'google_analytics', 'space_head', 'space_body', 'custom_css' );

				foreach ( $encoded_field_names as $field_name ) {
					$decoded_field_value = rawurldecode( $smof_data_to_decode[ $field_name ] );

					if ( $decoded_field_value ) {
						$smof_data_to_decode[ $field_name ] = $decoded_field_value;
					}
				}

				update_option( 'Avada_options', $smof_data_to_decode );
				update_option( 'avada_38_migrate', 'done' );
    		}
    	}
    }

	/**
	 * Register navigation menus
	 */
	public function register_nav_menus() {

		register_nav_menu( 'main_navigation', 'Main Navigation' );
		register_nav_menu( 'top_navigation', 'Top Navigation' );
		register_nav_menu( '404_pages', '404 Useful Pages' );
		register_nav_menu( 'sticky_navigation', 'Sticky Header Navigation' );

	}

    function theme_activation() {

    	global $pagenow;

    	if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) {

    		update_option( 'shop_catalog_image_size',   array( 'width' => 500, 'height' => '', 0 ) );
    		update_option( 'shop_single_image_size',    array( 'width' => 500, 'height' => '', 0 ) );
    		update_option( 'shop_thumbnail_image_size', array( 'width' => 120, 'height' => '', 0 ) );

    	}

    }

	function main_menu_args( $args ) {

		global $post;

		$c_pageID = '';

		if ( ( get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) && is_home() ) || ( get_option( 'page_for_posts' ) && is_archive() && ! is_tax( 'portfolio_category' ) && ! is_tax( 'portfolio_skills' )  && ! is_tax( 'portfolio_tags' ) && ! is_tax( 'faq_category' ) && ( class_exists( 'Woocommerce' ) && ! is_shop() ) && ! is_tax( 'product_cat') && ! is_tax( 'product_tag' ) ) ) {
			$c_pageID = get_option( 'page_for_posts' );
		} else {
			if ( isset( $post ) ) {
				$c_pageID = $post->ID;
			}

			if ( class_exists( 'Woocommerce' ) ) {
				if ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) {
					$c_pageID = get_option( 'woocommerce_shop_page_id' );
				}
			}
		}

		if ( get_post_meta( $c_pageID, 'pyre_displayed_menu', true ) != '' && get_post_meta( $c_pageID, 'pyre_displayed_menu', true ) != 'default' && ( $args['theme_location'] == 'main_navigation' || $args['theme_location'] == 'sticky_navigation' ) ) {
			$menu = get_post_meta( $c_pageID, 'pyre_displayed_menu', true );
			$args['menu'] = $menu;
		}

		return $args;

	}

}
