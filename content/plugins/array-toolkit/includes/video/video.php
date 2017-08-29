<?php
/**
 * Array Toolkit Video
 *
 * @package Array Toolkit
 * @since 1.0.0
 */


/**
 * Adds a video box to the the Post and Page edit screens
 */
function array_add_video_box() {

	$screens = array( 'post', 'page', 'array-portfolio', 'download' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'array_video_section',
			__( 'Video Embed', 'array-toolkit' ),
			'array_inner_video_box',
			$screen,
			'normal',
			'low'
		);
	}
}
add_action( 'add_meta_boxes', 'array_add_video_box' );



/**
 * Prints the video box markup
 */
function array_inner_video_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'array_video_box_nonce' );

	// Get existing value and use it for the value of the form
	$value = get_post_meta( $post->ID, 'array-video', true );
	echo '</label> ';
	echo '<textarea rows="3" style="width:98%; margin-top: 10px;" id="array_video_field" name="array_video_field">'.esc_textarea($value).'</textarea>';
	echo '<p>';
		printf( __( 'Add video to your page by entering the video\'s embed code in the box above (optional). ', 'array-toolkit' ) );
}



/**
 * Saves the video embed code on post save
 */
function array_save_video_meta( $post_id ) {

	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}

	// Check if the user intended to change this value.
	if ( ! isset( $_POST['array_video_box_nonce'] ) || ! wp_verify_nonce( $_POST['array_video_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission
	if( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get posted data and sanitize it
	$new_video = ( isset( $_POST['array_video_field'] ) ? $_POST['array_video_field'] : '' );

	// Get existing video
	$video = get_post_meta( $post_id, 'array-video', true );

	// If a new video was submitted and there was no previous one, add it
	if( $new_video && '' == $video ) {
		add_post_meta( $post_id, 'array-video', $new_video, true );
	}

	// If the new video doesn't match the old video, update it.
	elseif( $new_video && $new_video != $video ) {
		update_post_meta( $post_id, 'array-video', $new_video );
	}

	// If there's no new video and an old one exists, delete it.
	elseif( '' == $new_video && $video ) {
		delete_post_meta( $post_id, 'array-video', $video );
	}

}
add_action( 'save_post', 'array_save_video_meta' );