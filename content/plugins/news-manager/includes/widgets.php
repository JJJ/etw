<?php
if ( ! defined( 'ABSPATH' ) )
	exit; //exit if accessed directly

new News_Manager_Widgets();

class News_Manager_Widgets {

	private $options = array();

	public function __construct() {
		//settings
		$this->options = array_merge(
			array( 'general' => get_option( 'news_manager_general' ) )
		);

		//actions
		add_action( 'widgets_init', array( &$this, 'register_widgets' ) );
	}

	/**
	 * 
	 */
	public function register_widgets() {
		register_widget( 'News_Manager_List_Widget' );
		register_widget( 'News_Manager_Archive_Widget' );
		register_widget( 'News_Manager_Calendar_Widget' );

		if ( $this->options['general']['use_tags'] === TRUE && $this->options['general']['builtin_tags'] === FALSE )
			register_widget( 'News_Manager_Tags_Widget' );

		if ( $this->options['general']['use_categories'] === TRUE && $this->options['general']['builtin_categories'] === FALSE )
			register_widget( 'News_Manager_Categories_Widget' );
	}

}

class News_Manager_Archive_Widget extends WP_Widget {

	private $nm_defaults = array();
	private $nm_types = array();
	private $nm_order_types = array();

	public function __construct() {
		parent::__construct(
			'News_Manager_Archive_Widget', __( 'News Archives', 'news-manager' ), array(
			'description' => __( 'Displays news archives', 'news-manager' )
			)
		);

		$this->nm_defaults = array(
			'title'					 => __( 'News Archives', 'news-manager' ),
			'display_as_dropdown'	 => FALSE,
			'show_post_count'		 => TRUE,
			'type'					 => 'monthly',
			'order'					 => 'desc',
			'limit'					 => 0
		);

		$this->nm_types = array(
			'monthly'	 => __( 'Monthly', 'news-manager' ),
			'yearly'	 => __( 'Yearly', 'news-manager' )
		);

		$this->nm_order_types = array(
			'asc'	 => __( 'Ascending', 'news-manager' ),
			'desc'	 => __( 'Descending', 'news-manager' )
		);
	}

	public function widget( $args, $instance ) {
		$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$html = $args['before_widget'] . $args['before_title'] . ( ! empty( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title']) . $args['after_title'];
		$html .= nm_display_news_archives( $instance );
		$html .= $args['after_widget'];

		echo $html;
	}

	public function form( $instance ) {
		$html = '
		<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( isset( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title'] ) . '" />
		</p>
		<p>
			<input id="' . $this->get_field_id( 'display_as_dropdown' ) . '" type="checkbox" name="' . $this->get_field_name( 'display_as_dropdown' ) . '" value="" ' . checked( TRUE, (isset( $instance['display_as_dropdown'] ) ? $instance['display_as_dropdown'] : $this->nm_defaults['display_as_dropdown'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'display_as_dropdown' ) . '">' . __( 'Display as dropdown', 'news-manager' ) . '</label><br />
			<input id="' . $this->get_field_id( 'show_post_count' ) . '" type="checkbox" name="' . $this->get_field_name( 'show_post_count' ) . '" value="" ' . checked( TRUE, (isset( $instance['show_post_count'] ) ? $instance['show_post_count'] : $this->nm_defaults['show_post_count'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'show_post_count' ) . '">' . __( 'Show number of news', 'news-manager' ) . '</label>
		</p>
		<p>
			<label for="' . $this->get_field_id( 'type' ) . '">' . __( 'Display Type', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'type' ) . '" name="' . $this->get_field_name( 'type' ) . '">';

		foreach ( $this->nm_types as $id => $type ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['type'] ) ? $instance['type'] : $this->nm_defaults['type'] ), FALSE ) . '>' . $type . '</option>';
		}

		$html .= '
			</select>
		</p>
		<p>
			<label for="' . $this->get_field_id( 'order' ) . '">' . __( 'Order', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order' ) . '" name="' . $this->get_field_name( 'order' ) . '">';

		foreach ( $this->nm_order_types as $id => $order ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order'] ) ? $instance['order'] : $this->nm_defaults['order'] ), FALSE ) . '>' . $order . '</option>';
		}

		$html .= '
			</select>
		</p>
			<label for="' . $this->get_field_id( 'limit' ) . '">' . __( 'Limit', 'news-manager' ) . ':</label> <input id="' . $this->get_field_id( 'limit' ) . '" type="text" name="' . $this->get_field_name( 'limit' ) . '" value="' . esc_attr( isset( $instance['limit'] ) ? $instance['limit'] : $this->nm_defaults['limit'] ) . '" />
		</p>';

		echo $html;
	}

	public function update( $new_instance, $old_instance ) {
		//checkboxes
		$old_instance['display_as_dropdown'] = (isset( $new_instance['display_as_dropdown'] ) ? TRUE : FALSE);
		$old_instance['show_post_count'] = (isset( $new_instance['show_post_count'] ) ? TRUE : FALSE);

		//title
		$old_instance['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : $this->nm_defaults['title'] );

		//limit
		$old_instance['limit'] = (int) (isset( $new_instance['limit'] ) && (int) $new_instance['limit'] >= 0 ? $new_instance['limit'] : $this->nm_defaults['limit']);

		//order
		$old_instance['order'] = (isset( $new_instance['order'] ) && in_array( $new_instance['order'], array_keys( $this->nm_order_types ), TRUE ) ? $new_instance['order'] : $this->nm_defaults['order']);

		//type
		$old_instance['type'] = (isset( $new_instance['type'] ) && in_array( $new_instance['type'], array_keys( $this->nm_types ), TRUE ) ? $new_instance['type'] : $this->nm_defaults['type']);

		return $old_instance;
	}

}

class News_Manager_Calendar_Widget extends WP_Widget {

