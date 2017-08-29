<?php
/**
 * The template used for displaying featured items
 *
 * @package Baseline
 */

$image_class      = has_post_thumbnail() ? 'with-featured-image' : 'without-featured-image';
$featured_options = get_option( 'featured-content' );
$featured_name    = $featured_options[ 'tag-name' ];
$featured_id      = $featured_options[ 'tag-id' ];
$excerpt_length   = get_theme_mod( 'baseline_featured_excerpt_length', '40' );
?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<!-- Get the background image -->
		<?php
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "baseline-full-width" );

		if ( ! empty( $featured_image ) ) { ?>

			<a href="<?php the_permalink(); ?>" rel="bookmark"><div class="site-header-bg background-effect" style="background-image: url(<?php echo esc_url( $featured_image[0] ); ?>);"></div></a>

		<?php } ?>

		<div class="featured-content-header">
			<div class="featured-nav">
				<div class="featured-cat">
					<?php if( $featured_id ) { ?>
						<a href="<?php echo esc_url( get_term_link( $featured_id, 'category' ) ); ?>"><?php echo $featured_name; ?></a>
					<?php } ?>
				</div>

				<?php if ( baseline_has_featured_posts( 2 ) ) { ?>
					<div class="arrow-navs">
						<button class="arrow-link prev"><?php esc_html_e( 'Previous', 'baseline' ); ?></button><button class="arrow-link next"><?php esc_html_e( 'Next', 'baseline' ); ?></button>
					</div>
				<?php } ?>
			</div><!-- .featured-nav -->

			<div class="featured-text">
				<header class="entry-header">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>

					<?php baseline_byline(); ?>
				</header><!-- .entry-header -->

				<?php
					if ( $excerpt_length > 0 ) {
				?>
					<div class="entry-content">
						<p><?php echo wp_trim_words( get_the_excerpt(), $excerpt_length, ' &hellip;' ); ?></p>
					</div>
				<?php } ?>

				<p class="more-bg"><a class="more-link" href="<?php the_permalink() ?>" rel="bookmark"><?php esc_html_e( 'Read More', 'baseline' ); ?></a></p>
			</div><!-- .featured-text -->
		</div><!-- .gallery-thumb-inside -->
	</div><!-- .post -->
