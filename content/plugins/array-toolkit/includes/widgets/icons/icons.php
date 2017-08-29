<?php
/**
 * Array Social Icons Widget
 *
 * @since 1.0.0
 */


/**
 * Registers the social icons widget
 */
function load_array_icons_widget() {
	register_widget( 'Array_Icons_Widget' );
}
add_action('widgets_init','load_array_icons_widget');



class Array_Icons_Widget extends WP_Widget {

	function array_icons_widget() {

		$widget_ops = array(
			'classname'   => 'icons',
			'description' => __( 'Show social icon links', 'array-toolkit' )
		);
		$control_ops = array(
			'width'   => 200,
			'height'  => 350,
			'id_base' => 'array-icons-widget'
		);

		parent::__construct( 'array-icons-widget', __( 'Array Social Icons Widget', 'array-toolkit'), $widget_ops, $control_ops );
	}


	function widget( $args, $instance ) {

		extract($args);

		$icons_shape    = $instance['icons_shape'];
		$twitter_icon   = $instance['twitter_icon'];
		$dribbble_icon  = $instance['dribbble_icon'];
		$facebook_icon  = $instance['facebook_icon'];
		$vimeo_icon     = $instance['vimeo_icon'];
		$tumblr_icon    = $instance['tumblr_icon'];
		$linkedin_icon  = $instance['linkedin_icon'];
		$flickr_icon    = $instance['flickr_icon'];
		$google_icon    = $instance['google_icon'];
		$feed_icon      = $instance['feed_icon'];
		$youtube_icon   = $instance['youtube_icon'];
		$pinterest_icon = $instance['pinterest_icon'];
		$wordpress_icon = $instance['wordpress_icon'];
		$github_icon    = $instance['github_icon'];
		$instagram_icon = $instance['instagram_icon'];
		$behance_icon 	= $instance['behance_icon'];
		$rdio_icon 		= $instance['rdio_icon'];
		$spotify_icon 	= $instance['spotify_icon'];

		echo $before_widget;

		$arraysocial_options = get_option( 'arraysocial_options' ); ?>

		<div class="icons-widget">

			<div id="icons" class="<?php echo $instance['icons_shape']; ?>">
				<?php if ( $twitter_icon ) { ?>
					<a href="<?php echo $instance['twitter_icon']; ?>" class="twitter-icon" title="<?php _e( 'Twitter', 'array-toolkit' ); ?>"><i class="icon-twitter"></i></a>
				<?php } ?>

				<?php if ( $dribbble_icon ) { ?>
					<a href="<?php echo $instance['dribbble_icon']; ?>" class="dribbble-icon" title="<?php _e( 'Dribbble', 'array-toolkit' ); ?>"><i class="icon-dribbble"></i></a>
				<?php } ?>

				<?php if ( $facebook_icon ) { ?>
					<a href="<?php echo $instance['facebook_icon']; ?>" class="facebook-icon" title="<?php _e( 'Facebook', 'array-toolkit' ); ?>"><i class="icon-facebook"></i></a>
				<?php } ?>

				<?php if ( $vimeo_icon ) { ?>
					<a href="<?php echo $instance['vimeo_icon']; ?>" class="vimeo-icon" title="<?php _e( 'Vimeo', 'array-toolkit' ); ?>"><i class="icon-vimeo"></i></a>
				<?php } ?>

				<?php if ( $tumblr_icon ) { ?>
					<a href="<?php echo $instance['tumblr_icon']; ?>" class="tumblr-icon" title="<?php _e( 'Tumblr', 'array-toolkit' ); ?>"><i class="icon-tumblr"></i></a>
				<?php } ?>

				<?php if ( $linkedin_icon ) { ?>
					<a href="<?php echo $instance['linkedin_icon']; ?>" class="linkedin-icon" title="<?php _e( 'LinkedIn', 'array-toolkit' ); ?>"><i class="icon-linkedin"></i></a>
				<?php } ?>

				<?php if ( $flickr_icon ) { ?>
					<a href="<?php echo $instance['flickr_icon']; ?>" class="flickr-icon" title="<?php _e( 'Flickr', 'array-toolkit' ); ?>"><i class="icon-flickr"></i></a>
				<?php } ?>

				<?php if ( $google_icon ) { ?>
					<a href="<?php echo $instance['google_icon']; ?>" class="google-icon" title="<?php _e( 'Google', 'array-toolkit' ); ?>"><i class="icon-gplus"></i></a>
				<?php } ?>

				<?php if ( $feed_icon ) { ?>
					<a href="<?php echo $instance['feed_icon']; ?>" class="feed-icon" title="<?php _e( 'RSS Feed', 'array-toolkit' ); ?>"><i class="icon-rss"></i></a>
				<?php } ?>

				<?php if ( $youtube_icon ) { ?>
					<a href="<?php echo $instance['youtube_icon']; ?>" class="youtube-icon" title="<?php _e( 'YouTube', 'array-toolkit' ); ?>"><i class="icon-youtube"></i></a>
				<?php } ?>

				<?php if ( $pinterest_icon ) { ?>
					<a href="<?php echo $instance['pinterest_icon']; ?>" class="pinterest-icon" title="<?php _e( 'Pinterest', 'array-toolkit' ); ?>"><i class="icon-pinterest"></i></a>
				<?php } ?>

				<?php if ( $github_icon ) { ?>
					<a href="<?php echo $instance['github_icon']; ?>" class="github-icon" title="<?php _e( 'Github', 'array-toolkit' ); ?>"><i class="icon-github"></i></a>
				<?php } ?>

				<?php if ( $instagram_icon ) { ?>
					<a href="<?php echo $instance['instagram_icon']; ?>" class="instagram-icon" title="<?php _e( 'Instagram', 'array-toolkit' ); ?>"><i class="icon-instagram"></i></a>
				<?php } ?>

				<?php if ( $wordpress_icon ) { ?>
					<a href="<?php echo $instance['wordpress_icon']; ?>" class="wordpress-icon" title="<?php _e( 'WordPress', 'array-toolkit' ); ?>"><i class="icon-wordpress"></i></a>
				<?php } ?>

				<?php if ( $behance_icon ) { ?>
					<a href="<?php echo $instance['behance_icon']; ?>" class="behance-icon" title="<?php _e( 'Behance', 'array-toolkit' ); ?>"><i class="icon-behance"></i></a>
				<?php } ?>

				<?php if ( $rdio_icon ) { ?>
					<a href="<?php echo $instance['rdio_icon']; ?>" class="rdio-icon" title="<?php _e( 'Rdio', 'array-toolkit' ); ?>"><i class="icon-rdio"></i></a>
				<?php } ?>

				<?php if ( $spotify_icon ) { ?>
					<a href="<?php echo $instance['spotify_icon']; ?>" class="spotify-icon" title="<?php _e( 'Spotify', 'array-toolkit' ); ?>"><i class="icon-spotify"></i></a>
				<?php } ?>
			</div>
		</div>

			<?php
		echo $after_widget;
  }

