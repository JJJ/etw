<?php
/**
 * Custom meta boxes
 *
 * @package Ampersand
 * @since 1.0
 */


/**
 * Adds subtitle meta box to edit screens
 *
 * @since 2.0
 */
function ampersand_add_meta_boxes() {

	$screens = array( 'post', 'page', 'array-portfolio', 'portfolio' );
	foreach ( $screens as $screen ) {
		// Subtitle
		add_meta_box(
			'ampersand_subtitle_section',
			__( 'Page Subtitle', 'ampersand' ),
			'ampersand_inner_subtitle_box',
			$screen,
			'normal',
			'high'
		);
	}
}
add_action( 'add_meta_boxes', 'ampersand_add_meta_boxes' );



/**
 * Prints the subtitle box markup
 *
 * @since 3.0
 */
function ampersand_inner_subtitle_box( $post ) {

	// Use nonce for verification
	wp_nonce_field( plugin_basename( __FILE__ ), 'ampersand_subtitle_box_nonce' );

	// Get existing value and use it for the value of the form
	$value = get_post_meta( $post->ID, '_ampersand_subtitle_value', true );
	echo '</label> ';
	echo '<input style="width:98%; margin-top: 10px;" type="text" id="ampersand_subtitle_field" name="ampersand_subtitle_field" value="'.esc_attr($value).'" size="25" />';
	echo '<p>';
	_e( 'Add a subtitle for your page (optional).', 'ampersand' );
}



/**
 * Saves the subtitle on post save
 *
 * @since 3.0
 */
function ampersand_save_subtitle_meta( $post_id ) {

	global $post;

	// Return early if this is a newly created post that hasn't been saved yet.
	if( 'auto-draft' == get_post_status( $post_id ) ) {
		return $post_id;
	}

	// Check if the user intended to change this value.
	if ( ! isset( $_POST['ampersand_subtitle_box_nonce'] ) || ! wp_verify_nonce( $_POST['ampersand_subtitle_box_nonce'], plugin_basename( __FILE__ ) ) )
		return $post_id;

	// Get post type object
	$post_type = get_post_type_object( $post->post_type );

	// Check if user has permission
	if( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
		return $post_id;
	}

	// Get posted data and sanitize it
	$new_subtitle = ( isset( $_POST['ampersand_subtitle_field'] ) ? $_POST['ampersand_subtitle_field'] : '' );

	// Get existing subtitle
	$subtitle = get_post_meta( $post_id, '_ampersand_subtitle_value', true );

	// If a new subtitle was submitted and there was no previous one, add it
	if( $new_subtitle && '' == $subtitle ) {
		add_post_meta( $post_id, '_ampersand_subtitle_value', $new_subtitle, true );
	}

	// If the new subtitle doesn't match the old subtitle, update it.
	elseif( $new_subtitle && $new_subtitle != $subtitle ) {
		update_post_meta( $post_id, '_ampersand_subtitle_value', $new_subtitle );
	}

	// If there's no new subtitle and an old one exists, delete it.
	elseif( '' == $new_subtitle && $subtitle ) {
		delete_post_meta( $post_id, '_ampersand_subtitle_value', $subtitle );
	}

}
add_action( 'save_post', 'ampersand_save_subtitle_meta' );