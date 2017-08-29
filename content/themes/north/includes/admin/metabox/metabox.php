<?php
/**
 * Custom meta box for video embeds
 *
 * @package North
 * @since 3.0
 */


/**
 * Adds video and subtitle meta boxes edit screens
 *
 * @since 3.0
 */
function north_add_meta_boxes() {

	$screens = array( 'post', 'page', 'array-portfolio' );
	foreach ( $screens as $screen ) {
		// Video
		add_meta_box(
			'north_video_section',
			__( 'Video', 'north' ),
			'north_inner_video_box',
			$screen,
			'normal',
			'high'
		);
		// Subtitle
		add_meta_box(
			'north_subtitle_section',
			__( 'Subtitle', 'north' ),
			'north_inner_subtitle_box',
			$screen,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'north_add_meta_boxes' );



/**
 * Prints the video box markup
 *
 * @since 3.0
 */
function north_inner_video_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'north_video_box_nonce' );

	// Get existing value and use it for the value of the form
	$value = get_post_meta( $post->ID, 'video', true );
	$video_help = esc_url( 'https://array.is/articles/north/?#creating-media-postsTB_iframe=true&amp;width=850&amp;height=600' );
	echo '</label> ';
	echo '<textarea rows="3" style="width:98%; margin-top: 10px;" id="north_video_field" name="north_video_field">'.esc_textarea($value).'</textarea>';
	echo '<p>';
		printf( __( 'Add video to your page by entering the video\'s <a class="thickbox" href="%1$s">embed code</a> in the box above (optional). ', 'north' ), $video_help );
}


/**
 * Saves the video embed code on post save
 *
 * @since 3.0
 */
function north_save_video_meta( $post_id ) {

	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}

	// Check if the user intended to change this value.
	if ( ! isset( $_POST['north_video_box_nonce'] ) || ! wp_verify_nonce( $_POST['north_video_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission
	if( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get posted data and sanitize it
	$new_video = ( isset( $_POST['north_video_field'] ) ? $_POST['north_video_field'] : '' );

	// Get existing video
	$video = get_post_meta( $post_id, 'video', true );

	// If a new video was submitted and there was no previous one, add it
	if( $new_video && '' == $video ) {
		add_post_meta( $post_id, 'video', $new_video, true );
	}

	// If the new video doesn't match the old video, update it.
	elseif( $new_video && $new_video != $video ) {
		update_post_meta( $post_id, 'video', $new_video );
	}

	// If there's no new video and an old one exists, delete it.
	elseif( '' == $new_video && $video ) {
		delete_post_meta( $post_id, 'video', $video );
	}

}
add_action( 'save_post', 'north_save_video_meta' );



/**
 * Prints the subtitle box markup
 *
 * @since 3.0
 */
function north_inner_subtitle_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'north_subtitle_box_nonce' );

	// Get existing value and use it for the value of the form
	$value = get_post_meta( $post->ID, 'subtitle', true );
	echo '</label> ';
	echo '<input style="width:98%; margin-top: 10px;" type="text" id="north_subtitle_field" name="north_subtitle_field" value="'.esc_attr($value).'" size="25" />';
	echo '<p>';
	_e( 'Add a subtitle for your page (optional).', 'north' );
}



/**
 * Saves the subtitle on post save
 *
 * @since 3.0
 */
function north_save_subtitle_meta( $post_id ) {

	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}

	// Check if the user intended to change this value.
	if ( ! isset( $_POST['north_subtitle_box_nonce'] ) || ! wp_verify_nonce( $_POST['north_subtitle_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission
	if( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get posted data and sanitize it
	$new_subtitle = ( isset( $_POST['north_subtitle_field'] ) ? $_POST['north_subtitle_field'] : '' );

	// Get existing subtitle
	$subtitle = get_post_meta( $post_id, 'subtitle', true );

	// If a new subtitle was submitted and there was no previous one, add it
	if( $new_subtitle && '' == $subtitle ) {
		add_post_meta( $post_id, 'subtitle', $new_subtitle, true );
	}

	// If the new subtitle doesn't match the old subtitle, update it.
	elseif( $new_subtitle && $new_subtitle != $subtitle ) {
		update_post_meta( $post_id, 'subtitle', $new_subtitle );
	}

	// If there's no new subtitle and an old one exists, delete it.
	elseif( '' == $new_subtitle && $subtitle ) {
		delete_post_meta( $post_id, 'subtitle', $subtitle );
	}

}
add_action( 'save_post', 'north_save_subtitle_meta' );