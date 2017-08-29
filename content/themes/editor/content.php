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

		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	</header><!-- .entry-header -->

	<?php get_template_part( 'content', 'meta' ); ?>

	<div class="entry-content">
		<?php the_content( __( 'Continue reading &rarr;', 'editor' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'editor' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

</article><!-- #post-## -->
