<?php
/**
 * @package Make Plus
 */

if ( ! class_exists( 'TTFMP_Post_List' ) ) :
/**
 * Bootstrap the Post List features
 *
 * @since 1.2.0.
 */
class TTFMP_Post_List {

	var $filter = null;

	/**
	 * Name of the component.
	 *
	 * @since 1.2.0.
	 *
	 * @var   string    The name of the component.
	 */
	var $component_slug = 'post-list';

	/**
	 * Path to the component directory (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component).
	 *
	 * @since 1.2.0.
	 *
	 * @var   string    Path to the component directory
	 */
	var $component_root = '';

	/**
	 * File path to the plugin main file (e.g., /var/www/mysite/wp-content/plugins/make-plus/components/my-component/my-component.php).
	 *
	 * @since 1.2.0.
	 *
	 * @var   string    Path to the plugin's main file.
	 */
	var $file_path = '';

	/**
	 * The URI base for the plugin (e.g., http://example.com/wp-content/plugins/make-plus/my-component).
	 *
	 * @since 1.2.0.
	 *
	 * @var   string    The URI base for the plugin.
	 */
	var $url_base = '';

	/**
	 * The one instance of TTFMP_Post_List.
	 *
	 * @since 1.2.0.
	 *
	 * @var   TTFMP_Post_List
	 */
	private static $instance;

	/**
	 * Instantiate or return the one TTFMP_Post_List instance.
	 *
	 * @since  1.2.0.
	 *
	 * @return TTFMP_Post_List
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Set the class properties.
	 *
	 * @since 1.2.0.
	 *
	 * @return TTFMP_Post_List
	 */
	private function __construct() {
		// Set the main paths for the component
		$this->component_root = ttfmp_get_app()->component_base . '/' . $this->component_slug;
		$this->file_path      = $this->component_root . '/' . basename( __FILE__ );
		$this->url_base       = untrailingslashit( plugins_url( '/', __FILE__ ) );
	}

	/**
	 * Set up the component.
	 *
	 * @since  1.2.0.
	 *
	 * @return void
	 */
	public function init() {
		// Passive mode
		if ( true === ttfmp_get_app()->passive ) {
			// Includes
			require_once $this->component_root . '/class-filter.php';

			// Properties
			$this->filter = new TTFMP_Posts_List_Filter();

			// Enqueue
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );

			// Shortcode
			add_shortcode( 'ttfmp_post_list', array( $this, 'handle_shortcode' ) );
		}
		// Active mode
		else {
			// Includes
			require_once $this->component_root . '/class-section-definitions.php';
			require_once $this->component_root . '/class-widget.php';
			require_once $this->component_root . '/class-filter.php';

			// Properties
			$this->filter = new TTFMP_Posts_List_Filter();

			// Enqueue
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'admin_enqueue' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );

			// Shortcode
			add_shortcode( 'ttfmp_post_list', array( $this, 'handle_shortcode' ) );

			// Widget
			register_widget( 'TTFMP_Post_List_Widget' );

