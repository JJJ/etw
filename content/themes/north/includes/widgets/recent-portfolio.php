<?php
/**
 * Recent Portfolio Widget Class
 */
class north_recent_portfolio extends WP_Widget {

	/** constructor */
	function north_recent_portfolio() {
		parent::__construct( false, $name = __( 'North Portfolio Widget', 'north' ) );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		global $posttypes;
		$title  = apply_filters( 'widget_title', $instance['title'] );
		$number = apply_filters( 'widget_title', $instance['number'] );

		echo $before_widget; ?>

		<?php if ( $title ) echo $before_title . $title . $after_title; ?>

		<?php if ( '' == $title ) { ?>
			<h2 class="widgettitle"><?php _e( 'Portfolio', 'north' ); ?></h2>
		<?php } ?>

		<div id="portfolio-sidebar" class="portfolio-sidebar flexslider clearfix">

			<ul class="slides">
				<?php
					$args = array(
						'post_type'      => 'array-portfolio',
						'posts_per_page' => $number,
					);

					$recent_portfolio = new WP_Query( $args );

					if( $recent_portfolio->have_posts() ) : while($recent_portfolio->have_posts() ) : $recent_portfolio->the_post();
				?>

				<li>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="portfolio-small-image"><?php the_post_thumbnail( 'sidebar-image' ); ?></a>
				</li>

				<?php endwhile; endif;
				wp_reset_postdata(); ?>
			</ul>
		</div>

		<?php echo $after_widget; ?>

		<?php
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		global $posttypes;
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['number'] = strip_tags( $new_instance['number'] );
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		$posttypes = get_post_types( '', 'objects' );

		$title = esc_attr( $instance['title'] );
		$cat = esc_attr( $instance['cat'] );
		$number = esc_attr( $instance['number'] );
		?>
		 <p>
		  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'north' ); ?></label>
		  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
		  <label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number to Show:', 'north' ); ?></label>
		  <input class="widefat" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" />
		</p>
		<?php
	}
}

// Register the widget
function north_register_portfolio_widget() {
	register_widget( 'north_recent_portfolio' );
}
add_action( 'widgets_init', 'north_register_portfolio_widget' );