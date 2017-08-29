<?php
/**
 * The template used for displaying the carousel gallery and featured image
 *
 * @package Camera
 */
?>

	<!-- Grab the first gallery from the post -->
	<div class="slick">
		<?php

			// Grab the first gallery
			$gallery = get_post_gallery( $post->ID, false );

			// Get the gallery image IDs
			$gallery_ids = explode( ',', $gallery['ids'] );

			$image_output = '<div class="slick-slider">';

			foreach( $gallery_ids as $id ) {

				$gallery_image = wp_get_attachment_image_src( $id, 'full' );

				// Get the attachment's caption stored in post_excerpt
				$excerpt = get_post_field( 'post_excerpt', $id );

				// Only show a caption if there is one
				if ( ! empty( $excerpt ) ) {

					$image_excerpt_caption = '<div class="carousel-caption">'. $excerpt .'</div>';

				} else {

					$image_excerpt_caption = null;

				}

				// Output the image with captions
				$image_output .= '<div> ' . $image_excerpt_caption . ' <img src=" ' . $gallery_image[0] . ' " /></div>';
			}

			$image_output .= '</div>';

			// Display gallery
			echo $image_output;

		?>
	</div>
