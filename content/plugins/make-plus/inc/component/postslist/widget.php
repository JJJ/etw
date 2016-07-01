<?php
/**
 * @package Make Plus
 */

/**
 * Class MAKEPLUS_Component_PostsList_Widget
 *
 * Display a Posts List as a sidebar widget.
 *
 * @since 1.2.0.
 * @since 1.7.0. Changed class name from TTFMP_Post_List_Widget
 */
class MAKEPLUS_Component_PostsList_Widget extends WP_Widget {
	/**
	 * Set up the widget properties.
	 *
	 * @since 1.2.0.
	 *
	 * @return MAKEPLUS_Component_PostsList_Widget
	 */
	public function __construct() {
		parent::__construct(
			'ttfmp-post-list',
			esc_html__( 'Posts List (Make Plus)', 'make-plus' ),
			array(
				'classname'                   => 'ttfmp-widget-post-list',
				'description'                 => esc_html__( 'Display a list of posts or pages based on specific criteria.', 'make-plus' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Render the widget on the front end.
	 *
	 * @since 1.2.0.
	 *
	 * @param array $args        The configuration for this type of widget.
	 * @param array $instance    The options for the widget instance.
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {
		// Add widget marker to data that is passed to the template
		$instance['is-widget'] = true;

		// Set default title
		$instance = wp_parse_args( $instance, array( 'title' => '' ) );

		// Only proceed if there is something to output
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$instance['columns'] = 1;
		$query = MakePlus()->get_component( 'postslist' )->build_query( $instance );
		$content = MakePlus()->get_component( 'postslist' )->render( $query, $instance );
		if ( ! $title && ! $content ) {
			return;
		}

		// Before widget
		echo $args['before_widget'];

		// Widget title
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		// Widget content
		echo $content;

		// After widget
		echo $args['after_widget'];
	}

	/**
	 * Sanitize and save the widget options.
	 *
	 * @since 1.2.0.
	 *
	 * @param array $new_instance    The current widget options.
	 * @param array $old_instance    The previous widget options (unused).
	 *
	 * @return array                 The sanitized current widget options.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = MakePlus()->get_component( 'postslist' )->save_section( $new_instance );

		if ( isset( $instance['columns'] ) ) {
			unset( $instance['columns'] );
		}

		return $instance;
	}

	/**
	 * Render the form for configuring the widget options.
	 *
	 * @since 1.2.0.
	 *
	 * @param array $instance    The current widget options.
	 *                           
	 * @return void
	 */
	public function form( $instance ) {
		$defaults = array(
			'title' => '',
			'type' => ttfmake_get_section_default( 'type', 'post-list' ),
			'sortby' => ttfmake_get_section_default( 'sortby', 'post-list' ),
			'keyword' => ttfmake_get_section_default( 'keyword', 'post-list' ),
			'count' => 3,
			'offset' => ttfmake_get_section_default( 'offset', 'post-list' ),
			'taxonomy' => ttfmake_get_section_default( 'taxonomy', 'post-list' ),
			'show-title' => ttfmake_get_section_default( 'show-title', 'post-list' ),
			'show-date' => ttfmake_get_section_default( 'show-date', 'post-list' ),
			'show-excerpt' => 0,
			'excerpt-length' => ttfmake_get_section_default( 'excerpt-length', 'post-list' ),
			'show-author' => ttfmake_get_section_default( 'show-author', 'post-list' ),
			'show-categories' => 0,
			'show-tags' => 0,
			'show-comments' => ttfmake_get_section_default( 'show-comments', 'post-list' ),
			'thumbnail' => 'left',
			'aspect' => ttfmake_get_section_default( 'aspect', 'post-list' ),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		$instance['count'] = (int) $instance['count'];
		if ( $instance['count'] < -1 ) {
			$instance['count'] = abs( $instance['count'] );
		}

		$instance['taxonomy'] = MakePlus()->get_component( 'postslist' )->filter()->upgrade_filter_choice( $instance['taxonomy'] );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'make-plus' ); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>"><?php esc_html_e( 'Type:', 'make-plus' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'type' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'type' ) ); ?>" class="widefat ttfmp-posts-list-select-type">
				<?php foreach ( ttfmake_get_section_choices( 'type', 'post-list' ) as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $instance['type'] ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php esc_html_e( 'From:', 'make-plus' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" class="widefat ttfmp-posts-list-select-from">
				<?php echo MakePlus()->get_component( 'postslist' )->filter()->render_choice_list( $instance['type'], $instance['taxonomy'] ); ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'keyword' ) ); ?>"><?php esc_html_e( 'Keyword:', 'make-plus' ); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'keyword' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'keyword' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['keyword'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>"><?php esc_html_e( 'Sort by:', 'make-plus' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'sortby' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'sortby' ) ); ?>" class="widefat">
				<?php foreach ( ttfmake_get_section_choices( 'sortby', 'post-list' ) as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $instance['sortby'] ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of items to show:', 'make-plus' ); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['count'] ); ?>" />
			<small style="display: block; padding-top: 5px;"><?php echo wp_kses( __( 'To show all items, set to <code>-1</code>.', 'make-plus' ), wp_kses_allowed_html() ); ?></small>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>"><?php esc_html_e( 'Item offset:', 'make-plus' ); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'offset' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'offset' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['offset'] ); ?>" />
		</p>

		<p style="margin-bottom: 0;"><label><?php esc_html_e( 'Post display', 'make-plus' ); ?></label></p>

		<p style="margin-top: 1em;">
			<input class="checkbox" type="checkbox" <?php checked( $instance['show-title'], true ) ?> id="<?php echo esc_attr( $this->get_field_id( 'show-title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-title' ) ); ?>" value="1" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show-title' ) ); ?>"><?php esc_html_e( 'Show item title', 'make-plus' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show-date'], true ) ?> id="<?php echo esc_attr( $this->get_field_id( 'show-date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-date' ) ); ?>" value="1" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show-date' ) ); ?>"><?php esc_html_e( 'Show date', 'make-plus' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show-author'], true ) ?> id="<?php echo esc_attr( $this->get_field_id( 'show-author' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-author' ) ); ?>" value="1" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show-author' ) ); ?>"><?php esc_html_e( 'Show author', 'make-plus' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show-comments'], true ) ?> id="<?php echo esc_attr( $this->get_field_id( 'show-comments' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-comments' ) ); ?>" value="1" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show-comments' ) ); ?>"><?php esc_html_e( 'Show comment count', 'make-plus' ); ?></label>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( $instance['show-excerpt'], true ) ?> id="<?php echo esc_attr( $this->get_field_id( 'show-excerpt' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show-excerpt' ) ); ?>" value="1" />
			<label for="<?php echo esc_attr( $this->get_field_id( 'show-excerpt' ) ); ?>"><?php esc_html_e( 'Show excerpt', 'make-plus' ); ?></label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'excerpt-length' ) ); ?>"><?php esc_html_e( 'Excerpt length (words):', 'make-plus' ); ?></label> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'excerpt-length' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'excerpt-length' ) ); ?>" type="number" value="<?php echo esc_attr( $instance['excerpt-length'] ); ?>" />
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>"><?php esc_html_e( 'Show featured image:', 'make-plus' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'thumbnail' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'thumbnail' ) ); ?>" class="widefat">
				<?php foreach ( ttfmake_get_section_choices( 'thumbnail', 'post-list' ) as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $instance['thumbnail'] ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'aspect' ) ); ?>"><?php esc_html_e( 'Image aspect ratio:', 'make-plus' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'aspect' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'aspect' ) ); ?>" class="widefat">
				<?php foreach ( ttfmake_get_section_choices( 'aspect', 'post-list' ) as $value => $label ) : ?>
					<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $instance['aspect'] ); ?>>
						<?php echo esc_html( $label ); ?>
					</option>
				<?php endforeach; ?>
			</select>
		</p>
	<?php
	}
}