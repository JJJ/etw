<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_PostsList_Setup
 *
 * Enable a configurable list of posts that can be displayed in the Builder or as a widget.
 *
 * @since 1.2.0.
 * @since 1.7.0. Changed class name from TTFMP_Post_List.
 */
final class MAKEPLUS_Component_PostsList_Setup extends MAKEPLUS_Util_Modules implements MAKEPLUS_Util_HookInterface {
	/**
	 * An associative array of required modules.
	 *
	 * @since 1.7.0.
	 *
	 * @var array
	 */
	protected $dependencies = array(
		'mode'          => 'MAKEPLUS_Setup_ModeInterface',
		'compatibility' => 'MAKEPLUS_Compatibility_MethodsInterface',
		'filter'        => 'MAKEPLUS_Component_PostsList_FilterInterface',
	);

	/**
	 * Indicator of whether the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @var bool
	 */
	private static $hooked = false;

	/**
	 * MAKEPLUS_Component_PostsList_Setup constructor.
	 *
	 * @since 1.7.0.
	 *
	 * @param MAKEPLUS_APIInterface|null $api
	 * @param array                      $modules
	 */
	public function __construct( MAKEPLUS_APIInterface $api = null, array $modules = array() ) {
		// Module defaults.
		$modules = wp_parse_args( $modules, array(
			'filter' => 'MAKEPLUS_Component_PostsList_Filter',
		) );

		// Load dependencies.
		parent::__construct( $api, $modules );

		// Add the Make API if it's available
		if ( $this->mode()->has_make_api() ) {
			$this->add_module( 'theme', Make() );
		}
	}

	/**
	 * Magic method to handle deprecated properties.
	 *
	 * @since 1.7.0.
	 *
	 * @param string $name
	 *
	 * @return bool|null|string
	 */
	public function __get( $name ) {
		switch ( $name ) {
			case 'filter' :
				$this->compatibility()->doing_it_wrong(
					'filter',
					sprintf(
						__( 'Use %s instead.', 'make-plus' ),
						'<code>filter()</code>'
					),
					'1.7.0'
				);

				return $this->filter();
				break;

			default :
				trigger_error(
					sprintf(
						esc_html__( 'Undefined property: %1$s::%2$s', 'make-plus' ),
						get_class( $this ),
						esc_html( $name )
					)
				);

				return null;
				break;
		}
	}