	private $nm_options = array();
	private $nm_defaults = array();
	private $nm_taxonomies = array();
	private $nm_css_styles = array();
	private $nm_included_widgets = 0;

	public function __construct() {
		parent::__construct(
			'News_Manager_Calendar_Widget', __( 'News Calendar', 'news-manager' ), array(
			'description' => __( 'Displays news calendar', 'news-manager' )
			)
		);

		add_action( 'wp_ajax_nopriv_get-news-widget-calendar-month', array( &$this, 'get_widget_calendar_month' ) );
		add_action( 'wp_ajax_get-news-widget-calendar-month', array( &$this, 'get_widget_calendar_month' ) );

		$this->nm_options = array_merge(
			array( 'general' => get_option( 'news_manager_general' ) )
		);

		$this->nm_defaults = array(
			'title'				 => __( 'News Calendar', 'news-manager' ),
			'highlight_weekends' => TRUE,
			'categories'		 => 'all',
			'tags'				 => 'all',
			'css_style'			 => 'basic'
		);

		$this->nm_taxonomies = array(
			'all'		 => __( 'all', 'news-manager' ),
			'selected'	 => __( 'selected', 'news-manager' )
		);

		$this->nm_css_styles = array(
			'basic'	 => __( 'basic', 'news-manager' ),
			'dark'	 => __( 'dark', 'news-manager' ),
			'light'	 => __( 'light', 'news-manager' ),
			'flat'	 => __( 'flat', 'news-manager' )
		);
	}

	/**
	 * 
	 */
	public function get_widget_calendar_month() {
		if ( ! empty( $_POST['action'] ) && ! empty( $_POST['date'] ) && ! empty( $_POST['widget_id'] ) && ! empty( $_POST['nonce'] ) && $_POST['action'] === 'get-news-widget-calendar-month' && check_ajax_referer( 'news-manager-widget-calendar', 'nonce', FALSE ) ) {
			$widget_options = $this->get_settings();
			$widget_id = (int) $_POST['widget_id'];

			echo $this->display_calendar( $widget_options[$widget_id], $_POST['date'], $this->get_news_days( $_POST['date'], $widget_options[$widget_id] ), $widget_id, TRUE );
		}

		exit;
	}

