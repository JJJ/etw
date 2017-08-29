<?php
/**
 * Array Flickr Widget
 *
 * @since 1.0.0
 */


/**
 * Registers the Flickr widget
 */
function load_array_flickr_widget() {
	register_widget( 'Array_Flickr_Widget' );
}
add_action( 'widgets_init', 'load_array_flickr_widget' );



class Array_Flickr_Widget extends WP_Widget {

	function array_flickr_widget() {
		$widget_ops = array(
			'classname' => 'flickr',
			'description' => __( 'Display your latest Flickr photos', 'array-toolkit' )
		);
		$control_ops = array(
			'width'   => 200,
			'height'  => 350,
			'id_base' => 'array-flickr-widget'
		);
		parent::__construct( 'array-flickr-widget', __( 'Array Flickr Widget', 'array-toolkit' ), $widget_ops, $control_ops );
	}



	function widget( $args, $instance ) {

		extract($args);

		$flickr_title = apply_filters( 'widget_title', $instance['flickr_title'] );
		$flickr_id = $instance['flickr_id'];
		$flickr_count = $instance['flickr_count'];

		echo $before_widget; ?>
		<div class="flickr-widget">
		<?php
		if ( $flickr_title ) {
			echo $before_title . $flickr_title . $after_title;
		}
		?>

			<ul id="flickr-<?php echo $args['widget_id']; ?>" class="flickr">
			<?php
			// If the user's set their flickr_id, grab their latest pics
			if ( $flickr_id != '' ) {

				$images = array();
				$regx = "/<img(.+)\/>/";

				// Set up the flickr feed URL and retrieve it
				$rss_url = 'http://api.flickr.com/services/feeds/photos_public.gne?ids='.$flickr_id.'&lang=en-us&format=rss_200';
				$flickr_feed = simplexml_load_file( $rss_url );

				// Store images from the feed in an array
				foreach( $flickr_feed->channel->item as $item ) {
					preg_match( $regx, $item->description, $matches );

					$images[] = array(
						'link'  => $item->link,
						'thumb' => $matches[ 0 ]
					);
				}

				// Loop through the images and display the number they wish to show
				$image_count = 0;
				if ( $flickr_count == '' )
					$flickr_count = 5;

				foreach( $images as $img ) {
					if ( $image_count < $flickr_count ) {
						$img_tag = str_replace("_m", "_b", $img[ 'thumb' ] );
						echo '<li><a href="' . $img[ 'link' ] . '">' . $img_tag . '</a></li>';
						$image_count++;
					}
				}

			}//end if ($flickr_id)
			?>
			</ul>
		</div>

		<?php
		echo $after_widget;
	}



	function update( $new_instance, $old_instance ) {

		$new_instance['flickr_title'] = strip_tags( $new_instance['flickr_title'] );
		$new_instance['flickr_id']    = strip_tags( $new_instance['flickr_id'] );
		$new_instance['flickr_count'] = strip_tags( $new_instance['flickr_count'] );

		return $new_instance;
	}


	function form( $instance ) {
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'array-toolkit' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickr_title' ); ?>" name="<?php echo $this->get_field_name( 'flickr_title' ); ?>" value="<?php if( isset( $instance['flickr_title'] ) ) echo $instance['flickr_title']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'flickr_id' ); ?>"><?php _e( 'Your Flickr User ID:', 'array-toolkit' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickr_id' ); ?>" name="<?php echo $this->get_field_name( 'flickr_id' ); ?>" value="<?php if( isset( $instance['flickr_id'] ) ) echo $instance['flickr_id']; ?>" />
			<small><?php _e( 'Don\'t know your ID? Head on over to <a href="http://idgettr.com">idgettr</a> to find it.', 'array-toolkit' ); ?></small>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'flickr_count' ); ?>"><?php _e( 'Number of Photos:', 'array-toolkit' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'flickr_count' ); ?>" name="<?php echo $this->get_field_name( 'flickr_count' ); ?>" value="<?php if( isset( $instance['flickr_count'] ) ) echo $instance['flickr_count']; ?>" />
		</p>

		<?php
	}
}
