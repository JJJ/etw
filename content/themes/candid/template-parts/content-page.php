<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Candid
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>
	</header><!-- .entry-header -->

	<!-- Grab the featured image -->
	<?php if ( has_post_thumbnail() ) { ?>
		<div class="featured-image fadeInUpImage"><?php the_post_thumbnail( 'candid-full-width' ); ?></div>
	<?php } ?>

	<div class="entry-content">
		<?php the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'candid' ),
			'after'  => '</div>',
		) ); ?>
	</div><!-- .entry-content -->
</article><!-- #post-## -->
