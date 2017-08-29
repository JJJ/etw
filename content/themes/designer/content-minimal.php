<?php
/**
 * Template for displaying the minimal blog style, which is a setting in the customizer.
 *
 * @package Designer
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post minimal' ); ?>>

	<header class="entry-header">
		<div class="blog-date"><?php echo get_the_date(); ?></div>
		<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
	</header><!-- .entry-header -->

	<!-- Grab the featured image -->
	<?php if ( '' != get_the_post_thumbnail() ) { ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'blog-thumb' ); ?></a>
	<?php } ?>

</article><!-- #post-## -->