			// Hook up color customizations
			add_action( 'ttfmake_css', array( $this, 'color' ) );
		}
	}

	/**
	 * Enqueue scripts for specific pages in the WordPress Admin.@deprecated
	 *
	 * @since 1.6.2.
	 *
	 * @param string    $hook_suffix    The identifying string of the current admin page.
	 *
	 * @return void
	 */
	public function admin_enqueue( $hook_suffix ) {
		$action = current_action();
		if ( ! in_array( $hook_suffix, array( 'post.php', 'post-new.php', 'widgets.php' ) ) && 'customize_controls_enqueue_scripts' !== $action ) {
			return;
		}

		$dependencies = array( 'jquery' );
		if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
			$dependencies[] = 'ttfmake-builder';
		} else if ( 'customize_controls_enqueue_scripts' === $action ) {
			$dependencies[] = 'customize-widgets';
		}

		wp_enqueue_script(
			'ttfmp-posts-list-admin',
			trailingslashit( $this->url_base ) . 'js/admin.js',
			$dependencies,
			ttfmp_get_app()->version,
			true
		);

		if ( 'customize_controls_enqueue_scripts' === $action ) {
			wp_localize_script(
				'ttfmp-posts-list-admin',
				'ttfmpPostsList',
				array(
					'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
					'pagenow' => 'customizer',
				)
			);
		}
	}

	/**
	 * Enqueue styles and scripts for the Post List module.
	 *
	 * @since 1.2.0.
	 *
	 * @return void
	 */
	public function frontend_enqueue() {
		$load = false;

		// Check for a Builder section
		if ( function_exists( 'ttfmake_is_builder_page' ) && ttfmake_is_builder_page() ) {
			$sections = ttfmake_get_section_data( get_the_ID() );
			if ( ! empty( $sections ) ) {
				// Parse the sections included on the page.
				$section_types = wp_list_pluck( $sections, 'section-type' );
				$matched_sections = array_keys( $section_types, 'postlist' );

				// Only enqueue if there is at least one Posts List section.
				if ( ! empty( $matched_sections ) ) {
					$load = true;
				}
			}
		}

		// Check for a widget
		if ( is_active_widget( false, false, 'ttfmp-post-list', true ) ) {
			$load = true;
		}

		// Check for passive mode
		if ( true === ttfmp_get_app()->passive ) {
			$load = true;
		}

		if ( true === $load ) {
			wp_enqueue_style(
				'ttfmp-post-list',
				trailingslashit( $this->url_base ) . 'css/post-list.css',
				array(),
				ttfmp_get_app()->version,
				'all'
			);
		}
	}

	/**
	 * Determine the arguments for a custom WP_Query and build it.
	 *
	 * @since 1.2.0.
	 *
	 * @param  array        $options    The options for determining the query args.
	 * @return WP_Query                 The query object.
	 */
	public function build_query( $options ) {
		$defaults = array(
			'type' => 'post',
			'sortby' => 'date-desc',
			'keyword' => '',
			'count' => 6,
			'offset' => 0,
			'taxonomy' => 'all',
		);
		$d = wp_parse_args( $options, $defaults );

		// Initial args
		$args = array(
			'post_status' => 'publish',
			'ignore_sticky_posts' => true,
			'post_type' => $d['type'],
			'posts_per_page' => $d['count'],
			'offset' => $d['offset'],
		);

		// Sortby
		$sort = explode( '-', $d['sortby'], 2 );
		$args['orderby'] = $sort[0];
		if ( isset( $sort[1] ) ) {
			$args['order'] = $sort[1];
		}

		// Keyword
		if ( '' !== $d['keyword'] ) {
			$args['s'] = $d['keyword'];
		}

		// Taxonomy / Children
		if ( 'all' !== $d['taxonomy'] ) {
			// Back compat
			$d['taxonomy'] = $this->filter->upgrade_filter_choice( $d['taxonomy'] );

			$term = explode( ':', $d['taxonomy'] );
			if ( 'postid' === $term[0] ) {
				$args['post_parent'] = absint( $term[1] );
			} else {
				$args['tax_query'] = array(
					array(
						'taxonomy' => $term[0],
						'field' => 'slug',
						'terms' => $term[1],
					)
				);
			}
		}

		/**
		 * Filter the arguments that are used to create the Posts List query object.
		 *
		 * @since 1.6.0.
		 *
		 * @param array    $args       The query arguments.
		 * @param array    $options    The section/widget options used to determine the arguments.
		 */
		$args = apply_filters( 'ttfmp_post_list_query_args', $args, $options );

		return new WP_Query( $args );
	}

	/**
	 * Generate and return the markup for the post list.
	 *
	 * @since 1.2.0.
	 *
	 * @param  object    $query      The WP_Query object.
	 * @param  array     $display    The display options.
	 * @return string                The post list markup.
	 */
	public function render( $query, $display = array() ) {
		if ( ! is_object( $query ) || 'WP_Query' !== get_class( $query ) ) {
			return '';
		}

		global $ttfmp_data;

		$display_defaults = array(
			'columns' => 2,
			'show-title' => 1,
			'show-date' => 1,
			'show-excerpt' => 0,
			'excerpt-length' => apply_filters( 'excerpt_length', 55 ),
			'show-author' => 0,
			'show-categories' => 0,
			'show-tags' => 0,
			'show-comments' => 0,
			'thumbnail' => 'left',
			'aspect' => 'none',
		);
		$ttfmp_data = wp_parse_args( (array) $display, $display_defaults );

		// Columns
		$ttfmp_data['columns'] = absint( $ttfmp_data['columns'] );
		if ( 0 === $ttfmp_data['columns'] ) {
			$ttfmp_data['columns'] = $display_defaults['columns'];
		}

		// Class list
		$classes = 'ttfmp-post-list';
		$classes .= ' columns-' . $ttfmp_data['columns'];
		$classes .= ' thumbnail-' . $ttfmp_data['thumbnail'];
		if ( $ttfmp_data['show-excerpt'] ) {
			$classes .= ' has-excerpt';
		}

		// Template path
		$paths = apply_filters( 'ttfmp_post_list_template_paths', array(
			'theme'  => 'post-list-item.php',
			'plugin' => trailingslashit( $this->component_root ) . 'templates/post-list-item.php'
		) );
		if ( '' === $template = locate_template( $paths['theme'] ) ) {
			if ( file_exists( $paths['plugin'] ) ) {
				$template = $paths['plugin'];
			} else {
				return '';
			}
		}

		// Important numbers
		$post_count = $query->post_count;
		$columns = $ttfmp_data['columns'];
		$col_count = 1;

		// Generate the markup
		ob_start(); ?>
		<div class="<?php echo esc_attr( $classes ); ?>">
		<?php
		// Loop starts here
		while ( $query->have_posts() ) : $query->the_post(); ?>
		<?php
		// Multiple columns
		if ( $columns > 1 ) : ?>
			<?php
			// Start a new row
			if ( 1 === $col_count ) : ?>
			<div class="ttfmp-post-list-row">
			<?php endif; ?>
				<div class="ttfmp-post-list-item<?php if ( 0 === $col_count % $columns ) echo ' last'; ?>">
					<?php require( $template ); ?>
				</div>
			<?php
			// End a row
			if ( 0 === $col_count % $columns || $query->current_post + 1 === $post_count ) : ?>
			</div>
			<?php endif; ?>
			<?php
			// Adjust the column counter
			if ( $col_count === $columns ) :
				$col_count = 1;
			else :
				$col_count++;
			endif;
			?>
		<?php
		// Only one column
		else : ?>
			<div class="ttfmp-post-list-item">
				<?php require( $template ); ?>
			</div>
		<?php endif; ?>
		<?php
		// Loop ends here
		endwhile; wp_reset_postdata(); ?>
		</div>
		<?php
		$output = ob_get_clean();

		return apply_filters( 'ttfmp_post_list_output', $output, $query, $display );
	}

	/**
	 * Output the ttfmp_post_list shortcode.
	 *
	 * @since 1.2.0.
	 *
	 * @param  array      $atts    The shortcode parameters.
	 * @return string              The shortcode output.
	 */
	public function handle_shortcode( $atts ) {
		$converted_atts = array();
		foreach ( $atts as $key => $value ) {
			$converted_key = str_replace( '_', '-', $key );
			$converted_atts[$converted_key] = $value;
		}

		$query = $this->build_query( $converted_atts );
		return $this->render( $query, $converted_atts );
	}

	/**
	 * Enable color options for certain Post List styles
	 *
	 * @since 1.2.0.
	 *
	 * @return void
	 */
	public function color() {
		// Get and escape options
		$color_primary         = maybe_hash_hex_color( get_theme_mod( 'color-primary', ttfmake_get_default( 'color-primary' ) ) );
		$color_text            = maybe_hash_hex_color( get_theme_mod( 'color-text', ttfmake_get_default( 'color-text' ) ) );
		$color_detail          = maybe_hash_hex_color( get_theme_mod( 'color-detail', ttfmake_get_default( 'color-detail' ) ) );

		// Output the rules
		if ( $color_primary !== ttfmake_get_default( 'color-primary' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.builder-section-postlist .ttfmp-post-list-item-footer a:hover',
					'.ttfmp-widget-post-list .ttfmp-post-list-item-comment-link:hover'
				),
				'declarations' => array(
					'color' => $color_primary
				)
			) );
		}
		if ( $color_text !== ttfmake_get_default( 'color-text' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.ttfmp-widget-post-list .ttfmp-post-list-item-date a',
					'.builder-section-postlist .ttfmp-post-list-item-date a'
				),
				'declarations' => array(
					'color' => $color_text
				)
			) );
		}
		if ( $color_detail !== ttfmake_get_default( 'color-detail' ) ) {
			ttfmake_get_css()->add( array(
				'selectors'    => array(
					'.builder-section-postlist .ttfmp-post-list-item-footer',
					'.builder-section-postlist .ttfmp-post-list-item-footer a',
					'.ttfmp-widget-post-list .ttfmp-post-list-item-comment-link'
				),
				'declarations' => array(
					'color' => $color_detail
				)
			) );
		}
	}

	/**
	 * Generate an excerpt of specified length for inclusion in a Posts List item.@deprecated
	 *
	 * @since 1.6.2.
	 *
	 * @param  int    $length    The maximum length in words of the excerpt.
	 *
	 * @return string            The excerpt.
	 */
	public function get_excerpt( $length = 55 ) {
		$post = get_post();
		if ( empty( $post ) || post_password_required() ) {
			return '';
		}

		$text = $post->post_excerpt;
		$raw_excerpt = $text;

		// Generate an excerpt if necessary
		if ( ! $text ) {
			$text = strip_shortcodes( get_the_content( '' ) );
			$text = apply_filters( 'the_content', $text );
			$text = str_replace( ']]>', ']]&gt;', $text );
		}

		$length = absint( $length );
		$more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );
		if ( function_exists( 'ttfmake_get_read_more' ) ) {
			$more .= ' ' . ttfmake_get_read_more();
		} else {
			$more .= sprintf(
				' <a href="%1$s">%2$s</a>',
				esc_url( get_permalink( get_the_ID() ) ),
				esc_html__( 'Read more', 'make-plus' )
			);
		}

		// Trim the excerpt to the specified length
		$text = wp_trim_words( $text, $length, $more );
		$text = apply_filters( 'wp_trim_excerpt', $text, $raw_excerpt );

		// Apply normal excerpt filters
		return apply_filters( 'the_excerpt', $text );
	}
}
endif;

if ( ! function_exists( 'ttfmp_get_post_list' ) ) :
/**
 * Instantiate or return the one TTFMP_Post_List instance.
 *
 * @since  1.2.0.
 *
 * @return TTFMP_Post_List
 */
function ttfmp_get_post_list() {
	return TTFMP_Post_List::instance();
}
endif;

ttfmp_get_post_list()->init();