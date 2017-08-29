<?php
/**
 * The template used for displaying projects on index view
 *
 * @package Designer
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post portfolio-column' ); ?>>

	<!-- Grab the featured image based on theme options -->
	<?php if ( '' != get_the_post_thumbnail() ) {
		$image_size = 'portfolio-'.get_option( 'designer_customizer_portfolio', 'tile' ); ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( $image_size ); ?></a>
	<?php } ?>

	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php echo get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '<div class="entry-content"><span class="portfolio-entry-meta">', _x(', ', '', 'designer' ), '</span></div>' ); ?>
	</header><!-- .entry-header -->

</article><!-- #post-## -->