<?php
/**
 * @package Editor
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<!-- Grab the featured image -->
	<?php if ( '' != get_the_post_thumbnail() ) { ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
	<?php } ?>

	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-date">
			<?php editor_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<div class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_content(); ?></a></div>
	</header><!-- .entry-header -->

	<?php get_template_part( 'content', 'meta' ); ?>

</article><!-- #post-## -->