	// Updating the widget
	function update( $new_instance, $old_instance ) {

		//$instance = $old_instance;
		$new_instance['icons_shape']    = strip_tags( $new_instance['icons_shape'] );
		$new_instance['twitter_icon']   = strip_tags( $new_instance['twitter_icon'] );
		$new_instance['dribbble_icon']  = strip_tags( $new_instance['dribbble_icon'] );
		$new_instance['facebook_icon']  = strip_tags( $new_instance['facebook_icon'] );
		$new_instance['vimeo_icon']     = strip_tags( $new_instance['vimeo_icon'] );
		$new_instance['tumblr_icon']    = strip_tags( $new_instance['tumblr_icon'] );
		$new_instance['linkedin_icon']  = strip_tags( $new_instance['linkedin_icon'] );
		$new_instance['flickr_icon']    = strip_tags( $new_instance['flickr_icon'] );
		$new_instance['google_icon']    = strip_tags( $new_instance['google_icon'] );
		$new_instance['feed_icon']      = strip_tags( $new_instance['feed_icon'] );
		$new_instance['youtube_icon']   = strip_tags( $new_instance['youtube_icon'] );
		$new_instance['pinterest_icon'] = strip_tags( $new_instance['pinterest_icon'] );
		$new_instance['wordpress_icon'] = strip_tags( $new_instance['wordpress_icon'] );
		$new_instance['github_icon']    = strip_tags( $new_instance['github_icon'] );
		$new_instance['instagram_icon'] = strip_tags( $new_instance['instagram_icon'] );
		$new_instance['behance_icon'] 	= strip_tags( $new_instance['behance_icon'] );
		$new_instance['rdio_icon'] 		= strip_tags( $new_instance['rdio_icon'] );
		$new_instance['spotify_icon'] 	= strip_tags( $new_instance['spotify_icon'] );

		return $new_instance;
	}

