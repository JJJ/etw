<?php
/**
 * Array Toolkit EDD functions
 *
 * @package Array Toolkit
 * @since 1.1.5
 */


/**
 * Adds a demo link box to the the download edit screens
 */
function array_add_demo_box() {

	$screens = array( 'download' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'array_demo_section',
			__( 'Demo Link', 'array-toolkit' ),
			'array_inner_demo_box',
			$screen,
			'normal',
			'low'
		);
	}
}
add_action( 'add_meta_boxes', 'array_add_demo_box' );



/**
 * Prints the demo box markup
 */
function array_inner_demo_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'array_demo_box_nonce' );

	// Get existing value and use it for the value of the form
	$value = get_post_meta( $post->ID, 'array-demo', true );
	echo '</label> ';
	echo '<textarea rows="1" style="width:98%; margin-top: 10px;" id="array_demo_field" name="array_demo_field">'.esc_textarea($value).'</textarea>';
	echo '<p>';
		printf( __( 'Add a demo link to your product (optional).', 'array-toolkit' ) );
}



/**
 * Saves the demo url on post save
 */
function array_save_demo_meta( $post_id ) {

	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}

	// Check if the user intended to change this value.
	if ( ! isset( $_POST['array_demo_box_nonce'] ) || ! wp_verify_nonce( $_POST['array_demo_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission
	if( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get posted data and sanitize it
	$new_demo = ( isset( $_POST['array_demo_field'] ) ? $_POST['array_demo_field'] : '' );

	// Get existing demo
	$demo = get_post_meta( $post_id, 'array-demo', true );

	// If a new demo was submitted and there was no previous one, add it
	if( $new_demo && '' == $demo ) {
		add_post_meta( $post_id, 'array-demo', $new_demo, true );
	}

	// If the new demo doesn't match the old demo, update it.
	elseif( $new_demo && $new_demo != $demo ) {
		update_post_meta( $post_id, 'array-demo', $new_demo );
	}

	// If there's no new demo and an old one exists, delete it.
	elseif( '' == $new_demo && $demo ) {
		delete_post_meta( $post_id, 'array-demo', $demo );
	}

}
add_action( 'save_post', 'array_save_demo_meta' );