<?php
/**
 * The template displays the Featured Content section on the blog
 *
 * @package Atomic
 */
?>

<?php
	// Get the featured content
	$featured_content = atomic_get_featured_content();

	// Count the featured content posts
	$hero_count = apply_filters( 'atomic_get_featured_posts', array() );

	// If there is no featured content, don't return markup
	if ( atomic_has_featured_posts( 1 ) && is_home() ) {
	?>
			<div class="featured-posts index-posts">
					<div class="container">
						<div class="slide-navs"></div>
						<div class="featured-post-container">
							<?php foreach ( $featured_content as $post ) : setup_postdata( $post );

								get_template_part( 'template-parts/content-index' );

								endforeach;
							?>
						</div>
					</div>
			</div><!-- .index-posts -->
		<?php wp_reset_postdata(); ?>
<?php } ?>