	/**
	 * 
	 */
	public function widget( $args, $instance ) {
		//include js and css only once
		if ( ++ $this->nm_included_widgets === 1 ) {
			wp_register_script(
				'news-manager-front-widgets-calendar', NEWS_MANAGER_URL . '/js/front-widgets.js', array( 'jquery' )
			);

			wp_enqueue_script( 'news-manager-front-widgets-calendar' );

			wp_localize_script(
				'news-manager-front-widgets-calendar', 'nmArgs', array(
				'ajaxurl'	 => admin_url( 'admin-ajax.php' ),
				'nonce'		 => wp_create_nonce( 'news-manager-widget-calendar' )
				)
			);
		}

		$date = date( 'Y-m', current_time( 'timestamp' ) );
		$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$html = $args['before_widget'] . $args['before_title'] . ( ! empty( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title']) . $args['after_title'];
		$html .= $this->display_calendar( $instance, $date, $this->get_news_days( $date, $instance ), $this->number );
		$html .= $args['after_widget'];

		echo $html;
	}

	/**
	 * 
	 */
	public function form( $instance ) {
		$html = '
		<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( isset( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title'] ) . '" />
		</p>
		<p>
			<input id="' . $this->get_field_id( 'highlight_weekends' ) . '" type="checkbox" name="' . $this->get_field_name( 'highlight_weekends' ) . '" value="" ' . checked( TRUE, (isset( $instance['highlight_weekends'] ) ? $instance['highlight_weekends'] : $this->nm_defaults['highlight_weekends'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'highlight_weekends' ) . '">' . __( 'Highlight weekends', 'news-manager' ) . '</label>
		</p>
		<p>
			<label>' . __( 'CSS Style', 'news-manager' ) . ':</label>
			<select name="' . $this->get_field_name( 'css_style' ) . '">';

		foreach ( $this->nm_css_styles as $style => $trans ) {
			$html .= '
				<option value="' . esc_attr( $style ) . '" ' . selected( $style, (isset( $instance['css_style'] ) ? $instance['css_style'] : $this->nm_defaults['css_style'] ), FALSE ) . '>' . $trans . '</option>';
		}

		$html .= '
			</select>
		</p>';

		if ( $this->nm_options['general']['use_tags'] === TRUE ) {
			$tag = isset( $instance['tags'] ) ? $instance['tags'] : $this->nm_defaults['tags'];

			$html .= '
		<div class="news-manager-list">
			<label>' . __( 'News Tags', 'news-manager' ) . ':</label>
			<br />';

			foreach ( $this->nm_taxonomies as $id => $taxonomy ) {
				$html .= '
			<input class="taxonomy-select-tags" id="' . $this->get_field_id( 'tag_' . $id ) . '" name="' . $this->get_field_name( 'tags' ) . '" type="radio" value="' . esc_attr( $id ) . '" ' . checked( $id, $tag, FALSE ) . ' /><label for="' . $this->get_field_id( 'tag_' . $id ) . '">' . $taxonomy . '</label> ';
			}

			$html .= '
			<div class="checkbox-list-tags checkbox-list"' . ($tag === 'all' ? ' style="display: none;"' : '') . '>
				' . $this->display_taxonomy_checkbox_list( nm_get_taxonomy_name( 'tag' ), 'tags_arr', $instance ) . '
			</div>
		</div>';
		}

		if ( $this->nm_options['general']['use_categories'] === TRUE ) {
			$category = isset( $instance['categories'] ) ? $instance['categories'] : $this->nm_defaults['categories'];

			$html .= '
		<div class="news-manager-list">
			<label>' . __( 'News Categories', 'news-manager' ) . ':</label>
			<br />';

			foreach ( $this->nm_taxonomies as $id => $taxonomy ) {
				$html .= '
			<input class="taxonomy-select-cats" id="' . $this->get_field_id( 'cat_' . $id ) . '" name="' . $this->get_field_name( 'categories' ) . '" type="radio" value="' . esc_attr( $id ) . '" ' . checked( $id, $category, FALSE ) . ' /><label for="' . $this->get_field_id( 'cat_' . $id ) . '">' . $taxonomy . '</label> ';
			}

			$html .= '
			<div class="checkbox-list-cats checkbox-list"' . ($category === 'all' ? ' style="display: none;"' : '') . '>
				' . $this->display_taxonomy_checkbox_list( nm_get_taxonomy_name( 'category' ), 'categories_arr', $instance ) . '
			</div>
		</div>';
		}

		echo $html;
	}

	/**
	 * 
	 */
	public function update( $new_instance, $old_instance ) {
		//highlight weekends
		$old_instance['highlight_weekends'] = (isset( $new_instance['highlight_weekends'] ) ? TRUE : FALSE);

		//title
		$old_instance['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : $this->nm_defaults['title'] );

		//taxonomies
		$old_instance['tags'] = (isset( $new_instance['tags'] ) && in_array( $new_instance['tags'], array_keys( $this->nm_taxonomies ), TRUE ) ? $new_instance['tags'] : $this->nm_defaults['tags']);
		$old_instance['categories'] = (isset( $new_instance['categories'] ) && in_array( $new_instance['categories'], array_keys( $this->nm_taxonomies ), TRUE ) ? $new_instance['categories'] : $this->nm_defaults['categories']);

		//css style
		$old_instance['css_style'] = (isset( $new_instance['css_style'] ) && in_array( $new_instance['css_style'], array_keys( $this->nm_css_styles ), TRUE ) ? $new_instance['css_style'] : $this->nm_defaults['css_style']);

		//tags
		if ( $old_instance['tags'] === 'selected' ) {
			$old_instance['tags_arr'] = array();

			if ( isset( $new_instance['tags_arr'] ) && is_array( $new_instance['tags_arr'] ) ) {
				foreach ( $new_instance['tags_arr'] as $cat_id ) {
					$old_instance['tags_arr'][] = (int) $cat_id;
				}

				$old_instance['tags_arr'] = array_unique( $old_instance['tags_arr'], SORT_NUMERIC );
			}
		} else
			$old_instance['tags_arr'] = array();

		//categories
		if ( $old_instance['categories'] === 'selected' ) {
			$old_instance['categories_arr'] = array();

			if ( isset( $new_instance['categories_arr'] ) && is_array( $new_instance['categories_arr'] ) ) {
				foreach ( $new_instance['categories_arr'] as $cat_id ) {
					$old_instance['categories_arr'][] = (int) $cat_id;
				}

				$old_instance['categories_arr'] = array_unique( $old_instance['categories_arr'], SORT_NUMERIC );
			}
		} else
			$old_instance['categories_arr'] = array();

		return $old_instance;
	}

	/**
	 * 
	 */
	private function display_calendar( $options, $start_date, $news, $widget_id, $ajax = FALSE ) {
		global $wp_locale;

		$weekdays = array( 1 => 7, 2 => 6, 3 => 5, 4 => 4, 5 => 3, 6 => 2, 7 => 1 );
		$date = explode( ' ', date( 'Y m j t', strtotime( $start_date . '-02' ) ) );
		$month = (int) $date[1] - 1;
		$prev_month = (($a = $month - 1) === -1 ? 11 : $a);
		$prev_month_pad = str_pad( $prev_month + 1, 2, '0', STR_PAD_LEFT );
		$next_month = ($month + 1) % 12;
		$next_month_pad = str_pad( $next_month + 1, 2, '0', STR_PAD_LEFT );
		$first_day = (($first = date( 'w', strtotime( date( $date[0] . '-' . $date[1] . '-01' ) ) )) === '0' ? 7 : $first);
		$rel = $widget_id . '|';

		//Polylang and WPML compatibility
		if ( defined( 'ICL_LANGUAGE_CODE' ) )
			$rel .= ICL_LANGUAGE_CODE;

		$html = '
		<div id="news-calendar-' . $widget_id . '" class="news-calendar-widget widget_calendar' . (isset( $options['css_style'] ) && $options['css_style'] !== 'basic' ? ' ' . $options['css_style'] : '') . '" rel="' . $rel . '" ' . ($ajax === TRUE ? 'style="display: none;"' : '') . '>
			<span class="active-month">' . $wp_locale->get_month( $date[1] ) . ' ' . $date[0] . '</span>
			<table class="nav-days">
				<thead>
					<tr>';

		for ( $i = 1; $i <= 7; $i ++  ) {
			$html .= '
						<th scope="col">' . $wp_locale->get_weekday_initial( $wp_locale->get_weekday( $i !== 7 ? $i : 0 ) ) . '</th>';
		}

		$html .= '
					</tr>
				</thead>
				<tbody>';

		$weeks = ceil( ($date[3] - $weekdays[$first_day]) / 7 ) + 1;
		$now = date_parse( current_time( 'mysql' ) );
		$day = $k = 1;

		for ( $i = 1; $i <= $weeks; $i ++  ) {
			$html .= '<tr>';

			for ( $j = 1; $j <= 7; $j ++  ) {
				$td_class = array();
				$real_day = (bool) ($k ++ >= $first_day && $day <= $date[3]);

				if ( $real_day === TRUE && in_array( $day, $news ) )
					$td_class[] = 'active';

				if ( $day === $now['day'] && ($month + 1 === $now['month']) && (int) $date[0] === $now['year'] )
					$td_class[] = 'today';

				if ( $real_day === FALSE )
					$td_class[] = 'pad';

				if ( $options['highlight_weekends'] === TRUE && $j >= 6 && $j <= 7 )
					$td_class[] = 'weekend';

				$html .= '<td' . ( ! empty( $td_class ) ? ' class="' . implode( ' ', $td_class ) . '"' : '') . '>';

				if ( $real_day === TRUE ) {
					$html .= (in_array( $day, $news ) ? '<a href="' . esc_url( nm_get_news_date_link( $date[0], $month + 1, $day ) ) . '">' . $day . '</a>' : $day);
					$day ++;
				} else
					$html .= '&nbsp';

				$html .= '</td>';
			}

			$html .= '</tr>';
		}

		$html .= '
				</tbody>
			</table>
			<table class="nav-months">
				<tr>
					<td class="prev-month" colspan="2">
						<a rel="' . ($prev_month === 11 ? ($date[0] - 1) : $date[0]) . '-' . $prev_month_pad . '" href="#">&laquo; ' . $wp_locale->get_month( $prev_month_pad ) . '</a>
					</td>
					<td class="ajax-spinner" colspan="1"><div></div></td>
					<td class="next-month" colspan="2">
						<a rel="' . ($next_month === 0 ? ($date[0] + 1) : $date[0]) . '-' . $next_month_pad . '" href="#">' . $wp_locale->get_month( $next_month_pad ) . ' &raquo;</a>
					</td>
				</tr>
			</table>
		</div>';

		return $html;
	}

	/**
	 * 
	 */
	private function get_news_days( $date, $options ) {
		$days = array();

		$news_args = array(
			'post_type'			 => 'news',
			'posts_per_page'	 => -1,
			'suppress_filters'	 => FALSE,
			'm'					 => str_replace( '-', '', $date )
		);

		if ( $options['tags'] !== 'all' ) {
			$news_args['tax_query'][] = array(
				'taxonomy'			 => nm_get_taxonomy_name( 'tag' ),
				'field'				 => 'id',
				'terms'				 => $options['tags_arr'],
				'include_children'	 => FALSE,
				'operator'			 => 'IN'
			);
		}

		if ( $options['categories'] !== 'all' ) {
			$news_args['tax_query'][] = array(
				'taxonomy'			 => nm_get_taxonomy_name( 'category' ),
				'field'				 => 'id',
				'terms'				 => $options['categories_arr'],
				'include_children'	 => FALSE,
				'operator'			 => 'IN'
			);
		}

		//Polylang and WPML compatibility
		if ( defined( 'ICL_LANGUAGE_CODE' ) )
			$news_args['lang'] = ICL_LANGUAGE_CODE;

		$news = get_posts( $news_args );

		if ( ! empty( $news ) ) {
			foreach ( $news as $single_news ) {
				$s_datetime = explode( ' ', $single_news->post_date );
				$s_date = explode( '-', $s_datetime[0] );

				if ( count( $s_date ) === 3 )
					$days[] = (int) $s_date[2];
			}
		}

		return array_unique( $days, SORT_NUMERIC );
	}

	/**
	 * 
	 */
	private function display_taxonomy_checkbox_list( $taxonomy_name, $name, $instance, $depth = 0, $parent = 0 ) {
		$html = '';
		$array = isset( $instance[$name] ) ? $instance[$name] : array();
		$terms = get_terms(
			$taxonomy_name, array(
			'hide_empty' => FALSE,
			'parent'	 => $parent
			)
		);

		if ( ! empty( $terms ) ) {
			$html .= '
			<ul class="terms-checkbox-list depth-level-' . $depth ++ . '">';

			foreach ( $terms as $term ) {
				$html .= '
				<li>
					<input id="' . $this->get_field_id( 'chkbxlst_' . $term->term_taxonomy_id ) . '" type="checkbox" name="' . $this->get_field_name( $name ) . '[]" value="' . esc_attr( $term->term_id ) . '" ' . checked( TRUE, in_array( $term->term_id, $array ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'chkbxlst_' . $term->term_taxonomy_id ) . '">' . $term->name . '</label>
					' . $this->display_taxonomy_checkbox_list( $taxonomy_name, $name, $instance, $depth, $term->term_id ) . '
				</li>';
			}

			$html .= '
			</ul>';
		} elseif ( $parent === 0 )
			$html = __( 'No results were found.', 'news-manager' );

		return $html;
	}

}

class News_Manager_List_Widget extends WP_Widget {

	private $nm_options = array();
	private $nm_defaults = array();
	private $nm_taxonomies = array();
	private $nm_orders = array();
	private $nm_order_types = array();

	public function __construct() {
		parent::__construct(
			'News_Manager_List_Widget', __( 'News List', 'news-manager' ), array(
			'description' => __( 'Displays a list of news', 'news-manager' )
			)
		);

		$this->nm_options = array_merge(
			array( 'general' => get_option( 'news_manager_general' ) )
		);

		$this->nm_defaults = array(
			'title'					 => __( 'News', 'news-manager' ),
			'number_of_news'		 => 5,
			'tags'					 => 'all',
			'categories'			 => 'all',
			'order_by'				 => 'publish',
			'order'					 => 'desc',
			'show_news_thumbnail'	 => TRUE,
			'show_news_excerpt'		 => FALSE,
			'no_news_message'		 => __( 'No News', 'news-manager' )
		);

		$this->nm_taxonomies = array(
			'all'		 => __( 'all', 'news-manager' ),
			'selected'	 => __( 'selected', 'news-manager' )
		);

		$this->nm_orders = array(
			'publish'	 => __( 'Publish date', 'news-manager' ),
			'title'		 => __( 'Title', 'news-manager' )
		);

		$this->nm_order_types = array(
			'asc'	 => __( 'Ascending', 'news-manager' ),
			'desc'	 => __( 'Descending', 'news-manager' )
		);
	}

	/**
	 * 
	 */
	public function widget( $args, $instance ) {
		$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		//backward compatibility
		$comp = $instance;
		$comp['tags'] = ($instance['tags'] === 'selected' ? $instance['tags_arr'] : array());
		$comp['categories'] = ($instance['categories'] === 'selected' ? $instance['categories_arr'] : array());

		$html = $args['before_widget'] . $args['before_title'] . ( ! empty( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title']) . $args['after_title'];
		$html .= nm_display_news( $comp );
		$html .= $args['after_widget'];

		echo $html;
	}

	/**
	 * 
	 */
	public function form( $instance ) {
		$html = '
		<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( isset( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title'] ) . '" />
		</p>
		<p>
			<label for="' . $this->get_field_id( 'number_of_news' ) . '">' . __( 'Number of news', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'number_of_news' ) . '" name="' . $this->get_field_name( 'number_of_news' ) . '" type="text" value="' . esc_attr( isset( $instance['number_of_news'] ) ? $instance['number_of_news'] : $this->nm_defaults['number_of_news'] ) . '" />
		</p>';

		if ( $this->nm_options['general']['use_tags'] === TRUE ) {
			$tag = isset( $instance['tags'] ) ? $instance['tags'] : $this->nm_defaults['tags'];

			$html .= '
		<div class="news-manager-list">
			<label>' . __( 'News Tags', 'news-manager' ) . ':</label>
			<br />';

			foreach ( $this->nm_taxonomies as $id => $taxonomy ) {
				$html .= '
			<input class="taxonomy-select-tags" id="' . $this->get_field_id( 'tag_' . $id ) . '" name="' . $this->get_field_name( 'tags' ) . '" type="radio" value="' . esc_attr( $id ) . '" ' . checked( $id, $tag, FALSE ) . ' /><label for="' . $this->get_field_id( 'tag_' . $id ) . '">' . $taxonomy . '</label> ';
			}

			$html .= '
			<div class="checkbox-list-tags checkbox-list"' . ($tag === 'all' ? ' style="display: none;"' : '') . '>
				' . $this->display_taxonomy_checkbox_list( nm_get_taxonomy_name( 'tag' ), 'tags_arr', $instance ) . '
			</div>
		</div>';
		}

		if ( $this->nm_options['general']['use_categories'] === TRUE ) {
			$category = isset( $instance['categories'] ) ? $instance['categories'] : $this->nm_defaults['categories'];

			$html .= '
		<div class="news-manager-list">
			<label>' . __( 'News Categories', 'news-manager' ) . ':</label>
			<br />';

			foreach ( $this->nm_taxonomies as $id => $taxonomy ) {
				$html .= '
			<input class="taxonomy-select-cats" id="' . $this->get_field_id( 'cat_' . $id ) . '" name="' . $this->get_field_name( 'categories' ) . '" type="radio" value="' . esc_attr( $id ) . '" ' . checked( $id, $category, FALSE ) . ' /><label for="' . $this->get_field_id( 'cat_' . $id ) . '">' . $taxonomy . '</label> ';
			}

			$html .= '
			<div class="checkbox-list-cats checkbox-list"' . ($category === 'all' ? ' style="display: none;"' : '') . '>
				' . $this->display_taxonomy_checkbox_list( nm_get_taxonomy_name( 'category' ), 'categories_arr', $instance ) . '
			</div>
		</div>';
		}

		$html .= '
		<p>
			<label for="' . $this->get_field_id( 'order_by' ) . '">' . __( 'Order by', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order_by' ) . '" name="' . $this->get_field_name( 'order_by' ) . '">';

		foreach ( $this->nm_orders as $id => $order_by ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order_by'] ) ? $instance['order_by'] : $this->nm_defaults['order_by'] ), FALSE ) . '>' . $order_by . '</option>';
		}

		$html .= '
			</select>
			<br />
			<label for="' . $this->get_field_id( 'order' ) . '">' . __( 'Order', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order' ) . '" name="' . $this->get_field_name( 'order' ) . '">';

		foreach ( $this->nm_order_types as $id => $order ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order'] ) ? $instance['order'] : $this->nm_defaults['order'] ), FALSE ) . '>' . $order . '</option>';
		}

		$html .= '
			</select>
		</p>
		<p>
			<input id="' . $this->get_field_id( 'show_news_thumbnail' ) . '" type="checkbox" name="' . $this->get_field_name( 'show_news_thumbnail' ) . '" value="" ' . checked( TRUE, (isset( $instance['show_news_thumbnail'] ) ? $instance['show_news_thumbnail'] : $this->nm_defaults['show_news_thumbnail'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'show_news_thumbnail' ) . '">' . __( 'Display news thumbnail', 'news-manager' ) . '</label>
			<br />
			<input id="' . $this->get_field_id( 'show_news_excerpt' ) . '" type="checkbox" name="' . $this->get_field_name( 'show_news_excerpt' ) . '" value="" ' . checked( TRUE, (isset( $instance['show_news_excerpt'] ) ? $instance['show_news_excerpt'] : $this->nm_defaults['show_news_excerpt'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'show_news_excerpt' ) . '">' . __( 'Display news excerpt', 'news-manager' ) . '</label>
		</p>
		<p>
			<label for="' . $this->get_field_id( 'no_news_message' ) . '">' . __( 'No news message', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'no_news_message' ) . '" type="text" name="' . $this->get_field_name( 'no_news_message' ) . '" value="' . esc_attr( isset( $instance['no_news_message'] ) ? $instance['no_news_message'] : $this->nm_defaults['no_news_message'] ) . '" />
		</p>';

		echo $html;
	}

	/**
	 * 
	 */
	public function update( $new_instance, $old_instance ) {
		//number of news
		$old_instance['number_of_news'] = (int) (isset( $new_instance['number_of_news'] ) ? $new_instance['number_of_news'] : $this->nm_defaults['number_of_news']);

		//order
		$old_instance['order_by'] = (isset( $new_instance['order_by'] ) && in_array( $new_instance['order_by'], array_keys( $this->nm_orders ), TRUE ) ? $new_instance['order_by'] : $this->nm_defaults['order_by']);
		$old_instance['order'] = (isset( $new_instance['order'] ) && in_array( $new_instance['order'], array_keys( $this->nm_order_types ), TRUE ) ? $new_instance['order'] : $this->nm_defaults['order']);

		//booleans
		$old_instance['show_news_thumbnail'] = (isset( $new_instance['show_news_thumbnail'] ) ? TRUE : FALSE);
		$old_instance['show_news_excerpt'] = (isset( $new_instance['show_news_excerpt'] ) ? TRUE : FALSE);

		//texts
		$old_instance['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : $this->nm_defaults['title'] );
		$old_instance['no_news_message'] = sanitize_text_field( isset( $new_instance['no_news_message'] ) ? $new_instance['no_news_message'] : $this->nm_defaults['no_news_message'] );

		//taxonomies
		$old_instance['tags'] = (isset( $new_instance['tags'] ) && in_array( $new_instance['tags'], array_keys( $this->nm_taxonomies ), TRUE ) ? $new_instance['tags'] : $this->nm_defaults['tags']);
		$old_instance['categories'] = (isset( $new_instance['categories'] ) && in_array( $new_instance['categories'], array_keys( $this->nm_taxonomies ), TRUE ) ? $new_instance['categories'] : $this->nm_defaults['categories']);

		//tags
		if ( $old_instance['tags'] === 'selected' ) {
			$old_instance['tags_arr'] = array();

			if ( isset( $new_instance['tags_arr'] ) && is_array( $new_instance['tags_arr'] ) ) {
				foreach ( $new_instance['tags_arr'] as $cat_id ) {
					$old_instance['tags_arr'][] = (int) $cat_id;
				}

				$old_instance['tags_arr'] = array_unique( $old_instance['tags_arr'], SORT_NUMERIC );
			}
		} else
			$old_instance['tags_arr'] = array();

		//categories
		if ( $old_instance['categories'] === 'selected' ) {
			$old_instance['categories_arr'] = array();

			if ( isset( $new_instance['categories_arr'] ) && is_array( $new_instance['categories_arr'] ) ) {
				foreach ( $new_instance['categories_arr'] as $cat_id ) {
					$old_instance['categories_arr'][] = (int) $cat_id;
				}

				$old_instance['categories_arr'] = array_unique( $old_instance['categories_arr'], SORT_NUMERIC );
			}
		} else
			$old_instance['categories_arr'] = array();

		return $old_instance;
	}

	/**
	 * 
	 */
	private function display_taxonomy_checkbox_list( $taxonomy_name, $name, $instance, $depth = 0, $parent = 0 ) {
		$html = '';
		$array = isset( $instance[$name] ) ? $instance[$name] : array();
		$terms = get_terms(
			$taxonomy_name, array(
			'hide_empty' => FALSE,
			'parent'	 => $parent
			)
		);

		if ( ! empty( $terms ) ) {
			$html .= '
			<ul class="terms-checkbox-list depth-level-' . $depth ++ . '">';

			foreach ( $terms as $term ) {
				$html .= '
				<li>
					<input id="' . $this->get_field_id( 'chkbxlst_' . $term->term_taxonomy_id ) . '" type="checkbox" name="' . $this->get_field_name( $name ) . '[]" value="' . esc_attr( $term->term_id ) . '" ' . checked( TRUE, in_array( $term->term_id, $array ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'chkbxlst_' . $term->term_taxonomy_id ) . '">' . $term->name . '</label>
					' . $this->display_taxonomy_checkbox_list( $taxonomy_name, $name, $instance, $depth, $term->term_id ) . '
				</li>';
			}

			$html .= '
			</ul>';
		} elseif ( $parent === 0 )
			$html = __( 'No results were found.', 'news-manager' );

		return $html;
	}

}

class News_Manager_Tags_Widget extends WP_Widget {

	private $nm_defaults = array();
	private $nm_orders = array();
	private $nm_order_types = array();

	public function __construct() {
		parent::__construct(
			'News_Manager_Tags_Widget', __( 'News Tags', 'news-manager' ), array(
			'description' => __( 'Displays a list of news tags', 'news-manager' )
			)
		);

		$this->nm_defaults = array(
			'title'					 => __( 'News Tags', 'news-manager' ),
			'display_as_dropdown'	 => FALSE,
			'show_hierarchy'		 => TRUE,
			'hide_empty'			 => TRUE,
			'order_by'				 => 'name',
			'order'					 => 'asc'
		);

		$this->nm_orders = array(
			'id'	 => __( 'ID', 'news-manager' ),
			'name'	 => __( 'Name', 'news-manager' )
		);

		$this->nm_order_types = array(
			'asc'	 => __( 'Ascending', 'news-manager' ),
			'desc'	 => __( 'Descending', 'news-manager' )
		);
	}

	/**
	 * 
	 */
	public function widget( $args, $instance ) {
		$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$html = $args['before_widget'] . $args['before_title'] . ( ! empty( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title']) . $args['after_title'];
		$html .= nm_display_news_tags( $instance );
		$html .= $args['after_widget'];

		echo $html;
	}

	/**
	 * 
	 */
	public function form( $instance ) {
		$html = '
		<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( isset( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title'] ) . '" />
		</p>
		<p>
			<input id="' . $this->get_field_id( 'display_as_dropdown' ) . '" type="checkbox" name="' . $this->get_field_name( 'display_as_dropdown' ) . '" value="" ' . checked( TRUE, (isset( $instance['display_as_dropdown'] ) ? $instance['display_as_dropdown'] : $this->nm_defaults['display_as_dropdown'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'display_as_dropdown' ) . '">' . __( 'Display as dropdown', 'news-manager' ) . '</label>
			<br />
			<input id="' . $this->get_field_id( 'show_hierarchy' ) . '" type="checkbox" name="' . $this->get_field_name( 'show_hierarchy' ) . '" value="" ' . checked( TRUE, (isset( $instance['show_hierarchy'] ) ? $instance['show_hierarchy'] : $this->nm_defaults['show_hierarchy'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'show_hierarchy' ) . '">' . __( 'Show hierarchy', 'news-manager' ) . '</label>
			<br />
			<input id="' . $this->get_field_id( 'hide_empty' ) . '" type="checkbox" name="' . $this->get_field_name( 'hide_empty' ) . '" value="" ' . checked( TRUE, (isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->nm_defaults['hide_empty'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'hide_empty' ) . '">' . __( 'Hide empty', 'news-manager' ) . '</label>
		</p>
		<p>
			<label for="' . $this->get_field_id( 'order_by' ) . '">' . __( 'Order by', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order_by' ) . '" name="' . $this->get_field_name( 'order_by' ) . '">';

		foreach ( $this->nm_orders as $id => $order_by ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order_by'] ) ? $instance['order_by'] : $this->nm_defaults['order_by'] ), FALSE ) . '>' . $order_by . '</option>';
		}

		$html .= '
			</select>
			<br />
			<label for="' . $this->get_field_id( 'order' ) . '">' . __( 'Order', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order' ) . '" name="' . $this->get_field_name( 'order' ) . '">';

		foreach ( $this->nm_order_types as $id => $order ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order'] ) ? $instance['order'] : $this->nm_defaults['order'] ), FALSE ) . '>' . $order . '</option>';
		}

		$html .= '
			</select>
		</p>';

		echo $html;
	}

	/**
	 * 
	 */
	public function update( $new_instance, $old_instance ) {
		//title
		$old_instance['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : $this->nm_defaults['title'] );

		//checkboxes
		$old_instance['display_as_dropdown'] = (isset( $new_instance['display_as_dropdown'] ) ? TRUE : FALSE);
		$old_instance['show_hierarchy'] = (isset( $new_instance['show_hierarchy'] ) ? TRUE : FALSE);
		$old_instance['hide_empty'] = (isset( $new_instance['hide_empty'] ) ? TRUE : FALSE);

		//order
		$old_instance['order_by'] = (isset( $new_instance['order_by'] ) && in_array( $new_instance['order_by'], array_keys( $this->nm_orders ), TRUE ) ? $new_instance['order_by'] : $this->nm_defaults['order_by']);
		$old_instance['order'] = (isset( $new_instance['order'] ) && in_array( $new_instance['order'], array_keys( $this->nm_order_types ), TRUE ) ? $new_instance['order'] : $this->nm_defaults['order']);

		return $old_instance;
	}

}

class News_Manager_Categories_Widget extends WP_Widget {

	private $nm_defaults = array();
	private $nm_orders = array();
	private $nm_order_types = array();

	public function __construct() {
		parent::__construct(
			'News_Manager_Categories_Widget', __( 'News Categories', 'news-manager' ), array(
			'description' => __( 'Displays a list of news categories', 'news-manager' )
			)
		);

		$this->nm_defaults = array(
			'title'					 => __( 'News Categories', 'news-manager' ),
			'display_as_dropdown'	 => FALSE,
			'show_hierarchy'		 => TRUE,
			'hide_empty'			 => TRUE,
			'order_by'				 => 'name',
			'order'					 => 'asc'
		);

		$this->nm_orders = array(
			'id'	 => __( 'ID', 'news-manager' ),
			'name'	 => __( 'Name', 'news-manager' )
		);

		$this->nm_order_types = array(
			'asc'	 => __( 'Ascending', 'news-manager' ),
			'desc'	 => __( 'Descending', 'news-manager' )
		);
	}

	/**
	 * 
	 */
	public function widget( $args, $instance ) {
		$instance['title'] = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );

		$html = $args['before_widget'] . $args['before_title'] . ( ! empty( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title']) . $args['after_title'];
		$html .= nm_display_news_categories( $instance );
		$html .= $args['after_widget'];

		echo $html;
	}

	/**
	 * 
	 */
	public function form( $instance ) {
		$html = '
		<p>
			<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'news-manager' ) . ':</label>
			<input id="' . $this->get_field_id( 'title' ) . '" name="' . $this->get_field_name( 'title' ) . '" type="text" value="' . esc_attr( isset( $instance['title'] ) ? $instance['title'] : $this->nm_defaults['title'] ) . '" />
		</p>
		<p>
			<input id="' . $this->get_field_id( 'display_as_dropdown' ) . '" type="checkbox" name="' . $this->get_field_name( 'display_as_dropdown' ) . '" value="" ' . checked( TRUE, (isset( $instance['display_as_dropdown'] ) ? $instance['display_as_dropdown'] : $this->nm_defaults['display_as_dropdown'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'display_as_dropdown' ) . '">' . __( 'Display as dropdown', 'news-manager' ) . '</label>
			<br />
			<input id="' . $this->get_field_id( 'show_hierarchy' ) . '" type="checkbox" name="' . $this->get_field_name( 'show_hierarchy' ) . '" value="" ' . checked( TRUE, (isset( $instance['show_hierarchy'] ) ? $instance['show_hierarchy'] : $this->nm_defaults['show_hierarchy'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'show_hierarchy' ) . '">' . __( 'Show hierarchy', 'news-manager' ) . '</label>
			<br />
			<input id="' . $this->get_field_id( 'hide_empty' ) . '" type="checkbox" name="' . $this->get_field_name( 'hide_empty' ) . '" value="" ' . checked( TRUE, (isset( $instance['hide_empty'] ) ? $instance['hide_empty'] : $this->nm_defaults['hide_empty'] ), FALSE ) . ' /> <label for="' . $this->get_field_id( 'hide_empty' ) . '">' . __( 'Hide empty', 'news-manager' ) . '</label>
		</p>
		<p>
			<label for="' . $this->get_field_id( 'order_by' ) . '">' . __( 'Order by', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order_by' ) . '" name="' . $this->get_field_name( 'order_by' ) . '">';

		foreach ( $this->nm_orders as $id => $order_by ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order_by'] ) ? $instance['order_by'] : $this->nm_defaults['order_by'] ), FALSE ) . '>' . $order_by . '</option>';
		}

		$html .= '
			</select>
			<br />
			<label for="' . $this->get_field_id( 'order' ) . '">' . __( 'Order', 'news-manager' ) . ':</label>
			<select id="' . $this->get_field_id( 'order' ) . '" name="' . $this->get_field_name( 'order' ) . '">';

		foreach ( $this->nm_order_types as $id => $order ) {
			$html .= '
				<option value="' . esc_attr( $id ) . '" ' . selected( $id, (isset( $instance['order'] ) ? $instance['order'] : $this->nm_defaults['order'] ), FALSE ) . '>' . $order . '</option>';
		}

		$html .= '
			</select>
		</p>';

		echo $html;
	}

	/**
	 * 
	 */
	public function update( $new_instance, $old_instance ) {
		//title
		$old_instance['title'] = sanitize_text_field( isset( $new_instance['title'] ) ? $new_instance['title'] : $this->nm_defaults['title'] );

		//checkboxes
		$old_instance['display_as_dropdown'] = (isset( $new_instance['display_as_dropdown'] ) ? TRUE : FALSE);
		$old_instance['show_hierarchy'] = (isset( $new_instance['show_hierarchy'] ) ? TRUE : FALSE);
		$old_instance['hide_empty'] = (isset( $new_instance['hide_empty'] ) ? TRUE : FALSE);

		//order
		$old_instance['order_by'] = (isset( $new_instance['order_by'] ) && in_array( $new_instance['order_by'], array_keys( $this->nm_orders ), TRUE ) ? $new_instance['order_by'] : $this->nm_defaults['order_by']);
		$old_instance['order'] = (isset( $new_instance['order'] ) && in_array( $new_instance['order'], array_keys( $this->nm_order_types ), TRUE ) ? $new_instance['order'] : $this->nm_defaults['order']);

		return $old_instance;
	}

}