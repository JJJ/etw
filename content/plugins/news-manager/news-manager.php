<?php
/*
  Plugin Name: News Manager
  Description: Every CMS site needs a news section. News Manager allows you add, manage and display news, date archives, AJAX Calendar, Categories, Tags and more.
  Version: 1.1.0
  Author: dFactory
  Author URI: http://www.dfactory.eu/
  Plugin URI: http://www.dfactory.eu/plugins/news-manager/
  License: MIT License
  License URI: http://opensource.org/licenses/MIT

  News Manager
  Copyright (C) 2013-2016, Digital Factory - info@digitalfactory.pl

  Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

if ( ! defined( 'ABSPATH' ) )
	exit; //exit if accessed directly

define( 'NEWS_MANAGER_URL', plugins_url( '', __FILE__ ) );
define( 'NEWS_MANAGER_PATH', plugin_dir_path( __FILE__ ) );
define( 'NEWS_MANAGER_REL_PATH', dirname( plugin_basename( __FILE__ ) ) . '/' );

$news_manager = new News_Manager();

include_once(NEWS_MANAGER_PATH . 'includes/settings.php');
include_once(NEWS_MANAGER_PATH . 'includes/query.php');
include_once(NEWS_MANAGER_PATH . 'includes/widgets.php');
include_once(NEWS_MANAGER_PATH . 'includes/functions.php');

class News_Manager {

	private $options = array();
	private $currencies = array();
	private $defaults = array(
		'general'		 => array(
			'supports'								 => array(
				'title'			 => true,
				'editor'		 => true,
				'author'		 => true,
				'thumbnail'		 => true,
				'excerpt'		 => true,
				'custom-fields'	 => false,
				'comments'		 => true,
				'trackbacks'	 => false,
				'revisions'		 => false
			),
			'use_categories'						 => true,
			'builtin_categories'					 => false,
			'use_tags'								 => true,
			'builtin_tags'							 => false,
			'deactivation_delete'					 => false,
			'news_nav_menu'							 => array(
				'show'		 => false,
				'menu_name'	 => '',
				'menu_id'	 => 0,
				'item_id'	 => 0
			),
			'first_weekday'							 => 1,
			'news_in_rss'							 => false,
			'display_news_in_tags_and_categories'	 => true,
			'rewrite_rules'							 => true
		),
		'capabilities'	 => array(
			'publish_news',
			'edit_news',
			'edit_others_news',
			'edit_published_news',
			'delete_published_news',
			'delete_news',
			'delete_others_news',
			'read_private_news',
			'manage_news_categories',
			'manage_news_tags'
		),
		'permalinks'	 => array(
			'news_slug'						 => 'news',
			'news_categories_rewrite_slug'	 => 'category',
			'news_tags_rewrite_slug'		 => 'tag',
			'single_news_prefix'			 => false,
			'single_news_prefix_type'		 => 'category'
		),
		'version'		 => '1.1.0'
	);
	private $transient_id = '';

	public function __construct() {
		register_activation_hook( __FILE__, array( &$this, 'multisite_activation' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'multisite_deactivation' ) );

		//settings
		$this->options = array_merge(
			array( 'general' => get_option( 'news_manager_general' ) ), array( 'permalinks' => get_option( 'news_manager_permalinks' ) )
		);

		//update plugin version
		update_option( 'news_manager_version', $this->defaults['version'], '', 'no' );

		//session id
		$this->transient_id = (isset( $_COOKIE['nm_transient_id'] ) ? $_COOKIE['nm_transient_id'] : 'nmtr_' . sha1( $this->generate_hash() ));

		//actions
		add_action( 'init', array( &$this, 'register_taxonomies' ) );
		add_action( 'init', array( &$this, 'register_post_types' ) );
		add_action( 'plugins_loaded', array( &$this, 'init_session' ), 1 );
		add_action( 'plugins_loaded', array( &$this, 'load_textdomain' ) );
		add_action( 'admin_footer', array( &$this, 'edit_screen_icon' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'admin_scripts_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'front_scripts_styles' ) );
		add_action( 'admin_notices', array( &$this, 'news_admin_notices' ) );

		//filters
		add_filter( 'map_meta_cap', array( &$this, 'news_map_meta_cap' ), 10, 4 );
		add_filter( 'post_updated_messages', array( &$this, 'register_post_types_messages' ) );
		add_filter( 'plugin_row_meta', array( &$this, 'plugin_extend_links' ), 10, 2 );
		add_filter( 'request', array( &$this, 'myfeed_request' ) );
		add_filter( 'post_type_link', array( &$this, 'custom_post_type_link' ), 10, 2 );
	}

	/**
	 * Multisite activation
	 */
	public function multisite_activation( $networkwide ) {
		if ( is_multisite() && $networkwide ) {
			global $wpdb;

			$activated_blogs = array();
			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT blog_id FROM ' . $wpdb->blogs, '' ) );

			foreach ( $blogs_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->activate_single();
				$activated_blogs[] = (int) $blog_id;
			}

			switch_to_blog( $current_blog_id );
			update_site_option( 'news_manager_activated_blogs', $activated_blogs, array() );
		} else
			$this->activate_single();
	}

	/**
	 * Activation
	 */
	public function activate_single() {
		global $wp_roles;

		//add caps to administrators
		foreach ( $wp_roles->roles as $role_name => $display_name ) {
			$role = $wp_roles->get_role( $role_name );

			if ( $role->has_cap( 'manage_options' ) ) {
				foreach ( $this->defaults['capabilities'] as $capability ) {
					$role->add_cap( $capability );
				}
			}
		}

		//add default options
		add_option( 'news_manager_general', $this->defaults['general'], '', 'no' );
		add_option( 'news_manager_capabilities', '', '', 'no' );
		add_option( 'news_manager_permalinks', $this->defaults['permalinks'], '', 'no' );
		add_option( 'news_manager_version', $this->defaults['version'], '', 'no' );

		//permalinks
		flush_rewrite_rules();
	}

	/**
	 * Multisite deactivation
	 */
	public function multisite_deactivation( $networkwide ) {
		if ( is_multisite() && $networkwide ) {
			global $wpdb;

			$current_blog_id = $wpdb->blogid;
			$blogs_ids = $wpdb->get_col( $wpdb->prepare( 'SELECT blog_id FROM ' . $wpdb->blogs, '' ) );

			if ( ($activated_blogs = get_site_option( 'news_manager_activated_blogs', false, false )) === false )
				$activated_blogs = array();

			foreach ( $blogs_ids as $blog_id ) {
				switch_to_blog( $blog_id );
				$this->deactivate_single( true );

				if ( in_array( (int) $blog_id, $activated_blogs, true ) )
					unset( $activated_blogs[array_search( $blog_id, $activated_blogs )] );
			}

			switch_to_blog( $current_blog_id );
			update_site_option( 'news_manager_activated_blogs', $activated_blogs );
		} else
			$this->deactivate_single();
	}

	/**
	 * Deactivation
	 */
	public function deactivate_single( $multi = false ) {
		global $wp_roles;

		//remove capabilities
		foreach ( $wp_roles->roles as $role_name => $display_name ) {
			$role = $wp_roles->get_role( $role_name );

			foreach ( $this->defaults['capabilities'] as $capability ) {
				$role->remove_cap( $capability );
			}
		}

		if ( $multi === true ) {
			$options = get_option( 'news_manager_general' );
			$check = $options['deactivation_delete'];
		} else
			$check = $this->options['general']['deactivation_delete'];

		if ( $check === true ) {
			$settings = new News_Manager_Settings();
			$settings->update_menu();

			delete_option( 'news_manager_general' );
			delete_option( 'news_manager_capabilities' );
			delete_option( 'news_manager_permalinks' );
			delete_option( 'news_manager_version' );
		}

		//permalinks
		flush_rewrite_rules();
	}

	/**
	 * 
	 */
	public function myfeed_request( $feeds ) {
		if ( isset( $feeds['feed'] ) && ! isset( $feeds['post_type'] ) && $this->options['general']['news_in_rss'] === true )
			$feeds['post_type'] = array( 'post', 'news' );

		return $feeds;
	}

	/**
	 * 
	 */
	public function custom_post_type_link( $post_link, $post_id ) {
		$post = get_post( $post_id );

		if ( is_wp_error( $post ) || $post->post_type !== 'news' || empty( $post->post_name ) )
			return $post_link;

		if ( $this->options['permalinks']['single_news_prefix'] === true ) {
			if ( $this->options['general']['use_tags'] === true && $this->options['general']['builtin_tags'] === false && $this->options['permalinks']['single_news_prefix_type'] === 'tag' )
				$category = 'news-tag';
			elseif ( $this->options['general']['use_categories'] === true && $this->options['general']['builtin_categories'] === false && $this->options['permalinks']['single_news_prefix_type'] === 'category' )
				$category = 'news-category';
			else
				return $post_link;
		} else
			return $post_link;

		$terms = get_the_terms( $post->ID, $category );

		if ( is_wp_error( $terms ) || ! $terms )
			$term = '';
		else {
			$term_obj = array_pop( $terms );
			$term = $term_obj->slug . '/';
		}

		return home_url( user_trailingslashit( $this->options['permalinks']['news_slug'] . '/' . $term . $post->post_name ) );
	}

	/**
	 * 
	 */
	private function get_supports() {
		$supports = array();

		foreach ( $this->options['general']['supports'] as $support => $bool ) {
			if ( $bool === true )
				$supports[] = $support;
		}

		return $supports;
	}

	/**
	 * 
	 */
	public function get_defaults() {
		return $this->defaults;
	}

	/**
	 * 
	 */
	public function get_session_id() {
		return $this->transient_id;
	}

	/**
	 * Generates random string
	 */
	private function generate_hash() {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_[]{}<>~`+=,.;:/?|';
		$max = strlen( $chars ) - 1;
		$password = '';

		for ( $i = 0; $i < 64; $i ++  ) {
			$password .= substr( $chars, mt_rand( 0, $max ), 1 );
		}

		return $password;
	}

	/**
	 * Initializes cookie-session
	 */
	public function init_session() {
		setcookie( 'nm_transient_id', $this->transient_id, 0, COOKIEPATH, COOKIE_DOMAIN );
	}

	/**
	 * Loads text domain
	 */
	public function load_textdomain() {
		load_plugin_textdomain( 'news-manager', false, NEWS_MANAGER_REL_PATH . 'languages/' );
	}

	/**
	 * 
	 */
	public function news_admin_notices() {
		global $pagenow, $typenow;

		$message_arr = get_transient( $this->transient_id );

		if ( $typenow === 'news' && $message_arr !== false ) {
			$messages = maybe_unserialize( $message_arr );

			echo '
			<div id="message" class="' . $messages['status'] . '">
				<p>' . $messages['text'] . '</p>
			</div>';

			delete_transient( $this->transient_id );
		}
	}

	/**
	 * Registration of new custom taxonomies: news-category, news-tag
	 */
	public function register_taxonomies() {

		if ( $this->options['general']['use_categories'] === true && $this->options['general']['builtin_categories'] === false ) {
			$labels_news_categories = array(
				'name'				 => _x( 'News Categories', 'taxonomy general name', 'news-manager' ),
				'singular_name'		 => _x( 'News Category', 'taxonomy singular name', 'news-manager' ),
				'search_items'		 => __( 'Search News Categories', 'news-manager' ),
				'all_items'			 => __( 'All News Categories', 'news-manager' ),
				'parent_item'		 => __( 'Parent News Category', 'news-manager' ),
				'parent_item_colon'	 => __( 'Parent News Category:', 'news-manager' ),
				'edit_item'			 => __( 'Edit News Category', 'news-manager' ),
				'view_item'			 => __( 'View News Category', 'news-manager' ),
				'update_item'		 => __( 'Update News Category', 'news-manager' ),
				'add_new_item'		 => __( 'Add New News Category', 'news-manager' ),
				'new_item_name'		 => __( 'New News Category Name', 'news-manager' ),
				'menu_name'			 => __( 'Categories', 'news-manager' ),
			);

			$slug = $this->options['permalinks']['news_slug'] . '/' . $this->options['permalinks']['news_categories_rewrite_slug'];

			if ( $this->options['permalinks']['single_news_prefix'] === true && $this->options['permalinks']['single_news_prefix_type'] === 'category' )
				$slug = $this->options['permalinks']['news_slug'];

			$args_news_categories = array(
				'public'				 => true,
				'hierarchical'			 => true,
				'labels'				 => $labels_news_categories,
				'show_ui'				 => true,
				'show_admin_column'		 => true,
				'update_count_callback'	 => '_update_post_term_count',
				'query_var'				 => true,
				'rewrite'				 => array(
					'slug'			 => $slug,
					'with_front'	 => false,
					'hierarchical'	 => false
				),
				'capabilities'			 => array(
					'manage_terms'	 => 'manage_news_categories',
					'edit_terms'	 => 'manage_news_categories',
					'delete_terms'	 => 'manage_news_categories',
					'assign_terms'	 => 'edit_news'
				)
			);

			register_taxonomy( 'news-category', 'news', apply_filters( 'nm_register_news_categories', $args_news_categories ) );
		}

		if ( $this->options['general']['use_tags'] === true && $this->options['general']['builtin_tags'] === false ) {
			$labels_news_tags = array(
				'name'						 => _x( 'News Tags', 'taxonomy general name', 'news-manager' ),
				'singular_name'				 => _x( 'News Tag', 'taxonomy singular name', 'news-manager' ),
				'search_items'				 => __( 'Search News Tags', 'news-manager' ),
				'popular_items'				 => __( 'Popular News Tags', 'news-manager' ),
				'all_items'					 => __( 'All News Tags', 'news-manager' ),
				'parent_item'				 => null,
				'parent_item_colon'			 => null,
				'edit_item'					 => __( 'Edit News Tag', 'news-manager' ),
				'update_item'				 => __( 'Update News Tag', 'news-manager' ),
				'add_new_item'				 => __( 'Add New News Tag', 'news-manager' ),
				'new_item_name'				 => __( 'New News Tag Name', 'news-manager' ),
				'separate_items_with_commas' => __( 'Separate news tags with commas', 'news-manager' ),
				'add_or_remove_items'		 => __( 'Add or remove news tags', 'news-manager' ),
				'choose_from_most_used'		 => __( 'Choose from the most used news tags', 'news-manager' ),
				'menu_name'					 => __( 'Tags', 'news-manager' ),
			);

			$slug = $this->options['permalinks']['news_slug'] . '/' . $this->options['permalinks']['news_tags_rewrite_slug'];

			if ( $this->options['permalinks']['single_news_prefix'] === true && $this->options['permalinks']['single_news_prefix_type'] === 'tag' )
				$slug = $this->options['permalinks']['news_slug'];

			$args_news_tags = array(
				'public'				 => true,
				'hierarchical'			 => false,
				'labels'				 => $labels_news_tags,
				'show_ui'				 => true,
				'show_admin_column'		 => true,
				'update_count_callback'	 => '_update_post_term_count',
				'query_var'				 => true,
				'rewrite'				 => array(
					'slug'			 => $slug,
					'with_front'	 => false,
					'hierarchical'	 => false
				),
				'capabilities'			 => array(
					'manage_terms'	 => 'manage_news_tags',
					'edit_terms'	 => 'manage_news_tags',
					'delete_terms'	 => 'manage_news_tags',
					'assign_terms'	 => 'edit_news'
				)
			);

			register_taxonomy( 'news-tag', 'news', apply_filters( 'nm_register_news_tags', $args_news_tags ) );
		}
	}

	/**
	 * Registration of new custom post types: news
	 */
	public function register_post_types() {
		$labels_news = array(
			'name'				 => _x( 'News', 'post type general name', 'news-manager' ),
			'singular_name'		 => _x( 'News', 'post type singular name', 'news-manager' ),
			'menu_name'			 => __( 'News', 'news-manager' ),
			'all_items'			 => __( 'All News', 'news-manager' ),
			'add_new'			 => __( 'Add New', 'news-manager' ),
			'add_new_item'		 => __( 'Add New News', 'news-manager' ),
			'edit_item'			 => __( 'Edit News', 'news-manager' ),
			'new_item'			 => __( 'New News', 'news-manager' ),
			'view_item'			 => __( 'View News', 'news-manager' ),
			'items_archive'		 => __( 'News Archive', 'news-manager' ),
			'search_items'		 => __( 'Search News', 'news-manager' ),
			'not_found'			 => __( 'No news found', 'news-manager' ),
			'not_found_in_trash' => __( 'No news found in trash', 'news-manager' ),
			'parent_item_colon'	 => ''
		);

		$taxonomies = array();

		if ( $this->options['general']['use_tags'] === true ) {
			if ( $this->options['general']['builtin_tags'] === false )
				$taxonomies[] = 'news-tag';
			else
				$taxonomies[] = 'post_tag';
		}

		if ( $this->options['general']['use_categories'] === true ) {
			if ( $this->options['general']['builtin_categories'] === false )
				$taxonomies[] = 'news-category';
			else
				$taxonomies[] = 'category';
		}

		$prefix = '';

		if ( $this->options['permalinks']['single_news_prefix'] === true ) {
			if ( $this->options['general']['use_tags'] === true && $this->options['general']['builtin_tags'] === false && $this->options['permalinks']['single_news_prefix_type'] === 'tag' )
				$prefix = '/%news-tag%';
			elseif ( $this->options['general']['use_categories'] === true && $this->options['general']['builtin_categories'] === false && $this->options['permalinks']['single_news_prefix_type'] === 'category' )
				$prefix = '/%news-category%';
		}

		// Menu icon
		global $wp_version;

		$menu_icon = NEWS_MANAGER_URL . '/images/icon-news-16.png';
		if ( $wp_version >= 3.8 ) {
			$menu_icon = 'dashicons-media-text';
		}

		$args_news = array(
			'labels'				 => $labels_news,
			'description'			 => '',
			'public'				 => true,
			'exclude_from_search'	 => false,
			'publicly_queryable'	 => true,
			'show_ui'				 => true,
			'show_in_menu'			 => true,
			'show_in_admin_bar'		 => true,
			'show_in_nav_menus'		 => true,
			'menu_position'			 => 5,
			'menu_icon'				 => $menu_icon,
			'capability_type'		 => 'news',
			'capabilities'			 => array(
				'publish_posts'			 => 'publish_news',
				'edit_posts'			 => 'edit_news',
				'edit_others_posts'		 => 'edit_others_news',
				'edit_published_posts'	 => 'edit_published_news',
				'delete_published_posts' => 'delete_published_news',
				'delete_posts'			 => 'delete_news',
				'delete_others_posts'	 => 'delete_others_news',
				'read_private_posts'	 => 'read_private_news',
				'edit_post'				 => 'edit_single_news',
				'delete_post'			 => 'delete_single_news',
				'read_post'				 => 'read_single_news',
			),
			'map_meta_cap'			 => false,
			'hierarchical'			 => false,
			'supports'				 => $this->get_supports( $this->options['general']['supports'] ),
			'rewrite'				 => array(
				'slug'		 => $this->options['permalinks']['news_slug'] . $prefix,
				'with_front' => false,
				'feed'		 => true,
				'pages'		 => true
			),
			'has_archive'			 => $this->options['permalinks']['news_slug'],
			'query_var'				 => true,
			'can_export'			 => true,
			'taxonomies'			 => $taxonomies,
		);

		register_post_type( 'news', apply_filters( 'nm_register_post_type', $args_news ) );
	}

	/**
	 * Custom post type messages
	 */
	public function register_post_types_messages( $messages ) {
		global $post, $post_ID;

		$messages['news'] = array(
			0	 => '', //Unused. Messages start at index 1.
			1	 => sprintf( __( 'News updated. <a href="%s">View news</a>', 'news-manager' ), esc_url( get_permalink( $post_ID ) ) ),
			2	 => __( 'Custom field updated.', 'news-manager' ),
			3	 => __( 'Custom field deleted.', 'news-manager' ),
			4	 => __( 'News updated.', 'news-manager' ),
			//translators: %s: date and time of the revision
			5	 => isset( $_GET['revision'] ) ? sprintf( __( 'News restored to revision from %s', 'news-manager' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6	 => sprintf( __( 'News published. <a href="%s">View news</a>', 'news-manager' ), esc_url( get_permalink( $post_ID ) ) ),
			7	 => __( 'News saved.', 'news-manager' ),
			8	 => sprintf( __( 'News submitted. <a target="_blank" href="%s">Preview news</a>', 'news-manager' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) ),
			9	 => sprintf( __( 'News scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview news</a>', 'news-manager' ),
				//translators: Publish box date format, see http://php.net/date
				date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ) ),
			10	 => sprintf( __( 'News draft updated. <a target="_blank" href="%s">Preview news</a>', 'news-manager' ), esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ) )
		);

		return $messages;
	}

	/**
	 * 
	 */
	public function admin_scripts_styles( $page ) {
		$screen = get_current_screen();

		//widgets
		if ( $page === 'widgets.php' ) {
			wp_register_script(
				'news-manager-admin-widgets', NEWS_MANAGER_URL . '/js/admin-widgets.js', array( 'jquery' )
			);

			wp_enqueue_script( 'news-manager-admin-widgets' );

			wp_register_style(
				'news-manager-admin', NEWS_MANAGER_URL . '/css/admin.css'
			);

			wp_enqueue_style( 'news-manager-admin' );
		}
		//news options page
		elseif ( $page === 'news_page_news-settings' ) {
			wp_register_script(
				'news-manager-admin-settings', NEWS_MANAGER_URL . '/js/admin-settings.js', array( 'jquery' )
			);

			wp_enqueue_script( 'news-manager-admin-settings' );

			wp_localize_script(
				'news-manager-admin-settings', 'nmArgs', array(
				'resetToDefaults'		 => __( 'Are you sure you want to reset these settings to defaults?', 'news-manager' ),
				'tagsRewriteURL'		 => site_url() . '/<strong>' . $this->options['permalinks']['news_slug'] . '</strong>/<strong>' . $this->options['permalinks']['news_tags_rewrite_slug'] . '</strong>/news-title/',
				'categoriesRewriteURL'	 => site_url() . '/<strong>' . $this->options['permalinks']['news_slug'] . '</strong>/<strong>' . $this->options['permalinks']['news_categories_rewrite_slug'] . '</strong>/news-title/'
				)
			);

			wp_register_style(
				'news-manager-admin', NEWS_MANAGER_URL . '/css/admin.css'
			);

			wp_enqueue_style( 'news-manager-admin' );
;
		}
		//list of news
		elseif ( $page === 'edit.php' && $screen->post_type === 'news' ) {
			wp_register_style(
				'news-manager-admin', NEWS_MANAGER_URL . '/css/admin.css'
			);

			wp_enqueue_style( 'news-manager-admin' );
		}
	}

	/**
	 * 
	 */
	public function front_scripts_styles() {
		wp_register_style(
			'news-manager-front', NEWS_MANAGER_URL . '/css/front.css'
		);

		wp_enqueue_style( 'news-manager-front' );
	}

	/**
	 * Edit screen icon
	 */
	public function edit_screen_icon() {
		// Screen icon
		global $wp_version;
		if ( $wp_version < 3.8 ) {
			global $post;

			if ( get_post_type( $post ) === 'news' || (isset( $_GET['post_type'] ) && $_GET['post_type'] === 'news') ) {
				echo '
				<style>
					#icon-edit { background: transparent url(\'' . NEWS_MANAGER_URL . '/images/icon-news-32.png\') no-repeat; }
				</style>';
			}
		}
	}

	/**
	 * Adds links to Support Forum
	 */
	public function plugin_extend_links( $links, $file ) {
		if ( ! current_user_can( 'install_plugins' ) )
			return $links;

		$plugin = plugin_basename( __FILE__ );

		if ( $file == $plugin ) {
			return array_merge(
				$links, array( sprintf( '<a href="http://www.dfactory.eu/support/forum/news-manager/" target="_blank">%s</a>', __( 'Support', 'news-manager' ) ) )
			);
		}

		return $links;
	}

	/**
	 * Maps capabilities
	 */
	public function news_map_meta_cap( $caps, $cap, $user_id, $args ) {
		if ( 'edit_single_news' === $cap || 'delete_single_news' === $cap || 'read_single_news' === $cap ) {
			$post = get_post( $args[0] );
			$post_type = get_post_type_object( $post->post_type );
			$caps = array();

			if ( $post->post_type !== 'news' )
				return $caps;
		}

		if ( 'edit_single_news' === $cap ) {
			if ( $user_id == $post->post_author )
				$caps[] = $post_type->cap->edit_posts;
			else
				$caps[] = $post_type->cap->edit_others_posts;
		}
		elseif ( 'delete_single_news' === $cap ) {
			if ( isset( $post->post_author ) && $user_id == $post->post_author )
				$caps[] = $post_type->cap->delete_posts;
			else
				$caps[] = $post_type->cap->delete_others_posts;
		}
		elseif ( 'read_single_news' === $cap ) {
			if ( 'private' != $post->post_status )
				$caps[] = 'read';
			elseif ( $user_id == $post->post_author )
				$caps[] = 'read';
			else
				$caps[] = $post_type->cap->read_private_posts;
		}

		return $caps;
	}

}