<?php
/**
 * The template used for displaying featured content in the header
 *
 * @package Baseline
 */
?>

<?php
// Get the featured content
$featured_content = baseline_get_featured_content();

// If there is no featured content, don't return markup
if ( baseline_has_featured_posts( 1 ) && is_front_page() ) {

	// Count the featured content posts
	$featured_count = apply_filters( 'baseline_get_featured_posts', array() );

	// Apply a class for conditional styling
	if ( baseline_has_featured_posts( 2 ) ) {
		$featured_count_class = 'multi-featured';
	} else {
		$featured_count_class = 'single-featured';
	}
?>
	<div class="featured-content fadeIn <?php echo $featured_count_class; ?>">
		<div class="container">
			<div class="slide-navs"></div>
			<div class="featured-slides">
			<?php foreach ( $featured_content as $post ) : setup_postdata( $post );

				// Get the featured post template (template-parts/content-featured-item.php)
				get_template_part( 'template-parts/content-featured-item' );

				endforeach;
			?>
			</div>

			<?php
			// If we have more than one post, create the paging navs
			if ( baseline_has_featured_posts( 2 ) ) { ?>
				<ul id="pager-navs">
					<?php foreach ( $featured_content as $post ) : setup_postdata( $post ); ?>

							<li><a href="<?php the_permalink(); ?>" rel="bookmark"><i class="fa fa-circle-o"></i></a></li>

					<?php endforeach; ?>
				</ul>
			<?php } ?>

		</div><!-- .container -->
	</div><!-- .featured-wrapper -->
<?php } ?>