	function form( $instance ) {

		$icons_shape = isset( $instance['icons_shape'] ) ? $instance['icons_shape'] : 'icons-rounded';
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'icons_shape' ); ?>"><?php _e( 'Icon Shape', 'array-toolkit' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'icons_shape' ); ?>" name="<?php echo $this->get_field_name( 'icons_shape' ); ?>" class="widefat" style="width:100%;">
				<option value="icons-rounded" <?php selected( $icons_shape, 'icons-rounded' ); ?>><?php _e( 'Rounded Square', 'array-toolkit' ); ?></option>
				<option value="icons-square" <?php selected( $icons_shape, 'icons-square' ); ?>><?php _e( 'Square', 'array-toolkit' ); ?></option>
				<option value="icons-circle" <?php selected( $icons_shape, 'icons-circle' ); ?>><?php _e( 'Circle', 'array-toolkit' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('twitter_icon'); ?>"><?php _e( 'Twitter Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('twitter_icon'); ?>" name="<?php echo $this->get_field_name('twitter_icon'); ?>" value="<?php if(isset($instance['twitter_icon'])) echo $instance['twitter_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('github_icon'); ?>"><?php _e( 'Github Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('github_icon'); ?>" name="<?php echo $this->get_field_name('github_icon'); ?>" value="<?php if(isset($instance['github_icon'])) echo $instance['github_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('instagram_icon'); ?>"><?php _e( 'Instagram Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('instagram_icon'); ?>" name="<?php echo $this->get_field_name('instagram_icon'); ?>" value="<?php if(isset($instance['instagram_icon'])) echo $instance['instagram_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('dribbble_icon'); ?>"><?php _e( 'Dribbble Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('dribbble_icon'); ?>" name="<?php echo $this->get_field_name('dribbble_icon'); ?>" value="<?php if(isset($instance['dribbble_icon'])) echo $instance['dribbble_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('facebook_icon'); ?>"><?php _e( 'Facebook Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('facebook_icon'); ?>" name="<?php echo $this->get_field_name('facebook_icon'); ?>" value="<?php if(isset($instance['facebook_icon'])) echo $instance['facebook_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('vimeo_icon'); ?>"><?php _e( 'Vimeo Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('vimeo_icon'); ?>" name="<?php echo $this->get_field_name('vimeo_icon'); ?>" value="<?php if(isset($instance['vimeo_icon'])) echo $instance['vimeo_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('tumblr_icon'); ?>"><?php _e( 'Tumblr Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('tumblr_icon'); ?>" name="<?php echo $this->get_field_name('tumblr_icon'); ?>" value="<?php if(isset($instance['tumblr_icon'])) echo $instance['tumblr_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('linkedin_icon'); ?>"><?php _e( 'LinkedIn Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('linkedin_icon'); ?>" name="<?php echo $this->get_field_name('linkedin_icon'); ?>" value="<?php if(isset($instance['linkedin_icon'])) echo $instance['linkedin_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('flickr_icon'); ?>"><?php _e( 'Flickr Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('flickr_icon'); ?>" name="<?php echo $this->get_field_name('flickr_icon'); ?>" value="<?php if(isset($instance['flickr_icon'])) echo $instance['flickr_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('google_icon'); ?>"><?php _e( 'Google Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('google_icon'); ?>" name="<?php echo $this->get_field_name('google_icon'); ?>" value="<?php if(isset($instance['google_icon'])) echo $instance['google_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('feed_icon'); ?>"><?php _e( 'RSS Feed Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('feed_icon'); ?>" name="<?php echo $this->get_field_name('feed_icon'); ?>" value="<?php if(isset($instance['feed_icon'])) echo $instance['feed_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('youtube_icon'); ?>"><?php _e( 'YouTube Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('youtube_icon'); ?>" name="<?php echo $this->get_field_name('youtube_icon'); ?>" value="<?php if(isset($instance['youtube_icon'])) echo $instance['youtube_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('pinterest_icon'); ?>"><?php _e( 'Pinterest Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('pinterest_icon'); ?>" name="<?php echo $this->get_field_name('pinterest_icon'); ?>" value="<?php if(isset($instance['pinterest_icon'])) echo $instance['pinterest_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('wordpress_icon'); ?>"><?php _e( 'WordPress Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('wordpress_icon'); ?>" name="<?php echo $this->get_field_name('wordpress_icon'); ?>" value="<?php if(isset($instance['wordpress_icon'])) echo $instance['wordpress_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('behance_icon'); ?>"><?php _e( 'Behance Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('behance_icon'); ?>" name="<?php echo $this->get_field_name('behance_icon'); ?>" value="<?php if(isset($instance['behance_icon'])) echo $instance['behance_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('rdio_icon'); ?>"><?php _e( 'Rdio Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('rdio_icon'); ?>" name="<?php echo $this->get_field_name('rdio_icon'); ?>" value="<?php if(isset($instance['rdio_icon'])) echo $instance['rdio_icon']; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('spotify_icon'); ?>"><?php _e( 'Spotify Link:', 'array-toolkit' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('spotify_icon'); ?>" name="<?php echo $this->get_field_name('spotify_icon'); ?>" value="<?php if(isset($instance['spotify_icon'])) echo $instance['spotify_icon']; ?>" />
		</p>

		<?php
	}
}
