<?php
/**
 * @package Baseline
 */

$post_tags = get_the_tags();
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<?php
		// Grab the featured image
		if ( has_post_thumbnail() ) { ?>
		<?php if( is_single() ) { ?>
			<div class="featured-image"><?php the_post_thumbnail( 'baseline-full-width' ); ?></div>
		<?php } else { ?>
			<a href="<?php the_permalink(); ?>" rel="bookmark"><div class="featured-image"><?php the_post_thumbnail( 'baseline-full-width' ); ?></div></a>
		<?php } ?>
	<?php } ?>

	<div class="container">
		<header class="entry-header entry-large">
			<?php if ( ( has_category() ) ) { ?>
				<div class="entry-meta">
					<?php echo baseline_list_cats(); ?>
				</div><!-- .entry-meta -->
			<?php } ?>

			<?php if ( is_single() ) { ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php } else { ?>
				<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php } ?>

			<?php baseline_byline(); ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php if ( $post->post_excerpt && ! is_single() ) { ?>
				<?php the_excerpt(); ?>
				<p class="more-bg"><a class="more-link" href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'baseline' ); ?></a></p>
			<?php } else { ?>
				<?php the_content( esc_html__( 'Read More', 'baseline' ) ); ?>
			<?php } ?>

			<?php
				if ( is_single() ) {
				wp_link_pages( array(
					'before' => '<div class="page-links"><div class="page-links-inside">' . esc_html__( 'Pages:', 'baseline' ),
					'after'  => '</div></div>',
				) ); } ?>


				<?php
				if ( is_single() ) {

					if ( function_exists( 'sharing_display' ) || class_exists( 'Jetpack_Likes' ) ) {
						echo "<div class='share-icons'>";

							// Sharing Buttons
							if ( function_exists( 'sharing_display' ) ) {
								echo sharing_display();
							}

							// Likes
							if ( class_exists( 'Jetpack_Likes' ) ) {
								$custom_likes = new Jetpack_Likes;
								echo $custom_likes->post_likes( '' );
							}

						echo "</div>";
					}

					echo '<div class="post-meta">';
						// Related Posts
						if ( class_exists( 'Jetpack_RelatedPosts' ) ) {
						echo '<div class="meta-column meta-column-large">';
							echo do_shortcode( '[jetpack-related-posts]' );
						echo '</div>';
						}

						if ( has_category() ) {
							echo '<div class="meta-column">';

								echo '<span>';
									esc_html_e( 'Categories', 'baseline' );
								echo '</span>';

								the_category( ', ' );
							echo '</div>';
						}

						if ( $post_tags  ) {
							echo '<div class="meta-column">';
								echo '<span>';
									esc_html_e( 'Tags', 'baseline' );
								echo '</span>';

								the_tags( '' );
							echo '</div>';
						}

					echo '</div>';
				}
				?>
		</div><!-- .entry-content -->
	</div><!-- .container -->

</article><!-- #post-## -->
