<?php
/**
 * The template used for displaying portfolio items in a grid
 *
 * @package Baseline
 */

// Check if the post has an image
$image_class = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';

// Get the gallery size
$gallery_size = get_option( 'baseline_customizer_post_style', 'grid-medium' );
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class( 'gallery-thumb post' ); ?>>
		<a class="gallery-thumb-image <?php echo esc_attr( $image_class ); ?>" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<!-- Grab the image, or the fallback image -->
			<?php if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'baseline-' . $gallery_size );
			} else { ?>
				<!-- Use a fallback image to keep the grid tidy -->
				<div class="fallback"></div>
			<?php } ?>
		</a>

		<div class="container">
			<header class="entry-header">
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

				<?php baseline_byline(); ?>
			</header><!-- .entry-header -->


			<?php
				$excerpt_length = get_theme_mod( 'baseline_excerpt_length', '40' );
				if ( $excerpt_length > 0 ) {
			?>
				<div class="entry-content">
					<p><?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, ' &hellip;' ); ?></p>
				</div>
			<?php } ?>

			<p class="more-bg"><a class="more-link" href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'baseline' ); ?></a></p>

		</div><!-- .gallery-thumb-inside -->

	</div>
