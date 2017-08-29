<?php
/**
 * Portfolio Widget
 *
 * @since 1.0.0
 */

/**
 * Register the Portfolio widget
 */
function designer_portfolio_widget() {
	register_widget( 'designer_portfolio_widget' );
}
add_action( 'widgets_init', 'designer_portfolio_widget' );

/**
 * Portfolio widget class
 *
 * @since 2.8.0
 */
class designer_portfolio_widget extends WP_Widget {

	function designer_portfolio_widget() {

		$widget_ops = array(
			'classname'   => 'designer-portfolio',
			'description' => __( 'Display your latest Portfolio items.', 'designer' )
		);
		$control_ops = array(
			'width'   => 200,
			'height'  => 350,
			'id_base' => 'designer-portfolio'
		);
		parent::__construct( 'designer-portfolio', __( 'Portfolio Items', 'designer' ), $widget_ops, $control_ops );
	}

	/**
	 * Displays the widget content
	 *
	 * @since 1.0.0
	 */
	function widget( $args, $instance ) {

		$title = esc_attr( $instance['title'] );
		$portfolio_items = esc_attr( $instance['portfolio_items'] );

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : __( 'Portfolio Items', 'designer' );

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$portfolio_items = ( ! empty( $instance['portfolio_items'] ) ) ? absint( $instance['portfolio_items'] ) : 5;
		if ( ! $portfolio_items )
			$portfolio_items = 5;

		/**
		 * Filter the arguments for the Portfolio widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the recent posts.
		 */
		$r = new WP_Query( apply_filters( 'widget_posts_args', array(
			'posts_per_page'      => $portfolio_items,
			'post_type'           => 'jetpack-portfolio',
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true
		) ) );

		if ( $r->have_posts() ) :
		?>
			<?php echo $args['before_widget']; ?>
			<?php if ( $title ) echo $args['before_title'] . $title . $args['after_title']; ?>

				<ul>
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<li>
						<?php if ( '' != get_the_post_thumbnail() ) { ?>
							<a class="portfolio-widget-thumb" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'portfolio-tiny' ); ?></a>
						<?php } ?>
						<a href="<?php the_permalink(); ?>"><?php get_the_title() ? the_title() : the_ID(); ?></a>
					</li>
				<?php endwhile; ?>
					<!-- Link to project archive -->
					<li class="view-all"><a href="<?php echo esc_url( get_post_type_archive_link( 'jetpack-portfolio' ) ); ?>" ><?php _e( 'View All Projects', 'designer' ); ?></a></li>
				</ul>

			<?php echo $args['after_widget']; ?>
		<?php
		// Reset the global $the_post as this query will have stomped on it
		wp_reset_postdata();

		endif;
	}

	/**
	 * Update the instance
	 *
	 * @since 1.0.0
	 */
	function update( $new_instance, $old_instance ) {

		$new_instance['title'] = $new_instance['title'];
		$new_instance['portfolio_items'] = $new_instance['portfolio_items'];
		return $new_instance;
	}

	/**
	 * Displays the widget settings form
	 *
	 * @since 1.0.0
	 */
	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'portfolio_items' => '' ) );
		$instance['title'] = $instance['title'];
		$instance['portfolio_items'] = $instance['portfolio_items']; ?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'designer' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php if( isset( $instance['title'] ) ) echo $instance['title']; ?>" />
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'portfolio_items' ); ?>"><?php _e( 'Number of Projects:', 'designer' ); ?>
				<input class="widefat" id="<?php echo $this->get_field_id( 'portfolio_items' ); ?>" name="<?php echo $this->get_field_name( 'portfolio_items' ); ?>" type="text" value="<?php if( isset( $instance['portfolio_items'] ) ) echo $instance['portfolio_items']; ?>" />
			</label>
		</p>

	<?php
	}
}