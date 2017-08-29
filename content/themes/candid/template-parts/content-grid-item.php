<?php
/**
 * The template used for displaying portfolio items in a grid
 *
 * @package Candid
 */

// Check for a featured image
$show_titles = get_option( 'candid_customizer_show_titles', 'hover' );

if ( $show_titles == 'show' ) {
	$image_class = 'without-featured-image';
} else {
	$image_class = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';
}

// Get the gallery size
$gallery_size = get_option( 'candid_customizer_gallery_style', 'portfolio-grid-medium' );
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'gallery-thumb post' ); ?>>
		<a class="gallery-thumb-image <?php echo esc_attr( $image_class ); ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<!-- Grab the image, or the fallback image -->
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'candid-' . $gallery_size );
			} else { ?>
				<!-- Use a fallback image to keep the grid tidy -->
				<img class="fallback" src="<?php echo get_template_directory_uri(); ?>/images/fallback.jpg" alt="fallback" />
			<?php } ?>
		</a>

		<!-- Overlay title and categories -->
		<div class="photo-overlay <?php echo $image_class; ?>">
			<div class="photo-overlay-text">
				<h3 class="entry-title"><?php the_title(); ?></h3>

				<?php if ( has_category() ) { ?>
					<div class="overlay-cats">
						<?php
							// Limit the number of categories output on the grid to 5 to prevent overflow
							$i = 0;
							foreach( ( get_the_category() ) as $cat ) {
								echo '<a href="' . esc_url( get_category_link( $cat->cat_ID ) ) . '">' . $cat->cat_name . '</a>';
								if ( ++$i == 5 ) break;
							}
						?>
					</div>
				<?php } ?>
			</div>
		</div><!-- .photo-overlay -->
	</div>
