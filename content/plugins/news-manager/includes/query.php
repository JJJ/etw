<?php
if ( ! defined( 'ABSPATH' ) )
	exit; //exit if accessed directly

new News_Manager_Query();

class News_Manager_Query {

	private $options = array();

	public function __construct() {
		//settings
		$this->options = array_merge(
			array( 'general' => get_option( 'news_manager_general' ) ), array( 'permalinks' => get_option( 'news_manager_permalinks' ) )
		);

		//actions
		add_action( 'init', array( &$this, 'register_rewrite' ) );
		add_action( 'pre_get_posts', array( &$this, 'extend_pre_query' ) );

		//filters
		add_filter( 'query_vars', array( &$this, 'register_query_vars' ) );
	}

	/**
	 * 
	 */
	public function register_rewrite() {
		global $wp_rewrite;

		$wp_rewrite->add_rule(
			$this->options['permalinks']['news_slug'] . '/([0-9]{4}(?:/[0-9]{2}(?:/[0-9]{2})?)?)/?(?:' . $wp_rewrite->pagination_base . '/([0-9]{1,})/?)?$', 'index.php?post_type=news&news_ondate=$matches[1]&paged=$matches[2]', 'top'
		);

		$wp_rewrite->add_rewrite_tag(
			'%news_ondate%', '([0-9]{4}(?:/[0-9]{2}(?:/[0-9]{2})?)?)', 'post_type=news&news_ondate='
		);

		$wp_rewrite->add_permastruct(
			'news_ondate', $this->options['permalinks']['news_slug'] . '/%news_ondate%', array(
			'with_front' => FALSE
			)
		);

		if ( $this->options['general']['rewrite_rules'] === TRUE ) {
			$this->options['general']['rewrite_rules'] = FALSE;
			update_option( 'news_manager_general', $this->options['general'] );
			flush_rewrite_rules();
		}
	}

	/**
	 * 
	 */
	public function register_query_vars( $query_vars ) {
		$query_vars[] = 'news_ondate';

		return $query_vars;
	}

	/**
	 * 
	 */
	public function extend_pre_query( $query ) {
		if ( ((is_category() && $this->options['general']['use_categories'] === TRUE && $this->options['general']['builtin_categories'] === TRUE) || (is_tag() && $this->options['general']['use_tags'] === TRUE && $this->options['general']['builtin_tags'] === TRUE)) && $query->is_main_query() && empty( $query->query_vars['suppress_filters'] ) && $this->options['general']['display_news_in_tags_and_categories'] === TRUE ) {
			if ( ($post_type = $query->get( 'post_type' )) === '' )
				$post_type = array( 'post', 'news' );
			elseif ( is_array( $post_type ) ) {
				$post_type[] = 'post';
				$post_type[] = 'news';
			} else
				$post_type = '';

			$query->set( 'post_type', $post_type );
		}

		if ( $query->get( 'post_type' ) === 'news' ) {
			if ( ! empty( $query->query_vars['news_ondate'] ) ) {
				$date = explode( '/', $query->query_vars['news_ondate'] );
				$query->is_date = TRUE; //for is_date() function
				//year
				if ( ($a = count( $date )) === 1 ) {
					$query->set( 'year', $date[0] );
					$query->is_year = TRUE; //for is_year() function
				}
				//year + month
				elseif ( $a === 2 ) {
					$query->set( 'year', $date[0] );
					$query->set( 'monthnum', $date[1] );
					$query->is_month = TRUE; //for is_month() function
				}
				//year + month + day
				elseif ( $a === 3 ) {
					$query->set( 'year', $date[0] );
					$query->set( 'monthnum', $date[1] );
					$query->set( 'day', $date[2] );
					$query->is_day = TRUE; //for is_day() function
				}
			}
		}
	}

}