<?php
/**
 * @package Designer
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

	<header class="entry-header">
		<?php if ( is_single() ) { ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
		<?php } else { ?>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		<?php } ?>
	</header><!-- .entry-header -->

	<!-- Grab the featured image -->
	<?php if ( '' != get_the_post_thumbnail() ) { ?>
		<a class="featured-image" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_post_thumbnail( 'large-image' ); ?></a>
	<?php } ?>

	<div class="entry-content">
		<?php the_content( __( 'Read More <span>&rarr;</span>', 'designer' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'designer' ),
				'after'  => '</div>',
			) );
		?>
		<?php if ( is_single() ) { ?>
			<?php edit_post_link( __( 'Edit', 'designer' ), '<span class="edit-link">', '</span>' ); ?>
		<?php } ?>
	</div><!-- .entry-content -->

	<?php get_template_part( 'content', 'meta' ); ?>

</article><!-- #post-## -->
