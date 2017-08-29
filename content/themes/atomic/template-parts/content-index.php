<?php
/**
 * The template for displaying posts with a thumbnail, title and excerpt.
 *
 * @package Atomic
 */
?>
<article id="post-<?php the_ID(); ?>-index" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="featured-image"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail( 'atomic-portfolio' ); ?></a></div>
	<?php } ?>

	<div class="post-text">
		<?php atomic_grid_cats(); ?>

		<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

		<?php
			// WP.com: Disable sharing and likes for this excerpt area
			if ( function_exists( 'post_flair_mute' ) )
				post_flair_mute();

			add_filter( 'excerpt_length', 'atomic_portfolio_excerpt_length' );

			echo '<div class="entry-excerpt">';
				atomic_remove_sharing();
				echo the_excerpt();
			echo '</div>';

			remove_filter( 'excerpt_length', 'atomic_portfolio_excerpt_length' );

			// WP.com: Turn sharing and likes back on for all other loops.
			if ( function_exists( 'post_flair_unmute' ) )
				post_flair_unmute();
		?>

		<?php atomic_post_byline(); ?>

		<p class="more-link"><a href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'atomic' ); ?></a></p>
	</div>
</article><!-- #post-## -->