	/**
	 * Hook into WordPress.
	 *
	 * @since 1.7.0.
	 *
	 * @return void
	 */
	public function hook() {
		if ( $this->is_hooked() ) {
			return;
		}

		// Passive mode. Only enable the shortcode.
		if ( 'active' !== $this->mode()->get_mode() ) {
			// Enqueue
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );

			// Shortcode
			add_shortcode( 'ttfmp_post_list', array( $this, 'handle_shortcode' ) );
		}
		// Full functionality.
		else {
			// Add Builder section settings
			add_filter( 'make_section_defaults', array( $this, 'section_defaults' ) );
			add_filter( 'make_section_choices', array( $this, 'section_choices' ), 10, 3 );

			// Add the Builder section
			if ( is_admin() ) {
				add_action( 'after_setup_theme', array( $this, 'add_section' ), 11 );
			}

			// Admin styles and scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'admin_enqueue' ) );

			// Front end styles
			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ), 20 );

			// Shortcode
			add_shortcode( 'ttfmp_post_list', array( $this, 'handle_shortcode' ) );

			// Widget
			register_widget( 'MAKEPLUS_Component_PostsList_Widget' );

			// Hook up color customizations
			add_action( 'make_style_loaded', array( $this, 'color' ) );

			// Handle Ajax request
			if ( is_admin() ) {
				add_action( 'wp_ajax_makeplus-postslist-filter', array( $this, 'ajax_update_filter_list' ) );
			}
		}

		// Hooking has occurred.
		self::$hooked = true;
	}

	/**
	 * Check if the hook routine has been run.
	 *
	 * @since 1.7.0.
	 *
	 * @return bool
	 */
	public function is_hooked() {
		return self::$hooked;
	}

	/**
	 * Register the section.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked action after_setup_theme
	 *
	 * @return void
	 */
	public function add_section() {
		// Bail if we're not in the admin
		if ( ! is_admin() ) {
			return;
		}

		ttfmake_add_section(
			'postlist',
			__( 'Posts List', 'make-plus' ),
			makeplus_get_plugin_directory_uri() . 'css/postslist/images/post-list.png',
			__( 'Display your posts or pages in a list or grid layout.', 'make-plus' ),
			array( $this, 'save_section' ),
			'sections/builder-templates/post-list',
			'sections/front-end-templates/post-list',
			810,
			makeplus_get_plugin_directory() . 'inc/component/postslist',
			array(
				100 => array(
					'type'  => 'section_title',
					'name'  => 'title',
					'label' => __( 'Enter section title', 'make-plus' ),
					'class' => 'ttfmake-configuration-title ttfmake-section-header-title-input',
				),
				200 => array(
					'type'  => 'image',
					'name'  => 'background-image',
					'label' => __( 'Background image', 'make-plus' ),
					'class' => 'ttfmake-configuration-media',
					'default' => ttfmake_get_section_default( 'background-image', 'post-list' ),
				),
				300 => array(
					'type'    => 'checkbox',
					'label'   => __( 'Darken background to improve readability', 'make-plus' ),
					'name'    => 'darken',
					'default' => ttfmake_get_section_default( 'darken', 'post-list' ),
				),
				400 => array(
					'type'    => 'select',
					'name'    => 'background-style',
					'label'   => __( 'Background style', 'make-plus' ),
					'default' => ttfmake_get_section_default( 'background-style', 'post-list' ),
					'options' => ttfmake_get_section_choices( 'background-style', 'post-list' ),
				),
				500 => array(
					'type'    => 'color',
					'label'   => __( 'Background color', 'make-plus' ),
					'name'    => 'background-color',
					'class'   => 'ttfmake-text-background-color ttfmake-configuration-color-picker',
					'default' => ttfmake_get_section_default( 'background-color', 'post-list' ),
				),
			)
		);
	}

	/**
	 * Save the data for the Posts List section.
	 *
	 * @since 1.7.0.
	 *
	 * @param array $data    The data from the $_POST array for the section.
	 *
	 * @return array         The cleaned data.
	 */
	public function save_section( $data ) {
		// Checkbox fields will not be set if they are unchecked.
		$checkboxes = array( 'show-title', 'show-date', 'show-excerpt', 'show-author', 'show-categories', 'show-tags', 'show-comments' );
		foreach ( $checkboxes as $key ) {
			if ( ! isset( $data[$key] ) ) {
				$data[$key] = 0;
			}
		}
		// Data to sanitize and save
		$defaults = array(
			'title' => ttfmake_get_section_default( 'title', 'post-list' ),
			'background-image' => ttfmake_get_section_default( 'background-image', 'post-list' ),
			'darken' => ttfmake_get_section_default( 'darken', 'post-list' ),
			'background-style' => ttfmake_get_section_default( 'background-style', 'post-list' ),
			'background-color' => ttfmake_get_section_default( 'background-color', 'post-list' ),
			'columns' => ttfmake_get_section_default( 'columns', 'post-list' ),
			'type' => ttfmake_get_section_default( 'type', 'post-list' ),
			'sortby' => ttfmake_get_section_default( 'sortby', 'post-list' ),
			'keyword' => ttfmake_get_section_default( 'keyword', 'post-list' ),
			'count' => ttfmake_get_section_default( 'count', 'post-list' ),
			'offset' => ttfmake_get_section_default( 'offset', 'post-list' ),
			'taxonomy' => ttfmake_get_section_default( 'taxonomy', 'post-list' ),
			'show-title' => ttfmake_get_section_default( 'show-title', 'post-list' ),
			'show-date' => ttfmake_get_section_default( 'show-date', 'post-list' ),
			'show-excerpt' => ttfmake_get_section_default( 'show-excerpt', 'post-list' ),
			'excerpt-length' => ttfmake_get_section_default( 'excerpt-length', 'post-list' ),
			'show-author' => ttfmake_get_section_default( 'show-author', 'post-list' ),
			'show-categories' => ttfmake_get_section_default( 'show-categories', 'post-list' ),
			'show-tags' => ttfmake_get_section_default( 'show-tags', 'post-list' ),
			'show-comments' => ttfmake_get_section_default( 'show-comments', 'post-list' ),
			'thumbnail' => ttfmake_get_section_default( 'thumbnail', 'post-list' ),
			'aspect' => ttfmake_get_section_default( 'aspect', 'post-list' ),
		);
		$parsed_data = wp_parse_args( $data, $defaults );

		$clean_data = array();

		// Title
		$clean_data['title'] = $clean_data['label'] = apply_filters( 'title_save_pre', $parsed_data['title'] );

		// Background image
		$image_id = ( isset( $parsed_data['background-image']['image-id'] ) ) ? $parsed_data['background-image']['image-id'] : $parsed_data['background-image'];
		$clean_data['background-image'] = ttfmake_sanitize_image_id( $image_id );

		// Darken
		$clean_data['darken'] = absint( $parsed_data['darken'] );

		// Background style
		$clean_data['background-style'] = ttfmake_sanitize_section_choice( $parsed_data['background-style'], 'background-style', 'post-list' );

		// Background color
		$clean_data['background-color'] = maybe_hash_hex_color( $parsed_data['background-color'] );

		// Columns
		$clean_data['columns'] = ttfmake_sanitize_section_choice( $parsed_data['columns'], 'columns', 'post-list' );

		// Type
		$clean_data['type'] = ttfmake_sanitize_section_choice( $parsed_data['type'], 'type', 'post-list' );

		// Taxonomy
		$clean_data['taxonomy'] = $this->filter()->sanitize_filter_choice( $parsed_data['taxonomy'], $clean_data['type'] );

		// Sort by
		$clean_data['sortby'] = ttfmake_sanitize_section_choice( $parsed_data['sortby'], 'sortby', 'post-list' );

		// Keyword
		$clean_data['keyword'] = esc_html( $parsed_data['keyword'] );

		// Count
		$clean_count = (int) $parsed_data['count'];
		if ( $clean_count < -1 ) {
			$clean_count = abs( $clean_count );
		}
		$clean_data['count'] = $clean_count;

		// Offset
		$clean_data['offset'] = absint( $parsed_data['offset'] );

		// Checkboxes
		foreach ( $checkboxes as $key ) {
			$clean_data[$key] = absint( $parsed_data[$key] );
		}

		// Thumbnail
		$clean_data['thumbnail'] = ttfmake_sanitize_section_choice( $parsed_data['thumbnail'], 'thumbnail', 'post-list' );

		// Aspect
		$clean_data['aspect'] = ttfmake_sanitize_section_choice( $parsed_data['aspect'], 'aspect', 'post-list' );

		// Excerpt length
		$clean_data['excerpt-length'] = absint( $parsed_data['excerpt-length'] );

		return $clean_data;
	}

	/**
	 * Save the data for the Posts List section.
	 *
	 * @since 1.2.0.
	 * @deprecated 1.7.0.
	 *
	 * @param array $data    The data from the $_POST array for the section.
	 *
	 * @return array         The cleaned data.
	 */
	public function save_post_list( $data ) {
		// Deprecated function message
		$this->compatibility()->deprecated_function(
			__METHOD__,
			'1.7.0',
			'save_section'
		);

		return $this->save_section( $data );
	}

	/**
	 * Add new section defaults.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked filter make_section_defaults
	 *
	 * @param array $defaults    The default section defaults.
	 *
	 * @return array             The augmented section defaults.
	 */
	public function section_defaults( $defaults ) {
		$new_defaults = array(
			'post-list-title' => '',
			'post-list-background-image' => 0,
			'post-list-darken' => 0,
			'post-list-background-style' => 'tile',
			'post-list-background-color' => '',
			'post-list-columns' => 2,
			'post-list-type' => 'post',
			'post-list-sortby' => 'date-desc',
			'post-list-keyword' => '',
			'post-list-count' => 6,
			'post-list-offset' => 0,
			'post-list-taxonomy' => 'all',
			'post-list-show-title' => 1,
			'post-list-show-date' => 1,
			'post-list-show-excerpt' => 1,
			'post-list-excerpt-length' => apply_filters( 'excerpt_length', 55 ),
			'post-list-show-author' => 0,
			'post-list-show-categories' => 0,
			'post-list-show-tags' => 0,
			'post-list-show-comments' => 0,
			'post-list-thumbnail' => 'top',
			'post-list-aspect' => 'none',
		);

		return array_merge( $defaults, $new_defaults );
	}

	/**
	 * Add new section choices.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked filter make_section_choices
	 *
	 * @param array  $choices         The existing choices.
	 * @param string $key             The key for the section setting.
	 * @param string $section_type    The section type.
	 *
	 * @return array                  The choices for the particular section_type / key combo.
	 */
	public function section_choices( $choices, $key, $section_type ) {
		if ( count( $choices ) > 1 || ! in_array( $section_type, array( 'post-list' ) ) ) {
			return $choices;
		}

		$choice_id = "$section_type-$key";

		switch ( $choice_id ) {
			case 'post-list-background-style' :
				$choices = array(
					'tile'  => __( 'Tile', 'make-plus' ),
					'cover' => __( 'Cover', 'make-plus' ),
				);
				break;
			case 'post-list-columns' :
				$choices = array(
					1 => __( '1', 'make-plus' ),
					2 => __( '2', 'make-plus' ),
					3 => __( '3', 'make-plus' ),
					4 => __( '4', 'make-plus' ),
				);
				break;
			case 'post-list-type' :
				// Post types
				$post_types = get_post_types(
					array(
						'public' => true,
						'_builtin' => false
					)
				);
				$post_types = array_merge( array( 'post', 'page' ), (array) $post_types );
				// Labels
				$labels = array();
				foreach ( $post_types as $type ) {
					$labels[] = get_post_type_object( $type )->labels->singular_name;
				}
				// Choices
				$choices = array_combine( $post_types, $labels );
				break;
			case 'post-list-sortby' :
				$choices = array(
					'date-desc' => __( 'Date: newest first', 'make-plus' ),
					'date-asc' => __( 'Date: oldest first', 'make-plus' ),
					'title-asc' => __( 'Title: A to Z', 'make-plus' ),
					'title-desc' => __( 'Title: Z to A', 'make-plus' ),
					'comment_count-desc' => __( 'Most comments', 'make-plus' ),
					'menu_order-asc' => __( 'Page order', 'make-plus' ),
					'rand' => __( 'Random', 'make-plus' ),
				);
				break;
			case 'post-list-thumbnail' :
				$choices = array(
					'top' => __( 'Top', 'make-plus' ),
					'left' => __( 'Left', 'make-plus' ),
					'right' => __( 'Right', 'make-plus' ),
					'none' => __( 'None', 'make-plus' ),
				);
				break;
			case 'post-list-aspect' :
				$choices = array(
					'none' => __( 'None', 'make-plus' ),
					'square' => __( 'Square', 'make-plus' ),
					'landscape' => __( 'Landscape', 'make-plus' ),
					'portrait' => __( 'Portrait', 'make-plus' ),
				);
				break;
		}

		return $choices;
	}

	/**
	 * Enqueue the JS and CSS for the admin.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked action admin_enqueue_scripts
	 * @hooked action customize_controls_enqueue_scripts
	 *
	 * @param string $hook_suffix    The suffix for the screen.
	 *
	 * @return void
	 */
	public function admin_enqueue( $hook_suffix = '' ) {
		// Have to be careful with this test because this function was introduced in Make 1.2.0.
		$post_type_supports_builder = ( function_exists( 'ttfmake_post_type_supports_builder' ) ) ? ttfmake_post_type_supports_builder( get_post_type() ) : false;

		// Builder styles
		if (
			in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) )
			&&
			( $post_type_supports_builder || ( 'page' === get_post_type() ) )
		) {
			// Add the section CSS
			wp_enqueue_style(
				'makeplus-postslist-sections',
				makeplus_get_plugin_directory_uri() . 'css/postslist/sections.css',
				array(),
				MAKEPLUS_VERSION,
				'all'
			);
		}

		// Script
		if (
			in_array( $hook_suffix, array( 'post.php', 'post-new.php', 'widgets.php' ) )
			||
		    'customize_controls_enqueue_scripts' === current_action()
		) {
			// Compile script dependencies
			$dependencies = array( 'jquery' );
			if ( in_array( $hook_suffix, array( 'post.php', 'post-new.php' ) ) ) {
				$dependencies[] = 'ttfmake-builder';
			} else if ( 'customize_controls_enqueue_scripts' === current_action() ) {
				$dependencies[] = 'customize-widgets';
			}

			wp_enqueue_script(
				'makeplus-postslist-admin',
				makeplus_get_plugin_directory_uri() . 'js/postslist/admin.js',
				$dependencies,
				MAKEPLUS_VERSION,
				true
			);

			// Add JS data for the Customizer.
			if ( 'customize_controls_enqueue_scripts' === current_action() ) {
				wp_localize_script(
					'makeplus-postslist-admin',
					'MakePlusPostsList',
					array(
						'ajaxurl' => esc_url( admin_url( 'admin-ajax.php' ) ),
						'pagenow' => 'customizer',
					)
				);
			}
		}
	}

	/**
	 * Enqueue styles and scripts for the Post List module.
	 *
	 * @since 1.2.0.
	 *
	 * @hooked action wp_enqueue_scripts
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
		if ( is_active_widget( false, false, 'ttfmp-post-list', true ) || is_customize_preview() ) {
			$load = true;
		}

		// Check for passive mode
		if ( 'active' !== $this->mode()->get_mode() ) {
			$load = true;
		}

		// Enqueue the stylesheet
		if ( true === $load ) {
			wp_enqueue_style(
				'makeplus-postslist-frontend',
				makeplus_get_plugin_directory_uri() . 'css/postslist/frontend.css',
				array(),
				MAKEPLUS_VERSION,
				'all'
			);

			// If current theme is a child theme of Make, load the Posts List stylesheet
			// before the child theme stylesheet so styles can be customized.
			if ( $this->has_module( 'theme' ) && is_child_theme() ) {
				$this->theme()->scripts()->add_dependency( 'make-main', 'makeplus-postslist-frontend', 'style' );
			}
		}
	}

	/**
	 * Determine the arguments for a custom WP_Query and build it.
	 *
	 * @since 1.2.0.
	 *
	 * @param array $options    The options for determining the query args.
	 *
	 * @return WP_Query         The query object.
	 */
	public function build_query( array $options ) {
		$defaults = array(
			'type'     => 'post',
			'sortby'   => 'date-desc',
			'keyword'  => '',
			'count'    => 6,
			'offset'   => 0,
			'taxonomy' => 'all',
		);
		$d = wp_parse_args( $options, $defaults );

		// Initial args
		$args = array(
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'post_type'           => $d['type'],
			'posts_per_page'      => $d['count'],
			'offset'              => $d['offset'],
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
			$d['taxonomy'] = $this->filter()->upgrade_filter_choice( $d['taxonomy'] );

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

		// Check for deprecated filter
		if ( has_filter( 'ttfmp_post_list_query_args' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_post_list_query_args',
				'1.7.0',
				sprintf(
					__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_postslist_query_args</code>'
				)
			);

			/**
			 * Filter the arguments that are used to create the Posts List query object.
			 *
			 * @since 1.6.0.
			 * @deprecated 1.7.0.
			 *
			 * @param array    $args       The query arguments.
			 * @param array    $options    The section/widget options used to determine the arguments.
			 */
			$args = apply_filters( 'ttfmp_post_list_query_args', $args, $options );
		}

		/**
		 * Filter the arguments that are used to create the Posts List query object.
		 *
		 * @since 1.7.0.
		 *
		 * @param array $args       The query arguments.
		 * @param array $options    The section/widget options used to determine the arguments.
		 */
		$args = apply_filters( 'makeplus_postslist_query_args', $args, $options );

		return new WP_Query( $args );
	}

	/**
	 * Generate and return the markup for the post list.
	 *
	 * @since 1.2.0.
	 *
	 * @param WP_Query $query      The WP_Query object.
	 * @param array    $display    The display options.
	 *
	 * @return string              The post list markup.
	 */
	public function render( WP_Query $query, array $display = array() ) {
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
		$ttfmp_data = wp_parse_args( $display, $display_defaults );

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

		// Cache thumbnails
		if ( 'none' !== $ttfmp_data['thumbnail'] ) {
			update_post_thumbnail_cache( $query );
		}

		// Template path
		$paths = array(
			'theme'  => 'post-list-item.php',
			'plugin' => makeplus_get_plugin_directory() . 'inc/component/postslist/templates/post-list-item.php'
		);

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_post_list_template_paths' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_post_list_template_paths',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_postslist_template_paths</code>'
				)
			);

			$paths = apply_filters( 'ttfmp_post_list_template_paths', $paths );
		}

		/**
		 * Filter: Modify the array of paths used when locating the post-list-item.php template file.
		 *
		 * @since 1.7.0.
		 *
		 * @param array $paths
		 */
		$paths = apply_filters( 'makeplus_postslist_template_paths', $paths );

		if ( '' === $template = locate_template( $paths['theme'] ) ) {
			if ( is_readable( $paths['plugin'] ) ) {
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

		// Check for deprecated filter.
		if ( has_filter( 'ttfmp_post_list_output' ) ) {
			$this->compatibility()->deprecated_hook(
				'ttfmp_post_list_output',
				'1.7.0',
				sprintf(
					esc_html__( 'Use the %s hook instead.', 'make-plus' ),
					'<code>makeplus_postslist_output</code>'
				)
			);

			$output = apply_filters( 'ttfmp_post_list_output', $output, $query, $display );
		}

		/**
		 * Filter: Modify the HTML output for a Posts List.
		 *
		 * @since 1.7.0.
		 *
		 * @param string   $output
		 * @param WP_Query $query
		 * @param array    $display
		 */
		return apply_filters( 'makeplus_postslist_output', $output, $query, $display );
	}

	/**
	 * Output the ttfmp_post_list shortcode.
	 *
	 * @since 1.2.0.
	 *
	 * @param array $atts    The shortcode parameters.
	 *
	 * @return string        The shortcode output.
	 */
	public function handle_shortcode( $atts ) {
		$converted_atts = array();

		foreach ( $atts as $key => $value ) {
			$converted_key = str_replace( '_', '-', $key );
			$converted_atts[ $converted_key ] = $value;
		}

		// Get the query
		$query = $this->build_query( $converted_atts );

		return $this->render( $query, $converted_atts );
	}

	/**
	 * Enable color options for certain Post List styles
	 *
	 * @since 1.2.0.
	 * @since 1.7.0. Added the $style parameter.
	 *
	 * @hooked action make_style_loaded
	 *
	 * @param MAKE_Style_ManagerInterface $style
	 *
	 * @return void
	 */
	public function color( MAKE_Style_ManagerInterface $style ) {
		// Output the rules
		if ( ! $style->thememod()->is_default( 'color-primary' ) ) {
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-postlist .ttfmp-post-list-item-footer a:hover',
					'.ttfmp-widget-post-list .ttfmp-post-list-item-comment-link:hover'
				),
				'declarations' => array(
					'color' => $style->thememod()->get_value( 'color-primary' )
				)
			) );
		}
		if ( ! $style->thememod()->is_default( 'color-text' ) ) {
			$style->css()->add( array(
				'selectors'    => array(
					'.ttfmp-widget-post-list .ttfmp-post-list-item-date a',
					'.builder-section-postlist .ttfmp-post-list-item-date a'
				),
				'declarations' => array(
					'color' => $style->thememod()->get_value( 'color-text' )
				)
			) );
		}
		if ( ! $style->thememod()->is_default( 'color-detail' ) ) {
			$style->css()->add( array(
				'selectors'    => array(
					'.builder-section-postlist .ttfmp-post-list-item-footer',
					'.builder-section-postlist .ttfmp-post-list-item-footer a',
					'.ttfmp-widget-post-list .ttfmp-post-list-item-comment-link'
				),
				'declarations' => array(
					'color' => $style->thememod()->get_value( 'color-detail' )
				)
			) );
		}
	}

	/**
	 * Generate an excerpt of specified length for inclusion in a Posts List item.
	 *
	 * @since 1.6.2.
	 *
	 * @param int $length    The maximum length in words of the excerpt.
	 *
	 * @return string        The excerpt.
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

	/**
	 * Handle an Ajax request for the filter choice list for a particular post type.
	 *
	 * @since 1.6.2.
	 *
	 * @return void
	 */
	public function ajax_update_filter_list() {
		$post_type = ( isset( $_POST['p'] ) ) ? sanitize_key( $_POST['p'] ) : null;
		$selected  = ( isset( $_POST['v'] ) ) ? esc_attr( $_POST['v'] ) : null;

		if ( $post_type ) {
			echo $this->filter()->render_choice_list( $post_type, $selected );
		}

		wp_die();
	}
}